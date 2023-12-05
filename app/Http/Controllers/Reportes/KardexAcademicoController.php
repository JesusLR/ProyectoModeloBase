<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Alumno;
use App\Models\AlumnoRestringido;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Firmante;
use App\Models\Grupo;
use App\Models\Historico;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\ResumenAcademico;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Validator;

class KardexAcademicoController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    // $this->middleware('permisos:r_plantilla_profesores');
    // set_time_limit(8000000);
  }

  public function reporte()
  {
    $anioActual = Carbon::now('America/Merida');
    $programas = Programa::where('progClave', '<>', '000')->get()->unique('progClave');
    $ubicaciones = Ubicacion::sedes()->get();


    return view('reportes.cardex_academico.create', compact('anioActual', 'ubicaciones', 'programas'));
  }

  public function imprimir(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'aluClave' => 'required_without:aluMatricula',
        'aluMatricula' => 'required_without:aluClave',
        'plan_id' => 'required',
      ],
      [
        'aluClave.required_without' => 'El campo Clave del alumno es obligatorio cuando la Matrícula del alumno no está presente',
        'aluMatricula.required_without' => 'El campo Matrícula del alumno es obligatorio cuando la Clave del alumno no está presente',
        'plan_id.required' => 'Es necesario que proporcione un plan.',
      ]
    );

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }




    if ($request->aluClave) {
      $alumno = Alumno::where('aluClave', $request->aluClave)->first();
    }

    if ($request->aluMatricula) {
      $alumno = Alumno::where('aluMatricula', $request->aluMatricula)->first();
    }

    $llamada_sp = DB::select("call procKardexAcademico(
        " . $alumno->id . ",
        " . $request->plan_id . "
      )");


    if (count($llamada_sp) < 1) {
      return back();
      alert()->warning('Escuela Modelo', 'No se encuentran datos con la información proporcionada.');
    }

    // dd($request->plan_id, $alumno->id);

    $resumenacademico = ResumenAcademico::select(
      'resumenacademico.plan_id',
      'resumenacademico.resUltimoGrado',
      'resumenacademico.resCreditosCursados',
      'resumenacademico.resCreditosAprobados',
      'resumenacademico.resAvanceAcumulado',
      'resumenacademico.resPromedioAcumulado',
      'resumenacademico.resPeriodoUltimo',
      'resumenacademico.resEstado',
      'alumnos.aluClave',
      'alumnos.aluMatricula',
      'personas.perApellido1',
      'personas.perApellido2',
      'personas.perCurp',
      'personas.perNombre',
      'planes.planClave',
      'programas.progNombre',
      'escuelas.escNombre',
      'departamentos.depNombre',
      'departamentos.depClaveOficial',
      'departamentos.depCalMinAprob'
    )
      ->join('alumnos', 'resumenacademico.alumno_id', '=', 'alumnos.id')
      ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
      ->join('planes', 'resumenacademico.plan_id', '=', 'planes.id')
      ->join('programas', 'planes.programa_id', '=', 'programas.id')
      ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
      ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
      ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
      ->where('planes.id', $request->plan_id)
      ->where('alumnos.id', $alumno->id)
      ->first();

    if ($resumenacademico != "") {
      $centroTrabajo = $resumenacademico->depClaveOficial;
      $creditosAprob = $resumenacademico->resCreditosAprobados;
      $progNombre = $resumenacademico->progNombre;
      $planClave = $resumenacademico->planClave;
      $ultimoCurso = $resumenacademico->resUltimoGrado;
      $nombreAlumno = $resumenacademico->perApellido1 . ' ' . $resumenacademico->perApellido2 . ' ' . $resumenacademico->perNombre;
      $aluMatricula = $resumenacademico->aluMatricula;
      $perCurp = $resumenacademico->perCurp;
      $resPromedioAcumulado = $resumenacademico->resPromedioAcumulado;
      $planClave = $resumenacademico->planClave;
      $planClave = $resumenacademico->planClave;
      $depCalMinAprob = $resumenacademico->depCalMinAprob;
      $resEstado = $resumenacademico->resEstado;

      $cgt = Cgt::where('periodo_id', $resumenacademico->resPeriodoUltimo)
        ->where('plan_id', $resumenacademico->plan_id)
        ->first();

      $grupo = $cgt->cgtGrupo;
      $turno = $cgt->cgtTurno;
    } else {
      $centroTrabajo = "";
      $creditosAprob = "";
      $progNombre = "";
      $planClave = "";
      $ultimoCurso = "";
      $nombreAlumno = "";
      $aluMatricula = "";
      $perCurp = "";
      $resPromedioAcumulado = "";
      $grupo = "";
      $turno = "";
      $depCalMinAprob = "";
      $resEstado = "";
    }

    $fechaActual = Carbon::now('America/Merida');
    $fechaHora = Utils::fecha_string($fechaActual->format('Y/m/d'), 'fechaCorta') . '_' . $fechaActual->format('H:m:s');

    $firmante = Firmante::where("id", "=", $request->firmante)->first();

    $parametro_NombreArchivo = "pdf_cardex_academico";

    if ($request->formato_reporte == "PDF") {
      // view('reportes.pdf.universidad.cardex_academico.pdf_cardex_academico')
      $pdf = PDF::loadView('reportes.pdf.universidad.cardex_academico.' . $parametro_NombreArchivo, [
        'datos' => collect($llamada_sp)->groupBy('semestre'),
        'centroTrabajo' => $centroTrabajo,
        'creditosAprob' => $creditosAprob,
        'progNombre' => $progNombre,
        'planClave' => $planClave,
        'ultimoCurso' => $ultimoCurso,
        'nombreAlumno' => $nombreAlumno,
        'aluMatricula' => $aluMatricula,
        'perCurp' => $perCurp,
        'resPromedioAcumulado' => $resPromedioAcumulado,
        'grupo' => $grupo,
        'turno' => $turno,
        'fechaImpresion' => strtoupper(Utils::fecha_string($fechaActual->format('Y-m-d'))),
        'depCalMinAprob' => $depCalMinAprob,
        'resEstado' => $resEstado,
        'firmante' => $firmante
      ]);

      return $pdf->stream('cardex_academico_' . $alumno->aluClave . '_' . $fechaHora . '.pdf');
      return $pdf->download('cardex_academico_' . $alumno->aluClave . '_' . $fechaHora . '.pdf');
    }else{

      $aluClave = $alumno->aluClave;
      $header = [
        'centroTrabajo' => $centroTrabajo,
        'creditosAprob' => $creditosAprob,
        'progNombre' => $progNombre,
        'planClave' => $planClave,
        'ultimoCurso' => $ultimoCurso,
        'nombreAlumno' => $nombreAlumno,
        'aluMatricula' => $aluMatricula,
        'perCurp' => $perCurp,
        'resPromedioAcumulado' => $resPromedioAcumulado,
        'grupo' => $grupo,
        'turno' => $turno,
        'fechaImpresion' => strtoupper(Utils::fecha_string($fechaActual->format('Y-m-d'))),
        'depCalMinAprob' => $depCalMinAprob,
        'resEstado' => $resEstado,
        'firmante' => $firmante,
        'aluClave' => $aluClave
      ];

      $infoReporte = collect($llamada_sp)->groupBy('semestre');
      return $this->generarExcel($infoReporte, $header);
    }


  }

  public function generarExcel($info_reporte, $header) {
   


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    $sheet->getColumnDimension('J')->setAutoSize(true);
    $sheet->getColumnDimension('K')->setAutoSize(true);
    $sheet->getColumnDimension('L')->setAutoSize(true);
    $sheet->getColumnDimension('M')->setAutoSize(true);
    $sheet->getColumnDimension('N')->setAutoSize(true);
    #Título.
    // $sheet->mergeCells("A1:J1");
    #Encabezado columna 1.
    // $sheet->mergeCells("A2:E2");
    // $sheet->mergeCells("A3:E3");
    // $sheet->mergeCells("A4:E4");
    // $sheet->mergeCells("A5:E5");
    #Encabezado columna 2.
    // $sheet->mergeCells("F2:J2");
    // $sheet->mergeCells("F3:J3");
    // $sheet->mergeCells("F4:J4");
    // $sheet->mergeCells("F5:J5");
    

    # Contenido título.
    // $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->setCellValue('A1', "Escuela: UNIVERSIDAD MODELO");
    # Contenido encabezado columna 1.
    $sheet->setCellValue('A2', "Programa: {$header['progNombre']}");
    $sheet->setCellValue('A3', "Alumno: {$header['nombreAlumno']}");
    $sheet->setCellValue('A4', "CURP: {$header['perCurp']}");

    # Contenido encabezado columna 2.
    $sheet->setCellValue('B1', "CCT: {$header['centroTrabajo']}");
    $sheet->setCellValue('B2', "Plan(es): {$header['planClave']}");
    $sheet->setCellValue('B3', "Matrícula: {$header['aluMatricula']}");

    if ($header['resEstado'] == "R")
    $resEstado = "ACTIVA";
    if ($resEstado == "B")
    $resEstado = "BAJA";
    if ($resEstado == "E")
    $resEstado = "EGRESADO";
    $sheet->setCellValue('B4', "Sit: {$resEstado}");

    # Contenido encabezado columna 3.
    $sheet->setCellValue('C1', "Créditos Aprobados: {$header['creditosAprob']}");
    $sheet->setCellValue('C2', "Curso: {$header['ultimoCurso']}");

    if ($header['turno'] =='M')
      $turno = "MATUTINO"; 
    if ($header['turno'] =='V')
      $turno = "VESPERTINO";                 
    if ($header['turno'] =='M')
      $turno = "MIXTO"; 

    $resPromedioAcumulado = number_format((float)$header['resPromedioAcumulado'], 2, '.', '');

    $sheet->setCellValue('C3', "Turno: {$header['turno']}");
    $sheet->setCellValue('C4', "Prom: {$resPromedioAcumulado}");



    $sheet->setCellValue('A6', "Fecha de impresión: {$header['fechaImpresion']}");

    $sheet->setCellValue('A8', "⬜ Acta de Nac.");
    $sheet->setCellValue('B8', "⬜ Certificado Bachillerato o Licenciatura");
    $sheet->setCellValue('C8', "⬜ CURP");
    $sheet->setCellValue('D8', "⬜ Certificado Validado");
    $sheet->setCellValue('E8', "Grupo: {$header['fechaImpresion']}");


    $sheet->setCellValue('A10', "(*) CALIFICACIÓN REPROBATORIA. EL MÍNIMO APROBATORIO ES: {$header['depCalMinAprob']}");

    # Tabla principal de historial.
    $sheet->getStyle("A12:H12")->getFont()->setBold(true);

    $sheet->setCellValueByColumnAndRow(1, 12, "CURSO");
    $sheet->setCellValueByColumnAndRow(2, 12, "Clave");
    $sheet->getStyle(2, 12)->getAlignment()->setHorizontal('center');
    $sheet->setCellValueByColumnAndRow(3, 12, "ORD");
    $sheet->setCellValueByColumnAndRow(4, 12, "REG 1");
    $sheet->setCellValueByColumnAndRow(5, 12, "REG 2");
    $sheet->setCellValueByColumnAndRow(6, 12, "REG 3");
    $sheet->setCellValueByColumnAndRow(7, 12, "ESP");
    $sheet->setCellValueByColumnAndRow(8, 12, "EQ");


    $fila = 13;
    $contador = 13;

    foreach ($info_reporte as $semestre => $value) {
      
      if($value[0]->anioInicial != ''){
        $fechaCurso = $value[0]->anioInicial.'-'.intval($value[0]->anioInicial+1);
      }else{
        $fechaCurso = "";
      }      
      


      $sheet->setCellValue("A{$fila}", "Curso " . $semestre . ' ' . $fechaCurso);


      // colorea la selda 
      $spreadsheet->getActiveSheet()->getStyle("A{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("B{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("C{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("D{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("E{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("F{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("G{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $spreadsheet->getActiveSheet()->getStyle("H{$fila}")->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('EBEAEA');

      $fila++;
      $contador++;

      foreach ($value as $alumno) {
        
        $sheet->setCellValue("A{$fila}", $alumno->nombreMateria);
        $sheet->setCellValue("B{$fila}", $alumno->claveMateria);
        $sheet->getStyle("B{$fila}")->getAlignment()->setHorizontal('center');

        $fechaCurso = "";

        // ORD 
        if($alumno->ordinarioCal != ""){
          if($alumno->acreditacion == "N"){
            $ordinarioCal = $alumno->ordinarioCal;
          }
          if($alumno->acreditacion == "A") {
            if ($alumno->ordinarioCal == 0){
              $ordinarioCal = "A";
            }else{
              $ordinarioCal = "NA";
            }
          }
                        
        }else{
          $ordinarioCal = "";
        }

        if($alumno->ordinarioFecha != "") {
          $ordinarioFecha = "(".Carbon::parse($alumno->ordinarioFecha)->format('d/m/Y').")";
        }else{
          $ordinarioFecha = "";
        }
        
        $sheet->setCellValue("C{$fila}", $ordinarioCal.' '.$ordinarioFecha);
        $ordinarioCal = "";
        $ordinarioFecha = "";

        // REG 1 
        if($alumno->extra1Cal != ""){
          if($alumno->acreditacion == "N"){
            $extra1Cal = $alumno->extra1Cal;
          }
          if($alumno->acreditacion == "A") {
            if ($alumno->extra1Cal == 0){
              $extra1Cal = "A";
            }else{
              $extra1Cal = "NA";
            }
          }
                        
        }else{
          $extra1Cal = "";
        }

        if($alumno->extra1Fecha != "") {
          $extra1Fecha = "(".Carbon::parse($alumno->extra1Fecha)->format('d/m/Y').")";
        }else{
          $extra1Fecha = "";
        }
        
        $sheet->setCellValue("D{$fila}", $extra1Cal.' '.$extra1Fecha);
        $extra1Cal = "";
        $extra1Fecha = "";

        // REG 2 
        if($alumno->extra2Cal != ""){
          if($alumno->acreditacion == "N"){
            $extra2Cal = $alumno->extra2Cal;
          }
          if($alumno->acreditacion == "A") {
            if ($alumno->extra2Cal == 0){
              $extra2Cal = "A";
            }else{
              $extra2Cal = "NA";
            }
          }
                        
        }else{
          $extra2Cal = "";
        }

        if($alumno->extra2Fecha != "") {
          $extra2Fecha = "(".Carbon::parse($alumno->extra2Fecha)->format('d/m/Y').")";
        }else{
          $extra2Fecha = "";
        }
        
        $sheet->setCellValue("E{$fila}", $extra2Cal.' '.$extra2Fecha);
        $extra2Cal = "";
        $extra2Fecha = "";


        // REG 3 
        if($alumno->extra3Cal != ""){
          if($alumno->acreditacion == "N"){
            $extra3Cal = $alumno->extra3Cal;
          }
          if($alumno->acreditacion == "A") {
            if ($alumno->extra3Cal == 0){
              $extra3Cal = "A";
            }else{
              $extra3Cal = "NA";
            }
          }
                        
        }else{
          $extra3Cal = "";
        }

        if($alumno->extra3Fecha != "") {
          $extra3Fecha = "(".Carbon::parse($alumno->extra3Fecha)->format('d/m/Y').")";
        }else{
          $extra3Fecha = "";
        }
        
        $sheet->setCellValue("F{$fila}", $extra3Cal.' '.$extra3Fecha);
        $extra3Cal = "";
        $extra3Fecha = "";

        // ESP 
        if($alumno->especialCal != ""){
          if($alumno->acreditacion == "N"){
            $especialCal = $alumno->especialCal;
          }
          if($alumno->acreditacion == "A") {
            if ($alumno->especialCal == 0){
              $especialCal = "A";
            }else{
              $especialCal = "NA";
            }
          }
                        
        }else{
          $especialCal = "";
        }

        if($alumno->especialFecha != "") {
          $especialFecha = "(".Carbon::parse($alumno->especialFecha)->format('d/m/Y').")";
        }else{
          $especialFecha = "";
        }
        
        $sheet->setCellValue("G{$fila}", $especialCal.' '.$especialFecha);
        $especialCal = "";
        $especialFecha = "";


        // EQ 
        if($alumno->revalidaCal != ""){
          if($alumno->acreditacion == "N"){
            $revalidaCal = $alumno->revalidaCal;
          }
          if($alumno->acreditacion == "A") {
            if ($alumno->revalidaCal == 0){
              $revalidaCal = "A";
            }else{
              $revalidaCal = "NA";
            }
          }
                        
        }else{
          $revalidaCal = "";
        }

    
        $sheet->setCellValue("H{$fila}", $revalidaCal);
        $revalidaCal = "";
        $especialFecha = "";


        $fila++;
        $contador++;
      }


     

      
    }
    $saltos1 = intval($contador+2);
    $saltos2 = intval($contador+4);
    $saltos3 = intval($contador+6);
    $saltos4 = intval($contador+7);

    $sheet->setCellValue("A{$saltos1}", $header['firmante']['firPuesto']);      
    $sheet->setCellValue("A{$saltos2}", $header['firmante']['firNombre']);
    $sheet->setCellValue("A{$saltos3}", "Observaciones: Para cualquier aclaración, dirigirse al director correspondiente");
    $sheet->setCellValue("A{$saltos4}", "* No cuenta para promedios por haberla aprobado en el mismo período");
    
    $writer = new Xlsx($spreadsheet);

    try {
        $writer->save(storage_path("KardexAcademico_".$header['aluClave'].".xlsx"));
    } catch (Exception $e) {
        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
        return back()->withInput();
    }

    return response()->download(storage_path("KardexAcademico_".$header['aluClave'].".xlsx"));
  }
}

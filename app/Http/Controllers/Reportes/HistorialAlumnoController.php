<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Plan;
use App\Models\Curso;
use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\Firmante;
use App\Models\Programa;
use App\Models\ResumenAcademico;
use App\Models\Historico;
use App\Models\Ubicacion;
use App\Models\AlumnoRestringido;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Validator;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class HistorialAlumnoController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    $anioActual = Carbon::now('America/Merida');
    $programas = Programa::where('progClave','<>','000')->get()->unique('progClave');
    $ubicaciones = Ubicacion::sedes()->get();


    return View('reportes/historial_alumno.create',compact('anioActual', 'ubicaciones','programas'));
  }

  /**
  * Retorna los resúmenes académicos del alumno.
  */
  private function buscar_resacas($alumno_id, $plan_id = null) {

    return ResumenAcademico::with('plan.programa')
    ->where('alumno_id', $alumno_id)
    ->whereHas('plan.programa', static function ($query) use ($plan_id) {
      if($plan_id) {
        $query->where('plan_id', $plan_id);
      }
    })->latest('resFechaIngreso')->get();
  } //buscar_resacas.

  /**
  * retorna los planes que ha cursado el alumno
  */
  private function mapear_planes($alumno_id) {

    $resacas = $this->buscar_resacas($alumno_id);

    return $resacas->map(static function($resaca, $key) {
      return collect([
        'plan_id' => $resaca->plan->id,
        'progClave' => $resaca->plan->programa->progClave,
        'planClave' => $resaca->plan->planClave,
        'depClave' => $resaca->plan->programa->escuela->departamento->depClave
      ]);
    })->keyBy('plan_id');
  }// map_resacas_por_planes.


  public function obtenerProgramasClave($aluClave)
  {
    $alumno = Alumno::where('aluClave',$aluClave)->first();
    if(!$alumno) { return json_encode(null); }

    return response()->json($this->mapear_planes($alumno->id));
  }


  public function obtenerProgramasMatricula($aluMatricula)
  {
    $alumno = Alumno::where('aluMatricula',$aluMatricula)->first();
    if(!$alumno) { return json_encode(null); }

    return response()->json($this->mapear_planes($resacas));
  }


  public function checkBlackList($request)
  {
    $query = Alumno::query();
    if ( is_null($request->aluClave) ) $query->where('aluMatricula', $request->aluMatricula);
    else $query->where('aluClave', $request->aluClave);

    $alu = $query->first();
    $restric = AlumnoRestringido::select('listanegra.lnRazon', 'users.username')
      ->join('users', 'listanegra.usuario_at', '=', 'users.id')
      ->where('alumno_id', $alu->id)->first();

    $message = [
      'check' => false,
      'content' => ''
    ];

    if ($restric) {
      $message['check'] = true;
      $message['content'] = $restric->lnRazon.' Bloqueado por el usuario: '.$restric->username;
    }
    return $message;
  }


  public function imprimir(Request $request)
  {

    $validator = Validator::make($request->all(),[
      'aluClave' =>'required_without:aluMatricula',
      'aluMatricula'=>'required_without:aluClave',
      'plan_id' => 'required',
    ],
    [
      'aluClave.required_without'=>'El campo Clave del alumno es obligatorio cuando la Matrícula del alumno no está presente',
      'aluMatricula.required_without'=>'El campo Matrícula del alumno es obligatorio cuando la Clave del alumno no está presente',
      'plan_id.required' => 'Es necesario que proporcione un plan.',
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    $message = $this->checkBlackList($request);
    
    if ($message['check']) {
      alert()->warning('Alumno restringido', $message['content'])->showConfirmButton();
      return back()->withInput();
    }

    $plan = Plan::with('programa.escuela.departamento.periodoActual')->findOrFail($request->plan_id);
    $programa = $plan->programa;
    $escuela = $programa->escuela;
    $departamento = $escuela->departamento;
    $periodo = $departamento->periodoActual;
    $ubicacion = $departamento->ubicacion;

    $historial = Historico::with(['alumno.persona','materia.plan', 'periodo'])

      ->whereHas('alumno.persona', function($query) use ($request) {
        if ($request->aluClave) {
          $query->where('aluClave', '=', $request->aluClave);//
        }
        if ($request->aluMatricula) {
          $query->where('aluMatricula', '=', $request->aluMatricula);//
        }
      })
      ->whereHas('materia.plan', function($query) use ($request) {
        if ($request->plan_id) {
          $query->where('plan_id', '=', $request->plan_id);//
        }
      })
      ->whereHas('periodo', static function($query) use ($periodo) {
        $query->whereDate('perFechaInicial', '<=', $periodo->perFechaInicial);
      })
      ->latest()->get();

    $historialFirst = $historial->first();

    if(!$historial->first()){
      alert()->warning('Escuela Modelo','No se encuentran datos con la información proporcionada.
      Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $ultimoCurso = $historialFirst->alumno->cursos()
      ->whereHas('periodo', static function($query) use ($periodo) {
        $query->whereDate('perFechaInicial', '<=', $periodo->perFechaInicial);
      })
      // ->where("curEstado", "=", "R")
      ->latest("curFechaRegistro")
    ->first();

    $historialA = collect();
    $fechaActual = Carbon::now('America/Merida');


    //variables que se mandan a la vista fuera del array
    $alumnoNombre = $historialFirst->alumno;
    $personaNombre = $historialFirst->alumno->persona;

    $grupoNom = Grupo::select('gpoSemestre','gpoClave')->where('materia_id',$historialFirst->materia_id)
      ->where('plan_id',$historialFirst->plan_id)->where('periodo_id',$historialFirst->periodo_id)
    ->first();


    $resumenAcademico = $this->buscar_resacas($historialFirst->alumno_id, $historialFirst->plan_id)->first();


    $fechaIngreso = Carbon::parse($resumenAcademico->resFechaIngreso)->format("d-m-Y");



    foreach ($historial  as $key => $historico){
      $grupo = Grupo::where('materia_id','=',$historico->materia_id)->where('plan_id','=',$historico->plan_id)->where('periodo_id','=',$historico->periodo_id)->first();
      $curso = Curso::where('alumno_id','=',$historico->alumno_id)->where('periodo_id','=',$historico->periodo_id)->first();
      if ($curso) {
        $cgt = $curso->cgt;
        $curTipoIngreso = $curso->curTipoIngreso;
        $cgtGradoSemestre = $cgt->cgtGradoSemestre;
      }else{
        $curTipoIngreso = '';
        $cgtGradoSemestre = '';
      }

      $matClave = $historico->materia->matClave;
      $matNombre = $historico->materia->matNombreOficial;
      $matCreditos = $historico->materia->matCreditos;
      $periodoInicial = $historico->periodo->perFechaInicial;
      $periodoFinal = $historico->periodo->perFechaFinal;
      $calificacion = $historico->histCalificacion;
      $fechaMat = $historico->histFechaExamen;
      $matTipoAcreditacion = $historico->materia->matTipoAcreditacion;
      $depCalMinAprob = $historico->plan->programa->escuela->departamento->depCalMinAprob;

      $calificacionName = '';
      $calificacionNumerica = $calificacion;
      if ($matTipoAcreditacion == 'A') {
        if ($calificacion == 0)
        {
          $calificacion = 'Apr';
        }elseif ($calificacion == 1)
        {
          $calificacion = 'No Apr';
        }
      }

      if ($calificacion == -1) {
        $calificacion = 0;
      }

      $historialA->push((Object)[
        'historico'=>$historico,
        'periodo_id' => $historico->periodo_id,
        'curTipoIngreso'=>$curTipoIngreso,
        'cgtGradoSemestre'=>$cgtGradoSemestre,
        'matClave'=>$matClave,
        'matNombre'=>$matNombre,
        'matCreditos'=>$matCreditos,
        'periodoInicial'=>$periodoInicial,
        'periodoFinal'=>$periodoFinal,
        'fechaMat'=>$fechaMat,
        'matClaveFecha'=>$matClave.$fechaMat,
        'calificacion'=>"$calificacion",
        'depCalMinAprob'=>$depCalMinAprob,
        'grupo'=>$grupo,
        'ordenar' =>$periodoInicial,
        'matTipoAcreditacion' => $matTipoAcreditacion,
        'calificacionNumerica' => $calificacionNumerica
      ]);
    }

    $firmante = Firmante::where("id", "=", $request->firmante)->first();

    $nombreArchivo = 'pdf_historial_alumno';
    $infoReporte = [
      "historialA" => $historialA->sortBy('matClaveFecha')->groupBy('periodoInicial')->sortKeys(),
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "historialFirst" => $historialFirst,
      "nombreArchivo" => $nombreArchivo,
      "ubicacionNombre" => $ubicacion,
      "departamento" => $departamento,
      "programaNombre" => $programa,
      "credPlan" => $plan,
      "alumnoNombre" => $alumnoNombre,
      "personaNombre" => $personaNombre,
      "grupoNom" => $grupoNom,
      "resumenAcademico" =>$resumenAcademico,
      'ultimoCurso'     => $ultimoCurso,
      "fechaIngreso" =>$fechaIngreso,
      "perAnio" => $request->perAnio,
      "firmante" => $firmante
    ];

    if($request->formato_reporte != 'PDF') {
      return $this->generarExcel($infoReporte);
    }

    return PDF::loadView('reportes.pdf.'. $nombreArchivo, $infoReporte)->stream($nombreArchivo.'.pdf');

  }

  /**
   * @param array $info_reporte
   */
  public function generarExcel($info_reporte) {

    $persona = $info_reporte['personaNombre'];
    $alumno = $info_reporte['alumnoNombre'];
    $programa = $info_reporte['programaNombre'];
    $plan = $info_reporte['credPlan'];
    $ubicacion = $info_reporte['ubicacionNombre'];
    $departamento = $info_reporte['departamento'];
    $ultimoCurso = $info_reporte['ultimoCurso'];
    $resumenAcademico = $info_reporte['resumenAcademico'];
    $grupo = $info_reporte['grupoNom'];
    $alumnoSemestre = $ultimoCurso ? $ultimoCurso->cgt->cgtGradoSemestre : null;
    $fechaIngreso = $info_reporte['fechaIngreso'];
    if(!$alumnoSemestre) {
      $alumnoSemestre = $resumenAcademico ? $resumenAcademico->resUltimoGrado : '';
    }

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
    $sheet->mergeCells("A1:J1");
    #Encabezado columna 1.
    $sheet->mergeCells("A2:E2");
    $sheet->mergeCells("A3:E3");
    $sheet->mergeCells("A4:E4");
    $sheet->mergeCells("A5:E5");
    #Encabezado columna 2.
    $sheet->mergeCells("F2:J2");
    $sheet->mergeCells("F3:J3");
    $sheet->mergeCells("F4:J4");
    $sheet->mergeCells("F5:J5");

    # Contenido título.
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->setCellValue('A1', "{$ubicacion->ubiClave} {$ubicacion->ubiNombre} - {$departamento->depClave}");
    # Contenido encabezado columna 1.
    $sheet->setCellValue('A2', $persona->nombreCompleto(true));
    $sheet->setCellValue('A3', "{$programa->progClave} ({$plan->planClave}) {$programa->progNombre}");
    $sheet->setCellValue('A4', "Semestre: {$alumnoSemestre}   Grupo: ".($grupo ? $grupo->gpoClave : '')." Fecha Ingreso: {$fechaIngreso}");
    # Contenido encabezado columna 2.
    $sheet->setCellValue('F2', "Matrícula: {$alumno->aluMatricula}");
    $sheet->setCellValue('F3', "Clave de pago: {$alumno->aluClave}");
    $sheet->setCellValue('F4', "Total de créditos del plan: {$plan->planNumCreditos}");
    $sheet->setCellValue('F5', "Calificación mínima aprobatoria: {$departamento->depCalMinAprob}");
    # Tabla principal de historial.
    $sheet->getStyle("A6:N6")->getFont()->setBold(true);

    $sheet->setCellValueByColumnAndRow(1, 6, "Curso/Semestre");
    $sheet->setCellValueByColumnAndRow(2, 6, "Tipo ingreso");
    $sheet->setCellValueByColumnAndRow(3, 6, "Periodo");
    $sheet->setCellValueByColumnAndRow(4, 6, "Cve. Materia");
    $sheet->setCellValueByColumnAndRow(5, 6, "Nombre materia");
    $sheet->setCellValueByColumnAndRow(6, 6, "Créditos");
    $sheet->setCellValueByColumnAndRow(7, 6, "Periodo acreditación");
    $sheet->setCellValueByColumnAndRow(8, 6, "Tipo acreditación");
    $sheet->setCellValueByColumnAndRow(9, 6, "Fecha examen");
    $sheet->setCellValueByColumnAndRow(10, 6, "Calificación");
    # estadística por periodo
    $sheet->setCellValueByColumnAndRow(11, 6, "Cred.Cursados");
    $sheet->setCellValueByColumnAndRow(12, 6, "Cred.Aprob.");
    $sheet->setCellValueByColumnAndRow(13, 6, "Promedio");
    $sheet->setCellValueByColumnAndRow(14, 6, "avance %");

    $fila = 7;
    foreach($info_reporte['historialA'] as $historial_periodo) {

      $periodo_estadistica = self::estadisticaPorPeriodoDelAlumno($historial_periodo);
      $sheet->setCellValue("K{$fila}", $periodo_estadistica['contarCred']);
      $sheet->setCellValue("L{$fila}", $periodo_estadistica['contarCredApr']);
      $sheet->setCellValue("M{$fila}", number_format($periodo_estadistica['promedio'], 2));
      $sheet->setCellValue("N{$fila}", $periodo_estadistica['avance']);
      
      foreach($historial_periodo as $materia) {
        $materia->matNombre .= $materia->grupo && $materia->grupo->optativa_id ? ' - ' . strtoupper($materia->historico->histComplementoNombre) : '';

        $sheet->setCellValueExplicit("A{$fila}", ($materia->cgtGradoSemestre ?: ''), DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("B{$fila}", ($materia->curTipoIngreso ?: ''), DataType::TYPE_STRING);
        $sheet->setCellValue("C{$fila}", ($materia->periodoInicial . ' al ' . $materia->periodoFinal));
        $sheet->setCellValueExplicit("D{$fila}", $materia->matClave, DataType::TYPE_STRING);
        $sheet->setCellValue("E{$fila}", $materia->matNombre);
        $sheet->setCellValueExplicit("F{$fila}", $materia->matCreditos, DataType::TYPE_STRING);
        $sheet->setCellValue("G{$fila}", $materia->historico->histPeriodoAcreditacion);
        $sheet->setCellValue("H{$fila}", $materia->historico->histTipoAcreditacion);
        $sheet->setCellValueExplicit("I{$fila}", $materia->historico->histFechaExamen, DataType::TYPE_STRING);
        $sheet->setCellValue("J{$fila}", $materia->calificacion);
        $fila++;
      }
    }

    $writer = new Xlsx($spreadsheet);
    try {
        $writer->save(storage_path("HistorialAcademicoAlumno.xlsx"));
    } catch (Exception $e) {
        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
        return back()->withInput();
    }

    return response()->download(storage_path("HistorialAcademicoAlumno.xlsx"));
  }

  /**
   * Reúne y procesa información de creditos y promedios por cada periodo (solo se usa para el formato Excel).
   * 
   * @param Illuminate\Support\Collection
   */
  private static function estadisticaPorPeriodoDelAlumno($historial_periodo) {
    $primerHistorial = $historial_periodo->first();
    $depCalMinAprob = $primerHistorial->depCalMinAprob;
    $contarCred = $historial_periodo->unique('matClave')->sum('matCreditos');
    $promedio = $historial_periodo->sortByDesc('historico.histFechaExamen')
      ->where('matTipoAcreditacion','<>','A')
      ->unique('matClave')
      ->sum('calificacionNumerica');
    $promedioCount = $historial_periodo->sortByDesc('historico.histFechaExamen')
      ->where('matTipoAcreditacion','<>','A')
      ->unique('matClave')
      ->count('calificacionNumerica');


    $contarCredApr = $historial_periodo->filter(function($item,$key) use($depCalMinAprob){
      return $item->calificacion >= $depCalMinAprob;
    })->sum('matCreditos');

    return [
      'contarCred' => $contarCred,
      'contarCredApr' => $contarCredApr,
      'promedio' => $promedio / $promedioCount,
      'avance' => $contarCredApr / $contarCred * 100,
    ];
  }

}

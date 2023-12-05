<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Periodo;

use DB;
use Carbon\Carbon;
use App\Http\Helpers\Utils;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use \PhpOffice\PhpSpreadsheet\Style\Color;
use Exception;
use PDF;

class BachillerHistoricoInscripcionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function reporte()
  {
    $grados = [
      '0' => 'Último grado del programa',
      '1' => '1',
      '2' => '2',
      '3' => '3'
    ];

    $opciones = [
      'F'   => 'Llevaron cursos niveles anteriores',
      'T'   => 'TODOS',
      'R'   => 'Sólo posibles alumnos duplicados',
    ];

    $ubicaciones = Ubicacion::where('id', '<>', 0)->get();

    return view('bachiller.reportes.historico_inscripcion.create',compact('grados', 'opciones', 'ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    // obligatorios
    $periodo = Periodo::findOrFail($request->periodo_id);
    $ubicacion = Ubicacion::findOrFail($request->ubicacion_id);
    $departamento = Departamento::findOrFail($request->departamento_id);
    // opcionales
    $escuela = $request->escuela_id ? Escuela::findOrFail($request->escuela_id) : NULL;
    $programa = $request->programa_id ? Programa::findOrFail($request->programa_id) : NULL;
    $plan = $request->plan_id ? Plan::findOrFail($request->plan_id) : NULL;
    // asignar cadena vacia si no lo pasaron
    $escClave = $escuela ? $escuela->escClave : '';
    $progClave = $programa ? $programa->progClave : '';
    $planClave = $plan ? $plan->planClave : '';
    $grupo = $request->cgtGrupo ? $request->cgtGrupo : '';

    $results = DB::select("call procHistoricoInscripciones("
      .$periodo->perNumero
      .",'".$periodo->perAnio
      ."','".$ubicacion->ubiClave
      ."','".$departamento->depClave
      ."','".$request->cgtGradoSemestreb
      ."','".$request->opcion // hasta aqui son obligatorios
      ."','".$escClave
      ."','".$progClave
      ."','".$planClave
      ."','".$grupo
      ."')");


      if($request->opcionVista == "EXCEL"){
        return $this->generarExcel($results, $periodo, $request->opcion);
      }

      if($request->opcionVista == "PDF"){
        return $this->generarPdf($results, $periodo, $request->opcion);
      }
      
  }

  /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($results, $periodo, $opcion)
    {
      if ($opcion == 'F') {
        $mensaje = 'SÓLO SE INCLUYEN ALUMNOS QUE ESTEN REGISTRADOS EN AL MENOS UN CURSO ANTERIOR AL NIVEL PREPARATORIA';
      } elseif ($opcion == 'R') {
        $mensaje = 'SÓLO SE INCLUYEN ALUMNOS CON MÁS DE UNA CLAVE DE PAGO';
      } else {
        $mensaje = '';
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

      $sheet->mergeCells('H6:J6');
      $sheet->mergeCells('K6:P6');
      $sheet->mergeCells('Q6:S6');
      $sheet->mergeCells('T6:Y6');
      $sheet->mergeCells('Z6:AE6');
      $sheet->mergeCells('AF6:AI6');

      $styleArray = [
        'borders' => [
          // 'vertical' => [
          //   'borderStyle' => Border::BORDER_MEDIUM,
          //   'color' => ['argb' => Color::COLOR_BLACK],
          // ],
          'left' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => ['argb' => Color::COLOR_BLACK],
          ],
          'right' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => ['argb' => Color::COLOR_BLACK],
          ],
        ],
      ];
    
      $sheet->getStyle('H6:J6')->applyFromArray($styleArray);
      $sheet->getStyle('K6:P6')->applyFromArray($styleArray);
      $sheet->getStyle('Q6:S6')->applyFromArray($styleArray);
      $sheet->getStyle('T6:Y6')->applyFromArray($styleArray);
      // $sheet->getStyle('Z6:AE6')->applyFromArray($styleArray);
      // $sheet->getStyle('AF6:AI6')->applyFromArray($styleArray);
      
      $sheet->getStyle('H7:J7')->applyFromArray($styleArray);
      $sheet->getStyle('K7:P7')->applyFromArray($styleArray);
      $sheet->getStyle('Q7:S7')->applyFromArray($styleArray);
      $sheet->getStyle('T7:Y7')->applyFromArray($styleArray);
      // $sheet->getStyle('Z7:AE7')->applyFromArray($styleArray);
      // $sheet->getStyle('AF7:AI7')->applyFromArray($styleArray);

      //cabecera
      $sheet->mergeCells('A1:I1');
      $sheet->mergeCells('A2:I2');
      $sheet->mergeCells('A3:I3');
      $sheet->mergeCells('A4:I4');
      $sheet->mergeCells('A5:I5');

      $sheet->setCellValue('A1', "Preparatoria ESCUELA MODELO");
      $sheet->setCellValue('A2', "HISTORICOS DE INSCRIPCIONES DE ALUMNOS DE NIVEL PREPARATORIA");
      $sheet->setCellValue('A4', "PERIODO: ".Utils::fecha_string($periodo->perFechaInicial, 'mesCorto').' - '.Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'));
      $sheet->setCellValue('A5', $mensaje);

      $sheet->mergeCells('J1:AI1');
      $sheet->mergeCells('J2:AI2');
      $sheet->mergeCells('J3:AI3');
      $sheet->mergeCells('J4:AI4');
      $sheet->mergeCells('J5:AI5');

      $fechaActual = Carbon::now('America/Merida');
      $sheet->setCellValue('J1', $fechaActual->format('d/m/Y'));
      $sheet->setCellValue('J2', $fechaActual->format('H:i:s'));
      $sheet->setCellValue('J3', "Historial_de_cursos.xlsx");
      $sheet->setCellValue('J4', "Los alumnos marcados con un * tiene mas de una clave de pago");

      $sheet->getStyle('H6:AI6')->getAlignment()->setHorizontal('center');
      $sheet->setCellValue('H6', "PRE");
      $sheet->setCellValue('K6', "PRI");
      $sheet->setCellValue('Q6', "SEC");
      $sheet->setCellValue('T6', "BAC");
      // $sheet->setCellValue('Z6', "SUP");
      // $sheet->setCellValue('AF6', "POS");

      $sheet->setCellValueByColumnAndRow(1, 7, "Clave pago");
      $sheet->setCellValueByColumnAndRow(2, 7, "Nombre");
      $sheet->setCellValueByColumnAndRow(3, 7, "Programa");
      $sheet->setCellValueByColumnAndRow(4, 7, "Sem");
      $sheet->setCellValueByColumnAndRow(5, 7, "Gpo");
      $sheet->setCellValueByColumnAndRow(6, 7, "Edo");
      $sheet->setCellValueByColumnAndRow(7, 7, "Primer curso");

      // PRE
      $sheet->setCellValueByColumnAndRow(8, 7, "1");
      $sheet->getColumnDimension('H')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(9, 7, "2");
      $sheet->getColumnDimension('I')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(10, 7, "3");
      $sheet->getColumnDimension('J')->setAutoSize(true);

      // PRI
      $sheet->setCellValueByColumnAndRow(11, 7, "1");
      $sheet->getColumnDimension('K')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(12, 7, "2");
      $sheet->getColumnDimension('L')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(13, 7, "3");
      $sheet->getColumnDimension('M')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(14, 7, "4");
      $sheet->getColumnDimension('N')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(15, 7, "5");
      $sheet->getColumnDimension('O')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(16, 7, "6");
      $sheet->getColumnDimension('P')->setAutoSize(true);

      // SEC
      $sheet->setCellValueByColumnAndRow(17, 7, "1");
      $sheet->getColumnDimension('Q')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(18, 7, "2");
      $sheet->getColumnDimension('R')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(19, 7, "3");
      $sheet->getColumnDimension('S')->setAutoSize(true);

      // BAC
      $sheet->setCellValueByColumnAndRow(20, 7, "1");
      $sheet->getColumnDimension('T')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(21, 7, "2");
      $sheet->getColumnDimension('U')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(22, 7, "3");
      $sheet->getColumnDimension('V')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(23, 7, "4");
      $sheet->getColumnDimension('W')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(24, 7, "5");
      $sheet->getColumnDimension('X')->setAutoSize(true);
      $sheet->setCellValueByColumnAndRow(25, 7, "6");
      $sheet->getColumnDimension('Y')->setAutoSize(true);

      // SUP
      // $sheet->setCellValueByColumnAndRow(26, 7, "1");
      // $sheet->getColumnDimension('Z')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(27, 7, "2");
      // $sheet->getColumnDimension('AA')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(28, 7, "3");
      // $sheet->getColumnDimension('AB')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(29, 7, "4");
      // $sheet->getColumnDimension('AC')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(30, 7, "5");
      // $sheet->getColumnDimension('AD')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(31, 7, "6");
      // $sheet->getColumnDimension('AE')->setAutoSize(true);

      // // POS
      // $sheet->setCellValueByColumnAndRow(32, 7, "1");
      // $sheet->getColumnDimension('AF')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(33, 7, "2");
      // $sheet->getColumnDimension('AG')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(34, 7, "3");
      // $sheet->getColumnDimension('AH')->setAutoSize(true);
      // $sheet->setCellValueByColumnAndRow(35, 7, "4");
      // $sheet->getColumnDimension('AI')->setAutoSize(true);

      $fila = 8;
      foreach($results as $result) {
          $sheet->setCellValueExplicit("A{$fila}", $result->aluClave, DataType::TYPE_NUMERIC);
          $sheet->setCellValueExplicit("B{$fila}", $result->aluNombre, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("C{$fila}", $result->progClave, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("D{$fila}", $result->cgtGrado, DataType::TYPE_NUMERIC);
          $sheet->setCellValueExplicit("E{$fila}", $result->cgtGrupo, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("F{$fila}", $result->curEstado, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("G{$fila}", Carbon::parse($result->primerRegistro)->format('d/m/Y'), DataType::TYPE_STRING); // poner formato de fecha
          // PRE
          $sheet->setCellValueExplicit("H{$fila}", $result->PRE1, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("I{$fila}", $result->PRE2, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("J{$fila}", $result->PRE3, DataType::TYPE_STRING);
          $sheet->getStyle("H{$fila}:J{$fila}")->applyFromArray($styleArray);
          // PRI
          $sheet->setCellValueExplicit("K{$fila}", $result->PRI1, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("L{$fila}", $result->PRI2, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("M{$fila}", $result->PRI3, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("N{$fila}", $result->PRI4, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("O{$fila}", $result->PRI5, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("P{$fila}", $result->PRI6, DataType::TYPE_STRING);
          $sheet->getStyle("K{$fila}:P{$fila}")->applyFromArray($styleArray);
          // SEC
          $sheet->setCellValueExplicit("Q{$fila}", $result->SEC1, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("R{$fila}", $result->SEC2, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("S{$fila}", $result->SEC3, DataType::TYPE_STRING);
          $sheet->getStyle("Q{$fila}:S{$fila}")->applyFromArray($styleArray);
          // BAC
          $sheet->setCellValueExplicit("T{$fila}", $result->BAC1, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("U{$fila}", $result->BAC2, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("V{$fila}", $result->BAC3, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("W{$fila}", $result->BAC4, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("X{$fila}", $result->BAC5, DataType::TYPE_STRING);
          $sheet->setCellValueExplicit("Y{$fila}", $result->BAC6, DataType::TYPE_STRING);
          $sheet->getStyle("T{$fila}:Y{$fila}")->applyFromArray($styleArray);
          // SUP
          // $sheet->setCellValueExplicit("Z{$fila}", $result->SUP1, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AA{$fila}", $result->SUP2, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AB{$fila}", $result->SUP3, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AC{$fila}", $result->SUP4, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AD{$fila}", $result->SUP5, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AE{$fila}", $result->SUP6, DataType::TYPE_STRING);
          // $sheet->getStyle("Z{$fila}:AE{$fila}")->applyFromArray($styleArray);
          // // POS
          // $sheet->setCellValueExplicit("AF{$fila}", $result->POS1, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AG{$fila}", $result->POS2, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AH{$fila}", $result->POS3, DataType::TYPE_STRING);
          // $sheet->setCellValueExplicit("AI{$fila}", $result->POS4, DataType::TYPE_STRING);
          // $sheet->getStyle("AF{$fila}:AI{$fila}")->applyFromArray($styleArray);

          $fila++;
      }

      $writer = new Xlsx($spreadsheet);
      try {
          $writer->save(storage_path("Historial_de_cursos.xlsx"));
      } catch (Exception $e) {
          alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
          return back()->withInput();
      }

      return response()->download(storage_path("Historial_de_cursos.xlsx"))->deleteFileAfterSend(true);
    }

    public function generarPdf($results, $periodo, $opcion)
    {

      if ($opcion == 'F') {
        $mensaje = 'SÓLO SE INCLUYEN ALUMNOS QUE ESTEN REGISTRADOS EN AL MENOS UN CURSO ANTERIOR AL NIVEL PREPARATORIA';
      } elseif ($opcion == 'R') {
        $mensaje = 'SÓLO SE INCLUYEN ALUMNOS CON MÁS DE UNA CLAVE DE PAGO';
      } else {
        $mensaje = '';
      }

      $parametro_NombreArchivo = "pdf_historico_inscripcion";
      // view('reportes.pdf.bachiller.alumnos_leales.pdf_historico_inscripcion')
      $pdf = PDF::loadView('reportes.pdf.bachiller.alumnos_leales.' . $parametro_NombreArchivo, [
          'results' => $results,
          'periodo' => $periodo,
          'opcion' => $opcion,
          'mensaje' => $mensaje
      ]);

      return $pdf->stream($parametro_NombreArchivo . '.pdf');
      return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}
<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\ResumenAcademico;
use App\Http\Models\Plan;
use App\Http\Models\Historico;
use App\Http\Models\Curso;

use App\Http\Helpers\Utils;
use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MateriasAdeudadasAlumnoController extends Controller
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
    $ubicaciones = Ubicacion::where('id', '<>', 0)->get();
    return View('reportes/materias_adeudadas_alumno.create', compact('ubicaciones'));

  }

  public function imprimir(Request $request) {
    $fechaActual = Carbon::now('America/Merida');
    $swal_title = 'Sin registros';
    $swal_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';

    $plan = Plan::with('programa.escuela')
    ->whereHas('programa.escuela.departamento.ubicacion', static function($query) use ($request) {
      $query->where('escuela_id', $request->escuela_id);
      if($request->programa_id) {
        $query->where('programa_id', $request->programa_id);
      }
    })
    ->where(static function($query) use ($request) {
      if($request->plan_id) {
        $query->where('id', $request->plan_id);
      }
    })->first();

    if(!$plan) {
      alert()->warning($swal_title, $swal_text)->showConfirmButton();
      return back()->withInput();
    }

    $programa = $plan->programa;
    $escuela = $programa->escuela;
    $departamento = $escuela->departamento;
    $periodo = $departamento->periodoActual;
    $ubicacion = $departamento->ubicacion;

    $array_parametros = array(
      "'".$ubicacion->ubiClave."'",
      "'".$departamento->depClave."'",
      "'".$escuela->escClave."'",
      $request->programa_id ? "'".$programa->progClave."'" : "''",
      $request->plan_id ? "'".$plan->planClave."'" : "''",
      "'".$request->resUltimoGrado."'" ?: "''",
      "'".$request->aluClave."'" ?: "''",
      "'".$request->aluMatricula."'" ?: "''",
      "'".$request->perApellido1."'" ?: "''",
      "'".$request->perApellido2."'" ?: "''",
      "'".$request->perNombre."'" ?: "''",
      "'".$request->matClave."'" ?: "''",
      "'".$request->tipoReporte."'",
      "'".$request->resEstado."'",
      "'".$request->incluirNoCursadas."'",
      "'".$request->urgentes."'",
    );
    $parametros = implode(",", $array_parametros);
    $reprobadas = DB::select('call procMateriasAdeudadas('.$parametros.')');
    $reprobadas = collect($reprobadas);
    if($reprobadas->isEmpty()) {
      alert()->warning($swal_title, $swal_text)->showConfirmButton();
      return back()->withInput();
    }



    $descripcionReporte = 'NO se incluyen como adeudadas las materias no cursadas';
    if($request->incluirNoCursadas == 'S') {
      $descripcionReporte = 'SÍ se inccluyen como adeudadas las materias no cursadas';
    }

    $reprobadas = $reprobadas->map(static function($item, $key) {
      $item = collect($item)->put('nombreCompleto', $item->paterno.' '.$item->materno.' '.$item->nombre)
      ->put('programa_plan', $item->programa.' ('.$item->plan.') '.$item->nombrePrograma);
      return $item;
    });

    $agrupacion = ($request->tipoReporte == 'M') ? 'matClave' : 'cvePago';
    $orden = ($request->tipoReporte == 'M') ? 'matSemestre' : 'maxSemestre';

    $datos = $reprobadas->groupBy(['programa_plan',$orden, $agrupacion])->sortKeys();

    $nombreArchivo = 'pdf_materia_adeudada_por_alumno';
    if($request->tipoReporte == 'M') {
      $nombreArchivo = 'pdf_alumno_por_materia_adeudada';
    }

    $info_reporte = [
      "ubicacion"         => $ubicacion,
      "periodo"           => $periodo,
      "descripcionReporte" => $descripcionReporte,
      "datos"             => $datos,
      "tipoReporte"       => $request->tipoReporte,
      "nombreArchivo"     => $nombreArchivo . '.pdf',
      "fechaActual"       => $fechaActual->format('d/m/Y'),
      "horaActual"        => $fechaActual->format('H:i:s'),
    ];

    return $request->formato == 'PDF'
        ? PDF::loadView('reportes.pdf.' . $nombreArchivo, $info_reporte)->stream($nombreArchivo.'.pdf')
        : $this->generarExcel($info_reporte);
  }//imprimir.

  /**
   * @param array $info_reporte
   */
  public function generarExcel($info_reporte) {
    
      $alumnosAgrupadosPorPrograma = $info_reporte['datos'];

      $spreadsheet = new Spreadsheet();
      foreach($alumnosAgrupadosPorPrograma as $key => $alumnos_plan) {
          $info_plan = $alumnos_plan->first()->first()->first();
          $sheet_name = $info_plan['programa'] . " {$info_plan['plan']}";
          $newSheet = new Worksheet($spreadsheet, $sheet_name);
          $spreadsheet->addSheet($newSheet);
          $sheet = $spreadsheet->getSheetByName($sheet_name);
          self::llenarDatosPorTab($sheet, $info_reporte, $alumnos_plan);
      }
      $spreadsheet->removeSheetByIndex(0); # Borrar la primer tab (está vacía).

      $writer = new Xlsx($spreadsheet);
      try {
          $writer->save(storage_path("MateriasAdeudadasAlumno.xlsx"));
      } catch (Exception $e) {
          throw $e;
      }

      return response()->download(storage_path("MateriasAdeudadasAlumno.xlsx"));
  }

  /**
   * @param array $info_reporte
   * @param Illuminate\Support\Collection
   */
  private function llenarDatosPorTab($sheet, $info_reporte, $alumnos_plan) {

      $periodo = $info_reporte['periodo'];
      $departamento = $periodo->departamento;

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getColumnDimension('H')->setAutoSize(true);
      $sheet->mergeCells("A1:H1");
      $sheet->getStyle('A1')->getFont()->setBold(true);
      $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$departamento->depClave} - {$periodo->perNumero}/{$periodo->perAnio} | {$info_reporte['descripcionReporte']}");
      $sheet->getStyle("A2:H2")->getFont()->setBold(true);

      $columnasOrdenadas = self::definirOrdenColumnasExcel($info_reporte['tipoReporte']);

      $columnaHeadIndex = 1;
      foreach($columnasOrdenadas as $nombreColumna) {
        $sheet->setCellValueByColumnAndRow($columnaHeadIndex, 2, $nombreColumna);
        $columnaHeadIndex++;
      }

      $fila = 3;
      foreach($alumnos_plan as $semestre) {
        # $item puede ser materia o alumno, según el tipo de reporte.
        foreach($semestre as $item) { 
          foreach ($item as $adeudo) {
            $acreditacion = ($adeudo['acredPeriodo'] ?: '**') . '   ' . ($adeudo['acredTipo'] ?: '');
            $histCalificacion = $adeudo['calificacion'];
            if($histCalificacion) {
              $histCalificacion = ($histCalificacion == -1) ? 'NPE' : $histCalificacion;
            }

            if($info_reporte['tipoReporte'] == 'M') {
              $sheet->setCellValueExplicit("A{$fila}", $adeudo['matClave'], DataType::TYPE_STRING);
              $sheet->setCellValue("B{$fila}", $adeudo['matNombre']);
              $sheet->setCellValueExplicit("C{$fila}", $adeudo['cvePago'], DataType::TYPE_STRING);
              $sheet->setCellValue("D{$fila}", $adeudo['nombreCompleto']);
              $sheet->setCellValue("E{$fila}", $adeudo['maxSemestre']);
              $sheet->setCellValue("F{$fila}", $acreditacion);
              $sheet->setCellValue("G{$fila}", ($adeudo['noCursada'] == 0 ? 'No cursada': $adeudo['fechaExamen']));
              $sheet->setCellValue("H{$fila}", ($adeudo['noCursada'] == 1 ? $histCalificacion : ''));
            } else {
              $sheet->setCellValueExplicit("A{$fila}", $adeudo['cvePago'], DataType::TYPE_STRING);
              $sheet->setCellValue("B{$fila}", $adeudo['nombreCompleto']);
              $sheet->setCellValue("C{$fila}", $adeudo['maxSemestre']);
              $sheet->setCellValueExplicit("D{$fila}", $adeudo['matClave'], DataType::TYPE_STRING);
              $sheet->setCellValue("E{$fila}", $adeudo['matNombre']);
              $sheet->setCellValue("F{$fila}", $acreditacion);
              $sheet->setCellValue("G{$fila}", ($adeudo['noCursada'] == 0 ? 'No cursada': $adeudo['fechaExamen']));
              $sheet->setCellValue("H{$fila}", ($adeudo['noCursada'] == 1 ? $histCalificacion : ''));
            }
            $fila++;
          }
        }
      }
  }

  /**
   * @param string $tipoReporte
   */
  private static function definirOrdenColumnasExcel(string $tipoReporte): array
  {
    return $tipoReporte == 'M'
      ? ['Materia', 'Nombre de materia', 'Clave de pago', 'Nombre del alumno', 'Grado', 'Acreditación', 'Fecha examen', 'Calificacion']
      : ['Clave de pago', 'Nombre del alumno', 'Grado', 'Materia', 'Nombre de la materia', 'Acreditación', 'Fecha examen', 'Calificacion'];
  }

}//Controller class.

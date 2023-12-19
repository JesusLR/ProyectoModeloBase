<?php

namespace App\Http\Controllers\ReportesFederal\Segey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Beca;
use App\Models\PreparatoriaProcedencia;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RegistroAlumnosController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_alumnos_becados');
  }

  public function reporte()
  {
    return View('reportes-federal/segey/registro_alumnos.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function registroAlumnos($request)
  {
    //falta añoCurso
    $cursos = Curso::with('alumno.persona', 'periodo.departamento.ubicacion', 'cgt.plan.programa')
      ->whereHas('cgt.plan', static function($query) use ($request) {
        $query->where('planRegistro', 'F');
      })
      ->whereHas('cgt.plan.programa', static function($query) use ($request) {
        if($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
        if ($request->cgtGradoSemestre) {//BAC,SUP -------------------------
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);
        }
        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', '=', $request->cgtGrupo);
        }
      })
      ->whereHas('alumno.persona', static function($query) use ($request) {
        if ($request->aluEstado) {
          $query->where('aluEstado', '=', $request->aluEstado);
        }
      })
      ->where(static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        if($request->curEstado == 'T') {
          $query->whereIn('curEstado', ['P', 'C', 'A', 'R']);
        }else if($request->curEstado == 'R') {
          $query->where('curEstado', 'R');
        }
      })->get();

    // nuevo campo para ordenar por apellido1, apellido2, nombre
    $cursos = ($cursos)->map(function ($obj) {
      $obj->sortByNombres = str_slug($obj->alumno->persona->perApellido1
        . '-' . $obj->alumno->persona->perApellido2
        . '-' . $obj->alumno->persona->perNombre, '-');


      $obj->groupByCgt = str_slug($obj->cgt->plan->planClave
      . '-' . $obj->cgt->plan->programa->progClave
      . '-' . $obj->cgt->cgtGrupo
      . '-' . $obj->cgt->cgtGradoSemestre,
       '-');

      return $obj;
    })->sortBy("sortByNombres");


    if ($request->tipoPdf == "DG") {

      $cursos->map(function ($item, $key) {
        $preparatoriaId = $item->alumno->preparatoria_id;
        $item->prepaProcedencia = PreparatoriaProcedencia::where("id", "=", $preparatoriaId)->first();

        return $item;
      });
    }

    return $cursos;
  }


  public function imprimir(Request $request)
  {
    $cursos = collect();
    $archivo = "";
    $orientacion = "";

    $cursos = $this->registroAlumnos($request);
    $curso = $cursos->first();

    if(!$curso) {
      alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    $cursos = $cursos->groupBy("groupByCgt")->sortBy(function ($product, $key) {
      $progGradoGrupo = explode( '-', trim($key) );
      $progGradoGrupo = collect($progGradoGrupo)->slice(1)->all();
      $progGradoGrupo = implode("-", $progGradoGrupo);

      return $progGradoGrupo;
    });

    $prefix = $request->tipoArchivo == 'PDF' ? 'pdf_' : 'excel_';

    if ($request->tipoPdf == "RA") {
      $archivo = $prefix . "registro_alumnos";
      $orientacion = "portrait";
    }

    if ($request->tipoPdf == "DG") {
      $archivo = $prefix . 'datos_geral_alu_inscritos';
      $orientacion = "landscape";
    }

    $fechaActual = Carbon::now();
    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    if ($request->tipoArchivo == 'PDF') {
      $pdf = PDF::loadView('reportes.pdf.federal.segey.' . $archivo, [
        "cursos" => $cursos,
        "curso"  => $curso,
        "nombreArchivo" => $archivo . '.pdf',
        "fechaActual" => $fechaActual->toDateString(),
        "horaActual" => $fechaActual->toTimeString(),
      ]);

      $pdf->setPaper('letter', $orientacion);
      $pdf->defaultFont = 'Times Sans Serif';
      return $pdf->stream($archivo . '.pdf');
    } else {
      return $this->generarExcel($cursos, $curso, $archivo);
    }
  }

  public function generarExcel($cursos, $curse, $archivo)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);

    $fila = 1;
    foreach($cursos as $curso) {
      $sheet->mergeCells("A{$fila}:D{$fila}");
      $sheet->getStyle("A{$fila}")->getFont()->setBold(true);
      $sheet->setCellValue("A{$fila}", "CENTRO DE ENSEÑANZA SUPERIOR DE LA ESCUELA MODELO");
      $fila++;

      $sheet->mergeCells("A{$fila}:D{$fila}");
      $sheet->getStyle("A{$fila}")->getFont()->setBold(true);
      $anio = $curse->periodo->perAnio + 1;
      $sheet->setCellValue("A{$fila}", "REGISTRO DE ALUMNOS: {$curse->periodo->perAnio} - {$anio}");
      $fila++;

      $sheet->mergeCells("A{$fila}:D{$fila}");
      $sheet->getStyle("A{$fila}")->getFont()->setBold(true);
      $grupoCgt = $curso->first();
      $sheet->setCellValue("A{$fila}", "Nombre del programa: {$grupoCgt->cgt->plan->programa->progNombre}");
      $fila++;

      $sheet->mergeCells("A{$fila}:D{$fila}");
      $sheet->getStyle("A{$fila}")->getFont()->setBold(true);
      $grupoCgt = $curso->first();
      $sheet->setCellValue("A{$fila}", "Clave: {$grupoCgt->periodo->departamento->depClaveOficial}");
      $fila++;

      $sheet->mergeCells("A{$fila}:D{$fila}");
      $sheet->getStyle("A{$fila}")->getFont()->setBold(true);
      $grupoCgt = $curso->first();
      $sheet->setCellValue("A{$fila}", "Semestre: {$grupoCgt->cgt->cgtGradoSemestre} {$grupoCgt->cgt->cgtGrupo}");
      $fila++;

      $sheet->getStyle("A{$fila}:G{$fila}")->getFont()->setBold(true);
      $sheet->setCellValueByColumnAndRow(1, $fila, "No");
      $sheet->setCellValueByColumnAndRow(2, $fila, "Matrícula");
      $sheet->setCellValueByColumnAndRow(3, $fila, "CURP");
      $sheet->setCellValueByColumnAndRow(4, $fila, "Nombre");
      $sheet->setCellValueByColumnAndRow(5, $fila, "Sexo");
      $sheet->setCellValueByColumnAndRow(6, $fila, "T.I.");
      $sheet->setCellValueByColumnAndRow(7, $fila, "T.R.");
      $fila++;
      $loop = 1;
      foreach($curso as $alumno) {
        $sheet->setCellValueExplicit("A{$fila}", $loop, DataType::TYPE_NUMERIC);
        $sheet->setCellValueExplicit("B{$fila}", $alumno->alumno->aluMatricula, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("C{$fila}", $alumno->alumno->persona->perCurp, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("D{$fila}", $alumno->alumno->persona->perApellido1 . ' ' . $alumno->alumno->persona->perApellido2 . ' ' . $alumno->alumno->persona->perNombre, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("E{$fila}", $alumno->alumno->persona->perSexo, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("F{$fila}", $alumno->curTipoIngreso, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit("G{$fila}", '', DataType::TYPE_STRING);
        $fila++;
        $loop++;
      }
    }

    $writer = new Xlsx($spreadsheet);
    try {
        $writer->save(storage_path($archivo . '.xlsx'));
    } catch (Exception $e) {
        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
        return back()->withInput();
    }

    return response()->download(storage_path($archivo . '.xlsx'))->deleteFileAfterSend(true);
}
}

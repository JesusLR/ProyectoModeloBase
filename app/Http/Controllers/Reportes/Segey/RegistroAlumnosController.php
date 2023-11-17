<?php

namespace App\Http\Controllers\Reportes\Segey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\Http\Models\Beca;
use App\Http\Models\PreparatoriaProcedencia;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

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
    return View('reportes/segey/registro_alumnos.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function registroAlumnos($request)
  {
    //falta añoCurso
    $cursos = Curso::with('alumno.persona', 'periodo.departamento.ubicacion', 'cgt.plan.programa')
      
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

    if ($request->tipoPdf == "RA") {
      $archivo = "pdf_registro_alumnos";
      $orientacion = "portrait";
    }

    if ($request->tipoPdf == "DG") {
      $archivo = 'pdf_datos_geral_alu_inscritos';
      $orientacion = "landscape";
    }

    $fechaActual = Carbon::now();
    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $pdf = PDF::loadView('reportes.pdf.segey.' . $archivo, [
      "cursos" => $cursos,
      "curso"  => $curso,
      "nombreArchivo" => $archivo . '.pdf',
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
    ]);

    $pdf->setPaper('letter', $orientacion);
    $pdf->defaultFont = 'Times Sans Serif';
    return $pdf->stream($archivo . '.pdf');
  }
}
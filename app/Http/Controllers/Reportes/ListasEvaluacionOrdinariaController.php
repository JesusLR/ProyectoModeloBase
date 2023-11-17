<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Grupo;
use App\Http\Models\Inscrito;
use App\Http\Models\Horario;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ListasEvaluacionOrdinariaController extends Controller
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
    return View('reportes/listas_evaluacion_ordinaria.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }

  
  public function listasEvaluacionOrdinaria($request)
  {
    $grupos = Grupo::with('periodo', 'plan.programa.escuela.departamento.ubicacion',
      'periodo', 'empleado.persona', 'materia')

      ->whereHas('plan.programa.escuela', function($query) use ($request) {
        if($request->programa_id)
          $query->where('programa_id', $request->programa_id);
        if ($request->plan_id)
          $query->where('plan_id', '=', $request->plan_id);
      })
      ->whereHas('materia', function($query) use ($request) {
        if ($request->matClave)
          $query->where('matClave', $request->matClave);
      })
      ->where(static function($query) use ($request) {
        if($request->grupo_id)
          $query->where('id', $request->grupo_id);
        if($request->periodo_id)
          $query->where('periodo_id', $request->periodo_id);
        if($request->gpoSemestre)
          $query->where('gpoSemestre', $request->gpoSemestre);
        if($request->gpoClave)
          $query->where('gpoClave', $request->gpoClave);
        if($request->empleado_id)
          $query->where('empleado_id', $request->empleado_id);
      })
      ->get();

      if($grupos->isEmpty()) {
        return false;
      }

    //obtener inscritos por cada grupo (grupo_id)
    $grupoIds = $grupos->pluck('id');

    //obtener escolaridad de los directores 
    $directorIds = $grupos->map(function ($item, $key) {
      return $item->plan->programa->escuela->empleado->id;
    })->unique()->all();

    $escolaridad = DB::table("escolaridad")->whereIn("empleado_id", $directorIds) // $directorIds
      ->leftJoin('abreviaturastitulos', 'escolaridad.abreviaturaTitulo_id', '=', 'abreviaturastitulos.id')
      ->where('escolaridad.escoUltimoGrado', '=', 'S')->get();

    $grupos = $grupos->map(function ($item, $key) use ($escolaridad) {
      $dirEscolaridad = $escolaridad->filter(function ($value, $key) use ($item) {
        return $value->empleado_id == $item->plan->programa->escuela->empleado->id;
      })->first();

      if ($dirEscolaridad) {
        $item->escolaridadDirector  = $dirEscolaridad->abtAbreviatura;
      } else {
        $item->escolaridadDirector = "";
      }

      return $item;
    });

    //meter columna de inscritos a grupos
    $inscritos = Inscrito::whereIn("grupo_id", $grupoIds)
      ->leftJoin("calificaciones", "inscritos.id", "=", "calificaciones.inscrito_id")
      ->leftJoin("cursos", "inscritos.curso_id", "=", "cursos.id")
      ->leftJoin("alumnos", "cursos.alumno_id", "=", "alumnos.id")
      ->leftJoin("personas", "alumnos.persona_id", "=", "personas.id")
      ->where("cursos.curEstado", "<>", "B")
    ->get(); // tiene repetidos los id de alumnos

    //SORTBY APELLIDOS NOMBRE
    $inscritos = $inscritos->map(function ($item, $key) {
      $item->sortByApellidoNombre = str_slug($item->perApellido1 . "-" . $item->perApellido2 . "-" . $item->perNombre, '-');
      return $item;
    })->sortBy("sortByApellidoNombre")->groupBy("grupo_id");

    $grupos = ($grupos)->map(function ($item, $key) use ($inscritos) {

      //sortBy materia grupo semestre
      $item->sortByMateriaGrupoSemestre = str_slug($item->materia->matClave . "-" . $item->gpoClave . '-' . $item->gpoSemestre, '-');

      //meter columna de inscritos
      $grupoId = $item->id;
      $inscritosGpo = $inscritos->filter(function ($value, $key) use ($grupoId) {
        return $key == $grupoId;
      })->first();

      if ($inscritosGpo) {      
        $item->inscritos = $inscritosGpo->all();
      } else {
        $item->inscritos = [];
      }

      return $item;
    });

    if ($request->numAlumnos) {
      $grupos = $grupos->filter(function ($grupo, $key) use ($request) {

        if ($request->filtroNumAlumnos == "mayor") {
          return count($grupo->inscritos) >= $request->numAlumnos;
        }
        if ($request->filtroNumAlumnos == "menor") {
          return count($grupo->inscritos) <= $request->numAlumnos;
        }
        if ($request->filtroNumAlumnos == "igual" || !$request->filtroNumAlumnos) {
          return count($grupo->inscritos) == $request->numAlumnos;
        }
      });
    }

    if($grupos->isEmpty()) {
      return false;
    }

    return collect($grupos)->sortBy("sortByMateriaGrupoSemestre");
  }


  public function imprimir(Request $request)
  {
    $grupos = $this->listasEvaluacionOrdinaria($request);

    if (!$grupos) {
      alert()->error('Error', 'No se encontraron resultados')->showConfirmButton()->autoClose(2000);
      return redirect()->back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');

    $escuelaPorcentajeExamenOrdinario = 30;
    $escuelaPorcentajeExamenParcial   = 70;

    if ($grupos->first()->plan->programa->escuela->escPorcExaPar) {
      $escuelaPorcentajeExamenParcial = $grupos->first()->plan->programa->escuela->escPorcExaPar;

    }
    if ($grupos->first()->plan->programa->escuela->escPorcExaOrd) {
      $escuelaPorcentajeExamenOrdinario = $grupos->first()->plan->programa->escuela->escPorcExaOrd;
    }

    if ($grupos->first()->materia->matPorcentajeParcial) {
      $escuelaPorcentajeExamenParcial = $grupos->first()->materia->matPorcentajeParcial;
    }
    if ($grupos->first()->materia->matPorcentajeOrdinario) {
      $escuelaPorcentajeExamenOrdinario = $grupos->first()->materia->matPorcentajeOrdinario;
    }

    $nombreArchivo = 'pdf_listas_evaluacion_ordinaria';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "grupos" => $grupos,
      "nombreArchivo" => $nombreArchivo,
      "curEstado" => $request->curEstado,
      "escuelaPorcentajeExamenParcial" => $escuelaPorcentajeExamenParcial,
      "escuelaPorcentajeExamenOrdinario" => $escuelaPorcentajeExamenOrdinario,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString()
    ])->stream($nombreArchivo . '.pdf');
  }
}
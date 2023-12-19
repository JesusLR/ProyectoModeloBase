<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Grupo;
use App\Models\Inscrito;
use App\Models\Portal_configuracion;

use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ListasEvaluacionParcialController extends Controller
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
  }

  public function reporte()
  {
    return View('reportes/listas_evaluacion_parcial.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function listasEvaluacionParcial($request)
  {
    $grupos = Grupo::with('plan.programa.escuela.departamento.ubicacion', 'periodo', 'empleado.persona', 'materia')
      ->whereHas('plan.programa.escuela.departamento.ubicacion', static function($query) use ($request) {
        if($request->programa_id)
          $query->where('programa_id', $request->programa_id);
        if ($request->plan_id)
          $query->where('plan_id', $request->plan_id);

      })
      ->whereHas('materia', static function($query) use ($request) {
        if ($request->matClave)
          $query->where('matClave', '=', $request->matClave);
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
        if($request->grupo_id)
          $query->where('id', $request->grupo_id);
      })->get();

      if($grupos->isEmpty()) {
        return false;
      }

    //obtener escolaridad de los directores
    $directorIds = $grupos->map(function ($item, $key) {
      return $item->plan->programa->escuela->empleado->id;
    })->unique()->all();

    $escolaridad = DB::table("escolaridad")->whereIn("empleado_id", $directorIds)
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
    $inscritos = Inscrito::whereIn("grupo_id", $grupos->pluck('id'))
      ->leftJoin("calificaciones", "inscritos.id", "=", "calificaciones.inscrito_id")
      ->leftJoin("cursos", "inscritos.curso_id", "=", "cursos.id")
      ->leftJoin("alumnos", "cursos.alumno_id", "=", "alumnos.id")
      ->leftJoin("personas", "alumnos.persona_id", "=", "personas.id")
      ->where("cursos.curEstado", "<>", "B")
    ->get();// tiene repetidos los id de alumnos

    $inscritos = $inscritos->map(function ($item, $key) {
      $alumno = $item->curso->alumno->persona->perApellido1 . "-" .
          $item->curso->alumno->persona->perApellido2  . "-" .
          $item->curso->alumno->persona->perNombre;

      $item->sortByNombres = Str::slug($alumno, "-");

      return $item;
    });

    $inscritos = $inscritos->sortBy("sortByNombres")->groupBy("grupo_id");

    $grupos = ($grupos)->map(function ($item, $key) use ($inscritos) {

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

    if($grupos->isEmpty()) {
      return false;
    }

    return collect($grupos)->where("inscritos_gpo", ">", 0)->sortBy("gpoSemestre");
  }


  public function imprimir(Request $request)
  {
    $configTercerParcial = Portal_configuracion::select('pcEstado')
      ->where('pcClave', 'TERCER_PARCIAL')
      ->where('pcPortal', 'D')
      ->first();
      $TERCER_PARCIAL = ($configTercerParcial->pcEstado == 'A');
    $grupos = $this->listasEvaluacionParcial($request);

    if(!$grupos) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_listas_evaluacion_parcial';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "grupos" => $grupos,
      "nombreArchivo" => $nombreArchivo,
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      'TERCER_PARCIAL' => $TERCER_PARCIAL
    ])->stream($nombreArchivo . '.pdf');
  }
}

<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Grupo;
use App\Models\Inscrito;
use App\Models\Horario;
use App\Models\Escolaridad;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CalendarioExamenesOrdinariosController extends Controller
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
    return View('reportes/calendario_examenes_ordinarios.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function calendarioExamenesOrdinarios($request)
  {
    $grupos = Grupo::with('materia', 'plan.programa.escuela.departamento.ubicacion', 'empleado.persona')
      ->whereHas('plan.programa.escuela', static function($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
      })
      ->whereHas('materia', static function($query) use ($request) {
        if ($request->matClave) {
          $query->where('matClave', '=', $request->matClave);//
        }
      })
      ->where(static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        if($request->gpoSemestre) {
          $query->where('gpoSemestre', $request->gpoSemestre);
        }
        if($request->gpoClave) {
          $query->where('gpoClave', $request->gpoClave);
        }
        if($request->empleado_id) {
          $query->where('empleado_id', $request->empleado_id);
        }
      })->get();

    if($grupos->isEmpty()) {
      return false;
    }


    $escolaridad = Escolaridad::with("abreviatura")->get();

    $inscritos = Inscrito::whereIn("grupo_id", $grupos->pluck('id'))
      ->leftJoin("cursos", "inscritos.curso_id", "=", "cursos.id")
      ->where("cursos.curEstado", "<>", "B")
      ->get()->groupBy("grupo_id");// tiene repetidos los id de alumnos


    //hacer merge de cantidad de alumnos a grupos
    $grupos = $grupos->map(function ($item, $key) use ($escolaridad, $inscritos) {
      $item["abtAbreviatura"] =
        $escolaridad
          ->where("empleado_id", "=", $item->empleado_id)
          ->where('escoUltimoGrado', '=', 'S')
        ->first()
        ? $escolaridad
          ->where("empleado_id", "=", $item->empleado_id)
          ->where('escoUltimoGrado', '=', 'S')
          ->first()->abreviatura->abtAbreviatura
        : "";

      $item["sortByGrupoFechaSemestre"] = str_slug( $item["gpoClave"] . '-' . $item["gpoFechaExamenOrdinario"]   , '-');
      $item["groupByGpoSemestreGpoClave"] = str_slug( $item["gpoSemestre"] . '-' . $item["gpoClave"]   , '-');

      $grupoId = $item->id;
      $inscrito = $inscritos->filter(function ($value, $key) use ($grupoId) {
        return $grupoId == $key;
      })->first();

      if ($inscrito) {
        $item->cantidadInscritos = count($inscrito->all());
      } else {
        $item->cantidadInscritos = 0;
      }

      return $item;
    });


    if ($request->numAlumnos) {
      $grupos = $grupos->filter(function ($grupo, $key) use ($request) {
        if ($request->filtroNumAlumnos == "mayor") {
          return $grupo->cantidadInscritos >= $request->numAlumnos;
        }
        if ($request->filtroNumAlumnos == "menor") {
          return $grupo->cantidadInscritos <= $request->numAlumnos;
        }
        if ($request->filtroNumAlumnos == "igual" || !$request->filtroNumAlumnos) {
          return $grupo->cantidadInscritos == $request->numAlumnos;
        }
      });
    }

    $grupos = ($grupos)->sortBy("gpoSemestre")->groupBy("groupByGpoSemestreGpoClave");

    if($grupos->isEmpty()) {
      return false;
    }

    return $grupos;
  }


  public function imprimir(Request $request)
  {
    $grupos = collect();

    $nombreArchivo = "pdf_calendario_examenes_ordinarios";
    $grupos = $this->calendarioExamenesOrdinarios($request);

    if(!$grupos) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('CDT');

    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $pdf = PDF::loadView('reportes.pdf.' . $nombreArchivo, [
      "grupos" => $grupos,
      "nombreArchivo" => $nombreArchivo . ".pdf",
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
    ]);

    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');
  }
}
<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Cgt;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\Inscrito;
use App\Models\Calificacion;
use App\Models\Ubicacion;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ResumenCalificacionPorGrupo extends Controller
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
    $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
    return View('reportes/resumen_cal_por_grupo.create', compact('ubicaciones'));
  }
  
  public function resumenCalifPorGrupo($request)
  {
    $cgts = Cgt::with("plan.programa.escuela.departamento", "periodo")
      ->whereHas('periodo', static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
      })
      ->whereHas('plan.programa.escuela.departamento', static function($query) use ($request) {
        $query->where('escuela_id', $request->escuela_id);
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
      })
      ->where(static function($query) use ($request) {
        if($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
        }
        if($request->cgtGrupo) {
          $query->where('cgtGrupo', $request->cgtGrupo);
        }
      })->get();

    if($cgts->isEmpty()) {
      return false;
    }

    $cgts = $cgts->map(function ($cgt, $key) use ($request) {


      $inscritos = Inscrito::with("curso")
        ->whereHas('curso.cgt',function($query) use ($cgt) {
          $query->where('cgt_id', $cgt->id);
        })
      ->get()
      ->unique("curso.id")
      ->sortBy(function ($item, $key) {
        return $item->curso->alumno->persona->perApellido1
          . $item->curso->alumno->persona->perApellido2
          . $item->curso->alumno->persona->perNombre;
      });



      $cursoIds = $inscritos->map(function($item, $key) {
        return $item->curso->id;
      })->all();

      $grupoCalif = Calificacion::with("inscrito", "inscrito.grupo", "inscrito.curso")
        ->whereHas('inscrito.curso',function($query) use ($cursoIds) {
          $query->whereIn('curso_id', $cursoIds);
        })
      ->get();



      if ($request->incluyeMaterias == "BASICAS") {
        $grupoCalif = $grupoCalif->filter(function ($item, $key) {
          return $item->inscrito->grupo->optativa_id == null;
        });
      }
      if ($request->incluyeMaterias == "OPT") {
        $grupoCalif = $grupoCalif->filter(function ($item, $key) {
          return $item->inscrito->grupo->optativa_id != null;
        });
      }



      $materias = Materia::where("plan_id", "=", $cgt->plan_id)
        ->where("matSemestre", "=", $cgt->cgtGradoSemestre)
      ->get();


      if ($request->incluyeMaterias == "BASICAS"
      ||  $request->incluyeMaterias == "OPT") {
        $materiaBasicaOpt = $grupoCalif->unique("inscrito.grupo.materia.id")->map(function ($item, $key) {
          return $item->inscrito->grupo->materia->id;
        });
        $materias = $materias->whereIn("id", $materiaBasicaOpt);
      }



      $cgt->inscritos  = $inscritos;
      $cgt->materias   = $materias;
      $cgt->grupoCalif = $grupoCalif;

      return $cgt;
    })->filter(function ($item, $key) {
      return $item->inscritos->count() > 0;
    });

    return $cgts;
  }


  public function imprimir(Request $request)
  {
    $cgts = $this->resumenCalifPorGrupo($request);

    if(!$cgts) {
      alert()->warning('Sin coincidencias', 'No hay registros que cumplan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
    
    $fechaActual = Carbon::now('America/Merida');

    $nombreArchivo = 'pdf_resumen_cal_por_grupo.pdf';
    return PDF::loadView('reportes.pdf.pdf_resumen_cal_por_grupo', [
      "cgts"             => $cgts,
      "tipoCalificacion" => $request->tipoCalificacion,
      "incluyeFaltas"    => $request->incluyeFaltas == 'SI' ? true : false,
      "nombreArchivo"    => $nombreArchivo,
      "curEstado"        => $request->curEstado,
      "fechaActual"      => $fechaActual->toDateString(),
      "horaActual"       => $fechaActual->toTimeString(),
    ])->stream($nombreArchivo);
  }
}
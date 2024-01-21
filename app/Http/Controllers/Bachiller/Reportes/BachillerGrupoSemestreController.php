<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_cch_horarios;
use App\Models\Bachiller\Bachiller_cch_inscritos;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_horarios;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Bachiller\Bachiller_paquete_detalle;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Horario;
use App\Models\Paquete_detalle;
use App\Models\Empleado;
use App\Models\Inscrito;

use Carbon\Carbon;
use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerGrupoSemestreController extends Controller
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

    return view('bachiller.reportes.grupo_semestre.create', [
      "ubicaciones"     => Ubicacion::where('ubiClave', '<>', '000')->get(),
      "empleados"     => Bachiller_empleados::where('id', '<>', '0')->get()
    ]);
  }



  public function horariosGrupoSemestreYucatan($request)
  {
    $grupos = Bachiller_horarios::with(['bachiller_grupo_merida.bachiller_materia.plan.programa.escuela', 'aula', 'bachiller_grupo_merida.bachiller_empleado'])
      ->whereHas('bachiller_grupo_merida.bachiller_materia.plan', function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        $query->where('plan_id', $request->plan_id);
        if ($request->gpoSemestre) {
          $query->where('gpoGrado', '=', $request->gpoSemestre);
        }
        if ($request->gpoClavegpoClave) {
          $query->where('gpoClave', '=', $request->gpoClavegpoClave);
        }
        if ($request->empleado_id) {
          $query->where("empleado_id_docente", "=", $request->empleado_id);
        }
        if ($request->materia_id) {
          $query->where('bachiller_materia_id', '=', $request->materia_id);
        }
      })->get();

    if($grupos->isEmpty()) {
      return false;
    }

    $inscritosByGrupoIds = Bachiller_inscritos::whereIn('bachiller_grupo_id', $grupos->pluck('grupo_id'))->get();
    //hacer merge de cantidad de alumnos a grupos
    $grupos = $grupos->map(function ($item, $key) use ($inscritosByGrupoIds) {

        if(is_null($item["bachiler_grupo"])){
            $matClave = " ";
        }else{
            $matClave = $item["bachiler_grupo"]["bachiller_materia"]["matClave"];
        }

      $item["sortGrupoClaveMat"] = str_slug($item["bachiller_grupo_merida"]["gpoClave"]
      .'-'. $matClave , '-');

      $cantidadAlumnos = $inscritosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->bachiller_grupo_id == $item["grupo_id"];
      })->count();

      $item["cantidadAlumnos"] = $cantidadAlumnos;

      return $item;
    });

    return collect($grupos)->sortBy("bachiller_grupo_merida.gpoGrado")->groupBy("bachiller_grupo_merida.gpoGrado");
  }

  public function horariosGrupoSemestreChetumal($request)
  {
    $grupos = Bachiller_cch_horarios::with(['bachiller_grupo_chetumal.bachiller_materia.plan.programa.escuela', 'aula', 'bachiller_grupo_chetumal.bachiller_empleado'])
      ->whereHas('bachiller_grupo_chetumal.bachiller_materia.plan', function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        $query->where('plan_id', $request->plan_id);
        if ($request->gpoSemestre) {
          $query->where('gpoGrado', '=', $request->gpoSemestre);
        }
        if ($request->gpoClavegpoClave) {
          $query->where('gpoClave', '=', $request->gpoClavegpoClave);
        }
        if ($request->empleado_id) {
          $query->where("empleado_id_docente", "=", $request->empleado_id);
        }
        if ($request->materia_id) {
          $query->where('bachiller_materia_id', '=', $request->materia_id);
        }
      })->get();

    if($grupos->isEmpty()) {
      return false;
    }

    $inscritosByGrupoIds = Bachiller_cch_inscritos::whereIn('bachiller_grupo_id', $grupos->pluck('id'))->get();

    //hacer merge de cantidad de alumnos a grupos
    $grupos = $grupos->map(function ($item, $key) use ($inscritosByGrupoIds) {

      $item["sortGrupoClaveMat"] = str_slug($item["bachiller_grupo_chetumal"]["gpoClave"]
      .'-'.$item["bachiller_grupo_chetumal"]["bachiller_materia"]["matClave"], '-');

      $cantidadAlumnos = $inscritosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["id"];
      })->count();

      $item["cantidadAlumnos"] = $cantidadAlumnos;

      return $item;
    });

    return collect($grupos)->sortBy("bachiller_grupo_chetumal.gpoGrado")->groupBy("bachiller_grupo_chetumal.gpoGrado");
  }


  public function horariosGrupoSemestrePaquetesYucatan(Request $request)
  {
    $grupos = Bachiller_paquete_detalle::with('bachiller_paquete', 'bachiller_grupo_yucatan.bachiller_materia.plan.programa.escuela','bachiller_grupo_yucatan.bachiller_empleado')
      ->whereHas('bachiller_paquete', static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        $query->where('plan_id', $request->plan_id);
      })
      ->whereHas('bachiller_grupo_yucatan.bachiller_materia.plan', function($query) use ($request) {
        if ($request->gpoSemestre) {
          $query->where('gpoGrado', '=', $request->gpoSemestre);
        }
        if ($request->gpoClave) {
          $query->where('gpoClave', '=', $request->gpoClave);
        }
        if ($request->empleado_id) {
          $query->where("empleado_id_docente", "=", $request->empleado_id);
        }
        if ($request->materia_id) {
          $query->where('bachiller_materia_id', '=', $request->materia_id);
        }
      })->get();

    if($grupos->isEmpty()) {
      return false;
    }

    $inscritosByGrupoIds = Bachiller_inscritos::whereIn('bachiller_grupo_id', $grupos->pluck('bachiller_grupo_id'))->get();
    $horariosByGrupoIds = Bachiller_horarios::whereIn('grupo_id', $grupos->pluck('grupo_id'))
      ->leftJoin("aulas", "bachiller_horarios.aula_id", "=", "aulas.id")
      ->get();

    //hacer merge de cantidad de alumnos a grupos
    $grupos = $grupos->map(function ($item, $key) use ($inscritosByGrupoIds, $horariosByGrupoIds) {

      $item["sortGrupoClaveMat"] = str_slug($item["grupo"]["gpoClave"]
      .'-'.$item["bachiller_grupo_yucatan"]["bachiller_materia"]["matClave"], '-');

      $cantidadAlumnos = $inscritosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["id"];
      })->count();

      $horarios = $horariosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["grupo_id"];
      });


      $item["cantidadAlumnos"] = $cantidadAlumnos;
      $item["horarios"] = $horarios;

      return $item;
    });

    if ($request->tipoReporte == "gradoMateria" && $request->tipoGradoMateria == "maestros") {
      return collect($grupos);
    }else{
      return collect($grupos)->sortBy("bachiller_grupo_yucatan.gpoGrado")->groupBy("bachiller_paquete_id");
    }


  }

  public function horariosGrupoSemestrePaquetesChetumal(Request $request)
  {
    $grupos = Bachiller_paquete_detalle::with('bachiller_paquete', 'bachiller_grupo_yucatan.bachiller_materia.plan.programa.escuela','bachiller_grupo_yucatan.bachiller_empleado')
      ->whereHas('bachiller_paquete', static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        $query->where('plan_id', $request->plan_id);
      })
      ->whereHas('bachiller_grupo_yucatan.bachiller_materia.plan', function($query) use ($request) {
        if ($request->gpoSemestre) {
          $query->where('gpoGrado', '=', $request->gpoSemestre);
        }
        if ($request->gpoClave) {
          $query->where('gpoClave', '=', $request->gpoClave);
        }
        if ($request->empleado_id) {
          $query->where("empleado_id_docente", "=", $request->empleado_id);
        }
        if ($request->materia_id) {
          $query->where('bachiller_materia_id', '=', $request->materia_id);
        }
      })->get();

    if($grupos->isEmpty()) {
      return false;
    }

    $inscritosByGrupoIds = Bachiller_inscritos::whereIn('bachiller_grupo_id', $grupos->pluck('bachiller_grupo_id'))->get();
    $horariosByGrupoIds = Bachiller_horarios::whereIn('grupo_id', $grupos->pluck('grupo_id'))
      ->leftJoin("aulas", "bachiller_horarios.aula_id", "=", "aulas.id")
      ->get();

    //hacer merge de cantidad de alumnos a grupos
    $grupos = $grupos->map(function ($item, $key) use ($inscritosByGrupoIds, $horariosByGrupoIds) {

      $item["sortGrupoClaveMat"] = str_slug($item["grupo"]["gpoClave"]
      .'-'.$item["bachiller_grupo_merida"]["bachiller_materia"]["matClave"], '-');

      $cantidadAlumnos = $inscritosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["id"];
      })->count();

      $horarios = $horariosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["grupo_id"];
      });


      $item["cantidadAlumnos"] = $cantidadAlumnos;
      $item["horarios"] = $horarios;

      return $item;
    });


    return collect($grupos)->sortBy("bachiller_grupo_yucatan.gpoGrado")->groupBy("bachiller_paquete_id");
  }


  public function horariosGrupoSemestrePaquetesYucantan(Request $request)
  {
    $grupos = Bachiller_paquete_detalle::with('bachiller_paquete', 'bachiller_grupo_yucatan.bachiller_materia.plan.programa.escuela','bachiller_grupo_yucatan.bachiller_empleado')
      ->whereHas('bachiller_paquete', static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        $query->where('plan_id', $request->plan_id);
      })
      ->whereHas('bachiller_grupo_yucatan.bachiller_materia.plan', function($query) use ($request) {
        if ($request->gpoSemestre) {
          $query->where('gpoGrado', '=', $request->gpoSemestre);
        }
        if ($request->gpoClave) {
          $query->where('gpoClave', '=', $request->gpoClave);
        }
        if ($request->empleado_id) {
          $query->where("empleado_id_docente", "=", $request->empleado_id);
        }
        if ($request->materia_id) {
          $query->where('bachiller_materia_id', '=', $request->materia_id);
        }
      })->get();

    if($grupos->isEmpty()) {
      return false;
    }

    $inscritosByGrupoIds = Bachiller_inscritos::whereIn('bachiller_grupo_id', $grupos->pluck('bachiller_grupo_id'))->get();
    $horariosByGrupoIds = Bachiller_horarios::whereIn('grupo_id', $grupos->pluck('grupo_id'))
      ->leftJoin("aulas", "bachiller_horarios.aula_id", "=", "aulas.id")
      ->get();

    //hacer merge de cantidad de alumnos a grupos
    $grupos = $grupos->map(function ($item, $key) use ($inscritosByGrupoIds, $horariosByGrupoIds) {

      $item["sortGrupoClaveMat"] = str_slug($item["bachiller_grupo_yucatan"]["gpoClave"]
      .'-'.$item["bachiller_grupo_yucatan"]["bachiller_materia"]["matClave"], '-');

      $cantidadAlumnos = $inscritosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["id"];
      })->count();

      $horarios = $horariosByGrupoIds->filter(function ($value, $key) use ($item) {
        return $value->grupo_id == $item["grupo_id"];
      });


      $item["cantidadAlumnos"] = $cantidadAlumnos;
      $item["bachiller_horarios"] = $horarios;

      return $item;
    });


    // return collect($grupos)->sortBy("bachiller_grupo_yucatan.gpoGrado")->groupBy("bachiller_paquete_id");
    return collect($grupos)->groupBy("bachiller_paquete_id");

  }


  public function imprimir(Request $request)
  {


    if ($request->tipoReporte == "gradoMateria") {
      if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
        $grupos = $this->horariosGrupoSemestreYucatan($request);
      }else{
        $grupos = $this->horariosGrupoSemestreChetumal($request);
      }

    }

    if ($request->tipoReporte == "paquete") {
      if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
        $grupos = $this->horariosGrupoSemestrePaquetesYucantan($request);
      }else{
        $grupos = $this->horariosGrupoSemestrePaquetesChetumal($request);
      }

    }

    if(!$grupos) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }


    $fechaActual = Carbon::now('America/Merida');

    if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
      if ($request->tipoReporte == "gradoMateria" && $request->tipoGradoMateria == "horarios") {
        $nombreArchivo = 'pdf_grupo_semestre';
      }
      if ($request->tipoReporte == "gradoMateria" && $request->tipoGradoMateria == "maestros") {
        $nombreArchivo = 'pdf_grupo_semestre_maestros';
      }
      if ($request->tipoReporte == "paquete") {
        $nombreArchivo = 'pdf_grupo_semestre_paquete';
      }
    }else{
      if ($request->tipoReporte == "gradoMateria" && $request->tipoGradoMateria == "horarios") {
        $nombreArchivo = 'pdf_grupo_semestre_chetumal';
      }
      if ($request->tipoReporte == "gradoMateria" && $request->tipoGradoMateria == "maestros") {
        $nombreArchivo = 'pdf_grupo_semestre_maestros_chetumal';
      }
      if ($request->tipoReporte == "paquete") {
        $nombreArchivo = 'pdf_grupo_semestre_paquete_chetumal';
      }
    }


    // view('reportes.pdf.bachiller.horarios.pdf_grupo_semestre');
    $pdf = PDF::loadView('reportes.pdf.bachiller.horarios.'.$nombreArchivo, [
      "grupos" => $grupos,
      "nombreArchivo" => $nombreArchivo,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
    ]);

    $pdf->setPaper('letter', 'landscape');

    return $pdf->stream($nombreArchivo.'.pdf');
  }
}

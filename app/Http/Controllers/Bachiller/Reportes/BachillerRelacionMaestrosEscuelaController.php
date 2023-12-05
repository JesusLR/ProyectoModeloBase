<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_cch_grupos;
use App\Models\Bachiller\Bachiller_grupos;
use Illuminate\Support\Collection;
use App\Models\Departamento;
use App\Models\Grupo;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerRelacionMaestrosEscuelaController extends Controller
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
    return view('bachiller.reportes.relacion_maestros_escuela.create', [
      'ubicaciones' => Ubicacion::whereIn('id', [1, 2,3])->sedes()->get(),
    ]);

  }    



  public function relacionMaestrosGenNombre($request)
  {
    $grupos = self::buscarGrupos($request);

    if($grupos->isEmpty()) {
      return false;
    }

    //dd($grupos[0]);

    return $grupos->map(static function($grupo) {
      $grupo['BachillerNombreCompleto'] = MetodosPersonas::BachillerNombreCompleto($grupo->bachiller_empleado, true);
      $grupo['gpoGradoProgClave'] = $grupo->gpoGrado .'-'. $grupo->plan->programa->progClave;
      $grupo['gpoGradoGrupo'] = $grupo->gpoGrado . $grupo->gpoClave;
      $grupo['empleadoEstado'] = $grupo->bachiller_empleado->empEstado;

      return $grupo;
    })->sortBy('BachillerNombreCompleto')->groupBy('empleado_id_docente');
  }


  public function relacionMaestrosEscuelaSemestre($request)
  {
    $grupos = self::buscarGrupos($request);
    if($grupos->isEmpty()) {
      return false;
    }

    return $grupos->map(static function($grupo) {
      $nombreCompleto = MetodosPersonas::BachillerNombreCompleto($grupo->bachiller_empleado, true);
      $escuela = $grupo->plan->programa->escuela;
      $grupo['nombreCompleto'] = $nombreCompleto;
      $grupo['escuela_nombreCompleto'] = "{$escuela->escClave}-{$nombreCompleto}";

      return $grupo;
    })->sortBy('escuela_nombreCompleto')->groupBy('plan.programa.progClave');
  }


  public function relacionMaestrosEscuela($request)
  {
    $maestros = self::buscarGrupos($request)->unique('empleado_id_docente')->pluck('bachiller_empleado');
    if($maestros->isEmpty()) {
      return false;
    }

    // Para datos de Yucatan 
    if($request->ubicacion_id == 1 || $request->ubicacion_id == 2){
      $gruposData = Bachiller_grupos::with(['periodo', 'plan.programa.escuela', 'bachiller_horarios'])
      ->whereHas('plan.programa.escuela', static function($query) use ($request) {
        $query->where('departamento_id', $request->departamento_id);
        if($request->escuela_id)
          $query->where('escuela_id', $request->escuela_id);
      })
      ->whereIn('empleado_id_docente', $maestros->pluck('id'))
      ->get()
      ->map(static function($grupo) {
  
        $grupo->horasDeClase = $grupo->bachiller_horarios->sum(static function($horario) {
          return $horario->ghFinal - $horario->ghInicio;
        });
        $periodo = $grupo->periodo;
        $grupo->sortByPerAnioPerNumero = "{$periodo->perAnio}-{$periodo->perNumero}-";
  
        return $grupo;
      })->sortBy('sortByPerAnioPerNumero')->groupBy('empleado_id_docente');
    }

    // para datos de quintana roo 
    if($request->ubicacion_id == 3){
      $gruposData = Bachiller_cch_grupos::with(['periodo', 'plan.programa.escuela', 'bachiller_horarios'])
      ->whereHas('plan.programa.escuela', static function($query) use ($request) {
        $query->where('departamento_id', $request->departamento_id);
        if($request->escuela_id)
          $query->where('escuela_id', $request->escuela_id);
      })
      ->whereIn('empleado_id_docente', $maestros->pluck('id'))
      ->get()
      ->map(static function($grupo) {
  
        $grupo->horasDeClase = $grupo->bachiller_horarios->sum(static function($horario) {
          return $horario->ghFinal - $horario->ghInicio;
        });
        $periodo = $grupo->periodo;
        $grupo->sortByPerAnioPerNumero = "{$periodo->perAnio}-{$periodo->perNumero}-";
  
        return $grupo;
      })->sortBy('sortByPerAnioPerNumero')->groupBy('empleado_id_docente');
    }
    
    // ------------------------------------------------------------------------
    $maestros->transform(static function($maestro) use ($gruposData) {
      $grupos_maestro = $gruposData->get($maestro->id) ?: new Collection;
      $maestro->nombreCompleto = MetodosPersonas::BachillerNombreCompleto($maestro->bachiller_empleado, true); //duda
      $maestro->ultimoCurso = $grupos_maestro->last();
      $maestro->grupos_maestro = $grupos_maestro;

      return $maestro;
    })->sortBy('BachillerNombreCompleto');

    return (Object) [
      "maestrosActivos" => $maestros->where('empEstado', 'A'),
      "maestrosInactivos" => $maestros->where('empEstado', 'B'),
      "maestrosSuspendidos" => $maestros->where('empEstado', 'S'),
    ];
  }


  public function relacionMaestrosEscuelaCargaAcademica(Request $request)
  {
    $grupos = self::buscarGrupos($request);
    if($grupos->isEmpty()) {
      return false;
    }

    $maestros = $grupos->unique("empleado_id_docente");
    foreach ($maestros as $grupo) {
      $grupo["sortByNombre"] = MetodosPersonas::BachillerNombreCompleto($grupo->bachiller_empleado, true);
    }
    $maestros = $maestros->sortBy("sortByNombre");
    $maestroIds = $maestros->map(function ($item, $key) {
      return $item->empleado_id_docente;
    })->all();

    if ($request->ubicacion_id == 1 || $request->ubicacion_id == 2) {
      $gruposByMaestrosId = Bachiller_grupos::with('bachiller_materia', 'bachiller_empleado', 'periodo', 'plan.programa.escuela.departamento')
      ->whereHas('plan.programa.escuela.departamento', function ($query) use ($request) {
        $query->where('departamento_id', $request->departamento_id);
        if ($request->escuela_id) {
          $query->where('escuela_id', '=', $request->escuela_id);
        }
      })
        ->where(static function ($query) use ($request) {
          if ($request->periodo_id) {
            $query->where('periodo_id', $request->periodo_id);
          }
        })
        ->whereIn("empleado_id_docente", $maestroIds)->get();

      $materias = $gruposByMaestrosId->groupBy('empleado_id_docente');
      $grupoIds = $gruposByMaestrosId->pluck('id');

      $horariosByGruposDelPerActual = DB::table("bachiller_horarios")
      ->leftJoin("bachiller_grupos", "bachiller_horarios.grupo_id", "=", "bachiller_grupos.id")
      ->whereIn("bachiller_horarios.grupo_id", $grupoIds)->get();
    }

    if ($request->ubicacion_id == 3) {
      $gruposByMaestrosId = Bachiller_cch_grupos::with('bachiller_materia', 'bachiller_empleado', 'periodo', 'plan.programa.escuela.departamento')
      ->whereHas('plan.programa.escuela.departamento', function ($query) use ($request) {
        $query->where('departamento_id', $request->departamento_id);
        if ($request->escuela_id) {
          $query->where('escuela_id', '=', $request->escuela_id);
        }
      })
        ->where(static function ($query) use ($request) {
          if ($request->periodo_id) {
            $query->where('periodo_id', $request->periodo_id);
          }
        })
        ->whereIn("empleado_id_docente", $maestroIds)->get();

      $materias = $gruposByMaestrosId->groupBy('empleado_id_docente');
      $grupoIds = $gruposByMaestrosId->pluck('id');

      $horariosByGruposDelPerActual = DB::table("bachiller_horarios")
      ->leftJoin("bachiller_cch_grupos", "bachiller_horarios.grupo_id", "=", "bachiller_cch_grupos.id")
      ->whereIn("bachiller_horarios.grupo_id", $grupoIds)->get();
    }
    


    //SUMATORIA DE HORAS DE CLASE POR GRUPO
    $horariosByGruposDelPerActual = $horariosByGruposDelPerActual->map(function ($item, $key) {
      $horasDeClase = $item->ghFinal - $item->ghInicio;
      $item->horasDeClase = $horasDeClase;
      return (Object) collect($item)->only("empleado_id_docente", "horasDeClase")->all();
    })->groupBy("empleado_id_docente");




    // OBTENER COLUMNA  DE ULTIMO CURSO DEL MAESTRO --------------------------------------------------------------------

      //PASO PROCESO ANTERIOR 2) OBTENER GRUPOS POR MAESTROS IDS. VARIABLE $gruposByMaestrosId
      //PASO 3) AGRUPAR POR MAESTRO, OBTENER EL PERIODO MAYOR AÑO CON MAYOR NUMERO PERIODO

      $gruposGroupByEmpleadoid = $gruposByMaestrosId;

      foreach ($gruposGroupByEmpleadoid as $item) {
        $item->sortByPerAnioPerNumero = str_slug($item->periodo->perAnio . '-' . $item->periodo->perNumero, '-');
      }

      $gruposGroupByEmpleadoid = $gruposGroupByEmpleadoid->groupBy("empleado_id_docente")->map(function ($item, $key) {
        return $item->last();
      });
    // FINAL OBTENER COLUMNA  DE ULTIMO CURSO DEL MAESTRO---------------------------------------------------------
    // ASIGNAR LOS HORARIOS AGRUPADOS POR MAESTRO, POR ID_EMPLEADO AL LISTADO DE MAESTROS (INSERTAR COLUMNA POR MAESTRO),
    $maestros = $maestros->map(function ($item, $key) use ($horariosByGruposDelPerActual, $gruposGroupByEmpleadoid, $materias) {
      $empleadoId = $item->empleado_id_docente;


      $ultimoCurso = $gruposGroupByEmpleadoid->filter(function ($value, $key) use ($empleadoId) {
        return $empleadoId == $key;
      });


      $horario = $horariosByGruposDelPerActual->filter(function ($value, $key) use ($empleadoId) {
        return $empleadoId == $key;
      });


      $materias = $materias->filter(function ($value, $key) use ($empleadoId) {
        return $empleadoId == $key;
      });


      $item->horario = $horario;
      $item->ultimoCurso = $ultimoCurso->first();
      $item->materias = $materias->first();

      return $item;
    });

    return (Object) [
      "maestrosActivos" => $maestros->where('bachiller_empleado.empEstado', 'A'),
      "maestrosInactivos" => $maestros->where('bachiller_empleado.empEstado', 'B'),
      "maestrosSuspendidos" => $maestros->where('bachiller_empleado.empEstado', 'S'),
    ];

  }


  public function imprimir(Request $request)
  {
    $nombreArchivo = "pdf_rel_maestro_gral_nombre";
    $departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);
    $grupos = collect();
    $empEstado = $request->empEstado;

    if ($request->tipoPdf == "G") {//GENERAL POR NOMBRE
      $nombreArchivo = "pdf_rel_maestro_gral_nombre";
      $grupos = $this->relacionMaestrosGenNombre($request);
    }

    if ($request->tipoPdf == "E") {//POR ESCUELA Y CARRERA
      $nombreArchivo = "pdf_rel_maestro_escuela";
      $grupos = $this->relacionMaestrosEscuela($request);
    }

    if ($request->tipoPdf == "ECA") {
      $nombreArchivo = "pdf_rel_maestro_escuela_carga_academica";
      $grupos = $this->relacionMaestrosEscuelaCargaAcademica($request);
    }

    if ($request->tipoPdf == "EC") {//POR ESCUELA Y CARRERA
      $nombreArchivo = "pdf_rel_maestro_escuela_carrera";
      $grupos = $this->relacionMaestrosEscuelaSemestre($request);
    }

    if ($request->tipoPdf == "S") {//POR SEMESTRE
      $nombreArchivo = "pdf_rel_maestro_semestre";
      $grupos = $this->relacionMaestrosEscuelaSemestre($request);
    }


    if(!$grupos) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.
      Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    //dd($grupos);
    //$collection->sortBy('price');

    $fechaActual = Carbon::now('America/Merida');
    $pdf = PDF::loadView('reportes.pdf.bachiller.relacion_maestros_escuelas.' . $nombreArchivo, [
      "grupos" => $grupos,
      "ubicacion" => $departamento->ubicacion,
      "nombreArchivo" => $nombreArchivo . ".pdf",
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "tipoEspacio" => $request->tipoEspacio,
      "empEstado" => $empEstado
    ]);

    $pdf->setPaper('letter', 'landscape');

    return $pdf->stream($nombreArchivo.'.pdf');
  }

  /**
  * @param Illuminate\Http\Request
  */
    private static function buscarGrupos($request) {

      // para Yucatán
      if($request->ubicacion_id == 1 || $request->ubicacion_id == 2){
        return Bachiller_grupos::with(['bachiller_empleado', 'plan.programa.escuela', 'periodo'])
        ->where('gpoGrado', '>', 0)
        ->whereHas('plan.programa.escuela', static function($query) use ($request) {
            $query->where('departamento_id', $request->departamento_id);
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('bachiller_empleado', static function($query) use ($request) {
            if($request->empEstado && $request->empEstado != 'T')
                $query->where('empEstado', $request->empEstado);
            if($request->perApellido1)
                $query->where('empApellido1', $request->perApellido1);
            if($request->perApellido2)
                $query->where('empApellido2', $request->perApellido2);
            if($request->perNombre)
                $query->where('empNombre', $request->perNombre);
        })
        ->where(static function($query) use ($request) {
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
            if($request->gpoSemestre)
                $query->where('gpoGrado', $request->gpoSemestre);
            if($request->empleado_id)
                $query->where('empleado_id_docente', $request->empleado_id);
        })
        ->get();
      }

      // para Quintana Roo 
      if($request->ubicacion_id == 3){
        return Bachiller_cch_grupos::with(['bachiller_empleado', 'plan.programa.escuela', 'periodo'])
        ->where('gpoGrado', '>', 0)
        ->whereHas('plan.programa.escuela', static function($query) use ($request) {
            $query->where('departamento_id', $request->departamento_id);
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('bachiller_empleado', static function($query) use ($request) {
            if($request->empEstado && $request->empEstado != 'T')
                $query->where('empEstado', $request->empEstado);
            if($request->perApellido1)
                $query->where('empApellido1', $request->perApellido1);
            if($request->perApellido2)
                $query->where('empApellido2', $request->perApellido2);
            if($request->perNombre)
                $query->where('empNombre', $request->perNombre);
        })
        ->where(static function($query) use ($request) {
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
            if($request->gpoSemestre)
                $query->where('gpoGrado', $request->gpoSemestre);
            if($request->empleado_id)
                $query->where('empleado_id_docente', $request->empleado_id);
        })
        ->get();
      }
        
    }
}

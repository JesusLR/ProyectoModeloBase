<?php

namespace App\Http\Controllers\Primaria\Reportes;

use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\Departamento;
use App\Models\Grupo;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Primaria\Primaria_grupo;
use App\Models\Primaria\Primaria_inscrito;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaRelacionMaestrosEscuelaController extends Controller
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

    $primaria_empleados = Primaria_empleado::where('empEstado', '!=', 'B')->get();

    return view('primaria.reportes.relacion_maestros_escuela.create', [
      'ubicaciones' => Ubicacion::whereIn('id', [1,2])->sedes()->get(),
      'primaria_empleados' => $primaria_empleados
    ]);

  }


  public function relacionMaestrosGenNombrePresencial($request)
  {
    // este es para periodos menores a 2021 
    if($request->periodo_id < "1942"){
      $grupos = self::buscarGrupos($request);

      if($grupos->isEmpty()) {
        return false;
      }
  
      //dd($grupos[0]);
  
      return $grupos->map(static function($grupo) {
        $grupo['PrimariaNombreCompleto'] = MetodosPersonas::PrimariaNombreCompleto($grupo->primaria_empleado, true);
        $grupo['gpoGradoProgClave'] = $grupo->gpoGrado .'-'. $grupo->plan->programa->progClave;
        $grupo['gpoGradoGrupo'] = $grupo->gpoGrado . $grupo->gpoClave;
        $grupo['empleadoEstado'] = $grupo->primaria_empleado->empEstado;
  
        return $grupo;
      })->sortBy('PrimariaNombreCompleto')->groupBy('empleado_id_docente');
    }else{
      
        // este es para periodos mayores a 2021 
      if($request->periodo_id >= "1942"){
        
        $grupos = self::buscarGrupos2021($request);
  
        if($grupos->isEmpty()) {
          return false;
        }
    
        //dd($grupos[0]);
    
        return $grupos->map(static function($grupo) {
          $grupo['PrimariaNombreCompleto'] = MetodosPersonas::PrimariaNombreCompleto($grupo->primaria_empleado, true);
          $grupo['gpoGradoProgClave'] = $grupo->primaria_grupo->gpoGrado .'-'. $grupo->primaria_grupo->plan->programa->progClave;
          $grupo['gpoGradoGrupo'] = $grupo->primaria_grupo->gpoGrado . $grupo->primaria_grupo->gpoClave;
          $grupo['empleadoEstado'] = $grupo->primaria_empleado->empEstado;
    
          return $grupo;
        })->sortBy('PrimariaNombreCompleto')->groupBy('inscEmpleadoIdDocente');

      }
    }
    
  }



  public function relacionMaestrosEscuelaSemestre($request)
  {
    $grupos = self::buscarGrupos($request);
    if($grupos->isEmpty()) {
      return false;
    }

    return $grupos->map(static function($grupo) {
      $nombreCompleto = MetodosPersonas::PrimariaNombreCompleto($grupo->primaria_empleado, true);
      $escuela = $grupo->plan->programa->escuela;
      $grupo['nombreCompleto'] = $nombreCompleto;
      $grupo['escuela_nombreCompleto'] = "{$escuela->escClave}-{$nombreCompleto}";

      return $grupo;
    })->sortBy('escuela_nombreCompleto')->groupBy('plan.programa.progClave');
  }


  public function relacionMaestrosEscuela($request)
  {
    $maestros = self::buscarGrupos($request)->unique('empleado_id_docente')->pluck('primaria_empleado');
    if($maestros->isEmpty()) {
      return false;
    }

    $gruposData = Primaria_grupo::with(['periodo', 'plan.programa.escuela', 'horarios'])
    ->whereHas('plan.programa.escuela', static function($query) use ($request) {
      $query->where('departamento_id', $request->departamento_id);
      if($request->escuela_id)
        $query->where('escuela_id', $request->escuela_id);
    })
    ->whereIn('empleado_id_docente', $maestros->pluck('id'))
    ->get()
    ->map(static function($grupo) {

      $grupo->horasDeClase = $grupo->horarios->sum(static function($horario) {
        return $horario->ghFinal - $horario->ghInicio;
      });
      $periodo = $grupo->periodo;
      $grupo->sortByPerAnioPerNumero = "{$periodo->perAnio}-{$periodo->perNumero}-";

      return $grupo;
    })->sortBy('sortByPerAnioPerNumero')->groupBy('empleado_id_docente');
    // ------------------------------------------------------------------------
    $maestros->transform(static function($maestro) use ($gruposData) {
      $grupos_maestro = $gruposData->get($maestro->id) ?: new Collection;
      $maestro->nombreCompleto = MetodosPersonas::PrimariaNombreCompleto($maestro->primaria_empleado, true); //duda
      $maestro->ultimoCurso = $grupos_maestro->last();
      $maestro->grupos_maestro = $grupos_maestro;

      return $maestro;
    })->sortBy('PrimariaNombreCompleto');

    return (Object) [
      "maestrosActivos" => $maestros->where('empEstado', 'A'),
      "maestrosInactivos" => $maestros->where('empEstado', 'B'),
      "maestrosSuspendidos" => $maestros->where('empEstado', 'S'),
    ];
  }

  public function relacionMaestrosEscuelaCargaAcademica(Request $request)
  {
    $grupos = self::buscarGrupos($request);
    if ($grupos->isEmpty()) {
      return false;
    }

    if ($request->tipoDeModalidad == "P" || $request->tipoDeModalidad == "") {

      $maestros = $grupos->unique("empleado_id_docente");
      foreach ($maestros as $grupo) {
        $grupo["sortByNombre"] = MetodosPersonas::PrimariaNombreCompleto($grupo->primaria_empleado, true);
      }
      $maestros = $maestros->sortBy("sortByNombre");
      $maestroIds = $maestros->map(function ($item, $key) {
        return $item->empleado_id_docente;
      })->all();

      $gruposByMaestrosId = Primaria_grupo::with('primaria_materia', 'primaria_empleado', 'periodo', 'plan.programa.escuela.departamento')
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

      $horariosByGruposDelPerActual = DB::table("horarios")
      ->leftJoin("primaria_grupos", "horarios.grupo_id", "=", "primaria_grupos.id")
      ->whereIn("horarios.grupo_id", $grupoIds)->get();


      //SUMATORIA DE HORAS DE CLASE POR GRUPO
      $horariosByGruposDelPerActual = $horariosByGruposDelPerActual->map(function ($item, $key) {
        $horasDeClase = $item->ghFinal - $item->ghInicio;
        $item->horasDeClase = $horasDeClase;
        return (object) collect($item)->only("empleado_id_docente", "horasDeClase")->all();
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

      return (object) [
        "maestrosActivos" => $maestros->where('primaria_empleado.empEstado', 'A'),
        "maestrosInactivos" => $maestros->where('primaria_empleado.empEstado', 'B'),
        "maestrosSuspendidos" => $maestros->where('primaria_empleado.empEstado', 'S'),
      ];
    }

    if ($request->tipoDeModalidad == "V") {

      $maestros = $grupos->unique("empleado_id_auxiliar");
      foreach ($maestros as $grupo) {
        $grupo["sortByNombre"] = MetodosPersonas::PrimariaNombreCompleto($grupo->primaria_empleado, true);
      }
      $maestros = $maestros->sortBy("sortByNombre");
      $maestroIds = $maestros->map(function ($item, $key) {
        return $item->empleado_id_auxiliar;
      })->all();

      $gruposByMaestrosId = Primaria_grupo::with('primaria_materia', 'primaria_empleado', 'periodo', 'plan.programa.escuela.departamento')
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
        ->whereIn("empleado_id_auxiliar", $maestroIds)->get();

      $materias = $gruposByMaestrosId->groupBy('empleado_id_auxiliar');
      $grupoIds = $gruposByMaestrosId->pluck('id');

      $horariosByGruposDelPerActual = DB::table("horarios")
      ->leftJoin("primaria_grupos", "horarios.grupo_id", "=", "primaria_grupos.id")
      ->whereIn("horarios.grupo_id", $grupoIds)->get();


      //SUMATORIA DE HORAS DE CLASE POR GRUPO
      $horariosByGruposDelPerActual = $horariosByGruposDelPerActual->map(function ($item, $key) {
        $horasDeClase = $item->ghFinal - $item->ghInicio;
        $item->horasDeClase = $horasDeClase;
        return (object) collect($item)->only("empleado_id_auxiliar", "horasDeClase")->all();
      })->groupBy("empleado_id_auxiliar");




      // OBTENER COLUMNA  DE ULTIMO CURSO DEL MAESTRO --------------------------------------------------------------------

      //PASO PROCESO ANTERIOR 2) OBTENER GRUPOS POR MAESTROS IDS. VARIABLE $gruposByMaestrosId
      //PASO 3) AGRUPAR POR MAESTRO, OBTENER EL PERIODO MAYOR AÑO CON MAYOR NUMERO PERIODO

      $gruposGroupByEmpleadoid = $gruposByMaestrosId;

      foreach ($gruposGroupByEmpleadoid as $item) {
        $item->sortByPerAnioPerNumero = str_slug($item->periodo->perAnio . '-' . $item->periodo->perNumero, '-');
      }

      $gruposGroupByEmpleadoid = $gruposGroupByEmpleadoid->groupBy("empleado_id_auxiliar")->map(function ($item, $key) {
        return $item->last();
      });
      // FINAL OBTENER COLUMNA  DE ULTIMO CURSO DEL MAESTRO---------------------------------------------------------
      // ASIGNAR LOS HORARIOS AGRUPADOS POR MAESTRO, POR ID_EMPLEADO AL LISTADO DE MAESTROS (INSERTAR COLUMNA POR MAESTRO),
      $maestros = $maestros->map(function ($item, $key) use ($horariosByGruposDelPerActual, $gruposGroupByEmpleadoid, $materias) {
        $empleadoId = $item->empleado_id_auxiliar;


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

      return (object) [
        "maestrosActivos" => $maestros->where('primaria_empleado.empEstado', 'A'),
        "maestrosInactivos" => $maestros->where('primaria_empleado.empEstado', 'B'),
        "maestrosSuspendidos" => $maestros->where('primaria_empleado.empEstado', 'S'),
      ];
    }
  }


  public function imprimir(Request $request)
  {
    $nombreArchivo = "pdf_rel_maestro_gral_nombre";
    $departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);
    $grupos = collect();
    $empEstado = $request->empEstado;

    if ($request->tipoPdf == "G") {//GENERAL POR NOMBRE

      if($request->tipoDeModalidad == ""){
        $nombreArchivo = "pdf_rel_maestro_gral_nombre";
        $grupos = $this->relacionMaestrosGenNombrePresencial($request); 
      }
      if($request->tipoDeModalidad == "P" || $request->tipoDeModalidad == "V"){
        $nombreArchivo = "pdf_rel_maestro_gral_nombre_2021";
        $grupos = $this->relacionMaestrosGenNombrePresencial($request); 
      }
   
    }
    
    if(!$grupos) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.
      Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    //dd($grupos);
    //$collection->sortBy('price');

    // view('reportes.pdf.primaria.relacion_maestros_escuelas.pdf_rel_maestro_gral_nombre_2021');
    $fechaActual = Carbon::now('America/Merida');
    $pdf = PDF::loadView('reportes.pdf.primaria.relacion_maestros_escuelas.' . $nombreArchivo, [
      "grupos" => $grupos,
      "ubicacion" => $departamento->ubicacion,
      "nombreArchivo" => $nombreArchivo . ".pdf",
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "tipoEspacio" => $request->tipoEspacio,
      "empEstado" => $empEstado,
      "modalidad" => $request->tipoDeModalidad
    ]);

    $pdf->setPaper('letter', 'landscape');

    return $pdf->stream($nombreArchivo.'.pdf');
  }

  /**
  * @param Illuminate\Http\Request
  */
    private static function buscarGrupos($request) {

        return Primaria_grupo::with(['primaria_empleado', 'plan.programa.escuela', 'periodo'])
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
            ->whereHas('primaria_empleado', static function($query) use ($request) {
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

    private static function buscarGrupos2021($request) {

      return Primaria_inscrito::with(['primaria_empleado', 'primaria_grupo.plan.programa.escuela', 'primaria_grupo.periodo'])

      ->where('inscTipoAsistencia', '=', $request->tipoDeModalidad)

          ->whereHas('primaria_grupo', static function($query) {
            $query->where('gpoGrado', '>', 0);
        })
          ->whereHas('primaria_grupo.plan.programa.escuela', static function($query) use ($request) {
              $query->where('departamento_id', $request->departamento_id);
              if($request->plan_id)
                  $query->where('plan_id', $request->plan_id);
              if($request->programa_id)
                  $query->where('programa_id', $request->programa_id);
              if($request->escuela_id)
                  $query->where('escuela_id', $request->escuela_id);
          })
          ->whereHas('primaria_empleado', static function($query) use ($request) {
              if($request->empEstado && $request->empEstado != 'T')
                  $query->where('empEstado', $request->empEstado);
              if($request->perApellido1)
                  $query->where('empApellido1', $request->perApellido1);
              if($request->perApellido2)
                  $query->where('empApellido2', $request->perApellido2);
              if($request->perNombre)
                  $query->where('empNombre', $request->perNombre);
          })

          ->whereHas('primaria_grupo.periodo', static function($query) use ($request) {
              if($request->periodo_id)
                  $query->where('periodo_id', $request->periodo_id);
              if($request->gpoSemestre)
                  $query->where('gpoGrado', $request->gpoSemestre);
              if($request->empleado_id)
                  $query->where('inscEmpleadoIdDocente', $request->empleado_id);
            
          })
          
          ->get();
  }
}

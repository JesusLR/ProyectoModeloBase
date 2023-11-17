<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Horario;
use App\Http\Models\Grupo;

use DB;
use PDF;
use Carbon\Carbon;
use App\clases\personas\MetodosPersonas;
use RealRashid\SweetAlert\Facades\Alert;

class RelacionMaestrosEscuelaController extends Controller
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
    return View('reportes/relacion_maestros_escuela.create', [
      'ubicaciones' => Ubicacion::sedes()->get(),
    ]);
  }

  
  public function relacionMaestrosGenNombre($request)
  {
    $grupos = self::buscarGrupos($request);
    if($grupos->isEmpty()) {
      return false;
    }

    return $grupos->map(static function($grupo) {
      $grupo['nombreCompleto'] = MetodosPersonas::nombreCompleto($grupo->empleado->persona, true);
      $grupo['gpoSemProgClave'] = $grupo->gpoSemestre .'-'. $grupo->plan->programa->progClave;

      return $grupo;
    })->sortBy('nombreCompleto')->groupBy('empleado_id');
  }


  public function relacionMaestrosEscuelaSemestre($request)
  {
    $grupos = self::buscarGrupos($request);
    if($grupos->isEmpty()) {
      return false;
    }

    return $grupos->map(static function($grupo) {
      $nombreCompleto = MetodosPersonas::nombreCompleto($grupo->empleado->persona, true);
      $escuela = $grupo->plan->programa->escuela;
      $grupo['nombreCompleto'] = $nombreCompleto;
      $grupo['escuela_nombreCompleto'] = "{$escuela->escClave}-{$nombreCompleto}";

      return $grupo;
    })->sortBy('escuela_nombreCompleto')->groupBy('plan.programa.progClave');
  }


  public function relacionMaestrosEscuela($request)
  {
    $maestros = self::buscarGrupos($request)->unique('empleado_id')->pluck('empleado');
    if($maestros->isEmpty()) {
      return false;
    }

    $gruposData = Grupo::with(['periodo', 'plan.programa.escuela', 'horarios'])
    ->whereHas('plan.programa.escuela', static function($query) use ($request) {
      $query->where('departamento_id', $request->departamento_id);
      if($request->escuela_id)
        $query->where('escuela_id', $request->escuela_id);
    })
    ->whereIn('empleado_id', $maestros->pluck('id'))
    ->get()
    ->map(static function($grupo) {

      $grupo->horasDeClase = $grupo->horarios->sum(static function($horario) {
        return $horario->ghFinal - $horario->ghInicio;
      });
      $periodo = $grupo->periodo;
      $grupo->sortByPerAnioPerNumero = "{$periodo->perAnio}-{$periodo->perNumero}-";

      return $grupo;
    })->sortBy('sortByPerAnioPerNumero')->groupBy('empleado_id');
    // ------------------------------------------------------------------------
    $maestros->transform(static function($maestro) use ($gruposData) {
      $grupos_maestro = $gruposData->get($maestro->id) ?: new Collection;
      $maestro->nombreCompleto = MetodosPersonas::nombreCompleto($maestro->persona, true);
      $maestro->ultimoCurso = $grupos_maestro->last();
      $maestro->grupos_maestro = $grupos_maestro;

      return $maestro;
    })->sortBy('nombreCompleto');

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

    $maestros = $grupos->unique("empleado_id");
    foreach ($maestros as $grupo) {
      $grupo["sortByNombre"] = MetodosPersonas::nombreCompleto($grupo->empleado->persona, true);
    }
    $maestros = $maestros->sortBy("sortByNombre");
    $maestroIds = $maestros->map(function ($item, $key) {
      return $item->empleado_id;
    })->all();

    $gruposByMaestrosId = Grupo::with('materia', 'empleado.persona', 'periodo', 'plan.programa.escuela.departamento')
      ->whereHas('plan.programa.escuela.departamento', function($query) use ($request) {
        $query->where('departamento_id', $request->departamento_id);
        if ($request->escuela_id) {
          $query->where('escuela_id', '=', $request->escuela_id);
        }
      })
      ->where(static function($query) use ($request) {
        if($request->periodo_id) {
          $query->where('periodo_id', $request->periodo_id);
        }
      })
      ->whereIn("empleado_id", $maestroIds)->get();

    $materias = $gruposByMaestrosId->groupBy('empleado_id');
    $grupoIds = $gruposByMaestrosId->pluck('id');

    $horariosByGruposDelPerActual = DB::table("horarios")
      ->leftJoin("grupos", "horarios.grupo_id", "=", "grupos.id")
      ->whereIn("grupo_id", $grupoIds)->get();


    //SUMATORIA DE HORAS DE CLASE POR GRUPO
    $horariosByGruposDelPerActual = $horariosByGruposDelPerActual->map(function ($item, $key) {
      $horasDeClase = $item->ghFinal - $item->ghInicio;
      $item->horasDeClase = $horasDeClase;
      return (Object) collect($item)->only("empleado_id", "horasDeClase")->all();
    })->groupBy("empleado_id");




    // OBTENER COLUMNA  DE ULTIMO CURSO DEL MAESTRO --------------------------------------------------------------------

      //PASO PROCESO ANTERIOR 2) OBTENER GRUPOS POR MAESTROS IDS. VARIABLE $gruposByMaestrosId
      //PASO 3) AGRUPAR POR MAESTRO, OBTENER EL PERIODO MAYOR AÑO CON MAYOR NUMERO PERIODO

      $gruposGroupByEmpleadoid = $gruposByMaestrosId;

      foreach ($gruposGroupByEmpleadoid as $item) {
        $item->sortByPerAnioPerNumero = str_slug($item->periodo->perAnio . '-' . $item->periodo->perNumero, '-');
      }

      $gruposGroupByEmpleadoid = $gruposGroupByEmpleadoid->groupBy("empleado_id")->map(function ($item, $key) {
        return $item->last();
      });
    // FINAL OBTENER COLUMNA  DE ULTIMO CURSO DEL MAESTRO---------------------------------------------------------
    // ASIGNAR LOS HORARIOS AGRUPADOS POR MAESTRO, POR ID_EMPLEADO AL LISTADO DE MAESTROS (INSERTAR COLUMNA POR MAESTRO),
    $maestros = $maestros->map(function ($item, $key) use ($horariosByGruposDelPerActual, $gruposGroupByEmpleadoid, $materias) {
      $empleadoId = $item->empleado_id;


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
      "maestrosActivos" => $maestros->where('empleado.empEstado', 'A'),
      "maestrosInactivos" => $maestros->where('empleado.empEstado', 'B'),
      "maestrosSuspendidos" => $maestros->where('empleado.empEstado', 'S'),
    ];
  
  }


  public function imprimir(Request $request)
  {
    $nombreArchivo = "pdf_rel_maestro_gral_nombre";
    $departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);
    $grupos = collect();

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
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');
    $pdf = PDF::loadView('reportes.pdf.' . $nombreArchivo, [
      "grupos" => $grupos,
      "ubicacion" => $departamento->ubicacion,
      "nombreArchivo" => $nombreArchivo . ".pdf",
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "tipoEspacio" => $request->tipoEspacio,
    ]);

    return $pdf->stream($nombreArchivo.'.pdf');
  }

  /**
  * @param Illuminate\Http\Request
  */
  private static function buscarGrupos($request) {

    return Grupo::with(['empleado.persona', 'plan.programa.escuela', 'periodo'])
    ->whereHas('plan.programa.escuela', static function($query) use ($request) {
      $query->where('departamento_id', $request->departamento_id);
      if($request->plan_id)
        $query->where('plan_id', $request->plan_id);
      if($request->programa_id)
        $query->where('programa_id', $request->programa_id);
      if($request->escuela_id)
        $query->where('escuela_id', $request->escuela_id);
    })
    ->whereHas('empleado.persona', static function($query) use ($request) {
      if($request->empEstado && $request->empEstado != 'T')
        $query->where('empEstado', $request->empEstado);
      if($request->perApellido1)
        $query->where('perApellido1', $request->perApellido1);
      if($request->perApellido2)
        $query->where('perApellido2', $request->perApellido2);
      if($request->perNombre)
        $query->where('perNombre', $request->perNombre);
    })
    ->where(static function($query) use ($request) {
      if($request->periodo_id)
        $query->where('periodo_id', $request->periodo_id);
      if($request->gpoSemestre)
        $query->where('gpoSemestre', $request->gpoSemestre);
      if($request->empleado_id)
        $query->where('empleado_id', $request->empleado_id);
    })
    ->get();
  }
}
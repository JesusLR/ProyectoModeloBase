<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\HorarioAdmivo;

use DB;
use PDF;
use Carbon\Carbon;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;

class HorarioPersonalMaestrosController extends Controller
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
    return View('reportes.horarioPersonalMaestro.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }

  public function imprimir(Request $request)
  {
    $gruposPrimerFiltro = $this->filtrarGruposDesde($request);
    if($gruposPrimerFiltro->isEmpty()) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }
    $grupo1 = $gruposPrimerFiltro->first();
    $periodo = $grupo1->periodo;
    $escuela = $grupo1->plan->programa->escuela;
    $empleados = $gruposPrimerFiltro->unique('empleado')->pluck('empleado');
    $grupos = self::obtenerGruposDeMaestros($empleados, $periodo)->keyBy('id'); #Ignorando programa_id.
    $horarios = self::obtenerHorariosDesde($grupos);
    $horariosAdmivos = self::obtenerHorariosAdministrativosDesde($periodo, $empleados->pluck('id'));
    $grupos_equivalentes = self::obtenerGruposEquivalentesDe($grupos)->groupBy('grupo_equivalente_id');

    $horariosData = new Collection;
    self::mapear_horariosDocentes($horarios, $grupos, $horariosData);
    self::mapear_horariosAdministrativos($horariosAdmivos, $horariosData);

    $materiasData = new Collection;
    self::mapear_materiaPorGrupo($grupos, $materiasData);

    $datos = self::mapear_paraPDF($empleados, $horariosData, $materiasData)->where('totalHoras', '>', 0);

    if ($request->tipoHora == "ADMIN" && $request->horas) {
      $datos = $datos->where("totalHorasAdministrativas", $request->horas);
    }
    if ($request->tipoHora == "DOC" && $request->horas) {
      $datos = $datos->where("totalHorasDocentes", $request->horas);
    }
    if ($request->tipoHora == "DOCADMIN" && $request->horas) {
      $datos = $datos->where("totalHoras", $request->horas);
    }

    if($datos->isEmpty()) {
      alert()->warning('No hay horarios', 'No se encontraron horarios que coincidan con este filtro. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_horario_personal_maestro';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "datos" => $datos,
      "ubicacion" => $periodo->departamento->ubicacion,
      "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
      "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
      "escuela" => $escuela,
      "nombreArchivo" => $nombreArchivo,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
    ]);

    return $pdf->stream($nombreArchivo . '.pdf');
  } // imprimir.



  /**
  * @param Illuminate\Http\Request $request
  */
  private static function filtrarGruposDesde($request): Collection
  {
    return Grupo::with(['materia.plan', 'empleado.persona'])
      ->whereHas('materia.plan', static function($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
      })
      ->whereHas('empleado.persona', static function($query) use ($request) {
        if($request->perApellido1) {
          $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
        }
        if($request->perApellido2) {
          $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
        }
        if($request->perNombre) {
          $query->where('perNombre', 'like' , '%'.$request->perNombre.'%');
        }
      })
      ->where(static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        if($request->empleado_id) {
          $query->where('empleado_id', $request->empleado_id);
        }
      })->get();
  }



  /**
  * @param Collection $empleados
  * @param App\Models\Periodo $periodo
  */
  private static function obtenerGruposDeMaestros($empleados, $periodo): Collection
  {
    return Grupo::with('empleado.persona', 'materia.plan.programa')
    ->where('periodo_id', $periodo->id)
    ->whereIn('empleado_id', $empleados->pluck('id'))
    ->get();
  }



  /**
  * @param Collection
  */
  private static function obtenerHorariosDesde($grupos): Collection
  {
    return Horario::with('aula')->whereIn('grupo_id', $grupos->pluck('id'))->get();
  }



  /**
  * @param Collection
  */
  private static function obtenerGruposEquivalentesDe($grupos): Collection
  {
    return Grupo::whereIn('grupo_equivalente_id', $grupos->pluck('id'))->get();
  }



  /**
  * @param Collection $periodo
  * @param array $empleados_ids
  */
  private static function obtenerHorariosAdministrativosDesde($periodo, $empleados_ids): Collection
  {
    return HorarioAdmivo::where("periodo_id", $periodo->id)->whereIn("empleado_id", $empleados_ids)->get();
  }



  /**
  * @param Collection $horarios
  * @param Collection $grupos
  * @param Collection $horariosData 
  */
  private static function mapear_horariosDocentes($horarios, $grupos, $horariosData): void
  { 
    $horarios->groupBy('grupo_id')
    ->each(static function($horarios_grupo, $key) use ($grupos, $horariosData) {
      $grupo = $grupos->get($key);

      $horarios_grupo->each(static function($horario, $key) use ($grupo, $horariosData) {
          $horariosData->push([
            'tipoHorario' => 'DOC',
            'grupo_id' => $grupo->id,
            'empleado_id' => $grupo->empleado_id,
            'grupo_equivalente_id' => $grupo->grupo_equivalente_id,
            'dia' => $horario->ghDia,
            'hrInicio' => $horario->ghInicio,
            'hrFinal' => $horario->ghFinal,
            'matClave' => $grupo->materia->matClave,
            'aulaClave' => $horario->aula->aulaClave,
            'horas_inicio_fin' => [$horario->ghInicio, $horario->ghFinal],
            'clave_unica_horario' => $horario->ghDia . '-' . $horario->ghInicio . '-' . $horario->ghFinal,
          ]);
      });
    });
  }



  /**
  * @param Collection $horariosAdmivos
  * @param Collection $horariosData
  */
  private static function mapear_horariosAdministrativos($horariosAdmivos, $horariosData): void
  {
    $horariosAdmivos->each(static function($horario, $key) use ($horariosData) {
      $horariosData->push([
        'tipoHorario' => 'ADM',
        'grupo_id' => null,
        'empleado_id' => $horario->empleado_id,
        'grupo_equivalente_id' => null,
        'dia' => $horario->hadmDia,
        'hrInicio' => $horario->hadmHoraInicio,
        'hrFinal' => $horario->hadmFinal,
        'matClave' => null,
        'aulaClave' => null,
        'horas_inicio_fin' => [$horario->hadmHoraInicio, $horario->hadmFinal],
        'clave_unica_horario' => $horario->hadmDia . '-' . $horario->hadmHoraInicio . '-' . $horario->hadmFinal,
      ]);
    });
  }



  /**
  * @param Collection $grupos
  * @param Collection $materiasData
  */
  private static function mapear_materiaPorGrupo($grupos, $materiasData): void
  {
    $grupos->groupBy('materia_id')
    ->each(static function($grupos_materia, $key) use ($materiasData) {
      $materia = $grupos_materia->first()->materia;

      $grupos_materia->each(static function($grupo, $key) use ($materia, $materiasData) {
        $materiasData->push([
          'grupo_id' => $grupo->id,
          'empleado_id' => $grupo->empleado_id,
          'matClave' => $materia->matClave,
          'matNombre' => $materia->matNombreOficial,
          'progClave' => $materia->plan->programa->progClave,
          'fechaOrdinario' => Utils::fecha_string($grupo->gpoFechaExamenOrdinario, 'mesCorto'),
          'optNombre' => $grupo->optativa_id ? ' - '.$grupo->optativa->optNombre : '',
        ]);
      });
    });
  }



  /**
  * @param Collection $empleados
  * @param Collection $horariosData
  * @param Collection materiasData
  */
  private static function mapear_paraPDF($empleados, $horariosData, $materiasData): Collection
  {
    return $empleados->map(static function($empleado, $key) use ($horariosData, $materiasData) {

      $horarios_empleado = $horariosData->where('empleado_id', $empleado->id);
      $totalHorasDocentes = self::calcularTotalHoras($horarios_empleado, 'DOC');
      $totalHorasAdministrativas = self::calcularTotalHoras($horarios_empleado, 'ADM');

      return collect([
        'empleado_id' => $empleado->id,
        'nombreCompleto' => MetodosPersonas::nombreCompleto($empleado->persona),
        'horarios_empleado' => $horarios_empleado,
        'materias_empleado' => $materiasData->where('empleado_id', $empleado->id),
        'totalHorasDocentes' => $totalHorasDocentes,
        'totalHorasAdministrativas' => $totalHorasAdministrativas,
        'totalHoras' => $totalHorasDocentes + $totalHorasAdministrativas,
      ]);

    });
  }



  /**
  * @param Collection $horarios_empleado
  * @param string $tipoHorario
  */
  private static function calcularTotalHoras($horarios_empleado, $tipoHorario): int
  {
    if($horarios_empleado->isEmpty()) { 
      return 0; 
    }
    
    $horarios = new Collection;
    $horarios_empleado->where('tipoHorario', $tipoHorario)
    ->each(static function($horario) use ($horarios) {
      $horas = $horario['horas_inicio_fin'];

      foreach(range($horas[0], ($horas[1] - 1)) as $hora) {
        $clave = $horario['dia'] . '-' . $hora;
        $horarios->push($clave);
      }

    });

    return $horarios->unique()->count();
  }


}
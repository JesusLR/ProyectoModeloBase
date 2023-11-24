<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Horario;
use App\clases\cgts\MetodosCgt;

use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;

class RelacionGruposController extends Controller
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
    return View('reportes/relacion_grupo.create', [
      'ubicaciones' => Ubicacion::sedes()->get()
    ]);
  }

  public function imprimir(Request $request) {

    $cgts = $this->filtrarCgtsDesde($request);
    if($cgts->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No se encontraron datos con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $periodo = $cgts->first()->periodo;
    $planes_ids = $cgts->pluck('plan_id');
    $horarios = $this->obtenerHorariosDesde($planes_ids, $periodo->id);
    $cgts_mapeados = $this->mapear_cgts_cursos($cgts);
    $alumnosPorPrograma = $this->contarAlumnosPorPrograma($cgts_mapeados);
    $horasPorPrograma = $this->calcularHorasDocentesPorPrograma($horarios);

    $cgts_mapeados = $this->mapear_cgts_datosPorPrograma($cgts_mapeados, $alumnosPorPrograma, $horasPorPrograma);
    $total_departamento = $this->obtenEstadisticasDepartamento($cgts_mapeados);
    $datos = $cgts_mapeados->sortBy('orden')->groupBy('programa_id');
    
    $esReporteDetallado = ($request->tipoReporte == 'relGrupoDetalle');
    $nombreArchivo = $esReporteDetallado ? 'pdf_relacion_grupos_detalle' : 'pdf_relacion_grupos';
    $fechaActual = Carbon::now('America/Merida'); 

    return PDF::loadView('reportes.pdf.' . $nombreArchivo, [
      "datos" => $datos,
      "total_departamento" => $total_departamento,
      "nombreArchivo" => $nombreArchivo,
      "periodo" => $periodo,
      "departamento" => $periodo->departamento,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
    ])->stream($nombreArchivo.'.pdf');
  } #imprimir.



  private function filtrarCgtsDesde($request): Collection 
  {
    return Cgt::with(['plan.programa', 'cursos'])
      ->where('periodo_id', $request->periodo_id)
      ->whereHas('plan.programa', static function($query) use ($request) {
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
      })->get();
  }



  /**
  * @param array $planes_ids
  * @param int periodo_id
  */
  private function obtenerHorariosDesde($planes_ids, $periodo_id): Collection
  {
    return Horario::with('grupo.plan')
      ->whereHas('grupo.plan', static function($query) use ($planes_ids, $periodo_id) {
        $query->where('periodo_id', $periodo_id);
        $query->whereIn('plan_id', $planes_ids);
      })->get();
  }

  /**
  * @param Collection $cgts
  */
  private function mapear_cgts_cursos($cgts): Collection
  {
    return $cgts->map(static function($cgt, $key) {
      $plan = $cgt->plan;
      $programa = $plan->programa;
      $cursos = $cgt->cursos;
      $totalRegistrados = $cursos->whereIn('curEstado', ['A', 'C', 'R', 'P'])
      // ->where('curTipoIngreso', '<>', 'OY')
      ->count();

      return collect([
        'cgt_id' => $cgt->id,
        'plan_id' => $plan->id,
        'programa_id' => $programa->id,
        'grado' => $cgt->cgtGradoSemestre,
        'grupo' => $cgt->cgtGrupo,
        'orden' => MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo),
        'progNombre' => $programa->progNombre,
        'oyentes' => $cursos->where('curTipoIngreso', 'OY')->count(),
        'condicionados' => $cursos->where('curEstado', 'C')->count(),
        'condicionados2' => $cursos->where('curEstado', 'A')->count(),
        'inscritos' => $cursos->where('curEstado', 'R')->count(),
        'preinscritos' => $cursos->where('curEstado', 'P')->count(),
        'totalRegistrados' => $totalRegistrados,
      ]);
    });
  }



  /**
  * @param Collection $cgts_mapeados
  */
  private function contarAlumnosPorPrograma($cgts_mapeados): Collection
  {
    return $cgts_mapeados->groupBy('programa_id')
    ->map(static function($programa, $programa_id) {
      $cantidad_cgts = $programa->count();
      $carreraInscritos = $programa->sum('inscritos');

      return collect([
        'programa_id' => $programa_id,
        'cantidad_cgts' => $cantidad_cgts,
        'totalCarrera' => $programa->sum('totalRegistrados'),
        'carreraInscritos' => $carreraInscritos,
        'carreraPreinscritos' => $programa->sum('preinscritos'),
        'carreraOyentes' => $programa->sum('oyentes'),
        'carreraCondicionados' => $programa->sum('condicionados'),
        'carreraCondicionados2' => $programa->sum('condicionados2'),
        'inscritosEntreGrupos' => $carreraInscritos ? round($carreraInscritos / $cantidad_cgts) : 0,
      ]);
    });
  }



  /**
  * @param Collection $horarios
  */
  private function calcularHorasDocentesPorPrograma($horarios): Collection
  {
    return $horarios->groupBy('grupo.plan.programa_id')
    ->map(static function($horarios_programa, $programa_id) {
      return collect([
        'programa_id' => $programa_id,
        'horasDocentes' => $horarios_programa->sum('ghFinal') - $horarios_programa->sum('ghInicio'),
      ]);
    });
  }



  /**
  * @param Collection $cgts_mapeados
  * @param Collection $alumnosPorPrograma
  * @param Collection $horasPorPrograma
  */
  private function mapear_cgts_datosPorPrograma($cgts_mapeados, $alumnosPorPrograma, $horasPorPrograma): Collection
  {
    return $cgts_mapeados->map(static function($cgt_mapeado) use ($alumnosPorPrograma, $horasPorPrograma) {
      $alumnosDePrograma = $alumnosPorPrograma->get($cgt_mapeado['programa_id']);
      $horasDePrograma = $horasPorPrograma->get($cgt_mapeado['programa_id']);

      return $cgt_mapeado->merge([
        'totalCarrera' => $alumnosDePrograma['totalCarrera'],
        'carreraInscritos' => $alumnosDePrograma['carreraInscritos'],
        'carreraPreinscritos' => $alumnosDePrograma['carreraPreinscritos'],
        'carreraOyentes' => $alumnosDePrograma['carreraOyentes'],
        'carreraCondicionados' => $alumnosDePrograma['carreraCondicionados'],
        'carreraCondicionados2' => $alumnosDePrograma['carreraCondicionados2'],
        'cantidad_cgts' => $alumnosDePrograma['cantidad_cgts'],
        'inscritosEntreGrupos' => $alumnosDePrograma['inscritosEntreGrupos'],
        'horasDocentes' => $horasDePrograma['horasDocentes'],
      ]);
    });
  }



  /**
  * @param Collection $cgts_mapeados
  */
  private function obtenEstadisticasDepartamento($cgts_mapeados): Collection
  {
    $programas = $cgts_mapeados->unique('programa_id');
    return collect([
      'inscritos' => $programas->sum('carreraInscritos'),
      'preinscritos' => $programas->sum('carreraPreinscritos'),
      'condicionados' => $programas->sum('carreraCondicionados'),
      'condicionados2' => $programas->sum('carreraCondicionados2'),
      'totalRegistrados' => $programas->sum('totalCarrera'),
      'oyentes' => $programas->sum('carreraOyentes'),
      'cgts' => $programas->sum('cantidad_cgts'),
      'inscritosEntreGrupos' => $programas->sum('inscritosEntreGrupos'),
      'horasDocentes' => $programas->sum('horasDocentes'),
    ]);
  }


}
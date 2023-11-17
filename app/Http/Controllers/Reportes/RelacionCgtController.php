<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Models\Cgt;
use App\Http\Models\Ubicacion;
use App\clases\cgts\MetodosCgt;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class RelacionCgtController extends Controller
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
    $ubicaciones = Ubicacion::sedes()->get();
    return View('reportes/relacion_cgt.create', compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $cgts = Cgt::with(['plan.programa', 'cursos'])
    ->where(static function($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
      if($request->cgtGradoSemestre)
        $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
      if($request->cgtGrupo)
        $query->where('cgtGrupo', $request->cgtGrupo);
      if($request->cgtTurno)
        $query->where('cgtTurno', $request->cgtTurno);
      if($request->cgtCupo)
        $query->where('cgtCupo', $request->cgtCupo);
    })
    ->whereHas('plan.programa.escuela', static function($query) use ($request) {
      if($request->plan_id)
        $query->where('plan_id', $request->plan_id);
      if($request->programa_id)
        $query->where('programa_id', $request->programa_id);
      if($request->escuela_id)
        $query->where('escuela_id', $request->escuela_id);
    })
    ->get()
    ->each(static function($cgt) {
      $plan = $cgt->plan;
      $programa = $plan->programa;
      $escuela = $programa->escuela;
      $cgt->planClave = $plan->planClave;
      $cgt->progClave = $programa->progClave;
      $cgt->escClave = $escuela->escClave;
      $cgt->orden_cgt = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo).$cgt->cgtTurno;
      $cgt->inscritos = $cgt->cursos->whereIn('curEstado', ['R', 'C', 'A'])->count();
      $cgt->preinscritos = $cgt->cursos->where('curEstado', 'P')->count();
      $cgt->total_preinscritos = $cgt->inscritos + $cgt->preinscritos;
    })
    ->when($request->solo_con_inscritos, static function($collection) {
      return $collection->filter(static function($cgt) {
        return $cgt->total_preinscritos > 0;
      });
    })
    ->when($request->cgtTotalRegistrados, static function($collection) use ($request) {
      return $collection->filter(static function($cgt) use ($request) {
        return $cgt->total_preinscritos->count() == $request->cgtTotalRegistrados;
      });
    });

    if($cgts->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
    
    $fechaActual = Carbon::now('America/Merida');
    $periodo = $cgts->first()->periodo;
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;
    $perFechas = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto').' - '.Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

    $cgts->each(static function($cgt) use ($departamento, $ubicacion) {
      $cgt->ubiClave = $ubicacion->ubiClave;
      $cgt->depClave = $departamento->depClave;
    });

    $nombreArchivo = 'pdf_relacion_cgt';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "programas" => $cgts->sortBy('orden_cgt')->groupBy('progClave')->sortKeys(),
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "periodo" => $perFechas,
      "perNumero" => $periodo->perNumero,
      "perAnio" => $periodo->perAnio
    ])->stream($nombreArchivo.'.pdf');

  }

}
<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Calificacion;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PorcentajeAprobacionController extends Controller
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
    $ubicaciones = Ubicacion::sedes()->get();
    return View('reportes/porcentaje_aprobacion.create', compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $calificaciones = Calificacion::with('inscrito.grupo.materia.plan.programa')
    ->whereHas('inscrito.grupo.materia.plan.programa', function($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
      $query->where('escuela_id', $request->escuela_id);
      if($request->programa_id) {
        $query->where('programa_id', $request->programa_id);
      }
      if ($request->gpoSemestre) {
        $query->where('gpoSemestre', $request->gpoSemestre);
      }
      if ($request->gpoClave) {
        $query->where('gpoClave', $request->gpoClave);
      }
    })
    ->whereNotNull('incsCalificacionFinal')->get();

    if($calificaciones->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    //variables que se mandan a la vista fuera del array
    $grupo1 = $calificaciones->first()->inscrito->grupo;
    $escuela = $grupo1->plan->programa->escuela;
    $periodo = $grupo1->periodo;
    $departamento = $periodo->departamento;
    $perFechas = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto').' - '.Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

    $dataCalif = $calificaciones->groupBy('inscrito.grupo.plan.programa.progClave')
    ->map(static function($programa_calificaciones, $progClave) use ($departamento) {
      $programa = $programa_calificaciones->first()->inscrito->grupo->plan->programa;
      $numMat = $programa_calificaciones->count();
      $numMatApr = $programa_calificaciones->where('incsCalificacionFinal', '>=', $departamento->depCalMinAprob)->count();
      $numMatRep = $programa_calificaciones->where('incsCalificacionFinal', '<', $departamento->depCalMinAprob)->count();

      return collect([
        'progClave' => $programa->progClave,
        'progNombre' => $programa->progNombre,
        'numMat' => $numMat,
        'numMatApr' => $numMatApr,
        'numMatRep' => $numMatRep,
        'porcenApr' => $numMatApr / $numMat * 100,
        'porcenRep' => $numMatRep / $numMat * 100,
      ]);
    });

    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_porcentaje_aprobacion';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "dataCalif" => $dataCalif,
      "escClave" => $escuela->escClave,
      "escNombre" => $escuela->escNombre,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "ubicacion" => $departamento->ubicacion,
      "perFechas" => $perFechas,
    ])->stream($nombreArchivo.'.pdf');

  }

}
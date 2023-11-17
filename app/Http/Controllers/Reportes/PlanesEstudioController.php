<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Plan;
use App\Http\Models\Materia;

use Carbon\Carbon;
use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class PlanesEstudioController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_planes_estudio');
  }

  public function reporte()
  {
    $estadosAcuerdoPlan = ESTADO_ACUERDO_PLAN;

    return View('reportes/planes_estudio.create', [
      'estadosAcuerdoPlan' => $estadosAcuerdoPlan,
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function imprimir(Request $request)
  {

    $planes = Plan::with('programa.escuela.departamento')
      ->leftJoin('acuerdos', 'planes.id', '=', 'acuerdos.plan_id')
      ->where('planClave', '<>', '000')
      ->whereHas('programa.escuela.departamento.ubicacion', function($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
      })->where(static function($query) use ($request) {
        if($request->acuNumero) {
          $query->where('acuNumero', $request->acuNumero);
        }
        if($request->acuFecha) {
          $query->where('acuFecha', $request->acuFecha);
        }
        if($request->planPeriodos) {
          $query->where('planPeriodos', $request->planPeriodos);
        }
        if($request->acuEstadoPlan) {
          $query->where('acuEstadoPlan', $request->acuEstadoPlan);
        }
      })->get();

    $materiasByPlanesId = Materia::whereIn('plan_id', $planes->pluck('id'))->get();
    
    //hacer merge de cantidad de materias a planes
    $planes = $planes->map(function ($item, $key) use ($materiasByPlanesId) {


      $cantidadMaterias = $materiasByPlanesId->filter(function ($value, $key) use ($item) {
        return $value->plan_id == $item["id"];
      })->count();

      $item["cantidadMaterias"] = $cantidadMaterias;

      return $item;
    });

    //filtro por numero de materias
    if ($request->numMaterias) {
      $planes = $planes->filter(function ($value, $key) use ($request) {
        return $value["cantidadMaterias"] == $request->numMaterias;
      });
    }

    if($planes->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }


    $planes = $planes->groupBy("programa.escuela_id");


    $fechaActual = Carbon::now('CDT');

    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

  
    $nombreArchivo = 'pdf_rel_planes_estudio.pdf';

    $pdf = PDF::loadView('reportes.pdf.pdf_rel_planes_estudio', [
      "planes" => $planes,
      "nombreArchivo" => $nombreArchivo,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';
    return $pdf->stream($nombreArchivo);
    return $pdf->download($nombreArchivo);
  }
}
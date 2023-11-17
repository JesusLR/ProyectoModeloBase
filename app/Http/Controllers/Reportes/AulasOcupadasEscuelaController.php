<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Horario;
use App\Http\Models\Escuela;
use App\Http\Models\Ubicacion;
use App\Http\Models\Aula;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AulasOcupadasEscuelaController extends Controller
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
    $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
    return View('reportes/aulas_ocupadas_escuela.create',compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $horarios = Horario::with('grupo.plan.programa.escuela.departamento.ubicacion', 'aula')

    ->whereHas('grupo.plan.programa.escuela.departamento.ubicacion', static function($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
      if($request->escuela_id) {
        $query->where('escuela_id', $request->escuela_id);
      }
      if($request->programa_id) {
        $query->where('programa_id', $request->programa_id);
      }
    })
    ->get();

    if($horarios->isEmpty()) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
   
    $aulaOcu = collect();
    $fechaActual = Carbon::now();

    //variables que se mandan a la vista fuera del array
    $horario1 = $horarios->first();
    $ubicacionNombre = $horario1->aula->ubicacion;
    $escuelaNombre = $horario1->grupo->plan->programa->escuela;
    
    foreach($horarios as $horario){

      $aulaClave = $horario->aula->aulaClave;
      $aulaDescripcion = $horario->aula->aulaDescripcion;
      $aulaCupo = $horario->aula->aulaCupo;
      $aulaUbicacion = $horario->aula->aulaUbicacion;
      $escClave = $horario->grupo->plan->programa->escuela->escClave;
      $progClave = $horario->grupo->plan->programa->progClave;
    
      $aulaOcu->push([
        'horario' => $horario,
        'aulaClave' => $aulaClave,
        'aulaDescripcion' => $aulaDescripcion,
        'aulaCupo' => $aulaCupo,
        'aulaUbicacion' => $aulaUbicacion,
        'escClave' => $escClave,
        'progClave' => $progClave
      ]);
    }

    $aulaOcu = $aulaOcu->sortBy('aulaClave')->unique('aulaClave')->groupBy('aulaClave');
  
    $fechaPrefecteo = $request->perFechaPre;
    $horaPrefecteo = $request->perHoraPre;
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_aulas_ocupadas_escuela';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "aulaOcu" => $aulaOcu,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "ubicacionNombre" => $ubicacionNombre,
      "escuelaNombre" => $escuelaNombre,
      "fechaPrefecteo" => $fechaPrefecteo,
      "horaPrefecteo" => $horaPrefecteo,
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');
  }

}
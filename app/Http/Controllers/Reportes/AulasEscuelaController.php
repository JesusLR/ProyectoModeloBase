<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Programa;
use App\Http\Models\Escuela;
use App\Http\Models\Ubicacion;
use App\Http\Models\Aula;

use Carbon\Carbon;
use PDF;
use DB;

class AulasEscuelaController extends Controller
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
    return View('reportes/aulas_escuela.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }

  public function imprimir(Request $request)
  {
    $aulas = Aula::with('ubicacion')->where('ubicacion_id', $request->ubicacion_id)->get();

    $aulaFirst = $aulas->first();

    if(!$aulaFirst){
      return View('reportes/aulas_escuela.create')->with('message','Clave de Campus incorrecta.');
    }

    $ubicacionA = collect();
    $fechaActual = Carbon::now();

    //variables que se mandan a la vista fuera del array
    $ubicacionNombre = $aulaFirst->ubicacion;

    foreach($aulas as $aula) {

      $ubicacionA->push([
        'aula' => $aula,
        'aulaClave' => $aula->aulaClave,
        'aulaDescripcion' => $aula->aulaDescripcion,
        'aulaUbicacion' => $aula->aulaUbicacion,
        'aulaEdificio' => $aula->aulaEdificio,
      ]);
    }

    $ubicacionA = $ubicacionA->sortBy('aulaDescripcion')->groupBy('aulaDescripcion');
  
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_aulas_escuela';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "ubicacionA" => $ubicacionA,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "ubicacionNombre" => $ubicacionNombre,
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
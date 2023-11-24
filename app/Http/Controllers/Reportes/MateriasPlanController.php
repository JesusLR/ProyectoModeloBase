<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Materia;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Acuerdo;
use App\Models\Prerequisito;
use App\Models\Ubicacion;

use PDF;
use DB;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class MateriasPlanController extends Controller
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
    return View('reportes/materias_plan.create',compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $materias = Materia::with('plan.programa.escuela.departamento.ubicacion')
    ->whereHas('plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
      $query->where('plan_id', $request->plan_id);
    })->get();

    if($materias->isEmpty()) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $materiaP = collect();
    $fechaActual = Carbon::now('CDT');

    //variables que se mandan a la vista fuera del array
    $materia1 = $materias->first();
    $planNombre = $materia1->plan;
    $programaNombre = $planNombre->programa;
    $acuerdo = Acuerdo::where('plan_id', '=', $planNombre->id)->first();

    foreach($materias as $materia){
      
      $ubiClave = $materia->plan->programa->escuela->departamento->ubicacion->ubiClave;
      $matClave = $materia->matClave;
      $matNombre = $materia->matNombreOficial;
      $planClave = $materia->plan->planClave;
      $grado = $materia->matSemestre;


      
      $prerequisito = Prerequisito::where('materia_id', '=', $materia->id)->first();
      if (isset($prerequisito)) {
        $materiaPre = Materia::where('id', '=', $prerequisito->materia_prerequisito_id)->first();
        $materiaPreNombre = $materiaPre->matNombreOficial;
      }else{
        $materiaPreNombre = '';
      }
      

      $materiaP->push([
        'materia'=>$materia,
        'ubiClave'=>$ubiClave,
        'matClave'=>$matClave,
        'matNombre'=>$matNombre,
        'planClave'=>$planClave,
        'grado'=>$grado,
        'materiaPreNombre'=>$materiaPreNombre,
        'fechaActual' => $fechaActual->toDateString(),
        'horaActual' => $fechaActual->toTimeString()
        
     
      ]);
    }

    $materiaP = $materiaP->sortBy('grado')->groupBy('grado');
  
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_materias_por_plan';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "materiaP" => $materiaP,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "programaNombre" => $programaNombre,
      "planNombre" => $planNombre,
      "acuerdo" => $acuerdo,
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
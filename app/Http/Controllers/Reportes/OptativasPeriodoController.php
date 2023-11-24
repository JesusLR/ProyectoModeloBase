<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Ubicacion;
use App\Models\Estado;
use App\Models\Programa;
use App\Models\Periodo;
use App\Models\Calificacion;
use App\Models\Inscrito;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class OptativasPeriodoController extends Controller
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
    return View('reportes/optativas_periodo.create',compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $inscritos = Inscrito::with('curso.cgt.plan.programa.escuela.departamento.ubicacion','grupo.materia','grupo.optativa')
    
      ->whereHas('curso.cgt.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        
        $query->where('periodo_id', $request->periodo_id);
        if($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
      })
      
      ->whereHas('grupo.materia', function($query) use ($request) {
        if ($request->gpoSemestre) {
          $query->where('gpoSemestre', '=', $request->gpoSemestre);//
        }
        if ($request->gpoClave) {
          $query->where('gpoClave', '=', $request->gpoClave);//
        }
        if ($request->matClave) {
          $query->where('matClave', '=', $request->matClave);//
        }
        $query->where('matClasificacion', '=', 'O');
      })->get();

    if($inscritos->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
    
    $optativaM = collect();
    $fechaActual = Carbon::now();

    //variables que se mandan a la vista fuera del array
   $registro1 = $inscritos->first();
   $periodo = $registro1->curso->periodo;
    $perFechas = $periodo->perFechaInicial.' - '.$periodo->perFechaFinal;

    foreach($inscritos as $inscrito){
   
      $ubiNombre = $inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
      $progClave = $inscrito->curso->cgt->plan->programa->progClave;
      $planClave = $inscrito->curso->cgt->plan->planClave;
      $matClave = $inscrito->grupo->materia->matClave;
      $optativaNombre1 = $inscrito->grupo->materia->matNombre;
      $optativaDesc1 = $inscrito->grupo->gpoMatClaveComplementaria;
      $gpoSemestre = $inscrito->grupo->gpoSemestre;
      $gpoClave = $inscrito->grupo->gpoClave;
      $inscritosGpo = $inscrito->grupo->inscritos_gpo;
      $optativaNombre2 = $inscrito->grupo->materia->matNombreOficial;
      $optativaDesc2 = $inscrito->grupo->optativa->optNombre;
      $idUnique = $inscrito->grupo->id;

      $optativaM->push([  
        'inscrito'=>$inscrito,
        'ubiNombre'=>$ubiNombre,
        'progClave'=>$progClave,
        'planClave'=>$planClave,
        'matClave'=>$matClave,
        'optativaNombre1'=>$optativaNombre1,
        'optativaDesc1'=>$optativaDesc1,
        'gpoSemestre'=>$gpoSemestre,
        'gpoClave'=>$gpoClave,
        'inscritosGpo'=>$inscritosGpo,
        'optativaNombre2'=>$optativaNombre2,
        'optativaDesc2'=>$optativaDesc2,
        'idUnique'=>$idUnique,
        'ordenar'=>$gpoSemestre.$gpoClave
        
      ]);
    
    }
    
    $optativaM = $optativaM->sortBy('progClave')->unique('idUnique')->groupBy('progClave');
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_optativas_periodo';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "optativaM" => $optativaM,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "periodo" => $perFechas,
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
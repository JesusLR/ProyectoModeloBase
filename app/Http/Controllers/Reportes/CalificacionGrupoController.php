<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Grupo;
use App\Http\Models\Ubicacion;
use App\Http\Models\Materia;
use App\Http\Models\Programa;
use App\Http\Models\Periodo;
use App\Http\Models\Calificacion;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class CalificacionGrupoController extends Controller
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
    $anioActual = Carbon::now();
    return View('reportes/calificacion_grupo.create',compact('anioActual'));
  }

  public function imprimir(Request $request)
  {
    $calificacionGrupo = Calificacion::with('inscrito.curso.alumno.persona','inscrito.curso.periodo',
    'inscrito.curso.cgt.plan.programa.escuela.departamento.ubicacion','inscrito.grupo.materia')

      ->whereHas('inscrito.curso.alumno.persona', function($query) use ($request) {
        if ($request->aluClave) {//
          $query->where('aluClave', '=', $request->aluClave);//
        }
        if ($request->aluMatricula) {//
          $query->where('aluMatricula', '=', $request->aluMatricula);//
        }
        if ($request->perApellido1) {//
          $query->where('perApellido1', '=', $request->perApellido1);//
        }
        if ($request->perApellido2) {//
          $query->where('perApellido2', '=', $request->perApellido2);//
        }
        if ($request->perNombre) {//
          $query->where('perNombre', '=', $request->perNombre);//
        }
      })

      ->whereHas('inscrito.curso.periodo', function($query) use ($request) {
        if ($request->perNumero) {
          $query->whereIn('perNumero', [0, 3]);//
        }

        if ($request->perAnio) {
          $query->where('perAnio', $request->perAnio);//
        }
      })
    
      ->whereHas('inscrito.curso.cgt.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        if ($request->ubiClave) {
          $query->where('ubiClave', '=', $request->ubiClave);//
        }
        if ($request->depClave) {
          $query->where('depClave', '=', $request->depClave);//
        }
        if ($request->progClave) {
          $query->where('progClave', '=', $request->progClave);//
        }
        if ($request->planClave) {
          $query->where('planClave', '=', $request->planClave);//
        }
      })
      ->whereHas('inscrito.grupo.materia', function($query) use ($request) {
        if ($request->gpoSemestre) {
          $query->where('gpoSemestre', '=', $request->gpoSemestre);//
        }
        if ($request->gpoClave) {
          $query->where('gpoClave', '=', $request->gpoClave);//
        }
      })->get();

      if($calificacionGrupo->isEmpty()) {
        alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
        return back()->withInput();
      }
    
    /*
    $boletaIds = $boleta->filter(function ($item) {
      return $item->id;
    });
    */
    $calificacionIds = $calificacionGrupo->map(function ($item, $key) {
      return $item->id;
    });
    
    $calificacionG = collect();
    $fechaActual = Carbon::now();

    //variables que se mandan a la vista fuera del array
    $programaNombre = Programa::select('progClave','progNombre','escuela_id')->where('progClave',$request->progClave)->first();
    $ubicacionNombre = Ubicacion::select('ubiClave','ubiNombre')->where('ubiClave',$request->ubiClave)->first();
    $escuelaNombre = Escuela::select('escClave','escNombre','departamento_id')->where('id',$programaNombre->escuela_id)->first();
    $depCalif = Departamento::select('depClave','depCalMinAprob')->where('id',$escuelaNombre->departamento_id)->first();
    $perFechaInicial = Periodo::select('perFechaInicial')->where('perNumero',$request->perNumero)->where('perAnio',$request->perAnio)->first();
    $perFechaFinal = Periodo::select('perFechaFinal')->where('perNumero',$request->perNumero)->where('perAnio',$request->perAnio)->first();
    $periodo = $perFechaInicial->perFechaInicial.' - '.$perFechaFinal->perFechaFinal;
    
    $evaluacion = '';
    switch ($request->evaluacion) {
      case 'parc_1':
      $evaluacion = 'Calificaciones del primer parcial.';
      break;
      case 'parc_2':
      $evaluacion = 'Calificaciones del segundo parcial.';
      break;
      case 'parc_3':
      $evaluacion = 'Calificaciones del tercer parcial.';
      break;
      case 'ordinario':
      $evaluacion = 'Calificaciones del ordinario.';
      break;
      case 'final':
      $evaluacion = 'Calificaciones finales.';
      break;
    }

    $faltas = $request->faltas;
    $materiasIncluidas = $request->materias;
    //usar las materias que estén en ese periodo por medio de grupos
    foreach($calificacionIds as $calificacion_id){
      $calificacion = Calificacion::where('id', $calificacion_id)->first();
      
      if ($materiasIncluidas == 'B') {
      $materiasGpo = Grupo::with('materia')->where('periodo_id',$calificacion->inscrito->curso->periodo->id)->whereHas('materia', function($query) {
        $query->where("matClasificacion", 'B');
      })->distinct()->get();
      }
      elseif ($materiasIncluidas == 'O') {
        $materiasGpo = Grupo::with('materia')->where('periodo_id',$calificacion->inscrito->curso->periodo->id)->whereHas('materia', function($query) {
          $query->where("matClasificacion", 'O');
        })->distinct()->get();
      }
      elseif ($materiasIncluidas == 'A') {
      $materiasGpo = Grupo::with('materia')->where('plan_id',$calificacion->inscrito->curso->cgt->plan->id)
      ->where('periodo_id',$calificacion->inscrito->curso->periodo->id)->distinct()->get();
      }
      $materiasCount = $materiasGpo->count();
   
      $aluClave = $calificacion->inscrito->curso->alumno->aluClave;
      $perApellido1 = $calificacion->inscrito->curso->alumno->persona->perApellido1;
      $perApellido2 = $calificacion->inscrito->curso->alumno->persona->perApellido2;
      $perNombre = $calificacion->inscrito->curso->alumno->persona->perNombre;
      $matClave = $calificacion->inscrito->grupo->materia->matClave;
      $depCalMinAprob = $calificacion->inscrito->curso->cgt->plan->programa->escuela->departamento->depCalMinAprob;

      $gpoSemestre = $calificacion->inscrito->grupo->gpoSemestre;
      $gpoClave = $calificacion->inscrito->grupo->gpoClave;

      $calificacionG->push([  
        'calificacion'=>$calificacion,
        'materiasGpo'=>$materiasGpo,
        'aluClave'=>$aluClave,
        'perApellido1'=>$perApellido1,
        'perApellido2'=>$perApellido2,
        'perNombre'=>$perNombre,
        'matClave'=>$matClave,
        'depCalMinAprob'=>$depCalMinAprob,
        'gpoSemestre'=>$gpoSemestre,
        'gpoClave'=>$gpoClave
      ]);
    
    }
    
    $calificacionG = $calificacionG->sortBy('aluClave');
    $calificacionG = $calificacionG->unique('aluClave');
    $calificacionG = $calificacionG->groupBy('aluClave');
    
    dd($calificacionG);
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_calificacion_grupo';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "calificacionG" => $calificacionG,
      "fechaActual" => dateDMY($fechaActual),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "programaNombre" => $programaNombre,
      "ubicacionNombre" => $ubicacionNombre,
      "depCalif" => $depCalif,
      "periodo" => $periodo,
      "evaluacion" => $evaluacion,
      "faltas" => $faltas,
      "perAnio" => $request->perAnio
      /*
      "nombreArchivo" => $nombreArchivo,
      "aluEstado" => $request->aluEstado,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString()
      */
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

/*
  public function imprimir(Request $request)
  {
 
    $nombreArchivo = "pdf_alumno_por_materia_adeudada";
    $fechaActual = Carbon::now();
    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $pdf = PDF::loadView('reportes.pdf.' . $nombreArchivo, [
      "historicoList" => $historicoList,
      "nombreArchivo" => $nombreArchivo . '.pdf',
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
    ]);

    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';
    return $pdf->stream($nombreArchivo);
    return $pdf->download($nombreArchivo);
    // return response()->json($curso);
  }
  */
}
<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use Illuminate\Http\Request;
use App\Http\Models\Grupo;
use App\Http\Models\Ubicacion;
use App\Http\Models\Materia;
use App\Http\Models\Programa;
use App\Http\Models\Periodo;
use App\Http\Models\Calificacion;
use App\Http\Models\Cgt;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Inscrito;
use App\Http\Models\Plan;


use Carbon\Carbon;

use PDF;
use DB;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;

class ResumenPromediosController extends Controller
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
    $ubicaciones = Ubicacion::where('ubiClave','<>','000')->get();
    return View('reportes/resumen_promedios.create',compact('anioActual','ubicaciones'));
  }

  public function obtenerProgramas($ubiClave)
  {
    $ubicacion = Ubicacion::where('ubiClave',$ubiClave)->first();
    $departamentos = Departamento::where('ubicacion_id',$ubicacion->id)->pluck('id');
    $escuelas = Escuela::whereIn('departamento_id',$departamentos)->pluck('id');
    $programas = Programa::whereIn('escuela_id',$escuelas)->orderBy('progClave')->get();
    return response()->json($programas);
  }

  public function obtenerPlanes($programa_id){
    $planes = Plan::where('programa_id',$programa_id)->get();
    return response()->json($planes);
  }

  public function imprimir(Request $request)
  {

    $calificaciones = Calificacion::with('inscrito.curso.periodo','inscrito.grupo.materia',
    'inscrito.curso.cgt.plan.programa.escuela.departamento.ubicacion')
      ->whereHas('inscrito.curso.periodo', function($query) use ($request) {
          $query->where('periodo_id', $request->periodo_id);
      })
    
      ->whereHas('inscrito.curso.cgt.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
        if ($request->plan_id) {
          $query->where('plan_id', '=', $request->plan_id);//
        }
        if ($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);//
        }
        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', '=', $request->cgtGrupo);//
        }
      })
      ->whereHas('inscrito.grupo.materia', function($query) use ($request) {
        if ($request->matSemestre) {
          $query->where('matSemestre', '=', $request->matSemestre);//
        }
        if ($request->matClave) {
          $query->where('matClave', '=', $request->matClave);//
        }
      })->get();

      if($calificaciones->isEmpty()){
        alert()->warning('Advertencia', 'No se encuentran datos con la información proporcionada.
        Favor de verificar.')->showConfirmButton();
        return redirect()->back()->withInput();
      }

      $programa = $calificaciones->first()->inscrito->curso->cgt->plan->programa;
      $ubicacion = $calificaciones->first()->inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion;
      $periodo = $calificaciones->first()->inscrito->curso->periodo;
      $periodoCapturado = Utils::fecha_string($periodo->perFechaInicial).'-'.Utils::fecha_string($periodo->perFechaFinal).' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';

      $materias = $calificaciones->map(function($item,$key){
        return $item->inscrito->grupo->materia->id;
      })->unique();

      $datos = new Collection();

      $materias->each(function($materias) use($calificaciones,$datos,$request){
        $materia = Materia::find($materias);
        
          $grupoA = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'A'){
              if($item->inscrito->grupo->materia->matClave == $materia->matClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $grupoB = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'B'){
              if($item->inscrito->grupo->materia->matClave == $materia->matClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();


          $grupoC = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'C'){
              if($item->inscrito->grupo->materia->matClave == $materia->matClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();


          $grupoD = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'D'){
              if($item->inscrito->grupo->materia->matClave == $materia->matClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();


          $grupoE = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'E'){
              if($item->inscrito->grupo->materia->matClave == $materia->matClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();


          $grupoF = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'F'){
              if($item->inscrito->grupo->materia->matClave == $materia->matClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $grupoA = number_format($grupoA,3);
          $grupoB = number_format($grupoB,3);
          $grupoC = number_format($grupoC,3);
          $grupoD = number_format($grupoD,3);
          $grupoE = number_format($grupoE,3);
          $grupoF = number_format($grupoF,3);

          $total = 0;
          $dividor = 0;
          if($grupoA != 0){
            $dividor++;
            $total = $total + $grupoA;
          }

          if($grupoB != 0){
            $dividor++;
            $total = $total + $grupoB;
          }
          if($grupoC != 0){
            $dividor++;
            $total = $total + $grupoC;
          }
          if($grupoD != 0){
            $dividor++;
            $total = $total + $grupoD;
          }
          if($grupoE != 0){
            $dividor++;
            $total = $total + $grupoE;
          }
          if($grupoF != 0){
            $dividor++;
            $total = $total + $grupoF;
          }
          if($dividor != 0){
            $total = $total/$dividor;
          }

          $planA = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'A'){
              if($item->inscrito->grupo->materia->plan->planClave == $materia->plan->planClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $planB = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'B'){
              if($item->inscrito->grupo->materia->plan->planClave == $materia->plan->planClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $planC = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'C'){
              if($item->inscrito->grupo->materia->plan->planClave == $materia->plan->planClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $planD = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'D'){
              if($item->inscrito->grupo->materia->plan->planClave == $materia->plan->planClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $planE = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'E'){
              if($item->inscrito->grupo->materia->plan->planClave == $materia->plan->planClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();

          $planF = $calificaciones->filter(function($item,$key) use ($materia){
            if($item->inscrito->grupo->gpoClave == 'F'){
              if($item->inscrito->grupo->materia->plan->planClave == $materia->plan->planClave){
                  return $item;
              }
            }
          })->map(function($item,$key) use($request){
            switch ($request->tipoCalificacion) {
              case 'parcial_1':
              return $item->inscCalificacionParcial1;
              break;
              case 'parcial_2':
              return $item->inscCalificacionParcial2;
              break;
              case 'parcial_3':
              return $item->inscCalificacionParcial3;
              break;
              case 'ordinario':
              return $item->inscCalificacionOrdinario;
              break;
              case 'final':
              return $item->incsCalificacionFinal;
              break;
            }
          })->avg();
          

          $planA = number_format($planA,3);
          $planB = number_format($planB,3);
          $planC = number_format($planC,3);
          $planD = number_format($planD,3);
          $planE = number_format($planE,3);
          $planF = number_format($planF,3);        
          
          $totalPlan = 0;
          $dividorPlan = 0;
          if($planA != 0){
            $dividorPlan++;
            $totalPlan = $totalPlan + $planA;
          }

          if($planB != 0){
            $dividorPlan++;
            $totalPlan = $totalPlan + $planB;
          }
          if($planC != 0){
            $dividorPlan++;
            $totalPlan = $totalPlan + $planC;
          }
          if($planD != 0){
            $dividorPlan++;
            $totalPlan = $totalPlan + $planD;
          }
          if($planE != 0){
            $dividorPlan++;
            $totalPlan = $totalPlan + $planE;
          }
          if($planF != 0){
            $dividorPlan++;
            $totalPlan = $totalPlan + $planF;
          }
          if($dividorPlan != 0){
            $totalPlan = $totalPlan/$dividorPlan;
          }

        $datos->push([
          'planClave'=>$materia->plan->planClave,
          'matClave'=>$materia->matClave,
          'matNombre'=>$materia->matNombreOficial,
          'grupoA'=>$grupoA,
          'grupoB'=>$grupoB,
          'grupoC'=>$grupoC,
          'grupoD'=>$grupoD,
          'grupoE'=>$grupoE,
          'grupoF'=>$grupoF,
          'total'=>number_format($total,3),
          'planA'=>$planA,
          'planB'=>$planB,
          'planC'=>$planC,
          'planD'=>$planD,
          'planE'=>$planE,
          'planF'=>$planF,
          'totalPlan'=>number_format($totalPlan,3)

        ]);

      });

      $datos = $datos->sortBy('matClave');
      $datos = $datos->groupBy('planClave');
      
      $fechaActual = Carbon::now('CDT');
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_resumen_promedios';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "tipoCalificacion" => $request->tipoCalificacion,
      "programa" => $programa,
      "ubicacion" => $ubicacion,
      "periodo"=> $periodoCapturado
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use App\Http\Models\Ficha;
use App\Http\Models\Programa;
use App\Http\Models\Periodo;
use App\Http\Models\Calificacion;
use App\Http\Models\Departamento;
use App\Http\Models\Inscrito;

use App\Http\Helpers\Utils;

use Carbon\Carbon;

use PDF;
use DB;
use PhpParser\Node\Expr\FuncCall;
use RealRashid\SweetAlert\Facades\Alert;

class ResAntiguedadPreinscritosController extends Controller
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
    $ubicacion = Ubicacion::where('ubiClave','<>','000')->get();
    return View('reportes/res_antiguedad_preinscritos.create',compact('ubicacion'));
  }

  public function obtenerDepartamento(Request $request,$ubicacion_id){
    if($request->ajax()){
    $departamentos = Departamento::whereIn('depClave',['SUP','POS'])->where('ubicacion_id',$ubicacion_id)->orderByDesc('depClave')->get();
    return response()->json([
        'departamentos'=>$departamentos
    ]);
    }
  }

  public function obtenerPeriodos(Request $request, $departamento_id){
    if($request->ajax()){
      $periodos = Periodo::where('departamento_id',$departamento_id)->orderByDesc('id')->get();
      return response()->json($periodos);
    }
  }

  public function obtenerFechas(Request $request, $periodo_id){
    if($request->ajax()){
      $periodo = Periodo::findOrFail($periodo_id);
      $fechaInicial = Utils::fecha_string($periodo->perFechaInicial);
      $fechaFinal = Utils::fecha_string($periodo->perFechaFinal);  
      return response()->json([
        'fechaInicial'=>$fechaInicial,
        'fechaFinal'=>$fechaFinal
      ]);
    }
  }
  
  public function obtenerInformacion(Request $request){
    $cursos = Curso::with(['cgt.plan.programa.escuela.departamento.ubicacion','alumno','periodo'])
    ->whereHas('periodo',static function($query) use($request){
      $query->where('id',$request->periodo);
    })
    ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion',static function($query) use($request){
      $query->where('ubicacion_id',$request->ubicacion);
      $query->where('departamento_id',$request->departamento);
    })
    ->where(static function($query) use($request){
      $query->where('curEstado','P');
      if($request->primerIngreso == 'primer'){
      $query->where('curTipoIngreso','PI');
      }
    })->get();

    $aluClaves      = collect();
    $periodo        = collect();
    $fichas         = collect();
    $periodoCursado = collect();


    if ($cursos->isNotEmpty()) {

      $aluClaves = $cursos->map(function($item,$key){
        return $item->alumno->aluClave;
      })->all();
      $periodo = $cursos->first()->periodo;

      $fichas = Ficha::whereIn('fchClaveAlu',$aluClaves)
      ->where(function($query) use($periodo){
        $query->where('fchAnioPer',$periodo->perAnio);
        if($periodo->perNumero == 1){
          $query->where('fchConc',00);
        }elseif($periodo->perNumero == 3){
          $query->where('fchConc',99);
        }
      })->orderByDesc('fchFechaImpr')->get()->unique('fchClaveAlu');

      $periodoCursado = $periodo->perNumero.'/'.$periodo->perAnio;

    }
    
    $informacion = [
      'cantCursos' => $cursos->count(),
      'cursos'=>$cursos,
      'fichas'=>$fichas,
      'periodoCursado'=>$periodoCursado
    ];


    return $informacion;
  }

  public function resumenAntiguedad($informacion){

    $cursos = $informacion['cursos'];
    $fichas = $informacion['fichas'];
    $periodo = $informacion['periodoCursado'];
    $fechaActual = Carbon::now('CDT');
    $datos = collect();

    $cursos->each(static function($curso) use($fichas,$datos,$fechaActual){
      $aluClave = $curso->alumno->aluClave;
      $programa = $curso->cgt->plan->programa;
      $ubicacion = $curso->cgt->plan->programa->escuela->departamento->ubicacion;
    
      $diferencia1 = $fichas->filter(static function($item,$key) use($aluClave,$fechaActual){
        if($item->fchClaveAlu == $aluClave){
          $diasContados = Utils::diferenciaDias($item->fchFechaImpr,$fechaActual);
          return $diasContados >= 1 && $diasContados <= 15;
        }
      })->count();

      $diferencia2 = $fichas->filter(static function($item,$key) use($aluClave,$fechaActual){
        if($item->fchClaveAlu == $aluClave){
          $diasContados = Utils::diferenciaDias($item->fchFechaImpr,$fechaActual);
          return $diasContados >= 16 && $diasContados <= 30;
        }
      })->count();

      $diferencia3 = $fichas->filter(static function($item,$key) use($aluClave,$fechaActual){
        if($item->fchClaveAlu == $aluClave){
          $diasContados = Utils::diferenciaDias($item->fchFechaImpr,$fechaActual);
          return $diasContados > 30;
        }
      })->count();
      
      $diferenciaTotal = $diferencia1+$diferencia2+$diferencia3;
  
        if($diferenciaTotal > 0){
        $datos->push([
          'programa'=>$programa,
          'progClave'=>$programa->progClave,
          'progNombre'=>$programa->progNombre,
          'ubicacion'=>$ubicacion,
          'aluClave'=>$aluClave,
          'diferencia1'=>$diferencia1,
          'diferencia2'=>$diferencia2,
          'diferencia3'=>$diferencia3,
          'diferenciaTotal'=>$diferenciaTotal
        ]);
        }
      
    });
    
    $datos = $datos->sortBy(function($item,$key){
      return $item['progClave'];
    })
    ->groupBy(function($item,$key){
      return $item['progClave'];
    });

    $tipo = 'resumen';
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_res_antiguedad_preinscritos';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => Utils::fecha_string($fechaActual,true),
      "horaActual" => $fechaActual->format('H:i:s'),
      "periodo" => $periodo,
      "tipo" => $tipo
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');


  }

  public function detalleAntiguedad($informacion){
    $cursos = $informacion['cursos'];
    $fichas = $informacion['fichas'];
    $periodo = $informacion['periodoCursado'];
    $fechaActual = Carbon::now('CDT');
    $datos = collect();
    
    $cursos->each(static function($curso) use($fichas,$datos,$fechaActual){
      $alumno = $curso->alumno;
      $programa = $curso->cgt->plan->programa;
      $ubicacion = $curso->cgt->plan->programa->escuela->departamento->ubicacion;
      $ficha = $fichas->where('fchClaveAlu',$alumno->aluClave)->sortByDesc('fchFechaImpr')->first();
      if($ficha){
      $diasContados = Utils::diferenciaDias($ficha->fchFechaImpr,$fechaActual);

      $diferencia1 = '';
      $diferencia2 = '';
      $diferencia3 = '';

      if($diasContados >= 1 && $diasContados <= 15){
        $diferencia1 = 'X';
      }
      if($diasContados >= 16 && $diasContados <= 30){
        $diferencia2 = 'X';
      }
      if($diasContados > 30){
        $diferencia3 = 'X';
      }
      
      $diferenciaTotal = $fichas->filter(static function($item,$key) use($alumno,$fechaActual,$diferencia1,$diferencia2,$diferencia3){
        if($item->fchClaveAlu == $alumno->aluClave){
          $diasContados = Utils::diferenciaDias($item->fchFechaImpr,$fechaActual);
          return $item;
        }
      })->count();
      
        if($diferenciaTotal > 0){
        $datos->push([
          'programa'=>$programa,
          'ubicacion'=>$ubicacion,
          'aluClave'=>$alumno->aluClave,
          'nombreAlumno'=>$alumno->persona->perApellido1.' '.$alumno->persona->perApellido2.' '.$alumno->persona->perNombre,
          'diferencia1'=>$diferencia1,
          'diferencia2'=>$diferencia2,
          'diferencia3'=>$diferencia3,
          'diferenciaTotal'=>$diferenciaTotal
        ]);
        }
      }
    });

    $datos = $datos->sortBy(function($item,$key){
      return $item['programa']['progClave'];
    })
    ->groupBy(function($item,$key){
      return $item['programa']['progClave'];
    });

    $tipo = 'detalle';


    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_res_antiguedad_preinscritos';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => Utils::fecha_string($fechaActual,true),
      "horaActual" => $fechaActual->format('H:i:s'),
      "periodo" => $periodo,
      "tipo" => $tipo
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');
  }

  public function imprimir(Request $request)
  {
    $informacion = $this->obtenerInformacion($request);

    if($informacion["cantCursos"] == 0) {

      alert()->warning('Advertencia', 'No se encuentran datos con la información proporcionada.
      Favor de verificar.')->showConfirmButton();
      return redirect()->back()->withInput();
    }


    if($request->tipoReporte == 'resumen'){
      return $this->resumenAntiguedad($informacion);
    }else{ 
      return $this->detalleAntiguedad($informacion); 
    }
  }
}
<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Historico;
use App\Http\Models\Ubicacion;
use App\Http\Models\Materia;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;
use App\Http\Models\Periodo;
use App\Http\Models\Calificacion;
use App\Http\Models\Inscrito;

use App\Http\Helpers\Utils;
use Carbon\Carbon;

use PDF;
use DB;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;

class IndiceReprobacionController extends Controller
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
    return View('reportes/indice_reprobacion.create',compact('anioActual', 'ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $periodo = Periodo::findOrFail($request->periodo_id);
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;
    $escClave = $request->escuela_id ? Escuela::find($request->escuela_id)->escClave : null;
    $progClave = $request->programa_id ? Programa::find($request->programa_id)->progClave : null;

    $resultado = DB::select("call procIndiceEvaluacionOrdinarios("
    .$periodo->perNumero.",".$periodo->perAnio.",'".$ubicacion->ubiClave."','".$departamento->depClave
    ."','".$escClave."','".$progClave."','".$request->cgtGrado."','".$request->cgtGrupo
    ."','".$request->curEstado."','".$request->evaluacion."')");
    
    $datos = new Collection();

    for ($i=0; $i < count($resultado); $i++) { 
      $nivel = $resultado[$i]->nivel;
      $grupo = $resultado[$i]->grupo;
      $reprobado0 = $resultado[$i]->reprobado0;
      $reprobado1 = $resultado[$i]->reprobado1;
      $reprobado2 = $resultado[$i]->reprobado2;
      $reprobado3 = $resultado[$i]->reprobado3;
      $reprobado4 = $resultado[$i]->reprobado4;
      $total = $resultado[$i]->total;

      $datos->push([
        'nivel'=>$nivel,
        'grupo'=>$grupo,
        'reprobado0'=>$reprobado0,
        'reprobado1'=>$reprobado1,
        'reprobado2'=>$reprobado2,
        'reprobado3'=>$reprobado3,
        'reprobado4'=>$reprobado4,
        'total'=>$total,
        'orden'=>$nivel.$grupo
      ]);
    }

    if($datos->isEmpty()) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    $datos = $datos->groupBy('nivel');

    $calificacionEval = '';

    switch ($request->evaluacion) {
      case 1:
      $calificacionEval="PRIMER PARCIAL";
      break;
      case 2:
      $calificacionEval="SEGUNDO PARCIAL";
      break;
      case 3:
      $calificacionEval="TERCER PARCIAL";
      break;
      case 'O':
      $calificacionEval="ORDINARIO";
      break;
      case 'F':
      $calificacionEval="FINAL";
      break;
    }
    $alumnosIncluidos = '';
    switch ($request->curEstado) {
      case '':
      $alumnosIncluidos="TODOS LOS ALUMNOS";
      break;
      case 'R':
      $alumnosIncluidos="ALUMNOS REGULARES";
      break;
      case 'P':
      $alumnosIncluidos="ALUMNOS PREINSCRITOS";
      break;
      case 'B':
      $alumnosIncluidos="ALUMNOS DE BAJA";
      break;
      case 'C':
      $alumnosIncluidos="ALUMNOS CONDICIONADOS";
      break;
      case 'A':
      $alumnosIncluidos="ALUMNOS CONDICIONADOS 2";
      break;
    }
    
    $periodoData = $periodo->perNumero.'/'.$periodo->perAnio.' ('.Utils::fecha_string($periodo->perFechaInicial,true).' - '.Utils::fecha_string($periodo->perFechaFinal,true).')';
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $fechaActual = Carbon::now('CDT');

    $nombreArchivo = 'pdf_indice_reprobacion';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "calificacionEval" => $calificacionEval,
      "alumnosIncluidos" => $alumnosIncluidos,
      "ubicacionNombre" => $ubicacion,
      "periodo" => $periodoData,
      "perAnio" => $periodo->perAnio
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
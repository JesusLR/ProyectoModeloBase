<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Historico;
use App\Models\Ubicacion;
use App\Models\Materia;
use App\Models\Periodo;
use App\Models\Calificacion;
use App\Models\Inscrito;
use App\Models\Escuela;
use App\Models\Programa;
use App\Models\Plan;

use DB;
use PDF;
use Carbon\Carbon;
use App\Http\Helpers\Utils;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;

class RelGruposEquivalentesController extends Controller
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
    return View('reportes/rel_grupos_equivalentes.create', compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
    $planClave = $request->plan_id ? Plan::findOrFail($request->plan_id)->planClave : null;
    $progClave = $request->programa_id ? Programa::findOrFail($request->programa_id)->progClave : null;
    $escClave = $request->escuela_id ? Escuela::findOrFail($request->escuela_id)->escClave : null;
    
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;

    $resultado = DB::select("call procRelacionEquivalentes("
    .$periodo->perNumero.",".$periodo->perAnio.",'".$ubicacion->ubiClave."','".$departamento->depClave
    ."','".$escClave."','".$progClave."','".$planClave."','".$request->cgtGrado."','".
    $request->matClave."','".$request->cgtGrupo."','".$request->cgtInscritos."','"."''"."')");
    
    $datos = new Collection();

    for ($i=0; $i < count($resultado); $i++) { 
      $tipo = $resultado[$i]->tipo;
      $escuela = $resultado[$i]->escuela;
      $programa = $resultado[$i]->programa;
      $plan = $resultado[$i]->plan;
      $claveMat = $resultado[$i]->claveMat;
      $nombreMat = $resultado[$i]->nombreMat;
      $grupo = $resultado[$i]->grupo;
      $inscritos = $resultado[$i]->inscritos;

      $datos->push([
        'tipo'=>$tipo,
        'escuela'=>$escuela,
        'programa'=>$programa,
        'plan'=>$plan,
        'claveMat'=>$claveMat,
        'nombreMat'=>$nombreMat,
        'grupo'=>$grupo,
        'inscritos'=>$inscritos      
        ]);
    }
    

    if($datos->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada')->showConfirmButton();
      return back()->withInput();
    }

    $perFechas = Utils::fecha_string($periodo->perFechaInicial, true).' - '.Utils::fecha_string($periodo->perFechaFinal, true).' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $fechaActual = Carbon::now('CDT');

    $nombreArchivo = 'pdf_rel_grupos_equivalentes';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "ubicacionNombre" => $ubicacion,
      "periodo" => $perFechas,
      "perAnio" => $periodo->perAnio
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
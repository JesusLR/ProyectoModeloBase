<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Grupo;

use App\Http\Helpers\Utils;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use PDF;
use DB;

class ValidarFechasOrdinariosController extends Controller
{
    //
    public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
  }

  public function reporte(){

  	return view('reportes/validar_fechas_ordinarios.create',[
  		'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get(),
    ]);
  }//reporte.


  public function imprimir(Request $request) {

  	$grupos = Grupo::with(['materia.plan.programa.escuela.departamento.ubicacion'])
  	->whereHas('materia.plan.programa.escuela.departamento.ubicacion', static function ($query) use ($request) {
      $query->where('escuela_id', $request->escuela_id);

  		if($request->programa_id){
  			$query->where('programa_id', $request->programa_id);
  		}
  		if($request->plan_id){
  			$query->where('plan_id', $request->plan_id);
  		}
  		if($request->matClave){
  			$query->where('matClave', $request->matClave);
  		}
  	})
  	->where(static function ($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
  		if($request->gpoSemestre){
  			$query->where('gpoSemestre', $request->gpoSemestre);
  		}
  		if($request->gpoGrupo){
  			$query->where('gpoGrupo', $request->gpoGrupo);
  		}
  		if($request->inscritos_gpo){
  			$query->where('inscritos_gpo', $request->inscritos_gpo);
  		}
  	});

  	if(!$grupos->first()){
  		alert()->warning('Sin coincidencias', 'No se encuentran datos con la información proporcionada. Favor de verificar')->showConfirmButton();
  		return back()->withInput();
  	}

  	$fechaActual = Carbon::now('CDT');
  	$periodo = $grupos->first()->periodo;
  	$calendario = DB::table('calendarioexamen')->where('periodo_id', $periodo->id)->first();

  	if(!$calendario){
  		alert()->warning('No hay calendario', 'El periodo aún no cuenta con un calendario
  			de exámenes, se debe crear tal calendario para poder realizar este reporte.');
  		return back()->withInput();
  	}

  	$fechas = [$calendario->calexInicioOrdinario, $calendario->calexFinOrdinario];
  	$grupos = $grupos->whereNotBetween('gpoFechaExamenOrdinario',$fechas)->get()

	->map(function ($item, $key) {
		$matNombre = $item->materia->matNombreOficial;
		if($item->optativa_id){
			$matNombre = $matNombre.' - '.$item->optativa->optNombre;
		}
		
		return [
			'progClave' => $item->plan->programa->progClave,
			'progNombre' => $item->plan->programa->progNombre,
			'planClave' => $item->plan->planClave,
			'gpoSemestre' => $item->gpoSemestre,
			'gpoClave' => $item->gpoClave,
			'matClave' => $item->materia->matClave,
			'matNombre' => $matNombre,
			'fechaExamen' => Utils::fecha_string($item->gpoFechaExamenOrdinario,'mesCorto'),
			'horaExamen' => Carbon::parse($item->gpoHoraExamenOrdinario)->format('H:i'),
			'inscritos_gpo' => $item->inscritos_gpo
		];

	})->groupBy(['progClave','planClave','gpoSemestre']);

  if($grupos->isEmpty()) {
    alert()->success('Validación exitosa', 'Todos los exámenes están bien agendados.')->showConfirmButton();
    return back()->withInput();
  }

  	setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_validar_fechas_ordinarios';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "nombreArchivo" => $nombreArchivo,
      "grupos" => $grupos,
      "ubiClave" => $periodo->departamento->ubicacion->ubiClave,
      "ubiNombre" => $periodo->departamento->ubicacion->ubiNombre,
      "depClave" => $periodo->departamento->depClave,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "fechaInicio" => Utils::fecha_string($fechas[0],'mesCorto'),
      "fechaFin" => Utils::fecha_string($fechas[1],'mesCorto'),
      "periodo" => $periodo->perNumero.'/'.$periodo->perAnio,
      "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial,'mesCorto'),
      "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal,'mesCorto'),
      "tipoReporte" => $request->tipoReporte,
    ]);

    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';
    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }//imprimir.

}//controller class.
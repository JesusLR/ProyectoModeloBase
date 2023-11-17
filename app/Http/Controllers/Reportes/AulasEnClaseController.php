<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\clases\prefecteos\MetodosPrefecteos;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\Utils;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AulasEnClaseController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$horas = array(
    		7 => '7 a.m.',
    		8 => '8 a.m.',
    		9 => '9 a.m.',
    		10 => '10 a.m.',
    		11 => '11 a.m.',
    		12 => '12 p.m.',
    		13 => '1 p.m.',
    		14 => '2 p.m.',
    		15 => '3 p.m.',
    		16 => '4 p.m.',
    		17 => '5 p.m.',
    		18 => '6 p.m.',
    		19 => '7 p.m.',
    		20 => '8 p.m.',
    		21 => '9 p.m.',
    		22 => '10 p.m.',
    	);

    	return view('prefecteo/aulas_en_clase.create', [
    		'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get(),
    		'fechaActual' => Carbon::now('America/Merida'),
    		'horas' => $horas,
    	]);
    }

    public function imprimir(Request $request) {

    	$detalles = MetodosPrefecteos::buscarDetallesDesdeRequest($request)->get();
    	if($detalles->isEmpty()) {
    		alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$periodo = $detalles->first()->prefecteo->periodo;

    	$data = $detalles->map(static function($detalle) {
    		$aula = $detalle->aula;
    		$grupo = $detalle->grupo;
    		$empleado = $grupo->empleado;

    		return collect([
    			'prefecteo_id' => $detalle->prefecteo_id,
    			'prefHoraInicio' => $detalle->prefecteo->prefHoraInicio,
    			'ghInicio' => str_pad($detalle->ghInicio, 2, '0', STR_PAD_LEFT),
    			'ghFinal' => str_pad($detalle->ghFinal, 2, '0', STR_PAD_LEFT),
    			'aulaClave' => $aula->aulaClave,
    			'aulaDescripcion' => $aula->aulaDescripcion,
    			'aulaUbicacion' => $aula->aulaUbicacion,
    			'progClave' => $detalle->programa->progClave,
    			'gpoSemestre' => $grupo->gpoSemestre,
    			'gpoClave' => $grupo->gpoClave,
    			'empleado_id' => $empleado->id,
    			'nombreEmpleado' => MetodosPersonas::nombreCompleto($empleado->persona, true),
    		]);
    	})->sortBy('aulaUbicacion')->groupBy('prefHoraInicio')->sortKeys();

    	$fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_aulas_en_clases";
        return PDF::loadView("prefecteo.pdf.{$nombreArchivo}",[
	        "data" => $data,
	        "periodo" => $periodo,
	        "ubicacion" => $periodo->departamento->ubicacion,
	        "fechaActual" => $fechaActual->format('d/m/Y'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "fechaPrefecteo" => Utils::fecha_string($request->prefFecha, 'mesCorto'),
	        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');
    }
}

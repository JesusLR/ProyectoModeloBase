<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Edocta;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\Utils;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PagosErroresAlAplicarController extends Controller
{
    //
    public function _construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }


    public function reporte() {
    	return view('reportes/pagos_errores_al_aplicar.create', ['fechaActual' => Carbon::now('America/Merida')]);
    }

    public function imprimir(Request $request) {
    	$errores = Edocta::with('alumno.persona')
    	->where(static function($query) use ($request) {
    		$query->where('edoEstado', $request->edoEstado);
    		$query->whereBetween('edoFechaOper', [$request->fecha1, $request->fecha2]);
    		if($request->aluClave) {
    			$query->where('edoClaveAlu', $request->aluClave);
    		}
    	})->latest('edoFechaOper')->get();

    	if($errores->isEmpty()) {
    		alert()->warning('Sin coincidencias', 'No se encuentran datos con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}
    	
    	$errores = self::modificarNombresYFechas($errores, $request);

    	$fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_pagos_errores_al_aplicar";
        return PDF::loadView("reportes/pdf.{$nombreArchivo}",[
	        "errores" => $errores,
	        "edoEstado" => self::describirEstado($request->edoEstado),
	        "fecha1" => Utils::fecha_string($request->fecha1, 'mesCorto'),
	        "fecha2" => Utils::fecha_string($request->fecha2, 'mesCorto'),
	        "fechaActual" => $fechaActual->format('d/m/Y'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');
    }



    /**
    * @param Collection $errores
    * @param Request $request
    */
    private static function modificarNombresYFechas($errores, $request): Collection
    {
    	return $errores->each(static function($error) use ($request) {
    		$error->edoFechaOper = Utils::fecha_string($error->edoFechaOper, 'mesCorto');
    		$error->edoFechaProc = Utils::fecha_string($error->edoFechaProc, 'mesCorto');
    		if($request->edoEstado != 'N') {
    			$error->nombreCompleto = MetodosPersonas::nombreCompleto($error->alumno->persona, true);
    		}
    	});
    }

    /**
    * @param string
    */
    public static function describirEstado($edoEstado): string
    {	$descripcion = 'Repetido';
	    switch ($edoEstado) {
	    	case 'N':
	    		$descripcion = 'Inválido';
	    		break;
	    	case 'D':
	    		$descripcion = 'Descartado';
	    		break;
	    }
    	return $descripcion;
    }
}

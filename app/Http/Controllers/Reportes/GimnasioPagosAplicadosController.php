<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\UsuaGimTipo;
use App\Http\Models\Pago;
use App\clases\usuariogim\MetodosUsuaGim;
use App\Http\Helpers\Utils;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class GimnasioPagosAplicadosController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }


    public function reporte() {

    	return view('reportes/gimnasio_pagos_aplicados.create', ['tipos' => UsuaGimTipo::get()]);
    }


    public function imprimir(Request $request) {
    	$usuarios = MetodosUsuaGim::buscarDesdeRequest($request)->get();
    	if($usuarios->isEmpty()) {
    		alert()->warning('Sin coincidencias', 'No hay usuarios que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
    		return back()->withInput();
    	}

    	$usuarios = $usuarios->map(static function($usuario) {
    		$usuario->clave_pago = '0000'.$usuario->id;
    		return $usuario;
    	})->keyBy('clave_pago');

    	$pagosData = Pago::with('concepto')
    		->whereIn('pagClaveAlu', $usuarios->keys())
    		->whereBetween('pagFechaPago', [$request->fecha1, $request->fecha2])
    		->latest('pagFechaPago')->get();
    	if($pagosData->isEmpty()) {
    		alert()->warning('Sin Coincidencias', 'No se encontraron pagos aplicados de usuarios con este filtro. Favor de verificar la información proporcionada.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$pagos = $pagosData->map(static function($pago) use ($usuarios) {
    		$usuario = $usuarios->get($pago->pagClaveAlu);

    		return collect([
    			'usuario_id' => $usuario->id,
    			'nombreCompleto' => MetodosUsuaGim::nombreCompleto($usuario, true),
    			'aluClave' => $usuario->aluClave,
    			'gimTipo' => $usuario->gimTipo,
    			'tugDescripcion' => $usuario->tipo->tugDescripcion,
    			'pagFechaPago' => Utils::fecha_string($pago->pagFechaPago, 'mesCorto'),
    			'pagImpPago' => $pago->pagImpPago,
    			'orden' => $pago->pagFechaPago,
    		]);
    	})->sortByDesc('orden');

    	$fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_gimnasio_pagos_aplicados";
        return PDF::loadView("reportes/pdf.{$nombreArchivo}",[
	        "pagos" => $pagos,
	        "fecha1" => Utils::fecha_string($request->fecha1, 'mesCorto'),
	        "fecha2" => Utils::fecha_string($request->fecha2, 'mesCorto'),
	        "fechaActual" => $fechaActual->format('d/m/Y'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');


    }# imprimir.
}

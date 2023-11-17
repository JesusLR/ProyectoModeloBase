<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Pago;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class RelPagosCapturadosUsuarioController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$fechaActual = Carbon::now('CDT');
    	return view('reportes/rel_pagos_capturados_usuario.create', compact('fechaActual'));
    }//reporte.

    public function imprimir(Request $request) {

    	$fechaActual = Carbon::now('CDT');

    	$pagos = Pago::with(['alumno','concepto','usuario'])
    	->whereHas('alumno', static function($query) use ($request) {
    		if($request->aluClave) {
    			$query->where('aluClave', $request->aluClave);
    		}
    	})
    	->whereHas('usuario', static function($query) use ($request) {
    		$query->where('username', $request->username);
    	})
    	->where(static function($query) use ($request) {
    		$fecha1 = Carbon::parse($request->fecha1)->format('Y-m-d');
    		$fecha2 = Carbon::parse($request->fecha2)->format('Y-m-d');

    		$query->whereDate('pagFechaPago', '>=', $fecha1);
    		$query->whereDate('pagFechaPago', '<=', $fecha2);
    		if($request->pagAnioPer) {
    			$query->where('pagAnioPer', $request->pagAnioPer);
    		}
    		if($request->pagConcPago) {
    			$query->where('pagConcPago', $request->pagConcPago);
    		}
    	})
    	->where('pagFormaAplico', 'M')->get();

    	if($pagos->isEmpty()) {
    		alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
    		return back()->withInput();
    	}

    	$pago1 = $pagos->first();
    	$usuario = $pago1->usuario;
    	$persona = $usuario->empleado->persona;

    	$info = collect([
    		'username' => $usuario->username,
    		'empNombre' => $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2,
    		'depNombre' => $usuario->empleado->escuela->departamento->depNombre,
    		'ubiNombre' => $usuario->empleado->escuela->departamento->ubicacion->ubiNombre
    	]);

    	$datos = $pagos->map(function($item, $key) {
    		$alumno = $item->alumno;
    		$persona = $alumno->persona;

    		return collect([
    			'aluClave' => $alumno->aluClave,
    			'nombre' => $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre,
    			'pagAnioPer' => $item->pagAnioPer,
    			'pagConcPago' => $item->pagConcPago,
    			'conpNombre' => $item->concepto->conpNombre,
    			'pagRefPago' => $item->pagRefPago,
    			'pagImpPago' => $item->pagImpPago,
    			'pagFechaPago' => Utils::fecha_string($item->pagFechaPago, 'mesCorto', 'y')
    		]);
    	});


    	// Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_rel_pagos_capturados_usuario.pdf";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.pdf_rel_pagos_capturados_usuario", [
	        "info" => $info,
	        "datos" => $datos,
	        "fechaActual" => Utils::fecha_string($fechaActual, 'mesCorto'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }//imprimir.
}//Controller class

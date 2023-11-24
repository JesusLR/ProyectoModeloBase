<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Curso;
use App\Models\Pago;

use App\Http\Helpers\Utils;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use PDF;

class EstadoDeCuentaController extends Controller
{
    //
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permisos:r_plantilla_profesores');
		// set_time_limit(8000000);
	}

    public function reporte() {

    	$anioActual = Carbon::now('CDT');

    	return view('reportes/estado_cuenta.create', compact('anioActual'));
    }//reporte.

    public function imprimir(Request $request) {
    	$fechaActual = Carbon::now('CDT');

    	$curso = Curso::with(['alumno.persona', 'cgt'])
    	->whereHas('alumno.persona', static function($query) use ($request) {
    		$query->where('aluClave', $request->aluClave);
    	})
    	->latest('curFechaRegistro')->first();

    	if(!$curso) {
    		alert()->warning('No existe Clave', 
    			'No se encuentró alumno con esa clave de pago. Favor de verificar')
    		->showConfirmButton();
    		return back()->withInput();
    	}

    	$alumno = $curso->alumno;
    	$persona = $alumno->persona;
    	$pagos = Pago::with('concepto')->where('pagClaveAlu', $alumno->aluClave)
    	->where(static function($query) use ($request) {
    		if($request->pagAnioPer) {
    			$query->where('pagAnioPer', $request->pagAnioPer);
    		}
    	})->latest('pagFechaPago')->get();

    	$info = collect([
    		'aluClave' => $alumno->aluClave,
    		'nombre' => $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2,
    		'perCurp' => $persona->perCurp,
    		'grado' => $curso->cgt->cgtGradoSemestre.'-'.$curso->cgt->cgtGrupo,
    		'curEstado' => $curso->curEstado,
    		'aluEstado' => $alumno->aluEstado,
    		'progNombre' => $curso->cgt->plan->programa->progNombre,
    		'escNombre' => $curso->cgt->plan->programa->escuela->escNombre,
    		'depNombre' => $curso->cgt->plan->programa->escuela->departamento->depNombre,
    		'ubiNombre' => $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre,
    	]);

    	// Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_estado_cuenta";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.pdf_estado_cuenta", [
	        "info" => $info,
	        "pagos" => $pagos,
	        "fechaActual" => Utils::fecha_string($fechaActual, 'mesCorto'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo.'.pdf'
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo.'.pdf');
        return $pdf->download($nombreArchivo.'.pdf');
    }//imprimir.
}//Controller class.

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Pago;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PagosDuplicadosController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
        ini_set('memory_limit', '-1');
    }

    public function reporte() {
    	$fechaActual = Carbon::now('CDT');
    	$ubicaciones = Ubicacion::where('id','<>',0)->get();
    	return view('reportes/pagos_duplicados.create', compact('fechaActual', 'ubicaciones'));
    }//reporte.

    public function imprimir(Request $request) {

    	$alert_title = 'Sin coincidencias';
    	$alert_text = 'No se encontraron registros con la información proporcionada. Favor de verificar.';
    	$fechaActual = Carbon::now('CDT');



    	# ----------------- FILTRO 1 - INFO GENERAL DE ALUMNOS -----------------------------
    	$cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
    	->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
    		$query->where('escuela_id', $request->escuela_id);
    	})
    	->whereHas('alumno.persona', static function($query) use ($request) {
    		if($request->aluClave) {
    			$query->where('aluClave', $request->aluClave);
    		}
    	})
    	->latest('curFechaRegistro')->get()->unique('alumno_id');

    	if($cursos->isEmpty()) {
    		alert()->warning($alert_title, $alert_text)->showConfirmButton();
    		return back()->withInput();
    	}

        $cursos = $cursos->keyBy('alumno.aluClave');

        $curso1 = $cursos->first();
        $info = collect([
            'depNombre' => $curso1->periodo->departamento->depNombre,
            'ubiNombre' => $curso1->periodo->departamento->ubicacion->ubiNombre,
            'escNombre' => $curso1->cgt->plan->programa->escuela->escNombre
        ]);



    	# --------------- FILTRO 2 - OBTENER PAGOS DE ALUMNOS ------------------------------
    	$claves = $cursos->pluck('alumno.aluClave', 'alumno.aluClave');
    	$pagosData = Pago::with(['alumno', 'concepto', 'usuario'])
    	->where(static function($query) use ($request, $claves) {
    		$fecha1 = Carbon::parse($request->fecha1)->format('Y-m-d');
    		$fecha2 = Carbon::parse($request->fecha2)->format('Y-m-d');
    		$query->whereIn('pagClaveAlu', $claves);
    		$query->whereBetween('pagFechaPago',[$fecha1, $fecha2]);
    		if($request->pagAnioPer) {
    			$query->where('pagAnioPer', $request->pagAnioPer);
    		}
    		if($request->pagConcPago) {
    			$query->where('pagConcPago', $request->pagConcPago);
    		}
    	})
        ->latest('pagFechaPago')->get();

    	if($pagosData->isEmpty()) {
    		alert()->warning($alert_title, $alert_text)->showConfirmButton();
    		return back()->withInput();
    	}

        $claves = $pagosData->unique('pagClaveAlu')->pluck('pagClaveAlu', 'pagClaveAlu');



        # ----------------------- PROCESO ------------------------------------
        $cursos = $cursos->whereIn('alumno.aluClave', $claves);

        $pagosData = $pagosData->groupBy(['pagClaveAlu', function($item, $key) {

            return $item->pagAnioPer.'-'.$item->pagConcPago;

        }]);

        $pagosData->each(static function($pagos, $aluClave) use ($pagosData, $cursos) {

            $pagos->each(static function($anio_concepto, $key) use ($pagos) {
                $no_duplicados = ($anio_concepto->count() < 2) ? true : false;
                if($no_duplicados) {
                    $pagos->forget($key);
                }
            });

            if($pagos->isEmpty()) {
                $pagosData->forget($aluClave);
                $cursos->forget($aluClave);
            } else {
                $curso = $cursos->pull($aluClave);
                $pagos->put('curso', $curso);
            }
        });

        if($pagosData->isEmpty()) {
            alert()->warning($alert_title, $alert_text)->showConfirmButton();
            return back()->withInput();
        }

    	// Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_pagos_duplicados.pdf";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.pdf_pagos_duplicados", [
	        "info" => $info,
	        "datos" => $pagosData,
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

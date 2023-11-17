<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;

use App\Http\Helpers\Utils;	
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use PDF;

class RelCondicionadosController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$ubicaciones = Ubicacion::all();
    	return view('reportes/relacion_condicionados.create', compact('ubicaciones'));
    }//reporte.

    public function imprimir(Request $request) {

    	$fechaActual = Carbon::now('CDT');

    	$cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela', 'periodo'])
    	->whereHas('periodo', static function($query) use ($request) {
    		$query->where('id', $request->periodo_id);
    	})
    	->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
    		if($request->escuela_id) {
    			$query->where('escuela_id', $request->escuela_id);
    		}
    		if($request->programa_id) {
    			$query->where('programa_id', $request->programa_id);
    		}
    	})
    	->where(static function($query) use ($request) {
    		if($request->curEstado) {
    			$query->where('curEstado', $request->curEstado);
    		} else {
    			$query->whereIn('curEstado', ['A', 'C', 'X']);
    		}
    	})->get();

    	if($cursos->isEmpty()) {
    		alert()->warning('Sin registros', 'No hay datos que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
    		return back()->withInput();
    	}

    	$periodo = $cursos->first()->periodo;
    	$info = collect([
    		'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
    		'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto')
    	]);

    	$datos = $cursos->map(function($item, $key) {
    		$persona = $item->alumno->persona;
    		$nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
    		$progClave = $item->cgt->plan->programa->progClave;

    		return Collect([
    			'aluClave' => $item->alumno->aluClave,
    			'nombre' => $nombre,
    			'ubiClave' => $item->periodo->departamento->ubicacion->ubiClave,
    			'depClave' => $item->periodo->departamento->depClave,
    			'progClave' => $progClave,
    			'grado' => $item->cgt->cgtGradoSemestre,
    			'grupo' => $item->cgt->cgtGrupo,
    			'curEstado' => $item->curEstado,
    			'orden' => $progClave.'-'.$nombre
    		]);
    	})->sortBy('orden')->groupBy(['curEstado', 'progClave'])->sortKeysDesc();


    	// Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_relacion_condicionados.pdf";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.pdf_relacion_condicionados", [
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

}//Controller class.

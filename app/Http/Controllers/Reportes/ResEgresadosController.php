<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Egresado;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class ResEgresadosController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){
    	return view('reportes/res_egresados.create',[
            'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
        ]);
    }//FIN function reporte.

    public function dateDMY($fecha){
    	if($fecha){
    	$f = Carbon::parse($fecha)->format('d/m/Y');
    	return $f;
    	}
    }//FIN function dateDMY

    public function obtenerRecursos($request){
    	$egresados = Egresado::with('plan.programa.escuela')
    	  ->whereHas('plan.programa.escuela', static function($query) use($request){
            $query->where('departamento_id', $request->departamento_id);
            if($request->escuela_id) {
                $query->where('escuela_id', $request->escuela_id);
            }
    	  	if($request->programa_id){
    	  		$query->where('programa_id', $request->programa_id);
    	  	}
    	  })
          ->where(static function($query) use ($request) {
            if($request->periodo_id) {
                $query->where('periodo_id', $request->periodo_id);
            }
          })
    	  ->get();

    	  $recursos = [
    	  	'egresados' => $egresados,
            'tipoReporte' => $request->tipoReporte
    	  ];

    	  return $recursos;
    }//FIN function obtenerRecursos.

    public function resEgresados($recursos){
    	$datos = collect([]);
    	$fechaActual = Carbon::now('CDT');
    	$egresados = $recursos['egresados']; 
    	$te = count($egresados); #Total de egresados
    	if($te == 0){
    		alert()->warning('Sin coincidencias','No existen registros con la información proporcionada. Favor de verificar')->showConfirmButton();
            return back()->withInput();
    	}

    	/*
    	* Retornar el primer egresado.
    	* -> Obtener Número / Año del Periodo.
    	*/
    	$egre1 = $egresados->first();
    	$perNum = $egre1->periodo->perNumero;
    	$perAnio = $egre1->periodo->perAnio;
        $ubicacion = $egre1->periodo->departamento->ubicacion;
    	
    	/*
    	* Por cada egresado.
    	* -> Extraer info para agrupar / ordenar.
    	* -> Guadar info en $datos([]).
    	*/
    	for ($i=0; $i < $te; $i++){ 
    		$egre = $egresados->get($i);
    		$escClave = $egre->plan->programa->escuela->escClave;
    		$progClave = $egre->plan->programa->progClave;
    		$progNombre = $egre->plan->programa->progNombre;

    		$datos->push([
    			'ubiClave' => $ubicacion->ubiClave,
    			'ubiNombre' => $ubicacion->ubiNombre,
    			'escClave' => $escClave,
    			'progClave' => $progClave,
    			'progNombre' => $progNombre
    		]);
    	}//FIN for $te

    	/*
    	* Esta Collection almacenará la información de la carrera.
    	* y el total de egresados de la misma.
    	*/
    	$progData = collect([]);

    	//Agrupar y obtener información por carrera.
    	$ubicaciones = $datos->groupBy('ubiClave');
    	foreach ($ubicaciones as $ubicacion){
    		$carreras = $ubicacion->groupBy('progClave');
    		foreach($carreras as $carrera){
    			$prog1 = $carrera->first();
    			$cam = $prog1['ubiClave'];
    			$car = $prog1['progClave'];

    			//Buscar cantidad egresados por cada Campus->carrera.
    			$carTotal = $datos->where('ubiClave',$cam)
    					->where('progClave',$car)
    					->count();

    			$progData->push([
    				'ubiClave' => $cam,
    				'ubiNombre' => $prog1['ubiNombre'],
    				'escClave' => $prog1['escClave'],
    				'progClave' => $car,
    				'progNombre' => $prog1['progNombre'],
    				'carTotal' => $carTotal
    			]);
    			
    		} //FIN foreach carrera. 
    	}//FIN foreach ubicacion.

    	/*
    	* Agrupar por
    	* -> Campus.
    	*   -> Escuela.
    	*/
    	$grouped = $progData->groupBy(['ubiClave',function($item){
    		return $item['escClave'];
    	}]);

    	// Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_res_egresados.pdf";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.pdf_res_egresados", [
        "datos" => $grouped,
        "perNum" => $perNum,
        "perAnio" => $perAnio,
        "fechaActual" => $this->dateDMY($fechaActual),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo,
        "tipoReporte" => $recursos['tipoReporte']
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }//FIN function resEgresados.

    public function imprimir(Request $request){
    	$recursos = $this->obtenerRecursos($request);
    	return $this->resEgresados($recursos);
    }//FIN function imprimir.
}//FIN Controller class.
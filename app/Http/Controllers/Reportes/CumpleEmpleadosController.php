<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Empleado;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CumpleEmpleadosController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){

    	$empEstado = [
      		'A' => 'ACTIVO',
      		'B' => 'BAJA',
            'C' => 'ACTIVOS EN CLASES',
            'S' => 'SUSPENDIDO',
            'T' => 'TODOS'
  		];
  		$mesCumple = [
            '00' => 'TODOS',
  			'01' => 'ENERO',
  			'02' => 'FEBRERO',
  			'03' => 'MARZO',
  			'04' => 'ABRIL',
  			'05' => 'MAYO',
  			'06' => 'JUNIO',
  			'07' => 'JULIO',
  			'08' => 'AGOSTO',
  			'09' => 'SEPTIEMBRE',
  			'10' => 'OCTUBRE',
  			'11' => 'NOVIEMBRE',
  			'12' => 'DICIEMBRE'
  		];
    	$anioActual = Carbon::now();
    	return view('reportes/cumple_empleados.create',[
            'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get(),
    		'empEstado' => $empEstado,
    		'mesCumple' => $mesCumple
    		]);
    }

    public function dateDMY($fecha){
    	if($fecha){
    	$f = Carbon::parse($fecha)->format('d/m/Y');
    	return $f;
    	}
    }

    public function obtenerRecursos($request){

	    	$empleados = Empleado::with('escuela.departamento.ubicacion',
	    		'persona')
	    	->whereHas('escuela.departamento.ubicacion',function($query) use ($request){
                $query->where('escuela_id', $request->escuela_id);
	    	})
	    	->whereHas('persona',function($query) use ($request){
	    		if($request->perApellido1){
	    			$query->where('perApellido1', $request->perApellido1);
	    		}
	    		if($request->perApellido1){
	    			$query->where('perApellido1', $request->perApellido1);
	    		}
	    		if($request->perNombre){
	    			$query->where('perNombre', $request->perNombre);
	    		}
                if($request->mesCumple && $request->mesCumple != 00){
                    $query->whereMonth('perFechaNac', $request->mesCumple);
                }
	    	})
	    	->where(function($query) use ($request){
	    		if($request->empEstado){
                    $e = $request->empEstado;
                    if($e == 'T' || $e == 'C'){
                        $query->whereIn('empEstado', ['A', 'B', 'S']);
                    }
                    if($e != 'C' || $e !=  'T'){    
	    			$query->where('empEstado',$request->empEstado);
                    }
                    
	    		}
                if($request->NoEmpleado){
                    $query->where('id',$request->NoEmpleado);
                }
	    	})
	    	->get();

            if($empleados->isEmpty()) {
                return false;
            }

            $recursos = [
                "empEstado" => $request->empEstado,
                "empleados" => $empleados
            ];

    	return $recursos;
    }//FIN function obtenerRecursos

    public function cumpleEmpleados($recursos){

    	// Unix
		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');

    	$datos = collect([]);
    	$fechaActual = Carbon::now("CDT");
    	$horaActual = $fechaActual->format("H:i:s");
        $empEstado = $recursos['empEstado']; 
        $empleados = $recursos['empleados'];

        //Obtener periodo Actual
        $departamento = $empleados->first()->escuela->departamento;
        $periodo = $departamento->periodoActual;

    	foreach ($empleados as $empleado) {
    		$empAp1 = $empleado->persona->perApellido1;
    		$empAp2 = $empleado->persona->perApellido2;
    		$empNom = $empleado->persona->perNombre;
    		$empEsc = $empleado->escuela->escClave;
    		$empFecNac = $empleado->persona->perFechaNac; #Nacimiento.
    		$empDia = Carbon::parse($empFecNac)->format('d'); #Dia Cumple
    		$empMes = Carbon::parse($empFecNac)->formatLocalized('%B'); #Mes Cumple

    		//variable para agrupar los Items
    		$ubiClave = $empleado->escuela->departamento->ubicacion->ubiClave;

    		//Establecer orden de Items
            $mesOrden = Carbon::parse($empFecNac)->format('m');
    		$empOrden = $ubiClave.$empEsc.$mesOrden.$empDia.$empAp1.$empAp2.$empNom;

            //Determinar si el empleado imparte clases actualmente
            $clase = Grupo::where('empleado_id',$empleado->id)
                          ->where('periodo_id', $periodo->id)
                          ->first();

    		$datos->push([
    			"empleado" => $empleado,
    			"empAp1" => $empAp1,
    			"empAp2" => $empAp2,
    			"empNom" => $empNom,
    			"empEsc" => $empEsc,
    			"empMes" => $empMes,
    			"empDia" => $empDia,
    			"ubiClave" => $ubiClave,
    			"empOrden" => $empOrden,
                "enClases" => $clase ? true : false
    		]);
    	}//FIN foreach empleados

        /*
        * Si Request estado es 'C' 
        * -> Enviar solo empleados activos en clases.
        */
        if($empEstado == 'C'){
            $datos = $datos->where('enClases', true);
        }

        if($datos->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay cumpleaños que cumplan con la información proporcionada.')->showConfirmButton();
            return back()->withInput();
        }

    	//Nombre del archivo PDF de descarga
    	$nombreArchivo = "pdf_cumple_empleados";
		//Cargar vista del PDF
		$pdf = PDF::loadView("reportes.pdf.pdf_cumple_empleados", [
		"datos" => $datos->sortBy('empOrden'),
        "perAnio" => $periodo->perAnio,
        "perNumero" => $periodo->perNumero,
      	"fechaActual" => $this->dateDMY($fechaActual),
      	"horaActual" => $horaActual,
      	"nombreArchivo" => $nombreArchivo.'.pdf'
    	]);
		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream($nombreArchivo.'.pdf');
		return $pdf->download($nombreArchivo.'.pdf');
    }//FIN function cumpleEmpleados

    public function imprimir(Request $request){
    	$recursos = $this->obtenerRecursos($request);

        if(!$recursos) {
            alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
            return back()->withInput();
        }
        
    	return $this->cumpleEmpleados($recursos);
    }
}//FIN class Controller

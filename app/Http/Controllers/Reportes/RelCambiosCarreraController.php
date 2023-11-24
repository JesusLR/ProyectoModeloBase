<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Curso;

use App\clases\personas\MetodosPersonas;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use PDF;
use DB;


class RelCambiosCarreraController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){

    	return view('reportes/rel_cambios_carrera.create',[
            'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    		]); 
    }//FIN function reporte

    public function dateDMY($fecha){
    	if($fecha){
    	$f = Carbon::parse($fecha)->format('d/m/Y');
    	return $f;
    	}
    }//FIN functiondateDMY

    public function obtenerRecursos($request){
    	$cursos = Curso::with('cgt.plan.programa.escuela','alumno.persona')
         ->where('periodo_id', $request->periodo_id)
    	 ->whereHas('cgt.plan.programa.escuela', static function($query) use($request){
            if($request->escuela_id) {
                $query->where('escuela_id', $request->escuela_id);
            }
            if($request->programa_id) {
                $query->where('programa_id', $request->programa_id);
            }
            if($request->plan_id) {
                $query->where('plan_id', $request->plan_id);
            }
	 		if($request->cgtGradoSemestre){
	 			$query->where('cgtGradoSemestre',$request->cgtGradoSemestre);
	 		}
	 		if($request->cgtGrupo){
	 			$query->where('cgtGrupo',$request->cgtGrupo);
	 		}
	 	 })
    	 ->whereHas('alumno.persona',function($query) use($request){
    	 	if($request->aluClave){
    	 		$query->where('aluClave', $request->aluClave);
    	 	}
    	 	if($request->aluMatricula){
    	 		$query->where('aluMatricula', $request->aluMatricula);
    	 	}
    	 	if($request->perApellido1){
    	 		$query->where('perApellido1', $request->perApellido1);
    	 	}
    	 	if($request->perApellido2){
    	 		$query->where('perApellido2', $request->perApellido2);
    	 	}
    	 	if($request->perNombre){
    	 		$query->where('perNombre', $request->perNombre);
    	 	}
    	 })
    	 ->get();


    	 $recursos = [
    	 	'cursos' => $cursos
    	 ];

    	 return $recursos;
    }//FIN function obtenerRecursos

    public function cambiosCarrera($recursos){
    	$datos = collect([]);
    	$cursos = $recursos['cursos'];

    	if($cursos->isEmpty()){
    		alert()->warning('Sin coincidencias','No existen registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$fechaActual = Carbon::now('CDT');
    	$horaActual = $fechaActual->format('H:i:s');

    	//Info de Periodo.
    	$curso1 = $cursos->first();
        $periodo = $curso1->periodo;
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;


    	foreach ($cursos as $key => $curso){

    		$ubiClave = $ubicacion->ubiClave;
    		$ubiNombre = $ubicacion->ubiNombre;
    		$depClave = $departamento->depClave;
    		$escClave = $curso->cgt->plan->programa->escuela->escClave;
    		$planId = $curso->cgt->plan->id;
    		$planClave = $curso->cgt->plan->planClave; #Año del Plan
    		$progClave = $curso->cgt->plan->programa->progClave;
    		$aluId = $curso->alumno->id;
    		$aluIng = $curso->curTipoIngreso;
    		$aluClave = $curso->alumno->aluClave;
            $nombreCompleto = MetodosPersonas::nombreCompleto($curso->alumno->persona, true);
    		$aluGrado = $curso->cgt->cgtGradoSemestre;
    		$aluGrupo = $curso->cgt->cgtGrupo;
    		$aluGG = $aluGrado.$aluGrupo;
    		//Variable para ordenar.
    		$aluOrden = $ubiClave.$escClave.$progClave.$aluGG.$nombreCompleto;

    		//resumen correspondiente al periodoBase en cuestión.
    		$resAct =  DB::table('resumenacademico')
    				->where('alumno_id',$aluId)
    				->where('plan_id',$planId)
    				->first();
    		$cambioCarr = false;

    		if($resAct){
	    		$resActFI = $resAct->resFechaIngreso;
	    		//resumenes anteriores.
	    		$resumenes = DB::table('resumenacademico')
	    				->where('alumno_id',$aluId)
	    				->where('resFechaIngreso','<',$resActFI)
	    				->orderByDesc('resFechaIngreso')
	    				->get();
	    		//Si existe registro, se busca el más reciente, para extraer datos.
	    		if(count($resumenes) > 0){
	    			$resAnt = $resumenes->first(); #Carrera Anterior.
	    			//Fecha de Egreso
	    			$resAntFE = $resAnt->resFechaEgreso;
	    			$perId2 = $resAnt->resPeriodoUltimo;
	    			$per2 = Periodo::where('id',$perId2)->first();
	    			$perNum2 = $per2->perNumero;
	    			$perAnio2 = $per2->perAnio;
	    			//Info Carrera Anterior.
	    			$planAntId = $resAnt->plan_id;
	    			$planAnt = Plan::where('id',$planAntId)->first();
	    			$planClave2 = $planAnt->planClave; #Año del Plan
	    			$depClave2 = $planAnt->programa->escuela->departamento->depClave;
	    			$progClave2 = $planAnt->programa->progClave;

	    			/*
	    			* -> Si el alumno tiene fecha de egreso, no cuenta como cambio 
	    			*    de carrera.
	    			* -> Si el alumno cambió de Departamento, no cuenta como cambio
	    			*    de carrera.
	    			*/
	    			if(!$resAntFE && $depClave == $depClave2){
	    				if($aluIng == 'EQ'){
	    					$cambioCarr = true;
	    				}
	    			}

	    			$datos->push([
	    				'ubiClave' => $ubiClave,
	    				'ubiNombre' => $ubiNombre,
	    				'progClave' => $progClave,
	    				'progAct' => $progClave.'  '.$planClave,
	    				'aluClave' => $aluClave,
	    				//Nombre Completo.
	    				'aluCom' => $nombreCompleto,
	    				'aluGrado' => $aluGrado,
	    				'aluGrupo' => $aluGrupo,
	    				'alluGG' => $aluGG,
	    				'aluIng' => $aluIng,
	    				'progAnt' => $progClave2.'  '.$planClave2,
	    				'per2' => $perNum2.'/'.$perAnio2,
	    				'aluOrden' => $aluOrden,
	    				'cambioCarr' => $cambioCarr
	    			]);
	    		}//FIN if count(resumenes)
    		}//FIN if resAct
    	}//FIN foreach cursosIds

        if($datos->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay cambios de carrera que coincidan con la información del filtro.')->showConfirmButton();
            return back()->withInput();
        }

    	//Ordenar y enviar solo los que cabiaron de carrera.
        $cambiosCarrera = $datos->where('cambioCarr', true);
        if($cambiosCarrera->isEmpty()) {
            alert()->warning('No hay Cambios', 'No se encontraron casos de cambios de carrera que cumplan con los criterios de búsqueda.')->showConfirmButton();
            return back()->withInput();
        }

        $datos = $cambiosCarrera->sortBy('aluOrden')->groupBy('progClave');

    	// Unix
		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');
    	//Nombre del archivo PDF de descarga
    	$nombreArchivo = "pdf_rel_cambios_carrera.pdf";
		//Cargar vista del PDF
		$pdf = PDF::loadView("reportes.pdf.pdf_rel_cambios_carrera", [
		"datos" => $datos,
      	"fechaActual" => $this->dateDMY($fechaActual),
      	"horaActual" => $horaActual,
      	"anioActual" => $fechaActual->format('Y'),
      	"perFechaInicial" => $this->dateDMY($periodo->perFechaInicial),
      	"perFechaFinal" => $this->dateDMY($periodo->perFechaFinal),
      	"perAct" => $periodo->perNumero.'/'.$periodo->perAnio,
      	"nombreArchivo" => $nombreArchivo
    	]);
		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream($nombreArchivo);
		return $pdf->download($nombreArchivo);
    }//FIN function cambiosCarrera

    public function imprimir(Request $request){
    	$recursos = $this->obtenerRecursos($request);
    	return $this->cambiosCarrera($recursos);
    }//FIN function imprimir
}//FIN Controller class

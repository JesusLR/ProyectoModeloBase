<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\Http\Models\Grupo;
use App\Http\Models\Inscrito;
use App\clases\personas\MetodosPersonas;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PosiblesEgresadosController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){
    	$anioActual = Carbon::now();
    	return view('reportes/rel_pos_egresados.create',[
    		// 'anioActual' => $anioActual
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
        $agrupacion = 'escClave';
    	$cursos = Curso::with('cgt.plan.programa.escuela', 'alumno.persona')
    	  ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', static function($query) use($request, $agrupacion){
            $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id) {
                $query->where('programa_id', $request->programa_id);
                $agrupacion = 'progClave';
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
    	  ->whereHas('alumno.persona', static function($query) use($request){
    	  	if($request->aluClave){
    	  		$query->where('aluClave',$request->aluClave);
    	  	}
    	  	if($request->aluMatricula){
    	  		$query->where('aluMatricula',$request->aluMatricula);
    	  	}
    	  	if($request->perApellido1){
    	  		$query->where('perApellido1',$request->perApellido1);
    	  	}
    	  	if($request->perApellido2){
    	  		$query->where('perApellido2',$request->perApellido2);
    	  	}
    	  	if($request->perNombre){
    	  		$query->where('perNombre',$request->perNombre);
    	  	}
    	  })
          ->where('periodo_id', $request->periodo_id)
    	  ->get();

          if($cursos->isEmpty()) {
            return false;
          }

          $recursos = [
            'cursos' => $cursos,
            'agrupacion' => $agrupacion
          ];
    	  return $recursos;
    }//FIN function obtenerRecursos

    public function posiblesEgresados($recursos){

    	$datos = collect([]);
    	$cursos = $recursos['cursos'];
        if(count($cursos) == 0){
            alert()->error('Error', 'No existen registros con la información proporcionada')->showConfirmButton();
            return back()->withInput();
        }
        $agrupacion = $recursos['agrupacion'];
    	$fechaActual = Carbon::now('CDT');
    	$horaActual = $fechaActual->format('H:i:s');

        //Info de Periodo
        $curso1 = $cursos->first();
        $periodo = $curso1->periodo;
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;

    	foreach ($cursos as $key => $curso) {

            $ubiClave = $ubicacion->ubiClave;
            $ubiNombre = $ubicacion->ubiNombre;
            $escClave = $curso->cgt->plan->programa->escuela->escClave;
            $progClave = $curso->cgt->plan->programa->progClave;
            $progNombre = $curso->cgt->plan->programa->progNombre;
            $planClave =  $curso->cgt->plan->planClave;
            $planId = $curso->cgt->plan->id;
            $aluId = $curso->alumno->id;
            $aluIns = $curso->curTipoIngreso; #Tipo de Inscripción
            $aluClave = $curso->alumno->aluClave;
            $aluMatricula = $curso->alumno->aluMatricula;
            $nombreCompleto = MetodosPersonas::nombreCompleto($curso->alumno->persona, true);
            $aluGrado = $curso->cgt->cgtGradoSemestre;
            $aluGrupo = $curso->cgt->cgtGrupo;
            $aluGG = $aluGrado.$aluGrupo;
            //Variable para orden de Items.
            $aluOrden = $ubiClave.$escClave.$progClave.$aluGG.$nombreCompleto;

            //Total de créditos del Plan.
            $planCred = $curso->cgt->plan->planNumCreditos;
            //Calificación mínima aprobatoria del Departamento.
            $calMin = $curso->cgt->plan->programa->escuela->departamento->depCalMinAprob;
            if($aluGrado > 1 && $aluIns != 'EQ'){
                //Resumen académico del Alumno en el Plan.
                $resumen = DB::table('resumenacademico')->where('alumno_id',$aluId)
                        ->where('plan_id',$planId)
                        ->first();
                if($resumen){
                $crApr = $resumen->resCreditosAprobados;
                //Créditos Faltantes.
                $crFal = $planCred - $crApr;
                //créditos del curso.
                $gruposIds = Inscrito::where('curso_id',$curso->id)
                        ->pluck('grupo_id');
                $crCur = 0;
                $posEgresado = false;
                foreach ($gruposIds as $key => $grupo_id){
                    $grupo = Grupo::where('id',$grupo_id)->first();
                    $matCred = $grupo->materia->matCreditos;
                    $crCur = $crCur + $matCred;
                }

                /*
                * Determinar si el alumno es posible Egresado
                * -> 5 créditos de tolerancia, tomando en cuenta los créditos
                *    del curso en cuestión.
                */
                $crTolerancia = $crFal - $crCur;
                if($crTolerancia <= 5){
                    $posEgresado = true;
                }

                $datos->push([
                    'ubiClave' => $ubiClave,
                    'ubiNombre' => $ubiNombre,
                    'progClave' => $progClave,
                    'progNombre' => $progNombre,
                    'planClave' => $planClave,
                    'aluClave' => $aluClave,
                    'aluMatricula' => $aluMatricula,
                    'aluComp' => $nombreCompleto,
                    'aluGrado' => $aluGrado,
                    'aluGrupo' => $aluGrupo,
                    'aluGG' => $aluGG,
                    'aluOrden' => $aluOrden,
                    'planCred' => $planCred,
                    'calMin' => $calMin,
                    'crApr' => $crApr,
                    'crFal' => $crFal,
                    'crCur' => $crCur,
                    'posEgresado' =>$posEgresado
                ]);
                }//FIN if resumen
            }//FIN if aluGrado
        }//FIN foreach cursosIds

        $posEgresados = $datos->where('posEgresado',true);
        if($posEgresados->isEmpty()) {
            alert()->warning('No hay Egresados', 'No hay posibles egresados que coincidan con este filtro.')->showConfirmButton();
            return back()->withInput();
        }
        $datos = $posEgresados->sortBy('aluOrden');

        if($agrupacion == 'escClave'){
            $datos = $datos->groupBy($agrupacion);
            foreach ($datos as $escuela) {
                $carreras = $escuela->groupBy('progClave');
                foreach ($carreras as $carrera) {
                    $datos = $carrera->groupBy('aluGG');
                }
            }
        }//if escClave
        elseif ($agrupacion == 'progClave'){
            $carreras = $datos->groupBy($agrupacion);
            foreach($carreras as $carrera){
                $datos = $carrera->groupBy('aluGG');
            }
        }//elseif progClave

    	// Unix
		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');
    	//Nombre del archivo PDF de descarga
    	$nombreArchivo = "pdf_rel_pos_egre.pdf";
		//Cargar vista del PDF
		$pdf = PDF::loadView("reportes.pdf.pdf_rel_pos_egre", [
		"grupos" => $datos,
        "agrupacion" => $agrupacion,
      	"fechaActual" => $this->dateDMY($fechaActual),
      	"horaActual" => $horaActual,
      	"anioActual" => $fechaActual->format('Y'),
      	"perFechaInicial" => $this->dateDMY($periodo->perFechaInicial),
      	"perFechaFinal" => $this->dateDMY($periodo->perFechaFinal),
      	"nombreArchivo" => $nombreArchivo
    	]);
		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream($nombreArchivo);
		return $pdf->download($nombreArchivo);
    }//FIN function posiblesEgresados

    public function imprimir(Request $request){
    	$recursos = $this->obtenerRecursos($request);

        if(!$recursos) {
            alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
            return back()->withInput();
        }
        
    	return $this->posiblesEgresados($recursos);
    }//FIN function imprimir
}//FIN Controller class

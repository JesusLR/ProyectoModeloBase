<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

use App\Http\Models\Curso;
use App\Http\Models\Historico;
use App\Http\Models\Minutario;
use App\Http\Models\Firmante;
use App\Http\Models\Ubicacion;

use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use PDF;
use DB;

use App\clases\periodos\MetodosPeriodos;
use App\clases\cgts\MetodosCgt;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\Utils;

class SolicitudBecaController extends Controller
{
    //
    public function __contruct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_constancia_inscripcion');
    }

    public function reporte(){
    	$fechaActual = Carbon::now('CDT')->year;
    	$opciones = [
    		1 => 'Último periodo',
    		2 => 'Últimos 2 periodos'
    	];
        $ubicaciones = Ubicacion::where('ubiClave','<>','000')->get();
        $firmantes = Firmante::all(); 
    	return view('reportes/constancia_solicitud_beca.create',
    		compact('fechaActual','opciones','ubicaciones','firmantes'));
    }// function reporte.

    public function getResources($request){

        $tipoConstancia = null;
        $firmante = null;
        if($request->tipoConstancia){
            $tipoConstancia = $request->tipoConstancia;
        }
    	$curso = Curso::with('periodo.departamento.ubicacion','cgt.plan.programa','alumno.persona')
    		->whereHas('periodo.departamento',function($query) use($request){
    			if($request->perAnio){
    				$query->where('perAnio',$request->perAnio);
    			}
    			if($request->perNumero){
    				$query->where('perNumero',$request->perNumero);
    			}
    			if($request->depClave){
    				$query->where('depClave',$request->depClave);
    			}
                if($request->ubicaciones){
                    $query->where('ubicacion_id','=',$request->ubicaciones);
                }
    		})
    		->whereHas('cgt.plan.programa',function($query) use($request){
    			if($request->cgtGradoSemestre){
    				$query->where('cgtGradoSemestre',$request->cgtGradoSemestre);
    			}
    			if($request->cgtGrupo){
    				$query->where('cgtGrupo',$request->cgtGrupo);
    			}
    			if($request->progClave){
    				$query->where('progClave',$request->progClave);
    			}
    		})
    		->whereHas('alumno.persona',function($query) use($request){
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
    		->where('curEstado','<>','B') #Excluir alumno dado de baja en curso.
    		->first();

            if($request->firmante){
                $firmante = Firmante::find($request->firmante);
            }

            $recursos = [
                'curso' => $curso,
                'firmante' => $firmante,
                'tipoConstancia' => $tipoConstancia
            ];

    		return $recursos;
    }// function getResources.

    public function solicitarBeca($recursos){

    	$datos = collect([]);
    	$fechaActual = Carbon::now('America/Merida');
    	$curso = $recursos['curso'];
        $firmante = $recursos['firmante'];
        $tipoConstancia = $recursos['tipoConstancia'];
    	if(!$curso){
    		alert()->warning('Ups..','No se encontraron registros con la información
    			proporcionada. Favor de verificar.');
    		return back()->withInput();
    	}

    	$periodo = $curso->periodo;
    	$perAnteriores = MetodosPeriodos::buscarAnteriores($periodo,$periodo->perEstado)
    		->get();

    	$alumno = $curso->alumno;
    	$plan_id = $curso->cgt->plan->id;
    	$periodosIds = $perAnteriores->pluck('id');
    	$historicos = Historico::where('alumno_id',$alumno->id)
    		->where('histPeriodoAcreditacion','<>','RV')
    		->whereIn('periodo_id',$periodosIds)
            ->latest('histFechaExamen')
            ->get()
            ->unique('materia_id');

    	/*
    	* Obtener solo el 'id' de los 2 últimos
    	* periodos en los que el alumno tiene históricos.
    	*/
    	$periodos = $historicos->unique('periodo_id')
    		->sortByDesc(function($item,$key){
    			return $item->periodo->perFechaInicial;
    		})
    		->map(function($item,$key){
    			return $item->periodo;
    		})
    		->take(2)->pluck('id');
    	$historicos = $historicos->whereIn('periodo_id',$periodos)
            ->sortByDesc(function($item,$key){
                return $item->periodo->perFechaInicial;
            })
    		->groupBy('periodo_id');

    	DB::beginTransaction();
    	try {
    		$minutario = new Minutario;
    		$minutario->minAnio = $fechaActual->year;
    		$minutario->minClavePago = $alumno->aluClave;
    		$minutario->minDepartamento = $periodo->departamento->depClave;
    		$minutario->minTipo = 'CB';
    		$minutario->minFecha = $fechaActual->format('Y-m-d');
    		$minutario->usuario_at = auth()->user()->id;
    		$minutario->save();
    	} catch (\Exception $e) {
    		DB::rollback();
    		alert()->error('Error','Ha ocurrido un error durante el proceso.
    			Favor de intentarlo nuevamente.');
    		throw $e;
    		return back()->withInput();
    	}

    	DB::commit(); #TEST.

    	// Generar datos para el PDF.
    	$municipio = $periodo->departamento->ubicacion->municipio;

    	//Datos del Docente del Departamento.
    	$depClaveOficial = $periodo->departamento->depClaveOficial;

    	//Info del Alumno.
        $nombreCompleto = MetodosPersonas::nombreCompleto($alumno->persona, true);

    	//Info de Carrera.
    	$semestre = MetodosCgt::semestreALetras($curso->cgt->cgtGradoSemestre);
    	$progNombre = $curso->cgt->plan->programa->progNombre;

        if($tipoConstancia == 1){
            $historicos = $historicos->take(1);
        }

        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_solicitud_beca.pdf";
        //Cargar vista del PDF
        return PDF::loadView("reportes.pdf.pdf_solicitud_beca",[
        "minutario" => $minutario,
        "alumno" => $alumno,
        "persona" => $alumno->persona,
        "firmante" => $firmante,
        "depClaveOficial" => $depClaveOficial,
        "nombreCompleto" => $nombreCompleto,
        "semestre" => $semestre,
        "progNombre" => $progNombre,
        "periodo" => $periodo,
        "historicos" => $historicos,
        "municipio" => $municipio,
        "fechaActual" => $fechaActual,
        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo);

    }// function solicitarBeca.

    public function imprimir(Request $request){
    	$recursos = $this->getResources($request);
    	return $this->solicitarBeca($recursos);
    }// function imprimir.

    public function getFirmantes($ubicacion_id){

        $firmante = Firmante::where('ubicacion_id',$ubicacion_id)->pluck('firNombre','id');
        return json_encode($firmante);
    }// function getFirmantes.

}//FIN Controller class

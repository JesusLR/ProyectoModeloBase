<?php

namespace App\Http\Controllers\Bachiller;

use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_grupos;
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Http\Models\Bachiller\Bachiller_resumenacademico;
use App\clases\SCEM\Mailer as ScemMailer;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_calendarioexamen;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;
use Validator;

class BachillerCierreActasUADYController extends Controller
{
	public $ubicacion;
	//
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function dateDMY($fecha)
	{
		if ($fecha) {
			$f = Carbon::parse($fecha)->format('d/m/Y');
			return $f;
		}
	} //FIN function dateDMY
	public function dateYMD($fecha)
	{
		$f = null;
		if ($fecha) {
			$f = Carbon::parse($fecha)->format('Y-m-d');
		}
		return $f;
	} //FIN function dateYMD

	public function filtro()
	{
		$fechaActual = Carbon::now('America/Merida');
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

		return view('bachiller.cierre_actas.create', compact('fechaActual', 'ubicaciones'));
	} //FIN function filtro.

	public function cierreActas(Request $request)
	{

		DB::select("call procBachillerCambiarEstadoGrupoCalificado(".$request->periodo_id.")");

		$bachiller_calendario = Bachiller_calendarioexamen::where('plan_id', $request->plan_id)
		->where('periodo_id', $request->periodo_id)
		->first();
		
		$bachiller_grupos_a = Bachiller_grupos::select('bachiller_grupos.*')
		->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
		->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
		->where('bachiller_grupos.periodo_id', $request->periodo_id)
		->where('bachiller_grupos.plan_id', $request->plan_id)
		->where('bachiller_grupos.estado_act', 'A')
		->where(function ($query) use ($request) {
			if ($request->gpoSemestre) {
				$query->where('bachiller_grupos.gpoGrado', $request->gpoSemestre);
			}
			if ($request->gpoClave) {
				$query->where('bachiller_grupos.gpoClave', $request->gpoClave);
			}

			// materias 
			if ($request->gpoClave) {
				$query->where('bachiller_materias.matClave', $request->matClave);
			}

			// empleado 
			if($request->empleado_id){
				$query->where('bachiller_empleados.id', $request->empleado_id);
			}
			
		})  
		->whereNull('bachiller_grupos.deleted_at')
		->get();

		
		$bachiller_grupos_33 = Bachiller_grupos::select('bachiller_grupos.*')
		->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
		->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
		->where('bachiller_grupos.periodo_id', $request->periodo_id)
		->where('bachiller_grupos.plan_id', $request->plan_id)		
		->where('bachiller_grupos.estado_act', '!=', 'C')
		->where(function ($query) use ($request) {
			if ($request->gpoSemestre) {
				$query->where('bachiller_grupos.gpoGrado', $request->gpoSemestre);
			}
			if ($request->gpoClave) {
				$query->where('bachiller_grupos.gpoClave', $request->gpoClave);
			}

			// materias 
			if ($request->gpoClave) {
				$query->where('bachiller_materias.matClave', $request->matClave);
			}

			// empleado 
			if($request->empleado_id){
				$query->where('bachiller_empleados.id', $request->empleado_id);
			}
			
		})  
		->whereNull('bachiller_grupos.deleted_at')
		->get();

		if(count($bachiller_grupos_a) > 0){


			foreach($bachiller_grupos_a as $buscando){
				$inscritos = Bachiller_inscritos::where('bachiller_grupo_id', $buscando->id)->whereNull('deleted_at')->get();

				if(count($inscritos) > 0){
					alert()->warning('Ups...', 'No se puede proceder con el cierre debido que cuenta con '.count($bachiller_grupos_a).' grupos los cuales aun no se han termiando de capturar las evidencias')->showConfirmButton();
					return back()->withInput();
				}
			}

			
		}


		if(count($bachiller_grupos_33) > 0){
			foreach($bachiller_grupos_33 as $fecha_validacion){
				if($fecha_validacion->gpoFechaExamenOrdinario == ""
				|| $fecha_validacion->gpoFechaExamenOrdinario < $bachiller_calendario->calexInicioOrdinario
				|| $fecha_validacion->gpoFechaExamenOrdinario > $bachiller_calendario->calexFinOrdinario){

					alert()->warning('Ups...', 'No se puede proceder con el cierre debido que la fecha de ordinario no escorrecto')->showConfirmButton();
					return back()->withInput();
				}
			}
		}

		$fechaActual = Carbon::now('America/Merida')->format('d/m/Y');
		/*
    	* Especificar reglas de validación para los inputs.
    	*/
		$messages = [
			
			'gpoFechaExamenOrdinario.date_format' => 'El formato de fecha debe ser
    							día/mes/año,
                              ejemplo: ' . $fechaActual . '.
                              Revisar el campo Fecha de Ordinario.'
		];
        
		$validator = Validator::make($request->all(), [
			'ubicacion_id' => 'required',
			'departamento_id' => 'required',
			'escuela_id' => 'required',
			'gpoFechaExamenOrdinario' => 'date_format:d/m/Y|nullable',

		], $messages);

		if ($validator->fails()) {
			return redirect('bachiller_cierre_actas')
				->withErrors($validator)
				->withInput();
		}

		$grupos = Bachiller_grupos::with(
			'periodo',
			'plan.programa.escuela.departamento.ubicacion',
			'bachiller_empleado',
			'bachiller_materia'
		)
			->whereHas('periodo', function ($query) use ($request) {
				if ($request->periodo_id) {
					$query->where('id', $request->periodo_id);
				}
			})
			->whereHas('plan.programa.escuela.departamento.ubicacion', function ($query) use ($request) {
				if ($request->ubicacion_id) {
					$query->where('id', $request->ubicacion_id);
				}
			})

            ->whereHas('plan.programa.escuela.departamento', function ($query) use ($request) {
				
				if ($request->departamento_id) {
					$query->where('id', $request->departamento_id);
				}
			})

            ->whereHas('plan.programa.escuela', function ($query) use ($request) {
			
				if ($request->escuela_id) {
					$query->where('id', $request->escuela_id);
				}
			})
            ->whereHas('plan.programa', function ($query) use ($request) {			
				
				if ($request->programa_id) {
					$query->where('id', $request->programa_id);
				}
			})
            ->whereHas('plan', function ($query) use ($request) {			
				
				if ($request->plan_id) {
					$query->where('id', $request->plan_id);
				}
			})
			->whereHas('bachiller_materia', function ($query) use ($request) {
				if ($request->matClave) {
					$query->where('matClave', $request->matClave);
				}
			})
			->whereHas('bachiller_empleado', function ($query) use ($request) {
				if ($request->empleado_id) {
					$query->where('id', $request->empleado_id);
				}
			})
			->where(function ($query) use ($request) {
				if ($request->gpoSemestre) {
					$query->where('gpoGrado', $request->gpoSemestre);
				}
				if ($request->gpoClave) {
					$query->where('gpoClave', $request->gpoClave);
				}
				// if ($request->gpoFechaExamenOrdinario) {
				// 	$gpoFechaOrd = $this->dateYMD($request->gpoFechaExamenOrdinario);
				// 	$query->where('gpoFechaExamenOrdinario', '=', $gpoFechaOrd);
				// }
				$query->where('estado_act', '=', 'B'); #TEST.
				$query->whereNull('deleted_at'); #TEST.

			})            
			->get();
            

        // $bachiller_materia_id = $grupos->groupBy('bachiller_materia_id');
		


        foreach($grupos as $gr){
            DB::update("UPDATE bachiller_grupos SET estado_act = 'C' WHERE id= $gr->id");
        }

		$tGpos = count($grupos); #Total de grupos.
		if ($tGpos < 1) {
			alert()->warning('Ups... Sin coincidencias', 'No se encuentran datos con la
    			información proporcionada, favor de verificar.')->showConfirmButton();
			return back()->withInput();
		}

		$this->ubicacion = Ubicacion::find($request->ubicacion_id);

           
		/*
    	* Datos del alumno.
    	*/
		$datos = collect([]);
		$actas_pendientes = new Collection;
		$actCerradas = 0;
		DB::beginTransaction();
		for ($i = 0; $i < $tGpos; $i++) {
			$grupo = $grupos->get($i);
			$plan_id = $grupo->plan_id;
			$materia_id = $grupo->bachiller_materia_id;
            // $materia_id = $bachiller_materia_id->keys()[$i];

			$periodo_id = $grupo->periodo_id;

			$histNombreOficial = null;
			$histComplementoNombre = null;
			if ($grupo->optativa_id) {
				$histNombreOficial = ucwords($grupo->optativa->optNombre);
				$histComplementoNombre  = strtoupper($histNombreOficial);
			}

			$inscritos = $grupo->bachiller_inscrito()->whereNull('deleted_at')->get();
			$inscritoIds = $inscritos->map(function ($item, $key) {
				return $item->id;
			});
			// $calificaciones = Calificacion::whereIn("inscrito_id", $inscritoIds)->get();
            // $calificaciones = Bachiller_inscritos_evidencias::whereIn("bachiller_inscrito_id", $inscritoIds)->get();
            $calificaciones = Bachiller_inscritos::select('bachiller_inscritos.*')
			->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
			->whereIn("bachiller_inscritos.id", $inscritoIds)
			->where("cursos.curEstado", "!=", "B")
			->whereNull('bachiller_inscritos.deleted_at')
			->whereNull('cursos.deleted_at')
			->get();




			$califFinalVacia = false;
			foreach ($calificaciones as $calificacion) {
				if (is_null($calificacion->insPuntosObtenidosFinal)) {
					$califFinalVacia = true;
				}
			}


			if ($califFinalVacia) {
				$actas_pendientes->push($grupo);

			} else {

				$tins = count($inscritos); #Total de Inscritos.
				for ($x = 0; $x < $tins; $x++) {
					$inscrito = $inscritos->get($x);
					$curso  = $inscrito->curso;
					$alumno = $curso->alumno;
					$tipoIng = $curso->curTipoIngreso;
					$cgt = $curso->cgt;
					$bachiller_grupo = $inscrito->bachiller_grupo;
					$calificaciones = $inscrito;
					$cgtGrupo = $cgt->cgtGrupo; //parametro de busqueda
                    // return $calificaciones = $inscrito->calificacion()->first();

                   $bachiller_inscrito = Bachiller_inscritos::select(DB::raw("SUM(bachiller_inscritos.insPuntosObtenidosFinal) as insPuntosObtenidosFinal"))
                    ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                    ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
					->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                    ->where('cursos.alumno_id', '=', $curso->alumno_id)
                    ->where('bachiller_grupos.bachiller_materia_id', '=', $materia_id)
					->where('bachiller_grupos.periodo_id', '=', $curso->periodo_id)
					->where('bachiller_grupos.gpoGrado', $bachiller_grupo->gpoGrado)
					->where('cgt.cgtGrupo', $cgtGrupo)
					->whereNull('bachiller_inscritos.deleted_at')
					->whereNull('cursos.deleted_at')
					->whereNull('bachiller_grupos.deleted_at')
                    ->first();

                  
					/*
						* Si curTipoIngreso = 'OY' (oyente)  No realizan las siguientes acciones.
						* -> Historico-> tipoAcreditacion por defecto es 'CI'.
						* -> Si Curso-> curTipoIngreso = 'RO' (Recursando)
						*    -> Historico-> tipoAcreditacion se registra como 'CR'.
						*/
					if ($tipoIng != 'OY') { #if_tipoIng.
						$tipoAcreditacion = 'CI';
						if ($tipoIng == 'RO') {
							$tipoAcreditacion = 'CR';
						}

                        $fechaHora = Carbon::now('America/Merida')->format('Y-m-d H:i:s');
						try {

							// $consulta = DB::select("SELECT * FROM bachiller_historico WHERE alumno_id=$alumno->id AND plan_id=$cgt->plan_id AND bachiller_materia_id=$materia_id AND periodo_id=$curso->periodo_id");

							$consulta = DB::table('bachiller_historico')
							->where('alumno_id', $alumno->id)
							->where('plan_id', $cgt->plan_id)
							->where('bachiller_materia_id', $materia_id)
							->where('periodo_id', $curso->periodo_id)
							->where('histTipoAcreditacion', '=', 'CI')
							->whereNull('deleted_at')
							->exists();

							if(!$consulta){
								$nvoHist = new Bachiller_historico();
								$nvoHist->alumno_id = $alumno->id;
								$nvoHist->plan_id = $plan_id;
								$nvoHist->bachiller_materia_id = $materia_id;
								$nvoHist->periodo_id = $periodo_id;
								$nvoHist->histComplementoNombre = $histComplementoNombre;
								$nvoHist->histPeriodoAcreditacion = 'PN';
								$nvoHist->histTipoAcreditacion = $tipoAcreditacion;
								$nvoHist->histFechaExamen = $grupo->gpoFechaExamenOrdinario;
								$nvoHist->histCalificacion = $bachiller_inscrito->insPuntosObtenidosFinal;
								$nvoHist->histFolio = null;
								$nvoHist->hisActa = null;
								$nvoHist->histLibro = null;
								$nvoHist->histNombreOficial = $histNombreOficial;
								$nvoHist->created_at = $fechaHora;
								$alumno->bachiller_historico()->save($nvoHist); #TEST funciona.

								/*
								* Se modifica el registro de $inscrito.
								* -> Se le agrega el historico_id
								*/

								// obtenemos el registro nuevo 
								$consulta2 = Bachiller_historico::select('bachiller_historico.*')
								->where('alumno_id', $alumno->id)
								->where('plan_id', $cgt->plan_id)
								->where('bachiller_materia_id', $materia_id)
								->where('periodo_id', $curso->periodo_id)
								->first();

								// obtenemos el inscrito acd de la misma materia 
								$consulta3 = Bachiller_inscritos::select('bachiller_inscritos.id', 'bachiller_inscritos.preparatoria_historico_id')
								->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
								->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
								->where('cursos.alumno_id', $consulta2->alumno_id)
								->where('bachiller_grupos.plan_id', $consulta2->plan_id)
								->where('bachiller_grupos.bachiller_materia_id', $consulta2->bachiller_materia_id)
								->where('bachiller_grupos.periodo_id', $consulta2->periodo_id)
								->get();

								// actualizamos el id de historico con los inscritos obtenidos 
								foreach($consulta3 as $insc){
									DB::update("UPDATE bachiller_inscritos SET preparatoria_historico_id=$nvoHist->id WHERE id=$insc->id");
								}

								

								// $inscrito->preparatoria_historico_id = $nvoHist->id;
								// $inscrito->save(); #TEST funciona.
								
							}

							

						} catch (\Exception $e) {
							DB::rollBack();
							alert()->error('Error', 'Ocurrió un problema durante
									el registro');
							throw $e;
						}

						/*
							* Se almacena la información académica del alumno.
							* para buscar su resumen académico y hacer los cálculos
							* de promedio, créditos, etc.
							*/
						if (!$datos->contains('alumno_id', $alumno->id)) {
							$datos->push([
								'alumno_id' => $alumno->id,
								'inscrito' => $inscrito,
								'plan' => $grupo->plan,
							]);
						}
					} //FIN if_tipoIng.

				} //FIN for $tins

				//Cerrar grupo.
				try {
					$grupo->estado_act = 'C';
					if ($grupo->save()) { #TEST
						$actCerradas++;
					}
				} catch (\Exception $e) {
					DB::rollBack();
					throw $e;
				}
			}
		} //FIN for $tGpos.

		/* ---------------------------------------------------------------------------------- */

		//INICIA PROCESO DE ACTUALIZACIÓN DE RESUMEN ACADÉMICO.

		/*
    	* -> Extraer los Ids de los alumnos.
    	* -> Buscar los históricos y resúmenes académicos de los alumnos.
    	*/
		$aluIds = $datos->pluck('alumno_id');
		$histData = Bachiller_historico::whereIn('alumno_id', $aluIds)
			->get();
		$resacaData = Bachiller_resumenacademico::whereIn('alumno_id', $aluIds)
			->get();

		/*
    	* Por cada alumno.
    	* procesar y actualizar datos de su resumenacadémico.
    	*/

		foreach ($datos as $key => $alumno) {
			$issues = collect([]); #almacenaará incidencias, en caso de existir.
			$hasIssue = false;
			$alu_id = $alumno['alumno_id'];
			$plan = $alumno['plan'];
			$inscrito = $alumno['inscrito'];
			$alu = $inscrito->curso->alumno;
			$grupo = $inscrito->bachiller_grupo;
			$aluDep = $plan->programa->escuela->departamento;
			$calMin = $aluDep->depCalMinAprob;
			// $materia = $grupo->bachiller_materia_id;
			// $periodoID = $inscrito->curso->periodo_id;	
			
			/*
    		* -> Obtener Historicos del alumno y borrarlos de $histData.
    		* -> filtrar por históricos pertenecientes al plan actual.
    		*/
			$histAlumno = $histData->filter(function ($value, $key)
			use ($alu_id, $histData, $plan) {
				if ($value->alumno_id == $alu_id) { //Aqui modifique por el resumen academico se agrega && $value->periodo_id == $periodoID
					$a = $histData->pull($key);
					return $a->plan_id == $plan->id;
				}
			});

			/*
    		* -> Traer primer historico, para obtener periodo_id,
    		* -> Obtener el primer curso.
    		* (Se requerirá esta información en caso de crear
    		*  ResumenAcademico).
    		*/
			$hist1 = $histAlumno->sortBy('histFechaExamen')
				->first();
			$cur1 = $inscrito->curso->alumno->cursos()
				->where('periodo_id', $hist1->periodo_id)->first();
			if (!$cur1) {
				$issueLine = __LINE__;
				$issueFile = __FILE__;
				$issueDetail = 'No se pudo encontrar el primer curso del alumno.';
				$fechai = Carbon::now('CDT')->format('Y-m-d');
				$hasIssue = true;
				/*
    			* Si no encuentra el primer curso del alumno.
    			* No podrá crear resumenAcademico en caso de requerirse.
    			* -> Se registra tal incidencia en la tabla cierreactaslog.
    			*/
				$issues->push([
					'issueLine' => $issueLine,
					'issueFile' => $issueFile,
					'issueDetail' => $issueDetail,
					'fechai' => $fechai
				]);
			}

			/*
    		* Traer solo el registro más reciente por materia cursada.
    		* -> Separar por materias tipo 'N' y tipo 'A'.
    		*/
			$matCursadas = $histAlumno->sortByDesc('histFechaExamen')
				->unique('bachiller_materia_id');
			$materiasN = $matCursadas->filter(function ($value, $key) {
				return $value->bachiller_materia->matTipoAcreditacion == 'N';
			});
			$materiasA = $matCursadas->filter(function ($value, $key) {
				return $value->bachiller_materia->matTipoAcreditacion == 'A';
			});

			//Obtener Créditos Cursados.
			$resCreditosCursados = $matCursadas->sum(function ($item) {
				return $item->bachiller_materia->matCreditos;
			});

			/*
	    	* Créditos Aprobados.
	    	* -> Obtener créditos de materias tipo 'N'.
	    	* -> Obtener créditos de materias tipo 'A'.
	    	* -> Sumar.
	    	*/
			$credAprobN = $materiasN->where('histCalificacion', '>=', $calMin)
				->sum(function ($item) {
					return $item->bachiller_materia->matCreditos;
				});
			$credAprobA = $materiasA->where('histCalificacion', 0)
				->sum(function ($item) {
					return $item->bachiller_materia->matCreditos;
				});
			$resCreditosAprobados = $credAprobA + $credAprobN;

			/*
	    	* Promedio Acumulado.
	    	* -> Solo se promedia con materias tipo 'N'.
			*/
			$materiasN = $materiasN->map(function ($item, $key) {
				if ($item->histCalificacion < 0) {
					$item->histCalificacion = 0;
				}
				return $item;
			});
			$resPromedioAcumulado = $materiasN->avg('histCalificacion');
			$resPromedioAcumulado = number_format($resPromedioAcumulado, 4);

			/*
			* Avance Acumulado.
			*/
			$planCreditos = $plan->planNumCreditos;
			$resAvanceAcumulado = ($resCreditosAprobados / $planCreditos) * 100;
			$resAvanceAcumulado = number_format($resAvanceAcumulado, 2);

			/*
			* Obtener y modificar el resumen académico del alumno.
			*/
			$resumen = $resacaData->filter(function ($value, $key)
			use ($alu_id, $resacaData, $plan) {
				if ($value->alumno_id == $alu_id) {
					$a = $resacaData->pull($key);
					return $a->plan_id == $plan->id;
				}
			})->first();

			if ($resumen) {
				//Modificar resumen.
				$resumen->resPeriodoUltimo = $grupo->periodo->id;
				$resumen->resUltimoGrado = $grupo->gpoGrado;
				$resumen->resCreditosCursados = $resCreditosCursados;
				$resumen->resCreditosAprobados = $resCreditosAprobados;
				$resumen->resAvanceAcumulado = $resAvanceAcumulado;
				$resumen->resPromedioAcumulado = $resPromedioAcumulado;
				$resumen->resEstado = $alu->aluEstado;
				$resumen->resObservaciones = 'ModificadoPorScem'; #TEST.
				try {
					$resumen->save();
				} catch (\Exception $e) {
					DB::rollBack();
					throw $e;
				}
			} elseif (!$resumen && $hasIssue == false) {
				//Crear resumen.
				$curFechaRegistro = $cur1->curFechaRegistro;
				if (!$cur1->curFechaRegistro) {
					$curFechaRegistro = $cur1->periodo->perFechaInicial;
				}

				$resumen = new Bachiller_resumenacademico();
				$resumen->alumno_id = $alu_id;
				$resumen->plan_id = $plan->id;
				$resumen->resClaveEspecialidad = null;
				$resumen->resPeriodoIngreso = $cur1->periodo->id;
				$resumen->resPeriodoEgreso = null;
				$resumen->resPeriodoUltimo = $grupo->periodo->id;
				$resumen->resUltimoGrado = $grupo->gpoGrado;
				$resumen->resCreditosCursados = $resCreditosCursados;
				$resumen->resCreditosAprobados = $resCreditosAprobados;
				$resumen->resAvanceAcumulado = $resAvanceAcumulado;
				$resumen->resPromedioAcumulado = $resPromedioAcumulado;
				$resumen->resEstado = $alu->aluEstado;
				$resumen->resFechaIngreso = $curFechaRegistro;
				$resumen->resFechaEgreso = null;
				$resumen->resFechaBaja = null;
				$resumen->resRazonBaja = null;
				$resumen->resObservaciones = 'CreadoPorScem'; #TEST
				$resumen->usuario_id = auth()->user()->id;
				try {
					$resumen->save();
				} catch (\Exception $e) {
					DB::rollBack();
					throw $e;
				}
			} elseif (!$resumen && $hasIssue == true) {
				$issueAsunto = 'ResumenAcademico No Creado';
				$issue_id = DB::table('cierreactaslog')->insertGetId([
					'aluClave' => $alu->aluClave,
					'alumno_id' => $alu->id,
					'plan_id' => $plan->id,
					'periodo_id' => $grupo->periodo->id,
					'curso_id' => $inscrito->curso->id,
					'issueArchivo' => $issues[0]['issueFile'] . ' Linea: ' . $issues[0]['issueLine'],
					'issueAsunto' => $issueAsunto,
					'issueDetalle' => $issues[0]['issueDetail'],
					'issueFecha' => $issues[0]['fechai'],
					'user_at' => auth()->user()->id
				]);
			}

			
		} //FIN foreach $datos.

		// if($tGpos == $actCerradas){
		//Se realizan los cabios en la base de datos.
		DB::commit();

		if ($actas_pendientes->isEmpty()) {

			$grupossssss = Bachiller_grupos::with(
				'periodo',
				'plan.programa.escuela.departamento.ubicacion',
				'bachiller_empleado',
				'bachiller_materia'
			)
				->whereHas('periodo', function ($query) use ($request) {
					if ($request->periodo_id) {
						$query->where('id', $request->periodo_id);
					}
				})
				->whereHas('plan.programa.escuela.departamento.ubicacion', function ($query) use ($request) {
					if ($request->ubicacion_id) {
						$query->where('id', $request->ubicacion_id);
					}
				})
	
				->whereHas('plan.programa.escuela.departamento', function ($query) use ($request) {
					
					if ($request->departamento_id) {
						$query->where('id', $request->departamento_id);
					}
				})
	
				->whereHas('plan.programa.escuela', function ($query) use ($request) {
				
					if ($request->escuela_id) {
						$query->where('id', $request->escuela_id);
					}
				})
				->whereHas('plan.programa', function ($query) use ($request) {			
					
					if ($request->programa_id) {
						$query->where('id', $request->programa_id);
					}
				})
				->whereHas('plan', function ($query) use ($request) {			
					
					if ($request->plan_id) {
						$query->where('id', $request->plan_id);
					}
				})
				->whereHas('bachiller_materia', function ($query) use ($request) {
					if ($request->matClave) {
						$query->where('matClave', $request->matClave);
					}
				})
				->whereHas('bachiller_empleado', function ($query) use ($request) {
					if ($request->empleado_id) {
						$query->where('id', $request->empleado_id);
					}
				})
				->where(function ($query) use ($request) {
				
					$query->where('estado_act', '=', 'A'); #TEST.
					$query->whereNull('deleted_at'); #TEST.

				})            
				->get();

				if(count($grupossssss) > 0){
					$mensaje = "Pero ".count($grupossssss)." no se pudieron cerrar, por favor verifique que todos los grupos materias ya tengan todas las evidencias capturadas";
				}else{
					$mensaje = "";
				}


		

			alert()->success('Realizado', 'Se cerraron ' . $actCerradas . ' actas de ' . $tGpos . ' grupos. '.$mensaje)->showConfirmButton();
			// alert()->success('Escuela Modelo', 'Se ha realizado el cierre de grupos con éxito.')->showConfirmButton();

			return redirect('bachiller_cierre_actas');
		} else {
			try {
				$pdf = $this->actas_pendientes_pdf($actas_pendientes);
				// $this->enviarNotificacion('luislara@modelo.edu.mx', $pdf);
				return $pdf->stream('pdf_actas_pendientes_cerrar.pdf');

				alert()->success('Escuela Modelo', 'Se ha realizado el cierre de grupos con éxito.')->showConfirmButton();
				return redirect('bachiller_cierre_actas');
			} catch (Exception $e) {
				alert('Error', $e->getMessage())->showConfirmButton();
				return back()->withInput();
			}
		}
		// }else{
		// 	alert()->error('Error','ha ocurrido un error, 
		// 		favor de intentar nuevamente');
		// 	return back()->withInput();
		// }

	} //FIN function cierreActas.

	public function actas_pendientes_pdf($grupos)
	{
		$fechaActual = Carbon::now('America/Merida');

        // view('reportes.pdf.bachiller.actas_pendientes.pdf_actas_pendientes_cerrar');
		return PDF::loadView('reportes.pdf.bachiller.actas_pendientes.pdf_actas_pendientes_cerrar', [
			"grupo1" => $grupos->first(),
			"grupos" => $grupos->groupBy(['plan.programa.progClave', 'gpoSemestre']),
			"nombreArchivo" => 'pdf_actas_pendientes_cerrar',
			'tituloHead' => $t = 'ACTAS DE EXAMEN ORDINARIO PENDIENTES POR CERRAR 
                          Y CAPTURAR',
			"fechaActual" => $fechaActual->toDateString(),
			"horaActual" => $fechaActual->toTimeString(),
		]);
	}

	/**
	 * @param string $to
	 * @param PDF $pdf
	 */
	public function enviarNotificacion($to, $pdf)
	{
		$info['username_email'] = 'ordinarios@modelo.edu.mx'; // 'ordinarios@unimodelo.com';
		$info['password_email'] = 'JFotw752';
		$info['to_email'] = $to;
		$info['to_name'] = '';
		$info['cc_email'] = '';
		$info['subject'] = 'SCEM | Cierre de actas de ordinario.';
		$info['body'] = $this->mensaje_cierre_ordinarios();

		$email_alternativo1 = "";
		$email_alternativo2 = "";
		$email_alternativo3 = "";		

		if($this->ubicacion->ubiClave == 'CVA') {
			$email_alternativo1 = 'amartinez@modelo.edu.mx';
			$email_alternativo2 = 'mtuz@modelo.edu.mx';

		} else {
			$email_alternativo1 = 'msauri@modelo.edu.mx';
			$email_alternativo2 = 'a.aviles@modelo.edu.mx';
			$email_alternativo3 = 'arubio@modelo.edu.mx';
		}

			

		try {
			$mail = new ScemMailer($info);

			if($this->ubicacion->ubiClave == 'CVA') {
				$mail->agregar_destinatario($email_alternativo1);
				$mail->agregar_destinatario($email_alternativo2);
	
			} else {
				$mail->agregar_destinatario($email_alternativo1);
				$mail->agregar_destinatario($email_alternativo2);
				$mail->agregar_destinatario($email_alternativo3);
			}

			
			$mail->agregar_destinatario('luislara@modelo.edu.mx');
			$mail->agregar_destinatario('eail@modelo.edu.mx');
			// $mail->adjuntar_pdf($pdf, 'pdf_actas_pendientes_cerrar.pdf');
			$mail->enviar();
		} catch (Exception $e) {
			throw $e;
		}
	}

	private function mensaje_cierre_ordinarios()
	{
		$usuario = auth()->user();
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);

		return "<p>{$nombre_empleado} ({$usuario->username}) ha realizado un cierre de actas de Ordinario.</p>
        <br>
        <p>
        Fecha de Proceso: " . Utils::fecha_string(Carbon::now('America/Merida')) . "
        </p>
        ";
	} # mensaje_modificacion_pago

}//FIN controller class

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;

use App\Models\Ubicacion;
use App\Models\Grupo;
use App\Models\Historico;
use App\Models\Calificacion;
use App\Models\ResumenAcademico;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use App\clases\SCEM\Mailer as ScemMailer;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use DB;

class CierreActasController extends Controller
{
    public $ubicacion;
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_actas_pendientes');
    	set_time_limit(8000000);
    }

    public function dateDMY($fecha){
        if($fecha){
        $f = Carbon::parse($fecha)->format('d/m/Y');
        return $f;
        }
    }//FIN function dateDMY
    public function dateYMD($fecha){
        $f = null;
        if($fecha){
            $f = Carbon::parse($fecha)->format('Y-m-d');
        }
        return $f;
    }//FIN function dateYMD

    public function filtro(){
    	$fechaActual = Carbon::now('America/Merida');
    	return view('cierre_actas.create',compact('fechaActual'));
    }//FIN function filtro.

    public function cierreActas(Request $request){
    	$fechaActual = Carbon::now('America/Merida')->format('d/m/Y');
    	/*
    	* Especificar reglas de validación para los inputs.
    	*/
    	$messages = [
    		'perNumero.in' => 'Los valores permitidos para :attribute
    							son: 1,3,4,5,6.',
    		'gpoFechaExamenOrdinario.date_format' => 'El formato de fecha debe ser
    							día/mes/año,
                              ejemplo: '.$fechaActual.'.
                              Revisar el campo Fecha de Ordinario.'
    	];
    	$validator = Validator::make($request->all(),[
    		'ubiClave' => 'required',
    		'depClave' => 'required',
    		'escClave' => 'required',
    		'perNumero' => 'required|in:1,3,4,5,6',
    		'gpoFechaExamenOrdinario' => 'date_format:d/m/Y|nullable',

    	],$messages);

    	if($validator->fails()){
    		return redirect('cierre_actas')
    			->withErrors($validator)
    			->withInput();
    	}

    	$grupos = Grupo::with('periodo',
            'plan.programa.escuela.departamento.ubicacion',
    		'empleado','materia')
    	->whereHas('periodo',function($query) use($request){
    		if($request->perAnio){
    			$query->where('perAnio',$request->perAnio);
    		}
    		if($request->perNumero){
    			$query->where('perNumero',$request->perNumero);
    		}
    	})
    	->whereHas('plan.programa.escuela.departamento.ubicacion',function($query) use($request){
            if($request->ubiClave){
                $query->where('ubiClave',$request->ubiClave);
            }
            if($request->depClave){
                $query->where('depClave',$request->depClave);
            }
    		if($request->escClave){
    			$query->where('escClave',$request->escClave);
    		}
    		if($request->progClave){
    			$query->where('progClave',$request->progClave);
    		}
    		if($request->planClave){
    			$query->where('planClave',$request->planClave);
    		}
    	})
    	->whereHas('materia',function($query) use($request){
    		if($request->matClave){
    			$query->where('matClave',$request->matClave);
    		}
    	})
    	->whereHas('empleado',function($query) use($request){
    		if($request->empleado_id){
    			$query->where('id',$request->empleado_id);
    		}
    	})
    	->where(function($query) use($request){
    		if($request->gpoSemestre){
    			$query->where('gpoSemestre',$request->gpoSemestre);
    		}
    		if($request->gpoClave){
    			$query->where('gpoClave',$request->gpoClave);
    		}
    		if($request->gpoFechaExamenOrdinario){
    			$gpoFechaOrd = $this->dateYMD($request->gpoFechaExamenOrdinario);
    			$query->where('gpoFechaExamenOrdinario','=',$gpoFechaOrd);
    		}
    		$query->where('estado_act','=','B'); #TEST.
    	})
    	->get();


    	$tGpos = count($grupos); #Total de grupos.
    	if($tGpos < 1){
    		alert()->warning('Ups... Sin coicidencias', 'No se encuentran datos con la
    			información proporcionada, favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

        $this->ubicacion = Ubicacion::where('ubiClave', $request->ubiClave)->first();

    	/*
    	* Datos del alumno.
    	*/
    	$datos = collect([]);
        $actas_pendientes = new Collection;
    	$actCerradas = 0;
    	DB::beginTransaction();
    	for ($i=0; $i < $tGpos; $i++) {
    		$grupo = $grupos->get($i);
    		$plan_id = $grupo->plan_id;
    		$materia_id = $grupo->materia_id;
    		$periodo_id = $grupo->periodo_id;

            $histNombreOficial = null;
            $histComplementoNombre = null;
            if($grupo->optativa_id){
                $histNombreOficial = ucwords($grupo->optativa->optNombre);
                $histComplementoNombre  = strtoupper($histNombreOficial);
			}

				$inscritos = $grupo->inscritos()->get();
				$inscritoIds = $inscritos->map(function ($item, $key) {
					return $item->id;
				});
				$calificaciones = Calificacion::whereIn("inscrito_id", $inscritoIds)->get();


				$califFinalVacia = false;
				foreach ($calificaciones as $calificacion) {
					if (is_null($calificacion->inscCalificacionOrdinario)) {
						$califFinalVacia = true;
					}
				}

				if ($califFinalVacia) {
                    $actas_pendientes->push($grupo);
                } else {
					$tins = count($inscritos); #Total de Inscritos.
					for ($x=0; $x < $tins; $x++) {
						$inscrito = $inscritos->get($x);
						$curso  = $inscrito->curso;
						$alumno = $curso->alumno;
						$tipoIng = $curso->curTipoIngreso;
						$calificaciones = $inscrito->calificacion()->first();


						/*
						* Si curTipoIngreso = 'OY' (oyente)  No realizan las siguientes acciones.
						* -> Historico-> tipoAcreditacion por defecto es 'CI'.
						* -> Si Curso-> curTipoIngreso = 'RO' (Recursando)
						*    -> Historico-> tipoAcreditacion se registra como 'CR'.
						*/
						if($tipoIng != 'OY'){ #if_tipoIng.
							$tipoAcreditacion = 'CI';
							if($tipoIng == 'RO'){
								$tipoAcreditacion = 'CR';
							}

							try{
								$nvoHist = New Historico;
								$nvoHist->alumno_id = $alumno->id;
								$nvoHist->plan_id = $plan_id;
								$nvoHist->materia_id = $materia_id;
								$nvoHist->periodo_id = $periodo_id;
								$nvoHist->histComplementoNombre = $histComplementoNombre;
								$nvoHist->histPeriodoAcreditacion = 'PN';
								$nvoHist->histTipoAcreditacion = $tipoAcreditacion;
								$nvoHist->histFechaExamen = $grupo->gpoFechaExamenOrdinario;
								$nvoHist->histCalificacion = $calificaciones->incsCalificacionFinal;
								$nvoHist->histFolio = null;
								$nvoHist->hisActa = null;
								$nvoHist->histLibro = null;
								$nvoHist->histNombreOficial = $histNombreOficial;
								$alumno->historico()->save($nvoHist); #TEST funciona.

							/*
							* Se modifica el registro de $inscrito.
							* -> Se le agrega el historico_id
							*/
								$inscrito->historico_id = $nvoHist->id;
								$inscrito->save(); #TEST funciona.
							}catch(\Exception $e){
								DB::rollBack();
								alert()->error('Error','Ocurrió un problema durante
									el registro');
								throw $e;
							}

							/*
							* Se almacena la información académica del alumno.
							* para buscar su resumen académico y hacer los cálculos
							* de promedio, créditos, etc.
							*/
							if(!$datos->contains('alumno_id',$alumno->id)){
								$datos->push([
									'alumno_id' => $alumno->id,
									'inscrito' => $inscrito,
									'plan' => $grupo->plan,
								]);
							}

						}//FIN if_tipoIng.

					}//FIN for $tins

					//Cerrar grupo.
					try{
						$grupo->estado_act = 'C';
						if($grupo->save()){ #TEST
							$actCerradas++;
						}
					}catch(\Exception $e){
						DB::rollBack();
						throw $e;
					}
				}

    	}//FIN for $tGpos.

/* ---------------------------------------------------------------------------------- */

//INICIA PROCESO DE ACTUALIZACIÓN DE RESUMEN ACADÉMICO.

    	/*
    	* -> Extraer los Ids de los alumnos.
    	* -> Buscar los históricos y resúmenes académicos de los alumnos.
    	*/
    	$aluIds = $datos->pluck('alumno_id');
    	$histData = Historico::whereIn('alumno_id',$aluIds)
    		->get();
    	$resacaData = ResumenAcademico::whereIn('alumno_id',$aluIds)
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
    		$grupo = $inscrito->grupo;
    		$aluDep = $plan->programa->escuela->departamento;
    		$calMin = $aluDep->depCalMinAprob;

    		/*
    		* -> Obtener Historicos del alumno y borrarlos de $histData.
    		* -> filtrar por históricos pertenecientes al plan actual.
    		*/
    		$histAlumno = $histData->filter(function($value,$key)
    			use($alu_id,$histData,$plan){
    			if($value->alumno_id == $alu_id){
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
    			->where('periodo_id',$hist1->periodo_id)->first();
    		if(!$cur1){
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
    			->unique('materia_id');
	    	$materiasN = $matCursadas->filter(function($value,$key){
	    		return $value->materia->matTipoAcreditacion == 'N';
	    	});
	    	$materiasA = $matCursadas->filter(function($value,$key){
	    		return $value->materia->matTipoAcreditacion == 'A';
	    	});

	    	//Obtener Créditos Cursados.
	    	$resCreditosCursados = $matCursadas->sum(function($item){
	    		return $item->materia->matCreditos;
	    	});

		    /*
	    	* Créditos Aprobados.
	    	* -> Obtener créditos de materias tipo 'N'.
	    	* -> Obtener créditos de materias tipo 'A'.
	    	* -> Sumar.
	    	*/
	    	$credAprobN = $materiasN->where('histCalificacion','>=',$calMin)
	    		->sum(function($item){
	    			return $item->materia->matCreditos;
	    	});
	    	$credAprobA = $materiasA->where('histCalificacion',0)
	    		->sum(function($item){
	    			return $item->materia->matCreditos;
	    	});
	    	$resCreditosAprobados = $credAprobA + $credAprobN;

		    /*
	    	* Promedio Acumulado.
	    	* -> Solo se promedia con materias tipo 'N'.
			*/
			$materiasN = $materiasN->map(function($item,$key){
				if($item->histCalificacion < 0){
					$item->histCalificacion = 0;
				}
				return $item;
			});
			$resPromedioAcumulado = $materiasN->avg('histCalificacion');
			$resPromedioAcumulado = number_format($resPromedioAcumulado,4);

			/*
			* Avance Acumulado.
			*/
			$planCreditos = $plan->planNumCreditos;
			$resAvanceAcumulado = ($resCreditosAprobados / $planCreditos) * 100;
			$resAvanceAcumulado = number_format($resAvanceAcumulado,2);

			/*
			* Obtener y modificar el resumen académico del alumno.
			*/
			$resumen = $resacaData->filter(function($value,$key)
				use($alu_id,$resacaData,$plan){
					if($value->alumno_id == $alu_id){
						$a = $resacaData->pull($key);
						return $a->plan_id == $plan->id;
					}
				})->first();

			if($resumen){
				//Modificar resumen.
				$resumen->resPeriodoUltimo = $grupo->periodo->id;
				$resumen->resUltimoGrado = $grupo->gpoSemestre;
				$resumen->resCreditosCursados = $resCreditosCursados;
				$resumen->resCreditosAprobados = $resCreditosAprobados;
				$resumen->resAvanceAcumulado = $resAvanceAcumulado;
				$resumen->resPromedioAcumulado = $resPromedioAcumulado;
				$resumen->resEstado = $alu->aluEstado;
				$resumen->resObservaciones = 'ModificadoPorScem'; #TEST.
				try{
					$resumen->save();
				}catch(\Exception $e){
		    		DB::rollBack();
		    		throw $e;
		    	}

			}elseif(!$resumen && $hasIssue == false){
				//Crear resumen.
				$curFechaRegistro = $cur1->curFechaRegistro;
				if(!$cur1->curFechaRegistro){
					$curFechaRegistro = $cur1->periodo->perFechaInicial;
				}

				$resumen = New ResumenAcademico;
				$resumen->alumno_id = $alu_id;
                $resumen->plan_id = $plan->id;
                $resumen->resClaveEspecialidad = null;
                $resumen->resPeriodoIngreso = $cur1->periodo->id;
                $resumen->resPeriodoEgreso = null;
                $resumen->resPeriodoUltimo = $grupo->periodo->id;
                $resumen->resUltimoGrado = $grupo->gpoSemestre;
                $resumen->resCreditosCursados = $resCreditosCursados;
                $resumen->resCreditosAprobados = $resCreditosAprobados;
                $resumen->resAvanceAcumulado = $resAvanceAcumulado;
                $resumen->resPromedioAcumulado = $resPromedioAcumulado;
                $resumen->resEstado = $alu->aluEstado;
                $resumen->resFechaIngreso = $curFechaRegistro;
                $resumen->resFechaEgreso = null;
                $resumen->resFechaBaja = null;
                $resumen->resRazonBaja = null;
                $resumen->resObservaciones = 'CreadoPorScem';#TEST
                $resumen->usuario_id = auth()->user()->id;
                try{
					$resumen->save();
				}catch(\Exception $e){
		    		DB::rollBack();
		    		throw $e;
		    	}

			}elseif(!$resumen && $hasIssue == true) {
				$issueAsunto = 'ResumenAcademico No Creado';
				$issue_id = DB::table('cierreactaslog')->insertGetId([
					'aluClave' => $alu->aluClave,
					'alumno_id' => $alu->id,
					'plan_id' => $plan->id,
					'periodo_id' => $grupo->periodo->id,
					'curso_id' => $inscrito->curso->id,
					'issueArchivo' => $issues[0]['issueFile'].' Linea: '.$issues[0]['issueLine'],
					'issueAsunto' => $issueAsunto,
					'issueDetalle' => $issues[0]['issueDetail'],
					'issueFecha' => $issues[0]['fechai'],
					'user_at' => auth()->user()->id
				]);
			}



    	}//FIN foreach $datos.


    	// if($tGpos == $actCerradas){
	    	//Se realizan los cabios en la base de datos.
			DB::commit();
            if($actas_pendientes->isEmpty()) {
                alert()->success('Realizado', 'Se cerraron ' . $actCerradas . ' actas de ' . $tGpos . ' grupos.')->showConfirmButton();
                return redirect('cierre_actas');
            } else {
                try {
                    $pdf = $this->actas_pendientes_pdf($actas_pendientes);
                    $this->enviarNotificacion('luislara@modelo.edu.mx', $pdf);
                    return $pdf->stream('pdf_actas_pendientes_cerrar.pdf');
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

    }//FIN function cierreActas.

    public function actas_pendientes_pdf($grupos) {
        $fechaActual = Carbon::now('America/Merida');

        return PDF::loadView('reportes.pdf.pdf_actas_pendientes_cerrar', [
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

        $email_alternativo1 = "cesauri@modelo.edu.mx";
        $email_alternativo2 = "sil_bar@modelo.edu.mx";
        if($this->ubicacion->ubiClave == "CCH") {
            $email_alternativo1 = "mduch@modelo.edu.mx";
            $email_alternativo2 = "jpereira@modelo.edu.mx";
        }else if($this->ubicacion->ubiClave == "CVA") {
            $email_alternativo1 = 'ppineda@modelo.edu.mx'; // "aime@modelo.edu.mx";
        }

        try {
            $mail = new ScemMailer($info);
            $mail->agregar_destinatario($email_alternativo1);
            $mail->agregar_destinatario($email_alternativo2);
            $mail->agregar_destinatario('luislara@modelo.edu.mx');
            $mail->agregar_destinatario('eail@modelo.edu.mx');
            $mail->adjuntar_pdf($pdf, 'pdf_actas_pendientes_cerrar.pdf');
            $mail->enviar();
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function mensaje_cierre_ordinarios() {
        $usuario = auth()->user();
        $nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);

        return "<p>{$nombre_empleado} ({$usuario->username}) ha realizado un cierre de actas de Ordinario.
        Han habido algunos grupos que no han podido cerrar actas y se presentan en el archivo adjunto a continuación.</p>
        <br>
        <p>
        Fecha de Proceso: ".Utils::fecha_string(Carbon::now('America/Merida'))."
        </p>
        ";
      } # mensaje_modificacion_pago

}//FIN controller class

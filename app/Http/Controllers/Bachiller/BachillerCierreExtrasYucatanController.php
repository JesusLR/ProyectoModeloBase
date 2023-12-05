<?php

namespace App\Http\Controllers\Bachiller;

use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Bachiller\Bachiller_resumenacademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


use App\Models\Curso;
use App\Models\Ubicacion;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Validator;
use PDF;

class BachillerCierreExtrasYucatanController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	// $this->middleware('permisos:r_actas_pendientes');
    	// set_time_limit(8000000);
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
    	$fechaActual = Carbon::now('CDT');
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $bachiller_empleados = Bachiller_empleados::where('empEstado', '!=', 'B')->get();

    	return view('bachiller.cierre_extras.create',compact('fechaActual', 'ubicaciones', 'bachiller_empleados'));
    }//FIN function filtro.

    public function getMateriasEvidencias(Request $request, $plan_id, $programa_id)
    {
        if ($request->ajax()) {
            $Materia = Bachiller_materias::select('bachiller_materias.*')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('bachiller_materias.plan_id', $plan_id)
            ->where('programas.id', $programa_id)
            ->get();

            return response()->json($Materia);
        }
    }

    public function cierreExtras(Request $request){

    	$fechaActual = Carbon::now('CDT')->format('d/m/Y');

    	/*
    	* Validar datos de los inputs.
    	*/
    	$messages = [
    		// 'perNumero.in' => 'Los valores permitidos para :attribute
    		// 					son: 1 o 3.',
    		'iexfecha.date_format' => 'El formato de fecha debe ser
    							día/mes/año,
                              ejemplo: '.$fechaActual.'.
                              Revisar el campo Fecha de Ordinario.',
            // 'depClave.in' => 'Por el momento, este módulo funciona solo con
            //                   Departamento Superior(SUP)'
    	];
    	$validator = Validator::make($request->all(),[
    		'ubicacion_id' => 'required',
    		// 'depClave' => ['required',Rule::in(['SUP','POS'])],
    		// 'perNumero' => 'required|in:1,3',
    		'iexfecha' => 'date_format:d/m/Y|nullable',

    	],$messages);

    	if($validator->fails()){
    		return redirect('bachiller_cierre_actas')
    			->withErrors($validator)
    			->withInput();
    	}

    	$inscritos = Bachiller_inscritosextraordinarios::with(
    		'bachiller_extraordinario.periodo',
    		'bachiller_extraordinario.bachiller_materia.plan.programa.escuela.departamento.ubicacion')
    		->whereHas('bachiller_extraordinario.periodo',
                function($query) use($request){
    			if($request->periodo_id){
    				$query->where('id',$request->periodo_id);
    			}
    		})
    		->whereHas('bachiller_extraordinario.bachiller_materia.plan.programa.escuela.departamento.ubicacion',
                function($query) use($request){
                if($request->ubicacion_id){
                    $query->where('id',$request->ubicacion_id);
                }                
            })
            ->whereHas('bachiller_extraordinario.bachiller_materia.plan.programa.escuela.departamento',
                function($query) use($request){                
                if($request->departamento_id){
                    $query->where('id',$request->departamento_id);
                }                
            })
            ->whereHas('bachiller_extraordinario.bachiller_materia.plan.programa.escuela',
                function($query) use($request){
                if($request->escuela_id){
                    $query->where('id',$request->escuela_id);
                }                
            })
            ->whereHas('bachiller_extraordinario.bachiller_materia.plan.programa',
                function($query) use($request){               
                if($request->programa_id){
                    $query->where('id',$request->programa_id);
                }                
            })
            ->whereHas('bachiller_extraordinario.bachiller_materia.plan',
                function($query) use($request){            
                
                if($request->plan_id){
                    $query->where('id',$request->plan_id);
                }
            })
            ->whereHas('bachiller_extraordinario.bachiller_materia',
                function($query) use($request){  
                if($request->materia_id){
                    $query->where('id',$request->materia_id);
                }                
            })

            ->whereHas('bachiller_extraordinario.bachiller_empleado',
                function($query) use($request){  
                if($request->empleado_id){
                    $query->where('bachiller_empleado_id',$request->empleado_id);
                }
            })

            ->whereHas('bachiller_extraordinario',
                function($query) use($request){  
                if($request->iexFecha){
                    $iexFecha = $this->dateYMD($request->iexFecha);
                    $query->where('extFecha',$iexFecha);
                }
            })
            ->where(function($query) use($request){
                // if($request->iexFecha){
                //     $iexFecha = $this->dateYMD($request->iexFecha);
                //     $query->where('iexFecha',$iexFecha);
                // }
                $query->where('iexEstado','!=','C');
                // $query->where('iexEstado','==','P');
                // $query->whereNotNull('iexCalificacion');
                $query->whereNull('iexFolioHistorico'); #TEST
            })
        ->get();


        // si encuentra algun alumno sin calificar entra en la validacion y no deja continuar 
        foreach ($inscritos as $key => $value) {
            if($value->iexCalificacion == ""){
                alert()->error('Ups..','No se puede realizar el cierre de Recuperativos debido que hay alumnos sin calificar. Favor de verificar')->showConfirmButton()->autoClose('6000');
                return back()->withInput();
            }
        }

        $tins = count($inscritos);
        if($tins < 1){
            alert()->error('Ups..','No hay registros que coincidan con la
                información proporcionada, favor de verificar.');
            return back()->withInput();
        }

        /*
        * Contiene alumnos que no puedan registrar $nvoHist
        * por cuestiones académicas(exceso de intentos de extraordinario).
        */
        $noRegistrados = collect([]);

        //Resúmenes e Históricos de todos los alumnos filtrados.
        $aluIds = $inscritos->pluck('alumno_id');
        $histData = Bachiller_historico::whereIn('alumno_id',$aluIds)->get();
        $resacaData = Bachiller_resumenacademico::whereIn('alumno_id',$aluIds)->get();

        $groupedAluId = $inscritos->groupBy('alumno_id');
        
        DB::beginTransaction();

        foreach ($groupedAluId as $alu_id => $aluExtras) {

            $extra1 = $aluExtras->first();
            $plan = $extra1->bachiller_extraordinario->bachiller_materia->plan;
            $departamento = $plan->programa->escuela->departamento;
            $ubicacion = $departamento->ubicacion;
            $calMin = $departamento->depCalMinAprob;
            $hasIssue = false;
            $issues = collect([]);

            $tipoRecuperativo = $extra1->bachiller_extraordinario->extTipo;

            //Históricos del alumno a evaluar.
            $histAlumno = $histData->filter(function($value,$key)
                use($alu_id,$histData,$plan){
                    if($value->alumno_id == $alu_id){
                        $a = $histData->pull($key);
                        return $a->plan_id == $plan->id;
                    }
                });

            //Resumen académico del alumno.
            $resumen = $resacaData->filter(function($value,$key)
                use($alu_id,$resacaData,$plan){
                    if($value->alumno_id == $alu_id){
                        $a = $resacaData->pull($key);
                        return $a->plan_id == $plan->id;
                    }
                })->first();

            $t_aluExtras = count($aluExtras); #extraordinarios del alumno.
            for ($i=0; $i < $t_aluExtras; $i++) { #for_total
                $inscrito = $aluExtras->get($i);
                $materia = $inscrito->bachiller_extraordinario->bachiller_materia;
                $periodo_presentado = $inscrito->bachiller_extraordinario->periodo;
                
                $tipoAcred = 'O1';

                $_plan = $inscrito->bachiller_extraordinario->bachiller_materia->plan_id;

                

                /* -------------------------------------------------------------------------- */
                /*                                    kike                                    */
                /* -------------------------------------------------------------------------- */
                // obtenemos el periodo donde curso esa materia 
                // primero buscamos en historico 
                $busca_en_historico = Bachiller_historico::select('bachiller_historico.periodo_id', 'bachiller_materias.matNombre',
                'bachiller_historico.histPeriodoAcreditacion', 'bachiller_historico.histTipoAcreditacion')
                ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->where('bachiller_materias.id', $materia->id)
                ->where('bachiller_historico.alumno_id', $inscrito->alumno_id)
                ->where('bachiller_historico.plan_id', $_plan)
                ->where('bachiller_historico.histPeriodoAcreditacion', '=', 'PN')
                ->where('bachiller_historico.histTipoAcreditacion', '=', 'CI')
                ->first();

                if($busca_en_historico != ""){
                    $periodo = $busca_en_historico->periodo_id;
                }else{

                    // si no hay dato en historico buscamos en inscritos 
                    $buscando_en_inscritos = Bachiller_inscritos::select('bachiller_grupos.periodo_id', 'bachiller_materias.matNombre', 'bachiller_grupos.gpoGrado')
                    ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                    ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                    ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                    ->where('bachiller_materias.id', $materia->id)
                    ->where('cursos.alumno_id', $inscrito->alumno_id)
                    ->where('bachiller_grupos.plan_id', $_plan)
                    ->first();

                    if($buscando_en_inscritos != ""){
                        $periodo = $buscando_en_inscritos->periodo_id;
                    }else{

                        // si no hay datos en ninguna de las 2 tablas asignamos el periodo_id del recueprativo 
                        $periodo = $inscrito->bachiller_extraordinario->periodo->id;
                    }
    
                }
                
                

                

                $ultIntento = $histAlumno->where('bachiller_materia_id',$materia->id)
                    ->whereIn('histPeriodoAcreditacion',['EX' ,'RE', 'AC'])
                    ->sortByDesc('histTipoAcreditacion')
                    ->pluck('histTipoAcreditacion')
                    ->first();

                if($ultIntento){
                    $tipoAcred = $this->obtenerHistTipoAcreditacion($ultIntento, $ubicacion->ubiClave);
                }
                
                if($tipoAcred == 'NA') {
                    $noRegistrados->push([
                        'inscrito' => $inscrito,
                        'plan' => $plan,
                        'materia' => $materia,
                        'periodo' => $periodo,
                    ]);
                }

                if($tipoAcred != 'NA'){
                    try {

                        $nvoHist = New Bachiller_historico;
                        $nvoHist->alumno_id = $inscrito->alumno_id;
                        $nvoHist->plan_id = $plan->id;
                        $nvoHist->bachiller_materia_id = $materia->id;
                        $nvoHist->periodo_id = $periodo_presentado->id;
                        $nvoHist->periodo_id_ficticio = $periodo;
                        $nvoHist->histComplementoNombre = null;
                        $nvoHist->histPeriodoAcreditacion = ($tipoRecuperativo == "ACOMPAÑAMIENTO" ? "AC" : "RE");
                        $nvoHist->histTipoAcreditacion = $tipoAcred;
                        $nvoHist->histFechaExamen = $inscrito->bachiller_extraordinario->extFecha;
                        $nvoHist->histCalificacion = $inscrito->iexCalificacion;
                        $nvoHist->histFolio = null;
                        $nvoHist->hisActa = null;
                        $nvoHist->histLibro = null;
                        $nvoHist->histNombreOficial = $materia->matNombreOficial;
                        $nvoHist->save();
                        $inscrito->iexFolioHistorico = $nvoHist->id;
                        $inscrito->save();

                        //Agregar nuevo Historico al Collection de $histAlumno.
                        $histAlumno->push($nvoHist);

                        $tipoRecuperativo = "";
                        
                    } catch (\Exception $e) {
                        DB::rollBack();
                        alert()->error('Error','ha ocurrido un error, 
                            favor de intentar nuevamente');
                        return back()->withInput();
                        throw $e;
                    }
                }
                
            }//for_total

            /* -------------------------------------------------------------
            * ACTUALIZACIÓN DE RESUMEN ACADÉMICO.
            */
            $fechaProceso = Carbon::now('CDT')->format('Y-m-d');

            /*
            * -> Traer primer historico, para obtener periodo_id,
            * -> Obtener el primer curso.
            * (Se requerirá esta información en caso de crear
            *  ResumenAcademico).
            */
            $hist1 = $histAlumno->sortBy('histFechaExamen')
                ->first();
            $cur1 = $inscrito->alumno->cursos()
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
                ->unique('bachiller_materia_id');
            $materiasN = $matCursadas->filter(function($value,$key){
                return $value->bachiller_materia->matTipoAcreditacion == 'N';
            });
            $materiasA = $matCursadas->filter(function($value,$key){
                return $value->bachiller_materia->matTipoAcreditacion == 'A';
            });

            //Obtener Créditos Cursados.
            $resCreditosCursados = $matCursadas->sum(function($item){
                return $item->bachiller_materia->matCreditos;
            });

            /*
            * Créditos Aprobados.
            * -> Obtener créditos de materias tipo 'N'.
            * -> Obtener créditos de materias tipo 'A'.
            * -> Sumar.
            */
            $credAprobN = $materiasN->where('histCalificacion','>=',$calMin)
                ->sum(function($item){
                    return $item->bachiller_materia->matCreditos;
            });
            $credAprobA = $materiasA->where('histCalificacion',0)
                ->sum(function($item){
                    return $item->bachiller_materia->matCreditos;
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



            if($resumen){
                //Modificar resumen.
                // $resumen->resPeriodoUltimo = $inscrito->extraordinario->periodo_id;
                $resumen->resCreditosCursados = $resCreditosCursados;
                $resumen->resCreditosAprobados = $resCreditosAprobados;
                $resumen->resAvanceAcumulado = $resAvanceAcumulado;
                $resumen->resPromedioAcumulado = $resPromedioAcumulado;
                $resumen->resObservaciones = 'ModificadoPorScem '.$fechaProceso;#TEST.
                try{
                    $resumen->save();
                }catch(\Exception $e){
                    DB::rollBack();
                    alert()->error('Error','ha ocurrido un error, 
                        favor de intentar nuevamente');
                    return back()->withInput();
                    throw $e;
                }
            }elseif(!$resumen && $hasIssue == false){
                //Crear resumen.
                $ultGrado = $histAlumno->map(function($item,$key){
                return $item->bachiller_materia;
                })->sortByDesc('matSemestre')
                ->pluck('matSemestre')
                ->first();

                $curFechaRegistro = $cur1->curFechaRegistro;
                if(!$cur1->curFechaRegistro){
                    $curFechaRegistro = $cur1->periodo->perFechaInicial;
                }

                $resumen = New Bachiller_resumenacademico;
                $resumen->alumno_id = $alu_id;
                $resumen->plan_id = $plan->id;
                $resumen->resClaveEspecialidad = null;
                $resumen->resPeriodoIngreso = $cur1->periodo->id;
                $resumen->resPeriodoEgreso = null;
                $resumen->resPeriodoUltimo = $inscrito->bachiller_extraordinario->periodo_id;
                $resumen->resUltimoGrado = $ultGrado;
                $resumen->resCreditosCursados = $resCreditosCursados;
                $resumen->resCreditosAprobados = $resCreditosAprobados;
                $resumen->resAvanceAcumulado = $resAvanceAcumulado;
                $resumen->resPromedioAcumulado = $resPromedioAcumulado;
                $resumen->resEstado = $inscrito->alumno->aluEstado;
                $resumen->resFechaIngreso = $curFechaRegistro;
                $resumen->resFechaEgreso = null;
                $resumen->resFechaBaja = null;
                $resumen->resRazonBaja = null;
                $resumen->resObservaciones = 'CreadoPorScem '.$fechaProceso;#TEST
                $resumen->usuario_id = auth()->user()->id;
                try{
                    $resumen->save();
                }catch(\Exception $e){
                    DB::rollBack();
                    alert()->error('Error','ha ocurrido un error, 
                        favor de intentar nuevamente');
                    return back()->withInput();
                    throw $e;
                }
            }elseif(!$resumen && $hasIssue == true) {
                $issueAsunto = 'ResumenAcademico No Creado';
                $issue_id = DB::table('cierreactaslog')->insertGetId([
                    'aluClave' => $inscrito->alumno->aluClave,
                    'alumno_id' => $inscrito->alumno->id,
                    'plan_id' => $plan->id,
                    'periodo_id' => $inscrito->bachiller_extraordinario->periodo_id,
                    'curso_id' => $inscrito->alumno_id, #este módulo no maneja cursos.
                    'issueArchivo' => $issues[0]['issueFile'].' Linea: '.$issues[0]['issueLine'],
                    'issueAsunto' => $issueAsunto,
                    'issueDetalle' => $issues[0]['issueDetail'],
                    'issueFecha' => $issues[0]['fechai'],
                    'user_at' => auth()->user()->id
                ]);
            }

        }//foreach groupedAluId

        DB::commit();
        if($noRegistrados->isNotEmpty()){
            // Unix
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            //Nombre del archivo PDF de descarga
            $nombreArchivo = "pdf_cierre_extras_incidencias";
            //Cargar vista del PDF
            $pdf = PDF::loadView("bachiller.cierre_extras.pdf.pdf_cierre_extras_incidencias",[
            "noRegistrados" => $noRegistrados,
            "fechaActual" => Carbon::now('CDT')->format('d/m/Y'),
            "horaActual" => Carbon::now('CDT')->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo
            ]);
            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';
            return $pdf->stream($nombreArchivo);
            return $pdf->download($nombreArchivo);
        }else{
            alert()->success('Realizado','Se ha realizado con éxito el cierre de 
                actas de Recuperativos. Sin incidencias');
            return redirect('bachiller_cierre_extras');
        }
        
        
    }//FIN function cierreExtras.


    /**
    * Recibe el ultimo intento de extraordinario. (histTipoAcreditacion)
    * Retorna el tipo de acreditación correspondiente.
    *
    * @param string $ultimoIntento
    * @param string $ubiClave
    *
    * @return string $histTipoAcreditacion.
    */
    public function obtenerHistTipoAcreditacion($ultimoIntento, $ubiClave): string
    {
        $numero = substr($ultimoIntento, -1);
        $numero = intval($numero);

        $histTipoAcreditacion = 'NA';
        if(is_int($numero) && $numero > 0) {
            $numero++;

            if($numero <= 9) {
                $histTipoAcreditacion = 'O'.$numero;
            }

            if($ubiClave != 'CCH' && $numero > 3) {
                $histTipoAcreditacion = 'NA';
            }

        }

        return $histTipoAcreditacion;
    }//obtenerHistTipoAcreditacion.





} //FIN Controller class.
<?php

namespace App\Http\Controllers\Bachiller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Egresado;
use App\Models\Pago;
use App\Models\ConceptoTitulacion;
use App\Models\ConceptoModoTitulacion;
use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Curso;

use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_resumenacademico;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerEgresadoController extends Controller
{
    //
    public function __contruct(){
    	$this->middleware('auth');
    }

    /* 
    * --------------------------------------------------------------------------
    *    FUNCIONES DE PROCESO REGISTRO DE EGRESADOS / TITULADOS.
    * --------------------------------------------------------------------------
    */
    public function filtro(){

    	return view('bachiller.egresados.procesar', [
            'ubicaciones' => Ubicacion::whereIn('id', [1, 2])->get(),
        ]);
    }// function filtro.

    public function procesar(Request $request){

        $periodo_seleccionado = Periodo::with('departamento')->findOrFail($request->periodo_id);
        $departamento = $periodo_seleccionado->departamento;

    	$resacas = Bachiller_resumenacademico::with('plan.programa','alumno.persona')
    	->whereHas('plan.programa',function($query) use($request){
    		$query->where('escuela_id', $request->escuela_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
    	})
    	->whereHas('alumno.persona',function($query) use($request){
    		if($request->aluClave)
    			$query->where('aluClave', $request->aluClave);
    		if($request->aluMatricula)
    			$query->where('aluMatricula', $request->aluMatricula);
    		if($request->perApellido1)
    			$query->where('perApellido1', $request->perApellido1);
    		if($request->perApellido2)
    			$query->where('perApellido2', $request->perApellido2);
    		if($request->perNombre)
    			$query->where('perNombre', $request->perNombre);
    	})
    	->where('resEstado','=','R')
    	->get();

    	if($resacas->isEmpty()){
    		alert()->warning('Sin coincidencias','No se encontraron registros con la información 
    			proporcionada. Favor de verificar e intentar nuevamente.');
    		return back()->withInput();
    	}

    	$resacas = $resacas->filter(function($resaca,$key){
    		$egresado = $resaca->alumno->egresado()
    			->where('plan_id',$resaca->plan->id)
    			->first();
    		if(!$egresado){
    			return $resaca->resCreditosAprobados >= $resaca->plan->planNumCreditos;
    		}
    	});

        if($resacas->isEmpty()) {
            alert('No hay egresados', 'Al parecer no se cuenta con créditos suficientes para egresar')->showConfirmButton();
            return back()->withInput();
        }

    	$conceptos_pagos = [
    		'01','02','03','04','05','06',
    		'07','08','09','10','11','12'
    	];

		//Buscar el último pago de cada alumno.
		$pagosData = Pago::whereIn('pagClaveAlu', $resacas->pluck('alumno.aluClave'))
            ->whereIn('pagConcPago', $conceptos_pagos)
			->orderBy('pagConcPago')
			->get()->keyBy('pagClaveAlu');

		//COMIENZAN LOS CAMBIOS EN LA BASE DE DATOS.
		DB::beginTransaction();

    	$egr_registrados = 0; #TEST.
    	$alu_actualizados = 0; #TEST.
    	$res_actualizados = 0; #TEST.
    	foreach ($resacas as $key => $resumen) { #foreach_resacas.
    		$alumno = $resumen->alumno;
    		$plan = $resumen->plan;
    		$ult_pago = $pagosData->get($alumno->aluClave);

    		try {
                $egresado = Egresado::create([
                    'periodo_id' => $periodo_seleccionado->id,
                    'alumno_id' => $alumno->id,
                    'plan_id' => $plan->id,
                    'egrPrimerPeriodo' => $resumen->resPeriodoIngreso,
                    'egrUltimoPeriodo' => $resumen->resPeriodoUltimo,
                    'egrUltimoMesPago' => $ult_pago ? Utils::obtenerMesAnual($ult_pago->pagConcPago) : 0,
                    'egrUltimoAnioPago' => $ult_pago ? $ult_pago->pagAnioPer : 0,
                    'egrCreditosPlan' => $plan->planNumCreditos,
                    'egrCreditosCursados' => $resumen->resCreditosAprobados,
                    'egrPeriodoTitulacion' => null,
                    'egrFechaExamenProfesional' => null,
                    'egrFechaExpedicionTitulo' => null,
                    'egrOpcionTitulo' => null,
                    'egrModoTituloSegey' => null,
                    'egrDesempenioSegey' => null,
                    'egrTipoDesempenioSegey' => null,
                    'egrTipoBecaSegey' => null,
                ]);

                $resumen->update([
                    'resPeriodoEgreso' => $periodo_seleccionado->id,
                    'resEstado' => 'E',
                    'resFechaEgreso' => Carbon::now('America/Merida')->format('Y-m-d'),
                    'resObservaciones' => 'ModificadoPorScem',
                ]);

                $alumno->update([
                    'aluEstado' => 'E',
                ]);

                $egr_registrados++; #TEST.
                $res_actualizados++;
                $alu_actualizados++;
    		} catch (Exception $e) {
    			DB::rollBack();
    			alert()->error('Ha ocurrido un problema', 'Ha ocurrido un problema durante el proceso,
    				favor de intentar nuevamente.');
    			return back()->withInput();
    		}

    	}// foreach_resacas.

    	if($resacas->count() == $egr_registrados){
    		DB::commit(); #TEST
    		alert()->success('Completado','Se ha registrado con éxito a '.$egr_registrados.' egresado(s)');
    		return redirect('registro_egresados')->withInput();
    	}else{
    		DB::rollBack();
    		alert()->error('Error','Ha ocurrido un problema durante el proceso,
    			favor de intentar nuevamente. Si el problema persiste, consulte
    			al área de Sistemas');
    		return back()->withInput();
    	}



    }//function procesar.

    public function getAlumnoByClave($aluClave){

    	$resumen = Bachiller_resumenacademico::with(['periodoUltimo','alumno.persona', 'plan.programa.escuela.departamento.ubicacion'])
    	->whereHas('alumno',function($query) use($aluClave){
    		$query->where('aluClave',$aluClave);
    	})
    	->whereHas('periodoUltimo.departamento',function($query){
    		$query->where('depClave','=','SUP')
    			  ->orWhere('depClave','=','POS');
    	})
    	->where('resEstado','=','R')
    	->latest('updated_at')
    	->first();

    	return response()->json($resumen);
    } // function getAlumnoByClave.



    /* 
    * --------------------------------------------------------------------------
    *    FUNCIONES DE PROCESO CRUD EGRESADOS.
    * --------------------------------------------------------------------------
    */

    public function index(){
        return view('bachiller.egresados.show-list');
    }//index

    public function create(){
        $fechaActual = Carbon::now('CDT');
        $conceptos_titulacion = ConceptoTitulacion::all()
            ->pluck('contNombre','id');
        $modos_titulacion = ConceptoModoTitulacion::all()
            ->pluck('conmNombre','id');
        $tipos_desempenio = [
            'P' => 'Promedio',
            'E' => 'Examen Ceneval',
            'U' => 'Otro',
        ];
        $tipos_becas = [
            '3' => 'Sep/Segey',
            '4' => 'Modelo',
            '5' => 'Otro',
            '6' => 'Sin beca',
        ];
        $ubicaciones = Ubicacion::all()
            ->where('ubiClave','<>','000')
            ->pluck('ubiNombre','ubiClave');
        $departamentos = [
            'SUP' => 'SUP',
            'POS' => 'POS',
        ];
        $meses = Utils::meses_key_int();

        return view('bachiller.egresados.create',
            compact('fechaActual',
                'conceptos_titulacion',
                'modos_titulacion',
                'tipos_desempenio',
                'tipos_becas',
                'ubicaciones',
                'departamentos',
                'meses'));
    }//create


    public function store(Request $request){

        $resumen = Bachiller_resumenacademico::with(['alumno','plan.programa'])
        ->whereHas('alumno', static function ($query) use ($request){
            if($request->aluClave){
                $query->where('aluClave', $request->aluClave);
            }
        })
        ->whereHas('plan.programa', static function ($query) use ($request){
            if($request->progClave){
                $query->where('progClave', $request->progClave);
            }
            if($request->planClave){
                $query->where('planClave', $request->planClave);
            }
        })
        ->first();

        if(!$resumen){
            alert()->warning('Ups...','No hay registros que coincidan con la
                infomración proporcionada. Favor de verificar.');
            return back()->withInput();
        }

        $egresado = $resumen->alumno->egresado()->where('plan_id', $resumen->plan_id)->first();

        if(!$egresado){

            DB::beginTransaction();
            try {
                $egresado = Egresado::create([
                    'periodo_id' => $request->perProceso,
                    'alumno_id' => $resumen->alumno->id,
                    'plan_id' => $resumen->plan->id,
                    'egrPrimerPeriodo' => $request->egrPrimerPeriodo,
                    'egrUltimoPeriodo' => $resumen->resPeriodoUltimo,
                    'egrUltimoMesPago' => null,
                    'egrUltimoAnioPago' => null,
                    'egrCreditosPlan' => $resumen->plan->planNumCreditos,
                    'egrCreditosCursados' => $resumen->resCreditosCursados,
                    'egrPeriodoTitulacion' => null,
                    'egrFechaExamenProfesional' => null,
                    'egrFechaExpedicionTitulo' => null,
                    'egrOpcionTitulo' => null,
                    'egrModoTituloSegey' => null,
                    'egrDesempenioSegey' => null,
                    'egrTipoDesempenioSegey' => null,
                    'egrTipoBecaSegey' => null,
                    'usuario_at' => auth()->user()->id,
                ]);

                $resumen->update([
                    'resPeriodoEgreso' => $request->perEgreso,
                    'resEstado' => 'E',
                    'resFechaEgreso' => Carbon::now('CDT')->format('Y-m-d'),
                    'resObservaciones' => 'ModificadoPorScem-RegistroManual',
                ]);

                $resumen->alumno->update([
                    'aluEstado' => 'E',
                ]);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

            //DB::commit(); #TEST.
            alert()->success('Realizado','Se ha registrado con éxito el egresado.');
            return redirect('egresados');

        }else{
            alert()->error('Ups..','El alumno ya está registrado como egresado
                de este plan');
            return back()->withInput();
        }
    }//store

    public function edit(Request $request, $id){
        $fechaActual = Carbon::now('CDT');
        $egresado = Egresado::findOrFail($id);
        $aluClave = $egresado->alumno->aluClave;
        $plan_id = $egresado->plan_id;
        $data = $this->buscarAlumno($request, $aluClave, $plan_id);

        $conceptos_titulacion = ConceptoTitulacion::all()
            ->pluck('contNombre','id');
        $modos_titulacion = ConceptoModoTitulacion::all()
            ->pluck('conmNombre','id');

        $tipos_desempenio = [
            'P' => 'Promedio',
            'E' => 'Examen Ceneval',
            'U' => 'Otro',
        ];

        $tipos_becas = [
            '3' => 'Sep/Segey',
            '4' => 'Modelo',
            '5' => 'Otro',
            '6' => 'Sin beca',
        ];

        $ubicaciones = Ubicacion::all()
            ->where('ubiClave','<>','000')
            ->pluck('ubiNombre','ubiClave');
        $departamentos = [
            'SUP' => 'SUP',
            'POS' => 'POS',
        ];

        $meses = Utils::meses_key_int();

        return view('bachiller.egresados.edit',
            compact('fechaActual',
                'conceptos_titulacion',
                'modos_titulacion',
                'tipos_desempenio',
                'tipos_becas',
                'ubicaciones',
                'departamentos',
                'meses',
                'egresado',
                'data'));
    
    }//edit.

    public function update(Request $request, $id){
        DB::beginTransaction();
        try {
            $egresado = Egresado::findOrFail($id);
            $egresado->update([
                'egrUltimoPeriodo' => $request->perEgreso,
                'egrUltimoMesPago' => Utils::validaEmpty($request->ultMesPago),
                'egrUltimoAnioPago' => Utils::validaEmpty($request->ultAnioPago),
                'egrCreditosCursados' => $request->resCreditosCursados,
                'egrPeriodoTitulacion' => Utils::validaEmpty($request->perTitulacion),
                'egrFechaExamenProfesional' => Utils::validaEmpty($request->fechaExamenProf),
                'egrFechaExpedicionTitulo' => Utils::validaEmpty($request->fechaExpedicionTitulo),
                'egrOpcionTitulo' => Utils::validaEmpty($request->opcionTitulo),
                'egrModoTituloSegey' => Utils::validaEmpty($request->modoTitulacionSegey),
                'egrDesempenioSegey' => Utils::validaEmpty($request->desempenioProm),
                'egrTipoDesempenioSegey' => Utils::validaEmpty($request->tipoDesempenio),
                'egrTipoBecaSegey' => Utils::validaEmpty($request->tipoBeca),
                'usuario_at' => auth()->user()->id,
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit(); #TEST.
        alert()->success('Realizado','Se ha actualizado con éxito el egresado.');
        return redirect('egresados');
    }//update.

    public function show(Request $request, $id){

        $fechaActual = Carbon::now('CDT');
        $egresado = Egresado::findOrFail($id);
        $aluClave = $egresado->alumno->aluClave;
        $plan_id = $egresado->plan_id;
        $data = $this->buscarAlumno($request, $aluClave, $plan_id);

        $conceptos_titulacion = ConceptoTitulacion::all()
            ->pluck('contNombre','id');
        $modos_titulacion = ConceptoModoTitulacion::all()
            ->pluck('conmNombre','id');

        $tipos_desempenio = [
            'P' => 'Promedio',
            'E' => 'Examen Ceneval',
            'U' => 'Otro',
        ];

        $tipos_becas = [
            '3' => 'Sep/Segey',
            '4' => 'Modelo',
            '5' => 'Otro',
            '6' => 'Sin beca',
        ];

        $ubicaciones = Ubicacion::all()
            ->where('ubiClave','<>','000')
            ->pluck('ubiNombre','ubiClave');
        $departamentos = [
            'SUP' => 'SUP',
            'POS' => 'POS',
        ];

        $meses = Utils::meses_key_int();

        return view('bachiller.egresados.show',
            compact('fechaActual',
                'conceptos_titulacion',
                'modos_titulacion',
                'tipos_desempenio',
                'tipos_becas',
                'ubicaciones',
                'departamentos',
                'meses',
                'egresado',
                'data'));

    }//show

    public function destroy($id){

        $egresado = Egresado::findOrFail($id);
        $egresado->delete();

    }//destroy.


    public function obtenerPeriodos($ubiClave,$depClave){
        $anioActual = Carbon::now('CDT')->year;
        $periodos = Periodo::with('departamento.ubicacion')
        ->whereHas('departamento.ubicacion',static function ($query) use ($ubiClave,$depClave){
            $query->where('ubiClave','=',$ubiClave);
            if($depClave == 'T'){
                $query->whereIn('depClave',['SUP','POS']);
            }else{
                $query->where('depClave', $depClave);
            }
        })
        ->latest('perFechaInicial')
        ->get();

        $data = [
            'periodos' => $periodos,
        ];
        return json_encode($data);

    }//function obtenerPeriodos.

    public function list(){
        $egresados = Egresado::with(['alumno.persona','plan.programa','periodo.departamento.ubicacion', 'periodoTitulacion'])->latest();

        return DataTables::eloquent($egresados)
            ->filterColumn('aluClave', function ($query, $keyword) {
                return $query->whereHas('alumno.persona', function ($query) use ($keyword) {
                    $query->where('aluClave', $keyword);
                });
            })
            ->addColumn('aluClave', function (Egresado $egresado){
                return $egresado->alumno->aluClave;
            })
            ->filterColumn('nombreCompleto', function ($query, $keyword) {
                return $query->whereHas('alumno.persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto', function (Egresado $egresado){
                $nombre = $egresado->alumno->persona->perNombre;
                $apellido1 = $egresado->alumno->persona->perApellido1;
                $apellido2 = $egresado->alumno->persona->perApellido2;
                return $nombre.' '.$apellido1.' '.$apellido2;
            })
            ->filterColumn('periodo', function ($query, $keyword) {
                return $query->whereHas('periodo', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNumero,'-',perAnio) like ?",["%{$keyword}%"]);
                });
            })
            ->addColumn('periodo', function (Egresado $egresado){
                return $egresado->periodo->perNumero.'-'.$egresado->periodo->perAnio;
            })
            ->filterColumn('periodoTitulacion', function ($query, $keyword) {
                return $query->whereHas('periodoTitulacion', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNumero,'-',perAnio) like ?",["%{$keyword}%"]);
                });
            })
            ->addColumn('periodoTitulacion', function (Egresado $egresado){
                return $egresado->periodoTitulacion ?
                $egresado->periodoTitulacion->perNumero.'-'.$egresado->periodoTitulacion->perAnio : '';
            })
            ->filterColumn('programa', function($query, $keyword) {
                return $query->whereHas('plan.programa', function ($query) use ($keyword) {
                    $query->where('progClave', $keyword);
                });
            })
            ->addColumn('programa', function (Egresado $egresado){
                return $egresado->plan->programa->progClave;
            })
            ->filterColumn('plan', function ($query, $keyword) {
                return $query->whereHas('plan.programa', function ($query) use ($keyword) {
                    $query->where('planClave', $keyword);
                });
            })
            ->addColumn('plan', function (Egresado $egresado){
                return $egresado->plan->planClave;
            })
            ->filterColumn('ubicacion', function($query, $keyword) {
                return $query->whereHas('periodo.departamento.ubicacion', function($query) use ($keyword) {
                    $query->where('ubiClave', $keyword);
                });
            })
            ->addColumn('ubicacion', function(Egresado $egresado) {
                return $egresado->periodo->departamento->ubicacion->ubiClave;
            })
            ->addColumn('action', function (Egresado $egresado){
                $usuarioPermitido = in_array(Auth::user()->permiso('egresados'), ['A', 'B']);
                $btn_edit = $usuarioPermitido ? Utils::btn_edit($egresado->id, 'egresados') : '';

                return '<div class="row">'
                            .Utils::btn_show($egresado->id, 'egresados')
                            .$btn_edit.
                       '</div>';
            })->make(true);

    }//list

    public function buscarAlumno(Request $request, $aluClave, $plan_id = null){

        $resumen = Bachiller_resumenacademico::with('alumno','plan.programa')
        ->whereHas('alumno',static function ($query) use ($aluClave){
            if($aluClave){
                $query->where('aluClave','=',$aluClave);
            }
        })
        ->whereHas('plan.programa',static function ($query) use ($request){
            if($request->progClave){
                $query->where('progClave',$request->progClave);
            }
            if($request->planClave){
                $query->where('planClave',$request->planClave);
            }
        })
        ->where(static function ($query) use ($plan_id) {
            if($plan_id){
                $query->where('plan_id',$plan_id);
            }
        })
        ->latest('resFechaIngreso')
        ->first();

        $egresado = Egresado::with('alumno','plan')
        ->whereHas('alumno',static function ($query) use ($request,$aluClave){
            $query->where('aluClave','=',$aluClave);
        })
        ->where(static function ($query) use ($plan_id, $resumen){
            if($plan_id){
                $query->where('plan_id',$plan_id);
            }
        })
        ->first();

        $ultimoCurso = Curso::with('cgt.plan.programa','periodo.departamento')
            ->where('curEstado','<>','B')
            ->latest('curFechaRegistro')
            ->first();

        $alumno = $egresado->alumno;
        $persona = $alumno->persona;
        $plan = $egresado->plan;
        $programa = $plan->programa;
        $departamento = $egresado->periodo->departamento;
        $ubicacion = $departamento->ubicacion;

        //Buscar ultMesDePago
        $curPlanPago = $ultimoCurso->curPlanPago;
        $periodoUltimoCurso = $ultimoCurso->periodo;
        $mesPago = $egresado->egrUltimoMesPago;
        $anioPago = $egresado->egrUltimoAnioPago;
        

        $data = [
            'resumen' => $resumen,
            'alumno' => $alumno,
            'persona' => $persona,
            'plan' => $plan,
            'programa' => $programa,
            'departamento' => $departamento,
            'ubicacion' => $ubicacion,
            'egresado' => $egresado,
            'ultimoCurso' => $ultimoCurso,
            'mesPago' => $mesPago,
            'anioPago' => $anioPago,
        ];

        if($request->ajax()){
            return json_encode($data);
        }else{
            return $data;
        }
    }


}// Controller class.

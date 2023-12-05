<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Cgt;
use App\Models\Beca;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\Pago;
use App\clases\periodos\MetodosPeriodos;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class BachillerPreinscripcionAutomaticaController extends Controller
{
    public static $becas;
    public static $resumenesData;

    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:preinscripcion_automatica');
    	set_time_limit(8000000);
    }

    public function create() {
    	return view('bachiller.preinscripcion_auto.create',[
            'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function preinscribir(Request $request) {

        $cursos = Curso::with(['periodo', 'cgt.plan', 'alumno'])
        ->where('periodo_id', $request->periodo_id)
        ->where('curEstado', 'R')
        ->whereHas('cgt.plan.programa', static function($query) use ($request) {
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
        })->latest('curFechaRegistro')->get()->unique('alumno_id');

        if($cursos->isEmpty()){
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')
            ->showConfirmButton();
            return back()->withInput();
        }

        self::$becas = Beca::all()->keyBy('bcaClave');
        $cursosData = new Collection;
        $periodo = $cursos->first()->periodo;
        $periodo_siguiente = MetodosPeriodos::buscarSiguientes($periodo, $periodo->perEstado)->first();

        if(!$periodo_siguiente) {
            alert('No se pudo realizar el proceso', 'Se requiere la creación del periodo siguiente antes de realizar la Preinscripción Automática.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $cursos = self::descartar_ya_inscritos($cursos, $periodo_siguiente);
        $cursos = self::descartar_egresados($cursos);

        self::$resumenesData = Bachiller_resumenacademico::whereIn('alumno_id', $cursos->pluck('alumno_id'))
        ->whereIn('plan_id', $cursos->pluck('cgt.plan_id'))
        ->latest('resFechaIngreso')
        ->get()
        ->groupBy('alumno_id');

        $no_han_pagado = new Collection;
        if(!$periodo_siguiente->iniciaEnAgosto()) {
            $no_han_pagado = self::quienes_no_han_pagado($cursos, $periodo_siguiente);
        }

        $cursos->each(static function($curso) use ($periodo_siguiente, $no_han_pagado) {
            $alumno = $curso->alumno;
            $cgt = $curso->cgt;
            $plan = $cgt->plan;
            $alumno_deudor = $no_han_pagado->get($alumno->id);
            $no_ha_pagado = $alumno_deudor ? true : false;
            $puede_inscribirse = $alumno_deudor && $alumno_deudor->conceptos_adeudados->count() >= 4 ? false : true;

            $cgtSiguiente = self::validarCgt($cgt, $plan, $periodo_siguiente);
            if($cgtSiguiente == 'N') {
                $cgtSiguiente = self::crearCgt($cgt, $periodo_siguiente);
            }

            $curEstado = $curso->curEstado;
            if($curso->curEstado == 'R' && $no_ha_pagado)
                $curEstado = 'P';
            if($periodo_siguiente->iniciaEnAgosto())
                $curEstado = 'P'; #Todos pasan como P

            if($cgtSiguiente instanceof Cgt && $puede_inscribirse) {
                $nuevo_curso = self::registrar_nuevo_curso($curso, $cgtSiguiente, $curEstado);
                $resumen = self::procesar_resumen_academico($curso, $plan);
                if($alumno->aluEstado == 'N') {
                    $alumno->update(['aluEstado' => 'R']);
                }

            }
        });

        alert('Realizado','Se ha realizado la preinscripción Automática de ' .$cursos->count(). ' alumnos en el periodo '.$periodo_siguiente->perNumero.'/'.$periodo_siguiente->perAnio, 'success')
        ->showConfirmButton();
        return back()->withInput();
    }//preinscribir.

    /**
    * Verifica que no sea el último grado del alumno.
    * Busca el cgtSiguiente y si existe, retorna sus datos.
    *
    * @param App\Models\Cgt
    * @param App\Models\Plan
    * @param App\Models\Periodo $periodo_siguiente
    */
    public static function validarCgt($cgt, $plan, $periodo_siguiente){

        if($cgt->cgtGradoSemestre < $plan->planPeriodos) {
            $cgtSiguiente = Cgt::where('periodo_id', $periodo_siguiente->id)
                ->where('plan_id', $plan->id)
                ->where('cgtGradoSemestre', $cgt->cgtGradoSemestre + 1)
                ->where('cgtGrupo', $cgt->cgtGrupo)
                ->first();

            return $cgtSiguiente ?: 'N'; # 'N' no existe cgt.
        }

        return 'esUltGrado';
    }

    /**
    * @param App\Models\Cgt
    * @param App\Models\Periodo
    */
    private static function crearCgt($cgt, $periodo) {

        return Cgt::create([
            'plan_id' => $cgt->plan_id,
            'periodo_id' => $periodo->id,
            'cgtGradoSemestre' => $cgt->cgtGradoSemestre + 1,
            'cgtGrupo' => $cgt->cgtGrupo,
            'cgtTurno' => $cgt->cgtTurno,
            'cgtCupo' => $cgt->cgtCupo,
            'empleado_id' => 0,
            'cgtEstado' => $cgt->cgtEstado,
            'cgtDescripcion' => 'CreadoPorScem', #TEST
            'cgtTotalRegistrados' => null,
            'cgtInscritos' => null,
            'cgtPreinscritos' => null,
            'cgtBaja' => null,
            'cgtOtros' => null,
        ]);
    }

    /**
    * @param Collection $cursos
    * @param App\Models\Periodo $periodo_siguiente
    */
    private static function descartar_ya_inscritos($cursos, $periodo_siguiente) : Collection
    {
        $inscritos = Curso::where('periodo_id', $periodo_siguiente->id)
        ->whereIn('alumno_id', $cursos->pluck('alumno_id'))
        ->get()->keyBy('alumno_id');

        return $cursos->whereNotIn('alumno_id', $inscritos->keys());
    }

    /**
    * @param Collection
    */
    private static function descartar_egresados($cursos) : Collection
    {
        return $cursos->filter(static function($curso) {
            $cgt = $curso->cgt;
            $plan = $cgt->plan;

            return $cgt->cgtGradoSemestre < $plan->planPeriodos; #No es último semestre.
        });
    }

    /**
    * @param App\Models\Curso $curso
    * @param App\Models\Cgt $cgtSiguiente
    * @param string $curEstado
    */
    private static function registrar_nuevo_curso($curso, $cgtSiguiente, $curEstado)
    {
        $esBecaSemestral = false;
        if($curso->curTipoBeca) {
            $beca = self::$becas->get($curso->curTipoBeca);
            $esBecaSemestral = ($beca && $beca->bcaVigencia == 'S');
        }
        return Curso::create([
            'alumno_id' => $curso->alumno_id,
            'cgt_id' => $cgtSiguiente->id,
            'periodo_id' => $cgtSiguiente->periodo_id,
            'curTipoBeca' => $esBecaSemestral ? null : $curso->curTipoBeca,
            'curPorcentajeBeca' => $esBecaSemestral ? null : $curso->curPorcentajeBeca,
            'curObservacionesBeca' => $esBecaSemestral ? "Tuvo beca semestral {$curso->curTipoBeca}{$curso->curPorcentajeBeca}" : $curso->curObservacionesBeca,
            'curFechaRegistro' => Carbon::now('America/Merida')->format('Y-m-d'),
            'curFechaBaja' => null,
            'curEstado' => $curEstado,
            'curTipoIngreso' => 'RI',
            'curImporteInscripcion' => null,
            'curImporteMensualidad' => null,
            'curImporteVencimiento' => null,
            'curImporteDescuento' => null,
            'curDiasProntoPago' => null,
            'curPlanPago' => $curso->curPlanPago,
            'curOpcionTitulo' => $curso->curOpcionTitulo,
            'curAnioCuotas' => $curso->curAnioCuotas,
        ]);
    }

    /**
    * @param App\Models\Curso $curso_anterior
    * @param App\Models\Plan
    */
    private static function procesar_resumen_academico($curso_anterior, $plan) {
        $resumenes_alumno = self::$resumenesData->pull($curso_anterior->alumno_id) ?: new Collection;
        $resumen = $resumenes_alumno->where('plan_id', $plan->id)->first();

        if(!$resumen) {
            $resumen = Bachiller_resumenacademico::create([
                'alumno_id' => $curso_anterior->alumno_id,
                'plan_id' => $plan->id,
                'resClaveEspecialidad' => null,
                'resPeriodoIngreso' => $curso_anterior->periodo->id,
                'resPeriodoEgreso' => null,
                'resPeriodoUltimo' => $curso_anterior->periodo->id,
                'resUltimoGrado' => 0,
                'resCreditosCursados' => 0,
                'resCreditosAprobados' => 0,
                'resAvanceAcumulado' => 0,
                'resPromedioAcumulado' => 0,
                'resEstado' => 'R',
                'resFechaIngreso' => $curso_anterior->curFechaRegistro ?: Carbon::parse($curso_anterior->created_at)->format('Y-m-d'),
                'resFechaEgreso' => null,
                'resFechaBaja' => null,
                'resRazonBaja' => null,
                'resObservaciones' => 'CreadoPorScem', #TEST
            ]);
        }

        return $resumen;
    }

    /**
    * @param Collection $cursos
    * @param App\Models\Periodo $periodo_siguiente
    */
    private static function quienes_no_han_pagado($cursos, $periodo_siguiente) {
        $cursos_regulares = $cursos->where('curEstado', 'R');
        if($cursos_regulares->isEmpty()) return new Collection();

        $ubicacion = $periodo_siguiente->departamento->ubicacion;
        $pagosData = self::buscarPagos($cursos_regulares, $periodo_siguiente);

        return $cursos_regulares->filter(static function($curso) use ($pagosData, $ubicacion) {
            $alumno = $curso->alumno;
            $pagos_alumno = $pagosData->pull($alumno->aluClave) ?: new Collection;
            $conceptos = self::obtener_conceptos_requeridos($curso->curPlanPago, $ubicacion);
            $curso->conceptos_adeudados = self::faltan_pagos($pagos_alumno, $conceptos);

            return ($pagos_alumno->isEmpty() || $curso->conceptos_adeudados->isNotEmpty());
        })
        ->keyBy('alumno_id');
    }

    /**
    * @param Collection $cursos
    * @param App\Models\Periodo
    */
    private static function buscarPagos($cursos, $periodo) {

        return Pago::whereIn('pagClaveAlu', $cursos->pluck('alumno.aluClave'))
        ->where('pagAnioPer', $periodo->perAnioPago)
        ->whereIn('pagConcPago', ['99', '01', '02', '03', '04', '05'])
        ->get()->groupBy('pagClaveAlu');
    }

    /**
    * @param string $curPlanPago
    * @param App\Models\Ubicacion
    */
    private static function obtener_conceptos_requeridos($curPlanPago, $ubicacion) {

        return collect(['99']);

        /*
        if($curPlanPago == 'N' && $ubicacion->ubiClave != 'CVA') {
            return collect(['00']);
        }

        return collect(['01', '02', '03', '04', '05']);
        */
    }

    /**
    * @param Collection $pagos
    * @param Collection $conceptos
    */
    private static function faltan_pagos($pagos, $conceptos) {
        $pagados = $pagos->pluck('pagConcPago')->unique();

        return $conceptos->diff($pagados);
    }

}//FIN Controller class.

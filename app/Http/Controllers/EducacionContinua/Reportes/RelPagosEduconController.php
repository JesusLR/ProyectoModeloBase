<?php

namespace App\Http\Controllers\EducacionContinua\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Pago;
use App\Models\Ficha;
use App\Http\Helpers\Utils;
use App\Models\Empleado;
use App\Models\TiposPrograma;
use App\Models\InscritosEduCont;
use App\Models\EducacionContinua;
use App\clases\personas\MetodosPersonas as Personas;

use DB;
use PDF;
use Carbon\Carbon;

class RelPagosEduconController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:rel_pagos_edu_continua');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    $tiposPrograma = TiposPrograma::get();
    $empleados = Empleado::where("empEstado", "=", "A")->get();

    return View('educacion_continua/reportes.pagos.create', [
      'tiposPrograma' => $tiposPrograma,
      'empleados'     => $empleados
    ]);
  }


  public function imprimir(Request $request)
  {
    $programas = EducacionContinua::with(['periodo', 'ubicacion', 'escuela', 'tipoprograma'])
    ->where(static function($query) use ($request) {
      if($request->tipoprograma_id)
        $query->where('tipoprograma_id', $request->tipoprograma_id);
      if($request->educacioncontinua_id)
        $query->where('id', $request->educacioncontinua_id);
      if($request->ecFechaRegistro)
        $query->where('ecFechaRegistro', $request->ecFechaRegistro);
      if($request->ecClave)
        $query->where('ecClave', $request->ecClave);
      if($request->ecCoordinador_empleado_id)
        $query->where('ecCoordinador_empleado_id', $request->ecCoordinador_empleado_id);
      if($request->ecInstructor1_empleado_id)
        $query->where('ecInstructor1_empleado_id', $request->ecInstructor1_empleado_id);
      if($request->ecInstructor2_empleado_id)
        $query->where('ecInstructor2_empleado_id', $request->ecInstructor2_empleado_id);
      if($request->ecEstado)
        $query->where('ecEstado', $request->ecEstado);
    })
    ->whereHas('periodo', static function($query) use ($request) {
      if($request->perAnio)
        $query->where('perAnio', $request->perAnio);
      if($request->perNumero)
        $query->where('perNumero', $request->perNumero);
    })
    ->whereHas('ubicacion', static function($query) use ($request) {
      if($request->ubiClave)
        $query->where('ubiClave', $request->ubiClave);
    })
    ->whereHas('escuela', static function($query) use ($request) {
      if($request->escClave)
        $query->where('escClave', $request->escClave);
    })->get()->map(static function($programa) {

      return self::obtenerInfoPrograma($programa);
    });

    if($programas->isEmpty()) return self::alert_verificacion();

   //dd($programas);
    # ----------------------------------------------------------------
    $inscritos = new Collection;
    InscritosEduCont::with(['alumno.persona'])
    ->where(static function($query) use ($programas) {
      if($programas->isNotEmpty())
        $query->whereIn('educacioncontinua_id', $programas->pluck('id'));
    })
    ->whereHas('alumno.persona', static function($query) use ($request) {
      if($request->aluClave)
        $query->where('aluClave', $request->aluClave);
      if($request->nombreCompleto)
        $query->whereNombreCompleto($request->nombreCompleto);
    })->chunk(100, static function($registros) use ($inscritos) {

      if($registros->isEmpty()) return false;

      $registros->each(static function($inscrito) use ($inscritos) {
        $info = self::obtenerInfoInscrito($inscrito);
        $inscritos->push($info);
      });
    });

    if($inscritos->isEmpty()) return self::alert_verificacion();

    //dd($programas, $inscritos);
    # -----------------------------------------------------------------
    $conceptosEducacionContinua = ['90', '91', '92', '93', '94', '95', '96', '97', '98'];
    $alumnos_claves = $inscritos->pluck('clave_alumno')->unique();
    $aniosPago = $programas->pluck('perAnioPago')->unique();
    $pagosData = new Collection;
    Pago::whereIn('pagClaveAlu', $alumnos_claves)
    ->whereIn('pagConcPago', $conceptosEducacionContinua)
    ->whereIn('pagAnioPer', $aniosPago)
    ->chunk(100, static function($pagos) use ($pagosData) {

      if($pagos->isEmpty()) return false;

      $pagos->each(static function($pago) use ($pagosData) {
        $info = self::obtenerInfoPago($pago);
        $pagosData->push($info);
      });
    });

    //dd($pagosData);

    $pagosData =  $pagosData->keyBy('clave_alumno');


    $programas->transform(static function($programa) use ($pagosData, $inscritos)
    {
        $pagos_carrera = $pagosData;
        $inscritos_carrera = $inscritos;

        //dd($inscritos_carrera,$pagos_carrera );
        $inscritos_carrera->transform(static function($inscrito) use ($pagos_carrera)
        {
            $pagos = $pagos_carrera->get($inscrito['clave_alumno']) ?: collect([]);
            //$key = array_search('90', $pagos);
            //dd($pagos, $key);

            if (!($pagos instanceof Illuminate\Database\Eloquent\Collection)) {
                //SOLO REGRESA UN REGISTRO Y LO CONVIERTE EN ARRAY
                $pagos = collect([$pagos]);
            }

            $pago_inscripcion = $pagos->where('concepto', '90')->first();
            $pago_inscripcion2 = $pagos->where('concepto', '98')->first();
            $pago1 = $pagos->where('concepto', '91')->first();
            $pago2 = $pagos->where('concepto', '92')->first();
            $pago3 = $pagos->where('concepto', '93')->first();
            $pago4 = $pagos->where('concepto', '94')->first();
            $pago5 = $pagos->where('concepto', '95')->first();
            $pago6 = $pagos->where('concepto', '96')->first();
            $pago7 = $pagos->where('concepto', '97')->first();
            $inscrito['pago_inscripcion'] = $pago_inscripcion ? $pago_inscripcion['fecha_pago'] : '';
            $inscrito['pago_inscripcion2'] = $pago_inscripcion2 ? $pago_inscripcion2['fecha_pago'] : '';
            $inscrito['pago1'] = $pago1 ? $pago1['fecha_pago'] : '';
            $inscrito['pago2'] = $pago2 ? $pago2['fecha_pago'] : '';
            $inscrito['pago3'] = $pago3 ? $pago3['fecha_pago'] : '';
            $inscrito['pago4'] = $pago4 ? $pago4['fecha_pago'] : '';
            $inscrito['pago5'] = $pago5 ? $pago5['fecha_pago'] : '';
            $inscrito['pago6'] = $pago6 ? $pago6['fecha_pago'] : '';
            $inscrito['pago7'] = $pago7 ? $pago7['fecha_pago'] : '';

            return $inscrito;
        });
        $programa->put('inscritos', $inscritos_carrera);


        return $programa;

    });

    //dd($programas);

    $programas = $programas->filter(static function($programa) {
      return $programa['inscritos']->isNotEmpty();
    });




    $registroUltimoPago = Pago::where("pagFormaAplico", "=", "A")->latest()->first();
    $registroUltimoPago = Utils::fecha_string($registroUltimoPago->pagFechaPago, 'mesCorto');

    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_rel_pagos_educontinua';
    $pdf = PDF::loadView('educacion_continua.pdf.'. $nombreArchivo, [
      "programas" => $programas,
      "registroUltimoPago" => $registroUltimoPago,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
    ]);

    return $pdf->stream($nombreArchivo);
  }# imprimir


  /**
  * @param App\Models\EducacionContinua $programa
  */
  private static function obtenerInfoPrograma($programa)
  {
    $ubicacion = $programa->ubicacion;
    $periodo = $programa->periodo;

    return collect([
      'id' => $programa->id,
      'clave' => $programa->ecClave,
      'nombre' => $programa->ecNombre,
      'perAnioPago' => $programa->periodo->perAnioPago,
      'tipo_programa' => $programa->tipoprograma->tpNombre,
      'ubicacion' => $ubicacion->ubiClave.'-'.$ubicacion->ubiNombre,
      'periodo_inicio' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
      'periodo_fin' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
    ]);
  }


  /**
  * @param App\Models\InscritosEduCont $inscrito
  */
  private static function obtenerInfoInscrito($inscrito)
  {
    $alumno = $inscrito->alumno;

    return collect([
      'educacioncontinua_id' => $inscrito->educacioncontinua_id,
      'clave_alumno' => $alumno->aluClave,
      'nombreCompleto' => Personas::nombreCompleto($alumno->persona, true),
    ]);
  }


  /**
  * @param App\Models\Pago $pago
  */
  private static function obtenerInfoPago($pago)
  {
    return [
      'clave_alumno' => $pago->pagClaveAlu,
      'anioPago' => $pago->pagAnioPer,
      'concepto' => $pago->pagConcPago,
      'referencia' => $pago->pagRefPago,
      'fecha_pago' => Utils::fecha_string($pago->pagFechaPago, 'mesCorto'),
    ];
  }


  /**
  * @param App\Models\Ficha
  */
  private static function obtenerInfoFicha($ficha)
  {
    return [
      'referencia' => $ficha->fhcRef1,
      // 'clave_carrera' => $ficha->fchClaveCarr,
      'clave_carrera' => $ficha->fchClaveProgAct,
    ];
  }

  public static function alert_verificacion() {
    alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
    return back()->withInput();
  }

}

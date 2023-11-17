<?php

namespace App\Http\Controllers\Reportes;

use Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Curso;
use App\Http\Models\Pago;
use App\Http\Models\ConceptoPago;
use App\Http\Models\Mensaje;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas as Personas;
use App\clases\cgts\MetodosCgt;
use App\clases\SCEM\Mailer as ScemCorreo;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class RecordatorioPagosController extends Controller
{
    //
    public $cursos;
    public $conceptosPago;
    public $periodo;

    public function __construct() {
    	$this->middleware(['auth', 'permisos:recordatorioPagos']);
    }

    public function reporte() {

    	return view('reportes/recordatorio_pagos.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'meses' => Utils::meses_orden_escolar(),
    		'hoy' => Carbon::now('America/Merida'),
    		'mensaje' => Mensaje::delModulo('recordatorioPagos')->latest()->first(),
    	]);
    }

    public function imprimir(Request $request) {
		$perState = in_array($request->departamento_id, [11,13,14,15,19,26]) ? 'A' : 'S'; // los numeros indican los id de maternal a secundaria departamento_id
    	$this->conceptosPago = self::mapa_conceptos_pago();
    	$this->periodo = Periodo::with('departamento.ubicacion')
    	->where('departamento_id', $request->departamento_id)
    	->where('perEstado', $perState)
    	->where('perAnioPago', $request->ciclo_escolar)
    	->first();
    	$departamento = $this->periodo->departamento;
    	$ubicacion = $departamento->ubicacion;
        $perActual = $departamento->periodoActual->id;
        // dd ($perActual);
    	# -----------------------------------------------------------
    	$mensaje = Mensaje::findOrFail($request->mensaje_id);
    	if($mensaje->msjMensaje != $request->mensaje_agregado) {
    		$mensaje->update(['msjMensaje' => $request->mensaje_agregado]);
    	}
    	# -----------------------------------------------------------
    	$hoy = Carbon::now('America/Merida');
    	$ultimaFecha = Carbon::parse(Pago::ultimoPagoAutomatico()->pagFechaPago);
    	$this->cursos = new Collection;
    	$this->concepto_limite = $request->meses ?: Utils::obtenerMesEscolar($hoy->month);

    	Curso::with(['alumno.persona', 'cgt.plan.programa'])
    	->where(static function($query) use ($request) {
    		if($request->estado_curso)
    			$query->whereIn('curEstado', explode("-", $request->estado_curso));
    	})
    	->whereHas('periodo', function($query) use ($request, $perActual) {
            // $query->where('perAnioPago', $this->periodo->perAnioPago);
    		$query->where('id', $perActual);
    	})
    	->whereHas('cgt.plan.programa', static function($query) use ($request) {
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    		if($request->programa_id)
    			$query->where('programa_id', $request->programa_id);
    		if($request->cgtGradoSemestre)
    			$query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
    		if($request->cgtGrupo)
    			$query->where('cgtGrupo', $request->cgtGrupo);
    	})
    	->whereHas('alumno.persona', static function($query) use ($request) {
    		$query->where('aluEstado', '<>', 'B');
    		if($request->aluMatricula)
    			$query->where('aluMatricula', $request->aluMatricula);
    		if($request->aluClave)
    			$query->where('aluClave', $request->aluClave);
    		if($request->nombres)
    			$query->where('perNombre', 'like', "%{$request->nombres}%");
    		if($request->apellidos)
    			$query->whereApellidos($request->apellidos);
    	})->chunk(200, function($cursos) use ($request) {

    		if($cursos->isEmpty()) return false;

    		$pagosData = self::buscarPagosDeAlumnos($cursos->pluck('alumno'), $this->periodo);
    		$cursos->each(function($curso) use ($pagosData, $request) {
				// if (self::semestre_inmediato_anterior($curso)) {
					$info = self::infoEsencialCurso($curso);
					if (in_array($request->departamento_id, [7,11,13,14,15,19,26])) { // si el departamento es de MAT a BAC entonces ignoramos el concepto 00 inscripción de enero
						if ( isset($info['conceptos'][6]) ) unset($info['conceptos'][6]);
					}
					$course = self::semestre_inmediato_anterior($curso);
					if ($course) {
						if ($course->periodo->perNumero != 3) {
							// if ( isset($info['conceptos'][0]) ) unset($info['conceptos'][0]);
							// if ( isset($info['conceptos'][1]) ) unset($info['conceptos'][1]);
							// if ( isset($info['conceptos'][2]) ) unset($info['conceptos'][2]);
							// if ( isset($info['conceptos'][3]) ) unset($info['conceptos'][3]);
							// if ( isset($info['conceptos'][4]) ) unset($info['conceptos'][4]);
							// if ( isset($info['conceptos'][5]) ) unset($info['conceptos'][5]);
						}
					} else {
						if ( isset($info['conceptos'][0]) ) unset($info['conceptos'][0]);
						if ( isset($info['conceptos'][1]) ) unset($info['conceptos'][1]);
						if ( isset($info['conceptos'][2]) ) unset($info['conceptos'][2]);
						if ( isset($info['conceptos'][3]) ) unset($info['conceptos'][3]);
						if ( isset($info['conceptos'][4]) ) unset($info['conceptos'][4]);
						if ( isset($info['conceptos'][5]) ) unset($info['conceptos'][5]);
					}
					$pagos = $pagosData->get($info['aluClave']);
					if ($pagos) { // validación $pagos null
						$adeudos = $this->obtenerPagosFaltantes($info, $pagos);
						if($adeudos->isNotEmpty()) {
							$info->put('adeudos', $adeudos);
							$this->cursos->push($info);
						}
					}
				// }
    		});
    	});

    	if($this->cursos->isEmpty()) {
	    	alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
    		return back()->withInput();
    	}

		$nombreArchivo = 'pdf_recordatorio_pagos';
    	$info_general['fechaActual'] = Utils::fecha_string(Carbon::now('America/Merida'));
    	$info_general['cursos'] = $this->cursos->unique('alumno_id')->sortBy('orden');
    	$info_general['departamento'] = $departamento;
    	$info_general['ubicacion'] = $ubicacion->load('municipio.estado');
    	$info_general['ultimaFecha'] = Utils::fecha_string($ultimaFecha);
    	$info_general['mensaje'] = $mensaje->msjMensaje;
    	$info_general['mensaje_agregado'] = $request->mensaje_agregado ?: '';

    	if($request->accion == 'PDF') {
    		return PDF::loadView("reportes.pdf.{$nombreArchivo}", $info_general)->stream($nombreArchivo.'.pdf');
    	} else {
    		return view('reportes/recordatorio_pagos.lista_para_correos', $info_general);
    	}
    }#imprimir

    /**
    * @param App\Http\Models\Curso
    */
    private static function infoEsencialCurso($curso) {
    	$alumno = $curso->alumno;
    	$cgt = $curso->cgt;
    	$programa = $cgt->plan->programa;
    	$nombreCompleto = Personas::nombreCompleto($alumno->persona, true);
    	$cgt_orden = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);

    	return collect([
    		'curso_id' => $curso->id,
    		'alumno_id' => $alumno->id,
    		'aluClave' => $alumno->aluClave,
    		'nombreCompleto' => $nombreCompleto,
    		'grado' => $cgt->cgtGradoSemestre,
    		'grupo' => $cgt->cgtGrupo,
    		'plan_pago' => $curso->curPlanPago,
    		'programa' => $programa->progNombre,
    		'beca' => $curso->curPorcentajeBeca ? "Beca: {$curso->curPorcentajeBeca}%" : '',
			'curPorcentajeBeca' => $curso->curPorcentajeBeca,
    		'conceptos' => collect(Utils::mensualidadesDeCurso($curso->curPlanPago)),
    		'email' => "{$alumno->aluClave}@modelo.edu.mx",
    		'orden' => "{$programa->progNombre}-{$cgt_orden}-{$nombreCompleto}",
    	]);
    }

	    /**
    * @param App\Http\Models\Curso
    */
    private static function semestre_inmediato_anterior($curso) {
		$perAnioPago = $curso->periodo->perAnioPago;
		$perNumero = $curso->periodo->perNumero;
		return Curso::with('cgt', 'alumno', 'periodo')
		->whereHas('periodo', function ($query) use ($perNumero, $perAnioPago) {
			$query->where('perNumero', $perNumero);
			$query->where('perAnio', $perAnioPago);
		})
		->where('alumno_id', $curso->alumno->id)
		->where('curEstado', '!=', 'B')
		->first();
		//
		$curso_anterior = $curso->id ? Curso::find($curso->id) : null;

        // $semestre_inmediato_anterior es para obtener el curso anterior pero sin saltar de semestre
        $semestre_inmediato_anterior = null;
        if ($curso_anterior) {
            $perEstado = $curso_anterior->periodo->perEstado;
            //aqui va la logica si es semestral o cuatrimestral 
            if ($perEstado == 'S') {
                // 3 2022, 1 2023
                $perNumero = $curso_anterior->periodo->perNumero == 3 ? 1 : 3;
                $perAnio = $curso_anterior->periodo->perNumero == 3 ? $curso_anterior->periodo->perAnio : ($curso_anterior->periodo->perAnio-1);
            } elseif ($perEstado == 'C') {
                // 6 2022, 4 2023 y 5 2023
                if ($curso_anterior->periodo->perNumero == 5) {
                    $perNumero = 4;
                    $perAnio = $curso_anterior->periodo->perAnio;
                } elseif ($curso_anterior->periodo->perNumero == 4) {
                    $perNumero = 6;
                    $perAnio = ($curso_anterior->periodo->perAnio-1);
                } else {
                    $perNumero = 5;
                    $perAnio = $curso_anterior->periodo->perAnio;
                }
            } else {
				return true;
            }
            if ($perEstado == 'S' || $perEstado == 'C') {
                // entonces obtenemos el curso anterior
                $semestre_inmediato_anterior = Curso::with('cgt', 'alumno', 'periodo')
                ->whereHas('periodo', function ($query) use ($perNumero, $perAnio) {
                    $query->where('perNumero', $perNumero);
                    $query->where('perAnio', $perAnio);
                })
                ->where('alumno_id', $curso_anterior->alumno->id)
				->where('curEstado', '!=', 'B')
                ->first();
            }
        }
		return $semestre_inmediato_anterior ? true : false;
	}

    /**
    * @param Collection $alumnos
    * @param App\Http\Models\Periodo $periodo
    */
    private static function buscarPagosDeAlumnos($alumnos, $periodo) {

    	return Pago::whereIn('pagClaveAlu', $alumnos->pluck('aluClave'))
    	->where('pagAnioPer', $periodo->perAnioPago)
    	->inscripciones_Colegiaturas()
    	->get()->groupBy('pagClaveAlu');
    }

    /**
    * @param Collection $info
    * @param Collection $pagos
    */
    private function obtenerPagosFaltantes($info, $pagos = null) {
    	$adeudos = new Collection;
		$becaMenor100ONull = ( $info['curPorcentajeBeca'] < 100 || is_null($info['curPorcentajeBeca']) );
    	if(!$pagos && $becaMenor100ONull) {
    		#Debe todos los conceptos.
    		return $this->filtrar_conceptos_anteriores_o_igual_al_limite($this->conceptosPago);
    	}

		// dd(isset($info['conceptos'][11]), $info['conceptos']);
		if ($info['curPorcentajeBeca'] == 100) {

			if ( isset($info['conceptos'][1]) ) unset($info['conceptos'][1]);
			if ( isset($info['conceptos'][2]) ) unset($info['conceptos'][2]);
			if ( isset($info['conceptos'][3]) ) unset($info['conceptos'][3]);
			if ( isset($info['conceptos'][4]) ) unset($info['conceptos'][4]);
			if ( isset($info['conceptos'][5]) ) unset($info['conceptos'][5]);

			if ( isset($info['conceptos'][7]) ) unset($info['conceptos'][7]);
			if ( isset($info['conceptos'][8]) ) unset($info['conceptos'][8]);
			if ( isset($info['conceptos'][9]) ) unset($info['conceptos'][9]);
			if ( isset($info['conceptos'][10]) ) unset($info['conceptos'][10]);
			if ( isset($info['conceptos'][11]) ) unset($info['conceptos'][11]);
			if ( isset($info['conceptos'][12]) ) unset($info['conceptos'][12]);
			if ( isset($info['conceptos'][13]) ) unset($info['conceptos'][13]);
		}
    	if($info['plan_pago'] == 'A') unset($info['conceptos'][6]);

    	$info['conceptos']->each(function($concepto, $key) use ($pagos, $adeudos) {
    		$pago = $pagos->where('pagConcPago', $concepto)->first();
    		if(!$pago) {
    			$info_adeudo = $this->conceptosPago->get($concepto);
    			$adeudos->push($info_adeudo);
    		}
    	});

    	return $this->filtrar_conceptos_anteriores_o_igual_al_limite($adeudos);
    }

    /**
    * Mapea los conceptos correspondientes a los pagos de inscripciones y colegiaturas
    * de un ciclo escolar.
    */
    private static function mapa_conceptos_pago()
    {
    	return ConceptoPago::inscripciones_Colegiaturas()
    	->get()
    	->map(static function($concepto) {
    		$clave = $concepto->conpClave;
    		$nombre_concepto = $concepto->conpNombre;
    		$num_orden = intval($concepto->conpClave);

    		switch ($clave) {
    			case '99':
    				$clave = '01'; #Septiembre en mes escolar.
    				// $nombre_concepto .= ' Agosto';
    				$num_orden = 0.5;
    				break;
    			case '00':
    				$clave = '05'; #Enero en mes escolar.
    				// $nombre_concepto .= ' Enero';
    				$num_orden = 5.5;
    		}

    		return collect([
    			'nombre_concepto' => $nombre_concepto,
    			'clave_concepto' => $concepto->conpClave,
    			'concepto_int' => intval($clave),
    			'orden' => $num_orden,
    		]);
    	})->sortBy('orden')->keyBy('clave_concepto');
    }

    /**
    * @param Collection
    */
    private function filtrar_conceptos_anteriores_o_igual_al_limite($adeudos)
    {
    	return $adeudos->filter(function($adeudo) {
    		return $adeudo['orden'] <= $this->concepto_limite;
    	})->sortBy('orden');
    }

    public function enviar_correo(Request $request, $curso_id) {
    	$curso = $request->curso;
    	$info['username_email'] = "colegiaturas@modelo.edu.mx"; // "colegiaturas@unimodelo.com";
    	$info['password_email'] = "Tok47343"; // "ZVB8z7DYKf";

    	$info['to_email'] = $curso['email'];
    	$info['to_name'] = $curso['nombreCompleto'];
    	// $info['to_email'] = "flopezh@modelo.edu.mx"; # TEST
    	// $info['to_name'] = "Francisco Lopez"; # TEST

    	$info['cc_email'] = "";
    	$info['subject'] = "Aviso de Colegiaturas, Clave de alumno: {$curso['aluClave']}";
    	$info['body'] = $this->mensaje_recordatorio_pago($request);

    	try {
    		$mail = new ScemCorreo($info);
    		$mail->enviar();
    	} catch (Exception $e) {
    		return response()->json([
    			'status' => 'error',
    			'title' => 'Ha ocurrido un error',
    			'msg' => $e->getMessage(),
    		]);
    	}

    	return response()->json([
    		'status' => 'success',
    		'title' => 'Envío Exitoso!',
    		'msg' => "Se ha enviado el recordatorio de pago al alumno {$curso['aluClave']} - {$curso['nombreCompleto']}",
    	]);
    }#enviar_correo

    private function mensaje_recordatorio_pago($request) {
    	$departamento = $request->departamento;
    	$ubicacion = $request->ubicacion;
    	$curso = $request->curso;
    	$saludo_inicial = ($departamento['depClave'] == 'POS' || $departamento['depClave'] == 'SUP') ? 'Estimado: ' : 'Sr. Padre de familia de: ';

    	$adeudos = '';
    	foreach ($curso['adeudos'] as $adeudo) {
    		$adeudos .= strtoupper($adeudo['nombre_concepto']).'<br>';
    	}
		$lang = Lang::get('recordatorios/RecordatorioPago.acuerdo', ['ultimaFecha' => $request->ultimaFecha]);
    	return "<p>{$saludo_inicial} {$curso['nombreCompleto']}</p>
    	<br>
    	<p>
    	{$lang}
    	</p>
    	<br>
    	<p>{$adeudos}</p>
    	<br>
    	<p>{$request->mensaje_agregado}</p>
    	<p style='text-align: center;'>Por su atención al presente, reiterámosle nuestro reconocimiento</p>
    	<p style='text-align: center;'>Atentamente:</p>
        <p style='text-align: center;'>COORDINACIÓN ADMINISTRATIVA</p>
    	<p>{$ubicacion['ubiClave']} {$curso['programa']}</p>
    	<p style='text-align: center;'>
    	Gra/Sem: {$curso['grado']} Grupo: {$curso['grupo']}
    	Clave de pago: {$curso['aluClave']} {$curso['beca']}
    	</p>
    	";
    } # mensaje_recordatorio_pago <p>{$request->mensaje}</p>

}

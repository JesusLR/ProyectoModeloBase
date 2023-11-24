<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Curso;
use App\Models\Ubicacion;
use App\Models\Cuota;
use App\Models\Pago;
use App\Http\Helpers\GenerarReferencia;
use Carbon\Carbon;

use App\Http\Helpers\Utils;

use PDF;

use Ficha;


class TarjetaPagoController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
			$this->middleware('auth');
			$this->middleware('permisos:r_tarjeta_pago');
	}


	public function reporte()
	{
			$ubicaciones = Ubicacion::all();
			$tiposBeca = [
					'S' => 'SEP',
					'C' => 'CONSEJO',
					'H' => 'HERMANOS',
					'E' => 'EMPLEADO',
					'F' => 'FERNANDO PONCE',
					'R' => 'RECOMENDACIÓN',
					'L' => 'LIGA A.S.',
					'X' => 'EXCELENCIA',
					'T' => 'LEALTAD',
			];
			$estadoCurso = [
					'P' => 'PREINSCRITO',
					'R' => 'REGULAR',
					'C' => 'CONDICIONADO',
					'A' => 'CONDICIONADO 2',
					'B' => 'BAJA',
			];
			return View('reportes/tarjeta_pago.create', compact('ubicaciones','tiposBeca','estadoCurso'));
	}



	public function tarjetaPagoAlumno($curso_id)
	{
		$curso = Curso::where('id', '=', $curso_id)->first();

		//INSCRIPCION SIEMPRE VA POR LA CUOTA ACTUAL
		$departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
		$escuelaId = $curso->cgt->plan->programa->escuela->id;
		$programaId = $curso->cgt->plan->programa->id;
		//AÑO DE LA INSCRIPCION - PERIODO AÑO DE PAGO
		$perAnioPago = $curso->periodo->perAnioPago;


		$aluClave = $curso->alumno->aluClave;


		$perAnioPagoInscripcion = $perAnioPago + 1;
		$cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $perAnioPago]])->first();
		$cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $perAnioPago]])->first();
		$cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $perAnioPago]])->first();

		if ($cuotaDep) {
			$cuotaActual = $cuotaDep;
		}
		if ($cuotaEsc) {
			$cuotaActual = $cuotaEsc;
		}
		if ($cuotaProg) {
			$cuotaActual = $cuotaProg;
		}


		$convenio = $cuotaActual->cuoNumeroCuenta;
		//SI EL ALUMNO TIENE UNA INSCRIPCION ESPECIAL, SE SUSTITUYE LA ACTUAL POR LA ESPECIAL
		$importeInscripcion = $cuotaActual->cuoImporteInscripcion1;
		if ($curso->curImporteInscripcion != null) {
			$importeInscripcion = $curso->curImporteInscripcion;
		}

    $curDate = Carbon::now();


		// SACAR VENCIMIENTOS /REFERENCIAS DE INSCRIPCION
		$fechaInscripcion1 = "15/Ene/$perAnioPagoInscripcion";
		$esFechaInscripcion1Vencida = $curDate->setTime(0, 0, 0)->gt(Carbon::parse("$perAnioPagoInscripcion-01-15")->setTime(0, 0, 0));

		$fechaInscripcion2 = "31/Ene/$perAnioPagoInscripcion";
		$esFechaInscripcion2Vencida = $curDate->setTime(0, 0, 0)->gt(Carbon::parse("$perAnioPagoInscripcion-01-31")->setTime(0, 0, 0));

		$fechaInscripcion3 = "20/Feb/$perAnioPagoInscripcion";
		$esFechaInscripcion3Vencida = $curDate->setTime(0, 0, 0)->gt(Carbon::parse("$perAnioPagoInscripcion-02-20")->setTime(0, 0, 0));


		$fechaInscripcionUltimoAtraso = "";
		$fechaInscUltimoAtrasoRef = "";
		if ($esFechaInscripcion3Vencida) {
			$fechaInscripcionUltimoAtraso = $curDate->addDays(7);
			$dia  = $fechaInscripcionUltimoAtraso->day;
			$mesString  = Utils::num_meses_corto_string($fechaInscripcionUltimoAtraso->month);
			$mes  = $fechaInscripcionUltimoAtraso->month;
			$anio = $fechaInscripcionUltimoAtraso->year;

			$fechaInscripcionUltimoAtraso = "$dia/$mesString/$anio";
			$fechaInscUltimoAtrasoRef     = "$anio-$mes-$dia";
		}


		$fechaInscRef1 = "$perAnioPagoInscripcion-01-15";
		$fechaInscRef2 = "$perAnioPagoInscripcion-01-31";
		$fechaInscRef3 = "$perAnioPagoInscripcion-02-20";


		$anioReferencia = $perAnioPago % 100;
		$referenciaInscParcial = $aluClave . $anioReferencia . "00";

		$generarReferencia = new GenerarReferencia;
		$inscripcionRef = number_format(ceil($importeInscripcion), 2, '.', '');
		$referenciaInscripcion1 = $generarReferencia->crear($referenciaInscParcial, $fechaInscRef1, $inscripcionRef);
		$referenciaInscripcion2 = $generarReferencia->crear($referenciaInscParcial, $fechaInscRef2, $inscripcionRef);
		$referenciaInscripcion3 = $generarReferencia->crear($referenciaInscParcial, $fechaInscRef3, $inscripcionRef);

		$referenciaInscripcionUltimoAtraso = "";
		if ($esFechaInscripcion3Vencida) {
			$referenciaInscripcionUltimoAtraso = $generarReferencia->crear($referenciaInscParcial, $fechaInscUltimoAtrasoRef, $inscripcionRef);
		
		}

		// $this->crearFicha($curso->periodo->perNumero,
		// 	$curso->periodo->perAnio, $curso->alumno->aluClave,
		// 	$curso->cgt->plan->programa->progClave, $curso->cgt->cgtGradoSemestre,
		// 	$curso->cgt->cgtGrupo, $curso->alumno->aluEstado,
		// 	$fechaInscRef1, $inscripcionRef, $referenciaInscripcion1);




		$estadoPagoInscripcion = Pago::where('pagClaveAlu', '=', $aluClave)
			->where('pagConcPago', '=', '00')
			->where('pagEstado', '=', 'A')
			->where("pagAnioPer", '=', $perAnioPago)
		->first();

		if ($estadoPagoInscripcion) {
			$estadoPagoInscripcion->pagImpPago = number_format($estadoPagoInscripcion->pagImpPago, 2, '.', ',');
		}


		$curPlanPago = $curso->curPlanPago;


		$septiembre = $this->generarLibreta(1,  $perAnioPago, $curso_id, $importeInscripcion);
		$octubre    = $this->generarLibreta(2,  $perAnioPago, $curso_id, $importeInscripcion);
		$noviembre  = $this->generarLibreta(3,  $perAnioPago, $curso_id, $importeInscripcion);
		$diciembre  = $this->generarLibreta(4,  $perAnioPago, $curso_id, $importeInscripcion);
		$enero      = $this->generarLibreta(5,  $perAnioPago, $curso_id, $importeInscripcion);
		$febrero    = $this->generarLibreta(6,  $perAnioPago, $curso_id, $importeInscripcion);
		$marzo      = $this->generarLibreta(7,  $perAnioPago, $curso_id, $importeInscripcion);
		$abril      = $this->generarLibreta(8,  $perAnioPago, $curso_id, $importeInscripcion);
		$mayo       = $this->generarLibreta(9,  $perAnioPago, $curso_id, $importeInscripcion);
		$junio      = $this->generarLibreta(10, $perAnioPago, $curso_id, $importeInscripcion);
		$julio      = $this->generarLibreta(11, $perAnioPago, $curso_id, $importeInscripcion);
		$agosto     = $this->generarLibreta(12, $perAnioPago, $curso_id, $importeInscripcion);

		$nombreArchivo = "";
		if ($curPlanPago == "N" || $curPlanPago == "A") {
			$nombreArchivo = "pdf_tarjeta_pago_normal_anticipo";
		}
		if ($curPlanPago == "O") {
			$nombreArchivo = "pdf_tarjeta_pago_once_meses";
		}
		if ($curPlanPago == "D") {
			$nombreArchivo = "pdf_tarjeta_pago_doce_meses";
		}


		//NO APLICA PAGO POR SEMESTRE INVALIDO
		$noAplicoPago = (($curso->cgt->plan->planPeriodos == $curso->cgt->cgtGradoSemestre) && ($curso->periodo->perAnio == $curso->periodo->perAnioPago));


		// dd($junio->cuotaAtrasoPorMeses2);


		$fechaActual = Carbon::now("CDT");
		$fechaActualFormatoTarjeta = sprintf('%02d', $fechaActual->day) . "/" . Utils::num_meses_corto_string($fechaActual->month) . "/" . $fechaActual->year;
		$horaActual = $fechaActual->format("H:i:s");

		// dd(number_format (20000.20, 2 , "." , "," ));

	


		// dd($fechaActualFormatoTarjeta);

		// Unix
		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');

		$pdf = PDF::loadView('reportes.pdf.' . $nombreArchivo, [
			"curso"         => $curso,
			"noAplicoPago" => $noAplicoPago,
			"nombreArchivo" => $nombreArchivo . '.pdf',
			"septiembre" => $septiembre,
			"octubre"    => $octubre,
			"noviembre"  => $noviembre,
			"diciembre"  => $diciembre,
			"enero"      => $enero,
			"febrero"    => $febrero,
			"marzo"      => $marzo,
			"abril"      => $abril,
			"mayo"       => $mayo,
			"junio"      => $junio,
			"julio"      => $julio,
			"agosto"     => $agosto,
			"convenio"   => $convenio,
			"inscripcion" => (Object) [
				"estadoPagoInscripcion" => $estadoPagoInscripcion,
				"importeInscripcion" =>  ceil((double) $importeInscripcion),
				"fechaInscripcion1" => $fechaInscripcion1,
				"esFechaInscripcion1Vencida" => $esFechaInscripcion1Vencida,
				"referenciaInscripcion1" => $referenciaInscripcion1,
				
				"fechaInscripcion2" => $fechaInscripcion2,
				"esFechaInscripcion2Vencida" => $esFechaInscripcion2Vencida,
				"referenciaInscripcion2" => $referenciaInscripcion2,


				"fechaInscripcion3" => $fechaInscripcion3,
				"esFechaInscripcion3Vencida" => $esFechaInscripcion3Vencida,
				"referenciaInscripcion3" => $referenciaInscripcion3,

				"fechaInscripcionUltimoAtraso" => $fechaInscripcionUltimoAtraso,
				"referenciaInscripcionUltimoAtraso" => $referenciaInscripcionUltimoAtraso
			],
			"curPlanPago" => $curPlanPago,
			"fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
			"horaActual" => $horaActual
		]);


		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream($nombreArchivo);
		return $pdf->download($nombreArchivo);
	}


	// public function crearFicha ($fchNumPer, $fchAnioPer, $fchClaveAlu, $fchClaveCarr,
	// 	$fchGradoSem, $fchGrupo, $fchTipo,
	// 	$fchFechaVenc1, $fhcImp1, $fhcRef1, $fchFechaVenc2, $fhcImp2, $fhcRef2, $fchEstado) {


	// 	Ficha::create([
	// 		"fchNumPer"       => $fchNumPer,
	// 		"fchAnioPer"      => $fchAnioPer,
	// 		"fchClaveAlu"     => $fchClaveAlu,
	// 		"fchClaveCarr"    => $fchClaveCarr,
	// 		"fchClaveProgAct" => NULL,
	// 		"fchGradoSem"     => $fchGradoSem,
	// 		"fchGrupo"        => $fchGrupo,
	// 		"fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
	// 		"fchHoraImpr"     => Carbon::now()->format("h:i:s"),
	// 		"fchUsuaImpr"     => auth()->user()->id,
	// 		"fchTipo"         => $fchTipo,

	// 		"fchConc"         => "00",

	// 		"fchFechaVenc1"   => $fchFechaVenc1,
	// 		"fhcImp1"         => $fhcImp1,
	// 		"fhcRef1"         => $fhcRef1,

	// 		"fchFechaVenc2"   => $cuoFechaLimiteInscripcion2,
	// 		"fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
	// 		"fhcRef2"         => $ficha['referencia2'],

	// 		"fchEstado"       => "P"
	// 	]);

	// }

	public function generarLibreta ($mes, $perAnioPago, $cursoId, $importeInscripcion)
	{
		$conceptoCeros = sprintf("%02d", $mes);
		$generarReferencia = new GenerarReferencia;
		return $generarReferencia->generarImportes($cursoId, $conceptoCeros, $perAnioPago, $mes, $importeInscripcion);
	}
}
<?php

namespace App\Http\Controllers\Reportes;

use PDF;
use Ficha;

use Carbon\Carbon;
use App\Models\Pago;
use App\Models\Cuota;
use App\Models\Curso;
use App\Http\Helpers\Utils;
use Illuminate\Http\Request;

use App\Models\Ubicacion;

use App\Http\Controllers\Controller;

use App\Http\Helpers\GenerarReferenciaScript;
use Illuminate\Support\Facades\Storage;


class TarjetaPagoAlumnosScriptController extends Controller
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



	public function tarjetaPagoAlumno(Request $request)
	{
    $curIds = [
      143787,
      143818,
      143821,
      143949,
      143951,
      143953,
      143955,
      143956,
      143958,
      143959,
      143960,
      143961,
      143962,
      143963,
      143964,
      143965,
      143966,
      143967,
      143969,
      143975,
      143976,
      143977,
      143979,
      143980,
      143981,
      143983,
      143984,
      143985,
      143986,
      143987,
      143988,
      143989,
      143990,
      143991,
      143992,
      143993,
      143994,
      143995,
      143996,
      143997,
      143998,
      143999,
      144000,
      144001,
      144002,
      144003,
      144004,
      144005,
      144006,
      144007,
      144008,
      144009,
      144010,
      144011,
      144012,
      144013,
      144014,
      144015,
      144016,
      144017,
      144020,
      144021,
      144022,
      144025,
      144026,
      144027,
      144028,
      144029,
      144030,
      144031,
      144032,
      144033,
      144034,
      144035,
      144036,
      144037,
      144038,
      144040,
      144041,
      144042,
      144043,
      144045,
      144046,
      144047,
      144048,
      144049,
      144050,
      144052,
      144053,
      144054,
      144055,
      144057,
      144058,
      144059,
      144060,
      144061,
      144062,
      144063,
      144064,
      144065,
      144066,
      144067,
      144068,
      144069,
      144070,
      144071,
      144072,
      144073,
      144075,
      144076,
      144078,
      144079,
      144080,
      144081,
      144082,
      144084,
      144085,
      144086,
      144089,
      144090,
      144091,
      144099,
      144100,
      144101,
      144103,
      144104,
      144106,
      144109,
      144110,
      144111,
      144112,
      144113,
      144114,
      144115,
      144116,
      144119,
      144120,
      144122,
      144125,
      144129,
      144130,
      144131,
      144132,
      144133,
      144135,
      144137,
      144138,
      144142,
      144143,
      144144,
      144145,
      144146,
      144147,
      144148,
      144149,
      144150,
      144151,
      144152,
      144153,
      144155,
      144156,
      144157,
      144158,
      144159,
      144160,
      144161,
      144162,
      144163,
      144164,
      144165,
      144166,
      144167,
      144170,
      144172,
      144175,
      144177,
      144178,
      144182,
      144184,
      144186,
      144188,
      144189,
      144190,
      144191,
      144192,
      144193,
      144194,
      144195,
      144197,
      144199,
      144216,
      144217,
      144218,
      144219,
      144220,
      144221,
      144222,
      144224,
      144225,
      144226,
      144227,
      144228,
      144230,
      144231,
      144232,
      144234,
      144235,
      144237,
      144239,
      144240,
      144241,
      144244,
      144246,
      144249,
      144250,
      144251,
      144252,
      144253,
      144254,
      144255,
      144257,
      144258,
      144259,
      144260,
      144261,
      144262,
      144264,
      144266,
      144268,
      144270,
      144271,
      144272,
      144274,
      144276,
      144279,
      144280,
      144281,
      144284,
      144285,
      144286,
      144288,
      144289,
      144290,
      144292,
      144293,
      144294,
      144295,
      144296,
      144297,
      144298,
      144299,
      144301,
      144303,
      144304,
      144305,
      144306,
      144307,
      144308,
      144309,
      144310,
      144313,
      144318,
      144319,
      144320,
      144322,
      144323,
      144324,
      144325,
      144327,
      144328,
      144329,
      144330,
      144331,
      144332,
      144333,
      144334,
      144335,
      144336,
      144337,
      144340,
      144342,
      144344,
      144345,
      144346,
      144347,
      144349,
      144350,
      144351,
      144352,
      144353,
      144354,
      144356,
      144357,
      144358,
      144360,
      144361,
      144364,
      144365,
      144366,
      144367,
      144369,
      144371,
      144372,
      144374,
      144376,
      144377,
      144378,
      144379,
      144380,
      144381,
      144382,
      144383,
      144384,
      144385,
      144386,
      144387,
      144388,
      144389,
      144390,
      144391,
      144392,
      144393,
      144395,
      144396,
      144399,
      144400,
      144401,
      144402,
      144403,
      144404,
      144405,
      144406,
      144410,
      144411,
      144412,
      144414,
      144416,
      144417,
      144419,
      144424,
      144425,
      144426,
      144427,
      144428,
      144429,
      144430,
      144431,
      144432,
      144433,
      144434,
      144435,
      144437,
      144438,
      144439,
      144441,
      144442,
      144443,
      144444,
      144445,
      144446,
      144447,
      144449,
      144451,
      144452,
      144454,
      144457,
      144458,
      144459,
      144460,
      144461,
      144462,
      144464,
      144465,
      144467,
      144468,
      144471,
      144474,
      144477,
      144478,
      144479,
      144480,
      144481,
      144483,
      144484,
      144486,
      144487,
      144488,
      144489,
      144491,
      144492,
      144493,
      144494,
      144495,
      144496,
      144497,
      144498,
      144500,
      144501,
      144503,
      144504,

    ];
		$cursos = Curso::whereIn('id', $curIds)->get();



    foreach ($cursos as $curso) {
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

      $generarReferencia = new GenerarReferenciaScript;
      $inscripcionRef = number_format(ceil($importeInscripcion), 2, '.', '');
      $referenciaInscripcion1 = $generarReferencia->crear($referenciaInscParcial, $fechaInscRef1, $inscripcionRef);
      $referenciaInscripcion2 = $generarReferencia->crear($referenciaInscParcial, $fechaInscRef2, $inscripcionRef);
      $referenciaInscripcion3 = $generarReferencia->crear($referenciaInscParcial, $fechaInscRef3, $inscripcionRef);

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


      // $septiembre = $this->generarLibreta(1,  $perAnioPago, $curso_id, $importeInscripcion);
      // $octubre    = $this->generarLibreta(2,  $perAnioPago, $curso_id, $importeInscripcion);
      // $noviembre  = $this->generarLibreta(3,  $perAnioPago, $curso_id, $importeInscripcion);
      // $diciembre  = $this->generarLibreta(4,  $perAnioPago, $curso_id, $importeInscripcion);
      // $enero      = $this->generarLibreta(5,  $perAnioPago, $curso_id, $importeInscripcion);
      // $febrero    = $this->generarLibreta(6,  $perAnioPago, $curso_id, $importeInscripcion);
      // $marzo      = $this->generarLibreta(7,  $perAnioPago, $curso_id, $importeInscripcion);
      $abril      = $this->generarLibreta(8,  $perAnioPago, $curso->id, $importeInscripcion);
      $mayo       = $this->generarLibreta(9,  $perAnioPago, $curso->id, $importeInscripcion);
      $junio      = $this->generarLibreta(10, $perAnioPago, $curso->id, $importeInscripcion);
      // $julio      = $this->generarLibreta(11, $perAnioPago, $curso_id, $importeInscripcion);
      // $agosto     = $this->generarLibreta(12, $perAnioPago, $curso_id, $importeInscripcion);


      $nombreArchivo = "";
      if ($curPlanPago == "N" || $curPlanPago == "A") {
        $nombreArchivo = "pdf_script_tarjeta_pago_normal_anticipo";
      }
      if ($curPlanPago == "O") {
        $nombreArchivo = "pdf_script_tarjeta_pago_once_meses";
      }
      if ($curPlanPago == "D") {
        $nombreArchivo = "pdf_script_tarjeta_pago_doce_meses";
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
        // "septiembre" => $septiembre,
        // "octubre"    => $octubre,
        // "noviembre"  => $noviembre,
        // "diciembre"  => $diciembre,
        // "enero"      => $enero,
        // "febrero"    => $febrero,
        // "marzo"      => $marzo,
        "abril"      => $abril,
        "mayo"       => $mayo,
        "junio"      => $junio,
        // "julio"      => $julio,
        // "agosto"     => $agosto,
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




      $path = public_path('pdf');
      $fileName = str_pad($curso->alumno->aluClave, 8,"0", STR_PAD_LEFT)   . '.' . 'pdf' ;
      $pdf->save($path . '/' . $fileName);

    }
	}



	public function generarLibreta ($mes, $perAnioPago, $cursoId, $importeInscripcion)
	{
		$conceptoCeros = sprintf("%02d", $mes);
		$generarReferencia = new GenerarReferenciaScript;
		return $generarReferencia->generarImportes($cursoId, $conceptoCeros, $perAnioPago, $mes, $importeInscripcion);
	}
}
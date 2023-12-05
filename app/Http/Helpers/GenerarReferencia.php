<?php

namespace App\Http\Helpers;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Cuota;
use App\Models\Referencia;
use App\Models\Pago;
use App\Models\Beca;

use App\Http\Helpers\Utils;

use Carbon\Carbon;



class GenerarReferencia
{



  public function __construct()
  {
  }


  //conceptos de pagos
  private $conceptos = [
    "00" => "Inscripción Enero",
    "01" => "Septiembre",
    "02" => "Octubre",
    "03" => "Noviembre",
    "04" => "Diciembre",
    "05" => "Enero",
    "06" => "Febrero",
    "07" => "Marzo",
    "08" => "Abril",
    "09" => "Mayo",
    "10" => "Junio",
    "99" => "Inscripción Agosto",
  ];

  private $meses = [
    "01" => "09",
    "02" => "10",
    "03" => "11",
    "04" => "12",
    "05" => "01",
    "06" => "02",
    "07" => "03",
    "08" => "04",
    "09" => "05",
    "10" => "06",
    "11" => "07",
    "12" => "08",
  ];

  private $mesIngles = [
    "01" => "January",
    "02" => "February",
    "03" => "March",
    "04" => "April",
    "05" => "May",
    "06" => "June",
    "07" => "July",
    "08" => "August",
    "09" => "September",
    "10" => "October",
    "11" => "November",
    "12" => "December",
  ];

  //relación de nombres cortos de los meses
  private $mesCorto = [
    "01" => "Ene",
    "02" => "Feb",
    "03" => "Mar",
    "04" => "Abr",
    "05" => "May",
    "06" => "Jun",
    "07" => "Jul",
    "08" => "Ago",
    "09" => "Sep",
    "10" => "Oct",
    "11" => "Nov",
    "12" => "Dic",
  ];

  private $conceptoInicial = [
    "00",
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "99",
  ];


  //conceptos que son de inscripción
  private $concInscripcion = [
    "00",
    "99"
  ];

  private $prontoPago = 225;
  private $recargo = 150;

  public function crear($concepto, $fecha, $importe)
  {
    //separar fecha
    $arrayDate = explode('-',$fecha);
    $dia = $arrayDate[2];
    $mes = $arrayDate[1];
    $anio = $arrayDate[0];
    //valores fijos para concentrado de importe
    $fijosImporte = array (7, 3, 1);
    $fijosVerifica = array (11, 13, 17, 19, 23);

    //concentrado de fecha
    $conAnio = ($anio - 2014) * 372;
    $conMes = ($mes - 1) * 31;
    $conDia = $dia -1;
    $conFecha = $conAnio + $conMes + $conDia;
    $conFecha = sprintf ("%04d", $conFecha);

    //concentrado de importe
    $importeSeparado = explode (".", $importe);
    $importeSinPunto = $importeSeparado[0].$importeSeparado[1];
    $arregloImporte = str_split ($importeSinPunto);
    $arregloImporte = array_reverse ($arregloImporte);
    $conImporte = 0;

    foreach ($arregloImporte as $k => $v) {

      // if (!is_numeric($v) || !is_numeric($k)){
      //   dd($v, $k, gettype($v), gettype($k), $arregloImporte, $importe, $concepto);
      // }

      $conImporte += $v * $fijosImporte[$k % 3];
    }
    $conImporte = $conImporte % 10;

    //resultado final
    $referencia = $concepto . $conFecha . $conImporte . 2; //el 2 al final es fijo
    $arregloReferencia = str_split ($referencia);
    $arregloReferencia = array_reverse ($arregloReferencia);
    $verificador = 0;


    foreach ($arregloReferencia as $k => $v) {
      $verificador += $v * $fijosVerifica[$k % 5];
    }

    $verificador = $verificador % 97;
    $verificador++;
    $verificador = sprintf ("%02d", $verificador);
    $referencia .= $verificador;

    return $referencia;
  }

  public function crearBBVA($concepto, $fecha, $importe, $conpRefClave, $refNumerica)
    {
        //separar fecha
        $arrayDate = explode('-',$fecha);
        $dia = $arrayDate[2];
        $mes = $arrayDate[1];
        $anio = $arrayDate[0];
        //valores fijos para concentrado de importe
        $fijosImporte = array (7, 3, 1);
        $fijosVerifica = array (11, 13, 17, 19, 23);

        //concentrado de fecha
        $conAnio = ($anio - 2014) * 372;
        $conMes = ($mes - 1) * 31;
        $conDia = $dia -1;
        $conFecha = $conAnio + $conMes + $conDia;
        $conFecha = sprintf ("%04d", $conFecha);

        //concentrado de importe
        $importeSeparado = explode (".", $importe);
        $importeSinPunto = $importeSeparado[0].$importeSeparado[1];
        $arregloImporte = str_split ($importeSinPunto);
        $arregloImporte = array_reverse ($arregloImporte);
        $conImporte = 0;

        foreach ($arregloImporte as $k => $v) {

            // if (!is_numeric($v) || !is_numeric($k)){
            //   dd($v, $k, gettype($v), gettype($k), $arregloImporte, $importe, $concepto);
            // }

            $conImporte += $v * $fijosImporte[$k % 3];
        }
        $conImporte = $conImporte % 10;

        //resultado final
        $referencia = $concepto . $conpRefClave . $refNumerica. $conFecha . $conImporte . 2; //el 2 al final es fijo
        //$referencia = $concepto . $conpRefClave . "0000". $conFecha . $conImporte . 2; //el 2 al final es fijo

        $arregloReferencia = str_split ($referencia);
        $arregloReferencia = array_reverse ($arregloReferencia);
        $verificador = 0;


        foreach ($arregloReferencia as $k => $v) {
            $verificador += $v * $fijosVerifica[$k % 5];
        }

        $verificador = $verificador % 97;
        $verificador++;
        $verificador = sprintf ("%02d", $verificador);
        $referencia .= $verificador;

        return $referencia;
    }

  public function crearHSBC($concepto, $fecha, $importe, $conpRefClave, $refNumerica)
    {
        //separar fecha
        $arrayDate = explode('-',$fecha);
        $dia = $arrayDate[2];
        $mes = $arrayDate[1];
        $anio = $arrayDate[0];
        //valores fijos para concentrado de importe
        $fijosImporte = array (7, 3, 1);
        $fijosVerifica = array (11, 13, 17, 19, 23);

        //concentrado de fecha
        $conAnio = ($anio - 2014) * 372;
        $conMes = ($mes - 1) * 31;
        $conDia = $dia -1;
        $conFecha = $conAnio + $conMes + $conDia;
        $conFecha = sprintf ("%04d", $conFecha);

        //concentrado de importe
        $importeSeparado = explode (".", $importe);
        $importeSinPunto = $importeSeparado[0].$importeSeparado[1];
        $arregloImporte = str_split ($importeSinPunto);
        $arregloImporte = array_reverse ($arregloImporte);
        $conImporte = 0;

        foreach ($arregloImporte as $k => $v) {

            // if (!is_numeric($v) || !is_numeric($k)){
            //   dd($v, $k, gettype($v), gettype($k), $arregloImporte, $importe, $concepto);
            // }

            $conImporte += $v * $fijosImporte[$k % 3];
        }
        $conImporte = $conImporte % 10;

        //resultado final
        $referencia = $concepto . $conpRefClave . $refNumerica. $conFecha . $conImporte . 2; //el 2 al final es fijo
        //$referencia = $concepto . $conpRefClave . "0000". $conFecha . $conImporte . 2; //el 2 al final es fijo
        $arregloReferencia = str_split ($referencia);
        $arregloReferencia = array_reverse ($arregloReferencia);
        $verificador = 0;


        foreach ($arregloReferencia as $k => $v) {
            $verificador += $v * $fijosVerifica[$k % 5];
        }

        $verificador = $verificador % 97;
        $verificador++;
        $verificador = sprintf ("%02d", $verificador);
        $referencia .= $verificador;

        return $referencia;
    }

  public static function obtenerFecha($fecha = "now") {
    //sumarle 7 días a la fecha
    $fecha = strtotime($fecha);
    $fechaFinal = strtotime ("+7 days", $fecha);

    //verificar quincena
    $diaActual = date ("d", $fecha);
    $diaFinal = date ("d", $fechaFinal);
    if ($diaActual <= 15) {
      if ($diaFinal > 15) {
        $fechaFinal = strtotime ("first day of this month", $fecha);
        $fechaFinal = strtotime ("+14 days", $fechaFinal);
      }
    } else {
      if ($diaFinal < $diaActual) {
        $fechaFinal = strtotime ("last day of this month", $fecha);
      }
    }

    //ya el final
    $fechaFinal = date ("Y-m-d", $fechaFinal);
    return $fechaFinal;
  }

  //función para obtener la diferencia entre dos meses
  public static function diferenciaMeses ($fechaInicial, $fechaFinal) {
    $fechaInicial = strtotime ($fechaInicial);
    $fechaFinal = strtotime ($fechaFinal);
    $anioInicial = date ("Y", $fechaInicial);
    $anioFinal = date ("Y", $fechaFinal);
    $mesInicial = date ("m", $fechaInicial);
    $mesFinal = date ("m", $fechaFinal);
    $mesesInicial = ($anioInicial * 12) + $mesInicial;
    $mesesFinal = ($anioFinal * 12) + $mesFinal;
    $mesesTotal = $mesesFinal - $mesesInicial;
    $mesesTotal = $mesesTotal < 0 ? 0 : $mesesTotal;
    return $mesesTotal;
  }

  //función para obtener el período actual
  //a partir de agosto se considera que se esto en el año actual
  public static function periodoActual()
  {
    $anio = date ("Y");
    $mes = date ("m");
    $anioPeriodo = $mes < "08" ? $anio - 1 : $anio;
  }


  public function generarImportes($curso, $concepto, $cuoAnio, $mes, $importeInscripcion)
  {
    $currentDateVencimiento = Carbon::now()->addDays(7);
    $currentDate = Carbon::now();



    $conceptoMes = [
			1 => 9,  //septiembre
			2 => 10, //octubre
			3 => 11, //noviembre
			4 => 12, //diciembre
			5 => 1,  //enero
			6 => 2,  //febrero
			7 => 3,  //marzo
			8 => 4,  //abril
			9 => 5,  //mayo
			10 => 6, //junio
			11 => 7, //julio
			12 => 8, //agosto
		];

		$mesCorto = [
			1  => 'Ene', 2  => 'Feb',
			3  => 'Mar', 4  => 'Abr',
			5  => 'May', 6  => 'Jun',
			7  => 'Jul', 8  => 'Ago',
			9  => 'Sep', 10 => 'Oct',
			11 => 'Nov', 12 => 'Dic',
	  ];

    $curso = Curso::with("cgt.plan.programa", "periodo")->where([['id', $curso]])->first();

    $aluClave = $curso->alumno->aluClave;

    //VERIFICAR SI YA PAGO LA MENSUALIDAD
    $mensualidadPagada = Pago::where('pagClaveAlu', '=', $aluClave)
      ->where('pagConcPago', '=', $concepto)
      ->where('pagAnioPer', '=', $cuoAnio)
      ->where('pagEstado', '=', 'A')
    ->first();


    //COMENTADO PARA TEST -------------------------------------------------
    if ($mensualidadPagada) {
      return (Object) [
        "esMensualidadPagada" => true,
        "mensualidadPagada"   => $mensualidadPagada,
        "fechaMensualidadPagadaFormato" => $this->fechaPagoFormatoTerjeta($mensualidadPagada->pagFechaPago)
      ];
    }





    $departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
    $escuelaId = $curso->cgt->plan->programa->escuela->id;
    $programaId = $curso->cgt->plan->programa->id;



    //AÑO DE LA INSCRIPCION - PERIODO AÑO DE PAGO
    $cuotaActual = 0;
    $perAnioPago = $curso->periodo->perAnioPago;
    $perAnio = $curso->periodo->perAnio;

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


    $curPlanPago = $curso->curPlanPago;

    //IMPORTE MENSUAL
    $mensualidad = 0;
    //OBTENER CUOTA MENSUAL DEPENDIENDO EL PLAN DEL PAGO
    if ($curPlanPago == "N" || $curPlanPago == "A") {
      $mensualidad = $cuotaActual->cuoImporteMensualidad10;
    }
    if ($curPlanPago == "O") {
      $mensualidad = $cuotaActual->cuoImporteMensualidad11;
    }
    if ($curPlanPago == "D") {
      $mensualidad = $cuotaActual->cuoImporteMensualidad12;
    }

    // $diaLimiteProntoPagoActual = $cuotaActual->cuoDiasProntoPago;











    //VERIFICAR SI TIENE CUOTA POR AÑO GENERACION
    $cuoAnioGeneracion = $curso->curAnioCuotas;
    $cuotaGeneracional = 0;
    $diaLimiteProntoPagoGeneracion = 0;
    if ($cuoAnioGeneracion) {
      $cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $cuoAnioGeneracion]])->first();
      $cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $cuoAnioGeneracion]])->first();
      $cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $cuoAnioGeneracion]])->first();
      if ($cuotaDep) {
        $cuotaGeneracional = $cuotaDep;
      }
      if ($cuotaEsc) {
        $cuotaGeneracional = $cuotaEsc;
      }
      if ($cuotaProg) {
        $cuotaGeneracional = $cuotaProg;
      }

      //OBTENER CUOTA MENSUAL DEPENDIENDO EL PLAN DEL PAGO
      if ($curPlanPago == "N" || $curPlanPago == "A") {
        $mensualidadGeneracional = $cuotaGeneracional->cuoImporteMensualidad10;
      }
      if ($curPlanPago == "O") {
        $mensualidadGeneracional = $cuotaGeneracional->cuoImporteMensualidad11;
      }
      if ($curPlanPago == "D") {
        $mensualidadGeneracional = $cuotaGeneracional->cuoImporteMensualidad12;
      }

      $diaLimiteProntoPagoGeneracion = $cuotaGeneracional->cuoDiasProntoPago;
    }




    //VERIFICAR SI TIENE CUOTA POR ALUMNO
    $mensualidadAlumno         = null;
    $prontoPagoAlumno          = null;
    $diaLimiteProntoPagoAlumno = null;
    $importeVencimientoAlumno  = null;
    $beca                      = null;

    if ($curso->curImporteMensualidad != "" || $curso->curPorcentajeBeca != null) {
      $mensualidadAlumno = $curso->curImporteMensualidad;
    }
    if ($curso->curImporteDescuento != "" || $curso->curPorcentajeBeca != null) {
      $prontoPagoAlumno = $curso->curImporteDescuento;
    }
    if ($curso->curImporteVencimiento != "" || $curso->curPorcentajeBeca != null) {
      $importeVencimientoAlumno = $curso->curImporteVencimiento;
    }
    if ($curso->curDiasProntoPago != "" || $curso->curPorcentajeBeca != null) {
      $diaLimiteProntoPagoAlumno = $curso->curDiasProntoPago;
    }



    // dd($curso);
    // dd($curso->curPorcentajeBeca);

    if ($curso->curPorcentajeBeca != "" || $curso->curPorcentajeBeca != null ) {
      $beca = $curso->curPorcentajeBeca;
    }



    //OBTENER DIA/MES/ANIO PRONTO PAGO
    $diasProntoPago  = 0;
    if (!$cuoAnioGeneracion) {
      $diaProntoPago = $cuotaActual->cuoDiasProntoPago;
    }
    if ($cuoAnioGeneracion) {
      $diaProntoPago = $cuotaGeneracional->cuoDiasProntoPago;
    }
    if ($diaLimiteProntoPagoAlumno) {
      $diaProntoPago = $curso->curDiasProntoPago;
    }

		$mesProntoPago = $conceptoMes[$mes];

		//SI LLEGA A ENERO, SE LE SUMA UN AÑO
		$anioProntoPago = $perAnioPago;
		if ($mes > 4) {
			$anioProntoPago = $anioProntoPago + 1;
		}
		//SI ES SEPTIEMBRE, 2 DIAS MAS DE APLAZO
		if ($mesProntoPago == 9) {
			$diaProntoPago = $diaProntoPago + 5;
		}
		//SI ES DICIEMBRE, 1 DIAS MAS DE APLAZO
		if ($mesProntoPago == 12) {
			$diaProntoPago = $diaProntoPago + 1;
    }
    //FIN OBTENER DIA/MES/ANIO PRONTO PAGO





    //GENERAR FECHAS LIMITES DE PAGO
    $fecha1mk             = mktime(0, 0, 0, $mesProntoPago, $diaProntoPago, $anioProntoPago);




		$diaFechaCorta        = date("d", $fecha1mk);
		$mesFechaCorta        = date("n", $fecha1mk);
		$mesLetraFechaCorta   = $mesCorto[$mesFechaCorta];
		$anioFechaCorta       = date("Y", $fecha1mk);
    $fechaProntoPago      = date("Y-n-d", $fecha1mk);








		$fechaProntoPagoCorto = "$diaFechaCorta/$mesLetraFechaCorta/$anioFechaCorta";
    $fechaProntoPagoCarbon = Carbon::createFromTimestamp(strtotime($fechaProntoPago));
    $fechaProntoPagoMysql  =  "$anioFechaCorta/$mesFechaCorta/$diaFechaCorta";


		$fecha2mk = strtotime("last day of this month", $fecha1mk);
		$diaFechaCorta = date("d", $fecha2mk);
		$mesFechaCorta = date("n", $fecha2mk);
		$mesLetraFechaCorta = $mesCorto[$mesFechaCorta];
		$anioFechaCorta = date("Y", $fecha2mk);
		$fechaNormalPago = date("Y-n-d", $fecha2mk);
		$fechaNormalPagoCorto = "$diaFechaCorta/$mesLetraFechaCorta/$anioFechaCorta";
    $fechaNormalPagoCarbon = Carbon::createFromTimestamp(strtotime($fechaNormalPago));
    $fechaNormalPagoMysql  =  "$anioFechaCorta/$mesFechaCorta/$diaFechaCorta";


		$fecha3mk = strtotime("+20 days", $fecha2mk);
		$diaFechaCorta = date("d", $fecha3mk);
		$mesFechaCorta = date("n", $fecha3mk);
		$mesLetraFechaCorta = $mesCorto[$mesFechaCorta];
		$anioFechaCorta = date("Y", $fecha3mk);
		$fechaAtrasoPago = date("Y-n-d", $fecha3mk);
    $fechaAtrasoPagoCorto = "$diaFechaCorta/$mesLetraFechaCorta/$anioFechaCorta";
    $fechaAtrasoPagoCarbon = Carbon::createFromTimestamp(strtotime($fechaAtrasoPago));
    $fechaAtrasoPagoMysql  =  "$anioFechaCorta/$mesFechaCorta/$diaFechaCorta";







    //IMPORTE POR ANTICIPO CREDITO
    $importePorAntCred = 0;
    //OBTENER CUOTA MENSUAL DEPENDIENDO EL PLAN DEL PAGO
    if ($curPlanPago == "A") {
      $importePorAntCred = $importeInscripcion / 10;
    }









    //PRONTO PAGO       --------------------------------------------------
		$cuotaProntoPago = 0;
		$descuentoProntoPago = 0;
		$porcentajeBeca = 0;

    if (!$cuoAnioGeneracion) {
			$cuotaProntoPago = $mensualidad;
			$descuentoProntoPago = $cuotaActual->cuoImporteProntoPago;
		}

    if ($cuoAnioGeneracion) {
			$cuotaProntoPago = $mensualidadGeneracional;
			$descuentoProntoPago = $cuotaGeneracional->cuoImporteProntoPago;
		}

		//mensualidad alumno override if exists
		if ($mensualidadAlumno != null) {
      $cuotaProntoPago = $mensualidadAlumno;
    }

		//descuento pronto pago override if exists
		if ($prontoPagoAlumno != null) {
      $descuentoProntoPago = $prontoPagoAlumno;
		}

    $vigenciaBeca = "";
    $descuentoBeca = 1;
		if (($beca != "" || $beca != null) && ($curso->curTipoBeca != null || $curso->curTipoBeca != "")) {
      $porcentajeBeca = $curso->curPorcentajeBeca;


      $vigenciaBeca = Beca::where("bcaClave", "=", $curso->curTipoBeca)->first();
      $vigenciaBeca = $vigenciaBeca->bcaVigencia;


      $descuentoBeca = 1 - ($beca / 100);


      if ($perAnioPago == $perAnio) {
        if ($vigenciaBeca == "S" && (int) $concepto > 5) {
          $descuentoBeca = 1;
        }
      }
    }



    $cuotaProntoPagoRefImpConc = $cuotaProntoPago;
    $importeBeca = 1 - $descuentoBeca;
    $cuotaProntoPago = (($cuotaProntoPago - $descuentoProntoPago) * round($descuentoBeca, 2)) + $importePorAntCred;
    //termina pronto pago ---------------------------------------------------



    //CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------
    //AGARRAR LAS 2 ULTIMAS CIFRAS
    $perAnioPagoRef = (String) substr($curso->periodo->perAnioPago, -2);
    $refNum =  $perAnioPagoRef . $concepto;
    // if ($curPlanPago == "A") {
    if ($curPlanPago == "A" && $currentDate->lt($fechaProntoPagoCarbon)) {

      $alumnoId   = $curso->alumno_id;
      $programaId = $curso->cgt->plan->programa->id;

      $refAnioPer = $curso->periodo->perAnioPago;
      $refConcPago = $concepto;
      $refFechaVenc = $fechaProntoPagoMysql;
      $refImpTotal = $cuotaProntoPago;
      $refImpConc = $cuotaProntoPagoRefImpConc;
      $refImpBeca = $importeBeca * $cuotaProntoPagoRefImpConc;
      $refImpPP = $descuentoBeca * (Double) $descuentoProntoPago;
      $refImpAntCred = $importePorAntCred;
      $refImpRecar = 0;
      $refUsuarioAplico = null; //auth()->user()->id;
      $refFechaAplico   = null; //Carbon::now()->format("Y-m-d")
      $refEstado = "P";



      $refNum = $this->generarRegistroReferencia(
        $alumnoId, $programaId,  $refAnioPer,
        $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
        $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
        $refFechaAplico, $refEstado);
    }

    $refConcepto = $curso->alumno->aluClave . $refNum;




    $cuotaProntoPagoRef = number_format(ceil($cuotaProntoPago), 2, '.', '');
    $crearReferenciaProntoPago = $this->crear($refConcepto, $fechaProntoPago, $cuotaProntoPagoRef);
    $cuotaProntoPagoRef = number_format(ceil($cuotaProntoPago), 2, '.', ',');




    //FIN  CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------















    //CUOTA NORMAL ------------------------------------------------------------
    $cuotaNormal = 0;
    $cuotaNormal = $mensualidad;
    //mensualidad alumno override if exists
    if ($mensualidadAlumno != null) {
      $cuotaNormal = (Double) $mensualidadAlumno;
    }
    $cuotaNormalRefImpConc = $cuotaNormal;
    $cuotaNormal = (Double) $cuotaNormal + $importePorAntCred;



    //CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------
    //AGARRAR LAS 2 ULTIMAS CIFRAS
    $perAnioPagoRef = (String) substr($curso->periodo->perAnioPago, -2);
    $refNum =  $perAnioPagoRef . $concepto;
    // if ($curPlanPago == "A") {
    if ($curPlanPago == "A" && $currentDate->lt($fechaNormalPagoCarbon)) {

      $alumnoId   = $curso->alumno_id;
      $programaId = $curso->cgt->plan->programa->id;
      $refAnioPer = $curso->periodo->perAnioPago;
      $refConcPago = $concepto;
      $refFechaVenc = $fechaNormalPagoMysql;
      $refImpTotal = $cuotaNormal;
      $refImpConc = $cuotaProntoPagoRefImpConc;
      $refImpBeca = 0;
      $refImpPP = 0;
      $refImpAntCred = $importePorAntCred;
      $refImpRecar = 0;
      $refUsuarioAplico = null;
      $refFechaAplico   = null;
      $refEstado = "P";


      $refNum = $this->generarRegistroReferencia(
        $alumnoId, $programaId,  $refAnioPer,
        $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
        $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
        $refFechaAplico, $refEstado);
    }

    $refConcepto = $curso->alumno->aluClave . $refNum;



    $cuotaNormalPagoRef = number_format(ceil($cuotaNormal), 2, '.', '');
    $crearReferenciaNormalPago = $this->crear($refConcepto, $fechaNormalPago, $cuotaNormalPagoRef);
    $cuotaNormalPagoRef = number_format(ceil($cuotaNormal), 2, '.', ',');

    //FIN  CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------




    //TERMINA CUOTA NORMAL ------------------------------------------------------------




    //CUOTA ATRASO -------------------------------------------------
    $cuotaMensualidad = (Double) $mensualidad;
    $importeAtraso = $cuotaActual->cuoImporteVencimiento;
    //mensualidad alumno override if exists

		if ($mensualidadAlumno != null) {
			$cuotaMensualidad = (Double) $mensualidadAlumno;
		}


		if ($importeVencimientoAlumno != null) {
			$importeAtraso = (Double) $importeVencimientoAlumno;
		}
    $cuotaAtrasoRefImpConc = $cuotaMensualidad + $importeAtraso;
    $cuotaAtraso = $cuotaMensualidad + $importeAtraso + $importePorAntCred;


    //CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------
    //AGARRAR LAS 2 ULTIMAS CIFRAS
    $perAnioPagoRef = (String) substr($curso->periodo->perAnioPago, -2);
    $refNum =  $perAnioPagoRef . $concepto;
    // if ($curPlanPago == "A") {
    if ($curPlanPago == "A" && $currentDate->lt($fechaAtrasoPagoCarbon)) {

      $alumnoId   = $curso->alumno_id;
      $programaId = $curso->cgt->plan->programa->id;
      $refAnioPer = $curso->periodo->perAnioPago;
      $refConcPago = $concepto;
      $refFechaVenc = $fechaAtrasoPagoMysql;
      $refImpTotal = $cuotaAtraso;
      $refImpConc = $cuotaAtrasoRefImpConc;
      $refImpBeca = 0;
      $refImpPP = 0;
      $refImpAntCred = $importePorAntCred;
      $refImpRecar = $importeAtraso;
      $refUsuarioAplico = null;
      $refFechaAplico   = null;
      $refEstado = "P";


      $refNum = $this->generarRegistroReferencia(
        $alumnoId, $programaId,  $refAnioPer,
        $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
        $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
        $refFechaAplico, $refEstado);
    }

    $refConcepto = $curso->alumno->aluClave . $refNum;



    $cuotaAtrasoPagoRef = number_format(ceil($cuotaAtraso), 2, '.', '');
    $crearReferenciaAtrasoPago = $this->crear($refConcepto, $fechaAtrasoPago, $cuotaAtrasoPagoRef);
    $cuotaAtrasoPagoRef = number_format(ceil($cuotaAtraso), 2, '.', ',');


    //FIN  CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------

    //TERMINA CUOTA ATRASO -------------------------------------------------





    // $currentDate = Carbon::createFromDate(2018, 1, 16); // para test
    $cuotaAtrasoPorMeses1 = 0;
    $crearReferenciaCuotaAtrasoPorMeses1 = "";
    $fechaAtrasoPago1Meses = null;
    $espagoAtraso1 = false;
    if ($currentDate->month != $currentDateVencimiento->month) {
      $espagoAtraso1 = false;

      $limiteMes = $currentDate->endOfMonth();


      $mesCdv = $limiteMes->month;
      $anioCdv = $limiteMes->year;

      $mesFnp = $fechaNormalPagoCarbon->month;
      $anioFnp = $fechaNormalPagoCarbon->year;


      //sacar mes completo de diferencia sin dias. Salto de mes.
      $diffMeses = ($mesCdv + (12 * ($anioCdv - $anioFnp))) - $mesFnp;


      //CUOTA ATRASO -------------------------------------------------
      $cuotaMensualidad = (Double) $mensualidad;
      $importeAtraso = $cuotaActual->cuoImporteVencimiento;
      //mensualidad alumno override if exists

      if ($mensualidadAlumno != null) {
        $cuotaMensualidad = (Double) $mensualidadAlumno;
      }


      if ($importeVencimientoAlumno != null) {
        $importeAtraso = (Double) $importeVencimientoAlumno;
      }

      $cuotaAtrasoPorMeses1RefImpConc = $cuotaMensualidad;
      $cuotaAtrasoPorMeses1 = $cuotaMensualidad + ($importeAtraso * $diffMeses) + $importePorAntCred;



      //CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------
      //AGARRAR LAS 2 ULTIMAS CIFRAS
      $perAnioPagoRef = (String) substr($curso->periodo->perAnioPago, -2);
      $refNum =  $perAnioPagoRef . $concepto;

      if ($curPlanPago == "A") {
        $alumnoId   = $curso->alumno_id;
        $programaId = $curso->cgt->plan->programa->id;
        $refAnioPer = $curso->periodo->perAnioPago;
        $refConcPago = $concepto;
        $refFechaVenc = $limiteMes->year . "/" . $limiteMes->month . "/" . $limiteMes->day;
        $refImpTotal = $cuotaAtrasoPorMeses1;
        $refImpConc = $cuotaAtrasoPorMeses1RefImpConc;
        $refImpBeca = 0;
        $refImpPP = 0;
        $refImpAntCred = $importePorAntCred;
        $refImpRecar = $importeAtraso * $diffMeses;
        $refUsuarioAplico = null;
        $refFechaAplico   = null;
        $refEstado = "P";


        $refNum = $this->generarRegistroReferencia(
          $alumnoId, $programaId,  $refAnioPer,
          $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
          $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
          $refFechaAplico, $refEstado);
      }

      $refConcepto = $curso->alumno->aluClave . $refNum;


      $cuotaAtrasoPorMeses1Ref = number_format(ceil($cuotaAtrasoPorMeses1), 2, '.', '');
      $fechaAtrasoPago1Meses = $limiteMes->year . "-" . $limiteMes->month . "-" . $limiteMes->day;
      $crearReferenciaCuotaAtrasoPorMeses1 = $this->crear($refConcepto, $fechaAtrasoPago1Meses, $cuotaAtrasoPorMeses1Ref);
      $cuotaAtrasoPorMeses1 = number_format(ceil($cuotaAtrasoPorMeses1), 2, '.', ',');


      //FIN  CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------
    }











    //CUOTA ATRASO POR MESES 2
    $cuotaAtrasoPorMeses2 = 0;
    $crearReferenciaCuotaAtrasoPorMeses2 = "";
    $fechaAtrasoPago2Meses = null;
    $espagoAtraso2 = false;
    if ($currentDateVencimiento->gt($fechaAtrasoPagoCarbon)) {
      $espagoAtraso2 = true;

      $mesCdv = $currentDateVencimiento->month;
      $anioCdv = $currentDateVencimiento->year;

      $mesFnp = $fechaNormalPagoCarbon->month;
      $anioFnp = $fechaNormalPagoCarbon->year;


      //sacar mes completo de diferencia sin dias. Salto de mes.
      $diffMeses = ($mesCdv + (12 * ($anioCdv - $anioFnp))) - $mesFnp;






      //CUOTA ATRASO -------------------------------------------------
      $cuotaMensualidad = (Double) $mensualidad;
      $importeAtraso = $cuotaActual->cuoImporteVencimiento;
      //mensualidad alumno override if exists

      if ($mensualidadAlumno != null) {
        $cuotaMensualidad = (Double) $mensualidadAlumno;
      }


      if ($importeVencimientoAlumno != null) {
        $importeAtraso = (Double) $importeVencimientoAlumno;
      }



      $cuotaAtrasoPorMeses2RefImpConc = $cuotaMensualidad;
      $cuotaAtrasoPorMeses2 = $cuotaMensualidad + ($importeAtraso * $diffMeses) + $importePorAntCred;




      //CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------
      //AGARRAR LAS 2 ULTIMAS CIFRAS
      $perAnioPagoRef = (String) substr($curso->periodo->perAnioPago, -2);
      $refNum =  $perAnioPagoRef . $concepto;

      if ($curPlanPago == "A") {
        $alumnoId   = $curso->alumno_id;
        $programaId = $curso->cgt->plan->programa->id;
        $refAnioPer = $curso->periodo->perAnioPago;
        $refConcPago = $concepto;
        $refFechaVenc = $currentDateVencimiento->year . "/" . $currentDateVencimiento->month . "/" . $currentDateVencimiento->day;
        $refImpTotal = $cuotaAtrasoPorMeses2;
        $refImpConc = $cuotaAtrasoPorMeses2RefImpConc;
        $refImpBeca = 0;
        $refImpPP = 0;
        $refImpAntCred = $importePorAntCred;
        $refImpRecar = $importeAtraso * $diffMeses;
        $refUsuarioAplico = null;
        $refFechaAplico   = null;
        $refEstado = "P";


        $refNum = $this->generarRegistroReferencia(
          $alumnoId, $programaId,  $refAnioPer,
          $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
          $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
          $refFechaAplico, $refEstado);
      }

      $refConcepto = $curso->alumno->aluClave . $refNum;


      $cuotaAtrasoPorMeses2Ref = number_format(ceil($cuotaAtrasoPorMeses2), 2, '.', '');
      $fechaAtrasoPago2Meses = $currentDateVencimiento->year . "-" . $currentDateVencimiento->month . "-" . $currentDateVencimiento->day;
      $crearReferenciaCuotaAtrasoPorMeses2 = $this->crear($refConcepto, $fechaAtrasoPago2Meses, $cuotaAtrasoPorMeses2Ref);
      $cuotaAtrasoPorMeses2 = number_format(ceil($cuotaAtrasoPorMeses2), 2, '.', ',');




      //FIN  CREAR REFERENCIAS DE ANTICIPO CREDITO ---------------------------------------------------------------


      //TERMINA CUOTA ATRASO -------------------------------------------------
    }


    // dd($fechaProntoPagoCorto);

    $fechaAtrasoPago1Meses = $fechaAtrasoPago1Meses ? $this->fechaPagoFormatoTerjeta($fechaAtrasoPago1Meses) : "";
    $fechaAtrasoPago2Meses = $fechaAtrasoPago2Meses ? $this->fechaPagoFormatoTerjeta($fechaAtrasoPago2Meses) : "";

    $curDate = Carbon::now();



    return (Object) [

      "curTipoBeca" => $curso->curTipoBeca,

      "esMensualidadPagada"  => false,
      "mensualidadPagada"    => 0,

      "cuotaProntoPago"      => $cuotaProntoPagoRef,
      "referenciaProntoPago" => $crearReferenciaProntoPago,
      "fechaProntoPago"      => $fechaProntoPagoCorto,
      "esFechaProntoPagoVencida" => $curDate->setTime(0, 0, 0)->gt($fechaProntoPagoCarbon->setTime(0, 0, 0)),

      "cuotaNormal"          => $cuotaNormalPagoRef,
      "referenciaNormal"     => $crearReferenciaNormalPago,
      "fechaNormalPagoCorto" => $fechaNormalPagoCorto,
      "esFechaNormalPagoVencida" => $curDate->setTime(0, 0, 0)->gt($fechaNormalPagoCarbon->setTime(0, 0, 0)),

      "cuotaAtraso"          => $cuotaAtrasoPagoRef,
      "referenciaAtraso"     => $crearReferenciaAtrasoPago,
      "fechaAtrasoPagoCorto" => $fechaAtrasoPagoCorto,

      "cuotaAtrasoPorMeses1"  => $cuotaAtrasoPorMeses1,
      "referenciaAtrasoMes1"  => $crearReferenciaCuotaAtrasoPorMeses1,
      "fechaAtrasoPago1Meses" => $fechaAtrasoPago1Meses,

      "cuotaAtrasoPorMeses2"  => $cuotaAtrasoPorMeses2,
      "referenciaAtrasoMes2"  => $crearReferenciaCuotaAtrasoPorMeses2,
      "fechaAtrasoPago2Meses" => $fechaAtrasoPago2Meses,

      "espagoAtraso1" => $espagoAtraso1,
      "espagoAtraso2" => $espagoAtraso2,
    ];
  }

  public function fechaPagoFormatoTerjeta($fecha)
  {
    $fecha = Carbon::parse($fecha);
    $fecha = sprintf('%02d', $fecha->day) . "/" . Utils::num_meses_corto_string($fecha->month) . "/" . $fecha->year;
    return $fecha;
  }


  public function generarRegistroReferencia($alumnoId, $programaId, $refAnioPer,
    $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
    $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
    $refFechaAplico, $refEstado ) {

    $refNum = 0;
    $referencia = Referencia::where("alumno_id", $alumnoId)->get()->sortBy("refNum")->last();
    if ($referencia) {
        if($referencia->refNum == "9999")
        {
            $refNum = sprintf('%04d', 1);
        }
        else
        {
            $refNum = sprintf('%04d', $referencia->refNum + 1);
        }
    }
    if (!$referencia) {
      $refNum = sprintf('%04d', 1);
    }

    $referencia = Referencia::create([
      'alumno_id'     => $alumnoId,
      'programa_id'   => $programaId,
      'refNum'        => $refNum,
      'refAnioPer'    => $refAnioPer,
      'refConcPago'   => $refConcPago,
      'refFechaVenc'  => $refFechaVenc,
      'refImpTotal'   => $refImpTotal,
      'refImpConc'    => $refImpConc,
      'refImpBeca'    => $refImpBeca,
      'refImpPP'      => $refImpPP,
      'refImpAntCred' => $refImpAntCred,
      'refImpRecar'    => $refImpRecar,
      'refUsuarioAplico' => $refUsuarioAplico,
      'refFechaAplico'   => $refFechaAplico,
      'refEstado'        => $refEstado
    ]);

    return $refNum;
  }


    public function generarRegistroReferenciaHSBC($alumnoId, $programaId, $refAnioPer,
                                              $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
                                              $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
                                              $refFechaAplico, $refEstado ) {

        $refNum = 0;
        //$referencia = Referencia::where("alumno_id", $alumnoId)->get()->sortBy("refNum")->last();

        $referencia = Referencia::where("alumno_id", $alumnoId)
            ->where("refAnioPer", $refAnioPer)
            ->where("refConcPago", $refConcPago)
            ->orderBy('refAnioPer')
            ->orderBy('id')
            ->get()->last();

        if ($referencia) {
            if($referencia->refNum == "9999")
            {
                $refNum = sprintf('%04d', 1);
            }
            else
            {
                $refNum = sprintf('%04d', $referencia->refNum + 1);
            }
        }
        if (!$referencia) {
            $refNum = sprintf('%04d', 1);
        }

        $id_banco = 7;
        $referencia = Referencia::create([
            'alumno_id'     => $alumnoId,
            'programa_id'   => $programaId,
            'refNum'        => $refNum,
            'refAnioPer'    => $refAnioPer,
            'refConcPago'   => $refConcPago,
            'refFechaVenc'  => $refFechaVenc,
            'refImpTotal'   => $refImpTotal,
            'refImpConc'    => $refImpConc,
            'refImpBeca'    => $refImpBeca,
            'refImpPP'      => $refImpPP,
            'refImpAntCred' => $refImpAntCred,
            'refImpRecar'    => $refImpRecar,
            'refUsuarioAplico' => $refUsuarioAplico,
            'refFechaAplico'   => $refFechaAplico,
            'refEstado'        => $refEstado,
            'banco_id'         => $id_banco
        ]);

        return $refNum;
    }

    public function generarRegistroReferenciaBBVA($alumnoId, $programaId, $refAnioPer,
                                                  $refConcPago, $refFechaVenc, $refImpTotal, $refImpConc,
                                                  $refImpBeca, $refImpPP, $refImpAntCred, $refImpRecar, $refUsuarioAplico,
                                                  $refFechaAplico, $refEstado ) {

        $refNum = 0;
        //$referencia = Referencia::where("alumno_id", $alumnoId)->get()->sortBy("refAnioPer")->sortBy("refNum")->last();
        /*
        $referencia = Referencia::where("alumno_id", $alumnoId)
            ->orderBy('refAnioPer')
            ->orderBy('id')
            ->get()->last();
        */

        $referencia = Referencia::where("alumno_id", $alumnoId)
            ->where("refAnioPer", $refAnioPer)
            ->where("refConcPago", $refConcPago)
            ->orderBy('refAnioPer')
            ->orderBy('id')
            ->get()->last();

        //dd($referencia->refNum);

        if ($referencia) {
            if($referencia->refNum == "9999")
            {
                $refNum = sprintf('%04d', 1);
            }
            else
            {
                $refNum = sprintf('%04d', $referencia->refNum + 1);
            }
        }
        else
        {
            if (!$referencia) {
                $refNum = sprintf('%04d', 1);
            }
        }


        $id_banco = 4;
        $referencia = Referencia::create([
            'alumno_id'     => $alumnoId,
            'programa_id'   => $programaId,
            'refNum'        => $refNum,
            'refAnioPer'    => $refAnioPer,
            'refConcPago'   => $refConcPago,
            'refFechaVenc'  => $refFechaVenc,
            'refImpTotal'   => $refImpTotal,
            'refImpConc'    => $refImpConc,
            'refImpBeca'    => $refImpBeca,
            'refImpPP'      => $refImpPP,
            'refImpAntCred' => $refImpAntCred,
            'refImpRecar'    => $refImpRecar,
            'refUsuarioAplico' => $refUsuarioAplico,
            'refFechaAplico'   => $refFechaAplico,
            'refEstado'        => $refEstado,
            'banco_id'         => $id_banco
        ]);

        return $refNum;
    }
}

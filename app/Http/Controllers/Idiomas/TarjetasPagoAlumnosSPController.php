<?php

namespace App\Http\Controllers\Idiomas;

use DB;
use PDF;


use Ficha;
use Carbon\Carbon;
use App\Http\Models\Beca;
use App\Http\Models\Pago;
use App\Http\Models\Plan;
use App\Http\Models\Cuota;
use App\Http\Models\Curso;
use App\Http\Models\Idiomas\Idiomas_cursos;

use App\Http\Helpers\Utils;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Helpers\GenerarReferencia;
use App\clases\alumnos\MetodosAlumnos;
use RealRashid\SweetAlert\Facades\Alert;


class TarjetasPagoAlumnosSPController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    set_time_limit(8000000);
  }


  public function reporte()
  {

    return View('reportes/tarjetas_pago_alumnos.spcreate', [
      "becas" => Beca::all(),
      "ubicaciones" => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function imprimir(Request $request)
  {
    $periodo      = Periodo::where("id", "=", $request->periodo_id)->first();
    $ubicacion    = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
    $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
    $escuela      = Escuela::where("id", "=", $request->escuela_id)->first();
    $programa     = Programa::where("id", "=", $request->programa_id)->first();
    $plan         = Plan::where("id", "=", $request->plan_id)->first();

    $escClave = $escuela ? $escuela->escClave: "";
    $ubiClave = $ubicacion ? $ubicacion->ubiClave: "";

    $perNumero = $periodo ? $periodo->perNumero: "";
    $perAnio   = $periodo ? $periodo->perAnio: "";
    $depClave  = $departamento ? $departamento->depClave: "";
    $progClave = $programa ? $programa->progClave: "";
    $planClave = $plan ? $plan->planClave: "";
    $aluClave = $request->aluClave;

    $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
        $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
    //dd($conpRefClave);
    //
    $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;
    /*
    $procLibretaPago = DB::select('call procLibretaPagoCOVID("'
      .$perNumero.'", "'
      .$perAnio.'", "'
      .$ubiClave.'", "'
      .$depClave.'", "'
      .$escClave.'", "'
      .$progClave.'", "'
      .$planClave.'", "'
      .$request->cgtGradoSemestre.'", "'
      .$request->cgtGrupo.'", "'
      .$request->curEstado.'", "'
      .$request->curPlanPago.'", "'
      .$request->vigenciaBeca.'", "'
      .$request->bcaClave.'", "'
      .$request->porcentajeBeca.'", "'
      .$request->aluClave.'", "'
      .$request->banco.'")');
    */

      if ($depClave == "PRE")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDPre("'
              .$perNumero.'", "'
              .$perAnio.'", "'
              .$ubiClave.'", "'
              .$depClave.'", "'
              .$escClave.'", "", "", "", "", "", "", "", "", "", "'
              .$aluClave.'", "")');
      }
      if ($depClave == "PRI")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDPri("'
              .$perNumero.'", "'
              .$perAnio.'", "'
              .$ubiClave.'", "'
              .$depClave.'", "'
              .$escClave.'", "", "", "", "", "", "", "", "", "", "'
              .$aluClave.'", "")');
      }

      if ($depClave == "SEC")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDSec("'
              .$perNumero.'", "'
              .$perAnio.'", "'
              .$ubiClave.'", "'
              .$depClave.'", "'
              .$escClave.'", "", "", "", "", "", "", "", "", "", "'
              .$aluClave.'", "")');
      }

      if ($depClave == "BAC")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDBac("'
              .$perNumero.'", "'
              .$perAnio.'", "'
              .$ubiClave.'", "'
              .$depClave.'", "'
              .$escClave.'", "", "", "", "", "", "", "", "", "", "'
              .$aluClave.'", "")');
      }

      if ($depClave == "SUP" || $depClave == "POS")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVID("'
              .$perNumero.'", "'
              .$perAnio.'", "'
              .$ubiClave.'", "'
              .$depClave.'", "'
              .$escClave.'", "", "", "", "", "", "", "", "", "", "'
              .$aluClave.'", "")');
      }

    $bancoSeleccionado = $request->banco;

    $procLibretaPago = collect($procLibretaPago);

    $procLibretaPago->map(function ($item, $key) use ($bancoSeleccionado, $conpRefClave)
    {
      $generarReferencia = new GenerarReferencia;


      if (!is_null($item->importe1))
      {
        $fecha1 = Carbon::parse($item->fecha1);

        $item->fecha1Formato = sprintf('%02d', $fecha1->day)
        . "/" . Utils::num_meses_corto_string($fecha1->month)
        . "/" . $fecha1->year;
      }

      if (!is_null($item->importe2)) {
        $fecha2 = Carbon::parse($item->fecha2);


        $item->fecha2Formato = sprintf('%02d', $fecha2->day)
        . "/" . Utils::num_meses_corto_string($fecha2->month)
        . "/" . $fecha2->year;
      }
      if (!is_null($item->importe3)) {
        $fecha3 = Carbon::parse($item->fecha3);


        $item->fecha3Formato = sprintf('%02d', $fecha3->day)
        . "/" . Utils::num_meses_corto_string($fecha3->month)
        . "/" . $fecha3->year;
      }



      if ($item->estado == "DEBE") {
        if ($item->titulo == "INSCRIPCION") {
          $referenciaInscParcial = $item->clavePago . $item->anioConc . "00";

          $fechaRef1 = Carbon::parse($item->fecha1);
          $fechaRef2 = Carbon::parse($item->fecha2);
          $fechaRef3 = Carbon::parse($item->fecha3);

          $fechaInscRef1 = "$fechaRef1->year-$fechaRef1->month-$fechaRef1->day";
          $fechaInscRef2 = "$fechaRef2->year-$fechaRef2->month-$fechaRef2->day";
          $fechaInscRef3 = "$fechaRef3->year-$fechaRef3->month-$fechaRef3->day";

          $referenciaInscripcion1 = null;
          $referenciaInscripcion2 = null;
          $referenciaInscripcion3 = null;

          if (!is_null($item->importe1)) {
		        $inscripcionRef = number_format(ceil($item->importe1), 2, '.', '');

                if ($bancoSeleccionado == "BBVA")
                {
                    /*
                    $referenciaInscripcion1 = $generarReferencia
                        ->crear($referenciaInscParcial, $fechaInscRef1, $inscripcionRef);
                    */
                    $referenciaInscripcion1 = $generarReferencia
                        ->crearBBVA($referenciaInscParcial, $fechaInscRef1, $inscripcionRef, $conpRefClave);

                }

                if ($bancoSeleccionado == "HSBC")
                {
                  $referenciaInscripcion1 = $generarReferencia
                      ->crearHSBC($referenciaInscParcial, $fechaInscRef1, $inscripcionRef, $conpRefClave);
                }

          }

          if (!is_null($item->importe2)) {
		        $inscripcionRef = number_format(ceil($item->importe2), 2, '.', '');

              if ($bancoSeleccionado == "BBVA") {
                  /*
                  $referenciaInscripcion2 = $generarReferencia
                      ->crear($referenciaInscParcial, $fechaInscRef2, $inscripcionRef);
                  */
                  $referenciaInscripcion2 = $generarReferencia
                      ->crearBBVA($referenciaInscParcial, $fechaInscRef2, $inscripcionRef, $conpRefClave);
              }

              if ($bancoSeleccionado == "HSBC") {
                  $referenciaInscripcion2 = $generarReferencia
                      ->crearHSBC($referenciaInscParcial, $fechaInscRef2, $inscripcionRef, $conpRefClave);
              }
          }

          if (!is_null($item->importe3)) {
		        $inscripcionRef = number_format(ceil($item->importe3), 2, '.', '');

              if ($bancoSeleccionado == "BBVA") {
                  /*
                  $referenciaInscripcion3 = $generarReferencia
                      ->crear($referenciaInscParcial, $fechaInscRef3, $inscripcionRef);
                  */
                  $referenciaInscripcion3 = $generarReferencia
                      ->crearBBVA($referenciaInscParcial, $fechaInscRef3, $inscripcionRef, $conpRefClave);
              }

              if ($bancoSeleccionado == "HSBC") {
                  $referenciaInscripcion3 = $generarReferencia
                      ->crearHSBC($referenciaInscParcial, $fechaInscRef3, $inscripcionRef, $conpRefClave);
              }
          }

          $item->referencia1 = $referenciaInscripcion1;
          $item->referencia2 = $referenciaInscripcion2;
          $item->referencia3 = $referenciaInscripcion3;
        }

        if ($item->titulo != "INSCRIPCION") {
          // dd($item);

          $referenciaPago1 = null;
          $referenciaPago2 = null;
          $referenciaPago3 = null;

          if (!is_null($item->importe1)) {
            $refNum = $item->anioConc . $item->concepto;
            $refConcepto = $item->clavePago . $refNum;
            $cuotaImporte = number_format(ceil($item->importe1), 2, '.', '');
            $fechaImporte = $item->fecha1;

              if ($bancoSeleccionado == "BBVA") {
                if($item->planPago == "A") {
                  $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                      $item->alumno_id, $item->programa_id, $item->anioCuota,
                      $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                      $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                      null, "P");
                  $refConcepto = $item->clavePago . $refNum;
                }
                //$referenciaPago1 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
                $referenciaPago1 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
              }
              if ($bancoSeleccionado == "HSBC") {
                if($item->planPago == "A") {
                  $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                      $item->alumno_id, $item->programa_id, $item->anioCuota,
                      $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                      $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                      null, "P");
                  $refConcepto = $item->clavePago . $refNum;
                }
                $referenciaPago1 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
              }
          }

          if (!is_null($item->importe2)) {

              /* YA LO TRAIGO CALCULADO DESDE EL SP....CARAJOOOOS!!!!!
              //CUARENTENA COVID APOYO
              if (
                  ( ($item->titulo == "SEPTIEMBRE") || ($item->titulo == "OCTUBRE")
                      || ($item->titulo == "NOVIEMBRE") || ($item->titulo == "DICIEMBRE")) &&
                  ($item->perAnio == 2020)
                  && ($item->perNumero == 3)
              )
              {
                   //dd($item);

                  $refNum = $item->anioConc . $item->concepto;
                  $refConcepto = $item->clavePago . $refNum;
                  $cuotaImporte = number_format(ceil($item->importe1), 2, '.', '');
                  $fechaImporte = $item->fecha2;

                  if ($bancoSeleccionado == "BBVA") {
                      $refNum = $generarReferencia->generarRegistroReferencia(
                          $item->alumno_id, $item->programa_id, $item->anioCuota,
                          $item->concepto, $item->fecha2, $item->importe1, $item->refImpConc1,
                          $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                          null, "P");
                      $referenciaPago2 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
                  }
                  if ($bancoSeleccionado == "HSBC") {
                      $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                          $item->alumno_id, $item->programa_id, $item->anioCuota,
                          $item->concepto, $item->fecha2, $item->importe1, $item->refImpConc1,
                          $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                          null, "P");
                      $referenciaPago2 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
                  }
                  $item->importe2 = $item->importe1;
                  //$item->fecha2 = $item->fecha1;
                  $item->refImpConc2 = $item->refImpConc1;
                  $item->refImpBeca2 = $item->refImpBeca1;
                  $item->refImpPP2 = $item->refImpPP1;
                  $item->refImpAntCred2 = $item->refImpAntCred1;
                  $item->refImpRecar2 = $item->refImpRecar1;

              }
              else
              { */

                  $refNum = $item->anioConc . $item->concepto;
                  $refConcepto = $item->clavePago . $refNum;
                  $cuotaImporte = number_format(ceil($item->importe2), 2, '.', '');
                  $fechaImporte = $item->fecha2;

                  if ($bancoSeleccionado == "BBVA") {
                    if($item->planPago == "A") {
                      $refNum = $generarReferencia->generarRegistroReferencia(
                          $item->alumno_id, $item->programa_id, $item->anioCuota,
                          $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                          $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                          null, "P");
                      $refConcepto = $item->clavePago . $refNum;
                    }
                    //$referenciaPago2 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
                    $referenciaPago2 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
                  }
                  if ($bancoSeleccionado == "HSBC") {
                    if($item->planPago == "A") {
                      $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                          $item->alumno_id, $item->programa_id, $item->anioCuota,
                          $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                          $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                          null, "P");
                      $refConcepto = $item->clavePago . $refNum;
                    }
                    $referenciaPago2 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
                  }

             // }



          }

          if (!is_null($item->importe3))
          {
            $refNum = $item->anioConc . $item->concepto;
            $refConcepto = $item->clavePago . $refNum;
            $cuotaImporte = number_format(ceil($item->importe3), 2, '.', '');
            $fechaImporte = $item->fecha3;

              if ($bancoSeleccionado == "BBVA") {
                if($item->planPago == "A") {
                  $refNum = $generarReferencia->generarRegistroReferencia(
                      $item->alumno_id, $item->programa_id, $item->anioCuota,
                      $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                      $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                      null, "P");
                  $refConcepto = $item->clavePago . $refNum;
                }
                //$referenciaPago3 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
                $referenciaPago3 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
              }
              if ($bancoSeleccionado == "HSBC") {
                if($item->planPago == "A") {
                  $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                      $item->alumno_id, $item->programa_id, $item->anioCuota,
                      $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                      $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                      null, "P");
                  $refConcepto = $item->clavePago . $refNum;
                }
                $referenciaPago3 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave);
              }
          }


          $item->referenciaPago1 = $referenciaPago1;
          $item->referenciaPago2 = $referenciaPago2;
          $item->referenciaPago3 = $referenciaPago3;
        }
      }

      return $item;
    });

    // dd($procLibretaPago);


    $procLibretaPago = $procLibretaPago->groupBy("clavePago");


    // $curPlanPago = "";
    // $nombreArchivo = "";
    // if ($curPlanPago == "N" || $curPlanPago == "A") {
    //   $nombreArchivo = "pdf_tarjeta_pago_normal_anticipo";
    // }
    // if ($curPlanPago == "O") {
    //   $nombreArchivo = "pdf_tarjeta_pago_once_meses";
    // }
    // if ($curPlanPago == "D") {
    //   $nombreArchivo = "pdf_tarjeta_pago_doce_meses";
    // }


    $fechaActual = Carbon::now("CDT");
    $fechaActualFormatoTarjeta = sprintf('%02d', $fechaActual->day)
      . "/" . Utils::num_meses_corto_string($fechaActual->month)
      . "/" . $fechaActual->year;

    $horaActual = $fechaActual->format("H:i:s");

		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');

      if ($bancoSeleccionado == "BBVA") {
          $pdf = PDF::loadView("reportes.pdf.tarjetas_pago_sp.tarjeta_pago_todo", [
              "pagos" => $procLibretaPago,
              "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
              "horaActual" => $horaActual
          ]);
      }

      if ($bancoSeleccionado == "HSBC") {
          $pdf = PDF::loadView("reportes.pdf.tarjetas_pago_sp.tarjeta_pago_todo_hsbc", [
              "pagos" => $procLibretaPago,
              "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
              "horaActual" => $horaActual
          ]);
      }



		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream("archivo".'.pdf');
		return $pdf->download($nombreArchivo.'.pdf');
  }


 public function imprimirdesdecurso($curso_id, $bancoSeleccionado)
    {
        $curso = Idiomas_cursos::select(
            'ubicacion.ubiClave',
            'departamentos.depClave',
            'escuelas.escClave',
            'periodos.perAnioPago',
            'periodos.perNumero',
            'periodos.perAnio',
            'alumnos.aluClave'
        )
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->where('idiomas_cursos.id', $curso_id)->first();

        //INSCRIPCION SIEMPRE VA POR LA CUOTA ACTUAL
        $ubiClave = $curso->ubiClave;
        $depClave = $curso->depClave;
        $escClave = $curso->escClave;
        //AÑO DE LA INSCRIPCION - PERIODO AÑO DE PAGO
        $perAnioPago = $curso->perAnioPago;
        $perNumero = $curso->perNumero;
        $perAnio   = $curso->perAnio;
        $aluClave = $curso->aluClave;

        $porcentajeBeca = 0;


        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");

        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        $procLibretaPago = DB::select('call procLibretaPagoCOVIDIdi("'
            .$perNumero.'", "'
            .$perAnio.'", "'
            .$ubiClave.'", "'
            .$depClave.'", "'
            .$escClave.'", "", "", "", "", "", "", "", "", "", "'
            .$aluClave.'", "")');

        $procLibretaPago = collect($procLibretaPago);
// foreach ($procLibretaPago as $key => $item) {
//     echo 'planPago: '.$item->planPago;
//     echo '<br>';
// }
// dd('fin foreach');
        $procLibretaPago->map(function ($item, $key) use ($bancoSeleccionado, $conpRefClave, $curso)
        {
            $generarReferencia = new GenerarReferencia;

            if (!is_null($item->importe1))
            {
                $fecha1 = Carbon::parse($item->fecha1);

                $item->fecha1Formato = sprintf('%02d', $fecha1->day)
                    . "/" . Utils::num_meses_corto_string($fecha1->month)
                    . "/" . $fecha1->year;
            }
            if (!is_null($item->importe2)) {
                $fecha2 = Carbon::parse($item->fecha2);

                $item->fecha2Formato = sprintf('%02d', $fecha2->day)
                    . "/" . Utils::num_meses_corto_string($fecha2->month)
                    . "/" . $fecha2->year;
            }
            if (!is_null($item->importe3)) {
                $fecha3 = Carbon::parse($item->fecha3);

                $item->fecha3Formato = sprintf('%02d', $fecha3->day)
                    . "/" . Utils::num_meses_corto_string($fecha3->month)
                    . "/" . $fecha3->year;
            }


            if ($item->estado == "DEBE") {

                if ($item->titulo == "INSCRIPCION") {
                    $referenciaInscParcial = $item->clavePago . $item->anioConc . "00";

                    $fechaRef1 = Carbon::parse($item->fecha1);
                    $fechaRef2 = Carbon::parse($item->fecha2);
                    $fechaRef3 = Carbon::parse($item->fecha3);

                    $fechaInscRef1 = "$fechaRef1->year-$fechaRef1->month-$fechaRef1->day";
                    $fechaInscRef2 = "$fechaRef2->year-$fechaRef2->month-$fechaRef2->day";
                    $fechaInscRef3 = "$fechaRef3->year-$fechaRef3->month-$fechaRef3->day";

                    $referenciaInscripcion1 = null;
                    $referenciaInscripcion2 = null;
                    $referenciaInscripcion3 = null;

                    if (!is_null($item->importe1)) {
                        $inscripcionRef = number_format(ceil($item->importe1), 2, '.', '');

                        if ($bancoSeleccionado == "BBVA")
                        {
                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                                $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                                null, "P");

                            $referenciaInscripcion1 = $generarReferencia
                                ->crearBBVA($referenciaInscParcial, $fechaInscRef1, $inscripcionRef, $conpRefClave, $refNum);
                        }

                        if ($bancoSeleccionado == "HSBC")
                        {
                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                                $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                                null, "P");

                            $referenciaInscripcion1 = $generarReferencia
                                ->crearHSBC($referenciaInscParcial, $fechaInscRef1, $inscripcionRef, $conpRefClave, $refNum);
                        }

                    }

                    if (!is_null($item->importe2)) {
                        $inscripcionRef = number_format(ceil($item->importe2), 2, '.', '');

                        if ($bancoSeleccionado == "BBVA") {
                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                                $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                                null, "P");

                            $referenciaInscripcion2 = $generarReferencia
                                ->crearBBVA($referenciaInscParcial, $fechaInscRef2, $inscripcionRef, $conpRefClave, $refNum);
                        }

                        if ($bancoSeleccionado == "HSBC") {
                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                                $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                                null, "P");

                            $referenciaInscripcion2 = $generarReferencia
                                ->crearHSBC($referenciaInscParcial, $fechaInscRef2, $inscripcionRef, $conpRefClave, $refNum);
                        }

                    }

                    if (!is_null($item->importe3)) {
                        $inscripcionRef = number_format(ceil($item->importe3), 2, '.', '');

                        if ($bancoSeleccionado == "BBVA") {
                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                                $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                                null, "P");

                            $referenciaInscripcion3 = $generarReferencia
                                ->crearBBVA($referenciaInscParcial, $fechaInscRef3, $inscripcionRef, $conpRefClave, $refNum);
                        }

                        if ($bancoSeleccionado == "HSBC") {
                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                                $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                                null, "P");

                            $referenciaInscripcion3 = $generarReferencia
                                ->crearHSBC($referenciaInscParcial, $fechaInscRef3, $inscripcionRef, $conpRefClave, $refNum);
                        }
                    }

                    $item->referencia1 = $referenciaInscripcion1;
                    $item->referencia2 = $referenciaInscripcion2;
                    $item->referencia3 = $referenciaInscripcion3;
                }

                if ($item->titulo != "INSCRIPCION") {
                    $referenciaPago1 = null;
                    $referenciaPago2 = null;
                    $referenciaPago3 = null;

                    if (!is_null($item->importe1)) {
                        $refNum = $item->anioConc . $item->concepto;
                        $refConcepto = $item->clavePago . $refNum;
                        $cuotaImporte = number_format(ceil($item->importe1), 2, '.', '');
                        $fechaImporte = $item->fecha1;

                        if ($bancoSeleccionado == "BBVA") {
                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                                $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                                null, "P");

                          $referenciaPago1 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                        }
                        if ($bancoSeleccionado == "HSBC") {
                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                                $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                                null, "P");
                          $referenciaPago1 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                        }
                    }

                    if (!is_null($item->importe2)) {
                        $refNum = $item->anioConc . $item->concepto;
                        $refConcepto = $item->clavePago . $refNum;
                        $cuotaImporte = number_format(ceil($item->importe2), 2, '.', '');
                        $fechaImporte = $item->fecha2;

                        if ($bancoSeleccionado == "BBVA") {
                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                                $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                                null, "P");
                            $referenciaPago2 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                        }
                        if ($bancoSeleccionado == "HSBC") {
                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                                $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                                null, "P");
                            $referenciaPago2 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                        }
                    }

                    if (!is_null($item->importe3))
                    {
                        $refNum = $item->anioConc . $item->concepto;
                        $refConcepto = $item->clavePago . $refNum;
                        $cuotaImporte = number_format(ceil($item->importe3), 2, '.', '');
                        $fechaImporte = $item->fecha3;

                        if ($bancoSeleccionado == "BBVA") {
                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                                $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                                null, "P");
                          $referenciaPago3 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                        }
                        if ($bancoSeleccionado == "HSBC") {
                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $item->alumno_id, $item->programa_id, $item->anioCuota,
                                $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                                $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                                null, "P");
                          $referenciaPago3 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                        }
                    }
                    $item->referenciaPago1 = $referenciaPago1;
                    $item->referenciaPago2 = $referenciaPago2;
                    $item->referenciaPago3 = $referenciaPago3;

                    $item->referencia1 = $referenciaPago1;
                    $item->referencia2 = $referenciaPago2;
                    $item->referencia3 = $referenciaPago3;
                }
            }

            return $item;
        });


        $procLibretaPago = $procLibretaPago->groupBy("clavePago");

        $fechaActual = Carbon::now("CDT");
        $fechaActualFormatoTarjeta = sprintf('%02d', $fechaActual->day)
            . "/" . Utils::num_meses_corto_string($fechaActual->month)
            . "/" . $fechaActual->year;

        $horaActual = $fechaActual->format("H:i:s");

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        if ($bancoSeleccionado == "BBVA") {
            $pdf = PDF::loadView("idiomas.reportes.pdf.tarjetas_pago_sp.tarjeta_pago_todo_bbva", [
                "pagos" => $procLibretaPago,
                "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
                "horaActual" => $horaActual
            ]);
        }

        if ($bancoSeleccionado == "HSBC") {
            $pdf = PDF::loadView("idiomas.reportes.pdf.tarjetas_pago_sp.tarjeta_pago_todo_hsbc", [
                "pagos" => $procLibretaPago,
                "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
                "horaActual" => $horaActual
            ]);
        }

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream("libretapago".'.pdf');
    }


}

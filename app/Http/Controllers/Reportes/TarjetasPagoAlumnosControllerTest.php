<?php

namespace App\Http\Controllers\Reportes;

use DB;
use PDF;


use Ficha;
use Carbon\Carbon;
use App\Http\Models\Beca;
use App\Http\Models\Pago;
use App\Http\Models\Plan;
use App\Http\Models\Cuota;
use App\Http\Models\Curso;

use App\Http\Helpers\Utils;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Helpers\GenerarReferencia;
use RealRashid\SweetAlert\Facades\Alert;


class TarjetasPagoAlumnosControllerTest extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }


  public function reporte()
  {

    return View('reportes/tarjetas_pago_alumnos.testcreate', [
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

    $procLibretaPago = DB::select('call procLibretaPago("'
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




    $procLibretaPago = collect($procLibretaPago);

    $procLibretaPago->map(function ($item, $key) {
      $generarReferencia = new GenerarReferencia;
      
      if (!is_null($item->importe1)) {
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
          
          $fechaInscRef1 = "$item->anioCuota-01-15";
          $fechaInscRef2 = "$item->anioCuota-01-31";
          $fechaInscRef3 = "$item->anioCuota-02-20";

          $referenciaInscripcion1 = null;
          $referenciaInscripcion2 = null;
          $referenciaInscripcion3 = null;

          if (!is_null($item->importe1)) {
		        $inscripcionRef = number_format(ceil($item->importe1), 2, '.', '');
            $referenciaInscripcion1 = $generarReferencia
              ->crear($referenciaInscParcial, $fechaInscRef1, $inscripcionRef);
          }

          if (!is_null($item->importe2)) {
		        $inscripcionRef = number_format(ceil($item->importe2), 2, '.', '');
            $referenciaInscripcion2 = $generarReferencia
              ->crear($referenciaInscParcial, $fechaInscRef2, $inscripcionRef);
          }

          if (!is_null($item->importe3)) {
		        $inscripcionRef = number_format(ceil($item->importe3), 2, '.', '');
            $referenciaInscripcion3 = $generarReferencia
              ->crear($referenciaInscParcial, $fechaInscRef3, $inscripcionRef);
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

 
            $refNum = $generarReferencia->generarRegistroReferencia(
              $item->alumno_id, $item->programa_id,  $item->anioCuota, 
              $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
              $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
              null, "P");
            $referenciaPago1 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
          }

          if (!is_null($item->importe2)) {
            $refNum = $item->anioConc . $item->concepto;
            $refConcepto = $item->clavePago . $refNum; 
            $cuotaImporte = number_format(ceil($item->importe2), 2, '.', '');
            $fechaImporte = $item->fecha2;

            
            $refNum = $generarReferencia->generarRegistroReferencia(
              $item->alumno_id, $item->programa_id,  $item->anioCuota, 
              $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
              $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
              null, "P");
            $referenciaPago2 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
          }

          if (!is_null($item->importe3)) {
            $refNum = $item->anioConc . $item->concepto;
            $refConcepto = $item->clavePago . $refNum; 
            $cuotaImporte = number_format(ceil($item->importe3), 2, '.', '');
            $fechaImporte = $item->fecha3;
             

            $refNum = $generarReferencia->generarRegistroReferencia(
              $item->alumno_id, $item->programa_id,  $item->anioCuota, 
              $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
              $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
              null, "P");
            $referenciaPago3 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
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

		$pdf = PDF::loadView("reportes.pdf.tarjetas_pago_test.tarjeta_pago_todo", [
      "pagos" => $procLibretaPago,
      "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
      "horaActual" => $horaActual
    ]);

		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream("archivo".'.pdf');
		return $pdf->download($nombreArchivo.'.pdf');
  }

}
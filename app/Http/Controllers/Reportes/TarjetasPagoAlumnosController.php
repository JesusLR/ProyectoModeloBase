<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Models\Ubicacion;
use App\Http\Models\Beca;
use App\Http\Models\Pago;
use App\Http\Models\Cuota;
use App\Http\Models\Curso;
use App\Http\Helpers\Utils;
use App\Http\Helpers\GenerarReferencia;

use DB;
use PDF;
use Ficha;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;


class TarjetasPagoAlumnosController extends Controller
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

    return View('reportes/tarjetas_pago_alumnos.create', [
      "becas" => Beca::all(),
      "ubicaciones" => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function obtenerCursos($request)
  {
    $cursos = Curso::with('cgt.plan.programa', 'periodo.departamento.ubicacion', 'alumno.persona')
      ->whereHas('cgt.plan.programa', function($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
        if ($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);
        }
        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', '=', $request->cgtGrupo);
        }
      })
      ->where(static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        $query->where('curEstado', '<>', 'B');
        $query->where('curEstado', 'R');
        if($request->bcaClave){
          $query->where('curTipoBeca', $request->bcaClave);
        }
      })->get();

    //nuevo campo para ordenar por apellido1, apellido2, nombre
    $cursos = ($cursos)->map(function ($obj) {
      $obj->nombresGradoGrupo = str_slug(
        $obj->cgt->cgtGradoSemestre
        . '-' . $obj->cgt->cgtGrupo
        . '-' . $obj->alumno->persona->perApellido1
        . '-' . $obj->alumno->persona->perApellido2
        . '-' . $obj->alumno->persona->perNombre, '-');

      return $obj;
    })->sortBy("nombresGradoGrupo");

    return $cursos;
  }


  public function imprimir(Request $request)
  {
    $cursos = $this->obtenerCursos($request);


    if(count($cursos) == 0) {
      alert()->error('Error', "No existen datos de alumnos con la información proporcionada.");
      return back()->withInput();
    }

    $cursoIds = $cursos->map(function ($item, $key) {
      return $item->id;
    });

    return $this->tarjetaPagoAlumno($cursoIds);
  }

  
	public function tarjetaPagoAlumno($cursos)
	{
    $pagos = collect([]);
    foreach ($cursos as $curso_id) {
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


      // SACAR VENCIMIENTOS /REFERENCIAS DE INSCRIPCION
      $fechaInscripcion1 = "15/Ene/$perAnioPagoInscripcion";
      $fechaInscripcion2 = "31/Ene/$perAnioPagoInscripcion";
      $fechaInscripcion3 = "20/Feb/$perAnioPagoInscripcion";
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


      $pagos->push([
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
          "importeInscripcion" => ceil((double) $importeInscripcion),
          "fechaInscripcion1" => $fechaInscripcion1,
          "referenciaInscripcion1" => $referenciaInscripcion1,
          
          "fechaInscripcion2" => $fechaInscripcion2,
          "referenciaInscripcion2" => $referenciaInscripcion2,
  
          "fechaInscripcion3" => $fechaInscripcion3,
          "referenciaInscripcion3" => $referenciaInscripcion3,
        ],
        "curPlanPago" => $curPlanPago,
        "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
        "horaActual" => $horaActual
      ]);
    }



    


      // dd(number_format (20000.20, 2 , "." , "," ));

    

		// dd($fechaActualFormatoTarjeta);

		// Unix
		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');

		$pdf = PDF::loadView("reportes.pdf.tarjetas_pago.tarjeta_pago_todo", [
      "pagos" => $pagos
    ]);


		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream($nombreArchivo.'.pdf');
		return $pdf->download($nombreArchivo.'.pdf');
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
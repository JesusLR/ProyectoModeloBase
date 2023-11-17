<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Departamento;
use App\Http\Models\Curso;
use App\Http\Models\Pago;
use App\Http\Helpers\Utils;
use App\clases\departamentos\MetodosDepartamentos;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ResumenProntoPagoController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	return view('reportes/resumen_pronto_pago.create', [
    		'fechaActual' => Carbon::now('America/Merida'),
    		'departamentos' => MetodosDepartamentos::nivelesAcademicos(),
    	]);
    }

    public function imprimir(Request $request) {

    	$swal_title = 'Sin coincidencias';
    	$swal_txt = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';

    	$cursos = self::buscarCursos($request);
    	if($cursos->isEmpty()) {
    		alert($swal_title, $swal_txt, 'warning')->showConfirmButton();
    		return back()->withInput();
    	}

    	$pagos = self::buscarPagos($request, $cursos->pluck('alumno.aluClave'));
    	if($pagos->isEmpty()) {
    		alert($swal_title, $swal_txt, 'warning')->showConfirmButton();
    		return back()->withInput();
    	}

    	$pagos = $pagos->map(static function($pago) {
    		$pago->tipoDePago = self::obtenerTipoDePago($pago);
    		return $pago;
    	});

    	$info = $cursos->first();
    	$cursos = $cursos->whereIn('alumno.aluClave', $pagos->pluck('pagClaveAlu'));
    	$datos = self::mapear_info_por_campus($cursos, $pagos)->sortBy('ubiClave');

    	$fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_resumen_pronto_pago";
        return PDF::loadView("reportes/pdf.{$nombreArchivo}",[
	        "datos" => $datos,
	        "nivelAcademico" => MetodosDepartamentos::describirNivel($info->periodo->departamento),
	        "cursoEscolar" => $info->periodo->perAnio.'-'.($info->periodo->perAnio + 1),
	        "gran_total_alumnos" => $datos->sum('total_alumnos'),
	        "gran_total_pronto_pago" => $datos->sum('total_pronto_pago'),
	        "gran_total_normales" => $datos->sum('total_normales'),
	        "gran_total_recargos" => $datos->sum('total_recargos'),
	        "fechaActual" => $fechaActual->format('d/m/Y'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');
    }



    /**
    * Cursos correspondientes al año de curso proporcionado.
    * retorna el más reciente por cada alumno_id.
    *
    * @param Request
    */
    private static function buscarCursos($request): Collection
    {
    	return Curso::with(['alumno:id,aluClave', 'periodo'])
    	->whereHas('periodo.departamento', static function($query) use ($request) {
    		$query->where('perAnioPago', $request->pagAnioPer)
    			  ->where('depClave', $request->depClave);
    	})->latest('curFechaRegistro')->get()->unique('alumno_id');
    }


    /**
    * Pagos correspondientes al pagAnioPer del filtro que contengan las
    * aluClaves de los alumnos filtrados
    *
    * @param Request $request
    * @param array $aluClaves
    */
    private static function buscarPagos($request, $aluClaves): Collection
    {
    	return Pago::whereIn('pagClaveAlu', $aluClaves)->where('pagAnioPer', $request->pagAnioPer)
    	->whereIn('pagConcPago', ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'])->get();
    }


    /**
    * Define el tipo de pago, si paga:
    * - En los primeros 15 días del mes = 'Pronto Pago'.
    * - Después del 15 y antes de fin de mes = 'Normal'.
    * - El siguiente mes = 'Recargo'.
    *
    * @param App\Http\Models\Pago
    */
    private static function obtenerTipoDePago($pago) 
    {
    	$mes = (int)Utils::obtenerMesAnual($pago->pagConcPago);
    	$anio = (int)$pago->pagAnioPer;

    	$limiteProntoPago = Carbon::createFromDate($anio, $mes, 15)->format('Y-m-d');
    	$fechaRecargo = Carbon::createFromDate($anio, $mes, 1)->addMonths(1)->format('Y-m-d');

    	$tipoDePago = 'Normal';
    	if($pago->pagFechaPago <= $limiteProntoPago) {
    		$tipoDePago = 'Pronto Pago';
    	} elseif ($pago->pagFechaPago >= $fechaRecargo) {
    		$tipoDePago = 'Recargo';
    	}

    	return $tipoDePago;
    }


    /**
    * @param Collection $cursos
    * @param Collection $pagos
    */
    private static function mapear_info_por_campus($cursos, $pagos): Collection
    {
    	return $cursos->groupBy('periodo.departamento_id')->map(static function($departamento_cursos) use ($pagos) {
    		$departamento = $departamento_cursos->first()->periodo->departamento;
    		$ubicacion = $departamento->ubicacion;
    		$departamento_pagos = $pagos->whereIn('pagClaveAlu', $departamento_cursos->pluck('alumno.aluClave'));
    		$meses = self::mapear_totales_por_mes($departamento_pagos)->sortBy('mes_orden');

    		return collect([
    			'ubiClave' => $ubicacion->ubiClave,
    			'ubiNombre' => $ubicacion->ubiNombre,
    			'meses' => $meses,
    			'total_alumnos' => $meses->sum('alumnos'),
    			'total_pronto_pago' => $meses->sum('pronto_pago'),
    			'total_normales' => $meses->sum('normales'),
    			'total_recargos' => $meses->sum('recargos'),
    		]);
    	});
    }


    /**
    * Mapea los pagos, los cuenta dependiendo su tipo, y los agrupa por conceptos (meses)
    *
    * @param Collection
    */
    private static function mapear_totales_por_mes($pagos): Collection
    {
    	return $pagos->groupBy('pagConcPago')->map(static function($pagos_mes) {
    		$info = $pagos_mes->first();
    		$mes_numero = Utils::obtenerMesAnual($info->pagConcPago);

    		return collect([
    			'mes_orden' => (int)$info->pagConcPago,
    			'mes_nombre' => strtoupper(Utils::num_meses_string((int)$mes_numero)),
    			'pagConcPago' => $info->pagConcPago,
    			'alumnos' => $pagos_mes->unique('pagClaveAlu')->count(),
    			'pronto_pago' => $pagos_mes->where('tipoDePago', 'Pronto Pago')->count(),
    			'normales' => $pagos_mes->where('tipoDePago', 'Normal')->count(),
    			'recargos' => $pagos_mes->where('tipoDePago', 'Recargo')->count(),
    		]);
    	});
    }

}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Baja;
use App\Http\Models\Pago;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Http\Helpers\Utils;

class RelacionBajasPeriodoController extends Controller
{
    //REPORTE RELACIÓN DE BAJAS POR PERIODO.

    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$ubicaciones = Ubicacion::all();
    	return view('reportes/relacion_bajas_periodo.create', compact('ubicaciones'));
    }//reporte.

    public function imprimir(Request $request) {

    	$fechaActual = Carbon::now('America/Merida');

    	$bajas = Baja::with('curso.periodo', 'curso.alumno.persona', 'curso.cgt.plan.programa.escuela.departamento.ubicacion')
    	->whereHas('curso.cgt.plan.programa.escuela.departamento.ubicacion', static function($query) use ($request) {
    		if($request->departamento_id) {
    			$query->where('departamento_id', $request->departamento_id);
    		}
    		if($request->escuela_id) {
    			$query->where('escuela_id', $request->escuela_id);
    		}
    		if($request->programa_id) {
    			$query->where('programa_id', $request->programa_id);
    		}
    	})
    	->whereHas('curso.periodo', static function($query) use ($request) {
    		if($request->periodo_id) {
    			$query->where('periodo_id', $request->periodo_id);
    		}
    	})
    	->whereHas('curso.alumno.persona', static function($query) use ($request) {
    		if($request->aluClave) {
    			$query->where('aluClave', $request->aluClave);
    		}
    		if($request->aluMatricula) {
    			$query->where('aluMatricula', $request->aluMatricula);
    		}
    		if($request->perApellido1) {
    			$query->where('perApellido1', $request->perApellido1);
    		}
    		if($request->perApellido2) {
    			$query->where('perApellido2', $request->perApellido2);
    		}
    		if($request->perNombre) {
    			$query->where('perNombre', $request->perNombre);
    		}
    	})
    	->where(static function ($query) use ($request) {
    		if($request->bajFechaBaja) {
    			$query->whereDate('bajFechaBaja', '>=', $request->bajFechaBaja);
    		}
            if($request->fechaBaja2) {
                $query->whereDate('bajFechaBaja', '<=', $request->fechaBaja2);
            }
    	})->get();

    	if($bajas->isEmpty()) {
    		alert()->warning('Sin datos', 'No se encontraron registros con la información proporcionada')->showConfirmButton();
    		return back()->withInput();
    	}

    	$datos = new Collection;

    	$baja1 = $bajas->first();
    	$periodo = $baja1->curso->periodo;
    	$perAnioPago = $periodo->perAnioPago;
    	$ubicacion = $periodo->departamento->ubicacion;

    	$aluClaves = $bajas->pluck('curso.alumno.aluClave');
    	$pagosData = Pago::whereIn('pagClaveAlu', $aluClaves)
    	->where('pagAnioPer', $perAnioPago)
    	->whereIn('pagConcPago', ['00', '99'])
    	->get();

    	$bajas->each(static function ($item, $key) use ($datos, $pagosData, $ubicacion, $periodo) {
    		$curso = $item->curso;
    		$planPago = $curso->curPlanPago;
    		$programa = $curso->cgt->plan->programa;
    		$alumno = $curso->alumno;
    		$nombreCompleto = $alumno->persona->nombreCompleto(true);

    		$pagConcPago = '00';
            if ($periodo->perNumero == 3) $pagConcPago = '99';
            if ($periodo->perNumero == 1) $pagConcPago = '00';
    		if($ubicacion->ubiClave == 'CVA' || in_array($planPago, ['A', 'O', 'D'])) { 
    			$pagConcPago = '99';
    		}
    		$pagoInscripcion = $pagosData->where('pagClaveAlu', $alumno->aluClave)
    			->where('pagConcPago', $pagConcPago)
    			->first();

    		$datos->push([
    			'aluClave' => $alumno->aluClave,
    			'aluMatricula' => $alumno->aluMatricula,
    			'nombreCompleto' => $nombreCompleto,
    			'grado' => $curso->cgt->cgtGradoSemestre,
    			'grupo' => $curso->cgt->cgtGrupo,
    			'estado' => $alumno->aluEstado.' '.$curso->curEstado,
    			'pagFechaPago' => $pagoInscripcion ? Utils::fecha_string($pagoInscripcion->pagFechaPago, 'mesCorto') : '',
    			'bajFechaBaja' => Utils::fecha_string($item->bajFechaBaja, 'mesCorto'),
    			'bajRazonBaja' => $item->conceptoBaja ? $item->conceptoBaja->conbNombre : '',
                'planClave' => $curso->cgt->plan->planClave,
    			'progClave' => $programa->progClave,
    			'progNombre' => $programa->progNombre,
    			'escNombre' => $programa->escuela->escNombre,
                'escClave' => $programa->escuela->escClave,
    			'orden' => $programa->progClave.'-'.$nombreCompleto.'-'.$curso->cgt->cgtGrupo
    		]);
    	});

        $infoReporte = [
            "escuelas" => $request->formato_reporte == 'PDF' ? $datos->sortBy('orden')->groupBy(['escNombre', 'progClave', 'grado'])->sortKeys() : $datos,
            'periodo' => $periodo,
            "departamento" => $periodo->departamento,
            "ubicacion" => $ubicacion,
            "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
            "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
            "fechaActual" => Utils::fecha_string($fechaActual, 'mesCorto'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => "pdf_relacion_bajas_periodo.pdf",
        ];

        if($request->formato_reporte == 'Excel') {
            return $this->generarExcel($infoReporte);
        }

        return PDF::loadView("reportes.pdf.pdf_relacion_bajas_periodo", $infoReporte)->stream($infoReporte['nombreArchivo']);
    }//imprimir


    /**
     * @param array $info_reporte
     */
    public function generarExcel($info_reporte) {

        $periodo = $info_reporte['periodo'];
        $periodo_descripcion = $info_reporte['perFechaInicial'] . ' - ' . $info_reporte['perFechaFinal'] . "({$periodo->perNumero}/{$periodo->perAnio})";
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->mergeCells("A1:L1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$periodo_descripcion}");
        $sheet->getStyle("A2:L2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(4, 2, "Cve. Pago");
        $sheet->setCellValueByColumnAndRow(5, 2, "Matrícula");
        $sheet->setCellValueByColumnAndRow(6, 2, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(7, 2, "Gra.");
        $sheet->setCellValueByColumnAndRow(8, 2, "Gpo.");
        $sheet->setCellValueByColumnAndRow(9, 2, "Edo.");
        $sheet->setCellValueByColumnAndRow(10, 2, "Pago Inscr.");
        $sheet->setCellValueByColumnAndRow(11, 2, "Fecha baja");
        $sheet->setCellValueByColumnAndRow(12, 2, "Razón de la baja");

        $fila = 3;
        foreach($info_reporte['escuelas']->sortBy('orden') as $baja) {
            $sheet->setCellValue("A{$fila}", $baja['escClave']);
            $sheet->setCellValue("B{$fila}", $baja['progClave']);
            $sheet->setCellValueExplicit("C{$fila}", $baja['planClave'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $baja['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E{$fila}", $baja['aluMatricula'], DataType::TYPE_STRING);
            $sheet->setCellValue("F{$fila}", $baja['nombreCompleto']);
            $sheet->setCellValue("G{$fila}", $baja['grado']);
            $sheet->setCellValue("H{$fila}", $baja['grupo']);
            $sheet->setCellValue("I{$fila}", $baja['estado']);
            $sheet->setCellValue("J{$fila}", $baja['pagFechaPago']);
            $sheet->setCellValue("K{$fila}", $baja['bajFechaBaja']);
            $sheet->setCellValue("L{$fila}", $baja['bajRazonBaja']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("RelacionBajasPorPeriodo.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("RelacionBajasPorPeriodo.xlsx"));
    }

}//Controller class.
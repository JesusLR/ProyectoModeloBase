<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;
use App\Http\Models\Plan;
use App\Http\Models\Beca;
use App\Http\Helpers\UltimaFechaPago;

use Carbon\Carbon;

use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class BecasConObservacionesController extends Controller
{
    public function __construct() 
    {
    	$this->middleware(['auth', 'permisos:becas_con_observaciones']);
    }

    public function reporte()
    {
    	return view('reportes/becas_con_observaciones.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'becas' => Beca::get(),
    	]);
    }

   	public function imprimir(Request $request)
   	{
   		# parámetros obligatorios en la vista.
   		$periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
   		$departamento = $periodo->departamento;
   		$ubicacion = $departamento->ubicacion;
   		# Opcionales...
   		$escClave = $request->escuela_id ? Escuela::findOrFail($request->escuela_id)->escClave : NULL;
   		$progClave = $request->programa_id ? Programa::findOrFail($request->programa_id)->progClave : NULL;
   		$planClave = $request->plan_id ? Plan::findOrFail($request->plan_id)->planClave : NULL;

   		$becas = DB::select("call procBecasConObservaciones(
   			'{$ubicacion->ubiClave}',
   			'{$departamento->depClave}',
   			{$periodo->perNumero},
   			{$periodo->perAnio},
   			'{$escClave}',
   			'{$progClave}',
   			'{$planClave}',
   			".($request->semestre ?: 'NULL').",
   			'{$request->curEstado}',
   			'{$request->bcaClave}',
   			'{$request->bcaVigencia}'
   		)");

   		if(empty($becas)) {
    		alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	return $this->generarExcel($becas);
   	}

    public function generarExcel($becas)
    {
    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
		$sheet->getStyle('A2:W2')->getFont()->setBold(true);
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
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->getColumnDimension('R')->setAutoSize(true);
		$sheet->getColumnDimension('S')->setAutoSize(true);
		$sheet->getColumnDimension('T')->setAutoSize(true);
		$sheet->getColumnDimension('U')->setAutoSize(true);
		$sheet->getColumnDimension('V')->setAutoSize(true);
		$sheet->getColumnDimension('W')->setAutoSize(true);
		$sheet->setCellValueByColumnAndRow(1, 2, "Ubicacion");
		$sheet->setCellValueByColumnAndRow(2, 2, "Departamento");
		$sheet->setCellValueByColumnAndRow(3, 2, "Escuela");
		$sheet->setCellValueByColumnAndRow(4, 2, "Programa");
		$sheet->setCellValueByColumnAndRow(5, 2, "Semestre");
		$sheet->setCellValueByColumnAndRow(6, 2, "Clave de pago");
		$sheet->setCellValueByColumnAndRow(7, 2, "Nombre del Alumno");
		$sheet->setCellValueByColumnAndRow(8, 2, "Sexo");
		$sheet->setCellValueByColumnAndRow(9, 2, "Fecha Nac.");
		$sheet->setCellValueByColumnAndRow(10, 2, "Edad");
		$sheet->setCellValueByColumnAndRow(11, 2, "Edo. Curso");
		$sheet->setCellValueByColumnAndRow(12, 2, "Plan pago");
		$sheet->setCellValueByColumnAndRow(13, 2, "Cuota Gen");
		$sheet->setCellValueByColumnAndRow(14, 2, "Correo");
		$sheet->setCellValueByColumnAndRow(15, 2, "Beca");
		$sheet->setCellValueByColumnAndRow(16, 2, "Porcentaje");
		$sheet->setCellValueByColumnAndRow(17, 2, "Observaciones");
		$sheet->setCellValueByColumnAndRow(18, 2, "Fecha pago Agosto");
		$sheet->setCellValueByColumnAndRow(19, 2, "Importe Agosto");
		$sheet->setCellValueByColumnAndRow(20, 2, "Fecha pago Enero");
		$sheet->setCellValueByColumnAndRow(21, 2, "Importe Enero");
		$sheet->setCellValueByColumnAndRow(22, 2, "Pagos hasta: ");
		$sheet->setCellValueByColumnAndRow(23, 2, UltimaFechaPago::ultimoPago());

		$fila = 3;
    	foreach($becas as $becado) {
			$sheet->setCellValue("A{$fila}", $becado->ubiClave);
			$sheet->setCellValue("B{$fila}", $becado->depClave);
			$sheet->setCellValue("C{$fila}", $becado->escClave);
			$sheet->setCellValue("D{$fila}", $becado->progClave);
			$sheet->setCellValue("E{$fila}", $becado->cgtGradoSemestre);
			$sheet->setCellValueExplicit("F{$fila}", $becado->aluClave, DataType::TYPE_STRING);
			$sheet->setCellValue("G{$fila}", $becado->nombre_completo);
			$sheet->setCellValue("H{$fila}", $becado->perSexo);
			$sheet->setCellValue("I{$fila}", Carbon::parse($becado->perFechaNac)->format('d/m/Y'));
			$sheet->setCellValue("J{$fila}", $becado->perEdad);
			$sheet->setCellValue("K{$fila}", $becado->curEstado);
			$sheet->setCellValue("L{$fila}", $becado->curPlanPago);
			$sheet->setCellValue("M{$fila}", $becado->curAnioCuotas);
			$sheet->setCellValue("N{$fila}", $becado->perCorreo1);
			$sheet->setCellValue("O{$fila}", $becado->curTipoBeca);
			$sheet->setCellValue("P{$fila}", $becado->curPorcentajeBeca);
			$sheet->setCellValue("Q{$fila}", $becado->curObservacionesBeca);
			$sheet->setCellValue("R{$fila}", $becado->fechaPagoAgosto);
			$sheet->setCellValue("S{$fila}", $becado->importePagoAgosto);
			$sheet->setCellValue("T{$fila}", $becado->fechaPagoEnero);
			$sheet->setCellValue("U{$fila}", $becado->importePagoEnero);
			$fila++;
    	}


    	$writer = new Xlsx($spreadsheet);
    	try {
    	    $writer->save(storage_path("BecasConObservaciones.xlsx"));
    	} catch (Exception $e) {
    	    alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
    	    return back()->withInput();
    	}

    	return response()->download(storage_path("BecasConObservaciones.xlsx"));
    }
}

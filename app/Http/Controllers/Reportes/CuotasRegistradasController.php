<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;

use Exception;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class CuotasRegistradasController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:cuotas_registradas']);
    }

    public function reporte()
    {
    	return view('reportes/cuotas_registradas.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'hoy' => Carbon::now('America/Merida')
    	]);
    }

    public function imprimir(Request $request)
    {
    	$progClave = $request->programa_id ? Programa::findOrFail($request->programa_id)->progClave : '';
    	$escClave = $request->escuela_id ? Escuela::findOrFail($request->escuela_id)->escClave : '';
    	$depClave = $request->departamento_id ? Departamento::findOrFail($request->departamento_id)->depClave : '';
    	$ubiClave = $request->ubicacion_id ? Ubicacion::findOrFail($request->ubicacion_id)->ubiClave : '';
    	$cuoAnio = $request->cuoAnio ? intval($request->cuoAnio) : 'NULL';

    	$cuotas = DB::select("call procCuotasRegistradasExcel(
    		'{$ubiClave}', 
    		'{$depClave}', 
    		'{$escClave}', 
    		'{$progClave}',
    		{$cuoAnio},
    		'{$request->cuoTipo}'
    	)");

    	if(empty($cuotas)) {
    		alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	return $this->generarExcel($cuotas);
    }

    public function generarExcel($cuotas)
    {
    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
		$sheet->getStyle('A2:U2')->getFont()->setBold(true);
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
		$sheet->setCellValueByColumnAndRow(1, 2, "Año");
		$sheet->setCellValueByColumnAndRow(2, 2, "Ubicación");
		$sheet->setCellValueByColumnAndRow(3, 2, "Departamentos");
		$sheet->setCellValueByColumnAndRow(4, 2, "Escuela");
		$sheet->setCellValueByColumnAndRow(5, 2, "Programa");
		$sheet->setCellValueByColumnAndRow(6, 2, "Tipo");
		$sheet->setCellValueByColumnAndRow(7, 2, "Días pronto pago");
		$sheet->setCellValueByColumnAndRow(8, 2, "Importe inscripción 1");
		$sheet->setCellValueByColumnAndRow(9, 2, "Límite inscripción 1");
		$sheet->setCellValueByColumnAndRow(10, 2, "Importe inscripción 2");
		$sheet->setCellValueByColumnAndRow(11, 2, "Límite inscripción 2");
		$sheet->setCellValueByColumnAndRow(12, 2, "Importe inscripción 3");
		$sheet->setCellValueByColumnAndRow(13, 2, "Límite inscripcion 3");
		$sheet->setCellValueByColumnAndRow(14, 2, "Importe mensualidad 10");
		$sheet->setCellValueByColumnAndRow(15, 2, "Importe mensualidad 11");
		$sheet->setCellValueByColumnAndRow(16, 2, "Importe mensualidad 12");
		$sheet->setCellValueByColumnAndRow(17, 2, "Importe ordinario UADY");
		$sheet->setCellValueByColumnAndRow(18, 2, "Importe padres familia");
		$sheet->setCellValueByColumnAndRow(19, 2, "Importe pronto pago");
		$sheet->setCellValueByColumnAndRow(20, 2, "Importe vencimiento");
		$sheet->setCellValueByColumnAndRow(21, 2, "Número de cuentas");

		$fila = 3;
    	foreach($cuotas as $cuota) {
			$sheet->setCellValue("A{$fila}", $cuota->cuoAnio);
			$sheet->setCellValue("B{$fila}", $cuota->ubiClave);
			$sheet->setCellValue("C{$fila}", $cuota->depClave);
			$sheet->setCellValue("D{$fila}", $cuota->escClave);
			$sheet->setCellValue("E{$fila}", $cuota->progClave);
			$sheet->setCellValue("F{$fila}", $cuota->cuoTipo);
			$sheet->setCellValue("G{$fila}", $cuota->cuoDiasProntoPago);
			$sheet->setCellValue("H{$fila}", $cuota->cuoImporteInscripcion1);
			$sheet->setCellValue("I{$fila}", $cuota->cuoFechaLimiteInscripcion1);
			$sheet->setCellValue("J{$fila}", $cuota->cuoImporteInscripcion2);
			$sheet->setCellValue("K{$fila}", $cuota->cuoFechaLimiteInscripcion2);
			$sheet->setCellValue("L{$fila}", $cuota->cuoImporteInscripcion3);
			$sheet->setCellValue("M{$fila}", $cuota->cuoFechaLimiteInscripcion3);
			$sheet->setCellValue("N{$fila}", $cuota->cuoImporteMensualidad10);
			$sheet->setCellValue("O{$fila}", $cuota->cuoImporteMensualidad11);
			$sheet->setCellValue("P{$fila}", $cuota->cuoImporteMensualidad12);
			$sheet->setCellValue("Q{$fila}", $cuota->cuoImporteOrdinarioUady);
			$sheet->setCellValue("R{$fila}", $cuota->cuoImportePadresFamilia);
			$sheet->setCellValue("S{$fila}", $cuota->cuoImporteProntoPago);
			$sheet->setCellValue("T{$fila}", $cuota->cuoImporteVencimiento);
			$sheet->setCellValueExplicit("U{$fila}", $cuota->cuoNumeroCuenta, DataType::TYPE_STRING);
			$fila++;
    	}


    	$writer = new Xlsx($spreadsheet);
    	try {
    	    $writer->save(storage_path("CuotasRegistradas.xlsx"));
    	} catch (Exception $e) {
    	    alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
    	    return back()->withInput();
    	}

    	return response()->download(storage_path("CuotasRegistradas.xlsx"));
    }
}

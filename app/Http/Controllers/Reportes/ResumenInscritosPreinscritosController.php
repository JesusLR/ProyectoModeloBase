<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Helpers\UltimaFechaPago;

use DB;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class ResumenInscritosPreinscritosController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:resumen_inscritos_preinscritos']);
    }

    public function reporte()
    {
    	return view('reportes/resumen_inscritos_preinscritos.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	$periodo = Periodo::findOrFail($request->periodo_id);
    	$departamento = $periodo->departamento;
    	$ubicacion = $departamento->ubicacion;
    	$registros = collect(DB::select("call procResumenPrimeros(
    		{$periodo->perNumero}, {$periodo->perAnio}, '{$ubicacion->ubiClave}', '{$departamento->depClave}')"
    	));

    	if($registros->isEmpty()) {
    		alert('Sin coincidencias', 'No se encontraron datos con la información proporcionada. Favor de verificar')->showConfirmButton();
    		return back()->withInput();
    	}

    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', "Suma de total");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2:I2')->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Preinscrito");
        $sheet->setCellValueByColumnAndRow(4, 2, "Exani");
        $sheet->setCellValueByColumnAndRow(5, 2, "Pago Insc.");
        $sheet->setCellValueByColumnAndRow(6, 2, "Regular");
        $sheet->setCellValueByColumnAndRow(7, 2, "Total general");
        $sheet->setCellValueByColumnAndRow(8, 2, "Pagos hasta:");
        $sheet->setCellValueByColumnAndRow(9, 2, UltimaFechaPago::ultimoPago());

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        $fila = 3;
        foreach ($registros as $key => $registro) {
            if($registro->bold == "1") {
                $sheet->getStyle("A{$fila}:I{$fila}")->getFont()->setBold(true);
            }
            $sheet->setCellValue("A{$fila}", $registro->escClave);
            $sheet->setCellValue("B{$fila}", $registro->progClave);
            $sheet->setCellValue("C{$fila}", $registro->edoP);
            $sheet->setCellValue("D{$fila}", $registro->edoX);
            $sheet->setCellValue("E{$fila}", $registro->edoI);
            $sheet->setCellValue("F{$fila}", $registro->edoR);
            $sheet->setCellValue("G{$fila}", $registro->total);
            $fila++;
        }

    	$writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ResumenInscritosPreinscritos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ResumenInscritosPreinscritos.xlsx"));
    }
}

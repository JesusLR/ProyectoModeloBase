<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Alumno;
use App\Http\Models\Pago;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\Utils;

class HistorialPagosAlumnoController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	return view('reportes/historial_pagos_alumno.create');
    }

    /**
    * Los parámetros importantes que debe contener el Request.
    * $request->alumno_id.
    * $request->formatoImpresion. ( PDF || EXCEL )
    */
    public function imprimir(Request $request) {

    	$alumno = Alumno::with('persona')->where('aluClave', $request->aluClave)->first();
    	if(!$alumno) {
    		alert()->warning('Clave no válida', 'No existe la clave de alumno '.$request->aluClave.'. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}


        $pagos = $this->obtenerPagosDeAlumno($alumno);
        if($pagos->isEmpty()) {
            alert()->warning('Sin pagos', 'No se encontraron pagos de este alumno. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }
        if ($request->formatoImpresion == 'EXCEL') {
            return $this->generarExcel($pagos, $alumno);
        }
    	return $this->imprimirPDF($pagos, $alumno);
    }



    public function obtenerPagosDeAlumno($alumno) {
        //
        return Pago::with('concepto')
        ->where('pagClaveAlu', $alumno->aluClave)->where('pagEstado', 'A')
        ->whereIn('pagConcPago', ["99", "01", "02", "03", "04", "05", "00", "06", "07", "08", "09", "10", "11", "12", "78", "86"])->get()
        ->sortByDesc(static function($pago, $key) {
            return $pago->pagAnioPer.' '.$pago->concepto->ordenReportes;
        });
    }



    public function imprimirPDF($pagos, $alumno) {

        $fechaActual = Carbon::now('CDT');
        //
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $nombreArchivo = 'pdf_historial_pagos_alumno';
        $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
          "alumno" => $alumno,
          "pagos" => $pagos,
          "fechaActual" => $fechaActual->format('d/m/Y'),
          "horaActual" => $fechaActual->format('H:i:s'),
          "nombreArchivo" => $nombreArchivo,
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Sans Serif';
        return $pdf->stream($nombreArchivo.'.pdf');
        return $pdf->download($nombreArchivo.'.pdf');
    }

    public function generarExcel($pagos, $alumno)
    { 
        $fechaActual = Carbon::now('CDT');
        //
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        #Título.
        $sheet->mergeCells("A1:D1");
        #Encabezado columna 1.
        $sheet->mergeCells("A2:D2");
        $sheet->mergeCells("A3:D3");
        $sheet->mergeCells("A4:D4");
        $sheet->mergeCells("A5:D5");
        #Encabezado columna 2.
        $sheet->mergeCells("E1:G1");
        $sheet->mergeCells("E2:G2");
        $sheet->mergeCells("E3:G3");
    
        # Contenido título.
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "UNIVERSIDAD MODELO, S.C.P.");
        # Contenido encabezado columna 1.
        $sheet->setCellValue('A2', "Historial de Pagos de Alumno");
        $sheet->setCellValue('A3', "Clave de Pago: ".$alumno->aluClave);
        $sheet->setCellValue('A4', "Nombre: ".MetodosPersonas::nombreCompleto($alumno->persona));
        # Contenido encabezado columna 2.
        $sheet->setCellValue('E1', $fechaActual->format('d/m/Y'));
        $sheet->setCellValue('E2', $fechaActual->format('H:i:s'));
        $sheet->setCellValue('E3', "excel_historial_pagos_alumno.xlsx");
        # Tabla principal de historial.
        $sheet->getStyle("A6:F6")->getFont()->setBold(true);
        # cabecera
        $sheet->setCellValueByColumnAndRow(1, 6, "Periodo");
        $sheet->setCellValueByColumnAndRow(2, 6, "Concepto de pago");
        $sheet->setCellValueByColumnAndRow(3, 6, "Importe");
        $sheet->setCellValueByColumnAndRow(4, 6, "Referencia");
        $sheet->setCellValueByColumnAndRow(5, 6, "Fecha");
        $sheet->setCellValueByColumnAndRow(6, 6, "Comentario");
    
        $fila = 7;
        foreach($pagos as $pago) {
            // Periodo
            $sheet->setCellValue("A{$fila}", $pago->pagAnioPer);
            $sheet->getStyle('A'.$fila)->getAlignment()->setHorizontal('left');
            // Concepto de pago
            $sheet->setCellValue("B{$fila}", $pago->pagConcPago." ".$pago->concepto->conpNombre);
            // Importe
            $sheet->setCellValue("C{$fila}", '$'.number_format($pago->pagImpPago, 2, '.', ''));
            $sheet->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');
            // Referencia
            $sheet->setCellValue("D{$fila}", $pago->pagRefPago);
            $sheet->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');
            // Fecha
            $sheet->setCellValue("E{$fila}", Utils::fecha_string($pago->pagFechaPago,'mesCorto'));
            // Comentario
            $sheet->setCellValue("F{$fila}", $pago->pagComentario);
            $fila++;
        }
    
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("excel_historial_pagos_alumno.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
    
        return response()->download(storage_path("excel_historial_pagos_alumno.xlsx"));
    }

}

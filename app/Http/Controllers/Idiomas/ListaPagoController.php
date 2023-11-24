<?php

namespace App\Http\Controllers\Idiomas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Models\Periodo;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Programa;
use App\Models\Plan;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\UltimaFechaPago;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ListaPagoController extends Controller
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
        $ubicaciones = Ubicacion::sedes()->get();
        return View('idiomas.listas_pagos.create',compact('ubicaciones'));
    }

    public function imprimir(Request $request)
    {
        if(!Auth::check()) {
            return redirect('login');
        }

        $periodo = Periodo::where('id', $request->periodo_id)->first();
        $ubicacion = Ubicacion::where('id', $request->ubicacion_id)->first();
        $departamento = Departamento::where('id', $request->departamento_id)->first();

        $escClave = '';
        if ( $request->escuela_id ) {
            $escuela = Escuela::where('id', $request->escuela_id)->first();
            $escClave = $escuela->escClave;
        }
        $progClave = '';
        if ( $request->programa_id ) {
            $programa = Programa::where('id', $request->programa_id)->first();
            $progClave = $programa->progClave;
        }
        $planClave = '';
        if ( $request->plan_id ) {
            $plan = Plan::where('id', $request->plan_id)->first();
            $planClave = $plan->planClave;
        }

        $gpoSemestre = $request->gpoSemestre ? $request->gpoSemestre : '';
        $gpoClave = $request->gpoClave ? $request->gpoClave : '';
        $aluClave = $request->aluClave ? $request->aluClave : '';

        $result =  DB::select("call procListasPagosMesIdiomas("
            .$periodo->perNumero.","
            .$periodo->perAnio.",'"
            .$ubicacion->ubiClave."','"
            .$departamento->depClave."','"
            .$escClave."','"
            .$progClave."','"
            .$planClave."','"
            .$gpoSemestre."','"
            .$gpoClave."','"
            .$aluClave."','','','')");

        return $this->generarExcel($result, $periodo, $ubicacion, $departamento);

    }# imprimir

    /**
     * @param Collection
    */
    public function generarExcel($result, $periodo, $ubicacion, $departamento)
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
        $sheet->mergeCells("A1:B1");
    
        # Contenido título.
        $sheet->setCellValue('A1', "Pagos $ubicacion->ubiClave $departamento->depClave $periodo->perNumero $periodo->perAnio");
        $sheet->setCellValue('C1', "Pagos hasta:");

        $sheet->setCellValue('D1', UltimaFechaPago::ultimoPago());
        # Tabla principal de historial.
        // $sheet->getStyle("A6:F6")->getFont()->setBold(true);
        # cabecera
        $sheet->setCellValueByColumnAndRow(1, 2, "Esc");
        $sheet->setCellValueByColumnAndRow(2, 2, "Prog");
        $sheet->setCellValueByColumnAndRow(3, 2, "Grado");
        $sheet->setCellValueByColumnAndRow(4, 2, "Grupo");
        $sheet->setCellValueByColumnAndRow(5, 2, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(6, 2, "Apellido 1");
        $sheet->setCellValueByColumnAndRow(7, 2, "Apellido 2");
        $sheet->setCellValueByColumnAndRow(8, 2, "Nombre");
        $sheet->setCellValueByColumnAndRow(9, 2, "Edo");
        $sheet->setCellValueByColumnAndRow(10, 2, "Insc Ago");
        $sheet->setCellValueByColumnAndRow(11, 2, "Fecha Insc");
        $sheet->setCellValueByColumnAndRow(12, 2, "Septiembre");
        $sheet->setCellValueByColumnAndRow(13, 2, "Fecha Sep");
        $sheet->setCellValueByColumnAndRow(14, 2, "Octubre");
        $sheet->setCellValueByColumnAndRow(15, 2, "Fecha Oct");
        $sheet->setCellValueByColumnAndRow(16, 2, "Noviembre");
        $sheet->setCellValueByColumnAndRow(17, 2, "Fecha Nov");
        $sheet->setCellValueByColumnAndRow(18, 2, "Diciembre");
        $sheet->setCellValueByColumnAndRow(19, 2, "Fecha Dic");
        $sheet->setCellValueByColumnAndRow(20, 2, "Enero");
        $sheet->setCellValueByColumnAndRow(21, 2, "Fecha Ene");
        $sheet->setCellValueByColumnAndRow(22, 2, "Insc Ene");
        $sheet->setCellValueByColumnAndRow(23, 2, "Fecha Insc");
        $sheet->setCellValueByColumnAndRow(24, 2, "Febrero");
        $sheet->setCellValueByColumnAndRow(25, 2, "Fecha Feb");
        $sheet->setCellValueByColumnAndRow(26, 2, "Marzo");
        $sheet->setCellValueByColumnAndRow(27, 2, "Fecha Mar");
        $sheet->setCellValueByColumnAndRow(28, 2, "Abril");
        $sheet->setCellValueByColumnAndRow(29, 2, "Fecha Abr");
        $sheet->setCellValueByColumnAndRow(30, 2, "Mayo");
        $sheet->setCellValueByColumnAndRow(31, 2, "Fecha May");
        $sheet->setCellValueByColumnAndRow(32, 2, "Junio");
        $sheet->setCellValueByColumnAndRow(33, 2, "Fecha Jun");
    
        $fila = 3;
        foreach($result as $value) {
            $sheet->setCellValue("A{$fila}", $value->escClave);
            $sheet->getStyle('A'.$fila)->getAlignment()->setHorizontal('left');
            $sheet->setCellValue("B{$fila}", $value->progClave);
            // $sheet->setCellValue("C{$fila}", '$'.number_format($value->cgtGradoSemestre, 2, '.', ''));
            $sheet->setCellValue("C{$fila}", $value->cgtGradoSemestre);
            $sheet->setCellValue("D{$fila}", $value->cgtGrupo);
            // $sheet->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');
            $sheet->setCellValue("E{$fila}", $value->aluClave);
            $sheet->setCellValue("F{$fila}", $value->perApellido1);
            $sheet->setCellValue("G{$fila}", $value->perApellido2);
            $sheet->setCellValue("H{$fila}", $value->perNombre);
            $sheet->setCellValue("I{$fila}", $value->curEstado);
            $sheet->setCellValue("J{$fila}", $value->Importe49);
            $sheet->setCellValue("K{$fila}", $value->fecha49);
            $sheet->setCellValue("L{$fila}", $value->Importe51);
            $sheet->setCellValue("M{$fila}", $value->fecha51);
            $sheet->setCellValue("N{$fila}", $value->Importe52);
            $sheet->setCellValue("O{$fila}", $value->fecha52);
            $sheet->setCellValue("P{$fila}", $value->Importe53);
            $sheet->setCellValue("Q{$fila}", $value->fecha53);
            $sheet->setCellValue("R{$fila}", $value->Importe54);
            $sheet->setCellValue("S{$fila}", $value->fecha54);
            $sheet->setCellValue("T{$fila}", $value->Importe55);
            $sheet->setCellValue("U{$fila}", $value->fecha55);
            $sheet->setCellValue("V{$fila}", $value->Importe50);
            $sheet->setCellValue("W{$fila}", $value->fecha50);
            $sheet->setCellValue("X{$fila}", $value->Importe56);
            $sheet->setCellValue("Y{$fila}", $value->fecha56);
            $sheet->setCellValue("Z{$fila}", $value->Importe57);
            $sheet->setCellValue("AA{$fila}", $value->fecha57);
            $sheet->setCellValue("AB{$fila}", $value->Importe58);
            $sheet->setCellValue("AC{$fila}", $value->fecha58);
            $sheet->setCellValue("AD{$fila}", $value->Importe59);
            $sheet->setCellValue("AE{$fila}", $value->fecha59);
            $sheet->setCellValue("AF{$fila}", $value->Importe60);
            $sheet->setCellValue("AG{$fila}", $value->fecha60);
            
            $fila++;
        }
    
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("excel_listas_pagos_idiomas.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
    
        return response()->download(storage_path("excel_listas_pagos_idiomas.xlsx"));
    }
}
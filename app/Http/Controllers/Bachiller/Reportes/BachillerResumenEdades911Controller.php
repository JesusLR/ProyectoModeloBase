<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BachillerResumenEdades911Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.conteo_edades.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $departamento = Departamento::find($request->departamento_id);
        $periodo = Periodo::find($request->periodo_id);
        $programa = Programa::find($request->programa_id);
        $plan = Plan::find($request->plan_id);

        $ciclo = Periodo::select('periodos.*', 'departamentos.depClave')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('periodos.perAnioPago', $periodo->perAnioPago)
            ->where('departamentos.depClave', 'BAC')
            ->where('ubicacion.id', $ubicacion->id)
            ->orderBy('periodos.perNumero', 'DESC')
            ->get();


        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');        // En windows
        setlocale(LC_TIME, 'spanish');

        $procBachiller911ConteoSexoEdad = DB::select("call procBachiller911ConteoSexoEdad(
            " . $periodo->perNumero . ",
            " . $periodo->perAnio . ",
            '" . $ubicacion->ubiClave . "',
            '" . $departamento->depClave . "',
            '" . $programa->progClave . "',
            " . $plan->planClave . "
        )");


        if($request->tipoReporte == "pdf"){
            $parametro_NombreArchivo = "pdf_resumen_edades";
            // view('reportes.pdf.bachiller.resumen_edades.pdf_resumen_edades');
            $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_edades.' . $parametro_NombreArchivo, [
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), $fechaActual->format('Y/m-d')),
                "conteo_edades" => $procBachiller911ConteoSexoEdad,
                "numeroPerido" => $periodo->perNumero,
                "ubicacion" => $ubicacion,
                "ciclo" => $ciclo,
                "hora" => $fechaActual->format('H:i:s')
            ]);

            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }


        if($request->tipoReporte == "excel"){

            $fechaHoy = Utils::fecha_string($fechaActual->format('Y-m-d'), $fechaActual->format('Y/m-d'));
            $conteo_edades = $procBachiller911ConteoSexoEdad;
            $ubicacion = $ubicacion->ubiClave;
            $ciclo = $ciclo[0]->perAnio.'-'.$ciclo[1]->perAnio;
            $hora = $fechaActual->format('H:i:s');

            return $this->generarExcel($fechaHoy, $conteo_edades, $ubicacion, $ciclo, $hora);
            
        }
                
    }

    public function generarExcel($fechaHoy, $conteo_edades, $ubicacion, $ciclo, $hora) {

        
    
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
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        #Título.
        $sheet->mergeCells("A1:E1");
        $sheet->mergeCells("A2:E2");
        $sheet->mergeCells("A3:E3");
        $sheet->mergeCells("A4:E4");
        $sheet->mergeCells("A5:E5");


        $sheet->mergeCells("K1:M1");
        $sheet->mergeCells("K2:M2");
        $sheet->mergeCells("K3:M3");
        #Encabezado columna 1.
        // $sheet->mergeCells("A2:E2");
        // $sheet->mergeCells("A3:E3");
        // $sheet->mergeCells("A4:E4");
        // $sheet->mergeCells("A5:E5");
        // #Encabezado columna 2.
        // $sheet->mergeCells("F2:J2");
        // $sheet->mergeCells("F3:J3");
        // $sheet->mergeCells("F4:J4");
        // $sheet->mergeCells("F5:J5");
    
        # Contenido título.
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', 'Preparatoria "ESCUELA MODELO"');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('A2', 'Resumen de alumnos por edades');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "Curso escolar: {$ciclo}");
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->setCellValue('A4', "Ubicación: {$ubicacion}");
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->setCellValue('A5', "Inscritos, Pre-inscritos, Condicionados");

        $sheet->getStyle('K1')->getFont()->setBold(true);
        $sheet->setCellValue('K1', "{$fechaHoy}");

        $sheet->getStyle('K2')->getFont()->setBold(true);
        $sheet->setCellValue('K2', "{$hora}");
        # Contenido encabezado columna 1.

        $sheet->getStyle('A7')->getFont()->setBold(true);
        $sheet->setCellValue('A7', "Primeros");

        $sheet->getStyle("A8:P8")->getFont()->setBold(true);    
        $sheet->setCellValueByColumnAndRow(1, 8, "Edades");
        $sheet->setCellValueByColumnAndRow(2, 8, "14");
        $sheet->setCellValueByColumnAndRow(3, 8, "15");
        $sheet->setCellValueByColumnAndRow(4, 8, "16");
        $sheet->setCellValueByColumnAndRow(5, 8, "17");
        $sheet->setCellValueByColumnAndRow(6, 8, "18");
        $sheet->setCellValueByColumnAndRow(7, 8, "19");
        $sheet->setCellValueByColumnAndRow(8, 8, "20");
        $sheet->setCellValueByColumnAndRow(9, 8, "21");
        $sheet->setCellValueByColumnAndRow(10, 8, "22");
        $sheet->setCellValueByColumnAndRow(11, 8, "23");
        $sheet->setCellValueByColumnAndRow(12, 8, "24");
        $sheet->setCellValueByColumnAndRow(13, 8, "25");
        $sheet->setCellValueByColumnAndRow(14, 8, "Existentes");
        $sheet->setCellValueByColumnAndRow(15, 8, "Bajas");
        $sheet->setCellValueByColumnAndRow(16, 8, "Inscritos");

        $sheet->setCellValueByColumnAndRow(1, 9, "Hombres: ");
        $sheet->setCellValueByColumnAndRow(1, 10, "Mujeres: ");
        $filaPrimeroHombres = 9;
        $filaPrimeroMujeres = 10;
        $filaPrimeroTotal = 11;
        $sumaPrimero14 = 0;
        $sumaPrimero15 = 0;
        $sumaPrimero16 = 0;
        $sumaPrimero17 = 0;
        $sumaPrimero18 = 0;
        $sumaPrimero19 = 0;
        $sumaPrimero20 = 0;
        $sumaPrimero21 = 0;
        $sumaPrimero22 = 0;
        $sumaPrimero23 = 0;
        $sumaPrimero24 = 0;
        $sumaPrimero25 = 0;


        $sumaPrimeroExistentes = 0;
        $sumaPrimeroBajas = 0;
        $sumaPrimeroInscritos = 0;


        $sheet->getStyle("B8:P8")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaPrimeroTotal}:P{$filaPrimeroTotal}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaPrimeroHombres}:P{$filaPrimeroHombres}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaPrimeroMujeres}:P{$filaPrimeroMujeres}")->getAlignment()->setHorizontal('center');


        // segundos 
        $sheet->getStyle('A13')->getFont()->setBold(true);
        $sheet->setCellValue('A13', "Segundos");

        $sheet->getStyle("A14:P14")->getFont()->setBold(true);    
        $sheet->setCellValueByColumnAndRow(1, 14, "Edades");
        $sheet->setCellValueByColumnAndRow(2, 14, "14");
        $sheet->setCellValueByColumnAndRow(3, 14, "15");
        $sheet->setCellValueByColumnAndRow(4, 14, "16");
        $sheet->setCellValueByColumnAndRow(5, 14, "17");
        $sheet->setCellValueByColumnAndRow(6, 14, "18");
        $sheet->setCellValueByColumnAndRow(7, 14, "19");
        $sheet->setCellValueByColumnAndRow(8, 14, "20");
        $sheet->setCellValueByColumnAndRow(9, 14, "21");
        $sheet->setCellValueByColumnAndRow(10, 14, "22");
        $sheet->setCellValueByColumnAndRow(11, 14, "23");
        $sheet->setCellValueByColumnAndRow(12, 14, "24");
        $sheet->setCellValueByColumnAndRow(13, 14, "25");
        $sheet->setCellValueByColumnAndRow(14, 14, "Existentes");
        $sheet->setCellValueByColumnAndRow(15, 14, "Bajas");
        $sheet->setCellValueByColumnAndRow(16, 14, "Inscritos");

        $sheet->setCellValueByColumnAndRow(1, 15, "Hombres: ");
        $sheet->setCellValueByColumnAndRow(1, 16, "Mujeres: ");

        $filaSegundoHombres = 15;
        $filaSegundoMujeres = 16;
        $filaSegundoTotal = 17;
        $sumaSegundo14 = 0;
        $sumaSegundo15 = 0;
        $sumaSegundo16 = 0;
        $sumaSegundo17 = 0;
        $sumaSegundo18 = 0;
        $sumaSegundo19 = 0;
        $sumaSegundo20 = 0;
        $sumaSegundo21 = 0;
        $sumaSegundo22 = 0;
        $sumaSegundo23 = 0;
        $sumaSegundo24 = 0;
        $sumaSegundo25 = 0;


        $sumaSegundoExistentes = 0;
        $sumaSegundoBajas = 0;
        $sumaSegundoInscritos = 0;


        $sheet->getStyle("B14:P14")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaSegundoTotal}:P{$filaSegundoTotal}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaSegundoHombres}:P{$filaSegundoHombres}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaSegundoMujeres}:P{$filaSegundoMujeres}")->getAlignment()->setHorizontal('center');


        // terceros 
        $sheet->getStyle('A19')->getFont()->setBold(true);
        $sheet->setCellValue('A19', "Terceros");

        $sheet->getStyle("A20:P20")->getFont()->setBold(true);    
        $sheet->setCellValueByColumnAndRow(1, 20, "Edades");
        $sheet->setCellValueByColumnAndRow(2, 20, "14");
        $sheet->setCellValueByColumnAndRow(3, 20, "15");
        $sheet->setCellValueByColumnAndRow(4, 20, "16");
        $sheet->setCellValueByColumnAndRow(5, 20, "17");
        $sheet->setCellValueByColumnAndRow(6, 20, "18");
        $sheet->setCellValueByColumnAndRow(7, 20, "19");
        $sheet->setCellValueByColumnAndRow(8, 20, "20");
        $sheet->setCellValueByColumnAndRow(9, 20, "21");
        $sheet->setCellValueByColumnAndRow(10, 20, "22");
        $sheet->setCellValueByColumnAndRow(11, 20, "23");
        $sheet->setCellValueByColumnAndRow(12, 20, "24");
        $sheet->setCellValueByColumnAndRow(13, 20, "25");
        $sheet->setCellValueByColumnAndRow(14, 20, "Existentes");
        $sheet->setCellValueByColumnAndRow(15, 20, "Bajas");
        $sheet->setCellValueByColumnAndRow(16, 20, "Inscritos");

        $sheet->setCellValueByColumnAndRow(1, 21, "Hombres: ");
        $sheet->setCellValueByColumnAndRow(1, 22, "Mujeres: ");

        $filaTerceroHombres = 21;
        $filaTerceroMujeres = 22;
        $filaTerceroTotal = 23;
        $sumaTercero14 = 0;
        $sumaTercero15 = 0;
        $sumaTercero16 = 0;
        $sumaTercero17 = 0;
        $sumaTercero18 = 0;
        $sumaTercero19 = 0;
        $sumaTercero20 = 0;
        $sumaTercero21 = 0;
        $sumaTercero22 = 0;
        $sumaTercero23 = 0;
        $sumaTercero24 = 0;
        $sumaTercero25 = 0;


        $sumaTerceroExistentes = 0;
        $sumaTerceroBajas = 0;
        $sumaTerceroInscritos = 0;


        $sheet->getStyle("B20:P20")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaTerceroTotal}:P{$filaTerceroTotal}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaTerceroHombres}:P{$filaTerceroHombres}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaTerceroMujeres}:P{$filaTerceroMujeres}")->getAlignment()->setHorizontal('center');


        // total 
        $sheet->setCellValueByColumnAndRow(1, 25, "Total ");
        $totalExistentes = 0;
        $totalBajas = 0;
        $totalInscritos = 0;

        // mostrar datos de primero 
        foreach($conteo_edades as $resumen) {

            // primero hombres 
            if($resumen->grado == "Primeros" && $resumen->sexo == "M"){

                

                if(isset($resumen->edad14)){
                    $sheet->setCellValue("B{$filaPrimeroHombres}", $resumen->edad14);

                    $sumaPrimero14 = $sumaPrimero14 + $resumen->edad14;
                }else{
                    $sheet->setCellValue("B{$filaPrimeroHombres}", "");
                }
               
                if(isset($resumen->edad15)){
                    $sheet->setCellValue("C{$filaPrimeroHombres}", $resumen->edad15);
                    $sumaPrimero15 = $sumaPrimero15 + $resumen->edad15;
                }else{
                    $sheet->setCellValue("C{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad16)){
                    $sheet->setCellValue("D{$filaPrimeroHombres}", $resumen->edad16);
                    $sumaPrimero16 = $sumaPrimero16 + $resumen->edad16;
                }else{
                    $sheet->setCellValue("D{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad17)){
                    $sheet->setCellValue("E{$filaPrimeroHombres}", $resumen->edad17);
                    $sumaPrimero17 = $sumaPrimero17 + $resumen->edad17;
                }else{
                    $sheet->setCellValue("E{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad18)){
                    $sheet->setCellValue("F{$filaPrimeroHombres}", $resumen->edad18);
                    $sumaPrimero18 = $sumaPrimero18 + $resumen->edad18;
                }else{
                    $sheet->setCellValue("F{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad19)){
                    $sheet->setCellValue("G{$filaPrimeroHombres}", $resumen->edad19);
                    $sumaPrimero19 = $sumaPrimero19 + $resumen->edad19;
                }else{
                    $sheet->setCellValue("G{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad20)){
                    $sheet->setCellValue("H{$filaPrimeroHombres}", $resumen->edad20);
                    $sumaPrimero20 = $sumaPrimero20 + $resumen->edad20;
                }else{
                    $sheet->setCellValue("H{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad21)){
                    $sheet->setCellValue("I{$filaPrimeroHombres}", $resumen->edad21);
                    $sumaPrimero21 = $sumaPrimero21 + $resumen->edad21;
                }else{
                    $sheet->setCellValue("I{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad22)){
                    $sheet->setCellValue("J{$filaPrimeroHombres}", $resumen->edad22);
                    $sumaPrimero22 = $sumaPrimero22 + $resumen->edad22;
                }else{
                    $sheet->setCellValue("J{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad23)){
                    $sheet->setCellValue("K{$filaPrimeroHombres}", $resumen->edad23);
                    $sumaPrimero23 = $sumaPrimero23 + $resumen->edad23;
                }else{
                    $sheet->setCellValue("K{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad24)){
                    $sheet->setCellValue("L{$filaPrimeroHombres}", $resumen->edad24);
                    $sumaPrimero24 = $sumaPrimero24 + $resumen->edad24;
                }else{
                    $sheet->setCellValue("L{$filaPrimeroHombres}", "");
                }

                if(isset($resumen->edad25)){
                    $sheet->setCellValue("M{$filaPrimeroHombres}", $resumen->edad25);
                    $sumaPrimero25 = $sumaPrimero25 + $resumen->edad25;
                }else{
                    $sheet->setCellValue("M{$filaPrimeroHombres}", "");
                }

                $sheet->setCellValue("N{$filaPrimeroHombres}", $resumen->existencia);
                $sumaPrimeroExistentes = $sumaPrimeroExistentes + $resumen->existencia;
                $totalExistentes = $totalExistentes + $resumen->existencia;

                $sheet->setCellValue("O{$filaPrimeroHombres}", $resumen->bajas);
                $sumaPrimeroBajas = $sumaPrimeroBajas + $resumen->bajas;
                $totalBajas = $totalBajas + $resumen->bajas;

                $sheet->setCellValue("P{$filaPrimeroHombres}", $resumen->inscritos);
                $sumaPrimeroInscritos = $sumaPrimeroInscritos + $resumen->inscritos;
                $totalInscritos = $totalInscritos + $resumen->inscritos;

                $filaPrimeroHombres++;            

                
            }

            // primeros mujeres 
            if($resumen->grado == "Primeros" && $resumen->sexo == "F"){

                if(isset($resumen->edad14)){
                    $sheet->setCellValue("B{$filaPrimeroMujeres}", $resumen->edad14);

                    $sumaPrimero14 = $sumaPrimero14 + $resumen->edad14;
                }else{
                    $sheet->setCellValue("B{$filaPrimeroMujeres}", "");
                }
               
                if(isset($resumen->edad15)){
                    $sheet->setCellValue("C{$filaPrimeroMujeres}", $resumen->edad15);
                    $sumaPrimero15 = $sumaPrimero15 + $resumen->edad15;
                }else{
                    $sheet->setCellValue("C{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad16)){
                    $sheet->setCellValue("D{$filaPrimeroMujeres}", $resumen->edad16);
                    $sumaPrimero16 = $sumaPrimero16 + $resumen->edad16;
                }else{
                    $sheet->setCellValue("D{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad17)){
                    $sheet->setCellValue("E{$filaPrimeroMujeres}", $resumen->edad17);
                    $sumaPrimero17 = $sumaPrimero17 + $resumen->edad17;
                }else{
                    $sheet->setCellValue("E{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad18)){
                    $sheet->setCellValue("F{$filaPrimeroMujeres}", $resumen->edad18);
                    $sumaPrimero18 = $sumaPrimero18 + $resumen->edad18;
                }else{
                    $sheet->setCellValue("F{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad19)){
                    $sheet->setCellValue("G{$filaPrimeroMujeres}", $resumen->edad19);
                    $sumaPrimero19 = $sumaPrimero19 + $resumen->edad19;
                }else{
                    $sheet->setCellValue("G{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad20)){
                    $sheet->setCellValue("H{$filaPrimeroMujeres}", $resumen->edad20);
                    $sumaPrimero20 = $sumaPrimero20 + $resumen->edad20;
                }else{
                    $sheet->setCellValue("H{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad21)){
                    $sheet->setCellValue("I{$filaPrimeroMujeres}", $resumen->edad21);
                    $sumaPrimero21 = $sumaPrimero21 + $resumen->edad21;
                }else{
                    $sheet->setCellValue("I{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad22)){
                    $sheet->setCellValue("J{$filaPrimeroMujeres}", $resumen->edad22);
                    $sumaPrimero22 = $sumaPrimero22 + $resumen->edad22;
                }else{
                    $sheet->setCellValue("J{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad23)){
                    $sheet->setCellValue("K{$filaPrimeroMujeres}", $resumen->edad23);
                    $sumaPrimero23 = $sumaPrimero23 + $resumen->edad23;
                }else{
                    $sheet->setCellValue("K{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad24)){
                    $sheet->setCellValue("L{$filaPrimeroMujeres}", $resumen->edad24);
                    $sumaPrimero24 = $sumaPrimero24 + $resumen->edad24;
                }else{
                    $sheet->setCellValue("L{$filaPrimeroMujeres}", "");
                }

                if(isset($resumen->edad25)){
                    $sheet->setCellValue("M{$filaPrimeroMujeres}", $resumen->edad25);
                    $sumaPrimero25 = $sumaPrimero25 + $resumen->edad25;
                }else{
                    $sheet->setCellValue("M{$filaPrimeroMujeres}", "");
                }

                $sheet->setCellValue("N{$filaPrimeroMujeres}", $resumen->existencia);
                $sumaPrimeroExistentes = $sumaPrimeroExistentes + $resumen->existencia;

                $sheet->setCellValue("O{$filaPrimeroMujeres}", $resumen->bajas);
                $sumaPrimeroBajas = $sumaPrimeroBajas + $resumen->bajas;

                $sheet->setCellValue("P{$filaPrimeroMujeres}", $resumen->inscritos);
                $sumaPrimeroInscritos = $sumaPrimeroInscritos + $resumen->inscritos;

                $totalExistentes = $totalExistentes + $resumen->existencia;
                $totalBajas = $totalBajas + $resumen->bajas;
                $totalInscritos = $totalInscritos + $resumen->inscritos;

                $filaPrimeroMujeres++;            

                
            }

            // segundo hombres 
            if($resumen->grado == "Segundos" && $resumen->sexo == "M"){

                

                if(isset($resumen->edad14)){
                    $sheet->setCellValue("B{$filaSegundoHombres}", $resumen->edad14);

                    $sumaSegundo14 = $sumaSegundo14 + $resumen->edad14;
                }else{
                    $sheet->setCellValue("B{$filaSegundoHombres}", "");
                }
               
                if(isset($resumen->edad15)){
                    $sheet->setCellValue("C{$filaSegundoHombres}", $resumen->edad15);
                    $sumaSegundo15 = $sumaSegundo15 + $resumen->edad15;
                }else{
                    $sheet->setCellValue("C{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad16)){
                    $sheet->setCellValue("D{$filaSegundoHombres}", $resumen->edad16);
                    $sumaSegundo16 = $sumaSegundo16 + $resumen->edad16;
                }else{
                    $sheet->setCellValue("D{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad17)){
                    $sheet->setCellValue("E{$filaSegundoHombres}", $resumen->edad17);
                    $sumaSegundo17 = $sumaSegundo17 + $resumen->edad17;
                }else{
                    $sheet->setCellValue("E{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad18)){
                    $sheet->setCellValue("F{$filaSegundoHombres}", $resumen->edad18);
                    $sumaSegundo18 = $sumaSegundo18 + $resumen->edad18;
                }else{
                    $sheet->setCellValue("F{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad19)){
                    $sheet->setCellValue("G{$filaSegundoHombres}", $resumen->edad19);
                    $sumaSegundo19 = $sumaSegundo19 + $resumen->edad19;
                }else{
                    $sheet->setCellValue("G{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad20)){
                    $sheet->setCellValue("H{$filaSegundoHombres}", $resumen->edad20);
                    $sumaSegundo20 = $sumaSegundo20 + $resumen->edad20;
                }else{
                    $sheet->setCellValue("H{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad21)){
                    $sheet->setCellValue("I{$filaSegundoHombres}", $resumen->edad21);
                    $sumaSegundo21 = $sumaSegundo21 + $resumen->edad21;
                }else{
                    $sheet->setCellValue("I{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad22)){
                    $sheet->setCellValue("J{$filaSegundoHombres}", $resumen->edad22);
                    $sumaSegundo22 = $sumaSegundo22 + $resumen->edad22;
                }else{
                    $sheet->setCellValue("J{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad23)){
                    $sheet->setCellValue("K{$filaSegundoHombres}", $resumen->edad23);
                    $sumaSegundo23 = $sumaSegundo23 + $resumen->edad23;
                }else{
                    $sheet->setCellValue("K{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad24)){
                    $sheet->setCellValue("L{$filaSegundoHombres}", $resumen->edad24);
                    $sumaSegundo24 = $sumaSegundo24 + $resumen->edad24;
                }else{
                    $sheet->setCellValue("L{$filaSegundoHombres}", "");
                }

                if(isset($resumen->edad25)){
                    $sheet->setCellValue("M{$filaSegundoHombres}", $resumen->edad25);
                    $sumaSegundo25 = $sumaSegundo25 + $resumen->edad25;
                }else{
                    $sheet->setCellValue("M{$filaSegundoHombres}", "");
                }

                $sheet->setCellValue("N{$filaSegundoHombres}", $resumen->existencia);
                $sumaSegundoExistentes = $sumaSegundoExistentes + $resumen->existencia;

                $sheet->setCellValue("O{$filaSegundoHombres}", $resumen->bajas);
                $sumaSegundoBajas = $sumaSegundoBajas + $resumen->bajas;

                $sheet->setCellValue("P{$filaSegundoHombres}", $resumen->inscritos);
                $sumaSegundoInscritos = $sumaSegundoInscritos + $resumen->inscritos;

                $totalExistentes = $totalExistentes + $resumen->existencia;
                $totalBajas = $totalBajas + $resumen->bajas;
                $totalInscritos = $totalInscritos + $resumen->inscritos;

                $filaSegundoHombres++;            

                
            }
            // segundo mujeres 
            if($resumen->grado == "Segundos" && $resumen->sexo == "F"){

                if(isset($resumen->edad14)){
                    $sheet->setCellValue("B{$filaSegundoMujeres}", $resumen->edad14);

                    $sumaSegundo14 = $sumaSegundo14 + $resumen->edad14;
                }else{
                    $sheet->setCellValue("B{$filaSegundoMujeres}", "");
                }
               
                if(isset($resumen->edad15)){
                    $sheet->setCellValue("C{$filaSegundoMujeres}", $resumen->edad15);
                    $sumaSegundo15 = $sumaSegundo15 + $resumen->edad15;
                }else{
                    $sheet->setCellValue("C{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad16)){
                    $sheet->setCellValue("D{$filaSegundoMujeres}", $resumen->edad16);
                    $sumaSegundo16 = $sumaSegundo16 + $resumen->edad16;
                }else{
                    $sheet->setCellValue("D{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad17)){
                    $sheet->setCellValue("E{$filaSegundoMujeres}", $resumen->edad17);
                    $sumaSegundo17 = $sumaSegundo17 + $resumen->edad17;
                }else{
                    $sheet->setCellValue("E{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad18)){
                    $sheet->setCellValue("F{$filaSegundoMujeres}", $resumen->edad18);
                    $sumaSegundo18 = $sumaSegundo18 + $resumen->edad18;
                }else{
                    $sheet->setCellValue("F{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad19)){
                    $sheet->setCellValue("G{$filaSegundoMujeres}", $resumen->edad19);
                    $sumaSegundo19 = $sumaSegundo19 + $resumen->edad19;
                }else{
                    $sheet->setCellValue("G{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad20)){
                    $sheet->setCellValue("H{$filaSegundoMujeres}", $resumen->edad20);
                    $sumaSegundo20 = $sumaSegundo20 + $resumen->edad20;
                }else{
                    $sheet->setCellValue("H{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad21)){
                    $sheet->setCellValue("I{$filaSegundoMujeres}", $resumen->edad21);
                    $sumaSegundo21 = $sumaSegundo21 + $resumen->edad21;
                }else{
                    $sheet->setCellValue("I{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad22)){
                    $sheet->setCellValue("J{$filaSegundoMujeres}", $resumen->edad22);
                    $sumaSegundo22 = $sumaSegundo22 + $resumen->edad22;
                }else{
                    $sheet->setCellValue("J{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad23)){
                    $sheet->setCellValue("K{$filaSegundoMujeres}", $resumen->edad23);
                    $sumaSegundo23 = $sumaSegundo23 + $resumen->edad23;
                }else{
                    $sheet->setCellValue("K{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad24)){
                    $sheet->setCellValue("L{$filaSegundoMujeres}", $resumen->edad24);
                    $sumaSegundo24 = $sumaSegundo24 + $resumen->edad24;
                }else{
                    $sheet->setCellValue("L{$filaSegundoMujeres}", "");
                }

                if(isset($resumen->edad25)){
                    $sheet->setCellValue("M{$filaSegundoMujeres}", $resumen->edad25);
                    $sumaSegundo25 = $sumaSegundo25 + $resumen->edad25;
                }else{
                    $sheet->setCellValue("M{$filaSegundoMujeres}", "");
                }

                $sheet->setCellValue("N{$filaSegundoMujeres}", $resumen->existencia);
                $sumaSegundoExistentes = $sumaSegundoExistentes + $resumen->existencia;

                $sheet->setCellValue("O{$filaSegundoMujeres}", $resumen->bajas);
                $sumaSegundoBajas = $sumaSegundoBajas + $resumen->bajas;

                $sheet->setCellValue("P{$filaSegundoMujeres}", $resumen->inscritos);
                $sumaSegundoInscritos = $sumaSegundoInscritos + $resumen->inscritos;

                $totalExistentes = $totalExistentes + $resumen->existencia;
                $totalBajas = $totalBajas + $resumen->bajas;
                $totalInscritos = $totalInscritos + $resumen->inscritos;

                $filaSegundoMujeres++;            

                
            }

             // terceros hombres
             if($resumen->grado == "Terceros" && $resumen->sexo == "M"){                

                if(isset($resumen->edad14)){
                    $sheet->setCellValue("B{$filaTerceroHombres}", $resumen->edad14);

                    $sumaTercero14 = $sumaTercero14 + $resumen->edad14;
                }else{
                    $sheet->setCellValue("B{$filaTerceroHombres}", "");
                }
               
                if(isset($resumen->edad15)){
                    $sheet->setCellValue("C{$filaTerceroHombres}", $resumen->edad15);
                    $sumaTercero15 = $sumaTercero15 + $resumen->edad15;
                }else{
                    $sheet->setCellValue("C{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad16)){
                    $sheet->setCellValue("D{$filaTerceroHombres}", $resumen->edad16);
                    $sumaTercero16 = $sumaTercero16 + $resumen->edad16;
                }else{
                    $sheet->setCellValue("D{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad17)){
                    $sheet->setCellValue("E{$filaTerceroHombres}", $resumen->edad17);
                    $sumaTercero17 = $sumaTercero17 + $resumen->edad17;
                }else{
                    $sheet->setCellValue("E{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad18)){
                    $sheet->setCellValue("F{$filaTerceroHombres}", $resumen->edad18);
                    $sumaTercero18 = $sumaTercero18 + $resumen->edad18;
                }else{
                    $sheet->setCellValue("F{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad19)){
                    $sheet->setCellValue("G{$filaTerceroHombres}", $resumen->edad19);
                    $sumaTercero19 = $sumaTercero19 + $resumen->edad19;
                }else{
                    $sheet->setCellValue("G{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad20)){
                    $sheet->setCellValue("H{$filaTerceroHombres}", $resumen->edad20);
                    $sumaTercero20 = $sumaTercero20 + $resumen->edad20;
                }else{
                    $sheet->setCellValue("H{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad21)){
                    $sheet->setCellValue("I{$filaTerceroHombres}", $resumen->edad21);
                    $sumaTercero21 = $sumaTercero21 + $resumen->edad21;
                }else{
                    $sheet->setCellValue("I{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad22)){
                    $sheet->setCellValue("J{$filaTerceroHombres}", $resumen->edad22);
                    $sumaTercero22 = $sumaTercero22 + $resumen->edad22;
                }else{
                    $sheet->setCellValue("J{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad23)){
                    $sheet->setCellValue("K{$filaTerceroHombres}", $resumen->edad23);
                    $sumaTercero23 = $sumaTercero23 + $resumen->edad23;
                }else{
                    $sheet->setCellValue("K{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad24)){
                    $sheet->setCellValue("L{$filaTerceroHombres}", $resumen->edad24);
                    $sumaTercero24 = $sumaTercero24 + $resumen->edad24;
                }else{
                    $sheet->setCellValue("L{$filaTerceroHombres}", "");
                }

                if(isset($resumen->edad25)){
                    $sheet->setCellValue("M{$filaTerceroHombres}", $resumen->edad25);
                    $sumaTercero25 = $sumaTercero25 + $resumen->edad25;
                }else{
                    $sheet->setCellValue("M{$filaTerceroHombres}", "");
                }

                $sheet->setCellValue("N{$filaTerceroHombres}", $resumen->existencia);
                $sumaTerceroExistentes = $sumaTerceroExistentes + $resumen->existencia;

                $sheet->setCellValue("O{$filaTerceroHombres}", $resumen->bajas);
                $sumaTerceroBajas = $sumaTerceroBajas + $resumen->bajas;

                $sheet->setCellValue("P{$filaTerceroHombres}", $resumen->inscritos);
                $sumaTerceroInscritos = $sumaTerceroInscritos + $resumen->inscritos;

                $totalExistentes = $totalExistentes + $resumen->existencia;
                $totalBajas = $totalBajas + $resumen->bajas;
                $totalInscritos = $totalInscritos + $resumen->inscritos;

                $filaTerceroHombres++;            

                
            }

            // terceros mujeres 
            if($resumen->grado == "Terceros" && $resumen->sexo == "F"){

                if(isset($resumen->edad14)){
                    $sheet->setCellValue("B{$filaTerceroMujeres}", $resumen->edad14);

                    $sumaTercero14 = $sumaTercero14 + $resumen->edad14;
                }else{
                    $sheet->setCellValue("B{$filaTerceroMujeres}", "");
                }
               
                if(isset($resumen->edad15)){
                    $sheet->setCellValue("C{$filaTerceroMujeres}", $resumen->edad15);
                    $sumaTercero15 = $sumaTercero15 + $resumen->edad15;
                }else{
                    $sheet->setCellValue("C{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad16)){
                    $sheet->setCellValue("D{$filaTerceroMujeres}", $resumen->edad16);
                    $sumaTercero16 = $sumaTercero16 + $resumen->edad16;
                }else{
                    $sheet->setCellValue("D{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad17)){
                    $sheet->setCellValue("E{$filaTerceroMujeres}", $resumen->edad17);
                    $sumaTercero17 = $sumaTercero17 + $resumen->edad17;
                }else{
                    $sheet->setCellValue("E{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad18)){
                    $sheet->setCellValue("F{$filaTerceroMujeres}", $resumen->edad18);
                    $sumaTercero18 = $sumaTercero18 + $resumen->edad18;
                }else{
                    $sheet->setCellValue("F{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad19)){
                    $sheet->setCellValue("G{$filaTerceroMujeres}", $resumen->edad19);
                    $sumaTercero19 = $sumaTercero19 + $resumen->edad19;
                }else{
                    $sheet->setCellValue("G{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad20)){
                    $sheet->setCellValue("H{$filaTerceroMujeres}", $resumen->edad20);
                    $sumaTercero20 = $sumaTercero20 + $resumen->edad20;
                }else{
                    $sheet->setCellValue("H{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad21)){
                    $sheet->setCellValue("I{$filaTerceroMujeres}", $resumen->edad21);
                    $sumaTercero21 = $sumaTercero21 + $resumen->edad21;
                }else{
                    $sheet->setCellValue("I{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad22)){
                    $sheet->setCellValue("J{$filaTerceroMujeres}", $resumen->edad22);
                    $sumaTercero22 = $sumaTercero22 + $resumen->edad22;
                }else{
                    $sheet->setCellValue("J{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad23)){
                    $sheet->setCellValue("K{$filaTerceroMujeres}", $resumen->edad23);
                    $sumaTercero23 = $sumaTercero23 + $resumen->edad23;
                }else{
                    $sheet->setCellValue("K{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad24)){
                    $sheet->setCellValue("L{$filaTerceroMujeres}", $resumen->edad24);
                    $sumaTercero24 = $sumaTercero24 + $resumen->edad24;
                }else{
                    $sheet->setCellValue("L{$filaTerceroMujeres}", "");
                }

                if(isset($resumen->edad25)){
                    $sheet->setCellValue("M{$filaTerceroMujeres}", $resumen->edad25);
                    $sumaTercero25 = $sumaTercero25 + $resumen->edad25;
                }else{
                    $sheet->setCellValue("M{$filaTerceroMujeres}", "");
                }

                $sheet->setCellValue("N{$filaTerceroMujeres}", $resumen->existencia);
                $sumaTerceroExistentes = $sumaTerceroExistentes + $resumen->existencia;

                $sheet->setCellValue("O{$filaTerceroMujeres}", $resumen->bajas);
                $sumaTerceroBajas = $sumaTerceroBajas + $resumen->bajas;

                $sheet->setCellValue("P{$filaTerceroMujeres}", $resumen->inscritos);
                $sumaTerceroInscritos = $sumaTerceroInscritos + $resumen->inscritos;


                $totalExistentes = $totalExistentes + $resumen->existencia;
                $totalBajas = $totalBajas + $resumen->bajas;
                $totalInscritos = $totalInscritos + $resumen->inscritos;

                $filaTerceroMujeres++;            

                
            }
        }
    

        // sumas de hombres y mujeres de primero 
        $sheet->getStyle("A{$filaPrimeroTotal}:P{$filaPrimeroTotal}")->getFont()->setBold(true);
        $sheet->getStyle("A{$filaPrimeroTotal}:P{$filaPrimeroTotal}")->getAlignment()->setHorizontal('center');

        if($sumaPrimero14 != 0){
            $sheet->setCellValue("B{$filaPrimeroTotal}", $sumaPrimero14);
        }
        
        if($sumaPrimero15 != 0){
            $sheet->setCellValue("C{$filaPrimeroTotal}", $sumaPrimero15);
        }

        if($sumaPrimero16 != 0){
            $sheet->setCellValue("D{$filaPrimeroTotal}", $sumaPrimero16);
        }

        if($sumaPrimero17 != 0){
            $sheet->setCellValue("E{$filaPrimeroTotal}", $sumaPrimero17);
        }

        if($sumaPrimero18 != 0){
            $sheet->setCellValue("F{$filaPrimeroTotal}", $sumaPrimero18);
        }

        if($sumaPrimero19 != 0){
            $sheet->setCellValue("G{$filaPrimeroTotal}", $sumaPrimero19);
        }

        if($sumaPrimero20 != 0){
            $sheet->setCellValue("H{$filaPrimeroTotal}", $sumaPrimero20);
        }

        if($sumaPrimero21 != 0){
            $sheet->setCellValue("I{$filaPrimeroTotal}", $sumaPrimero21);
        }

        if($sumaPrimero22 != 0){
            $sheet->setCellValue("J{$filaPrimeroTotal}", $sumaPrimero22);
        }

        if($sumaPrimero23 != 0){
            $sheet->setCellValue("K{$filaPrimeroTotal}", $sumaPrimero23);
        }

        if($sumaPrimero24 != 0){
            $sheet->setCellValue("L{$filaPrimeroTotal}", $sumaPrimero24);
        }

        if($sumaPrimero25 != 0){
            $sheet->setCellValue("M{$filaPrimeroTotal}", $sumaPrimero25);
        }

        if($sumaPrimeroExistentes != 0){
            $sheet->setCellValue("N{$filaPrimeroTotal}", $sumaPrimeroExistentes);
        }

        if($sumaPrimeroBajas != 0){
            $sheet->setCellValue("O{$filaPrimeroTotal}", $sumaPrimeroBajas);
        }

        if($sumaPrimeroInscritos != 0){
            $sheet->setCellValue("p{$filaPrimeroTotal}", $sumaPrimeroInscritos);
        }


        // sumas de hombres y mujeres de segundo 
        $sheet->getStyle("A{$filaSegundoTotal}:P{$filaSegundoTotal}")->getFont()->setBold(true);
        $sheet->getStyle("A{$filaSegundoTotal}:P{$filaSegundoTotal}")->getAlignment()->setHorizontal('center');

        if($sumaSegundo14 != 0){
            $sheet->setCellValue("B{$filaSegundoTotal}", $sumaSegundo14);
        }
        
        if($sumaSegundo15 != 0){
            $sheet->setCellValue("C{$filaSegundoTotal}", $sumaSegundo15);
        }

        if($sumaSegundo16 != 0){
            $sheet->setCellValue("D{$filaSegundoTotal}", $sumaSegundo16);
        }

        if($sumaSegundo17 != 0){
            $sheet->setCellValue("E{$filaSegundoTotal}", $sumaSegundo17);
        }

        if($sumaSegundo18 != 0){
            $sheet->setCellValue("F{$filaSegundoTotal}", $sumaSegundo18);
        }

        if($sumaSegundo19 != 0){
            $sheet->setCellValue("G{$filaSegundoTotal}", $sumaSegundo19);
        }

        if($sumaSegundo20 != 0){
            $sheet->setCellValue("H{$filaSegundoTotal}", $sumaSegundo20);
        }

        if($sumaSegundo21 != 0){
            $sheet->setCellValue("I{$filaSegundoTotal}", $sumaSegundo21);
        }

        if($sumaSegundo22 != 0){
            $sheet->setCellValue("J{$filaSegundoTotal}", $sumaSegundo22);
        }

        if($sumaSegundo23 != 0){
            $sheet->setCellValue("K{$filaSegundoTotal}", $sumaSegundo23);
        }

        if($sumaSegundo24 != 0){
            $sheet->setCellValue("L{$filaSegundoTotal}", $sumaSegundo24);
        }

        if($sumaSegundo25 != 0){
            $sheet->setCellValue("M{$filaSegundoTotal}", $sumaSegundo25);
        }

        if($sumaSegundoExistentes != 0){
            $sheet->setCellValue("N{$filaSegundoTotal}", $sumaSegundoExistentes);
        }

        if($sumaSegundoBajas != 0){
            $sheet->setCellValue("O{$filaSegundoTotal}", $sumaSegundoBajas);
        }

        if($sumaSegundoInscritos != 0){
            $sheet->setCellValue("p{$filaSegundoTotal}", $sumaSegundoInscritos);
        }


        // sumas de hombres y mujeres de terceros 
        $sheet->getStyle("A{$filaTerceroTotal}:P{$filaTerceroTotal}")->getFont()->setBold(true);
        $sheet->getStyle("A{$filaTerceroTotal}:P{$filaTerceroTotal}")->getAlignment()->setHorizontal('center');

        if($sumaTercero14 != 0){
            $sheet->setCellValue("B{$filaTerceroTotal}", $sumaTercero14);
        }
        
        if($sumaTercero15 != 0){
            $sheet->setCellValue("C{$filaTerceroTotal}", $sumaTercero15);
        }

        if($sumaTercero16 != 0){
            $sheet->setCellValue("D{$filaTerceroTotal}", $sumaTercero16);
        }

        if($sumaTercero17 != 0){
            $sheet->setCellValue("E{$filaTerceroTotal}", $sumaTercero17);
        }

        if($sumaTercero18 != 0){
            $sheet->setCellValue("F{$filaTerceroTotal}", $sumaTercero18);
        }

        if($sumaTercero19 != 0){
            $sheet->setCellValue("G{$filaTerceroTotal}", $sumaTercero19);
        }

        if($sumaTercero20 != 0){
            $sheet->setCellValue("H{$filaTerceroTotal}", $sumaTercero20);
        }

        if($sumaTercero21 != 0){
            $sheet->setCellValue("I{$filaTerceroTotal}", $sumaTercero21);
        }

        if($sumaTercero22 != 0){
            $sheet->setCellValue("J{$filaTerceroTotal}", $sumaTercero22);
        }

        if($sumaTercero23 != 0){
            $sheet->setCellValue("K{$filaTerceroTotal}", $sumaTercero23);
        }

        if($sumaTercero24 != 0){
            $sheet->setCellValue("L{$filaTerceroTotal}", $sumaTercero24);
        }

        if($sumaTercero25 != 0){
            $sheet->setCellValue("M{$filaTerceroTotal}", $sumaTercero25);
        }

        if($sumaTerceroExistentes != 0){
            $sheet->setCellValue("N{$filaTerceroTotal}", $sumaTerceroExistentes);
        }

        if($sumaTerceroBajas != 0){
            $sheet->setCellValue("O{$filaTerceroTotal}", $sumaTerceroBajas);
        }

        if($sumaTerceroInscritos != 0){
            $sheet->setCellValue("P{$filaTerceroTotal}", $sumaTerceroInscritos);
        }


        $sheet->getStyle("B25:P25")->getFont()->setBold(true);
        $sheet->getStyle("B25:P25")->getAlignment()->setHorizontal('center');
        $sheet->setCellValue("N25", $totalExistentes);
        $sheet->setCellValue("O25", $totalBajas);
        $sheet->setCellValue("P25", $totalInscritos);

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ResumenDeEdades.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
    
        return response()->download(storage_path("ResumenDeEdades.xlsx"));
      }
    
}

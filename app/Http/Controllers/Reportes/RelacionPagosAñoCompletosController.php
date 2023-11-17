<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Departamento;
use App\Http\Models\Curso;
use App\Http\Models\Pago;
use App\Http\Helpers\Utils;
use App\Http\Helpers\UltimaFechaPago;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;
use DB;

class RelacionPagosAñoCompletosController extends Controller
{
    private static $departamento;

    public function __construct() {
        // $this->middleware(['auth', 'permisos:relacion_pagos_completos']);
    }

    public function reporte() {

        return view('reportes/relacion_pagos_año_completos.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'anio' => Carbon::now('America/Merida')->year,
        ]);
    }

    public function imprimir(Request $request)
    {
        // per numero pero anio ubicacion y departamento
        $periodo = Periodo::find($request->periodo_id);
        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $departamento = Departamento::find($request->departamento_id);
        
        $results =  DB::select("call procListaPagosMes("
            .$periodo->perNumero
            .",'".$periodo->perAnio
            ."','".$ubicacion->ubiClave
            ."','".$departamento->depClave
            ."','"
            ."','"
            ."','"
            ."','"
            ."','"
            ."',''"
            .")");

        if(collect($results)->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }
        // dd($results);
        return $this->generarExcel($results, $periodo, $ubicacion, $departamento);
    }

    /**
     * @param array $results
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($results, $periodo, $ubicacion, $departamento) {

        // $ubicacion = self::$departamento->ubicacion;
        // $periodos = $info_reporte['periodos'];
        // $request = $info_reporte['request'];
        // $titulo = "{$ubicacion->ubiClave} - " . $departamento->depClave ." - Año escolar {$periodo->perAnioPago}";
        // $titulo .=  "       Última fecha de pago: " . UltimaFechaPago::ultimoPago();

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
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
        $sheet->getColumnDimension('AE')->setAutoSize(true);
        $sheet->getColumnDimension('AF')->setAutoSize(true);
        $sheet->getColumnDimension('AG')->setAutoSize(true);
        $sheet->getColumnDimension('AH')->setAutoSize(true);
        $sheet->getColumnDimension('AI')->setAutoSize(true);
        $sheet->getColumnDimension('AJ')->setAutoSize(true);
        $sheet->getColumnDimension('AK')->setAutoSize(true);
        $sheet->getColumnDimension('AL')->setAutoSize(true);
        $sheet->getColumnDimension('AM')->setAutoSize(true);
        $sheet->getColumnDimension('AN')->setAutoSize(true);
        $sheet->getColumnDimension('AO')->setAutoSize(true);
        $sheet->getColumnDimension('AP')->setAutoSize(true);
        $sheet->getColumnDimension('AQ')->setAutoSize(true);
        $sheet->getColumnDimension('AR')->setAutoSize(true);
        $sheet->getColumnDimension('AS')->setAutoSize(true);
        $sheet->getColumnDimension('AT')->setAutoSize(true);

        $sheet->setCellValueByColumnAndRow(1, 1, 'Período');
        $sheet->setCellValueByColumnAndRow(2, 1, 'Año');
        $sheet->setCellValueByColumnAndRow(3, 1, 'Ubi');
        $sheet->setCellValueByColumnAndRow(4, 1, 'Dep');
        $sheet->setCellValueByColumnAndRow(5, 1, 'Esc');
        $sheet->setCellValueByColumnAndRow(6, 1, 'Prgo');
        $sheet->setCellValueByColumnAndRow(7, 1, 'Sem');
        $sheet->setCellValueByColumnAndRow(8, 1, 'Gpo');
        $sheet->setCellValueByColumnAndRow(9, 1, 'Clave Pago');
        $sheet->setCellValueByColumnAndRow(10, 1, 'Apellido 1');
        $sheet->setCellValueByColumnAndRow(11, 1, 'Apellido 2');
        $sheet->setCellValueByColumnAndRow(12, 1, 'Nombre');

        $sheet->setCellValueByColumnAndRow(13, 1, 'Edo');
        $sheet->setCellValueByColumnAndRow(14, 1, 'Plan');
        $sheet->setCellValueByColumnAndRow(15, 1, 'Beca');
        $sheet->setCellValueByColumnAndRow(16, 1, 'Porc');
        $sheet->setCellValueByColumnAndRow(17, 1, 'Insc Ago');
        $sheet->setCellValueByColumnAndRow(18, 1, 'Fecha Insc');
        $sheet->setCellValueByColumnAndRow(19, 1, 'Septiembre');
        $sheet->setCellValueByColumnAndRow(20, 1, 'Fecha Sep');
        $sheet->setCellValueByColumnAndRow(21, 1, 'Octubre');

        $sheet->setCellValueByColumnAndRow(22, 1, 'Fecha Oct');
        $sheet->setCellValueByColumnAndRow(23, 1, 'Noviembre');
        $sheet->setCellValueByColumnAndRow(24, 1, 'Fecha Nov');
        $sheet->setCellValueByColumnAndRow(25, 1, 'Diciembre');
        $sheet->setCellValueByColumnAndRow(26, 1, 'Fecha Dic');
        $sheet->setCellValueByColumnAndRow(27, 1, 'Enero');
        $sheet->setCellValueByColumnAndRow(28, 1, 'Fecha Ene');
        $sheet->setCellValueByColumnAndRow(29, 1, 'Insc. Ene');
        $sheet->setCellValueByColumnAndRow(30, 1, 'Fecha Insc');
        $sheet->setCellValueByColumnAndRow(31, 1, 'Febrero');
        $sheet->setCellValueByColumnAndRow(32, 1, 'Fecha Feb');
        $sheet->setCellValueByColumnAndRow(33, 1, 'Marzo');

        $sheet->setCellValueByColumnAndRow(34, 1, 'Fecha Mar');
        $sheet->setCellValueByColumnAndRow(35, 1, 'Abril');
        $sheet->setCellValueByColumnAndRow(36, 1, 'Fecha Abr');
        $sheet->setCellValueByColumnAndRow(37, 1, 'Mayo');
        $sheet->setCellValueByColumnAndRow(38, 1, 'Fecha May');
        $sheet->setCellValueByColumnAndRow(39, 1, 'Junio');
        $sheet->setCellValueByColumnAndRow(40, 1, 'Fecha Jun');
        $sheet->setCellValueByColumnAndRow(41, 1, 'Julio');
        $sheet->setCellValueByColumnAndRow(42, 1, 'Fecha Jul');
        $sheet->setCellValueByColumnAndRow(43, 1, 'Agosto');
        $sheet->setCellValueByColumnAndRow(44, 1, 'Fecha Ago');
        $sheet->setCellValueByColumnAndRow(45, 1, 'Último pago: '.UltimaFechaPago::ultimoPago());

        $fila = 2;
        foreach($results as $result) {
            $columna = "A";
            $sheet->setCellValue(($columna . $fila), $result->perNumero);
            $sheet->setCellValue((++$columna . $fila), $result->perAnio);
            $sheet->setCellValue((++$columna . $fila), $result->ubiClave);
            $sheet->setCellValue((++$columna . $fila), $result->depClave);
            $sheet->setCellValue((++$columna . $fila), $result->escClave);
            $sheet->setCellValue((++$columna . $fila), $result->progClave);
            $sheet->setCellValue((++$columna . $fila), $result->cgtGradoSemestre);
            $sheet->setCellValue((++$columna . $fila), $result->cgtGrupo);
            $sheet->setCellValue((++$columna . $fila), $result->aluClave);
            $sheet->setCellValue((++$columna . $fila), $result->perApellido1);
            $sheet->setCellValue((++$columna . $fila), $result->perApellido2);
            $sheet->setCellValue((++$columna . $fila), $result->perNombre);
            $sheet->setCellValue((++$columna . $fila), $result->curEstado);
            $sheet->setCellValue((++$columna . $fila), $result->curPlanPago);
            $sheet->setCellValue((++$columna . $fila), $result->curTipoBeca);
            $sheet->setCellValue((++$columna . $fila), $result->curPorcentajeBeca);
             // formato pesos
            $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe99) ? '' : $result->Importe99, // el valor
                is_null($result->Importe99) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("Q$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha99) ? '' : Carbon::parse($result->fecha99)->format('d/m/Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit(
                (++$columna . $fila),  // la columna con su fila ejemplo A1
                is_null($result->Importe01) ? '' : $result->Importe01, // el valor
                is_null($result->Importe01) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("S$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha01) ? '' : Carbon::parse($result->fecha01)->format('d/m/Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe02) ? '' : $result->Importe02, // el valor 
                is_null($result->Importe02) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("U$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha02) ? '' : Carbon::parse($result->fecha02)->format('d/m/Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe03) ? '' : $result->Importe03, // el valor 
                is_null($result->Importe03) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("W$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha03) ? '' : Carbon::parse($result->fecha03)->format('d/m/Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe04) ? '' : $result->Importe04, // el valor 
                is_null($result->Importe04) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("Y$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha04) ? '' : Carbon::parse($result->fecha04)->format('d/m/Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe05) ? '' : $result->Importe05, // el valor 
                is_null($result->Importe05) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AA$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha05) ? '' : Carbon::parse($result->fecha05)->format('d/m/Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe00) ? '' : $result->Importe00, // el valor 
                is_null($result->Importe00) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AC$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha00) ? '' : Carbon::parse($result->fecha00)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe06) ? '' : $result->Importe06, // el valor 
                is_null($result->Importe06) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AE$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha06) ? '' : Carbon::parse($result->fecha06)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe07) ? '' : $result->Importe07, // el valor 
                is_null($result->Importe07) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AG$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha07) ? '' : Carbon::parse($result->fecha07)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe08) ? '' : $result->Importe08, // el valor 
                is_null($result->Importe08) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AI$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha08) ? '' : Carbon::parse($result->fecha08)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe09) ? '' : $result->Importe09, // el valor 
                is_null($result->Importe09) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AK$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha09) ? '' : Carbon::parse($result->fecha09)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe10) ? '' : $result->Importe10, // el valor 
                is_null($result->Importe10) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AM$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha10) ? '' : Carbon::parse($result->fecha10)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe11) ? '' : $result->Importe11, // el valor 
                is_null($result->Importe11) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AO$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha11) ? '' : Carbon::parse($result->fecha11)->format('d/m/Y'), DataType::TYPE_STRING);
           $sheet->setCellValueExplicit(
                (++$columna . $fila), // la columna con su fila ejemplo A1
                is_null($result->Importe12) ? '' : $result->Importe12, // el valor 
                is_null($result->Importe12) ? DataType::TYPE_STRING : DataType::TYPE_NUMERIC // el tipo del valor
            );
            $sheet->getStyle("AQ$fila")->getAlignment()->setHorizontal('right');
            $sheet->setCellValue((++$columna . $fila), is_null($result->fecha12) ? '' : Carbon::parse($result->fecha12)->format('d/m/Y'), DataType::TYPE_STRING);
            
            $fila++;
            $columna = "A"; # comenzará la fila de otro alumno.
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("RelacionPagosAñoCompletos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("RelacionPagosAñoCompletos.xlsx"));
    }

    private static function importeFormat($importe) {
        if (is_null($importe)) return '';
        return $importe != 0 ? '$'.number_format($importe, 2, '.', ',') : '$0.00';
    }

    private static function importeNull($importe) {
        if (is_null($importe)) return '';
    }
}

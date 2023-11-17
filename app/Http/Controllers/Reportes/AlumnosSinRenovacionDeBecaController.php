<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;
use App\Http\Models\Beca;
use App\Http\Helpers\Utils;
use App\Http\Helpers\UltimaFechaPago;
use App\clases\periodos\MetodosPeriodos;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class AlumnosSinRenovacionDeBecaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function reporte() {

        return view('reportes/alumnos_sin_renovacion_beca.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'becas' => Beca::get(),
        ]);
    }

    public function imprimir(Request $request) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;
        $escClave = $request->escuela_id ? Escuela::findOrFail($request->escuela_id)->escClave : null;
        $progClave = $request->programa_id ? Programa::findOrFail($request->programa_id)->progClave : null;
        $semestre = $request->semestre ? "'{$request->semestre}'" : 'NULL';
        $aluClave = $request->aluClave ? "'{$request->aluClave}'" : 'NULL';
        // dd($periodo);
        $alumnos = DB::select("call procAlumnosSinRenovacionDeBeca(
            '{$ubicacion->ubiClave}',
            '{$departamento->depClave}',
            {$periodo->perNumero},
            {$periodo->perAnio},
            {$periodo->perAnioPago},
            '{$escClave}',
            '{$progClave}',
            {$semestre},
            {$aluClave},
            '{$request->curTipoBeca}'
        );");

        if(empty($alumnos)) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $alumnos);
    }


    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo_solicitado = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $periodo = $periodo_solicitado;
        $departamento = $periodo->departamento;
        $fechas_periodo = Utils::fecha_string($periodo_solicitado->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo_solicitado->perFechaFinal, 'mesCorto');
        $perAnioPago = $periodo->perAnioPago;

        # Si no existe periodo anterior en el mismo año escolar, elige el periodo más reciente del año escolar anterior.
        if(!MetodosPeriodos::buscarAnteriores($periodo, $periodo->perEstado)->where('perAnioPago', $periodo->perAnioPago)->exists()) {
            $periodo = MetodosPeriodos::buscarAnteriores($periodo, $periodo->perEstado)->where('perAnioPago', ($periodo->perAnioPago - 1))->first();
        }

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'periodo_descripcion' => "{$fechas_periodo} ({$periodo_solicitado->perNumero}/{$periodo_solicitado->perAnio})",
            'periodo' => $periodo,
            'periodo_solicitado' => $periodo_solicitado,
            'periodo_anterior' => MetodosPeriodos::buscarAnteriores($periodo, $periodo->perEstado)->first(),
        ];
    }


    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $alumnos) {

        $periodo = $info_reporte['periodo'];
        $periodo_solicitado = $info_reporte['periodo_solicitado'];
        $periodo_anterior = $info_reporte['periodo_anterior'];

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
        $sheet->mergeCells("A1:O1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}" . "        Última fecha de pago: " . UltimaFechaPago::ultimoPago());
        $sheet->getStyle("A2:O2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Semestre");
        $sheet->setCellValueByColumnAndRow(4, 2, "Cve. Pago");
        $sheet->setCellValueByColumnAndRow(5, 2, "Nombre alumno");
        $sheet->setCellValueByColumnAndRow(6, 2, "Edo {$periodo_solicitado->perNumero}/{$periodo_solicitado->perAnio}");
        $sheet->setCellValueByColumnAndRow(7, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(8, 2, "Beca {$periodo->perNumero}/{$periodo->perAnio}");
        $sheet->setCellValueByColumnAndRow(9, 2, "Porc");
        $sheet->setCellValueByColumnAndRow(10, 2, "Observaciones de beca");
        $sheet->setCellValueByColumnAndRow(11, 2, "Concepto");
        $sheet->setCellValueByColumnAndRow(12, 2, "Importe");
        $sheet->setCellValueByColumnAndRow(13, 2, "Pago Inscripción {$periodo_solicitado->perNumero}/{$periodo_solicitado->perAnio}");
        $sheet->setCellValueByColumnAndRow(14, 2, "Prom {$periodo->perNumero}/{$periodo->perAnio}");
        $sheet->setCellValueByColumnAndRow(15, 2, "Prom {$periodo_anterior->perNumero}/{$periodo_anterior->perAnio}");

        $fila = 3;
        foreach($alumnos as $alumno) {
            $sheet->setCellValue("A{$fila}", $alumno->escClave);
            $sheet->setCellValue("B{$fila}", $alumno->progClave);
            $sheet->setCellValueExplicit("C{$fila}", $alumno->semestre, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $alumno->aluClave, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $alumno->nombreCompleto);
            $sheet->setCellValueExplicit("F{$fila}", $alumno->curEstado, DataType::TYPE_STRING);
            $sheet->setCellValue("G{$fila}", $alumno->curPlanPago);
            $sheet->setCellValueExplicit("H{$fila}", $alumno->curTipoBeca, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I{$fila}", $alumno->curPorcentajeBeca, DataType::TYPE_STRING);
            $sheet->setCellValue("J{$fila}", $alumno->curObservacionesBeca);
            $sheet->setCellValue("K{$fila}", $alumno->pagConcPago);
            $sheet->setCellValue("L{$fila}", $alumno->pagImpPago);
            $sheet->setCellValue("M{$fila}", $alumno->pagFechaPago);
            $sheet->setCellValue("N{$fila}", $alumno->promedio_actual);
            $sheet->setCellValue("O{$fila}", $alumno->promedio_anterior);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("AlumnosSinRenovacionDeBeca.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("AlumnosSinRenovacionDeBeca.xlsx"));
    }
}

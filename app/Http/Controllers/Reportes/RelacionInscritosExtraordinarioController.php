<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\InscritoExtraordinario;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RelacionInscritosExtraordinarioController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'permisos:menu_reportes_extraordinarios']);
    }

    public function reporte() {

        return view('reportes/relacion_inscritos_extraordinario.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        if(!self::buscarInscritos($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $inscritos = new Collection;
        self::buscarInscritos($request)
        ->chunk(150, static function($registros) use ($inscritos) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($inscrito) use ($inscritos) {
                $inscritos->push(self::info_esencial($inscrito));
            });
        });

        $infoReporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($infoReporte, $inscritos);
    }

    /**
     * @param Iluminate\Http\Request
     */
    private static function buscarInscritos($request) {

        return InscritoExtraordinario::with(['extraordinario.materia.plan.programa.escuela', 'alumno.persona'])
        ->whereHas('extraordinario.materia.plan.programa.escuela', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
        });
    }

    /**
     * @param App\Models\InscritoExtraordinario
     */
    private static function info_esencial($inscrito) {

        $alumno = $inscrito->alumno;
        $nombreCompleto = $alumno->persona->nombreCompleto(true);
        $extraordinario = $inscrito->extraordinario;
        $materia = $extraordinario->materia;
        $plan = $materia->plan;
        $programa = $plan->programa;
        $escuela = $programa->escuela;

        return [
            'aluClave' => $alumno->aluClave,
            'nombreCompleto' => $nombreCompleto,
            'folioExtraordinario' => $extraordinario->id,
            'extFecha' => $extraordinario->extFecha,
            'extHora' => $extraordinario->extHora,
            'matClave' => $materia->matClave,
            'matNombre' => $materia->matNombreOficial,
            'matSemestre' => $materia->matSemestre,
            'planClave' => $plan->planClave,
            'progClave' => $programa->progClave,
            'escClave' => $escuela->escClave,
            'orden' => "{$escuela->escClave}-{$programa->progClave}-{$nombreCompleto}",
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $fechas_periodo = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'periodo_descripcion' => "{$fechas_periodo} ({$periodo->perNumero}/{$periodo->perAnio})",
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $inscritos) {

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
        $sheet->mergeCells("A1:K1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:K2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(4, 2, "Cve. Pago");
        $sheet->setCellValueByColumnAndRow(5, 2, "Nombre alumno");
        $sheet->setCellValueByColumnAndRow(6, 2, "Cve. materia");
        $sheet->setCellValueByColumnAndRow(7, 2, "Nombre materia");
        $sheet->setCellValueByColumnAndRow(8, 2, "Sem.");
        $sheet->setCellValueByColumnAndRow(9, 2, "Folio Extraordinario");
        $sheet->setCellValueByColumnAndRow(10, 2, "Fecha");
        $sheet->setCellValueByColumnAndRow(11, 2, "Hora");

        $fila = 3;
        foreach($inscritos->sortBy('orden') as $inscrito) {
            $sheet->setCellValue("A{$fila}", $inscrito['escClave']);
            $sheet->setCellValue("B{$fila}", $inscrito['progClave']);
            $sheet->setCellValueExplicit("C{$fila}", $inscrito['planClave'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $inscrito['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $inscrito['nombreCompleto']);
            $sheet->setCellValueExplicit("F{$fila}", $inscrito['matClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("G{$fila}", $inscrito['matNombre']);
            $sheet->setCellValueExplicit("H{$fila}", $inscrito['matSemestre'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I{$fila}", $inscrito['folioExtraordinario'], DataType::TYPE_STRING);
            $sheet->setCellValue("J{$fila}", $inscrito['extFecha']);
            $sheet->setCellValue("K{$fila}", $inscrito['extHora']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("RelacionInscritosExtraordinario.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("RelacionInscritosExtraordinario.xlsx"));
    }
}

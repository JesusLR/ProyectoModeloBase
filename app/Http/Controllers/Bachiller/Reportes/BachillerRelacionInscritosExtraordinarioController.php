<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Http\Models\Escuela;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use Carbon\Carbon;
use Exception;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class BachillerRelacionInscritosExtraordinarioController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function reporte() {

        $ubicaciones = Ubicacion::whereIn("id", [1,2,3])->get();

        return view('bachiller.reportes.relacion_inscritos_extraordinario.create', [
            'ubicaciones' => $ubicaciones
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

        if($request->tipoReporte == 1){
            return $this->generarExcel($infoReporte, $inscritos, $request->extTipo);
        }
        
        if($request->tipoReporte == 2){

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');

            $fechaHoy = $fechaActual->format('d').'/'.Utils::num_meses_corto_string($fechaActual->format('m')).'/'.$fechaActual->format('Y');
            
            $parametro_NombreArchivo = 'relacion_inscritos_recuperativos';
            // view('reportes.pdf.bachiller.relacion_inscritos_recuperativos.relacion_inscritos_recuperativos');
            $pdf = PDF::loadView('reportes.pdf.bachiller.relacion_inscritos_recuperativos.' . $parametro_NombreArchivo, [
                "info_reporte" => $infoReporte,
                "inscritos" => $inscritos,
                "fechaHoy" => $fechaHoy,
                "fechaActual" => $fechaActual,
                "iexEstado" => $request->iexEstado,
                "extTipo" => $request->extTipo
            ]);

            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }

    /**
     * @param Iluminate\Http\Request
     */
    private static function buscarInscritos($request) {

        return Bachiller_inscritosextraordinarios::with(['bachiller_extraordinario.bachiller_materia.plan.programa.escuela', 'alumno.persona'])        
        ->where(static function($query) use ($request) {
            if($request->iexEstado != ""){
                $query->where('iexEstado', $request->iexEstado);
            }else{
                $query->where('iexEstado', '!=', 'C');
            }
        })
        ->whereHas('bachiller_extraordinario.bachiller_materia.plan.programa.escuela', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->extFecha)
                $query->where('extFecha', $request->extFecha);
        })

        ->whereHas('bachiller_extraordinario', static function($query) use ($request) {          
            if($request->folio)
                $query->where('id', $request->folio);


            if($request->extTipo != ""){
                $query->where('extTipo', '=', $request->extTipo);
            }
        })
        
        ->whereHas('bachiller_extraordinario.bachiller_materia', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->matClave)
                $query->where('matClave', $request->matClave);
        });
    }

    /**
     * @param App\Http\Models\InscritoExtraordinario
     */
    private static function info_esencial($inscrito) {

        $alumno = $inscrito->alumno;
        $nombreCompleto = $alumno->persona->nombreCompleto(true);
        $bachiller_extraordinario = $inscrito->bachiller_extraordinario;
        $bachiller_materia = $bachiller_extraordinario->bachiller_materia;
        $plan = $bachiller_materia->plan;
        $programa = $plan->programa;
        $escuela = $programa->escuela;

        return [
            'aluClave' => $alumno->aluClave,
            'aluMatricula' => $alumno->aluMatricula,
            'nombreCompleto' => $nombreCompleto,
            'folioExtraordinario' => $bachiller_extraordinario->id,
            'extFecha' => $bachiller_extraordinario->extFecha,
            'extHora' => $bachiller_extraordinario->extHora,
            'matClave' => $bachiller_materia->matClave,
            'matNombre' => $bachiller_materia->matNombre,
            'matSemestre' => $bachiller_materia->matSemestre,
            'planClave' => $plan->planClave,
            'progClave' => $programa->progClave,
            'escClave' => $escuela->escClave,
            'orden' => "{$escuela->escClave}-{$programa->progClave}-{$nombreCompleto}",
            'iexEstado' => $inscrito->iexEstado,
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $fechas_periodo = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');
        $escuela = Escuela::findOrFail($request->escuela_id);
        $programa = Programa::findOrFail($request->programa_id);
        $plan = Plan::findOrFail($request->plan_id);

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'periodo_descripcion' => "{$fechas_periodo} ({$periodo->perNumero}/{$periodo->perAnio})",
            'escuela' => $escuela,
            'programa' => $programa,
            'plan' => $plan
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $inscritos, $extTipo) {

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

        $sheet->mergeCells("A1:E1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");

        if($extTipo != ""){
            $sheet->getStyle('F1')->getFont()->setBold(true);
            $sheet->setCellValue('F1', "Tipo recuperativo: {$extTipo}");
        }
        

        $sheet->getStyle("A2:M2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(4, 2, "Cve. Pago");
        $sheet->setCellValueByColumnAndRow(5, 2, "Matricula");
        $sheet->setCellValueByColumnAndRow(6, 2, "Nombre alumno");
        $sheet->setCellValueByColumnAndRow(7, 2, "Cve. materia");
        $sheet->setCellValueByColumnAndRow(8, 2, "Nombre materia");
        $sheet->setCellValueByColumnAndRow(9, 2, "Sem.");
        $sheet->setCellValueByColumnAndRow(10, 2, "Folio Extraordinario");
        $sheet->setCellValueByColumnAndRow(11, 2, "Fecha");
        $sheet->setCellValueByColumnAndRow(12, 2, "Hora");
        $sheet->setCellValueByColumnAndRow(13, 2, "Estado");

        $fila = 3;
        foreach($inscritos->sortBy('orden') as $inscrito) {
            $sheet->setCellValue("A{$fila}", $inscrito['escClave']);
            $sheet->setCellValue("B{$fila}", $inscrito['progClave']);
            $sheet->setCellValueExplicit("C{$fila}", $inscrito['planClave'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $inscrito['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E{$fila}", $inscrito['aluMatricula'], DataType::TYPE_STRING);
            $sheet->setCellValue("F{$fila}", $inscrito['nombreCompleto']);
            $sheet->setCellValueExplicit("G{$fila}", $inscrito['matClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("H{$fila}", $inscrito['matNombre']);
            $sheet->setCellValueExplicit("I{$fila}", $inscrito['matSemestre'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$fila}", $inscrito['folioExtraordinario'], DataType::TYPE_STRING);
            $sheet->setCellValue("K{$fila}", Utils::fecha_string($inscrito['extFecha'], $inscrito['extFecha']));
            $sheet->setCellValue("L{$fila}", $inscrito['extHora']);
            if($inscrito['iexEstado'] == "P"){
                $sheet->setCellValue("M{$fila}", "PAGADO");
            }else{
                $sheet->setCellValue("M{$fila}", "NO PAGADO")->getStyle("M{$fila}")->getFont()->setBold(true);
            }
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("BachillerRelacionInscritosExtraordinario.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("BachillerRelacionInscritosExtraordinario.xlsx"));
    }
}

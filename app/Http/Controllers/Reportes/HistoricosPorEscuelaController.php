<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Historico;
use App\Models\ResumenAcademico;
use App\clases\historicos\MetodosHistoricos;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class HistoricosPorEscuelaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function reporte() {

        return view('reportes/historicos_por_escuela.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {
        if(!self::buscarHistoricos($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $historicos = new Collection;
        self::buscarHistoricos($request)
        ->chunk(150, static function($registros) use ($historicos) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($historico) use ($historicos) {
                $info = self::info_esencial($historico);
                $historicos->put($info['orden'], $info);
            });
        });

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $historicos);
    }


    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarHistoricos($request) {
        $periodo1 = Periodo::findOrFail($request->periodo_1);
        $periodo2 = Periodo::findOrFail($request->periodo_2);
        # -----------------------
        $resacas = ResumenAcademico::select('resumenacademico.alumno_id AS resaca_alumno_id', 'resumenacademico.plan_id AS resaca_plan_id', 
            'resumenacademico.resUltimoGrado', 'resumenacademico.resFechaIngreso', 'cgt.cgtGradoSemestre', 'cgt.cgtGrupo')
        ->leftJoin('cursos', 'cursos.alumno_id', 'resumenacademico.alumno_id')
        ->leftJoin('cgt', static function($join) {
            $join->on('cursos.cgt_id', 'cgt.id')
                ->on('resumenacademico.plan_id', 'cgt.plan_id')
                ->on('resumenacademico.resUltimoGrado', 'cgt.cgtGradoSemestre');
        });
        # -----------------------
        return Historico::with(['alumno.persona', 'materia', 'periodo'])
        ->select('historico.*', 'resacas.*')
        ->leftJoinSub($resacas, 'resacas', static function($join) {
            $join->on('historico.alumno_id', 'resacas.resaca_alumno_id')
                ->on('historico.plan_id', 'resacas.resaca_plan_id');
        })
        ->where(static function($query) use ($request) {
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
        })
        ->whereHas('plan', static function($query) use ($request) {
            $query->where('programa_id', $request->programa_id);
        })
        ->whereHas('periodo', static function($query) use ($periodo1, $periodo2) {
            $query->whereDate('perFechaInicial', '>=', $periodo1->perFechaInicial)
                ->whereDate('perFechaInicial', '<=', $periodo2->perFechaInicial);
        });
    }

    /**
     * @param App\Models\Historico
     */
    private static function info_esencial($historico) {

        $alumno = $historico->alumno;
        $persona = $alumno->persona;
        $nombreCompleto = $persona->nombreCompleto(true);
        $materia = $historico->materia;
        $periodo = $historico->periodo;

        return [
            'aluClave' => $alumno->aluClave,
            'perApellido1' => $persona->perApellido1,
            'perApellido2' => $persona->perApellido2,
            'perNombre' => $persona->perNombre,
            'perNumero' => $periodo->perNumero,
            'perAnio' => $periodo->perAnio,
            'resUltimoGrado' => $historico->resUltimoGrado ?: null,
            'grupo' => $historico->cgtGrupo ?: '',
            'fechaIngreso' => $historico->resFechaIngreso ?: null,
            'matClave' => $materia->matClave,
            'matNombreOficial' => $materia->matNombreOficial,
            'histPeriodoAcreditacion' => $historico->histPeriodoAcreditacion,
            'histFechaExamen' => $historico->histFechaExamen,
            'histCalificacion' => $materia->esAlfabetica() ? MetodosHistoricos::definirCalificacion($historico, $materia) : $historico->histCalificacion,
            'orden' => "{$nombreCompleto}-" 
                . (str_pad($materia->matSemestre, 2, '0', STR_PAD_LEFT)) 
                . "-{$materia->matNombreOficial}"
                . "-{$historico->histPeriodoAcreditacion}-{$historico->histTipoAcreditacion}",
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo1 = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_1);
        $periodo2 = Periodo::findOrFail($request->periodo_2);
        $departamento = $periodo1->departamento;

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'programa' => Programa::findOrFail($request->programa_id),
            'periodos' => "Históricos del periodo {$periodo1->perNumero}/{$periodo1->perAnio} al {$periodo2->perNumero}/{$periodo2->perAnio}",
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $historicos) {

        $programa = $info_reporte['programa'];

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
        $sheet->mergeCells("A1:T1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodos']}");
        $sheet->getStyle("A2:T2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Año");
        $sheet->setCellValueByColumnAndRow(2, 2, "Periodo");
        $sheet->setCellValueByColumnAndRow(3, 2, "Clave de pago");
        $sheet->setCellValueByColumnAndRow(4, 2, "Apellido paterno");
        $sheet->setCellValueByColumnAndRow(5, 2, "Apellido materno");
        $sheet->setCellValueByColumnAndRow(6, 2, "Nombre alumno");
        $sheet->setCellValueByColumnAndRow(7, 2, "Carrera");
        $sheet->setCellValueByColumnAndRow(8, 2, "Grado");
        $sheet->setCellValueByColumnAndRow(9, 2, "Grupo");
        $sheet->setCellValueByColumnAndRow(10, 2, "Fecha ingreso");
        $sheet->setCellValueByColumnAndRow(11, 2, "Clave materia");
        $sheet->setCellValueByColumnAndRow(12, 2, "Materia");
        $sheet->setCellValueByColumnAndRow(13, 2, "Acreditación");
        $sheet->setCellValueByColumnAndRow(14, 2, "Fecha examen");
        $sheet->setCellValueByColumnAndRow(15, 2, "Calificación");

        $fila = 3;
        foreach($historicos->sortKeys() as $historico) {
            $sheet->setCellValueExplicit("A{$fila}", $historico['perAnio'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$fila}", $historico['perNumero'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", $historico['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("D{$fila}", $historico['perApellido1']);
            $sheet->setCellValue("E{$fila}", $historico['perApellido2']);
            $sheet->setCellValue("F{$fila}", $historico['perNombre']);
            $sheet->setCellValue("G{$fila}", $programa->progNombre);
            $sheet->setCellValueExplicit("H{$fila}", $historico['resUltimoGrado'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I{$fila}", $historico['grupo'], DataType::TYPE_STRING);
            $sheet->setCellValue("J{$fila}", $historico['fechaIngreso']);
            $sheet->setCellValueExplicit("K{$fila}", $historico['matClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("L{$fila}", $historico['matNombreOficial']);
            $sheet->setCellValue("M{$fila}", $historico['histPeriodoAcreditacion']);
            $sheet->setCellValue("N{$fila}", $historico['histFechaExamen']);
            $sheet->setCellValueExplicit("O{$fila}", $historico['histCalificacion'], DataType::TYPE_STRING);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("HistoricosPorEscuela.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("HistoricosPorEscuela.xlsx"));
    }
}

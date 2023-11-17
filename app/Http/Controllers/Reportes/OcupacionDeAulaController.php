<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Grupo;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class OcupacionDeAulaController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function reporte()
    {
        return view('reportes/ocupacion_de_aula.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        if(!self::buscarGrupos($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $grupos = new Collection;
        self::buscarGrupos($request)
        ->chunk(200, static function($registros) use ($grupos) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($grupo) use ($grupos) {
                $grupos->push(self::info_esencial($grupo));
            });
        });

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $grupos);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarGrupos($request)
    {
        return Grupo::with(['materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona', 'horarios.aula'])
        ->whereHas('materia.plan.programa', static function($query) use ($request) {
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
        })
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
        });
    }

    /**
     * @param App\Http\Models\Grupo
     */
    private static function info_esencial($grupo): array {
        $materia = $grupo->materia;
        $empleado = $grupo->empleado;
        $programa = $materia->plan->programa;
        $horarios = $grupo->horarios->keyBy('ghDia');
        $lunes = $horarios->get(1) ?: null;
        $martes = $horarios->get(2) ?: null;
        $miercoles = $horarios->get(3) ?: null;
        $jueves = $horarios->get(4) ?: null;
        $viernes = $horarios->get(5) ?: null;
        $sabado = $horarios->get(6) ?: null;

        return [
            'ubiClave' => $programa->escuela->departamento->ubicacion->ubiClave,
            'progClave' => $programa->progClave,
            'gpoSemestre' => $grupo->gpoSemestre,
            'gpoClave' => $grupo->gpoClave,
            'matClave' => $materia->matClave,
            'matNombre' => str_replace(',', '', $materia->matNombreOficial),
            'empleado_id' => $grupo->empleado_id,
            'empleado_nombre' => $empleado->persona->nombreCompleto(),
            'lunes' => $lunes ? "{$lunes->ghInicio}-{$lunes->ghFinal}" : null,
            'aula_lunes' => $lunes && $lunes->aula ? $lunes->aula->aulaClave : null,
            'martes' => $martes ? "{$martes->ghInicio}-{$martes->ghFinal}" : null,
            'aula_martes' => $martes && $martes->aula ? $martes->aula->aulaClave : null,
            'miercoles' => $miercoles ? "{$miercoles->ghInicio}-{$miercoles->ghFinal}" : null,
            'aula_miercoles' => $miercoles && $miercoles->aula ? $miercoles->aula->aulaClave : null,
            'jueves' => $jueves ? "{$jueves->ghInicio}-{$jueves->ghFinal}" : null,
            'aula_jueves' => $jueves && $jueves->aula ? $jueves->aula->aulaClave : null,
            'viernes' => $viernes ? "{$viernes->ghInicio}-{$viernes->ghFinal}" : null,
            'aula_viernes' => $viernes && $viernes->aula ? $viernes->aula->aulaClave : null,
            'sabado' => $sabado ? "{$sabado->ghInicio}-{$sabado->ghFinal}" : null,
            'aula_sabado' => $sabado && $sabado->aula ? $sabado->aula->aulaClave : null,
            'num_credencial' => $empleado->empCredencial,
            'orden' => "{$programa->progClave}-" . (str_pad($grupo->gpoSemestre, 2, '0', STR_PAD_LEFT)) . "-{$grupo->gpoClave}",
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
    public function generarExcel($info_reporte, $grupos) {

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
        $sheet->mergeCells("A1:T1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:T2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Ubicacion");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Semestre");
        $sheet->setCellValueByColumnAndRow(4, 2, "Grupo");
        $sheet->setCellValueByColumnAndRow(5, 2, "Clave materia");
        $sheet->setCellValueByColumnAndRow(6, 2, "Materia");
        $sheet->setCellValueByColumnAndRow(7, 2, "Clave maestro");
        $sheet->setCellValueByColumnAndRow(8, 2, "Maestro");
        $sheet->setCellValueByColumnAndRow(9, 2, "Lunes");
        $sheet->setCellValueByColumnAndRow(10, 2, "Aula Lunes");
        $sheet->setCellValueByColumnAndRow(11, 2, "Martes");
        $sheet->setCellValueByColumnAndRow(12, 2, "Aula Martes");
        $sheet->setCellValueByColumnAndRow(13, 2, "Miércoles");
        $sheet->setCellValueByColumnAndRow(14, 2, "Aula Miércoles");
        $sheet->setCellValueByColumnAndRow(15, 2, "Jueves");
        $sheet->setCellValueByColumnAndRow(16, 2, "Aula Jueves");
        $sheet->setCellValueByColumnAndRow(17, 2, "Viernes");
        $sheet->setCellValueByColumnAndRow(18, 2, "Aula Viernes");
        $sheet->setCellValueByColumnAndRow(19, 2, "Sábado");
        $sheet->setCellValueByColumnAndRow(20, 2, "Aula Sábado");

        $fila = 3;
        foreach($grupos->sortBy('orden') as $grupo) {
            $sheet->setCellValue("A{$fila}", $grupo['ubiClave']);
            $sheet->setCellValue("B{$fila}", $grupo['progClave']);
            $sheet->setCellValueExplicit("C{$fila}", $grupo['gpoSemestre'], DataType::TYPE_STRING);
            $sheet->setCellValue("D{$fila}", $grupo['gpoClave']);
            $sheet->setCellValueExplicit("E{$fila}", $grupo['matClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("F{$fila}", $grupo['matNombre']);
            $sheet->setCellValueExplicit("G{$fila}", $grupo['empleado_id'], DataType::TYPE_STRING);
            $sheet->setCellValue("H{$fila}", $grupo['empleado_nombre']);
            $sheet->setCellValueExplicit("I{$fila}", $grupo['lunes'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$fila}", $grupo['aula_lunes'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("K{$fila}", $grupo['martes'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("L{$fila}", $grupo['aula_martes'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("M{$fila}", $grupo['miercoles'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("N{$fila}", $grupo['aula_miercoles'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("O{$fila}", $grupo['jueves'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("P{$fila}", $grupo['aula_jueves'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("Q{$fila}", $grupo['viernes'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("R{$fila}", $grupo['aula_viernes'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("S{$fila}", $grupo['sabado'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("T{$fila}", $grupo['aula_sabado'], DataType::TYPE_STRING);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("OcupacionDeAula.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("OcupacionDeAula.xlsx"));
    }
}

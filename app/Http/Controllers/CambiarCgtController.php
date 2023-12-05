<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Cgt;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Exception;

class CambiarCgtController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function vista() {

        return view('cambiar_cgt.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function realizar_cambio(Request $request) {

        $cgt_actual = Cgt::with('plan.programa')->findOrFail($request->cgt_id);
        $cgt_asignado = Cgt::findOrFail($request->cgt_asignado);

        if($cgt_actual->id == $cgt_asignado->id) {
            alert('No se realizó el cambio', 'Al parecer ha seleccionado el mismo CGT', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $cursosQueCambian = $cgt_actual->cursos()->whereIn('id', $request->cursos_ids)->get();
        $cursosNuevos = new Collection;
        
        DB::beginTransaction();
        try {
            $cursosQueCambian->each(static function($curso) use ($cgt_asignado, $cursosNuevos) {
                $replica = $curso->replicate();
                $replica->cgt_id = $cgt_asignado->id;

                $curso->delete();
                $replica->save();
                $cursosNuevos->push(self::info_esencial($replica));
            });
        } catch (Exception $e) {
            DB::rollBack();
            alert('Error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();

        $info_reporte = self::obtenerInfoReporte($request, $cgt_actual, $cgt_asignado);

        return $this->generarExcel($info_reporte, $cursosNuevos);
    }

    /**
     * @param App\Models\Curso
     */
    private static function info_esencial($curso) {
        $alumno = $curso->alumno;
        $nombreCompleto = $alumno->persona->nombreCompleto(true);

        return [
            'aluClave' => $alumno->aluClave,
            'aluMatricula' => $alumno->aluMatricula,
            'nombreCompleto' => $nombreCompleto,
            'curEstado' => $curso->curEstado,
            'orden' => $nombreCompleto,
        ];
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param App\Models\Cgt $cgt_actual
     * @param App\Models\Cgt $cgt_asignado
     */
    private static function obtenerInfoReporte($request, $cgt_actual, $cgt_asignado) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $plan = $cgt_actual->plan;
        $fechas_periodo = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'cgt_actual' => $cgt_actual,
            'cgt_asignado' => $cgt_asignado,
            'plan' => $plan,
            'programa' => $plan->programa,
            'periodo_descripcion' => "{$fechas_periodo} ({$periodo->perNumero}/{$periodo->perAnio})",
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $cursos) {

        $info_cgt_actual = "{$info_reporte['cgt_actual']->cgtGradoSemestre} - {$info_reporte['cgt_actual']->cgtGrupo} - {$info_reporte['cgt_actual']->cgtTurno}";
        $info_cgt_asignado = "{$info_reporte['cgt_asignado']->cgtGradoSemestre} - {$info_reporte['cgt_asignado']->cgtGrupo} - {$info_reporte['cgt_asignado']->cgtTurno}";
        $info_programa_plan = "{$info_reporte['programa']->progClave} ({$info_reporte['plan']->planClave}) {$info_reporte['programa']->progNombre}";

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $sheet->mergeCells("A1:D1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->mergeCells("A2:D2");
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('A2', "Cambio del CGT {$info_cgt_actual} al {$info_cgt_asignado} del programa {$info_programa_plan}");
        $sheet->getStyle("A3:D3")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 3, "Clave de pago");
        $sheet->setCellValueByColumnAndRow(2, 3, "Matrícula");
        $sheet->setCellValueByColumnAndRow(3, 3, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(4, 3, "Estado curso");

        $fila = 4;
        foreach($cursos->sortBy('orden') as $curso) {
            $sheet->setCellValueExplicit("A{$fila}", $curso['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$fila}", $curso['aluMatricula'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", $curso['nombreCompleto'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $curso['curEstado'], DataType::TYPE_STRING);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CambioDeCgtListaAlumnos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CambioDeCgtListaAlumnos.xlsx"))->deleteFileAfterSend(true);
    }
}

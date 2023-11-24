<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Curso;
use App\Http\Helpers\Utils;
use App\clases\cgts\MetodosCgt;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;

class MovimientoBecasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        return view('reportes/movimiento_becas.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
        ]);
    }

    public function imprimir(Request $request)
    {
        $cursos = new Collection; 
        self::buscarCursos($request)
        ->chunk(150, static function($registros) use ($cursos) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($curso) use ($cursos) {
                $cursos->push(self::info_esencial($curso));
            });
        });

        if($cursos->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $cursos);
    }

    /**
     * @param Illuminate\Http\Request $request
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
     * @param Illuminate\Http\Request
     */
    private static function buscarCursos($request)
    {
        return Curso::with(['alumno.persona', 'cgt.plan.programa.escuela', 'becas_historial.usuario'])
        ->where('periodo_id', $request->periodo_id)
        ->whereHas('alumno', static function($query) use ($request) {
            if($request->aluClave)
                $query->where('aluClave', $request->aluClave);
        })
        ->whereHas('cgt.plan.programa', static function($query) use ($request) {
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->semestre)
                $query->where('cgtGradoSemestre', $request->semestre);
            if($request->grupo)
                $query->where('cgtGrupo', $request->grupo);
        })
        ->whereHas('becas_historial', static function($query) use ($request) {
            if($request->fecha1)
                $query->whereDate('fecha_cambio', '>=', $request->fecha1);
            if($request->fecha2)
                $query->whereDate('fecha_cambio', '<=', $request->fecha2);
        });
    }

    /**
     * @param App\Models\Curso
     */
    private static function info_esencial($curso) 
    {
        $alumno = $curso->alumno;
        $nombreCompleto = $alumno->persona->nombreCompleto(true);
        $cgt = $curso->cgt;
        $plan = $cgt->plan;
        $programa = $plan->programa;
        $escuela = $programa->escuela;
        $cgt_orden = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);

        return [
            'aluClave' => $alumno->aluClave,
            'nombreCompleto' => $nombreCompleto,
            'grado' => $cgt->cgtGradoSemestre,
            'grupo' => $cgt->cgtGrupo,
            'planClave' => $plan->planClave,
            'progClave' => $programa->progClave,
            'escClave' => $escuela->escClave,
            'becas_historial' => self::mapearHistorialBecas($curso->becas_historial),
            'orden' => $escuela->escClave . $programa->progClave . $cgt_orden . $nombreCompleto,
        ];
    }

    /**
     * @param Illuminate\Support\Collection $becasHistorial
     */
    private static function mapearHistorialBecas($becasHistorial)
    {
        return $becasHistorial->map(static function($historial) {

            return [
                'tipo' => $historial->tipo,
                'porcentaje' => $historial->porcentaje,
                'observaciones' => $historial->observaciones,
                'fecha_cambio' => $historial->fecha_cambio,
                'username' => $historial->usuario->username,
            ];
        })->sortByDesc('fecha_cambio');
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection $cursos
     */
    public function generarExcel($info_reporte, $cursos) {

        $ubicacion = $info_reporte['ubicacion'];
        $departamento = $info_reporte['departamento'];
        $periodo = $info_reporte['periodo_descripcion'];

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

        $sheet->mergeCells("A1:L1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} - {$departamento->depClave} - {$periodo}");

        $sheet->getStyle("A2:L2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(4, 2, "Clave de pago");
        $sheet->setCellValueByColumnAndRow(5, 2, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(6, 2, "grado");
        $sheet->setCellValueByColumnAndRow(7, 2, "grupo");
        $sheet->setCellValueByColumnAndRow(8, 2, "Beca");
        $sheet->setCellValueByColumnAndRow(9, 2, "Porcentaje");
        $sheet->setCellValueByColumnAndRow(10, 2, "Observaciones");
        $sheet->setCellValueByColumnAndRow(11, 2, "Fecha de cambio");
        $sheet->setCellValueByColumnAndRow(12, 2, "Hizo el cambio");

        $fila = 3;
        foreach($cursos->sortBy('orden') as $alumno) {
            foreach($alumno['becas_historial'] as $historial) {
                $sheet->setCellValueExplicit("A{$fila}", $alumno['escClave'], DataType::TYPE_STRING);
                $sheet->setCellValue("B{$fila}", $alumno['progClave']);
                $sheet->setCellValue("C{$fila}", $alumno['planClave']);
                $sheet->setCellValue("D{$fila}", $alumno['aluClave']);
                $sheet->setCellValue("E{$fila}", $alumno['nombreCompleto']);
                $sheet->setCellValue("F{$fila}", $alumno['grado']);
                $sheet->setCellValue("G{$fila}", $alumno['grupo']);
                $sheet->setCellValue("H{$fila}", $historial['tipo']);
                $sheet->setCellValue("I{$fila}", $historial['porcentaje']);
                $sheet->setCellValue("J{$fila}", $historial['observaciones']);
                $sheet->setCellValue("K{$fila}", $historial['fecha_cambio']);
                $sheet->setCellValue("L{$fila}", $historial['username']);
                $fila++;
            }
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("MovimientoDeBecas.xlsx"));
        } catch (Exception $e) {
            throw $e;
        }

        return response()->download(storage_path('MovimientoDeBecas.xlsx'));
    }
}

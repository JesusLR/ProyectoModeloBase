<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Extraordinario;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ResumenInscritosExtraordinarioController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'permisos:menu_reportes_extraordinarios', 'permisos:resumen_inscritos_extraordinario']);
    }

    public function reporte() {

        return view('reportes/resumen_inscritos_extraordinario.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {
        
        if(!self::buscarInscritosExtraordinario($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $extras_censados = new Collection;
        self::buscarInscritosExtraordinario($request)
        ->chunk(150, static function($registros) use ($extras_censados) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($extraordinario) use ($extras_censados) {
                $info = self::info_esencial($extraordinario);

                if($registro = $extras_censados->get($info['key'])) {
                    /**
                     * Si existe un registro en la collection de escClave-progClave-planClave, lo actualiza.
                     * Si no, en el else agrega el registro de esa key.
                     */
                    $registro['inscritos'] = $registro['inscritos']->merge($info['inscritos'])->unique();
                    $registro['preinscritos'] += $info['preinscritos'];
                    $extras_censados[$info['key']] = $registro;
                } else {
                    $extras_censados->put($info['key'], $info);
                }
            });
        });

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $extras_censados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    public static function buscarInscritosExtraordinario($request) {

        return Extraordinario::with(['materia.plan.programa.escuela', 'inscritos', 'preinscritos'])
        ->whereHas('materia.plan.programa', static function($query) use ($request) {
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('periodo', static function($query) use ($request) {
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
        })
        ->where(static function($query) {
            $query->has('inscritos')->orHas('preinscritos');
        });
    }

    /**
     * @param App\Http\Models\Extraordinario
     */
    private static function info_esencial($extraordinario) {
        $plan = $extraordinario->materia->plan;
        $programa = $plan->programa;
        $escuela = $programa->escuela;

        return [
            'planClave' => $plan->planClave,
            'progClave' => $programa->progClave,
            'escClave' => $escuela->escClave,
            'inscritos' => $extraordinario->inscritos->pluck('alumno_id')->unique(),
            'preinscritos' => $extraordinario->preinscritos->count(),
            'key' => "{$escuela->escClave}-{$programa->progClave}-{$plan->planClave}",
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;

        return [
            'periodo' => "{$periodo->perNumero}/{$periodo->perAnio}",
            'departamento' => "{$departamento->depClave} {$departamento->depNombre}",
            'ubicacion' => "{$ubicacion->ubiClave} {$ubicacion->ubiNombre}",
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection $extras_censados
     */
    public function generarExcel($info_reporte, $extras_censados) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->mergeCells("A1:E1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']} - {$info_reporte['departamento']} - {$info_reporte['periodo']}");
        $sheet->getStyle("A2:E2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(3, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(4, 2, "Inscritos");
        $sheet->setCellValueByColumnAndRow(5, 2, "Solicitudes");

        $fila = 3;
        foreach($extras_censados->sortKeys() as $programa) {
            $sheet->setCellValue("A{$fila}", $programa['escClave']);
            $sheet->setCellValue("B{$fila}", $programa['progClave']);
            $sheet->setCellValueExplicit("C{$fila}", $programa['planClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("D{$fila}", $programa['inscritos']->count());
            $sheet->setCellValue("E{$fila}", $programa['preinscritos']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ResumenInscritosExtraordinarios.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ResumenInscritosExtraordinarios.xlsx"));
    }
}

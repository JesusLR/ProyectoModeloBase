<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_extraordinarios;
use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Extraordinario;

use Carbon\Carbon;
use Exception;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class BachillerResumenInscritosExtraordinarioController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth']);
    }

    public function reporte() {

        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        return view('bachiller.reportes.resumen_inscritos_extraordinario.create', [
            'ubicaciones' => $ubicaciones
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
                    $registro['bachiller_inscritos'] = $registro['bachiller_inscritos']->merge($info['bachiller_inscritos'])->unique();
                    $registro['bachiller_preinscritos'] += $info['bachiller_preinscritos'];
                    $extras_censados[$info['key']] = $registro;
                } else {
                    $extras_censados->put($info['key'], $info);
                }
            });
        });

       

        $info_reporte = self::obtenerInfoReporte($request);

        if($request->tipoReporte == 1){
            return $this->generarExcel($info_reporte, $extras_censados);
        }
        
        if($request->tipoReporte == 2){

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');

            $fechaHoy = $fechaActual->format('d').'/'.Utils::num_meses_corto_string($fechaActual->format('m')).'/'.$fechaActual->format('Y');
            
            $parametro_NombreArchivo = 'resumen_inscritos_recuperativos';
            $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_inscritos_recuperativos.' . $parametro_NombreArchivo, [
                "info_reporte" => $info_reporte,
                "extras_censados" => $extras_censados,
                "fechaHoy" => $fechaHoy,
                "fechaActual" => $fechaActual
            ]);

            // $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }

    /**
     * @param Illuminate\Http\Request
     */
    public static function buscarInscritosExtraordinario($request) {

        return Bachiller_extraordinarios::with(['bachiller_materia.plan.programa.escuela', 'bachiller_inscritos', 'bachiller_preinscritos'])
        ->whereHas('bachiller_materia.plan.programa', static function($query) use ($request) {
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('bachiller_materia', static function($query) use ($request) {
            if($request->matClave)
                $query->where('matClave', $request->matClave);
        })
        ->whereHas('periodo', static function($query) use ($request) {
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
        })
        ->where(static function($query) {
            $query->has('bachiller_inscritos')->orHas('bachiller_preinscritos');
        })
        
        ->where(static function($query) use ($request) {
            if($request->folio)
                $query->where('id', $request->folio);

            if($request->extFecha)
                $query->where('extFecha', $request->extFecha);
        });
    }

    /**
     * @param App\Models\Extraordinario
     */
    private static function info_esencial($extraordinario) {
        $plan = $extraordinario->bachiller_materia->plan;
        $programa = $plan->programa;
        $escuela = $programa->escuela;    

        return [
            'planClave' => $plan->planClave,
            'progClave' => $programa->progClave,
            'escClave' => $escuela->escClave,
            'bachiller_inscritos' => $extraordinario->bachiller_inscritos->pluck('alumno_id')->unique(),
            'bachiller_preinscritos' => $extraordinario->bachiller_preinscritos->count(),
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
            $sheet->setCellValue("D{$fila}", $programa['bachiller_inscritos']->count());
            $sheet->setCellValue("E{$fila}", $programa['bachiller_preinscritos']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("Bachiller_ResumenInscritosExtraordinarios.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("Bachiller_ResumenInscritosExtraordinarios.xlsx"));
    }
}

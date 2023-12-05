<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\ServicioSocial;
use App\Models\Curso;
use App\Http\Helpers\Utils;
use App\clases\serviciosocial\MetodosServicioSocial;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ConteoServicioSocialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function reporte()
    {
        return view('reportes/conteo_servicio_social.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'clasificaciones' => MetodosServicioSocial::clasificaciones(),
        ]);
    }

    public function imprimir(Request $request)
    {
        $servicios = self::buscarServiciosSociales($request);
        
        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $servicios);
    }

    private static function buscarServiciosSociales($request)
    {
        $cursos = Curso::select('cursos.id AS curso_id', 'cursos.alumno_id AS curso_alumno_id', 
            'programas.id AS programa_id', 'programas.escuela_id', 'periodos.id AS periodo_id', 'periodos.perNumero', 'periodos.perAnio'
        )
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->join('planes', 'planes.id', 'cgt.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('periodos', 'periodos.id', 'cursos.periodo_id');

        return ServicioSocial::select('serviciosocial.ssClasificacion', 'serviciosocial.progClave', 
            DB::raw("CONCAT(serviciosocial.progClave, '-', serviciosocial.ssClasificacion) AS programa_clasificacion")
        )
        ->joinSub($cursos, 'cursos_query', static function($join) {
            $join->on('serviciosocial.alumno_id', 'cursos_query.curso_alumno_id')
                ->on('serviciosocial.ssNumeroPeriodoInicio', 'cursos_query.perNumero')
                ->on('serviciosocial.ssAnioPeriodoInicio', 'cursos_query.perAnio');
        })
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->ssClasificacion)
                $query->where('ssClasificacion', $request->ssClasificacion);
        })->get();
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
    public function generarExcel($info_reporte, $servicios) {

        $claves_programas = $servicios->keyBy('progClave')->sortKeys()->keys();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $sheet->mergeCells("A1:G1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:G2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(2, 2, "Público Federal");
        $sheet->setCellValueByColumnAndRow(3, 2, "Público Estatal");
        $sheet->setCellValueByColumnAndRow(4, 2, "Público Municipal");
        $sheet->setCellValueByColumnAndRow(5, 2, "Modelo");
        $sheet->setCellValueByColumnAndRow(6, 2, "Social");
        $sheet->setCellValueByColumnAndRow(7, 2, "Total");

        $fila = 3;
        foreach($claves_programas as $progClave) {
            $sheet->setCellValue("A{$fila}", $progClave);
            $sheet->setCellValue("B{$fila}", self::realizar_conteo($servicios, $progClave, 'F'));
            $sheet->setCellValue("C{$fila}", self::realizar_conteo($servicios, $progClave, 'E'));
            $sheet->setCellValue("D{$fila}", self::realizar_conteo($servicios, $progClave, 'P'));
            $sheet->setCellValue("E{$fila}", self::realizar_conteo($servicios, $progClave, 'M'));
            $sheet->setCellValue("F{$fila}", self::realizar_conteo($servicios, $progClave, 'S'));
            $sheet->setCellValue("G{$fila}", self::realizar_conteo($servicios, $progClave)); # Total por escuela
            $fila++;
        }

        # Totales por clasificación
        $sheet->setCellValue("A{$fila}", "Total");
        $sheet->setCellValue("B{$fila}", self::realizar_conteo($servicios, null, 'F'));
        $sheet->setCellValue("C{$fila}", self::realizar_conteo($servicios, null, 'E'));
        $sheet->setCellValue("D{$fila}", self::realizar_conteo($servicios, null, 'P'));
        $sheet->setCellValue("E{$fila}", self::realizar_conteo($servicios, null, 'M'));
        $sheet->setCellValue("F{$fila}", self::realizar_conteo($servicios, null, 'S'));
        $sheet->setCellValue("G{$fila}", self::realizar_conteo($servicios)); #Total general

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ListaServicioSocial.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ListaServicioSocial.xlsx"));
    }

    /**
     * @param Illuminate\Support\Collection $servicios
     * @param string $progClave
     * @param string $clasificacion
     */
    private static function realizar_conteo($servicios, $progClave = null, $clasificacion = null): int 
    {
        $filtrado = new Collection;
        if($progClave && $clasificacion) {
            $filtrado = $servicios->groupBy('programa_clasificacion')->get("{$progClave}-{$clasificacion}");
        } elseif ($progClave && !$clasificacion) {
            $filtrado = $servicios->groupBy('progClave')->get($progClave);
        } elseif($clasificacion && !$progClave) {
            $filtrado = $servicios->groupBy('ssClasificacion')->get($clasificacion);
        } else {
            return $servicios->count();
        }

        return $filtrado ? $filtrado->count() : 0;
    }
}

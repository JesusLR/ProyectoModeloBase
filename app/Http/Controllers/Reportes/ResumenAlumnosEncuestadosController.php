<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Curso;
use App\Http\Helpers\Utils;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ResumenAlumnosEncuestadosController extends Controller
{

    public function __construct() {
        $this->middleware(['auth', 'permisos:resumen_alumnos_encuestados']);
    }

    public function reporte() {
        return view('reportes/resumen_alumnos_encuestados.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {
        $cursos = new Collection;
        self::buscarCursos($request)
        ->chunk(200, static function($registros) use ($cursos) {
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

        $info = $this->obtenerInfoReporte($request, $cursos);
        $agrupados = $this->agrupar_contabilizar_por($cursos, 'escClave');


        return $request->formato == 'PDF' ? $this->generarPDF($info, $agrupados) : $this->generarExcel($info, $agrupados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarCursos($request) {

        return Curso::with(['cgt.plan.programa.escuela'])->select('cursos.*', 'validaencuesta.encValidado')
        ->join('validaencuesta', 'validaencuesta.alumno_id', 'cursos.alumno_id')
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->encValidado != '*') {
                $query->where('validaencuesta.encValidado', $request->encValidado);
            }
        })
        ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->cgtGradoSemestre)
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
            if($request->cgtGrupo)
                $query->where('cgtGrupo', $request->cgtGrupo);
        });
    }

    /**
     * @param App\Models\Curso
     */
    private static function info_esencial($curso): array {
        $cgt = $curso->cgt;
        $programa = $cgt->plan->programa;

        return [
            'escClave' => $programa->escuela->escClave,
            'progClave' => $programa->progClave,
            'grado' => $cgt->cgtGradoSemestre,
            'encValidado' => $curso->encValidado ?: 'X',
            'clave_conteo' => ($curso->encValidado ?: 'X') . '-' . $cgt->cgtGradoSemestre, #clasifica los conteos para tabla del reporte.
        ];
    }

    /**
     * @param Illuminate\Support\Collection
     * @param string $agrupacion
     */
    private function agrupar_contabilizar_por($cursos, $agrupacion) {
        $grupo_siguiente = $agrupacion == 'escClave' ? 'progClave' : null;

        return $cursos->groupBy($agrupacion)
        ->map(function($cursos_agrupados, $key) use ($agrupacion, $grupo_siguiente) {
            
            $encuestados = $cursos_agrupados->groupBy('clave_conteo')
            ->map(static function($cursos_clave, $clave) {
                return $cursos_clave->count();
            });

            return collect([
                $agrupacion => $key,
                'grupo_siguiente' => $grupo_siguiente ? $this->agrupar_contabilizar_por($cursos_agrupados, $grupo_siguiente) : null,
            ])->merge($encuestados);
        })->sortKeys();
    }

    /**
     * @param Illuminate\Http\Request
     * @param Illuminate\Support\Collection
     */
    private function obtenerInfoReporte($request, $cursos) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $periodo_fechas = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');
        $hoy = Carbon::now('America/Merida');

        return [
            'fechaActual' => $hoy->format('d/m/Y'),
            'horaActual' => $hoy->format('H:i:s'),
            'periodo' => $periodo_fechas . " ({$periodo->perNumero}/{$periodo->perAnio})",
            'ubicacion' => $periodo->departamento->ubicacion,
            'semestres_filtrados' => $cursos->keyBy('grado')->sortKeys()->keys(),
            'nombreArchivo' =>'pdf_resumen_alumnos_encuestados',
        ];
    }

    /**
     * @param array $infoReporte
     * @param Illuminate\Support\Collection $cursos
     */
    private function generarPDF($infoReporte, Collection $cursos) {
        $infoReporte['datos'] = $cursos;

        return PDF::loadView("reportes.pdf.{$infoReporte['nombreArchivo']}", $infoReporte)
        ->stream($infoReporte['nombreArchivo'] . '.pdf');
    }

    /**
     * @param array
     * @param Illuminate\Support\Collection $cursos
     */
    private function generarExcel($infoReporte, Collection $cursos) {

        $ubicacion = $infoReporte['ubicacion'];
        $semestres = $infoReporte['semestres_filtrados'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} {$ubicacion->ubiNombre}          {$infoReporte['periodo']}");
        $sheet->getStyle('A2:O2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue("A2", "Programa");
        $sheet->setCellValue("A3", "Validado");

        $columnaInicial = 'B';
        foreach($semestres as $semestre) {
            $columnaSiguiente = chr(ord($columnaInicial) + 1);
            $sheet->mergeCells("{$columnaInicial}2:{$columnaSiguiente}2");
            $sheet->getStyle("{$columnaInicial}2")->getFont()->setBold(true);
            $sheet->getStyle("{$columnaInicial}3:{$columnaSiguiente}3")->getFont()->setBold(true);
            $sheet->setCellValue("{$columnaInicial}2", "{$semestre}° Semestre");
            $sheet->setCellValue("{$columnaInicial}3", "S");
            $sheet->setCellValue("{$columnaSiguiente}3", "N");
            $columnaInicial = chr(ord($columnaSiguiente) + 1);
        }

        $fila = 4;
        foreach ($cursos as $key => $escuela) {

            foreach($escuela['grupo_siguiente'] as $programa) {
                $sheet->setCellValue("A{$fila}", "{$escuela['escClave']}-{$programa['progClave']}");
                $columnaInicial = 'B';
                foreach($semestres as $semestre) {
                    $sheet->setCellValue("{$columnaInicial}{$fila}", ($programa->get("S-{$semestre}") ?: 0));
                    $sheet->setCellValue((++$columnaInicial) . "{$fila}", ($programa->get("N-{$semestre}") ?: 0));
                    $columnaInicial++;
                }
                $fila++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ResumenAlumnosEncuestados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ResumenAlumnosEncuestados.xlsx"));
    }
}

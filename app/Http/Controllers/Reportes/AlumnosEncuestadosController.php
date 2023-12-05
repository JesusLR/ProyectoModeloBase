<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Curso;
use App\clases\cgts\MetodosCgt;
use App\Http\Helpers\Utils;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class AlumnosEncuestadosController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'permisos:alumnos_encuestados']);
    }

    public function reporte() {

        return view('reportes/alumnos_encuestados.create', [
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

        $info = self::obtenerInfoReporte($request);

        return $request->formato == 'PDF' ? $this->generarPDF($info, $cursos) : $this->generarExcel($info, $cursos);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarCursos($request) {

        return Curso::with(['cgt.plan.programa', 'alumno.persona'])->select('cursos.*', 'validaencuesta.encValidado')
        ->leftJoin('validaencuesta', 'validaencuesta.alumno_id', 'cursos.alumno_id')
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->encValidado) {
                if($request->encValidado != '*')
                    $query->where('validaencuesta.encValidado', $request->encValidado);
            } else {
                $query->whereNull('validaencuesta.id');
            }
        })
        ->whereHas('cgt.plan.programa', static function($query) use ($request) {
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
        $alumno = $curso->alumno;
        $persona = $alumno->persona;
        $cgt = $curso->cgt;
        $plan = $cgt->plan;
        $programa = $plan->programa;
        $ordenCgt = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);

        return [
            'aluClave' => $alumno->aluClave,
            'perCurp' => $persona->perCurp,
            'nombreCompleto' => $persona->nombreCompleto(true),
            'progClave' => $programa->progClave,
            'progNombre' => $programa->progNombre,
            'planClave' => $plan->planClave,
            'grado' => $cgt->cgtGradoSemestre,
            'grupo' => $cgt->cgtGrupo,
            'encValidado' => $curso->encValidado ?: 'X',
            'orden' => "{$programa->progClave}-{$ordenCgt}-{$persona->nombreCompleto(true)}", 
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $periodo_fechas = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');
        $hoy = Carbon::now('America/Merida');

        return [
            'fechaActual' => $hoy->format('d/m/Y'),
            'horaActual' => $hoy->format('H:i:s'),
            'periodo' => $periodo_fechas . " ({$periodo->perNumero}/{$periodo->perAnio})",
            'ubicacion' => $periodo->departamento->ubicacion,
            'nombreArchivo' =>'pdf_alumnos_encuestados',
        ];
    }

    /**
     * @param array $infoReporte
     * @param Illuminate\Support\Collection $cursos
     */
    private function generarPDF($infoReporte, Collection $cursos) {
        $infoReporte['datos'] = $cursos->sortBy('orden')->groupBy(['progClave', 'grado']);

        return PDF::loadView("reportes.pdf.{$infoReporte['nombreArchivo']}", $infoReporte)
        ->stream($infoReporte['nombreArchivo'] . '.pdf');
    }

    /**
     * @param array
     * @param Illuminate\Support\Collection $cursos
     */
    private function generarExcel($infoReporte, Collection $cursos) {

        $ubicacion = $infoReporte['ubicacion'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} {$ubicacion->ubiNombre}          {$infoReporte['periodo']}");
        $sheet->getStyle('A2:G2')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(2, 2, "Curp");
        $sheet->setCellValueByColumnAndRow(3, 2, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(4, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(5, 2, "Grado");
        $sheet->setCellValueByColumnAndRow(6, 2, "Grupo");
        $sheet->setCellValueByColumnAndRow(7, 2, "Encuesta");

        $fila = 3;
        foreach ($cursos->sortBy('orden') as $key => $curso) {
            $sheet->setCellValueExplicit("A{$fila}", $curso['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $curso['perCurp']);
            $sheet->setCellValue("C{$fila}", $curso['nombreCompleto']);
            $sheet->setCellValue("D{$fila}", $curso['progClave']);
            $sheet->setCellValue("E{$fila}", $curso['grado']);
            $sheet->setCellValue("F{$fila}", $curso['grupo']);
            $sheet->setCellValue("G{$fila}", $curso['encValidado']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("AlumnosEncuestados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("AlumnosEncuestados.xlsx"));
    }
}

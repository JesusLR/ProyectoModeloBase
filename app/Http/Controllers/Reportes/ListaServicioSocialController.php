<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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

class ListaServicioSocialController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'permisos:lista_servicio_social']);
    }

    public function reporte() {

        return view('reportes/lista_servicio_social.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'clasificaciones' => MetodosServicioSocial::clasificaciones(),
        ]);
    }

    public function imprimir(Request $request) {
        
        if(!self::buscarServiciosSociales($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $servicios = new Collection;
        self::buscarServiciosSociales($request)
        ->chunk(150, static function($registros) use ($servicios) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($servicio) use ($servicios) {
                $servicios->push(self::info_esencial($servicio));
            });
        });

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $servicios);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarServiciosSociales($request) {
        $cursos = Curso::select('cursos.id AS curso_id', 'cursos.alumno_id AS curso_alumno_id', 'cgt.id AS cgt_id', 'cgt.cgtGradoSemestre AS grado',
            'programas.id AS programa_id', 'programas.progClave', 'periodos.id AS periodo_id', 'periodos.perNumero', 'periodos.perAnio'
        )
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->join('planes', 'planes.id', 'cgt.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('periodos', 'periodos.id', 'cursos.periodo_id');

        return ServicioSocial::with(['alumno.persona'])->select('serviciosocial.*', 'cursos_query.*')
        ->joinSub($cursos, 'cursos_query', static function($join) {
            $join->on('serviciosocial.alumno_id', 'cursos_query.curso_alumno_id')
                ->on('serviciosocial.ssNumeroPeriodoInicio', 'cursos_query.perNumero')
                ->on('serviciosocial.ssAnioPeriodoInicio', 'cursos_query.perAnio');
        })
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->ssClasificacion)
                $query->where('ssClasificacion', $request->ssClasificacion);
        });
    }

    /**
     * @param App\Models\ServicioSocial
     */
    private static function info_esencial($servicio) {
        $alumno = $servicio->alumno;
        $nombreCompleto = $alumno->persona->nombreCompleto(true);

        return [
            'folio' => $servicio->id,
            'aluClave' => $alumno->aluClave,
            'nombreCompleto' => $nombreCompleto,
            'progClave' => $servicio->progClave,
            'grado' => $servicio->grado,
            'ssEstadoActual' => $servicio->ssEstadoActual,
            'ssFechaInicio' => $servicio->ssFechaInicio,
            'ssNumeroAsignacion' => $servicio->ssNumeroAsignacion,
            'ssLugar' => $servicio->ssLugar,
            'ssFechaLiberacion' => $servicio->ssFechaLiberacion,
            'ssClasificacion' => MetodosServicioSocial::describirClasificacion($servicio->ssClasificacion),
            'orden' => $servicio->progClave . '-' . $nombreCompleto,
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
    public function generarExcel($info_reporte, $servicios) {

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
        $sheet->mergeCells("A1:J1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:J2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Clave de pago");
        $sheet->setCellValueByColumnAndRow(2, 2, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(3, 2, "Carrera");
        $sheet->setCellValueByColumnAndRow(4, 2, "Grado");
        $sheet->setCellValueByColumnAndRow(5, 2, "Estado");
        $sheet->setCellValueByColumnAndRow(6, 2, "Fecha inicio");
        $sheet->setCellValueByColumnAndRow(7, 2, "Num. asignación");
        $sheet->setCellValueByColumnAndRow(8, 2, "Lugar de realización");
        $sheet->setCellValueByColumnAndRow(9, 2, "Fecha liberación");
        $sheet->setCellValueByColumnAndRow(10, 2, "Clasificación");

        $fila = 3;
        foreach($servicios->sortBy('orden') as $servicio) {
            $sheet->setCellValueExplicit("A{$fila}", $servicio['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $servicio['nombreCompleto']);
            $sheet->setCellValue("C{$fila}", $servicio['progClave']);
            $sheet->setCellValue("D{$fila}", $servicio['grado']);
            $sheet->setCellValue("E{$fila}", $servicio['ssEstadoActual']);
            $sheet->setCellValue("F{$fila}", $servicio['ssFechaInicio']);
            $sheet->setCellValueExplicit("G{$fila}", $servicio['ssNumeroAsignacion'], DataType::TYPE_STRING);
            $sheet->setCellValue("H{$fila}", $servicio['ssLugar']);
            $sheet->setCellValue("I{$fila}", $servicio['ssFechaLiberacion']);
            $sheet->setCellValue("J{$fila}", $servicio['ssClasificacion']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ListaServicioSocial.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ListaServicioSocial.xlsx"));
    }
}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Empleado;
use App\Http\Helpers\Utils;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ResumenDocentesEncuestadosController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'permisos:resumen_docentes_encuestados']);
    }

    public function reporte() {
        return view('reportes/resumen_docentes_encuestados.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {
        $empleados = new Collection;
        self::buscarEmpleados($request)
        ->chunk(200, static function($registros) use ($empleados) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($empleado) use ($empleados) {
                $empleados->push(self::info_esencial($empleado));
            });
        });

        if($empleados->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $info = $this->obtenerInfoReporte($request, $empleados);
        $agrupados = $this->agruparContabilizarPorEscuela($empleados);
        return $request->formato == 'PDF' ? $this->generarPDF($info, $agrupados) : $this->generarExcel($info, $agrupados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarEmpleados($request) {
        return Empleado::with('escuela')->select('empleados.*', 'validaencuestadocente.encValidado')
        ->join('validaencuestadocente', 'validaencuestadocente.empleado_id', 'empleados.id')
        ->where(static function($query) use ($request) {
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->encValidado != '*') {
                $query->where('validaencuestadocente.encValidado', $request->encValidado);
            }
        })
        ->whereHas('escuela',static function($query) use ($request) {
            $query->where('departamento_id', $request->departamento_id);
        });
    }

    /**
     * @param App\Http\Models\Empleado
     */
    private static function info_esencial($empleado): array {
        $escuela = $empleado->escuela;

        return [
            'escClave' => $escuela->escClave,
            'escNombre' => $escuela->escNombre,
            'encValidado' => $empleado->encValidado ?: 'X',
        ];
    }

    /**
     * @param Illuminate\Support\Collection
     */
    private function agruparContabilizarPorEscuela($empleados) {

        return $empleados->groupBy('escClave')
        ->map(function($empleados_agrupados, $key) {
            $info = $empleados_agrupados->first();

            $encuestados = $empleados_agrupados->groupBy('encValidado')
            ->map(static function($empleados_clave, $clave) {
                return $empleados_clave->count();
            });

            return collect([
                'escClave' => $info['escClave'],
                'escNombre' => $info['escNombre'],
            ])->merge($encuestados);
        })->sortKeys();
    }

    /**
     * @param Illuminate\Http\Request
     */
    private function obtenerInfoReporte($request) {
        $departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);
        $hoy = Carbon::now('America/Merida');

        return [
            'fechaActual' => $hoy->format('d/m/Y'),
            'horaActual' => $hoy->format('H:i:s'),
            'departamento' => $departamento,
            'ubicacion' => $departamento->ubicacion,
            'nombreArchivo' =>'pdf_resumen_docentes_encuestados',
        ];
    }

    /**
     * @param array $infoReporte
     * @param Illuminate\Support\Collection $empleados
     */
    private function generarPDF($infoReporte, Collection $empleados) {
        $infoReporte['datos'] = $empleados;

        return PDF::loadView("reportes.pdf.{$infoReporte['nombreArchivo']}", $infoReporte)
        ->stream($infoReporte['nombreArchivo'] . '.pdf');
    }

    /**
     * @param array
     * @param Illuminate\Support\Collection $escuelas
     */
    private function generarExcel($infoReporte, Collection $escuelas) {

        $ubicacion = $infoReporte['ubicacion'];
        $departamento = $infoReporte['departamento'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} - {$ubicacion->ubiNombre}    {$departamento->depClave} - {$departamento->depNombre}");
        $sheet->getStyle('A2:D2')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue("A2", "Escuela");
        $sheet->setCellValue("B2", "Si");
        $sheet->setCellValue("C2", "No");
        $sheet->setCellValue("D2", "Total");

        $fila = 3;
        foreach ($escuelas as $escuela) {
            $total_S = $escuela->get("S") ?: 0;
            $total_N = $escuela->get("N") ?: 0;

            $sheet->setCellValue("A{$fila}", "{$escuela['escClave']} - {$escuela['escNombre']}");
            $sheet->setCellValue("B{$fila}", $total_S);
            $sheet->setCellValue("C{$fila}", $total_N);
            $sheet->setCellValue("D{$fila}", $total_S + $total_N);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ResumenDocentesEncuestados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ResumenDocentesEncuestados.xlsx"));
    }
}

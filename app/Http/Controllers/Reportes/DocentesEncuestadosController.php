<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Empleado;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class DocentesEncuestadosController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'permisos:docentes_encuestados']);
    }

    public function reporte() {

        return view('reportes/docentes_encuestados.create', [
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

        $info = self::obtenerInfoReporte($request);

        return $request->formato == 'PDF' ? $this->generarPDF($info, $empleados) : $this->generarExcel($info, $empleados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarEmpleados($request) {

        return Empleado::with(['escuela', 'persona'])->select('empleados.*', 'validaencuestadocente.encValidado')
        ->join('validaencuestadocente', 'validaencuestadocente.empleado_id', 'empleados.id')
        ->where(static function($query) use ($request) {
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->encValidado) {
                $query->where('validaencuestadocente.encValidado', $request->encValidado);
            } else {
                $query->whereIn('validaencuestadocente.encValidado', ['S', 'N']);
            }
        })
        ->whereHas('escuela', static function($query) use ($request) {
            $query->where('departamento_id', $request->departamento_id);
        });
    }

    /**
     * @param App\Models\Empleado
     */
    private static function info_esencial($empleado): array {
        $persona = $empleado->persona;
        $escuela = $empleado->escuela;

        return [
            'empleado_id' => $empleado->id,
            'empCredencial' => $empleado->empCredencial,
            'nombreCompleto' => $persona->nombreCompleto(true),
            'escClave' => $escuela->escClave,
            'escNombre' => $escuela->escNombre,
            'encValidado' => $empleado->encValidado ?: 'X',
            'orden' => "{$escuela->escClave}-{$persona->nombreCompleto(true)}", 
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);
        $hoy = Carbon::now('America/Merida');

        return [
            'fechaActual' => $hoy->format('d/m/Y'),
            'horaActual' => $hoy->format('H:i:s'),
            'departamento' => $departamento,
            'ubicacion' => $departamento->ubicacion,
            'nombreArchivo' =>'pdf_docentes_encuestados',
        ];
    }

    /**
     * @param array $infoReporte
     * @param Illuminate\Support\Collection $empleados
     */
    private function generarPDF($infoReporte, Collection $empleados) {
        $infoReporte['datos'] = $empleados->sortBy('orden')->groupBy(['escClave'])->sortKeys();

        return PDF::loadView("reportes.pdf.{$infoReporte['nombreArchivo']}", $infoReporte)
        ->stream($infoReporte['nombreArchivo'] . '.pdf');
    }

    /**
     * @param array
     * @param Illuminate\Support\Collection $empleados
     */
    private function generarExcel($infoReporte, Collection $empleados) {

        $ubicacion = $infoReporte['ubicacion'];
        $departamento = $infoReporte['departamento'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} - {$ubicacion->ubiNombre}     {$departamento->depClave} - {$departamento->depNombre}");
        $sheet->getStyle('A2:E2')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "No. Empleado");
        $sheet->setCellValueByColumnAndRow(3, 2, "Credencial");
        $sheet->setCellValueByColumnAndRow(4, 2, "Nombre");
        $sheet->setCellValueByColumnAndRow(5, 2, "Encuesta");

        $fila = 3;
        foreach ($empleados->sortBy('orden') as $key => $empleado) {
            $sheet->setCellValue("A{$fila}", $empleado['escClave']);
            $sheet->setCellValueExplicit("B{$fila}", $empleado['empleado_id'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", $empleado['empCredencial'], DataType::TYPE_STRING);
            $sheet->setCellValue("D{$fila}", $empleado['nombreCompleto']);
            $sheet->setCellValue("E{$fila}", $empleado['encValidado']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("DocentesEncuestados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("DocentesEncuestados.xlsx"));
    }
}

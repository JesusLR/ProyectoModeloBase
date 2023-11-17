<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Empleado;
use App\Http\Models\Periodo;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Exception;

class CIBIESAdministrativosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:cibies_administrativos']);
    }

    public function reporte() {

        return view('reportes/cibies_administrativos.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {
        $empleados = new Collection;
        self::buscarAdministrativos($request)
        ->chunk(150, static function($registros) use ($empleados) {
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

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $empleados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarAdministrativos($request) {

        return Empleado::with('persona', 'puesto')
        ->where(static function($query) use ($request) {
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('horariosadmivos', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
        })
        ->whereDoesntHave('grupos', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
        });
    }

    /**
     * @param App\Http\Models\Empleado
     */
    private static function info_esencial($empleado) {
        
        $persona = $empleado->persona;

        return [
            'empleado_id' => $empleado->id,
            'nombreCompleto' => $persona->nombreCompleto(true),
            'edad' => $persona->edad(),
            'sexo' => $persona->esMujer() ? 'Mujer' : 'Hombre',
            'orden' => $persona->nombreCompleto(true),
            'puesto' => $empleado->puesto->puesNombre,
            'correo' => $empleado->empCorreo1,
            'telefono' => $persona->perTelefono1,
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
    public function generarExcel($info_reporte, $empleados) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->mergeCells("A1:O1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:O2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "No.");
        $sheet->setCellValueByColumnAndRow(2, 2, "NOMBRE COMPLETO");
        $sheet->setCellValueByColumnAndRow(3, 2, "EDAD");
        $sheet->setCellValueByColumnAndRow(4, 2, "SEXO");
        $sheet->setCellValueByColumnAndRow(5, 2, "PUESTO");
        $sheet->setCellValueByColumnAndRow(6, 2, "ÁREA O DEPARTAMENTO DE ASIGNACIÓN");
        $sheet->setCellValueByColumnAndRow(7, 2, "TIPO DE CONTRATO (PLAZA, HONORARIOS, ASIMILABLES)");
        $sheet->setCellValueByColumnAndRow(8, 2, "EN CASO DE SER HONORARIOS (TIEMPO DE CONTRATACIÓN)");
        $sheet->setCellValueByColumnAndRow(9, 2, "CORREO INSTITUCIONAL");
        $sheet->setCellValueByColumnAndRow(10, 2, "TEL/CEL INSTITUCIONAL");
        $sheet->setCellValueByColumnAndRow(11, 2, "GRADO MÁXIMO DE ESTUDIOS");
        $sheet->setCellValueByColumnAndRow(12, 2, "DISCAPACIDAD (SI/NO)");
        $sheet->setCellValueByColumnAndRow(13, 2, "TIPO DE DISCAPACIDAD");
        $sheet->setCellValueByColumnAndRow(14, 2, "RECIBIÓ CAPACITACIÓN CICLO ANTERIOR");
        $sheet->setCellValueByColumnAndRow(15, 2, "ESTÁ EN PROCESO DE FORMACIÓN ACADÉMICA");

        $fila = 3;
        foreach($empleados->sortBy('orden') as $empleado) {
            $sheet->setCellValueExplicit("A{$fila}", $empleado['empleado_id'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $empleado['nombreCompleto']);
            $sheet->setCellValue("C{$fila}", $empleado['edad']);
            $sheet->setCellValue("D{$fila}", $empleado['sexo']);
            $sheet->setCellValue("E{$fila}", $empleado['puesto']);
            $sheet->setCellValue("I{$fila}", $empleado['correo']);
            $sheet->setCellValue("J{$fila}", $empleado['telefono']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CIBIESAdministrativos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CIBIESAdministrativos.xlsx"));
    }
}

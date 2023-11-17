<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Empleado;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Exception;

class CIBIESDocentesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:cibies_docentes']);
    }

    public function reporte() {

        return view('reportes/cibies_docentes.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {
        $empleados = new Collection;
        self::buscarDocentes($request)
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
    private static function buscarDocentes($request) {

        return Empleado::with(['persona', 'escolaridades.profesion'])
        ->whereHas('grupos.plan.programa', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        });
    }

    /**
     * @param App\Http\Models\Empleado
     */
    private static function info_esencial($empleado) {

        $persona = $empleado->persona;
        $nombreCompleto = $persona->nombreCompleto(true);
        $escolaridad_ultima = $empleado->escolaridades->firstWhere('escoUltimoGrado', 'S');
        $profesion = $escolaridad_ultima ? $escolaridad_ultima->profesion : null;

        return [
            'empleado_id' => $empleado->id,
            'nombreCompleto' => $nombreCompleto,
            'edad' => $persona->edad(),
            'sexo' => $persona->esMujer() ? 'Mujer' : 'Hombre',
            'nivel' => $profesion ? self::definirNivel($profesion->profNivel) : '',
            'orden' => $nombreCompleto,
        ];
    }

    /**
     * @param string $profNivel
     */
    private static function definirNivel($profNivel = null) {
        switch ($profNivel) {
            case 'L':
                return 'Licenciatura';
            case 'M':
                return 'Maestría';
            case 'D':
                return 'Doctorado';
            case 'E':
                return 'Especialidad';
            default:
                return 'No definido';
        }
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
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->mergeCells("A1:P1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:P2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "NO.");
        $sheet->setCellValueByColumnAndRow(2, 2, "NOMBRE COMPLETO");
        $sheet->setCellValueByColumnAndRow(3, 2, "EDAD");
        $sheet->setCellValueByColumnAndRow(4, 2, "SEXO");
        $sheet->setCellValueByColumnAndRow(5, 2, "TIPO DE DOCENTE");
        $sheet->setCellValueByColumnAndRow(6, 2, "SI EL TIPO DE DOCENTE ES OTRO (ESCRIBIR EL TIPO DE DOCENTE CORRECTO)");
        $sheet->setCellValueByColumnAndRow(7, 2, "GRADO MÁXIMO DE ESTUDIOS");
        $sheet->setCellValueByColumnAndRow(8, 2, "DISCAPACIDAD (SI/NO)");
        $sheet->setCellValueByColumnAndRow(9, 2, "TIPO DE DISCAPACIDAD");
        $sheet->setCellValueByColumnAndRow(10, 2, "PARTICIPA EN ACTIVIDADES DE INVESTIGACIÓN");
        $sheet->setCellValueByColumnAndRow(11, 2, "S.N.I");
        $sheet->setCellValueByColumnAndRow(12, 2, "PERFIL PRODEP");
        $sheet->setCellValueByColumnAndRow(13, 2, "RECIBIÓ CAPACITACIÓN CICLO ANTERIOR");
        $sheet->setCellValueByColumnAndRow(14, 2, "ESTÁ EN PROCESO DE FORMACIÓN ACADÉMICA");
        $sheet->setCellValueByColumnAndRow(15, 2, "CUENTA CON APOYO ACTUALMENTE");
        $sheet->setCellValueByColumnAndRow(16, 2, "TIPOS DE APOYO 1 (ESCRIBIR EL NOMBRE)");

        $fila = 3;
        foreach($empleados->sortBy('orden') as $empleado) {
            $sheet->setCellValueExplicit("A{$fila}", $empleado['empleado_id'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $empleado['nombreCompleto']);
            $sheet->setCellValue("C{$fila}", $empleado['edad']);
            $sheet->setCellValue("D{$fila}", $empleado['sexo']);
            $sheet->setCellValue("G{$fila}", $empleado['nivel']);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CIBIESDocentes.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CIBIESDocentes.xlsx"));
    }
}

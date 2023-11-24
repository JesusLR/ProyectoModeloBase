<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Escuela;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\HorarioAdmivo;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Exception;

class HorariosPersonalesExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:horarios_personales_excel']);
    }

    public function reporte() {

        return view('reportes/horarios_personales_excel.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        $empleados = new Collection;
        self::buscarEmpleados($request)
        ->chunk(30, static function($registros) use ($request, $empleados) {
            if($registros->isEmpty())
                return false;

            $horarios_docentes = self::buscarHorariosDeClases($request, $registros)->groupBy('empleado_id');

            $registros->each(static function($empleado) use ($empleados, $horarios_docentes) {
                $empleado->horarios_clase = $horarios_docentes->pull($empleado->empleado_id);
                if($empleado->horarios_clase instanceof Collection)
                    $empleados->push($empleado);
            });
        });
        // dd($empleados->take(2));
        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $empleados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarEmpleados($request) {

        return Empleado::select(
            'empleados.id AS empleado_id', 
            DB::raw("CONCAT_WS(' ', personas.perApellido1, personas.perApellido2, personas.perNombre) AS nombreCompleto"),
            'conteo_horas_docentes.suma_horas AS total_horas_docentes', 
            'conteo_horas_administrativas.suma_horas AS total_horas_administrativas'
        )
        ->join('personas', 'personas.id', 'empleados.persona_id')
        ->joinSub(self::conteoHorasDocentesPorEmpleadoSubQuery($request), 'conteo_horas_docentes', static function($join) {
            $join->on('conteo_horas_docentes.empleado_id', 'empleados.id');
        })
        ->leftJoinSub(self::conteoHorasAdministrativasPorEmpleadoSubQuery($request), 'conteo_horas_administrativas', static function($join) {
            $join->on('conteo_horas_administrativas.empleado_id', 'empleados.id');
        })
        ->groupBy('empleados.id')
        ->where(static function($query) use ($request) {
            if($request->empleado_id)
                $query->where('empleados.id', $request->empleado_id);
            if($request->perApellido1)
                $query->where('personas.perApellido1', 'like', "%{$request->perApellido1}%");
            if($request->perApellido2)
                $query->where('personas.perApellido2', 'like', "%{$request->perApellido2}%");
            if($request->perNombre)
                $query->where('perNombre', 'like', "%{$request->perNombre}%");
        });
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function conteoHorasDocentesPorEmpleadoSubQuery($request) {

        return Horario::select(
            DB::raw("SUM(horarios.ghFinal - horarios.ghInicio) AS suma_horas"), 'grupos.empleado_id AS empleado_id'
        )
        ->join('grupos', 'grupos.id', 'horarios.grupo_id')
        ->whereHas('grupo.plan', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id)
                ->whereNull('grupo_equivalente_id');
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
        })
        ->groupBy('grupos.empleado_id');
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function conteoHorasAdministrativasPorEmpleadoSubQuery($request) {

        return HorarioAdmivo::select(
            DB::raw("SUM(horariosadmivos.hadmFinal - horariosadmivos.hadmHoraInicio) AS suma_horas"), 'empleados.id AS empleado_id'
        )
        ->join('empleados', 'empleados.id', 'horariosadmivos.empleado_id')
        ->join('periodos', 'periodos.id', 'horariosadmivos.periodo_id')
        ->where('periodo_id', $request->periodo_id)
        ->groupBy('empleados.id');
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Support\Collection $empleados
     */
    private static function buscarHorariosDeClases($request, $empleados) {

        return Horario::select('horarios.id AS horario_id', 'grupos.id AS grupo_id', 'grupos.empleado_id', 'horarios.ghDia AS dia',
            'horarios.ghInicio AS inicio', 'horarios.ghFinal AS final', 'aulas.aulaClave AS aula', 
            'materias.matClave', 'materias.matNombre', 'programas.progClave', 'optativas.optNombre',
            'grupos.gpoFechaExamenOrdinario as fecha_ordinario'
        )
        ->join('grupos', 'grupos.id', 'horarios.grupo_id')
        ->join('materias', 'materias.id', 'grupos.materia_id')
        ->join('planes', 'planes.id', 'materias.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('aulas', 'aulas.id', 'horarios.aula_id')
        ->leftJoin('optativas', 'optativas.id', 'grupos.optativa_id')
        ->whereNull('grupos.deleted_at')
        ->whereNull('grupos.grupo_equivalente_id')
        ->whereIn('grupos.empleado_id', $empleados->pluck('empleado_id'))
        ->where('grupos.periodo_id', $request->periodo_id)
        ->get();
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
            'escuela' => Escuela::findOrFail($request->escuela_id),
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $empleados) {

        $spreadsheet = new Spreadsheet();

        foreach($empleados->sortBy('nombreCompleto') as $empleado) {
            $newSheet = new Worksheet($spreadsheet, $empleado->empleado_id);
            $spreadsheet->addSheet($newSheet);
            $sheet = $spreadsheet->getSheetByName($empleado->empleado_id);
            self::llenarDatosPorTab($sheet, $info_reporte, $empleado);
        }
        $spreadsheet->removeSheetByIndex(0); # Borrar primer tab (No se utilizó).

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("HorariosPersonalesExcel.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("HorariosPersonalesExcel.xlsx"));
    }

    /**
     * @param PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param array $info_reporte
     * @param Illuminate\Support\Collection $empleado
     */
    private static function llenarDatosPorTab($sheet, $info_reporte, $empleado) {

        $ubicacion = $info_reporte['ubicacion'];
        $departamento = $info_reporte['departamento'];
        $escuela = $info_reporte['escuela'];
        $clases = $empleado->horarios_clase;
        $total_horas = intval($empleado->total_horas_docentes) + intval($empleado->total_horas_administrativas);


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
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->mergeCells("A1:G1"); $sheet->mergeCells("J1:M1");
        $sheet->mergeCells("A2:G2"); $sheet->mergeCells("J2:M2");
        $sheet->mergeCells("A3:G3"); $sheet->mergeCells("J3:M3");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('J1')->getFont()->setBold(true);

        $sheet->setCellValue('A1', "{$ubicacion->ubiNombre} | {$departamento->depNombre} | {$escuela->escNombre}");
        $sheet->setCellValue('J1', "NUM. CONTROL");

        $sheet->setCellValue('A2', "NOMBRE: {$empleado->nombreCompleto}");
        $sheet->setCellValueExplicit('J2', $empleado->empleado_id, DataType::TYPE_STRING);

        $sheet->setCellValue('A3', $info_reporte['periodo_descripcion']);
        $sheet->setCellValue('J3', "DOC: {$empleado->total_horas_docentes} ADM: ".($empleado->total_horas_administrativas ?: '0')." TOT: {$total_horas}");

        # ---------- HORARIO MATUTINO ----------
        $sheet->getStyle("A5")->getFont()->setBold(true);
        $sheet->getStyle("A6:M6")->getFont()->setBold(true);
        $sheet->getStyle("A7:M7")->getFont()->setBold(true);

        $sheet->mergeCells("A5:M5");

        $sheet->mergeCells("B6:C6");
        $sheet->mergeCells("D6:E6");
        $sheet->mergeCells("F6:G6");
        $sheet->mergeCells("H6:I6");
        $sheet->mergeCells("J6:K6");
        $sheet->mergeCells("L6:M6");

        $sheet->setCellValue('A6', "HORARIO MATUTINO");

        $sheet->setCellValue('A6', "HORA");
        $sheet->setCellValue('B6', "LUNES");
        $sheet->setCellValue('D6', "MARTES");
        $sheet->setCellValue('F6', "MIÉRCOLES");
        $sheet->setCellValue('H6', "JUEVES");
        $sheet->setCellValue('J6', "VIERNES");
        $sheet->setCellValue('L6', "SÁBADO");

        $columna = 'B';
        foreach(range(1, 6) as $dia) {
            $sheet->setCellValue("{$columna}7", 'clave');
            $columna++;
            $sheet->setCellValue("{$columna}7", 'aula');
            $columna++;
        }

        $fila = 8;
        foreach(range(7, 14) as $hora_inicio) {
            $columna = 'B';
            $hora_fin = $hora_inicio + 1;
            $inicio_fin = str_pad($hora_inicio, 2, '0', STR_PAD_LEFT) . '-' . str_pad($hora_fin, 2, '0', STR_PAD_LEFT);
            $sheet->setCellValue("A{$fila}", $inicio_fin);
            foreach(range(1, 6) as $dia) {
                $clase = $clases->where('dia', $dia)->filter(static function($clase) use ($hora_inicio, $hora_fin) {
                    return intval($clase->inicio) <= $hora_inicio && intval($clase->final) >= $hora_fin;
                })->first();
                $sheet->setCellValue("{$columna}{$fila}", ($clase ? $clase->matClave : ''));
                $columna++;
                $sheet->setCellValue("{$columna}{$fila}", ($clase ? $clase->aula : ''));
                $columna++;
            }
            $fila++;
        }

        # ---------- HORARIO VESPERTINO ----------
        $sheet->getStyle("A17")->getFont()->setBold(true);
        $sheet->getStyle("A18:M18")->getFont()->setBold(true);
        $sheet->getStyle("A19:M19")->getFont()->setBold(true);

        $sheet->mergeCells("A17:M17");

        $sheet->mergeCells("B18:C18");
        $sheet->mergeCells("D18:E18");
        $sheet->mergeCells("F18:G18");
        $sheet->mergeCells("H18:I18");
        $sheet->mergeCells("J18:K18");
        $sheet->mergeCells("L18:M18");

        $sheet->setCellValue('A17', "HORARIO VESPERTINO");

        $sheet->setCellValue('A18', "HORA");
        $sheet->setCellValue('B18', "LUNES");
        $sheet->setCellValue('D18', "MARTES");
        $sheet->setCellValue('F18', "MIÉRCOLES");
        $sheet->setCellValue('H18', "JUEVES");
        $sheet->setCellValue('J18', "VIERNES");
        $sheet->setCellValue('L18', "SÁBADO");

        $columna = 'B';
        foreach(range(1, 6) as $dia) {
            $sheet->setCellValue("{$columna}19", 'clave');
            $columna++;
            $sheet->setCellValue("{$columna}19", 'aula');
            $columna++;
        }

        $fila = 20;
        foreach(range(15, 21) as $hora_inicio) {
            $columna = 'B';
            $hora_fin = $hora_inicio + 1;
            $inicio_fin = str_pad($hora_inicio, 2, '0', STR_PAD_LEFT) . '-' . str_pad($hora_fin, 2, '0', STR_PAD_LEFT);
            $sheet->setCellValue("A{$fila}", $inicio_fin);
            foreach(range(1, 6) as $dia) {
                $clase = $clases->where('dia', $dia)->filter(static function($clase) use ($hora_inicio, $hora_fin) {
                    return intval($clase->inicio) <= $hora_inicio && intval($clase->final) >= $hora_fin;
                })->first();
                $sheet->setCellValue("{$columna}{$fila}", ($clase ? $clase->matClave : ''));
                $columna++;
                $sheet->setCellValue("{$columna}{$fila}", ($clase ? $clase->aula : ''));
                $columna++;
            }
            $fila++;
        }

        # ---------- LISTA DE MATERIAS IMPARTIDAS ----------
        $sheet->getStyle("A28:M28")->getFont()->setBold(true);

        $sheet->mergeCells("B28:I28");
        $sheet->mergeCells("J28:K28");
        $sheet->mergeCells("L28:M28");

        $sheet->setCellValue("A28", "CLAVE");
        $sheet->setCellValue("B28", "DESCRIPCIÓN");
        $sheet->setCellValue("J28", "CARRERA");
        $sheet->setCellValue("L28", "ORDINARIO");

        $fila = 29;
        foreach($clases->keyBy('grupo_id') as $materia) {
            $sheet->mergeCells("B{$fila}:I{$fila}");
            $sheet->mergeCells("J{$fila}:K{$fila}");
            $sheet->mergeCells("L{$fila}:M{$fila}");
            $nombre_materia = $materia->matNombre . ($materia->optNombre ? ' - ' . $materia->optNombre : '');
            $sheet->setCellValue("A{$fila}", $materia->matClave);
            $sheet->setCellValue("B{$fila}", $nombre_materia);
            $sheet->setCellValue("J{$fila}", $materia->progClave);
            $sheet->setCellValue("L{$fila}", $materia->fecha_ordinario);
            $fila++;
        }
    }
}

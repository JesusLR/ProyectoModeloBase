<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Horario;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CargaDeAlumnosPorAulaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function reporte() {

        return view('reportes/carga_alumnos_aula.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        if(!self::buscarHorarios($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $horarios = new Collection;
        self::buscarHorarios($request)
        ->chunk(200, static function($registros) use ($horarios) {

            if($registros->isEmpty())
                return false;

            $registros->each(static function($horario) use ($horarios) {
                $horarios->push(self::info_esencial($horario));
            });
        });
        // dd($horarios->pluck('inscritos'));

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $horarios);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarHorarios($request) {

        return Horario::with(['grupo.plan.programa.escuela', 'grupo.inscritos', 'aula'])
        ->whereHas('grupo.plan.programa', static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('aula', static function($query) use ($request) {
            if($request->aulaClave)
                $query->where('aulaClave', $request->aulaClave);
        })
        ->where(static function($query) use ($request) {
            if($request->ghDia)
                $query->where('ghDia', $request->ghDia);
        });
    }

    /**
     * @param App\Models\Horario
     */
    private static function info_esencial($horario) {
        $grupo = $horario->grupo;
        $programa = $grupo->plan->programa;

        return [
            'aulaClave' => $horario->aula->aulaClave,
            'escClave' => $programa->escuela->escClave,
            'progClave' => $programa->progClave,
            'dia' => $horario->ghDia,
            'horaInicio' => intval($horario->ghInicio),
            'horaFinal' => intval($horario->ghFinal),
            'inscritos' => $grupo->inscritos->count(),
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
    public function generarExcel($info_reporte, $horarios) {

        $dias = [
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábados',
        ];
        $horariosAgrupadosPorDia = $horarios->groupBy('dia');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach($dias as $key => $dia) {
            if($key == 1) {
                $sheet->setTitle($dia);
            } else {
                $newSheet = new Worksheet($spreadsheet, $dia);
                $spreadsheet->addSheet($newSheet);
            }
            $sheet = $spreadsheet->getSheetByName($dia);
            $horariosDelDia = $horariosAgrupadosPorDia->get($key);
            if($horariosDelDia) {
                self::llenarDatosPorTab($sheet, $info_reporte, $horariosDelDia);
            }
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CargaDeAlumnosPorAula.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CargaDeAlumnosPorAula.xlsx"));
    }

    /**
     * @param PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param array $info_reporte
     * @param Illuminate\Support\Collection $horarios
     */
    private static function llenarDatosPorTab($sheet, $info_reporte, $horarios) {

        $horasClase = [
            [7, 8], [8, 9], [9, 10], [10, 11], [11, 12], [12, 13], [13, 14], [14, 15], # matutino
            [15, 16], [16, 17], [17, 18], [18, 19], [19, 20], [20, 21], [21, 22], # vespertino
        ];

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
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->mergeCells("A1:R1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
        $sheet->getStyle("A2:R2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Clave aula");
        $sheet->setCellValueByColumnAndRow(2, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(3, 2, "Programa");

        $columna = 4;
        foreach($horasClase as $horaClase) {
            $sheet->setCellValueByColumnAndRow($columna, 2, "{$horaClase[0]}-{$horaClase[1]}");
            $columna++;
        }
        $columna = 4;

        $fila = 3;
        foreach($horarios->groupBy('aulaClave') as $horariosAula) {
            $aula = $horariosAula->first();
            $sheet->setCellValueExplicit("A{$fila}", $aula['aulaClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $aula['escClave']);
            $sheet->setCellValue("C{$fila}", $aula['progClave']);
            foreach($horasClase as $horaClase) {
                $estadistica = self::obtenerEstadisticasPor($horaClase, $horariosAula);
                $sheet->setCellValueByColumnAndRow($columna, $fila, ($estadistica['inscritos'] ?: null));
                $columna++;
            }
            $columna = 4;
            $fila++;
        }
    }

    /**
     * @param array $horaClase
     * @param Illuminate\Support\Collection $horarios
     */
    private static function obtenerEstadisticasPor($horaClase, $horarios) {

        $clases = $horarios->filter(static function($horario) use ($horaClase) {
            return $horario['horaInicio'] <= $horaClase[0] && $horario['horaFinal'] >= $horaClase[1];
        });

        return [
            'inscritos' => $clases->sum('inscritos'),
        ];
    }
}

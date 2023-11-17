<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class DeudoresEconomicoAcademicoController extends Controller
{
    private $ubicacion;
    private $departamento;
    private $periodo;
    private $tipos_reporte = [
        1 => 'reporteEspecifico',
        2 => 'reporteEstadisticoIndividual',
        3 => 'reporteEstadisticoGeneral',
    ];
    private $mesesPagos = [
        'InscAgo', 'Sep', 'Oct', 'Nov', 'Dic','Ene', 'InscEne', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'
    ];

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function reporte() {

        return view('reportes/deudores_economico_academico.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        $this->periodo = Periodo::findOrFail($request->periodo_id);
        $this->departamento = $this->periodo->departamento;
        $this->ubicacion = $this->departamento->ubicacion;
        $escuela = $request->escuela_id ? Escuela::findOrFail($request->escuela_id) : null;
        $programa = $request->programa_id ? Programa::findOrFail($request->programa_id) : null;

        $banco_materias_adeudadas = DB::select("call procMateriasAdeudadas(
            '{$this->ubicacion->ubiClave}',
            '{$this->departamento->depClave}',
            '" . ($escuela ? $escuela->escClave : null) . "',
            '" . ($programa ? $programa->progClave : null) . "',
            '', '', '', '', '', '', '', '', '', 'N', 'S', 'N'
        )");
        $banco_materias_adeudadas = collect($banco_materias_adeudadas)->groupBy('cvePago');

        $deudores = DB::select("call procResumenDeudasAlumno(
            {$this->periodo->perNumero},
            {$this->periodo->perAnio},
            '{$this->ubicacion->ubiClave}',
            '{$this->departamento->depClave}',
            '" . auth()->user()->id . "'
        )");

        $deudores = collect($deudores)->keyBy('CvePago')
        ->filter(function($deudor, $cvePago) use ($banco_materias_adeudadas) {
            $deudor->materias_adeudadas = $banco_materias_adeudadas->pull($cvePago) ?: new Collection;
            $deudor->pagos_adeudados = $this->mapearPagosAdeudados($deudor);

            return $deudor->materias_adeudadas->isNotEmpty();
        });

        if($deudores->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada', 'warning')->showConfirmButton();
            return back()->withInput();
        }
        // dd($deudores->first());

        return $this->generarExcel($deudores, $request->tipo_reporte);
    }

    /**
     * @param Illuminate\Support\Collection $deudores
     * @param int $tipo_reporte
     */
    private function generarExcel(Collection $deudores, $tipo_reporte) {

        $ultimaColumna = $tipo_reporte == 3 ? 'E' : 'H';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells("A1:{$ultimaColumna}1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$this->ubicacion->ubiClave} - {$this->ubicacion->ubiNombre}     {$this->departamento->depClave} - {$this->departamento->depNombre}");
        $sheet->getStyle("A2:{$ultimaColumna}2")->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        if($tipo_reporte != 3) {
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
        }

        # Columnas generales
        if($tipo_reporte != 3) {
            $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
            $sheet->setCellValueByColumnAndRow(2, 2, "Carrera");
            $sheet->setCellValueByColumnAndRow(3, 2, "Plan");
            $sheet->setCellValueByColumnAndRow(4, 2, "Cve. Pago");
            $sheet->setCellValueByColumnAndRow(5, 2, "Alumno");
            $sheet->setCellValueByColumnAndRow(6, 2, "Semestre");
            $sheet->setCellValueByColumnAndRow(7, 2, "Meses de adeudo");
            $sheet->setCellValueByColumnAndRow(8, 2, "Asignaturas adeudadas");
        } else {
            $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
            $sheet->setCellValueByColumnAndRow(2, 2, "Clave programa");
            $sheet->setCellValueByColumnAndRow(3, 2, "Nombre");
            $sheet->setCellValueByColumnAndRow(4, 2, "Plan");
            $sheet->setCellValueByColumnAndRow(5, 2, "Alumnos con deuda económica o académica");
        }

        $funcion = $this->tipos_reporte[$tipo_reporte];
        $sheet = $this->{$funcion}($sheet, $deudores);

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("DeudoresEconomicoAcademico.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("DeudoresEconomicoAcademico.xlsx"));
    }

    /**
     * @param PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param Illuminate\Support\Collection $deudores
     */
    private function reporteEspecifico($sheet, $deudores) {

        $fila = 3;
        foreach ($deudores as $key => $deudor) {
            $plan = $deudor->materias_adeudadas->first()->plan;
            $fila_alumno = $fila; # fila donde comienza la info del alumno
            $sheet->setCellValue("A{$fila}", $deudor->Esc);
            $sheet->setCellValue("B{$fila}", $deudor->Prog);
            $sheet->setCellValueExplicit("C{$fila}", $plan, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $deudor->CvePago, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $deudor->Nombre);
            $sheet->setCellValueExplicit("F{$fila}", $deudor->Sem, DataType::TYPE_STRING);
            foreach($deudor->pagos_adeudados as $mes => $monto) {
                $sheet->setCellValue("G{$fila}", $mes);
                $fila++;
            }
            $ultimaFilaPagos = $fila;
            $fila = $fila_alumno;
            foreach($deudor->materias_adeudadas as $materia) {
                $sheet->setCellValue("H{$fila}", "{$materia->matClave} - {$materia->matNombre}");
                $fila++;
            }
            $fila = $fila > $ultimaFilaPagos ? $fila : $ultimaFilaPagos; #define última fila del ocupada por el alumno.
            $fila++; # Deja línea vacía después de cada alumno.
        }
    }

    /**
     * @param PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param Illuminate\Support\Collection $deudores
     */
    private function reporteEstadisticoIndividual($sheet, $deudores) {

        $fila = 3;
        foreach ($deudores as $key => $deudor) {
            $plan = $deudor->materias_adeudadas->first()->plan;
            $sheet->setCellValue("A{$fila}", $deudor->Esc);
            $sheet->setCellValue("B{$fila}", $deudor->Prog);
            $sheet->setCellValueExplicit("C{$fila}", $plan, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $deudor->CvePago, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $deudor->Nombre);
            $sheet->setCellValueExplicit("F{$fila}", $deudor->Sem, DataType::TYPE_STRING);
            $sheet->setCellValue("G{$fila}", $deudor->pagos_adeudados->count());
            $sheet->setCellValue("H{$fila}", $deudor->materias_adeudadas->count());
            $fila++;
        }

        return $sheet;
    }

    /**
     * @param PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param Illuminate\Support\Collection $deudores
     */
    private function reporteEstadisticoGeneral($sheet, $deudores) {
        $fila = 3;

        $programas_plan = $deudores->groupBy(static function($deudor) {
            return $deudor->Prog . '-' . $deudor->materias_adeudadas->first()->plan;
        });

        foreach ($programas_plan as $key => $plan) {
            $infoPrograma = $plan->first()->materias_adeudadas->first();

            $sheet->setCellValue("A{$fila}", $infoPrograma->escuela);
            $sheet->setCellValue("B{$fila}", $infoPrograma->programa);
            $sheet->setCellValue("C{$fila}", ($infoPrograma ? $infoPrograma->nombrePrograma : ''));
            $sheet->setCellValueExplicit("D{$fila}", $infoPrograma->plan, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $plan->count());
            $fila++;
        }

        return $sheet;
    }

    /**
     * @param object $deudor
     */
    private function mapearPagosAdeudados($deudor) {
        $adeudos = new Collection;
        foreach($this->mesesPagos as $pago) {
            if($deudor->{$pago}) 
                $adeudos->put($pago, $deudor->{$pago});
        }

        return $adeudos;
    }
}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\ResumenAcademico;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class AlumnosRegularesSinCursoController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'permisos:alumnos_regulares_sin_curso']);
    }

    public function reporte() {

        return view('reportes/alumnos_regulares_sin_curso.create', [
            'hoy' => Carbon::now('America/Merida'),
        ]);
    }

    public function imprimir(Request $request) {
        if(!$this->buscarAlumnosSinCurso($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        return $this->generarExcel($request);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private function buscarAlumnosSinCurso($request) {
        DB::select("call procAlumnosRegularesSinCurso({$request->perAnioPago})");

        return DB::table('_temp_alumnos_regulares_sin_curso');
    }

    /**
     * @param Illuminate\Http\Request $request. 
     */
    public function generarExcel($request) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells("A1:K1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "Alumnos regulares que no han sido inscritos a ningún curso.");
        $sheet->getStyle("A2:K2")->getFont()->setBold(true);
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

        $sheet->setCellValueByColumnAndRow(1, 2, "Clave pago");
        $sheet->setCellValueByColumnAndRow(2, 2, "Matrícula");
        $sheet->setCellValueByColumnAndRow(3, 2, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(4, 2, "CURP");
        $sheet->setCellValueByColumnAndRow(5, 2, "Fecha ingreso");
        $sheet->setCellValueByColumnAndRow(6, 2, "Último grado");
        $sheet->setCellValueByColumnAndRow(7, 2, "Plan");
        $sheet->setCellValueByColumnAndRow(8, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(9, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(10, 2, "Departamento");
        $sheet->setCellValueByColumnAndRow(11, 2, "Ubicacion");

        $fila = 3;
        $this->buscarAlumnosSinCurso($request)->orderBy('nombreCompleto')
        ->chunk(200, static function($registros) use ($sheet, &$fila) {
            if($registros->isEmpty())
                return false;

            foreach($registros as $alumno) {
                $sheet->setCellValueExplicit("A{$fila}", $alumno->aluClave, DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("B{$fila}", $alumno->aluMatricula, DataType::TYPE_STRING);
                $sheet->setCellValue("C{$fila}", $alumno->nombreCompleto);
                $sheet->setCellValue("D{$fila}", $alumno->nombreCompleto);
                $sheet->setCellValue("E{$fila}", $alumno->resFechaIngreso);
                $sheet->setCellValue("F{$fila}", $alumno->resUltimoGrado);
                $sheet->setCellValue("G{$fila}", $alumno->planClave);
                $sheet->setCellValue("H{$fila}", $alumno->progClave);
                $sheet->setCellValue("I{$fila}", $alumno->escClave);
                $sheet->setCellValue("J{$fila}", $alumno->depClave);
                $sheet->setCellValue("K{$fila}", $alumno->ubiClave);
                $fila++;
            }
        });

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("AlumnosRegularesSinCurso.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("AlumnosRegularesSinCurso.xlsx"));
    }

}

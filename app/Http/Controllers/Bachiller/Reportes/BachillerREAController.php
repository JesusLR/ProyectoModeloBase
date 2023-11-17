<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Periodo;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BachillerREAController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.REA.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {

        $periodo = Periodo::find($request->periodo_id);
        $perNumero = $periodo->perNumero;
        $perAnio = $periodo->perAnio;

        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $ubiClave = $ubicacion->ubiClave;

        $programa = Programa::find($request->programa_id);
        $progClave = $programa->progClave;

        $cgtGradoSemestre = $request->cgtGradoSemestre;
        $cgtGrupo = $request->cgtGrupo;

        $resultado_collection = DB::select('call procBachillerFormatoREA(?,?,?,?,?,?)',array($perNumero,
        $perAnio,
        $ubiClave,
        $progClave,
        $cgtGradoSemestre,
        $cgtGrupo));


        $registroAlumnos = collect($resultado_collection);


        if ($registroAlumnos->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');


        return $this->generarExcel($registroAlumnos);
    }


    public function generarExcel($registroAlumnos) {


    
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
        $sheet->getColumnDimension('K')->setAutoSize(true);
        // #Título.
        // $sheet->mergeCells("A1:J1");
        // #Encabezado columna 1.
        // $sheet->mergeCells("A2:E2");
        // $sheet->mergeCells("A3:E3");
        // $sheet->mergeCells("A4:E4");
        // $sheet->mergeCells("A5:E5");
        // #Encabezado columna 2.
        // $sheet->mergeCells("F2:J2");
        // $sheet->mergeCells("F3:J3");
        // $sheet->mergeCells("F4:J4");
        // $sheet->mergeCells("F5:J5");
    
         
        $sheet->setCellValueByColumnAndRow(1, 1, "Matrícula");
        $sheet->setCellValueByColumnAndRow(2, 1, "Primer Apellido");
        $sheet->setCellValueByColumnAndRow(3, 1, "Segundo Apellido");
        $sheet->setCellValueByColumnAndRow(4, 1, "Nombres");
        $sheet->setCellValueByColumnAndRow(5, 1, "Curso");
        $sheet->setCellValueByColumnAndRow(6, 1, "Gpo");
        $sheet->setCellValueByColumnAndRow(7, 1, "Turno");
        $sheet->setCellValueByColumnAndRow(8, 1, "Fecha_Nacimiento");
        $sheet->setCellValueByColumnAndRow(9, 1, "CURP");
        $sheet->setCellValueByColumnAndRow(10, 1, "Sexo");
        $sheet->setCellValueByColumnAndRow(11, 1, "Presenta");
    
        $fila = 2;
        foreach($registroAlumnos as $alumno) {    
    
            $sheet->setCellValueExplicit("A{$fila}", ($alumno->Matricula ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$fila}", ($alumno->perApellido1 ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", ($alumno->perApellido2 ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $alumno->perNombre, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $alumno->grado);
            $sheet->setCellValueExplicit("F{$fila}", $alumno->Gpo, DataType::TYPE_STRING);
            $sheet->setCellValue("G{$fila}", $alumno->turno);
            $sheet->setCellValue("H{$fila}", $alumno->fechaNac);
            $sheet->setCellValueExplicit("I{$fila}", $alumno->perCurp, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$fila}", $alumno->perSexo, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("K{$fila}", $alumno->presenta, DataType::TYPE_STRING);

            $fila++;
        }
    
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("REA (Registro de alumnos).xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
    
        return response()->download(storage_path("REA (Registro de alumnos).xlsx"));
      }
}

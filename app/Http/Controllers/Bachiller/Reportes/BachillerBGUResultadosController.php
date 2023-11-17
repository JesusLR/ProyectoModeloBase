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

class BachillerBGUResultadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.BGU.create', [
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

        // $matriculas = $request->matriculas;

        // return $matriculas;
        // $porciones = explode(",", $matriculas);

        // return count($porciones);
        // for ($i=0; $i < count($porciones); $i++) { 
        //     print_r($porciones[0]."----------");
        // }

        // die();

        // procBachillerFormatoSOCA //elviejo
        $resultado_collection = DB::select('call procBachillerFormatoBGU(?,?,?,?,?,?)',array($perNumero,
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
        // $sheet->getColumnDimension('L')->setAutoSize(true);
        // $sheet->getColumnDimension('M')->setAutoSize(true);
        // $sheet->getColumnDimension('N')->setAutoSize(true);
        // $sheet->getColumnDimension('O')->setAutoSize(true);
        // $sheet->getColumnDimension('P')->setAutoSize(true);
        // $sheet->getColumnDimension('Q')->setAutoSize(true);
        // $sheet->getColumnDimension('R')->setAutoSize(true);
        // $sheet->getColumnDimension('S')->setAutoSize(true);
        // $sheet->getColumnDimension('T')->setAutoSize(true);
        // $sheet->getColumnDimension('U')->setAutoSize(true);
        // $sheet->getColumnDimension('V')->setAutoSize(true);
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
        $sheet->setCellValueByColumnAndRow(8, 1, "TipoEvaluacion");
        $sheet->setCellValueByColumnAndRow(9, 1, "Clave_asig");
        $sheet->setCellValueByColumnAndRow(10, 1, "Fecha_EvalP");
        $sheet->setCellValueByColumnAndRow(11, 1, "Calif_Final");
        // $sheet->setCellValueByColumnAndRow(12, 1, "Clave_Obl4");
        // $sheet->setCellValueByColumnAndRow(13, 1, "Clave_Opt1");
        // $sheet->setCellValueByColumnAndRow(14, 1, "Clave_Opt2");
        // $sheet->setCellValueByColumnAndRow(15, 1, "Clave_Opt3");
        // $sheet->setCellValueByColumnAndRow(16, 1, "Clave_Opt4");
        // $sheet->setCellValueByColumnAndRow(17, 1, "Clave_Opt5");
        // $sheet->setCellValueByColumnAndRow(18, 1, "Clave_Opt6");
        // $sheet->setCellValueByColumnAndRow(19, 1, "Clave_Ocu1");
        // $sheet->setCellValueByColumnAndRow(20, 1, "Clave_Ocu2");
        // $sheet->setCellValueByColumnAndRow(21, 1, "Clave_Ocu3");
        // $sheet->setCellValueByColumnAndRow(22, 1, "Clave_Ocu4");

    
        $fila = 2;
        foreach($registroAlumnos as $alumno) {    
    
            $sheet->setCellValueExplicit("A{$fila}", ($alumno->matricula ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$fila}", ($alumno->apellido1 ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", ($alumno->apellido2 ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $alumno->nombres, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", $alumno->curso);
            $sheet->setCellValueExplicit("F{$fila}", $alumno->grupo, DataType::TYPE_STRING);
            $sheet->setCellValue("G{$fila}", $alumno->turno);
            $sheet->setCellValue("H{$fila}", $alumno->tipoEvaluacion);
            $sheet->setCellValueExplicit("I{$fila}", $alumno->claveAsig, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$fila}", $alumno->fechaEval, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("K{$fila}", $alumno->caliFinal, DataType::TYPE_NUMERIC);
            // $sheet->setCellValueExplicit("L{$fila}", $alumno->claveObl4, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("M{$fila}", $alumno->claveOpt1, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("N{$fila}", $alumno->claveOpt2, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("O{$fila}", $alumno->claveOpt3, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("P{$fila}", $alumno->claveOpt4, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("Q{$fila}", $alumno->claveOpt5, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("R{$fila}", $alumno->claveOpt6, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("S{$fila}", $alumno->claveOcu1, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("T{$fila}", $alumno->claveOcu2, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("U{$fila}", $alumno->claveOcu3, DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit("V{$fila}", $alumno->claveOcu4, DataType::TYPE_STRING);


            $fila++;
        }
    
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("BGU resultados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
    
        return response()->download(storage_path("BGU resultados.xlsx"));
      }
}


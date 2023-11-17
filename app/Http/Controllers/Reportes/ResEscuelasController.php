<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Ubicacion;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Prophecy\Call\Call;

class ResEscuelasController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function reporte(){
    	return view('reportes.res_escuelas.create',[
            'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
        ]);
    }

    public function imprimir(Request $request) {

        if($request->ubicacion_id){
            $ubicacion = Ubicacion::find($request->ubicacion_id);
            $ubiClave = $ubicacion->ubiClave;
        }else{
            $ubiClave = "";
        }

        if($request->departamento_id){
            $departamento = Departamento::find($request->departamento_id);
            $depClave = $departamento->depClave;
        }else{
            $depClave = "";
        }
        
        if($request->escuela_id){
            $escuela = Escuela::find($request->escuela_id);
            $escClave = $escuela->escClave;
        }else{
            $escClave = "";
        }
        
        

        $escuelas = DB::select("call procResumenEscuelas(
            '".$ubiClave."',
            '".$depClave."',
            '".$escClave."'
        )");
        $escuelas = collect($escuelas);

        if($escuelas->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        return $this->generarExcel($escuelas);

    }

    public function generarExcel($escuelas) {


    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->getStyle('F1')->getFont()->setBold(true);


        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
 
       
         
        $sheet->setCellValueByColumnAndRow(1, 1, "Ubi");
        $sheet->setCellValueByColumnAndRow(2, 1, "Depto");
        $sheet->setCellValueByColumnAndRow(3, 1, "Escuela");
        $sheet->setCellValueByColumnAndRow(4, 1, "Director");
        $sheet->setCellValueByColumnAndRow(5, 1, "Coordinador Administrativo");
        $sheet->setCellValueByColumnAndRow(6, 1, "Coordinador Académico");

    
        $fila = 2;
        foreach($escuelas as $escuela) {    
    
            $sheet->setCellValueExplicit("A{$fila}", ($escuela->ubiClave ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$fila}", ($escuela->depClave ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", ($escuela->escClave ?: ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $escuela->director, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E{$fila}", $escuela->cordinador_administrativo, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F{$fila}", $escuela->cordinador_academico, DataType::TYPE_STRING);


            $fila++;
        }
    
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("resumen de escuelas.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
    
        return response()->download(storage_path("resumen de escuelas.xlsx"));
    }

}

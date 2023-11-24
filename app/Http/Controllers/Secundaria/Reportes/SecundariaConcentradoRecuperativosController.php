<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Secundaria\Secundaria_inscritos;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class SecundariaConcentradoRecuperativosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.reportes.concentrado_recuperativos.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
       $secundaria_inscritos = Secundaria_inscritos::select(
           'secundaria_inscritos.inscTrimestre1',
           'secundaria_inscritos.inscRecuperativoTrimestre1',
           'secundaria_inscritos.inscTrimestre2',
           'secundaria_inscritos.inscRecuperativoTrimestre2',
           'secundaria_inscritos.inscTrimestre3',
           'secundaria_inscritos.inscRecuperativoTrimestre3',
           'alumnos.aluClave',
           'personas.perApellido1',
           'personas.perApellido2',
           'personas.perNombre',
           'secundaria_grupos.gpoGrado',
           'secundaria_grupos.gpoClave',
           'secundaria_grupos.gpoMatComplementaria',
           'periodos.perAnio',
           'periodos.perFechaInicial',
           'periodos.perFechaFinal',
           'departamentos.depClave',
           'departamentos.depNombre',
           'ubicacion.ubiClave',
           'ubicacion.ubiNombre',
           'planes.planClave',
           'programas.progNombre',
           'programas.progClave',
           'escuelas.escNombre',
           'escuelas.escClave',
           'secundaria_materias.matClave',
           'secundaria_materias.matNombre'
       )
        ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
        ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
        ->where('periodos.id', '=', $request->periodo_id)
        ->where('planes.id', '=', $request->plan_id)
        ->where(static function ($query) use ($request) {

            if ($request->trimestre == "TRIMESTRE1") {
                $query->where('secundaria_inscritos.inscTrimestre1', '<', 6);
            }

            if ($request->trimestre == "TRIMESTRE2") {
                $query->where('secundaria_inscritos.inscTrimestre2', '<', 6);
            }

            if ($request->trimestre == "TRIMESTRE3") {
                $query->where('secundaria_inscritos.inscTrimestre3', '<', 6);
            }

            if ($request->gpoGrado) {
                $query->where('secundaria_grupos.gpoGrado', $request->gpoGrado);
            }

            if ($request->gpoClave) {
                $query->where('secundaria_grupos.gpoClave', $request->gpoClave);
            }

            if ($request->matClave) {
                $query->where('secundaria_materias.matClave', $request->matClave);
            }

            if ($request->aluClave) {
                $query->where('alumnos.aluClave', $request->aluClave);
            }

            if ($request->perApellido1) {
                $query->where('personas.perApellido1', $request->perApellido1);
            }
            if ($request->perApellido2) {
                $query->where('personas.perApellido2', $request->perApellido2);
            }

            if ($request->perNombre) {
                $query->where('personas.perNombre', $request->perNombre);
            }
        })
        ->orderBy('secundaria_grupos.gpoGrado', 'ASC')
        ->orderBy('secundaria_grupos.gpoClave', 'ASC')
        ->orderBy('secundaria_materias.matClave', 'ASC')
        ->orderBy('personas.perApellido1', 'ASC')
        ->orderBy('personas.perApellido2', 'ASC')
        ->orderBy('personas.perNombre', 'ASC')        
        ->get();
        
        
    
        // return count($secundaria_inscritos);

        if($request->tipoImpresion == "pdf"){
            return $this->PDF($secundaria_inscritos, $request->trimestre, $request->gpoGrado, $request->gpoClave);
        }else{
            return $this->EXCEL($secundaria_inscritos, $request->trimestre, $request->gpoGrado, $request->gpoClave);
        }
    }


    private static function PDF($secundaria_inscrito, $trimestre, $grado, $grupo)
    {
        $parametro_NombreArchivo = 'pdf_secundaria_recuperativos'; //nombre del archivo blade

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        // view('reportes.pdf.secundaria.concentrado_recuperativos.pdf_secundaria_recuperativos');
        $pdf = PDF::loadView('reportes.pdf.secundaria.concentrado_recuperativos.' . $parametro_NombreArchivo, [
           "secundaria_inscritos" => $secundaria_inscrito,
           "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
           "horaActual" => $fechaActual->format('H:i:s'),
           "nombreArchivo" => $parametro_NombreArchivo,
           "trimestre" => $trimestre,
           "grado" => $grado,
           "grupo" => $grupo
        ]);

        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    private static function EXCEL($secundaria_inscrito, $trimestre, $grado, $grupo)
    {
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
        $sheet->getColumnDimension('L')->setAutoSize(true);
        // $sheet->mergeCells("A1:I1");
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getFont()->setBold(true);

        $sheet->setCellValue('C1', "Secundaria ESCUELA MODELO");
        $sheet->setCellValue('C2', "LISTA DE RECUPERATIVOS");

        $sheet->setCellValue('C4', "Período: " . Utils::fecha_string($secundaria_inscrito[0]->perFechaInicial, 'mesCorto'). " al ".Utils::fecha_string($secundaria_inscrito[0]->perFechaFinal, 'mesCorto'));
        $sheet->setCellValue('C5', "Ubicación: " . $secundaria_inscrito[0]->ubiClave . " ".$secundaria_inscrito[0]->ubiNombre);
        $sheet->setCellValue('C6', "Nivel: " . $secundaria_inscrito[0]->depClave . " (".$secundaria_inscrito[0]->planClave.") ".$secundaria_inscrito[0]->progNombre);

        if($trimestre == "TRIMESTRE1"){
            $sheet->setCellValue('C7', "Trimestre: 1");
        }
        if($trimestre == "TRIMESTRE2"){
            $sheet->setCellValue('C7', "Trimestre: 2");
        }
        if($trimestre == "TRIMESTRE3"){
            $sheet->setCellValue('C7', "Trimestre: 3");
        }
        
        if($grado != ""){
            $sheet->setCellValue('C8', "Grado: ". $grado);
        }
        if($grupo != ""){
            $sheet->setCellValue('D8', "grupo: ". $grupo);
        }
        



        $sheet->getStyle("A10:J10")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 10, "Num");
        $sheet->setCellValueByColumnAndRow(2, 10, "Clave pago");
        $sheet->setCellValueByColumnAndRow(3, 10, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(4, 10, "Grado");
        $sheet->setCellValueByColumnAndRow(5, 10, "Grupo");
        $sheet->setCellValueByColumnAndRow(6, 10, "Materia");
        $sheet->setCellValueByColumnAndRow(7, 10, "Materia ACD");
        $sheet->setCellValueByColumnAndRow(8, 10, "Calificación Trim 1");
        $sheet->setCellValueByColumnAndRow(9, 10, "Calificación Recuperativo Trim 1");   
        
        $sheet->getStyle(1, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(2, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(3, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(4, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(5, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(6, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(7, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(8, 10)->getAlignment()->setHorizontal('center');
        $sheet->getStyle(9, 10)->getAlignment()->setHorizontal('center');



        $fila = 11;
        foreach($secundaria_inscrito as $key => $inscrito) {
            $sheet->setCellValue("A{$fila}", $key+1);
            $sheet->setCellValue("B{$fila}", $inscrito->aluClave);
            $sheet->setCellValue("C{$fila}", $inscrito->perApellido1." ".$inscrito->perApellido2." ".$inscrito->perNombre);

            $sheet->getStyle("D{$fila}")->getAlignment()->setHorizontal('center');
            $sheet->setCellValue("D{$fila}", $inscrito->gpoGrado);

            $sheet->getStyle("E{$fila}")->getAlignment()->setHorizontal('center');
            $sheet->setCellValue("E{$fila}", $inscrito->gpoClave);
            $sheet->setCellValue("F{$fila}", $inscrito->matClave." ".$inscrito->matNombre);
            $sheet->setCellValue("G{$fila}", $inscrito->gpoMatComplementaria);

            $sheet->getStyle("H{$fila}")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("I{$fila}")->getAlignment()->setHorizontal('center');

            if($trimestre == "TRIMESTRE1"){
                $sheet->setCellValue("H{$fila}", $inscrito->inscTrimestre1);                
                if ($inscrito->inscRecuperativoTrimestre1 != ""){
                    if($inscrito->inscRecuperativoTrimestre1 == -1){
                        $sheet->setCellValue("I{$fila}", "NP");
                    }else{
                        if($inscrito->inscRecuperativoTrimestre1 == 6 || $inscrito->inscRecuperativoTrimestre1 == 7){
                            $sheet->setCellValue("I{$fila}", number_format((float)$inscrito->inscRecuperativoTrimestre1, 0, '.', ''));
                            
                        }else{
                            $sheet->setCellValue("I{$fila}", number_format((float)$inscrito->inscRecuperativoTrimestre1, 1, '.', ''));
                        }
                    }
                    
                }
            }
            if($trimestre == "TRIMESTRE2"){
                $sheet->setCellValue("H{$fila}", $inscrito->inscTrimestre2);
                if ($inscrito->inscRecuperativoTrimestre2 != ""){
                    if($inscrito->inscRecuperativoTrimestre2 == -1){
                        $sheet->setCellValue("I{$fila}", "NP");
                    }else{
                        if($inscrito->inscRecuperativoTrimestre2 == 6 || $inscrito->inscRecuperativoTrimestre2 == 7){
                            $sheet->setCellValue("I{$fila}", number_format((float)$inscrito->inscRecuperativoTrimestre2, 0, '.', ''));
                            
                        }else{
                            $sheet->setCellValue("I{$fila}", number_format((float)$inscrito->inscRecuperativoTrimestre2, 1, '.', ''));
                        }
                    }
                    
                }
            }
            if($trimestre == "TRIMESTRE3"){
                $sheet->setCellValue("H{$fila}", $inscrito->inscTrimestre3);
                if ($inscrito->inscRecuperativoTrimestre3 != ""){
                    if($inscrito->inscRecuperativoTrimestre3 == -1){
                        $sheet->setCellValue("I{$fila}", "NP");
                    }else{
                        if($inscrito->inscRecuperativoTrimestre3 == 6 || $inscrito->inscRecuperativoTrimestre3 == 7){
                            $sheet->setCellValue("I{$fila}", number_format((float)$inscrito->inscRecuperativoTrimestre3, 0, '.', ''));
                            
                        }else{
                            $sheet->setCellValue("I{$fila}", number_format((float)$inscrito->inscRecuperativoTrimestre3, 1, '.', ''));
                        }
                    }
                    
                }
            }
            

            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("SecundariaConcentradoRecuperativos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("SecundariaConcentradoRecuperativos.xlsx"));
    }
}

<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BachillerSOCAACOController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.SOCA_ACO.create', [
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

        // $resultado_collection = DB::select('call procBachillerFormatoSOCAAcompaniamiento(?,?,?,?,?,?)', array(
        //     $perNumero,
        //     $perAnio,
        //     $ubiClave,
        //     $progClave,
        //     $cgtGradoSemestre,
        //     $cgtGrupo
        // ));

        // if(bachiller_extraordinarios.extTipo > 'RECUPERATIVO', 'REC', 'ACO')

        if($request->extFecha == ""){

        }
        $resultado_collection = DB::select("SELECT 
        alumnos.id as alumno_id,
        alumnos.aluMatricula AS matricula,
        personas.perApellido1 as apellido1,
        personas.perApellido2 as apellido2,
        personas.perNombre as nombres,	
        cgt.cgtGradoSemestre as semestre,
        1 as turno,
        cgt.cgtGrupo as grupo,
        'ACO' AS tipoEvaluacion,
        bachiller_extraordinarios.extTipo,
        periodos.id as periodo_id,
        bachiller_extraordinarios.extFecha
        FROM bachiller_inscritosextraordinarios
        INNER JOIN bachiller_extraordinarios ON bachiller_extraordinarios.id = bachiller_inscritosextraordinarios.extraordinario_id
        AND bachiller_extraordinarios.deleted_at IS NULL
        INNER JOIN bachiller_materias ON bachiller_materias.id = bachiller_extraordinarios.bachiller_materia_id
        AND bachiller_materias.deleted_at IS NULL
        INNER JOIN alumnos ON alumnos.id = bachiller_inscritosextraordinarios.alumno_id
        AND alumnos.deleted_at IS NULL
        INNER JOIN personas ON personas.id = alumnos.persona_id
        AND personas.deleted_at IS NULL
        INNER JOIN periodos ON periodos.id = bachiller_extraordinarios.periodo_id
        AND periodos.deleted_at IS NULL
        INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
        AND departamentos.deleted_at IS NULL
        INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id
        AND ubicacion.deleted_at IS NULL
        INNER JOIN cursos ON cursos.alumno_id = alumnos.id
        AND cursos.deleted_at IS NULL
        INNER JOIN cgt ON cgt.id = cursos.cgt_id
        AND cgt.deleted_at IS NULL
        INNER JOIN planes ON planes.id = cgt.plan_id
        AND planes.deleted_at IS NULL
        INNER JOIN programas ON programas.id = planes.programa_id
        AND programas.deleted_at IS NULL   
        WHERE bachiller_inscritosextraordinarios.deleted_at IS NULL
        AND periodos.id=$request->periodo_id
        and ubicacion.ubiClave='" . $ubiClave . "'
        and programas.progClave='" . $progClave . "'
        AND bachiller_inscritosextraordinarios.iexEstado <> 'C'
        AND bachiller_materias.matClasificacion IN ('B', 'O', 'U')
        ORDER BY
        personas.perApellido1 ASC,
        personas.perApellido2 ASC,
        personas.perNombre ASC");

        // ceil(cgt.cgtGradoSemestre / 2),
        
      

        $registroAlumnos = collect($resultado_collection);

        if($request->cgtGradoSemestre == "" && $request->cgtGrupo == ""){
            $registros = $registroAlumnos;
        }

        if($request->cgtGradoSemestre != "" && $request->cgtGrupo == ""){
            $registros = $registroAlumnos->where('semestre', '=', $request->cgtGradoSemestre);
        }

        if($request->cgtGradoSemestre == "" && $request->cgtGrupo != ""){
            $registros = $registroAlumnos->where('grupo', '=', $request->cgtGrupo);
        }

        if($request->cgtGradoSemestre != "" && $request->cgtGrupo != ""){
            $registros = $registroAlumnos->where('semestre', '=', $request->cgtGradoSemestre)->where('grupo', '=', $request->cgtGrupo);
        }

        if($request->extFecha != ""){
            $registros = $registroAlumnos->where('extFecha', '=', $request->extFecha);
        }else{
            $registros = $registros = $registroAlumnos;
        }
        
        

        // return count($registroAlumnos->groupBy('matricula'));


        if ($registros->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $datos_agrupados = collect($registros)->groupBy('matricula');


        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');


        return $this->generarExcel($datos_agrupados, $perNumero, $perAnio, $ubiClave, $progClave, $request->periodo_id, $request->extFecha);
    }


    public function generarExcel($datos_agrupados, $perNumero, $perAnio, $ubiClave, $progClave, $periodo_id, $extFecha)
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
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
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
        $sheet->setCellValueByColumnAndRow(9, 1, "Clave_Obl1");
        $sheet->setCellValueByColumnAndRow(10, 1, "Clave_Obl2");
        $sheet->setCellValueByColumnAndRow(11, 1, "Clave_Obl3");
        $sheet->setCellValueByColumnAndRow(12, 1, "Clave_Obl4");
        $sheet->setCellValueByColumnAndRow(13, 1, "Clave_Opt1");
        $sheet->setCellValueByColumnAndRow(14, 1, "Clave_Opt2");
        $sheet->setCellValueByColumnAndRow(15, 1, "Clave_Opt3");
        $sheet->setCellValueByColumnAndRow(16, 1, "Clave_Opt4");
        $sheet->setCellValueByColumnAndRow(17, 1, "Clave_Opt5");
        $sheet->setCellValueByColumnAndRow(18, 1, "Clave_Opt6");
        $sheet->setCellValueByColumnAndRow(19, 1, "Clave_Ocu1");
        $sheet->setCellValueByColumnAndRow(20, 1, "Clave_Ocu2");
        $sheet->setCellValueByColumnAndRow(21, 1, "Clave_Ocu3");
        $sheet->setCellValueByColumnAndRow(22, 1, "Clave_Ocu4");


        $fila = 2;

        $contador = 1;
        foreach ($datos_agrupados as $matricula => $valores) {
            foreach ($valores as $key => $alumno) {
                if ($alumno->matricula == $matricula && $contador++ == 1) {

                    $matri = DB::select("SELECT CONCAT(SUBSTR(alumnos.aluMatricula FROM 6 FOR 3),SUBSTR(alumnos.aluMatricula FROM 10 FOR 5)) AS 'aluMatricula' FROM alumnos WHERE id=$alumno->alumno_id");

                    $curs = DB::select("select cursos.id, cgt.cgtGradoSemestre 
                    from cursos 
                    INNER JOIN cgt ON cgt.id = cursos.cgt_id
                    INNER JOIN planes ON planes.id = cgt.plan_id
                    INNER JOIN programas ON programas.id = planes.programa_id
                    WHERE programas.progClave='BAC' AND cursos.alumno_id=$alumno->alumno_id order by cursos.id desc limit 1");

                    $sem = $curs[0]->cgtGradoSemestre;
                    $curso2 = DB::select("SELECT ceil($sem / 2) AS curso");
                    $cur = $curso2[0]->curso;

                    $gr = DB::select("select cursos.id, cgt.cgtGradoSemestre,
                        cgt.cgtGrupo,
                        cgt.cgtTurno
                        from cursos 
                        INNER JOIN cgt ON cgt.id = cursos.cgt_id
                        INNER JOIN planes ON planes.id = cgt.plan_id
                        INNER JOIN programas ON programas.id = planes.programa_id
                        WHERE programas.progClave='BAC' AND cursos.alumno_id=$alumno->alumno_id order by cursos.id desc limit 1");

                        $sems=$gr[0]->cgtGradoSemestre;
                        $gpo = $gr[0]->cgtGrupo;
                        $turno = $gr[0]->cgtTurno;

                        $grupo2 = DB::select("SELECT CONCAT(CEIL($sems / 2),'".$gpo."','-','".$turno."') AS grupo");

                        $grup = $grupo2[0]->grupo; 

                    

                    $sheet->setCellValueExplicit("A{$fila}", ($matri[0]->aluMatricula ?: ''), DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("B{$fila}", ($alumno->apellido1 ?: ''), DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("C{$fila}", ($alumno->apellido2 ?: ''), DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("D{$fila}", $alumno->nombres, DataType::TYPE_STRING);
                    $sheet->setCellValue("E{$fila}", $cur);
                    $sheet->setCellValueExplicit("F{$fila}", $grup, DataType::TYPE_STRING);
                    $sheet->setCellValue("G{$fila}", $alumno->turno);
                    $sheet->setCellValue("H{$fila}", $alumno->tipoEvaluacion);


                    // busca las basicas 
                    $basicas = DB::select("SELECT DISTINCT
                    bachiller_materias.matClave
                    FROM bachiller_inscritosextraordinarios
                    INNER JOIN bachiller_extraordinarios ON bachiller_extraordinarios.id = bachiller_inscritosextraordinarios.extraordinario_id
                    AND bachiller_extraordinarios.deleted_at IS NULL
                    INNER JOIN bachiller_materias ON bachiller_materias.id = bachiller_extraordinarios.bachiller_materia_id
                    AND bachiller_materias.deleted_at IS NULL
                    INNER JOIN alumnos ON alumnos.id = bachiller_inscritosextraordinarios.alumno_id
                    AND alumnos.deleted_at IS NULL
                    INNER JOIN personas ON personas.id = alumnos.persona_id
                    AND personas.deleted_at IS NULL
                    INNER JOIN periodos ON periodos.id = bachiller_extraordinarios.periodo_id
                    AND periodos.deleted_at IS NULL
                    INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
                    AND departamentos.deleted_at IS NULL
                    INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    AND ubicacion.deleted_at IS NULL
                    INNER JOIN cursos ON cursos.alumno_id = alumnos.id
                    AND cursos.deleted_at IS NULL
                    INNER JOIN cgt ON cgt.id = cursos.cgt_id
                    AND cgt.deleted_at IS NULL
                    INNER JOIN planes ON planes.id = cgt.plan_id
                    AND planes.deleted_at IS NULL
                    INNER JOIN programas ON programas.id = planes.programa_id
                    AND programas.deleted_at IS NULL   
                    WHERE bachiller_inscritosextraordinarios.deleted_at IS NULL
                    AND periodos.perNumero=$perNumero
                    AND periodos.perAnio=$perAnio
                    AND ubicacion.ubiClave='".$ubiClave."'
                    AND programas.progClave='".$progClave."'
					AND alumnos.id=$alumno->alumno_id
					AND bachiller_materias.matClasificacion='B'
                    AND bachiller_inscritosextraordinarios.iexCalificacion IS NULL
                    AND bachiller_inscritosextraordinarios.iexEstado <> 'C'");
                    $basicases = collect($basicas);

                    $obli1 = "";
                    $obli2 = "";
                    $obli3 = "";
                    $obli4 = "";
                    if(count($basicases) > 0){
                        if(!empty($basicases[0]->matClave)){
                            $obli1 = $basicases[0]->matClave;
                        }else{
                            $obli1 = "";
                        }
                       
                    }else{
                        $obli1 = "";
                    }  

                    if(count($basicases) > 0){
                        if(!empty($basicases[1]->matClave)){
                            $obli2 = $basicases[1]->matClave;
                        }else{
                            $obli2 = "";
                        }
                       
                    }else{
                        $obli2 = "";
                    }  

                    if(count($basicases) > 0){
                        if(!empty($basicases[2]->matClave)){
                            $obli3 = $basicases[2]->matClave;
                        }else{
                            $obli3 = "";
                        }
                       
                    }else{
                        $obli3 = "";
                    }  

                    if(count($basicases) > 0){
                        if(!empty($basicases[3]->matClave)){
                            $obli4 = $basicases[3]->matClave;
                        }else{
                            $obli4 = "";
                        }
                       
                    }else{
                        $obli4 = "";
                    }  

                    $sheet->setCellValueExplicit("I{$fila}", $obli1, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("J{$fila}", $obli2, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("K{$fila}", $obli3, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("L{$fila}", $obli4, DataType::TYPE_STRING);

                    // busca optativas 
                    $optati = DB::select("SELECT DISTINCT
                    bachiller_materias.matClave
                    FROM bachiller_inscritosextraordinarios
                    INNER JOIN bachiller_extraordinarios ON bachiller_extraordinarios.id = bachiller_inscritosextraordinarios.extraordinario_id
                    AND bachiller_extraordinarios.deleted_at IS NULL
                    INNER JOIN bachiller_materias ON bachiller_materias.id = bachiller_extraordinarios.bachiller_materia_id
                    AND bachiller_materias.deleted_at IS NULL
                    INNER JOIN alumnos ON alumnos.id = bachiller_inscritosextraordinarios.alumno_id
                    AND alumnos.deleted_at IS NULL
                    INNER JOIN personas ON personas.id = alumnos.persona_id
                    AND personas.deleted_at IS NULL
                    INNER JOIN periodos ON periodos.id = bachiller_extraordinarios.periodo_id
                    AND periodos.deleted_at IS NULL
                    INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
                    AND departamentos.deleted_at IS NULL
                    INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    AND ubicacion.deleted_at IS NULL
                    INNER JOIN cursos ON cursos.alumno_id = alumnos.id
                    AND cursos.deleted_at IS NULL
                    INNER JOIN cgt ON cgt.id = cursos.cgt_id
                    AND cgt.deleted_at IS NULL
                    INNER JOIN planes ON planes.id = cgt.plan_id
                    AND planes.deleted_at IS NULL
                    INNER JOIN programas ON programas.id = planes.programa_id
                    AND programas.deleted_at IS NULL   
                    WHERE bachiller_inscritosextraordinarios.deleted_at IS NULL
                    AND periodos.perNumero=$perNumero
                    AND periodos.perAnio=$perAnio
                    AND ubicacion.ubiClave='".$ubiClave."'
                    AND programas.progClave='".$progClave."'
					AND alumnos.id=$alumno->alumno_id
					AND bachiller_materias.matClasificacion='O'
                    AND bachiller_inscritosextraordinarios.iexCalificacion IS NULL
                    AND bachiller_inscritosextraordinarios.iexEstado <> 'C' ");
                    $optativas = collect($optati);

                  
                    if(count($optativas) > 0){
                        if(!empty($optativas[0]->matClave)){
                            $opta1 = $optativas[0]->matClave;
                        }else{
                            $opta1 = "";
                        }
                       
                    }else{
                        $opta1 = "";
                    }  

                    if(count($optativas) > 0){
                        if(!empty($optativas[1]->matClave)){
                            $opta2 = $optativas[1]->matClave;
                        }else{
                            $opta2 = "";
                        }
                       
                    }else{
                        $opta2 = "";
                    }  

                    if(count($optativas) > 0){
                        if(!empty($optativas[2]->matClave)){
                            $opta3 = $optativas[2]->matClave;
                        }else{
                            $opta3 = "";
                        }
                       
                    }else{
                        $opta3 = "";
                    }  

                    if(count($optativas) > 0){
                        if(!empty($optativas[3]->matClave)){
                            $opta4 = $optativas[3]->matClave;
                        }else{
                            $opta4 = "";
                        }
                       
                    }else{
                        $opta4 = "";
                    }  

                    if(count($optativas) > 0){
                        if(!empty($optativas[4]->matClave)){
                            $opta5 = $optativas[4]->matClave;
                        }else{
                            $opta5 = "";
                        }
                       
                    }else{
                        $opta5 = "";
                    }  

                    if(count($optativas) > 0){
                        if(!empty($optativas[5]->matClave)){
                            $opta6 = $optativas[5]->matClave;
                        }else{
                            $opta6 = "";
                        }
                       
                    }else{
                        $opta6 = "";
                    }  

                    $sheet->setCellValueExplicit("M{$fila}", $opta1, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("N{$fila}", $opta2, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("O{$fila}", $opta3, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("P{$fila}", $opta4, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("Q{$fila}", $opta5, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("R{$fila}", $opta6, DataType::TYPE_STRING);


                    // busca optativas 
                    $ocupacional = DB::select("SELECT DISTINCT
                    bachiller_materias.matClave
                    FROM bachiller_inscritosextraordinarios
                    INNER JOIN bachiller_extraordinarios ON bachiller_extraordinarios.id = bachiller_inscritosextraordinarios.extraordinario_id
                    AND bachiller_extraordinarios.deleted_at IS NULL
                    INNER JOIN bachiller_materias ON bachiller_materias.id = bachiller_extraordinarios.bachiller_materia_id
                    AND bachiller_materias.deleted_at IS NULL
                    INNER JOIN alumnos ON alumnos.id = bachiller_inscritosextraordinarios.alumno_id
                    AND alumnos.deleted_at IS NULL
                    INNER JOIN personas ON personas.id = alumnos.persona_id
                    AND personas.deleted_at IS NULL
                    INNER JOIN periodos ON periodos.id = bachiller_extraordinarios.periodo_id
                    AND periodos.deleted_at IS NULL
                    INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
                    AND departamentos.deleted_at IS NULL
                    INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    AND ubicacion.deleted_at IS NULL
                    INNER JOIN cursos ON cursos.alumno_id = alumnos.id
                    AND cursos.deleted_at IS NULL
                    INNER JOIN cgt ON cgt.id = cursos.cgt_id
                    AND cgt.deleted_at IS NULL
                    INNER JOIN planes ON planes.id = cgt.plan_id
                    AND planes.deleted_at IS NULL
                    INNER JOIN programas ON programas.id = planes.programa_id
                    AND programas.deleted_at IS NULL   
                    WHERE bachiller_inscritosextraordinarios.deleted_at IS NULL
                    AND periodos.perNumero=$perNumero
                    AND periodos.perAnio=$perAnio
                    AND ubicacion.ubiClave='".$ubiClave."'
                    AND programas.progClave='".$progClave."'
					AND alumnos.id=$alumno->alumno_id
					AND bachiller_materias.matClasificacion='U'
                    AND bachiller_inscritosextraordinarios.iexCalificacion IS NULL
                    AND bachiller_inscritosextraordinarios.iexEstado <> 'C' ");
                    $ocupacionales = collect($ocupacional);

                  
                    if(count($ocupacionales) > 0){
                        if(!empty($ocupacionales[0]->matClave)){
                            $ocupa1 = $ocupacionales[0]->matClave;
                        }else{
                            $ocupa1 = "";
                        }
                       
                    }else{
                        $ocupa1 = "";
                    }  

                    if(count($ocupacionales) > 0){
                        if(!empty($ocupacionales[1]->matClave)){
                            $ocupa2 = $ocupacionales[1]->matClave;
                        }else{
                            $ocupa2 = "";
                        }
                       
                    }else{
                        $ocupa2 = "";
                    }  

                    if(count($ocupacionales) > 0){
                        if(!empty($ocupacionales[2]->matClave)){
                            $ocupa3 = $ocupacionales[2]->matClave;
                        }else{
                            $ocupa3 = "";
                        }
                       
                    }else{
                        $ocupa3 = "";
                    }  

                    if(count($ocupacionales) > 0){
                        if(!empty($ocupacionales[3]->matClave)){
                            $ocupa4 = $ocupacionales[3]->matClave;
                        }else{
                            $ocupa4 = "";
                        }
                       
                    }else{
                        $ocupa4 = "";
                    }  

                    $sheet->setCellValueExplicit("S{$fila}", $ocupa1, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("T{$fila}", $ocupa2, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("U{$fila}", $ocupa3, DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("V{$fila}", $ocupa4, DataType::TYPE_STRING);

                    $fila++;
                }
            }



            $contador = 1;
        }

        $writer = new Xlsx($spreadsheet);
     

        try {
            $writer->save(storage_path("SOCA (ACO) - ".$extFecha.".xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("SOCA (ACO) - ".$extFecha.".xlsx"));


    }
}
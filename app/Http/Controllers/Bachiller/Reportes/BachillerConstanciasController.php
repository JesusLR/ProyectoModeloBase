<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Curso;
use App\Http\Models\Primaria\Primaria_inscrito;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Minutario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerConstanciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function imprimirCartaConducta($id_curso)
    {
        // query de seleccion de alumno 
        $curso_alumno = Curso::select(
            "cursos.id",
            "alumnos.id as alumno_id",
            "alumnos.aluClave",
            "alumnos.aluMatricula",
            "personas.id as persona_id",
            "personas.perNombre",
            "personas.perApellido1",
            "personas.perApellido2",
            "personas.perSexo",
            "cgt.id as cgt_id",
            "cgt.cgtGradoSemestre",
            "cgt.cgtGrupo",
            "periodos.id as periodo_id",
            "periodos.perAnioPago",
            "ubicacion.ubiClave",
            "departamentos.depClave"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();


        $parametro_genero_alumno = "";
        $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_clave_ubicacion = $curso_alumno->ubiClave;
        $parametro_matricula = $curso_alumno->aluMatricula;



        //Validamos el campus para consulta correspondiente
        if($parametro_clave_ubicacion == "CME" || $parametro_clave_ubicacion == "CVA" || $parametro_clave_ubicacion == "CMT"){
            // buscar el grupo al que el alumno pertenece 
            $resultado_array =  DB::select("call procBachillerObtieneGrupoCursoYucatan(" . $id_curso . ")");   
        }else{
            // buscar el grupo al que el alumno pertenece 
            $resultado_array =  DB::select("call procBachillerObtieneGrupoCursoChetumal(" . $id_curso . ")");   
        }

            

        if(empty($resultado_array)){
            alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
            return back()->withInput();
        }
        $resultado_grupo = collect($resultado_array);
        $parametro_grupo = $resultado_grupo[0]->gpoClave;


        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $es = "La alumna";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $es = "El alumno";
        }

        // valida que grado es para escribir lo que corresponda 
        $gradoEnLetras = "";
        if ($parametro_grado == 1) {
            $gradoEnLetras = "PRIMER GRADO";
        }
        if ($parametro_grado == 2) {
            $gradoEnLetras = "SEGUNDO GRADO";
        }
        if ($parametro_grado == 3) {
            $gradoEnLetras = "TERCER GRADO";
        }
        if ($parametro_grado == 4) {
            $gradoEnLetras = "CUARTO GRADO";
        }
        if ($parametro_grado == 5) {
            $gradoEnLetras = "QUINTO GRADO";
        }
        if ($parametro_grado == 6) {
            $gradoEnLetras = "SEXTO GRADO";
        }

        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');

       // meeses en letras 
       $mesLetras = "";
       if ($fechaMes == "01") {
           $mesLetras = "Enero";
       }
       if ($fechaMes == "02") {
           $mesLetras = "Febrero";
       }
       if ($fechaMes == "03") {
           $mesLetras = "Marzo";
       }
       if ($fechaMes == "04") {
           $mesLetras = "Abril";
       }
       if ($fechaMes == "05") {
           $mesLetras = "Mayo";
       }
       if ($fechaMes == "06") {
           $mesLetras = "Junio";
       }
       if ($fechaMes == "07") {
           $mesLetras = "Julio";
       }
       if ($fechaMes == "08") {
           $mesLetras = "Agosto";
       }
       if ($fechaMes == "09") {
           $mesLetras = "Septiembre";
       }
       if ($fechaMes == "10") {
           $mesLetras = "Octubre";
       }
       if ($fechaMes == "11") {
           $mesLetras = "Noviembre";
       }
       if ($fechaMes == "12") {
           $mesLetras = "Diciembre";
       }


       $diaEnletras = ['a un día', 'a los dos días', 'a los tres días',
       'a los cuatro días', 'a los cinco días', 'a los seis días', 'a los siete días', 'a los cho días', 'a los nueve días', 'a los diez días', 'a los once días'
       ,'a los doce días', 'a los trece días', 'a los catorce días', 'a los quince días', 'a los dieciséis días', 'a los diecisiete días', 'a los dieciocho días',
       'a los diecinueve días', 'a los veinte días', 'a los veintiuno días', 'a los veintidos días', 'a los veintitres días', 'a los veinticuatro días', 'a los veinticinco días',
       'a los veintiseis días','a los veintisiete días',
       'a los veintiocho días', 'a los veintinueve días','a los treinta días', 'a los treinta y un días'];

       $fechaDiaLetra = $diaEnletras[$fechaDia-1];

       if($fechaAnio == "2019"){
           $anoLEtras = "dos mil diecinueve";
       }
       if($fechaAnio == "2020"){
           $anoLEtras = "dos mil veinte";
       }
       if($fechaAnio == "2021"){
           $anoLEtras = "dos mil veintiuno";
       }
       if($fechaAnio == "2022"){
           $anoLEtras = "dos mil veintidos";
       }
       if($fechaAnio == "2023"){
           $anoLEtras = "dos mil veintitres";
       }
       if($fechaAnio == "2024"){
           $anoLEtras = "dos mil veinticuatro";
       }
       if($fechaAnio == "2025"){
           $anoLEtras = "dos mil veinticinco";
       }
       

       if($parametro_clave_ubicacion == "CME"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        if($parametro_clave_ubicacion == "CVA"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }

         // Guardamos registro 
         $minutario = Minutario::create([
            'minAnio' => $curso_alumno->perAnioPago,
            'minClavePago' => $curso_alumno->aluClave,
            'minCursoID' => $curso_alumno->id,
            'minDepartamento' => $curso_alumno->depClave,
            'minTipo' => "CO",
            'minNombreDocumento' => "CONSTANCIA DE CONDUCTA",
            'minFecha' =>  $fechaActual->format('Y-m-d')
        ]);

        $parametro_NombreArchivo = "pdf_Bachiller_carta_conducta";
        $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "es" => $es,
            "parametro_clave_ubicacion" => $parametro_clave_ubicacion,
            "mesLetras" => $mesLetras,
            "fechaDiaLetra" => $fechaDiaLetra,
            "anoLEtras" => $anoLEtras,
            "minutario" => $minutario,
            "parametro_matricula" => $parametro_matricula
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$parametro_grado.$parametro_grupo.'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    public function imprimirConstanciaEstudio($id_curso)
    {

        // query de seleccion de alumno 
        $curso_alumno = Curso::select(
            "cursos.id",
            "alumnos.id as alumno_id",
            "alumnos.aluClave",
            "alumnos.aluMatricula",
            "personas.id as persona_id",
            "personas.perNombre",
            "personas.perApellido1",
            "personas.perApellido2",
            "personas.perSexo",
            "cgt.id as cgt_id",
            "cgt.cgtGradoSemestre",
            "cgt.cgtGrupo",
            "periodos.id as periodo_id",
            "periodos.perAnioPago",
            "ubicacion.ubiClave"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();


        $parametro_genero_alumno = "";
        $parametro_consideracion = "";
        $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_matricula = $curso_alumno->aluMatricula;
        $parametro_clave = $curso_alumno->aluClave;
        $parametro_ubicacion_clave = $curso_alumno->ubiClave;

        if($parametro_ubicacion_clave == "CME" || $parametro_ubicacion_clave == "CVA"){
            $resultado_array =  DB::select("call procBachillerObtieneGrupoCursoYucatan(" . $id_curso . ")");
        }

        if($parametro_ubicacion_clave == "CCH"){
            $resultado_array =  DB::select("call procBachillerObtieneGrupoCursoChetumal(" . $id_curso . ")");
        }

        // buscar el grupo al que el alumno pertenece 

        if(empty($resultado_array)){
            alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
            return back()->withInput();
        }
        $resultado_grupo = collect($resultado_array);
        $parametro_grupo = $resultado_grupo[0]->gpoClave;


        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $parametro_consideracion = "está considerada como alumna ";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $parametro_consideracion = "es alumno ";
        }

        // valida que grado es para escribir lo que corresponda 
        $gradoEnLetras = "";
        if ($parametro_grado == 1) {
            $gradoEnLetras = "PRIMER GRADO";
        }
        if ($parametro_grado == 2) {
            $gradoEnLetras = "SEGUNDO GRADO";
        }
        if ($parametro_grado == 3) {
            $gradoEnLetras = "TERCER GRADO";
        }
        if ($parametro_grado == 4) {
            $gradoEnLetras = "CUARTO GRADO";
        }
        if ($parametro_grado == 5) {
            $gradoEnLetras = "QUINTO GRADO";
        }
        if ($parametro_grado == 6) {
            $gradoEnLetras = "SEXTO GRADO";
        }

        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');


        $mesLetras = "";
        if ($fechaMes == "01") {
            $mesLetras = "ENERO";
        }
        if ($fechaMes == "02") {
            $mesLetras = "FEBRERO";
        }
        if ($fechaMes == "03") {
            $mesLetras = "MARZO";
        }
        if ($fechaMes == "04") {
            $mesLetras = "ABRIL";
        }
        if ($fechaMes == "05") {
            $mesLetras = "MAYO";
        }
        if ($fechaMes == "06") {
            $mesLetras = "JUNIO";
        }
        if ($fechaMes == "07") {
            $mesLetras = "JULIO";
        }
        if ($fechaMes == "08") {
            $mesLetras = "AGOSTO";
        }
        if ($fechaMes == "09") {
            $mesLetras = "SEPTIEMBRE";
        }
        if ($fechaMes == "10") {
            $mesLetras = "OCTUBRE";
        }
        if ($fechaMes == "11") {
            $mesLetras = "NOVIEMBRE";
        }
        if ($fechaMes == "12") {
            $mesLetras = "DICIEMBRE";
        }


        // fecha que se mostrara en PDF 
        if($parametro_ubicacion_clave == "CME"){
            $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }
        if($parametro_ubicacion_clave == "CVA"){
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }

        $parametro_NombreArchivo = "pdf_Bachiller_constancia_estudios";
        $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,     
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_ubicacion_clave" => $parametro_ubicacion_clave 
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$parametro_grado.$parametro_grupo.'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    public function imprimirConstanciaNoAdeudo($id_curso)
    {
        
        // query de seleccion de alumno 
        $curso_alumno = Curso::select(
            "cursos.id",
            "alumnos.id as alumno_id",
            "alumnos.aluClave",
            "alumnos.aluMatricula",
            "personas.id as persona_id",
            "personas.perNombre",
            "personas.perApellido1",
            "personas.perApellido2",
            "personas.perSexo",
            "cgt.id as cgt_id",
            "cgt.cgtGradoSemestre",
            "cgt.cgtGrupo",
            "periodos.id as periodo_id",
            "periodos.perAnioPago",
            "ubicacion.ubiClave"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();


        $parametro_genero_alumno = "";
        $parametro_consideracion = "";
        $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_matricula = $curso_alumno->aluMatricula;
        $parametro_clave = $curso_alumno->aluClave;
        $parametro_clave_ubicacion = $curso_alumno->ubiClave;


        // buscar el grupo al que el alumno pertenece 
        $resultado_array =  DB::select("call procBachillerObtieneGrupoCurso(" . $id_curso . ")");       

        if(empty($resultado_array)){
            alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
            return back()->withInput();
        }
        $resultado_grupo = collect($resultado_array);
        $parametro_grupo = $resultado_grupo[0]->gpoClave;

        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $parametro_consideracion = "fue alumna  ";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $parametro_consideracion = "fue alumno  ";
        }

        // valida que grado es para escribir lo que corresponda 
        $gradoEnLetras = "";
        if ($parametro_grado == 1) {
            $gradoEnLetras = "PRIMER GRADO";
        }
        if ($parametro_grado == 2) {
            $gradoEnLetras = "SEGUNDO GRADO";
        }
        if ($parametro_grado == 3) {
            $gradoEnLetras = "TERCER GRADO";
        }
        if ($parametro_grado == 4) {
            $gradoEnLetras = "CUARTO GRADO";
        }
        if ($parametro_grado == 5) {
            $gradoEnLetras = "QUINTO GRADO";
        }
        if ($parametro_grado == 6) {
            $gradoEnLetras = "SEXTO GRADO";
        }

        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');


        $mesLetras = "";
        if ($fechaMes == "01") {
            $mesLetras = "ENERO";
        }
        if ($fechaMes == "02") {
            $mesLetras = "FEBRERO";
        }
        if ($fechaMes == "03") {
            $mesLetras = "MARZO";
        }
        if ($fechaMes == "04") {
            $mesLetras = "ABRIL";
        }
        if ($fechaMes == "05") {
            $mesLetras = "MAYO";
        }
        if ($fechaMes == "06") {
            $mesLetras = "JUNIO";
        }
        if ($fechaMes == "07") {
            $mesLetras = "JULIO";
        }
        if ($fechaMes == "08") {
            $mesLetras = "AGOSTO";
        }
        if ($fechaMes == "09") {
            $mesLetras = "SEPTIEMBRE";
        }
        if ($fechaMes == "10") {
            $mesLetras = "OCTUBRE";
        }
        if ($fechaMes == "11") {
            $mesLetras = "NOVIEMBRE";
        }
        if ($fechaMes == "12") {
            $mesLetras = "DICIEMBRE";
        }


        // fecha que se mostrara en PDF 
        if($parametro_clave_ubicacion == "CME"){
            $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }
        if($parametro_clave_ubicacion == "CVA"){
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }

        $parametro_NombreArchivo = "pdf_Bachiller_constancia_NoAdeudo";
        $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,     
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_clave_ubicacion" => $parametro_clave_ubicacion     
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$parametro_grado.$parametro_grupo.'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    // constancia de cupo 
    public function imprimirConstanciaCupo($id_curso, $tipoConstancia)
    {


        $inscrito = DB::select("SELECT DISTINCT
            sm.matClave, 
            sm.matNombre,
            sm.matNombreCorto,
            sm.id as materia_id,
            si.inscTrimestre1 as trimestre1,
            si.inscTrimestre2 as trimestre2,
            si.inscTrimestre3 as trimestre3,
            si.inscPromedioTrim as promedioTrimestre,
            sg.gpoGrado,
            sg.gpoClave,
            cgt.cgtGrupo,
            periodos.perAnioPago,
            personas.perNombre,
            personas.perApellido1,
            personas.perApellido2,
            personas.perSexo,
            ubicacion.ubiClave
        FROM
        cursos
        INNER JOIN periodos ON cursos.periodo_id = periodos.id
        AND periodos.deleted_at IS NULL
        INNER JOIN cgt ON cursos.cgt_id = cgt.id
        AND cgt.deleted_at IS NULL
        INNER JOIN planes ON cgt.plan_id = planes.id
        AND planes.deleted_at IS NULL
        INNER JOIN programas ON planes.programa_id = programas.id
        AND programas.deleted_at IS NULL
        INNER JOIN escuelas ON programas.escuela_id = escuelas.id
        AND escuelas.deleted_at IS NULL
        INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
        AND departamentos.deleted_at IS NULL
        INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
        AND ubicacion.deleted_at IS NULL
            INNER JOIN Bachiller_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN Bachiller_grupos sg ON sg.id = si.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN Bachiller_materias sm ON sm.id = sg.Bachiller_materia_id
            AND sg.deleted_at IS NULL
                                INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
                                AND alumnos.deleted_at IS NULL
                                INNER JOIN personas on alumnos.persona_id = personas.id
                                AND personas.deleted_at IS NULL
        WHERE
            cursos.id = $id_curso
            AND departamentos.depClave = 'SEC'										
            AND sm.matClave NOT LIKE ('ART%')
            AND sm.matClave NOT LIKE ('TEC%')
            AND sm.matClave NOT LIKE ('FIN%')
            AND sm.matClave NOT LIKE ('TUT%')
            AND sm.matClave NOT LIKE ('DVE%')
            AND sm.matClave NOT LIKE ('LAB%')
            AND sm.matClave NOT LIKE ('OYT%')
            AND sm.matClave NOT LIKE ('TALLE%')
            AND sm.matClave NOT LIKE ('RPY%')
            ORDER BY sm.matClave asc");

        if (count($inscrito) == 0) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }
        $parametro_alumno = $inscrito[0]->perApellido1 . ' ' . $inscrito[0]->perApellido2 . ' ' . $inscrito[0]->perNombre;
        $parametro_grupo = $inscrito[0]->cgtGrupo;
        $parametro_periodo_incio = $inscrito[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$inscrito[0]->perAnioPago;
        $parametro_periodo_sig = 1 + $parametro_periodo_fin;
        $parametro_ubicacion = $inscrito[0]->ubiClave;

        // valida el genero
        if ($inscrito[0]->perSexo == "F") {
            $parametro_genero_alumno = "que la alumna";
        } else {
            $parametro_genero_alumno = "que el alumno";
        }


        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');

        // valida que grado es para escribir lo que corresponda 
        $gradoEnLetras = "";
        $gradoSiguiente = "";
        $nivel = "";
        if ($inscrito[0]->gpoGrado == 1) {
            $gradoEnLetras = "primer grado";
            $gradoSiguiente = "2do";
            $nivel = "Bachiller";
        }
        if ($inscrito[0]->gpoGrado == 2) {
            $gradoEnLetras = "segundo grado";
            $gradoSiguiente = "3er";
            $nivel = "Bachiller";
        }
        if ($inscrito[0]->gpoGrado == 3) {
            $gradoEnLetras = "tercer grado";
            $gradoSiguiente = "1er";
            $nivel = "preparatoria";
        }
        //  if ($inscrito[0]->gpoGrado == 4) {
        //      $gradoEnLetras = "cuarto grado";
        //      $gradoSiguiente = "5to";
        //  }
        //  if ($inscrito[0]->gpoGrado == 5) {
        //      $gradoEnLetras = "quinto grado";
        //      $gradoSiguiente = "6to";
        //  }
        //  if ($inscrito[0]->gpoGrado == 6) {
        //      $gradoEnLetras = "sexto grado";
        //      $gradoSiguiente = "";
        //  }

        // meeses en letras 
        $mesLetras = "";
        if ($fechaMes == "01") {
            $mesLetras = "Enero";
        }
        if ($fechaMes == "02") {
            $mesLetras = "Febrero";
        }
        if ($fechaMes == "03") {
            $mesLetras = "Marzo";
        }
        if ($fechaMes == "04") {
            $mesLetras = "Abril";
        }
        if ($fechaMes == "05") {
            $mesLetras = "Mayo";
        }
        if ($fechaMes == "06") {
            $mesLetras = "Junio";
        }
        if ($fechaMes == "07") {
            $mesLetras = "Julio";
        }
        if ($fechaMes == "08") {
            $mesLetras = "Agosto";
        }
        if ($fechaMes == "09") {
            $mesLetras = "Septiembre";
        }
        if ($fechaMes == "10") {
            $mesLetras = "Octubre";
        }
        if ($fechaMes == "11") {
            $mesLetras = "Noviembre";
        }
        if ($fechaMes == "12") {
            $mesLetras = "Diciembre";
        }


        if($parametro_ubicacion == "CME"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        if($parametro_ubicacion == "CVA"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        

        // view('reportes.pdf.Bachiller.constancias.pdf_Bachiller_constancia_cupo');

        if($tipoConstancia == "membretada"){
            $parametro_NombreArchivo = "pdf_Bachiller_constancia_cupo";
                $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                'inscrito' => $inscrito,
                'fechaHoy' => $fechahoy,
                'alumno' => $parametro_alumno,
                'genero' => $parametro_genero_alumno,
                'grado' => $gradoEnLetras,
                'grupo' => $parametro_grupo,
                'periodo_inicio' => $parametro_periodo_incio,
                'periodo_fin' => $parametro_periodo_fin,
                'periodo_siguiente' => $parametro_periodo_sig,
                'gradoSiguiente' => $gradoSiguiente,
                'nivel' => $nivel,
                'parametro_ubicacion' => $parametro_ubicacion
            ]);
        }

        if($tipoConstancia == "digital"){
            $parametro_NombreArchivo = "pdf_Bachiller_constancia_cupo_digital";
                $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                'inscrito' => $inscrito,
                'fechaHoy' => $fechahoy,
                'alumno' => $parametro_alumno,
                'genero' => $parametro_genero_alumno,
                'grado' => $gradoEnLetras,
                'grupo' => $parametro_grupo,
                'periodo_inicio' => $parametro_periodo_incio,
                'periodo_fin' => $parametro_periodo_fin,
                'periodo_siguiente' => $parametro_periodo_sig,
                'gradoSiguiente' => $gradoSiguiente,
                'nivel' => $nivel,
                'parametro_ubicacion' => $parametro_ubicacion
            ]);
        }
        

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    // constancia de promedio final 
    public function imprimirConstanciaPromedioFinal($id_curso, $tipoConstancia)
    {


        $inscrito = DB::select("SELECT DISTINCT
            sm.matClave, 
            sm.matNombre,
            sm.matNombreCorto,
            sm.id as materia_id,
            si.inscTrimestre1 as trimestre1,
            si.inscTrimestre2 as trimestre2,
            si.inscTrimestre3 as trimestre3,
            si.inscPromedioTrim as promedioTrimestre,
            sg.gpoGrado,
            sg.gpoClave,
            cgt.cgtGrupo,
            periodos.perAnioPago,
            personas.perNombre,
            personas.perApellido1,
            personas.perApellido2,
            personas.perSexo,
            ubicacion.ubiClave
        FROM
        cursos
        INNER JOIN periodos ON cursos.periodo_id = periodos.id
        AND periodos.deleted_at IS NULL
        INNER JOIN cgt ON cursos.cgt_id = cgt.id
        AND cgt.deleted_at IS NULL
        INNER JOIN planes ON cgt.plan_id = planes.id
        AND planes.deleted_at IS NULL
        INNER JOIN programas ON planes.programa_id = programas.id
        AND programas.deleted_at IS NULL
        INNER JOIN escuelas ON programas.escuela_id = escuelas.id
        AND escuelas.deleted_at IS NULL
        INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
        AND departamentos.deleted_at IS NULL
        INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
        AND ubicacion.deleted_at IS NULL
            INNER JOIN Bachiller_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN Bachiller_grupos sg ON sg.id = si.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN Bachiller_materias sm ON sm.id = sg.Bachiller_materia_id
            AND sg.deleted_at IS NULL
                                INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
                                AND alumnos.deleted_at IS NULL
                                INNER JOIN personas on alumnos.persona_id = personas.id
                                AND personas.deleted_at IS NULL
        WHERE
            cursos.id = $id_curso
            AND departamentos.depClave = 'SEC'										
            AND sm.matClave NOT LIKE ('ART%')
            AND sm.matClave NOT LIKE ('TEC%')
            AND sm.matClave NOT LIKE ('FIN%')
            AND sm.matClave NOT LIKE ('TUT%')
            AND sm.matClave NOT LIKE ('DVE%')
            AND sm.matClave NOT LIKE ('LAB%')
            AND sm.matClave NOT LIKE ('OYT%')
            AND sm.matClave NOT LIKE ('TALLE%')
            AND sm.matClave NOT LIKE ('RPY%')
            ORDER BY sm.matClave asc");

        if (count($inscrito) == 0) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }
        $parametro_alumno = $inscrito[0]->perApellido1 . ' ' . $inscrito[0]->perApellido2 . ' ' . $inscrito[0]->perNombre;
        $parametro_grupo = $inscrito[0]->cgtGrupo;
        $parametro_periodo_incio = $inscrito[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$inscrito[0]->perAnioPago;
        $parametro_periodo_sig = 1 + $parametro_periodo_fin;
        $parametro_ubicacion = $inscrito[0]->ubiClave;

        // valida el genero
        if ($inscrito[0]->perSexo == "F") {
            $parametro_genero_alumno = "que la alumna";
        } else {
            $parametro_genero_alumno = "que el alumno";
        }


        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');

        // valida que grado es para escribir lo que corresponda 
        $gradoEnLetras = "";
        $gradoSiguiente = "";
        $nivel = "";
        if ($inscrito[0]->gpoGrado == 1) {
            $gradoEnLetras = "primer grado";
            $gradoSiguiente = "2do";
            $nivel = "Bachiller";
        }
        if ($inscrito[0]->gpoGrado == 2) {
            $gradoEnLetras = "segundo grado";
            $gradoSiguiente = "3er";
            $nivel = "Bachiller";
        }
        if ($inscrito[0]->gpoGrado == 3) {
            $gradoEnLetras = "tercer grado";
            $gradoSiguiente = "1er";
            $nivel = "preparatoria";
        }
        //  if ($inscrito[0]->gpoGrado == 4) {
        //      $gradoEnLetras = "cuarto grado";
        //      $gradoSiguiente = "5to";
        //  }
        //  if ($inscrito[0]->gpoGrado == 5) {
        //      $gradoEnLetras = "quinto grado";
        //      $gradoSiguiente = "6to";
        //  }
        //  if ($inscrito[0]->gpoGrado == 6) {
        //      $gradoEnLetras = "sexto grado";
        //      $gradoSiguiente = "";
        //  }

        // meeses en letras 
        $mesLetras = "";
        if ($fechaMes == "01") {
            $mesLetras = "Enero";
        }
        if ($fechaMes == "02") {
            $mesLetras = "Febrero";
        }
        if ($fechaMes == "03") {
            $mesLetras = "Marzo";
        }
        if ($fechaMes == "04") {
            $mesLetras = "Abril";
        }
        if ($fechaMes == "05") {
            $mesLetras = "Mayo";
        }
        if ($fechaMes == "06") {
            $mesLetras = "Junio";
        }
        if ($fechaMes == "07") {
            $mesLetras = "Julio";
        }
        if ($fechaMes == "08") {
            $mesLetras = "Agosto";
        }
        if ($fechaMes == "09") {
            $mesLetras = "Septiembre";
        }
        if ($fechaMes == "10") {
            $mesLetras = "Octubre";
        }
        if ($fechaMes == "11") {
            $mesLetras = "Noviembre";
        }
        if ($fechaMes == "12") {
            $mesLetras = "Diciembre";
        }


        $diaEnletras = ['a un día', 'a los dos días', 'a los tres días',
        'a los cuatro días', 'a los cinco días', 'a los seis días', 'a los siete días', 'a los cho días', 'a los nueve días', 'a los diez días', 'a los once días'
        ,'a los doce días', 'a los trece días', 'a los catorce días', 'a los quince días', 'a los dieciséis días', 'a los diecisiete días', 'a los dieciocho días',
        'a los diecinueve días', 'a los veinte días', 'a los veintiuno días', 'a los veintidos días', 'a los veintitres días', 'a los veinticuatro días', 'a los veinticinco días',
        'a los veintiseis días','a los veintisiete días',
        'a los veintiocho días', 'a los veintinueve días','a los treinta días', 'a los treinta y un días'];

        $fechaDiaLetra = $diaEnletras[$fechaDia-1];

        if($fechaAnio == "2019"){
            $anoLEtras = "dos mil diecinueve";
        }
        if($fechaAnio == "2020"){
            $anoLEtras = "dos mil veinte";
        }
        if($fechaAnio == "2021"){
            $anoLEtras = "dos mil veintiuno";
        }
        if($fechaAnio == "2022"){
            $anoLEtras = "dos mil veintidos";
        }
        if($fechaAnio == "2023"){
            $anoLEtras = "dos mil veintitres";
        }
        if($fechaAnio == "2024"){
            $anoLEtras = "dos mil veinticuatro";
        }
        if($fechaAnio == "2025"){
            $anoLEtras = "dos mil veinticinco";
        }
        

        if($parametro_ubicacion == "CME"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        if($parametro_ubicacion == "CVA"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        

        // view('reportes.pdf.Bachiller.constancias.pdf_Bachiller_constancia_cupo');

        if($tipoConstancia == "membretada"){
            $parametro_NombreArchivo = "pdf_Bachiller_constancia_cupo";
                $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                'inscrito' => $inscrito,
                'fechaHoy' => $fechahoy,
                'alumno' => $parametro_alumno,
                'genero' => $parametro_genero_alumno,
                'grado' => $gradoEnLetras,
                'grupo' => $parametro_grupo,
                'periodo_inicio' => $parametro_periodo_incio,
                'periodo_fin' => $parametro_periodo_fin,
                'periodo_siguiente' => $parametro_periodo_sig,
                'gradoSiguiente' => $gradoSiguiente,
                'nivel' => $nivel,
                'parametro_ubicacion' => $parametro_ubicacion
            ]);
        }

        if($tipoConstancia == "digital"){
            $parametro_NombreArchivo = "pdf_Bachiller_constancia_promedio_final_digital";
                $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                'inscrito' => $inscrito,
                'fechaHoy' => $fechahoy,
                'alumno' => $parametro_alumno,
                'genero' => $parametro_genero_alumno,
                'grado' => $gradoEnLetras,
                'grupo' => $parametro_grupo,
                'periodo_inicio' => $parametro_periodo_incio,
                'periodo_fin' => $parametro_periodo_fin,
                'periodo_siguiente' => $parametro_periodo_sig,
                'gradoSiguiente' => $gradoSiguiente,
                'nivel' => $nivel,
                'parametro_ubicacion' => $parametro_ubicacion,
                'fechaDiaLetra' => $fechaDiaLetra,
                'mesLetras' => $mesLetras,
                'anoLEtras' => $anoLEtras
            ]);
        }
        

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function imprimirConstanciaArtesTalleres($id_curso, $tipoConstancia)
    {


        // llama al procedure de los alumnos a buscar 
        $resultado_array =  DB::select("call procBachillerConstanciaArtesTalleres(".$id_curso.")");

        $resultado_collection = collect($resultado_array);

        // si no hay datos muestra alerta 
        if ($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }


        $parametro_ubicacion = $resultado_collection[0]->ubicacion;
        $alumno = $resultado_collection[0]->nombres.' '.$resultado_collection[0]->ape_paterno.' '.$resultado_collection[0]->ape_materno;
        // valida el genero
        if ($resultado_collection[0]->sexoAlumno == "F") {
            $parametro_genero_alumno = "que la alumna";
        } else {
            $parametro_genero_alumno = "que el alumno";
        }


        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');

     
        $mesLetras = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        if($parametro_ubicacion == "CME"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras[$fechaMes-1] . ' de ' . $fechaAnio;
        }
        if($parametro_ubicacion == "CVA"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras[$fechaMes-1] . ' de ' . $fechaAnio;
        }
        

        // view('reportes.pdf.Bachiller.constancias.pdf_Bachiller_constancia_cupo');

        if($tipoConstancia == "membretada"){
            $parametro_NombreArchivo = "pdf_Bachiller_constancia_taller_artes";
                $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                
            ]);
        }

        if($tipoConstancia == "digital"){
            $parametro_NombreArchivo = "pdf_Bachiller_constancia_taller_artes";
                $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                    'fechahoy' => $fechahoy,
                    'parametro_ubicacion' => $parametro_ubicacion,
                    'alumno' => $alumno,
                    'materiasComplementarias' => $resultado_collection,
                    'parametro_genero_alumno' => $parametro_genero_alumno     
            ]);
        }
        

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    public function imprimirConstanciaInscripcion($id_curso, $tipoConstancia)
    {


        // query de seleccion de alumno 
        $curso_alumno = Curso::select(
            "cursos.id",
            "alumnos.id as alumno_id",
            "alumnos.aluClave",
            "alumnos.aluMatricula",
            "personas.id as persona_id",
            "personas.perNombre",
            "personas.perApellido1",
            "personas.perApellido2",
            "personas.perSexo",
            "cgt.id as cgt_id",
            "cgt.cgtGradoSemestre",
            "cgt.cgtGrupo",
            "periodos.id as periodo_id",
            "periodos.perNumero",
            "periodos.perAnioPago",
            "periodos.perFechaInicial",
            "periodos.perFechaFinal",
            "ubicacion.ubiClave",
            "departamentos.depClave"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();

        // si no hay datos muestra alerta 
        if ($curso_alumno == "") {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }

        

        $parametro_ubicacion = $curso_alumno->ubiClave;
        $alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametroGrado = $curso_alumno->cgtGradoSemestre;
        $perFechaInicial = $curso_alumno->perFechaInicial;
        $perFechaFinal = $curso_alumno->perFechaFinal;
        $aluMatricula =$curso_alumno->aluMatricula;


        $cicloEscolar = "";
        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "La joven";
            $parametro_genero_alumno2 = "alumna";

        } else {
            $parametro_genero_alumno = "El joven";
            $parametro_genero_alumno2 = "alumno";

        }


        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $fechaDia = $fechaActual->format('j');       
        $fechaMes = $this->num_meses_string($fechaActual->format('m'));
        $fechaAnio = $fechaActual->format('Y');


        // Guardamos registro 
        $minutario = Minutario::create([
            'minAnio' => $curso_alumno->perAnioPago,
            'minClavePago' => $curso_alumno->aluClave,
            'minCursoID' => $curso_alumno->id,
            'minDepartamento' => $curso_alumno->depClave,
            'minTipo' => "",
            'minNombreDocumento' => "CONSTANCIA DE INSCRIPCIÓN SEMESTRAL",
            'minFecha' =>  $fechaActual->format('Y-m-d')
        ]);

        // if ($parametro_ubicacion == "CME") {
        //     // fecha que se mostrara en PDF 
        //     $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . $mesLetras[$fechaMes - 1] . ' DE ' . $fechaAnio;
        // }
        // if ($parametro_ubicacion == "CVA") {
        //     // fecha que se mostrara en PDF 
        //     $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras[$fechaMes - 1] . ' DE ' . $fechaAnio;
        // }

        $cicloEscolarInicio = Utils::fecha_string($perFechaInicial); 
        $cicloEscolarFin = Utils::fecha_string($perFechaFinal);
        


        // Curso en letras  
        if($parametroGrado == "1"){
            $parametroGradoLetras = "PRIMER semestre";
        }
        if($parametroGrado == "2"){
            $parametroGradoLetras = "SEGUNDO semestre";
        }
        if($parametroGrado == "3"){
            $parametroGradoLetras = "TERCER semestre";
        }
        if($parametroGrado == "4"){
            $parametroGradoLetras = "CUARTO semestre";
        }
        if($parametroGrado == "5"){
            $parametroGradoLetras = "QUINTO semestre";
        }
        if($parametroGrado == "6"){
            $parametroGradoLetras = "SEXTO semestre";
        }



        if ($tipoConstancia == "digital") {
            $parametro_NombreArchivo = "pdf_bachiller_constancia_inscripcion_semestral";

            

            $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
                // 'fechahoy' => $fechahoy,
                'parametro_ubicacion' => $parametro_ubicacion,
                'alumno' => $alumno,
                'curso_alumno' => $curso_alumno,
                'parametro_genero_alumno' => $parametro_genero_alumno,
                'parametro_genero_alumno2' => $parametro_genero_alumno2,
                'parametroGradoLetras' => $parametroGradoLetras,
                'cicloEscolarInicio' => $cicloEscolarInicio,
                'cicloEscolarFin' => $cicloEscolarFin,
                'fechaDia' => $fechaDia,
                'fechaMes' => $fechaMes,
                'fechaAnio' => $fechaAnio,
                'aluMatricula' => $aluMatricula,
                'minutario' => $minutario
            ]);
        }

      

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function imprimirConstanciaEscolaridad($id_curso, $tipoConstancia)
    {

        // query de seleccion de alumno 
        $curso_alumno = Curso::select(
            "cursos.id",
            "alumnos.id as alumno_id",
            "alumnos.aluClave",
            "alumnos.aluMatricula",
            "personas.id as persona_id",
            "personas.perNombre",
            "personas.perApellido1",
            "personas.perApellido2",
            "personas.perSexo",
            "cgt.id as cgt_id",
            "cgt.cgtGradoSemestre",
            "cgt.cgtGrupo",
            "periodos.id as periodo_id",
            "periodos.perAnioPago",
            "ubicacion.ubiClave"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();


        $parametro_genero_alumno = "";
        $parametro_consideracion = "";
        $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_matricula = $curso_alumno->aluMatricula;
        $parametro_clave = $curso_alumno->aluClave;
        $parametro_ubicacion_clave = $curso_alumno->ubiClave;

        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $parametro_consideracion = "es alumna ";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $parametro_consideracion = "es alumno ";
        }

        // valida que grado es para escribir lo que corresponda 
        $gradoEnLetras = "";
        if ($parametro_grado == 1) {
            $gradoEnLetras = "primer grado";
        }
        if ($parametro_grado == 2) {
            $gradoEnLetras = "segundo grado";
        }
        if ($parametro_grado == 3) {
            $gradoEnLetras = "tercer grado";
        }
        // if ($parametro_grado == 4) {
        //     $gradoEnLetras = "CUARTO GRADO";
        // }
        // if ($parametro_grado == 5) {
        //     $gradoEnLetras = "QUINTO GRADO";
        // }
        // if ($parametro_grado == 6) {
        //     $gradoEnLetras = "SEXTO GRADO";
        // }

        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');


        $mesLetras = "";
        if ($fechaMes == "01") {
            $mesLetras = "Enero";
        }
        if ($fechaMes == "02") {
            $mesLetras = "Febrero";
        }
        if ($fechaMes == "03") {
            $mesLetras = "Marzo";
        }
        if ($fechaMes == "04") {
            $mesLetras = "Abril";
        }
        if ($fechaMes == "05") {
            $mesLetras = "Mayo";
        }
        if ($fechaMes == "06") {
            $mesLetras = "Junio";
        }
        if ($fechaMes == "07") {
            $mesLetras = "Julio";
        }
        if ($fechaMes == "08") {
            $mesLetras = "Agosto";
        }
        if ($fechaMes == "09") {
            $mesLetras = "Septiembre";
        }
        if ($fechaMes == "10") {
            $mesLetras = "Octubre";
        }
        if ($fechaMes == "11") {
            $mesLetras = "Noviembre";
        }
        if ($fechaMes == "12") {
            $mesLetras = "Diciembre";
        }


        // fecha que se mostrara en PDF 
        if($parametro_ubicacion_clave == "CME"){
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio . '.';
        }
        if($parametro_ubicacion_clave == "CVA"){
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio . '.';
        }

        $parametro_NombreArchivo = "pdf_Bachiller_constancia_escolaridad";
        $pdf = PDF::loadView('reportes.pdf.Bachiller.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,     
            "grado" => $gradoEnLetras,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_ubicacion_clave" => $parametro_ubicacion_clave 
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public static function num_meses_string($number) {
        switch ($number) {
            case 1:
                return 'Enero';
                break;
            case 2:
                return 'Febrero';
                break;
            case 3:
                return 'Marzo';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Mayo';
                break;
            case 6:
                return 'Junio';
                break;
            case 7:
                return 'Julio';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Septiembre';
                break;
            case 10:
                return 'Octubre';
                break;
            case 11:
                return 'Noviembre';
                break;
            case 12:
                return 'Diciembre';
                break;
        }
    }
}


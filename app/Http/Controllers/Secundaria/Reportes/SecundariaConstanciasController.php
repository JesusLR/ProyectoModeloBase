<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Primaria\Primaria_inscrito;
use App\Models\Secundaria\Secundaria_inscritos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaConstanciasController extends Controller
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
        $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_clave_ubicacion = $curso_alumno->ubiClave;



        // buscar el grupo al que el alumno pertenece 
        // $resultado_array =  DB::select("call procSecundariaObtieneGrupoCurso(" . $id_curso . ")");

        // if (empty($resultado_array)) {
        //     alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
        //     return back()->withInput();
        // }
        // $resultado_grupo = collect($resultado_array);
        // $parametro_grupo = $resultado_grupo[0]->gpoClave;

        $parametro_grupo = $curso_alumno->cgtGradoSemestre;


        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $es = "alumna";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $es = "alumno";
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
        if ($parametro_grado == 4) {
            $gradoEnLetras = "cuarto grado";
        }
        if ($parametro_grado == 5) {
            $gradoEnLetras = "quinto grado";
        }
        if ($parametro_grado == 6) {
            $gradoEnLetras = "sexto grado";
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


        // view('reportes.pdf.secundaria.constancias.pdf_secundaria_carta_conducta')
        // fecha que se mostrara en PDF 
        if ($parametro_clave_ubicacion == "CME") {
            $fechahoy = 'MÉRIDA, YUC., ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }

        if ($parametro_clave_ubicacion == "CVA") {
            $fechahoy = 'VALLADOLID, YUC., ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }

        $parametro_NombreArchivo = "pdf_secundaria_carta_conducta";
        $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
            "sexo" => $curso_alumno->perSexo,
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fecha" => $fechahoy,
            "periodo" => $periodo,
            "es" => $es,
            "parametro_clave_ubicacion" => $parametro_clave_ubicacion
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '_' . $parametro_alumno . '_' . $parametro_grado . $parametro_grupo . '_' . $periodo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    //Constancia de estudio
    public function imprimirConstanciaEstudio($id_curso, $tiene_foto)
    {

        //return "hola";
        // query de seleccion de alumno 
        $curso_alumno = Curso::select(
            "cursos.id",
            "cursos.curSecundariaFoto",
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
            ->where(static function ($query) use ($tiene_foto) {

                if ($tiene_foto == "con_foto") {
                    $query->where('cursos.curSecundariaFoto', '!=', "");
                }

             
            })
            ->first();


        if($curso_alumno == ""){
            alert()->warning('Sin coincidencias', 'El alumno no cuenta con una foto cargada.')->showConfirmButton();
            return back()->withInput();
        }
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

        // buscar el grupo al que el alumno pertenece 
        $resultado_array =  DB::select("call procSecundariaObtieneGrupoCurso(" . $id_curso . ")");

        if (empty($resultado_array)) {
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
        if ($parametro_ubicacion_clave == "CME") {
            $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';

            $parametro_NombreArchivo = "pdf_secundaria_constancia_estudios_cme";
            // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_estudios_cme');
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
                "genero" => $parametro_genero_alumno,
                "alumno" => $parametro_alumno,
                "grado" => $gradoEnLetras,
                "grupo" => $parametro_grupo,
                "fechaHoy" => $fechahoy,
                "periodo" => $periodo,
                "matricula" => $parametro_matricula,
                "clave" => $parametro_clave,
                "parametro_consideracion" => $parametro_consideracion,
                "parametro_ubicacion_clave" => $parametro_ubicacion_clave,
                "sexo" => $curso_alumno->perSexo
            ]);

            $pdf->defaultFont = 'Calibri';

            return $pdf->stream($parametro_NombreArchivo . '_' . $parametro_alumno . '_' . $parametro_grado . $parametro_grupo . '_' . $periodo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
        if ($parametro_ubicacion_clave == "CVA") {
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';

            $parametro_NombreArchivo = "pdf_secundaria_constancia_estudios_cva";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
                "genero" => $parametro_genero_alumno,
                "alumno" => $parametro_alumno,
                "grado" => $gradoEnLetras,
                "grupo" => $parametro_grupo,
                "fechaHoy" => $fechahoy,
                "periodo" => $periodo,
                "matricula" => $parametro_matricula,
                "clave" => $parametro_clave,
                "parametro_consideracion" => $parametro_consideracion,
                "parametro_ubicacion_clave" => $parametro_ubicacion_clave,
                "tiene_foto" => $tiene_foto,
                "curso_alumno" => $curso_alumno,
                "campus" => "CampusCVA"
            ]);

            $pdf->defaultFont = 'Calibri';

            return $pdf->stream($parametro_NombreArchivo . '_' . $parametro_alumno . '_' . $parametro_grado . $parametro_grupo . '_' . $periodo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
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
        $resultado_array =  DB::select("call procSecundariaObtieneGrupoCurso(" . $id_curso . ")");

        if (empty($resultado_array)) {
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
        if ($parametro_clave_ubicacion == "CME") {
            $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }
        if ($parametro_clave_ubicacion == "CVA") {
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';
        }

        $parametro_NombreArchivo = "pdf_secundaria_constancia_NoAdeudo";
        $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "ubicacion" => $parametro_clave_ubicacion
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '_' . $parametro_alumno . '_' . $parametro_grado . $parametro_grupo . '_' . $periodo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    // constancia de cupo 
    public function imprimirConstanciaCupo($id_curso, $tipoConstancia)
    {


        $inscrito = DB::select("SELECT
            sm.id as materia_id,
            sm.matClave, 
            sm.matNombre,
            sm.matNombreCorto,
            sm.id as materia_id,
            si.inscTrimestre1 as trimestre1,						
			IFNULL(CASE
				WHEN si.inscRecuperativoTrimestre1 >= 6 THEN si.inscRecuperativoTrimestre1
				WHEN si.inscRecuperativoTrimestre1 = -1 THEN 5
				WHEN si.inscRecuperativoTrimestre1 = -2 THEN 5
				ELSE NULL
			END,si.inscTrimestre1) AS trimestre1Sep,	
			si.inscRecuperativoTrimestre1,					
            si.inscTrimestre2 as trimestre2,						
			IFNULL(CASE
				WHEN si.inscRecuperativoTrimestre2 >= 6 THEN si.inscRecuperativoTrimestre2
				WHEN si.inscRecuperativoTrimestre2 = -1 THEN 5
				WHEN si.inscRecuperativoTrimestre2 = -2 THEN 5
				ELSE NULL
			END,si.inscTrimestre2) AS trimestre2Sep,						
            si.inscRecuperativoTrimestre2,						
			si.inscTrimestre3 as trimestre3,
			IFNULL(CASE
				WHEN si.inscRecuperativoTrimestre3 >= 6 THEN si.inscRecuperativoTrimestre3
				WHEN si.inscRecuperativoTrimestre3 = -1 THEN 5
				WHEN si.inscRecuperativoTrimestre3 = -2 THEN 5
				ELSE NULL
			END,si.inscTrimestre3) AS trimestre3Sep,          
            si.inscRecuperativoTrimestre3,
            si.inscPromedioTrim as promedioTrimestre,
            si.inscCalificacionFinalModelo,
            si.inscCalificacionFinalSEP,
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
            INNER JOIN secundaria_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN secundaria_grupos sg ON sg.id = si.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN secundaria_materias sm ON sm.id = sg.secundaria_materia_id
            AND sg.deleted_at IS NULL
            INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
            AND alumnos.deleted_at IS NULL
            INNER JOIN personas on alumnos.persona_id = personas.id
            AND personas.deleted_at IS NULL
            WHERE
            cursos.id = $id_curso
            AND sm.matEspecialidad='1FA'
            AND departamentos.depClave = 'SEC'          	
            ORDER BY sm.matOrdenVisual asc");

            // AND sm.matClave NOT LIKE ('ART%')
            // AND sm.matClave NOT LIKE ('TEC%')
            // AND sm.matClave NOT LIKE ('FIN%')
            // AND sm.matClave NOT LIKE ('TUT%')
            // AND sm.matClave NOT LIKE ('DVE%')
            // AND sm.matClave NOT LIKE ('EF1%')
            // AND sm.matClave NOT LIKE ('LAB%')
            // AND sm.matClave NOT LIKE ('OYT%')
            // AND sm.matClave NOT LIKE ('TALLE%')
            // AND sm.matClave NOT LIKE ('RPY%')

        // $inscrito = DB::select("call procSecundariaConstanciaCupo(".$id_curso.")");
        // $inscrito2 = DB::select("call procSecundariaConstanciaCupo2(".$id_curso.")");
        // $inscrito3 = DB::select("call procSecundariaConstanciaCupo3(".$id_curso.")");


        if (count($inscrito) == 0) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }


        $inscrito2 = DB::select("SELECT DISTINCT
            sm.matClave, 
            sm.matNombre,
            sm.matNombreCorto,
            sm.id as materia_id,
            si.inscTrimestre1 as trimestre1,                   
            IFNULL(CASE
                WHEN si.inscRecuperativoTrimestre1 >= 6 THEN si.inscRecuperativoTrimestre1
                WHEN si.inscRecuperativoTrimestre1 = -1 THEN 6
                WHEN si.inscRecuperativoTrimestre1 = -2 THEN 6
                ELSE NULL
            END,si.inscTrimestre1) AS trimestre1Sep,	
            si.inscRecuperativoTrimestre1,
            si.inscTrimestre2 as trimestre2,						
            IFNULL(CASE
                WHEN si.inscRecuperativoTrimestre2 >= 6 THEN si.inscRecuperativoTrimestre2
                WHEN si.inscRecuperativoTrimestre2 = -1 THEN 6
                WHEN si.inscRecuperativoTrimestre2 = -2 THEN 6
                ELSE NULL
            END,si.inscTrimestre2) AS trimestre2Sep,                    
            si.inscRecuperativoTrimestre2,                    
            si.inscTrimestre3 as trimestre3,
            IFNULL(CASE
                WHEN si.inscRecuperativoTrimestre3 >= 6 THEN si.inscRecuperativoTrimestre3
                WHEN si.inscRecuperativoTrimestre3 = -1 THEN 6
                WHEN si.inscRecuperativoTrimestre3 = -2 THEN 6
                ELSE NULL
            END,si.inscTrimestre3) AS trimestre3Sep,  
            si.inscRecuperativoTrimestre3,
            si.inscPromedioTrim as promedioTrimestre,
            si.inscCalificacionFinalModelo,
            si.inscCalificacionFinalSEP,
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
            INNER JOIN secundaria_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN secundaria_grupos sg ON sg.id = si.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN secundaria_materias sm ON sm.id = sg.secundaria_materia_id
            AND sg.deleted_at IS NULL
            INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
            AND alumnos.deleted_at IS NULL
            INNER JOIN personas on alumnos.persona_id = personas.id
            AND personas.deleted_at IS NULL
            WHERE
            cursos.id = $id_curso
            AND departamentos.depClave = 'SEC'										
            AND sm.matClave LIKE ('EF1%')");

        $inscrito3 = DB::select("SELECT DISTINCT
            sm.matClave, 
            sm.matNombre,
            sm.matNombreCorto,
            sm.id as materia_id,
            si.inscTrimestre1 as trimestre1,		
			IFNULL(CASE
				WHEN si.inscRecuperativoTrimestre1 >= 6 THEN si.inscRecuperativoTrimestre1
				WHEN si.inscRecuperativoTrimestre1 = -1 THEN 6
				WHEN si.inscRecuperativoTrimestre1 = -2 THEN 6
				ELSE NULL
			END,si.inscTrimestre1) AS trimestre1Sep,	
			si.inscRecuperativoTrimestre1,
            si.inscTrimestre2 as trimestre2,						
			IFNULL(CASE
                WHEN si.inscRecuperativoTrimestre2 >= 6 THEN si.inscRecuperativoTrimestre2
				WHEN si.inscRecuperativoTrimestre2 = -1 THEN 6
				WHEN si.inscRecuperativoTrimestre2 = -2 THEN 6
				ELSE NULL
		    END,si.inscTrimestre2) AS trimestre2Sep,						
            si.inscRecuperativoTrimestre2,						
			si.inscTrimestre3 as trimestre3,
			IFNULL(CASE
				WHEN si.inscRecuperativoTrimestre3 >= 6 THEN si.inscRecuperativoTrimestre3
				WHEN si.inscRecuperativoTrimestre3 = -1 THEN 6
				WHEN si.inscRecuperativoTrimestre3 = -2 THEN 6
				ELSE NULL
			END,si.inscTrimestre3) AS trimestre3Sep,         
            si.inscRecuperativoTrimestre3,
            si.inscPromedioTrim as promedioTrimestre,
            si.inscCalificacionFinalModelo,
            si.inscCalificacionFinalSEP,
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
            INNER JOIN secundaria_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN secundaria_grupos sg ON sg.id = si.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN secundaria_materias sm ON sm.id = sg.secundaria_materia_id
            AND sg.deleted_at IS NULL
            INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
            AND alumnos.deleted_at IS NULL
            INNER JOIN personas on alumnos.persona_id = personas.id
            AND personas.deleted_at IS NULL
            WHERE
            cursos.id = $id_curso
            AND departamentos.depClave = 'SEC'										
            AND sm.matClave LIKE ('DVE%')");

        $parametro_alumno = $inscrito[0]->perApellido1 . ' ' . $inscrito[0]->perApellido2 . ' ' . $inscrito[0]->perNombre;
        $parametro_grupo = $inscrito[0]->cgtGrupo;
        $parametro_periodo_incio = $inscrito[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$inscrito[0]->perAnioPago;
        $parametro_periodo_sig = 1 + $parametro_periodo_fin;
        $parametro_ubicacion = $inscrito[0]->ubiClave;

        // valida el genero
        if ($inscrito[0]->perSexo == "F") {
            $parametro_genero_alumno = "que la alumna";
            $parametro_inscrito = "Inscrita";
        } else {
            $parametro_genero_alumno = "que el alumno";
            $parametro_inscrito = "Inscrito";
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
            $nivel = "secundaria";
        }
        if ($inscrito[0]->gpoGrado == 2) {
            $gradoEnLetras = "segundo grado";
            $gradoSiguiente = "3er";
            $nivel = "secundaria";
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


        if ($parametro_ubicacion == "CME") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        if ($parametro_ubicacion == "CVA") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }


        // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_cupo');

        if ($tipoConstancia == "membretada") {
            $parametro_NombreArchivo = "pdf_secundaria_constancia_cupo";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
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
                "inscrito2" => $inscrito2,
                "inscrito3" => $inscrito3,
                "parametro_inscrito" => $parametro_inscrito
            ]);
        }

        if ($tipoConstancia == "digital") {
            // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_cupo_digital');
            $parametro_NombreArchivo = "pdf_secundaria_constancia_cupo_digital";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
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
                "inscrito2" => $inscrito2,
                "inscrito3" => $inscrito3,
                "parametro_inscrito" => $parametro_inscrito
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
            si.inscCalificacionFinalSEP as promedioTrimestre,
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
            INNER JOIN secundaria_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN secundaria_grupos sg ON sg.id = si.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN secundaria_materias sm ON sm.id = sg.secundaria_materia_id
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
            -- AND sm.matClave NOT LIKE ('DVE%')
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
            $nivel = "secundaria";
        }
        if ($inscrito[0]->gpoGrado == 2) {
            $gradoEnLetras = "segundo grado";
            $gradoSiguiente = "3er";
            $nivel = "secundaria";
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


        $diaEnletras = [
            'a un día', 'a los dos días', 'a los tres días',
            'a los cuatro días', 'a los cinco días', 'a los seis días', 'a los siete días', 'a los cho días', 'a los nueve días', 'a los diez días', 'a los once días', 'a los doce días', 'a los trece días', 'a los catorce días', 'a los quince días', 'a los dieciséis días', 'a los diecisiete días', 'a los dieciocho días',
            'a los diecinueve días', 'a los veinte días', 'a los veintiuno días', 'a los veintidos días', 'a los veintitres días', 'a los veinticuatro días', 'a los veinticinco días',
            'a los veintiseis días', 'a los veintisiete días',
            'a los veintiocho días', 'a los veintinueve días', 'a los treinta días', 'a los treinta y un días'
        ];

        $fechaDiaLetra = $diaEnletras[$fechaDia - 1];

        if ($fechaAnio == "2019") {
            $anoLEtras = "dos mil diecinueve";
        }
        if ($fechaAnio == "2020") {
            $anoLEtras = "dos mil veinte";
        }
        if ($fechaAnio == "2021") {
            $anoLEtras = "dos mil veintiuno";
        }
        if ($fechaAnio == "2022") {
            $anoLEtras = "dos mil veintidos";
        }
        if ($fechaAnio == "2023") {
            $anoLEtras = "dos mil veintitres";
        }
        if ($fechaAnio == "2024") {
            $anoLEtras = "dos mil veinticuatro";
        }
        if ($fechaAnio == "2024") {
            $anoLEtras = "dos mil veinticinco";
        }


        if ($parametro_ubicacion == "CME") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }
        if ($parametro_ubicacion == "CVA") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio;
        }


        // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_cupo');

        if ($tipoConstancia == "membretada") {
            $parametro_NombreArchivo = "pdf_secundaria_constancia_cupo";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
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

        if ($tipoConstancia == "digital") {
            $parametro_NombreArchivo = "pdf_secundaria_constancia_promedio_final_digital";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
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
        $resultado_array =  DB::select("call procSecundariaConstanciaArtesTalleres(" . $id_curso . ")");

        $resultado_collection = collect($resultado_array);

        // si no hay datos muestra alerta 
        if ($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }


        $parametro_ubicacion = $resultado_collection[0]->ubicacion;
        $alumno = $resultado_collection[0]->nombres . ' ' . $resultado_collection[0]->ape_paterno . ' ' . $resultado_collection[0]->ape_materno;
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
        if ($parametro_ubicacion == "CME") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras[$fechaMes - 1] . ' de ' . $fechaAnio;
        }
        if ($parametro_ubicacion == "CVA") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras[$fechaMes - 1] . ' de ' . $fechaAnio;
        }


        // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_cupo');

        if ($tipoConstancia == "membretada") {
            $parametro_NombreArchivo = "pdf_secundaria_constancia_taller_artes";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, []);
        }

        if ($tipoConstancia == "digital") {
            $parametro_NombreArchivo = "pdf_secundaria_constancia_taller_artes";
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
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

        // si no hay datos muestra alerta 
        if ($curso_alumno == "") {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }


        $parametro_ubicacion = $curso_alumno->ubiClave;
        $alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametroGrado = $curso_alumno->cgtGradoSemestre;
        $cicloSiguiente = $curso_alumno->perAnioPago + 1;
        $cicloEscolar = $curso_alumno->perAnioPago . '-' . $cicloSiguiente;
        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la alumna";
            $consider = "considerada como alumna";
            $ins = "inscrita";
        } else {
            $parametro_genero_alumno = "Que el alumno";
            $consider = "considerado como alumno";
            $ins = "inscrito";
        }


        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');


        $mesLetras = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
        if ($parametro_ubicacion == "CME") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . $mesLetras[$fechaMes - 1] . ' DE ' . $fechaAnio;
        }
        if ($parametro_ubicacion == "CVA") {
            // fecha que se mostrara en PDF 
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras[$fechaMes - 1] . ' DE ' . $fechaAnio;
        }

        // Curso en letras  
        if ($parametroGrado == "1") {
            $parametroGradoLetras = "PRIMER GRADO";
        }
        if ($parametroGrado == "2") {
            $parametroGradoLetras = "SEGUNDO GRADO";
        }
        if ($parametroGrado == "3") {
            $parametroGradoLetras = "TERCER GRADO";
        }



        if ($tipoConstancia == "membretada") {
            $parametro_NombreArchivo = "pdf_secundaria_constancia_inscripcion";
            // view("reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_inscripcion");
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
                'fechahoy' => $fechahoy,
                'parametro_ubicacion' => $parametro_ubicacion,
                'alumno' => $alumno,
                'curso_alumno' => $curso_alumno,
                'parametro_genero_alumno' => $parametro_genero_alumno,
                'parametroGradoLetras' => $parametroGradoLetras,
                'cicloEscolar' => $cicloEscolar,
                'consider' => $consider,
                'ins' => $ins
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
        if ($parametro_ubicacion_clave == "CME") {
            $fechahoy = 'Mérida, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio . '.';
        }
        if ($parametro_ubicacion_clave == "CVA") {
            $fechahoy = 'Valladolid, Yucatán, a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio . '.';
        }

        $parametro_NombreArchivo = "pdf_secundaria_constancia_escolaridad";
        $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
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

        return $pdf->stream($parametro_NombreArchivo . '_' . $parametro_alumno . '_' . $periodo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

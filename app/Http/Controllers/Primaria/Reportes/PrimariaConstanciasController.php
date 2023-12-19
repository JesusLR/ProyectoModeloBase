<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\ListaNegra;
use App\Models\Primaria\Primaria_inscrito;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaConstanciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function imprimirCartaConducta($id_curso, $foto)
    {
        // query de seleccion de alumno
        $curso_alumno = Curso::select(
            "cursos.id",
            "cursos.curPrimariaFoto",
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
            "ubicacion.ubiClave",
            "departamentos.depClaveOficial"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();

        if($curso_alumno == ""){
            alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
            return back()->withInput();
        }

        $listaNegra = ListaNegra::where('alumno_id', $curso_alumno->alumno_id)->whereNull('deleted_at')->first();


        if(!empty($listaNegra)){
            alert()->warning('Upsss', 'El alumno no tiene derecho a la constancia debido a '. $listaNegra->lnRazon)->showConfirmButton();
            return back();
        }

        $parametro_genero_alumno = "";
        $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_ubicacion = $curso_alumno->ubiClave;
        $curPrimariaFoto = $curso_alumno->curPrimariaFoto;
        $parametro_grupo = $curso_alumno->cgtGrupo;
        $depClaveOficial = $curso_alumno->depClaveOficial;


        // buscar el grupo al que el alumno pertenece
        // $resultado_array =  DB::select("call procPrimariaObtieneGrupoCurso(" . $id_curso . ")");


        // $resultado_grupo = collect($resultado_array);
        // if(isset($resultado_grupo[0]->gpoClave)){
        //     $parametro_grupo = $resultado_grupo[0]->cgtGrupo;

        // }else{
        //     $parametro_grupo = "";
        // }

        // $parametro_grupo = $curso_alumno->cgtGrupo;

        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $parametroAlumno = "alumna";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $parametroAlumno = "alumno";
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

        if($parametro_ubicacion == "CME"){
            $fechahoy = 'Mérida, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCME";

        }
        if($parametro_ubicacion == "CVA"){
            $fechahoy = 'Valladolid, Yuc., ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCVA";

        }

        $parametro_NombreArchivo = "pdf_primaria_carta_conducta";
        // view('reportes.pdf.primaria.constancias.pdf_primaria_carta_conducta');
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "parametro_ubicacion" => $parametro_ubicacion,
            "parametroAlumno" => $parametroAlumno,
            "foto" => $foto,
            "campus" => $campus,
            "perAnioPago" => $parametro_periodo_inicio,
            "curPrimariaFoto" => $curPrimariaFoto,
            "depClaveOficial" => $depClaveOficial
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$parametro_grado.$parametro_grupo.'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    public function imprimirConstanciaEstudio($id_curso, $foto)
    {

        // query de seleccion de alumno
        $curso_alumno = Curso::select(
            "cursos.id",
            "cursos.curPrimariaFoto",
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
            "departamentos.depClaveOficial"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();


        $listaNegra = ListaNegra::where('alumno_id', $curso_alumno->alumno_id)->whereNull('deleted_at')->first();


        if(!empty($listaNegra)){
            alert()->warning('Upsss', 'El alumno no tiene derecho a la constancia debido a '. $listaNegra->lnRazon)->showConfirmButton();
            return back();
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
        $parametro_ubicacion = $curso_alumno->ubiClave;
        $curPrimariaFoto = $curso_alumno->curPrimariaFoto;
        $parametro_grupo = $curso_alumno->cgtGrupo;
        $depClaveOficial = $curso_alumno->depClaveOficial;

        // buscar el grupo al que el alumno pertenece
        $resultado_array =  DB::select("call procPrimariaObtieneGrupoCurso(" . $id_curso . ")");

        // if(empty($resultado_array)){
        //     alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
        //     return back()->withInput();
        // }
        // $resultado_grupo = collect($resultado_array);
        // $parametro_grupo = $resultado_grupo[0]->gpoClave;


        // valida el genero
        if ($curso_alumno->perSexo == "F") {
            $parametro_genero_alumno = "Que la niña ";
            $parametro_consideracion = "está considerada como alumna ";
            $inscrito = "inscrita";
        } else {
            $parametro_genero_alumno = "Que el niño";
            $parametro_consideracion = "es alumno ";
            $inscrito = "inscrito";
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
        if($parametro_ubicacion === "CME"){
            $fechahoy = 'Mérida, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }
        if($parametro_ubicacion === "CVA"){
            $fechahoy = 'Valladolid, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }


        $parametro_NombreArchivo = "pdf_primaria_constancia_estudios";
        // view('reportes.pdf.primaria.constancias.pdf_primaria_constancia_estudios');
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_ubicacion" => $parametro_ubicacion,
            "foto" => $foto,
            "curPrimariaFoto" => $curPrimariaFoto,
            "perAnioPago" => $parametro_periodo_inicio,
            "campus" => $campus,
            "inscrito" => $inscrito,
            "depClaveOficial" => $depClaveOficial
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$parametro_grado.$parametro_grupo.'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    public function imprimirConstanciaNoAdeudo($id_curso, $foto)
    {

        // query de seleccion de alumno
        $curso_alumno = Curso::select(
            "cursos.id",
            "cursos.curPrimariaFoto",
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
            "departamentos.depClaveOficial"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();

        $listaNegra = ListaNegra::where('alumno_id', $curso_alumno->alumno_id)->whereNull('deleted_at')->first();


        if(!empty($listaNegra)){
            alert()->warning('Upsss', 'El alumno no tiene derecho a la constancia debido a '. $listaNegra->lnRazon)->showConfirmButton();
            return back();
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
        $parametro_ubicacion = $curso_alumno->ubiClave;
        $curPrimariaFoto = $curso_alumno->curPrimariaFoto;
        $depClaveOficial = $curso_alumno->depClaveOficial;




        // buscar el grupo al que el alumno pertenece
        $resultado_array =  DB::select("call procPrimariaObtieneGrupoCurso(" . $id_curso . ")");

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
        if($parametro_ubicacion === "CME"){
            $fechahoy = 'Mérida, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }else{
            $fechahoy = 'Valladolid, Yuc., A ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }


        $parametro_NombreArchivo = "pdf_primaria_constancia_NoAdeudo";
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => $gradoEnLetras,
            "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_ubicacion" => $parametro_ubicacion,
            "curPrimariaFoto" => $curPrimariaFoto,
            "campus" => $campus,
            "perAnioPago" => $parametro_periodo_inicio,
            "foto" => $foto,
            "depClaveOficial" => $depClaveOficial
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$parametro_grado.$parametro_grupo.'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    // constancia de cupo
    public function imprimirConstanciaCupo($id_curso)
    {


        // $inscrito = DB::select("SELECT DISTINCT
        // pm.matClave,
        // pm.matNombre,
        // pm.matNombreCorto,
        // pm.id as materia_id,
        // round(pi.inscTrimestre1) as trimestre1,
        // round(pi.inscTrimestre2) as trimestre2,
        // round(pi.inscTrimestre3) as trimestre3,
        // CASE
        //         WHEN pi.inscTrimestre1 IS NOT NULL
        //         AND (pi.inscTrimestre2 IS NULL AND pi.inscTrimestre3 IS NULL) THEN ROUND(pi.inscTrimestre1)
        //         WHEN (pi.inscTrimestre1 + pi.inscTrimestre2) IS NOT NULL
        //         AND pi.inscTrimestre3 IS NULL THEN ROUND((ROUND(pi.inscTrimestre1) + ROUND(pi.inscTrimestre2))/2,1)
        //         WHEN (pi.inscTrimestre1 + pi.inscTrimestre2 + pi.inscTrimestre3) IS NOT NULL
        //         THEN ROUND((ROUND(pi.inscTrimestre1) + ROUND(pi.inscTrimestre2)
        //         + ROUND(pi.inscTrimestre3))/3,1)
        //         ELSE NULL
        //     END as promedioTrimestre,
        // pg.gpoGrado,
        // pg.gpoClave,
        // cgt.cgtGrupo,
        // periodos.perAnioPago,
        // personas.perNombre,
        // personas.perApellido1,
        // personas.perApellido2,
        // personas.perSexo,
        // ubicacion.ubiClave
        // FROM
        // cursos
        // INNER JOIN periodos ON cursos.periodo_id = periodos.id
        // AND periodos.deleted_at IS NULL
        // INNER JOIN cgt ON cursos.cgt_id = cgt.id
        // AND cgt.deleted_at IS NULL
        // INNER JOIN planes ON cgt.plan_id = planes.id
        // AND planes.deleted_at IS NULL
        // INNER JOIN programas ON planes.programa_id = programas.id
        // AND programas.deleted_at IS NULL
        // INNER JOIN escuelas ON programas.escuela_id = escuelas.id
        // AND escuelas.deleted_at IS NULL
        // INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
        // AND departamentos.deleted_at IS NULL
        // INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
        // AND ubicacion.deleted_at IS NULL
        // INNER JOIN primaria_inscritos pi ON pi.curso_id = cursos.id
        // AND pi.deleted_at IS NULL
        // INNER JOIN primaria_grupos pg ON pg.id = pi.primaria_grupo_id
        // AND pg.deleted_at IS NULL
        // INNER JOIN primaria_materias pm ON pm.id = pg.primaria_materia_id
        // AND pg.deleted_at IS NULL
        // INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
        // AND alumnos.deleted_at IS NULL
        // INNER JOIN personas on alumnos.persona_id = personas.id
        // AND personas.deleted_at IS NULL
        // WHERE
        // cursos.id = $id_curso
        // AND pm.matEspecialidad is not null
        // ORDER BY pm.matClave asc");

        $inscrito = DB::select("call procPrimariaBoletaCalificacionesCurso(".$id_curso.")");

        $inscrito = collect($inscrito);

        if (count($inscrito) == 0) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado datos relacionados al alumno')->showConfirmButton();
            return back()->withInput();
        }

        $parametro_alumno = $inscrito[0]->ape_paterno . ' ' . $inscrito[0]->ape_materno.' '.$inscrito[0]->nombres;
        $parametro_grupo = $inscrito[0]->grupo;
        $parametro_periodo_incio = $inscrito[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$inscrito[0]->perAnioPago;
        $parametro_periodo_sig = 1 + $parametro_periodo_fin;
        $parametro_ubicacion = $inscrito[0]->ubicacion;
        $parametro_CCT = $inscrito[0]->depClaveOficial;
        $curPrimariaFoto = $inscrito[0]->curPrimariaFoto;

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
        if ($inscrito[0]->gpoGrado == 1
        ) {
            $gradoEnLetras = "primer grado";
            $gradoSiguiente = "SEGUNDO GRADO";
        }
        if ($inscrito[0]->gpoGrado == 2
        ) {
            $gradoEnLetras = "segundo grado";
            $gradoSiguiente = "TERCER GRADO";
        }
        if ($inscrito[0]->gpoGrado == 3
        ) {
            $gradoEnLetras = "tercer grado";
            $gradoSiguiente = "CUARTO GRADO";
        }
        if ($inscrito[0]->gpoGrado == 4
        ) {
            $gradoEnLetras = "cuarto grado";
            $gradoSiguiente = "QUINTO GRADO";
        }
        if ($inscrito[0]->gpoGrado == 5
        ) {
            $gradoEnLetras = "quinto grado";
            $gradoSiguiente = "SEXTO GRADO ";
        }
        if ($inscrito[0]->gpoGrado == 6
        ) {
            $gradoEnLetras = "sexto grado";
            $gradoSiguiente = "";
        }

        // meeses en letras
        $mesLetras = "";
        if ($fechaMes == "01") {
            $mesLetras = "Enero";
        }
        if ($fechaMes == "02"
        ) {
            $mesLetras = "Febrero";
        }
        if ($fechaMes == "03"
        ) {
            $mesLetras = "Marzo";
        }
        if ($fechaMes == "04"
        ) {
            $mesLetras = "Abril";
        }
        if ($fechaMes == "05"
        ) {
            $mesLetras = "Mayo";
        }
        if ($fechaMes == "06"
        ) {
            $mesLetras = "Junio";
        }
        if ($fechaMes == "07"
        ) {
            $mesLetras = "Julio";
        }
        if ($fechaMes == "08"
        ) {
            $mesLetras = "Agosto";
        }
        if ($fechaMes == "09"
        ) {
            $mesLetras = "Septiembre";
        }
        if ($fechaMes == "10"
        ) {
            $mesLetras = "Octubre";
        }
        if ($fechaMes == "11"
        ) {
            $mesLetras = "Noviembre";
        }
        if ($fechaMes == "12"
        ) {
            $mesLetras = "Diciembre";
        }


        // fecha que se mostrara en PDF
        if($parametro_ubicacion === "CME"){
            $fechahoy = 'Mérida, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }else{
            $fechahoy = 'Valladolid, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }


        $parametro_NombreArchivo = "pdf_primaria_constancia_cupo";
        // view('reportes.pdf.primaria.constancias.pdf_primaria_constancia_cupo');
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
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
            'parametro_ubicacion' => $parametro_ubicacion,
            'parametro_CCT' => $parametro_CCT,
            'campus' => $campus,
            'perAnioPago' => $parametro_periodo_incio,
            'curPrimariaFoto' => $curPrimariaFoto
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    function constanciaPasaporteIngles ($id_curso, $foto)
    {
        // query de seleccion de alumno
        $curso_alumno = Curso::select(
            "cursos.id",
            "cursos.curPrimariaFoto",
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
            "departamentos.depClaveOficial"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();

        $listaNegra = ListaNegra::where('alumno_id', $curso_alumno->alumno_id)->whereNull('deleted_at')->first();


        if(!empty($listaNegra)){
            alert()->warning('Upsss', 'El alumno no tiene derecho a la constancia debido a '. $listaNegra->lnRazon)->showConfirmButton();
            return back();
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
        $parametro_ubicacion = $curso_alumno->ubiClave;
        $curPrimariaFoto = $curso_alumno->curPrimariaFoto;
        $depClaveOficial = $curso_alumno->depClaveOficial;
        $parametro_grupo = $curso_alumno->cgtGrupo;





        // buscar el grupo al que el alumno pertenece
        // $resultado_array =  DB::select("call procPrimariaObtieneGrupoCurso(" . $id_curso . ")");

        // if(empty($resultado_array)){
        //     alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
        //     return back()->withInput();
        // }
        // $resultado_grupo = collect($resultado_array);
        // $parametro_grupo = $resultado_grupo[0]->gpoClave;

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
            $gradoEnLetras = "FIRST GRADE";
        }
        if ($parametro_grado == 2) {
            $gradoEnLetras = "SECOND GRADE";
        }
        if ($parametro_grado == 3) {
            $gradoEnLetras = "THIRD GRADE";
        }
        if ($parametro_grado == 4) {
            $gradoEnLetras = "FOURTH GRADE";
        }
        if ($parametro_grado == 5) {
            $gradoEnLetras = "FIFTH GRADE";
        }
        if ($parametro_grado == 6) {
            $gradoEnLetras = "SIXTH GRADE";
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
            $mesLetras = "january";
        }
        if ($fechaMes == "02") {
            $mesLetras = "february";
        }
        if ($fechaMes == "03") {
            $mesLetras = "march";
        }
        if ($fechaMes == "04") {
            $mesLetras = "april";
        }
        if ($fechaMes == "05") {
            $mesLetras = "may";
        }
        if ($fechaMes == "06") {
            $mesLetras = "june";
        }
        if ($fechaMes == "07") {
            $mesLetras = "july";
        }
        if ($fechaMes == "08") {
            $mesLetras = "august";
        }
        if ($fechaMes == "09") {
            $mesLetras = "september";
        }
        if ($fechaMes == "10") {
            $mesLetras = "octuber";
        }
        if ($fechaMes == "11") {
            $mesLetras = "november";
        }
        if ($fechaMes == "12") {
            $mesLetras = "december";
        }


        // fecha que se mostrara en PDF
        if($parametro_ubicacion === "CME"){
            $fechahoy = 'MÉRIDA, YUC., ' . $fechaDia . 'ST ' . strtoupper($mesLetras) . ', ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }else{
            $fechahoy = 'VALLADOLID, YUC., ' . $fechaDia . 'ST ' . strtoupper($mesLetras) . ', ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }


        $parametro_NombreArchivo = "pdf_primaria_constancia_pasaport_ingles";
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => strtoupper($gradoEnLetras),
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_ubicacion" => $parametro_ubicacion,
            "curPrimariaFoto" => $curPrimariaFoto,
            "campus" => $campus,
            "perAnioPago" => $parametro_periodo_inicio,
            "depClaveOficial" => $depClaveOficial,
            "grupo" => $parametro_grupo,
            "foto" => $foto
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    function constanciaPasaporte ($id_curso, $foto)
    {
        // query de seleccion de alumno
        $curso_alumno = Curso::select(
            "cursos.id",
            "cursos.curPrimariaFoto",
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
            "departamentos.depClaveOficial"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where("cursos.id", $id_curso)
            ->first();


        $listaNegra = ListaNegra::where('alumno_id', $curso_alumno->alumno_id)->whereNull('deleted_at')->first();


        if(!empty($listaNegra)){
            alert()->warning('Upsss', 'El alumno no tiene derecho a la constancia debido a '. $listaNegra->lnRazon)->showConfirmButton();
            return back();
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
        $parametro_ubicacion = $curso_alumno->ubiClave;
        $curPrimariaFoto = $curso_alumno->curPrimariaFoto;
        $depClaveOficial = $curso_alumno->depClaveOficial;
        $parametro_grupo = $curso_alumno->cgtGrupo;





        // buscar el grupo al que el alumno pertenece
        // $resultado_array =  DB::select("call procPrimariaObtieneGrupoCurso(" . $id_curso . ")");

        // if(empty($resultado_array)){
        //     alert()->warning('Sin coincidencias', 'El alumno no cuenta con grupo asignado.')->showConfirmButton();
        //     return back()->withInput();
        // }
        // $resultado_grupo = collect($resultado_array);
        // $parametro_grupo = $resultado_grupo[0]->gpoClave;

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
            $mesLetras = "enero";
        }
        if ($fechaMes == "02") {
            $mesLetras = "febrero";
        }
        if ($fechaMes == "03") {
            $mesLetras = "marzo";
        }
        if ($fechaMes == "04") {
            $mesLetras = "abril";
        }
        if ($fechaMes == "05") {
            $mesLetras = "mayo";
        }
        if ($fechaMes == "06") {
            $mesLetras = "junio";
        }
        if ($fechaMes == "07") {
            $mesLetras = "julio";
        }
        if ($fechaMes == "08") {
            $mesLetras = "agosto";
        }
        if ($fechaMes == "09") {
            $mesLetras = "septiembre";
        }
        if ($fechaMes == "10") {
            $mesLetras = "octubre";
        }
        if ($fechaMes == "11") {
            $mesLetras = "noviembre";
        }
        if ($fechaMes == "12") {
            $mesLetras = "diciembre";
        }


        // fecha que se mostrara en PDF
        if($parametro_ubicacion === "CME"){
            $fechahoy = 'Mérida, Yuc., a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }else{
            $fechahoy = 'Valladolid, Yuc., a ' . $fechaDia . ' de ' . $mesLetras . ' de ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }


        $parametro_NombreArchivo = "pdf_primaria_constancia_pasaporte";
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            "alumno" => $parametro_alumno,
            "grado" => strtoupper($gradoEnLetras),
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "parametro_ubicacion" => $parametro_ubicacion,
            "curPrimariaFoto" => $curPrimariaFoto,
            "campus" => $campus,
            "perAnioPago" => $parametro_periodo_inicio,
            "depClaveOficial" => $depClaveOficial,
            "grupo" => $parametro_grupo,
            "foto" => $foto,
            "sexo" => $curso_alumno->perSexo
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'_'.$parametro_alumno .'_'.$periodo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

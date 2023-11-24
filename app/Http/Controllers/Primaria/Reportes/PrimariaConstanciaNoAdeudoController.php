<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaConstanciaNoAdeudoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('primaria.reportes.constancias.adeudo', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        # code...
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
            "ubicacion.ubiClave",
            "cursos.curPrimariaFoto"
        )
            ->join("alumnos", "cursos.alumno_id", "=", "alumnos.id")
            ->join("personas", "alumnos.persona_id", "=", "personas.id")
            ->join("cgt", "cursos.cgt_id", "=", "cgt.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->join("planes", "cgt.plan_id", "=", "planes.id")
            ->where("periodos.id", $request->periodo_id)
            ->where("planes.id", $request->plan_id)
            ->where("cursos.curEstado", '=', 'R')
            ->where(static function ($query) use ($request) {


                if ($request->gpoGrado) {
                    $query->where('cgt.cgtGradoSemestre', $request->gpoGrado);
                }

                if ($request->gpoClave) {
                    $query->where('cgt.cgtGrupo', $request->gpoClave);
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
            ->orderBy('cgt.cgtGradoSemestre', 'ASC')
            ->orderBy('cgt.cgtGrupo', 'ASC')
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->get();


        if (count($curso_alumno) < 1) {
            alert()->warning('Sin coincidencias', 'No se han encontrado alumos registrados a este grupo')->showConfirmButton();
            return back()->withInput();
        }

        $parametro_genero_alumno = "";
        $parametro_consideracion = "";
        // $parametro_alumno = $curso_alumno->perApellido1 . ' ' . $curso_alumno->perApellido2 . ' ' . $curso_alumno->perNombre;
        $parametro_grado = $curso_alumno[0]->cgtGradoSemestre;
        $parametro_periodo_inicio = $curso_alumno[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno[0]->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        // $parametro_matricula = $curso_alumno[0]->aluMatricula;
        $parametro_clave = $curso_alumno[0]->aluClave;
        $perAnioPago = $curso_alumno[0]->perAnioPago;


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

        if($curso_alumno[0]->ubiClave == "CME"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'MÉRIDA, YUC., A ' . $fechaDia . ' DE ' . strtolower($mesLetras) . ' DE ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }

        if($curso_alumno[0]->ubiClave == "CVA"){
            // fecha que se mostrara en PDF 
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . strtolower($mesLetras) . ' DE ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }

        

        $parametro_NombreArchivo = "pdf_primaria_constancia_NoAdeudo_general";
        // view('reportes.pdf.primaria.constancias.pdf_primaria_constancia_NoAdeudo_general');
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            "genero" => $parametro_genero_alumno,
            // "alumno" => $parametro_alumno,     
            "grado" => $gradoEnLetras,
            // "grupo" => $parametro_grupo,
            "fechaHoy" => $fechahoy,
            "periodo" => $periodo,
            // "matricula" => $parametro_matricula,
            "clave" => $parametro_clave,
            "parametro_consideracion" => $parametro_consideracion,
            "inscrito" => $curso_alumno,
            "ubicacion" =>$curso_alumno[0]->ubiClave,
            "incluyeFoto" => $request->incluyeFoto,
            "perAnioPago" => $perAnioPago,
            "campus" => $campus
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo.'.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

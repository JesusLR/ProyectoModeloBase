<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class SecundariaConstanciaEstudiosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.reportes.constancias.estudios', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {

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
            ->join("planes", "cgt.plan_id", "=", "planes.id")
            ->join("programas", "planes.programa_id", "=", "programas.id")
            ->join("periodos", "cursos.periodo_id", "=", "periodos.id")
            ->join("departamentos", "periodos.departamento_id", "=", "departamentos.id")
            ->join("ubicacion", "departamentos.ubicacion_id", "=", "ubicacion.id")
            ->where('periodos.id', $request->periodo_id)
            ->where('planes.id', $request->plan_id)
            ->where('programas.id', $request->programa_id)
            ->where(static function ($query) use ($request) {

                if ($request->fotoAlumno == "SI") {
                    $query->where('cursos.curSecundariaFoto', '!=', "");
                }

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
            ->orderBy('personas.perApellido1')
            ->orderBy('personas.perApellido2')
            ->orderBy('personas.perNombre')
            ->get();

        if (count($curso_alumno) <= 0) {
            alert()->warning('Sin coincidencias', 'Se no han encontrado datos con la información proporcionada')->showConfirmButton();
            return back()->withInput();
        }


        $parametro_periodo_inicio = $curso_alumno[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno[0]->perAnioPago;
        $periodo = $parametro_periodo_inicio . '-' . $parametro_periodo_fin;
        $parametro_ubicacion_clave = $curso_alumno[0]->ubiClave;

      
       

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

            $parametro_NombreArchivo = "pdf_secundaria_constancia_estudios_cme_general";
            // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_estudios_cme_general');
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
                "fechaHoy" => $fechahoy,
                "periodo" => $periodo,
                "parametro_ubicacion_clave" => $parametro_ubicacion_clave,
                "curso_alumno" => $curso_alumno,
                "fotoAlumno" => $request->fotoAlumno,
                "campus" => "CampusCME"
            ]);

            $pdf->defaultFont = 'Calibri';

            return $pdf->stream('contancia_de_estudios.pdf');
            return $pdf->download('contancia_de_estudios.pdf');
        }
        if ($parametro_ubicacion_clave == "CVA") {
            $fechahoy = 'VALLADOLID, YUC., A ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';


            $parametro_NombreArchivo = "pdf_secundaria_constancia_estudios_cva_general";
            // view('reportes.pdf.secundaria.constancias.pdf_secundaria_constancia_estudios_cva_general');
            $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
                "fechaHoy" => $fechahoy,
                "periodo" => $periodo,
                "parametro_ubicacion_clave" => $parametro_ubicacion_clave,
                "curso_alumno" => $curso_alumno,
                "fotoAlumno" => $request->fotoAlumno,
                "campus" => "CampusCVA"
            ]);

            $pdf->defaultFont = 'Calibri';

            return $pdf->stream('contancia_de_estudios.pdf');
            return $pdf->download('contancia_de_estudios.pdf');
        }
    }
}

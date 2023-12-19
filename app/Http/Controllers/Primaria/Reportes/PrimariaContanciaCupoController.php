<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaContanciaCupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('primaria.reportes.constancias.cupo', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        # code...
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
            ->join("planes", "cgt.plan_id", "=", "planes.id")
            ->where("periodos.id", $request->periodo_id)
            ->where("planes.id", $request->plan_id)
            ->where("cursos.curEstado", '=', 'R')
            ->where(static function ($query) use ($request) {

                if ($request->incluyeFoto == "SI") {
                    $query->where('cursos.curPrimariaFoto', '!=', "");
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

        // $inscrito = DB::select("call procPrimariaCalificacionesSEPAlumno(".$id_curso.")");

        // $inscrito = collect($inscrito);


        // $parametro_alumno = $inscrito[0]->nombres . ' ' . $inscrito[0]->ape_paterno . ' ' . $inscrito[0]->ape_materno;
        $parametro_grupo = $curso_alumno[0]->cgtGradoSemestre;
        $parametro_periodo_incio = $curso_alumno[0]->perAnioPago;
        $parametro_periodo_fin = 1 + (int)$curso_alumno[0]->perAnioPago;
        $parametro_periodo_sig = 1 + $parametro_periodo_fin;
        // valida el genero





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
        if ($curso_alumno[0]->cgtGradoSemestre == 1
        ) {
            $gradoEnLetras = "primer grado";
            $gradoSiguiente = "SEGUNDO GRADO";
        }
        if ($curso_alumno[0]->cgtGradoSemestre == 2
        ) {
            $gradoEnLetras = "segundo grado";
            $gradoSiguiente = "TERCER GRADO";
        }
        if ($curso_alumno[0]->cgtGradoSemestre == 3
        ) {
            $gradoEnLetras = "tercer grado";
            $gradoSiguiente = "CUARTO GRADO";
        }
        if ($curso_alumno[0]->cgtGradoSemestre == 4
        ) {
            $gradoEnLetras = "cuarto grado";
            $gradoSiguiente = "QUINTO GRADO";
        }
        if ($curso_alumno[0]->cgtGradoSemestre == 5
        ) {
            $gradoEnLetras = "quinto grado";
            $gradoSiguiente = "SEXTO GRADO";
        }
        if ($curso_alumno[0]->cgtGradoSemestre == 6
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
        if($curso_alumno[0]->ubiClave == "CME"){
            $fechahoy = 'Mérida, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCME";
        }

        if($curso_alumno[0]->ubiClave == "CVA"){
            $fechahoy = 'Valladolid, Yuc., a ' . $fechaDia . ' de ' . strtolower($mesLetras) . ' de ' . $fechaAnio . '.';
            $campus = "primariaCVA";
        }


        $parametro_NombreArchivo = "pdf_primaria_constancia_cupo_general";
        // view('reportes.pdf.primaria.constancias.pdf_primaria_constancia_cupo_general');
        $pdf = PDF::loadView('reportes.pdf.primaria.constancias.' . $parametro_NombreArchivo, [
            'inscrito' => $curso_alumno,
            'fechaHoy' => $fechahoy,
            'grado' => $gradoEnLetras,
            'grupo' => $parametro_grupo,
            'periodo_inicio' => $parametro_periodo_incio,
            'periodo_fin' => $parametro_periodo_fin,
            'periodo_siguiente' => $parametro_periodo_sig,
            'gradoSiguiente' => $gradoSiguiente,
            'ubicacion' => $curso_alumno[0]->ubiClave,
            'incluyeFoto' => $request->incluyeFoto,
            'campus' => $campus

        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

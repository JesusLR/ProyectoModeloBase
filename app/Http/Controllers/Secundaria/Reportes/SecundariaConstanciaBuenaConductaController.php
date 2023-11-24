<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use App\clases\cgts\MetodosCgt;
use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Curso;
use App\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class SecundariaConstanciaBuenaConductaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.reportes.constancias.buenaConducta', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
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
            ->join("planes", "cgt.plan_id", "=", "planes.id")
            ->where("periodos.id", $request->periodo_id)
            ->where("planes.id", $request->plan_id)
            ->where("cursos.curEstado", '<>', 'B')
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


        // obtener fecha del sistema 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaDia = $fechaActual->format('d');
        $fechaMes = $fechaActual->format('m');
        $fechaAnio = $fechaActual->format('Y');

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



        if ($curso_alumno[0]->ubiClave == "CME") {
            $fechahoy = 'MÉRIDA, YUC., ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';

            $parametro_NombreArchivo = "pdf_secundaria_carta_conducta_general_cme";
            // view('reportes.pdf.secundaria.constancias.pdf_secundaria_carta_conducta_general_cme');
        }

        if ($curso_alumno[0]->ubiClave == "CVA") {
            $fechahoy = 'VALLADOLID, YUC., ' . $fechaDia . ' DE ' . $mesLetras . ' DE ' . $fechaAnio . '.';

            $parametro_NombreArchivo = "pdf_secundaria_carta_conducta_general_cva";
            // view('reportes.pdf.secundaria.constancias.pdf_secundaria_carta_conducta_general_cva');

        }


       
        $pdf = PDF::loadView('reportes.pdf.secundaria.constancias.' . $parametro_NombreArchivo, [
            "curso_alumno" => $curso_alumno,
            "fecha" => $fechahoy,
            "firmaSello" => $request->firmaSello
        ]);

        $pdf->defaultFont = 'Times New Roman';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');

    }
}

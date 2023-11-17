<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Periodo;
use App\Http\Models\Secundaria\Secundaria_alumnos_historia_clinica;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaListaDeInteresadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.reportes.lista_de_interesados.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        $periodo_id = $request->periodo_id;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $reporte_a_generar = $request->reporte_a_generar;

        $periodo = Periodo::where('id', $periodo_id)->first();

        if ($reporte_a_generar == "1") {
            $alumnos_actuales = DB::select("SELECT 
                personas.perApellido1,
                personas.perApellido2,
                personas.perNombre,
                personas.perCurp,
                personas.perCorreo1,
                alumnos.id as alumno_id,
                alumnos.aluClave,
                alumnos.aluGradoIngr,
                periodos.perAnioPago
                FROM cursos AS cursos
                INNER JOIN periodos ON cursos.periodo_id = periodos.id
                AND periodos.deleted_at IS NULL
                INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
                AND alumnos.deleted_at IS NULL
                INNER JOIN personas ON alumnos.persona_id = personas.id
                AND personas.deleted_at IS NULL
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
                INNER JOIN secundaria_alumnos_historia_clinica sc ON sc.alumno_id = alumnos.id
                AND sc.deleted_at IS NULL
            WHERE
                cursos.deleted_at IS NULL
                AND depClave = 'SEC'
                AND periodos.perAnioPago = $periodo->perAnioPago
            GROUP BY personas.perApellido1, 
            personas.perApellido2, personas.perNombre, 
            alumnos.id, alumnos.aluClave, periodos.perAnioPago;");
        }

        if ($reporte_a_generar == "2") {
            $alumnos_actuales = DB::select("SELECT 
            personas.perApellido1,
            personas.perApellido2,
            personas.perNombre,
            personas.perCurp,
            personas.perCorreo1,
            alumnos.id as alumno_id,
            alumnos.aluClave,
            alumnos.aluGradoIngr,
            sc.created_at
            FROM secundaria_alumnos_historia_clinica sc 
            INNER JOIN alumnos AS alumnos ON sc.alumno_id = alumnos.id
              AND sc.deleted_at IS NULL
            INNER JOIN personas ON alumnos.persona_id = personas.id
              AND personas.deleted_at IS NULL
            WHERE sc.alumno_id not in (
                SELECT distinct 
                alumnos.id as alumno_id
                FROM cursos AS cursos
                  INNER JOIN periodos ON cursos.periodo_id = periodos.id
                  AND periodos.deleted_at IS NULL
                  INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
                  AND alumnos.deleted_at IS NULL
                  INNER JOIN personas ON alumnos.persona_id = personas.id
                  AND personas.deleted_at IS NULL
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
            WHERE
                  cursos.deleted_at IS NULL
                  AND depClave = 'SEC')");
        }

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $parametro_NombreArchivo = "pdf_secundaria_lista_de_interesados";
            $pdf = PDF::loadView('reportes.pdf.secundaria.lista_de_interesados.' . $parametro_NombreArchivo, [
                "alumnos" => $alumnos_actuales,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "reporte_a_generar" => $reporte_a_generar              
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Primaria\Primaria_asistencia;
use App\Models\Primaria\Primaria_grupo;
use App\Models\Primaria\Primaria_inscrito;
use App\Models\Ubicacion;
use Carbon\Carbon;
use DateTime;
use Hamcrest\Util;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaListaDeFaltasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        // $ubicaciones = Ubicacion::sedes()->get();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();

        return view('primaria.reportes.lista_de_faltas.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getGruposGrado(Request $request, $perido_id, $plan_id, $grado)
    {
        if ($request->ajax()) {


            $primaria_grupos = DB::select("SELECT 
            pg.id,
            pg.gpoGrado,
            pg.gpoClave,
            pg.plan_id,
            pm.matClave,
            pm.matNombre,
            pma.matClaveAsignatura,
            pma.matNombreAsignatura
            FROM primaria_grupos AS pg
            INNER JOIN primaria_materias AS pm ON pm.id = pg.primaria_materia_id
            INNER JOIN periodos AS p ON p.id = pg.periodo_id
            LEFT JOIN primaria_materias_asignaturas AS pma ON pma.id = pg.primaria_materia_asignatura_id
            WHERE p.id = $perido_id
            AND pg.plan_id = $plan_id
            AND pg.gpoGrado = $grado");

            return response()->json($primaria_grupos);
        }
    }

    public function imprimir(Request $request)
    {
        $primaria_grupo_id = $request->primaria_grupo_id_select;
        $tipoDeModalidad = $request->tipoDeModalidad;
        $periodo_id = $request->periodo_id;
        $plan_id = $request->plan_id;
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;
        $numeroGrado = $request->numeroGrado;

        if ($primaria_grupo_id != "") {
            $primaria_inscritos = DB::select("SELECT 
            pi.id,
            pg.id AS primaria_grupo_id,
            pg.gpoGrado,
            pg.gpoClave,
            a.aluClave,
            pe.perApellido1,
            pe.perApellido2,
            pe.perNombre,
            p.perAnio,
            p.perNumero,
            p.perFechaInicial,
            p.perFechaFinal,
            d.depClave,
            d.depNombre,
            u.ubiClave,
            u.ubiNombre,
            pl.planClave,
            pro.progClave,
            pro.progNombre,
            es.escClave,
            es.escNombre,
            pm.matClave,
            pm.matNombre,
            pma.matClaveAsignatura,
            pma.matNombreAsignatura,
            pem.empApellido1,
            pem.empApellido2,
            pem.empNombre,
            pi.inscTipoAsistencia
            FROM primaria_inscritos AS pi
            INNER JOIN primaria_grupos AS pg ON pg.id = pi.primaria_grupo_id
            AND pg.deleted_at IS NULL
            INNER JOIN cursos AS c ON c.id = pi.curso_id
            AND c.deleted_at IS NULL
            INNER JOIN alumnos AS a ON a.id = c.alumno_id
            AND a.deleted_at IS NULL
            INNER JOIN personas AS pe ON pe.id = a.persona_id
            AND pe.deleted_at IS NULL
            INNER JOIN periodos AS p ON p.id = pg.periodo_id
            AND p.deleted_at IS NULL
            INNER JOIN departamentos AS d ON d.id = p.departamento_id
            AND d.deleted_at IS NULL
            INNER JOIN ubicacion AS u ON u.id = d.ubicacion_id
            AND u.deleted_at IS NULL
            INNER JOIN planes AS pl ON pl.id = pg.plan_id
            AND pl.deleted_at IS NULL
            INNER JOIN programas AS pro ON pro.id = pl.programa_id
            AND pro.deleted_at IS NULL
            INNER JOIN escuelas AS es ON es.id = pro.escuela_id
            AND es.deleted_at IS NULL
            INNER JOIN primaria_materias_asignaturas AS pma ON pma.id = pg.primaria_materia_asignatura_id
            AND pma.deleted_at IS NULL
            INNER JOIN primaria_materias AS pm ON pm.id = pg.primaria_materia_id
            AND pm.deleted_at IS NULL
            INNER JOIN primaria_empleados AS pem ON pem.id = pi.inscEmpleadoIdDocente
            AND pem.deleted_at IS NULL
            WHERE pg.id = $primaria_grupo_id
            AND pi.inscTipoAsistencia = '".$tipoDeModalidad."'
            AND pi.deleted_at IS NULL
            ORDER BY pe.perApellido1 ASC, pe.perApellido2 ASC, pe.perNombre ASC");

            $collect_primaria_inscritos = collect($primaria_inscritos);


            if ($collect_primaria_inscritos->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }


            $parametro_periodo = Utils::fecha_string($primaria_inscritos[0]->perFechaInicial, $primaria_inscritos[0]->perFechaInicial) . ' al ' . Utils::fecha_string($primaria_inscritos[0]->perFechaFinal, $primaria_inscritos[0]->perFechaFinal) . ' (' . $primaria_inscritos[0]->perNumero . '-' . $primaria_inscritos[0]->perAnio . ')';
            $parametro_escuela = $primaria_inscritos[0]->escClave . ' (' . $primaria_inscritos[0]->planClave . ') ' . $primaria_inscritos[0]->escNombre;
            $parametro_ubicacion = $primaria_inscritos[0]->ubiClave . '-' . $primaria_inscritos[0]->ubiNombre;
            $parametro_materia = $primaria_inscritos[0]->matClave . '-' . $primaria_inscritos[0]->matNombre;
            $parametro_asignatura = $primaria_inscritos[0]->matClaveAsignatura . '-' . $primaria_inscritos[0]->matNombreAsignatura;

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $parametro_fecha_actual = Utils::fecha_string($fechaActual->format('Y-m-d'), $fechaActual->format('Y-m-d'));
            $parametro_hora_actual = $fechaActual->format('H:i:s');
            $parametro_rango_busqueda = 'Del ' . Utils::fecha_string($fechaInicio, $fechaInicio) . ' al ' . Utils::fecha_string($fechaFin, $fechaFin);


            $parametro_NombreArchivo = "pdf_primaria_lista_de_asistencia";
            // view('reportes.pdf.primaria.lista_de_faltas.pdf_primaria_lista_de_asistencia');
            $pdf = PDF::loadView('reportes.pdf.primaria.lista_de_faltas.' . $parametro_NombreArchivo, [
                "primaria_inscritos" => $collect_primaria_inscritos,
                "fechaActual" => $parametro_fecha_actual,
                "horaActual" => $parametro_hora_actual,
                "parametro_NombreArchivo" => $parametro_NombreArchivo,
                "modalidad" => $request->tipoDeModalidad,
                "parametro_periodo" => $parametro_periodo,
                "parametro_escuela" => $parametro_escuela,
                "parametro_ubicacion" => $parametro_ubicacion,
                "parametro_materia" => $parametro_materia,
                "parametro_asignatura" => $parametro_asignatura,
                "fechaInicio" => $fechaInicio,
                "fechaFin" => $fechaFin,
                "parametro_rango_busqueda" => $parametro_rango_busqueda
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        } else {
            $primaria_inscritos = DB::select("SELECT 
            pi.id,
            pg.id AS primaria_grupo_id,
            pg.gpoGrado,
            pg.gpoClave,
            a.aluClave,
            pe.perApellido1,
            pe.perApellido2,
            pe.perNombre,
            p.perAnio,
            p.perNumero,
            p.perFechaInicial,
            p.perFechaFinal,
            d.depClave,
            d.depNombre,
            u.ubiClave,
            u.ubiNombre,
            pl.planClave,
            pro.progClave,
            pro.progNombre,
            es.escClave,
            es.escNombre,
            pm.matClave,
            pm.matNombre,
            pma.matClaveAsignatura,
            pma.matNombreAsignatura,
            pem.empApellido1,
            pem.empApellido2,
            pem.empNombre,
            pi.inscTipoAsistencia
            FROM primaria_inscritos AS pi
            INNER JOIN primaria_grupos AS pg ON pg.id = pi.primaria_grupo_id
            AND pg.deleted_at IS NULL
            INNER JOIN cursos AS c ON c.id = pi.curso_id
            AND c.deleted_at IS NULL
            INNER JOIN alumnos AS a ON a.id = c.alumno_id
            AND a.deleted_at IS NULL
            INNER JOIN personas AS pe ON pe.id = a.persona_id
            AND pe.deleted_at IS NULL
            INNER JOIN periodos AS p ON p.id = pg.periodo_id
            AND p.deleted_at IS NULL
            INNER JOIN departamentos AS d ON d.id = p.departamento_id
            AND d.deleted_at IS NULL
            INNER JOIN ubicacion AS u ON u.id = d.ubicacion_id
            AND u.deleted_at IS NULL
            INNER JOIN planes AS pl ON pl.id = pg.plan_id
            AND pl.deleted_at IS NULL
            INNER JOIN programas AS pro ON pro.id = pl.programa_id
            AND pro.deleted_at IS NULL
            INNER JOIN escuelas AS es ON es.id = pro.escuela_id
            AND es.deleted_at IS NULL
            INNER JOIN primaria_materias_asignaturas AS pma ON pma.id = pg.primaria_materia_asignatura_id
            AND pma.deleted_at IS NULL
            INNER JOIN primaria_materias AS pm ON pm.id = pg.primaria_materia_id
            INNER JOIN primaria_empleados AS pem ON pem.id = pi.inscEmpleadoIdDocente
            AND pem.deleted_at IS NULL
            WHERE pi.inscTipoAsistencia = '".$tipoDeModalidad."'
            AND p.id = $periodo_id
            AND pl.id = $plan_id
            AND pg.gpoGrado = $numeroGrado
            AND pm.deleted_at IS NULL
            AND pi.deleted_at IS NULL
            ORDER BY pe.perApellido1 ASC, pe.perApellido2 ASC, pe.perNombre ASC");

            $collect_primaria_inscritos = collect($primaria_inscritos);

            

            if ($collect_primaria_inscritos->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $agrupados = $collect_primaria_inscritos->groupBy('primaria_grupo_id');
            
            $parametro_periodo = Utils::fecha_string($primaria_inscritos[0]->perFechaInicial, $primaria_inscritos[0]->perFechaInicial) . ' al ' . Utils::fecha_string($primaria_inscritos[0]->perFechaFinal, $primaria_inscritos[0]->perFechaFinal) . ' (' . $primaria_inscritos[0]->perNumero . '-' . $primaria_inscritos[0]->perAnio . ')';
            $parametro_escuela = $primaria_inscritos[0]->escClave . ' (' . $primaria_inscritos[0]->planClave . ') ' . $primaria_inscritos[0]->escNombre;
            $parametro_ubicacion = $primaria_inscritos[0]->ubiClave . '-' . $primaria_inscritos[0]->ubiNombre;
            $parametro_materia = $primaria_inscritos[0]->matClave . '-' . $primaria_inscritos[0]->matNombre;
            $parametro_asignatura = $primaria_inscritos[0]->matClaveAsignatura . '-' . $primaria_inscritos[0]->matNombreAsignatura;

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $parametro_fecha_actual = Utils::fecha_string($fechaActual->format('Y-m-d'), $fechaActual->format('Y-m-d'));
            $parametro_hora_actual = $fechaActual->format('H:i:s');
            $parametro_rango_busqueda = 'Del ' . Utils::fecha_string($fechaInicio, $fechaInicio) . ' al ' . Utils::fecha_string($fechaFin, $fechaFin);


            $parametro_NombreArchivo = "pdf_primaria_lista_de_asistencia_todos";
            // view('reportes.pdf.primaria.lista_de_faltas.pdf_primaria_lista_de_asistencia_todos');
            $pdf = PDF::loadView('reportes.pdf.primaria.lista_de_faltas.' . $parametro_NombreArchivo, [
                "agrupados" => $agrupados,
                "fechaActual" => $parametro_fecha_actual,
                "horaActual" => $parametro_hora_actual,
                "parametro_NombreArchivo" => $parametro_NombreArchivo,
                "modalidad" => $request->tipoDeModalidad,
                "parametro_periodo" => $parametro_periodo,
                "parametro_escuela" => $parametro_escuela,
                "parametro_ubicacion" => $parametro_ubicacion,
                "parametro_materia" => $parametro_materia,
                "parametro_asignatura" => $parametro_asignatura,
                "fechaInicio" => $fechaInicio,
                "fechaFin" => $fechaFin,
                "parametro_rango_busqueda" => $parametro_rango_busqueda
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }
}
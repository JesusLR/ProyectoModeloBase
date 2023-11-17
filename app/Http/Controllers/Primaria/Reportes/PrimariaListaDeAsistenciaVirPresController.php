<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Periodo;
use App\Http\Models\Primaria\Primaria_asistencia;
use App\Http\Models\Primaria\Primaria_empleado;
use App\Http\Models\Primaria\Primaria_inscrito;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaListaDeAsistenciaVirPresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        // $ubicaciones = Ubicacion::sedes()->get();
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->sedes()->get();

        $docentes = Primaria_empleado::where('empEstado', '!=', 'B')->get();

        return view('primaria.reportes.lista_presencial_virtual.create', [
            'ubicaciones' => $ubicaciones,
            'docentes' => $docentes
        ]);
    }

    public function imprimir(Request $request)
    {
        $gpoGrado = $request->gpoGrado;
        $gpoGrupo = $request->gpoGrupo;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $periodo = Periodo::find($request->periodo_id);
        $perAnioPago = $periodo->perAnioPago;
        $docente_id = $request->docente_id;

        // alumnos inscritos antes del 2021
        if ($request->tipoDeModalidad == "") {

            $agrupados = DB::table('primaria_inscritos')
                ->select(
                    'primaria_grupos.gpoGrado',
                    DB::raw('count(*) as gpoGrado, primaria_grupos.gpoGrado'),
                    'primaria_grupos.gpoClave',
                    DB::raw('count(*) as gpoClave, primaria_grupos.gpoClave'),
                    'primaria_inscritos.primaria_grupo_id',
                    DB::raw('count(*) as primaria_grupo_id, primaria_inscritos.primaria_grupo_id'),
                    'primaria_materias.matNombre',
                    DB::raw('count(*) as matNombre, primaria_materias.matNombre'),
                    'primaria_materias.matClave',
                    DB::raw('count(*) as matClave, primaria_materias.matClave'),
                    'primaria_grupos.empleado_id_docente',
                    DB::raw('count(*) as empleado_id_docente, primaria_grupos.empleado_id_docente'),
                    'primaria_empleados.empNombre',
                    DB::raw('count(*) as empNombre, primaria_empleados.empNombre'),
                    'primaria_empleados.empApellido1',
                    DB::raw('count(*) as empApellido1, primaria_empleados.empApellido1'),
                    'primaria_empleados.empApellido2',
                    DB::raw('count(*) as empApellido2, primaria_empleados.empApellido2'),
                    'primaria_empleados.empSexo',
                    DB::raw('count(*) as empSexo, primaria_empleados.empSexo'),
                    'planes.planClave',
                    DB::raw('count(*) as planClave, planes.planClave'),
                    'ubicacion.ubiClave',
                    DB::raw('count(*) as ubiClave, ubicacion.ubiClave'),
                    'ubicacion.ubiNombre',
                    DB::raw('count(*) as ubiNombre, ubicacion.ubiNombre'),
                    'escuelas.escClave',
                    DB::raw('count(*) as escClave, escuelas.escClave'),
                    'escuelas.escNombre',
                    DB::raw('count(*) as escNombre, escuelas.escNombre'),
                    'periodos.perFechaInicial',
                    DB::raw('count(*) as perFechaInicial, periodos.perFechaInicial'),
                    'periodos.perFechaFinal',
                    DB::raw('count(*) as perFechaFinal, periodos.perFechaFinal'),
                    'programas.progClave',
                    DB::raw('count(*) as progClave, programas.progClave'),
                    'programas.progNombre',
                    DB::raw('count(*) as progNombre, programas.progNombre'),
                    'primaria_materias_asignaturas.matClaveAsignatura',
                    DB::raw('count(*) as matClaveAsignatura, primaria_materias_asignaturas.matClaveAsignatura'),
                    'primaria_materias_asignaturas.matNombreAsignatura',
                    DB::raw('count(*) as matNombreAsignatura, primaria_materias_asignaturas.matNombreAsignatura')

                )
                ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
                ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
                ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
                ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('primaria_empleados', 'primaria_grupos.empleado_id_docente', '=', 'primaria_empleados.id')
                ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
                ->groupBy('primaria_grupos.gpoGrado')
                ->groupBy('primaria_grupos.gpoClave')
                ->groupBy('primaria_inscritos.primaria_grupo_id')
                ->groupBy('primaria_materias.matNombre')
                ->groupBy('primaria_materias.matClave')
                ->groupBy('primaria_grupos.empleado_id_docente')
                ->groupBy('primaria_empleados.empNombre')
                ->groupBy('primaria_empleados.empApellido1')
                ->groupBy('primaria_empleados.empApellido2')
                ->groupBy('primaria_empleados.empSexo')
                ->groupBy('planes.planClave')
                ->groupBy('ubicacion.ubiClave')
                ->groupBy('escuelas.escClave')
                ->groupBy('escuelas.escNombre')
                ->groupBy('periodos.perFechaInicial')
                ->groupBy('periodos.perFechaFinal')
                ->groupBy('programas.progClave')
                ->groupBy('programas.progNombre')
                ->groupBy('primaria_materias_asignaturas.matClaveAsignatura')
                ->groupBy('primaria_materias_asignaturas.matNombreAsignatura')
                ->where('programas.id', $programa_id)
                ->where('planes.id', $plan_id)
                ->where('periodos.perAnioPago', $perAnioPago)
                ->where('primaria_grupos.gpoGrado', $gpoGrado)
                ->where('primaria_grupos.gpoClave', $gpoGrupo)
                ->where('cursos.curEstado', '=', 'R')
                //->orderBy('primaria_grupos.gpoGrado', 'asc')
                ->orderBy('primaria_materias.matNombre', 'asc')
                ->get();
        }

        // alumnos inscritos modo presencial y virtual
        if ($request->tipoDeModalidad != "") {

            if ($gpoGrupo != "") {

                $agrupados = Primaria_inscrito::select(
                    'primaria_grupos.gpoGrado',
                    'primaria_grupos.gpoClave',
                    'primaria_inscritos.primaria_grupo_id',
                    'primaria_materias.matNombre',
                    'primaria_materias.matClave',
                    'primaria_grupos.empleado_id_docente',
                    'primaria_empleados.empNombre',
                    'primaria_empleados.empApellido1',
                    'primaria_empleados.empApellido2',
                    'primaria_empleados.empSexo',
                    'planes.planClave',
                    'ubicacion.ubiClave',
                    'ubicacion.ubiNombre',
                    'escuelas.escClave',
                    'escuelas.escNombre',
                    'periodos.perFechaInicial',
                    'periodos.perFechaFinal',
                    'programas.progClave',
                    'programas.progNombre',
                    'primaria_materias_asignaturas.matClaveAsignatura',
                    'primaria_materias_asignaturas.matNombreAsignatura',
                    'alumnos.aluClave',
                    'personas.id as persona_id',
                    'personas.perNombre',
                    'personas.perApellido1',
                    'personas.perApellido2'
                )

                    ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
                    ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
                    ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
                    ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
                    ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                    ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                    ->join('primaria_empleados', 'primaria_inscritos.inscEmpleadoIdDocente', '=', 'primaria_empleados.id')
                    ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                    ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                    ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                    ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
                    ->groupBy(
                        'primaria_grupos.gpoGrado',
                        'primaria_grupos.gpoClave',
                        'primaria_inscritos.primaria_grupo_id',
                        'primaria_materias.matNombre',
                        'primaria_materias.matClave',
                        'primaria_grupos.empleado_id_docente',
                        'primaria_empleados.empNombre',
                        'primaria_empleados.empApellido1',
                        'primaria_empleados.empApellido2',
                        'primaria_empleados.empSexo',
                        'planes.planClave',
                        'ubicacion.ubiClave',
                        'escuelas.escClave',
                        'escuelas.escNombre',
                        'periodos.perFechaInicial',
                        'periodos.perFechaFinal',
                        'programas.progClave',
                        'programas.progNombre',
                        'primaria_materias_asignaturas.matClaveAsignatura',
                        'primaria_materias_asignaturas.matNombreAsignatura',
                        'alumnos.aluClave',
                        'personas.id',
                        'personas.perNombre',
                        'personas.perApellido1',
                        'personas.perApellido2'
                    )
                    ->where('programas.id', $programa_id)
                    ->where('planes.id', $plan_id)
                    ->where('periodos.perAnioPago', $perAnioPago)
                    ->where('primaria_grupos.gpoGrado', $gpoGrado)
                    ->where('primaria_grupos.gpoClave', $gpoGrupo)
                    ->where('cursos.curEstado', '=', 'R')
                    ->where('primaria_inscritos.inscTipoAsistencia', '=', $request->tipoDeModalidad)
                    ->where('primaria_inscritos.inscEmpleadoIdDocente', '=', $docente_id)
                    //->orderBy('primaria_grupos.gpoGrado', 'asc')
                    ->orderBy('personas.perApellido1', 'asc')
                    ->get();
            } else {
                $agrupados = Primaria_inscrito::select(
                    'primaria_grupos.gpoGrado',
                    'primaria_grupos.gpoClave',
                    'primaria_inscritos.primaria_grupo_id',
                    'primaria_materias.matNombre',
                    'primaria_materias.matClave',
                    'primaria_grupos.empleado_id_docente',
                    'primaria_empleados.empNombre',
                    'primaria_empleados.empApellido1',
                    'primaria_empleados.empApellido2',
                    'primaria_empleados.empSexo',
                    'planes.planClave',
                    'ubicacion.ubiClave',
                    'ubicacion.ubiNombre',
                    'escuelas.escClave',
                    'escuelas.escNombre',
                    'periodos.perFechaInicial',
                    'periodos.perFechaFinal',
                    'programas.progClave',
                    'programas.progNombre',
                    'primaria_materias_asignaturas.matClaveAsignatura',
                    'primaria_materias_asignaturas.matNombreAsignatura',
                    'alumnos.aluClave',
                    'personas.id as persona_id',
                    'personas.perNombre',
                    'personas.perApellido1',
                    'personas.perApellido2'
                )
                    ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
                    ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
                    ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
                    ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
                    ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                    ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                    ->join('primaria_empleados', 'primaria_inscritos.inscEmpleadoIdDocente', '=', 'primaria_empleados.id')
                    ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                    ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                    ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                    ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
                    ->groupBy(
                        'primaria_grupos.gpoGrado',
                        'primaria_grupos.gpoClave',
                        'primaria_inscritos.primaria_grupo_id',
                        'primaria_materias.matNombre',
                        'primaria_materias.matClave',
                        'primaria_grupos.empleado_id_docente',
                        'primaria_empleados.empNombre',
                        'primaria_empleados.empApellido1',
                        'primaria_empleados.empApellido2',
                        'primaria_empleados.empSexo',
                        'planes.planClave',
                        'ubicacion.ubiClave',
                        'escuelas.escClave',
                        'escuelas.escNombre',
                        'periodos.perFechaInicial',
                        'periodos.perFechaFinal',
                        'programas.progClave',
                        'programas.progNombre',
                        'primaria_materias_asignaturas.matClaveAsignatura',
                        'primaria_materias_asignaturas.matNombreAsignatura',
                        'alumnos.aluClave',
                        'personas.id',
                        'personas.perNombre',
                        'personas.perApellido1',
                        'personas.perApellido2'
                    )
                    ->where('programas.id', $programa_id)
                    ->where('planes.id', $plan_id)
                    ->where('periodos.perAnioPago', $perAnioPago)
                    ->where('primaria_grupos.gpoGrado', $gpoGrado)
                    ->where('cursos.curEstado', '=', 'R')
                    ->where('primaria_inscritos.inscTipoAsistencia', '=', $request->tipoDeModalidad)
                    ->where('primaria_inscritos.inscEmpleadoIdDocente', '=', $docente_id)
                    ->whereNull('primaria_grupos.deleted_at')
                    ->whereNull('primaria_inscritos.deleted_at')
                    //->orderBy('primaria_grupos.gpoGrado', 'asc')
                    ->orderBy('personas.perApellido1', 'asc')
                    ->get();
            }
        }


        if ($agrupados->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No se ha encontrado información con los datos proporcionados.')->showConfirmButton();
            return back()->withInput();
        }

        $alumnos = $agrupados->groupBy('aluClave');
        $prametro_progClave = $agrupados[0]->progClave;
        $parametro_docente = $agrupados[0]->empNombre.' '.$agrupados[0]->empApellido1.' '.$agrupados[0]->empApellido2;
        $parametro_ciclo_escolar = $perAnioPago.'-'.intval($perAnioPago+1);

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $parametro_NombreArchivo = "pdf_primaria_lista_presencial_virtual";
        $pdf = PDF::loadView('reportes.pdf.primaria.lista_presencial_virtual.' . $parametro_NombreArchivo, [
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "parametro_NombreArchivo" => $parametro_NombreArchivo,
            "alumnos" => $alumnos,
            "modalidad" => $request->tipoDeModalidad,
            "gpoGrado" => $gpoGrado,
            "prametro_progClave" => $prametro_progClave,
            "parametro_docente" => $parametro_docente,
            "parametro_ciclo_escolar" => $parametro_ciclo_escolar
        ]);


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


}

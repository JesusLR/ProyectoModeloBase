<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Conceptoscursoestado;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerCalificacionPorGrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();


        $conceptos = Conceptoscursoestado::get();
       
        return view('bachiller.reportes.calificaciones_por_grupo.boleta-calificaciones-create', [
            'ubicaciones' => $ubicaciones,
            'conceptos' => $conceptos
        ]);
       
    }

 
    public function imprimirCalificaciones(Request $request)
    {

        // filtra las calificaciones de acuerdo al mes que el usuario indique 
        $mesEvaluar = $request->mesEvaluar;
        $conceptos = $request->conceptos;
        $perAnioPago = $request->periodo_id;
        $gpoGrado = $request->gpoGrado;
        $gpoClave = $request->gpoClave;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $tipoReporte = $request->tipoReporte;
        $bimestreEvaluar = $request->bimestreEvaluar;
        $trimestreEvaluar = $request->trimestreEvaluar;
        $tipoCalificacionVista = $request->tipoCalificacionVista;

        $parametro_Titulo = "LISTA PARA REPORTAR CALIF.";

        // llama al procedure de los alumnos a buscar 
        $resultado_array =  DB::select("call procBachillerCalificacionesGrupo(".$perAnioPago.", ".$gpoGrado.", '".$gpoClave."', '".$conceptos."',".$programa_id.",".$plan_id.")");

        $resultado_collection = collect($resultado_array);

        // si no hay datos muestra alerta 
        if ($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }
    
        $resultado_registro = $resultado_array[0];
        $parametro_Grado = $resultado_registro->grado;
        $parametro_Grupo = $resultado_registro->grupo;
        $parametro_CGTGrupo = $resultado_registro->grupo;
        $parametro_Ciclo = $resultado_registro->ciclo_escolar;
        $parametro_progClave = $resultado_registro->progClave;
        $parametro_planClave = $resultado_registro->planClave;
        $parametro_progNombre = $resultado_registro->progNombre;

        // consulta para llenar los datos de la cabecera del pdf 
        $datos_cabecera = Bachiller_inscritos::select(
            'bachiller_inscritos.id', 
            'bachiller_inscritos.inscCalificacionSep', 
            'bachiller_inscritos.inscCalificacionOct', 
            'bachiller_inscritos.inscCalificacionNov', 
            'bachiller_inscritos.inscCalificacionDic',
            'bachiller_inscritos.inscCalificacionEne',
            'bachiller_inscritos.inscCalificacionFeb',
            'bachiller_inscritos.inscCalificacionMar',
            'bachiller_inscritos.inscCalificacionAbr',
            'bachiller_inscritos.inscCalificacionMay',
            'bachiller_inscritos.inscCalificacionJun',
            'bachiller_grupos.id as bachiller_grupo_id',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoClave',
            'bachiller_grupos.gpoTurno',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matNombreCorto',
            'planes.id as plan_id',
            'planes.planClave',
            'planes.planPeriodos',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'programas.progNombreCorto',
            'departamentos.id as departamento_id',
            'departamentos.depNivel',
            'departamentos.depClave',
            'departamentos.depNombre',
            'departamentos.depNombreCorto',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave', 
            'escuelas.escNombre',
            'escuelas.escNombreCorto',
            'bachiller_empleados.id as bachiller_empleado_id',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre',
            'cursos.id as curso_id',
            'alumnos.id as alumno_id',
            'alumnos.aluClave',
            'alumnos.aluEstado',
            'alumnos.aluMatricula',
            'personas.id as persona_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'cgt.cgtGrupo',
            'cgt.cgtGradoSemestre'
        )
        ->leftJoin('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
        ->leftJoin('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->leftJoin('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
        ->leftJoin('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
        ->leftJoin('programas', 'planes.programa_id', '=', 'programas.id')
        ->leftJoin('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
        ->leftJoin('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
        ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->leftJoin('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->where('departamentos.depClave', 'BAC')
        ->where('periodos.perAnioPago', $request->periodo_id)
        ->where('cgt.cgtGradoSemestre', $request->gpoGrado)
        ->where('cgt.cgtGrupo', $request->gpoClave)
        ->where('cursos.curEstado', $request->conceptos)
        ->first();

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        // obtiene las materias que se relacionan con el alumno en curso 
        $materia_alumos =  DB::select("SELECT DISTINCT
        sm.id AS bachiller_materia_id,
        sm.matClave,
        sm.matNombre,
        sm.matNombreCorto,
        sg.gpoMatComplementaria,
        cgt.cgtGrupo,
        sg.gpoClave
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
            INNER JOIN bachiller_inscritos si ON si.curso_id = cursos.id
            AND si.deleted_at IS NULL
            INNER JOIN bachiller_grupos sg ON sg.id = si.bachiller_grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN bachiller_materias sm ON sm.id = sg.bachiller_materia_id
            AND sm.deleted_at IS NULL
        WHERE
        cursos.deleted_at IS NULL
            AND departamentos.depClave = 'BAC'
            AND cgt.cgtGradoSemestre = '" . $request->gpoGrado . "'
            AND  cgt.cgtGrupo = '" . $request->gpoClave . "'
            AND periodos.perAnioPago = '" . $request->periodo_id . "'
            ORDER BY sm.matClave asc");

        $parametro_NombreArchivo = 'pdf_bachiller_calificaciones'; //nombre del archivo blade

        $thead = [];
        $tbody = [];
        foreach ($resultado_collection as $key => $insc) {
            $bachiller_evidencias = DB::table('bachiller_evidencias')
                ->select('eviNumero','eviPuntos', 'eviDescripcion')
                ->where('periodo_id', $insc->periodo_id)
                ->where('bachiller_materia_id', $insc->bachiller_materia_id)
                ->get();
            $thead[$insc->bachiller_materia_id] = $bachiller_evidencias;

            $bachiller_inscritos_evidencia = DB::table('bachiller_inscritos_evidencias')
                ->select('ievPuntos')
                ->where('bachiller_inscrito_id', $insc->bachiller_inscrito_id)
                ->get();
            $tbody[$insc->bachiller_inscrito_id] = $bachiller_inscritos_evidencia;
        }

        // dd($resultado_collection, $tbody);

        $pdf = PDF::loadView('reportes.pdf.bachiller.calificacion_por_grupo.' . $parametro_NombreArchivo, [
            "materia_alumos" => $materia_alumos,
            "calificaciones" => $resultado_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $parametro_Ciclo,
            "grado" => $parametro_Grado,
            'grupo' => $parametro_Grupo,
            "titulo" => $parametro_Titulo,
            'parametro_Titulo' => $parametro_Titulo,
            'parametro_NombreArchivo' => $parametro_NombreArchivo,
            'parametro_progClave' => $parametro_progClave,
            'parametro_planClave' => $parametro_planClave,
            'parametro_progNombre' => $parametro_progNombre,
            'parametro_CGTGrupo' => $parametro_CGTGrupo,
            'thead' => $thead,
            'tbody' => $tbody,
            "mesEvaluar" => $mesEvaluar,
            "datos_cabecera" => $datos_cabecera,
            "conceptos" => $conceptos,
            "tipoReporte" => $tipoReporte,
            "bimestreEvaluar" => $bimestreEvaluar,
            "trimestreEvaluar" => $trimestreEvaluar,
            "tipoCalificacionVista" => $tipoCalificacionVista,
        ]);

        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

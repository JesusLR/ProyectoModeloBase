<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;

class BachillerCopiarHorariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.copiarHorarios.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    // obtenemos el grupo origin a migrar 
    public function ObtenerGrupoOrigen(Request $request, $plan_id, $periodo_id, $gpoGrado)
    {
        if ($request->ajax()) {
            $grupoOrigen = Bachiller_grupos::select(
                'bachiller_grupos.*',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre'
            )
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->where('bachiller_grupos.plan_id', '=', $plan_id)
                ->where('bachiller_grupos.periodo_id', '=', $periodo_id)
                ->where('bachiller_grupos.gpoGrado', '=', $gpoGrado)
                // ->where('bachiller_materias.matNombre', 'like', '%LENGUAS%')
                // ->Where('bachiller_materias.matNombre','LIKE','%ARTE DEPORTE%')
                // ->whereNotNull('gpoMatComplementaria')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->orderBy('bachiller_grupos.gpoClave', 'ASC')
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();



            return response()->json([
                'grupoOrigen' => $grupoOrigen
            ]);
        }
    }

    public function getGrupoDestino(Request $request, $plan_id, $periodo_id, $gradoDestino, $grupo_origen_id)
    {
        if ($request->ajax()) {


            // obtenemos el grupos origen 
            $grupo_origen = Bachiller_grupos::find($grupo_origen_id);

            $grupoDestino = Bachiller_grupos::select(
                'bachiller_grupos.*',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre'
            )
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->where('bachiller_grupos.plan_id', '=', $plan_id)
                ->where('bachiller_grupos.periodo_id', '=', $periodo_id)
                ->where('bachiller_grupos.gpoGrado', '=', $gradoDestino)
                ->whereNotIn('bachiller_grupos.id', [$grupo_origen_id])
                ->where('bachiller_grupos.bachiller_materia_id', '=', $grupo_origen->bachiller_materia_id)
                // ->whereNotNull('gpoMatComplementaria')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->orderBy('bachiller_grupos.gpoClave', 'ASC')
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();



            return response()->json([
                'grupoDestino' => $grupoDestino
            ]);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {

            $grupo_origen_id = $request->input("grupo_origen_id");
            $grupo_id_destino = $request->input("grupo_id_destino");
            $usuario_at = auth()->user()->id;



            for ($i = 0; $i < count($grupo_id_destino); $i++) {
                $resultado_array =  DB::select("call procBachillerCopiarHorario(
                    " . $grupo_origen_id . ",
                    " . $grupo_id_destino[$i] . ",
                    " . $usuario_at . ")");
            }



            if (!empty($resultado_array[0]->totalDiasCapturados)) {

                if ($resultado_array[0]->totalDiasCapturados == -1)
                    return response()->json([
                        'res' => false,
                    ]);
            } else {
                return response()->json([
                    'res' => true,
                ]);
            }
        }
    }



    // public function getAlumnosDelGrupo(Request $request, $bachiller_grupo_id)
    // {
    //     if($request->ajax()){

    //         $alumnos = DB::select("SELECT bachiller_inscritos.id,
    //         bachiller_inscritos.curso_id,
    //         bachiller_grupos.gpoGrado,
    //         bachiller_grupos.gpoClave,
    //         alumnos.id as alumno_id,
    //         alumnos.aluClave,
    //         alumnos.aluMatricula,
    //         personas.perApellido1,
    //         personas.perApellido2,
    //         personas.perNombre,
    //         planes.planClave
    //         FROM bachiller_inscritos
    //         INNER JOIN bachiller_grupos ON bachiller_grupos.id = bachiller_inscritos.bachiller_grupo_id
    //         AND bachiller_grupos.deleted_at IS NULL
    //         INNER JOIN cursos ON cursos.id = bachiller_inscritos.curso_id
    //         AND cursos.deleted_at IS NULL
    //         INNER JOIN alumnos ON alumnos.id = cursos.alumno_id
    //         AND alumnos.deleted_at IS NULL
    //         INNER JOIN personas ON personas.id = alumnos.persona_id
    //         AND personas.deleted_at IS NULL
    //         INNER JOIN periodos ON periodos.id = bachiller_grupos.periodo_id
    //         AND periodos.deleted_at IS NULL
    //         INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
    //         AND departamentos.deleted_at IS NULL
    //         INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id
    //         AND ubicacion.deleted_at IS NULL
    //         INNER JOIN planes ON planes.id = bachiller_grupos.plan_id
    //         AND planes.deleted_at IS NULL
    //         INNER JOIN programas ON programas.id = planes.programa_id
    //         AND programas.deleted_at IS NULL
    //         WHERE bachiller_inscritos.deleted_at IS NULL
    //         AND bachiller_grupos.id = $bachiller_grupo_id
    //         ORDER BY personas.perApellido1 ASC, personas.perApellido2 ASC, personas.perNombre ASC");

    //         return response()->json($alumnos);
    //     }
    // }
}

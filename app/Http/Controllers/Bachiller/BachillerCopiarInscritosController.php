<?php

namespace App\Http\Controllers\Bachiller;

use Auth;
use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_grupos;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use Validator;

class BachillerCopiarInscritosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.copiarIncritos.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    // obtenemos el grupo origin a migrar 
    public function ObtenerGrupoOrigen(Request $request, $plan_id, $periodo_id, $gpoGrado)
    {
        if($request->ajax()){
            $grupoOrigen = Bachiller_grupos::select('bachiller_grupos.*', 
            'bachiller_materias.matClave', 
            'bachiller_materias.matNombre',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre')
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->where('bachiller_grupos.plan_id', '=', $plan_id)
            ->where('bachiller_grupos.periodo_id', '=', $periodo_id)
            ->where('bachiller_grupos.gpoGrado', '=', $gpoGrado)
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
                'bachiller_materias.matNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre'
            )
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
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

    

    public function getAlumnosDelGrupo(Request $request, $bachiller_grupo_id)
    {
        if($request->ajax()){
            
            $alumnos = DB::select("SELECT bachiller_inscritos.id,
            bachiller_inscritos.curso_id,
            bachiller_grupos.gpoGrado,
            bachiller_grupos.gpoClave,
            alumnos.id as alumno_id,
            alumnos.aluClave,
            alumnos.aluMatricula,
            personas.perApellido1,
            personas.perApellido2,
            personas.perNombre,
            planes.planClave,
            CONCAT_WS('' ,bachiller_empleados.empApellido1, bachiller_empleados.empApellido2, bachiller_empleados.empNombre) as docente
            FROM bachiller_inscritos
            INNER JOIN bachiller_grupos ON bachiller_grupos.id = bachiller_inscritos.bachiller_grupo_id
            AND bachiller_grupos.deleted_at IS NULL
            INNER JOIN cursos ON cursos.id = bachiller_inscritos.curso_id
            AND cursos.deleted_at IS NULL
            INNER JOIN alumnos ON alumnos.id = cursos.alumno_id
            AND alumnos.deleted_at IS NULL
            INNER JOIN personas ON personas.id = alumnos.persona_id
            AND personas.deleted_at IS NULL
            INNER JOIN periodos ON periodos.id = bachiller_grupos.periodo_id
            AND periodos.deleted_at IS NULL
            INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
            AND departamentos.deleted_at IS NULL
            INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id
            AND ubicacion.deleted_at IS NULL
            INNER JOIN planes ON planes.id = bachiller_grupos.plan_id
            AND planes.deleted_at IS NULL
            INNER JOIN programas ON programas.id = planes.programa_id
            AND programas.deleted_at IS NULL
            LEFT JOIN bachiller_empleados ON bachiller_empleados.id = bachiller_grupos.empleado_id_docente
            AND bachiller_empleados.deleted_at IS NULL
            WHERE bachiller_inscritos.deleted_at IS NULL
            AND bachiller_grupos.id = $bachiller_grupo_id
            ORDER BY personas.perApellido1 ASC, personas.perApellido2 ASC, personas.perNombre ASC");

            return response()->json($alumnos);
        }
    }
  

    public function store(Request $request)
    {
        if ($request->ajax()) {
            
            $ubicacion_id = $request->input("ubicacion_id");
            $programa_id = $request->input("programa_id");
            $plan_id = $request->input("plan_id");
            $periodo_id = $request->input("periodo_id");
            $grupo_origen_id = $request->input("grupo_origen_id");
            $grupo_id_destino = $request->input("grupo_id_destino");
            $inscritoacopiar = $request->input("inscritoacopiar");
            $copiarHorario = $request->input("copiarHorario");
            $usuario_at = auth()->user()->id;



            /* ---------------------- validamos si algun alumno fue --------------------- */
            /* -------------------------------------------------------------------------- */
            /*                seleccionado de lo contrario no se hace nada                */
            /* -------------------------------------------------------------------------- */

           
            if(count($inscritoacopiar) > 0){

                // para actualizar el campo grupo_id de la tabla bachiller_inscritos
                for ($i = 0; $i < count($inscritoacopiar); $i++) {

                    // actualizamos el grupo viejo por el nuevo
                    DB::update("UPDATE bachiller_inscritos SET bachiller_grupo_id=$grupo_id_destino WHERE id=$inscritoacopiar[$i]");

                    // marcamos borrado de evidencias del grupo anterior del alumno en caso de que tenga 
                    DB::update("UPDATE bachiller_inscritos_evidencias
                    JOIN bachiller_inscritos on bachiller_inscritos.id= bachiller_inscritos_evidencias.bachiller_inscrito_id
                    JOIN bachiller_grupos on bachiller_grupos.id= bachiller_inscritos.bachiller_grupo_id
                    SET bachiller_inscritos_evidencias.deleted_at=NOW()
                    WHERE bachiller_grupos.id=$grupo_origen_id
                    AND bachiller_inscritos.id=$inscritoacopiar[$i]
                    AND bachiller_inscritos_evidencias.deleted_at IS NULL");

                    // buscamos el primer registro 
                    $busca_paquete_id = Bachiller_inscritos::select('bachiller_paquete_id')
                    ->where('id', $inscritoacopiar[$i])
                    ->whereNotNull('bachiller_paquete_id')
                    ->whereNull('deleted_at')
                    ->first();

                    if($busca_paquete_id != ""){
                        // buscamos el nuevo registro 
                        $registro_a_actualizar = Bachiller_inscritos::where('id', $inscritoacopiar[$i])
                        ->where('bachiller_grupo_id', $grupo_id_destino)
                        ->whereNull('deleted_at')
                        ->first();

                        if($registro_a_actualizar != ""){
                            $registro_a_actualizar->update([
                                'bachiller_paquete_id' => $busca_paquete_id->bachiller_paquete_id
                            ]);
                        }
                    }
                }


                // Si selecciona el copiado de horario en SI se efectua,
                // dependera que el horario del grupo origen este capturado 
                if($copiarHorario == "SI"){
                    $resultado_array =  DB::select("call procBachillerCopiarHorario(
                        " . $grupo_origen_id . ",
                        " . $grupo_id_destino . ",
                        " . $usuario_at . ")");
                }

                return response()->json([
                    'res' => true,
                    'copiarHorario' => $copiarHorario
                ]);

            }else{
                return response()->json([
                    'res' => false,
                ]);
            }


            


         
                    
        }
    }
 
}

<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Secundaria\Secundaria_grupos;
use App\Http\Models\Ubicacion;
use Illuminate\Support\Facades\DB;

class SecundariaCambioGrupoACDController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $alumno = null;

        return view('secundaria.cambio_grupo_acd.create', [
            "ubicaciones" => $ubicaciones,
            "alumno" => $alumno
        ]);
    }

    public function cargar_grupos_acd_actuales(Request $request, $periodo_id, $programa_id, $plan_id, $aluClave)
    {
        if ($request->ajax()) {

            $grupos_acd_actual = DB::select("SELECT secundaria_inscritos.id, 
            secundaria_grupos.id AS secundaria_grupo_id,
            secundaria_grupos.gpoGrado, 
            secundaria_grupos.gpoClave,
            secundaria_grupos.gpoTurno,
            cursos.id AS curso_id,
            planes.planClave,
            programas.id AS programa_id,
            secundaria_materias.matClave,
            secundaria_materias.matNombre,
            secundaria_grupos.gpoMatComplementaria,
            secundaria_empleados.empApellido1,
            secundaria_empleados.empApellido2,
            secundaria_empleados.empNombre,
            alumnos.aluClave,
            personas.perApellido1,
            personas.perApellido2,
            personas.perNombre
            FROM secundaria_inscritos AS secundaria_inscritos
            INNER JOIN secundaria_grupos AS secundaria_grupos ON secundaria_grupos.id = secundaria_inscritos.grupo_id
            INNER JOIN cursos AS cursos ON cursos.id = secundaria_inscritos.curso_id
            INNER JOIN alumnos AS alumnos ON alumnos.id = cursos.alumno_id
            INNER JOIN periodos AS periodos ON periodos.id = secundaria_grupos.periodo_id
            INNER JOIN planes AS planes ON planes.id = secundaria_grupos.plan_id
            INNER JOIN programas AS programas ON programas.id = planes.programa_id
            INNER JOIN secundaria_materias AS secundaria_materias ON secundaria_materias.id = secundaria_grupos.secundaria_materia_id
            INNER JOIN secundaria_empleados AS secundaria_empleados ON secundaria_empleados.id = secundaria_grupos.empleado_id_docente
            INNER JOIN personas AS personas ON personas.id = alumnos.persona_id
            WHERE secundaria_grupos.gpoACD = 1
            AND periodos.id = $periodo_id
            AND programas.id = $programa_id
            AND secundaria_grupos.plan_id = $plan_id
            AND alumnos.aluClave=$aluClave");

            if(count($grupos_acd_actual) > 0){
                $grado = $grupos_acd_actual[0]->gpoGrado;

                $grupos_acd_destino = DB::select("SELECT secundaria_grupos.id AS secundaria_grupo_id,
                secundaria_grupos.gpoGrado, 
                secundaria_grupos.gpoClave,
                planes.planClave,
                programas.id AS programa_id,
                secundaria_materias.matClave,
                secundaria_materias.matNombre,
                secundaria_grupos.gpoMatComplementaria,
                secundaria_empleados.empApellido1,
                secundaria_empleados.empApellido2,
                secundaria_empleados.empNombre
                FROM secundaria_grupos AS secundaria_grupos
                INNER JOIN periodos AS periodos ON periodos.id = secundaria_grupos.periodo_id
                INNER JOIN planes AS planes ON planes.id = secundaria_grupos.plan_id
                INNER JOIN programas AS programas ON programas.id = planes.programa_id
                INNER JOIN secundaria_materias AS secundaria_materias ON secundaria_materias.id = secundaria_grupos.secundaria_materia_id
                INNER JOIN secundaria_empleados AS secundaria_empleados ON secundaria_empleados.id = secundaria_grupos.empleado_id_docente
                WHERE secundaria_grupos.gpoACD = 1
                AND periodos.id = $periodo_id
                AND programas.id = $programa_id
                AND secundaria_grupos.plan_id = $plan_id
                AND secundaria_grupos.gpoGrado = $grado");
            }else{
                $grupos_acd_destino = "";
            }

            

            return response()->json([
                'datos' => $grupos_acd_actual,
                'grupo_destino' => $grupos_acd_destino
            ]);
        }
    }

  
    public function cambiar_grupo_acd(Request $request)
    {
        if ($request->ajax()) {

            // variables 
            $curso_id = $request->input("curso_id");
            $grupo_id_origen = $request->input('grupo_id_origen');
            $grupo_id_destino = $request->input('grupo_id_destino');

            $grupo_origen = Secundaria_grupos::where('id', $grupo_id_origen)->first();
            $grupo_destino = Secundaria_grupos::where('id', $grupo_id_destino)->first();

            // validamos si la materia y la materia ACD son las mismas para poder realizar el cambio 
            if($grupo_origen->secundaria_materia_id === $grupo_destino->secundaria_materia_id){

                // Validamos si el grupo origin y destino son diferentes al destino
                if($grupo_origen->id !== $grupo_destino->id){

                     $resultado =  DB::select("call procSecundariaAlumnoCambioACD("
                        .$curso_id.", "
                        .$grupo_id_origen.", "
                        .$grupo_id_destino.")");

                    return response()->json([
                        'resultado' => "true"
                    ]);
                }else{
                    return response()->json([
                        'resultado' => "mismo_grupo"
                    ]);
                }
                
            }else{
                return response()->json([
                    'resultado' => "no_es_igual"
                ]);
            }
                
            
        }
    }
}

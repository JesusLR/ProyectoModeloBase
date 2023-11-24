<?php

namespace App\Http\Controllers\Bachiller;

use Auth;
use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use Validator;

class BachillerMigrarInscritosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.migrarIncritosACD.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    // obtenemos el grupo origin a migrar 
    public function ObtenerGrupoOrigen(Request $request, $plan_id, $periodo_id, $gpoGrado)
    {
        if($request->ajax()){
            $grupoOrigen = Bachiller_grupos::select('bachiller_grupos.*', 
            'bachiller_materias.matClave', 
            'bachiller_materias.matNombre')
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('bachiller_grupos.plan_id', '=', $plan_id)
            ->where('bachiller_grupos.periodo_id', '=', $periodo_id)
            ->where('bachiller_grupos.gpoGrado', '=', $gpoGrado)
            // ->whereNotNull('gpoMatComplementaria')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_materias.deleted_at')
            ->get();


            $periodo_origen = Periodo::select('periodos.*', 'ubicacion.id as ubicacion_id', 'departamentos.id as departamento_id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('periodos.id', $periodo_id)
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->first();
            
            $sumanoselanio = $periodo_origen->perAnioPago+1;

            $periodo_destino = Periodo::select('periodos.*')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('ubicacion.id', $periodo_origen->ubicacion_id)
            ->where('departamentos.id', $periodo_origen->departamento_id)
            ->where('periodos.perAnio', '=', $sumanoselanio)
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->orderBy('periodos.id', 'DESC')
            ->get();


            // $sumarGrado = $gpoGrado+1;

            // if(count($periodo_destino) > 0){
            //     $grupoDestino = Bachiller_grupos::select('bachiller_grupos.*',
            //     'bachiller_materias.matClave',
            //     'bachiller_materias.matNombre')
            //     ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            //     ->where('bachiller_grupos.plan_id', '=', $plan_id)
            //     ->where('bachiller_grupos.periodo_id', '=', $periodo_destino[0]->id)
            //     ->where('bachiller_grupos.gpoGrado', '=', $sumarGrado)
            //     // ->whereNotNull('gpoMatComplementaria')
            //     ->whereNull('bachiller_grupos.deleted_at')
            //     ->whereNull('bachiller_materias.deleted_at')
            //     ->get();
            // }else{
            //     $grupoDestino = "false";
            // }
            


            return response()->json([
                'grupoOrigen' => $grupoOrigen,
                'periodo_destino' => $periodo_destino,
                // 'grupoDestino' => $grupoDestino
            ]);
        }
    }

    public function getGrupoDestino(Request $request, $plan_id, $periodo_id, $gradoDestino)
    {
        if ($request->ajax()) {

            $grupoDestino = Bachiller_grupos::select(
                'bachiller_grupos.*',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre'
            )
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('bachiller_grupos.plan_id', '=', $plan_id)
                ->where('bachiller_grupos.periodo_id', '=', $periodo_id)
                ->where('bachiller_grupos.gpoGrado', '=', $gradoDestino)
                // ->whereNotNull('gpoMatComplementaria')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->get();



                return response()->json([
                    'grupoDestino' => $grupoDestino
                ]);
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
            $periodo_id_destino = $request->input("periodo_id_destino");
            $gpoGrado_destino = $request->input("gpoGrado_destino");
            $grupo_id_destino = $request->input("grupo_id_destino");
            $alumno_id = $request->input("alumno_id");

            if(count($alumno_id) > 0){
                for($i = 0; $i < count($alumno_id); $i++){
                    $resultado_array =  DB::select("call procBachillerInscribirAlSiguienteSemestre(
                        " . $alumno_id[$i] . ",
                        " . $periodo_id_destino . ",
                        " . $grupo_id_destino . ")");


                        // en este proceso se ejecuta en caso de que el inscribo se registre al grupo 
                        if(!empty($resultado_array[0]->_curso_id)){
                            $curso_id = $resultado_array[0]->_curso_id;

                            // buscamos el primer registro 
                            $busca_paquete_id = Bachiller_inscritos::select('bachiller_paquete_id')
                            ->where('curso_id', $curso_id)->whereNotNull('bachiller_paquete_id')
                            ->whereNull('deleted_at')
                            ->first();

                            if($busca_paquete_id != ""){
                                // buscamos el nuevo registro 
                                $registro_a_actualizar = Bachiller_inscritos::where('curso_id', $curso_id)->where('bachiller_grupo_id', $grupo_id_destino)
                                ->whereNull('deleted_at')
                                ->first();

                                if($registro_a_actualizar != ""){
                                    $registro_a_actualizar->update([
                                        'bachiller_paquete_id' => $busca_paquete_id->bachiller_paquete_id
                                    ]);
                                }
                            }

                            
                           

                        }

                    
                }

                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false                    
                ]);
            }
            

            

                

         
                    
        }
    }
 
}

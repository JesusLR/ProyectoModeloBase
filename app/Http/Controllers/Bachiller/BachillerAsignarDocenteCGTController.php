<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Cgt;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;

class BachillerAsignarDocenteCGTController extends Controller
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        $empleados = Bachiller_empleados::select('bachiller_empleados.*')
        ->where('empEstado', '!=', 'B')
        ->get();

        return view('bachiller.asignarDocenteCGT.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
        ]);
    }

    public function obtenerGrupos(Request $request, $ubicacion_id, $periodo_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::where('id', '=', $cgt_id)->first();

            if($ubicacion_id == "1" || $ubicacion_id == "2"){
                // llama al procedure de los grupos a buscar
                $resultado_array =  DB::select("call procBachillerGruposMateriasPorPeriodoYucatan(".$plan_id.", ".$periodo_id.", ".$cgt->cgtGradoSemestre.", '".$cgt->cgtGrupo."')");
            }else{
                // llama al procedure de los grupos a buscar
                $resultado_array =  DB::select("call procBachillerGruposMateriasPorPeriodoChetumal(".$plan_id.", ".$periodo_id.", ".$cgt->cgtGradoSemestre.", '".$cgt->cgtGrupo."')");
            }
           

            $grupos = collect($resultado_array);


            return response()->json($grupos);
            
        }
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validar si hay envio de datos 
        if ($request->ajax()) {

            // variables 
            $bachiller_grupo_id = $request->input("bachiller_grupo_id");
            $empleado_id = $request->input('empleado_id');
            $ubicacion_id = $request->input('ubicacion_id');



            // si el input es diferente de vacio entra 
            if ($bachiller_grupo_id != "") {

                // si el input es diferente de vacio entra 
                if ($empleado_id != "") {

                    $total_id_grupos = count($bachiller_grupo_id);

                    // ciclo para actualizar los id de empleado en la tabla grupos 
                    for ($x = 0; $x < $total_id_grupos; $x++) {
                        for ($i = 0; $i < count($bachiller_grupo_id); $i++) {

                            // validamos si la ubicacion es merida o valladolid 
                            if($ubicacion_id == "1" || $ubicacion_id == "2"){
                                $grupo = DB::statement('call procSecundariaActualizaGruposEmpleadoYucatan(?, ?)', [$bachiller_grupo_id[$i], $empleado_id]);
                            }else{
                                $grupo = DB::statement('call procSecundariaActualizaGruposEmpleadoChetumal(?, ?)', [$bachiller_grupo_id[$i], $empleado_id]);
                            }
                            
                        }
                        return response()->json([
                            'res' => $empleado_id,
                            'grupo' => $grupo
                        ]);
                    }
                } else {
                    // en caso que no hay empleado seleccionado lo siguiente 
                    return response()->json([
                        'res' => 'sinEmpleado',
                    ]);
                }
            } else {
                // en caso que no hay id de grupos, es decir no hay ningun check activo retorna lo siguiente 
                return response()->json([
                    'res' => 'error',
                ]);
            }
        }
    }

    

}

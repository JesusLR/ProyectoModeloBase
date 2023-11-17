<?php

namespace App\Http\Controllers\Secundaria;

use Auth;
use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Secundaria\Secundaria_grupos;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use Validator;

class SecundariaMigrarInscritosACDController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.migrarIncritosACD.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    // obtenemos el grupo origin a migrar 
    public function ObtenerGrupoOrigen(Request $request, $plan_id, $periodo_id, $gpoGrado)
    {
        if($request->ajax()){
            $grupoOrigen = Secundaria_grupos::select('secundaria_grupos.*')
            ->where('plan_id', '=', $plan_id)
            ->where('periodo_id', '=', $periodo_id)
            ->where('gpoGrado', '=', $gpoGrado)
            ->whereNotNull('gpoMatComplementaria')
            ->whereNull('deleted_at')
            ->get();


            $periodo_origen = Periodo::select('periodos.*', 'ubicacion.id as ubicacion_id', 'departamentos.id as departamento_id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('periodos.id', $periodo_id)
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->first();
            
            $sumanoselanio = $periodo_origen->perAnio+1;

            $periodo_destino = Periodo::select('periodos.*')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('ubicacion.id', $periodo_origen->ubicacion_id)
            ->where('departamentos.id', $periodo_origen->departamento_id)
            ->where('periodos.perAnio', '=', $sumanoselanio)
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->get();


            $sumarGrado = $gpoGrado+1;

            if(count($periodo_destino) > 0){
                $grupoDestino = Secundaria_grupos::select('secundaria_grupos.*')
                ->where('plan_id', '=', $plan_id)
                ->where('periodo_id', '=', $periodo_destino[0]->id)
                ->where('gpoGrado', '=', $sumarGrado)
                ->whereNotNull('gpoMatComplementaria')
                ->whereNull('deleted_at')
                ->get();
            }else{
                $grupoDestino = "false";
            }
            


            return response()->json([
                'grupoOrigen' => $grupoOrigen,
                'periodo_destino' => $periodo_destino,
                'grupoDestino' => $grupoDestino
            ]);
        }
    }

   

    public function getDepartamentosPorUbiClave(Request $request, $id)
    {
        if($request->ajax()){
               


            if (Auth::user()->secundaria == 1) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicosMigrarACD($id, ['SEC']);
            }

            return response()->json($departamentos);
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


            $resultado_array =  DB::select("call procSecundariaMigrarInscritosACD(
                " . $ubicacion_id . ",
                " . $programa_id . ",
                " . $plan_id . ",
                " . $periodo_id . ",
                " . $grupo_origen_id . ",
                " . $periodo_id_destino . ",
                " . $gpoGrado_destino . ",
                " . $grupo_id_destino . ")");

                return response()->json([
                    'res' => 'true',
                ]);

         
                    
        }
    }
 
}

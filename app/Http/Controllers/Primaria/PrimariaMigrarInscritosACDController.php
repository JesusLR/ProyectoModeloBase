<?php

namespace App\Http\Controllers\Primaria;

use Auth;
use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Validator;

class PrimariaMigrarInscritosACDController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();

        return view('primaria.migrarIncritosACD.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }



    public function getDepartamentosPorUbiClave(Request $request, $id)
    {
        if($request->ajax()){
               


            if (Auth::user()->primaria == 1) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicosMigrarACD($id, ['PRI']);
            }

            return response()->json($departamentos);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            
            $periodo_id = $request->input("periodo_id");
            $gpoGrado = $request->input('gpoGrado');
            $ubicacion_id = $request->input('ubicacion_id');


            if($gpoGrado != ""){

                $resultado_array =  DB::select("call procPrimariaAlumnoCopiarACD(" . $periodo_id . ",
                " . $gpoGrado . ",
                '" . $ubicacion_id . "')");

                return response()->json([
                    'res' => 'true',
                ]);
            }else{
                return response()->json([
                    'res' => 'error',
                ]);
            }
           
                    
        }
    }
 
}

<?php

namespace App\Http\Controllers\Secundaria;

use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Programa;
use Illuminate\Support\Facades\Auth;

class SecundariaFuncionesGenericasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDepartamentos(Request $request, $id)
    {
        if($request->ajax()){
            // $departamentos = Departamento::with('ubicacion')->where('ubicacion_id','=',$id)
            // ->whereIn('depClave', ['SUP', 'POS'])->get();

            $depClaveUsuario = Auth::user()->empleado->escuela->departamento->depClave;
            $depMAT = 'XXX';
            $depPRE = 'XXX';
            $depPRI = 'XXX';
            $depSEC = 'XXX';
            $depBAC = 'XXX';
            $depSUP = 'XXX';
            $depPOS = 'XXX';
            $depDIP = 'XXX';

            if (   (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
                || (Auth::user()->educontinua == 1) )
            {
                $depSUP = 'SUP';
                $depPOS = 'POS';
                $depDIP = 'DIP';
            }

            if (Auth::user()->bachiller == 1)
            {
                $depBAC = 'BAC';
            }

            if (Auth::user()->secundaria == 1)
            {
                $depSEC = 'SEC';
            }

            if (Auth::user()->primaria == 1)
            {
                $depPRI = 'PRI';
            }

            if ( (Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1) )
            {
                $depMAT = 'MAT';
                $depPRE = 'PRE';
            }

            $departamentos = null;

            $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id,
                [$depSEC]);

            /*
            switch ($depClaveUsuario)
            {
                case "MAT":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['MAT','PRE']);
                    break;
                case "PRE":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['PRE', 'MAT']);
                    break;
                case "PRI":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['PRI']);
                    break;
                case "SEC":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['SEC']);
                    break;
                case "BAC":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['BAC']);
                    break;
                case "SUP":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['SUP', 'POS', 'DIP']);
                    break;
                case "POS":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['POS', 'SUP', 'DIP']);
                    break;
                default:
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['DIP', 'POS', 'SUP']);
                    break;
            }
            */

            return response()->json($departamentos);
        }
    }


    public function getPlanesEspecificos(Request $request, $id)
    {
        if($request->ajax()){

            $programa = Programa::select('ubicacion.ubiClave')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('programas.id', $id)
            ->first();

            if($programa->ubiClave = "CME"){
                $planes = Plan::where('id', 86)->get();
            }else{
                if($programa->ubiClave = "CVA"){
                    $planes = Plan::where('id', 90)->get();
                }
            }

            
            // $planes = Plan::where('programa_id',$id)->orderBy('id', 'desc')->get();
            return response()->json($planes);
        }
    }
}

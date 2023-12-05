<?php

namespace App\Http\Controllers\Idiomas;

use App\clases\departamentos\MetodosDepartamentos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use App\Models\Departamento;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use URL;
use Validator;
use Debugbar;

use App\Models\Escuela;
use App\Models\Plan;
use App\Models\Programa;
use Illuminate\Support\Facades\Auth;

class IdiomasFuncionesGenericasController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getEscuelasIdi(Request $request)
    {

        if($request->ajax()){
            $escuelas = Escuela::where('departamento_id','=',$request->id)->where('escClave', 'ADI')
            ->get();

            return response()->json($escuelas);
        }
    }


    public function getDepartamentos(Request $request, $id)
    {
        if($request->ajax()){
            if (Auth::user()->idiomas == 1)
            {
                $depIDI = 'IDI';
            }

            $departamentos = Departamento::where('ubicacion_id', $id)->where('depClave', $depIDI)->get();
         

            return response()->json($departamentos);
        }
    }


    public function getPlanesEspesificos(Request $request, $id)
    {
        if($request->ajax()){
            
            $programa = Programa::select('ubicacion.ubiClave')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('programas.id', $id)->first();

            if($programa->ubiClave == "CME"){
                $planes = Plan::select('planes.*')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->where('planes.programa_id',$id)               
                // ->where('planes.planClave', '2016')
                ->where(function ($query) {
                $query->where('programas.progClave', 'IDI')
                    ->orWhere('programas.progClave', 'ING')
                    ->orWhere('programas.progClave', 'INI');
                })
                ->get();
            }

            if($programa->ubiClave == "CVA"){
                $planes = Plan::select('planes.*')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->where('planes.programa_id',$id)
                ->where(function ($query) {
                $query->where('programas.progClave', 'IDI')
                    ->orWhere('programas.progClave', 'ING')
                    ->orWhere('programas.progClave', 'INI');
                })
                ->orderBy('planes.planClave', 'desc')
                ->get();
            }

            if($programa->ubiClave == "CCH"){
                $planes = Plan::select(('planes.*'))
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->where('programa_id',$id)
                ->where(function ($query) {
                $query->where('programas.progClave', 'IDI')
                    ->orWhere('programas.progClave', 'ING')
                    ->orWhere('programas.progClave', 'INI');
                })
                ->orderBy('planClave', 'desc')
                ->get();
            }           

            
            return response()->json($planes);
        }
    }


     /**
    * Muestra la lista completa de departamentos por ubicacion_id.
    */
   public function getDepartamentosListaCompleta(Request $request, $ubicacion_id)
   {
       $departamentos = Departamento::where('ubicacion_id', $ubicacion_id)->get();

       if($request->ajax())
           return response()->json($departamentos);
   }

    public function getPlanesTodos(Request $request, $id)
    {
        if ($request->ajax()) {
            $planes = Plan::where('programa_id', $id)->orderBy('planClave', 'desc')->get();
            return response()->json($planes);
        }
    }
}

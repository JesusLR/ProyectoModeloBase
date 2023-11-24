<?php

namespace App\Http\Controllers\Primaria;

use App\clases\departamentos\MetodosDepartamentos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use App\Models\Cgt;
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

class PrimariaFuncionesGeneralesController extends Controller
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


    public function getEscuelasBac(Request $request)
    {

        if ($request->ajax()) {
            $escuelas = Escuela::where('departamento_id', '=', $request->id)->where('escClave', 'BAC')
                ->get();

            return response()->json($escuelas);
        }
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
                [$depPRI]);

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

    public function getPlanesEspesificos(Request $request, $id)
    {
        if ($request->ajax()) {

            $programa = Programa::select('ubicacion.ubiClave')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->where('programas.id', $id)->first();

            if ($programa->ubiClave == "CME") {
                $planes = Plan::select('planes.*')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('planes.programa_id', $id)
                    ->where('planes.id', 94)
                    ->where('programas.progClave', 'BAC')
                    ->get();
            }

            if ($programa->ubiClave == "CVA") {
                $planes = Plan::select('planes.*')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('planes.programa_id', $id)
                    ->where('planes.id', 103)
                    ->where('programas.progClave', 'BAC')
                    ->get();
            }

            if ($programa->ubiClave == "CCH") {
                $planes = Plan::select(('planes.*'))
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('programa_id', $id)
                    ->where('planes.id', 107)
                    ->where('programas.progClave', 'BAC')
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

        if ($request->ajax())
            return response()->json($departamentos);
    }

    public function getPlanesTodos(Request $request, $id)
    {
        if ($request->ajax()) {

            $planes = Plan::where('programa_id', $id)->orderBy('planClave', 'desc')->get();

            return response()->json($planes);
        }
    }

    public function obtenerNumerosGrado(Request $request, $periodo_id)
    {
        if ($request->ajax()) {
            $numeroSemestre = Cgt::select('cgtGradoSemestre AS grado')->where('periodo_id', $periodo_id)
            ->orderBy('cgtGradoSemestre')
            ->distinct()
            ->get();

            // $numeroSemestre = Cgt::where()
            return response()->json($numeroSemestre);
        }
    }

    public function obtenerLetrasSemestre(Request $request, $periodo_id)
    {
        if ($request->ajax()) {
            $letraSemestre = Cgt::select('cgtGrupo')->where('periodo_id', $periodo_id)
            ->orderBy('cgtGrupo')
            ->distinct()
            ->get();

            return response()->json($letraSemestre);
        }
    }
}

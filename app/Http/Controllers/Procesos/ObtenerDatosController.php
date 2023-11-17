<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use App\Http\Models\Cgt;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Firmante;
use App\Http\Models\Materia;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Helpers\Utils;

use Carbon\Carbon;

class ObtenerDatosController extends Controller
{
    public function obtenerFirmantes($ubicacion_id){
        $firmante = Firmante::where('ubicacion_id',$ubicacion_id)->get();
        return response()->json($firmante);
    }

    public function obtenerDepartamento(Request $request,$ubiClave){
        if($request->ajax()){
        $ubicacion = Ubicacion::where('ubiClave',$ubiClave)->first();
        $departamentos = Departamento::where('ubicacion_id',$ubicacion->id)->orderBy('depClave')->get();
        return response()->json([
            'departamentos'=>$departamentos
        ]);
        }
      }

    public function obtenerEscuelas(Request $request,$ubiClave, $depClave){
      if($request->ajax()){
        $ubicacion = Ubicacion::where('ubiClave',$ubiClave)->first();
        $departamento = Departamento::where('ubicacion_id',$ubicacion->id)->where('depClave',$depClave)->first();
        $escuelas = Escuela::where('departamento_id',$departamento->id)->orderBy('escClave')->get();
        return response()->json($escuelas);
      }
    }

    public function obtenerProgramas(Request $request,$ubiClave,$depClave,$escClave){
      if($request->ajax()){
        $ubicacion = Ubicacion::where('ubiClave',$ubiClave)->first();
        $departamento = Departamento::where('ubicacion_id',$ubicacion->id)->where('depClave',$depClave)->first();
        $escuela = Escuela::where('departamento_id',$departamento->id)->where('escClave',$escClave)->first();
        $programas = Programa::where('escuela_id',$escuela->id)->orderBy('progClave')->get();
        return response()->json($programas);
      }
    }

    public function obtenerPlanes(Request $request,$ubiClave,$depClave,$escClave,$progClave){
      if($request->ajax()){
        $ubicacion = Ubicacion::where('ubiClave',$ubiClave)->first();
        $departamento = Departamento::where('ubicacion_id',$ubicacion->id)->where('depClave',$depClave)->first();
        $escuela = Escuela::where('departamento_id',$departamento->id)->where('escClave',$escClave)->first();
        $programa = Programa::where('escuela_id',$escuela->id)->where('progClave',$progClave)->first();
        $planes = Plan::where('programa_id',$programa->id)->orderByDesc('planClave')->get();
        return response()->json($planes);
      }
    }

    public function obtenerMaterias(Request $request,$ubiClave,$depClave,$escClave,$progClave,$planClave){
      if($request->ajax()){
        $ubicacion = Ubicacion::where('ubiClave',$ubiClave)->first();
        $departamento = Departamento::where('ubicacion_id',$ubicacion->id)->where('depClave',$depClave)->first();
        $escuela = Escuela::where('departamento_id',$departamento->id)->where('escClave',$escClave)->first();
        $programa = Programa::where('escuela_id',$escuela->id)->where('progClave',$progClave)->first();
        $plan = Plan::where('programa_id',$programa->id)->where('planClave',$planClave)->first();
        $materias = Materia::where('plan_id',$plan->id)->orderBy('matClave')->get();
        return response()->json($materias);
      }
    }

    public function obtenerPeriodos(Request $request, $depClave){
      if($request->ajax()){
        $departamento = Departamento::where('depClave',$depClave)->first();
        $periodos = Periodo::where('departamento_id',$departamento->id)->orderByDesc('id')->get();
        return response()->json($periodos);
      }
    }

    public function obtenerFechas(Request $request, $periodo_id){
      if($request->ajax()){
        $periodo = Periodo::findOrFail($periodo_id);
        $fechaInicial = Utils::fecha_string($periodo->perFechaInicial);
        $fechaFinal = Utils::fecha_string($periodo->perFechaFinal);
        return response()->json([
          'fechaInicial'=>$fechaInicial,
          'fechaFinal'=>$fechaFinal
        ]);
      }
      }

      public function obtenerDepartamentoId(Request $request,$ubicacion_id){
        if($request->ajax()){
        $departamentos = Departamento::where('ubicacion_id',$ubicacion_id)->whereIn('depClave',['SUP','POS'])->orderByDesc('depClave')->get();
        return response()->json($departamentos);
        }
      }

    public function obtenerEscuelasId(Request $request,$departamento_id){
      if($request->ajax()){
        $escuelas = Escuela::where('departamento_id',$departamento_id)
            ->where(function($query) {
                $query->where("escNombre", "like", "ESCUELA%");
                $query->orWhere('escNombre', "like", "POSGRADOS%");
                $query->orWhere('escNombre', "like", "MAESTRIAS%");
                $query->orWhere('escNombre', "like", "ESPECIALIDADES%");
                $query->orWhere('escNombre', "like", "DOCTORADOS%");
            })->orderBy('escClave')->get();
        return response()->json($escuelas);
      }
    }

    public function obtenerProgramasId(Request $request,$escuela_id){
      if($request->ajax()){
        $programas = Programa::where('escuela_id',$escuela_id)->orderBy('progClave')->get();
        return response()->json($programas);
      }
    }

    public function obtenerPlanesId(Request $request,$programa_id){
      if($request->ajax()){
        $planes = Plan::where('programa_id',$programa_id)->orderByDesc('planClave')->get();
        return response()->json($planes);
      }
    }

    public function obtenerMateriasId(Request $request,$plan_id){
      if($request->ajax()){
        $materias = Materia::where('plan_id',$plan_id)->orderBy('matClave')->get();
        return response()->json($materias);
      }
    }

    public function obtenerCgtsId(Request $request,$plan_id,$periodo_id){
      if($request->ajax()){
        $cgts = Cgt::where('plan_id',$plan_id)->where('periodo_id',$periodo_id)->get();
        return response()->json($cgts);
      }
    }

    public function obtenerPeriodosId(Request $request, $departamento_id){
      if($request->ajax()){
        $periodos = Periodo::where('departamento_id',$departamento_id)->orderByDesc('id')->get();
        return response()->json($periodos);
      }
    }
}

<?php

namespace App\Http\Controllers\Archivos;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use App\Models\ControlEstados;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControlEstadosController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
      // $this->middleware('permisos:a_extraordinario');

      set_time_limit(8000000);

  }
  


  public function index(Request $request)
  {
    $ubicaciones = Ubicacion::all();

  
    $periodo = ControlEstados::with("periodo.departamento.ubicacion")->first();

    $primeraFecha = DB::table("control_estados")->where("tipoEstado", "1")->first();
    $segundaFecha = DB::table("control_estados")->where("tipoEstado", "2")->first();
    $terceraFecha = DB::table("control_estados")->where("tipoEstado", "3")->first();
    $cuartaFecha  = DB::table("control_estados")->where("tipoEstado", "4")->first();

    // dd($primeraFecha,$segundaFecha, $terceraFecha, $cuartaFecha);

    return view("archivo.controlestados.create", [
      "ubicaciones"  => $ubicaciones,
      "periodo"      => $periodo,
      "primeraFecha" => $primeraFecha->activo,
      "segundaFecha" => $segundaFecha->activo,
      "terceraFecha" => $terceraFecha->activo,
      "cuartaFecha"  => $cuartaFecha->activo,
    ]);
  }

  public function updateControlEstados(Request $request)
  {


    $validator = Validator::make($request->all(), [
        'periodo_id'      => 'required',
    ], [
      'periodo_id.required' => 'El período es obligatorio',
    ]
  );

  if ($validator->fails()) {
    return redirect()->back()->withInput()->withErrors($validator);
  }


    // $res = DB::table("control_estados")->where("tipoEstado", "=", 1)->create([
    //   "activo" =>$request->primeraFecha ? 1: 0,
    //   "periodo_id" => $request->periodo_id
    // ]);

    // $res = DB::table("control_estados")->where("tipoEstado", "=", 2)->update([
    //   "activo" =>$request->segundaFecha ? 1: 0,
    //   "periodo_id" => $request->periodo_id
    // ]);

    // $res = DB::table("control_estados")->where("tipoEstado", "=", 3)->update([
    //   "activo" =>$request->terceraFecha ? 1: 0,
    //   "periodo_id" => $request->periodo_id
    // ]);

    // $res = DB::table("control_estados")->where("tipoEstado", "=", 4)->update([
    //   "activo" =>$request->cuartaFecha ? 1: 0,
    //   "periodo_id" => $request->periodo_id
    // ]);
      

    return redirect()->back()->withInput();
  }

}
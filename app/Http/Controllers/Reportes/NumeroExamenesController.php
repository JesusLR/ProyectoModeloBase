<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Periodo;
use App\Http\Models\Cgt;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Escuela;
use App\Http\Models\Departamento;
use App\Http\Models\Ubicacion;
use App\Http\Models\Cuota;
use Auth;

use Carbon\Carbon;

use PDF;
use DB;

class NumeroExamenesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    //obtener año actual para el filtro que genera el reporte del año de periodo
    $anioActual = Carbon::now();
    return View('reportes/numero_examenes.create',compact('anioActual'));
  }


  public function imprimir(Request $request)
    {

        $resultOrdinarios = DB::select('call procNumeroExamenesOrdinarios('.$request->perNumero.','.$request->perAnio.')');

        $resultExtraordinarios = DB::select('call procNumeroExamenesExtraordinarios('.$request->perNumero.','.$request->perAnio.')');

        $resultInscritos = DB::select('call procNumeroExamenesInscritos('.$request->perNumero.','.$request->perAnio.')');
        
        return response()->json([
          "ordinarios"=>$resultOrdinarios,
          "extraordinarios"=>$resultExtraordinarios,
          "inscritos"=>$resultInscritos
        ]);

    }
}

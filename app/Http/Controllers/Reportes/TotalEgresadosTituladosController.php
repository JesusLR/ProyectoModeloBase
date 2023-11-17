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

class TotalEgresadosTituladosController extends Controller
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
    return View('reportes/total_egresados_titulados.create',compact('anioActual'));
  }


  public function imprimir(Request $request)
    {

        // $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);
        
            $resultEgresados =  DB::select("call procTotalEgresados("
                .$request->perAnio
                .",'".$request->escClave
                ."','".$request->progClave."')");

            $resultTitulados =  DB::select("call procTotalTitulados("
                .$request->perAnio
                .",'".$request->escClave
                ."','".$request->progClave."')");

            // $total_egresados_tit_array = DB::select('select * from'.$temporary_table_name);
            // $total_egresados_tit_collection = collect( $total_egresados_tit_array );

            //dd($pagos_deudores_collection);

            // DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );
        return response()->json([
          "egresados"=>$resultEgresados,
          "titulados"=>$resultTitulados
        ]);

    }
}

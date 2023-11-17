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
use RealRashid\SweetAlert\Facades\Alert;

class RelDeudoresLagunasController extends Controller
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

    $aluEstado = [
        'R' => 'REGULARES',
        'P' => 'PREINSCRITOS',
        'C' => 'CONDICIONADO',
        'A' => 'CONDICIONADO 2',
        'B' => 'BAJA',
        'T' => 'TODOS',
    ];

      return View('reportes/relacion_deudores_lagunas.create', [
        "aluEstado" => $aluEstado,
        "anioActual"=>$anioActual
      ]);
  }


  public function imprimir(Request $request)
    {

        $userId = Auth::id();

        $tipoReporte = $request->tipoReporte;
        $parametro_NombreArchivo = "";
        $parametro_Titulo = "";
        $parametro_Mes = "";
        $parametro_Ubicacion = "";
        $parametro_Periodo = "";
        $parametro_Programa = "";

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // Output: 54esmdr0qf
        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);

        if($tipoReporte == "campus")
        {
            $parametro_NombreArchivo = 'pdf_relacion_deudores_lagunas';
            $parametro_Titulo = "RELACIÓN DE DEUDORES DE COLEGIATURAS (CON LAGUNAS)";
            $result =  DB::select("call procColeAlumnosProgramaLaguna("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','".$request->depClave
                ."','".$request->progClave
                ."','".$request->tipoResumen
                ."','".$temporary_table_name."')");

            $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
            $pagos_deudores_collection = collect( $pagos_deudores_array );

            //dd($pagos_deudores_collection);

            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion." - Nivel: ".$request->depClave;
            $parametro_Programa = "Programa (Carrera): ".$result[0]->_return_progNombre;
            DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

        }elseif($tipoReporte == "carrera")
        {
            $parametro_NombreArchivo = 'pdf_relacion_deudores_lagunas';
            $parametro_Titulo = "RELACIÓN DE DEUDORES DE COLEGIATURAS (CON LAGUNAS)";
            $result =  DB::select("call procColeAlumnosProgramaLaguna("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','".$request->depClave
                ."','".$request->progClave
                ."','".$request->tipoResumen
                ."','".$temporary_table_name."')");

            $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
            $pagos_deudores_collection = collect( $pagos_deudores_array );

            //dd($pagos_deudores_collection);

            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion." - Nivel: ".$request->depClave;
            $parametro_Programa = "Programa (Carrera): ".$result[0]->_return_progNombre;
            DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );
        }


        if($pagos_deudores_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.')->showConfirmButton();
            return back()->withInput();
        }

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaActual = Carbon::now("CDT");
        $horaActual = $fechaActual->format("H:i:s");

        $pdf = PDF::loadView('reportes.pdf.'. $parametro_NombreArchivo, [
            "pagos" => $pagos_deudores_collection,
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $horaActual,
            "nombreArchivo" => $parametro_NombreArchivo,
            "elTitulo" => $parametro_Titulo,
            "elMes" => $parametro_Mes,
            "laUbicacion" => $parametro_Ubicacion,
            "ubiClave" => $request->ubiClave,
            "depClave" =>$request->depClave,
            "elPeriodo" => $parametro_Periodo,
            "elPrograma" => $parametro_Programa,
        ]);

        if($tipoReporte == "campus")
        {
            $pdf->setPaper('letter', 'landscape');
        }
        else
        {
            $pdf->setPaper('letter', 'landscape');
        }


        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo.'.pdf');
        return $pdf->download($parametro_NombreArchivo.'.pdf');


    }

}

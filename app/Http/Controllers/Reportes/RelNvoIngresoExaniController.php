<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Periodo;
use App\Models\Cgt;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Escuela;
use App\Models\Departamento;
use App\Models\Ubicacion;
use App\Models\Cuota;
use Auth;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

use PDF;
use DB;

class RelNvoIngresoExaniController extends Controller
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

    $escuelas = Escuela::with('departamento.ubicacion')
    ->whereHas('departamento.ubicacion', static function($query) {
      $query->where('depClave', 'SUP')
            ->where('ubiClave', 'CME')
            ->where("escNombre", "like", "ESCUELA%");
    })->get();

      return View('reportes/rel_nvo_ingreso_exani.create', [
        "aluEstado" => $aluEstado,
        "anioActual"=>$anioActual,
        "escuelas" => $escuelas
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
      $parametro_Semestre_Inicio = 1;
      $parametro_Semestre_Fin = 15;
      $parametro_Semestre_Filtro_Inicio = 1;
      $parametro_Semestre_Filtro_Fin = 15;


      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
      // Output: 54esmdr0qf
      $temporary_table_name = "_" . substr(str_shuffle($permitted_chars), 0, 15);

      if($tipoReporte == "escuela")
      {
          $parametro_NombreArchivo = 'pdf_rel_nuevo_ingreso_exani';
          $result =  DB::select("call procInscritosExaniPago99PorEscuela("
              .$userId
              .",".$request->perAnio
              .",'".$request->ubiClave
              ."','".$request->depClave
              ."','".$request->progClave
              ."',".$parametro_Semestre_Inicio
              .",".$parametro_Semestre_Fin
              .",".$parametro_Semestre_Filtro_Inicio
              .",".$parametro_Semestre_Filtro_Fin
              .",'".$request->tipoResumen
              ."','".$temporary_table_name."')");

          $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
          $pagos_deudores_collection = collect( $pagos_deudores_array );

          //dd($pagos_deudores_collection);

          $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
          $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
          $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion." - Nivel: ".$request->depClave;
          $parametro_Titulo = "RELACIÓN DE NUEVO INGRESO POR ESCUELA: ".$result[0]->_return_escuela;
          DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

      }

      if($tipoReporte == "programa")
      {
          $parametro_NombreArchivo = 'pdf_rel_nuevo_ingreso_exani';
          $result =  DB::select("call procInscritosExaniPago99PorPrograma("
              .$userId
              .",".$request->perAnio
              .",'".$request->ubiClave
              ."','".$request->depClave
              ."','".$request->progClave
              ."',".$parametro_Semestre_Inicio
              .",".$parametro_Semestre_Fin
              .",".$parametro_Semestre_Filtro_Inicio
              .",".$parametro_Semestre_Filtro_Fin
              .",'".$request->tipoResumen
              ."','".$temporary_table_name."')");

          $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
          $pagos_deudores_collection = collect( $pagos_deudores_array );

          //dd($pagos_deudores_collection);

          $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
          $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
          $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion." - Nivel: ".$request->depClave;
          $parametro_Titulo = "RELACIÓN DE NUEVO INGRESO POR PROGRAMA: ".$result[0]->_return_escuela;
          DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

      }

      if($pagos_deudores_collection->isEmpty()) {
        alert()->warning('No hay datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar los datos del filtro, como el año y la clave de '.$tipoReporte)->showConfirmButton();
        return back()->withInput();
      }


      $pagos_deudores_collection = $pagos_deudores_collection->sort(
        function ($a, $b) {
          return strcmp($a->grado, $b->grado)
              ?: strcmp($a->grupo, $b->grupo)
              ?: strcmp($a->alumno, $b->alumno);
        }
      );

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
        ]);



        $pdf->setPaper('letter', 'portrait');


        //$pdf->setPaper('letter', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo.'.pdf');
        return $pdf->download($parametro_NombreArchivo.'.pdf');


    }

}

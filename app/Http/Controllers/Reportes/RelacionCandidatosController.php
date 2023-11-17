<?php

namespace App\Http\Controllers\Reportes;

use DB;
use PDF;
use Auth;
use Carbon\Carbon;
use App\Http\Models\Cgt;
use App\Http\Models\Plan;
use App\Http\Models\Cuota;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Models\Programa;

use App\Http\Models\Candidato;
use App\Http\Models\Ubicacion;

use App\Http\Models\Departamento;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class RelacionCandidatosController extends Controller
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

      return View('reportes/relacion_candidatos.create', [
        "aluEstado" => $aluEstado,
        "anioActual"=>$anioActual,
        "escuelas" => $escuelas
      ]);
  }


  public function imprimir(Request $request)
  {

      $candidatos = Candidato::with('departamento','ubicacion', 'escuela', 'programa');


        if ($request->tipoReporte == "escuela") {
          $candidatos = $candidatos->whereHas('escuela', function($query) use ($request) {
            $query->where("escClave", "=", $request->progClave);
          });
        }

        if($request->tipoReporte == "programa") {
          $candidatos = $candidatos->whereHas('programa', function($query) use ($request) {
            $query->where("progClave", "=", $request->progClave);
          });
        }

      $candidatos = $candidatos->orderBy('perApellido1')->orderBy('perApellido2')->orderBy('perNombre');


      $candidatos = $candidatos->get();



      $tipoReporte = $request->tipoReporte;


      if($candidatos->isEmpty()) {
        alert()->warning('No hay datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar los datos del filtro, como el año y la clave de '.$tipoReporte)->showConfirmButton();
        return back()->withInput();
      }

        $fechaActual = Carbon::now("CDT");
        $horaActual = $fechaActual->format("H:i:s");
        $nombreArchivo = 'pdf_relacion_candidatos';

        $nombreEscuelaPrograma = "";
        if ($request->tipoReporte == "escuela") {
          $nombreEscuelaPrograma = Escuela::where("escClave", "=", $request->progClave)->first();
        }
        if ($request->tipoReporte == "programa") {
          $nombreEscuelaPrograma = Programa::where("progClave", "=", $request->progClave)->first();
        }


        return PDF::loadView('reportes.pdf.pdf_relacion_candidatos', [
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $horaActual,
            "depClave" => $request->depClave,
            "nombreArchivo" => $nombreArchivo,
            "candidatos" => $candidatos,
            "tipoReporte" => $request->tipoReporte,
            "escProgClave" => $request->progClave,
            "nombreEscuelaPrograma" => $nombreEscuelaPrograma

        ])->stream('pdf_relacion_candidatos.pdf');
    }

}

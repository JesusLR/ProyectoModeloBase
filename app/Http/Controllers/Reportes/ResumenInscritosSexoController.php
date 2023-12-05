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
use Yajra\DataTables\Facades\DataTables;

use App\Http\Helpers\Utils;
use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class ResumenInscritosSexoController extends Controller
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
    return View('reportes/resumen_inscritos_sexo.create',compact('anioActual'));
  }

  public function imprimir(Request $request)
    {

    $resultados =  DB::select("call procResumenInscritosSexo("
        .$request->perNumero
        .",".$request->perAnio.")");
    
    if (count($resultados) < 1) {
      alert()->error('Error...', " No hay registros que coincidan con la
      información proporcionada. Favor de verificar.")->showConfirmButton();
      return back()->withInput();
    }

    $datos = collect();

    for ($i=0; $i < count($resultados); $i++) { 
      $nivel = $resultados[$i]->nivel;
      $grado = $resultados[$i]->grado;

      $materias0RepM = $resultados[$i]->rep0m;
      $materias0RepF = $resultados[$i]->rep0f;
      $sumaMaterias0Rep = $materias0RepM + $materias0RepF;

      $materias3RepM = $resultados[$i]->rep3m;
      $materias3RepF = $resultados[$i]->rep3f;
      $sumaMaterias3Rep = $materias3RepM + $materias3RepF;

      $materias4RepM = $resultados[$i]->rep4m;
      $materias4RepF = $resultados[$i]->rep4f;
      $sumaMaterias4Rep = $materias4RepM + $materias4RepF;

      $bajasM = $resultados[$i]->bajm;
      $bajasF = $resultados[$i]->bajf;
      $sumaBajas = $bajasM + $bajasF;

      $sumaMateriasRepM = $materias0RepM + $materias3RepM + $materias4RepM;
      $sumaMateriasRepF = $materias0RepF + $materias3RepF + $materias4RepF;

      $sumaMateriasRepMyF = $sumaMateriasRepM + $sumaMateriasRepF;

      $sumaInscHom = $sumaMateriasRepM + $bajasM;
      $sumaInscMuj = $sumaMateriasRepF + $bajasF;
      $sumaInsc = $sumaInscHom + $sumaInscMuj;

      $datos->push([
        "nivel"=>$nivel,
        "grado"=>$grado,
        "materias0RepM"=>$materias0RepM,
        "materias0RepF"=>$materias0RepF,
        "sumaMaterias0Rep"=>$sumaMaterias0Rep,
        "materias3RepM"=>$materias3RepM,
        "materias3RepF"=>$materias3RepF,
        "sumaMaterias3Rep"=>$sumaMaterias3Rep,
        "materias4RepM"=>$materias4RepM,
        "materias4RepF"=>$materias4RepF,
        "sumaMaterias4Rep"=>$sumaMaterias4Rep,
        "bajasM"=>$bajasM,
        "bajasF"=>$bajasF,
        "sumaBajas"=>$sumaBajas,
        "sumaMateriasRepM"=>$sumaMateriasRepM,
        "sumaMateriasRepF"=>$sumaMateriasRepF,
        "sumaMateriasRepMyF"=>$sumaMateriasRepMyF,
        "sumaInscHom"=>$sumaInscHom,
        "sumaInscMuj"=>$sumaInscMuj,
        "sumaInsc"=>$sumaInsc,
      ]);
    }

    $datos = $datos->sortByDesc('nivel')->groupBy('nivel');

    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');
    
    $fechas = Periodo::select('perFechaInicial','perFechaFinal')
    ->where([
      'perAnio' => $request->perAnio,
      'perNumero'=> $request->perNumero
      ])->first();
    $periodo =  '('.$request->perNumero.'/'.$request->perAnio.')  '.Utils::fecha_string($fechas->perFechaInicial,true).' - '.Utils::fecha_string($fechas->perFechaFinal,true);

    $fechaActual = Carbon::now('CDT');

    $nombreArchivo = 'pdf_resumen_inscritos_sexo';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "periodo" => $periodo,
      "perNumero" => $request->perNumero,
      "perAnio" => $request->perAnio

    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

    }
}

<?php

namespace App\Http\Controllers\Reportes;

use DB;
use PDF;

use Carbon\Carbon;
use App\Http\Helpers\Utils;

use App\Models\Periodo;
use App\Models\Escuela;
use App\Models\Programa;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RelAlumnosReprobadosExport;

class RelAlumnosReprobadosController extends Controller
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
    $ubicaciones = Ubicacion::where('ubiClave','<>','000')->get();
    return View('reportes/rel_alumnos_reprobados.create',compact('anioActual','ubicaciones'));
  }

  public function cuatroMateriasReprobadas(Request $request)
    {

      $periodo = Periodo::find($request->periodo_id);
      $escClave = $request->escuela_id ? Escuela::find($request->escuela_id)->escClave : null;
      $progClave = $request->programa_id ? Programa::find($request->programa_id)->progClave : null;

    $resultados =  DB::select("call procBuscarReprobadosInsc("
    .$periodo->perNumero.","
    .$periodo->perAnio.",'"
    .$periodo->departamento->ubicacion->ubiClave."','"
    .$periodo->departamento->depClave."','"
    .$escClave."','"
    .$progClave."')");
            
    $datos = collect();

    for ($i=0; $i < count($resultados); $i++) { 
      $ubiClave = $resultados[$i]->ubiClave;
      $depClave = $resultados[$i]->depClave;
      $escClave = $resultados[$i]->escClave;
      $progClave = $resultados[$i]->progClave;
      $cgtGradoSemestre = $resultados[$i]->cgtGradoSemestre;
      $aluClave = $resultados[$i]->aluClave;
      $aluNombre = $resultados[$i]->aluNombre;
      $tipoIngreso = $resultados[$i]->tipoIngreso;
      $totalReprobadas = $resultados[$i]->totalReprobadas;
      

      $datos->push([
        "ubiClave"=>$ubiClave,
        "depClave"=>$depClave,
        "escClave"=>$escClave,
        "progClave"=>$progClave,
        "cgtGradoSemestre"=>$cgtGradoSemestre,
        "aluClave"=>$aluClave,
        "aluNombre"=>$aluNombre,
        "tipoIngreso"=>$tipoIngreso,
        "totalReprobadas"=>$totalReprobadas,
      ]);
    }

    return $datos;

    }

  public function materiasSeriadas(Request $request)
    {

      $periodo = Periodo::find($request->periodo_id);
      $escClave = $request->escuela_id ? Escuela::find($request->escuela_id)->escClave : null;
      $progClave = $request->programa_id ? Programa::find($request->programa_id)->progClave : null;

    $resultados =  DB::select("call procBuscarReprobadosInscSeriadas("
    .$periodo->perNumero.","
    .$periodo->perAnio.",'"
    .$periodo->departamento->ubicacion->ubiClave."','"
    .$periodo->departamento->depClave."','"
    .$escClave."','"
    .$progClave."')");
            
    $datos = collect();

    for ($i=0; $i < count($resultados); $i++) { 
      $ubiClave = $resultados[$i]->ubiClave;
      $depClave = $resultados[$i]->depClave;
      $escClave = $resultados[$i]->escClave;
      $progClave = $resultados[$i]->progClave;
      $semestre = $resultados[$i]->semestre;
      $aluClave = $resultados[$i]->aluClave;
      $aluNombre = $resultados[$i]->aluNombre;
      $tipoIngreso = $resultados[$i]->tipoIngreso;
      $repClave = $resultados[$i]->repClave;
      $repNombre = $resultados[$i]->repNombre;
      $curClave = $resultados[$i]->curClave;
      $curNombre = $resultados[$i]->curNombre;

      $datos->push([
        "ubiClave"=>$ubiClave,
        "depClave"=>$depClave,
        "escClave"=>$escClave,
        "progClave"=>$progClave,
        "semestre"=>$semestre,
        "aluClave"=>$aluClave,
        "aluNombre"=>$aluNombre,
        "tipoIngreso"=>$tipoIngreso,
        "repClave"=>$repClave,
        "repNombre"=>$repNombre,
        "curClave"=>$curClave,
        "curNombre"=>$curNombre,
      ]);
    }

    return $datos;

    }

    public function materiasSeriadasAnual(Request $request)
    {

      $periodo = Periodo::find($request->periodo_id);
      $escClave = $request->escuela_id ? Escuela::find($request->escuela_id)->escClave : null;
      $progClave = $request->programa_id ? Programa::find($request->programa_id)->progClave : null;

    $resultados =  DB::select("call procBuscarReprobadosInscAnual("
    .$periodo->perNumero.","
    .$periodo->perAnio.",'"
    .$periodo->departamento->ubicacion->ubiClave."','"
    .$periodo->departamento->depClave."','"
    .$escClave."','"
    .$progClave."')");
            
    $datos = collect();

    for ($i=0; $i < count($resultados); $i++) { 
      $ubiClave = $resultados[$i]->ubiClave;
      $depClave = $resultados[$i]->depClave;
      $escClave = $resultados[$i]->escClave;
      $progClave = $resultados[$i]->progClave;
      $cgtGradoSemestre = $resultados[$i]->cgtGradoSemestre;
      $cgtGrupo = $resultados[$i]->cgtGrupo;
      $aluClave = $resultados[$i]->aluClave;
      $aluNombre = $resultados[$i]->aluNombre;
      $curTipoIngreso = $resultados[$i]->curTipoIngreso;
      $matClave = $resultados[$i]->matClave;
      $matNombre = $resultados[$i]->matNombre;
      $matSemestre = $resultados[$i]->matSemestre;
      $calificacion = $resultados[$i]->calificacion;

      $datos->push([
        "ubiClave"=>$ubiClave,
        "depClave"=>$depClave,
        "escClave"=>$escClave,
        "progClave"=>$progClave,
        "cgtGradoSemestre"=>$cgtGradoSemestre,
        "cgtGrupo"=>$cgtGrupo,
        "aluClave"=>$aluClave,
        "aluNombre"=>$aluNombre,
        "curTipoIngreso"=>$curTipoIngreso,
        "matClave"=>$matClave,
        "matNombre"=>$matNombre,
        "matSemestre"=>$matSemestre,
        "calificacion"=>$calificacion,
      ]);
    }

    return $datos;

    }

    public function imprimir(Request $request){

    if($request->tipoReporte == 1){
      $datos = $this->cuatroMateriasReprobadas($request);
    }elseif($request->tipoReporte == 2){
      $datos = $this->materiasSeriadas($request);
    }elseif($request->tipoReporte == 3){
      $datos = $this->materiasSeriadasAnual($request);
    }

    if ($datos->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No se encuentran datos con la información proporcionada.
      Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $fechas = Periodo::findOrFail($request->periodo_id);
    $periodo =  '('.$fechas->perNumero.'/'.$fechas->perAnio.')  '.Utils::fecha_string($fechas->perFechaInicial,true).' - '.Utils::fecha_string($fechas->perFechaFinal,true);

    $fechaActual = Carbon::now('CDT');

    $descripcionReporte = 'Alumnos con cuatro o más reprobadas';
    if($request->tipoReporte == 2) {
      $descripcionReporte = 'Alumnos con materias seriadas reprobadas';
    } else if($request->tipoReporte == 3) {
      $descripcionReporte = 'Alumnos reprobados con más de un año de antigüedad';
    }

    $nombreArchivo = 'pdf_rel_alumnos_reprobados';
   
   if ($request->formatoReporte == "PDF") {
        $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
          
          "datos" => $datos,
          "fechaActual" => $fechaActual->format('d/m/Y'),
          "horaActual" => $fechaActual->format('H:i:s'),
          "nombreArchivo" => $nombreArchivo,
          "periodo" => $periodo,
          "descripcionReporte" => $descripcionReporte,
          "tipoReporte" => $request->tipoReporte,
          "perNumero" => $request->perNumero,
          "perAnio" => $request->perAnio

        ]);


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreArchivo.'.pdf');
        return $pdf->download($nombreArchivo.'.pdf');
    }

    if ($request->formatoReporte == "EXCEL"){


     return Excel::download(new RelAlumnosReprobadosExport($datos, $request->tipoReporte,$periodo,$request->perNumero,$request->perAnio), $nombreArchivo.'.xlsx');

    }
  }
}

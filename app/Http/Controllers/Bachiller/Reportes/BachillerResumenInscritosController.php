<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;
use App\Http\Models\Pago;
use App\Http\Helpers\Utils;
use App\Exports\ResumenInscritosExport;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
// use DB;

class BachillerResumenInscritosController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //$this->middleware('auth');
    //$this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    //obtener año actual para el filtro que genera el reporte del año de periodo
    $ubicaciones = Ubicacion::where('ubiClave','<>','000')->get();
    return view('bachiller.reportes.reportes_resumen_inscritos.create', compact('ubicaciones'));
  }

    public function imprimir(Request $request)
    {

      $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
      $departamento = $periodo->departamento;
      $ubicacion = $departamento->ubicacion;
      $escClave = $request->escuela_id ? Escuela::findOrFail($request->escuela_id)->escClave : null;
      $progClave = $request->programa_id ? Programa::findOrFail($request->programa_id)->progClave : null;

     //dd($periodo->perNumero, $periodo->perAnio, $ubicacion->ubiClave, $departamento->depClave, $escClave,  $progClave);

        //dd($request->tipoReporte);

        // dd($request->tipoReporte, $periodo->perNumero, $periodo->perAnioPago,$ubicacion->ubiClave,$departamento->depClave,$escClave,$progClave);
   $resultados = DB::select("call procResumenInscritos('"
    .$request->tipoReporte."',"
    .$periodo->perNumero.","
    .$periodo->perAnioPago.",'"
    .$ubicacion->ubiClave."','"
    .$departamento->depClave."','"
    .$escClave."','"
    .$progClave."')");

    //dd($resultados, count($resultados));
    if(empty($resultados))
    {
        alert()->error('Error...', " No hay registros que coincidan con la
      información proporcionada. Favor de verificar.")->showConfirmButton();
        return back()->withInput();
    }
    else
    {
        if (count($resultados) == 0)
        {
            alert()->error('Error...', " No hay registros que coincidan con la
      información proporcionada. Favor de verificar.")->showConfirmButton();
            return back()->withInput();
        }
    }


    // $fechas = Periodo::select('perFechaInicial','perFechaFinal')
    // ->where([
    //   'perAnio' => $request->perAnio,
    //   'perNumero'=> $request->perNumero
    //   ])->first();

    $ultimoPago = Utils::fecha_string(Pago::where('pagFormaAplico','A')->latest('pagFechaPago')->pluck('pagFechaPago')->first(),true);

    // $ubicacion = Ubicacion::where('ubiClave',$request->ubiClave)->first();

    $ubicacionNombre = $ubicacion->ubiClave.' '.$ubicacion->ubiNombre;

    $alumnos = '';

    if($request->tipoReporte == 'I'){
      $alumnos = 'ALUMNOS INSCRITOS AL PERIODO:';
    }else{
      $alumnos = 'ALUMNOS PRE-INSCRITOS Y CONDICIONADOS AL PERIODO:';
    }

    $descripcion = $alumnos.' '.$periodo->perNumero.'/'.$periodo->perAnio.'  ('
    .Utils::fecha_string($periodo->perFechaInicial,true).'-'.Utils::fecha_string($periodo->perFechaFinal,true).')';


    $datos = collect();


    $datos->push([
      'ultimoPago'=>'FECHA DE ULTIMO PAGO RECIBIDO: '.$ultimoPago
    ]);
    $datos->push([
      'ubicacion'=>$ubicacionNombre
    ]);
    $datos->push([
      'periodo'=>$descripcion
    ]);

    $datos->push([
      'progNombre'=>'Nivel',
      'ubiClave'=>'Ubicación',
      'depClave'=>'Departamento',
      'escClave'=>'Escuela',
      'progClave'=>'Programa',
      'total01'=>'1',
      'total02'=>'2',
      'total03'=>'3',
      'total04'=>'4',
      'total05'=>'5',
      'total06'=>'6',
      'total07'=>'7',
      'total08'=>'8',
      'total09'=>'9',
      'total10'=>'10+',
      'totalN'=>'Nvo',
      'totalR'=>'Reing',
      'total'=>'Total'
    ]);

    $sumaTotal01 = 0;
    $sumaTotal02 = 0;
    $sumaTotal03 = 0;
    $sumaTotal04 = 0;
    $sumaTotal05 = 0;
    $sumaTotal06 = 0;
    $sumaTotal07 = 0;
    $sumaTotal08 = 0;
    $sumaTotal09 = 0;
    $sumaTotal10 = 0;
    $sumaTotalN = 0;
    $sumaTotalR = 0;
    $sumaTotal = 0;

    //dd(count($resultados));

    for($i=0;$i < count($resultados);$i++){

      $ubiClave = $resultados[$i]->ubiClave;
      $depClave = $resultados[$i]->depClave;
      $escClave = $resultados[$i]->escClave;
      $progClave = $resultados[$i]->progClave;
      $progNombre = $resultados[$i]->progNombre;
      $total01 = $resultados[$i]->total01;
      $total02 = $resultados[$i]->total02;
      $total03 = $resultados[$i]->total03;
      $total04 = $resultados[$i]->total04;
      $total05 = $resultados[$i]->total05;
      $total06 = $resultados[$i]->total06;
      $total07 = $resultados[$i]->total07;
      $total08 = $resultados[$i]->total08;
      $total09 = $resultados[$i]->total09;
      $total10 = $resultados[$i]->total10;
      $totalN = $resultados[$i]->totalN;
      $totalR = $resultados[$i]->totalR;
      $total = $resultados[$i]->total;

      $sumaTotal01 += $total01;
      $sumaTotal02 += $total02;
      $sumaTotal03 += $total03;
      $sumaTotal04 += $total04;
      $sumaTotal05 += $total05;
      $sumaTotal06 += $total06;
      $sumaTotal07 += $total07;
      $sumaTotal08 += $total08;
      $sumaTotal09 += $total09;
      $sumaTotal10 += $total10;
      $sumaTotalN += $totalN;
      $sumaTotalR += $totalR;
      $sumaTotal += $total;

      $datos->push([
        'progNombre'=>$progNombre,
        'ubiClave'=>$ubiClave,
        'depClave'=>$depClave,
        'escClave'=>$escClave,
        'progClave'=>$progClave,
        'total01'=>$total01 ?: '',
        'total02'=>$total02 ?: '',
        'total03'=>$total03 ?: '',
        'total04'=>$total04 ?: '',
        'total05'=>$total05 ?: '',
        'total06'=>$total06 ?: '',
        'total07'=>$total07 ?: '',
        'total08'=>$total08 ?: '',
        'total09'=>$total09 ?: '',
        'total10'=>$total10 ?: '',
        'totalN'=>$totalN ?: '',
        'totalR'=>$totalR ?: '',
        'total'=>$total ?: ''
      ]);
    }

    $datos->push([
      'ubiClave'=>'',
      'depClave'=>'',
      'escClave'=>'TOTAL ACUMULADO',
      'progClave'=>'',
      'progNombre'=>'',
      'total01'=>$sumaTotal01,
      'total02'=>$sumaTotal02,
      'total03'=>$sumaTotal03,
      'total04'=>$sumaTotal04,
      'total05'=>$sumaTotal05,
      'total06'=>$sumaTotal06,
      'total07'=>$sumaTotal07,
      'total08'=>$sumaTotal08,
      'total09'=>$sumaTotal09,
      'total10'=>$sumaTotal10,
      'totalN'=>$sumaTotalN,
      'totalR'=>$sumaTotalR,
      'total'=>$sumaTotal
    ]);

    //dd($datos);
    //return $datos;

    return Excel::download(new ResumenInscritosExport($datos), 'resumen_inscritos.xlsx');


    // return view('reportes.resumen_inscritos.resumen_table',compact('datos','periodo','ubicacionNombre','ultimoPago'));

    }

    public function descargarExcel($datos)
    {
        return Excel::download(new ResumenInscritosExport($datos), 'resumen_inscritos.xlsx');
    }

    public function exportarExcel(Request $request)
    {
      $datos = $this->imprimir($request);

      return $this->descargarExcel($datos);
    }
}

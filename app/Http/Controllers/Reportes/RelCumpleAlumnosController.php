<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Ubicacion;
use App\Models\Estado;
use App\Models\Programa;
use App\Models\Periodo;
use App\Models\Calificacion;
use App\Models\Inscrito;

use App\Http\Helpers\Utils;
use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class RelCumpleAlumnosController extends Controller
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
    $meses = [
      '00' => 'TODOS',
      '01' => 'ENERO',
      '02' => 'FEBRERO',
      '03' => 'MARZO',
      '04' => 'ABRIL',
      '05' => 'MAYO',
      '06' => 'JUNIO',
      '07' => 'JULIO',
      '08' => 'AGOSTO',
      '09' => 'SEPTIEMBRE',
      '10' => 'OCTUBRE',
      '11' => 'NOVIEMBRE',
      '12' => 'DICIEMBRE'
    ];

    $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
    return View('reportes/rel_cumple_alumnos.create',compact('meses', 'ubicaciones'));
  }

  public function imprimir(Request $request)
  {

    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $alumnos = Curso::with('alumno.persona','cgt.plan.programa.escuela.departamento.ubicacion')
      ->where('periodo_id', $request->periodo_id)
      ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', static function($query) use ($request) {
        if($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
        if ($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);//
        }
        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', '=', $request->cgtGrupo);//
        }
      })
      ->whereHas('alumno.persona', static function($query) use($request){
        if ($request->perApellido1) {
          $query->where('perApellido1', '=', $request->perApellido1);
        }
        if ($request->perApellido2) {
          $query->where('perApellido2', '=', $request->perApellido2);
        }
        if ($request->perNombre) {
          $query->where('perNombre', '=', $request->perNombre);
        }
        if ($request->aluClave) {
          $query->where('aluClave', '=', $request->aluClave);
        }
        if ($request->aluMatricula) {
          $query->where('aluMatricula', '=', $request->aluMatricula);
        }
        if ($request->meses != '00') {
          $query->whereMonth('perFechaNac', '=', $request->meses);
        }
      })->get();

    if($alumnos->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }
      
    
    $fechaActual = Carbon::now('CDT');
   
    $perFecha = Periodo::find($request->periodo_id);
    $periodo = Utils::fecha_string($perFecha->perFechaInicial,true).' - '.Utils::fecha_string($perFecha->perFechaFinal,true);

    $datos = $alumnos->mapToGroups(function($item,$key){
      $nombreAlumno = $item->alumno->persona->perApellido1.' '.$item->alumno->persona->perApellido2.' '.$item->alumno->persona->perNombre;
      $progClave = $item->cgt->plan->programa->progClave;
      $ubiClave = $item->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
      $mesCumple = ucwords(Carbon::parse($item->alumno->persona->perFechaNac)->formatLocalized('%B'));
      $diaCumple = Carbon::parse($item->alumno->persona->perFechaNac)->format('d');
      $mes = Carbon::parse($item->alumno->persona->perFechaNac)->format('m');
      $orden = $ubiClave.$progClave.$mes.$diaCumple;

      return [ $progClave => [
        'aluClave' => $item->alumno->aluClave,
        'nombreAlumno' =>$nombreAlumno,
        'ubiClave' =>$ubiClave,
        'progClave'=>$progClave,
        'grado'=>$item->cgt->cgtGradoSemestre,
        'grupo'=>$item->cgt->cgtGrupo,
        'mes'=> $mesCumple,
        'dia'=> $diaCumple,
        'mesNum'=> $mes,
        'orden'=> $orden
      ]];
    })->map(function($item,$key){
      return $item->sortBy('orden')->groupBy('mesNum');
    });
    
    $nombreArchivo = 'pdf_rel_cumple_alumnos';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "periodo" => $periodo
    ]);

    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }

}
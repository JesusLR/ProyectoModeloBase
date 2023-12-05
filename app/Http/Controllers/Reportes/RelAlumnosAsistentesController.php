<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Cgt;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Programa;
use App\Models\Periodo;
use App\Models\ConceptoTitulacion;
use App\Models\Egresado;
use App\Models\Inscrito;

use App\Http\Helpers\Utils;

use Carbon\Carbon;
use Validator;
use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class RelAlumnosAsistentesController extends Controller
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
    $ubicaciones = Ubicacion::all();
    $conceptoTitulacion = ConceptoTitulacion::All();
    return View('reportes/rel_alumnos_asistentes.create',compact('conceptoTitulacion','ubicaciones'));
  }

  public function imprimir(Request $request)
  {
         
    $curso = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion','periodo','alumno.persona')
    
      ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        if ($request->ubicacion_id) {
          $query->where('ubicacion_id', '=', $request->ubicacion_id);//
        }
        if ($request->departamento_id) {
          $query->where('departamento_id', '=', $request->departamento_id);//
        }
        if($request->escuela_id) {
          $query->where('escuela_id','=', $request->escuela_id);
        }
        if ($request->programa_id) {
          $query->where('programa_id', '=', $request->programa_id);//
        }
        if ($request->plan_id) {
          $query->where('plan_id', '=', $request->plan_id);//
        }
        if ($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);//
        }
        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', '=', $request->cgtGrupo);//
        }
      })
      ->whereHas('alumno.persona',function($query) use($request){
        if ($request->aluClave) {
          $query->where('aluClave',$request->aluClave);
        }
        if ($request->aluMatricula) {
          $query->where('aluMatricula',$request->aluMatricula);
        }
        if ($request->perApellido1) {
          $query->where('perApellido1',$request->perApellido1);
        }
        if ($request->perApellido2) {
          $query->where('perApellido2',$request->perApellido2);
        }
        if ($request->perNombre) {
          $query->where('perNombre',$request->perNombre);
        }
      })
      ->whereHas('periodo',function($query) use($request){
        if ($request->periodo_id) {
          $query->where('id',$request->periodo_id);
        }
      })
      ->where('curTipoIngreso',$request->curTipoIngreso)->get();

      if (!$curso->first()) {
        alert()->warning('Sin coincidencias', " No hay registros que coincidan con la
        información proporcionada. Favor de verificar.")->showConfirmButton();
        return back()->withInput();
      }

      $perFecha = Periodo::where('id',$request->periodo_id)->first();
      $periodo = Utils::fecha_string($perFecha->perFechaInicial,true).' - '.Utils::fecha_string($perFecha->perFechaFinal,true);

      $tipoReporte = 'OYENTES';
      if($request->curTipoIngreso == 'RO') {
        $tipoReporte = 'REPETIDORES';
      }

      $datos = $curso->mapToGroups(function($item,$key){
        $depClave = $item->cgt->plan->programa->escuela->departamento->depClave;
        $nombreAlumno = $item->alumno->persona->perApellido1.' '.$item->alumno->persona->perApellido2.' '.$item->alumno->persona->perNombre;
        $progClave = $item->cgt->plan->programa->progClave;
        return [ $depClave => [
        'aluClave' =>$item->alumno->aluClave,
        'nombreAlumno'=>$nombreAlumno,
        'progClave'=>$progClave,
        'nivCar'=>$depClave.' '.$progClave,
        'grado' =>$item->cgt->cgtGradoSemestre,
        'grupo'=>$item->cgt->cgtGrupo,
        ]];
      })->map(function($item,$key){
        return $item->sortBy('progClave');
      });

    $fechaActual = Carbon::now('CDT');
   
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_rel_alumnos_asistentes';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "nombreArchivo" => $nombreArchivo,
      "periodo"=>$periodo,
      'fechaActual' =>$fechaActual->format('d/m/Y'),
      'horaActual'=>$fechaActual->format('H:i:s'),
      "perNumero" => $request->perNumero,
      "perAnio" => $request->perAnio,
      "tipoReporte" => $tipoReporte

    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

  }
}
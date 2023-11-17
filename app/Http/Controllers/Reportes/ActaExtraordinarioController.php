<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Extraordinario;
use App\Http\Models\InscritoExtraordinario;
use App\Http\Models\Ubicacion;
use App\Http\Models\Optativa;
use App\Http\Models\Periodo;
use App\Http\Models\Calificacion;
use App\Http\Models\Inscrito;
use App\clases\personas\MetodosPersonas;

use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;
use PDF;
use DB;

class ActaExtraordinarioController extends Controller
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
    $ubicaciones = Ubicacion::sedes()->get();
    return View('reportes/acta_extraordinario.create',compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $inscritosEx = InscritoExtraordinario::with('extraordinario.materia.plan.programa.escuela.departamento.ubicacion', 'alumno.persona','extraordinario.periodo')
      
      ->whereHas('extraordinario.periodo', function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
      })
      ->whereHas('extraordinario.materia.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        $query->where('escuela_id', $request->escuela_id);
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
        if ($request->matClave) {
          $query->where('matClave', '=', $request->matClave);//
        }
        if ($request->matSemestre) {
          $query->where('matSemestre', '=', $request->matSemestre);//
        }
      })
      ->whereHas('extraordinario', function($query) use ($request) {
        if ($request->empleado_id) {
          $query->where('empleado_id', '=', $request->empleado_id);//
        }
        if ($request->extAlumnosInscritos) {
          $query->where('extAlumnosInscritos', '=', $request->extAlumnosInscritos);//
        }
        if ($request->extGrupo) {
          $query->where('extGrupo', '=', $request->extGrupo);//
        }
      })
      ->where('iexEstado', 'P')->get();

      if($inscritosEx->isEmpty()){
        alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
      }
    
    $inscritoEx = collect();
    $fechaActual = Carbon::now('America/Merida');

    //variables que se mandan a la vista fuera del array
    $periodo = $inscritosEx->first()->extraordinario->periodo;
  
    $perFechas = Carbon::parse($periodo->perFechaInicial)->format('d/m/Y').' al '.Carbon::parse($periodo->perFechaFinal)->format('d/m/Y').' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';

    foreach($inscritosEx as $inscrito){
      $idExtra = $inscrito->extraordinario->id;
      //Datos del alumno
      $aluClave = $inscrito->alumno->aluClave;
      $alumnoNombre = MetodosPersonas::nombreCompleto($inscrito->alumno->persona, true);
      //Datos del empleado (maestro)
      $empleadoNombre = MetodosPersonas::nombreCompleto($inscrito->extraordinario->empleado->persona);
      $empleadoId = $inscrito->extraordinario->empleado_id;
      //Datos de la secretaria administrativa
      $depTituloDoc = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->depTituloDoc;
      $depNombreDoc = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->depNombreDoc;
      $depPuestoDoc = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->depPuestoDoc;

      $iexCalificacion = $inscrito->iexCalificacion;
      $progClave = $inscrito->extraordinario->materia->plan->programa->progClave;
      $planClave = $inscrito->extraordinario->materia->plan->planClave;
      $progNombre = $inscrito->extraordinario->materia->plan->programa->progNombre;
      $ubiClave = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiClave;
      $ubiNombre = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiNombre;
      $matClave = $inscrito->extraordinario->materia->matClave;
      $matNombre = $inscrito->extraordinario->materia->matNombreOficial;
      $extClave = $inscrito->extraordinario->id;
      $extFecha = $inscrito->extraordinario->extFecha;
      $extHora = $inscrito->extraordinario->extHora;
      $extGrupo = $inscrito->extraordinario->extGrupo;
      $califLetras = $iexCalificacion === null ? '' : str_replace(" CON 00/100","",NumeroALetras::convert($iexCalificacion));

      if($inscrito->extraordinario->materia->esAlfabetica()) {
        if (!is_null($iexCalificacion)) {
          $califLetras = $iexCalificacion == 0 ? 'APROBADO' : 'NO APROBADO';
          $iexCalificacion = $iexCalificacion == 0 ? 'A' : 'NA';
        }
      }

      $optativa = Optativa::where('id',$inscrito->extraordinario->optativa_id)->first();

      $inscritoEx->push([  
        'idExtra'=>$idExtra,
        'aluClave'=>$aluClave,
        'alumnoNombre'=>$alumnoNombre,
        'empleadoNombre'=>$empleadoNombre,
        'empleadoId'=>$empleadoId,
        'depTituloDoc'=>$depTituloDoc,
        'depNombreDoc'=>$depNombreDoc,
        'depPuestoDoc'=>$depPuestoDoc,
        'iexCalificacion'=>$iexCalificacion,
        'califLetras'=>$califLetras,
        'progClave'=>$progClave,
        'progNombre'=>$progNombre,
        'matClave'=>$matClave,
        'matNombre'=>$matNombre,
        'extClave'=>$extClave,
        'planClave'=>$planClave,
        'extFecha'=>$extFecha,
        'extHora'=>$extHora,
        'extGrupo'=>$extGrupo,
        'optativa'=>$optativa,
        'ubiClave'=>$ubiClave,
        'ubiNombre'=>$ubiNombre
      ]);
    
    }
    
    $inscritoEx = $inscritoEx->sortBy('alumnoNombre')->groupBy('idExtra');

    $nombreArchivo = 'pdf_acta_extraordinario';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "inscritoEx" => $inscritoEx,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "periodo" => $perFechas
    ])->stream($nombreArchivo.'.pdf');

  }

}
<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Extraordinario;
use App\Models\Ubicacion;
use App\Models\Optativa;
use App\clases\personas\MetodosPersonas;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_inscritosextraordinarios;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;
use PDF;
use DB;

class BachillerActaExtraordinarioController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function reporte()
  {
    // Mostrar el conmbo solo las ubicaciones correspondientes
    $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

    $docentes = Bachiller_empleados::where('empEstado', '!=', 'B')->get();

    return view('bachiller.reportes.acta_extraordinario.create', compact('ubicaciones', 'docentes'));
  }

  public function imprimir(Request $request)
  {
    $formatter = new NumeroALetras();
    $inscritosEx = Bachiller_inscritosextraordinarios::with('bachiller_extraordinario.bachiller_materia.plan.programa.escuela.departamento.ubicacion', 'alumno.persona','bachiller_extraordinario.periodo')

      ->whereHas('bachiller_extraordinario.periodo', function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
      })
      ->whereHas('bachiller_extraordinario.bachiller_materia.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
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
      ->whereHas('bachiller_extraordinario', function($query) use ($request) {
        if ($request->empleado_id) {
          $query->where('bachiller_empleado_id', '=', $request->empleado_id);//
        }
        if ($request->extAlumnosInscritos) {
          $query->where('extAlumnosInscritos', '=', $request->extAlumnosInscritos);//
        }
        if ($request->extGrupo) {
          $query->where('extGrupo', '=', $request->extGrupo);//
        }
      })
      ->where('iexEstado', '!=', 'C')->get();

      if($inscritosEx->isEmpty()){
        alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
      }

    $inscritoEx = collect();
    $fechaActual = Carbon::now('America/Merida');

    //variables que se mandan a la vista fuera del array
    $periodo = $inscritosEx->first()->bachiller_extraordinario->periodo;

    $perFechas = Carbon::parse($periodo->perFechaInicial)->format('d/m/Y').' al '.Carbon::parse($periodo->perFechaFinal)->format('d/m/Y').' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';

    foreach($inscritosEx as $inscrito){
      $idExtra = $inscrito->bachiller_extraordinario->id;
      //Datos del alumno
      $aluClave = $inscrito->alumno->aluClave;
      $alumnoNombre = MetodosPersonas::nombreCompleto($inscrito->alumno->persona, true);
      //Datos del empleado (maestro)
      $empleadoNombre = MetodosPersonas::BachillerNombreCompleto($inscrito->bachiller_extraordinario->bachiller_empleado);
      $empleadoId = $inscrito->bachiller_extraordinario->bachiller_empleado_id;
      //Datos de la secretaria administrativa
      $depTituloDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depTituloDoc;
      $depNombreDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depNombreDoc;
      $depPuestoDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depPuestoDoc;

      $iexCalificacion = $inscrito->iexCalificacion;
      $progClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->progClave;
      $planClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->planClave;
      $progNombre = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->progNombre;
      $ubiClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiClave;
      $ubiNombre = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiNombre;
      $matClave = $inscrito->bachiller_extraordinario->bachiller_materia->matClave;
      $matNombre = $inscrito->bachiller_extraordinario->bachiller_materia->matNombreOficial;
      $extClave = $inscrito->bachiller_extraordinario->id;
      $extFecha = $inscrito->bachiller_extraordinario->extFecha;
      $extHora = $inscrito->bachiller_extraordinario->extHora;
      $extGrupo = $inscrito->bachiller_extraordinario->extGrupo;
      $califLetras = $iexCalificacion === null ? '' : str_replace(" CON 00/100","",$formatter->toWords($iexCalificacion));

      if($inscrito->bachiller_extraordinario->bachiller_materia->esAlfabetica()) {
        $califLetras = $iexCalificacion == 0 ? 'APROBADO' : 'NO APROBADO';
        $iexCalificacion = $iexCalificacion == 0 ? 'A' : 'NA';
      }

      $optativa = Optativa::where('id',$inscrito->bachiller_extraordinario->optativa_id)->first();

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
    // view('reportes.pdf.bachiller.acta_extraordinario.pdf_acta_extraordinario');
    return PDF::loadView('reportes.pdf.bachiller.acta_extraordinario.'. $nombreArchivo, [
      "inscritoEx" => $inscritoEx,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "periodo" => $perFechas
    ])->stream($nombreArchivo.'.pdf');

  }

}

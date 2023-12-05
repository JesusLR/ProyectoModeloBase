<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Curso;
use App\Models\Cgt;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Programa;
use App\Models\Periodo;
use App\Models\ConceptoTitulacion;
use App\Models\Egresado;
use App\Models\Inscrito;

use Carbon\Carbon;
use Validator;
use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class RelTituladosPasantesController extends Controller
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
    // $anioActual = Carbon::now();
    $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
    $conceptoTitulacion = ConceptoTitulacion::All();
    return View('reportes/rel_titulados_pasantes.create',compact('ubicaciones','conceptoTitulacion'));
  }

  public function imprimir(Request $request)
  {
    $egresados = Egresado::with('plan.programa.escuela.departamento.ubicacion','alumno.persona')
    
      ->whereHas('plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        $query->where('departamento_id', $request->departamento_id);
        if ($request->plan_id) {
          $query->where('plan_id', $request->plan_id);//
        }
        if ($request->programa_id) {
          $query->where('programa_id', $request->programa_id);//
        }
        if ($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);//
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
        if($request->perSexo) {
          $query->where('perSexo', $request->perSexo);
        }
      })->where(function($query) use ($request){
        if ($request->egrOpcionTitulo) {
        $query->where('egrOpcionTitulo',$request->egrOpcionTitulo);
        }
        if ($request->egrFechaExamenProfesional) {
        $query->where('egrFechaExamenProfesional',$request->egrFechaExamenProfesional);
        }
        if ($request->egrFechaExpedicionTitulo) {
        $query->where('egrFechaExpedicionTitulo',$request->egrFechaExpedicionTitulo);
        }
        if ($request->pasantes == 'no') {
        $query->where('egrFechaExamenProfesional','!=',NULL);
        }
        if ($request->egrUltimoPeriodo) {
        $query->where('egrUltimoPeriodo',$request->egrUltimoPeriodo);
        }
        if ($request->egrPeriodoTitulacion) {
        $query->where('egrPeriodoTitulacion',$request->egrPeriodoTitulacion);
        }
      })->get();

      if ($egresados->isEmpty()) {
        alert()->warning('Sin coincidencias', " No hay registros que coincidan con la
        información proporcionada. Favor de verificar.")->showConfirmButton();
        return back()->withInput();
      }

      $alumnosIds = $egresados->pluck('alumno_id');
      $periodosIds = $egresados->pluck('egrUltimoPeriodo');
      $cursos = Curso::whereIn('periodo_id',$periodosIds)
      ->whereIn('alumno_id',$alumnosIds)
      ->latest('curFechaRegistro')->get();

      $anioActual = Carbon::now('CDT')->year;
      
    $datos = collect([]);
    $egresados->each(static function ($egresado) use($cursos,$datos,$anioActual) {
      $curso = $cursos->where('alumno_id',$egresado->alumno->id)->first();
      $conceptoTitulacion = ConceptoTitulacion::where('id',$egresado->egrOpcionTitulo)->pluck('contNombre')->first();
      $periodoEgreso = Periodo::find($egresado->egrUltimoPeriodo);
      $periodoTitulacion = Periodo::find($egresado->egrPeriodoTitulacion);
      $ubicacion = $egresado->plan->programa->escuela->departamento->ubicacion;
      $progClave = $egresado->plan->programa->progClave;
      $nacimiento = Carbon::parse($egresado->alumno->persona->perFechaNac)->format('Y');
      $edad = $anioActual - (int)$nacimiento;
      $grupo = $curso ? $curso->cgt->cgtGrupo : '';
      $grado = $curso ? $curso->cgt->cgtGradoSemestre : '';
      $nombreCompleto = $egresado->alumno->persona->perApellido1.' '.$egresado->alumno->persona->perApellido2.' '.$egresado->alumno->persona->perNombre;
      $egrFechaExamenProfesional = $egresado->egrFechaExamenProfesional;
      if ($egrFechaExamenProfesional != NULL) {
        $egrFechaExamenProfesional = Carbon::parse($egrFechaExamenProfesional)->format('d/m/Y');
      }
      $datos->push([
        'egresado' =>$egresado,
        'nombreCompleto' =>$nombreCompleto,
        'edad' => $edad,
        'progClave' => $progClave,
        'ubicacion' => $ubicacion,
        'periodoEgreso' => $periodoEgreso,
        'periodoTitulacion' => $periodoTitulacion,
        'egrFechaExamenProfesional' => $egrFechaExamenProfesional,
        'gradoGrupo' => $grado.$grupo,
        'conceptoTitulacion' => $conceptoTitulacion,
        'periodoOrden' => (int)($periodoEgreso->perAnio.$periodoEgreso->perNumero),
      ]);
    });
    
    $datos = $datos->sortBy('periodoOrden')->groupBy(['progClave', 'periodoOrden']);

    $fechaActual = Carbon::now('CDT');
   
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');

    $nombreArchivo = 'pdf_rel_titulados_pasantes';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "nombreArchivo" => $nombreArchivo,
      'fechaActual' =>$fechaActual->format('d/m/Y'),
      'horaActual'=>$fechaActual->format('H:i:s'),
      "perNumero" => $request->perNumero,
      "perAnio" => $request->perAnio
    ]);

    return $pdf->stream($nombreArchivo.'.pdf');

  }

}
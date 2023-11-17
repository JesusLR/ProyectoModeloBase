<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use App\Http\Models\Calificacion;
use App\Http\Models\Ubicacion;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BoletaCalificacionesController extends Controller
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
    return View('reportes/boleta_calificaciones.create',compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    if(!Auth::check()) {
      return redirect('login');
    }
    
    $calificaciones = Calificacion::with('inscrito.curso.alumno.persona','inscrito.grupo.materia.plan')

      ->whereHas('inscrito.curso.alumno.persona', static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        if ($request->aluClave)
          $query->where('aluClave', $request->aluClave);
        if ($request->aluMatricula)
          $query->where('aluMatricula', $request->aluMatricula);
        if ($request->perApellido1)
          $query->where('perApellido1', $request->perApellido1);
        if ($request->perApellido2)
          $query->where('perApellido2', $request->perApellido2);
        if ($request->perNombre)
          $query->where('perNombre', $request->perNombre);
      })
      ->whereHas('inscrito.grupo.materia.plan', static function($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
        if($request->plan_id)
          $query->where('plan_id', $request->plan_id);
        if ($request->gpoSemestre)
          $query->where('gpoSemestre', $request->gpoSemestre);
        if ($request->gpoClave)
          $query->where('gpoClave', $request->gpoClave);
      })->get();

    if($calificaciones->isEmpty()) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
    
    $datos = collect();
    $fechaActual = Carbon::now('America/Merida');

    //variables que se mandan a la vista fuera del array
    $registro1 = $calificaciones->first();
    $programa = $registro1->inscrito->curso->cgt->plan->programa;
    $periodo = $registro1->inscrito->curso->periodo;
    $ubicacion = $periodo->departamento->ubicacion;

    $periodo = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto').' - '
              .Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

    $alumnos = $calificaciones->groupBy('inscrito.curso.alumno.aluClave');
    $alumnos->each(static function($alumno_calificaciones) use ($datos, $programa) {
      $inscrito = $alumno_calificaciones->first()->inscrito;
      $alumno = $inscrito->curso->alumno;
      $grupo = $inscrito->grupo;
      $plan = $grupo->materia->plan;

      $datos->push([
        'alumno_id' => $alumno->id,
        'aluClave' => $alumno->aluClave,
        'nombreCompleto' => MetodosPersonas::nombreCompleto($alumno->persona, true),
        'calificaciones' => self::mapear_calificaciones($alumno_calificaciones),
        'adeudadas' => self::materiasAdeudadas($alumno, $plan, $programa),
        'gpoSemestre' => $grupo->gpoSemestre,
        'gpoClave' => $grupo->gpoClave,
      ]);
    });

    $nombreArchivo = 'pdf_boleta_calificaciones';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "datos" => $datos->sortBy('nombreCompleto'),
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "programa" => $programa,
      "periodo" => $periodo,
      "ubicacion" => $ubicacion,
    ])->stream($nombreArchivo.'.pdf');

  }# imprimir



  /**
  * @param Collection
  */
  private static function mapear_calificaciones($calificaciones): Collection
  {
    return $calificaciones->map(static function($calificacion) {
      $materia = $calificacion->inscrito->grupo->materia;

      return collect([
        'matClave' => $materia->matClave,
        'matNombre' => $materia->matNombreOficial,
        'es_alfabetica' => $materia->esAlfabetica(),
        'inscCalificacionParcial1' => $calificacion->inscCalificacionParcial1,
        'inscCalificacionParcial2' => $calificacion->inscCalificacionParcial2,
        'inscCalificacionParcial3' => $calificacion->inscCalificacionParcial3,
        'inscFaltasParcial1' => $calificacion->inscFaltasParcial1,
        'inscFaltasParcial2' => $calificacion->inscFaltasParcial2,
        'inscFaltasParcial3' => $calificacion->inscFaltasParcial3,
        'inscPromedioParciales' => $calificacion->inscPromedioParciales,
        'inscCalificacionOrdinario' => $calificacion->inscCalificacionOrdinario,
        'incsCalificacionFinal' => $calificacion->incsCalificacionFinal,
      ]);
    });
  }

  /**
  * @param App\Http\Models\Alumno $alumno
  * @param App\Http\Models\Plan $plan
  * @param App\Http\Models\Programa $programa
  */
  private static function materiasAdeudadas($alumno, $plan, $programa): Collection
  {
    $adeudadas = DB::select("call procMateriasAdeudadas(
      '','','','{$programa->progClave}','{$plan->planClave}','','{$alumno->aluClave}',
      '','','','','','','','', 'N')");

    return collect($adeudadas);
  }



  

}
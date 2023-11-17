<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use Illuminate\Http\Request;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use App\Http\Models\Estado;
use App\Http\Models\Programa;
use App\Http\Models\Periodo;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Calificacion;
use App\Http\Models\Inscrito;
use App\clases\personas\MetodosPersonas;
use App\clases\periodos\MetodosPeriodos;

use Carbon\Carbon;
use PDF;
use DB;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;

class ResAlumnosNoInscritosController extends Controller
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
    $anioActual = Carbon::now();
    $ubicaciones = Ubicacion::where('ubiClave','<>','000')->get();
    return View('reportes/res_alumnos_no_inscritos.create',compact('anioActual','ubicaciones'));
  }

  public function imprimir(Request $request)
  {

    $periodo = Periodo::findOrFail($request->periodo_id);
    $inscritosCaptura = $this->filtrarCursosPor($periodo, $request)->where('curEstado','!=', 'B');

    if($inscritosCaptura->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No se encontraron datos con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $datos = collect();
    $programa = $inscritosCaptura->first()->cgt->plan->programa;
    $ubicacion = $programa->escuela->departamento->ubicacion;

    //Se sacan los dos periodos siguientes
    $periodosSiguientes = MetodosPeriodos::buscarSiguientes($periodo, $periodo->perEstado)->limit(2)->get();
    if($periodosSiguientes->isEmpty()) {
      alert()->warning('No hay periodos siguientes', 'No se encontraron periodos siguientes para generar este reporte. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
  
    $periodoSiguiente = $request->periodoSiguiente == 'uno' ? $periodosSiguientes->first() : $periodosSiguientes->last();
    $periodoCurso = 'Alumnos de '.$periodo->perNumero.'/'.$periodo->perAnio.' que no se pre-inscribieron o fueron baja en '.$periodoSiguiente->perNumero.'/'.$periodoSiguiente->perAnio;
    
    //Con los periodos siguientes se vuelve a realizar la busqueda para sacar los no inscritos y las bajas
    $alumnosPeriodoSiguiente = $this->filtrarCursosPor($periodoSiguiente, $request);
    $alumnosNoInscritos = $inscritosCaptura->whereNotIn('alumno_id', $alumnosPeriodoSiguiente->pluck('alumno_id'));
    $alumnosBajas = $alumnosPeriodoSiguiente->whereIn('alumno_id', $inscritosCaptura->pluck('alumno_id'))
      ->where('curEstado', 'B');

    if ($alumnosNoInscritos->isEmpty() && $alumnosBajas->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No se encuentran datos con la información proporcionada.
      Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    //Se almacen los datos de los alumnos en el collect
    $alumnosNoInscritos->each(static function($curso) use($datos){

      $alumno = $curso->alumno;
      $nombreAlumno = MetodosPersonas::nombreCompleto($alumno->persona, true);

      $datos->push([
        'aluClave' => $alumno->aluClave,
        'nombreAlumno'=>$nombreAlumno,
        'Estado'=>'NO inscrito',
        'semestre'=>$curso->cgt->cgtGradoSemestre,
        'planPeriodos' => $curso->cgt->plan->planPeriodos,
      ]);

    });

    $alumnosBajas->each(static function($curso) use($datos){

      $alumno = $curso->alumno;
      $nombreAlumno = MetodosPersonas::nombreCompleto($alumno->persona, true);

      $datos->push([
        'aluClave' => $alumno->aluClave,
        'nombreAlumno'=>$nombreAlumno,
        'Estado'=>'Baja',
        'semestre'=>$curso->cgt->cgtGradoSemestre
      ]);
    });

    $datos = $datos->unique('aluClave')->sortBy('semestre')->groupBy('semestre');

    $fechaActual = Carbon::now('America/Merida');  

    $nombreArchivo = 'pdf_res_alumnos_no_inscritos';
    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      
      "datos" => $datos,
      "fechaActual" => Utils::fecha_string($fechaActual,true),
      "horaActual" => $fechaActual->format('H:i:s'),
      "periodoCurso" => $periodoCurso,
      "programa" => $programa,
      "ubicacion" => $ubicacion,
      "periodoSiguiente" => $request->periodoSiguiente,

    ]);

    return $pdf->stream($nombreArchivo.'.pdf');

  } // imprimir.



  /**
  * @param App\Http\Models\Periodo $periodo
  * @param Illuminate\Http\Request $request
  */
  private function filtrarCursosPor($periodo, $request): Collection
  {
    return Curso::with('cgt.plan.programa', 'alumno.persona')
    ->where('periodo_id', $periodo->id)
    ->whereHas('cgt.plan.programa', static function($query) use ($request) {
      $query->where('programa_id', $request->programa_id);
    })->get();
  }


}
<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Models\Pago;
use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Curso;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use App\clases\alumnos\MetodosAlumnos;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use DB;

class PosiblesHermanosController extends Controller
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
    return View('reportes/posibles_hermanos.create',compact('ubicaciones'));
  }


  public function imprimir(Request $request)
  {
    $alumnos = new Collection;
    $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);

    Curso::with(['alumno.persona', 'cgt.plan.programa'])
    ->where('periodo_id', $request->periodo_id)
    ->whereHas('cgt.plan.programa', static function ($query) use ($request) {
      if($request->escuela_id) {
        $query->where('escuela_id', $request->escuela_id);
      }
      if($request->programa_id) {
        $query->where('programa_id', $request->programa_id);
      }
    })
    ->chunk(100, static function($cursos) use ($alumnos) {

      if($cursos->isEmpty()) {
        return false;
      }

      $cursos->each(static function($curso) use ($alumnos) {
        $alumno = self::mapear_info_alumno($curso);
        $alumnos->push($alumno);
      });

    });

    if($alumnos->isEmpty()) {
      alert('Ups!', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
      return back()->withInput();
    }

    # ----------------------------------------------------------------
    $apellidos_combinaciones = $alumnos->map(static function($alumno) {
      return $alumno['apellidos_filtrados'];
    })->flatten();

    # ----------------------------------------------------------------
    Curso::with(['alumno.persona', 'cgt.plan.programa'])
    ->whereHas('periodo', static function($query) use ($periodo) {
      $query->where('perAnioPago', $periodo->perAnioPago);
    })
    ->whereHas('alumno.persona', static function($query) use ($apellidos_combinaciones) {
      $sql = DB::raw("CONCAT(perApellido1,' ',perApellido2)");
      $query->whereIn($sql, $apellidos_combinaciones);
    })
    ->whereNotIn('alumno_id', $alumnos->pluck('alumno_id'))
    ->oldest('curFechaRegistro')
    ->chunk(100, static function($cursos) use ($alumnos) {

      if($cursos->isEmpty()) {
        return false;
      }
      
      $cursos->groupBy('alumno_id')->each(static function($alumno_cursos) use ($alumnos) {
        $curso = $alumno_cursos->first();
        $alumno = self::mapear_info_alumno($curso);
        $alumnos->push($alumno);
      });

    });

    # ----------------------------------------------------------------
    $hermanos = $alumnos->groupBy(static function($alumno) {
      return $alumno['apellidos_filtrados'][0]; #apellidos sin tildes
    })->filter(static function($coincidencias_apellidos) {
      return $coincidencias_apellidos->count() > 1;
    })->flatten(1)->keyBy('aluClave');

    if($hermanos->isEmpty()) {
      alert('Ups', 'Al parecer no hay posibles hermanos para el filtro que ha proporcionado.', 'success')->showConfirmButton();
      return back()->withInput();
    }

    # ----------------------------------------------------------------
    $pagos = Pago::whereIn('pagClaveAlu', $hermanos->keys())
    ->where('pagAnioPer', $periodo->perAnioPago)
    ->oldest('pagFechaPago')
    ->pluck('pagFechaPago', 'pagClaveAlu');

    # ----------------------------------------------------------------
    $hermanos = $hermanos->map(static function($alumno, $aluClave) use ($pagos) {
      $fechaPago = $pagos->pull($aluClave);
      $alumno['pagFechaPago'] = $fechaPago ? Utils::fecha_string($fechaPago, 'mesCorto') : '';
      return $alumno;
    })->groupBy(static function($alumno) {
      return $alumno['apellidos_filtrados'][0];
    })->sortKeys();


    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_posibles_hermanos';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "datos" => $hermanos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
      "ubicacion" => $periodo->departamento->ubicacion,
      "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
      "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
    ])->stream($nombreArchivo.'.pdf');

  }# imprimir

  /**
  * @param App\Http\Models\Curso
  */
  private static function mapear_info_alumno($curso): array
  {
    $alumno = $curso->alumno;
    $persona = $alumno->persona;
    $cgt = $curso->cgt;

    return [
      'alumno_id' => $alumno->id,
      'aluClave' => $alumno->aluClave,
      'nombreCompleto' => MetodosPersonas::nombreCompleto($persona, true),
      'apellidos' => $persona->perApellido1.' '.$persona->perApellido2,
      'apellidos_filtrados' => MetodosAlumnos::filtrarApellidos($persona)->unique(),
      'progClave' => $cgt->plan->programa->progClave,
      'grado' => $cgt->cgtGradoSemestre,
      'grupo' => $cgt->cgtGrupo,
      'curEstado' => $curso->curEstado,
      'curTipoBeca' => $curso->curTipoBeca,
      'curPorcentajeBeca' => $curso->curPorcentajeBeca ? $curso->curPorcentajeBeca.'%' : '',
      'curFechaBaja' => Utils::fecha_string($curso->curFechaBaja, 'mesCorto'),
    ];
  }



}
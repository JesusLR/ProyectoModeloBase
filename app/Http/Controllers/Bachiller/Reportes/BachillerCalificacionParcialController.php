<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Firmante;
use App\Http\Models\Calificacion;
use App\Http\Models\Curso;
use App\Http\Models\Minutario;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use App\clases\cgts\MetodosCgt;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerCalificacionParcialController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    // $this->middleware('permisos:r_plantilla_profesores');
    // set_time_limit(8000000);
  }

  public function reporte()
  {
    $anioActual = Carbon::now('America/Merida')->year;
    $ubicacion = Ubicacion::whereIn('id', [1, 2, 3])->get();
    return view('bachiller.reportes.calificacion_parcial.create',compact('anioActual','ubicacion'));
  }
  

  public function imprimir(Request $request)
  {
    $curso = self::buscarCurso($request);
    if(!$curso) return self::alert_verificacion();

    $calificaciones = self::buscarCalificaciones($curso);
    if($calificaciones->isEmpty()) return self::alert_verificacion();
    # ---------------------------------------------------------------------
    $info['calificaciones'] = $calificaciones->map(static function($calificacion) {
      
      return [
        'matNombre' => $calificacion->bachiller_grupo->bachiller_materia->matNombre,
        'parcial1' => $calificacion->insCalificacionParcial1,
        'parcial2' => $calificacion->insCalificacionParcial2,
        'parcial3' => $calificacion->insCalificacionParcial3,
      ];
    })->sortBy('matNombre');
    # ---------------------------------------------------------------------
    $info['alumno'] = self::obtenerInfoAlumno($curso);
    $info['fechaDeHoy'] = self::fecha_texto_constancia();
    $info['periodo'] = $curso->periodo;
    $info['fechaInicial'] = Utils::fecha_string($info['periodo']->perFechaInicial);
    $info['fechaFinal'] = Utils::fecha_string($info['periodo']->perFechaFinal);
    $info['departamento'] = $info['periodo']->departamento;
    $info['municipio'] = $info['departamento']->ubicacion->municipio;
    $info['estado'] = $info['municipio']->estado;
    $info['firmante'] = Firmante::find($request->firmante);
    // $info['suscribe'] = $info['firmante']->firSexo == 'F' ? 'La que suscribe, ' : 'El que suscribe, ';
    $info['es_fue'] = self::definir_es_fue($info['periodo'], $info['departamento']->periodoActual);
    $info['minutario'] = self::crear_minutario($curso);

    if($request->ubicacion_id == 1){
      $nombreArchivo = 'pdf_calificacion_parcial_cme';
    }
    if($request->ubicacion_id == 2){
      $nombreArchivo = 'pdf_calificacion_parcial_cva';
    }

    // view('reportes.pdf.bachiller.calificacion_parcial.pdf_calificacion_parcial_cme');
    return PDF::loadView('reportes.pdf.bachiller.calificacion_parcial.'. $nombreArchivo, $info)
    ->stream($nombreArchivo.'.pdf');
  }#imprimir

  /**
  * @param Illuminate\Http\Request
  */
  private static function buscarCurso($request)
  {
    return Curso::with(['alumno.persona', 'cgt.plan.programa', 'periodo'])
    ->whereHas('periodo.departamento', static function($query) use ($request) {
      $query->where('ubicacion_id', $request->ubicacion_id)
            ->where('perAnio', $request->perAnio)
            ->where('perNumero', $request->perNumero);
    })
    ->whereHas('alumno', static function($query) use ($request) {
      $query->where('aluClave', $request->aluClave);
    })
    ->whereHas('cgt.plan.programa', static function($query) use ($request) {
      if($request->cgtGradoSemestre) 
        $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
      if($request->cgtGrupo)
        $query->where('cgtGrupo', $request->cgtGrupo);
      if($request->progClave)
        $query->where('progClave', $request->progClave);
    })->first();
  }

  /**
  * @param App\Http\Models\Curso
  */
  private static function buscarCalificaciones($curso)
  {
    return Bachiller_inscritos::with('bachiller_grupo.bachiller_materia')
    ->where('curso_id', $curso->id)
    ->get();
  }

  /**
  * Se utiliza cuando un query primario no encuentra registro.
  */
  private static function alert_verificacion()
  {
    alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')
    ->showConfirmButton();
    return back()->withInput();
  }

  /**
  * @param App\Http\Models\Curso
  */
  private static function obtenerInfoAlumno($curso)
  {
    $alumno = $curso->alumno;
    $persona = $alumno->persona;
    $cgt = $curso->cgt;

    return [
      'aluClave' => $alumno->aluClave,
      'nombreCompleto' => MetodosPersonas::nombreCompleto($persona, true),
      'pronombre' => $persona->esMujer() ? 'la' : 'el',
      'alumnx' => $persona->esMujer() ? 'alumna' : 'alumno',
      'grado' => $cgt->cgtGradoSemestre,
      'gradoLetras' => MetodosCgt::semestreALetras($cgt->cgtGradoSemestre),
      'programa' => $cgt->plan->programa->progNombre,
    ];
  }


  private static function fecha_texto_constancia()
  {
    $fechaActual = Carbon::now('America/Merida'); 
    $fechaDia = $fechaActual->format('d');
    $fechaMes = ucwords(Utils::num_meses_string($fechaActual->month));
    $fechaAnio = $fechaActual->format('Y');

    return "{$fechaDia} dias del mes {$fechaMes} de {$fechaAnio}";
  }


  /**
  * @param App\Http\Models\Periodo $periodo_seleccionado
  * @param App\Http\Models\Periodo $periodo_actual
  */
  private static function definir_es_fue($periodo_seleccionado, $periodo_actual)
  {
    $seleccionado_fecha = Carbon::parse($periodo_seleccionado->perFechaInicial);
    $actual_fecha =Carbon::parse($periodo_actual->perFechaInicial);

    return $seleccionado_fecha >= $actual_fecha ? 'es' : 'fue';
  }


  /**
  * @param App\Http\Models\Curso
  */
  private static function crear_minutario($curso) 
  {
    $periodo = $curso->periodo;

    return Minutario::create([
      'minAnio' => $periodo->perAnioPago,
      'minClavePago' => $curso->alumno->aluClave,
      'minDepartamento' => $periodo->departamento->depClave,
      'minTipo' => 'CP',
      'minNombreDocumento' => 'CERTIFICADO PARCIAL',
      'minFecha' => Carbon::now('America/Merida')->format('Y-m-d'),
    ]);
  }

}
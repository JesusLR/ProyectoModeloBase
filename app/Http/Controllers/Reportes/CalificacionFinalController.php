<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Models\Historico;
use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\Http\Models\Minutario;
use App\Http\Models\Materia;
use App\Http\Models\Firmante;
use App\Http\Models\Periodo;
use App\Http\Helpers\Utils;
use App\clases\periodos\MetodosPeriodos;
use App\clases\personas\MetodosPersonas;
use App\clases\historicos\MetodosHistoricos;
use App\clases\cgts\MetodosCgt;


use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CalificacionFinalController extends Controller
{

  protected $periodo;
  protected $historicos;
  protected $curso;

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
    $anioActual = Carbon::now('America/Merida')->year;
    $ubicacion = Ubicacion::sedes()->get();
    $firmante = Firmante::get();
    return View('reportes/calificacion_final.create', compact('anioActual','ubicacion','firmante'));
  }
  
  public function cambiarFirmante($ubicacion_id)
  {
    $firmante = Firmante::where('ubicacion_id',$ubicacion_id)->pluck('firNombre','id');
    return json_encode($firmante);
  }

  public function imprimir(Request $request)
  {

    $periodo_seleccionado = self::buscarPeriodoSeleccionado($request, 'SUP');
    if(!$periodo_seleccionado) return $this->alert_no_hay_registros();

    $periodo_anterior = MetodosPeriodos::buscarAnteriores($periodo_seleccionado, $periodo_seleccionado->perEstado)->first();
    $this->periodo = ($request->que_periodo_buscar == 'seleccionado') ? $periodo_seleccionado : $periodo_anterior;
    if(!$this->periodo) return $this->alert_no_hay_registros();

    //primero se busca por SUP
    $this->curso = $this->buscarCurso($request, $periodo_seleccionado);
    $this->historicos = $this->buscarHistoricosDesdeRequest($request);
    if($this->historicos->isEmpty() || !$this->curso) 
    {
      //si no lo encuentura buscamos por pos
      $periodo_seleccionado = self::buscarPeriodoSeleccionado($request, 'POS');
      if(!$periodo_seleccionado) return $this->alert_no_hay_registros();

      $periodo_anterior = MetodosPeriodos::buscarAnteriores($periodo_seleccionado, $periodo_seleccionado->perEstado)->first();
      $this->periodo = ($request->que_periodo_buscar == 'seleccionado') ? $periodo_seleccionado : $periodo_anterior;
      if(!$this->periodo) return $this->alert_no_hay_registros();

      //primero se busca por SUP
      $this->curso = $this->buscarCurso($request, $periodo_seleccionado);
      $this->historicos = $this->buscarHistoricosDesdeRequest($request);
      if($this->historicos->isEmpty() || !$this->curso) 
        return $this->alert_no_hay_registros();
    }

    $this->mapear_historicos();

    $firmante = Firmante::findOrFail($request->firmante);
    $fechaActual = Carbon::now('America/Merida'); 
    $fechaDia = $fechaActual->format('d');
    $fechaMes = ucwords(Utils::num_meses_string($fechaActual->month));
    $fechaAnio = $fechaActual->format('Y');
    $fechaDeHoy = $fechaDia.' dias del mes '.$fechaMes.' de '.$fechaAnio;
    $departamento = $this->periodo->departamento;
    $periodo_actual = $departamento->periodoActual;
    $ubicacion = $departamento->ubicacion;
    $nombreArchivo = 'pdf_calificacion_final';

    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "fechaDeHoy" => $fechaDeHoy,
      "cicloSemestre" => self::obtenerInfoPeriodo($this->periodo),
      "cicloEscolar" => self::obtenerInfoPeriodo($periodo_seleccionado),
      "departamento" => $departamento,
      "ubicacion" => $ubicacion,
      "es_fue" => $this->definir_es_fue($periodo_seleccionado, $periodo_actual),
      "historicos" => $this->historicos,
      "alumno" => self::obtenerInfoAlumno($this->curso),
      "firmante" => self::obtenerInfoFirmante($firmante),
      "minutario" => self::crear_minutario($this->curso),
    ])->stream($nombreArchivo.'.pdf');

  }#imprimir



  /**
  * @param Illuminate\Http\Request
  */
  private static function buscarPeriodoSeleccionado($request, $claveDepto)
  {
    return Periodo::where('perNumero', $request->perNumero)
    ->where('perAnio', $request->perAnio)
    ->whereHas('departamento.ubicacion', static function($query) use ($request, $claveDepto) {
      $query->where('ubicacion_id', $request->ubicacion_id)
      ->where('depClave', $claveDepto);
    })->first();
  }

  public function alert_no_hay_registros()
  {
    alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
    return back()->withInput();
  }


  /**
  * @param Illuminate\Http\Request
  * @param App\Http\Models\Periodo
  */
  private function buscarCurso($request, $periodo)
  {
    return Curso::with('alumno.persona')
    ->whereHas('alumno', static function($query) use ($request) {
      $query->where('aluClave', $request->aluClave);
    })
    ->where('periodo_id', $periodo->id)
    ->latest('curFechaRegistro')->first();
  }


  /**
  * @param Illuminate\Http\Request
  */
  private function buscarHistoricosDesdeRequest($request): Collection
  {
    return Historico::with(['materia.plan.programa'])
    ->where('periodo_id', $this->periodo->id)
    ->whereHas('materia.plan.programa', static function($query) use ($request) {
      if($request->matSemestre) $query->where('matSemestre', $request->matSemestre);
      if($request->progClave) $query->where('progClave', $request->progClave);
    })
    ->whereHas('alumno', static function($query) use ($request) {
      $query->where('aluClave', $request->aluClave);
    })->get();
  }


  /**
  * @param Collection
  */
  private function mapear_historicos()
  {
    $this->historicos = $this->historicos->map(static function($historico) {
      $materia = $historico->materia;

      return collect([
        'matClave' => $materia->matClave,
        'matNombre' => $materia->matNombreOficial,
        'semestreLetras' => MetodosCgt::semestreALetras($materia->matSemestre, null, true),
        'histComplementoNombre' => $historico->histComplementoNombre,
        'matTipoAcreditacion' => $materia->matTipoAcreditacion,
        'histCalificacion' => MetodosHistoricos::definirCalificacion($historico, $materia),
        'orden' => $materia->matClave.$historico->histFechaExamen,
      ]);
    })->sortByDesc('orden')->unique('matClave');
  }

  /**
  * crea un array con la info del alumno para el reporte
  *
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
      'sexo' => $persona->perSexo,
      'grado' => $cgt->cgtGradoSemestre,
      'gradoLetras' => MetodosCgt::semestreALetras($cgt->cgtGradoSemestre),
      'pronombre' => $persona->esHombre() ? 'el' : 'la',
      'alumnx' => $persona->esHombre() ? 'alumno' : 'alumna', 
      'progNombre' => $cgt->plan->programa->progNombre,
    ];
  }


  /**
  * @param App\Http\Models\Firmante
  */
  private static function obtenerInfoFirmante($firmante)
  {
    return [
      'nombre' => $firmante->firNombre,
      'puesto' => $firmante->firPuesto,
      'quien_suscribe' => $firmante->firSexo == 'F' ? 'La que suscribe' : 'El que suscribe',
    ];
  }


  /**
  * @param App\Http\Models\Periodo
  */
  private static function obtenerInfoPeriodo($periodo)
  {
    return [
      'fechaInicio' => Utils::fecha_string($periodo->perFechaInicial),
      'fechaFinal' => Utils::fecha_string($periodo->perFechaFinal),
    ];
  }

  /**
  * @param App\Http\Models\Periodo $periodo_seleccionado
  * @param App\Http\Models\Periodo $periodo_actual
  */
  private function definir_es_fue($periodo_seleccionado, $periodo_actual)
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
      'minTipo' => 'CF',
      'minFecha' => Carbon::now('America/Merida')->format('Y-m-d'),
    ]);
  }


}# class Controller
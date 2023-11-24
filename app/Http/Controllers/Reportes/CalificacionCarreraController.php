<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

use App\Models\Historico;
use App\Models\Ubicacion;
use App\Models\Firmante;
use App\Models\Curso;
use App\Models\Minutario;
use App\Http\Helpers\Utils;
use App\clases\historicos\MetodosHistoricos;
use App\clases\cgts\MetodosCgt;
use App\clases\personas\MetodosPersonas;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CalificacionCarreraController extends Controller
{

  protected $alumno;
  protected $materias;

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
    $this->materias = new Collection;
  }

  public function reporte()
  {
    $anioActual = Carbon::now('America/Merida')->year;
    $ubicacion = Ubicacion::sedes()->get();
    $firmante = Firmante::get();
    return View('reportes/calificacion_carrera.create',compact('anioActual','ubicacion','firmante'));
  }
  
  public function cambiarFirmante($ubicacion_id)
  {
    $firmante = Firmante::where('ubicacion_id',$ubicacion_id)->pluck('firNombre','id');
    return json_encode($firmante);
  }

  public function imprimir(Request $request)
  {
    $curso = self::buscarCurso($request);
    if(!$curso) return self::alert_verificacion();
    $this->alumno = $curso->alumno;
    $plan = $curso->cgt->plan;
    $historicos = $this->buscarHistoricos($plan);
    $cursos = $this->buscarCursosDeAlumno($plan);
    if($historicos->isEmpty()) return self::alert_verificacion();

    $this->materias = $this->info_por_semestre_cursado($historicos, $cursos);

    $periodo = $curso->periodo;
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;
    $municipio = $ubicacion->municipio;
    $firmante = Firmante::find($request->firmante);

    $nombreArchivo = 'pdf_calificacion_carrera';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "fechaDeHoy" => self::fecha_texto_constancia(),
      "fechaInicial" => Utils::fecha_string($periodo->perFechaInicial),
      "fechaFinal" => Utils::fecha_string($periodo->perFechaFinal),
      "departamento" => $departamento,
      "ubicacion" => $ubicacion,
      "municipio" => $municipio,
      "estado" => $municipio->estado,
      "es_fue" => $this->definir_es_fue($periodo, $departamento->periodoActual),
      "firmante" => $this->obtener_info_firmante($firmante),
      "alumno" => $this->obtener_info_alumno($curso),
      "minutario" => self::crear_minutario($curso),
      "semestres" => $this->materias->sortByDesc('histFechaExamen')->groupBy('grado')->sortKeys(),
    ])->stream($nombreArchivo.'.pdf');

  }#imprimir


  /**
  * @param Illuminate\Http\Request
  */
  private static function buscarCurso($request)
  {
    return Curso::with(['alumno.persona', 'periodo.departamento.ubicacion', 'cgt.plan.programa'])
    ->whereHas('alumno', static function($query) use ($request) {
      $query->where('aluClave', $request->aluClave);
    })
    ->whereHas('periodo.departamento.ubicacion', static function($query) use ($request) {
      $query->where('ubicacion_id', $request->ubicacion_id)
        ->where('perAnio', $request->perAnio)
        ->where('perNumero', $request->perNumero);
    })
    ->when(($request->progClave || $request->cgtGradoSemestre || $request->cgtGrupo), static function($query, $request) {
      
      return $query->whereHas('cgt.plan.programa', static function($query) use ($request) {
        if($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
        }
        if($request->cgtGrupo) {
          $query->where('cgtGrupo', $request->cgtGrupo);
        }
        if($request->progClave) {
          $query->where('progClave', $request->progClave);
        }
      });

    })->latest('curFechaRegistro')->first();
  }#buscarCurso.


  /**
  * @param App\Models\Plan
  */
  private function buscarHistoricos($plan): Collection
  {
    return Historico::with(['materia', 'periodo'])
    ->where('alumno_id', $this->alumno->id)->where('plan_id', $plan->id)
    ->oldest('histFechaExamen')
    ->get()->keyBy('materia_id');
  }


  /**
  * Arroja un mensaje y retorna a la vista previa
  */
  private static function alert_verificacion() {
    alert('Sin Coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar', 'warning')->showConfirmButton();
    return back()->withInput();
  }

  /**
  * @param App\Models\Plan
  */
  private function buscarCursosDeAlumno($plan): Collection
  {
    return Curso::with('cgt')
    ->where('alumno_id', $this->alumno->id)
    ->whereHas('cgt', static function($query) use ($plan) {
      $query->where('plan_id', $plan->id);
    })
    ->oldest('curFechaRegistro')
    ->get()->keyBy('periodo_id');
  }

  /**
  * @param Collection $historicos
  * @param Collection $cursos
  */
  private function info_por_semestre_cursado($historicos, $cursos)
  {
    $historicos->groupBy('periodo_id')->each(function($historicos_periodo, $periodo_id) use ($cursos) {
      $curso = $cursos->pull($periodo_id);

      $historicos_periodo->each(function($historico) use ($curso) {
        $materia = $this->info_materia_cursada($historico, $curso);
        $this->materias->push($materia);
      });

    });

    return $this->materias;
  }


  /**
  * @param App\Models\Historico $historico
  * @param App\Models\Curso $curso
  */
  private function info_materia_cursada($historico, $curso = null): array
  {
    $cgt = $curso ? $curso->cgt : null;
    $periodo = $curso ? $curso->periodo : $historico->periodo;
    $materia = $historico->materia;
    $grado = $cgt ? $cgt->cgtGradoSemestre : $materia->matSemestre;

    return [
      'materia_id' => $materia->id,
      'matClave' => $materia->matClave,
      'matNombre' => $materia->matNombreOficial,
      'matCreditos' => $materia->matCreditos,
      'matTipoAcreditacion' => $materia->matTipoAcreditacion,
      'matSemestre' => $materia->matSemestre,
      'grado' => $grado,
      'histCalificacion' => MetodosHistoricos::definirCalificacion($historico, $materia),
      'histFechaExamen' => Utils::fecha_string($historico->histFechaExamen, 'mesCorto'),
      'cicloSemestre' => Utils::fecha_string($periodo->perFechaInicial).' - '.Utils::fecha_string($periodo->perFechaFinal),
      'orden_materia' => $historico->histFechaExamen,
    ];
  }


  /**
  * @param App\Models\Curso
  */
  private function obtener_info_alumno($curso)
  {
    $persona = $this->alumno->persona;
    $cgt = $curso->cgt;
    $programa = $cgt->plan->programa;

    return [
      'clave' => $this->alumno->aluClave,
      'nombreCompleto' => MetodosPersonas::nombreCompleto($persona, true),
      'sexo' => $persona->perSexo,
      'grado' => $cgt->cgtGradoSemestre,
      'gradoLetras' => MetodosCgt::semestreALetras($cgt->cgtGradoSemestre),
      'pronombre' => $persona->esHombre() ? 'el' : 'la',
      'alumnx' => $persona->esHombre() ? 'alumno' : 'alumna',
      'programa' => $programa->progNombre,
      'tituloOficial' => $programa->progTituloOficial
    ];
  }


  /**
  * @param App\Models\Firmante
  */
  private function obtener_info_firmante($firmante)
  {
    return [
      'nombre' => $firmante->firNombre,
      'puesto' => $firmante->firPuesto,
      'suscribe' => $firmante->firSexo == 'F' ? 'La que suscribe, ' : 'El que suscribe, ',
    ];
  }


  /**
  * @param App\Models\Periodo $periodo_seleccionado
  * @param App\Models\Periodo $periodo_actual
  */
  private function definir_es_fue($periodo_seleccionado, $periodo_actual)
  {
    $seleccionado_fecha = Carbon::parse($periodo_seleccionado->perFechaInicial);
    $actual_fecha =Carbon::parse($periodo_actual->perFechaInicial);

    return $seleccionado_fecha >= $actual_fecha ? 'es' : 'fue';
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
  * @param App\Models\Curso
  */
  private static function crear_minutario($curso)
  {
    $periodo = $curso->periodo;

    return Minutario::create([
      'minAnio' => $periodo->perAnioPago,
      'minClavePago' => $curso->alumno->aluClave,
      'minDepartamento' => $periodo->departamento->depClave,
      'minTipo' => 'CC',
      'minFecha' => Carbon::now('America/Merida')->format('Y-m-d'),
    ]);
  }

}
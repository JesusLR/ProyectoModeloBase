<?php

namespace App\Http\Controllers\Bachiller\Reportes;

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
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_historico;
use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerCalificacionCarreraController extends Controller
{

  protected $alumno;
  protected $bachiller_materias;

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
    $this->bachiller_materias = new Collection;
  }

  public function reporte()
  {
    $anioActual = Carbon::now('America/Merida')->year;
    $ubicacion = Ubicacion::whereIn('id', [1, 2 ,3])->get();
    return view('bachiller.reportes.calificacion_carrera.create',compact('anioActual','ubicacion','firmante'));
  }
  
  public function imprimir(Request $request)
  {
    $curso = self::buscarCurso($request);
    if(!$curso) return self::alert_verificacion();
    $this->alumno = $curso->alumno;
    $plan = $curso->cgt->plan;
    $bachiller_historicos = $this->buscarHistoricos($plan);
    $cursos = $this->buscarCursosDeAlumno($plan);
    if($bachiller_historicos->isEmpty()) return self::alert_verificacion();

    $this->bachiller_materias = $this->info_por_semestre_cursado($bachiller_historicos, $cursos);

    $periodo = $curso->periodo;
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;
    $municipio = $ubicacion->municipio;

    $perAnio = $curso->periodo->perAnio+1;
    $perAnioPago = $curso->periodo->perAnioPago;
    $alumno_id = $curso->alumno_id;
    $saltos_en_hoja = 0;
    if($curso->cgt->cgtGradoSemestre == 1 || $curso->cgt->cgtGradoSemestre == 2){
      $saltos_en_hoja = 1;
    }
    
    if($curso->cgt->cgtGradoSemestre == 3 || $curso->cgt->cgtGradoSemestre == 4 || $curso->cgt->cgtGradoSemestre == 3 || $curso->cgt->cgtGradoSemestre == 4){
      $saltos_en_hoja = 2;
    }

    // $nuevo_curso = Curso::select('cursos.id', 'cursos.alumno_id',
    // 'periodos.id as periodo_id', 'periodos.perNumero', 'periodos.perAnio', 'periodos.perAnioPago', 'periodos.perFechaFinal')
    // ->where('cursos.alumno_id', $alumno_id)
    // ->where('periodos.perAnio', $perAnio)
    // ->where('periodos.perAnioPago', $perAnioPago)
    // ->join('periodos', '.periodo_id', '=', 'periodos.id')
    // ->first();
    // $firmante = Firmante::find($request->firmante);

    // view('reportes.pdf.bachiller.calificacion_carrerra.pdf_calificacion_carrera')
    // if($request->ubicacion_id == 1){
    //   $nombreArchivo = 'pdf_calificacion_carrera_cme';
    // }
    // if($request->ubicacion_id == 2){
    //   $nombreArchivo = 'pdf_calificacion_carrera_cva';
    // }
  
    if($request->mensaje == "NO"){
      $mensaje = ":";
    }
    if($request->mensaje == "COMPLETO"){
      $mensaje = " encontrándose su certificado completo en trámite:";
    }

    if($request->mensaje == "PARCIAL"){
      $mensaje = " encontrándose su certificado parcial en trámite:";
    }

    if($request->leyenda == "SEMESTRE"){
      $ciclo_escolar = Utils::fecha_string($periodo->perFechaInicial).' al '.Utils::fecha_string($periodo->perFechaFinal);

      $curso_perteneciente = "";

      // llamar a view correspondiente 
      if($curso->cgt->cgtGradoSemestre == 2 || $curso->cgt->cgtGradoSemestre == 3){
        if($request->ubicacion_id == 1){
          $nombreArchivo = 'pdf_calificacion_carrera_cme_unahoja';
        }
        if($request->ubicacion_id == 2){
          $nombreArchivo = 'pdf_calificacion_carrera_cva_unahoja';
        }
      }
  
      if($curso->cgt->cgtGradoSemestre == 1 ||  $curso->cgt->cgtGradoSemestre == 4 || $curso->cgt->cgtGradoSemestre == 5 || $curso->cgt->cgtGradoSemestre == 6){
        
        if($request->ubicacion_id == 1){
          $nombreArchivo = 'pdf_calificacion_carrera_cme';
        }
        if($request->ubicacion_id == 2){
          $nombreArchivo = 'pdf_calificacion_carrera_cva';
        }
      }

    }else{
      

      $request->perAnio;
      $request->perNumero;

      if($request->perNumero == 1){
        $_periodo = $curso->periodo->perAnio-1;

        $_cursos = Curso::select('cursos.*', 'periodos.perNumero', 'periodos.perAnio',
        'periodos.perAnioPago', 'periodos.perFechaInicial', 'periodos.perFechaFinal')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->where('alumno_id', $curso->alumno->id)
        ->where('periodos.perAnioPago', '=', $_periodo)
        ->orderBy('periodos.perAnio', 'ASC')
        ->get();

        $inicio = $_cursos[0]->perFechaInicial;
        $final = $_cursos[0]->perFechaFinal;


        $ciclo_escolar = Utils::fecha_string($inicio).' al '.Utils::fecha_string($final);

      }else{
        
        if($request->perNumero == 3){

          $_periodo = $curso->periodo->perAnio;
  
          $_cursos = Curso::select('cursos.*', 'periodos.perNumero', 'periodos.perAnio',
          'periodos.perAnioPago', 'periodos.perFechaInicial', 'periodos.perFechaFinal')
          ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
          ->where('alumno_id', $curso->alumno->id)
          ->where('periodos.perAnioPago', '=', $_periodo)          
          ->orderBy('periodos.perAnio', 'ASC')
          ->get();
  
          $inicio = $_cursos[0]->perFechaInicial;
          $final = $_cursos[0]->perFechaFinal;
  
  
          $ciclo_escolar = Utils::fecha_string($inicio).' al '.Utils::fecha_string($final);
  
        }
      }

      
      // llamar a view correspondiente 
      if($curso->cgt->cgtGradoSemestre == 2 || $curso->cgt->cgtGradoSemestre == 3){
        if($request->ubicacion_id == 1){
          $nombreArchivo = 'pdf_calificacion_carrera_cme_unahoja';
        }
        if($request->ubicacion_id == 2){
          $nombreArchivo = 'pdf_calificacion_carrera_cva_unahoja';
        }
        
      }
  
      if($curso->cgt->cgtGradoSemestre == 1 ||  $curso->cgt->cgtGradoSemestre == 4 || $curso->cgt->cgtGradoSemestre == 5 || $curso->cgt->cgtGradoSemestre == 6){
        
        if($request->ubicacion_id == 1){
          $nombreArchivo = 'pdf_calificacion_carrera_cme';
        }
        if($request->ubicacion_id == 2){
          $nombreArchivo = 'pdf_calificacion_carrera_cva';
        }
      }
      
      

      if($curso->cgt->cgtGradoSemestre == 1 || $curso->cgt->cgtGradoSemestre == 2){
        $curso_perteneciente = "PRIMER curso";
      }

      if($curso->cgt->cgtGradoSemestre == 3 || $curso->cgt->cgtGradoSemestre == 4){
        $curso_perteneciente = "SEGUNDO curso";
      }

      if($curso->cgt->cgtGradoSemestre == 5 || $curso->cgt->cgtGradoSemestre == 6){
        $curso_perteneciente = "TERCER curso";
      }

    }

    // return $this->bachiller_materias->sortByDesc('histFechaExamen')->groupBy('grado')->sortKeys();
    // view('reportes.pdf.bachiller.calificacion_carrerra.pdf_calificacion_carrera_cme');
    return PDF::loadView('reportes.pdf.bachiller.calificacion_carrerra.'. $nombreArchivo, [
      "fechaDeHoy" => self::fecha_texto_constancia(),
      "fechaInicial" => Utils::fecha_string($periodo->perFechaInicial),
      "fechaFinal" => Utils::fecha_string($periodo->perFechaFinal),
      // "fechaFinal" => Utils::fecha_string($nuevo_curso->perFechaFinal),
      "departamento" => $departamento,
      "ubicacion" => $ubicacion,
      "municipio" => $municipio,
      "estado" => $municipio->estado,
      "es_fue" => $this->definir_es_fue($periodo, $departamento->periodoActual),
      // "firmante" => $this->obtener_info_firmante($firmante),
      "alumno" => $this->obtener_info_alumno($curso),
      "minutario" => self::crear_minutario($curso),
      "semestres" => $this->bachiller_materias->sortByDesc('histFechaExamen')->groupBy('grado')->sortKeys(),
      "leyenda" => $request->leyenda,
      "mensaje" => $mensaje,
      "ciclo_escolar" => $ciclo_escolar,
      "curso_perteneciente" => $curso_perteneciente,
      "saltos_en_hoja" => $saltos_en_hoja
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

    ->whereHas('cgt', static function($query) use ($request) {
      if($request->cgtGradoSemestre) {
        $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
      }
      if($request->cgtGrupo) {
        $query->where('cgtGrupo', $request->cgtGrupo);
      }
    })

    ->whereHas('cgt.plan.programa', static function($query) use ($request) {
      if($request->progClave) {
        $query->where('progClave', $request->progClave);
      }
    })
    ->latest('curFechaRegistro')->first();
  }#buscarCurso.


  /**
  * @param App\Models\Plan
  */
  private function buscarHistoricos($plan): Collection
  {
    return Bachiller_historico::with(['bachiller_materia', 'periodo'])
    ->where('alumno_id', $this->alumno->id)->where('plan_id', $plan->id)
    ->whereNull('deleted_at')
    ->whereHas('bachiller_materia', static function($query) {
      $query->where('matClasificacion', '!=', 'C');
      $query->where('matClasificacion', '!=', 'X');
    })
    ->oldest('histFechaExamen')
    ->get()->keyBy('bachiller_materia_id');
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
  * @param Collection $bachiller_historicos
  * @param Collection $cursos
  */
  private function info_por_semestre_cursado($bachiller_historicos, $cursos)
  {
    $bachiller_historicos->groupBy('periodo_id_ficticio')->each(function($bachiller_historicos_periodo, $periodo_id_ficticio) use ($cursos) {
      $curso = $cursos->pull($periodo_id_ficticio);

      $bachiller_historicos_periodo->each(function($bachiller_historico) use ($curso) {
        $bachiller_materia = $this->info_materia_cursada($bachiller_historico, $curso);
        $this->bachiller_materias->push($bachiller_materia);
      });

    });

    return $this->bachiller_materias;
  }


  /**
  * @param App\Models\Historico $bachiller_historico
  * @param App\Models\Curso $curso
  */
  private function info_materia_cursada($bachiller_historico, $curso = null): array
  {
    $cgt = $curso ? $curso->cgt : null;

    // validamos si es recuersamiento 
    if($bachiller_historico->histPeriodoAcreditacion == "RV" || $bachiller_historico->histPeriodoAcreditacion == "RC"){
      $periodo = $curso ? $curso->periodo : $bachiller_historico->periodoFicticio;
    }else{
      $periodo = $curso ? $curso->periodo : $bachiller_historico->periodo;
    }
    
    $bachiller_materia = $bachiller_historico->bachiller_materia;
    $grado = $cgt ? $cgt->cgtGradoSemestre : $bachiller_materia->matSemestre;
    // $grado = $bachiller_materia->matSemestre;

    return [
      'materia_id' => $bachiller_materia->id,
      'matClave' => $bachiller_materia->matClave,
      'matNombre' => $bachiller_materia->matNombre,
      'matCreditos' => $bachiller_materia->matCreditos,
      'matTipoAcreditacion' => $bachiller_materia->matTipoAcreditacion,
      'matSemestre' => $bachiller_materia->matSemestre,
      'grado' => $grado,
      'histCalificacion' => MetodosHistoricos::definirCalificacion($bachiller_historico, $bachiller_materia),
      'histFechaExamen' => Utils::fecha_string($bachiller_historico->histFechaExamen, 'mesCorto'),
      'cicloSemestre' => Utils::fecha_string($periodo->perFechaInicial).' - '.Utils::fecha_string($periodo->perFechaFinal),
      'orden_materia' => $bachiller_historico->histFechaExamen,
      'es_revalidacion' => $bachiller_historico->histTipoAcreditacion
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
      'tituloOficial' => $programa->progTituloOficial,
      'matricula' => $this->alumno->aluMatricula
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
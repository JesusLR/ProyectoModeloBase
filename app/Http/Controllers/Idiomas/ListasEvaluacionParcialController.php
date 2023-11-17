<?php

namespace App\Http\Controllers\Idiomas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Grupo;
use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Idiomas\Idiomas_calificaciones_materia;
use App\Http\Models\Inscrito;

use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ListasEvaluacionParcialController extends Controller
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
  }

  public function reporte()
  {
    return View('idiomas.listas_evaluacion_parcial.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }

  public function imprimir(Request $request)
  {
    $query = Idiomas_grupos::select(
      'ubicacion.ubiClave',
      'ubicacion.ubiNombre',
      'periodos.id',
      'periodos.perNumero',
      'periodos.perAnio',
      'periodos.perFechaInicial',
      'periodos.perFechaFinal',
      'programas.id',
      'programas.progClave',
      'programas.progNombre',
      'planes.id',
      'planes.planClave',
      'alumnos.aluClave',
      'personas.perNombre',
      'personas.perApellido1',
      'personas.perApellido2',
      'idiomas_resumen_calificaciones.id as idiomas_resumen_calificaciones',
      'idiomas_resumen_calificaciones.rcReporte1',
      'idiomas_resumen_calificaciones.rcReporte1Ponderado',
      'idiomas_resumen_calificaciones.rcReporte2',
      'idiomas_resumen_calificaciones.rcReporte2Ponderado',
      'idiomas_resumen_calificaciones.rcMidTerm',
      'idiomas_resumen_calificaciones.rcMidTermPonderado',
      'idiomas_resumen_calificaciones.rcProject1',
      'idiomas_resumen_calificaciones.rcProject1Ponderado',
      'idiomas_resumen_calificaciones.rcReporte3',
      'idiomas_resumen_calificaciones.rcReporte3Ponderado',
      'idiomas_resumen_calificaciones.rcReporte4',
      'idiomas_resumen_calificaciones.rcReporte4Ponderado',
      'idiomas_resumen_calificaciones.rcFinalExam',
      'idiomas_resumen_calificaciones.rcFinalExamPonderado',
      'idiomas_resumen_calificaciones.rcProject2',
      'idiomas_resumen_calificaciones.rcProject2Ponderado',
      'idiomas_empleados.id AS empleado_id',
      'idiomas_empleados.empNombre',
      'idiomas_empleados.empApellido1',
      'idiomas_empleados.empApellido2',
      'idiomas_grupos.id as grupo_id',
      'idiomas_grupos.*'
    )
    ->join('periodos', 'idiomas_grupos.periodo_id', '=', 'periodos.id')
    ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
    ->join('programas', 'planes.programa_id', '=', 'programas.id')
    ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
    ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
    ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
    ->join('idiomas_cursos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
    ->join('idiomas_resumen_calificaciones', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
    ->join('idiomas_empleados', 'idiomas_grupos.idiomas_empleado_id', '=', 'idiomas_empleados.id')
    ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
    ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
    ->where('idiomas_cursos.curEstado', '!=', 'B')
    ->whereNull('idiomas_cursos.deleted_at')
    ->whereNull('idiomas_resumen_calificaciones.deleted_at')
    ->orderBy('personas.perApellido1', 'asc')
    ->orderBy('personas.perApellido2', 'asc')
    ->orderBy('personas.perNombre', 'asc');

    // if($request->idiomas_grupo_evidencia_id)
    if($request->programa_id)
      $query->where('programas.id', $request->programa_id);
    if ($request->plan_id)
      $query->where('planes.id', $request->plan_id);
    if ($request->matClave)
      $query->where('idiomas_materias.matClave', '=', $request->matClave);
    if($request->grupo_id)
      $query->where('idiomas_grupos.id', $request->grupo_id);
    if($request->periodo_id)
      $query->where('periodos.id', $request->periodo_id);
    if($request->gpoSemestre)
      $query->where('idiomas_grupos.gpoGrado', $request->gpoSemestre);
    if($request->gpoClave)
      $query->where('idiomas_grupos.gpoClave', $request->gpoClave);
    if($request->empleado_id)
      $query->where('idiomas_empleados.id', $request->empleado_id);
    if($request->grupo_id)
      $query->where('id', $request->grupo_id);

    if($query->get()->isEmpty()) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }
    $grupos = $query->get();
    $grupos = $grupos->groupBy('grupo_id');
    $evidencia_calificaciones_materias = 'cm'.$request->idiomas_grupo_evidencia_id;
    $evidencia_resumen_calificaciones = 'rc'.$request->idiomas_grupo_evidencia_id;
    $evidencia_resumen_calificaciones_ponderado = 'rc'.$request->idiomas_grupo_evidencia_id.'Ponderado';
    $oGrupo = new \stdClass();
    $oGrupo->grupos = [];
    $oGrupo->perFechaInicial = null;
    $oGrupo->perFechaFinal = null;
    $oGrupo->perNumero = null;
    $oGrupo->perAnio = null;
    $oGrupo->progClave = null;
    $oGrupo->planClave = null;
    $oGrupo->progNombre = null;
    $oGrupo->ubiClave = null;
    $oGrupo->ubiNombre = null;
    $oGrupo->matClave = null;
    $oGrupo->matNombre = null;
    $oGrupo->gpoClave = null;
    $oGrupo->gpoSemestre = null;
    foreach ($grupos as $grupo_id => $grupo) {
      $tbody = Idiomas_calificaciones_materia::select(
        'idiomas_materias.id',
        'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id',
        'matClave',
        'matNombre',
        $evidencia_calificaciones_materias
      )
      ->join('idiomas_materias', 'idiomas_calificaciones_materia.idiomas_materia_id', '=', 'idiomas_materias.id')
      ->whereIn('idiomas_resumen_calificaciones_id', $grupos[$grupo_id]->pluck('idiomas_resumen_calificaciones')->toArray())
      ->get();
      if( $tbody->isNotEmpty() ) {
        $oGrupo->grupos[$grupo_id]['cabecera'] = [];
        $oGrupo->grupos[$grupo_id]['alumnos'] = [];
        $oGrupo->grupos[$grupo_id]['gpoClave'] = null;
        $oGrupo->grupos[$grupo_id]['gpoSemestre'] = null;
        $cabecera = Idiomas_calificaciones_materia::select(
          'matNombre',
          'matClave'
        )
        ->join('idiomas_materias', 'idiomas_calificaciones_materia.idiomas_materia_id', '=', 'idiomas_materias.id')
        ->where('idiomas_resumen_calificaciones_id', $tbody[0]->idiomas_resumen_calificaciones_id)
        ->get();
        foreach ($cabecera as $titulo) {
          array_push($oGrupo->grupos[$grupo_id]['cabecera'], [
            'matNombre' => $titulo->matNombre,
            'matClave' => $titulo->matClave,
          ]);
        }
        foreach ($grupos[$grupo_id] as $key => $value) {
          $oGrupo->perFechaInicial = $grupos[$grupo_id][$key]->perFechaInicial;
          $oGrupo->perFechaFinal = $grupos[$grupo_id][$key]->perFechaFinal;
          $oGrupo->perNumero = $grupos[$grupo_id][$key]->perNumero;
          $oGrupo->perAnio = $grupos[$grupo_id][$key]->perAnio;
          $oGrupo->progClave = $grupos[$grupo_id][$key]->progClave;
          $oGrupo->planClave = $grupos[$grupo_id][$key]->planClave;
          $oGrupo->progNombre = $grupos[$grupo_id][$key]->progNombre;
          $oGrupo->ubiClave = $grupos[$grupo_id][$key]->ubiClave;
          $oGrupo->ubiNombre = $grupos[$grupo_id][$key]->ubiNombre;
          $oGrupo->grupos[$grupo_id]['gpoClave'] = $grupos[$grupo_id][$key]->gpoClave;
          $oGrupo->grupos[$grupo_id]['gpoSemestre'] = $grupos[$grupo_id][$key]->gpoGrado;
          
          $datos = [
            'aluClave' => $grupos[$grupo_id][$key]->aluClave,
            'perApellido1' => $grupos[$grupo_id][$key]->perApellido1,
            'perApellido2' => $grupos[$grupo_id][$key]->perApellido2,
            'perNombre' => $grupos[$grupo_id][$key]->perNombre,
            'evidencia' => $grupos[$grupo_id][$key]->$evidencia_resumen_calificaciones,
            'evidenciaPonderado' => $grupos[$grupo_id][$key]->$evidencia_resumen_calificaciones_ponderado,
            'empNombre' => $grupos[$grupo_id][$key]->empNombre,
            'empApellido1' => $grupos[$grupo_id][$key]->empApellido1,
            'empApellido2' => $grupos[$grupo_id][$key]->empApellido2,
            'empleado_id' => $grupos[$grupo_id][$key]->empleado_id,
            'midTerm' => $grupos[$grupo_id][$key]->rcMidTerm,
            'finalExam' => $grupos[$grupo_id][$key]->rcFinalExam,
            'project1' => $grupos[$grupo_id][$key]->rcProject1,
            'project2' => $grupos[$grupo_id][$key]->rcProject2,
          ];
          $calificaciones = $tbody->where('idiomas_resumen_calificaciones_id',$grupos[$grupo_id][$key]->idiomas_resumen_calificaciones);
          foreach ($calificaciones as $calificacion) {
            $datos[$calificacion->matNombre.'-'.$calificacion->matClave] = $calificacion->$evidencia_calificaciones_materias;
          }
          array_push($oGrupo->grupos[$grupo_id]['alumnos'], $datos);
        }
      }
    }

    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_listas_evaluacion_parcial';
    return PDF::loadView('idiomas.listas_evaluacion_parcial.'. $nombreArchivo, [
      'evidencia' => $request->idiomas_grupo_evidencia_id,
      'oGrupo' => $oGrupo,
      "nombreArchivo" => $nombreArchivo,
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
    ])->stream($nombreArchivo . '.pdf');
  }
}
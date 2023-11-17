<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\clases\personas\MetodosPersonas;
use App\clases\cgts\MetodosCgt;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AlumnosForaneosController extends Controller
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
    $anioActual = Carbon::now('America/Merida');
    $ubicaciones = Ubicacion::sedes()->get();
    return View('reportes/alumnos_foraneos.create', compact('anioActual', 'ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $cursos = Curso::with(['cgt.plan', 'alumno.persona'])
    ->where('periodo_id', $request->periodo_id)
    ->whereHas('cgt.plan', static function($query) use ($request) {
      $query->where('programa_id', $request->programa_id);
      if($request->cgtGradoSemestre) {
        $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
      }
      if($request->cgtGrupo) {
        $query->where('cgtGrupo', $request->cgtGrupo);
      }
    })
    ->whereHas('alumno.persona', static function($query) use ($request) {
      if($request->aluClave) {
        $query->where('aluClave', $request->aluClave);
      }
      if($request->aluMatricula) {
        $query->where('aluMatricula', $request->aluMatricula);
      }
      if($request->perApellido1) {
        $query->where('perApellido1', $request->perApellido1);
      }
      if($request->perApellido2) {
        $query->where('perApellido2', $request->perApellido2);
      }
      if($request->perNombre) {
        $query->where('perNombre', $request->perNombre);
      }
    })->latest('curFechaRegistro')->get()->unique('alumno_id');

    if($cursos->isEmpty()) {
      alert()->warning('No hay datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $registro1 = $cursos->first();
    //variables que se mandan a la vista fuera del array
    $programa = $registro1->cgt->plan->programa;
    $periodo = $registro1->periodo;
    $ubicacion = $periodo->departamento->ubicacion;
    $municipioBase = $ubicacion->municipio;
    $estadoBase = $municipioBase->estado;

    $foraneos = $cursos->map(static function($curso) {
      $alumno = $curso->alumno;
      $persona = $alumno->persona;
      $nombreCompleto = MetodosPersonas::nombreCompleto($persona, true);
      $cgt = $curso->cgt;
      $semestre_orden = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);
      $municipio = $persona->municipio;

      return collect([
        'aluClave' => $alumno->aluClave,
        'nombreCompleto' => $nombreCompleto,
        'grado' => $cgt->cgtGradoSemestre,
        'grupo' => $cgt->cgtGrupo,
        'municipio' => $municipio->munNombre,
        'estado' => $municipio->estado->edoNombre,
        'orden' => $semestre_orden.$nombreCompleto,
      ]);
    })->where('estado', '!=', $estadoBase->edoNombre)->sortBy('orden');

    if($foraneos->isEmpty()) {
      alert()->warning('Sin Foráneos', 'No hay datos alumnos foráneos dentro de este filtro de búsqueda')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_alumnos_foraneos';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "alumnos" => $foraneos,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo.'.pdf',
      "programa" => $programa,
      "ubicacion" => $ubicacion,
      "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
      "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
      "estadoBase" => $estadoBase,
    ])->stream($nombreArchivo.'.pdf');

  }

}
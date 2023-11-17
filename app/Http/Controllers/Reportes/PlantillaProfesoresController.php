<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Grupo;
use App\Http\Models\Escolaridad;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PlantillaProfesoresController extends Controller
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
  }

  public function reporte()
  {
    return View('reportes/plantilla_profesores.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }

  public function horariosGrupoSemestre($request)
  {

    $grupos = Grupo::with(['materia.plan', 'empleado.persona'])
    ->whereHas('materia.plan', static function($query) use ($request) {
      $query->where('programa_id', $request->programa_id);
      if($request->plan_id) {
        $query->where('plan_id', $request->plan_id);
      }
      if($request->matClave) {
        $query->where('matClave', $request->matClave);
      }
    })
    ->where(static function($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
      if($request->gpoSemestre) {
        $query->where('gpoSemestre', $request->gpoSemestre);
      }
      if($request->gpoClave) {
        $query->where('gpoClave', $request->gpoClave);
      }
      if($request->empleado_id) {
        $query->where('empleado_id', $request->empleado_id);
      }
    })->get();

    if($grupos->isEmpty()) {
      return false;
    }

    $escolaridades = Escolaridad::with('abreviatura')
    ->whereIn('empleado_id', $grupos->pluck('empleado_id'))
    ->where('escoUltimoGrado', 'S')->get()->keyBy('empleado_id');

    return $grupos->map(static function($grupo) use ($escolaridades) {
      $empleado = $grupo->empleado;
      $materia = $grupo->materia;
      $escolaridad = $escolaridades->get($empleado->id);

      return collect([
        'info' => $grupo,
        'matClave' => $materia->matClave,
        'matNombre' => $materia->matNombreOficial,
        'grado' => $grupo->gpoSemestre,
        'grupo' => $grupo->gpoClave,
        'abtAbreviatura' => $escolaridad ? $escolaridad->abreviatura->abtAbreviatura : '',
        'empleado_id' => $empleado->id,
        'nombreCompleto' => MetodosPersonas::nombreCompleto($empleado->persona, true),
        'orden' => $grupo->gpoClave.'-'.$materia->matClave,
      ]);
    })->sortBy('orden');
  }

  public function imprimir(Request $request)
  {
    $grados = $this->horariosGrupoSemestre($request);

    if(!$grados) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    $periodo = $grados->first()['info']->periodo;
    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_plantilla_profesores.pdf';

    return PDF::loadView('reportes.pdf.pdf_plantilla_profesores', [
      "grados" => $grados->groupBy('grado')->sortKeys(),
      "plan" => $grados->first()['info']->plan,
      "nombreArchivo" => $nombreArchivo,
      "periodo" => $periodo,
      "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
      "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
      "ubicacion" => $periodo->departamento->ubicacion,
      "fechaActual" => $fechaActual->format('Y/m/d'),
      "horaActual" => $fechaActual->format('H:i:s'),
    ])->stream($nombreArchivo);
  }
}
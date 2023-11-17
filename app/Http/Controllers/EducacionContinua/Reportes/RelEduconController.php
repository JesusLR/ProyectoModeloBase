<?php

namespace App\Http\Controllers\EducacionContinua\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Empleado;
use App\Http\Models\Ubicacion;
use App\Http\Models\TiposPrograma;
use App\Http\Models\InscritosEduCont;
use App\Http\Models\EducacionContinua;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class RelEduconController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:relacion_edu_continua');
  }

  public function reporte()
  {

    return View('educacion_continua/reportes.create', [
      'ubicaciones' => Ubicacion::sedes()->get(),
      'tiposPrograma' => TiposPrograma::get(),
      'empleados'     => Empleado::activos()->get(),
    ]);
  }
  

  public function imprimir(Request $request)
  {
    $programas = self::buscarProgramas($request);
    if($programas->isEmpty()) {
      alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
      return back()->withInput();
    }

    $inscritosData = InscritosEduCont::whereIn('educacioncontinua_id', $programas->pluck('id'));

    $programas->each(static function($programa) use ($inscritosData) {
      $inscritos = $inscritosData->where('educacioncontinua_id', $programa->id);
      $programa->cantidad_inscritos = $inscritos->count();
      $programa->cantidad_pagos = $inscritos->regulares()->count();
      $programa->ecFechaRegistro = Utils::fecha_string($programa->ecFechaRegistro, 'mesCorto');
    });
    
    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_rel_edu_continua';
    return PDF::loadView('educacion_continua.pdf.'. $nombreArchivo, [
      "programas" => $programas,
      "fechaActual" => $fechaActual->format('d/m/Y'),
      "horaActual" => $fechaActual->format('H:i:s'),
      "nombreArchivo" => $nombreArchivo,
    ])->stream($nombreArchivo.'.pdf');

  }# imprimir.


  private static function buscarProgramas($request): Collection
  {
    return EducacionContinua::with('tipoprograma')
    ->whereHas('periodo.departamento', static function($query) use ($request) {
      if($request->periodo_id) {
        $query->where('periodo_id', $request->periodo_id);
      }
      if($request->departamento_id) {
        $query->where('departamento_id', $request->departamento_id);
      }
    })
    ->where(static function($query) use ($request) {
      if($request->escuela_id) {
        $query->where('escuela_id', $request->escuela_id);
      }
      if($request->ubicacion_id) {
        $query->where('ubicacion_id', $request->ubicacion_id);
      }
      if($request->tipoprograma_id) {
        $query->where('tipoprograma_id', $request->tipoprograma_id);
      }
      if($request->ecClave) {
        $query->where('ecClave', $request->ecClave);
      }
      if($request->ecNombre) {
        $query->where('ecNombre', 'like', '%'.$request->ecNombre.'%');
      }
      if($request->ecFechaRegistro) {
        $query->where('ecFechaRegistro', $request->ecFechaRegistro);
      }
      if($request->ecCoordinador_empleado_id) {
        $query->where('ecCoordinador_empleado_id', $request->ecCoordinador_empleado_id);
      }
      if($request->ecInstructor1_empleado_id) {
        $query->where('ecInstructor1_empleado_id', $request->ecInstructor1_empleado_id);
      }
      if($request->ecInstructor2_empleado_id) {
        $query->where('ecInstructor2_empleado_id', $request->ecInstructor2_empleado_id);
      }
      if($request->ecEstado) {
        $query->where('ecEstado', $request->ecEstado);
      }
    })->get();
  } # buscarProgramas

}
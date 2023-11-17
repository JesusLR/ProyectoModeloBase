<?php

namespace App\Http\Controllers\EducacionContinua\Reportes;

use DB;
use PDF;
use Carbon\Carbon;
use App\Http\Models\Aula;
use App\Http\Models\Pago;
use App\Http\Helpers\Utils;
use App\Http\Helpers\UltimaFechaPago;
use Illuminate\Http\Request;
use App\Http\Models\Empleado;

use App\Http\Models\Ubicacion;
use App\Http\Models\TiposPrograma;
use App\Http\Controllers\Controller;
use App\Http\Models\InscritosEduCont;
use App\Http\Models\EducacionContinua;
use RealRashid\SweetAlert\Facades\Alert;

class RelAluProgEduconController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:rel_alu_prog_edu_continua');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    $tiposPrograma = TiposPrograma::get();
    $empleados = Empleado::where("empEstado", "=", "A")->get();

    return View('educacion_continua/reportes.alumnos.create', [
      'tiposPrograma' => $tiposPrograma,
      'empleados'     => $empleados
    ]);
  }
  

  public function imprimir(Request $request)
  {
    $programasEduContinua = EducacionContinua::with(["tipoprograma", 'inscritos', 'periodo'])
    ->whereHas('periodo', function($query) use($request) {
      if($request->perNumero)
        $query->where('perNumero',$request->perNumero);
      if($request->perAnio)
        $query->where('perAnio',$request->perAnio);
    })

    ->whereHas('ubicacion', function($query) use($request) {
      if($request->ubiClave){
        $query->where('ubiClave',$request->ubiClave);
      }
    })
    ->whereHas('escuela', function($query) use($request) {
      if($request->escClave){
        $query->where('escClave',$request->escClave);
      }
    })
    ->where(static function($query) use ($request) {
      if($request->progId)
        $query->where('id', $request->progId);
      if($request->ecClave)
        $query->where('ecClave', $request->ecClave);
      if($request->tipoprograma_id)
        $query->where('tipoprograma_id', $request->tipoprograma_id);
      if ($request->ecNombre)
        $query->where("ecNombre", "like", "%{$request->ecNombre}%");
      if ($request->ecFechaRegistro)
        $query->where("ecFechaRegistro", $request->ecFechaRegistro);
      if ($request->ecCoordinador_empleado_id)
        $query->where("ecCoordinador_empleado_id", $request->ecCoordinador_empleado_id);
      if ($request->ecInstructor1_empleado_id)
        $query->where("ecInstructor1_empleado_id", $request->ecInstructor1_empleado_id);
      if ($request->ecInstructor2_empleado_id)
        $query->where("ecInstructor2_empleado_id", $request->ecInstructor2_empleado_id);
      if ($request->ecEstado)
        $query->where("ecEstado", $request->ecEstado);
    })
    ->whereHas('inscritos.alumno.persona', static function($query) use ($request) {
      if ($request->aluClave)
        $query->where('aluClave',$request->aluClave);
      if ($request->nombreAlumno)
        $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"]);
    })
    ->get()
    ->each(static function($programa) {
      $programa->ecFechaRegistro = Utils::fecha_string($programa->ecFechaRegistro, 'mesCorto');
      $programa->perFechaInicial = Utils::fecha_string($programa->periodo->perFechaInicial, 'mesCorto');
      $programa->perFechaFinal = Utils::fecha_string($programa->periodo->perFechaFinal, 'mesCorto');
    });

    if($programasEduContinua->isEmpty()) {
      alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada', 'warning')->showConfirmButton();
      return back()->withInput();
    }
    
    $registroUltimoPago = UltimaFechaPago::ultimoPago();
    $fechaActual = Carbon::now('America/Merida');
    $nombreArchivo = 'pdf_rel_aluprog_continua';

    return PDF::loadView('educacion_continua.pdf.'. $nombreArchivo, [
      "programasEduContinua" => $programasEduContinua,
      "registroUltimoPago" => $registroUltimoPago,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "nombreArchivo" => $nombreArchivo,
      "perAnio" => $request->perAnio
    ])->stream($nombreArchivo . '.pdf');
  }
}
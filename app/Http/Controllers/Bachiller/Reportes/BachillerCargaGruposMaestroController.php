<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Grupo;
use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Empleado;
use App\Http\Models\Escuela;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use App\Http\Models\Bachiller\Bachiller_empleados;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerCargaGruposMaestroController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }


  public function reporte()
  {
    // Mostrar el conmbo solo las ubicaciones correspondientes 
    if(auth()->user()->campus_cme == 1 || auth()->user()->campus_cva == 1){
      $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();
    }

    if(auth()->user()->campus_cch == 1){
        $ubicaciones = Ubicacion::where('id', 3)->get();
    }
    return view('bachiller.reportes.carga_grupos_maestro.create', [
      'ubicaciones' => $ubicaciones
    ]);
  }

  public function imprimir(Request $request){

    $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;
    $escClave = $request->escuela_id ? Escuela::findOrFail($request->escuela_id)->escClave : null;

    if($request->ubicacion_id == 1 || $request->ubicacion_id == 2){
      $resultado = DB::select('call procBachillerCargaGrupoMaestroSumaYucatan('.
      $periodo->perNumero.','.
      $periodo->perAnio.',"'.
      $ubicacion->ubiClave.'","'.
      $departamento->depClave.'","'.
      $escClave.'","'.
      $request->empleado_id.'")');
    }

    if($request->ubicacion_id == 3){
      $resultado = DB::select('call procBachillerCargaGrupoMaestroSumaChetumal('.
      $periodo->perNumero.','.
      $periodo->perAnio.',"'.
      $ubicacion->ubiClave.'","'.
      $departamento->depClave.'","'.
      $escClave.'","'.
      $request->empleado_id.'")');
    }
    

    $datosEmpleado = collect();

    for($i = 0;$i < count($resultado); $i++){

        $hrsNoDoc = $resultado[$i]->hrsNoDoc;
        $hrsGrupo = $resultado[$i]->hrsGrupo;
      
        $progClave = $resultado[$i]->progClave;
        $planClave = $resultado[$i]->planClave;
        $matClave = $resultado[$i]->matClave;
        $gpoClave = $resultado[$i]->gpoClave;
        $inscritos_gpo = $resultado[$i]->inscritos_gpo;
        $matNombre = $resultado[$i]->matNombre;
        $hrsContrato = $resultado[$i]->hrsContrato;
        $empleado_id = $resultado[$i]->empleado_id;

        $datosEmpleado->push([
          'progClave'=>$progClave,
          'planClave'=>$planClave,
          'matClave'=>$matClave,
          'gpoClave'=>$gpoClave,
          'hrsGrupo'=>$hrsGrupo,
          'hrsNoDoc'=>$hrsNoDoc,
          'inscritos_gpo'=>$inscritos_gpo,
          'matNombre'=>$matNombre,
          'hrsContrato'=>$hrsContrato,
          'empleado_id'=>$empleado_id
        ]);

    }

    $empleados = Bachiller_empleados::whereIn('id', $datosEmpleado->pluck('empleado_id'))->get()->keyBy('id');
    $datos = $datosEmpleado->groupBy('empleado_id')
    ->map(static function($materias_empleado, $empleado_id) use ($empleados) {
      $empleado = $empleados->pull($empleado_id);
      $totalHorasDocentes = $materias_empleado->sum('hrsGrupo');
      $infoMaestro = [
        'gruposTotales' => $materias_empleado->count(),
        'alumnosTotales' => $materias_empleado->sum('inscritos_gpo'),
        'totalHorasDocentes' => $totalHorasDocentes,
        'totalHoras' => $totalHorasDocentes + $materias_empleado->first()['hrsNoDoc'],
        'nombreCompleto' => MetodosPersonas::BachillerNombreCompleto($empleado, true),
      ];

      return $materias_empleado->map(static function($materia, $key) use ($empleado, $infoMaestro) {
        return collect($materia)->merge($infoMaestro);
      });
      #flatten en este caso, deshace el groupBy por empleado_id para poder ordenar por nombreCompleto.
    })->flatten(1)->sortBy('nombreCompleto')->groupBy('nombreCompleto');

    $perFechas = Utils::fecha_string($periodo->perFechaInicial,true).' - '.Utils::fecha_string($periodo->perFechaFinal,true).' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';

    $fechaActual = Carbon::now('America/Merida'); 
    $tipoReporte = $request->tipoReporte == 'detalle' ? true : false;
    $nombreArchivo = 'pdf_carga_grupos_maestro';
      $pdf = PDF::loadView('reportes.pdf.bachiller.carga_grupos_maestro.'. $nombreArchivo, [
        
        "datos" => $datos,
        "nombreArchivo" => $nombreArchivo,
        "ubicacion" => $ubicacion,
        "periodo" => $perFechas,
        "tipoReporte" => $tipoReporte,
        "fechaActual" => Utils::fecha_string($fechaActual,true),
        "horaActual" => $fechaActual->format('H:i:s')
        
      ]);
  
      return $pdf->stream($nombreArchivo.'.pdf');
  }
}
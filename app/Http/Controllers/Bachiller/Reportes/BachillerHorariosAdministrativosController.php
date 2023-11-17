<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_horariosadmivos;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class BachillerHorariosAdministrativosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function reporte()
    {
        return view('bachiller.reportes.horarios_administrativos.create', [
            'ubicaciones' => Ubicacion::whereIn('id', [1, 2])->get()
        ]);
    }

    public function imprimir(Request $request)
    {
        $horarios_admin = Bachiller_horariosadmivos::select('bachiller_empleados.id as empleado_id')
        ->join('periodos', 'bachiller_horariosadmivos.periodo_id', '=', 'periodos.id')
        ->join('bachiller_empleados', 'bachiller_horariosadmivos.empleado_id', '=', 'bachiller_empleados.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('escuelas', 'bachiller_empleados.escuela_id', '=', 'escuelas.id')
        ->where('departamentos.id', $request->departamento_id)
        ->where('periodos.id', $request->periodo_id)
        ->where(static function ($query) use ($request) {

            if ($request->empleado_id) {
                $query->where('bachiller_empleados.id', $request->empleado_id);
            }

            if ($request->escuela_id) {
                $query->where('escuelas.id', $request->escuela_id);
            }
        })
        ->whereNull('bachiller_horariosadmivos.deleted_at')
        ->whereNull('periodos.deleted_at')
        ->whereNull('bachiller_empleados.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->distinct()->get();

        if (count($horarios_admin) < 1) {
            alert()->warning('Sin coincidencias', 'No hay datos capturados. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $periodo = Periodo::find($request->periodo_id);
        $ciclo_escolar = Utils::fecha_string($periodo->perFechaInicial, 'fechaCorta').'-'.Utils::fecha_string($periodo->perFechaFinal, 'fechaCorta');

        $departamento = Departamento::find($request->departamento_id);
        $depar = $departamento->depClave.'-'.$departamento->depNombre;

        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $ubic = $ubicacion->ubiClave.'-'.$ubicacion->ubiNombre;

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $parametro_NombreArchivo = "pdf_horarios_administrativos2";
        // view('reportes.pdf.bachiller.horarios_administrativos.pdf_horarios_administrativos')
        $pdf = PDF::loadView('reportes.pdf.bachiller.horarios_administrativos.' . $parametro_NombreArchivo, [
            'ciclo_escolar' => $ciclo_escolar,
            'depar' => $depar,
            'ubic' => $ubic,
            'periodo_id' => $periodo->id,
            'horarios_admin' => $horarios_admin,
            'fechaActual' => $fechaActual->format('d/m/Y'),
            'horaActual' => $fechaActual->format('h:i:s')
        ]);

        return $pdf->stream('Horarios_administrativos_'.$periodo->perNumero.'-'.$periodo->perAnio.'.pdf');
        return $pdf->download('Horarios_administrativos_'.$periodo->perNumero.'-'.$periodo->perAnio.'.pdf');



    }

  
}

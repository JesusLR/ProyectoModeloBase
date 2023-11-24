<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Ubicacion;
use App\Models\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerCalificacionFinalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reporte()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes 
        if(auth()->user()->campus_cme == 1 || auth()->user()->campus_cva == 1){
            $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();
        }

        if(auth()->user()->campus_cch == 1){
            $ubicaciones = Ubicacion::where('id', 3)->get();
        }

        return view('bachiller.reportes.calificacion_final.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {

        // Para obtener las fechas del periodo seleccionado 
        $periodo = Periodo::findOrFail($request->periodo_id);
        $perFechaInicialMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaInicial)->format('m'));
        $perFechaFinalMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaFinal)->format('m'));
        $cicloEscolar = $perFechaInicialMes.'/'.\Carbon\Carbon::parse($periodo->perFechaInicial)->format('Y').'-'.$perFechaFinalMes.'/'.\Carbon\Carbon::parse($periodo->perFechaFinal)->format('Y');

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $mesCorto = Utils::num_meses_corto_string($fechaActual->format('m'));
        $fechaHoy = $fechaActual->format('d').'/'.$mesCorto.'/'.$fechaActual->format('Y');


        if ($request->aluClave != "") {
            // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);
            
            $resultado_array =  DB::select("call procBachillerCalificacionesAlumnoYucatan(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ",
            " . $request->aluClave . ")");
            $resultado_collection = collect($resultado_array);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $parametro_NombreArchivo = "pdf_calificacion_final_alumno";
            $pdf = PDF::loadView('reportes.pdf.bachiller.calificacion_final.' . $parametro_NombreArchivo, [
                "fechaActual" => $fechaHoy,
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "alumno" => $resultado_collection
            ]);



            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
            // $resultado_registro = $resultado_array[0];
            // $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
        }

        if ($request->aluClave == "") {
            // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);
            
            $resultado_array =  DB::select("call procBachillerAvanceCalificacionesGradoGrupoYucatan(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ",
            '" . $request->gpoClave . "')");
            $resultado_collection = collect($resultado_array);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');

            $parametro_NombreArchivo = "pdf_calificacion_final_grupo";
            // view('reportes.pdf.bachiller.calificacion_final.pdf_calificacion_final_grupo');
            $pdf = PDF::loadView('reportes.pdf.bachiller.calificacion_final.' . $parametro_NombreArchivo, [
                "fechaActual" => $fechaHoy,
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "alumno" => $resultado_collection,
                "alumnoAgrupado" => $alumnoAgrupado
            ]);



            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
            // $resultado_registro = $resultado_array[0];
            // $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
        }


        
    }

}

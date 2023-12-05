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

class BachillerHorarioDeClasesAlumnoController extends Controller
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
        $ubicaciones = Ubicacion::whereIn('id', [1,2,3])->get();

        return view('bachiller.reportes.horario_de_clases_alumno.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        // dd($request->plan_id, $request->programa_id, $request->periodo_id, $request->gpoGrado, $request->gpoClave, $request->aluClave);     


        // Para obtener las fechas del periodo seleccionado 
        $periodo = Periodo::findOrFail($request->periodo_id);
        $perFechaInicialMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaInicial)->format('m'));
        $perFechaFinalMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaFinal)->format('m'));
        $cicloEscolar = \Carbon\Carbon::parse($periodo->perFechaInicial)->format('d').'/'.$perFechaInicialMes.'/'.\Carbon\Carbon::parse($periodo->perFechaInicial)->format('Y').' - '.\Carbon\Carbon::parse($periodo->perFechaInicial)->format('d').'/'.$perFechaFinalMes.'/'.\Carbon\Carbon::parse($periodo->perFechaFinal)->format('Y');

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $mesCorto = Utils::num_meses_corto_string($fechaActual->format('m'));
        $fechaHoy = $fechaActual->format('d').'/'.$mesCorto.'/'.$fechaActual->format('Y');


        // buscar por alumno 
        if ($request->aluClave != "") {
            // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);
        
            $llamar_sp = DB::select("call procBachillerAppHorariosAlumnoYucatan(".$request->programa_id.",
            ".$request->plan_id.",
            ".$request->periodo_id.",
            ".$request->gpoGrado.",
            ".$request->aluClave.")");
            $resultado_collection = collect($llamar_sp);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay horario disponible para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $parametro_NombreArchivo = "pdf_horario_alumno_nuevo";
            // view('reportes.pdf.bachiller.horario_de_clases_alumno.pdf_horario_alumno');
            $pdf = PDF::loadView('reportes.pdf.bachiller.horario_de_clases_alumno.' . $parametro_NombreArchivo, [
                "fechaActual" => $fechaHoy,
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "alumno" => $resultado_collection
            ]);



            // $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream('horario de clases.pdf');
            return $pdf->download('horario de clases.pdf');
        }

        // buscar por grado y grupo 
        if($request->gpoClave != ""){
            
            $llamar_sp = DB::select("call procBachillerAppHorariosGrupoYucatan(".$request->programa_id.",
            ".$request->plan_id.",
            ".$request->periodo_id.",
            ".$request->gpoGrado.",
            '".$request->gpoClave."')");
            $resultado_collection = collect($llamar_sp);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay horario disponible para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $agrupamos_datos_por_alumno = $resultado_collection->groupBy('aluClave');

            $parametro_NombreArchivo = "pdf_horario_grado_grupo_nuevo";
            // view('reportes.pdf.bachiller.horario_de_clases_alumno.pdf_horario_grado_grupo');
            $pdf = PDF::loadView('reportes.pdf.bachiller.horario_de_clases_alumno.' . $parametro_NombreArchivo, [
                "fechaActual" => $fechaHoy,
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "alumnoClave" => $agrupamos_datos_por_alumno,
                "alumno" => $resultado_collection
            ]);



            // $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream('horario de clases.pdf');
            return $pdf->download('horario de clases.pdf');
        }

        // buscar por solo grado 
        if($request->gpoClave == "" && $request->aluClave == ""){
            
            $llamar_sp = DB::select("call procBachillerAppHorariosGradoYucatan(".$request->programa_id.",
            ".$request->plan_id.",
            ".$request->periodo_id.",
            ".$request->gpoGrado.")");
            $resultado_collection = collect($llamar_sp);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay horario disponible para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $agrupamos_datos_por_alumno = $resultado_collection->groupBy('aluClave');

            $parametro_NombreArchivo = "pdf_horario_grado_grupo";
            // view('reportes.pdf.bachiller.horario_de_clases_alumno.pdf_horario_alumno');
            $pdf = PDF::loadView('reportes.pdf.bachiller.horario_de_clases_alumno.' . $parametro_NombreArchivo, [
                "fechaActual" => $fechaHoy,
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "alumnoClave" => $agrupamos_datos_por_alumno,
                "alumno" => $resultado_collection
            ]);



            // $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream('horario de clases.pdf');
            return $pdf->download('horario de clases.pdf');
        }
       
        
    }

}

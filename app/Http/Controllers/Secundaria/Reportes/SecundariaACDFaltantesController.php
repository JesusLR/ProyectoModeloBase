<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaACDFaltantesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

        $perActual = Auth::user()->empleado->escuela->departamento->perActual;

        return view('secundaria.reportes.no_inscritos_acd.create', [
            "ubicaciones" => $ubicaciones,
            "ubicacion_id" => $ubicacion_id,
            "perActual" => $perActual
        ]); 
    }


    public function imprimir(Request $request)
    {

        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $periodo = Periodo::find($request->periodo_id);

        $SP_llamar = DB::select("call procSecundariaResumenGpoACD(
            '".$ubicacion->ubiClave."',
            ".$periodo->perAnio.",
            '".$request->cgtGradoSemestre."',
            '".$request->cgtGrupo."',
            '".$request->aluClave."',
            '".$request->perApellido1."',
            '".$request->perApellido2."',
            '".$request->perNombre."'
        )");
        

        if (count(collect($SP_llamar)) < 1) {
            alert()->warning('Upss', 'No sean encontrado resultados.')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $parametro_NombreArchivo = "pdf_no_inscritos_acd";
        // view('reportes.pdf.secundaria.no_inscritos_acd.pdf_no_inscritos_acd')
        
        $pdf = PDF::loadView('reportes.pdf.secundaria.no_inscritos_acd.' . $parametro_NombreArchivo, [
            "cicloEscolar" => Utils::fecha_string($periodo->perFechaInicial, 'fechaCorta') . '-' . Utils::fecha_string($periodo->perFechaFinal, 'fechaCorta'),
            "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'fechaCorta'),
            "horaActual" => $fechaActual->format('h:i:s'),
            "alumnos" => $SP_llamar,
            "departamento" => Departamento::find($request->departamento_id),
            "ubicacion" => $ubicacion,
            "plan" => Plan::find($request->plan_id),
            "escuela" => Escuela::find($request->escuela_id)
        ]);

        return $pdf->stream('alumnos con acd faltantes.pdf');
        return $pdf->download('alumnos con acd faltantes.pdf');

       
    }
}

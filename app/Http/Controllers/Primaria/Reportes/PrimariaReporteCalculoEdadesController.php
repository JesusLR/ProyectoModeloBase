<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaReporteCalculoEdadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $ubicaciones = Ubicacion::sedes()->get();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();

        return view('primaria.reportes.lista_de_edades.index', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        $periodo_id = $request->periodo_id;
        $plan_id = $request->plan_id;
        $programa_id = $request->programa_id;
        $gpoGrado = $request->gpoGrado;
        $gpoClave = $request->gpoClave;
        $fechaCalcular = $request->fechaCalcular;
        $aluClave = $request->aluClave;

        // Buscar un solo alumno 
        if ($aluClave != "") {
            // llamada al SP 
            $resultado_array =  DB::select("call procPrimariaListaCalculoEdadesUnSoloAlumno(" . $periodo_id . ", 
                " . $gpoGrado . ",
                '" . $gpoClave . "',
                " . $programa_id . ",
                " . $plan_id . ",
                '" . $fechaCalcular . "',
                ".$aluClave.")");
            $resultado_collection = collect($resultado_array);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay información capturada con los datos proporcionados.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            
        } else {
            // llamada al SP 
            $resultado_array =  DB::select("call procPrimariaListaCalculoEdades(" . $periodo_id . ", 
        " . $gpoGrado . ",
        '" . $gpoClave . "',
        " . $programa_id . ",
        " . $plan_id . ",
        '" . $fechaCalcular . "')");
            $resultado_collection = collect($resultado_array);


            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay información capturada con los datos proporcionados.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
        }



        $parametro_NombreArchivo = "pdf_primaria_lista_edad";
        $pdf = PDF::loadView('reportes.pdf.primaria.lista_de_edades.' . $parametro_NombreArchivo, [
            "alumnos" => $resultado_collection,
            "fechaActual" => $fechaActual->format('d-m-Y'),
            "horaActual" => $fechaActual->format('H:i')

        ]);

        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

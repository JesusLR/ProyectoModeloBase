<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Periodo;
use App\Http\Models\Secundaria\Secundaria_grupos;
use App\Http\Models\Secundaria\Secundaria_materias;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaAlumnosIncritosDosACDController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.reportes.alumnosIncritosACD.create', [
            'ubicaciones' => $ubicaciones
        ]);
        
    }

    public function getGrupoACDFiltro(Request $request, $plan_id, $periodo_id, $grado)
    {
        if($request->ajax()){

            // SELECCIONAMOS TODOS LOS GRUPOS ACD
            $grupos = DB::select("SELECT secundaria_grupos.secundaria_materia_id, 
            secundaria_materias.matClave, 
            secundaria_materias.matNombre, 
            secundaria_grupos.gpoGrado
            FROM secundaria_grupos as secundaria_grupos
            INNER JOIN secundaria_materias as secundaria_materias on secundaria_materias.id = secundaria_grupos.secundaria_materia_id
            INNER JOIN periodos as periodos on periodos.id = secundaria_grupos.periodo_id
            WHERE secundaria_grupos.plan_id=$plan_id
            AND secundaria_grupos.periodo_id = $periodo_id
            AND secundaria_grupos.gpoGrado=$grado
            AND secundaria_grupos.gpoACD=1
            AND secundaria_materias.matVigentePlanPeriodoActual = 'SI'
            GROUP BY secundaria_grupos.secundaria_materia_id");



            return response()->json($grupos);
        }
    }


    public function imprimir(Request $request)
    {
        $plan_id = $request->plan_id;
        $periodo_id = $request->periodo_id;
        $gpoGrado = $request->gpoGrado;
        $materia_id = $request->materiaACD_id;


        $materia = Secundaria_materias::where('id', $materia_id)->first();



        $resultado_array =  DB::select("call procSecundariaListaAlumnos_DuplicadoACD(" . $plan_id . ", 
                " . $periodo_id . ",
                " . $materia_id . ",
                " . $gpoGrado . ")");
        $resultado_collection = collect($resultado_array);

        if ($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay datos relacionados a su busqueda')->showConfirmButton();
            return back()->withInput();
        }




        $fechaActual = Carbon::now('America/Merida');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $parametro_NombreArchivo = 'pdf_secundaria_lista_de_alumnos_inscritos_dos_acd';
        $pdf = PDF::loadView('reportes.pdf.secundaria.alumnosInscritosDosoMasACD.' . $parametro_NombreArchivo, [
            "alumnos" => $resultado_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "materia" => $materia,
        ]);


        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');

    }
}

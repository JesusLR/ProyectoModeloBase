<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Conceptoscursoestado;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaBoletaDeCalificacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporteBoleta()
    {
        // $ubicaciones = Ubicacion::sedes()->get();
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->sedes()->get();


        return view('primaria.reportes.boleta_de_calificaciones.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function boletadesdecurso(Request $request)
    {

        $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";

        $mostrar_observaciones = $request->mes_id;

        $periodoEscolar = Periodo::where('id', $request->periodo_id)->first();

        if ($periodoEscolar->perAnioPago >= 2021) {

            // busca cuando se proporciona grado y grupo 
            if ($request->gpoClave != "") {

                $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesGradoGrupo(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ",
            '" . $request->gpoClave . "')");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }
                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
                $resultado_registro = $resultado_array[0];
                $depClaveOficial = $resultado_registro->depClaveOficial;
            }

            // buscar por solo grado 
            if ($request->gpoClave == "" && $request->aluClave == "") {


                $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesGradoCompleto(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ")");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grado. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }
                $resultado_registro = $resultado_array[0];
                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');

                $depClaveOficial = $resultado_registro->depClaveOficial;
            }

            if ($request->aluClave != "") {
                $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesAlumno(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ",
            " . $request->aluClave . ")");
                 $resultado_collection = collect($resultado_array);

                //  dd($request->programa_id, $request->plan_id, $request->periodo_id);

                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }
                $resultado_registro = $resultado_array[0];
                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
                $depClaveOficial = $resultado_registro->depClaveOficial;
            }


            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $parametro_tipo = $resultado_registro->carrera; //PRB

            if($resultado_registro->ubicacion == "CME"){
                $campus = "primariaCME";
            }else{
                $campus = "primariaCVA";
            }
            

            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $parametro_NombreArchivo = 'pdf_primaria_boleta_calificaciones_general_grado_grupo_2022';
            // view('reportes.pdf.primaria.boleta_de_calificaciones.pdf_primaria_boleta_calificaciones_general_grado_grupo_2022');
            $pdf = PDF::loadView('reportes.pdf.primaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "titulo" => $parametro_Titulo,
                "alumnoAgrupado" => $alumnoAgrupado,
                "observaciones" => $mostrar_observaciones,
                "parametro_tipo" => $parametro_tipo,
                "depClaveOficial" => $depClaveOficial,
                "campus" => $campus
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        } else {
            // busca cuando se proporciona grado y grupo 
            if ($request->gpoClave != "") {

                $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesGradoGrupo(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ",
            '" . $request->gpoClave . "')");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }
                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
                $resultado_registro = $resultado_array[0];
            }

            // buscar por solo grado 
            if ($request->gpoClave == "" && $request->aluClave == "") {


                $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesGradoCompleto(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ")");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grado. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }
                $resultado_registro = $resultado_array[0];
                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
            }

            if ($request->aluClave != "") {
                $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesAlumno(" . $request->programa_id . ", 
            " . $request->plan_id . ",
            " . $request->periodo_id . ",
            " . $request->gpoGrado . ",
            " . $request->aluClave . ")");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }
                $resultado_registro = $resultado_array[0];
                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
            }


            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $parametro_tipo = $resultado_registro->carrera; //PRB


            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $parametro_NombreArchivo = 'pdf_primaria_boleta_calificaciones_general_grado_grupo';
            $pdf = PDF::loadView('reportes.pdf.primaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "titulo" => $parametro_Titulo,
                "alumnoAgrupado" => $alumnoAgrupado,
                "observaciones" => $mostrar_observaciones
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }

  
}

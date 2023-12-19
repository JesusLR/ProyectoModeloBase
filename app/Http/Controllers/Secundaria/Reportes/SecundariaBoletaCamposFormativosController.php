<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Periodo;
use App\Models\Secundaria\Secundaria_porcentajes;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaBoletaCamposFormativosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporteBoleta()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();

        return view('secundaria.reportes.boleta_campos_formativos.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function boletadesdecurso(Request $request)
    {

        $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";

        $mostrar_observaciones = $request->mes_id;

        $departamento_id = $request->departamento_id;
        $programa_id = $request->programa_id;
        $periodo_id = $request->periodo_id;
        $plan_id = $request->plan_id;
        $gpoGrado = $request->gpoGrado;
        $gpoClave = $request->gpoClave;

        $periodoEscolar = Periodo::where('id', $periodo_id)->first();
        // dd($programa_id, $periodo_id, $plan_id);
        // para periodos del 2021 en adelante llamar los siguientes metodos
        if ($periodoEscolar->perAnioPago >= 2021) {

            // obtener los porcentajes
            $secundaria_porcentajes = Secundaria_porcentajes::where('departamento_id', '=', $departamento_id)
            ->where('periodo_id', '=', $periodo_id)
            ->whereNull('deleted_at')
            ->first();


            // busca cuando se proporciona grado y grupo
            if ($request->gpoClave != "") {

                //dd($request->programa_id, $request->plan_id , $request->periodo_id , $request->gpoGrado, $request->gpoClave);

                $resultado_array =  DB::select("call procSecundariaCalificacionesGradoGrupo(" . $programa_id . ",
                " . $plan_id . ",
                " . $periodo_id . ",
                " . $gpoGrado . ",
                '" . $gpoClave . "')");
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


                $resultado_array =  DB::select("call procSecundariaCalificacionesGradoCompleto(" . $request->programa_id . ",
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
                // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);

                // dd(" . $request->programa_id . ",
                // " . $request->plan_id . ",
                // " . $request->periodo_id . ",
                // " . $request->gpoGrado . ",
                // " . $request->aluClave . ");

                $resultado_array =  DB::select("call procSecundariaCalificacionesAlumno(" . $request->programa_id . ",
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

            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $parametro_NombreArchivo = 'pdf_secundaria_boleta_calificaciones_general_grado_grupo_2022';

            $ubicacion = $resultado_collection[0]->ubicacion;

            if($ubicacion == "CME"){
                $campus = "CampusCME";
            }else{
                $campus = "CampusCVA";
            }

            // view('reportes.pdf.secundaria.boleta_campos_formativos.pdf_secundaria_boleta_calificaciones_general_grado_grupo_2022')
            $pdf = PDF::loadView('reportes.pdf.secundaria.boleta_campos_formativos.' . $parametro_NombreArchivo, [
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "titulo" => $parametro_Titulo,
                "alumnoAgrupado" => $alumnoAgrupado,
                "observaciones" => $mostrar_observaciones,
                "secundaria_porcentajes" => $secundaria_porcentajes,
                "campus" => $campus
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        } else { //para periodos menores o igual al 2020


            // busca cuando se proporciona grado y grupo
            if ($request->gpoClave != "") {

                //dd($request->programa_id, $request->plan_id , $request->periodo_id , $request->gpoGrado, $request->gpoClave);

                $resultado_array =  DB::select("call procSecundariaCalificacionesGradoGrupo(" . $request->programa_id . ",
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


                $resultado_array =  DB::select("call procSecundariaCalificacionesGradoCompleto(" . $request->programa_id . ",
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
                $resultado_array =  DB::select("call procSecundariaCalificacionesAlumno(" . $request->programa_id . ",
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

            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $parametro_NombreArchivo = 'pdf_secundaria_boleta_calificaciones_general_grado_grupo';
            // view('reportes.pdf.secundaria.boleta_de_calificaciones.pdf_secundaria_boleta_calificaciones_general_grado_grupo');
            $pdf = PDF::loadView('reportes.pdf.secundaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
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

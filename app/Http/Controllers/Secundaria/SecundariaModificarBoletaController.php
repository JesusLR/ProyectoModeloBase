<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Secundaria\Secundaria_mes_evaluaciones;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SecundariaModificarBoletaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function modificar()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $departamento_id = Auth::user()->empleado->escuela->departamento->id;


        $secundaria_mes_evaluaciones = Secundaria_mes_evaluaciones::where('departamento_id', $departamento_id)
            ->whereNotIn('id', [4, 14])
            ->orderBy('id', 'ASC')
            ->get();

        return view('secundaria.modificarBoleta.modificar', [
            'ubicaciones' => $ubicaciones,
            'secundaria_mes_evaluaciones' => $secundaria_mes_evaluaciones
        ]);
    }

    public function modificarpost(Request $request)
    {
        // dd($request->periodo_id,
        // $request->plan_id,
        // $request->programa_id,
        // $request->aluClave,
        // $request->secundaria_mes_evaluacione_id);

        $periodo_id = $request->input("periodo_id");
        $plan_id = $request->input("plan_id");
        $programa_id = $request->input("programa_id");
        $gpoGrado = $request->input("gpoGrado");
        $aluClave = $request->input("aluClave");
        $secundaria_mes_evaluacione_id = $request->input("secundaria_mes_evaluacione_id");

        $secundaria_mes_evaluaciones = Secundaria_mes_evaluaciones::where('id', $secundaria_mes_evaluacione_id)->first();

        $llamar_sp = DB::select("call procSecundariaModificarCalificacionesAlumno(
            " . $periodo_id . ",
            " . $plan_id . ",
            " . $programa_id . ",
            " . $gpoGrado . ",
            " . $aluClave . ",
            " . $secundaria_mes_evaluacione_id . "
        )");

        $datos_collection = collect($llamar_sp);

        return response()->json([
            "calificaciones" => $datos_collection,
            "secundaria_mes_evaluaciones" => $secundaria_mes_evaluaciones
        ]);
    }

    public function actualizar_calificaciones(Request $request)
    {
        $secundaria_calificacion_id = $request->input("secundaria_calificacion_id");
        $calificacion_alumno = $request->input("calificacion_alumno");
        $secundaria_inscrito_id = $request->input("secundaria_inscrito_id");
        $mes_calificacion = $request->input("mes_calificacion");

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $fechaHoy = $fechaActual->format('Y-m-d H:i:s');

        for ($i = 0; $i < count($secundaria_calificacion_id); $i++) {


            DB::table('secundaria_calificaciones')
                ->where('id', $secundaria_calificacion_id[$i])
                ->update([
                    'calificacion_evidencia1' => $calificacion_alumno[$i],                    
                    'promedio_mes' => $calificacion_alumno[$i],
                    'updated_at' => $fechaHoy,
                    'usuario_at' => auth()->user()->id

                ]);


            // SEPTIEMBRE
            if ($mes_calificacion == "SEPTIEMBRE") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionSep' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //OCTUBRE
            if ($mes_calificacion == "OCTUBRE") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionOct' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //NOVIEMBRE
            if ($mes_calificacion == "NOVIEMBRE") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionNov' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //DICIEMBRE
            if ($mes_calificacion == "DICIEMBRE") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionDic' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //ENERO
            if ($mes_calificacion == "ENERO") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionEne' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //FEBRERO
            if ($mes_calificacion == "FEBRERO") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionFeb' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //MARZO
            if ($mes_calificacion == "MARZO") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionMar' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //ABRIL
            if ($mes_calificacion == "ABRIL") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionAbr' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //MAYO
            if ($mes_calificacion == "MAYO") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionMay' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }

            //JUNIO
            if ($mes_calificacion == "JUNIO") {
                DB::table('secundaria_inscritos')
                    ->where('id', $secundaria_inscrito_id[$i])
                    ->update([
                        'inscCalificacionJun' => $calificacion_alumno[$i],
                        'updated_at' => $fechaHoy,
                        'usuario_at' => auth()->user()->id
                    ]);
            }
        }

        return response()->json([
            "response" => "true"
        ]);
    }
}

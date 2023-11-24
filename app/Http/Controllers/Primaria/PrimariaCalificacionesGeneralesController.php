<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrimariaCalificacionesGeneralesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function viewCalificacionGeneral()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('primaria.calificaciones.calificaciones_generales', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getAlumnosCalificaciones(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);

            $gruposClave = Curso::select(
                'cursos.id as curso_id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'periodos.id as periodo_id',
                'planes.id as plan_id',
                'programas.id as programa_id',
                'alumnos.id as alumno_id',
                'alumnos.aluClave',
                'personas.id as persona_id',
                'personas.perApellido1 as apellido_paterno',
                'personas.perApellido2 as apellido_materno',
                'personas.perNombre as nombres')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->where('departamentos.depClave', 'PRI')
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.id', $cgt->id)
            ->whereIn('cursos.curEstado', ['R', 'A', 'C', 'P'])
            ->orderBy('personas.perApellido1', 'asc')
            ->get();


            return response()->json($gruposClave);
        }
    }

    public function obtenerListaMateriaCalificaciones(Request $request, $curso_id)
    {
        if($request->ajax()){
            $resultado_array =  DB::select("SELECT 
            pi.id,
            pi.inscCalificacionSep,
            pi.inscCalificacionOct,
            pi.inscCalificacionNov,
            pi.inscCalificacionDic,
            pi.inscCalificacionEne,
            pi.inscCalificacionFeb,
            pi.inscCalificacionMar,
            pi.inscCalificacionAbr,
            pi.inscCalificacionMay,
            pi.inscCalificacionJun,
            pm.matClave,
            pm.matNombre,
            pma.matClaveAsignatura,
            pma.matNombreAsignatura
            FROM primaria_inscritos AS pi
            INNER JOIN cursos as c on c.id = pi.curso_id
            INNER JOIN primaria_grupos as pg on pg.id = pi.primaria_grupo_id
            INNER JOIN primaria_materias as pm on pm.id = pg.primaria_materia_id
            LEFT JOIN primaria_materias_asignaturas as pma on pma.id = pg.primaria_materia_asignatura_id
            WHERE curso_id=$curso_id
            ORDER BY pm.matOrdenVisual ASC");
            $resultado_collection = collect($resultado_array);

            return response()->json($resultado_collection);

        }
    }

    public function guardarCalificaciones(Request $request)
    {
        if($request->ajax()){
            $primaria_inscrito_id = $request->primaria_inscrito_id;
            $inscCalificacionSep = $request->inscCalificacionSep;
            $inscCalificacionOct = $request->inscCalificacionOct;
            $inscCalificacionNov = $request->inscCalificacionNov;
            $inscCalificacionDic = $request->inscCalificacionDic;
            $inscCalificacionEne = $request->inscCalificacionEne;
            $inscCalificacionFeb = $request->inscCalificacionFeb;
            $inscCalificacionMar = $request->inscCalificacionMar;
            $inscCalificacionAbr = $request->inscCalificacionAbr;
            $inscCalificacionMay = $request->inscCalificacionMay;
            $inscCalificacionJun = $request->inscCalificacionJun;
            $fechaActual = Carbon::now('America/Merida');
    
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            for ($i=0; $i < count($primaria_inscrito_id); $i++) { 
                DB::table('primaria_inscritos')
                ->where('id', $primaria_inscrito_id[$i])
                    ->update([
    
                        'inscCalificacionSep' => $inscCalificacionSep[$i],
                        'inscCalificacionOct' => $inscCalificacionOct[$i],
                        'inscCalificacionNov' => $inscCalificacionNov[$i],
                        'inscCalificacionDic' => $inscCalificacionDic[$i],
                        'inscCalificacionEne' => $inscCalificacionEne[$i],
                        'inscCalificacionFeb' => $inscCalificacionFeb[$i],
                        'inscCalificacionMar' => $inscCalificacionMar[$i],
                        'inscCalificacionAbr' => $inscCalificacionAbr[$i],
                        'inscCalificacionMay' => $inscCalificacionMay[$i],
                        'inscCalificacionJun' => $inscCalificacionJun[$i],
                        'updated_at' => $fechaActual->format('Y-m-d H:i:s'),
                        'usuario_at' => auth()->user()->id
    
                    ]);
            }

            return response()->json([
                'res' => "true",
            ]);
        }
        

       

        // alert('Escuela Modelo', 'Las calificaciones se actualizaron con éxito', 'success')->showConfirmButton()->autoClose('100000');
        // return back()->withInput();
       


    }

    
}

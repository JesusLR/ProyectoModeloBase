<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PreescolarAsignarCGTController extends Controller
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
    public function index()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $departamento = Departamento::select()->whereIn('depClave', ['PRE', 'MAT'])->get();

        return view('preescolar.asignar_cgt.create', [
            "ubicaciones" => $ubicaciones,
            "departamento" => $departamento
        ]);
    }

    public function getGradoGrupo(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){


            $gadroGrupo = Cgt::select(
                'cgt.id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo', 'periodos.id as periodo_id',
                'programas.id as programa_id',
                'planes.id as plan_id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.id', $cgt_id)
            ->get();

            $gruposClave = Cgt::select(
                'cgt.id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo', 'periodos.id as periodo_id',
                'programas.id as programa_id',
                'planes.id as plan_id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.cgtGradoSemestre', $gadroGrupo[0]->cgtGradoSemestre)
            ->get();

            return response()->json($gruposClave);
        }
    }

    public function getAlumnosGrado(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){


            $gadroGrupo = Curso::select(
                'cursos.id',
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
            ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.id', $cgt_id)
            ->whereNull('cgt.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('escuelas.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->get();

            if(count($gadroGrupo) > 0){
                $cgtGradoSemestre = $gadroGrupo[0]->cgtGradoSemestre;
                $cgtGrupo = $gadroGrupo[0]->cgtGrupo;
            }else{
                $cgtGradoSemestre = 0;
                $cgtGrupo = 'A';
            }

            $gruposClave = Curso::select(
                'cursos.id',
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
            ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.cgtGradoSemestre', $cgtGradoSemestre)
            ->where('cgt.cgtGrupo', $cgtGrupo)
            ->where('cursos.curEstado', '!=', 'B')
            ->whereNull('cgt.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('escuelas.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->orderBy('personas.perApellido1', 'asc')
            ->orderBy('personas.perApellido2', 'asc')
            ->orderBy('personas.perNombre', 'asc')
            ->get();


            return response()->json($gruposClave);
        }
    }

    public function getPreescolarInscritoCursos(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){


            $gadroGrupo = Curso::select(
                'cursos.id',
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
            ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.id', $cgt_id)
            ->whereNull('cgt.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('escuelas.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->get();

            if(count($gadroGrupo) > 0){
                $cgtGradoSemestre = $gadroGrupo[0]->cgtGradoSemestre;
                $cgtGrupo = $gadroGrupo[0]->cgtGrupo;
            }else{
                $cgtGradoSemestre = 0;
                $cgtGrupo = 'A';
            }


            // llama al procedure
            $resultado_array =  DB::select("call procPreescolarInscritoHayDatos(".$periodo_id.", ".$programa_id.", '".$plan_id."', ".$cgt_id.",".$cgtGradoSemestre.",'".$cgtGrupo."')");

            $resultado_collection = collect($resultado_array);

            return response()->json($resultado_collection);
        }
    }

    public function update(Request $request)
    {
        // return $request->cgt_id;
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fecha = $fechaActual->format('Y-m-d');
        $hora = $fechaActual->format('H:i:s');

        $fecha_hora = $fecha . ' ' . $hora;

        $curso_id = $request->curso_id;
        $grupo_perteneciente = $request->grupo_perteneciente;
        $collectionRespuesta = collect($grupo_perteneciente);
        $cgt_id = $collectionRespuesta->values();

        if (!empty($cgt_id)) {
            $contar = count($cgt_id);
            for ($i = 0; $i < $contar; $i++) {

                // $resultado_array =  DB::select("call procPrimariaInscritoHayDatos(".intval($curso_id).")");
                // $resultado_collection = collect($resultado_array);


                DB::table('cursos')
                ->where('id', $curso_id[$i])
                    ->update([
                        'cgt_id' => $cgt_id[$i],
                        'updated_at' => $fecha_hora
                    ]);
            }

            alert('Escuela Modelo', 'Se asigno CGT con éxito', 'success')->showConfirmButton();
            return back();
        }
    }

}

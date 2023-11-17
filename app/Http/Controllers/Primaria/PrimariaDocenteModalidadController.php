<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Primaria\Primaria_empleado;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrimariaDocenteModalidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();

        $empleados = Primaria_empleado::where('empEstado', '!=', 'B')->orderBy("empApellido1")->get();

        return view('primaria.docenteModalidad.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
        ]);
    }

    public function getAlumnoMateriasAsignaturas(Request $request)
    {
             

        if ($request->ajax()) {
            
            $periodo_id = $request->input("periodo_id");
            $programa_id = $request->input("programa_id");
            $plan_id = $request->input("plan_id");
            $aluClave = $request->input("aluClave");

            $materiasAsignaturas = DB::select("SELECT primaria_inscritos.id, 
            primaria_inscritos.primaria_grupo_id,
            primaria_inscritos.inscTipoAsistencia,
            primaria_inscritos.inscEmpleadoIdDocente,
            primaria_grupos.gpoGrado,
            primaria_grupos.gpoClave,
            alumnos.aluClave,
            personas.perNombre,
            personas.perApellido1,
            personas.perApellido2,
            emp.empApellido1,
            emp.empApellido2,
            emp.empNombre,
            primaria_materias.matClave,
            primaria_materias.matNombre,
            primaria_materias_asignaturas.matClaveAsignatura,
            primaria_materias_asignaturas.matNombreAsignatura
            FROM primaria_inscritos
            INNER JOIN cursos as cursos on cursos.id = primaria_inscritos.curso_id
            INNER JOIN primaria_grupos as primaria_grupos on primaria_grupos.id = primaria_inscritos.primaria_grupo_id
            INNER JOIN alumnos as alumnos on alumnos.id = cursos.alumno_id
            INNER JOIN personas as personas on personas.id = alumnos.persona_id
            INNER JOIN periodos AS periodos ON periodos.id = cursos.periodo_id
            INNER JOIN departamentos as dep ON dep.id = periodos.departamento_id
            INNER JOIN planes as planes on planes.id = primaria_grupos.plan_id
            INNER JOIN programas as programas on programas.id = planes.programa_id
            INNER JOIN primaria_materias as primaria_materias on primaria_materias.id = primaria_grupos.primaria_materia_id
            LEFT JOIN primaria_materias_asignaturas as primaria_materias_asignaturas on primaria_materias_asignaturas.id = primaria_grupos.primaria_materia_asignatura_id
            LEFT JOIN primaria_empleados AS emp ON emp.id = primaria_inscritos.inscEmpleadoIdDocente
            WHERE dep.depClave='PRI'
            AND periodos.id = $periodo_id
            AND programas.id = $programa_id
            AND planes.id = $plan_id
            AND alumnos.aluClave = $aluClave
            ORDER BY primaria_materias.matOrdenVisual ASC");
                      

            $primaria_empleados = DB::select("SELECT * FROM primaria_empleados WHERE empEstado!='B' ORDER BY empApellido1 ASC");


            return response()->json([
                'res' => true,
                'grupo' => $materiasAsignaturas,
                'empleados' => $primaria_empleados
                ]);

            
                    
        }
        
    }

    public function store(Request $request)
    {
        $primaria_inscrito_id = $request->primaria_inscrito_id;
        $inscTipoAsistencia = $request->inscTipoAsistencia;
        $docente_asignado = $request->docente_asignado;

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        // para  asegurar posiciones
        $collectioninscTipoAsistencia = collect($inscTipoAsistencia);
        $inscTipoAsistenciaRespuestas = $collectioninscTipoAsistencia->values();
        $inscTipoAsistenciaID = $collectioninscTipoAsistencia->keys();


        $collectiondocente_asignado = collect($docente_asignado);
        $docente_asignadoRespuestas = $collectiondocente_asignado->values();

        for ($i = 0; $i < count($inscTipoAsistenciaID); $i++) {

            $actu = DB::table('primaria_inscritos')
            ->where('id', $inscTipoAsistenciaID[$i])
                ->update([

                    'inscTipoAsistencia' => $inscTipoAsistenciaRespuestas[$i],
                    'inscEmpleadoIdDocente' => $docente_asignadoRespuestas[$i],                    
                    'updated_at' => $fechaActual->format('Y-m-d H:i:s'),
                    'usuario_at' => auth()->user()->id

                ]);

                // print_r($i);

                      

            

        }

     
        alert('Escuela Modelo', 'El tipo de asistencia y docente asignado se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('60000');
        return back();

    }
}

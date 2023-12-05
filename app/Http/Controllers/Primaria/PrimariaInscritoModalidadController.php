<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Primaria\Primaria_inscrito;
use App\Models\Primaria\Primaria_materias_asignaturas;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrimariaInscritoModalidadController extends Controller
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
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();

        $empleados = Primaria_empleado::where('empEstado', '!=', 'B')->orderBy("empApellido1")->get();

        return view('primaria.inscritoModalidad.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
        ]);
    }

    public function getMateriasAsignaturas(Request $request, $periodo_id, $plan_id)
    {
        if($request->ajax()){              

            $materiasAsignaturas = DB::select("SELECT 
            primaria_grupos.id,
            primaria_materias.matClave,
            primaria_grupos.gpoGrado,
            primaria_grupos.gpoClave,
            primaria_materias.matNombre,
            primaria_grupos.primaria_materia_asignatura_id,
            primaria_materias_asignaturas.matClaveAsignatura,
            primaria_materias_asignaturas.matNombreAsignatura
            FROM primaria_grupos as primaria_grupos
            INNER JOIN primaria_materias as primaria_materias on primaria_materias.id = primaria_grupos.primaria_materia_id
            INNER JOIN planes as planes on planes.id = primaria_grupos.plan_id
            INNER JOIN periodos as periodos on periodos.id = primaria_grupos.periodo_id
            LEFT JOIN primaria_materias_asignaturas as primaria_materias_asignaturas on primaria_materias_asignaturas.id = primaria_grupos.primaria_materia_asignatura_id
            WHERE periodos.id=$periodo_id
            AND planes.id = $plan_id
            ORDER BY primaria_grupos.gpoGrado ASC, primaria_grupos.gpoClave ASC");

            return response()->json($materiasAsignaturas);
        }
    }

    public function getAlumnosMateriasAsignaturas(Request $request)
    {
             

        if ($request->ajax()) {
            
            $primaria_grupo_id = $request->input("primaria_grupo_id");

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
            emp.empNombre
            FROM primaria_inscritos
            INNER JOIN cursos as cursos on cursos.id = primaria_inscritos.curso_id
            INNER JOIN primaria_grupos as primaria_grupos on primaria_grupos.id = primaria_inscritos.primaria_grupo_id
            INNER JOIN alumnos as alumnos on alumnos.id = cursos.alumno_id
            INNER JOIN personas as personas on personas.id = alumnos.persona_id
            INNER JOIN periodos AS periodos ON periodos.id = cursos.periodo_id
            INNER JOIN departamentos as dep ON dep.id = periodos.departamento_id
            LEFT JOIN primaria_empleados AS emp ON emp.id = primaria_inscritos.inscEmpleadoIdDocente
            WHERE dep.depClave='PRI'
            AND primaria_inscritos.primaria_grupo_id = $primaria_grupo_id
            ORDER BY personas.perApellido1 ASC");
                      

            $primaria_empleados = DB::select("SELECT * FROM primaria_empleados WHERE empEstado!='B' ORDER BY empApellido1 ASC");


            return response()->json([
                'res' => true,
                'grupo' => $materiasAsignaturas,
                'empleados' => $primaria_empleados
                ]);

            
                    
        }
        
    }

  
    public function guardarInscritosModalidad(Request $request)
    {

        // if ($request->ajax()) {

        $inscrito_id = $request->input("inscrito_id");
        $inscTipoAsistencia = $request->input("inscTipoAsistencia");
        $checkID = $request->checkID;
        $inscEmpleadoIdDocente = $request->inscEmpleadoIdDocente;

        // $inscTipoAsistencia = explode(',', $request->input("inscTipoAsistencia")); // convierto el string a un array.





        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $hoy = $fechaActual->format('Y-m-d H:i:s');



        for ($i = 0; $i < count($inscrito_id); $i++) {


            DB::table('primaria_inscritos')
            ->where('id', '=', $inscrito_id[$i])
                ->update([
                    "inscTipoAsistencia" => $inscTipoAsistencia[$i]
                ]);

        }

        // actualizar id empleado 
        if($checkID != ""){
            for ($i = 0; $i < count($checkID); $i++) {

                DB::table('primaria_inscritos')
                ->where('id', '=', $checkID[$i])
                    ->update([
                        "inscEmpleadoIdDocente" => $inscEmpleadoIdDocente,
                        "updated_at" => $hoy
                    ]);
    
            }
        }
        

        alert('Escuela Modelo', 'El cambio de Modalidad de estudios se ha actualizado con exito', 'success')->showConfirmButton()->autoClose('8000');

        return back();
        // }


    }

 

}

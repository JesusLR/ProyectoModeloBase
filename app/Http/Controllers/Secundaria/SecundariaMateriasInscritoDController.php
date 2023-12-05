<?php

namespace App\Http\Controllers\Secundaria;

use App\clases\cgts\MetodosCgt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;

class SecundariaMateriasInscritoDController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $alumno = null;
        // Mostrar solo Mérida y valladolid 
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.cargarMateriasInscrito.create', [
            "alumno" => $alumno,
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            
            $curso_id = $request->input("curso_id");
            $cgt_id = $request->input('cgt_id');
            
            //$grupo = DB::statement('call procSecundariaAgregaGruposInscritos(?, ?, ?, ?, ?, ?, ?)',[$secundaria_materia[$i], $plan_id, $periodo_id, $cgt_id, $matSemestre, $cgtGrupo, $cgtTurno]);

            if($cgt_id != ""){

                $resultado_array =  DB::select("call procSecundariaAgregaGruposNuevosInscritos(" . $curso_id . ",  " . $cgt_id . ")");

                return response()->json([
                    'res' => 'true',
                ]);
            }else{
                return response()->json([
                    'res' => 'error',
                ]);
            }

            
                    
        }
    }

    public function ultimoCurso(Request $request, $alumno_id) {

        $departamento = Departamento::with('ubicacion')->whereIn('departamentos.id', [15,19])->get();
        $perActualMerida = $departamento[0]->perActual;
        $perActualValladolid = $departamento[1]->perActual;


        $curso = Curso::with(['cgt.plan.programa.escuela.departamento.ubicacion', 'periodo'])
         ->where('alumno_id', $alumno_id)
         ->where('curEstado', '<>', 'B')
        //  ->latest('curFechaRegistro')
        ->whereIn('periodo_id', [$perActualMerida, $perActualValladolid])
         ->first();

         $data = null;
         if($curso) {

            $cgtSiguiente = MetodosCgt::cgt_siguiente($curso->cgt);

            $data = [
                'curso' => $curso,
                'cgt' => $curso->cgt,
                'plan' => $curso->cgt->plan,
                'programa' => $curso->cgt->plan->programa,
                'escuela' => $curso->cgt->plan->programa->escuela,
                'departamento' => $curso->cgt->plan->programa->escuela->departamento,
                'ubicacion' => $curso->cgt->plan->programa->escuela->departamento->ubicacion,
                'periodo' => $curso->periodo,
                'periodoSiguiente' => $curso->cgt->plan->programa->escuela->departamento->periodoSiguiente,
                'cgtSiguiente' => $cgtSiguiente
            ];
         }
         return json_encode($data);
    }//ultimocCurso.

    public function getMultipleAlumnosByFilter(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        if($request->ajax()){
            $alumnos = Alumno::with("persona")
                ->where('aluEstado', '!=', 'B')
                ->whereIn('aluEstado', ['E','R', 'N'])
                ->whereHas('persona', function($query) use ($request) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"]);
                });

            if ($request->aluClave) {
                $alumnos = $alumnos->where('aluClave', '=', $request->aluClave);
            }

            $alumnos = $alumnos->get();


            //$alumnos = Alumno::with('persona:id,perNombre,perApellido1,perApellido2')->where('aluEstado','!=','B')->where('aluEstado','!=','E')->get();
            return response()->json($alumnos);
        }
    }

    
}

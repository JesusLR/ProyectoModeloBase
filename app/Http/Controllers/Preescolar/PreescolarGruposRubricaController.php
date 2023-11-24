<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cgt;
use App\Models\Departamento;
use App\Models\Preescolar\Preescolar_materia;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Validator;

class PreescolarGruposRubricaController extends Controller
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
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();
        $departamento = Departamento::select()->findOrFail(13);

        return view('preescolar.grupoRubricas.create', [
            'ubicaciones' => $ubicaciones,
            'departamento' => $departamento
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    public function obtenerMaterias(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){


            $cgt = Cgt::findOrFail($cgt_id);

            $materias = Preescolar_materia::select(
            'preescolar_materias.id',
            'preescolar_materias.matClave',
            'preescolar_materias.matNombre', 
            'preescolar_materias.matSemestre', 
            'preescolar_materias.matPrerequisitos',
            'planes.planClave',
            'programas.progNombre',
            'escuelas.escNombre',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiNombre',
            'cgt.cgtGradoSemestre',
			'cgt.cgtGrupo',
            'cgt.cgtTurno',
			'cgt.plan_id as cgt_plan_id',
			'planes.id as plan_id')
            ->join('planes', 'preescolar_materias.plan_id', '=', 'planes.id')
            ->join('cgt', 'planes.id', '=', 'cgt.plan_id')
            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id') 
            ->whereIn('departamentos.depClave', ['MAT', 'PRE'])   
            // ->where('preescolar_materias.matSemestre', $cgt->cgtGradoSemestre) 
            // ->where('cgt.cgtGrupo', $cgt->cgtGrupo)
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)     
            ->where('cgt.id', $cgt_id)
            ->get();

            return response()->json([
                "materias" => $materias,
                "grado" => $cgt->cgtGradoSemestre
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       

        if ($request->ajax()) {
            
            $cgtGrupo = $request->input("cgtGrupo");
            $cgtTurno = $request->input("cgtTurno");

            $preescolar_materia = $request->input("preescolar_materia");

            $periodo_id = $request->input('periodo_id');
            $plan_id = $request->input('plan_id');
            $cgt_id = $request->input('cgt_id');
            $matSemestre = $request->input('matSemestre');
            $depClave = $request->input('depClave');

            

            if($preescolar_materia != ""){
                $total_id_materias = count($preescolar_materia);
                for ($x=0; $x < $total_id_materias; $x++) { 
                    // for ($i=0; $i < count($preescolar_materia) ; $i++) { 
                    //     $grupo = DB::statement('call procPreescolarAgregaGruposInscritos(?, ?, ?, ?, ?, ?, ?, ?)',[$preescolar_materia[$i], $plan_id, $periodo_id, $cgt_id, $matSemestre, $cgtGrupo, $cgtTurno, $depClave]);
                    // }  
                    // return response()->json([
                    //     'res' => true,
                    //     'grupo' => $grupo
                    //     ]);
                   
                }  
            }else{
                return response()->json([
                    'res' => 'error',
                    ]);
            }

            
                    
        }
       

        
    }

}

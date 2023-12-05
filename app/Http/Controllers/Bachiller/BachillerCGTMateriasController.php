<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cgt;
use App\Models\Departamento;
use App\Models\Primaria\Primaria_grupo;
use App\Models\Primaria\Primaria_materia;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Validator;

class BachillerCGTMateriasController extends Controller
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
        $ubicaciones = Ubicacion::whereIn('id', [3])->get();

        return view('bachiller.CGTMaterias.create', [
            'ubicaciones' => $ubicaciones
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

            $cgt = Cgt::find($cgt_id);
            $grado = $cgt->cgtGradoSemestre;

            $materias = Bachiller_materias::select(
            'bachiller_materias.id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre', 
            'bachiller_materias.matSemestre', 
            'bachiller_materias.matPrerequisitos',
            'planes.planClave',
            'programas.progNombre',
            'escuelas.escNombre',
            'departamentos.depNombre',
            'ubicacion.ubiNombre',
			'planes.id as plan_id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id') 
            ->where('departamentos.depClave', 'BAC')   
            ->where('bachiller_materias.matSemestre', $grado) 
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)     
            ->where('bachiller_materias.matVigentePlanPeriodoActual', '=', 'SI')
            ->where('bachiller_materias.matSeRamificaEnGrupoACD', '=', 'NO')
            ->get();

            return response()->json([
                "materias" => $materias,
                "cgt" => $cgt
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
            

            $bachiller_materia = $request->input("bachiller_materia");
            $periodo_id = $request->input('periodo_id');
            $plan_id = $request->input('plan_id');
            $cgt_id = $request->input('cgt_id');
            $ubicacion_id = $request->input('ubicacion_id');

            $cgt = Cgt::find($cgt_id);
            $matSemestre = $cgt->cgtGradoSemestre;
            $cgtGrupo = $cgt->cgtGrupo;
            $cgtTurno = $cgt->cgtTurno;


            

            if($bachiller_materia != ""){
                $total_id_materias = count($bachiller_materia);
                for ($x=0; $x < $total_id_materias; $x++) { 
                    for ($i=0; $i < count($bachiller_materia) ; $i++) { 

                        if($ubicacion_id == "1" || $ubicacion_id == "2" || $ubicacion_id == "4"){
                            $grupo = DB::statement('call procBachillerAgregaGruposInscritosYucatan(?, ?, ?, ?, ?, ?, ?)',[$bachiller_materia[$i], $plan_id, $periodo_id, $cgt_id, $matSemestre, $cgtGrupo, $cgtTurno]);

                        }else{
                            $grupo = DB::statement('call procBachillerAgregaGruposInscritosChetumal(?, ?, ?, ?, ?, ?, ?)',[$bachiller_materia[$i], $plan_id, $periodo_id, $cgt_id, $matSemestre, $cgtGrupo, $cgtTurno]);

                        }
                    }  
                    return response()->json([
                        'res' => true,
                        'grupo' => $grupo
                        ]);
                   
                }  
            }else{
                return response()->json([
                    'res' => 'error',
                    ]);
            }

            
                    
        }
       

        
    }
 
}

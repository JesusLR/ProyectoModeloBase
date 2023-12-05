<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_cch_grupos;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Bachiller\Bachiller_materias_acd;
use App\Models\Bachiller\Bachiller_materias_prereq;
use App\Models\Plan;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Auth;

class BachillerMateriasController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.materias.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $materias = Bachiller_materias::select('bachiller_materias.id as materia_id',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre', 
        'bachiller_materias.matSemestre', 
        'bachiller_materias.matPrerequisitos',
        'bachiller_materias.plan_id',
        'planes.planClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.depNombre',
        'ubicacion.ubiNombre',
        'bachiller_materias.matVigentePlanPeriodoActual')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return DataTables::of($materias)->addColumn('action',function($query) {


               $btnPrerequisitos = "";
               /*
               $btnPrerequisitos = '<a href="#" class="disabled button button--icon js-button js-ripple-effect" title="Pre-requisitos" style="color: gray; cursor: default;">
                <i class="material-icons">playlist_add_check</i>
                </a>';
                
                if ($query->matSemestre > 1) {
                    $btnPrerequisitos = '<a href="bachiller_materia/prerequisitos/'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect" title="Pre-requisitos">
                        <i class="material-icons">playlist_add_check</i>
                    </a>';
                } */

                $btnMateriasACD = "";

                $btnMateriasACD = '<a href="' . route('bachiller.bachiller_materia.index_acd', ['materia_id' => $query->materia_id, 'plan_id' => $query->plan_id]) . '" class="button button--icon js-button js-ripple-effect" title="Materias ACD">
                        <i class="material-icons">archive</i>
                </a>';

                if (Auth::user()->departamento_sistemas == 1 )
                {
                        $btnPermisos = '<a href="bachiller_materia/'.$query->materia_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        <form id="delete_'.$query->materia_id.'" action="bachiller_materia/'.$query->materia_id.'" method="POST" style="display:inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <a href="#" data-id="'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                                <i class="material-icons">delete</i>
                            </a>
                        </form>';
                }
                else
                {
                        $btnPermisos = '';
                }


             return '<div class="row">'
               .$btnPrerequisitos.
                '<a href="bachiller_materia/'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                </a>'. $btnPermisos
                .$btnMateriasACD;
            })
        ->make(true);
    }

    public function listACD($materia_id, $plan_id = null)
    {
        $materias = Bachiller_materias_acd::select('bachiller_materias_acd.id',
        'bachiller_materias_acd.bachiller_matClave',
        'bachiller_materias_acd.bachiller_matPorcentajeCalificacion',
        'bachiller_materias_acd.gpoMatComplementaria',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre', 
        'bachiller_materias.matSemestre', 
        'bachiller_materias.matPrerequisitos',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.depNombre',
        'ubicacion.ubiNombre',
        'bachiller_materias.matVigentePlanPeriodoActual',
        'periodos.perNumero',
        'periodos.perAnio')
        ->join('bachiller_materias', 'bachiller_materias_acd.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_materias_acd.periodo_id', '=', 'periodos.id')
        ->where('bachiller_materias_acd.bachiller_materia_id', '=', $materia_id)
        ->where('planes.id', '=', $plan_id);

        return DataTables::of($materias)
        

            ->filterColumn('numero_periodo', function($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
               
              })
              ->addColumn('numero_periodo',function($query) {
                  return $query->perNumero;
              })

              ->filterColumn('anio', function($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
               
              })
              ->addColumn('anio',function($query) {
                  return $query->perAnio;
              })

              ->filterColumn('materiaComplementaria', function($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
               
              })
              ->addColumn('materiaComplementaria',function($query) {
                  return $query->gpoMatComplementaria;
              })

              ->addColumn('action', function($query) {
  

                if (Auth::user()->departamento_sistemas == 1 )
                {
                    return '<a href="' . route('bachiller.bachiller_materia.show_acd', ['id' => $query->id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>
                    <a href="' . route('bachiller.bachiller_materia.edit_acd', ['id' => $query->id]) . '" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>
                    <form id="delete_' . $query->id . '" action="' . route('bachiller.bachiller_materia_acd.destroy_acd', ['id' => $query->id]) . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }
                else
                {
                    return '<a href="' . route('bachiller.bachiller_materia.show_acd', ['id' => $query->id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                    </a>';
                }


            })
         
        ->make(true);
    }

    public function index_acd($materia_id, $plan_id)
    {
        $materias_acd = Bachiller_materias::select(
        'bachiller_materias.id as bachiller_materia_id',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre', 
        'bachiller_materias.matSemestre', 
        'bachiller_materias.matPrerequisitos',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.depNombre',
        'ubicacion.ubiNombre',
        'bachiller_materias.matVigentePlanPeriodoActual'
        )
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_materias.id', '=', $materia_id)
        ->where('planes.id', '=', $plan_id)
        ->first();

        return view('bachiller.materias.show-list-acd', [
            "materia_id" => $materia_id,
            "plan_id" => $plan_id,
            "materias_acd" => $materias_acd
        ]);
    }

    public function create_acd($materia_id)
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        $bachiller_materia = Bachiller_materias::select('bachiller_materias.id as materia_id',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre', 
        'bachiller_materias.matSemestre', 
        'bachiller_materias.matPrerequisitos',
        'bachiller_materias.plan_id',
        'planes.planClave',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiNombre',
        'ubicacion.ubiClave',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre',
        'bachiller_materias.matVigentePlanPeriodoActual')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_materias.id', $materia_id)
        ->first();

        return view('bachiller.materias.create_acd', [
            'ubicaciones' => $ubicaciones,
            'bachiller_materia' => $bachiller_materia
        ]);
    }
     /**
     * Show prerequisitos.
     *
     * @return \Illuminate\Http\Response
     */
    public function prerequisitos($id)
    {
        $materia = Bachiller_materias::where('id', $id)->with('plan.programa')->first();
        $materias = Bachiller_materias::where('plan_id', $materia->plan_id)->where('matSemestre', '<', $materia->matSemestre)->with('plan.programa')->get();

        return view('bachiller.materias.prerequisitos', [
            'materias' => $materias,
            'materia' => $materia
        ]);
    }

    /**
     * Show user list.
     *
     */
    

    public function listPreRequisitos($id)
    {
        $bachiller_materias_prereq = Bachiller_materias_prereq::select(
            'bachiller_materias_prereq.id as id', 'bachiller_materias.matClave as matClave', 'bachiller_materias.matNombre', 'bachiller_materias.id as materiaId'
        )
        ->leftJoin("bachiller_materias", 'bachiller_materias_prereq.materia_prerequisito_id', "=", "bachiller_materias.id")
        ->where('bachiller_materias_prereq.materia_id', $id);

        return Datatables::of($bachiller_materias_prereq)
            ->addColumn('action', function($bachiller_materias_prereq) {
                return '<div class="row">
                    <div class="col s1">
                        <a href="'.url('bachiller_materia/eliminarPrerequisito/'.$bachiller_materias_prereq->id.'/'.$bachiller_materias_prereq->materiaId).'" class="button button--icon js-button js-ripple-effect" title="Eliminar prerequisito">
                            <i class="material-icons">delete</i>
                        </a>
                    </div>
                </div>';
            })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agregarPreRequisitos(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'materia_id'    => 'required',
                'materia'       => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('bachiller_materia')->withErrors($validator)->withInput();
        } else {
            $materia_id = $request->materia_id;
            $materia = Bachiller_materias::where('id', $materia_id)->with('plan.programa')->first();




            if (Utils::validaPermiso('materia', $materia->plan->programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);

                return redirect('bachiller_materia/prerequisitos/'.$materia_id);
            }


            try {
                //INSERTA LOS PRE-REQUISITOS DE UNA MATERIA
                $prerequisito = $request->materia;
                Bachiller_materias_prereq::create([
                    'materia_id'                => $materia_id,
                    'materia_prerequisito_id'   => $prerequisito
                ]);

                $materia->matPrerequisitos  = $materia->matPrerequisitos + 1;
                $materia->save();


                alert('Escuela Modelo', 'Los Pre-requisitos se ha creado con éxito','success')->autoClose(1000);
                return back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();

                return back()->withInput();
            }
        }
    }

    public function getBachillerMaterias(Request $request, $semestre, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Bachiller_materias::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', $semestre],
                ['matVigentePlanPeriodoActual', '=', 'SI']
            ])->get();

            return response()->json($materias);
        }
    }
     /**
     * Delete prerequisito.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminarPrerequisito($id, $materia_id)
    {
        $prerequisito = Bachiller_materias_prereq::findOrFail($id);

        if ($prerequisito->delete()) {
            $materia = Bachiller_materias::where('id', $prerequisito->materia_id)->first();

            if ($materia->matPrerequisitos == 0) {
                $materia->matPrerequisitos = 0;
            }

            if ($materia->matPrerequisitos > 0) {
                $materia->matPrerequisitos  = $materia->matPrerequisitos - 1;
            }

            $materia->save();
        }
        alert('Escuela Modelo', 'El prerequisito se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
        return back();
    }

    /**
     * Show materias.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMaterias(Request $request, $semestre, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Bachiller_materias::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', $semestre]
            ])->get();

            return response()->json($materias);
        }
    }

        /**
     * Show materias.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMateriasByPlan(Request $request, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Bachiller_materias::where([
                ['plan_id', '=', $plan_id]
            ])->get();

            return response()->json($materias);
        }
    }

    /**
     * Show materias optativas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMateriasOptativas(Request $request, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Bachiller_materias::where('plan_id',$plan_id)->where('matClasificacion','O')->get();
            return response()->json($materias);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {
        //     $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
        //     return view('bachiller.materias.create', [
        //         'ubicaciones' => $ubicaciones
        //     ]);
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);

        //     return redirect('bachiller_materia');
        // }
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
            return view('bachiller.materias.create', [
                'ubicaciones' => $ubicaciones
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(),
        //     [
        //         'plan_id'           => 'required',
        //         'matClave'          => 'required',
        //         'matNombre'         => 'required',
        //         'matNombreCorto'    => 'required',
        //         'matSemestre'       => 'required'
        //     ]
        // );

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }

        $existeClaveMateria = Bachiller_materias::where("plan_id", "=", $request->plan_id)->where("matClave", "=", $request->matClave)->first();
        if ($existeClaveMateria) {
            alert()->error('Ups...', "La clave de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
            return back()->withInput();
        }


        DB::beginTransaction();
        try {
            
            $materias = $request->materias;

            foreach ($materias as $key => $materia) {
                $materia = explode('~',$materia);

                if($materia[5] == "null"){
                    $vigente = "SI";
                }else{
                    $vigente = $materia[5];
                }

                Bachiller_materias::create([
                    'plan_id'                   => $materia[0],
                    'matClave'                  => $materia[2],
                    'matNombre'                 => $materia[3],
                    'matNombreCorto'            => $materia[4],
                    'matVigentePlanPeriodoActual' => $vigente,
                    'matSemestre'               => $materia[6],
                    'matCreditos'               => Utils::validaEmpty($materia[7]),
                    'matClasificacion'          => $materia[8] ? $materia[8] : null,
                    'matEspecialidad'           => $materia[9] ? $materia[9] : null,
                    'matTipoAcreditacion'       => $materia[10] ? $materia[10] : null,
                    'matPorcentajeParcial'      => Utils::validaEmpty($materia[11]),
                    'matPorcentajeOrdinario'    => Utils::validaEmpty($materia[12]),
                    'matNombreOficial'          => $materia[13] ? $materia[13] : null,
                    'matOrdenVisual'            => $materia[14] ? $materia[14] : null,
                    'matClaveEquivalente'       => null,
                    'matTipoGrupoMateria'       => $materia[15]
                ]);
            }

            // $materia = Materia::create([
            //     'plan_id'                   => $request->plan_id,
            //     'matClave'                  => $request->matClave,
            //     'matNombre'                 => $request->matNombre,
            //     'matNombreCorto'            => $request->matNombreCorto,
            //     'matSemestre'               => $request->matSemestre,
            //     'matCreditos'               => Utils::validaEmpty($request->matCreditos),
            //     'matClasificacion'          => $request->matClasificacion,
            //     'matEspecialidad'           => $request->matEspecialidad,
            //     'matTipoAcreditacion'       => $request->matTipoAcreditacion,
            //     'matPorcentajeParcial'      => Utils::validaEmpty($request->matPorcentajeParcial),
            //     'matPorcentajeOrdinario'    => Utils::validaEmpty($request->matPorcentajeOrdinario),
            //     'matNombreOficial'          => $request->matNombreOficial,
            //     'matOrdenVisual'            => $request->matOrdenVisual,
            //     'matClaveEquivalente'       => $request->matClaveEquivalente
            // ]);

            
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La Materia se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }

    public function store_acd(Request $request)
    {

        $existeClaveMateria = Bachiller_materias_acd::where("bachiller_materia_id", "=", $request->bachiller_materia_id)
        ->where("plan_id", "=", $request->plan_id)
        ->where("periodo_id", "=", $request->periodo_id)
        ->where("gpoMatComplementaria", "=", $request->gpoMatComplementaria)
        ->first();
        if ($existeClaveMateria) {
            alert()->error('Ups...', "La clave de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
            return back()->withInput();
        }


        DB::beginTransaction();
        try {
            
            $materias = $request->materias_acd;

            foreach ($materias as $key => $materia) {
                $materia = explode('~',$materia);
          

                Bachiller_materias_acd::create([
                    'bachiller_materia_id' => $materia[2],
                    'bachiller_matClave' => $materia[3],
                    'bachiller_matPorcentajeCalificacion' => $materia[8],
                    'plan_id' => $materia[0],
                    'periodo_id' => $materia[1],
                    'gpoGrado' => $materia[7],
                    'gpoMatComplementaria' => $materia[6]
                ]);
            }


        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La Materia ACD se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $materia = Bachiller_materias::with('plan.programa.escuela.departamento.ubicacion')->findOrFail($id);
        $ubicacion_id = $materia->plan->programa->escuela->departamento->ubicacion->id;

        return view('bachiller.materias.show', [
            'materia' => $materia,
            'ubicacion_id' => $ubicacion_id
        ]);
    }

    public function show_acd($id)
    {
        $materia_acd = Bachiller_materias_acd::select('bachiller_materias_acd.id',
        'bachiller_materias_acd.bachiller_matClave',
        'bachiller_materias_acd.bachiller_matPorcentajeCalificacion',
        'bachiller_materias_acd.gpoMatComplementaria',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre', 
        'bachiller_materias.matSemestre', 
        'bachiller_materias.matPrerequisitos',
        'bachiller_materias.id as bachiller_materia_id',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'bachiller_materias.matVigentePlanPeriodoActual',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('bachiller_materias', 'bachiller_materias_acd.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_materias_acd.periodo_id', '=', 'periodos.id')
        ->where('bachiller_materias_acd.id', '=', $id)
        ->first();

        return view('bachiller.materias.show_acd', [
            "materia_acd" => $materia_acd
        ]);
    }

    public function edit_acd($id)
    {
        $materia_acd = Bachiller_materias_acd::select('bachiller_materias_acd.id',
        'bachiller_materias_acd.bachiller_matClave',
        'bachiller_materias_acd.bachiller_matPorcentajeCalificacion',
        'bachiller_materias_acd.gpoMatComplementaria',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre', 
        'bachiller_materias.matSemestre', 
        'bachiller_materias.matPrerequisitos',
        'bachiller_materias.id as bachiller_materia_id',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'bachiller_materias.matVigentePlanPeriodoActual',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('bachiller_materias', 'bachiller_materias_acd.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_materias_acd.periodo_id', '=', 'periodos.id')
        ->where('bachiller_materias_acd.id', '=', $id)
        ->first();

        return view('bachiller.materias.edit_acd', [
            "materia_acd" => $materia_acd
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {
            $materia = Bachiller_materias::with('plan')->findOrFail($id);
            $plan = Plan::where('id', '=', $materia->plan->id)->first();
            
            return view('bachiller.materias.edit', [
                'materia' => $materia,
                'plan' => $plan
            ]);
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('bachiller_materia');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'matClave'          => 'required',
                'matNombre'         => 'required',
                'matNombreCorto'    => 'required',
                'matSemestre'       => 'required'
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(intval($request->matPorcentajeParcial + $request->matPorcentajeOrdinario) > 100) {
            alert('Error', 'La suma de los porcentajes no debe ser mayor a 100%. Favor de verificar.', 'error')->showConfirmButton();
            return back()->withInput();
        }

        
        $existeClaveMateria = Bachiller_materias::where("plan_id", "=", $request->plan_id)->where("matClave", "=", $request->matClave)->first();


        if (($request->matClaveAnterior != $request->matClave) && $existeClaveMateria) {
            alert()->error('Ups...', "La clave de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
            return back()->withInput();
        }

        try {
            $materia = Bachiller_materias::findOrFail($id);
            $materia->matClave                  = $request->matClave;
            $materia->matNombre                 = $request->matNombre;
            $materia->matNombreCorto            = $request->matNombreCorto;
            $materia->matSemestre               = $request->matSemestre;
            $materia->matCreditos               = Utils::validaEmpty($request->matCreditos);
            $materia->matClasificacion          = $request->matClasificacion;
            $materia->matTipoGrupoMateria       = $request->valorSeleccionado;
            $materia->matEspecialidad           = $request->matEspecialidad;
            $materia->matTipoAcreditacion       = $request->matTipoAcreditacion;
            $materia->matPorcentajeParcial      = Utils::validaEmpty($request->matPorcentajeParcial);
            $materia->matPorcentajeOrdinario    = Utils::validaEmpty($request->matPorcentajeOrdinario);
            $materia->matNombreOficial          = $request->matNombreOficial;
            $materia->matOrdenVisual            = $request->matOrdenVisual;
            $materia->matClaveEquivalente       = $request->matClaveEquivalente;
            $materia->matVigentePlanPeriodoActual = $request->matVigentePlanPeriodoActual;
            $materia->save();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('bachiller_materia/' . $id . '/edit')->withInput();
        }
        alert('Escuela Modelo', 'La Materia se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }

    public function update_acd(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'periodo_id'       => 'required',
                'gpoMatComplementaria'       => 'required',
                'bachiller_matPorcentajeCalificacion'       => 'required'
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // if(intval($request->matPorcentajeParcial + $request->matPorcentajeOrdinario) > 100) {
        //     alert('Error', 'La suma de los porcentajes no debe ser mayor a 100%. Favor de verificar.', 'error')->showConfirmButton();
        //     return back()->withInput();
        // }

        
        $existeClaveMateria = Bachiller_materias_acd::where("bachiller_materia_id", "=", $request->bachiller_materia_id)
        ->where("plan_id", "=", $request->plan_id)
        ->where("periodo_id", "=", $request->periodo_id)
        ->where("gpoMatComplementaria", "=", $request->gpoMatComplementaria)
        ->first();

        if ($existeClaveMateria != "") {
            if ($existeClaveMateria->id != $id) {
                if ($existeClaveMateria) {
                    alert()->error('Ups...', "La materia complementaria ya existe. Favor de capturar otra clave de materia")->autoClose(5000)->showConfirmButton();
                    return back()->withInput();
                }
            }
        }

        


        try {
            $materia = Bachiller_materias_acd::findOrFail($id);
            $materia->bachiller_materia_id                  = $request->bachiller_materia_id;
            $materia->bachiller_matClave                    = $request->bachiller_matClave;
            $materia->bachiller_matPorcentajeCalificacion   = $request->bachiller_matPorcentajeCalificacion;
            $materia->plan_id                               = $request->plan_id;
            $materia->periodo_id                            = $request->periodo_id;
            $materia->gpoGrado                              = $request->gpoGrado;
            $materia->gpoMatComplementaria                  = $request->gpoMatComplementaria;
            $materia->save();

            $bachiller_grupos = Bachiller_grupos::where('bachiller_materia_acd_id', '=', $id)->get();

            if(count($bachiller_grupos) > 0){
                foreach($bachiller_grupos as $grupo){
                    
                    DB::update("UPDATE bachiller_grupos SET gpoMatComplementaria='".$request->gpoMatComplementaria."' WHERE id=$grupo->id");
                    
                }
            }

            

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('bachiller_materia_acd/' . $id . '/edit')->withInput();
        }
        alert('Escuela Modelo', 'La Materia se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // obtenemos la ubicacion 
        $bachiller_materia = DB::select("
        SELECT ubicacion.ubiClave
        FROM bachiller_materias as bachiller_materias
        INNER JOIN planes as planes ON planes.id = bachiller_materias.plan_id
        INNER JOIN programas as programas ON programas.id = planes.programa_id
        INNER JOIN escuelas as escuelas ON escuelas.id = programas.escuela_id
        INNER JOIN departamentos as departamentos ON departamentos.id = escuelas.departamento_id
        INNER JOIN ubicacion as ubicacion ON ubicacion.id = departamentos.ubicacion_id
        WHERE bachiller_materias.id = 2154");
        

        if($bachiller_materia[0]->ubiClave == "CME" || $bachiller_materia[0]->ubiClave == "CVA"){
            $bachiller_grupos = DB::select("SELECT * FROM bachiller_grupos where bachiller_materia_id=$id AND deleted_at IS NULL");
            $deleted_at = collect($bachiller_grupos);
        }
        
        if($bachiller_materia[0]->ubiClave == "CCH") {
            $bachiller_grupos = DB::select("SELECT * FROM bachiller_cch_grupos where bachiller_materia_id=$id AND deleted_at IS NULL");
            $deleted_at = collect($bachiller_grupos);
        }
        

        // return count($deleted_at);

        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {
            $materia = Bachiller_materias::findOrFail($id);
            try {
                $programa_id = $materia->plan->programa_id;
                if (Utils::validaPermiso('materia',$programa_id)) {
                    alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                }

                if(count($deleted_at) > 0){
                    alert()->error('Escuela Modelo', 'No se puedo eliminar el registro debido que hay grupos relacionados con esta materia')->showConfirmButton();

                }else{
                    if ($materia->delete()) {
                        alert('Escuela Modelo', 'La materia se ha eliminado con éxito','success')->showConfirmButton()->autoClose(5000);
                    } else {
                        alert()->error('Error...', 'No se puedo eliminar la materia')->showConfirmButton();
                    }
                }
                
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }

        return redirect('bachiller_materia');
    }

    public function destroy_acd($id)
    {
        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {

            $materia = Bachiller_materias_acd::select(
                'bachiller_materias_acd.id',
                'bachiller_materias_acd.bachiller_matClave',
                'bachiller_materias_acd.bachiller_matPorcentajeCalificacion',
                'bachiller_materias_acd.gpoMatComplementaria',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_materias.matSemestre',
                'bachiller_materias.matPrerequisitos',
                'bachiller_materias.id as bachiller_materia_id',
                'planes.id as plan_id',
                'planes.planClave',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.escNombre',
                'departamentos.id as departamento_id',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'bachiller_materias.matVigentePlanPeriodoActual',
                'periodos.id as periodo_id',
                'periodos.perNumero',
                'periodos.perAnio',
                'escuelas.id as escuela_id',
                'escuelas.escClave',
                'escuelas.escNombre'
            )
            ->join('bachiller_materias', 'bachiller_materias_acd.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('periodos', 'bachiller_materias_acd.periodo_id', '=', 'periodos.id')
            ->where('bachiller_materias_acd.id', '=', $id)
            ->first();

            

            
            try {
                $programa_id = $materia->plan->programa_id;
                if (Utils::validaPermiso('materia', $programa_id)) {
                    alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                }
                if($materia->ubicacion_id == 1 || $materia->ubicacion_id == 2){
                    $bachiller_grupos = Bachiller_grupos::where('bachiller_materia_acd_id', $materia->id)->first();
                    if($bachiller_grupos != ""){
                        alert()->error('Ups...' . 'No se puede eliminar este registro debido que hay grupos cargados a esta materia complementaria')->showConfirmButton();
                    }else{
                        if ($materia->delete()) {
                            alert('Escuela Modelo', 'La materia complementaria se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
                        } else {
                            alert()->error('Error...', 'No se puedo eliminar la materia complementaria')->showConfirmButton();
                        }
                    }
                    
                }
    
                if($materia->ubicacion_id == 3){
                    $bachiller_grupos = Bachiller_cch_grupos::where('bachiller_materia_acd_id', $materia->id)->first();
                    if($bachiller_grupos != ""){
                        alert()->error('Ups...' . 'No se puede eliminar este registro debido que hay grupos cargados a esta materia complementaria')->showConfirmButton();
                    }else{
                        if ($materia->delete()) {
                            alert('Escuela Modelo', 'La materia complementaria se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
                        } else {
                            alert()->error('Error...', 'No se puedo eliminar la materia complementaria')->showConfirmButton();
                        }
                    }
                }
                
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }

        return back();
    }
}

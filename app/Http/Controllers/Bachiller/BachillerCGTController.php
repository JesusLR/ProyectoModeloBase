<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Cgt;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerCGTController extends Controller
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
        return view('bachiller.CGT.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $cgts = Cgt::select('cgt.id as cgt_id','cgt.cgtGradoSemestre','cgt.cgtGrupo','cgt.cgtTurno',
            'periodos.perNumero','periodos.perAnio','planes.planClave','programas.progNombre',
            'escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre',
            'departamentos.id AS departamento_id', 'ubicacion.id AS ubicacion_id')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', 'BAC');

        

        return DataTables::of($cgts)->addColumn('action',function($query) {

            $btnCambioMatricula = "";
            $btnEditar = "";
            $btnBorrar = "";
            

            $departamento_control_escolar = Auth::user()->departamento_control_escolar;
            $departamento_sistemas = Auth::user()->departamento_sistemas;


            if($departamento_control_escolar == 1 || $departamento_sistemas == 1){

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                
                

                if($ubicacion == $query->ubicacion_id){

                    $btnCambioMatricula = '<a href="bachiller_cambiar_matriculas_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Cambiar matrículas de alumnos">
                        <i class="material-icons">supervisor_account</i>
                    </a>';

                    $btnEditar = '<a href="bachiller_cgt/'.$query->cgt_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>';

                    $btnBorrar = '<form id="delete_'.$query->cgt_id.'" action="bachiller_cgt/'.$query->cgt_id.'" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <a href="#" data-id="'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';   
                }
                

                
            }else{
                $btnCambioMatricula = "";
                $btnEditar = "";
                $btnBorrar = "";
            }


            

            return '
            '.$btnCambioMatricula.'
            <a href="bachiller_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            
            '.$btnEditar
            .$btnBorrar.'
            ';
        }) ->make(true);
    }

    public function getCgts(Request $request, $plan_id,$periodo_id)
    {
        if ($request->ajax()) {
            $cgts = Cgt::where([
                ['plan_id', $plan_id],
                ['periodo_id', $periodo_id]
            ])
            ->orderBy('cgtGradoSemestre', 'ASC')
            ->orderBy('cgtGrupo', 'ASC')
            ->get();
            return response()->json($cgts);
        }
    }
     /**
     * Show cgts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCgtsSinN(Request $request, $plan_id,$periodo_id)
    {
        if ($request->ajax()) {
            $cgts = Cgt::where([
                ['plan_id', $plan_id],
                ['periodo_id', $periodo_id],
                ['cgtGrupo', '!=', 'N']
            ])
            ->orderBy('cgtGradoSemestre', 'ASC')
            ->orderBy('cgtGrupo', 'ASC')
            ->get();
            return response()->json($cgts);
        }
    }


    /**
     * Show cgts semestre.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCgtsSemestre(Request $request, $plan, $periodo, $semestre)
    {
        if($request->ajax()){
            $grupos = Bachiller_grupos::with('bachiller_materia', 'bachiller_empleado')
                ->where([
                    ['plan_id', '=', $plan],
                    ['periodo_id', '=', $periodo],
                    ['gpoGrado', '=', $semestre]
                ])
            ->get();

            return response()->json($grupos);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
        $empleados = Bachiller_empleados::get();

        return view('bachiller.CGT.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
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
        $validator = Validator::make($request->all(),
            [
                'plan_id' => 'required|unique:cgt,plan_id,NULL,id,periodo_id,' . $request->input('periodo_id')
                    . ',cgtGradoSemestre,' . $request->input('cgtGradoSemestre') . ',cgtGrupo,' . $request->input('cgtGrupo')
                    . ',cgtTurno,'.$request->input('cgtTurno').',deleted_at,NULL',
                'periodo_id' => 'required',
                'cgtGradoSemestre' => 'required',
                'cgtGrupo'  => 'required|max:3',
                'cgtTurno'   => 'required|max:1',
                // 'cgtDescripcion'   => 'max:30',
                // 'cgtCupo' => 'max:6',
                // 'empleado_id' => 'required'
            ],
            [
                'plan_id.unique' => "El cgt ya existe",
            ]
        );

        if ($validator->fails()) {
            if($request->ajax()) {
                return response()->json($validator->errors(), 400);
            }else {
                return redirect ('bachiller_cgt/create')->withErrors($validator)->withInput();
            }
        } 
        
        $programa_id = $request->input('programa_id');
        if (Utils::validaPermiso('cgt',$programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('bachiller_cgt/create');
        }


        //control estados 
        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $request->periodo_id)->where("fecha1", "=", 1)->first();
        if ($existeRestriccion) {
            return json_encode([
                "error" => "true",
                "errorMsg" => "Por el momento, el módulo se encuentra deshabilitado para este período."
            ]);

        }


        try {
            $cgt = Cgt::create([
                'plan_id'           => $request->input('plan_id'),
                'periodo_id'        => $request->input('periodo_id'),
                'cgtGradoSemestre'  => $request->input('cgtGradoSemestre'),
                'cgtGrupo'          => $request->input('cgtGrupo'),
                'cgtTurno'          => $request->input('cgtTurno'),
                'cgtDescripcion'    => $request->input('cgtDescripcion'),
                'cgtCupo'           => Utils::validaEmpty($request->input('cgtCupo')),
                'empleado_id'       => 0,
                'cgtEstado'         => 'A'
            ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            if($request->ajax()) {
                return response()->json([$errorCode, $errorMessage],400);
            }else{     
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_cgt/create')->withInput();
            }
        }

        if($request->ajax()) {
            return json_encode($cgt);
        }else{
            return redirect('bachiller_cgt/create');
        }

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
        $cgt = Cgt::select('cgt.id as cgt_id','cgt.cgtGradoSemestre','cgt.cgtGrupo','cgt.cgtTurno',
        'periodos.perNumero','periodos.perAnio','planes.planClave','programas.progNombre',
        'escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre', 'bachiller_empleados.empNombre', 'bachiller_empleados.empApellido1',
        'bachiller_empleados.empApellido2')
        ->leftJoin('bachiller_empleados', 'cgt.empleado_id', '=', 'bachiller_empleados.id')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', 'BAC')
        ->findOrFail($id);

        

        return view('bachiller.CGT.show', [
            'cgt' => $cgt
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
        $empleados = Bachiller_empleados::get();
        $cgt      = Cgt::with('plan', 'periodo', 'bachiller_empleado')->findOrFail($id);
        $periodos  = Periodo::where('departamento_id', $cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('bachiller_empleado', 'escuela')->where('escuela_id', $cgt->plan->programa->escuela_id)->get();
        $planes    = Plan::with('programa')->where('programa_id', $cgt->plan->programa->id)->get();



        //VALIDA PERMISOS EN EL PROGRAMA
        // if (Utils::validaPermiso('cgt',$cgt->plan->programa_id)) {
        //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
        //     return redirect('bachiller_cgt');
        // } else {
            return view('bachiller.CGT.edit', [
                'cgt' => $cgt,
                'empleados' => $empleados,
                'periodos' => $periodos,
                'programas' => $programas,
                'planes' => $planes
            ]);
        // }
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
                'plan_id'           => 'required',
                'cgtGradoSemestre'  => 'required|max:6',
                'cgtGrupo'          => 'required|max:3',
                'cgtTurno'          => 'required|max:1',
                'cgtDescripcion'    => 'max:30',
                'cgtCupo'           => 'max:6'
            ]
        );


        if ($validator->fails()) {
            return redirect ('bachiller_cgt/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $cgt = Cgt::with('plan','periodo','bachiller_empleado')->findOrFail($id);

                if ($cgt->cgtEstado == "C") {
                    alert()->error('Ups...', 'La modificación del CGT no se encuentra inactiva')->showConfirmButton()->autoClose(5000);
                    return redirect()->back()->withInput();
                }

                $cgt->plan_id           = $request->input('plan_id');
                $cgt->periodo_id        = $request->input('periodo_id');
                $cgt->cgtGradoSemestre  = $request->input('cgtGradoSemestre');
                $cgt->cgtGrupo          = $request->input('cgtGrupo');
                $cgt->cgtTurno          = $request->input('cgtTurno');
                $cgt->cgtDescripcion    = $request->input('cgtDescripcion');
                $cgt->cgtCupo           = Utils::validaEmpty($request->input('cgtCupo'));
                $cgt->empleado_id       = 0;
                $cgt->save();

                alert('Escuela Modelo', 'El cgt se ha actualizado con éxito','success')->showConfirmButton()->autoClose(5000);
                return redirect()->back()->withInput();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];

                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_cgt/' . $id . '/edit')->withInput();
            }
        }
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
        $cgt = Cgt::findOrFail($id);


    //control estados 
    $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=",$cgt->periodo_id)->where("fecha1", "=", 1)->first();
    if ($existeRestriccion) {
        alert()->error('Ups...', "Por el momento, el módulo se encuentra deshabilitado para este período.")->showConfirmButton()->autoClose(5000);
        return redirect()->back()->withInput();
    }

        if ($cgt->cgtEstado == "C") {
            alert()->error('Ups...', 'La modificación del CGT no se encuentra inactiva')->showConfirmButton()->autoClose(5000);
            return redirect()->back()->withInput();
        }

        try {
            $programa_id = $cgt->plan->programa_id;
            if (Utils::validaPermiso('cgt',$programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect('bachiller_cgt');
            }
            if ($cgt->delete()) {
                alert('Escuela Modelo', 'El cgt se ha eliminado con éxito','success')->showConfirmButton();
            }else{
                alert()->error('Error...', 'No se puedo eliminar el cgt')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('bachiller_cgt');
    }
}

<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Cgt;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Empleado;
use App\Models\Preescolar\Preescolar_grupo;
use App\Models\Programa;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Auth;

class PreescolarCGTController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:cgt',['except' => ['index','show','list','getCgts','getCgtsSemestre']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('preescolar.CGT.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $cgts = Cgt::select('cgt.id as cgt_id','cgt.cgtGradoSemestre','cgt.cgtGrupo','cgt.cgtTurno',
            'periodos.perNumero','periodos.perAnio','planes.planClave','programas.progNombre',
            'escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->whereIn('departamentos.depClave', ['PRE', 'MAT']);


        return DataTables::of($cgts)->addColumn('action',function($query) {

            $btnCambioMatricula = "";
            $btnEditar = "";
            $btnBorrar = "";

            $departamento_control_escolar = Auth::user()->departamento_control_escolar;
            $departamento_sistemas = Auth::user()->departamento_sistemas;


            if($departamento_control_escolar == 1 || $departamento_sistemas == 1){
                
                $btnCambioMatricula = '<a href="preescolar_cambiar_matriculas_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Cambiar matrículas de alumnos">
                    <i class="material-icons">supervisor_account</i>
                </a>';
                $btnEditar = '<a href="preescolar_cgt/'.$query->cgt_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';

                $btnBorrar = '<form id="delete_'.$query->cgt_id.'" action="preescolar_cgt/'.$query->cgt_id.'" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <a href="#" data-id="'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            }else{
                $btnCambioMatricula = "";
                $btnEditar = "";
                $btnBorrar = "";
            }

            return '
            '.$btnCambioMatricula.'
            <a href="preescolar_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            
            '.$btnEditar
            .$btnBorrar.'
            ';
        }) ->make(true);
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
            $grupos = Preescolar_grupo::with('preescolar_materia', 'empleado.persona')
                ->where([
                    ['plan_id', '=', $plan],
                    ['periodo_id', '=', $periodo],
                    ['gpoSemestre', '=', $semestre]
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
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $empleados = Empleado::get();

        return view('preescolar.CGT.create', [
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
                return redirect ('preescolar_cgt/create')->withErrors($validator)->withInput();
            }
        }

        $programa_id = $request->input('programa_id');
        if (Utils::validaPermiso('cgt',$programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('preescolar_cgt/create');
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
                return redirect('preescolar_cgt/create')->withInput();
            }
        }

        if($request->ajax()) {
            return json_encode($cgt);
        }else{
            return redirect('preescolar_cgt/create');
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
        'escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre', 'personas.perNombre as empNombre',
        'personas.perApellido1 as empApellido1',
        'personas.perApellido2 as empApellido2')
        ->leftJoin('empleados', 'cgt.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
        ->findOrFail($id);

        return view('preescolar.CGT.show', [
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
        $empleados = Empleado::get();
        $cgt       = Cgt::with('plan', 'periodo', 'empleado.persona')->findOrFail($id);
        $periodos  = Periodo::where('departamento_id', $cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado', 'escuela')->where('escuela_id', $cgt->plan->programa->escuela_id)->get();
        $planes    = Plan::with('programa')->where('programa_id', $cgt->plan->programa->id)->get();



        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('cgt',$cgt->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('preescolar_cgt');
        } else {
            return view('preescolar.CGT.edit', [
                'cgt' => $cgt,
                'empleados' => $empleados,
                'periodos' => $periodos,
                'programas' => $programas,
                'planes' => $planes
            ]);
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
                'plan_id'           => 'required',
                'cgtGradoSemestre'  => 'required|max:6',
                'cgtGrupo'          => 'required|max:3',
                'cgtTurno'          => 'required|max:1',
                'cgtDescripcion'    => 'max:30',
                'cgtCupo'           => 'max:6'
            ]
        );


        if ($validator->fails()) {
            return redirect ('preescolar_cgt/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $cgt = Cgt::with('plan','periodo','empleado')->findOrFail($id);

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
                return redirect('preescolar_cgt/' . $id . '/edit')->withInput();
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
                return redirect('preescolar_cgt');
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
        return redirect('preescolar_cgt');
    }
}

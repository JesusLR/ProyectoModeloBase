<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;

use App\Models\Cgt;
use App\Models\Grupo;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Plan;

class CgtController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:cgt',['except' => ['index','show','list','getCgts','getCgtsSemestre']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('cgt.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $cgts = Cgt::select('cgt.id as cgt_id','cgt.cgtGradoSemestre','cgt.cgtGrupo','cgt.cgtTurno',
            'periodos.perNumero','periodos.perAnio','planes.planClave','programas.progClave',
            'escuelas.escNombre','departamentos.depClave','ubicacion.ubiClave')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->orderByDesc('periodos.perAnio')
        ->orderBy('periodos.perNumero');

        return Datatables::of($cgts)->addColumn('action',function($query) {
            return '<a href="cambiar_matriculas_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Cambiar matrículas de alumnos">
                <i class="material-icons">supervisor_account</i>
            </a>
            <a href="cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="cgt/'.$query->cgt_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_'.$query->cgt_id.'" action="cgt/'.$query->cgt_id.'" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <a href="#" data-id="'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        }) ->make(true);
    }

     /**
     * Show cgts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCgts(Request $request, $plan_id,$periodo_id)
    {
        if ($request->ajax()) {
            $cgts = Cgt::where([
                ['plan_id', $plan_id],
                ['periodo_id', $periodo_id]
            ])->get();
            return response()->json($cgts);
        }
    }

    public function getCgtById(Request $request, $cgt_id) {
        $cgt = Cgt::with('plan.programa')->findOrFail($cgt_id);

        return response()->json($cgt);
    }

    /**
     * Se creo para llenar selects en las vistas, trae info desde la tabla 'cgt'.
     * Hay una función con el mismo nombre en funcionesAuxiliares para llenar selectores.
     */
    public function getCgtsPorSemestre(Request $request, $plan_id, $periodo_id, $semestre) 
    {
        $cgts = Cgt::with('plan.programa')->where([
            ['plan_id', '=', $plan_id],
            ['periodo_id', '=', $periodo_id],
            ['cgtGradoSemestre', '=', $semestre],
        ])->get();
        
        return response()->json($cgts);
    }


    /**
     * Show cgts semestre.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCgtsSemestre(Request $request, $plan, $periodo, $semestre)
    {
        if($request->ajax()){
            $grupos = Grupo::with('materia', 'empleado.persona')
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
        $ubicaciones = Ubicacion::all();
        $empleados = Empleado::with('persona')->get();
        return view('cgt.create', compact('ubicaciones', 'empleados'));
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
                return redirect ('cgt/create')->withErrors($validator)->withInput();
            }
        } 
        
        $programa_id = $request->input('programa_id');
        if (Utils::validaPermiso('cgt',$programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('cgt/create');
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
                return redirect('cgt/create')->withInput();
            }
        }

        if($request->ajax()) {
            return json_encode($cgt);
        }else{
            return redirect('cgt/create');
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
        $cgt = Cgt::with('plan','periodo','empleado.persona')->findOrFail($id);
        return view('cgt.show',compact('cgt'));
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
        $empleados = Empleado::with('persona')->get();
        $cgt       = Cgt::with('plan', 'periodo', 'empleado.persona')->findOrFail($id);
        $periodos  = Periodo::where('departamento_id', $cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado', 'escuela')->where('escuela_id', $cgt->plan->programa->escuela_id)->get();
        $planes    = Plan::with('programa')->where('programa_id', $cgt->plan->programa->id)->get();



        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('cgt',$cgt->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('cgt');
        } else {
            return view('cgt.edit',compact('cgt','empleados','periodos','programas','planes'));
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
            return redirect ('cgt/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $cgt = Cgt::with('plan','periodo','empleado.persona')->findOrFail($id);

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
                return redirect('cgt/' . $id . '/edit')->withInput();
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

        if($cgt->cursos->isNotEmpty()) {
            alert('Ups!...', 'Este registro tiene vinculados cursos activos. No es posible borrarlo.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        if (Utils::validaPermiso('cgt', $cgt->plan->programa->id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('cgt');
        }

        try {
            $cgt->delete();
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }

        alert('Escuela Modelo', 'El cgt se ha eliminado con éxito','success')->showConfirmButton();
        return redirect('cgt');
    }
}
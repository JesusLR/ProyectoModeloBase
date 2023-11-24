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

use App\Models\Plan;
use App\Models\Materia;
use App\Models\Ubicacion;
use App\Models\User;

class PlanController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:plan',['except' => ['index','show','list','getPlanes','getSemestre', 'getPlan']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('plan.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list(Request $request)
    {   
        $suma_creditos_materias = Materia::select('plan_id AS materias_plan_id', DB::raw("SUM(matCreditos) AS materias_creditos"))
        ->groupBy('plan_id');


        $planes = Plan::select('planes.id as plan_id','planes.*','programas.progClave','escuelas.escClave','ubicacion.ubiClave', 'suma_creditos_materias.*')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoinSub($suma_creditos_materias, 'suma_creditos_materias', static function($join) {
            $join->on('planes.id', 'suma_creditos_materias.materias_plan_id');
        })
        ->where(static function($query) use ($request) {
            if($request->tipo_filtro && $request->tipo_filtro == 'creditos_incongruentes') {
                $query->whereColumn('planes.planNumCreditos', '!=', 'suma_creditos_materias.materias_creditos');
            }
            if($request->tipo_filtro && $request->tipo_filtro == 'creditos_congruentes') {
                $query->whereColumn('planes.planNumCreditos', '=', 'suma_creditos_materias.materias_creditos');
            }
        });
        
        return Datatables::of($planes)
        ->addColumn('action', static function($query) {
            return '<a href="plan/'.$query->plan_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="plan/'.$query->plan_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <a href="#modalCambiarEstado" data-plan-id="'.$query->plan_id.'" class="btn-modal-estatus-plan modal-trigger button button--icon js-button js-ripple-effect" title="Cambiar Estado">
                <i class="material-icons">unarchive</i>
            </a>';
        })->make(true);
    }

     /**
     * Show planes.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlanes(Request $request, $id)
    {
        if($request->ajax()){
            $planes = Plan::where('programa_id',$id)->orderBy('id', 'desc')->get();
            return response()->json($planes);
        }
    }

     /**
     * Show planes federales.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlanesFederales(Request $request, $id)
    {
        if($request->ajax()){
            $planes = Plan::where('programa_id',$id)->where('planRegistro', 'F')->orderBy('id', 'desc')->get();
            return response()->json($planes);
        }
    }

    /**
     * Show semestre.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSemestre(Request $request, $id)
    {
        if($request->ajax())
        {
            $plan = Plan::where('id',$id)->first();
            return response()->json($plan);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("plan") == "A" || User::permiso("plan") == "B") {
            $ubicaciones = Ubicacion::all();
            return View('plan.create',compact('ubicaciones'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('plan');
        }
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
                'programa_id'   => 'required',
                'planClave'     => 'required',
                'planPeriodos'  => 'required',
                'tipo_registro'  => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('plan/create')->withErrors($validator)->withInput();
        }

        $programa_id = $request->input('programa_id');
        if (Utils::validaPermiso('plan',$programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('materia/create');
        }


        $existePlan = Plan::where("programa_id", "=", $request->programa_id)->where("planClave", "=", $request->planClave)->first();

        if ($existePlan) {
            alert()->error('Ups...', "La clave de plan ya existe. Favor de capturar otra clave de plan")->autoClose(5000);
            return back()->withInput();
        }
        
        try {
            $plan = Plan::create([
                'programa_id'   => $request->input('programa_id'),
                'planClave'     => $request->input('planClave'),
                'planPeriodos'  => Utils::validaEmpty($request->input('planPeriodos')),
                'planNumCreditos' => Utils::validaEmpty($request->input('planNumCreditos')),
                'planRegistro' => $request->input('tipo_registro')
            ]);

            alert('Escuela Modelo', 'El Plan se ha creado con éxito','success');

            return redirect('plan');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
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
        $plan = Plan::with('programa')->findOrFail($id);
        return view('plan.show',compact('plan'));
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
        if (User::permiso("plan") == "A" || User::permiso("plan") == "B") {
            $plan = Plan::with('programa')->findOrFail($id);
            return view('plan.edit',compact('plan'));
        }else{
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('plan');
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
                'programa_id'   => 'required',
                'planClave'     => 'required',
                'planPeriodos'  => 'required',
                'tipo_registro'  => 'required'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $programa_id = $request->programa_id;
        if (Utils::validaPermiso('plan', $programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return back();
        }

        $existePlan = Plan::where("programa_id", "=", $request->programa_id)->where("planClave", "=", $request->planClave)->first();
        if (($request->planClaveAnterior != $request->planClave) && $existePlan) {
            alert()->error('Ups...', "La clave de plan ya existe. Favor de capturar otra clave de plan")->autoClose(5000);
            return back()->withInput();
        }


        try {
            $plan = Plan::findOrFail($id);
            $plan->planClave    = $request->planClave;
            $plan->planPeriodos = Utils::validaEmpty($request->planPeriodos);
            $plan->planNumCreditos = Utils::validaEmpty($request->planNumCreditos);
            $plan->planRegistro    = $request->tipo_registro;
            $plan->save();
            alert('Escuela Modelo', 'El Plan se ha actualizado con éxito','success');

            return redirect('plan');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();

            return back()->withInput();
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
        if (User::permiso("plan") == "A" || User::permiso("plan") == "B") {
            $plan = Plan::findOrFail($id);
            try {
                $programa_id = $plan->programa_id;
                if(Utils::validaPermiso('plan',$programa_id)){
                    alert()
                    ->error('Ups...', 'Sin privilegios en el programa!')
                    ->showConfirmButton()
                    ->autoClose(5000);
                }
                if($plan->delete()){
                    alert('Escuela Modelo', 'El plan se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el plan')
                    ->showConfirmButton();
                }
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
            }
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
        }
        return redirect('plan');
    }

    public function cambiarPlanEstado(Request $request) {
        if(!$request->planId || !$request->planEstado) {
            return response()->json(['res' => false, 'msg' => 'No se ingresaron los datos correctamente']);
        }

        $plan = Plan::findOrFail($request->planId)->update(['planEstado' => $request->planEstado]);

        if($plan) {
            return response()->json(['res' => $plan, 'msg' => 'Se actualizó correctamente el estado del plan.']);
        } else {
            return response()->json(['res' => false, 'msg' => 'Hubo un problema durante el proceso.']);
        }
    }//cambiarPlanEstado.

    public function getPlan(Request $request, $plan_id) {
        if($request->ajax()) {
            return response()->json(Plan::find($plan_id));
        }
    }//getPlan.

}//Controller class.
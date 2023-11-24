<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Debugbar;

use App\Models\Cgt;
use App\Models\Grupo;
use App\Models\Curso;
use App\Models\Paquete;
use App\Models\Paquete_detalle;
use App\Models\Ubicacion;

class PaqueteController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:paquete',['except' => ['index','show','list','getPaquetes','getPaqueteDetalle']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('paquete.show-list');
    }

    /**
     * Show paquete list.
     *
     */
    public function list()
    {
        //$paquete = Paquete::with('periodo','plan','paquetes_detalle')->select('paquetes.*');
        $paquetes = Paquete::select('paquetes.id as paquete_id','periodos.perNumero', 'periodos.perAnio', 'planes.planClave',
            'programas.progNombre','consecutivo','semestre','ubicacion.ubiNombre', 'vw_paquetes_paquetedetalle.num_grupo')
            ->join('periodos', 'paquetes.periodo_id', '=', 'periodos.id')
            ->join('planes', 'paquetes.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('vw_paquetes_paquetedetalle', 'vw_paquetes_paquetedetalle.paquete_id', '=', 'paquetes.id')
            ->latest('paquetes.created_at');
            

        return Datatables::of($paquetes)
            // ->addColumn('num_grupo', function($query) {
            //     $num_grupo = Paquete_detalle::where('paquete_id', $query->paquete_id)->count();
            //     return $num_grupo;
            // })
            ->addColumn('action',function($query) {
                return '<a href="paquete/' . $query->paquete_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="paquete/' . $query->paquete_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <form id="delete_'.$query->paquete_id.'" action="paquete/' . $query->paquete_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token().'">
                    <a href="#" data-id="' . $query->paquete_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        return view('paquete.create',compact('ubicaciones'));
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
        $periodo_id = $request->input('periodo_id');
        $plan_id = $request->input('plan_id');
        $semestre = $request->input('semestre_id');
        //CUENTA CUANTOS PAQUETES HAY
        $count_paquetes = Paquete::where([['periodo_id',$periodo_id],['plan_id',$plan_id],['semestre',$semestre]])->count();
        //SE CREA EL CONSECUTIVO DEL PAQUETE
        $consecutivo = $count_paquetes + 1;
        $validator = Validator::make($request->all(),
            [
                'periodo_id'    => 'required|unique:paquetes,periodo_id,NULL,id,plan_id,'.$request->input('plan_id').',semestre,'.$semestre.',consecutivo,'.$consecutivo.',deleted_at,NULL',
                'plan_id'       => 'required',
                'semestre_id'   => 'required'
            ],
            [
                'periodo_id.unique' => "El paquete ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect('paquete/create')->withErrors($validator)->withInput();
        } else {
            try {
                $programa_id = $request->input('programa_id');
                if(Utils::validaPermiso('paquete',$programa_id)){
                    alert()
                    ->error('Ups...', 'Sin privilegios en el programa!')
                    ->showConfirmButton()
                    ->autoClose(5000);
                    return redirect()->to('paquete/create');
                }
                //INSERTA PAQUETE
                $paquete_id = Paquete::create([
                    'periodo_id'    => $periodo_id,
                    'plan_id'       => $plan_id,
                    'semestre'      => $semestre,
                    'consecutivo'   => $consecutivo
                ])->id;
                //INSERTA LOS GRUPOS EN PAQUETE DETALLE
                $grupos = $request->input('grupos');
                foreach($grupos as $grupo_id){
                    Paquete_detalle::create([
                        'paquete_id'    => $paquete_id,
                        'grupo_id'       => $grupo_id
                    ]);
                }
                alert('Escuela Modelo', 'El paquete se ha creado con éxito','success');
                return redirect('paquete');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Error...'.$errorCode, $errorMessage)
                ->showConfirmButton();
                return redirect('paquete/create')->withInput();
            }
        }
    }

     /**
     * Show cursos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaquetes(Request $request, $curso_id)
    {
        if($request->ajax()){
            $curso = Curso::with('cgt.periodo','cgt.plan.programa','alumno.persona')->where('id',$curso_id)->first();
            $paquetes = Paquete::where([
                ['periodo_id', '=', $curso->cgt->periodo_id],
                ['plan_id', '=', $curso->cgt->plan_id],
                ['semestre', '=', $curso->cgt->cgtGradoSemestre]
            ])->get();
            return response()->json($paquetes);
        }
    }

    /**
     * Show cursos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaqueteDetalle(Request $request, $paquete_id)
    {
        if($request->ajax()){
            $paquetes = Paquete_detalle::with('grupo.materia','grupo.empleado.persona','grupo.cgt.plan.programa','grupo.cgt.periodo')->where('paquete_id',$paquete_id)->get();
            return response()->json($paquetes);
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
        $paquete = Paquete::with('plan.programa','periodo')->findOrFail($id);
        $paquetes = Paquete_detalle::with('grupo.materia','grupo.empleado.persona','grupo.plan.programa','grupo.periodo')->where('paquete_id',$paquete->id)->get();
        return view('paquete.show',compact('paquete','paquetes'));
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
        $paquete = Paquete::with('plan.programa','periodo')->findOrFail($id);
        $paquetes = Paquete_detalle::with('grupo.materia','grupo.empleado.persona','grupo.plan.programa','grupo.periodo')->where('paquete_id',$paquete->id)->get();
        $gruposSemestre = Grupo::with('materia','empleado.persona')->where('gpoSemestre',$paquete->semestre)->where('plan_id',$paquete->plan_id)->where('periodo_id',$paquete->periodo_id)->get();
        //VALIDA PERMISOS EN EL PROGRAMA
        if(Utils::validaPermiso('paquete',$paquete->plan->programa_id)){
            alert()
            ->error('Ups...', 'Sin privilegios en el programa!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('paquete');
        }else{
            return view('paquete.edit',compact('paquete','paquetes','gruposSemestre'));
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
        $periodo_id = $request->input('periodo_id');
        $plan_id = $request->input('plan_id');
        $semestre = $request->input('semestre_id');
        //CUENTA CUANTOS PAQUETES HAY
        $count_paquetes = Paquete::where([['periodo_id',$periodo_id],['plan_id',$plan_id],['semestre',$semestre]])->count();
        //SE CREA EL CONSECUTIVO DEL PAQUETE
        $consecutivo = $count_paquetes + 1;
        $validator = Validator::make($request->all(),
            [
                'periodo_id'    => 'required',
                'plan_id'       => 'required',
                'semestre_id'   => 'required'
            ]
        );
        if ($validator->fails()) {
            return redirect('paquete/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                //ELIMINAR LOS PAQUETES ACTUALES
                foreach (Paquete_detalle::where('paquete_id',$id)->get() as $paquete_detalle) {
                    $paquete_detalle->delete();
                }
                //INSERTA LOS GRUPOS EN PAQUETE DETALLE
                $grupos = $request->input('grupos');
                foreach($grupos as $grupo_id){
                    Paquete_detalle::create([
                        'paquete_id'    => $id,
                        'grupo_id'       => $grupo_id
                    ]);
                }
                alert('Escuela Modelo', 'El paquete se ha actualizado con éxito','success');
                return redirect('paquete');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Error...'.$errorCode, $errorMessage)
                ->showConfirmButton();
                return redirect('paquete/'.$id.'/edit')->withInput();
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
        $paquete = Paquete::findOrFail($id);
        try {
            $programa_id = $paquete->plan->programa_id;
            if(Utils::validaPermiso('paquete',$programa_id)){
                alert()
                ->error('Ups...', 'Sin privilegios en el programa!')
                ->showConfirmButton()
                ->autoClose(5000);
                return redirect('paquete');
            }
            if($paquete->delete()){
                alert('Escuela Modelo', 'El paquete se ha eliminado con éxito','success');
            }else{
                alert()
                ->error('Error...', 'No se puedo eliminar el paquete')
                ->showConfirmButton();
            }
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
        }
        return redirect('paquete');
    }
}
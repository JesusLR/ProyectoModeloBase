<?php

namespace App\Http\Controllers\Bachiller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_grupos;
use App\Http\Models\Bachiller\Bachiller_paquete_detalle;
use App\Http\Models\Bachiller\Bachiller_paquetes;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Debugbar;

use App\Http\Models\Cgt;
use App\Http\Models\Grupo;
use App\Http\Models\Curso;
use App\Http\Models\Paquete;
use App\Http\Models\Paquete_detalle;
use App\Http\Models\Ubicacion;

class BachillerPaqueteController extends Controller
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
        return view('bachiller.paquete.show-list');
    }

    /**
     * Show paquete list.
     *
     */
    public function list()
    {
        $paquetes = Bachiller_paquetes::select('bachiller_paquetes.id as paquete_id','periodos.perNumero', 'periodos.perAnio', 'planes.planClave',
            'programas.progNombre','consecutivo','semestre','ubicacion.ubiNombre', 'ubicacion.ubiClave', 'vw_bachiller_paquetes_paquetedetalle.num_grupo')
            ->join('periodos', 'bachiller_paquetes.periodo_id', '=', 'periodos.id')
            ->join('planes', 'bachiller_paquetes.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('vw_bachiller_paquetes_paquetedetalle', 'vw_bachiller_paquetes_paquetedetalle.bachiller_paquete_id', '=', 'bachiller_paquetes.id')
            ->latest('bachiller_paquetes.created_at');
            

        return Datatables::of($paquetes)
            // ->addColumn('num_grupo', function($query) {
            //     $num_grupo = Paquete_detalle::where('paquete_id', $query->paquete_id)->count();
            //     return $num_grupo;
            // })
            ->addColumn('action',function($query) {

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                $sistemas = Auth::user()->departamento_sistemas;

                $btnEditar = "";
                $btnEliminar = "";

                if($ubicacion == $query->ubiClave || $sistemas == 1){
                    $btnEditar = '<a href="bachiller_paquete/' . $query->paquete_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';

                    $btnEliminar ='<form id="delete_'.$query->paquete_id.'" action="bachiller_paquete/' . $query->paquete_id . '" method="POST" style="display: inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token().'">
                        <a href="#" data-id="' . $query->paquete_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }
                return '<a href="bachiller_paquete/' . $query->paquete_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                .$btnEditar
                .$btnEliminar;
            })
        ->make(true);
    }

    public function getCgtsGrupos(Request $request, $plan, $periodo, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);

            $grupos = Bachiller_grupos::with('bachiller_materia', 'bachiller_empleado')
                ->where([
                    ['plan_id', '=', $plan],
                    ['periodo_id', '=', $periodo],
                    ['gpoGrado', '=', $cgt->cgtGradoSemestre],
                    ['gpoClave', '=', $cgt->cgtGrupo],
                    ['gpoTurno', '=', $cgt->cgtTurno]
                ])
                ->whereHas('bachiller_materia', function($query) use ($request) {
                        $query->orderBy('matOrdenVisual');
                       
                })
                // ->whereHas('bachiller_materia', function($query) use ($request) {
                //     $query->whereNull('matComplementaria');
                   
                // })
            ->get();

            return response()->json($grupos);
        }
    }

    public function getCgtsGruposTodos(Request $request, $plan, $periodo, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);

            $grupos = Bachiller_grupos::with('bachiller_materia', 'bachiller_empleado')
                ->where([
                    ['plan_id', '=', $plan],
                    ['periodo_id', '=', $periodo],
                    ['gpoGrado', '=', $cgt->cgtGradoSemestre]
                ])
                ->orderBy('gpoClave', 'ASC')
                ->whereHas('bachiller_materia', function($query) use ($request) {
                        $query->orderBy('matOrdenVisual', 'ASC');                       
                })
                ->whereHas('bachiller_empleado', function($query) use ($request) {
                    $query->orderBy('empApellido1', 'ASC');   
                    $query->orderBy('empApellido2', 'ASC');                     
                })
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        return view('bachiller.paquete.create',compact('ubicaciones'));
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
        $cgt_id = $request->input('cgt_id');

        // obtenemos el cgt para tomar el grado 
        $cgt = Cgt::findOrFail($cgt_id);
        $semestre = $cgt->cgtGradoSemestre;
        //CUENTA CUANTOS PAQUETES HAY
        $count_paquetes = Bachiller_paquetes::where([['periodo_id',$periodo_id],['plan_id',$plan_id],['semestre',$semestre]])->count();
        //SE CREA EL CONSECUTIVO DEL PAQUETE
        $consecutivo = $count_paquetes + 1;
        $validator = Validator::make($request->all(),
            [
                'periodo_id'    => 'required|unique:bachiller_paquetes,periodo_id,NULL,id,plan_id,'.$request->input('plan_id').',semestre,'.$semestre.',consecutivo,'.$consecutivo.',deleted_at,NULL',
                'plan_id'       => 'required',
                'cgt_id'   => 'required'
            ],
            [
                'periodo_id.unique' => "El paquete ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect('bachiller_paquete/create')->withErrors($validator)->withInput();
        } else {
            try {
                $programa_id = $request->input('programa_id');
                // if(Utils::validaPermiso('paquete',$programa_id)){
                //     alert()
                //     ->error('Ups...', 'Sin privilegios en el programa!')
                //     ->showConfirmButton()
                //     ->autoClose(5000);
                //     return redirect()->to('paquete/create');
                // }
                //INSERTA PAQUETE
                $paquete_id = Bachiller_paquetes::create([
                    'periodo_id'    => $periodo_id,
                    'plan_id'       => $plan_id,
                    'cgt_id'        => $cgt_id,
                    'semestre'      => $semestre,
                    'consecutivo'   => $consecutivo
                ])->id;
                //INSERTA LOS GRUPOS EN PAQUETE DETALLE
                $grupos = $request->input('grupos');
                foreach($grupos as $grupo_id){
                    Bachiller_paquete_detalle::create([
                        'bachiller_paquete_id'    => $paquete_id,
                        'bachiller_grupo_id'       => $grupo_id
                    ]);
                }
                alert('Escuela Modelo', 'El paquete se ha creado con éxito','success')->autoClose('6000')->showConfirmButton()->autoClose('6000');;
                return redirect('bachiller_paquete');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Error...'.$errorCode, $errorMessage)
                ->showConfirmButton();
                return redirect('bachiller_paquete/create')->withInput();
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
            $paquetes = Bachiller_paquetes::where([
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
            $paquetes = Bachiller_paquete_detalle::with('bachiller_grupo_yucatan.bachiller_materia','bachiller_grupo_yucatan.bachiller_empleado','bachiller_grupo_yucatan.cgt.plan.programa','bachiller_grupo_yucatan.cgt.periodo')->where('bachiller_paquete_id',$paquete_id)->get();
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
        $paquete = Bachiller_paquetes::with('plan.programa','periodo', 'cgt')->findOrFail($id);
        $paquetes = Bachiller_paquete_detalle::with('bachiller_grupo_yucatan.bachiller_materia','bachiller_grupo_yucatan.bachiller_empleado','bachiller_grupo_yucatan.plan.programa','bachiller_grupo_yucatan.periodo')
        ->where('bachiller_paquete_id',$paquete->id)->get();


        $variable_tipo_cgt = $paquetes[0]->bachiller_grupo_yucatan->gpoGrado.'-'.$paquetes[0]->bachiller_grupo_yucatan->gpoClave.'-'.$paquetes[0]->bachiller_grupo_yucatan->gpoTurno;

        return view('bachiller.paquete.show',compact('paquete','paquetes', 'variable_tipo_cgt'));
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

        $paquete = Bachiller_paquetes::select(
            'bachiller_paquetes.id',
            'bachiller_paquetes.consecutivo',
            'bachiller_paquetes.semestre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'planes.id as plan_id',
            'cgt.id as cgt_id',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'cgt.cgtTurno',
            'planes.id as plan_id',
            'planes.planClave'
        )
        ->join('planes', 'bachiller_paquetes.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_paquetes.periodo_id', '=', 'periodos.id')
        ->join('cgt', 'bachiller_paquetes.cgt_id', '=', 'cgt.id')
        ->where('bachiller_paquetes.id', $id)
        ->whereNull('planes.deleted_at')
        ->whereNull('programas.deleted_at')
        ->whereNull('escuelas.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->whereNull('periodos.deleted_at')
        ->whereNull('cgt.deleted_at')
        ->whereNull('bachiller_paquetes.deleted_at')
        ->first();
        
        $paquetes = Bachiller_paquete_detalle::select(
            'bachiller_grupos.id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_grupos.gpoMatComplementaria',
            'bachiller_empleados.id as bachiller_empleado_id',
            'bachiller_empleados.empNombre',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoClave',
            'bachiller_grupos.gpoTurno'
        )
        ->join('bachiller_grupos', 'bachiller_paquete_detalle.bachiller_grupo_id', '=', 'bachiller_grupos.id')
        ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
        ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('bachiller_paquetes', 'bachiller_paquete_detalle.bachiller_paquete_id', '=', 'bachiller_paquetes.id')
        ->join('periodos', 'bachiller_paquetes.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_paquetes.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where('bachiller_paquetes.id',$paquete->id)
        ->get();

        $gruposSemestre = Bachiller_grupos::select(
            'bachiller_grupos.id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_grupos.gpoMatComplementaria',
            'bachiller_empleados.id as bachiller_empleado_id',
            'bachiller_empleados.empNombre',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoClave',
            'bachiller_grupos.gpoTurno'
        )
        ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
        ->where('bachiller_grupos.gpoGrado',$paquete->semestre)
        ->where('bachiller_grupos.plan_id',$paquete->plan_id)
        ->where('bachiller_grupos.periodo_id',$paquete->periodo_id)
        ->whereNull('bachiller_grupos.deleted_at')
        ->whereNull('bachiller_empleados.deleted_at')
        ->whereNull('bachiller_materias.deleted_at')
        ->get();
       
        
        //VALIDA PERMISOS EN EL PROGRAMA
        // if(Utils::validaPermiso('paquete',$paquete->plan->programa_id)){
        //     alert()
        //     ->error('Ups...', 'Sin privilegios en el programa!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('paquete');
        // }else{
            return view('bachiller.paquete.edit',compact('paquete','paquetes','gruposSemestre'));
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
        $periodo_id = $request->input('periodo_id');
        $plan_id = $request->input('plan_id');
        $semestre = $request->input('semestre_id');
        //CUENTA CUANTOS PAQUETES HAY
        $count_paquetes = Bachiller_paquetes::where([['periodo_id', $periodo_id], ['plan_id', $plan_id], ['semestre', $semestre]])->count();
        //SE CREA EL CONSECUTIVO DEL PAQUETE
        $consecutivo = $count_paquetes + 1;
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'    => 'required',
                'plan_id'       => 'required',
                'semestre_id'   => 'required'
            ]
        );
        if ($validator->fails()) {
            return redirect('bachiller_paquete/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                if ($request->input('grupos') != "") {
                    //ELIMINAR LOS PAQUETES ACTUALES
                    foreach (Bachiller_paquete_detalle::where('bachiller_paquete_id', $id)->get() as $paquete_detalle) {
                        $paquete_detalle->delete();
                    }
                    //INSERTA LOS GRUPOS EN PAQUETE DETALLE
                    $grupos = $request->input('grupos');


                    foreach ($grupos as $grupo_id) {
                        Bachiller_paquete_detalle::create([
                            'bachiller_paquete_id'    => $id,
                            'bachiller_grupo_id'       => $grupo_id
                        ]);
                    }

                    alert('Escuela Modelo', 'El paquete se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('6000');;
                    return redirect('bachiller_paquete');
                } else {
                    alert('Escuela Modelo', 'No ha podido actualizar el paquete debido que no tiene grupos materias agregadas', 'warning')->showConfirmButton()->autoClose('6000');
                    return redirect('bachiller_paquete/' . $id . '/edit')->withErrors($validator)->withInput();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Error...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_paquete/' . $id . '/edit')->withInput();
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
        $paquete = Bachiller_paquetes::findOrFail($id);
        try {
            // $programa_id = $paquete->plan->programa_id;
            // if(Utils::validaPermiso('paquete',$programa_id)){

            //     alert()
            //     ->error('Ups...', 'Sin privilegios en el programa!')
            //     ->showConfirmButton()
            //     ->autoClose(5000);
            //     return redirect('paquete');
            // }
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
        return redirect('bachiller_paquete');
    }
}
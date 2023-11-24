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

use App\Models\Acuerdo;
use App\Models\Ubicacion;
use App\Models\User;

class AcuerdoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:acuerdo',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('acuerdo.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $acuerdos = Acuerdo::select('acuerdos.id as acuerdo_id','acuerdos.acuNumero','planes.planClave','programas.progClave','escuelas.escClave','departamentos.depClave','ubicacion.ubiClave')
        ->join('planes', 'acuerdos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return Datatables::of($acuerdos)->addColumn('action',function($query){
            return '<a href="acuerdo/' . $query->acuerdo_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="acuerdo/' . $query->acuerdo_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        }) ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("acuerdo") == "A" || User::permiso("acuerdo") == "B") {
            $ubicaciones = Ubicacion::all();
            return View('acuerdo.create',compact('ubicaciones'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('acuerdo');
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
                'plan_id'       => 'required|unique:acuerdos,plan_id,NULL,id,deleted_at,NULL',
                'acuNumero'     => 'required',
                'acuFecha'      => 'required',
                'acuEstadoPlan' => 'required'
            ],
            [
                'plan_id.unique' => "El Acuerdo ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('acuerdo/create')->withErrors($validator)->withInput();
        } else {
            $programa_id = $request->input('programa_id');
            if(Utils::validaPermiso('acuerdo',$programa_id)){
                alert()
                ->error('Ups...', 'Sin privilegios en el programa!')
                ->showConfirmButton()
                ->autoClose(5000);
                return redirect()->to('acuerdo/create');
            }
            try {
                $acuerdo = Acuerdo::create([
                    'plan_id'       => $request->input('plan_id'),
                    'acuNumero'     => $request->input('acuNumero'),
                    'acuFecha'      => $request->input('acuFecha'),
                    'acuEstadoPlan' => $request->input('acuEstadoPlan')
                ]);
                alert('Escuela Modelo', 'El Acuerdo se ha creado con éxito','success');
                return redirect('acuerdo');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('acuerdo/create')->withInput();
            }
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
        $acuerdo = Acuerdo::with('plan')->findOrFail($id);
        return view('acuerdo.show',compact('acuerdo'));
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
        if (User::permiso("acuerdo") == "A" || User::permiso("acuerdo") == "B") {
            $acuerdo = Acuerdo::with('plan')->findOrFail($id);
            return view('acuerdo.edit',compact('acuerdo'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('acuerdo');
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
                'acuNumero'     => 'required',
                'acuFecha'      => 'required',
                'acuEstadoPlan' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('acuerdo/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            $programa_id = $request->input('programa_id');
            if(Utils::validaPermiso('acuerdo',$programa_id)){
                alert()
                ->error('Ups...', 'Sin privilegios en el programa!')
                ->showConfirmButton()
                ->autoClose(5000);
                return redirect()->to('acuerdo/'.$id.'/edit');
            }
            try {
                $acuerdo = Acuerdo::findOrFail($id);
                $acuerdo->acuNumero     = $request->input('acuNumero');
                $acuerdo->acuFecha      = $request->input('acuFecha');
                $acuerdo->acuEstadoPlan = $request->input('acuEstadoPlan');
                $acuerdo->save();
                alert('Escuela Modelo', 'El Acuerdo se ha actualizado con éxito','success');
                return redirect('acuerdo');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('acuerdo/'.$id.'/edit')->withInput();
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
        if (User::permiso("acuerdo") == "A" || User::permiso("acuerdo") == "B") {
            $acuerdo = Acuerdo::findOrFail($id);
            try {
                $programa_id = $acuerdo->plan->programa_id;
                if(Utils::validaPermiso('acuerdo',$programa_id)){
                    alert()
                    ->error('Ups...', 'Sin privilegios en el programa!')
                    ->showConfirmButton()
                    ->autoClose(5000);
                }
                if($acuerdo->delete()){
                    alert('Escuela Modelo', 'El acuerdo se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el acuerdo')
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
        return redirect('acuerdo');
    }
}
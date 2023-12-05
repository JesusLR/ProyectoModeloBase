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

use App\Models\ClaveProfesor;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\User;

class ClaveProfesorController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:clave_profesor',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('clave_profesor.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $clavesProfesores = ClaveProfesor::select('clavesprofesores.id as claveProfesor_id', 'clavesprofesores.cpClaveSegey',
            'ubicacion.ubiNombre', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2', 'empleados.id as empleadoId')
            ->join('empleados', 'clavesprofesores.empleado_id', '=', 'empleados.id')
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            ->join('ubicacion', 'clavesprofesores.ubicacion_id', '=', 'ubicacion.id')
            ->latest('clavesprofesores.created_at');

        return Datatables::of($clavesProfesores)
        ->filterColumn('nombreCompleto', function ($query,$keyword) {
            return $query->whereHas('empleado.persona', function($query) use($keyword){
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto', function($query) {
            return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
        })
        ->addColumn('action', function($query) {
            return '<div class="row">
                <div class="col s1">
                <a href="clave_profesor/' . $query->claveProfesor_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
                </a>
                </div>
                <div class="col s1">
                <a href="clave_profesor/' . $query->claveProfesor_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                </div>
            </div>';
        }) ->make(true);
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
        $claveProfesor = ClaveProfesor::with('ubicacion','empleado.persona')->findOrFail($id);
        return view('clave_profesor.show',compact('claveProfesor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("clave_profesor") == "A" || User::permiso("clave_profesor") == "B") {
            $ubicaciones = Ubicacion::get();
            $empleados = Empleado::with('persona')->get();
            return View('clave_profesor.create', compact('ubicaciones','empleados'));
        }

        alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(2000);
        return redirect('clave_profesor');
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
                'ubicacion_id'  => 'required|unique:clavesprofesores,empleado_id,NULL,id,empleado_id,'.$request->input('empleado_id').',deleted_at,NULL',
                'empleado_id'   => 'required',
                'cpClaveSegey'  => 'required'
            ],
            [
                'ubicacion_id.unique' => "La clave de profesión ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('clave_profesor/create')->withErrors($validator)->withInput();
        }

        $existeClaveProfesor = ClaveProfesor::where("cpClaveSegey", "=", $request->cpClaveSegey)->first();
        if ($existeClaveProfesor) {
            alert()->error('Ups...', "Ya existe esta clave de profesor, prueba con otra clave")->autoClose(5000)->showConfirmButton();
            return back()->withInput();
        }


        try {
            ClaveProfesor::create([
                'ubicacion_id'  => $request->ubicacion_id,
                'empleado_id'   => $request->empleado_id,
                'cpClaveSegey'  => $request->cpClaveSegey
            ]);
            alert('Escuela Modelo', 'La clave de profesor se ha creado con éxito','success');

            return redirect('clave_profesor');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('clave_profesor/create')->withInput();
        }
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
        if (User::permiso("clave_profesor") == "A" || User::permiso("clave_profesor") == "B") {
            $claveProfesor = ClaveProfesor::with('ubicacion','empleado.persona')->findOrFail($id);
            return view('clave_profesor.edit',compact('claveProfesor'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('clave_profesor');
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
        $existeClaveProfesor = ClaveProfesor::where("cpClaveSegey", "=", $request->cpClaveSegey)->first();
        if ($existeClaveProfesor) {
            alert()->error('Ups...', "Ya existe esta clave de profesor, prueba con otra clave")->autoClose(5000)->showConfirmButton();
            return back()->withInput();
        }

        try {
            $claveProfesor = ClaveProfesor::findOrFail($id);
            $claveProfesor->cpClaveSegey = $request->input('cpClaveSegey');
            $claveProfesor->save();
            alert('Escuela Modelo', 'La clave de profesor se ha actualizado con éxito','success');
            return redirect('clave_profesor');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('clave_profesor/'.$id.'/edit')->withInput();
        }
    }

}
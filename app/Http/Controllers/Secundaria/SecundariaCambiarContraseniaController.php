<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Secundaria\Secundaria_empleados;
use App\Models\User_docente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class SecundariaCambiarContraseniaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('secundaria.cambiar_contrasenia.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = Secundaria_empleados::select(             
            'secundaria_empleados.id as empleado_id',
            'secundaria_empleados.empNombre',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empCorreo1',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('escuelas', 'secundaria_empleados.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', '=', 'SEC')
        ->get();

        return view('secundaria.cambiar_contrasenia.create', [
            'empleados' => $empleados
        ]);
    }

    public function getEmpleadoCorreo(Request $request, $id)
    {

        if($request->ajax()){

            $empleados = Secundaria_empleados::select(             
                'secundaria_empleados.id',
                'secundaria_empleados.empNombre',
                'secundaria_empleados.empApellido1',
                'secundaria_empleados.empApellido2',
                'secundaria_empleados.empCorreo1',
                'escuelas.escNombre',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre'
            )
            ->join('escuelas', 'secundaria_empleados.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('secundaria_empleados.id', '=', $id)
            ->get();
         

            return response()->json($empleados);
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
        

        $validator = Validator::make($request->all(), [
            'password'          =>  'required|min:8|max:20|regex:/^.*?(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/',
            'confirmPassword'   =>  'required|same:password',
            'empleado_id' => 'required|unique:users_docentes'
        ], [
            'confirmPassword.same'     => 'Ambos campos de contraseña deben coincidir.',
            'password.required'        => 'La contraseña nueva es requerida.',
            'confirmPassword.required' => 'La contraseña de verificación es requerida.',
            'password.regex' => 'La contraseña debe tener al menos una Mayúscula, una minúscula y un número.',
            'empleado_id.unique' => 'El empleado ya se encuentra registrado'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $secundaria_empleado = Secundaria_empleados::findOrfail($request->empleado_id);
        // validamos escuela_id para saber que campos habilitar 
        if($secundaria_empleado->escuela_id == "21"){
            $campus_cme = 1;
        }else{
            $campus_cme = 0;
        }

        if($secundaria_empleado->escuela_id == "22"){
            $campus_cva = 1;
        }else{
            $campus_cva = 0;
        }

        $docente = User_docente::create([
            'empleado_id' => $request->empleado_id,
            'password'    => Hash::make($request->password),
            'token'       => str_random(64),
            'maternal'    => 0,
            'preescolar'  => 0,            
            'secundaria'  => 1,
            'bachiller'   => 0,
            'superior'    => 0,
            'posgrado'    => 0, 
            'educontinua' => 0,
            'departamento_cobranza' => 0,
            'campus_cme'  => $campus_cme,
            'campus_cva'  => $campus_cva
        ]);
        
        $empleado = Secundaria_empleados::where('id', $request->empleado_id)->first();
        $empleado->update([
            'empCorreo1' => $request->empCorreo1
        ]);
        

        alert()->success('Escuela Modelo', 'Contraseña guardada correctamente.')->showConfirmButton();
        return redirect('secundaria_cambiar_contrasenia');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $docente = User_docente::findOrFail($id);
        $empleado = Secundaria_empleados::where('id', $docente->empleado_id)->first();

        return view('secundaria.cambiar_contrasenia.show', [
            'docente' => $docente,
            'empleado' => $empleado,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $docente = User_docente::findOrFail($id);

        $empleado = Secundaria_empleados::where('id', $docente->empleado_id)->first();

        return view('secundaria.cambiar_contrasenia.edit', [
            'docente' => $docente,
            'empleado' => $empleado
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password'          =>  'required|min:8|max:20|regex:/^.*?(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/',
            'confirmPassword'   =>  'required|same:password',
        ], [
            'confirmPassword.same'     => 'Ambos campos de contraseña deben coincidir.',
            'password.required'        => 'La contraseña nueva es requerida.',
            'confirmPassword.required' => 'La contraseña de verificación es requerida.',
            'password.regex' => 'La contraseña debe tener al menos una Mayúscula, una minúscula y un número.',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        $secundaria_empleado = Secundaria_empleados::findOrfail($request->empleado_id);

        // validamos escuela_id para saber que campos habilitar 
        if($secundaria_empleado->escuela_id == "21"){
            $campus_cme = 1;
        }else{
            $campus_cme = 0;
        }

        if($secundaria_empleado->escuela_id == "22"){
            $campus_cva = 1;
        }else{
            $campus_cva = 0;
        }

        $docente = User_docente::findOrFail($id)->update([
            'password' => Hash::make($request->password),
            'secundaria'  => 1,
            'campus_cme'  => $campus_cme,
            'campus_cva'  => $campus_cva
        ]);

        alert()->success('Escuela Modelo', 'Contraseña guardada correctamente.')->showConfirmButton();
        return redirect('secundaria_cambiar_contrasenia');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list() {

        $docentes = User_docente::select(
            'users_docentes.id', 
            'secundaria_empleados.id as empleado_id',
            'secundaria_empleados.empNombre',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empCorreo1',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('secundaria_empleados', 'users_docentes.empleado_id', '=', 'secundaria_empleados.id')
        ->join('escuelas', 'secundaria_empleados.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', '=', 'SEC')
        ->latest('users_docentes.created_at');

        return DataTables::eloquent($docentes)
        
        ->filterColumn('empleadoID', function ($query, $keyword) {
            $query->whereRaw("CONCAT(secundaria_empleados.id) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('empleadoID', function ($query) {
            return $query->empleado_id;
        })

        ->filterColumn('nombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('nombre', function ($query) {
            return $query->empNombre;
        })

        ->filterColumn('apellido1', function ($query, $keyword) {
            $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('apellido1', function ($query) {
            return $query->empApellido1;
        })

        ->filterColumn('apellido2', function ($query, $keyword) {
            $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('apellido2', function ($query) {
            return $query->empApellido2;
        })


        ->filterColumn('ubicacion', function($query, $keyword) {
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('ubicacion', function($query) {
            return $query->ubiNombre;
        })

        ->filterColumn('correo_empleado', function($query, $keyword) {
            $query->whereRaw("CONCAT(empCorreo1) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('correo_empleado', function($query) {
            return $query->empCorreo1;
        })

        ->filterColumn('departamento', function($query, $keyword) {
            $query->whereRaw("CONCAT(depNombre) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('departamento', function($query) {
            return $query->depNombre;
        })


       
        ->addColumn('action', static function(User_docente $docente) {
            $action_url = '/secundaria_cambiar_contrasenia';


            $ubicacion_clave = Auth::user()->empleado->escuela->departamento->ubicacion->ubiNombre;
            $usuario_sistema =  auth()->user()->departamento_sistemas;

            $btnEditar = "";

            if($ubicacion_clave == $docente->ubiNombre || $usuario_sistema == 1){
                $btnEditar = Utils::btn_edit($docente->id, $action_url);
            }

            return '<div class="row">'
                        .Utils::btn_show($docente->id, $action_url)
                        .$btnEditar.
                   '</div>';
        })  
        ->make(true);
    }//list.

}//Controller class

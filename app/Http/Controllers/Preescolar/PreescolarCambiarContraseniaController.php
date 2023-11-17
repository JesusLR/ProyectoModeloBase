<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Empleado;
use App\Http\Models\Persona;
use App\Models\User_docente;
use Illuminate\Support\Facades\Hash;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class PreescolarCambiarContraseniaController extends Controller
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
        return view('preescolar.cambiar_contrasenia.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = Empleado::select(             
            'empleados.id',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'empleados.empCorreo1',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('escuelas', 'empleados.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
        ->get();

        return view('preescolar.cambiar_contrasenia.create', [
            'empleados' => $empleados
        ]);
    }

    public function getEmpleadoCorreo(Request $request, $id)
    {

        if($request->ajax()){

            $empleados = Empleado::select(             
                'empleados.id',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'empleados.empCorreo1',
                'escuelas.escNombre',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre'
            )
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            ->join('escuelas', 'empleados.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('empleados.id', '=', $id)
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $preescolar_empleado = Empleado::select('ubicacion.ubiClave as ubicacion', 'escuelas.escClave')
        ->join('escuelas', 'empleados.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('empleados.id', $request->empleado_id)->first();

        // validamos escuela_id para saber que campos habilitar 
        if($preescolar_empleado->ubicacion == "CME"){
            $campus_cme = 1;
        }else{
            $campus_cme = 0;
        }

        if($preescolar_empleado->ubicacion == "CVA"){
            $campus_cva = 1;
        }else{
            $campus_cva = 0;
        }

        if($preescolar_empleado->ubicacion == "CCH"){
            $campus_cch = 1;
        }else{
            $campus_cch = 0;
        }

        if($preescolar_empleado->escClave == "MAT"){
            $maternal = 1;
        }else{
            $maternal = 0;
        }

        if($preescolar_empleado->escClave == "PRE"){
            $preescolar = 1;
        }else{
            $preescolar = 0;
        }

        $docente = User_docente::create([
            'empleado_id' => $request->empleado_id,
            'password'    => Hash::make($request->password),
            'token'       => str_random(64),
            'maternal' => $maternal,
            'preescolar' => $preescolar,
            'bachiller'  => 0,
            'superior'  => 0,
            'posgrado'  => 0,
            'educontinua' => 0,
            'campus_cme'  => $campus_cme,
            'campus_cva'  => $campus_cva,
            'campus_cch'  => $campus_cch
        ]);
   

        $empleado = Empleado::where('id', $request->empleado_id)->first();
        $empleado->update([
            'empCorreo1' => $request->empCorreo1
        ]);
        
        

        alert()->success('Escuela Modelo', 'Contraseña guardada correctamente.')->showConfirmButton();
        return redirect('preescolar_cambiar_contrasenia');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $docente = User_docente::findOrFail($id);
        $empleado = Empleado::where('id', $docente->empleado_id)->first();
        $persona = Persona::where('id', $empleado->persona_id)->first();

        return view('preescolar.cambiar_contrasenia.show', [
            'docente' => $docente,
            'empleado' => $empleado,
            'persona' => $persona
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
        $empleado = Empleado::where('id', $docente->empleado_id)->first();
        $persona = Persona::where('id', $empleado->persona_id)->first();

        return view('preescolar.cambiar_contrasenia.edit', [
            'docente' => $docente,
            'empleado' => $empleado,
            'persona' => $persona
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
        //
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $preescolar_empleado = Empleado::select('ubicacion.ubiClave as ubicacion', 'escuelas.escClave')
        ->join('escuelas', 'empleados.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('empleados.id', $request->empleado_id)->first();

          // validamos escuela_id para saber que campos habilitar 
          if($preescolar_empleado->ubicacion == "CME"){
            $campus_cme = 1;
        }else{
            $campus_cme = 0;
        }

        if($preescolar_empleado->ubicacion == "CVA"){
            $campus_cva = 1;
        }else{
            $campus_cva = 0;
        }

        if($preescolar_empleado->ubicacion == "CCH"){
            $campus_cch = 1;
        }else{
            $campus_cch = 0;
        }

        if($preescolar_empleado->escClave == "MAT"){
            $maternal = 1;
        }else{
            $maternal = 0;
        }

        if($preescolar_empleado->escClave == "PRE"){
            $preescolar = 1;
        }else{
            $preescolar = 0;
        }

        $docente = User_docente::findOrFail($id)->update([
            'maternal' => $maternal,
            'preescolar' => $preescolar,      
            'campus_cme'  => $campus_cme,
            'campus_cva'  => $campus_cva,
            'campus_cch'  => $campus_cch,
            'password' => Hash::make($request->password)
            ]);

        alert()->success('Escuela Modelo', 'Contraseña guardada correctamente.')->showConfirmButton();
        return redirect('preescolar_cambiar_contrasenia');
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
            'empleados.id as empleado_id',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'empleados.empCorreo1',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('empleados', 'users_docentes.empleado_id', '=', 'empleados.id')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('escuelas', 'empleados.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
        ->latest('users_docentes.created_at');

        return DataTables::eloquent($docentes)      

        ->filterColumn('empleadoID', function($query, $keyword) {
            $query->whereRaw("CONCAT(empleados.id) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('empleadoID', function($query) {
            return $query->empleado_id;
        })

        ->filterColumn('nombre', function($query, $keyword) {
            $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('nombre', function($query) {
            return $query->perNombre;
        })

        ->filterColumn('apellido1', function($query, $keyword) {
            $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('apellido1', function($query) {
            return $query->perApellido1;
        })

        ->filterColumn('apellido2', function($query, $keyword) {
            $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            
        })
        ->addColumn('apellido2', function($query) {
            return $query->perApellido2;
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
            $action_url = '/preescolar_cambiar_contrasenia';

            return '<div class="row">'
                        .Utils::btn_show($docente->id, $action_url)
                        .Utils::btn_edit($docente->id, $action_url).
                   '</div>';
        })  
        ->make(true);
    }//list.

}//Controller class

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User_docente;
use App\Http\Helpers\Utils;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class CambiarContrasenaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permisos:cambiar_contrasena');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('cambiar_contrasena.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('cambiar_contrasena.show', ['docente' => $docente]);
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
        return view('cambiar_contrasena.edit', ['docente' => $docente]);
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
            return redirect()->back()->withErrors($validator);
        }

        $docente = User_docente::findOrFail($id)->update(['password' => Hash::make($request->password)]);

        alert()->success('Escuela Modelo', 'Contraseña guardada correctamente.')->showConfirmButton();
        return redirect('cambiar_contrasena');
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

        $docentes = User_docente::with('empleado.persona')->select('users_docentes.*')
        ->has('empleado')
        ->latest('users_docentes.created_at');

        return DataTables::eloquent($docentes)
        ->filterColumn('nombreCompleto', static function($query, $keyword) {
            return $query->whereHas('empleado.persona', static function($query) use ($keyword) {
                return $query->whereRaw("CONCAT_WS(' ',perNombre,perApellido1,perApellido2) LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto', static function(User_docente $docente) {
            $persona = $docente->empleado->persona;
            return $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;
        })
        ->addColumn('action', static function(User_docente $docente) {
            $action_url = '/cambiar_contrasena';

            return '<div class="row">'
                        .Utils::btn_show($docente->id, $action_url)
                        .Utils::btn_edit($docente->id, $action_url).
                   '</div>';
        })  
        ->make(true);
    }//list.

}//Controller class

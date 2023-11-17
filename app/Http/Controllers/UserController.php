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

use App\Models\User;
use App\Http\Models\Empleado;
use App\Models\Modules;
use App\Models\Permission;
use App\Models\Permission_module_user;
use App\Http\Models\Ubicacion;
use App\Http\Models\Permiso_programa_user;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:usuario', ['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('usuario.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $users = User::with(['empleado' => function($empleados){
            $empleados->with(['persona' => function($personas){
                $personas->select('personas.id','personas.perNombre','personas.perApellido1','personas.perApellido2');
            }]);
            $empleados->select('empleados.id','empleados.empCredencial','empleados.persona_id');
        }])->select('users.id','users.username','users.empleado_id');

        return Datatables::of($users)
        ->filterColumn('nombreCompleto',function($query,$keyword){
            return $query->whereHas('empleado.persona', function($query) use($keyword){
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query){
            return $query->empleado->persona->perNombre." ".$query->empleado->persona->perApellido1." ".$query->empleado->persona->perApellido2;
        })
        ->addColumn('action',function($users){
            return '<a href="usuario/'.$users->id.'" class="button button--icon js-button js-ripple-effect" title="Ver cuenta de usuario">
                <i class="material-icons">account_circle</i>
            </a>
            <a href="usuario/'.$users->id.'/edit" class="button button--icon js-button js-ripple-effect">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_'.$users->id.'" action="usuario/'.$users->id.'" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <a href="#" data-id="'.$users->id.'" class="button button--icon js-button js-ripple-effect confirm-delete">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        }) ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Modules::get();
        $permissions = Permission::orderBy('id')->get();
        //$empleados = Empleado::with('persona')->get();
        $empleados = Empleado::with('persona')->where("empleados.empEstado", "=", "A")->get();
        $ubicaciones = Ubicacion::get();
        return view('usuario.create',compact('modules','permissions','empleados','ubicaciones'));
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
                'empleado_id'           => 'required',
                'username'              => 'required|max:255|unique:users,username,NULL,id,deleted_at,NULL',
                'password'              => ['required','min:8','max:20','confirmed','regex:/^.*?(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/'],
                'password_confirmation' => 'same:password',

            ],
            [
                'username.unique'   => "El usuario ya existe",
                'password.min'      => 'La contraseña debe tener al menos 8 caracteres',
                'password.max'      => 'La longitud máxima de la contraseña es de 20 caracteres',
                'password.regex'    => 'La contraseña debe tener al menos una Mayúscula, una minúscula y un número.', 
            ]
        );

        if ($validator->fails()) {
            return redirect ('usuario/create')->withErrors($validator)->withInput();
        } else {
            try {
                $user = User::create([
                    'empleado_id'      => $request->input('empleado_id'),
                    'username'         => $request->input('username'),
                    'password'         => bcrypt($request->input('password')),
                    'token'            => str_random(64),
                ]);


                // GUARDAR PERMISOS DE MODULOS
                $modules = Modules::get();
                foreach($modules as $modulo){
                    $input = 'modulo-' . $modulo->id;
                    $permissions = Permission_module_user::create([
                        'permission_id'   => $request->input($input),
                        'module_id'       => $modulo->id,
                        'user_id'         => $user->id,
                    ]);
                }


                // GUARDAR PERMISOS DE USUARIO POR CARRERA
                if ($request->input('programas')) {
                    $programas = $request->input('programas');
                    foreach ($programas as $programa_id) {
                        Permiso_programa_user::create([
                            'user_id'       => $user->id,
                            'programa_id'   => $programa_id
                        ]);
                    }
                }


                alert('Escuela Modelo', 'El Usuario se ha creado con éxito','success')->showConfirmButton();
                return redirect('usuario');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect('usuario/create')->withInput();
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
        $user = User::findOrFail($id);
        $permissions_module_user = Permission_module_user::where('user_id',$user->id)->get();
        $permiso_programa_user = Permiso_programa_user::with('programa')->where('user_id',$user->id)->get();
        return view('usuario.show',compact('user','permissions_module_user','permiso_programa_user'));
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
        $modules = Modules::get();
        $permissions = Permission::orderByDesc('id')->get();
        $empleados = Empleado::with('persona')->get();
        $ubicaciones = Ubicacion::get();
        $user = User::findOrFail($id);
        $permissions_module_user = Permission_module_user::with('module','permission')->where('user_id',$user->id)->get();
        $permiso_programa_user = Permiso_programa_user::with('programa.escuela')->where('user_id',$user->id)->get();
        return view('usuario.edit',compact('user','permissions_module_user','permiso_programa_user','modules','permissions','empleados','ubicaciones'));
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
        $validacionPassword = "";
        $validacionPasswordConfirmacion = "";
        if ($request->password) {
            $validacionPassword = 'min:8|max:20|confirmed|regex:/^.*?(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/';
            $validacionPasswordConfirmacion = 'same:password';
        }


        $validator = Validator::make($request->all(),
            [
                'empleado_id'           => 'required',
                'username'              => 'required|max:255',
                'password'              => $validacionPassword,
                'password_confirmation' => $validacionPasswordConfirmacion,

            ],
            [
                'username.unique'   => "El usuario ya existe",
                'password.min'      => 'La contraseña debe tener al menos 8 caracteres',
                'password.max'      => 'La longitud máxima de la contraseña es de 20 caracteres',
                'password.regex'    => 'La contraseña debe tener al menos una Mayúscula, una minúscula y un número.',
            ]
        );

        if ($validator->fails()) {
            return redirect('usuario/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $user = User::findOrFail($id);
                $user->empleado_id  = $request->input('empleado_id');
                $user->username     = $request->input('username');

                if ($request->password) {
                    $user->password = bcrypt($request->input('password'));
                }


                // GUARDAR PERMISOS DE MODULOS
                $modules = Modules::get();
                foreach($modules as $modulo) {
                    $permission_module = Permission_module_user::where([['module_id',$modulo->id],['user_id',$id]])->first();
                    $input = 'modulo-' . $modulo->id;
                    $permission_module->permission_id  = $request->input($input);
                    $permission_module->save();
                }

                // GUARDAR PERMISOS DE USUARIO POR CARRERA

                if ($request->programas) {
                    $programas = $request->programas;
                    foreach ($programas as $programa_id) {

                        $permiso_programa = Permiso_programa_user::where([['programa_id',$programa_id],['user_id',$id]])->exists();
                        if (!$permiso_programa) {
                            Permiso_programa_user::create([
                                'user_id'       => $id,
                                'programa_id'   => $programa_id
                            ]);
                        }
                    }
                }

                $user->save();

                alert('Escuela Modelo', 'El Usuario se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect('usuario');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('usuario/'.$id.'/edit')->withInput();
            }
        }
    }

    public function removePermisoPrograma (Request $request)
    {

        $color = new Permiso_programa_user;
        DB::table("permisos_programas_user")->where( "id", "=", $request->permisoProgramaId )->first();

        return response()->json(["color" => $color, "permisoId" => $request->permisoProgramaId]);

        $borra = $color->delete();

        return response()->json($borra);
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

        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        if ($user->id != $currentUser->id) {
            $user->delete();
            alert('Escuela Modelo', 'El Usuario se ha eliminado con éxito','success')->showConfirmButton();
        }else{
            alert()->error('Error...', 'No se puede eliminar el propio usuario')->showConfirmButton();
        }
        return redirect('usuario');
    }
}
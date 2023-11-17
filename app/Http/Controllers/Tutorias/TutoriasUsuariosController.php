<?php

namespace App\Http\Controllers\Tutorias;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Tutorias\Tutorias_permiso_roles;
use App\Http\Models\Tutorias\Tutorias_permisos;
use App\Http\Models\Tutorias\Tutorias_roles;
use App\Http\Models\Tutorias\Tutorias_usuario;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class TutoriasUsuariosController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('permisos:tutoriasusuarios',['except' => ['index', 'list', 'create']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tutorias.usuarios.show-list');
    }

    public function list()
    {


        $usuarios = Tutorias_usuario::select(
            'tutorias_usuarios.UsuarioID',
            'tutorias_usuarios.Correo AS correo_usuario',            
            'tutorias_usuarios.Nombre',
            'tutorias_usuarios.ApellidoPaterno',
            'tutorias_usuarios.ApellidoMaterno',
            'tutorias_usuarios.NombreUsuario',
            'tutorias_alumnos.Matricula',
            'tutorias_alumnos.Correo AS correo_alumno',
            'tutorias_tutores.Nombre AS nombre_tutor',
            'tutorias_tutores.ApellidoPaterno AS apellidoP_tutor',
            'tutorias_tutores.ApellidoPaterno AS apellidoM_tutor',
            'tutorias_tutores.Correo AS correo_tutor',
            'tutorias_roles.Nombre AS nombre_rol'
        )
        ->leftJoin('tutorias_alumnos', 'tutorias_usuarios.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->leftJoin('tutorias_roles', 'tutorias_usuarios.RolID', '=', 'tutorias_roles.RolID')
        ->leftJoin('tutorias_tutores', 'tutorias_usuarios.TutorID', '=', 'tutorias_tutores.TutorID')
        ->orderBy("tutorias_roles.Nombre", "asc");

        return Datatables::of($usuarios)
            ->filterColumn('nombre_rol', function ($query, $keyword) {
                return $query->whereHas('tutorias_rol', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(nombre_rol) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombre_rol', function ($query) {
                return $query->nombre_rol;
            })
            ->addColumn('action', function ($usuarios) {
                $acciones = '';

                $acciones = '<a href="/tutorias_usuario/'.$usuarios->UsuarioID.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
                </a>
                
                <a href="/tutorias_usuario/' . $usuarios->UsuarioID . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                    
                <form id="delete_' . $usuarios->UsuarioID . '" action="tutorias_usuario/' . $usuarios->UsuarioID . '" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $usuarios->UsuarioID . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
                </form>
                    ';
                return $acciones;
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
        $rol = Tutorias_roles::get();

        $tutorias_permiso_rol = Tutorias_permiso_roles::get();

        $permisos = Tutorias_permisos::get();

        return view('tutorias.usuarios.create', [
            'rol' => $rol,
            'permisos' => $permisos,
            'tutorias_permiso_rol' => $tutorias_permiso_rol
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ContrasenaDes = $request->ContrasenaDes;
        $contrasenia = $request->Contrasena;

        $validator = Validator::make(
            $request->all(),
            [
                'Nombre' => 'required',

            ],
            []
        );

        if ($validator->fails()) {
            return redirect()->route('tutorias_usuario.create')->withErrors($validator)->withInput();
        } {
            try {

                if ($contrasenia == $ContrasenaDes) {
                    $contrasenia = encrypt($request->Contrasena);
                    $decrypted = decrypt($contrasenia);

                    Tutorias_usuario::create([
                        'Nombre' => $request->Nombre,
                        'ApellidoPaterno' => $request->ApellidoPaterno,
                        'ApellidoMaterno' => $request->ApellidoMaterno,
                        'NombreUsuario' => $request->NombreUsuario,
                        'Correo' => $request->Correo,
                        'Contrasena' => $contrasenia,
                        'ContrasenaDes' => $decrypted,
                        'Estatus' => 1,
                        'TokenApp' => null,
                        'Foto' => null,
                        'RolID' => $request->RolID,
                        'Eliminado' => 0,
                        'MunicipioID' => 490,
                        'Notificacion' => 1,
                        'Intentos' => 0
                    ]);

                    alert('Escuela Modelo', 'El usuario se creo con éxito', 'success')->showConfirmButton();
                    return redirect('tutorias_usuario');
                } else {
                    alert('Escuela Modelo', 'Las contraseñas no son iguales', 'error')->showConfirmButton();
                    return redirect('tutorias_usuario/create');
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

                return redirect()->route('tutorias_usuario.create')->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($UsuarioID)
    {
        $usuarios = Tutorias_usuario::select(
            'tutorias_usuarios.UsuarioID',
            'tutorias_usuarios.Nombre',
            'tutorias_usuarios.ApellidoPaterno',
            'tutorias_usuarios.ApellidoMaterno',
            'tutorias_usuarios.RolID',
            'tutorias_roles.Nombre AS NombreRol'
        )
        ->join('tutorias_roles', 'tutorias_usuarios.RolID', '=', 'tutorias_roles.RolID')
        ->where('tutorias_usuarios.UsuarioID', '=', $UsuarioID)
        ->firstOrFail();

        $permiso_rol = Tutorias_permiso_roles::select('tutorias_permiso_roles.PermisoID', 'tutorias_permiso_roles.RolID', 'tutorias_permiso_roles.PermisoRolID', 'tutorias_permisos.Nombre as nombrePermiso')
        ->join('tutorias_roles', 'tutorias_permiso_roles.RolID', '=', 'tutorias_roles.RolID')
        ->join('tutorias_permisos', 'tutorias_permiso_roles.PermisoID', '=', 'tutorias_permisos.PermisoID')
        ->where('tutorias_permiso_roles.RolID', '=', $usuarios->RolID)
        ->get();

        return view('tutorias.usuarios.show',[
            'usuarios' => $usuarios,
            'permiso_rol' => $permiso_rol
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($UsuarioID)
    {
        $rol = Tutorias_roles::get();

        $usuarios = Tutorias_usuario::select(
            'tutorias_usuarios.UsuarioID',
            'tutorias_usuarios.Nombre',
            'tutorias_usuarios.ApellidoPaterno',
            'tutorias_usuarios.ApellidoMaterno',
            'tutorias_usuarios.RolID',
            'tutorias_roles.Nombre AS NombreRol'
        )
        ->join('tutorias_roles', 'tutorias_usuarios.RolID', '=', 'tutorias_roles.RolID')
        ->where('tutorias_usuarios.UsuarioID', '=', $UsuarioID)
        ->firstOrFail();

        return view('tutorias.usuarios.edit', [
            'usuarios' => $usuarios,
            'rol' => $rol
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
}

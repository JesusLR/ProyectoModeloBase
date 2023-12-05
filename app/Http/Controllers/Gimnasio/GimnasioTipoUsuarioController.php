<?php

namespace App\Http\Controllers\Gimnasio;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\User_docente;
use App\Models\Persona;
use App\Models\Idiomas\Idiomas_grupos;
use App\Models\Alumno;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Idiomas\Idiomas_empleados;
use App\Models\Gimnasio\Gimnasio_tipos_usuario;
use App\Models\Municipio;
use App\Models\Ubicacion;
use App\Models\Puesto;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;


class GimnasioTipoUsuarioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:empleado',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('gimnasio.tipo_usuarios.show-list');
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $tipos = Gimnasio_tipos_usuario::select('*');

        return Datatables::of($tipos)
           
            ->addColumn('action', function($query) {

                $url = 'gimnasio_tipo_usuario';
                return '<div>'
                        .Utils::btn_show($query->id, $url)
                        .Utils::btn_edit($query->id, $url)
                   .'</div>';
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
        return view('gimnasio.tipo_usuarios.create');
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
                'tugClave'        => 'required',
                'tugDescripcion'        => 'required',
                'tugImporte'        => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ('gimnasio_tipo_usuario/create')->withErrors($validator)->withInput();
        }

        try {
            Gimnasio_tipos_usuario::create([
                'tugClave'             => $request->tugClave,
                'tugDescripcion'              => $request->tugDescripcion,
                'tugImporte'              => $request->tugImporte,
                'tugVigente'              => 'S',
            ]);

            alert('Escuela Modelo', 'El tipo de usuario se ha creado con éxito', 'success')->showConfirmButton();
                return redirect('gimnasio_tipo_usuario');

        }catch (QueryException $e){
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return redirect('gimnasio_tipo_usuario/create')->withInput();
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
        $tipo = Gimnasio_tipos_usuario::findOrFail($id);

        if ($tipo->id == 0 || $tipo->id == 1) {
            alert()->error('Ups...', 'El tipo de usuario no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('gimnasio.tipo_usuarios.show',compact('tipo'));
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
        $tipo = Gimnasio_tipos_usuario::findOrFail($id);

        if ($tipo->id == 0 || $tipo->id == 1) {
            alert()->error('Ups...', 'El tipo de usuario no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('gimnasio.tipo_usuarios.edit',compact('tipo'));
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
                'tugClave'        => 'required',
                'tugDescripcion'        => 'required',
                'tugImporte'        => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ('gimnasio_tipo_usuario/create')->withErrors($validator)->withInput();
        }

        try {
            $empleado = Gimnasio_tipos_usuario::findOrFail($id);
            
            $empleado->update([
                'tugClave'             => $request->tugClave,
                'tugDescripcion'              => $request->tugDescripcion,
                'tugImporte'              => $request->tugImporte,
                'tugVigente'              => $request->tugVigente,
            ]);

            alert('Escuela Modelo', 'El tipo usuario se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('gimnasio_tipo_usuario');
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();

            return redirect('gimnasio_tipo_usuario/' . $id . '/edit')->withInput();
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
        // if(!auth()->user()->isAdmin('empleado')) {
            alert('Ups!', 'Sin privilegios para esta acción', 'error')->showConfirmButton();
            return back();
        // }

        $empleado = Idiomas_empleados::findOrFail($id);
        try {
            $empleado->delete();
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back();
        }

        alert('Escuela Modelo', 'El empleado se ha eliminado con éxito', 'success')->showConfirmButton();
        return redirect('idiomas_empleado');
    }
}
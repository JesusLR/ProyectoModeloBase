<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

use App\Http\Models\Preescolar\Preescolar_escuela;
use App\Http\Models\Ubicacion;
use App\Http\Models\Empleado;
use App\Models\User;

class PreescolarEscuelaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:escuela',['except' => ['index','show','list','getEscuelas', 'getEscuelasListaCompleta']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('preescolar.escuela.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $escuelas = Preescolar_escuela::select('escuelas.id as escuela_id', 'escuelas.escClave', 'escuelas.escNombre',
            'departamentos.depClave','ubicacion.ubiClave','personas.perNombre','personas.perApellido1',
            'personas.perApellido2')
        ->join('empleados', 'escuelas.empleado_id', '=', 'empleados.id')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', 'PRE')
        ->orWhere('departamentos.depClave', 'MAT');

        return Datatables::of($escuelas)
        ->filterColumn('nombreCompleto',function($query,$keyword){
            return $query->whereHas('empleado.persona', function($query) use($keyword){
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query){
            return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
        })
        ->addColumn('action',function($query){
            return '<a href="preescolar_escuela/'.$query->escuela_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="preescolar_escuela/'.$query->escuela_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        }) ->make(true);
    }

    /**
     * Mostrar escuelas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEscuelas(Request $request)
    {

        if($request->ajax()){
            $escuelas = Preescolar_escuela::where('departamento_id','=',$request->id)
                ->where(function($query) use ($request) {
                    $query->where("escNombre", "like", "ESCUELA%");
                    $query->orWhere('escNombre', "like", "POSGRADOS%");
                    $query->orWhere('escNombre', "like", "MAESTRIAS%");
                    $query->orWhere('escNombre', "like", "ESPECIALIDADES%");
                    $query->orWhere('escNombre', "like", "DOCTORADOS%");
                    $query->orWhere('escNombre', "like", "PRESCOLAR%");
                    $query->orWhere('escNombre', "like", "PRIMARIA%");
                    $query->orWhere('escNombre', "like", "MATERNAL%");
                    $query->orWhere('escNombre', "like", "SECUNDARIA%");
                    $query->orWhere('escNombre', "like", "BACHILLERATO%");

                    if ($request->otro == "diplomados") {
                        $query->orWhere('escNombre', "like", "DIPLOMADOS%");
                    }
                })
            ->get();

            return response()->json($escuelas);
        }
    }

    /**
     * Mostrar escuelas sin filtro por nombres.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEscuelasListaCompleta(Request $request, $departamento_id)
    {
        if($request->ajax()){
            $escuelas = Preescolar_escuela::where('departamento_id', '=', $request->departamento_id)->get();

            return response()->json($escuelas);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->isAdmin('escuela')) {
            $empleados = Empleado::with('persona')->activos()->get();
            $ubicaciones = Ubicacion::where('id', 1)->get();
            return View('preescolar.escuela.create',compact('ubicaciones','empleados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('preescolar.escuela');
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
                'departamento_id'   => 'required',
                'empleado_id'       => 'required',
                'escClave'          => 'required|unique:escuelas,escClave,NULL,id,departamento_id,'.$request->input('departamento_id').',deleted_at,NULL',
                'escNombre'         => 'required',
                'escNombreCorto'    => 'required',
                'escPorcExaPar'     => 'required',
                'escPorcExaOrd'     => 'required'
            ],
            [
                'escClave.unique' => "La escuela ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('preescolar_escuela/create')->withErrors($validator)->withInput();
        } else {
            try {
                $escuela = Preescolar_escuela::create([
                    'departamento_id'   => $request->input('departamento_id'),
                    'empleado_id'       => $request->input('empleado_id'),
                    'escClave'          => $request->input('escClave'),
                    'escNombre'         => $request->input('escNombre'),
                    'escNombreCorto'    => $request->input('escNombreCorto'),
                    'escPorcExaPar'     => Utils::validaEmpty($request->input('escPorcExaPar')),
                    'escPorcExaOrd'     => Utils::validaEmpty($request->input('escPorcExaOrd'))
                ]);
                alert('Escuela Modelo', 'La Escuela se ha creado con éxito','success');
                return redirect('preescolar_escuela');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('preescolar_escuela/create')->withInput();
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
        $escuela = Preescolar_escuela::with('departamento','empleado.persona')->findOrFail($id);
        return view('preescolar.escuela.show',compact('escuela'));
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
        if (auth()->user()->isAdmin('escuela')) {
            $empleados = Empleado::with('persona')->activos()->get();
            $escuela = Preescolar_escuela::with('departamento','empleado.persona')->findOrFail($id);
            return view('preescolar.escuela.edit',compact('escuela','empleados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('preescolar.escuela');
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
                'empleado_id'       => 'required',
                'escClave'          => 'required',
                'escNombre'         => 'required',
                'escNombreCorto'    => 'required',
                'escPorcExaPar'     => 'required',
                'escPorcExaOrd'     => 'required'
            ],
            [
                'escClave.unique' => "La escuela ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('preescolar_escuela/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $escuela = Preescolar_escuela::findOrFail($id);
                $escuela->empleado_id       = $request->input('empleado_id');
                $escuela->escClave          = $request->input('escClave');
                $escuela->escNombre         = $request->input('escNombre');
                $escuela->escNombreCorto    = $request->input('escNombreCorto');
                $escuela->escPorcExaPar     = Utils::validaEmpty($request->input('escPorcExaPar'));
                $escuela->escPorcExaOrd     = Utils::validaEmpty($request->input('escPorcExaOrd'));
                $escuela->save();
                alert('Escuela Modelo', 'La Escuela se ha actualizado con éxito','success');
                return redirect('preescolar_escuela');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('preescolar_escuela/'.$id.'/edit')->withInput();
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
        if (User::permiso("escuela") == "A" || User::permiso("escuela") == "B") {
            $escuela = Preescolar_escuela::findOrFail($id);
            try {
                if($escuela->delete()){
                    alert('Escuela Modelo', 'La escuela se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar la escuela')
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
        return redirect('preescolar_escuela');
    }
}

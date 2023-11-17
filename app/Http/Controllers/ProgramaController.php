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

use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use App\Http\Models\Empleado;
use App\Models\User;

class ProgramaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:programa',['except' => ['index','show','list','getProgramas','getPrograma']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('programa.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $programas = Programa::select('programas.id as programa_id','programas.progNombre','programas.progClave','escuelas.escClave','departamentos.depClave','ubicacion.ubiClave','personas.perNombre','personas.perApellido1','personas.perApellido2')
        ->join('empleados', 'programas.empleado_id', '=', 'empleados.id')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return Datatables::of($programas)
        ->filterColumn('nombreCompleto',function($query,$keyword){
            return $query->whereHas('empleado.persona', function($query) use($keyword){
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query){
            return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
        })
        ->addColumn('action',function($query){
            return '<a href="programa/'.$query->programa_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="programa/'.$query->programa_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    /**
     * Show programas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProgramas(Request $request, $escuela_id)
    {
        if($request->ajax()){
            $programas = Programa::where('escuela_id','=',$escuela_id)->get();
            return response()->json($programas);
        }
    }





    /**
     * Show programas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrograma(Request $request, $programa_id)
    {
        if($request->ajax()){
            $programa = Programa::with('escuela')->where('id','=',$programa_id)->first();
            return response()->json($programa);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->isAdmin('programa')) {
            $empleados = Empleado::with('persona')->activos()->get();
            $ubicaciones = Ubicacion::all();
            return View('programa.create',compact('ubicaciones','empleados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('programa');
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
                'escuela_id'        => 'required',
                'empleado_id'       => 'required',
                'progClave'         => 'required|unique:programas,progClave,NULL,id,escuela_id,'.$request->input('escuela_id').',deleted_at,NULL',
                'progNombre'        => 'required',
                'progNombreCorto'   => 'required'
            ],
            [
                'progClave.unique' => "El programa ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('programa/create')->withErrors($validator)->withInput();
        } else {
            try {
                $programa = Programa::create([
                    'escuela_id'        => $request->input('escuela_id'),
                    'empleado_id'       => $request->input('empleado_id'),
                    'progClave'         => $request->input('progClave'),
                    'progNombre'        => $request->input('progNombre'),
                    'progNombreCorto'   => $request->input('progNombreCorto'),
                    'progTituloOficial' => $request->input('progTituloOficial')
                ]);
                alert('Escuela Modelo', 'El Programa se ha creado con éxito','success');
                return redirect('programa');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('programa/create')->withInput();
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
        $programa = Programa::with('empleado','escuela')->findOrFail($id);
        return view('programa.show',compact('programa'));
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
        if (auth()->user()->isAdmin('programa')) {
            $empleados = Empleado::with('persona')->activos()->get();
            $programa = Programa::with('empleado','escuela')->findOrFail($id);
            return view('programa.edit',compact('programa','empleados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('programa');
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
                'progClave'         => 'required',
                'progNombre'        => 'required',
                'progNombreCorto'   => 'required'
            ],
            [
                'progClave.unique' => "El programa ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect('programa/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $programa = Programa::findOrFail($id);
                $programa->empleado_id          = $request->input('empleado_id');
                $programa->progClave            = $request->input('progClave');
                $programa->progNombre           = $request->input('progNombre');
                $programa->progNombreCorto      = $request->input('progNombreCorto');
                $programa->progTituloOficial    = $request->input('progTituloOficial');
                $programa->save();
                alert('Escuela Modelo', 'El Programa se ha actualizado con éxito','success');
                return redirect('programa');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('programa/'.$id.'/edit')->withInput();
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
        if (User::permiso("programa") == "A" || User::permiso("programa") == "B") {
            $programa = Programa::findOrFail($id);
            try {
                if($programa->delete()){
                    alert('Escuela Modelo', 'El programa se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el programa')
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
        return redirect('programa');
    }
}
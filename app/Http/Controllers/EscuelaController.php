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

use App\Models\Escuela;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\User;

class EscuelaController extends Controller
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
        return view('escuela.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $escuelas = Escuela::select('escuelas.id as escuela_id', 'escuelas.escClave', 'escuelas.escNombre',
            'departamentos.depClave','ubicacion.ubiClave','personas.perNombre','personas.perApellido1',
            'personas.perApellido2', 'perCordiAcademico.perApellido1 as perApellido1Aca','perCordiAcademico.perApellido2 as perApellido2Aca',
            'perCordiAcademico.perNombre as perNombreAca', 'perCordiAdministrativo.perApellido1 as perApellido1Admin',
            'perCordiAdministrativo.perApellido2 as perApellido2Admin', 'perCordiAdministrativo.perNombre as perNombreAdmin')
        ->join('empleados', 'escuelas.empleado_id', '=', 'empleados.id')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('empleados as coordinaAcademio', 'escuelas.academico_empleado_id', '=', 'coordinaAcademio.id')
        ->join('personas as perCordiAcademico', 'coordinaAcademio.persona_id', '=', 'perCordiAcademico.id')
        ->join('empleados as coordinaAdmin', 'escuelas.administrativo_empleado_id', '=', 'coordinaAdmin.id')
        ->join('personas as perCordiAdministrativo', 'coordinaAdmin.persona_id', '=', 'perCordiAdministrativo.id');

        return Datatables::of($escuelas)
        ->filterColumn('nombreCompleto',function($query,$keyword){
            return $query->whereHas('empleado.persona', function($query) use($keyword){
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query){
            return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
        })


        ->filterColumn('cordinadorAcademico',function($query,$keyword){
            $query->whereRaw("CONCAT(perCordiAcademico.perNombre, ' ', perCordiAcademico.perApellido1, ' ', perCordiAcademico.perApellido2) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('cordinadorAcademico',function($query){
            return $query->perNombreAca." ".$query->perApellido1Aca." ".$query->perApellido2Aca;
        })

        ->filterColumn('cordinadorAdministrativo',function($query,$keyword){
            $query->whereRaw("CONCAT(perCordiAdministrativo.perNombre, ' ', perCordiAdministrativo.perApellido1, ' ', perCordiAdministrativo.perApellido2) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('cordinadorAdministrativo',function($query){
            return $query->perNombreAdmin." ".$query->perApellido1Admin." ".$query->perApellido2Admin;
        })

        ->addColumn('action',function($query){
            return '<a href="escuela/'.$query->escuela_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="escuela/'.$query->escuela_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
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
            $escuelas = Escuela::where('departamento_id','=',$request->id)
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
            $escuelas = Escuela::where('departamento_id', '=', $request->departamento_id)->get();

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
            $ubicaciones = Ubicacion::all();
            return view('escuela.create',compact('ubicaciones','empleados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('escuela');
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
                'departamento_id'               => 'required',
                'empleado_id'                   => 'required',
                'academico_empleado_id'         => 'required',
                'administrativo_empleado_id'    => 'required',
                'escClave'                      => 'required|unique:escuelas,escClave,NULL,id,departamento_id,'.$request->input('departamento_id').',deleted_at,NULL',
                'escNombre'                     => 'required',
                'escNombreCorto'                => 'required',
                'escPorcExaPar'                 => 'required',
                'escPorcExaOrd'                 => 'required'
            ],
            [
                'escClave.unique' => "La escuela ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('escuela/create')->withErrors($validator)->withInput();
        } else {
            try {
                $escuela = Escuela::create([
                    'departamento_id'               => $request->input('departamento_id'),
                    'empleado_id'                   => $request->input('empleado_id'),
                    'academico_empleado_id'         => $request->input('academico_empleado_id'),
                    'administrativo_empleado_id'    => $request->input('administrativo_empleado_id'),
                    'escClave'                      => $request->input('escClave'),
                    'escNombre'                     => $request->input('escNombre'),
                    'escNombreCorto'                => $request->input('escNombreCorto'),
                    'escPorcExaPar'                 => Utils::validaEmpty($request->input('escPorcExaPar')),
                    'escPorcExaOrd'                 => Utils::validaEmpty($request->input('escPorcExaOrd'))
                ]);
                alert('Escuela Modelo', 'La Escuela se ha creado con éxito','success');
                return redirect('escuela');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('escuela/create')->withInput();
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
        $escuela = Escuela::with('departamento','empleado.persona')->findOrFail($id);
        $academico_empleado = Empleado::with('persona')->findOrFail($escuela->academico_empleado_id);
        $administrativo_empleado = Empleado::with('persona')->findOrFail($escuela->administrativo_empleado_id);
        return view('escuela.show',compact('escuela', 'academico_empleado', 'administrativo_empleado'));
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
            $escuela = Escuela::with('departamento','empleado.persona')->findOrFail($id);
            return view('escuela.edit',compact('escuela','empleados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('escuela');
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
                'empleado_id'                => 'required',
                'academico_empleado_id'      => 'required',
                'administrativo_empleado_id' => 'required',
                'escClave'                   => 'required',
                'escNombre'                  => 'required',
                'escNombreCorto'             => 'required',
                'escPorcExaPar'              => 'required',
                'escPorcExaOrd'              => 'required'
            ],
            [
                'escClave.unique' => "La escuela ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('escuela/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $escuela = Escuela::findOrFail($id);
                $escuela->empleado_id                   = $request->input('empleado_id');
                $escuela->academico_empleado_id         = $request->input('academico_empleado_id');
                $escuela->administrativo_empleado_id    = $request->input('administrativo_empleado_id');
                $escuela->escClave                      = $request->input('escClave');
                $escuela->escNombre                     = $request->input('escNombre');
                $escuela->escNombreCorto                = $request->input('escNombreCorto');
                $escuela->escPorcExaPar                 = Utils::validaEmpty($request->input('escPorcExaPar'));
                $escuela->escPorcExaOrd                 = Utils::validaEmpty($request->input('escPorcExaOrd'));
                $escuela->save();
                alert('Escuela Modelo', 'La Escuela se ha actualizado con éxito','success');
                return redirect('escuela');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('escuela/'.$id.'/edit')->withInput();
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
            $escuela = Escuela::findOrFail($id);
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
        return redirect('escuela');
    }
}

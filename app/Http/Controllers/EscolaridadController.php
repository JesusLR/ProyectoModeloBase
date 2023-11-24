<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Escolaridad;
use App\Models\Profesion;
use App\Models\Abreviatura;
use App\Models\Empleado;
use App\Http\Helpers\Utils;
use App\clases\escolaridades\MetodosEscolaridades;

class EscolaridadController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:escolaridad',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('escolaridad.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $escolaridades = Escolaridad::select(
            'escolaridad.id as escolaridad_id',
            'escolaridad.escoGraduado',
            'escolaridad.escoUltimoGrado',
            'escolaridad.escoObservaciones',
            'profesiones.profNombre',
            'abreviaturastitulos.abtDescripcion',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2')
        ->join('profesiones', 'escolaridad.profesion_id', '=', 'profesiones.id')
        ->join('abreviaturastitulos', 'escolaridad.abreviaturaTitulo_id', '=', 'abreviaturastitulos.id')
        ->join('empleados', 'escolaridad.empleado_id', '=', 'empleados.id')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->latest('escolaridad.created_at');

        return Datatables::of($escolaridades)
        ->filterColumn('nombreCompleto',function($query,$keyword){
            return $query->whereHas('empleado.persona', function($query) use($keyword){
                $query->whereRaw("CONCAT_WS(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query){
        return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
        })
        ->addColumn('action',function($query){
            return '<a href="escolaridad/'.$query->escolaridad_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="escolaridad/'.$query->escolaridad_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
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
        $escolaridad = Escolaridad::with('empleado.persona','profesion','abreviatura')->findOrFail($id);
        return view('escolaridad.show',compact('escolaridad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("escolaridad") == "A" || User::permiso("escolaridad") == "B") {
            $empleados = Empleado::with('persona')->get();
            $profesiones = Profesion::get();
            $abreviaturas = Abreviatura::get();
            return View('escolaridad.create',compact('empleados','profesiones','abreviaturas'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('escolaridad');
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
                'empleado_id'           => 'required',
                'profesion_id'          => 'required',
                'abreviaturaTitulo_id'  => 'required',
                'escoGraduado'          => 'required',
                'escoTipoDocumento'     => 'required',
                'escoFechaDocumento'    => 'required'
            ],
            [
                'empleado_id.unique' => "La escolaridad ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('escolaridad/create')->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {
                Escolaridad::create([
                    'empleado_id'           => $request->input('empleado_id'),
                    'profesion_id'          => $request->input('profesion_id'),
                    'abreviaturaTitulo_id'  => $request->input('abreviaturaTitulo_id'),
                    'escoGraduado'          => $request->input('escoGraduado'),
                    'escoTipoDocumento'     => $request->input('escoTipoDocumento'),
                    'escoFolio'             => $request->input('escoFolio'),
                    'escoFechaDocumento'    => $request->input('escoFechaDocumento'),
                    'escoObservaciones'     => $request->input('escoObservaciones'),
                    'escoUltimoGrado'       => 'N'
                ]);
            }catch (QueryException $e){
                DB::rollBack();
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('escolaridad/create')->withInput();
            }
            DB::commit();
            $escolaridades = MetodosEscolaridades::actualizarUltimoGrado($request->empleado_id);
            alert('Escuela Modelo', 'La escolaridad se ha creado con éxito','success')->showConfirmButton();
            return redirect('escolaridad');
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
        if (User::permiso("escolaridad") == "A" || User::permiso("escolaridad") == "B") {
            $escolaridad = Escolaridad::findOrFail($id);
            $empleado = Empleado::with('persona')->findOrFail($escolaridad->empleado_id);
            $profesiones = Profesion::get();
            $abreviaturas = Abreviatura::get();
            return view('escolaridad.edit',compact('escolaridad','empleado','profesiones','abreviaturas'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('escolaridad');
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
        DB::beginTransaction();
        try {
            $escolaridad = Escolaridad::findOrFail($id);
            $escolaridad->profesion_id          = $request->input('profesion_id');
            $escolaridad->abreviaturaTitulo_id  = $request->input('abreviaturaTitulo_id');
            $escolaridad->escoGraduado          = $request->input('escoGraduado');
            $escolaridad->escoTipoDocumento     = $request->input('escoTipoDocumento');
            $escolaridad->escoFolio             = $request->input('escoFolio');
            $escolaridad->escoFechaDocumento    = $request->input('escoFechaDocumento');
            $escolaridad->escoObservaciones     = $request->input('escoObservaciones');
            $escolaridad->save();
            
        }catch (QueryException $e){
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
            return redirect('escolaridad/'.$id.'/edit')->withInput();
        }
        DB::commit();
        $escolaridades = MetodosEscolaridades::actualizarUltimoGrado($escolaridad->empleado_id);
        alert('Escuela Modelo', 'La escolaridad se ha actualizado con éxito','success')->showConfirmButton();
        return redirect('escolaridad');
    }

}
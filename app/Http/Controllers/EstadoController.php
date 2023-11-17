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

use App\Http\Models\Estado;
use App\Http\Models\Pais;

class EstadoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:estado',['except' => ['index','show','list','getEstados']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('estados.show-list');
    }

    /**
     * Show list.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $estados = Estado::select('estados.id as estado_id','estados.edoNombre','estados.edoAbrevia','estados.edoRenapo'
        ,'estados.edoISO','paises.paisNombre')->join('paises','estados.pais_id','paises.id')->where('estados.id','!=',0);
      
        return Datatables::of($estados)
        ->filterColumn('paisNombre', static function($query, $keyword) {
            return $query->where('paisNombre', 'LIKE', "%{$keyword}%");
        })
        ->filterColumn('edoNombre', static function($query, $keyword) {
            return $query->where('edoNombre', 'LIKE', "%{$keyword}%");
        })
        ->filterColumn('edoAbrevia', static function($query, $keyword) {
            return $query->where('edoAbrevia', 'LIKE', "%{$keyword}%");
        })
        ->addColumn('action', static function($query){
            return '<a href="estados/'.$query->estado_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="estados/'.$query->estado_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    /**
     * Show estados.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEstados(Request $request, $id)
    {
        if($request->ajax()){
            $estados = Estado::estados($id);
            return response()->json($estados);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pais = Pais::where('id','!=',0)->get();
        return View('estados.create',compact('pais'));  
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
                'pais_id'          => 'required',
                'edoNombre'        => [
                    'required',
                    'max:30', 
                    function($attibute, $value, $fail) use ($request) {
                        if(Estado::where('edoNombre', 'like', $value)->where('pais_id', $request->pais_id)->first()) {
                            return $fail("Ya existe un estado con este nombre en el país seleccionado.");
                        }
                    }],
                'edoAbrevia'       => [
                    'required',
                    'max:10', 
                    function($attibute, $value, $fail) use ($request) {
                        if(Estado::where('edoAbrevia', 'like', $value)->where('pais_id', $request->pais_id)->first()) {
                            return $fail("Ya existe un estado con esta abreviatura en el país seleccionado.");
                        }
                    }],
                'edoRenapo'        => 'max:2',
                'edoISO'           => 'max:3'
            ],
            [
                'edoNombre.max'     => "El campo Nombre del Estado no debe contener más de 30 caracteres",
                'edoAbrevia.max'    => "El campo Nombre del Estado abreviado no debe contener más de 10 caracteres",
                'edoRenapo.max'     => "El campo Renapo del Estado no debe contener más de 2 caracteres",
                'edoISO.max'        => "El campo ISO del estado no debe contener más de 3 caracteres"
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $estado = Estado::create([
                'pais_id'        => $request->input('pais_id'),
                'edoNombre'        => ucfirst($request->input('edoNombre')),
                'edoAbrevia'       => ucfirst($request->input('edoAbrevia')),
                'edoRenapo'       => $request->input('edoRenapo'),
                'edoISO'       => $request->input('edoISO')
            ]);
        }catch (QueryException $e){
            alert()->error('Ups...'.$e->errorInfo[1],$e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }
        alert('Escuela Modelo', 'El Estado se ha creado con éxito','success')->showConfirmButton();
        return redirect('estados');
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
        $estado = Estado::select('estados.id as estado_id','estados.edoNombre','estados.edoAbrevia','estados.edoRenapo'
        ,'estados.edoISO','paises.paisNombre','paises.id as pais_id')->join('paises','estados.pais_id','paises.id')->findOrFail($id);
        $pais = Pais::where('id','!=',0)->get();
        return view('estados.show',compact('estado','pais'));
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
        
            
        // if (User::permiso("estados") == "A" || User::permiso("estados") == "B") {
        $estado = Estado::select('estados.id as estado_id','estados.edoNombre','estados.edoAbrevia','estados.edoRenapo'
        ,'estados.edoISO','paises.paisNombre','paises.id as pais_id')->join('paises','estados.pais_id','paises.id')->findOrFail($id);
        $pais = Pais::where('id','!=',0)->get();
            return View('estados.edit',compact('estado','pais'));
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('estados');
        // }
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
            'pais_id'          => 'required',
            'edoNombre'        => 'required|max:30',
            'edoAbrevia'       => 'required|max:10',
            'edoRenapo'        => 'max:2',
            'edoISO'           => 'max:3'
        ],
        [
            'edoNombre.max'     => "El campo Nombre del Estado no debe contener más de 30 caracteres",
            'edoAbrevia.max'    => "El campo Nombre del Estado abreviado no debe contener más de 10 caracteres",
            'edoRenapo.max'     => "El campo Renapo del Estado no debe contener más de 2 caracteres",
            'edoISO.max'        => "El campo ISO del estado no debe contener más de 3 caracteres"
        ]
        );

        if ($validator->fails()) {
            return redirect('estados/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $estado = Estado::findOrFail($id);
                $estado->pais_id           = $request->input('pais_id');
                $estado->edoNombre           = ucfirst($request->input('edoNombre'));
                $estado->edoAbrevia      = ucfirst($request->input('edoAbrevia'));
                $estado->edoRenapo      = $request->input('edoRenapo');
                $estado->edoISO      = $request->input('edoISO');
                $estado->save();
                alert('Escuela Modelo', 'El Estado se ha actualizado con éxito','success');
                return redirect('estados');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('estados/'.$id.'/edit')->withInput();
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
        // if (User::permiso("estados") == "A" || User::permiso("estados") == "B") {
            $estado = Estado::findOrFail($id);
            try {
                if($estado->delete()){
                    alert('Escuela Modelo', 'El Estado se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el estado')
                    ->showConfirmButton();
                }
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
            }
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        // }
        return redirect('estados');
    }
}
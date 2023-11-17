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

use App\Http\Models\Pais;
use App\Models\User;

class PaisesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:paises',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('paises.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $paises = Pais::where('id', '!=', 0);

        return Datatables::of($paises)
        ->filterColumn('paisNombre', static function($query, $keyword) {
            return $query->where('paisNombre', 'LIKE', "%{$keyword}%");
        })
        ->addColumn('action',function($query){
            return '<a href="paises/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="paises/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    public function create()
    {
        // if (User::permiso("paises") == "A" || User::permiso("paises") == "B") {
            return View('paises.create');
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('paises');
        // }    
            
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
                'paisNombre'        => 'required|unique:paises|max:50',
                'paisAbrevia'       => 'required|unique:paises|max:5'
            ],
            [
                'paisNombre.unique'   => "El nombre del pais ya existe",
                'paisAbrevia.unique'  => "El nombre abreviado del pais ya existe",
                'paisNombre.max'      => "El campo Nombre del Pais no debe contener más de 50 caracteres",
                'paisAbrevia.max'     => "El campo Nombre del Pais abreviado no debe contener más de 5 caracteres"
            ]
        );

        if ($validator->fails()) {
            return redirect ('paises/create')->withErrors($validator)->withInput();
        } else {
            try {
                $pais = Pais::create([
                    'paisNombre'        => ucfirst($request->input('paisNombre')),
                    'paisAbrevia'       => ucfirst($request->input('paisAbrevia'))
                ]);
                alert('Escuela Modelo', 'El Pais se ha creado con éxito','success');
                return redirect('paises');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('paises/create')->withInput();
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
        $pais = Pais::findOrFail($id);
        return view('paises.show',compact('pais'));
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
        
            
        // if (User::permiso("paises") == "A" || User::permiso("paises") == "B") {
            $pais = Pais::FindOrFail($id);
            return View('paises.edit',compact('pais'));
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('paises');
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
            'paisNombre'        => 'required|unique:paises|max:50',
            'paisAbrevia'       => 'required|unique:paises|max:5'
        ],
        [
            'paisNombre.unique'   => "El nombre del pais ya existe",
            'paisAbrevia.unique'  => "El nombre abreviado del pais ya existe",
            'paisNombre.max'      => "El campo Nombre del Pais no debe contener más de 50 caracteres",
            'paisAbrevia.max'     => "El campo Nombre del Pais abreviado no debe contener más de 5 caracteres"
        ]
        );

        if ($validator->fails()) {
            return redirect('paises/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $pais = Pais::findOrFail($id);
                $pais->paisNombre           = ucfirst($request->input('paisNombre'));
                $pais->paisAbrevia      = ucfirst($request->input('paisAbrevia'));
                $pais->save();
                alert('Escuela Modelo', 'El Pais se ha actualizado con éxito','success');
                return redirect('paises');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('paises/'.$id.'/edit')->withInput();
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
        // if (User::permiso("paises") == "A" || User::permiso("paises") == "B") {
            $pais = Pais::findOrFail($id);
            try {
                if($pais->delete()){
                    alert('Escuela Modelo', 'El Pais se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el pais')
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
        return redirect('paises');
    }
}
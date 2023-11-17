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

use App\Http\Models\Abreviatura;
use App\Models\User;

class AbreviaturaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:abreviatura',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('abreviatura.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $abreviatura = Abreviatura::select('abreviaturastitulos.id','abreviaturastitulos.abtAbreviatura','abreviaturastitulos.abtDescripcion');
        return Datatables::of($abreviatura)->addColumn('action',function($abreviatura){
            return '<a href="abreviatura/'.$abreviatura->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="abreviatura/'.$abreviatura->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
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
        $abreviatura = Abreviatura::findOrFail($id);
        return view('abreviatura.show',compact('abreviatura'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("abreviatura") == "A" || User::permiso("abreviatura") == "B") {
            return View('abreviatura.create');
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('abreviatura');
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
                'abtAbreviatura'    => 'required|unique:abreviaturastitulos,deleted_at,NULL',
                'abtDescripcion'    => 'required'
            ],
            [
                'abtAbreviatura.unique' => "La abreviatura ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('abreviatura/create')->withErrors($validator)->withInput();
        } else {
            try {
                Abreviatura::create([
                    'abtAbreviatura'    => $request->input('abtAbreviatura'),
                    'abtDescripcion'    => $request->input('abtDescripcion')
                ]);
                alert('Escuela Modelo', 'La abreviatura se ha creado con éxito','success');
                return redirect('abreviatura');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...'.$errorCode,$errorMessage)
                    ->showConfirmButton();
                return redirect('abreviatura/create')->withInput();
            }
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
        if (User::permiso("abreviatura") == "A" || User::permiso("abreviatura") == "B") {
            $abreviatura = Abreviatura::findOrFail($id);
            return view('abreviatura.edit',compact('abreviatura'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('abreviatura');
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
        try {
            $abreviatura = Abreviatura::findOrFail($id);
            $abreviatura->abtDescripcion   = $request->input('abtDescripcion');
            $abreviatura->save();
            alert('Escuela Modelo', 'La abreviatura se ha actualizado con éxito','success');
            return redirect('abreviatura');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
            return redirect('abreviatura/'.$id.'/edit')->withInput();
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
        if (User::permiso("abreviatura") == "A" || User::permiso("abreviatura") == "B") {
            $abreviatura = Abreviatura::findOrFail($id);
            try {
                if($abreviatura->delete()){
                    alert('Escuela Modelo', 'La abreviatura se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el acuerdo')
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
        return redirect('abreviatura');
    }

}
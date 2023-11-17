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

use App\Http\Models\Profesion;
use App\Models\User;

class ProfesionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:profesion',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('profesion.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $profesion = Profesion::select('profesiones.id','profesiones.profNombre','profesiones.profNivel');

        return Datatables::of($profesion)
        ->filterColumn('profNivel',function($query,$keyword){
            return $query->where('profNivel','like', '%{$keyword}%');
        })
        ->addColumn('profNivel',function($profesion){
            return Utils::nivel_profesion($profesion->profNivel);
        })
        ->addColumn('action',function($profesion){
            return '<a href="profesion/'.$profesion->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="profesion/'.$profesion->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("profesion") == "A" || User::permiso("profesion") == "B") {
            $niveles = array(
                'L' => 'LICENCIATURA',
                'E' => 'ESPECIALIDAD',
                'M' => 'MAESTRIA',
                'D' => 'DOCTORADO',
            );
            return View('profesion.create',compact('niveles'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('profesion');
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
                'profNombre'    => 'required|unique:profesiones,profNivel,NULL,id,deleted_at,NULL',
                'profNivel'     => 'required',
            ],
            [
                'profNombre.unique' => "La profesión ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('profesion/create')->withErrors($validator)->withInput();
        } else {
            try {
                Profesion::create([
                    'profNombre'    => $request->input('profNombre'),
                    'profNivel'     => $request->input('profNivel')
                ]);
                alert('Escuela Modelo', 'La profesión se ha creado con éxito','success');
                return redirect('profesion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('profesion/create')->withInput();
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
        $profesion = Profesion::findOrFail($id);
        return view('profesion.show',compact('profesion'));
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
        if (User::permiso("profesion") == "A" || User::permiso("profesion") == "B") {
            $profesion = Profesion::findOrFail($id);
            $niveles = array(
                'L' => 'LICENCIATURA',
                'E' => 'ESPECIALIDAD',
                'M' => 'MAESTRIA',
                'D' => 'DOCTORADO',
            );
            return view('profesion.edit',compact('profesion','niveles'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('profesion');
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
            $profesion = Profesion::findOrFail($id);
            $profesion->profNivel   = $request->input('profNivel');
            $profesion->save();
            alert('Escuela Modelo', 'La profesión se ha actualizado con éxito','success');
            return redirect('profesion');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
            return redirect('profesion/'.$id.'/edit')->withInput();
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
        if (User::permiso("profesion") == "A" || User::permiso("profesion") == "B") {
            $profesion = Profesion::findOrFail($id);
            try {
                if($profesion->delete()){
                    alert('Escuela Modelo', 'La profesion se ha eliminado con éxito','success');
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
        return redirect('profesion');
    }

}
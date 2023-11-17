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

use App\Http\Models\Optativa;
use App\Http\Models\Materia;
use App\Http\Models\Ubicacion;
use App\Http\Models\Cgt;
use App\Http\Models\Periodo;
use App\Models\User;

class OptativaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:optativa',['except' => ['index','show','list','getOptativas']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('optativa.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $optativas = Optativa::select(
            'optativas.id as optativa_id', 'optativas.optClaveEspecifica',
            'optativas.optNombre', 'materias.matClave', 'materias.matNombreOficial as matNombre',
            'ubicacion.ubiClave', 'programas.progClave', 'escuelas.escClave', 'departamentos.depClave', 'planes.planClave')
        ->join('materias', 'optativas.materia_id', '=', 'materias.id')
        ->join('planes', 'materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return Datatables::of($optativas)->addColumn('action', function($query) {
            return '<a href="optativa/' . $query->optativa_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="optativa/' . $query->optativa_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_' . $query->optativa_id . '" action="optativa/' . $query->optativa_id . '" method="POST" style="display:inline-block;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="' . $query->optativa_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        })->make(true);
    }

    /**
     * Show optativas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOptativas(Request $request, $id)
    {
        if($request->ajax()){
            $optativas = Optativa::where('materia_id', '=', $id)->get();
            return response()->json($optativas);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        return View('optativa.create',compact('ubicaciones'));
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
        // $validator = Validator::make($request->all(),
        //     [
        //         'materia_id'            => 'required|unique:optativas,materia_id,NULL,id,optClaveEspecifica,' . $request->input('optClaveEspecifica').',deleted_at,NULL',
        //         'optNumero'             => 'required',
        //         'optClaveEspecifica'    => 'required',
        //         'optNombre'             => 'required'
        //     ],
        //     [
        //         'materia_id.unique' => "La optativa ya existe",
        //     ]
        // );
        // if ($validator->fails()) {
        //     return redirect ('optativa/create')->withErrors($validator)->withInput();
        // } else {
            if (User::permiso("optativa") != "A" && User::permiso("optativa") != "B") {
                $programa_id = $request->input('programa_id');
                if(Utils::validaPermiso('optativa',$programa_id)){
                    alert()
                    ->error('Ups...', 'Sin privilegios en el programa!')
                    ->showConfirmButton()
                    ->autoClose(5000);
                    return redirect()->to('optativa/create');
                }
            }
            try {
                $optativas = $request->optativas;
                foreach($optativas as $optativa){
                    $optativa = explode('|',$optativa);
                    Optativa::create([
                        'materia_id' => $optativa[0],
                        'optNumero' => $optativa[1],
                        'optNombre' => $optativa[2],
                        'optClaveEspecifica' => $optativa[3]
                    ]);
                }
                alert('Escuela Modelo', 'La Optativa se ha creado con éxito','success')->showConfirmButton();
                return redirect('optativa');
                // $optativa = Optativa::create([
                //     'materia_id'            => $request->input('materia_id'),
                //     'optNumero'             => Utils::validaEmpty($request->input('optNumero')),
                //     'optClaveEspecifica'    => $request->input('optClaveEspecifica'),
                //     'optNombre'             => $request->input('optNombre')
                // ]);
                // alert('Escuela Modelo', 'La Optativa se ha creado con éxito','success');
                // return redirect('optativa');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('optativa/create')->withInput();
            }
        // } // Validator end
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
        $optativa = Optativa::with('materia.plan.programa.escuela.departamento')->findOrFail($id);
        return view('optativa.show',compact('optativa'));
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
        $optativa = Optativa::with('materia.plan.programa.escuela.departamento')->findOrFail($id);
        $materias = Materia::where([
            ['plan_id', '=', $optativa->materia->plan->id],
            ['matClasificacion', '=', 'O']
        ])->get();
        return view('optativa.edit',compact('optativa','materias'));
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
                'materia_id'            => 'required',
                'optNumero'             => 'required',
                'optClaveEspecifica'    => 'required',
                'optNombre'             => 'required'
            ]
        );
        if ($validator->fails()) {
            return redirect('optativa/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            if (User::permiso("optativa") != "A" && User::permiso("optativa") != "B") {
                $programa_id = $request->input('programa_id');
                if(Utils::validaPermiso('optativa',$programa_id)){
                    alert()
                    ->error('Ups...', 'Sin privilegios en el programa!')
                    ->showConfirmButton()
                    ->autoClose(5000);
                    return redirect()->to('optativa/'.$id.'/edit');
                }
            }
            try {
                $optativa = Optativa::findOrFail($id);
                $optativa->materia_id           = $request->input('materia_id');
                $optativa->optNumero            = Utils::validaEmpty($request->input('optNumero'));
                $optativa->optClaveEspecifica   = $request->input('optClaveEspecifica');
                $optativa->optNombre            = $request->input('optNombre');
                $optativa->save();
                alert('Escuela Modelo', 'El Optativa se ha actualizado con éxito','success');
                return redirect('optativa');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('optativa/'.$id.'/edit')->withInput();
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
        if (User::permiso("optativa") == "A" || User::permiso("optativa") == "B") {
            $optativa = Optativa::findOrFail($id);
            try {
                $programa_id = $optativa->materia->plan->programa_id;
                if(Utils::validaPermiso('optativa',$programa_id)){
                    alert()
                    ->error('Ups...', 'Sin privilegios en el programa!')
                    ->showConfirmButton()
                    ->autoClose(5000);
                }
                if($optativa->delete()){
                    alert('Escuela Modelo', 'El optativa se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el optativa')
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
        return redirect('optativa');
    }
}
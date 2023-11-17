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

use App\Http\Models\Aula;
use App\Http\Models\Ubicacion;
use App\Models\User;

class AulaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:aula',['except' => ['index','show','list','getAulas']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('aula.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $aulas = Aula::select('aulas.id as aula_id','aulas.aulaClave','aulas.aulaCupo','aulas.aulaDescripcion','aulas.aulaUbicacion','ubicacion.ubiNombre', 'aulas.aulaEdificio')
        ->join('ubicacion', 'aulas.ubicacion_id', '=', 'ubicacion.id');

        return Datatables::of($aulas)->addColumn('action',function($query){
            return '<a href="aula/'.$query->aula_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="aula/'.$query->aula_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        }) ->make(true);
    }

    public function getAulas(Request $request,$ubicacion_id){
        if($request->ajax()){
            $aulas = Aula::where([
                ['ubicacion_id', $ubicacion_id]
            ])->get();
            return response()->json($aulas);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("aula") == "A" || User::permiso("aula") == "B") {
            $ubicaciones = Ubicacion::all();
            return view('aula.create',compact('ubicaciones'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('aula');
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
                'ubicacion_id'      => 'required',
                'aulaClave'         => 'required|max:3|unique:aulas,aulaClave,NULL,id,ubicacion_id,'.$request->input('ubicacion_id').',deleted_at,NULL',
                'aulaCupo'          => 'max:6',
                'aulaDescripcion'   => 'max:45',
                'aulaUbicacion'     => 'max:45'
            ],
            [
                'aulaClave.unique' => "El aula ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect ('aula/create')->withErrors($validator)->withInput();
        } else {
            try {
                Aula::create([
                    'ubicacion_id'      => $request->input('ubicacion_id'),
                    'aulaClave'         => $request->input('aulaClave'),
                    'aulaCupo'          => Utils::validaEmpty($request->input('aulaCupo')),
                    'aulaDescripcion'   => $request->input('aulaDescripcion'),
                    'aulaUbicacion'     => $request->input('aulaUbicacion'),
                    'aulaEdificio'     => $request->input('aulaEdificio'),
                ]);
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Error...'.$errorCode, $errorMessage)
                ->showConfirmButton();
                return redirect('aula/create')->withInput();
            }
            alert('Escuela Modelo', 'El aula se ha creado con éxito','success')->showConfirmButton();
            return redirect('aula');
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
        $aula = Aula::with('ubicacion')->findOrFail($id);
        return view('aula.show',compact('aula'));
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
        if (User::permiso("aula") == "A" || User::permiso("aula") == "B") {
            $aula = Aula::with('ubicacion')->findOrFail($id);
            return view('aula.edit',compact('aula'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('aula');
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
                'ubicacion_id'      => 'required',
                'aulaClave'         => 'required|max:3',
                'aulaCupo'          => 'max:6',
                'aulaDescripcion'   => 'max:45',
                'aulaUbicacion'     => 'max:45'
            ]
        );
        if ($validator->fails()) {
            return redirect('aula/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $aula = Aula::findOrFail($id);
                $aula->aulaClave        = $request->input('aulaClave');
                $aula->aulaCupo         = Utils::validaEmpty($request->input('aulaCupo'));
                $aula->aulaDescripcion  = $request->input('aulaDescripcion');
                $aula->aulaUbicacion    = $request->input('aulaUbicacion');
                $aula->aulaEdificio    = $request->input('aulaEdificio');
                $aula->save();
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Error...'.$errorCode, $errorMessage)
                ->showConfirmButton();
                return redirect('aula/'.$id.'/edit')->withInput();
            }
            alert('Escuela Modelo', 'El aula se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('aula');
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
        if (User::permiso("aula") == "A" || User::permiso("aula") == "B") {
            $aula = Aula::findOrFail($id);
            try {
                if($aula->delete()){
                    alert('Escuela Modelo', 'El aula se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el aula')
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
        return redirect('aula');
    }
}
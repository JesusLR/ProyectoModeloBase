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

use App\Models\Ubicacion;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\User;

class UbicacionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:ubicacion',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('ubicacion.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $ubicaciones = Ubicacion::select('ubicacion.id as ubicacion_id','ubicacion.ubiClave','ubicacion.ubiNombre','estados.edoNombre','municipios.munNombre')
        ->join('municipios', 'ubicacion.municipio_id', '=', 'municipios.id')
        ->join('estados', 'municipios.estado_id', '=', 'estados.id');

        return Datatables::of($ubicaciones)->addColumn('action',function($query){
            return '<a href="ubicacion/'.$query->ubicacion_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="ubicacion/'.$query->ubicacion_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        }) ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("ubicacion") == "A" || User::permiso("ubicacion") == "B") {
            $estados = Estado::get();
            return view('ubicacion.create',compact('estados'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('ubicacion');
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
                'ubiClave'  => 'required|unique:ubicacion,ubiClave,NULL,id,deleted_at,NULL'
            ],
            [
                'ubiClave.unique' => "La ubicación ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('ubicacion/create')->withErrors($validator)->withInput();
        } else {
            try {
                $ubicacion = Ubicacion::create([
                    'ubiClave'          => $request->input('ubiClave'),
                    'ubiNombre'         => $request->input('ubiNombre'),
                    'ubiCalle'          => $request->input('ubiCalle'),
                    'ubiCP'             => $request->input('ubiCP'),
                    'municipio_id'      => $request->input('municipio_id')
                ]);
                alert('Escuela Modelo', 'La ubicación se ha creado con éxito','success');
                return redirect('ubicacion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('ubicacion/create')->withInput();
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
        $ubicacion = Ubicacion::with('municipio.estado')->findOrFail($id);
        return view('ubicacion.show',compact('ubicacion'));
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
        if (User::permiso("ubicacion") == "A" || User::permiso("ubicacion") == "B") {
            $estados = Estado::get();
            $municipios = Municipio::get();
            $ubicacion = Ubicacion::with('municipio.estado')->findOrFail($id);
            return view('ubicacion.edit',compact('ubicacion','estados','municipios'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('ubicacion');
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
            $ubicacion = Ubicacion::findOrFail($id);
            $ubicacion->ubiNombre       = $request->input('ubiNombre');
            $ubicacion->ubiCalle        = $request->input('ubiCalle');
            $ubicacion->ubiCP           = $request->input('ubiCP');
            $ubicacion->municipio_id    = $request->input('municipio_id');
            $ubicacion->save();
            alert('Escuela Modelo', 'La ubicación se ha actualizado con éxito','success');
            return redirect('ubicacion');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
            return redirect('ubicacion/'.$id.'/edit')->withInput();
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
        if (User::permiso("ubicacion") == "A" || User::permiso("ubicacion") == "B") {
            $ubicacion = Ubicacion::findOrFail($id);
            try {
                if($ubicacion->delete()){
                    alert('Escuela Modelo', 'La ubicacion se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar la ubicacion')
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
        return redirect('ubicacion');
    }
}
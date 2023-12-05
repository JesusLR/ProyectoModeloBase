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

use App\Models\ConceptoTitulacion;
use App\Models\User;

class ConceptoTitulacionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:concepto_titulacion',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('concepto_titulacion.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $conceptoTitulacion = ConceptoTitulacion::all();

        return Datatables::of($conceptoTitulacion)
        ->addColumn('action',function($query){
            return '<a href="concepto_titulacion/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="concepto_titulacion/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    public function create()
    {
        // if (User::permiso("concepto_titulacion") == "A" || User::permiso("concepto_titulacion") == "B") {
            $ultimoConceptoTitulacion = ConceptoTitulacion::orderByDesc('contClave')->first();
            return View('concepto_titulacion.create',compact('ultimoConceptoTitulacion'));
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('concepto_titulacion');
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
                'contClave'        => 'required',
                'contNombre'       => 'required|unique:conceptostitulacion'
            ],
            [
                'contNombre.unique' => "El concepto de titulación ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('concepto_titulacion/create')->withErrors($validator)->withInput();
        } else {
            try {
                $conceptoTitulacion = ConceptoTitulacion::create([
                    'contClave'        => $request->input('contClave'),
                    'contNombre'       => $request->input('contNombre')
                ]);
                alert('Escuela Modelo', 'El Concepto de titulación se ha creado con éxito','success');
                return redirect('concepto_titulacion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('concepto_titulacion/create')->withInput();
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
        $conceptoTitulacion = ConceptoTitulacion::findOrFail($id);
        return view('concepto_titulacion.show',compact('conceptoTitulacion'));
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
        
            
        // if (User::permiso("concepto_titulacion") == "A" || User::permiso("concepto_titulacion") == "B") {
            $conceptoTitulacion = ConceptoTitulacion::FindOrFail($id);
            return View('concepto_titulacion.edit',compact('conceptoTitulacion'));
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('concepto_titulacion');
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
                'contClave'        => 'required',
                'contNombre'       => 'required|unique:conceptostitulacion'
            ],
            [
                'contNombre.unique' => "El concepto de titulación ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect('concepto_titulacion/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $conceptoTitulacion = ConceptoTitulacion::findOrFail($id);
                $conceptoTitulacion->contClave           = $request->input('contClave');
                $conceptoTitulacion->contNombre      = $request->input('contNombre');
                $conceptoTitulacion->save();
                alert('Escuela Modelo', 'El Concepto de titulación se ha actualizado con éxito','success');
                return redirect('concepto_titulacion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('concepto_titulacion/'.$id.'/edit')->withInput();
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
        // if (User::permiso("concepto_titulacion") == "A" || User::permiso("concepto_titulacion") == "B") {
            $conceptoTitulacion = ConceptoTitulacion::findOrFail($id);
            try {
                if($conceptoTitulacion->delete()){
                    alert('Escuela Modelo', 'El concepto de titulación se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el concepto de titulación')
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
        return redirect('concepto_titulacion');
    }
}
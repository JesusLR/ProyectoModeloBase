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

use App\Http\Models\ConceptoBaja;
use App\Models\User;

class ConceptoBajaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:concepto_baja',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('concepto_baja.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $conceptoBaja = ConceptoBaja::all();

        return Datatables::of($conceptoBaja)
        ->addColumn('action',function($query){
            return '<a href="concepto_baja/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="concepto_baja/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    public function create()
    {
        // if (User::permiso("concepto_baja") == "A" || User::permiso("concepto_baja") == "B") {
            $ultimoConceptoBaja = ConceptoBaja::orderByDesc('conbClave')->first();
            return View('concepto_baja.create',compact('ultimoConceptoBaja'));
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('concepto_baja');
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
                'conbClave'        => 'required',
                'conbNombre'       => 'required|unique:conceptosbaja'
            ],
            [
                'conbNombre.unique' => "El concepto de baja ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('concepto_baja/create')->withErrors($validator)->withInput();
        } else {
            try {
                $conceptoBaja = ConceptoBaja::create([
                    'conbClave'        => $request->input('conbClave'),
                    'conbNombre'       => $request->input('conbNombre'),
                    'conbAbreviatura'   => $request->input('conbAbreviatura')
                ]);
                alert('Escuela Modelo', 'El Concepto de baja se ha creado con éxito','success');
                return redirect('concepto_baja');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('concepto_baja/create')->withInput();
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
        $conceptoBaja = ConceptoBaja::findOrFail($id);
        return view('concepto_baja.show',compact('conceptoBaja'));
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
        
            
        // if (User::permiso("concepto_baja") == "A" || User::permiso("concepto_baja") == "B") {
            $conceptoBaja = ConceptoBaja::FindOrFail($id);
            return View('concepto_baja.edit',compact('conceptoBaja'));
        // }else{
        //     alert()
        //     ->error('Ups...', 'Sin privilegios para esta acción!')
        //     ->showConfirmButton()
        //     ->autoClose(5000);
        //     return redirect('concepto_baja');
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
                'conbClave'        => 'required',
                'conbNombre'       => 'required|unique:conceptosbaja'
            ],
            [
                'conbNombre.unique' => "El concepto de baja ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect('concepto_baja/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $conceptoBaja = ConceptoBaja::findOrFail($id);
                $conceptoBaja->conbClave           = $request->input('conbClave');
                $conceptoBaja->conbNombre      = $request->input('conbNombre');
                $conceptoBaja->conbAbreviatura    = $request->input('conbAbreviatura');
                $conceptoBaja->save();
                alert('Escuela Modelo', 'El Concepto de baja se ha actualizado con éxito','success');
                return redirect('concepto_baja');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('concepto_baja/'.$id.'/edit')->withInput();
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
        // if (User::permiso("concepto_baja") == "A" || User::permiso("concepto_baja") == "B") {
            $conceptoBaja = ConceptoBaja::findOrFail($id);
            try {
                if($conceptoBaja->delete()){
                    alert('Escuela Modelo', 'El concepto de baja se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el concepto de baja')
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
        return redirect('concepto_baja');
    }
}
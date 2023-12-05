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

use App\Models\Pais;
use App\Models\PreparatoriaProcedencia;

class PreparatoriaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:municipio',['except' => ['index','show','list','getPreparatorias']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('preparatorias.show-list');
    }

    /**
     * Show list.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $preparatorias = PreparatoriaProcedencia::with('municipio.estado.pais')->select('preparatorias.*')->homologadas()
        ->where([['preparatorias.id', '<>', 0], ['municipio_id', '<>', 0]]);

        return Datatables::of($preparatorias)
        ->addColumn('preparatoria_id', static function(PreparatoriaProcedencia $preparatoria) {
            return $preparatoria->id;
        })
        ->addColumn('action', static function(PreparatoriaProcedencia $preparatoria) {
            return '<div class="row">'
                        .Utils::btn_show($preparatoria->id, '/preparatorias')
                        .Utils::btn_edit($preparatoria->id, '/preparatorias').
                    '</div>';
        })->make(true);
    }

    /**
     * Show preparatorias.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getPreparatorias(Request $request, $id)
    // {
    //     if($request->ajax()){
    //         $preparatorias = Estado::preparatorias($id);
    //         return response()->json($preparatorias);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $paises = Pais::where('id', '!=', 0)->get();
            return View('preparatorias.create', compact('paises'));
            
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
                'municipio_id'      => 'required',
                'prepNombre'        => 'required|unique:preparatorias|max:255'
            ],
            [
                'prepNombre.unique'  => "El nombre de la Preparatoria ya existe",
                'prepNombre.max'     => "El campo Nombre de la Preparatoria no debe contener más de 50 caracteres"
            ]
        );

        if ($validator->fails()) {
            return redirect ('preparatorias/create')->withErrors($validator)->withInput();
        } else {
            try {
                $preparatoria = PreparatoriaProcedencia::create([
                    'municipio_id'        => $request->input('municipio_id'),
                    'prepNombre'        => ucfirst($request->input('prepNombre'))
                ]);
                alert('Escuela Modelo', 'La Preparatoria se ha creado con éxito','success');
                return redirect('preparatorias');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('preparatorias/create')->withInput();
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
        $preparatoria = PreparatoriaProcedencia::with('municipio.estado.pais')->findOrFail($id);
        return view('preparatorias.show', compact('preparatoria'));
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
        $preparatoria = PreparatoriaProcedencia::with('municipio.estado')->findOrFail($id);
        return View('preparatorias.edit', compact('preparatoria'));
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
            'municipio_id'      => 'required',
            'prepNombre'        => 'required|max:255'
        ],
        [
            'prepNombre.max'     => "El campo Nombre de la Preparatoria no debe contener más de 50 caracteres"
        ]);

        if ($validator->fails()) {
            return redirect('preparatorias/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        try {
            $preparatoria = PreparatoriaProcedencia::findOrFail($id);
            $preparatoria->municipio_id           = $request->input('municipio_id');
            $preparatoria->prepNombre           = ucfirst($request->input('prepNombre'));
            $preparatoria->save();
        }catch (QueryException $e){
            alert()->error('Ups...'.$e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }
        alert('Escuela Modelo', 'La Preparatoria se ha actualizado con éxito','success')->showConfirmButton();
        return redirect('preparatorias');
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
        $preparatoria = PreparatoriaProcedencia::findOrFail($id);
        try {
            $preparatoria->delete();
        }catch (QueryException $e){
            alert()->error('Ups...'.$e->errorInfo[1],$e->errorInfo[2])->showConfirmButton();
        }

        alert('Escuela Modelo', 'La Preparatoria se ha eliminado con éxito','success')->showConfirmButton();
        return redirect('preparatorias');
    }
}
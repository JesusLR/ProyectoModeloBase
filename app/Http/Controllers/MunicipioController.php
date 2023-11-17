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
use App\Http\Models\Municipio;

class MunicipioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:municipio',['except' => ['index','show','list','getMunicipios']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('municipios.show-list');
    }

    /**
     * Show list.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $municipios = Municipio::select('municipios.id as municipio_id','municipios.munNombre','estados.edoNombre', 'paises.paisNombre')
            ->join('estados','municipios.estado_id','estados.id')
            ->join('paises', 'paises.id', 'estados.pais_id')
            ->where('municipios.id', '!=', 0);

        return Datatables::of($municipios)
            ->filterColumn('paisNombre', static function($query, $keyword) {
                return $query->where('paisNombre', 'LIKE', "%{$keyword}%");
            })
            ->filterColumn('edoNombre', static function($query, $keyword) {
                return $query->where('edoNombre', 'LIKE', "%{$keyword}%");
            })
            ->filterColumn('munNombre', static function($query, $keyword) {
                return $query->where('munNombre', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('action', static function($query) {
                return '<a href="municipios/'.$query->municipio_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="municipios/'.$query->municipio_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';
            })
        ->make(true);
    }

    /**
     * Show municipios.
     *
     * @return \Illuminate\Http\Response
     */
    public function getmunicipios(Request $request, $id)
    {
        if ($request->ajax()) {
            $municipios = DB::table("municipios")
            ->where("estado_id","=", $id)
            ->whereNotIn('id', [268])
            ->orderBy("munNombre")->get();
            return response()->json($municipios);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = Pais::where('id','!=',0)->get();
        return View('municipios.create',compact('paises'));
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
                'estado_id'          => 'required',
                'munNombre'        => ['required',
                    'max:50', 
                    function($attribute, $value, $fail) use ($request) {
                        if(Municipio::where('munNombre', 'like', $value)->where('estado_id', $request->estado_id)->first()) {
                            return $fail("Ya existe un municipio con ese nombre en el estado seleccionado.");
                        }
                }]
            ],
            [
                'munNombre.unique'  => "El nombre del municipio ya existe",
                'munNombre.max'     => "El campo Nombre del Municipio no debe contener más de 50 caracteres"
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $municipio = Municipio::create([
                'estado_id'        => $request->input('estado_id'),
                'munNombre'        => ucfirst($request->input('munNombre'))
            ]);
        }catch (QueryException $e){

            alert()->error('Ups...'.$e->errorInfo[1],$e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }
        alert('Escuela Modelo', 'El Municipio se ha creado con éxito','success')->showConfirmButton();
        return redirect('municipios');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Municipio $municipio)
    {
        $municipio->load('estado.pais');
        return view('municipios.show',compact('municipio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Municipio $municipio)
    {
        $municipio->load('estado.pais');
        return View('municipios.edit', compact('municipio'));
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
            'estado_id'        => 'required',
            'munNombre'        => 'required|max:50'
        ],
        [
            'munNombre.max'     => "El campo Nombre del Municipio no debe contener más de 50 caracteres"
        ]
        );

        if ($validator->fails()) {
            return redirect('municipios/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $municipio = Municipio::findOrFail($id);
                $municipio->estado_id           = $request->input('estado_id');
                $municipio->munNombre           = ucfirst($request->input('munNombre'));
                $municipio->save();
                alert('Escuela Modelo', 'El Municipio se ha actualizado con éxito','success');
                return redirect('municipios');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('municipios/'.$id.'/edit')->withInput();
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
    public function destroy(Municipio $municipio)
    {
        // if (User::permiso("municipios") == "A" || User::permiso("municipios") == "B") {
            try {
                if($municipio->delete()){
                    alert('Escuela Modelo', 'El Municipio se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el municipio')
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
        return redirect('municipios');
    }
}

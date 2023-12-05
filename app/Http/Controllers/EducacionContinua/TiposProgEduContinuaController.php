<?php

namespace App\Http\Controllers\EducacionContinua;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Helpers\Utils;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Ubicacion;
use App\Models\TiposPrograma;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EducacionContinua;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TiposProgEduContinuaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:tipos_prog_edu_continua',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('educacion_continua.tipos_programas.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $tiposProgEduContinua = DB::table("tiposprograma")
            ->select('tiposprograma.id as tiposprograma_id','tiposprograma.tpNombre','tiposprograma.tpAbreviatura');



        return Datatables::of($tiposProgEduContinua)
            ->addColumn('action',function($query){
                return '<a href="tiposProgEduContinua/'.$query->tiposprograma_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                    <form id="delete_' . $query->tiposprograma_id . '" action="/tiposProgEduContinua/' . $query->tiposprograma_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->tiposprograma_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( in_array(User::permiso("tipos_prog_edu_continua"), ['A', 'B']) ) {
            $tiposPrograma = TiposPrograma::all();
            $empleados = Empleado::where("empEstado", "=", "A")->get();

            $ubicaciones  = Ubicacion::all();


            return view('educacion_continua.tipos_programas.create', [
                "tiposPrograma" => $tiposPrograma,
                "empleados"     => $empleados,
                "ubicaciones"     => $ubicaciones
            ]);
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->back()->withInput();
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
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput();
        } else {
            try {
                $educacionContinua = TiposPrograma::create([
                    'tpNombre'      => $request->tpNombre,
                    'tpAbreviatura' => $request->tpAbreviatura,
                ]);

                alert('Escuela Modelo', 'El programa se ha creado con éxito','success')->showConfirmButton();
                return redirect()->back()->withInput();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];

                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect()->back()->withInput();
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
        // $ubicacion = Ubicacion::with('municipio.estado')->findOrFail($id);
        // return view('ubicacion.show',compact('ubicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if ( in_array(User::permiso("tipos_prog_edu_continua"), ['A', 'B']) ) {


            $tipoProgEduContinua = TiposPrograma::where("id", "=", $request->tiposProgEduContinua)->first();

            return view('educacion_continua.tipos_programas.edit', [
                'tipoProgEduContinua' => $tipoProgEduContinua
            ]);
        }else{
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->back()->withInput();;
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
            $tiposPrograma = TiposPrograma::findOrFail($id);
            $tiposPrograma->tpNombre       = $request->tpNombre;
            $tiposPrograma->tpAbreviatura        = $request->tpAbreviatura;
            $tiposPrograma->save();
            alert('Escuela Modelo', 'La ubicación se ha actualizado con éxito','success')->showConfirmButton();
            return redirect()->back()->withInput();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        if ( in_array(User::permiso("tipos_prog_edu_continua"), ['A', 'B']) ) {
            try {
                $deleted = DB::table('tiposprograma')->where('id', $request->tiposProgEduContinua)->delete();


                if ($deleted) {
                    alert('Escuela Modelo', 'El programa se ha eliminado con éxito','success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el programa')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }
        return redirect()->back()->withInput();
    }
}
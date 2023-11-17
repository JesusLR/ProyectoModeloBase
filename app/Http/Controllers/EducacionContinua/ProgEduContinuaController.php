<?php

namespace App\Http\Controllers\EducacionContinua;

use URL;
use Auth;
use Debugbar;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\EducacionContinua\StoreProgEduContinuaRequest;

use App\Models\User;
use App\Http\Models\Ubicacion;
use App\Http\Models\EducacionContinua;
use App\Http\Models\TiposPrograma;
use App\Http\Models\Empleado;
use App\Http\Helpers\Utils;


use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ProgEduContinuaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:prog_educacion_continua',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('educacion_continua.programas.show-list');
    }

    /**
    * Genera Datatable de programas de educación continua.
    *
    */
    public function list() {
        $programas = EducacionContinua::with(['tipoprograma', 'escuela', 'ubicacion'])
        ->latest('ecFechaRegistro')
        ->select('educacioncontinua.*');

        return DataTables::eloquent($programas)
        ->addColumn('action', static function(EducacionContinua $programa) {

            return '<div class="row">'
                        .Utils::btn_edit($programa->id, 'progeducontinua')
                        .Utils::btn_delete($programa->id, 'progeducontinua').
                   '</div>';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( !in_array(User::permiso("prog_educacion_continua"), ['A', 'B']) ) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        return view('educacion_continua.programas.create', [
            "tiposPrograma" => TiposPrograma::all(),
            "empleados"     => Empleado::activos()->get(),
            "ubicaciones"   => Ubicacion::sedes()->get(),
            "fechaActual"   => Carbon::now('America/Merida'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgEduContinuaRequest $request)
    {

        try {

            $educacionContinua = EducacionContinua::create($request->validated());

        } catch (QueryException $e) {
            alert()->error('Ups... '.$e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }
        alert('Escuela Modelo', 'El programa se ha creado con éxito','success')->showConfirmButton();
        return redirect('progeducontinua');
    }

    /**
     * Display the specified resource.
     *
     * @param int $progeducontinua
     *
     * @return \Illuminate\Http\Response
     */
    public function show(EducacionContinua $progeducontinua)
    {
        // $ubicacion = Ubicacion::with('municipio.estado')->findOrFail($id);
        // return view('ubicacion.show',compact('ubicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $progeducontinua
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(EducacionContinua $progeducontinua)
    {
        if ( in_array(User::permiso("prog_educacion_continua"), ['A', 'B']) ) {

            return view('educacion_continua.programas.edit', [
                'progeducontinua' => $progeducontinua,
                'tiposPrograma' => TiposPrograma::all(),
                'empleados' => Empleado::activos()->get(),
                'ubicaciones' => Ubicacion::sedes()->get(),
                'fechaActual' => Carbon::now('America/Merida'),
            ]);
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton();
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $progeducontinua
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProgEduContinuaRequest $request, EducacionContinua $progeducontinua)
    {
        try {

            $progeducontinua->update($request->validated());

        } catch (QueryException $e) {
            alert('Ups... '.$e->errorInfo[1], $e->errorInfo[2], 'error')->showConfirmButton();
            return back()->withInput();
        }
        alert('Realizado', 'Se ha actualizado el registro correctamente.', 'success')->showConfirmButton();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $progeducontinua
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducacionContinua $progeducontinua)
    {

        if ( !in_array(User::permiso("prog_educacion_continua"), ['A', 'B']) ) {
            alert('Ups...', 'Sin privilegios para esta acción!', 'error')->showConfirmButton();
            return redirect()->back();
        }

        try {
            $progeducontinua->delete();
        } catch (QueryException $e) {
            alert()->error('Ups... '.$e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return redirect()->back();
        }

        alert('Realizado', 'Se ha borrado el registro exitosamente!', 'success')->showConfirmButton();
        return redirect('progeducontinua');
    }
}
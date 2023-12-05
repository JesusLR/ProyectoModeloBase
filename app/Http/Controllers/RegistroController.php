<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Registro\StoreRegistro;
use Auth;

use App\Models\Registro;
use App\Models\Ubicacion;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use DB;

class RegistroController extends Controller
{

    public function __contruct(){
        $this->middleware('auth');
        $this->middleware('permisos:registro');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('registro.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $ubicaciones = Ubicacion::all();
        return view('registro.create', compact('ubicaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistro $request)
    {
        // Request ya fue validado en StoreRegistro.
        DB::beginTransaction();
        try {
            $responsable = Registro::create([
                'departamento_id' => $request->departamento_id,
                'regFechaInicioVigencia' => $request->regFechaInicioVigencia,
                'regNombreResponsable' => $request->regNombreResponsable,
                'regCargoResponsable' => $request->regCargoResponsable
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            alert()->error('Error','Ha ocurrido un error durante el registro. Favor de volver a intentar')->showConfirmButton();
            return  back()->withInput();
        }
        DB::commit();
        return redirect('registro');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $responsable = Registro::findOrFail($id);

        return view('registro.show', compact('responsable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $responsable = Registro::findOrFail($id);
        return view('registro.edit', compact('responsable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRegistro $request, $id)
    {
        //Request ya ha sido validado en StoreRegistro.

        $responsable = Registro::findOrFail($id);
        DB::beginTransaction();
        try {
            $responsable->update([
                'departamento_id' => $request->departamento_id,
                'regFechaInicioVigencia' => $request->regFechaInicioVigencia,
                'regNombreResponsable' => $request->regNombreResponsable,
                'regCargoResponsable' => $request->regCargoResponsable
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            alert()->error('Error', 'Ha ocurrido un error durante la actualización. Favor de intentar nuevamente.')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $responsable = Registro::findOrFail($id);
        try {
            $responsable->delete();
        } catch (Exception $e) {
            throw $e;
            alert()->error('Error', 'No se pudo eliminar el registro')->showConfirmButton();
            return back();
        }
        return redirect('registro');
    }

    /*
    * Crea el query para generar el DataTable en la vista show-list.
    */
    public function list() {
        $responsables = Registro::with('departamento')->latest();

        return DataTables::eloquent($responsables)
        ->addColumn('clave', static function(Registro $responsable) {
            return $responsable->id;
        })
        ->filterColumn('departamento', static function ($query, $keyword) {
            return $query->whereHas('departamento', static function($query) use ($keyword) {
                return $query->whereRaw("CONCAT(depClave,'-',depNombre) LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('departamento', static function(Registro $responsable) {
            $departamento = $responsable->departamento;
            return $departamento->depClave.'-'.$departamento->depNombreCorto;
        })
        ->addColumn('regFechaInicioVigencia', static function(Registro $responsable) {
            return $responsable->regFechaInicioVigencia;
        })
        ->addColumn('regNombreResponsable', static function(Registro $responsable) {
            return $responsable->regNombreResponsable;
        })
        ->addColumn('regCargoResponsable', static function(Registro $responsable) {
            return $responsable->regCargoResponsable;
        })
        ->addColumn('action', static function (Registro $responsable) {


            $btn_borrar = '<form id="delete_' . $responsable->id . '" action="registro/' . $responsable->id . '" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a href="#" data-id="' . $responsable->id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                                    <i class="material-icons">delete</i>
                                </a>
                            </form>';


            return '<div class="row">
                        <div class="col s1">
                        <a href="registro/'.$responsable->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                        <a href="registro/'.$responsable->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        </div>
                        <div class="col s1">
                            '.$btn_borrar.'
                        </div>
                    </div>';
        })
        ->toJson();
    }//list.

}// Controller class.

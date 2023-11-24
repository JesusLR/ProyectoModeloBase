<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AlumnoRestringido\StoreRestringido;
use Auth;

use App\Models\AlumnoRestringido;
use App\Models\NivelListaNegra;
use App\Models\Alumno;
use App\Models\User;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use DB;

class AlumnoRestringidoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:alumno');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('alumno_restringido.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $fechaActual = Carbon::now('CDT');
        $niveles = NivelListaNegra::all();
        return view('alumno_restringido.create', compact('fechaActual', 'niveles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestringido $request)
    {
        //
        $alumno = Alumno::where('aluClave', $request->aluClave)->first();
        if($alumno) {
            DB::beginTransaction();
            try {
                $restringido = AlumnoRestringido::create([
                    'alumno_id' => $alumno->id,
                    'lnFecha' => $request->lnFecha,
                    'lnNivel' => $request->lnNivel,
                    'lnRazon' => $request->lnRazon
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
                alert()->error('Ups!', 'Ha ocurrido un error durante el registro. Inténtelo nuevamente.')->showConfirmButton();
                return back()->withInput();
            }
            DB::commit();
            return redirect('alumno_restringido');
        } else {
            alert()->warning('No existe el alumno', 'No se encontró registro de alumno con la clave '.$request->aluClave.'. Verifique y busque nuevamente.')
                ->showConfirmButton();
            return back()->withInput();
        }
    }//store.

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $restringido = AlumnoRestringido::findOrFail($id);
        $user = User::find($restringido->usuario_at);
        return view('alumno_restringido.show', compact('restringido', 'user'));
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
        $restringido = AlumnoRestringido::findOrFail($id);
        $user = User::find($restringido->usuario_at);
        $niveles = NivelListaNegra::all();
        return view('alumno_restringido.edit', compact('restringido', 'user', 'niveles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRestringido $request, $id)
    {
        //
        $restringido = AlumnoRestringido::findOrFail($id);
        DB::beginTransaction();
        try {
            $restringido->update([
                'lnNivel' => $request->lnNivel,
                'lnRazon' => $request->lnRazon
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            alert()->error('Ups!', 'Ha ocurrido un error durante la atualización del registro. Favor de intentar nuevamente.')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        return redirect()->back();
    }//update.

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $restringido = AlumnoRestringido::findOrFail($id);
        try {
            $restringido->delete();
        } catch (Exception $e) {
            throw $e;
            alert()->error('Ups!', 'Ocurrió un error durante la eliminación. Favor de intentar nuevamente')->showConfirmButton();
            return back();
        }
        return back();
    }

    /*
    * Generar DataTable para la vista de Inicio del Móddulo.
    */
    public function list() {
        $restringidos = AlumnoRestringido::with(['alumno.persona', 'nivel'])->latest('lnFecha');

        return DataTables::eloquent($restringidos)
        ->filterColumn('aluClave', static function($query, $keyword) {
            return $query->whereHas('alumno.persona', static function($query) use ($keyword) {
                return $query->where('aluClave', $keyword);
            });
        })
        ->addColumn('aluClave', static function(AlumnoRestringido $restringido) {
            return $restringido->alumno->aluClave;
        })
        ->filterColumn('nombreCompleto', static function($query, $keyword) {
            return $query->whereHas('alumno.persona', static function($query) use ($keyword) {
                return $query->whereRaw("CONCAT(perNombre,' ',perApellido1,' ', perApellido2) LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto', static function(AlumnoRestringido $restringido) {
            $persona = $restringido->alumno->persona;
            return $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;
        })
        ->addColumn('lnFecha', static function(AlumnoRestringido $restringido) {
            return $restringido->lnFecha;
        })
        ->filterColumn('nlnDescripcion', static function($query, $keyword) {
            return $query->whereHas('nivel', static function($query) use ($keyword) {
                return $query->where('nlnDescripcion','like', '%'.$keyword.'%');
            });
        })
        ->addColumn('nlnDescripcion', static function(AlumnoRestringido $restringido) {
            return $restringido->nivel->nlnDescripcion;
        })
        ->addColumn('action', static function(AlumnoRestringido $restringido) {

            $btn_borrar = '<form id="delete_' . $restringido->id . '" action="alumno_restringido/' . $restringido->id . '" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a href="#" data-id="' . $restringido->id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                                    <i class="material-icons">delete</i>
                                </a>
                            </form>';

            return '<div class="row">
                        <div class="col s1">
                        <a href="alumno_restringido/'.$restringido->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                        <a href="alumno_restringido/'.$restringido->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        </div>
                        <div class="col s1">
                            '.$btn_borrar.'
                        <div>
                    </div>';
        })
        ->toJson();
    }//list.

    public function getAlumnoByClave($aluClave) {
        $alumno = Alumno::with('persona')
            ->where('aluClave', $aluClave)
            ->first();
        return json_encode($alumno);
    }//getAlumnoByClave.


}//Controller class.

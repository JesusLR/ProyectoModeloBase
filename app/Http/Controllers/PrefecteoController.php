<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Prefecteo;
use App\Models\PrefecteoDetalle;
use App\Http\Requests\Prefecteo\StorePrefecteoRequest;
use App\Http\Helpers\Utils;
use App\clases\prefecteos\MetodosPrefecteos;
use App\clases\horarios\MetodosHorarios;

use DB;
use Exception;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PrefecteoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('prefecteo.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('prefecteo.create', [
            'fechaActual' => Carbon::now('America/Merida'),
            'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrefecteoRequest $request)
    {
        $existentes = MetodosPrefecteos::buscarDesdeRequest($request)->get();
        if($existentes->isNotEmpty()) {
            alert()->warning('Ya existe Prefecteo', 'Ya se ha registrado prefecteo para esta fecha en el departamento. Favor de verificar')->showConfirmButton();
            return back()->withInput();
        }

        DB::beginTransaction();
        try {
            $prefecteos = MetodosPrefecteos::crearPorFecha($request->periodo_id, $request->prefFecha);
            $horarios = MetodosHorarios::buscarPorFecha($request->prefFecha, $request->periodo_id)->get();
            $detallesDatos = MetodosPrefecteos::mapearCollectionConHorarios($prefecteos, $horarios);
            $detalles = MetodosPrefecteos::crearDetallesDesdeCollection($detallesDatos);
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Ha ocurrido un problema.', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        DB::commit(); #TEST
        alert()->success('Realizado', 'Prefecteos generados con éxito.')->showConfirmButton();
        return redirect('prefecteo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $prefecteo
     * @return \Illuminate\Http\Response
     */
    public function show(Prefecteo $prefecteo)
    {
        //
        $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
        return view('prefecteo.show', compact('prefecteo', 'ubicaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $prefecteo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prefecteo $prefecteo)
    {
        //
        $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
        return view('prefecteo.edit', compact('prefecteo', 'ubicaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $prefecteo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prefecteo $prefecteo)
    {
        //
        try {
            $prefecteo->update([
                'prefHoraFinal' => $request->prefHoraFinal,
            ]);
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema.', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        alert()->success('Actualizado', 'El prefecteo se ha actualizado correctamente.')->shoowConfirmButton();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $prefecteo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prefecteo $prefecteo)
    {
        //

        try {
            $prefecteo->delete();
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema.', $e->getMessage())->showConfirmButton();
            return back();
        }
        alert()->success('Borrado.', 'Se ha borrado exitosamente el prefecteo.')->showConfirmButton();
        return redirect('prefecteo');
    }




    public function list() {
        $prefecteos = Prefecteo::with('periodo.departamento.ubicacion')->latest('prefFecha');

        return DataTables::eloquent($prefecteos)
        ->editColumn('prefHoraInicio', static function(Prefecteo $prefecteo) {
            return $prefecteo->prefHoraInicio.':00';
        })
        ->addColumn('action', static function(Prefecteo $prefecteo) {
            
            $url = 'prefecteo';

            return '<div class="row">'
                        .Utils::btn_show($prefecteo->id, $url)
                        .Utils::btn_edit($prefecteo->id, $url).
                   '</div>';
        })
        ->toJson();
    }



    /**
    * Genera el Datatable de detalles de un prefecteo.
    *
    * @param int $prefecteo_id
    */
    public function listDetalles($prefecteo_id) {

        $prefecteo = Prefecteo::findOrFail($prefecteo_id);
        $detalles = PrefecteoDetalle::with(['grupo', 'aula', 'programa', 'prefecteo'])
            ->where('prefecteo_id', $prefecteo->id);

        return DataTables::eloquent($detalles)
        ->editColumn('ghInicio', static function($detalle) {
            return $detalle->ghInicio.':00';
        })
        ->editColumn('ghFinal', static function($detalle) {
            return $detalle->ghFinal.':00';
        })
        ->addColumn('action', static function($detalle) {
            return '<div class="col s1">'
                        .Utils::btn_edit($detalle->id, '/prefecteodetalle').
                   '</div>';
        })->toJson();
    }




}

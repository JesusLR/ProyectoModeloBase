<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConceptoPago\StoreConceptoPago;
use App\Http\Requests\ConceptoPago\UpdateConceptoPago;

use App\Http\Models\ConceptoPago;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Helpers\Utils;
use DB;

class ConceptoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pagos/concepto_pago.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pagos/concepto_pago.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConceptoPago $request)
    {
        //
        DB::beginTransaction();
        try {
            $concepto = ConceptoPago::create([
                'conpClave' => $request->conpClave,
                'conpNombre' => $request->conpNombre,
                'conpAbreviatura' => $request->conpAbreviatura
            ]);
        } catch (Exception $e) {
            throw $e;
            DB::rollBack();
            alert()->warning('Ups!', 'No se pudo registrar el concepto. Favor de intentar nuevamente.')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        return redirect('/concepto_pago');
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
        $concepto = ConceptoPago::findOrFail($id);
        return view('pagos/concepto_pago.show', compact('concepto'));
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
        $concepto = ConceptoPago::findOrFail($id);
        return view('pagos/concepto_pago.edit', compact('concepto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConceptoPago $request, $id)
    {
        //

        $concepto = ConceptoPago::findOrFail($id);

        DB::beginTransaction();
        try {
            $concepto->update([
                'conpClave' => $request->conpClave,
                'conpNombre' => $request->conpNombre,
                'conpAbreviatura' => $request->conpAbreviatura
            ]);
            
        } catch (Exception $e) {
            throw $e;
            DB::rollBack();
            alert()->error('Error', 'No se pudo actualizar el concepto. Favor de intentar nuevamente')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert()->success('Realizado', 'Se ha actualizado con éxito el concepto de pago')->showConfirmButton();
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
        $concepto = ConceptoPago::findOrFail($id);
        try {
            $concepto->delete();
        } catch (Exception $e) {
            throw $e;
            alert()->error('Error', 'No pudo realizarse la acción. Favor de intentar nuevamente.')->showConfirmButton();
            return back();
        }
        return redirect('/concepto_pago');
    }

    public function list() {
        $conceptos = ConceptoPago::all();

        return DataTables::of($conceptos)
        ->addColumn('action', static function(ConceptoPago $concepto) {

            $url = '/concepto_pago';

            return '<div class="row">'
                        .Utils::btn_show($concepto->id, $url).
                        // .Utils::btn_edit($concepto->id, $url)
                        // .Utils::btn_delete($concepto->id, $url).
                    '</div>';
        })->make(true);
    }//list.

}//Controller class.

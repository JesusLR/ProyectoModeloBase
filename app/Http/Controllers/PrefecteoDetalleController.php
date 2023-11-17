<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\PrefecteoDetalle;

use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class PrefecteoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $detalle = PrefecteoDetalle::findOrFail($id);
        return view('prefecteo/detalles.edit', compact('detalle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $detalle = PrefecteoDetalle::findOrFail($id);
        try {
            $detalle->update([
                'asistenciaObservaciones' => $request->asistenciaObservaciones,
                'asistenciaEstado' => $request->asistenciaEstado,
                'prefHora' => $request->prefHora,
            ]);
        } catch (Exception $e) {
            alert()->error('Ha ocurido un problema', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        alert()->success('Actualizado', 'El registro se ha actualizado exitosamente.')->showConfirmButton();
        return redirect()->back();
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
    }
}

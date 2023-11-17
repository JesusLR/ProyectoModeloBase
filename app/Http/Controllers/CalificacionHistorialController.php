<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\CalificacionHistorial;

use Yajra\DataTables\Facades\DataTables;

class CalificacionHistorialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:inscrito']);
    }
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

    public function list(Request $request) 
    {
        $historial = CalificacionHistorial::select('calificaciones_historial.*', 'motivosfalta.mfAbreviatura AS motivo_abreviatura', 'motivosfalta_anterior.mfAbreviatura AS motivo_abreviatura_anterior')
        ->leftJoin('motivosfalta', 'motivosfalta.id', 'calificaciones_historial.motivofalta_id')
        ->leftJoin('motivosfalta AS motivosfalta_anterior', 'motivosfalta_anterior.id', 'calificaciones_historial.motivofalta_id')
        ->where(static function($query) use ($request) {
            if($request->calificacion_id)
                $query->where('calificacion_id', $request->calificacion_id);
        });

        return DataTables::of($historial)->make(true);
    }
}

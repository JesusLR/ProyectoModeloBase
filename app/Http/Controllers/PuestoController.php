<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Puesto\StorePuestoRequest;
use App\Models\Puesto;
use App\Http\Helpers\Utils;

use Auth;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class PuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:puestos']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('puestos.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->isAdmin('puestos')) {
            return back()->withErrors(['No está autorizado para esta acción']);
        }

        return view('puestos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePuestoRequest $request)
    {
        try {
            $puesto = Puesto::create($request->validated());
        } catch (Exception $e) {
            return back()->withInput()->withErrors([$e->getMessage()]);
        }

        return redirect('puestos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Puesto $puesto)
    {
        return view('puestos.show', compact('puesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Puesto $puesto)
    {
        if(!auth()->user()->isAdmin('puestos')) {
            return back()->withErrors(['No está autorizado para esta acción']);
        }

        return view('puestos.edit', compact('puesto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePuestoRequest $request, Puesto $puesto)
    {
        try {
            $puesto->update($request->validated());
        } catch (Exception $e) {
            return back()->withInput()->withErrors([$e->getMessage()]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puesto $puesto)
    {
        if(!auth()->user()->isAdmin('puestos')) {
            return back()->withErrors(['No está autorizado para esta acción']);
        }

        try {
            $puesto->delete();
        } catch (Exception $e) {
            return back()->withInput()->withErrors([$e->getMessage()]);
        }

        return redirect()->back();
    }

    public function list()
    {
        $puestos = Puesto::latest('created_at');
        $esAdmin = auth()->user()->isAdmin('puestos');

        return DataTables::of($puestos)
        ->addColumn('action', function($puesto) use ($esAdmin) {

            return '<div class="row">'
                .Utils::btn_show($puesto->id, 'puestos')
                .($esAdmin ? Utils::btn_edit($puesto->id, 'puestos') : '')
                .($esAdmin ? Utils::btn_delete($puesto->id, 'puestos') : '').
            '</div>';
        })->make(true);
    }
}

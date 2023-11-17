<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\UsuaGim;
use App\Http\Models\UsuaGimTipo;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Requests\UsuaGim\StoreUsuaGimRequest;
use App\Http\Requests\UsuaGim\UpdateUsuaGimRequest;
use App\clases\usuariogim\MetodosUsuaGim;

use DB;
use PDF;
use Exception;
use Carbon\Carbon;
use App\Http\Helpers\Utils;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class UsuarioGimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('usuariogimnasio.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipos = UsuaGimTipo::get();
        return view('usuariogimnasio.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsuaGimRequest $request)
    {
        //
        $alumno = $request->alumno_id ? Alumno::findOrFail($request->alumno_id) : null;
        try {
            $usuario = UsuaGim::create([
                'alumno_id' => $alumno ? $alumno->id : null,
                'gimApellidoPaterno' => $request->gimApellidoPaterno,
                'gimApellidoMaterno' => $request->gimApellidoMaterno,
                'gimNombre' => $request->gimNombre,
                'gimTipo' => $request->gimTipo,
            ]);
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        alert()->success('Registro exitoso!', 'El usuario ha sido registrado. Su Número de usuario es: '.$usuario->id)->showConfirmButton();
        return redirect('usuariogim');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $usuariogim
     * @return \Illuminate\Http\Response
     */
    public function show(UsuaGim $usuariogim)
    {
        //
        $pago = MetodosUsuaGim::buscarPagos($usuariogim->id)->first();
        $gimUltimoPago = $pago ? Utils::fecha_string($pago->pagFechaPago, 'mesCorto') : '';
        return view('usuariogimnasio.show', compact('usuariogim', 'gimUltimoPago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $usuariogim
     * @return \Illuminate\Http\Response
     */
    public function edit(UsuaGim $usuariogim)
    {
        //
        $tipos = UsuaGimTipo::get();
        $pago = MetodosUsuaGim::buscarPagos($usuariogim->id)->first();
        $gimUltimoPago = $pago ? Utils::fecha_string($pago->pagFechaPago, 'mesCorto') : '';
        return view('usuariogimnasio.edit', compact('tipos', 'usuariogim', 'gimUltimoPago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $usuariogim
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsuaGimRequest $request, UsuaGim $usuariogim)
    {
        //
        try {
            $usuariogim->update([
                'alumno_id' => $request->alumno_id,
                'gimApellidoPaterno' => $request->gimApellidoPaterno,
                'gimApellidoMaterno' => $request->gimApellidoMaterno,
                'gimNombre' => $request->gimNombre,
                'gimTipo' => $request->gimTipo,
            ]);
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        alert()->success('Actualizado', 'Se ha actualizado el registro de este usuario.')->showConfirmButton();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $usuariogim
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsuaGim $usuariogim)
    {
        //
        try {
            $usuariogim->delete();
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema.', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
    }


    public function list() 
    {
        $usuarios = UsuaGim::with('tipo')->select('usuagim.*')->latest('usuagim.created_at');

        return DataTables::eloquent($usuarios)
        ->addColumn('action', static function(UsuaGim $usuariogim) {
            
            $url = 'usuariogim';
            $btn_generar_ficha = '<div class="col s1">
                            <form id="generar_ficha_' . $usuariogim->id . '" action="usuariogim/' . $usuariogim->id . '/generar_ficha" method="POST" target="_blank">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a href="#" data-id="' . $usuariogim->id . '" class="button button--icon js-button js-ripple-effect btn-generar-ficha" title="Generar ficha de pago">
                                    <i class="material-icons">receipt</i>
                                </a>
                            </form>
                            </div>';

            return '<div>'
                        .Utils::btn_show($usuariogim->id, $url)
                        .Utils::btn_edit($usuariogim->id, $url)
                        .$btn_generar_ficha.
                   '</div>';
        })->make(true);
    }




    /**
    * función para la vista de create.
    */
    public function buscar_alumno(Request $request, $aluClave) {
        $alumno = Alumno::with('persona')
        ->whereHas('persona', static function($query) use ($aluClave) {
            $query->where('aluClave', $aluClave);
        })->first();

        if($request->ajax()) {
            return response()->json($alumno);
        }
    }


    public function usuariogim_pagos_list($usuariogim_id) 
    {
        $pagos = MetodosUsuaGim::buscarPagos($usuariogim_id);

        return DataTables::eloquent($pagos)
        ->editColumn('pagFechaPago', static function($pago) {
            return Utils::fecha_string($pago->pagFechaPago, 'mesCorto');
        })->toJson();
    }



    /**
    * @param int 
    */
    public function generar_ficha($usuariogim_id)
    {
        $usuariogim = UsuaGim::findOrFail($usuariogim_id);
        try {
            $referencia = MetodosUsuaGim::generar_referencia($usuariogim);
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema', $e->getMessage())->showConfirmButton();
            return redirect()->back();  
        }
        $fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_gimnasio_ficha_pago";
        
        return PDF::loadView("reportes/pdf.{$nombreArchivo}",[
            "usuariogim" => $usuariogim,
            "nombreCompleto" => MetodosUsuaGim::nombreCompleto($usuariogim, true),
            "referencia" => $referencia,
            "clave_pago" => '0000'.$usuariogim->id,
            "importe" => number_format($usuariogim->tipo->tugImporte, 2),
            "fechaActual" => Utils::fecha_string($fechaActual, 'mesCorto'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "fechaVencimiento" => Utils::fecha_string($fechaActual->addDays(7), 'mesCorto'),
            "fechaVencimiento2" => Utils::fecha_string(Carbon::now('America/Merida')->addDays(8), 'mesCorto'),
            "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');
    }




}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Alumno;
use App\Models\Pago;

use Yajra\DataTables\Facades\DataTables;

use DB;

class AlumnoPagosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permisos:alumno');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alumno_id = $request->alumno_id;
        $alumno = Alumno::findOrFail($alumno_id);
        $persona = $alumno->persona;



        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);

        $pagos = DB::select("call procDeudasAlumnoParaPago("
                ."1"

                .",".$alumno->aluClave
                .","."'I'"

               .",'".$temporary_table_name."')");


        $pago = DB::table($temporary_table_name)->where("cve_fila", "=", "TL$")->first();


        $concepto = DB::table("conceptospago")->where("conpClave", "=", $pago->conc_pago)->first();

        // $pagos = collect( $datatable_array );
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );


        return view('alumno_pagos.show-list', compact('alumno', 'persona', 'pago','concepto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $alumno_id = $request->alumno_id;
        $alumno = Alumno::findOrFail($alumno_id);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);

        $pagos = DB::select("call procDeudasAlumnoParaPago("

                ."1"

                .",".$alumno->aluClave
                .","."'I'"

               .",'".$temporary_table_name."')");

        $pagos = DB::table($temporary_table_name)->where("cve_fila", "<>", "TL$")->get();
        // $pagos = collect( $datatable_array );
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

        // conc_pago, total_mes, pagRefPago, descripcion_pago

        // dd($pagos);

        return DataTables::of($pagos)
            ->addColumn('action', function($query) {
                // dd($query);
                // +"id": "0"
                // +"cve_fila": "002019"
                // +"cve_pago": "25198867"
                // +"alumno": null
                // +"conc_pago": "00"
                // +"descripcion_pago": "Inscripción Semestral / Enero 2020"
                // +"pagFechaPago": "2019-12-17"
                // +"pagRefPago": "1900"
                // +"cve_programa": "IBM"
                // +"porcentaje_beca": "15"
                // +"curso": null
                // +"perAnioPago": "2019"
                // +"importe_adeudado": null
                // +"meses_atraso": null
                // +"recargos": null
                // +"inscrip_prorratea": null
                // +"total_mes": "7800.00"
                // +"total_acumulada": null
                // +"curEstado": null
                // +"esDeuda": "NO"

                $concepto = DB::table("conceptospago")->where("conpClave", "=", $query->conc_pago)->first();



                $btnAplicaPago = "";
                if ($query->puedePagar == "SI" && $concepto) {
                    $btnAplicaPago = '<form style="display: inline-block;" action="/pagos/ficha_general/ficha_alumno" method="POST" target="_blank">
                    <input type="hidden" name="aluClave" value="' . $query->cve_pago .'">
                    <input type="hidden" name="cuoAnio" value="' . $query->perAnioPago . '">
                    <input type="hidden" name="cuoConcepto" value="' .  $query->conc_pago.'">
                    <input type="hidden" name="importeNormal" value="' .$query->total_mes.'">
                    <input type="hidden" name="nomConcepto" value="' .$concepto->conpNombre. ' ' . $query->perAnioPago . '">
                    <input type="hidden" name="perNumero" value="' .$query->perNumero.'">
                    <input type="hidden" name="convNumero" value="' .$query->convNumero.'">

                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <button type="submit" style=" background: transparent;
                    border: 0px;
                    color: #0277bd;"  class="button button--icon js-button js-ripple-effect" title="Generar Ficha Pago">
                        <i class="material-icons">picture_as_pdf</i>
                    </button>
                </form>';
                }

                return $btnAplicaPago;
            })
        ->make(true);
    }//list.



}

<?php

namespace App\Http\Controllers\Idiomas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Idiomas\Idiomas_cuotas;
use App\Http\Models\Programa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Auth;

class IdiomasCuotaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('idiomas.cuotas.show-list');
    }

    /**
     * Show level list.
     *
     */
    public function list()
    {
        $cuotas = Idiomas_cuotas::select(
            'idiomas_cuotas.id AS id',
            'programas.progClave AS progClave',
            'idiomas_cuotas.cuoAnioPago AS cuoAnioPago',
            'idiomas_cuotas.cuoDescuentoMensualidad AS cuoDescuentoMensualidad',
            'idiomas_cuotas.cuoDescuentoInscripcion AS cuoDescuentoInscripcion',
            'idiomas_cuotas.cuoImporteMensualidad AS cuoImporteMensualidad',
            'idiomas_cuotas.cuoImporteInscripcion1 AS cuoImporteInscripcion1',
            'idiomas_cuotas.cuoFechaInscripcion1 AS cuoFechaInscripcion1',
            'idiomas_cuotas.cuoImporteInscripcion2 AS cuoImporteInscripcion2',
            'idiomas_cuotas.cuoFechaInscripcion2 AS cuoFechaInscripcion2',
            'idiomas_cuotas.cuoImporteInscripcion3 AS cuoImporteInscripcion3',
            'idiomas_cuotas.cuoFechaInscripicion3 AS cuoFechaInscripicion3',
            'idiomas_cuotas.cuoImporteVencimiento AS cuoImporteVencimiento',
            'idiomas_cuotas.cuoNumeroCuenta AS cuoNumeroCuenta')
        ->join('programas', 'idiomas_cuotas.programa_id', '=', 'programas.id');


        return DataTables::of($cuotas)
        ->addColumn('action',function($query) {
            return '<a href="idiomas_cuota/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="idiomas_cuota/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_' . $query->id . '" action="idiomas_cuota/' . $query->id . '" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $programas = Programa::select('programas.id','programas.progNombre','programas.progClave')
                ->where('programas.progClave', 'ING')
                ->orWhere('programas.progClave', 'INI')
                ->get();

            return view('idiomas.cuotas.create', compact('programas'));
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_cuota');
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'programa_id'             => 'required',
                'cuoAnioPago'             => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ('idiomas_cuota/create')->withErrors($validator)->withInput();
        }

        try {
            Idiomas_cuotas::create([
                'programa_id'             => $request->input('programa_id'),
                'cuoAnioPago'             => $request->input('cuoAnioPago'),
                'cuoDescuentoMensualidad' => $request->input('cuoDescuentoMensualidad'),
                'cuoDescuentoInscripcion' => $request->input('cuoDescuentoInscripcion'),
                'cuoImporteMensualidad'   => $request->input('cuoImporteMensualidad'),
                'cuoImporteInscripcion1'  => $request->input('cuoImporteInscripcion1'),
                'cuoFechaInscripcion1'    => $request->input('cuoFechaInscripcion1'),
                'cuoImporteInscripcion2'  => $request->input('cuoImporteInscripcion2'),
                'cuoFechaInscripcion2'    => $request->input('cuoFechaInscripcion2'),
                'cuoImporteInscripcion3'  => $request->input('cuoImporteInscripcion3'),
                'cuoFechaInscripicion3'    => $request->input('cuoFechaInscripicion3'),
                'cuoImporteVencimiento'   => $request->input('cuoImporteVencimiento'),
                'cuoNumeroCuenta'         => $request->input('cuoNumeroCuenta')
            ]);
            alert('Escuela Modelo', 'La cuota se ha creado con éxito','success')->showConfirmButton();
            return redirect('idiomas_cuota');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_cuota/create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuota = Idiomas_cuotas::select(
            'idiomas_cuotas.id AS id',
            'programas.progClave AS progClave',
            'idiomas_cuotas.cuoAnioPago AS cuoAnioPago',
            'idiomas_cuotas.cuoDescuentoMensualidad AS cuoDescuentoMensualidad',
            'idiomas_cuotas.cuoDescuentoInscripcion AS cuoDescuentoInscripcion',
            'idiomas_cuotas.cuoImporteMensualidad AS cuoImporteMensualidad',
            'idiomas_cuotas.cuoImporteInscripcion1 AS cuoImporteInscripcion1',
            'idiomas_cuotas.cuoFechaInscripcion1 AS cuoFechaInscripcion1',
            'idiomas_cuotas.cuoImporteInscripcion2 AS cuoImporteInscripcion2',
            'idiomas_cuotas.cuoFechaInscripcion2 AS cuoFechaInscripcion2',
            'idiomas_cuotas.cuoImporteInscripcion3 AS cuoImporteInscripcion3',
            'idiomas_cuotas.cuoFechaInscripicion3 AS cuoFechaInscripicion3',
            'idiomas_cuotas.cuoImporteVencimiento AS cuoImporteVencimiento',
            'idiomas_cuotas.cuoNumeroCuenta AS cuoNumeroCuenta')
        ->join('programas', 'idiomas_cuotas.programa_id', '=', 'programas.id')
        ->where('idiomas_cuotas.id', $id)
        ->first();

        return view('idiomas.cuotas.show', [
            'cuota' => $cuota
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $cuota = Idiomas_cuotas::select(
                'idiomas_cuotas.id AS id',
                'programas.id AS programa_id',
                'programas.progClave AS progClave',
                'idiomas_cuotas.cuoAnioPago AS cuoAnioPago',
                'idiomas_cuotas.cuoDescuentoMensualidad AS cuoDescuentoMensualidad',
                'idiomas_cuotas.cuoDescuentoInscripcion AS cuoDescuentoInscripcion',
                'idiomas_cuotas.cuoImporteMensualidad AS cuoImporteMensualidad',
                'idiomas_cuotas.cuoImporteInscripcion1 AS cuoImporteInscripcion1',
                'idiomas_cuotas.cuoFechaInscripcion1 AS cuoFechaInscripcion1',
                'idiomas_cuotas.cuoImporteInscripcion2 AS cuoImporteInscripcion2',
                'idiomas_cuotas.cuoFechaInscripcion2 AS cuoFechaInscripcion2',
                'idiomas_cuotas.cuoImporteInscripcion3 AS cuoImporteInscripcion3',
                'idiomas_cuotas.cuoFechaInscripicion3 AS cuoFechaInscripicion3',
                'idiomas_cuotas.cuoImporteVencimiento AS cuoImporteVencimiento',
                'idiomas_cuotas.cuoNumeroCuenta AS cuoNumeroCuenta')
            ->join('programas', 'idiomas_cuotas.programa_id', '=', 'programas.id')
            ->where('idiomas_cuotas.id', $id)
            ->first();

            $programas = Programa::select('programas.id','programas.progNombre','programas.progClave')
                ->where('programas.progClave', 'ING')
                ->orWhere('programas.progClave', 'INI')
                ->get();

            return view('idiomas.cuotas.edit', [
                'cuota' => $cuota,
                'programas' => $programas
            ]);
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_cuota');
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'programa_id'                => 'required',
                'cuoAnioPago'               => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('idiomas_cuota/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        try {
            
            $cuota = Idiomas_cuotas::findOrFail($id);
            $cuota->update([
                'programa_id'             => $request->input('programa_id'),
                'cuoAnioPago'             => $request->input('cuoAnioPago'),
                'cuoDescuentoMensualidad' => $request->input('cuoDescuentoMensualidad'),
                'cuoDescuentoInscripcion' => $request->input('cuoDescuentoInscripcion'),
                'cuoImporteMensualidad'   => $request->input('cuoImporteMensualidad'),
                'cuoImporteInscripcion1'  => $request->input('cuoImporteInscripcion1'),
                'cuoFechaInscripcion1'    => $request->input('cuoFechaInscripcion1'),
                'cuoImporteInscripcion2'  => $request->input('cuoImporteInscripcion2'),
                'cuoFechaInscripcion2'    => $request->input('cuoFechaInscripcion2'),
                'cuoImporteInscripcion3'  => $request->input('cuoImporteInscripcion3'),
                'cuoFechaInscripicion3'    => $request->input('cuoFechaInscripicion3'),
                'cuoImporteVencimiento'   => $request->input('cuoImporteVencimiento'),
                'cuoNumeroCuenta'         => $request->input('cuoNumeroCuenta')
            ]);
            alert('Escuela Modelo', 'La cuota se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('idiomas_cuota');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_cuota/' . $id . '/edit')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $cuota = Idiomas_cuotas::findOrFail($id);
            try {
                if($cuota->delete()){
                    alert('Escuela Modelo', 'La cuota se ha eliminado con éxito','success')->showConfirmButton();
                }else{
                    alert()->error('Error...', 'No se puedo eliminar la cuota')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        // }
        return redirect('idiomas_cuota');
    }
}
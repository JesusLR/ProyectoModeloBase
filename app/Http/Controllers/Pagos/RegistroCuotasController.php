<?php

namespace App\Http\Controllers\Pagos;


use URL;
use Auth;
use Debugbar;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models;
use App\Models\User;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;
use App\Http\Models\Cuota;
use App\Http\Helpers\Utils;
use App\clases\cuotas\MetodosCuotas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RegistroCuotasController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:registro_cuotas',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->list());
      return View('pagos.registro_cuotas.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $cuotas = Cuota::get()->sortByDesc('cuoAnio')
        ->map(static function($cuota) {
            $relacion = $cuota->relacion;
            $clave = 'depClave';
            $departamento = $cuota->cuoTipo == 'D' ? $relacion : null;
            if($cuota->cuoTipo == 'P') {
                $clave = 'progClave';
                $departamento = $relacion ? $relacion->escuela->departamento: null;
            }
            if($cuota->cuoTipo == 'E') {
                $clave = 'escClave';
                $departamento = $relacion ? $relacion->departamento : null;
            }
            $cuota->pertenece_a = $relacion ? $cuota->relacion->$clave : '';

            $ubicacion = MetodosCuotas::ubicacion($cuota);
            $cuota->ubicacion = $ubicacion ? $ubicacion->ubiClave : '';
            $cuota->departamento = $departamento ?: null;
            return $cuota;
        });

        return Datatables::of($cuotas)
        ->addColumn('action', static function($cuota) {
            return '<a href="/pagos/registro_cuotas/edit/'.$cuota->id.'" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <a href="/pagos/registro_cuotas/'.$cuota->id.'/cuota_descuento" class="button button--icon js-button js-ripple-effect" title="Descuentos de cuota">
                <i class="material-icons">money_off</i>
            </a>
            <form id="delete_' . $cuota->id . '" action="/pagos/registro_cuotas/delete/' . $cuota->id . '" method="POST" style="display: inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="' . $cuota->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
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
        if (User::permiso("ubicacion") == "A" || User::permiso("ubicacion") == "B") {
            $ubicaciones = Ubicacion::all();

            return view('pagos.registro_cuotas.create', [
                "ubicaciones" => $ubicaciones
            ]);
        } else {
            alert()
                ->error('Ups...', 'Sin privilegios para esta acción!')
                ->showConfirmButton()
                ->autoClose(5000);
            return redirect()->back();
        }
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
                'cuoTipo'  => 'required',
                'cuoAnio' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $dep_esc_prog_id = $request->departamento_id;
                if ($request->cuoTipo == "E") {
                    $dep_esc_prog_id = $request->escuela_id;
                }
                if ($request->cuoTipo == "D") {
                    $dep_esc_prog_id = $request->departamento_id;
                }
                if ($request->cuoTipo == "P") {
                    $dep_esc_prog_id = $request->programa_id;
                }

                Cuota::create([
                    'cuoTipo'          => $request->cuoTipo,
                    'dep_esc_prog_id'  => $dep_esc_prog_id,
                    'cuoAnio'          => $request->cuoAnio,

                    'cuoImportePadresFamilia'  => $request->cuoImportePadresFamilia,
                    'cuoImporteOrdinarioUady'  => $request->cuoImporteOrdinarioUady,

                    'cuoImporteMensualidad10'  => $request->cuoImporteMensualidad10,
                    'cuoImporteMensualidad11'  => $request->cuoImporteMensualidad11,
                    'cuoImporteMensualidad12'  => $request->cuoImporteMensualidad12,

                    'cuoImporteInscripcion1'  => $request->cuoImporteInscripcion1,
                    'cuoFechaLimiteInscripcion1'  => $request->cuoFechaLimiteInscripcion1,
                    'cuoImporteInscripcion2'  => $request->cuoImporteInscripcion2,
                    'cuoFechaLimiteInscripcion2'  => $request->cuoFechaLimiteInscripcion2,
                    'cuoImporteInscripcion3'  => $request->cuoImporteInscripcion3,
                    'cuoFechaLimiteInscripcion3'  => $request->cuoFechaLimiteInscripcion3,

                    'cuoImporteVencimiento'  => $request->cuoImporteVencimiento,
                    'cuoImporteProntoPago' => $request->cuoImporteProntoPago,
                    'cuoDiasProntoPago'  => $request->cuoDiasProntoPago,
                    'cuoNumeroCuenta'  => $request->cuoNumeroCuenta,
                ]);
                alert('Escuela Modelo', 'La cuota se ha creado con éxito','success')->showConfirmButton();
                return redirect()->back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];

                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect()->back();
            }
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
        // $ubicacion = Ubicacion::with('municipio.estado')->findOrFail($id);
        // return view('ubicacion.show',compact('ubicacion'));
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
        if (User::permiso("ubicacion") == "A" || User::permiso("ubicacion") == "B") {
            $ubicaciones = Ubicacion::all();
            $cuota = Cuota::findOrFail($id);
            $usuario = User::where("id", "=", $cuota->usuario_at)->first();
            $ubicacion = MetodosCuotas::ubicacion($cuota);
            $escuela = null;
            $departamento = $cuota->cuoTipo == 'D' ? $cuota->relacion : null;
            $programa = null;
            if ($cuota->cuoTipo == "E") {
                $escuela = $cuota->relacion;
                $departamento = $escuela->departamento;
            }
            if ($cuota->cuoTipo == "P") {
                $programa = $cuota->relacion;
                $escuela = $programa->escuela;
                $departamento = $escuela->departamento;
            }


            return view('pagos.registro_cuotas.edit',compact('ubicaciones', 'ubicacion', 'cuota', 'escuela', 'departamento', 'programa','usuario'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $dep_esc_prog_id = $request->dep_esc_prog_id;
            if ($request->cuoTipo == "E") {
                $dep_esc_prog_id = $request->escuela_id;
            }
            if ($request->cuoTipo == "D") {
                $dep_esc_prog_id = $request->departamento_id;
            }
            if ($request->cuoTipo == "P") {
                $dep_esc_prog_id = $request->programa_id;
            }


            $cuota = Cuota::findOrFail($request->cuota_id);

            $cuota->cuoTipo         = $request->cuoTipo ? $request->cuoTipo: $cuota->cuoTipo;
            $cuota->dep_esc_prog_id = $dep_esc_prog_id;
            $cuota->cuoAnio         = $request->cuoAnio;
            
            $cuota->cuoImportePadresFamilia    = $request->cuoImportePadresFamilia;
            $cuota->cuoImporteOrdinarioUady    = $request->cuoImporteOrdinarioUady;
            
            $cuota->cuoImporteMensualidad10  = $request->cuoImporteMensualidad10;
            $cuota->cuoImporteMensualidad11  = $request->cuoImporteMensualidad11;
            $cuota->cuoImporteMensualidad12  = $request->cuoImporteMensualidad12;

            $cuota->cuoImporteInscripcion1  = $request->cuoImporteInscripcion1;
            $cuota->cuoFechaLimiteInscripcion1  = $request->cuoFechaLimiteInscripcion1;
            $cuota->cuoImporteInscripcion2  = $request->cuoImporteInscripcion2;
            $cuota->cuoFechaLimiteInscripcion2  = $request->cuoFechaLimiteInscripcion2;
            $cuota->cuoImporteInscripcion3  = $request->cuoImporteInscripcion3;
            $cuota->cuoFechaLimiteInscripcion3  = $request->cuoFechaLimiteInscripcion3;


            $cuota->cuoImporteVencimiento  = $request->cuoImporteVencimiento;
            $cuota->cuoImporteProntoPago = $request->cuoImporteProntoPago;
            $cuota->cuoDiasProntoPago  = $request->cuoDiasProntoPago;
            $cuota->cuoNumeroCuenta  = $request->cuoNumeroCuenta;
            $cuota->usuario_at = auth()->user()->id;

            $cuota->save();

            alert('Escuela Modelo', 'La cuota se ha actualizado con éxito','success')->showConfirmButton();
            return redirect()->back()->withInput();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (User::permiso("ubicacion") == "A" || User::permiso("ubicacion") == "B") {

            $deleted = DB::table('cuotas')->where('id', $request->id)->delete();

            try {
                if ($deleted) {
                    alert('Escuela Modelo', 'La cuota se ha eliminado con éxito','success')->showConfirmButton();
                }else{
                    alert()->error('Error...', 'No se puedo eliminar la ubicacion')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        }else{
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }
        return redirect()->back();
    }

    /**
     * Manda a la vista principal del módulo de Cuota Descuento, con la cuota correspondiente 
     * para listar los descuentos disponibles.
     */
    public function cuota_descuento($cuota_id)
    {
        $cuota = Cuota::findOrFail($cuota_id);
        $programa = $cuota->cuoTipo == 'P' ? $cuota->relacion : null;
        $escuela = $cuota->cuoTipo == 'E' ? $cuota->relacion : null;
        $departamento = $cuota->cuoTipo == 'D' ? $cuota->relacion : null;

        return view('pagos/cuota_descuento.show-list', [
            'cuota' => Cuota::findOrFail($cuota_id),
            'programa' => $programa,
            'escuela' => $escuela,
            'departamento' => $departamento,
            'ubicacion' => MetodosCuotas::ubicacion($cuota),
        ]);
    }
}
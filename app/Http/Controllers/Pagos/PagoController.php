<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Cuota;
use App\Http\Helpers\Referencia;




class PagoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('permisos:pago',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('pago.create');
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $clave = $request->input('aluClave');
        $cuoAnio = $request->input('cuoAnio');
        $fechaVencimiento = $request->input('cuoFecha');
        $concepto = $request->input('cuoConcepto');




        //datos del Alumno y método de pago
        $curso = Curso::where([['id', $clave]])->first();


        $dep_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $esc_id = $curso->cgt->plan->programa->escuela->id;
        $prog_id = $curso->cgt->plan->programa->id;
        $cuoAnioGeneracion = $curso->curAnioCuotas;
        $periodoCurso = $curso->cgt->periodo->perNumero;
        $clavePago = $curso->alumno->aluClave;


        $perNombre = $curso->alumno->persona->perNombre;
        $perApellido1 = $curso->alumno->persona->perApellido1;
        $perApellido2 = $curso->alumno->persona->perApellido2;
        $nombreCompleto = "$perNombre $perApellido1 $perApellido2";
        $curPlanPago = $curso->curPlanPago;
        $tipoBeca = $curso->curTipoBeca;


        $anioConceptoDecenas = $cuoAnio - 2000;

        $conceptoCompleto = $clavePago.$anioConceptoDecenas.$concepto;

        $importes = Referencia::generarImportes(1, "05","2018", "2019-01-15");
         $mensualidad = $importes['mensualidad'];
         $inscripcionProrrateada = $importes['inscripcionProrrateada'];
         $prontoPago = $importes['prontoPago'];
         $descuentoImporte = $importes['descuentoImporte'];
         $recargo = $importes['recargo'];
         $importeTotalDecimal = $importes['importeTotalDecimal'];
         $diferenciaMeses = $importes['diferenciaMeses'];
         $curPorcentajeBeca = $importes['curPorcentajeBeca'];
        $referenciaPago = Referencia::crearReferencia($conceptoCompleto, $fechaVencimiento, $importeTotalDecimal);


      return View('pago.referencia', compact('nombreCompleto', 'curPlanPago', 'cuoAnio', 'dep_id', 'esc_id', 'prog_id', 'cuoAnioGeneracion', 'mensualidad', 'inscripcionProrrateada', 'prontoPago', 'curPorcentajeBeca', 'fechaVencimiento', 'concepto', 'diferenciaMeses', 'recargo', 'importeTotalDecimal', 'descuentoImporte', 'referenciaPago'));

    }


    public function obtenerCuotaConcepto(Request $request)
    {

        


    }
}
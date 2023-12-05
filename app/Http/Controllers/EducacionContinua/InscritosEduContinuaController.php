<?php

namespace App\Http\Controllers\EducacionContinua;

use URL;
use Auth;
use Debugbar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\EducacionContinua\StoreInscritoEduContinuaRequest;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Pago;
use App\Models\Cuota;
use App\Models\Curso;
use App\Models\Ficha;
use App\Models\Alumno;
use App\Models\Convenio;
use App\Models\Empleado;
use App\Models\Ubicacion;
use App\Models\TiposPrograma;
use App\Models\InscritosEduCont;
use App\Models\EducacionContinua;
use App\Http\Helpers\Utils;
use App\Http\Helpers\GenerarReferencia;
use App\clases\EducacionContinua\FichaPago;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;


class InscritosEduContinuaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:inscritos_edu_continua',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('educacion_continua.inscritos.show-list');
    }

    /**
    * Show user list.
    *
    */
    public function list()
    {
        $inscritos = InscritosEduCont::with(['alumno.persona', 'educacioncontinua'])->select('inscritoseducont.*')->latest();

        return DataTables::eloquent($inscritos)
        ->addColumn('aluClave', static function(InscritosEduCont $inscrito) {
            return str_pad($inscrito->alumno->aluClave, 8, '0', STR_PAD_LEFT);
        })
        ->filterColumn('nombreCompleto', static function($query, $keyword) {
            return $query->whereHas('alumno.persona', static function ($query) use ($keyword) {
                return $query->whereNombreCompleto($keyword);
            });
        })
        ->addColumn('nombreCompleto', static function(InscritosEduCont $inscrito) {
            return MetodosPersonas::nombreCompleto($inscrito->alumno->persona);
        })
        ->addColumn('action', static function(InscritosEduCont $inscrito) {
            $alumno = $inscrito->alumno;
            $nombres = MetodosPersonas::nombreCompleto($alumno->persona);

            $btn_generar_ficha = '';
            $fichasPagoActivas = true;
            
            if($fichasPagoActivas) {
                $btn_generar_ficha = '<div class="col s1">
                        <a href="inscritosEduContinua/'.$inscrito->id.'/realizar_pago" class="button button--icon js-button js-ripple-effect" title="Realizar Pago">
                            <i class="material-icons">credit_card</i>
                        </a>
                        </div>';
            }

            return '<div class="row">'
                        .Utils::btn_edit($inscrito->id, 'inscritosEduContinua')
                        .Utils::btn_delete($inscrito->id, 'inscritosEduContinua').
                        '<div class="col s1">
                        <a href="#modalHistorialPagos" data-id="'.$inscrito->id.'" data-nombres="'.$nombres.'" data-aluclave="'. $alumno->aluClave .'" class="modal-trigger btn-modal-historial-pagos button button--icon js-button js-ripple-effect" title="Historial Pagos">
                            <i class="material-icons">attach_money</i>
                        </a>
                        </div>
                        '. $btn_generar_ficha.'
                   </div>';
        })->make(true);
    }



    public function eduContPagosList (Request $request)
    {
        $id = $request->id;

        $importeInsc = DB::table("inscritoseducont as t1")->where("t1.id", "=", $id)
            ->whereNotNull("educacioncontinua.ecImporteInscripcion")
            ->select("t1.id","t1.alumno_id", 'alumnos.aluClave',
                "educacioncontinua.ecImporteInscripcion", "educacioncontinua.ecVencimientoInscripcion",
                DB::raw('90 as concepto'),'periodos.perAnioPago')
            ->join('educacioncontinua', 'educacioncontinua.id', '=', 't1.educacioncontinua_id')
            ->join('periodos', 'periodos.id','=', 'educacioncontinua.periodo_id')
            ->join('alumnos', 'alumnos.id','=','t1.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id');

        $impPagoUno = DB::table("inscritoseducont  as t1")->where("t1.id", "=", $id)
            ->whereNotNull("educacioncontinua.ecImportePago1")
            ->select("t1.id","t1.alumno_id", 'alumnos.aluClave',
                "educacioncontinua.ecImportePago1", "educacioncontinua.ecVencimientoPago1",
                DB::raw('91 as concepto'),'periodos.perAnioPago')
            ->join('educacioncontinua', 'educacioncontinua.id', '=', 't1.educacioncontinua_id')
            ->join('periodos', 'periodos.id','=', 'educacioncontinua.periodo_id')
            ->join('alumnos', 'alumnos.id','=','t1.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id');



        $impPagoDos = DB::table("inscritoseducont  as t1")->where("t1.id", "=", $id)
            ->whereNotNull("educacioncontinua.ecImportePago2")
            ->select("t1.id","t1.alumno_id", 'alumnos.aluClave',
                "educacioncontinua.ecImportePago2", "educacioncontinua.ecVencimientoPago2",
                DB::raw('92 as concepto'),'periodos.perAnioPago')
            ->join('educacioncontinua', 'educacioncontinua.id', '=', 't1.educacioncontinua_id')
            ->join('periodos', 'periodos.id','=', 'educacioncontinua.periodo_id')
            ->join('alumnos', 'alumnos.id','=','t1.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id');


        $impPagoTres = DB::table("inscritoseducont  as t1")->where("t1.alumno_id", "=", $id)
            ->whereNotNull("educacioncontinua.ecImportePago3")
            ->select("t1.id","t1.alumno_id", 'alumnos.aluClave',
                "educacioncontinua.ecImportePago3", "educacioncontinua.ecVencimientoPago3",
                DB::raw('93 as concepto'),'periodos.perAnioPago')
            ->join('educacioncontinua', 'educacioncontinua.id', '=', 't1.educacioncontinua_id')
            ->join('periodos', 'periodos.id','=', 'educacioncontinua.periodo_id')
            ->join('alumnos', 'alumnos.id','=','t1.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id');


        $impPagoCuatro = DB::table("inscritoseducont  as t1")->where("t1.id", "=", $id)
            ->whereNotNull("educacioncontinua.ecImportePago4")
            ->select("t1.id","t1.alumno_id", 'alumnos.aluClave',
                "educacioncontinua.ecImportePago4", "educacioncontinua.ecVencimientoPago4",
                DB::raw('94 as concepto'),'periodos.perAnioPago')
            ->join('educacioncontinua', 'educacioncontinua.id', '=', 't1.educacioncontinua_id')
            ->join('periodos', 'periodos.id','=', 'educacioncontinua.periodo_id')
            ->join('alumnos', 'alumnos.id','=','t1.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id');


        $impPagoCinco = DB::table("inscritoseducont  as t1")->where("t1.id", "=", $id)
            ->whereNotNull("educacioncontinua.ecImportePago5")
            ->select("t1.id","t1.alumno_id", 'alumnos.aluClave',
                "educacioncontinua.ecImportePago5", "educacioncontinua.ecVencimientoPago5",
                DB::raw('95 as concepto'),'periodos.perAnioPago')
            ->join('educacioncontinua', 'educacioncontinua.id', '=', 't1.educacioncontinua_id')
            ->join('periodos', 'periodos.id','=', 'educacioncontinua.periodo_id')
            ->join('alumnos', 'alumnos.id','=','t1.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id');

        $importeInsc = $importeInsc
            ->union($impPagoUno)
            ->union($impPagoDos)
            ->union($impPagoTres)
            ->union($impPagoCuatro)
            ->union($impPagoCinco)
        ->orderBy("id");



        return Datatables::of($importeInsc)


            ->addColumn('vencimiento', function($query) {
                return Carbon::parse($query->ecVencimientoInscripcion)->day
                    .'/'. Carbon::parse($query->ecVencimientoInscripcion)->formatLocalized('%b')
                    .'/'. Carbon::parse($query->ecVencimientoInscripcion)->year;
            })

            ->addColumn('importe', function($query) {
                return "$" . $query->ecImporteInscripcion;
            })
           
            ->addColumn('action', function($query) {
                $pago = Pago::where("pagConcPago", "=", "90")
                    ->where("pagAnioPer", "=", $query->perAnioPago)
                    ->where("pagClaveAlu", "=", $query->aluClave)
                ->first();

                $btnFichaPago = "";
                if (!$pago) {
                    $btnFichaPago = '<a target="_blank" href="fichaPagoEduContinua/'.$query->id.'/'.$query->concepto.'" class="button modal-trigger button--icon js-button js-ripple-effect" title="Tarjeta Pago">
                        <i class="material-icons">assignment</i>
                    </a>';
                }
                return $btnFichaPago;
            })
        ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( !in_array(User::permiso("inscritos_edu_continua"), ['A', 'B']) ) {

            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        return view('educacion_continua.inscritos.create', [
            'educacionContinua' => EducacionContinua::activos()->get(),
            'fechaActual' => Carbon::now('America/Merida'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInscritoEduContinuaRequest $request)
    {
        $educacionContinua = EducacionContinua::find($request->educacioncontinua_id);
        $alumno = Alumno::find($request->alumno_id);

        $pago = Pago::where("pagConcPago", "90")
            ->where("pagAnioPer", $educacionContinua->periodo->perAnioPago)
            ->where("pagClaveAlu", $alumno->aluClave)
            ->exists();

        try {

            $inscrito = InscritosEduCont::create([
                'alumno_id'               => $request->alumno_id,
                'educacioncontinua_id'    => $request->educacioncontinua_id,
                'iecGrupo'                => $request->iecGrupo,
                'iecEstado'               => $pago ? 'R' : 'P',
                'iecFechaRegistro'        => $request->iecFechaRegistro,
                'iecImporteInscripcion'   => $request->iecImporteInscripcion,
                'iecFechaProcesoRegistro' => $request->iecFechaProcesoRegistro,
            ]);

        } catch (QueryException $e) {
            alert()->error('Ups... '.$e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }
        alert('Escuela Modelo', 'El inscrito se ha creado con éxito','success')->showConfirmButton();
        return redirect('inscritosEduContinua');
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
        if ( !in_array(User::permiso("inscritos_edu_continua"), ['A', 'B']) ) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton();
            return redirect()->back();
        }

        return view('educacion_continua.inscritos.edit', [
            'inscrito' => InscritosEduCont::findOrFail($id),
        ]);
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
        $inscrito = InscritosEduCont::findOrFail($id);
        $pago = Pago::where("pagConcPago", "=", "90")
                ->where("pagAnioPer", "=", $inscrito->educacioncontinua->periodo->perAnioPago)
                ->where("pagClaveAlu", "=", $inscrito->alumno->aluClave)
                ->exists();

        try {
            $inscrito->update([
                'iecGrupo'                => $request->iecGrupo,
                'iecEstado'               => $pago ? 'R' : 'P',
                'iecImporteInscripcion'   => $request->iecImporteInscripcion,
            ]);
        }catch (QueryException $e){
            alert()->error('Ups...'.$e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return redirect()->back();
        }
        alert('Escuela Modelo', 'La ubicación se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
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

        if ( !in_array(User::permiso("inscritos_edu_continua"), ['A', 'B']) ) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton();
        }

        try {
            InscritosEduCont::findOrFail($id)->delete();
        } catch (QueryException $e) {
            alert()->error('Ups... '.$e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
        }

        return redirect('inscritosEduContinua');
    }


    public function realizar_pago($inscrito_id)
    {
        $inscrito = InscritosEduCont::with(['alumno.persona', 'educacioncontinua'])->findOrFail($inscrito_id);
        $alumno = $inscrito->alumno;
        $programa = $inscrito->educacioncontinua;
        $periodo = $programa->periodo;

        return view('educacion_continua.inscritos.realizar_pago', [
            'inscrito' => $inscrito,
            'pagos' => Pago::deAlumno($alumno->aluClave)->deEducacionContinua()
            ->where([
                ['pagAnioPer', '=', $periodo->perAnioPago],
                ['pagRefPago', '=', $programa->id],
            ])->get(),
        ]);
    }





    /**
    * Procesa ficha de pago y genera su PDF
    *
    * @param int $inscrito_id
    * @param string $concepto
    * @param string $banco
    *
    * @return \Illuminate\Http\Response
    */
    public function fichaPago(Request $request, $inscrito_id, $concepto, $banco)
    {
        if(!in_array($concepto, ['90', '91', '92', '93', '94', '95', '96', '97', '98']) || !in_array($banco, ['BBVA', 'HSBC'])) {

            alert('Datos no válidos', 'Los datos de concepto y banco no son válidos.', 'error')->showConfirmButton();
            return back()->withInput();
        }
        $aplicar_custom = $request->{"checkbox_{$concepto}"};
        $importe = $aplicar_custom ? $request->{"custom_importe_{$concepto}"} : null;
        $vencimiento = Carbon::now('America/Merida')->addDays(7)->format('Y-m-d');
        $vencimiento = $aplicar_custom ? $request->{"custom_fechaVencimiento_{$concepto}"} : null; # Que siempre no xD

        if($vencimiento && Carbon::now('America/Merida')->gt($vencimiento)) #si ya pasó la fecha
            $vencimiento = null;

        $inscrito = InscritosEduCont::findOrFail($inscrito_id);
        $ficha_pago = new FichaPago($inscrito, $concepto, $banco, $importe, $vencimiento);

        return $ficha_pago->generarFicha();
    }

}
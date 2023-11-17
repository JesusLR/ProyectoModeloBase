<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Auth;
use URL;
use Debugbar;

use App\Http\Models\Materia;
use App\Http\Models\InscritoExtraordinario;
use App\Http\Models\Extraordinario;
use App\Http\Models\Grupo;
use App\Http\Models\Paquete_detalle;
use App\Http\Models\Cgt;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\ReciboPago;
use App\Http\Models\Periodo;
use App\Http\Models\Programa;
use App\Http\Models\Plan;
use App\Http\Models\Calificacion;
use App\Http\Models\ResumenAcademico;
use App\Http\Models\Aula;
use App\Http\Models\Empleado;
use App\Http\Models\Inscrito;
use App\Http\Models\Prerequisito;
use App\Http\Models\Historico;
use App\Http\Models\Optativa;
use App\Http\Models\Ubicacion;
use App\Http\Models\CalendarioExamen;
use App\Http\Helpers\Utils;
use App\clases\alumnos\MetodosAlumnos;

use Validator;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Luecano\NumeroALetras\NumeroALetras;
use Yajra\DataTables\Facades\DataTables;
//use DB;


class ExtraordinarioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:extraordinario', ['except' => ['index', 'show', 'list', 'getExtraordinario', 'list_solicitudes', 'solicitudes']]);
    }

    public function dateDMY($date){
        $a = null;
        if($date){
            $a = Carbon::parse($date)->format('d/m/Y');
        }
        return $a;
    } //FIN function dateDMY.

    public function updateNumInscritosExtra($extra){
        /*
        * Busca a los inscritos en el extraordinario. los cuenta y actualiza
        * el campo de "extAlumnosInscritos".
        */
        $extraUpdated = false;
        $inscritos = $extra->inscritos()->where('iexEstado','<>','C')->count();
        DB::beginTransaction();
        try {
            $extra->extAlumnosInscritos = $inscritos;
            if($extra->save()){
                $extraUpdated = true;
            }

        } catch (QueryException $e) {
            DB::rollback();
        }
        DB::commit();
        return $extraUpdated;
    }//updateNumInscritosExtra.

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('extraordinario.show-list');
    }

    /**
     * Show list.
     *
     */
    public function list()
    {
        $extraordinarios = Extraordinario::select(
            'extraordinarios.id as extraordinario_id','extraordinarios.extAlumnosInscritos',
            'extraordinarios.extPago','extraordinarios.extFecha','extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','materias.matClave','materias.matNombreOficial as matNombre',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave',
            'programas.progClave','ubicacion.ubiClave','optativas.optNombre')
            ->join('periodos', 'extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('materias', 'extraordinarios.materia_id', '=', 'materias.id')
            ->join('planes', 'materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('aulas', 'extraordinarios.aula_id', '=', 'aulas.id')
            ->join('empleados', 'extraordinarios.empleado_id', '=', 'empleados.id')
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            ->leftjoin('optativas','extraordinarios.optativa_id','optativas.id');

        return Datatables::of($extraordinarios)
            ->filterColumn('nombreCompleto',function($query, $keyword) {
                return $query->whereHas('empleado.persona', function($query) use($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })
            ->addColumn('action',function($query) {
                return '<a href="extraordinario/' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="calificacion/agregarextra/'
                . $query->extraordinario_id
                . '" class="button button--icon js-button js-ripple-effect" title="Calificaciones">
                    <i class="material-icons">assignment_turned_in</i>
                </a>
                <form class="form-acta-examen'.$query->extraordinario_id.'" target="_blank" action="extraordinario/actaexamen/'.$query->extraordinario_id.'" method="POST" style="display: inline;">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <a href="#" data-id="'.$query->extraordinario_id.'" class="button button--icon js-button js-ripple-effect confirm-acta-examen" title="Acta de examen extraordinario">
                        <i class="material-icons">assignment</i>
                    </a>
                </form>
                <a href="extraordinario/' . $query->extraordinario_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <form id="delete_' . $query->extraordinario_id . '" action="extraordinario/' . $query->extraordinario_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
        ->make(true);
    }


    public function getAlumnosByFolioExtraordinario(Request $request, $extraordinario_id)
    {

        $extraordinario = Extraordinario::with(
            'empleado.persona', 'empleadoSinodal.persona', 'periodo',
            'materia.plan.programa.escuela.departamento.ubicacion',
            'aula', 'optativa.materia')
        ->findOrFail($extraordinario_id);

        $inscritos = ResumenAcademico::with('alumno.persona')
            ->where('plan_id',$extraordinario->materia->plan->id)
            ->get();


        return response()->json($inscritos);
    }


    /**
     * Show extraordinario.
     *
     */
    public function getExtraordinario(Request $request, $extraordinario_id)
    {
        if ($request->ajax()) {
            $extraordinario = Extraordinario::with(
                'empleado.persona', 'empleadoSinodal.persona', 'periodo',
                'materia.plan.programa.escuela.departamento.ubicacion',
                'aula', 'optativa.materia')
            ->find($extraordinario_id);

            return response()->json($extraordinario);
        }
    }

    public function validarAlumnoPresentaExtra(Request $request)
    {
        $alumno = Alumno::findOrFail($request->alumno);
        $puedePresentarExtra = true;
        $extraordinario = Extraordinario::with('materia')
            ->where("id", "=", $request->folioExt)
        ->first();

        $materia = $extraordinario->materia;
        // $plan = $materia->plan;
        $msg = null;
        $boolRevisarPagos = true;

        $materias_reprobadas = MetodosAlumnos::materias_reprobadas($alumno->aluClave);
        if(!$materias_reprobadas->contains('materia_id', $materia->id)) {
            $puedePresentarExtra = false;
            $msg = "El alumno no tiene reprobada la materia";
        }
        // $materias_plan = $plan->materias()->get();
        // $calMin = $plan->programa->escuela->departamento->depCalMinAprob;

        // $historicos = Historico::where("alumno_id","=",$request->alumno)
        //     ->where("plan_id","=",$plan->id)->get();

        // $historico = $historicos->where("alumno_id", "=", $request->alumno)
        //     ->where("materia_id", "=", $extraordinario->materia->id)
        //     ->sortByDesc("histFechaExamen")
        //     ->first();


        // if($historico){ # if_existeHistorico.

        //     if ($historico->histPeriodoAcreditacion == "EX") {
        //         if (($historico->histTipoAcreditacion == "X1" || $historico->histTipoAcreditacion == "X2") && $historico->histCalificacion >= $calMin) {
        //             $puedePresentarExtra = false;
        //             $msg = "- El alumno ya aprobó esta materia. \n";
        //             $boolRevisarPagos = false;
        //         }

        //         if ($historico->histTipoAcreditacion == "X3") {
        //             $puedePresentarExtra = false;
        //             $msg = "- El alumno ha excedido el número de intentos de extraordinarios. \n";
        //         }
        //     }

        //     if ($historico->histPeriodoAcreditacion == "CP" && $historico->histCalificacion >= $calMin) {
        //         $puedePresentarExtra = false;
        //         $msg = "- El alumno tiene aprobada la materia. \n";
        //         $boolRevisarPagos = false;
        //     }
        //     if ($historico->histPeriodoAcreditacion == "PN" && $historico->histCalificacion >= $calMin) {
        //         $puedePresentarExtra = false;
        //         $msg = "- El alumno no ha reprobado esta materia. \n";
        //         $boolRevisarPagos = false;
        //     }


        //     if ($historico->histPeriodoAcreditacion == "RC") {
        //         $puedePresentarExtra = false;
        //         $msg = "- El alumno ya ha acreditado esta materia. \n";
        //         $boolRevisarPagos = false;
        //     }

        //     if ($historico->histPeriodoAcreditacion == "RV") {
        //         $puedePresentarExtra = false;
        //         $msg = "- El alumno ya ha acreditado esta materia. \n";
        //         $boolRevisarPagos = false;
        //     }

        //     if($extraordinario->materia->matPrerequisitos > 0){
        //         $preRequisits = Prerequisito::where("materia_id","=",$extraordinario->materia->id)
        //             ->pluck('materia_prerequisito_id');
        //         foreach($preRequisits as $mat_pre_id){
        //             $mat_pre = $historicos->where("materia_id","=",$mat_pre_id)
        //                 ->sortByDesc('histFechaExamen')
        //                 ->first();
        //             if(!$mat_pre){
        //                 $mat_plan = $materias_plan->where("id","=",$mat_pre_id)->first();
        //                 $matNombre = $mat_plan->matNombre;
        //                 $puedePresentarExtra = false;
        //                 $msg = "- El alumno no ha cursado la materia ".$matNombre.". \n";
        //             }
        //         }
        //     }

        // }else{
        //     $puedePresentarExtra = false;
        //     $msg = "- El alumno no tiene registro en histórico con esta materia. \n";
        // }//FIN if_existeHistorico.


        if ($boolRevisarPagos)
        {
            //validando que no sea DEUDOR, si no hay que mandarlo con Francisco Lopez.
            if(MetodosAlumnos::esDeudor($alumno->aluClave)) {
                $puedePresentarExtra = false;
                $msg = $msg . "\n- El alumno tiene una deuda de pago con la Escuela. Favor de remitirlo con el Lic. Francisco Lopez.";
            }
        }

        $extras_alumno = InscritoExtraordinario::where('alumno_id', $alumno->id)->get();

        /**
        * El alumno está inscrito a un extra con la misma fecha.
        */
        $fechaOcupada = $extras_alumno->where('iexFecha', '=', $extraordinario->extFecha);
        /**
        * El alumno ya está inscrito a un extra con esta materia
        */
        $ya_esta_inscrito_a_materia = $extras_alumno->where('extraordinario_id', $extraordinario->id)->first();
        if($fechaOcupada->isNotEmpty() || $ya_esta_inscrito_a_materia) {
            $puedePresentarExtra = false;
            $msg = $msg . "\n- El alumno ya tiene un examen para esta misma fecha o ya está inscrito a este extraordinario.";
        }


        return response()->json([
            "puedePresentarExtra" => $puedePresentarExtra,
            "msg" => $msg,
        ]);
    }

    /**
     * Show list_solicitudes.
     *
     */
    public function list_solicitudes()
    {
        $inscritosextraordinarios = InscritoExtraordinario::select(
            'inscritosextraordinarios.id as inscritoExtraordinario_id','inscritosextraordinarios.iexFecha',
            'inscritosextraordinarios.iexCalificacion','inscritosextraordinarios.iexEstado', 'inscritosextraordinarios.iexModoRegistro',
            'extraordinarios.id as extraordinario_id','extraordinarios.extFecha as extFecha','materias.matClave','materias.matNombreOficial as matNombre',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave', 'optativas.optNombre',
            'alumnos.aluClave', 'periodos.perNumero','periodos.perAnio','programas.progClave','ubicacion.ubiClave')
            ->join('extraordinarios', 'inscritosextraordinarios.extraordinario_id', '=', 'extraordinarios.id')
            ->join('periodos', 'extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('materias', 'extraordinarios.materia_id', '=', 'materias.id')
            ->join('planes', 'materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('aulas', 'extraordinarios.aula_id', '=', 'aulas.id')
            ->join('alumnos', 'inscritosextraordinarios.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->leftjoin('optativas','extraordinarios.optativa_id','optativas.id');
            //->where('iexEstado', '<>', 'P');

        return Datatables::of($inscritosextraordinarios)
            ->filterColumn('nombreCompleto',function($query,$keyword) {
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })
            ->addColumn('action',function($query) {
                return '<a href="' . route('show.solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="' . route('edit.solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <a href="#" class="button button--icon js-button js-ripple-effect" title="Pagar">
                    <i class="material-icons">attach_money</i>
                </a>
                <a href="' . route('cancelar.solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Cancelar">
                    <i class="material-icons">cancel</i>
                </a>
                <a href="' . route('recibo.solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" target="_blank" title="ver recibo">
                    <i class="material-icons">subject</i>
                </a>';
            })


        ->make(true);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudes()
    {
        return View('extraordinario.show-solicitudes-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        $empleados = Empleado::with('persona')->activos()->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');
        return view('extraordinario.create', compact('ubicaciones', 'empleados', 'hoy'));
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
        $calendario = CalendarioExamen::where('periodo_id', $request->periodo_id)
        ->latest('created_at')->first();
        if(!$calendario) {
            alert('Ups!', 'No se encontró calendario de exámenes para este periodo. Favor de verificar esta información.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $fechaInicio = $calendario->calexInicioExtraordinario ?: false;
        $fechaFin = $calendario->calexFinExtraordinario ?: false;

        $start2 = $calendario->calexInicioExtraordinario2 ?: false;
        $end2 = $calendario->calexFinExtraordinario2 ?: false;

        if(!$fechaInicio || !$fechaFin) {
            alert('Ups!', 'No se encontraron fechas para periodo extraordinario en el calendario de este periodo. No se pueden hacer registros sin contar con estos datos. Favor de verificar.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $validator = Validator::make($request->all(),
            [
                'materia_id'  => 'required',
                'periodo_id'  => 'required',
                'empleado_id' => 'required',
                // 'extFecha'    => 'required|after_or_equal:'.$fechaInicio.'|before_or_equal:'.$fechaFin,
            ],
            [
                'materia_id.required'  => "La materia es requerida",
                'periodo_id.required'  => "El periodo es requerido",
                'empleado_id.required' => "El empleado es requerido",
                'extFecha.required'    => "La fecha de Extraordinario es requerida",
                'extFecha.after_or_equal' => "La fecha del extraordinario debe ser después o igual a las fecha de inicio de extraordinarios programada en el calendario de exámenes de este periodo.",
                'extFecha.before_or_equal' => "La fecha de extraordinario no puede ser mayor a la establecida como fecha de Fin de extraordinarios. Revise el calendario de exámenes de este periodo.",
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $check = Carbon::parse($request->extFecha)->between(Carbon::parse($fechaInicio)->subDays(1),Carbon::parse($fechaFin)->addDay());
        $check2 = ($start2 || $end2) ? Carbon::parse($request->extFecha)->between(Carbon::parse($start2)->subDays(1),Carbon::parse($end2)->addDay()) : false;

        if ($check) {
            $extOportunidad_DentroDelPeriodo = 1;
        } elseif($check2) {
            $extOportunidad_DentroDelPeriodo = 2;
        } else {
            alert('Ups!', 'La fecha no coincide con las fechas ingresadas en calendario extraordinarios.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        try {
            $programa_id = $request->programa_id;
            if (Utils::validaPermiso('extraordinario', $programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect()->back();
            }

            // validar que no se repitan por periodo, materia y por extOportunidad_DentroDelPeriodo
            $extra = Extraordinario::where('periodo_id', $request->periodo_id)
            ->where('materia_id', $request->materia_id)
            ->where('extOportunidad_DentroDelPeriodo', $extOportunidad_DentroDelPeriodo)
            ->where('extGrupo', $request->extGrupo)
            ->first();
            if($extra) {
                alert()->error('Ups...', 'Ya existe un extraordinario con este periodo, materia registrado con estas fechas!')->showConfirmButton()->autoClose(5000);
                return redirect()->back();
            }

            Extraordinario::create([
                'materia_id'            => $request->materia_id,
                'periodo_id'            => $request->periodo_id,
                'empleado_id'           => $request->empleado_id,
                'empleado_sinodal_id'   => $request->empleado_sinodal_id,
                'aula_id'               => $request->aula_id,
                'optativa_id'           => $request->optativa_id,
                'extFecha'              => $request->extFecha,
                'extHora'               => $request->extHora,
                'extNumeroFolio'        => NULL,
                'extNumeroActa'         => NULL,
                'extNumeroLibro'        => NULL,
                'extPago'               => Utils::validaEmpty($request->extPago),
                'extGrupo'              => $request->extGrupo,
                'extOportunidad_DentroDelPeriodo' => $extOportunidad_DentroDelPeriodo
            ]);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('extraordinario/create')->withInput();
        }
        alert('Escuela Modelo', 'Se creo el extraordinario con éxito', 'success')->showConfirmButton();
        return redirect('extraordinario');
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
        $calendario = CalendarioExamen::where("periodo_id", $request->periodo_id)
        ->latest('created_at')->first();
        if(!$calendario) {
            alert('Ups!', 'No se encontró calendario de exámenes para este periodo. Favor de verificar esta información.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $fechaInicio = $calendario->calexInicioExtraordinario ?: false;
        $fechaFin = $calendario->calexFinExtraordinario ?: false;

        $start2 = $calendario->calexInicioExtraordinario2 ?: false;
        $end2 = $calendario->calexFinExtraordinario2 ?: false;

        if(!$fechaInicio || !$fechaFin) {
            alert('Ups!', 'No se encontraron fechas para periodo extraordinario en el calendario de este periodo. No se pueden hacer registros sin contar con estos datos. Favor de verificar.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $validator = Validator::make($request->all(),
            [
                'materia_id' => 'required',
                'periodo_id' => 'required',
                'empleado_id' => 'required',
                // 'extFecha'    => 'required|after_or_equal:'.$fechaInicio.'|before_or_equal:'.$fechaFin,
            ],
            [
                'materia_id.required' => "La materia es requerida",
                'periodo_id.required' => "El periodo es requerido",
                'empleado_id.required' => "El empleado es requerido",
                'extFecha.required'    => "La fecha de Extraordinario es requerida",
                'extFecha.after_or_equal' => "La fecha del extraordinario debe ser después o igual a las fecha de inicio de extraordinarios programada en el calendario de exámenes de este periodo.",
                'extFecha.before_or_equal' => "La fecha de extraordinario no puede ser mayor a la establecida como fecha de Fin de extraordinarios. Revise el calendario de exámenes de este periodo.",
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $check = Carbon::parse($request->extFecha)->between(Carbon::parse($fechaInicio)->subDays(1),Carbon::parse($fechaFin)->addDay());
        $check2 = ($start2 || $end2) ? Carbon::parse($request->extFecha)->between(Carbon::parse($start2)->subDays(1),Carbon::parse($end2)->addDay()) : false;

        if ($check) {
            $extOportunidad_DentroDelPeriodo = 1;
        } elseif($check2) {
            $extOportunidad_DentroDelPeriodo = 2;
        } else {
            alert('Ups!', 'La fecha no coincide con las fechas ingresadas en calendario extraordinarios.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        try {
            $extraordinario = Extraordinario::findOrFail($id);
            $extraordinario->materia_id = $request->materia_id;
            $extraordinario->periodo_id = $request->periodo_id;
            $extraordinario->empleado_id = $request->empleado_id;
            $extraordinario->empleado_sinodal_id = $request->empleado_sinodal_id;
            $extraordinario->aula_id = $request->aula_id;
            $extraordinario->optativa_id = $request->optativa_id;
            $extraordinario->extFecha = $request->extFecha;
            $extraordinario->extHora = $request->extHora;
            $extraordinario->extNumeroFolio = NULL;
            $extraordinario->extNumeroActa = NULL;
            $extraordinario->extNumeroLibro = NULL;
            $extraordinario->extPago = Utils::validaEmpty($request->extPago);
            $extraordinario->extGrupo = $request->extGrupo;
            $extraordinario->save();

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
        alert('Escuela Modelo', 'El extraordinario se ha actualizado con éxito', 'success')->showConfirmButton();
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
        $extraordinario = Extraordinario::find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe extraordinario solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        if($extraordinario->inscritos()->count() + $extraordinario->preinscritos()->count() > 0) {
            alert("No se puede borrar el Extraordinario #{$extraordinario->id}", 'Actualmente hay alumnos inscritos a este extraordinario o en proceso de solicitud. Ya se ha generado una ficha pendiente por pagar. Favor de dirigirse a la opción PREINSCRITOS EXTRAORDINARIOS y revisar quienes son los alumnos que desean inscribirse a este examen. Es importante que se comunique con ellos para validar que no hayan pagado la inscripción a este examen que desea eliminar', 'warning')->showConfirmButton();
            return redirect()->back();
        }

        try {
            if (Utils::validaPermiso('extraordinario', $extraordinario->materia->plan->programa_id)) {

                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect('extraordinario');
            }
            if ($extraordinario->delete()) {

                alert('Escuela Modelo', 'El extraordinario se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {

                alert()->error('Error...', 'No se puedo eliminar el extraordinario')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }

        return redirect()->back();
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
        $extraordinario = Extraordinario::with('empleado','empleadoSinodal', 'periodo', 'materia', 'aula', 'optativa')->find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe extraordinario solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        return view('extraordinario.show', compact('extraordinario'));
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
        $extraordinario = Extraordinario::with('empleado', 'empleadoSinodal', 'periodo', 'materia', 'aula', 'optativa')->find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe extraordinario solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        if($extraordinario->inscritos()->count() + $extraordinario->preinscritos()->count() > 0) {
            alert("No se puede editar el Extraordinario #{$extraordinario->id}", 'Actualmente hay alumnos inscritos a este extraordinario o en proceso de solicitud. Ya se ha generado una ficha pendiente por pagar. Favor de dirigirse a la opción PREINSCRITOS EXTRAORDINARIOS y revisar quienes son los alumnos que desean inscribirse a este examen. Es importante que se comunique con ellos para validar que no hayan pagado la inscripción a este examen que desea modificar', 'warning')->showConfirmButton();
            return redirect()->back();
        }


        $empleados = Empleado::with('persona')->activos()->get();
        $aulas = Aula::where('ubicacion_id', $extraordinario->materia->plan->programa->escuela->departamento->ubicacion->id)->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');

        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('extraordinario', $extraordinario->materia->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        return view('extraordinario.edit', compact('extraordinario', 'empleados', 'aulas', 'hoy'));
    }



    //SOLICITUDES EXTRAORDINARIO



        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudCreate()
    {
        return view('extraordinario.create-solicitud');
    }

    public function solicitudStore(Request $request)
    {
        $fechaActual = Carbon::now('CDT');
        $aceptadaSinOrdinario = false;
        $ultOportunidad = false;


        $validator = Validator::make($request->all(),
            [
                'alumno_id'         => 'required',
                'iexEstado'         => 'required',
                'extraordinario_id' => 'required',

            ],
            [
                'alumno_id.required'         => "El alumno es requerido",
                'iexEstado.required'         => "El estatus de pago es requerido",
                'extraordinario_id.required' => "El folio extraordinario es requerido"
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /**
        * Si el alumno está inscrito a un extra con la misma fecha, no puede inscribirse a este extra.
        */
        $extraordinario = Extraordinario::find($request->extraordinario_id);
        $fechaOcupada = InscritoExtraordinario::where('alumno_id', $request->alumno_id)
        ->whereDate('iexFecha', '=', $extraordinario->extFecha)->get();
        if($fechaOcupada->isNotEmpty()) {
            alert()->warning('No se puede procesar la Solicitud', 'El alumno ya tiene un examen para esa misma fecha.')->showConfirmButton();
            return back()->withInput();
        }

        try {

            $inscritoExt = New InscritoExtraordinario;
            $inscritoExt->alumno_id = $request->alumno_id;
            $inscritoExt->extraordinario_id = $request->extraordinario_id;
            //$inscritoExt->iexFecha = $request->iexFecha;
            $inscritoExt->iexFecha = $extraordinario->extFecha;
            $inscritoExt->iexCalificacion = NULL;
            $inscritoExt->iexEstado = $request->iexEstado;
            $inscritoExt->iexModoRegistro = $request->iexModoRegistro;
            $inscritoExt->iexFolioHistorico = NULL;
            $inscritoExt->extOportunidad_DentroDelPeriodo = $extraordinario->extOportunidad_DentroDelPeriodo;
            $inscritoExt->save();

            if ($request->iexEstado == 'P' && $request->iexModoRegistro == 'E') {
                $alumno = Alumno::findOrFail($request->alumno_id);
                ReciboPago::create([
                    'alumno_id' => $request->alumno_id,
                    'aluClave' => $alumno->aluClave,
                    'conpClave' => '36',
                    'concepto' => 'INSCRIPCIÓN A CURSOS DE REGULARIZACIÓN',
                    'importe' => $request->extPago,
                    'fecha' =>  Carbon::now()->format("Y-m-d"),
                    'hora' => Carbon::now()->format("h:i:s"),
                    'reciboEstado' => 'Pagado',
                    'inscritosextraordinarios_id' => $inscritoExt->id,
                ]);
            }

            $extra = $inscritoExt->extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            $extPago = $inscritoExt->extraordinario->extPago;
            $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);

            $inscrito = Inscrito::with('curso','grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('grupo',function($query) use($inscritoExt){
                    $query->where('materia_id',$inscritoExt->extraordinario->materia_id);
                })
                ->first();
            if($inscrito){
                $calificaciones = Calificacion::where('inscrito_id',$inscrito->id)
                    ->first();
                if(!$calificaciones->inscCalificacionOrdinario){
                    $aceptadaSinOrdinario = true;
                }
            }else{
                $aceptadaSinOrdinario = true;
            }

            $historicosX2 = Historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('materia_id',$inscritoExt->extraordinario->materia_id)
                ->where('histTipoAcreditacion','X2')->get();
            if(count($historicosX2) > 0){
                $ultOportunidad = true;
            }

            if($extraUpdated){
                alert('Escuela Modelo', 'La solicitud de extraordinario se ha guardado correctamente', 'success')->showConfirmButton();
            }else{
                alert('Escuela Modelo', 'La solicitud de extraordinario se ha 
                    guardado correctamente, pero el Extraordinario no fue actualizado'
                    , 'warning')
                ->showConfirmButton();
            }

            // Unix
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            //Nombre del archivo PDF de descarga
            $nombreArchivo = "pdf_recibo_extraordinario";
            //Cargar vista del PDF
            $pdf = PDF::loadView("extraordinario.pdf.pdf_recibo_extraordinario",[
            "inscritoExt" => $inscritoExt,
            "pagoLetras" => $pagoLetras,
            "aceptadaSinOrdinario" => $aceptadaSinOrdinario,
            "ultOportunidad" => $ultOportunidad,
            "fechaActual" => $this->dateDMY($fechaActual),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo
            ]);
            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';
            return $pdf->stream($nombreArchivo . '.pdf');

            //return redirect()->back();

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
    }




    /**
     * Show the form for edit a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudShow($id)
    {
        $solicitud = InscritoExtraordinario::with('extraordinario')->findOrFail($id);
        $iexEstado = ESTADO_SOLICITUD;
        $iexModoRegistro = MODO_REGISTRO;
        return view('extraordinario.show-solicitud', compact('solicitud', 'iexEstado', 'iexModoRegistro'));
    }


    /**
     * Show the form for edit a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudEdit($id)
    {
        $solicitud = InscritoExtraordinario::with('extraordinario')->findOrFail($id);
        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('solicitud_extraordinario', $solicitud->extraordinario->materia->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('solicitudes/extraordinario');
        } else {
            $iexEstado = ESTADO_SOLICITUD;
            $iexModoRegistro = MODO_REGISTRO;
            return view('extraordinario.edit-solicitud', compact('solicitud', 'iexEstado', 'iexModoRegistro'));
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
    public function solicitudUpdate(Request $request, $id)
    {
        try {
            $inscritoExtraordinario = InscritoExtraordinario::findOrFail($id);
            $inscritoExtraordinario->iexCalificacion    = $request->input('iexCalificacion');
            $inscritoExtraordinario->iexEstado          = $request->input('iexEstado');
            $inscritoExtraordinario->iexModoRegistro    = $request->input('iexModoRegistro');
            $inscritoExtraordinario->save();

            $alumno = Alumno::findOrFail($request->alumno_id);
            $reciboPago = ReciboPAgo::where('inscritosextraordinarios_id', $id)->first();
            if ($request->iexEstado == 'P' && $request->iexModoRegistro == 'E') {
                if (!$reciboPago) {
                    ReciboPago::create([
                        'alumno_id' => $request->alumno_id,
                        'aluClave' => $alumno->aluClave,
                        'conpClave' => '36',
                        'concepto' => 'INSCRIPCIÓN A CURSOS DE REGULARIZACIÓN',
                        'importe' => $request->extPago,
                        'fecha' =>  Carbon::now()->format("Y-m-d"),
                        'hora' => Carbon::now()->format("h:i:s"),
                        'reciboEstado' => 'Pagado',
                        'inscritosextraordinarios_id' => $id,
                    ]);
                } else {
                    $reciboPago->update([
                        'reciboEstado' => 'Pagado'
                    ]);
                }
            }
            if ($request->iexEstado == 'C' && $request->iexModoRegistro == 'E') {
                if ($reciboPago) {
                    $reciboPago->update([
                        'reciboEstado' => 'Cancelado'
                    ]);
                }
            }

            $extra = $inscritoExtraordinario->extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            if($extraUpdated){
            alert('Escuela Modelo', 'La solicitud de extraordinario se ha actualizado con éxito', 'success')->showConfirmButton();
            }else{
                alert('Escuela Modelo', 'La solicitud de extraordinario se ha 
                        actualizado correctamente, pero el Extraordinario no fue 
                        actualizado'
                        , 'warning')
                    ->showConfirmButton();
            }

            return redirect('solicitudes/extraordinario');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('edit/solicitud/' . $id)->withInput();
        }
    }


    public function solicitudCancelar(Request $request)
    {
        try {
            $inscritoExtraordinario = InscritoExtraordinario::findOrFail($request->id);
            $inscritoExtraordinario->iexEstado = "C";
            $inscritoExtraordinario->save();

            if ($inscritoExtraordinario->iexModoRegistro == 'E') {
                $reciboPago = ReciboPAgo::where('inscritosextraordinarios_id', $request->id)->first();
                if ($reciboPago) {
                    $reciboPago->update([
                        'reciboEstado' => 'Cancelado'
                    ]);
                }
            }

            $extra = $inscritoExtraordinario->extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            if($extraUpdated){
                alert('Escuela Modelo', 'La solicitud de extraordinario se ha
                 cancelado con éxito', 'success')->showConfirmButton();
            }else{
                alert('Escuela Modelo', 'La solicitud de extraordinario se ha 
                    cancelado correctamente, pero el Extraordinario no fue 
                    actualizado'
                    , 'warning')
                ->showConfirmButton();
            }

            return redirect('solicitudes/extraordinario');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect()->back()->withInput();
        }
    }

    public function solicitudRecibo(Request $request){

        $fechaActual = Carbon::now('CDT');
        $aceptadaSinOrdinario = false;
        $ultOportunidad = false;

        try {
            $inscritoExt = InscritoExtraordinario::findOrFail($request->id);

            $extPago = $inscritoExt->extraordinario->extPago;
            $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);

            $inscrito = Inscrito::with('curso','grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('grupo',function($query) use($inscritoExt){
                    $query->where('materia_id',$inscritoExt->extraordinario->materia_id);
                })
                ->first();
            if($inscrito){
                $calificaciones = Calificacion::where('inscrito_id',$inscrito->id)
                    ->first();
                if(!$calificaciones->inscCalificacionOrdinario){
                    $aceptadaSinOrdinario = true;
                }
            }

            $historicosX2 = Historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('materia_id',$inscritoExt->extraordinario->materia_id)
                ->where('histTipoAcreditacion','X2')->get();
            if(count($historicosX2) > 0){
                $ultOportunidad = true;
            }


            alert('Escuela Modelo', 'La solicitud de extraordinario se ha guardado correctamente', 'success')->showConfirmButton();

            // Unix
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            //Nombre del archivo PDF de descarga
            $nombreArchivo = "pdf_recibo_extraordinario";
            //Cargar vista del PDF
            $pdf = PDF::loadView("extraordinario.pdf.pdf_recibo_extraordinario",[
            "inscritoExt" => $inscritoExt,
            "pagoLetras" => $pagoLetras,
            "aceptadaSinOrdinario" => $aceptadaSinOrdinario,
            "ultOportunidad" => $ultOportunidad,
            "fechaActual" => $this->dateDMY($fechaActual),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo
            ]);
            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';
            return $pdf->stream($nombreArchivo . '.pdf');


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
    }

    public function actaExamen($id){

        $extraordinario = Extraordinario::find($id);
        $inscritos = InscritoExtraordinario::where('extraordinario_id',$extraordinario->id)
        ->where('iexEstado', 'P')
        ->get();

        if($inscritos->isEmpty()) {
            alert()->error('Error', 'No existen registros con la información proporcionada')->showConfirmButton();
                return back()->withInput();
        }

        $inscritoIds = $inscritos->map(function($item,$key){
            return $item->id;
        });      

        $inscritoEx = collect();
        $fechaActual = Carbon::now();
        $periodo = '';

        foreach($inscritoIds as $inscrito_id){
            $inscrito = InscritoExtraordinario::where('id', '=', $inscrito_id)->first();
            $idExtra = $inscrito->extraordinario->id;
            //Datos del alumno
            $aluClave = $inscrito->alumno->aluClave;
            $perApellido1 = $inscrito->alumno->persona->perApellido1;
            $perApellido2 = $inscrito->alumno->persona->perApellido2;
            $perNombre = $inscrito->alumno->persona->perNombre;
            $alumnoNombre = $perApellido1.' '.$perApellido2.' '.$perNombre;
            //Datos del empleado (maestro)
            $perApellido1Emp = $inscrito->extraordinario->empleado->persona->perApellido1;
            $perApellido2Emp = $inscrito->extraordinario->empleado->persona->perApellido2;
            $perNombreEmp = $inscrito->extraordinario->empleado->persona->perNombre;
            $empleadoNombre = $perNombreEmp.' '.$perApellido1Emp.' '.$perApellido2Emp;
            $empleadoId = $inscrito->extraordinario->empleado_id;
            //Datos de la secretaria administrativa
            $depTituloDoc = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->depTituloDoc;
            $depNombreDoc = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->depNombreDoc;
            $depPuestoDoc = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->depPuestoDoc;
      
            $iexCalificacion = $inscrito->iexCalificacion;
            $planClave = $inscrito->extraordinario->materia->plan->planClave;
            $progClave = $inscrito->extraordinario->materia->plan->programa->progClave;
            $progNombre = $inscrito->extraordinario->materia->plan->programa->progNombre;
            $ubiClave = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiClave;
            $ubiNombre = $inscrito->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiNombre;
            $matClave = $inscrito->extraordinario->materia->matClave;
            $matNombre = $inscrito->extraordinario->materia->matNombre;
            $extClave = $inscrito->extraordinario->id;
            $extFecha = $inscrito->extraordinario->extFecha;
            $extHora = $inscrito->extraordinario->extHora;
            $extGrupo = $inscrito->extraordinario->extGrupo;
            $califLetras = $iexCalificacion === null ? '' : str_replace(" CON 00/100","",NumeroALetras::convert($iexCalificacion));

            if($inscrito->extraordinario->materia->esAlfabetica()) {
                if (!is_null($iexCalificacion)) {
                    $califLetras = $iexCalificacion == 0 ? 'APROBADO' : 'NO APROBADO';
                    $iexCalificacion = $iexCalificacion == 0 ? 'A' : 'NA';
                }
            }

            $optativa = Optativa::where('id',$inscrito->extraordinario->optativa_id)->first();
      
            $inscritoEx->push([  
              'idExtra'=>$idExtra,
              'aluClave'=>$aluClave,
              'perApellido1'=>$perApellido1,
              'alumnoNombre'=>$alumnoNombre,
              'empleadoNombre'=>$empleadoNombre,
              'empleadoId'=>$empleadoId,
              'depTituloDoc'=>$depTituloDoc,
              'depNombreDoc'=>$depNombreDoc,
              'depPuestoDoc'=>$depPuestoDoc,
              'iexCalificacion'=>$iexCalificacion,
              'califLetras'=>$califLetras,
              'progClave'=>$progClave,
              'progNombre'=>$progNombre,
              'matClave'=>$matClave,
              'planClave'=>$planClave,
              'matNombre'=>$matNombre,
              'extClave'=>$extClave,
              'extFecha'=>$extFecha,
              'extHora'=>$extHora,
              'extGrupo'=>$extGrupo,
              'ubiClave'=>$ubiClave,
              'optativa'=>$optativa,
              'ubiNombre'=>$ubiNombre
            ]);
          
          }
          
          $inscritoEx = $inscritoEx->sortBy('perApellido1');
          $inscritoEx = $inscritoEx->groupBy('idExtra');
          
          setlocale(LC_TIME, 'es_ES.UTF-8');
          // En windows
          setlocale(LC_TIME, 'spanish');
          $nombreArchivo = 'pdf_acta_extraordinario';
          $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
            
            "inscritoEx" => $inscritoEx,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo,
            "periodo" => $periodo
            /*
            "nombreArchivo" => $nombreArchivo,
            "aluEstado" => $request->aluEstado,
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $fechaActual->toTimeString()
            */
          ]);
      
      
          $pdf->setPaper('letter', 'portrait');
          $pdf->defaultFont = 'Times Sans Serif';
      
          return $pdf->stream($nombreArchivo . '.pdf');
        
    }

    public function validarAlumno($aluClave){

        $alumno = Alumno::where('aluClave',$aluClave)->first();
        $curso = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion')->where('alumno_id',$alumno->id)
        ->where('curEstado','<>','B')->latest('curFechaRegistro')->first();

        $departamento = $curso->cgt->plan->programa->escuela->departamento;

        $periodo = Periodo::find($departamento->perActual);

        // $inscritoExtraordinario = InscritoExtraordinario::with('extraordinarios')
        // ->whereHas('extraordinarios',function($query) use ($departamento){
        //     $query->where('periodo_id',$departamento->perActual);
        // })
        // ->where('alumno_id',$alumno->id)->get();
        
        // $extras = $inscritoExtraordinario->filter(function($item,$key) use($departamento){
        //    return $item->iexCalificacion < $departamento->depCalMinAprob;
        // });

        $extras = InscritoExtraordinario::select(
            'extraordinarios.id as extraordinario_id','extraordinarios.extAlumnosInscritos',
            'extraordinarios.extPago','inscritosextraordinarios.iexFecha','extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','materias.matClave','materias.matNombreOficial as matNombre',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave',
            'programas.progNombre','ubicacion.ubiNombre','optativas.optNombre','inscritosextraordinarios.iexCalificacion')
            ->join('extraordinarios', 'inscritosextraordinarios.extraordinario_id', '=', 'extraordinarios.id')
            ->join('periodos', 'extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('materias', 'extraordinarios.materia_id', '=', 'materias.id')
            ->join('planes', 'materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('aulas', 'extraordinarios.aula_id', '=', 'aulas.id')
            ->join('empleados', 'extraordinarios.empleado_id', '=', 'empleados.id')
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            ->leftjoin('optativas','extraordinarios.optativa_id','optativas.id')
            // ->where('periodo.id',$departamento->perActual)
            ->where('inscritosextraordinarios.iexCalificacion','<',$departamento->depCalMinAprob)
            ->whereBetween('inscritosextraordinarios.iexFecha',[$periodo->perFechaInicial,$periodo->perFechaFinal])
            ->where('inscritosextraordinarios.alumno_id',$alumno->id);


        return Datatables::of($extras)
        ->filterColumn('nombreCompleto',function($query, $keyword) {
            return $query->whereHas('empleado.persona', function($query) use($keyword) {
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query) {
            return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
        })
        ->addColumn('iexFecha',function($query) {
            return Utils::fecha_string($query->iexFecha,true);
        })
        ->addColumn('iexCalificacion',function($query){
            switch ($query->iexCalificacion) {
                case -1:
                return 'NPE';
                break;

                case -2:
                return 'SD';
                break;

                case -3:
                return 'Npa';
                break;
                
                default:
                return $query->iexCalificacion;
                break;
            }
        })
        ->make(true);

    }
}

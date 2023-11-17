<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Auth;
use URL;
use Debugbar;

use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use App\Http\Helpers\Utils;
use App\clases\alumnos\MetodosAlumnos;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_calendarioexamen;
use App\Http\Models\Bachiller\Bachiller_cch_inscritos;
use App\Http\Models\Bachiller\Bachiller_empleados;
use App\Http\Models\Bachiller\Bachiller_extraordinarios;
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Http\Models\Bachiller\Bachiller_resumenacademico;
use Validator;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Luecano\NumeroALetras\NumeroALetras;
use Yajra\DataTables\Facades\DataTables;
//use DB;


class BachillerCursoRecuperativoController extends Controller
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
        $inscritos = $extra->bachiller_inscritos()->where('iexEstado','<>','C')->count();
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
        return view('bachiller.curso_recuperativo.show-list');
    }

    /**
     * Show list.
     *
     */
    public function list()
    {
        $extraordinarios = Bachiller_extraordinarios::select(
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extAlumnosInscritos',
            'bachiller_extraordinarios.extPago','bachiller_extraordinarios.extFecha','bachiller_extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','bachiller_materias.matClave','bachiller_materias.matNombreOficial as matNombre',
            'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2','planes.planClave',
            'programas.progClave','ubicacion.ubiClave', 'empleadoAux.empApellido1', 'empleadoAux.empApellido2', 'empleadoAux.empNombre')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
            ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
            ->leftJoin('bachiller_empleados as empleadoAux', 'bachiller_extraordinarios.bachiller_empleado_sinodal_id', '=', 'empleadoAux.id');

            // ->leftjoin('optativas','bachiller_extraordinarios.optativa_id','optativas.id');

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

                $btnCalificaciones = "";
                $brnActa = "";
                $btnCalificaciones = '<a href="/bachiller_curso_recuperativo/agregarextra/'
                . $query->extraordinario_id
                . '" class="button button--icon js-button js-ripple-effect" title="Calificaciones">
                    <i class="material-icons">assignment_turned_in</i>
                </a>';

                $btnActa = '<form class="form-acta-examen'.$query->extraordinario_id.'" target="_blank" action="bachiller_curso_recuperativo/actaexamen/'.$query->extraordinario_id.'" method="POST" style="display: inline;">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <a href="#" data-id="'.$query->extraordinario_id.'" class="button button--icon js-button js-ripple-effect confirm-acta-examen" title="Acta de examen extraordinario">
                    <i class="material-icons">assignment</i>
                </a>
            </form>';
            
                return '<a href="bachiller_curso_recuperativo/' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                
                
                <a href="bachiller_curso_recuperativo/' . $query->extraordinario_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <form id="delete_' . $query->extraordinario_id . '" action="bachiller_curso_recuperativo/' . $query->extraordinario_id . '" method="POST" style="display: inline;">
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

        $extraordinario = Bachiller_extraordinarios::with(
            'bachiller_empleado', 'bachiller_empleadoSinodal', 'periodo',
            'bachiller_materia.plan.programa.escuela.departamento.ubicacion')
        ->findOrFail($extraordinario_id);

        $inscritos = Bachiller_resumenacademico::with('alumno.persona')
            ->where('plan_id',$extraordinario->bachiller_materia->plan->id)
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
            $extraordinario = Bachiller_extraordinarios::with(
                'bachiller_empleado', 'bachiller_empleadoSinodal', 'periodo',
                'bachiller_materia.plan.programa.escuela.departamento.ubicacion')
            ->find($extraordinario_id);

            return response()->json($extraordinario);
        }
    }

    public function validarAlumnoPresentaExtra(Request $request)
    {
        $alumno = Alumno::findOrFail($request->alumno);
        $puedePresentarExtra = true;
        $extraordinario = Bachiller_extraordinarios::with('bachiller_materia')
            ->where("id", "=", $request->folioExt)
        ->first();

        $materia = $extraordinario->bachiller_materia;
        // $plan = $materia->plan;
        $msg = null;
        $boolRevisarPagos = true;

        $materias_reprobadas = MetodosAlumnos::bachiller_materias_reprobadas($alumno->aluClave);
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

        $extras_alumno = Bachiller_inscritosextraordinarios::where('alumno_id', $alumno->id)->get();

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
        $inscritosextraordinarios = Bachiller_inscritosextraordinarios::select(
            'bachiller_inscritosextraordinarios.id as inscritoExtraordinario_id','bachiller_inscritosextraordinarios.iexFecha',
            'bachiller_inscritosextraordinarios.iexCalificacion','bachiller_inscritosextraordinarios.iexEstado',
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extFecha as extFecha','bachiller_materias.matClave','bachiller_materias.matNombreOficial as matNombre',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave',
            'alumnos.aluClave', 'periodos.perNumero','periodos.perAnio','programas.progClave','ubicacion.ubiClave')
            ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
            ->join('alumnos', 'bachiller_inscritosextraordinarios.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id');
            // ->leftjoin('optativas','extraordinarios.optativa_id','optativas.id');
            //->where('iexEstado', '<>', 'P');

        return Datatables::of($inscritosextraordinarios)
            ->filterColumn('nombreCompleto',function($query,$keyword) {
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })
            ->addColumn('action',function($query) {
                return '<a href="' . route('show.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="' . route('edit.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <a href="#" class="button button--icon js-button js-ripple-effect" title="Pagar">
                    <i class="material-icons">attach_money</i>
                </a>
                <a href="' . route('cancelar.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Cancelar">
                    <i class="material-icons">cancel</i>
                </a>
                <a href="' . route('recibo.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" target="_blank" title="ver recibo">
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
        return view('bachiller.curso_recuperativo.show-solicitudes-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        $empleados = Bachiller_empleados::activos()->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');
        return view('bachiller.curso_recuperativo.create', compact('ubicaciones', 'empleados', 'hoy'));
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
        $calendario = Bachiller_calendarioexamen::where("periodo_id", $request->periodo_id)
        ->latest('created_at')->first();
        if(!$calendario) {
            alert('Ups!', 'No se encontró calendario de exámenes para este periodo. Favor de verificar esta información.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $fechaInicio = $calendario->calexInicioExtraordinario ?: false;
        $fechaFin = $calendario->calexFinExtraordinario ?: false;
        if(!$fechaInicio || !$fechaFin) {
            alert('Ups!', 'No se encontraron fechas para periodo extraordinario en el calendario de este periodo. No se pueden hacer registros sin contar con estos datos. Favor de verificar.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $validator = Validator::make($request->all(),
            [
                'materia_id'  => 'required',
                'periodo_id'  => 'required',
                'empleado_id' => 'required',
                'extFecha'    => 'required|after_or_equal:'.$fechaInicio.'|before_or_equal:'.$fechaFin,
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

        try {
            $programa_id = $request->programa_id;
            if (Utils::validaPermiso('extraordinario', $programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect()->back();
            }

            Bachiller_extraordinarios::create([
                'periodo_id'            => $request->periodo_id,
                'bachiller_materia_id'            => $request->materia_id,
                'extFecha'              => $request->extFecha,
                'extHora'               => $request->extHora,
                'extLugar'              => NULL,
                'bachiller_empleado_id'           => $request->empleado_id,
                'bachiller_empleado_sinodal_id'   => $request->empleado_sinodal_id,                
                'extNumeroFolio'        => $request->extNumeroFolio,
                'extNumeroActa'         => $request->extNumeroActa,
                'extNumeroLibro'        => $request->extNumeroLibro,
                'extPago'               => Utils::validaEmpty($request->extPago),
                'extAlumnosInscritos'   => $request->extAlumnosInscritos,
                'extGrupo'              => $request->extGrupo,
                'extHoraInicioLunes'    => $request->extHoraInicioLunes,
                'extHoraFinLunes'       => $request->extHoraFinLunes,
                'extAulaLunes'          => $request->extAulaLunes,
                'extHoraInicioMartes'    => $request->extHoraInicioMartes,
                'extHoraFinMartes'       => $request->extHoraFinMartes,
                'extAulaMartes'          => $request->extAulaMartes,
                'extHoraInicioMiercoles'    => $request->extHoraInicioMiercoles,
                'extHoraFinMiercoles'       => $request->extHoraFinMiercoles,
                'extAulaMiercoles'          => $request->extAulaMiercoles,
                'extHoraInicioJueves'    => $request->extHoraInicioJueves,
                'extHoraFinJueves'       => $request->extHoraFinJueves,
                'extAulaJueves'          => $request->extAulaJueves,
                'extHoraInicioViernes'    => $request->extHoraInicioViernes,
                'extHoraFinViernes'       => $request->extHoraFinViernes,
                'extAulaViernes'          => $request->extAulaViernes,
                'extHoraInicioSabado'    => $request->extHoraInicioSabado,
                'extHoraFinSabado'       => $request->extHoraFinSabado,
                'extAulaSabado'          => $request->extAulaSabado,
                'extFechaSesion01'       => $request->extFechaSesion01,
                'extFechaSesion02'       => $request->extFechaSesion02,
                'extFechaSesion03'       => $request->extFechaSesion03,
                'extFechaSesion04'       => $request->extFechaSesion04,
                'extFechaSesion05'       => $request->extFechaSesion05,
                'extFechaSesion06'       => $request->extFechaSesion06,
                'extFechaSesion07'       => $request->extFechaSesion07,
                'extFechaSesion08'       => $request->extFechaSesion08,
                'extFechaSesion09'       => $request->extFechaSesion09,
                'extFechaSesion10'       => $request->extFechaSesion10,
                'extFechaSesion11'       => $request->extFechaSesion11,
                'extFechaSesion12'       => $request->extFechaSesion12,
                'extFechaSesion13'       => $request->extFechaSesion13,
                'extFechaSesion14'       => $request->extFechaSesion14,
                'extFechaSesion15'       => $request->extFechaSesion15,
                'extFechaSesion16'       => $request->extFechaSesion16,
                'extFechaSesion17'       => $request->extFechaSesion17,
                'extFechaSesion18'       => $request->extFechaSesion18,
                'extHoraInicioSesion01'  => $request->extHoraInicioSesion01,
                'extHoraInicioSesion02'  => $request->extHoraInicioSesion02,
                'extHoraInicioSesion03'  => $request->extHoraInicioSesion03,
                'extHoraInicioSesion04'  => $request->extHoraInicioSesion04,
                'extHoraInicioSesion05'  => $request->extHoraInicioSesion05,
                'extHoraInicioSesion06'  => $request->extHoraInicioSesion06,
                'extHoraInicioSesion07'  => $request->extHoraInicioSesion07,
                'extHoraInicioSesion08'  => $request->extHoraInicioSesion08,
                'extHoraInicioSesion09'  => $request->extHoraInicioSesion09,
                'extHoraInicioSesion10'  => $request->extHoraInicioSesion10,
                'extHoraInicioSesion11'  => $request->extHoraInicioSesion11,
                'extHoraInicioSesion12'  => $request->extHoraInicioSesion12,
                'extHoraInicioSesion13'  => $request->extHoraInicioSesion13,
                'extHoraInicioSesion14'  => $request->extHoraInicioSesion14,
                'extHoraInicioSesion15'  => $request->extHoraInicioSesion15,
                'extHoraInicioSesion16'  => $request->extHoraInicioSesion16,
                'extHoraInicioSesion17'  => $request->extHoraInicioSesion17,
                'extHoraInicioSesion18'  => $request->extHoraInicioSesion18,
                'extHoraFinSesion01'  => $request->extHoraFinSesion01,
                'extHoraFinSesion02'  => $request->extHoraFinSesion02,
                'extHoraFinSesion03'  => $request->extHoraFinSesion03,
                'extHoraFinSesion04'  => $request->extHoraFinSesion04,
                'extHoraFinSesion05'  => $request->extHoraFinSesion05,
                'extHoraFinSesion06'  => $request->extHoraFinSesion06,
                'extHoraFinSesion07'  => $request->extHoraFinSesion07,
                'extHoraFinSesion08'  => $request->extHoraFinSesion08,
                'extHoraFinSesion09'  => $request->extHoraFinSesion09,
                'extHoraFinSesion10'  => $request->extHoraFinSesion10,
                'extHoraFinSesion11'  => $request->extHoraFinSesion11,
                'extHoraFinSesion12'  => $request->extHoraFinSesion12,
                'extHoraFinSesion13'  => $request->extHoraFinSesion13,
                'extHoraFinSesion14'  => $request->extHoraFinSesion14,
                'extHoraFinSesion15'  => $request->extHoraFinSesion15,
                'extHoraFinSesion16'  => $request->extHoraFinSesion16,
                'extHoraFinSesion17'  => $request->extHoraFinSesion17,
                'extHoraFinSesion18'  => $request->extHoraFinSesion18               
                
            ]);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('bachiller_extraordinario/create')->withInput();
        }
        alert('Escuela Modelo', 'Se creo el extraordinario con éxito', 'success')->showConfirmButton();
        return redirect('bachiller_extraordinario');
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
        $calendario = Bachiller_calendarioexamen::where("periodo_id", $request->periodo_id)
        ->latest('created_at')->first();
        if(!$calendario) {
            alert('Ups!', 'No se encontró calendario de exámenes para este periodo. Favor de verificar esta información.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $fechaInicio = $calendario->calexInicioExtraordinario ?: false;
        $fechaFin = $calendario->calexFinExtraordinario ?: false;
        if(!$fechaInicio || !$fechaFin) {
            alert('Ups!', 'No se encontraron fechas para periodo extraordinario en el calendario de este periodo. No se pueden hacer registros sin contar con estos datos. Favor de verificar.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $validator = Validator::make($request->all(),
            [
                'materia_id' => 'required',
                'periodo_id' => 'required',
                'empleado_id' => 'required',
                'extFecha'    => 'required|after_or_equal:'.$fechaInicio.'|before_or_equal:'.$fechaFin,
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

        try {
            $extraordinario = Bachiller_extraordinarios::findOrFail($id);
            $extraordinario->periodo_id = $request->periodo_id;
            $extraordinario->bachiller_materia_id = $request->materia_id;
            $extraordinario->extFecha = $request->extFecha;
            $extraordinario->extHora = $request->extHora;
            $extraordinario->extLugar = NULL;
            $extraordinario->bachiller_empleado_id = $request->empleado_id;
            $extraordinario->bachiller_empleado_sinodal_id = $request->empleado_sinodal_id;
            $extraordinario->extNumeroFolio = $request->extNumeroFolio;
            $extraordinario->extNumeroActa = $request->extNumeroActa;
            $extraordinario->extNumeroLibro = $request->extNumeroLibro;
            $extraordinario->extPago = Utils::validaEmpty($request->extPago);
            $extraordinario->extAlumnosInscritos = $request->extAlumnosInscritos;
            $extraordinario->extGrupo = $request->extGrupo;
            $extraordinario->extHoraInicioLunes    = $request->extHoraInicioLunes;
            $extraordinario->extHoraFinLunes       = $request->extHoraFinLunes;
            $extraordinario->extAulaLunes          = $request->extAulaLunes;
            $extraordinario->extHoraInicioMartes    = $request->extHoraInicioMartes;
            $extraordinario->extHoraFinMartes       = $request->extHoraFinMartes;
            $extraordinario->extAulaMartes          = $request->extAulaMartes;
            $extraordinario->extHoraInicioMiercoles    = $request->extHoraInicioMiercoles;
            $extraordinario->extHoraFinMiercoles       = $request->extHoraFinMiercoles;
            $extraordinario->extAulaMiercoles          = $request->extAulaMiercoles;
            $extraordinario->extHoraInicioJueves    = $request->extHoraInicioJueves;
            $extraordinario->extHoraFinJueves       = $request->extHoraFinJueves;
            $extraordinario->extAulaJueves          = $request->extAulaJueves;
            $extraordinario->extHoraInicioViernes    = $request->extHoraInicioViernes;
            $extraordinario->extHoraFinViernes       = $request->extHoraFinViernes;
            $extraordinario->extAulaViernes          = $request->extAulaViernes;
            $extraordinario->extHoraInicioSabado    = $request->extHoraInicioSabado;
            $extraordinario->extHoraFinSabado       = $request->extHoraFinSabado;
            $extraordinario->extAulaSabado          = $request->extAulaSabado;
            $extraordinario->extFechaSesion01       = $request->extFechaSesion01;
            $extraordinario->extFechaSesion02       = $request->extFechaSesion02;
            $extraordinario->extFechaSesion03       = $request->extFechaSesion03;
            $extraordinario->extFechaSesion04       = $request->extFechaSesion04;
            $extraordinario->extFechaSesion05       = $request->extFechaSesion05;
            $extraordinario->extFechaSesion06       = $request->extFechaSesion06;
            $extraordinario->extFechaSesion07       = $request->extFechaSesion07;
            $extraordinario->extFechaSesion08       = $request->extFechaSesion08;
            $extraordinario->extFechaSesion09       = $request->extFechaSesion09;
            $extraordinario->extFechaSesion10       = $request->extFechaSesion10;
            $extraordinario->extFechaSesion11       = $request->extFechaSesion11;
            $extraordinario->extFechaSesion12       = $request->extFechaSesion12;
            $extraordinario->extFechaSesion13       = $request->extFechaSesion13;
            $extraordinario->extFechaSesion14       = $request->extFechaSesion14;
            $extraordinario->extFechaSesion15       = $request->extFechaSesion15;
            $extraordinario->extFechaSesion16       = $request->extFechaSesion16;
            $extraordinario->extFechaSesion17       = $request->extFechaSesion17;
            $extraordinario->extFechaSesion18       = $request->extFechaSesion18;
            $extraordinario->extHoraInicioSesion01  = $request->extHoraInicioSesion01;
            $extraordinario->extHoraInicioSesion02  = $request->extHoraInicioSesion02;
            $extraordinario->extHoraInicioSesion03  = $request->extHoraInicioSesion03;
            $extraordinario->extHoraInicioSesion04  = $request->extHoraInicioSesion04;
            $extraordinario->extHoraInicioSesion05  = $request->extHoraInicioSesion05;
            $extraordinario->extHoraInicioSesion06  = $request->extHoraInicioSesion06;
            $extraordinario->extHoraInicioSesion07  = $request->extHoraInicioSesion07;
            $extraordinario->extHoraInicioSesion08  = $request->extHoraInicioSesion08;
            $extraordinario->extHoraInicioSesion09  = $request->extHoraInicioSesion09;
            $extraordinario->extHoraInicioSesion10  = $request->extHoraInicioSesion10;
            $extraordinario->extHoraInicioSesion11  = $request->extHoraInicioSesion11;
            $extraordinario->extHoraInicioSesion12  = $request->extHoraInicioSesion12;
            $extraordinario->extHoraInicioSesion13  = $request->extHoraInicioSesion13;
            $extraordinario->extHoraInicioSesion14  = $request->extHoraInicioSesion14;
            $extraordinario->extHoraInicioSesion15  = $request->extHoraInicioSesion15;
            $extraordinario->extHoraInicioSesion16  = $request->extHoraInicioSesion16;
            $extraordinario->extHoraInicioSesion17  = $request->extHoraInicioSesion17;
            $extraordinario->extHoraInicioSesion18  = $request->extHoraInicioSesion18;
            $extraordinario->extHoraFinSesion01  = $request->extHoraFinSesion01;
            $extraordinario->extHoraFinSesion02  = $request->extHoraFinSesion02;
            $extraordinario->extHoraFinSesion03  = $request->extHoraFinSesion03;
            $extraordinario->extHoraFinSesion04  = $request->extHoraFinSesion04;
            $extraordinario->extHoraFinSesion05  = $request->extHoraFinSesion05;
            $extraordinario->extHoraFinSesion06  = $request->extHoraFinSesion06;
            $extraordinario->extHoraFinSesion07  = $request->extHoraFinSesion07;
            $extraordinario->extHoraFinSesion08  = $request->extHoraFinSesion08;
            $extraordinario->extHoraFinSesion09  = $request->extHoraFinSesion09;
            $extraordinario->extHoraFinSesion10  = $request->extHoraFinSesion10;
            $extraordinario->extHoraFinSesion11  = $request->extHoraFinSesion11;
            $extraordinario->extHoraFinSesion12  = $request->extHoraFinSesion12;
            $extraordinario->extHoraFinSesion13  = $request->extHoraFinSesion13;
            $extraordinario->extHoraFinSesion14  = $request->extHoraFinSesion14;
            $extraordinario->extHoraFinSesion15  = $request->extHoraFinSesion15;
            $extraordinario->extHoraFinSesion16  = $request->extHoraFinSesion16;
            $extraordinario->extHoraFinSesion17  = $request->extHoraFinSesion17;
            $extraordinario->extHoraFinSesion18  = $request->extHoraFinSesion18;
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
        $extraordinario = Bachiller_extraordinarios::find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe extraordinario solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        if($extraordinario->bachiller_inscritos()->count() + $extraordinario->bachiller_preinscritos()->count() > 0) {
            alert("No se puede borrar el Extraordinario #{$extraordinario->id}", 'Actualmente hay alumnos inscritos a este extraordinario o en proceso de solicitud. Ya se ha generado una ficha pendiente por pagar. Favor de dirigirse a la opción PREINSCRITOS EXTRAORDINARIOS y revisar quienes son los alumnos que desean inscribirse a este examen. Es importante que se comunique con ellos para validar que no hayan pagado la inscripción a este examen que desea eliminar', 'warning')->showConfirmButton();
            return redirect()->back();
        }

        try {
            if (Utils::validaPermiso('extraordinario', $extraordinario->bachiller_materia->plan->programa_id)) {

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
        $extraordinario = Bachiller_extraordinarios::with('bachiller_empleado','bachiller_empleadoSinodal', 'periodo', 'bachiller_materia')->find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe extraordinario solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        return view('bachiller.curso_recuperativo.show', compact('extraordinario'));
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
       $extraordinario = Bachiller_extraordinarios::with('bachiller_empleado', 'bachiller_empleadoSinodal', 'periodo', 'bachiller_materia')->find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe extraordinario solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        if($extraordinario->bachiller_inscritos()->count() + $extraordinario->bachiller_preinscritos()->count() > 0) {
            alert("No se puede editar el Extraordinario #{$extraordinario->id}", 'Actualmente hay alumnos inscritos a este extraordinario o en proceso de solicitud. Ya se ha generado una ficha pendiente por pagar. Favor de dirigirse a la opción PREINSCRITOS EXTRAORDINARIOS y revisar quienes son los alumnos que desean inscribirse a este examen. Es importante que se comunique con ellos para validar que no hayan pagado la inscripción a este examen que desea modificar', 'warning')->showConfirmButton();
            return redirect()->back();
        }


        $empleados = Bachiller_empleados::activos()->get();
        // $aulas = Aula::where('ubicacion_id', $extraordinario->materia->plan->programa->escuela->departamento->ubicacion->id)->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');

        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('extraordinario', $extraordinario->bachiller_materia->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        return view('bachiller.curso_recuperativo.edit', compact('extraordinario', 'empleados', 'hoy'));
    }



    //SOLICITUDES EXTRAORDINARIO



        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudCreate()
    {
        return view('bachiller.curso_recuperativo.create-solicitud');
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
        $extraordinario = Bachiller_extraordinarios::find($request->extraordinario_id);
        $fechaOcupada = Bachiller_inscritosextraordinarios::where('alumno_id', $request->alumno_id)
        ->whereDate('iexFecha', '=', $extraordinario->extFecha)->get();
        if($fechaOcupada->isNotEmpty()) {
            alert()->warning('No se puede procesar la Solicitud', 'El alumno ya tiene un examen para esa misma fecha.')->showConfirmButton();
            return back()->withInput();
        }

        try {

            $inscritoExt = New Bachiller_inscritosextraordinarios;
            $inscritoExt->alumno_id = $request->alumno_id;
            $inscritoExt->extraordinario_id = $request->extraordinario_id;
            $inscritoExt->iexFecha = $request->iexFecha;
            $inscritoExt->iexCalificacion = NULL;
            $inscritoExt->iexEstado = $request->iexEstado;
            $inscritoExt->iexFolioHistorico = NULL;
            $inscritoExt->save();

            $extra = $inscritoExt->bachiller_extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            $extPago = $inscritoExt->bachiller_extraordinario->extPago;
            $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);

            if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
                //Yucatán
                $inscrito = Bachiller_inscritos::with('curso','bachiller_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
                })
                ->first();

                // aun no hay tabla pendiente
                if($inscrito){
                    $calificaciones = Bachiller_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }else{
                    $aceptadaSinOrdinario = true;
                }

                $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                    ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                    ->where('histTipoAcreditacion','X2')->get();
                if(count($historicosX2) > 0){
                    $ultOportunidad = true;
                }

            }else{
                //Chetumal
                $inscrito = Bachiller_cch_inscritos::with('curso','bachiller_cch_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_cch_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
                })
                ->first();
            if($inscrito){
                $calificaciones = Bachiller_cch_inscritos::where('id',$inscrito->id)
                    ->first();
                if(!$calificaciones->insCalificacionOrdinario){
                    $aceptadaSinOrdinario = true;
                }
            }else{
                $aceptadaSinOrdinario = true;
            }

            $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                ->where('histTipoAcreditacion','X2')->get();
            if(count($historicosX2) > 0){
                $ultOportunidad = true;
            }

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
            $pdf = PDF::loadView("bachiller.curso_recuperativo.pdf.pdf_recibo_extraordinario",[
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
        $solicitud = Bachiller_inscritosextraordinarios::with('bachiller_extraordinario')->findOrFail($id);
        $iexEstado = ESTADO_SOLICITUD;
        return view('bachiller.curso_recuperativo.show-solicitud', compact('solicitud', 'iexEstado'));
    }


    /**
     * Show the form for edit a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudEdit($id)
    {
        $solicitud = Bachiller_inscritosextraordinarios::with('bachiller_extraordinario')->findOrFail($id);
        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('solicitud_extraordinario', $solicitud->bachiller_extraordinario->bachiller_materia->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('solicitudes/bachiller_extraordinario');
        } else {
            $iexEstado = ESTADO_SOLICITUD;
            return view('bachiller.curso_recuperativo.edit-solicitud', compact('solicitud', 'iexEstado'));
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
            $inscritoExtraordinario = Bachiller_inscritosextraordinarios::findOrFail($id);
            $inscritoExtraordinario->iexCalificacion    = $request->input('iexCalificacion');
            $inscritoExtraordinario->iexEstado          = $request->input('iexEstado');
            $inscritoExtraordinario->save();

            $extra = $inscritoExtraordinario->bachiller_extraordinario;
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

            return redirect('solicitudes/bachiller_extraordinario');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('edit/bachiller_solicitud/' . $id)->withInput();
        }
    }


    public function solicitudCancelar(Request $request)
    {
        try {
            $inscritoExtraordinario = Bachiller_inscritosextraordinarios::findOrFail($request->id);
            $inscritoExtraordinario->iexEstado = "C";
            $inscritoExtraordinario->save();

            $extra = $inscritoExtraordinario->bachiller_extraordinario;
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

            return redirect('solicitudes/bachiller_extraordinario');
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
            $inscritoExt = Bachiller_inscritosextraordinarios::findOrFail($request->id);

            $extPago = $inscritoExt->bachiller_extraordinario->extPago;
            $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);

            if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
                $inscrito = Bachiller_inscritos::with('curso','bachiller_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->bachiller_materia_id);
                })
                ->first();
                // Pendiente 
                if($inscrito){
                    $calificaciones = Bachiller_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }
            }else{
                // Chetumal 
                $inscrito = Bachiller_cch_inscritos::with('curso','bachiller_cch_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_cch_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->bachiller_materia_id);
                })
                ->first();
                if($inscrito){
                    $calificaciones = Bachiller_cch_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }
            }
            

            $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->bachiller_materia_id)
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
            $pdf = PDF::loadView("bachiller.curso_recuperativo.pdf.pdf_recibo_extraordinario",[
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

        $extraordinario = Bachiller_extraordinarios::find($id);
        $inscritos = Bachiller_inscritosextraordinarios::where('extraordinario_id',$extraordinario->id)
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
            $inscrito = Bachiller_inscritosextraordinarios::where('id', '=', $inscrito_id)->first();
            $idExtra = $inscrito->bachiller_extraordinario->id;
            //Datos del alumno
            $aluClave = $inscrito->alumno->aluClave;
            $perApellido1 = $inscrito->alumno->persona->perApellido1;
            $perApellido2 = $inscrito->alumno->persona->perApellido2;
            $perNombre = $inscrito->alumno->persona->perNombre;
            $alumnoNombre = $perApellido1.' '.$perApellido2.' '.$perNombre;
            //Datos del empleado (maestro)
             $perApellido1Emp = $inscrito->bachiller_extraordinario->bachiller_empleado->empApellido1;
            $perApellido2Emp = $inscrito->bachiller_extraordinario->bachiller_empleado->empApellido2;
            $perNombreEmp = $inscrito->bachiller_extraordinario->bachiller_empleado->empNombre;
            $empleadoNombre = $perNombreEmp.' '.$perApellido1Emp.' '.$perApellido2Emp;
            $empleadoId = $inscrito->bachiller_extraordinario->empleado_id;
            //Datos de la secretaria administrativa
            $depTituloDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depTituloDoc;
            $depNombreDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depNombreDoc;
            $depPuestoDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depPuestoDoc;
      
            $iexCalificacion = $inscrito->iexCalificacion;
            $planClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->planClave;
            $progClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->progClave;
            $progNombre = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->progNombre;
            $ubiClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiClave;
            $ubiNombre = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiNombre;
            $matClave = $inscrito->bachiller_extraordinario->bachiller_materia->matClave;
            $matNombre = $inscrito->bachiller_extraordinario->bachiller_materia->matNombre;
            $extClave = $inscrito->bachiller_extraordinario->id;
            $extFecha = $inscrito->bachiller_extraordinario->extFecha;
            $extHora = $inscrito->bachiller_extraordinario->extHora;
            $extGrupo = $inscrito->bachiller_extraordinario->extGrupo;
            $califLetras = $iexCalificacion === null ? '' : str_replace(" CON 00/100","",NumeroALetras::convert($iexCalificacion));

            if($inscrito->bachiller_extraordinario->bachiller_materia->esAlfabetica()) {
              $califLetras = $iexCalificacion == 0 ? 'APROBADO' : 'NO APROBADO';
              $iexCalificacion = $iexCalificacion == 0 ? 'A' : 'NA';
            }

            // $optativa = Optativa::where('id',$inscrito->bachiller_extraordinario->optativa_id)->first();
      
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
            //   'optativa'=>$optativa,
              'ubiNombre'=>$ubiNombre
            ]);
          
          }
          
          $inscritoEx = $inscritoEx->sortBy('perApellido1');
          $inscritoEx = $inscritoEx->groupBy('idExtra');
          
          setlocale(LC_TIME, 'es_ES.UTF-8');
          // En windows
          setlocale(LC_TIME, 'spanish');
          $nombreArchivo = 'pdf_acta_extraordinario';
          $pdf = PDF::loadView('reportes.pdf.bachiller.'. $nombreArchivo, [
            
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

        $extras = Bachiller_inscritosextraordinarios::select(
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extAlumnosInscritos',
            'bachiller_extraordinarios.extPago','bachiller_inscritosextraordinarios.iexFecha','bachiller_extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','bachiller_materias.matClave','bachiller_materias.matNombreOficial as matNombre',
            'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2','planes.planClave',
            'programas.progNombre','ubicacion.ubiNombre','bachiller_inscritosextraordinarios.iexCalificacion')
            ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
            ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
            // ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            // ->leftjoin('optativas','bachiller_extraordinarios.optativa_id','optativas.id')
            // ->where('periodo.id',$departamento->perActual)
            ->where('bachiller_inscritosextraordinarios.iexCalificacion','<',$departamento->depCalMinAprob)
            ->whereBetween('bachiller_inscritosextraordinarios.iexFecha',[$periodo->perFechaInicial,$periodo->perFechaFinal])
            ->where('bachiller_inscritosextraordinarios.alumno_id',$alumno->id);


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

    public function agregarExtra($extraordinario_id)
    {
        //OBTENER Extraordinario e inscritos
        $extraordinario  = Bachiller_extraordinarios::with('bachiller_materia.plan.programa','periodo','bachiller_empleado')->find($extraordinario_id);
        $inscritoextra  = Bachiller_inscritosextraordinarios::with('alumno.persona')->where('extraordinario_id',$extraordinario_id)->where('iexEstado','!=','C')->get();
    
        $inscritos = $inscritoextra->map(function ($item, $key) {
            $item->sortByNombres = $item->alumno->persona->perApellido1 . "-" . 
            $item->alumno->persona->perApellido2  . "-" . 
            $item->alumno->persona->perNombre;
            $item->iexEstado;

            return $item;
        })->sortBy("sortByNombres");

        $motivosFalta = DB::table("motivosfalta")->get()->sortByDesc("id");



        return view('bachiller.calificaciones_chetumal.curso_recuperativo.create',compact('extraordinario','inscritos', 'motivosFalta'));

    }

    public function extraStore(Request $request)
    {
        $extraordinario_id = $request->extraordinario_id;
        //OBTENER Inscritos Extraordinarios
        $extraordinario  = Bachiller_extraordinarios::with('bachiller_materia.plan.programa','periodo','bachiller_empleado')->find($extraordinario_id);
        $inscritoextra  = Bachiller_inscritosextraordinarios::with('alumno.persona')->where('extraordinario_id',$extraordinario_id)->where('iexEstado','!=','C')->get();


        try {

            $calificacion = $request->calificacion;

            $inscEx  = $request->has("calificacion.inscEx")  ? collect($calificacion["inscEx"])  : collect();
            $asistencia = $request->has("calificacion.asistencia")  ? collect($calificacion["asistencia"])  : collect();
            
            foreach ($inscritoextra as $inscrito) {
                $inscritoEx  = Bachiller_inscritosextraordinarios::find($inscrito->id);
                $calificacionEx = $inscEx->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();

                $miAsistencia = $asistencia->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();


                     
                if ($miAsistencia != 10) {
                    $calificacionEx = 0;
                }
               
                if ($inscritoEx) {
                    $inscritoEx->iexCalificacion  = !is_null($calificacionEx) ? $calificacionEx  : $inscritoEx->iexCalificacion;
                    $inscritoEx->motivofalta_id = $miAsistencia;
                    $inscritoEx->save(); 
                }
            }

            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton();
            return redirect('agregarextra/bachiller_curso_recuperativo_seq/' . $extraordinario_id)->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('agregarextra/bachiller_curso_recuperativo_seq/' . $extraordinario_id)->withInput();
        }
    }
}

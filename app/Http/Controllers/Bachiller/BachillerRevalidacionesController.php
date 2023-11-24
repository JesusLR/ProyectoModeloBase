<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Alumno;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class BachillerRevalidacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.revalidaciones.show-list');
    }

    public function list()
    {
        $bachiller_historico = Bachiller_historico::select(
            'bachiller_historico.id',
            'bachiller_historico.alumno_id',
            'bachiller_historico.plan_id',
            'bachiller_historico.bachiller_materia_id',
            'bachiller_historico.periodo_id',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histFolio',
            'bachiller_historico.hisActa',
            'bachiller_historico.histLibro',
            'bachiller_historico.histNombreOficial',
            'planes.planClave',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matSemestre',
            'periodoFicticio.id as periodo_id_ficticio',
            'periodoFicticio.perNumero as perNumeroFicticio',
            'periodoFicticio.perAnio as perAnioFicticio'
        )
            ->leftJoin('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->leftJoin('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->leftJoin('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->leftJoin('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('periodos as periodoFicticio', 'bachiller_historico.periodo_id_ficticio', '=', 'periodoFicticio.id')
            // ->where('periodos.perAnio', '>=', 2020)
            ->whereIn('bachiller_historico.histPeriodoAcreditacion', ['RV', 'RC'])
            ->orderBy('bachiller_historico.id', 'DESC');



        return DataTables::of($bachiller_historico)
            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })

            ->filterColumn('periodoAnio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoAnio', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('periodoNumero', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoNumero', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('plan', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('plan', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('clave_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_materia', function ($query) {
                return $query->matClave;
            })

            ->filterColumn('nombre_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_materia', function ($query) {
                return $query->matNombre;
            })


            ->filterColumn('fecha_examen', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histFechaExamen) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('fecha_examen', function ($query) {

                if($query->histFechaExamen != "0000-00-00"){
                    return Utils::fecha_string($query->histFechaExamen, $query->histFechaExamen);
                }else{
                    return "";
                }
            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {

                return $query->aluClave;
            })

            ->filterColumn('perApellido_pat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('perApellido_pat', function ($query) {
                return $query->perApellido1;
            })


            ->filterColumn('perApellido_mat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('perApellido_mat', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('nombre_al', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_al', function ($query) {

                return $query->perNombre;
            })

            ->filterColumn('periodo_acred', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histPeriodoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_acred', function ($query) {
                return $query->histPeriodoAcreditacion;
            })

            ->filterColumn('tipo_acred', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histTipoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('tipo_acred', function ($query) {
                return $query->histTipoAcreditacion;
            })

            ->filterColumn('califi', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histCalificacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('califi', function ($query) {
                return $query->histCalificacion;
            })

            ->filterColumn('semestre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matSemestre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('semestre', function ($query) {
                return $query->matSemestre;
            })


            ->filterColumn('anioFicticio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioFicticio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('anioFicticio', function ($query) {
                return $query->perAnioFicticio;
            })

            ->filterColumn('numeroFicticio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumeroFicticio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('numeroFicticio', function ($query) {
                return $query->perNumeroFicticio;
            })

            ->addColumn('action', function ($query) {


                $btnEditar = "";
                $btnEliminar = "";

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                $sistemas = Auth::user()->departamento_sistemas;
                $control = Auth::user()->departamento_control_escolar;


                // $ubicacion == $query->ubiClave
                if($sistemas == 1){
                    $btnEditar = '<a href="/bachiller_revalidaciones/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                    $btnEliminar = '<form id="delete_' . $query->id . '" action="bachiller_revalidaciones/' . $query->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }

                if($control == 1){
                    $btnEditar = '<a href="/bachiller_revalidaciones/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                }

                return '<a href="/bachiller_revalidaciones/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                .$btnEditar
                .$btnEliminar;
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        return view('bachiller.revalidaciones.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function buscaNombreAlumno(Request $request, $aluClave)
    {
        if ($request->ajax()) {

            $alumno = DB::select("SELECT personas.perApellido1, personas.perApellido2, personas.perNombre
            FROM alumnos as alum
            INNER JOIN personas as personas on personas.id = alum.persona_id
            WHERE alum.aluClave = $aluClave
            AND alum.aluEstado != 'B'");


            return response()->json($alumno);
        }
    }

    // public function buscaNombreAlumno(Request $request, $periodo_id, $plan_id, $aluClave)
    // {
    //     if ($request->ajax()) {

    //         $alumno = DB::select("SELECT personas.perApellido1, personas.perApellido2, personas.perNombre
    //         FROM cursos as cursos
    //         INNER JOIN alumnos as alum on alum.id = cursos.alumno_id
    //         INNER JOIN personas as personas on personas.id = alum.persona_id
    //         INNER JOIN cgt as cgt on cgt.id = cursos.cgt_id
    //         WHERE cursos.periodo_id = $periodo_id
    //         AND cursos.curEstado = 'R'
    //         AND cgt.plan_id = $plan_id
    //         AND alum.aluClave = $aluClave");


    //         return response()->json($alumno);
    //     }
    // }

    public function buscaMaterias(Request $request, $que_semestres_cursos_buscar, $plan_id)
    {
        if ($request->ajax()) {


            // Buscar materias de solo primer curso
            if ($que_semestres_cursos_buscar == "A") {
                $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                    ->whereIn('matSemestre', [1, 2])
                    ->where('matVigentePlanPeriodoActual', '=', 'SI')
                    ->orderBy('matSemestre', 'ASC')
                    ->get();
            }

            // primer y segundo curso 
            if ($que_semestres_cursos_buscar == "B") {
                $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                    ->whereIn('matSemestre', [1, 2, 3, 4])
                    ->where('matVigentePlanPeriodoActual', '=', 'SI')
                    ->orderBy('matSemestre', 'ASC')
                    ->get();
            }


            // segundo curso 
            if ($que_semestres_cursos_buscar == "C") {
                $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                    ->whereIn('matSemestre', [3, 4])
                    ->where('matVigentePlanPeriodoActual', '=', 'SI')
                    ->orderBy('matSemestre', 'ASC')
                    ->get();
            }


            return response()->json($bachiller_materias);
        }
    }

    public function show($id)
    {

        if(Auth::user()->campus_cme == 1){
            $departameto_id = 7;
        }

        if(Auth::user()->campus_cva == 1){
            $departameto_id = 17;
        }

        $periodos = DB::select("SELECT p.* FROM periodos as p
        INNER JOIN departamentos d ON d.id = p.departamento_id
        WHERE p.deleted_at IS NULL
        AND p.perAnio NOT IN (9018, 9017, 9016, 9015, 9014, 9013, 9012, 9011, 9010, 9009)
        AND d.id = $departameto_id
        ORDER BY p.perAnio DESC, p.perNumero DESC");

        $historico = Bachiller_historico::select(
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'planes.planClave',
            'planes.id as plan_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histNombreOficial',
            'bachiller_historico.id'
        )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('bachiller_historico.id', $id)
            ->first();


        return view('bachiller.revalidaciones.show', compact('historico', 'periodos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'  => 'required',
                'departamento_id'  => 'required',
                'plan_id'  => 'required',
                'tipoOficio'  => 'required',
                'fechaOficio'  => 'required',
                'opcion'  => 'required',
                'aluClave'  => 'required'
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'departamento_id.required' => 'El campo Departamento es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'tipoOficio.required' => 'El campo Tipo Oficio es obligatorio.',
                'opcion.required' => 'El campo Opción es obligatorio.',
                'aluClave.required' => 'El campo Clave Pago es obligatorio.',
                'fechaOficio.required' => 'El campo Fecha Oficio es obligatorio.',

            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_revalidaciones/create')->withErrors($validator)->withInput();
        } else {
            try {

                $periodo_id = $request->periodo_id;
                $departamento_id = $request->departamento_id;
                $departamento = Departamento::find($departamento_id);
                $depClave = $departamento->depClave;
                $plan_id = $request->plan_id;
                $plan = Plan::find($plan_id);
                $planClave = $plan->planClave;
                $tipoOficio = $request->tipoOficio;
                $opcion = $request->opcion;
                $aluClave = $request->aluClave;
                $numeroMateriasRev = $request->numeroMateriasRev;
                $fechaOficio = $request->fechaOficio;
                // Buscar alumno 
                $alumno = Alumno::where('aluClave', '=', $aluClave)->first();
                $alumno_id = $alumno->id;


                //buscamos el periodo enviado 
                $periodo = Periodo::find($periodo_id);
                
                

                $fechaActual = Carbon::now('America/Merida');
                setlocale(LC_TIME, 'es_ES.UTF-8');

                if ($tipoOficio == "RV") {

                    // Buscar materias de solo primer curso
                    if ($opcion == "A") {

                        $anioPeriodoAnteriorSegundo1 = $periodo->perAnio - 1;
                        $anioPeriodoAnteriorPrimero1 = $periodo->perAnio - 2;

                        $periodoSegundoSemestre1 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnteriorSegundo1)
                        ->where('perNumero', 1)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();
 

                        $periodoPrimerSemestre1 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnteriorPrimero1)
                        ->where('perNumero', 3)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $cgtPeriodoSegundo = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoSegundoSemestre1->id)
                        ->where('cgt.cgtGradoSemestre', 2)
                        ->first();
                        $cgtPeriodoPrimero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoPrimerSemestre1->id)
                        ->where('cgt.cgtGradoSemestre', 1)
                        ->first();

                        $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                            ->whereIn('matSemestre', [1, 2])
                            ->where('matVigentePlanPeriodoActual', '=', 'SI')
                            ->orderBy('matSemestre', 'ASC')
                            ->get();

                        foreach ($bachiller_materias as $value) {

                            $bachiller_historico = Bachiller_historico::where('alumno_id', $alumno_id)
                                ->where('plan_id', $plan_id)
                                ->where('bachiller_materia_id', $value->id)
                                ->where('periodo_id', $periodo_id)
                                ->first();


                            if ($bachiller_historico == "") {

                                $materia = Bachiller_materias::find($value->id);
                                $periodo_id_ficticio = 0;
                                if($materia->matSemestre == 1){
                                    $periodo_id_ficticio = $cgtPeriodoPrimero->periodo_id;
                                }

                                if($materia->matSemestre == 2){
                                    $periodo_id_ficticio = $cgtPeriodoSegundo->periodo_id;
                                }

                                $bachiller_historico = Bachiller_historico::create([
                                    'alumno_id' => $alumno_id,
                                    'plan_id' => $plan_id,
                                    'bachiller_materia_id' => $value->id,
                                    'periodo_id' => $periodo_id,
                                    'periodo_id_ficticio' => $periodo_id_ficticio,
                                    'histComplementoNombre' => NULL,
                                    'histPeriodoAcreditacion' => 'RV',
                                    'histTipoAcreditacion' => 'RV',
                                    'histFechaExamen' => $fechaOficio,
                                    'histCalificacion' => NULL,
                                    'histFolio' => NULL,
                                    'hisActa' => NULL,
                                    'histLibro' => NULL,
                                    'histNombreOficial' => NULL
                                ]);

                                $periodo_id_ficticio = 0;

                            }
                        }
                    }

                    // die();
                    // primer y segundo curso 
                    if ($opcion == "B") {

                        $anioPeriodoAnterior1 = $periodo->perAnio - 1;
                        $anioPeriodoAnterior2 = $periodo->perAnio - 2;
                        $anioPeriodoAnterior3 = $periodo->perAnio - 3;


                        $periodoCuartoSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnterior1)
                        ->where('perNumero', 1)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $periodoTerceroSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnterior2)
                        ->where('perNumero', 3)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $periodoSegundoSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnterior2)
                        ->where('perNumero', 1)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $periodoPrimeroSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnterior3)
                        ->where('perNumero', 3)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $cgtPeriodoPrimero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoPrimeroSemestre1_2->id)
                        ->where('cgt.cgtGradoSemestre', 1)
                        ->first();

                        // return $periodoSegundoSemestre1_2->id;
                        $cgtPeriodoSegundo = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoSegundoSemestre1_2->id)
                        ->where('cgt.cgtGradoSemestre', 2)
                        ->first();

                        $cgtPeriodoTercero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoTerceroSemestre1_2->id)
                        ->where('cgt.cgtGradoSemestre', 3)
                        ->first();

                        $cgtPeriodoCuarto = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoCuartoSemestre1_2->id)
                        ->where('cgt.cgtGradoSemestre', 4)
                        ->first();

                        $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                            ->whereIn('matSemestre', [1, 2, 3, 4])
                            ->where('matVigentePlanPeriodoActual', '=', 'SI')
                            ->orderBy('matSemestre', 'ASC')
                            ->get();

                        foreach ($bachiller_materias as $value) {

                            $bachiller_historico = Bachiller_historico::where('alumno_id', $alumno_id)
                                ->where('plan_id', $plan_id)
                                ->where('bachiller_materia_id', $value->id)
                                ->where('periodo_id', $periodo_id)
                                ->first();

                            // print_r($bachiller_historico."<br>");

                            if ($bachiller_historico == "") {

                                $materia = Bachiller_materias::find($value->id);
                                $periodo_id_ficticio = 0;
                                if($materia->matSemestre == 1){
                                    $periodo_id_ficticio = $cgtPeriodoPrimero->periodo_id;
                                }

                                if($materia->matSemestre == 2){
                                    $periodo_id_ficticio = $cgtPeriodoSegundo->periodo_id;
                                }
                                if($materia->matSemestre == 3){
                                    $periodo_id_ficticio = $cgtPeriodoTercero->periodo_id;
                                }
                                if($materia->matSemestre == 4){
                                    $periodo_id_ficticio = $cgtPeriodoCuarto->periodo_id;
                                }
                                
                                $bachiller_historico = Bachiller_historico::create([
                                    'alumno_id' => $alumno_id,
                                    'plan_id' => $plan_id,
                                    'bachiller_materia_id' => $value->id,
                                    'periodo_id' => $periodo_id,
                                    'periodo_id_ficticio' => $periodo_id_ficticio,
                                    'histComplementoNombre' => NULL,
                                    'histPeriodoAcreditacion' => 'RV',
                                    'histTipoAcreditacion' => 'RV',
                                    'histFechaExamen' => $fechaOficio,
                                    'histCalificacion' => NULL,
                                    'histFolio' => NULL,
                                    'hisActa' => NULL,
                                    'histLibro' => NULL,
                                    'histNombreOficial' => NULL
                                ]);
                            }
                        }
                    }


                    // segundo curso 
                    if ($opcion == "C") {

                        $anioPeriodoAnteriorCuarto2 = $periodo->perAnio - 1;
                        $anioPeriodoAnteriorTercero2 = $periodo->perAnio - 2;

                        $periodoCuartoSemestre2 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnteriorCuarto2)
                        ->where('perNumero', 1)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $periodoTerceroSemestre2 = $periodo::select('periodos.*', 'departamentos.depClave')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('perAnio', $anioPeriodoAnteriorTercero2)
                        ->where('perNumero', 3)
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->first();

                        $cgtPeriodoCuarto = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoCuartoSemestre2->id)
                        ->where('cgt.cgtGradoSemestre', 4)
                        ->first();
                        $cgtPeriodoTercero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                        ->where('departamentos.depClave', 'BAC')
                        ->where('ubicacion.id', $request->ubicacion_id)
                        ->where('periodos.id', $periodoTerceroSemestre2->id)
                        ->where('cgt.cgtGradoSemestre', 3)
                        ->first();

                        $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                            ->whereIn('matSemestre', [3, 4])
                            ->where('matVigentePlanPeriodoActual', '=', 'SI')
                            ->orderBy('matSemestre', 'ASC')
                            ->get();

                        foreach ($bachiller_materias as $value) {

                            $bachiller_historico = Bachiller_historico::where('alumno_id', $alumno_id)
                                ->where('plan_id', $plan_id)
                                ->where('bachiller_materia_id', $value->id)
                                ->where('periodo_id', $periodo_id)
                                ->first();

                            // print_r($bachiller_historico."<br>");

                            if ($bachiller_historico == "") {

                                $materia = Bachiller_materias::find($value->id);
                                $periodo_id_ficticio = 0;
                                if($materia->matSemestre == 3){
                                    $periodo_id_ficticio = $cgtPeriodoTercero->periodo_id;
                                }

                                if($materia->matSemestre == 4){
                                    $periodo_id_ficticio = $cgtPeriodoCuarto->periodo_id;
                                }
                                
                

                                $bachiller_historico = Bachiller_historico::create([
                                    'alumno_id' => $alumno_id,
                                    'plan_id' => $plan_id,
                                    'bachiller_materia_id' => $value->id,
                                    'periodo_id' => $periodo_id,
                                    'periodo_id_ficticio' => $periodo_id_ficticio,
                                    'histComplementoNombre' => NULL,
                                    'histPeriodoAcreditacion' => 'RV',
                                    'histTipoAcreditacion' => 'RV',
                                    'histFechaExamen' => $fechaOficio,
                                    'histCalificacion' => NULL,
                                    'histFolio' => NULL,
                                    'hisActa' => NULL,
                                    'histLibro' => NULL,
                                    'histNombreOficial' => NULL
                                ]);
                            }
                        }
                    }
                } else {
                    if ($tipoOficio == "RC") {
                        // Buscar materias de solo primer curso
                        if ($opcion == "A") {

                            $anioPeriodoAnteriorSegundo1 = $periodo->perAnio - 1;
                            $anioPeriodoAnteriorPrimero1 = $periodo->perAnio - 2;

                            $periodoSegundoSemestre1 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnteriorSegundo1)
                            ->where('perNumero', 1)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();
    

                            $periodoPrimerSemestre1 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnteriorPrimero1)
                            ->where('perNumero', 3)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $cgtPeriodoSegundo = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoSegundoSemestre1->id)
                            ->where('cgt.cgtGradoSemestre', 2)
                            ->first();
                            $cgtPeriodoPrimero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoPrimerSemestre1->id)
                            ->where('cgt.cgtGradoSemestre', 1)
                            ->first();

                            $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                                ->whereIn('matSemestre', [1, 2])
                                ->where('matVigentePlanPeriodoActual', '=', 'SI')
                                ->orderBy('matSemestre', 'ASC')
                                ->get();

                            foreach ($bachiller_materias as $value) {

                                $bachiller_historico = Bachiller_historico::where('alumno_id', $alumno_id)
                                    ->where('plan_id', $plan_id)
                                    ->where('bachiller_materia_id', $value->id)
                                    ->where('periodo_id', $periodo_id)
                                    ->get();

                                // print_r($bachiller_historico."<br>");

                                if ($bachiller_historico->isEmpty()) {

                                    $materia = Bachiller_materias::find($value->id);
                                    $periodo_id_ficticio = 0;
                                    if($materia->matSemestre == 1){
                                        $periodo_id_ficticio = $cgtPeriodoPrimero->periodo_id;
                                    }

                                    if($materia->matSemestre == 2){
                                        $periodo_id_ficticio = $cgtPeriodoSegundo->periodo_id;
                                    }

                                    $bachiller_historico = Bachiller_historico::create([
                                        'alumno_id' => $alumno_id,
                                        'plan_id' => $plan_id,
                                        'bachiller_materia_id' => $value->id,
                                        'periodo_id' => $periodo_id,
                                        'periodo_id_ficticio' => $periodo_id_ficticio,
                                        'histComplementoNombre' => NULL,
                                        'histPeriodoAcreditacion' => 'RC',
                                        'histTipoAcreditacion' => 'RC',
                                        'histFechaExamen' => $fechaOficio,
                                        'histCalificacion' => NULL,
                                        'histFolio' => NULL,
                                        'hisActa' => NULL,
                                        'histLibro' => NULL,
                                        'histNombreOficial' => NULL
                                    ]);
                                }
                            }
                        }

                        // die();
                        // primer y segundo curso 
                        if ($opcion == "B") {

                            $anioPeriodoAnterior1 = $periodo->perAnio - 1;
                            $anioPeriodoAnterior2 = $periodo->perAnio - 2;
                            $anioPeriodoAnterior3 = $periodo->perAnio - 3;


                            $periodoCuartoSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnterior1)
                            ->where('perNumero', 1)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $periodoTerceroSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnterior2)
                            ->where('perNumero', 3)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $periodoSegundoSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnterior2)
                            ->where('perNumero', 1)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $periodoPrimeroSemestre1_2 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnterior3)
                            ->where('perNumero', 3)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $cgtPeriodoPrimero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoPrimeroSemestre1_2->id)
                            ->where('cgt.cgtGradoSemestre', 1)
                            ->first();

                            // return $periodoSegundoSemestre1_2->id;
                            $cgtPeriodoSegundo = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoSegundoSemestre1_2->id)
                            ->where('cgt.cgtGradoSemestre', 2)
                            ->first();

                            $cgtPeriodoTercero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoTerceroSemestre1_2->id)
                            ->where('cgt.cgtGradoSemestre', 3)
                            ->first();

                            $cgtPeriodoCuarto = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoCuartoSemestre1_2->id)
                            ->where('cgt.cgtGradoSemestre', 4)
                            ->first();
                        
                            $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                                ->whereIn('matSemestre', [1, 2, 3, 4])
                                ->where('matVigentePlanPeriodoActual', '=', 'SI')
                                ->orderBy('matSemestre', 'ASC')
                                ->get();

                            foreach ($bachiller_materias as $value) {

                                $bachiller_historico = Bachiller_historico::where('alumno_id', $alumno_id)
                                    ->where('plan_id', $plan_id)
                                    ->where('bachiller_materia_id', $value->id)
                                    ->where('periodo_id', $periodo_id)
                                    ->get();

                                // print_r($bachiller_historico."<br>");

                                if ($bachiller_historico->isEmpty()) {

                                    $materia = Bachiller_materias::find($value->id);
                                    $periodo_id_ficticio = 0;
                                    if($materia->matSemestre == 1){
                                        $periodo_id_ficticio = $cgtPeriodoPrimero->periodo_id;
                                    }
                                    if($materia->matSemestre == 3){
                                        $periodo_id_ficticio = $cgtPeriodoSegundo->periodo_id;
                                    }
                                    if($materia->matSemestre == 3){
                                        $periodo_id_ficticio = $cgtPeriodoTercero->periodo_id;
                                    }

                                    if($materia->matSemestre == 4){
                                        $periodo_id_ficticio = $cgtPeriodoCuarto->periodo_id;
                                    }

                                    $bachiller_historico = Bachiller_historico::create([
                                        'alumno_id' => $alumno_id,
                                        'plan_id' => $plan_id,
                                        'bachiller_materia_id' => $value->id,
                                        'periodo_id' => $periodo_id,
                                        'periodo_id_ficticio' => $periodo_id_ficticio,
                                        'histComplementoNombre' => NULL,
                                        'histPeriodoAcreditacion' => 'RC',
                                        'histTipoAcreditacion' => 'RC',
                                        'histFechaExamen' => $fechaOficio,
                                        'histCalificacion' => NULL,
                                        'histFolio' => NULL,
                                        'hisActa' => NULL,
                                        'histLibro' => NULL,
                                        'histNombreOficial' => NULL
                                    ]);
                                }
                            }
                        }


                        // segundo curso 
                        if ($opcion == "C") {

                            $anioPeriodoAnteriorCuarto2 = $periodo->perAnio - 1;
                            $anioPeriodoAnteriorTercero2 = $periodo->perAnio - 2;

                            $periodoCuartoSemestre2 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnteriorCuarto2)
                            ->where('perNumero', 1)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $periodoTerceroSemestre2 = $periodo::select('periodos.*', 'departamentos.depClave')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('perAnio', $anioPeriodoAnteriorTercero2)
                            ->where('perNumero', 3)
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->first();

                            $cgtPeriodoCuarto = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoCuartoSemestre2->id)
                            ->where('cgt.cgtGradoSemestre', 4)
                            ->first();
                            $cgtPeriodoTercero = Cgt::select('periodos.id as periodo_id','cgt.cgtGradoSemestre')
                            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
                            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                            ->where('departamentos.depClave', 'BAC')
                            ->where('ubicacion.id', $request->ubicacion_id)
                            ->where('periodos.id', $periodoTerceroSemestre2->id)
                            ->where('cgt.cgtGradoSemestre', 3)
                            ->first();

                            $bachiller_materias = Bachiller_materias::where('plan_id', '=', $plan_id)
                                ->whereIn('matSemestre', [3, 4])
                                ->where('matVigentePlanPeriodoActual', '=', 'SI')
                                ->orderBy('matSemestre', 'ASC')
                                ->get();

                            foreach ($bachiller_materias as $value) {

                                $bachiller_historico = Bachiller_historico::where('alumno_id', $alumno_id)
                                    ->where('plan_id', $plan_id)
                                    ->where('bachiller_materia_id', $value->id)
                                    ->where('periodo_id', $periodo_id)
                                    ->get();

                                // print_r($bachiller_historico."<br>");

                                if ($bachiller_historico->isEmpty()) {

                                    $materia = Bachiller_materias::find($value->id);
                                    $periodo_id_ficticio = 0;
                                    if($materia->matSemestre == 3){
                                        $periodo_id_ficticio = $cgtPeriodoTercero->periodo_id;
                                    }

                                    if($materia->matSemestre == 4){
                                        $periodo_id_ficticio = $cgtPeriodoCuarto->periodo_id;
                                    }

                                    $bachiller_historico = Bachiller_historico::create([
                                        'alumno_id' => $alumno_id,
                                        'plan_id' => $plan_id,
                                        'bachiller_materia_id' => $value->id,
                                        'periodo_id' => $periodo_id,
                                        'periodo_id_ficticio' => $periodo_id_ficticio,
                                        'histComplementoNombre' => NULL,
                                        'histPeriodoAcreditacion' => 'RC',
                                        'histTipoAcreditacion' => 'RC',
                                        'histFechaExamen' => $fechaOficio,
                                        'histCalificacion' => NULL,
                                        'histFolio' => NULL,
                                        'hisActa' => NULL,
                                        'histLibro' => NULL,
                                        'histNombreOficial' => NULL
                                    ]);
                                }
                            }
                        }
                    }
                }


                $resumenAcademico = Bachiller_resumenacademico::where("alumno_id", "=", $alumno_id)
                ->where("plan_id", "=", $plan_id);

                $historicoAlumno = DB::table("vwbachillerhistoricoaprobados as t1")
                ->where("alumno_id", "=", $alumno_id)
                ->where("t1.plan_id", "=", $plan_id)
                ->join("bachiller_materias as t2", "t2.id", "=", "t1.bachiller_materia_id")
                ->get();


                $materiasAlumno = $historicoAlumno
                ->sortByDesc("histFechaExamen")->unique("bachiller_materia_id")
                ->where("matTipoAcreditacion", "=", "N");


                $materiasAlumno = $materiasAlumno->map(function ($item, $key) {
                    if ($item->histCalificacion == -1) {
                        $item->histCalificacion = 0;
                    }
                    return $item;
                });


                $resCreditosCursados = $materiasAlumno->sum("matCreditos");
                $resCreditosAprobados = $materiasAlumno->where("aprobado", "=", "A")->sum("matCreditos");


                $resPromedioAcumulado = $materiasAlumno->sum("histCalificacion") / $materiasAlumno->count();
                $resPromedioAcumulado = number_format($resPromedioAcumulado, 4);


                $materiasCreditos = Bachiller_materias::where("plan_id", "=", $plan_id)->get()->sum("matCreditos");
                $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
                $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);


                if ($resumenAcademico->first()) {
                    Bachiller_resumenacademico::where("alumno_id", "=", $alumno_id)->where("plan_id", "=", $plan_id)
                        ->update([
                            "resPeriodoUltimo"     => $periodo_id,
                            "resClaveEspecialidad" => null,
                            "resCreditosCursados"  => $resCreditosCursados,
                            "resCreditosAprobados" => $resCreditosAprobados,
                            "resAvanceAcumulado"   => $resAvanceAcumulado,
                            "resPromedioAcumulado" => $resPromedioAcumulado,
                        ]);
                }


                alert('Escuela Modelo', 'La revalidación se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_revalidaciones.create');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_revalidaciones/create')->withInput();
            }
        }
    }

    public function edit($id)
    {
        $bachiller_historico = Bachiller_historico::select(
            'bachiller_historico.id',
            'bachiller_historico.alumno_id',
            'bachiller_historico.plan_id',
            'bachiller_historico.bachiller_materia_id',
            'bachiller_historico.periodo_id',
            'bachiller_historico.periodo_id_ficticio',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histFolio',
            'bachiller_historico.hisActa',
            'bachiller_historico.histLibro',
            'bachiller_historico.histNombreOficial',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where("bachiller_historico.id", $id)
        ->first();

        $departamento_id = Auth::user()->empleado->escuela->departamento->id;

        $periodos = Periodo::select('periodos.*')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->where('departamentos.depClave', 'BAC')
        ->where('departamentos.id', $departamento_id)
        ->whereNull('periodos.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->orderBy('periodos.id', 'DESC')
        ->get();

        return view('bachiller.revalidaciones.edit', [
            'bachiller_historico' => $bachiller_historico,
            'periodos' => $periodos
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'  => 'required',
                'departamento_id'  => 'required',
                'plan_id'  => 'required',
                'tipoOficio'  => 'required',
                'fechaOficio'  => 'required'
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'departamento_id.required' => 'El campo Departamento es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'tipoOficio.required' => 'El campo Tipo Oficio es obligatorio.',
                'fechaOficio.required' => 'El campo Fecha Oficio es obligatorio.'           
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_revalidaciones/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $bachiller_historico = Bachiller_historico::find($id);

                $periodo_id = $request->periodo_id;
                $departamento_id = $request->departamento_id;
                $departamento = Departamento::find($departamento_id);
                $depClave = $departamento->depClave;
                $plan_id = $request->plan_id;
                $plan = Plan::find($plan_id);
                $planClave = $plan->planClave;
                $tipoOficio = $request->tipoOficio;
                $aluClave = $request->aluClave;
                $fechaOficio = $request->fechaOficio;
                // Buscar alumno 
                $alumno = Alumno::where('aluClave', '=', $aluClave)->first();
                $alumno_id = $alumno->id;

                $fechaActual = Carbon::now('America/Merida');
                setlocale(LC_TIME, 'es_ES.UTF-8');

                $bachiller_historico->update([
                    "periodo_id" => $periodo_id,
                    "histPeriodoAcreditacion" => $tipoOficio,
                    "histTipoAcreditacion" => $tipoOficio,
                    "histFechaExamen" => $fechaOficio
                ]);

                $resumenAcademico = Bachiller_resumenacademico::where("alumno_id", "=", $alumno_id)
                ->where("plan_id", "=", $plan_id);

                $historicoAlumno = DB::table("vwbachillerhistoricoaprobados as t1")
                ->where("alumno_id", "=", $alumno_id)
                ->where("t1.plan_id", "=", $plan_id)
                ->join("bachiller_materias as t2", "t2.id", "=", "t1.bachiller_materia_id")
                ->get();


                $materiasAlumno = $historicoAlumno
                ->sortByDesc("histFechaExamen")->unique("bachiller_materia_id")
                ->where("matTipoAcreditacion", "=", "N");


                $materiasAlumno = $materiasAlumno->map(function ($item, $key) {
                    if ($item->histCalificacion == -1) {
                        $item->histCalificacion = 0;
                    }
                    return $item;
                });


                $resCreditosCursados = $materiasAlumno->sum("matCreditos");
                $resCreditosAprobados = $materiasAlumno->where("aprobado", "=", "A")->sum("matCreditos");


                $resPromedioAcumulado = $materiasAlumno->sum("histCalificacion") / $materiasAlumno->count();
                $resPromedioAcumulado = number_format($resPromedioAcumulado, 4);


                $materiasCreditos = Bachiller_materias::where("plan_id", "=", $plan_id)->get()->sum("matCreditos");
                $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
                $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);


                if ($resumenAcademico->first()) {
                    Bachiller_resumenacademico::where("alumno_id", "=", $alumno_id)->where("plan_id", "=", $plan_id)
                        ->update([
                            "resPeriodoUltimo"     => $periodo_id,
                            "resClaveEspecialidad" => null,
                            "resCreditosCursados"  => $resCreditosCursados,
                            "resCreditosAprobados" => $resCreditosAprobados,
                            "resAvanceAcumulado"   => $resAvanceAcumulado,
                            "resPromedioAcumulado" => $resPromedioAcumulado,
                        ]);
                }


                alert('Escuela Modelo', 'La revalidación se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_revalidaciones.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                    return back();
                }
        }
    }

    public function obtienePeriodo(Request $request, $periodo_id)
    {
        if($request->ajax()){
            // $periodo = Periodo::where('id',$periodo_id)->get();

            $periodo = Periodo::find($periodo_id);

            return response()->json($periodo);
        }
    }

    public function destroy($id)
    {

        $historico = Bachiller_historico::findOrFail($id);

        try {

            if ($historico->delete()) {              

                alert('Escuela Modelo', 'El histórico se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el historico')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('error' . $errorCode, $errorMessage)->showConfirmButton();
        }

        return redirect()->back();
    }
}

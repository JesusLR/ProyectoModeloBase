<?php

namespace App\Http\Controllers\Secundaria;

use App\clases\departamentos\MetodosDepartamentos;
use Auth;
use Validator;
use App\Models\User;
use App\Http\Helpers\Utils;
use App\Http\Models\Cgt;
use App\Http\Models\Horario;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Escuela;
use App\Http\Models\Secundaria\Secundaria_calificaciones;
use App\Http\Models\Secundaria\Secundaria_empleados;
use App\Http\Models\Secundaria\Secundaria_grupos;
use App\Http\Models\Secundaria\Secundaria_grupos_evidencias;
use App\Http\Models\Secundaria\Secundaria_inscritos;
use App\Http\Models\Secundaria\Secundaria_materias;
use App\Http\Models\Secundaria\Secundaria_materias_acd;
use App\Http\Models\Secundaria\Secundaria_mes_evaluaciones;
use Carbon\Carbon;

class SecundariaGrupoController extends Controller
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
        return view('secundaria.grupos.show-list');
    }


    public function list()
    {

        //SECUNDARIA PERIODO ACTUAL (MERIDA Y VALLADOLID)
        $perActualUser = Auth::user()->empleado->escuela->departamento->perActual;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(15);
        $perActualCME = $departamentoCME->perActual;
        $perSigCME = $departamentoCME->perSig;


        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(19);
        $perActualCVA = $departamentoCVA->perActual;
        $perSigCVA = $departamentoCVA->perSig;

        $sistemas = Auth::user()->username;
        $campus = Auth::user()->campus_cme;


        $grupos = Secundaria_grupos::select(
            'secundaria_grupos.id',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoClave',
            'secundaria_grupos.gpoTurno',
            'secundaria_grupos.gpoMatComplementaria',
            'secundaria_materias.id as materia_id',
            'secundaria_materias.matClave',
            'secundaria_materias.matNombre',
            'secundaria_materias.matNombreCorto',
            'secundaria_materias.matSemestre',
            'planes.id as plan_id',
            'planes.planClave',
            'planes.planPeriodos',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'periodos.perEstado',
            'departamentos.id as departamento_id',
            'departamentos.depNivel',
            'departamentos.depClave',
            'departamentos.depNombre',
            'departamentos.depNombreCorto',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'ubicacion.ubiCalle',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empNombre',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'programas.progNombreCorto',
            'departamentos.perActual'
        )
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
            ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where(static function ($query) use ($sistemas, $perActualCME, $perActualCVA, $perSigCME, $perSigCVA, $campus) {

                if ($sistemas == "DESARROLLO.SECUNDARIA") {
                    $query->where('departamentos.depClave', '=', 'SEC');
                } else {
                    if ($campus == 1) {
                        $query->whereIn('ubicacion.id', [1]);
                    } else {
                        $query->whereIn('ubicacion.id', [2]);
                    }
                }
            })
            ->orderBy('secundaria_grupos.id', 'desc');

        //->where('periodos.id', $perActual)


        $acciones = '';
        return Datatables::of($grupos)

            ->filterColumn('materia_complementaria', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('materia_complementaria', function ($query) {
                return $query->gpoMatComplementaria;
            })

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })

            ->filterColumn('nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre', function ($query) {
                return $query->empNombre;
            })
            ->filterColumn('apellido1', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido1', function ($query) {
                return $query->empApellido1;
            })
            ->filterColumn('apellido2', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido2', function ($query) {
                return $query->empApellido2;
            })

            ->filterColumn('peranio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('peranio', function ($query) {
                return $query->perAnioPago;
            })

            ->filterColumn('planclave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('planclave', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('programa', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('programa', function ($query) {
                return $query->progNombre;
            })

            ->filterColumn('clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave', function ($query) {
                return $query->matClave;
            })

            ->filterColumn('matName', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('matName', function ($query) {
                return $query->matNombre;
            })
            ->addColumn('action', function ($grupos) {

                $perActualUser = Auth::user()->empleado->escuela->departamento->perActual;
                $perSigUser = Auth::user()->empleado->escuela->departamento->perSig;

                $departamentoCME = Departamento::with('ubicacion')->findOrFail(15);
                $perActualCME = $departamentoCME->perActual;
                $perSigCME = $departamentoCME->perSig;


                $departamentoCVA = Departamento::with('ubicacion')->findOrFail(19);
                $perActualCVA = $departamentoCVA->perActual;
                $perSigCVA = $departamentoCVA->perSig;


                $btnRecuperativos = "";
                $acciones = "";
                $btnEvidencias = "";
                $editarCalificaciones = "";
                $btnEditarGrupo = "";
                $btnEliminar = "";
                
                if(auth()->user()->departamento_sistemas == 1){ 
                    $btnRecuperativos = '<a href="secundaria_calificacion/grupo/' . $grupos->id . '/recuperativos" class="button button--icon js-button js-ripple-effect" title="Recuperativos" >
                    <i class="material-icons">wrap_text</i>
                    </a>';

                    $btnEvidencias = '<a href="secundaria_grupo/' . $grupos->id . '/evidencia" class="button button--icon js-button js-ripple-effect" title="Evidencias" >
                    <i class="material-icons">description</i>
                    </a>';

                    $editarCalificaciones = '<a href="secundaria_calificacion/grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Ver/Editar calificaciones" >
                    <i class="material-icons">playlist_add_check</i>
                    </a>';

                    $btnEditarGrupo = '<a href="secundaria_grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>';

                    $btnEliminar = '<form id="delete_' . $grupos->id . '" action="secundaria_grupo/' . $grupos->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $grupos->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    </form>';
                }else {
                    if($perActualCME == $grupos->periodo_id || $perSigCME == $grupos->periodo_id || $perActualCVA == $grupos->periodo_id || $perSigCVA == $grupos->periodo_id){
                        $btnRecuperativos = '<a href="secundaria_calificacion/grupo/' . $grupos->id . '/recuperativos" class="button button--icon js-button js-ripple-effect" title="Recuperativos" >
                            <i class="material-icons">wrap_text</i>
                            </a>';

                        $btnEvidencias = '<a href="secundaria_grupo/' . $grupos->id . '/evidencia" class="button button--icon js-button js-ripple-effect" title="Evidencias" >
                        <i class="material-icons">description</i>
                        </a>';

                        $editarCalificaciones = '<a href="secundaria_calificacion/grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Ver/Editar calificaciones" >
                        <i class="material-icons">playlist_add_check</i>
                        </a>';

                        $btnEditarGrupo = '<a href="secundaria_grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                        </a>';

                        $btnEliminar = '<form id="delete_' . $grupos->id . '" action="secundaria_grupo/' . $grupos->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $grupos->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                        </form>';
                    }else{
                        $btnRecuperativos = "";
                        $btnEvidencias = "";
                        $editarCalificaciones = "";
                        $btnEditarGrupo = "";
                        $btnEliminar = "";
                        
                    }
                }

                

                if(auth()->user()->departamento_sistemas == 1){                


                    $acciones = '<div class="row">'

                        .$btnEvidencias.

                        '<a href="secundaria_inscritos/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Alumnos" >
                            <i class="material-icons">assignment_turned_in</i>
                        </a>'

                        . $editarCalificaciones

                        . $btnRecuperativos .

                        '<a href="secundaria_inscritos/pase_lista/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Pase de lista" >
                        <i class="material-icons">assignment</i>
                        </a>

                        <a href="secundaria_grupo/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>'

                        . $btnEditarGrupo

                        . $btnEliminar .

                        '</div>';
                }else {
                    $acciones = '<div class="row">'

                    .$btnEvidencias.

                    '<a href="secundaria_inscritos/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Alumnos" >
                        <i class="material-icons">assignment_turned_in</i>
                    </a>'

                    . $editarCalificaciones

                    . $btnRecuperativos .

                    '<a href="secundaria_inscritos/pase_lista/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Pase de lista" >
                    <i class="material-icons">assignment</i>
                    </a>

                    <a href="secundaria_grupo/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>'

                    . $btnEditarGrupo

                    . $btnEliminar .

                    '</div>';
                }

                

                return $acciones;
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
        $empleados = Secundaria_empleados::where('empEstado', 'A')->get();
        return view('secundaria.grupos.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
        ]);
    }


    public function getSecundariaMaterias(Request $request, $semestre, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Secundaria_materias::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', $semestre],
                ['matVigentePlanPeriodoActual', '=', 'SI']
            ])->get();

            return response()->json($materias);
        }
    }


    public function materiaComplementaria(Request $request, $secundaria_materia_id, $plan_id, $periodo_id, $grado)
    {
        if ($request->ajax()) {

            $materiasACD = Secundaria_materias_acd::select(
                'secundaria_materias_acd.id',
                'secundaria_materias_acd.secundaria_materia_id',
                'secundaria_materias_acd.plan_id',
                'secundaria_materias_acd.periodo_id',
                'secundaria_materias_acd.gpoGrado',
                'secundaria_materias_acd.gpoMatComplementaria',
                'secundaria_materias.matNombre',
                'secundaria_materias.matClave'
            )
                ->join('secundaria_materias', 'secundaria_materias_acd.secundaria_materia_id', '=', 'secundaria_materias.id')
                ->join('periodos', 'secundaria_materias_acd.periodo_id', '=', 'periodos.id')
                ->join('planes', 'secundaria_materias_acd.plan_id', '=', 'planes.id')
                ->where('secundaria_materias_acd.secundaria_materia_id', '=', $secundaria_materia_id)
                ->where('secundaria_materias_acd.plan_id', '=', $plan_id)
                ->where('secundaria_materias_acd.periodo_id', '=', $periodo_id)
                ->where('secundaria_materias_acd.gpoGrado', '=', $grado)
                ->get();

            return response()->json($materiasACD);
        }
    }

    public function getDepartamentos(Request $request, $id)
    {
        if ($request->ajax()) {
            // $departamentos = Departamento::with('ubicacion')->where('ubicacion_id','=',$id)
            // ->whereIn('depClave', ['SUP', 'POS'])->get();

            if (Auth::user()->secundaria == 1) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['SEC']);
            }

            //$departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['POS', 'SUP', 'PRE']);
            return response()->json($departamentos);
        }
    }

    // seleccionar escuelas
    public function getEscuelas(Request $request)
    {

        if ($request->ajax()) {
            $escuelas = Escuela::where('departamento_id', '=', $request->id)
                ->where(function ($query) use ($request) {
                    $query->where("escNombre", "like", "ESCUELA%");
                    $query->orWhere('escNombre', "like", "POSGRADOS%");
                    $query->orWhere('escNombre', "like", "MAESTRIAS%");
                    $query->orWhere('escNombre', "like", "ESPECIALIDADES%");
                    $query->orWhere('escNombre', "like", "DOCTORADOS%");
                    $query->orWhere('escNombre', "like", "PRESCOLAR%");
                    $query->orWhere('escNombre', "like", "PRIMARIA%");
                    $query->orWhere('escNombre', "like", "SECUNDARIA%");


                    if ($request->otro == "diplomados") {
                        $query->orWhere('escNombre', "like", "DIPLOMADOS%");
                    }
                })
                ->get();

            return response()->json($escuelas);
        }
    }

    // OBTENER PERIDO SECUNDARIA
    public function getPeriodos(Request $request, $departamento_id)
    {
        $fecha = Carbon::now('CDT');
        $periodos = Periodo::where('departamento_id', $departamento_id)
            ->where('perAnio', '<=', $fecha->year + 1)
            ->orderBy('id', 'desc')->get();

        /*
        * Si $request posee una variable llamada 'field'.
        * retorna un "distinct" de los valores.
        * (creada para selects perNumero o perAnio).
        */
        if ($request->field && $request->field == 'perNumero') {
            $periodos = $periodos->sortBy('perNumero')->pluck('perNumero')->unique();
        } elseif ($request->field && $request->field == 'perAnio') {
            $periodos = $periodos->pluck('perAnio')->unique();
        }

        if ($request->ajax()) {
            return response()->json($periodos);
        }
    }

    public function listEquivalente(Request $request)
    {
        $periodo_id = $request->periodo_id;

        $grupo = Secundaria_grupos::select(
            "secundaria_grupos.id as id",
            "planes.planClave as planClave",
            "programas.progClave as progClave",
            "secundaria_materias.matClave as matClave",
            "secundaria_materias.matNombre as matNombre",
            "optativas.optNombre as optNombre",
            "secundaria_grupos.gpoGrado as gpoSemestre",
            "secundaria_grupos.gpoClave as gpoClave",
            "secundaria_grupos.gpoTurno as gpoTurno",
            "secundaria_grupos.grupo_equivalente_id",
            "periodos.perNumero",
            "periodos.perAnio"
        )
            ->join("secundaria_materias", "secundaria_materias.id", "=", "secundaria_grupos.secundaria_materia_id")
            ->join("periodos", "periodos.id", "=", "secundaria_grupos.periodo_id")
            ->join("planes", "planes.id", "=", "secundaria_grupos.plan_id")
            ->join("programas", "programas.id", "=", "planes.programa_id")
            ->leftJoin("optativas", "optativas.id", "=", "secundaria_grupos.optativa_id", "optativas.optNombre")
            ->where("secundaria_grupos.periodo_id", "=", $periodo_id)
            ->whereNull("secundaria_grupos.grupo_equivalente_id");


        return Datatables::of($grupo)

            ->filterColumn('gpoSemestre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoSemestre, gpoClave, gpoTurno) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('gpoSemestre', function ($query) {
                return $query->gpoSemestre . $query->gpoClave . $query->gpoTurno;
            })

            ->addColumn('action', function ($grupo) {
                return '<div class="row">
                    <div class="col s1">
                        <button class="btn modal-close" title="Ver" onclick="seleccionarGrupo(' . $grupo->id . ')">
                            <i class="material-icons">done</i>
                        </button>
                    </div>
                </div>';
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empleadoRequired = 'required';

        $empleado_id_docente          = $request->empleado_id;
        $empleado_id_auxiliar         = Utils::validaEmpty($request->empleado_id_auxiliar);


        if ($request->grupo_equivalente_id) {
            $empleadoRequired = '';
            $grupoEq = Secundaria_grupos::where("id", "=", $request->grupo_equivalente_id)->first();

            $empleado_id_docente                 = $grupoEq->empleado_id;
            $empleado_id_auxiliar         = Utils::validaEmpty($grupoEq->empleado_sinodal_id);
        }

        if ($request->input('gpoACD') == 1) {
            $gpoMatComplementaria = 'required';
            $texto = 'gpoMatComplementaria.required';
        }
        if ($request->gpoACD == 0) {
            $gpoMatComplementaria = 'nullable';
            $texto = 'gpoMatComplementaria.nullable';
        }

        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id' => 'required|unique:secundaria_grupos,periodo_id,NULL,id,secundaria_materia_id,' .
                    $request->input('materia_id') . ',plan_id,' . $request->input('plan_id') .
                    ',gpoGrado,' . $request->input('gpoSemestre') . ',gpoClave,' . $request->input('gpoClave') .
                    ',gpoTurno,' . $request->input('gpoTurno') . ',deleted_at,NULL',
                'materia_id'  => 'required',
                'empleado_id' => $empleadoRequired,
                'plan_id'     => 'required',
                'gpoSemestre' => 'required',
                'gpoClave'    => 'required',
                'gpoTurno'    => 'required',
                'gpoMatComplementaria' => $gpoMatComplementaria
                // 'gpoExtraCurr' => 'required',
            ],
            [
                'periodo_id.unique' => "El grupo ya existe",
                'empleado_id.required' => "El campo docente títular es obligatorio",
                'gpoClave.required' => "El campo clave de grupo es obligatorio",
                'materia_id.required' => "El campo materia es obligatorio",
                'gpoSemestre.required' => "El campo grado es obligatorio",
                $texto => "El campo materia complementaria es obligatorio"

            ]
        );

        //VALIDAR SI YA EXISTE EL GRUPO QUE SE ESTA CREANDO
        $grupo = Secundaria_grupos::with("plan", "periodo", "secundaria_empleado", "secundaria_materia")
            ->where("secundaria_materia_id", "=", $request->materia_id)
            ->where("plan_id", "=", $request->plan_id)
            ->where("gpoGrado", "=", $request->gpoSemestre)
            ->where("gpoClave", "=", $request->gpoClave)
            ->where("gpoTurno", "=", $request->gpoTurno)
            ->where("periodo_id", "=", $request->periodo_id)
            ->first();



        if (!$request->ajax()) {
            if ($validator->fails()) {
                return redirect()->route('secundaria.secundaria_grupo.create')->withErrors($validator)->withInput();
            }
        }

        if ($request->ajax()) {
            if ($validator->fails()) {
                if ($grupo) {
                    return response()->json([
                        "res" => false,
                        "existeGrupo" => true,
                        "msg" => $grupo
                    ]);
                } else {

                    return response()->json([
                        "res" => false,
                        "existeGrupo" => false,
                        "msg" => $validator->errors()->messages()
                    ]);
                }
            }
        }


        DB::beginTransaction();
        try {

            // valida si viene check 
            if ($request->gpoACD == 1) {
                $gpoACD = 1;
                $gpoMatComplementaria = $request->gpoMatComplementaria;
                $secundaria_materia_acd_id = $request->secundaria_materia_acd_id;
            }
            if ($request->gpoACD == 0) {
                $gpoACD = 0;
                $gpoMatComplementaria = null;
                $secundaria_materia_acd_id = null;
            }

            $grupo = Secundaria_grupos::create([
                'secundaria_materia_id'     => $request->input('materia_id'),
                'plan_id'                   => $request->input('plan_id'),
                'periodo_id'                => $request->input('periodo_id'),
                'gpoGrado'                  => $request->input('gpoSemestre'),
                'gpoClave'                  => $request->input('gpoClave'),
                'gpoTurno'                  => $request->input('gpoTurno'),
                'empleado_id_docente'       => $empleado_id_docente,
                'empleado_id_auxiliar'      => $empleado_id_auxiliar,
                'gpoMatComplementaria'      => $gpoMatComplementaria,
                'gpoFechaExamenOrdinario'   => null,
                'gpoHoraExamenOrdinario'    => null,
                'gpoCupo'                   => Utils::validaEmpty($request->input('gpoCupo')),
                'gpoNumeroFolio'            => $request->input('gpoNumeroFolio'),
                'gpoNumeroActa'             => $request->input('gpoNumeroActa'),
                'gpoNumeroLibro'            => $request->input('gpoNumeroLibro'),
                'grupo_equivalente_id'      => Utils::validaEmpty($request->input('grupo_equivalente_id')),
                'optativa_id'               => null,
                'estado_act'                =>  'A',
                'fecha_mov_ord_act'         => null,
                'clave_actv'                => null,
                'inscritos_gpo'             => 0,
                'nombreAlternativo'         => null,
                'gpoExtraCurr'              => 'g',
                'gpoACD'                    => $gpoACD,
                'secundaria_materia_acd_id' => $secundaria_materia_acd_id
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            return response()->json([
                "res" => false,
                "existeGrupo" => false,
                "msg" => [['Ha ocurrido un problema.' . $errorCode . '|' . $errorMessage]],
            ]);
        }
        DB::commit(); #TEST
        return response()->json([
            "res"  => true,
            "data" => $grupo
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $secundaria_grupo = Secundaria_grupos::with('plan', 'secundaria_materia', 'secundaria_empleado')->findOrFail($id);
        $docente_auxiliar = Secundaria_empleados::find($secundaria_grupo->empleado_id_auxiliar);
        $grupo_equivalente = Secundaria_grupos::with('plan', 'secundaria_materia', 'secundaria_empleado')->find($secundaria_grupo->grupo_equivalente_id);

        return view('secundaria.grupos.show', [
            'secundaria_grupo' => $secundaria_grupo,
            'docente_auxiliar' => $docente_auxiliar,
            'grupo_equivalente' => $grupo_equivalente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleados = Secundaria_empleados::where('empEstado', 'A')->get();
        $grupo = Secundaria_grupos::with('plan', 'secundaria_materia', 'secundaria_empleado')->findOrFail($id);
        $periodos = Periodo::where('departamento_id', $grupo->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado', 'escuela')->where('escuela_id', $grupo->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id', $grupo->plan->programa->id)->get();

        $materiasACD = Secundaria_materias_acd::select(
            'secundaria_materias_acd.id',
            'secundaria_materias_acd.secundaria_materia_id',
            'secundaria_materias_acd.plan_id',
            'secundaria_materias_acd.periodo_id',
            'secundaria_materias_acd.gpoGrado',
            'secundaria_materias_acd.gpoMatComplementaria',
            'secundaria_materias.matNombre',
            'secundaria_materias.matClave'
        )
            ->join('secundaria_materias', 'secundaria_materias_acd.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('periodos', 'secundaria_materias_acd.periodo_id', '=', 'periodos.id')
            ->join('planes', 'secundaria_materias_acd.plan_id', '=', 'planes.id')
            ->where('secundaria_materias_acd.secundaria_materia_id', '=', $grupo->secundaria_materia_id)
            ->where('secundaria_materias_acd.plan_id', '=', $grupo->plan_id)
            ->where('secundaria_materias_acd.periodo_id', '=', $grupo->periodo_id)
            ->where('secundaria_materias_acd.gpoGrado', '=', $grupo->gpoGrado)
            ->get();

        // if (!in_array($grupo->estado_act, ["A", "B"])) {
        //     alert()->error('Ups...', 'El grupo se encuentra cerrado, no se puede modificar')->showConfirmButton()->autoClose(5000);
        //     return redirect('grupo');
        // }

        $grupo_equivalente = Secundaria_grupos::with('plan', 'periodo', 'secundaria_materia')->find($grupo->grupo_equivalente_id);



        $cgts = Cgt::where([['plan_id', $grupo->plan_id], ['periodo_id', $grupo->periodo_id]])->get();
        $materias = Secundaria_materias::where([['plan_id', '=', $grupo->plan_id], ['matSemestre', '=', $grupo->gpoGrado]])->get();
        // $optativas = Optativa::where('materia_id', '=', $grupo->materia_id)->get();




        return view('secundaria.grupos.edit', compact(
            'grupo',
            'empleados',
            'periodos',
            'programas',
            'planes',
            'cgts',
            'materias',
            'optativas',
            'grupo_equivalente',
            'materiasACD'
        ));
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
        $empleadoRequired = 'required';

        $empleado_id_docente                 = $request->empleado_id;
        $empleado_id_auxiliar         = Utils::validaEmpty($request->empleado_id_auxiliar);

        if ($request->gpoACD == 1) {
            $gpoMatComplementaria = 'required';
            $texto = 'gpoMatComplementaria.required';
            $gpoMatComplementariaSave = $request->gpoMatComplementaria;
            $gpoACD = 1;
            $secundaria_materia_acd_id = $request->secundaria_materia_acd_id;
        }
        if ($request->gpoACD == 0) {
            $gpoMatComplementaria = 'nullable';
            $texto = 'gpoMatComplementaria.nullable';
            $gpoMatComplementariaSave = null;
            $gpoACD = 0;
            $secundaria_materia_acd_id = null;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'    => 'required',
                'materia_id'    => 'required',
                'empleado_id'   => $empleadoRequired,
                'plan_id'       => 'required',
                'gpoSemestre'   => 'required',
                'gpoClave'      => 'required',
                'gpoTurno'      => 'required',
                'gpoCupo'       => 'required',
                'gpoMatComplementaria' => $gpoMatComplementaria
            ],
            [
                'empleado_id.required' => "El campo docente títular es obligatorio",
                'gpoClave.required' => "El campo clave de grupo es obligatorio",
                'materia_id.required' => "El campo materia es obligatorio",
                'gpoSemestre.required' => "El campo grado es obligatorio",
                'gpoCupo.required' => "El campo Cupo es obligatorio",
                $texto => "El campo materia complementaria es obligatorio"

            ]
        );

        if ($validator->fails()) {
            return redirect('secundaria_grupo/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        try {

            $grupo = Secundaria_grupos::findOrFail($id);
            $grupo->empleado_id_docente                 = $empleado_id_docente;
            $grupo->empleado_id_auxiliar         = $empleado_id_auxiliar;
            $grupo->gpoFechaExamenOrdinario     = null;
            $grupo->gpoHoraExamenOrdinario      = null;
            $grupo->gpoMatComplementaria        = $gpoMatComplementariaSave;
            $grupo->gpoCupo                     = Utils::validaEmpty($request->gpoCupo);
            $grupo->gpoNumeroFolio              = $request->gpoNumeroFolio;
            $grupo->gpoNumeroActa               = $request->gpoNumeroActa;
            $grupo->gpoNumeroLibro              = $request->gpoNumeroLibro;
            $grupo->grupo_equivalente_id        = Utils::validaEmpty($request->grupo_equivalente_id);
            // $grupo->optativa_id                 = Utils::validaEmpty($request->optativa_id);
            $grupo->nombreAlternativo           = null;
            $grupo->gpoExtraCurr                = $request->gpoExtraCurr;
            $grupo->gpoACD                      = $gpoACD;
            $grupo->secundaria_materia_acd_id   = $secundaria_materia_acd_id;


            $success = $grupo->save();

            alert('Escuela Modelo', 'El grupo se ha actualizado con éxito', 'success')->showConfirmButton();
            return redirect()->back();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('secundaria_grupo/' . $id . '/edit')->withInput();
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                         llama la vista de evidencia                        */
    /* -------------------------------------------------------------------------- */
    public function evidenciaTable($id)
    {
        $grupo = Secundaria_grupos::where('id', $id)->first();

        $meses = Secundaria_mes_evaluaciones::get();

        $Evidencias = Secundaria_grupos_evidencias::where('secundaria_grupo_id', $id)->first();


        return view('secundaria.grupos.evidencia', [
            'grupo' => $grupo,
            'meses' => $meses,
            'Evidencias' => $Evidencias
        ]);
    }


    /* -------------------------------------------------------------------------- */
    /*             guarda o actualiza las evidencias segun sea el caso            */
    /* -------------------------------------------------------------------------- */
    public function guardar_actualizar_evidencia(Request $request)
    {
        $aplicarParaTodos = $request->aplicar;
        // valores de los request
        $secundaria_grupo_id =            $request->secundaria_grupo_id;
        $secundaria_mes_evaluacion_id =   $request->secundaria_mes_evaluacion_id;
        $numero_evidencias =            $request->numero_evidencias;
        $concepto_evidencia1 =          $request->concepto_evidencia1;
        $concepto_evidencia2 =          $request->concepto_evidencia2;
        $concepto_evidencia3 =          $request->concepto_evidencia3;
        $concepto_evidencia4 =          $request->concepto_evidencia4;
        $concepto_evidencia5 =          $request->concepto_evidencia5;
        $concepto_evidencia6 =          $request->concepto_evidencia6;
        $concepto_evidencia7 =          $request->concepto_evidencia7;
        $concepto_evidencia8 =          $request->concepto_evidencia8;
        $concepto_evidencia9 =          $request->concepto_evidencia9;
        $concepto_evidencia10 =         $request->concepto_evidencia10;
        $porcentaje_evidencia1 =        $request->porcentaje_evidencia1;
        $porcentaje_evidencia2 =        $request->porcentaje_evidencia2;
        $porcentaje_evidencia3 =        $request->porcentaje_evidencia3;
        $porcentaje_evidencia4 =        $request->porcentaje_evidencia4;
        $porcentaje_evidencia5 =        $request->porcentaje_evidencia5;
        $porcentaje_evidencia6 =        $request->porcentaje_evidencia6;
        $porcentaje_evidencia7 =        $request->porcentaje_evidencia7;
        $porcentaje_evidencia8 =        $request->porcentaje_evidencia8;
        $porcentaje_evidencia9 =        $request->porcentaje_evidencia9;
        $porcentaje_evidencia10 =       $request->porcentaje_evidencia10;
        $porcentajeTotal =              $request->porcentajeTotal;
        // $porcentajeTotal = 0;

        $grupo_evidencia = Secundaria_grupos_evidencias::where('secundaria_grupo_id', $secundaria_grupo_id)
            ->where('secundaria_mes_evaluacion_id', $secundaria_mes_evaluacion_id)
            ->first();

        // obtener listado de calificaciones en dicho mes seleccionado
        $calificaciones = Secundaria_calificaciones::select(
            'secundaria_calificaciones.secundaria_inscrito_id',
            'secundaria_calificaciones.secundaria_grupo_evidencia_id',
            'secundaria_mes_evaluaciones.id as secundaria_mes_evaluacion_id',
            'secundaria_grupos.id'
        )
            ->join('secundaria_grupos_evidencias', 'secundaria_calificaciones.secundaria_grupo_evidencia_id', '=', 'secundaria_grupos_evidencias.id')
            ->join('secundaria_mes_evaluaciones', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', '=', 'secundaria_mes_evaluaciones.id')
            ->join('secundaria_grupos', 'secundaria_grupos_evidencias.secundaria_grupo_id', '=', 'secundaria_grupos.id')
            ->where('secundaria_mes_evaluaciones.id', '=', $secundaria_mes_evaluacion_id)
            ->where('secundaria_grupos.id', '=', $secundaria_grupo_id)
            ->get();

        // si hay calificaciones en dicho mes no se podra registrar nuevas evidencias
        if (count($calificaciones) > 0) {
            alert()->error('Ups...', 'No se puede actualizar evidencias debido que cuenta con calificaciones registradas en el mes seleccionado')->showConfirmButton()->autoClose(7000);
            return back();
        }

        // valida si el porcentaje es menor o mayor a 100 para poder realizar el  registro
        if ($porcentajeTotal > 100 || $porcentajeTotal < 100) {
            alert()->error('Ups...', 'El porcentaje total no puede ser meno o mayor de %100')->showConfirmButton()->autoClose(5000);
            return back();
        } else {
            if (!empty($grupo_evidencia)) {
                $grupo_evidencia->update([
                    'secundaria_grupo_id'          => $secundaria_grupo_id,
                    'secundaria_mes_evaluacion_id' => $secundaria_mes_evaluacion_id,
                    'numero_evidencias'          => $numero_evidencias,
                    'concepto_evidencia1'        => $concepto_evidencia1,
                    'concepto_evidencia2'        => $concepto_evidencia2,
                    'concepto_evidencia3'        => $concepto_evidencia3,
                    'concepto_evidencia4'        => $concepto_evidencia4,
                    'concepto_evidencia5'        => $concepto_evidencia5,
                    'concepto_evidencia6'        => $concepto_evidencia6,
                    'concepto_evidencia7'        => $concepto_evidencia7,
                    'concepto_evidencia8'        => $concepto_evidencia8,
                    'concepto_evidencia9'        => $concepto_evidencia9,
                    'concepto_evidencia10'       => $concepto_evidencia10,
                    'porcentaje_evidencia1'      => $porcentaje_evidencia1,
                    'porcentaje_evidencia2'      => $porcentaje_evidencia2,
                    'porcentaje_evidencia3'      => $porcentaje_evidencia3,
                    'porcentaje_evidencia4'      => $porcentaje_evidencia4,
                    'porcentaje_evidencia5'      => $porcentaje_evidencia5,
                    'porcentaje_evidencia6'      => $porcentaje_evidencia6,
                    'porcentaje_evidencia7'      => $porcentaje_evidencia7,
                    'porcentaje_evidencia8'      => $porcentaje_evidencia8,
                    'porcentaje_evidencia9'      => $porcentaje_evidencia9,
                    'porcentaje_evidencia10'     => $porcentaje_evidencia10,
                    'porcentaje_total'           => $porcentajeTotal
                ]);
            } else {
                // si el checkbox de aplicar todos esta seleccioando se crea un array
                if ($aplicarParaTodos == "TODOS") {

                    if ($secundaria_mes_evaluacion_id == 1) {
                        // array de id de los meses
                        $valor2 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                        $numeroVueltas = 10;
                    }
                    if ($secundaria_mes_evaluacion_id == 2) {
                        // array de id de los meses
                        $valor2 = [2, 3, 4, 5, 6, 7, 8, 9, 10];
                        $numeroVueltas = 9;
                    }
                    if ($secundaria_mes_evaluacion_id == 3) {
                        // array de id de los meses
                        $valor2 = [3, 4, 5, 6, 7, 8, 9, 10];
                        $numeroVueltas = 8;
                    }
                    if ($secundaria_mes_evaluacion_id == 4) {
                        // array de id de los meses
                        $valor2 = [4, 5, 6, 7, 8, 9, 10];
                        $numeroVueltas = 7;
                    }
                    if ($secundaria_mes_evaluacion_id == 5) {
                        // array de id de los meses
                        $valor2 = [5, 6, 7, 8, 9, 10];
                        $numeroVueltas = 6;
                    }
                    if ($secundaria_mes_evaluacion_id == 6) {
                        // array de id de los meses
                        $valor2 = [6, 7, 8, 9, 10];
                        $numeroVueltas = 5;
                    }
                    if ($secundaria_mes_evaluacion_id == 7) {
                        // array de id de los meses
                        $valor2 = [7, 8, 9, 10];
                        $numeroVueltas = 4;
                    }
                    if ($secundaria_mes_evaluacion_id == 8) {
                        // array de id de los meses
                        $valor2 = [8, 9, 10];
                        $numeroVueltas = 3;
                    }
                    if ($secundaria_mes_evaluacion_id == 9) {
                        // array de id de los meses
                        $valor2 = [9, 10];
                        $numeroVueltas = 2;
                    }
                    if ($secundaria_mes_evaluacion_id == 10) {
                        // array de id de los meses
                        $valor2 = [10];
                        $numeroVueltas = 1;
                    }

                    // array de evidencias
                    for ($i = 0; $i < $numeroVueltas; $i++) {

                        $evidencias = new Secundaria_grupos_evidencias();
                        $evidencias['secundaria_grupo_id']          = $secundaria_grupo_id;
                        $evidencias['secundaria_mes_evaluacion_id'] = $valor2[$i];
                        $evidencias['numero_evidencias']          = $numero_evidencias;
                        $evidencias['concepto_evidencia1']        = $concepto_evidencia1;
                        $evidencias['concepto_evidencia2']        = $concepto_evidencia2;
                        $evidencias['concepto_evidencia3']        = $concepto_evidencia3;
                        $evidencias['concepto_evidencia4']        = $concepto_evidencia4;
                        $evidencias['concepto_evidencia5']        = $concepto_evidencia5;
                        $evidencias['concepto_evidencia6']        = $concepto_evidencia6;
                        $evidencias['concepto_evidencia7']        = $concepto_evidencia7;
                        $evidencias['concepto_evidencia8']        = $concepto_evidencia8;
                        $evidencias['concepto_evidencia9']        = $concepto_evidencia9;
                        $evidencias['concepto_evidencia10']       = $concepto_evidencia10;
                        $evidencias['porcentaje_evidencia1']      = $porcentaje_evidencia1;
                        $evidencias['porcentaje_evidencia2']      = $porcentaje_evidencia2;
                        $evidencias['porcentaje_evidencia3']      = $porcentaje_evidencia3;
                        $evidencias['porcentaje_evidencia4']      = $porcentaje_evidencia4;
                        $evidencias['porcentaje_evidencia5']      = $porcentaje_evidencia5;
                        $evidencias['porcentaje_evidencia6']      = $porcentaje_evidencia6;
                        $evidencias['porcentaje_evidencia7']      = $porcentaje_evidencia7;
                        $evidencias['porcentaje_evidencia8']      = $porcentaje_evidencia8;
                        $evidencias['porcentaje_evidencia9']      = $porcentaje_evidencia9;
                        $evidencias['porcentaje_evidencia10']     = $porcentaje_evidencia10;
                        $evidencias['porcentaje_total']           = $porcentajeTotal;

                        $evidencias->save();
                    }
                } else {
                    // Se ejecuta si solo es un mes, es decir si no se da la opcion de meses restantes
                    Secundaria_grupos_evidencias::create([
                        'secundaria_grupo_id'          => $secundaria_grupo_id,
                        'secundaria_mes_evaluacion_id' => $secundaria_mes_evaluacion_id,
                        'numero_evidencias'          => $numero_evidencias,
                        'concepto_evidencia1'        => $concepto_evidencia1,
                        'concepto_evidencia2'        => $concepto_evidencia2,
                        'concepto_evidencia3'        => $concepto_evidencia3,
                        'concepto_evidencia4'        => $concepto_evidencia4,
                        'concepto_evidencia5'        => $concepto_evidencia5,
                        'concepto_evidencia6'        => $concepto_evidencia6,
                        'concepto_evidencia7'        => $concepto_evidencia7,
                        'concepto_evidencia8'        => $concepto_evidencia8,
                        'concepto_evidencia9'        => $concepto_evidencia9,
                        'concepto_evidencia10'       => $concepto_evidencia10,
                        'porcentaje_evidencia1'      => $porcentaje_evidencia1,
                        'porcentaje_evidencia2'      => $porcentaje_evidencia2,
                        'porcentaje_evidencia3'      => $porcentaje_evidencia3,
                        'porcentaje_evidencia4'      => $porcentaje_evidencia4,
                        'porcentaje_evidencia5'      => $porcentaje_evidencia5,
                        'porcentaje_evidencia6'      => $porcentaje_evidencia6,
                        'porcentaje_evidencia7'      => $porcentaje_evidencia7,
                        'porcentaje_evidencia8'      => $porcentaje_evidencia8,
                        'porcentaje_evidencia9'      => $porcentaje_evidencia9,
                        'porcentaje_evidencia10'     => $porcentaje_evidencia10,
                        'porcentaje_total'           => $porcentajeTotal
                    ]);
                }
            }

            alert('Escuela Modelo', 'Los datos para la evidencia se han agregado con éxito', 'success')->showConfirmButton()->autoClose(3000);;
            return back();
        }
    }

    public function getEvidencias(Request $request, $id_grupo, $id_mes)
    {
        if ($request->ajax()) {

            $evidencias = Secundaria_grupos_evidencias::select('secundaria_grupos_evidencias.*')
                ->where('secundaria_grupo_id', $id_grupo)
                ->where('secundaria_mes_evaluacion_id', $id_mes)
                ->get();

            return response()->json($evidencias);
        }
    }

    public function getGrupos(Request $request, $id)
    {
        $usuarioLogueado = auth()->user()->id;

        if ($request->ajax()) {

            if ($usuarioLogueado == 163) {
                $grupos = Secundaria_grupos::select(
                    'secundaria_grupos.id',
                    'secundaria_grupos.secundaria_materia_id',
                    'secundaria_materias.matNombre',
                    'secundaria_materias.matSemestre',
                    'secundaria_grupos.plan_id',
                    'secundaria_grupos.periodo_id',
                    'secundaria_grupos.gpoGrado',
                    'secundaria_grupos.gpoClave',
                    'secundaria_grupos.gpoTurno',
                    'secundaria_grupos.empleado_id_docente',
                    'secundaria_empleados.empNombre',
                    'secundaria_empleados.empApellido1',
                    'secundaria_empleados.empApellido2',
                    'secundaria_grupos.empleado_id_auxiliar',
                    'empleados.empNombre as empNombre_aux',
                    'empleados.empApellido1 as empApellido1_aux',
                    'empleados.empApellido2 as empApellido2_aux',
                    'secundaria_grupos.gpoMatComplementaria',
                    'secundaria_grupos.nombreAlternativo',
                    'periodos.perFechaInicial',
                    'periodos.perFechaFinal',
                    'programas.progNombre'
                )
                    ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                    ->join('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
                    ->leftJoin('secundaria_empleados as empleados', 'secundaria_grupos.empleado_id_auxiliar', '=', 'empleados.id')
                    ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
                    ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('secundaria_grupos.periodo_id', '=', $id)
                    ->get();
            } else {
                $grupos = Secundaria_grupos::select(
                    'secundaria_grupos.id',
                    'secundaria_grupos.secundaria_materia_id',
                    'secundaria_materias.matNombre',
                    'secundaria_materias.matSemestre',
                    'secundaria_grupos.plan_id',
                    'secundaria_grupos.periodo_id',
                    'secundaria_grupos.gpoGrado',
                    'secundaria_grupos.gpoClave',
                    'secundaria_grupos.gpoTurno',
                    'secundaria_grupos.empleado_id_docente',
                    'secundaria_empleados.empNombre',
                    'secundaria_empleados.empApellido1',
                    'secundaria_empleados.empApellido2',
                    'secundaria_grupos.empleado_id_auxiliar',
                    'empleados.empNombre as empNombre_aux',
                    'empleados.empApellido1 as empApellido1_aux',
                    'empleados.empApellido2 as empApellido2_aux',
                    'secundaria_grupos.gpoMatComplementaria',
                    'secundaria_grupos.nombreAlternativo',
                    'periodos.perFechaInicial',
                    'periodos.perFechaFinal',
                    'programas.progNombre'
                )
                    ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                    ->join('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
                    ->leftJoin('secundaria_empleados as empleados', 'secundaria_grupos.empleado_id_auxiliar', '=', 'empleados.id')
                    ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
                    ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('secundaria_grupos.periodo_id', '=', $id)
                    ->where('secundaria_grupos.empleado_id_docente', '=', $usuarioLogueado)
                    ->get();
            }
            return response()->json($grupos);
        }
    }

    public function getMaterias(Request $request, $id)
    {
        $usuarioLogueado = auth()->user()->id;

        if ($request->ajax()) {
            if ($usuarioLogueado == 163) {
                $grupos = Secundaria_grupos::select(
                    'secundaria_grupos.id',
                    'secundaria_grupos.secundaria_materia_id',
                    'secundaria_materias.matNombre',
                    'secundaria_materias.matSemestre',
                    'secundaria_grupos.plan_id',
                    'secundaria_grupos.periodo_id',
                    'secundaria_grupos.gpoGrado',
                    'secundaria_grupos.gpoClave',
                    'secundaria_grupos.gpoTurno',
                    'secundaria_grupos.empleado_id_docente',
                    'secundaria_empleados.empNombre',
                    'secundaria_empleados.empApellido1',
                    'secundaria_empleados.empApellido2',
                    'secundaria_grupos.empleado_id_auxiliar',
                    'empleados.empNombre as empNombre_aux',
                    'empleados.empApellido1 as empApellido1_aux',
                    'empleados.empApellido2 as empApellido2_aux',
                    'secundaria_grupos.gpoMatComplementaria',
                    'secundaria_grupos.nombreAlternativo',
                    'periodos.perFechaInicial',
                    'periodos.perFechaFinal',
                    'programas.progNombre'
                )
                    ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                    ->join('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
                    ->leftJoin('secundaria_empleados as empleados', 'secundaria_grupos.empleado_id_auxiliar', '=', 'empleados.id')
                    ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
                    ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('secundaria_grupos.id', '=', $id)
                    ->get();
            } else {
                $grupos = Secundaria_grupos::select(
                    'secundaria_grupos.id',
                    'secundaria_grupos.secundaria_materia_id',
                    'secundaria_materias.matNombre',
                    'secundaria_materias.matSemestre',
                    'secundaria_grupos.plan_id',
                    'secundaria_grupos.periodo_id',
                    'secundaria_grupos.gpoGrado',
                    'secundaria_grupos.gpoClave',
                    'secundaria_grupos.gpoTurno',
                    'secundaria_grupos.empleado_id_docente',
                    'secundaria_empleados.empNombre',
                    'secundaria_empleados.empApellido1',
                    'secundaria_empleados.empApellido2',
                    'secundaria_grupos.empleado_id_auxiliar',
                    'empleados.empNombre as empNombre_aux',
                    'empleados.empApellido1 as empApellido1_aux',
                    'empleados.empApellido2 as empApellido2_aux',
                    'secundaria_grupos.gpoMatComplementaria',
                    'secundaria_grupos.nombreAlternativo',
                    'periodos.perFechaInicial',
                    'periodos.perFechaFinal',
                    'programas.progNombre'
                )
                    ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                    ->join('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
                    ->leftJoin('secundaria_empleados as empleados', 'secundaria_grupos.empleado_id_auxiliar', '=', 'empleados.id')
                    ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
                    ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->where('secundaria_grupos.id', '=', $id)
                    ->where('secundaria_grupos.empleado_id_docente', '=', $usuarioLogueado)
                    ->get();
            }

            return response()->json($grupos);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*           obtener los meses de evidencia dados de alta por grupo           */
    /* -------------------------------------------------------------------------- */
    public function getMesEvidencias(Request $request, $id)
    {

        if ($request->ajax()) {

            $mesEvidencia = Secundaria_grupos_evidencias::select(
                'secundaria_grupos_evidencias.id',
                'secundaria_grupos_evidencias.secundaria_grupo_id',
                'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id',
                'secundaria_mes_evaluaciones.mes',
                'secundaria_grupos.periodo_id'
            )
                ->join('secundaria_mes_evaluaciones', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', '=', 'secundaria_mes_evaluaciones.id')
                ->join('secundaria_grupos', 'secundaria_grupos_evidencias.secundaria_grupo_id', '=', 'secundaria_grupos.id')
                ->where('secundaria_grupos_evidencias.secundaria_grupo_id', '=', $id)
                ->where('secundaria_mes_evaluaciones.numero_evaluacion', '!=', 4)
                ->whereNull('secundaria_grupos_evidencias.deleted_at')
                ->orderBy('secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', 'ASC')
                ->get();


            return response()->json([
                'mesEvidencia' => $mesEvidencia
            ]);
        }
    }


    public function getMeses(Request $request, $id)
    {
        if ($request->ajax()) {

            $meses = Secundaria_grupos_evidencias::select(
                'secundaria_grupos_evidencias.id',
                'secundaria_grupos_evidencias.secundaria_grupo_id',
                'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id',
                'secundaria_mes_evaluaciones.mes'
            )
                ->join('secundaria_mes_evaluaciones', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', '=', 'secundaria_mes_evaluaciones.id')
                ->join('secundaria_grupos', 'secundaria_grupos_evidencias.secundaria_grupo_id', '=', 'secundaria_grupos.id')
                ->where('secundaria_grupos_evidencias.id', '=', $id)
                ->get();

            return response()->json($meses);
        }
    }

    public function getNumeroEvaluacion(Request $request, $mes)
    {
        if ($request->ajax()) {


            $numeroEvalucacion = Secundaria_grupos_evidencias::select(
                'secundaria_grupos_evidencias.*',
                'secundaria_mes_evaluaciones.*'
            )
                ->join('secundaria_mes_evaluaciones', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', '=', 'secundaria_mes_evaluaciones.id')
                // ->where('secundaria_mes_evaluaciones.mes', '=', $mes)
                ->where('secundaria_grupos_evidencias.id', '=', $mes)
                ->get();

            return response()->json($numeroEvalucacion);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $secundaria_inscritos = Secundaria_inscritos::where('grupo_id', '=', $id)->get();

        $secundaria_grupo = Secundaria_grupos::findOrFail($id);


        if (count($secundaria_inscritos) == "0") {
            try {

                if ($secundaria_grupo->delete()) {
                    alert('Escuela Modelo', 'El grupo se ha eliminado con éxito', 'success')->showConfirmButton();
                    return redirect()->route('primaria_grupo.index');
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el grupo')->showConfirmButton();
                    return redirect()->route('secundaria.secundaria_grupo.index');
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            }
        } else {
            alert('Escuela Modelo', 'No se puede eliminar este grupo debido que cuenta con alumnos inscritos', 'warning')->showConfirmButton();
            return redirect()->route('secundaria.secundaria_grupo.index');
        }
    }
}

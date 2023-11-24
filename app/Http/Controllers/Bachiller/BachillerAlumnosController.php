<?php

namespace App\Http\Controllers\Bachiller;

use Auth;
use App\clases\alumnos\MetodosAlumnos;
use App\clases\cgts\MetodosCgt;
use App\clases\departamentos\MetodosDepartamentos;
use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Alumno;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_actividades;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_conducta;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_desarrollo;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_familiares;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_habitos;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_heredo;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_medica;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_nacimiento;
use App\Models\Bachiller\Bachiller_alumnos_historia_clinica_sociales;
use App\Models\Bachiller\SecundariaProcedencia;
use App\Models\Baja;
use App\Models\Beca;
use App\Models\Candidato;
use App\Models\ConceptoBaja;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Estado;
use App\Models\MatriculaAnterior;
use App\Models\Minutario;
use App\Models\Municipio;
use App\Models\Pago;
use App\Models\Pais;
use App\Models\Persona;
use App\Models\PreparatoriaProcedencia;
use App\Models\Programa;
use App\Models\Tutor;
use App\Models\Ubicacion;
use App\Models\Modules;
use App\Models\Permission;
use App\Models\Permission_module_user;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use App\clases\SCEM\MailerBAC;
use App\Models\ListaNegra;
use App\Models\TutorAlumno;
use Illuminate\Support\Str;
use PDF;

class BachillerAlumnosController extends Controller
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

        $registroUltimoPago = Pago::where("pagFormaAplico", "=", "A")->latest()->first();
        $registroUltimoPago = Carbon::parse($registroUltimoPago->pagFechaPago)->day
        . "/" . Utils::num_meses_corto_string(Carbon::parse($registroUltimoPago->pagFechaPago)->month)
        . "/" . Carbon::parse($registroUltimoPago->pagFechaPago)->year;

        return view('bachiller.alumnos.show-list', [
            "registroUltimoPago" => $registroUltimoPago
        ]);
    }


    public function cambiarMatricula(Request $request)
    {
        $departamentos = Departamento::get();
        $alumno = Alumno::with('persona.municipio')->findOrFail($request->alumnoId);
        $planes = Curso::with("cgt.plan.programa")->where("cursos.alumno_id", "=", $request->alumnoId)->get()->unique("cgt.plan.id");


        if (User::permiso("alumno") == "A" || User::permiso("alumno") == "B" || User::permiso("alumno") == "E") {
            return view('bachiller.alumnos.cambiar-matricula-bachiller', compact('alumno', 'departamentos', "planes"));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(2000);
            return redirect('bachiller_alumno');
        }
    }


    public function postCambiarMatricula (Request $request)
    {
        $alumno = new Alumno;
        $alumno = $alumno->where("id", "=", $request->alumnoId)->first();
        $alumno->aluMatricula = $request->aluMatricula;
        $alumno->save();

        if ($alumno->save()) {
            $matriculasanteriores = new MatriculaAnterior();
            $matriculasanteriores->alumno_id = $request->alumnoId;
            $matriculasanteriores->matricNueva = $request->aluMatricula;
            $matriculasanteriores->matricAnterior = $request->matricAnterior;
            $matriculasanteriores->programa_id = $request->plan_id;
            $matriculasanteriores->save();

            alert('Escuela Modelo', 'La matrícula se ha actualizado con éxito', 'success')->showConfirmButton();
            return redirect('bachiller_alumno')->withInput();
        } else {
            alert()->error('Ups...', 'La matrícula no se ha actualizado correctamente')->showConfirmButton();
            return back();
        }
    }

    /**
     * Show alumno list.
     *
     */
    public function list()
    {
        $alumnos = DB::table('alumnos')
            ->select('alumnos.id as alumno_id','alumnos.aluClave','alumnos.aluEstado', 'alumnos.aluFechaIngr',
                'personas.perNombre','personas.perApellido1','personas.perApellido2',
                'personas.perTelefono1','personas.perCurp',
                'resumenacademico.resFechaBaja')
            ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->leftJoin('resumenacademico', 'alumnos.id','=','resumenacademico.alumno_id')
            ->distinct("alumnos.id")
            ->whereNull('alumnos.deleted_at')
            ->orderBy("alumnos.id", "desc");


        return DataTables::of($alumnos)
            ->filterColumn('perNombre', function($query, $keyword) {
                return $query->whereHas('persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
                });
            })
            ->editColumn('aluFechaIngr', static function($query) {
                return Carbon::parse($query->aluFechaIngr)->format('Y-m-d');
            })
            ->addColumn('perNombre', function($query) {
                return $query->perNombre;
            })
            ->filterColumn('perApellido1', function($query, $keyword) {
                return $query->whereHas('persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perApellido1', function($query) {
                return $query->perApellido1;
            })
            ->filterColumn('perApellido2', function($query, $keyword) {
                return $query->whereHas('persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perApellido2', function($query) {
                return $query->perApellido2;
            })

            ->addColumn('aluEstado', function($query) {
                switch ($query->aluEstado) {
                    case 'B':
                        return "BAJA";
                        break;
                    case 'R':
                        return "REGULAR";
                        break;
                    case 'E':
                        return "EGRESADO";
                        break;
                    case 'N':
                        return "NUEVO INGRESO";
                        break;
                }
            })
            ->filterColumn('aluEstado', function ($query, $keyword) {

                $estado = "";
                switch ($keyword) {
                    case 'BAJA':
                        $estado = "B";
                        break;
                    case 'REGULAR':
                        $estado = "R";
                        break;
                    case 'EGRESADO':
                        $estado = "E";
                        break;
                    case 'NUEVO INGRESO':
                        $estado = "N";
                        break;
                }

                return $query->where('aluEstado','=',$estado);
            })

            ->filterColumn('resFechaBaja', function ($query, $keyword) {
                return $query->where('resFechaBaja','like','%'.$keyword.'%');
            })
            ->addColumn('resFechaBaja', function ($query) {
                return ($query->resFechaBaja) ? $query->resFechaBaja : '';
            })
            ->addColumn('action', function($query) {
                $btnBorrar = "";
                $btnModificarEstatus = "";
                $btnHistorialPagos   = "";
                $btnAlumnoPagos = "";
                $btn_inscribirse_extraordinario = '';
                $btnEditar = "";
                $modalCursos = "";
                $btnPasswordChange = "";

                $user_log_sistemas = auth()->user()->departamento_sistemas;
                $user_log_cme = auth()->user()->campus_cme;
                $user_log_cva = auth()->user()->campus_cva;
                $user_log_cch = auth()->user()->campus_cch;


                $modalCursos = '<a href="#modalCursos-bachiller" data-alumno-id="' . $query->alumno_id . '" class="modal-trigger btn-modal-cursos-detalle-bachiller button button--icon js-button js-ripple-effect " title="Ver Cursos Detalle">
                        <i class="material-icons">dvr</i>
                    </a>';

                if (User::permiso("alumno") == "A") {
                    $btnBorrar = '<form id="delete_' . $query->alumno_id . '" action="bachiller_alumno/' . $query->alumno_id . '" method="POST" style="display:inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $query->alumno_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';

                    $btnModificarEstatus = '<a href="#modalEstatusAlumno-bachiller" data-alumno-id="'. $query->alumno_id . '" class="btn-modal-estatus-alumno modal-trigger button button--icon js-button js-ripple-effect" title="Cambiar Estatus Del Alumno">
                        <i class="material-icons">unarchive</i>
                    </a>';

                    $alumnoExiste = Alumno::join('users_alumnos', 'alumnos.aluClave', '=', 'users_alumnos.username')->where('aluClave', $query->aluClave)->first();
                    if ($alumnoExiste) {
                        $btnPasswordChange = '<a href="bachiller_alumno/change_password/' . $query->alumno_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar contraseña Del Alumno">
                            <i class="material-icons">lock</i>
                        </a>';
                    }
                }

                if ( Auth::user()->username == "DIONEDPENICHE" || Auth::user()->username == "REBECAR") {
                    $alumnoExiste = Alumno::join('users_alumnos', 'alumnos.aluClave', '=', 'users_alumnos.username')->where('aluClave', $query->aluClave)->first();
                    if ($alumnoExiste) {
                        $btnPasswordChange = '<a href="primaria_alumno/change_password/' . $query->alumno_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar contraseña Del Alumno">
                            <i class="material-icons">lock</i>
                        </a>';
                    }
                }

                if($user_log_sistemas == 1 || $user_log_cme == 1 || $user_log_cva == 1 || $user_log_cch == 1){
                    $btnEditar = '<a href="bachiller_alumno/' . $query->alumno_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                }
                if (User::permiso("alumno") == "A" || User::permiso("alumno") == "B" || User::permiso("alumno") == "C") {
                    $btnHistorialPagos = '<a href="#modalHistorialPagosAluBachiller" data-nombres="' . $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2 .
                        '" data-aluClave="' . $query->aluClave . '" data-alumno-id="'.$query->alumno_id.'" class="modal-trigger btn-modal-historial-pagos-bachiller button button--icon js-button js-ripple-effect" title="Historial Pagos">
                        <i class="material-icons">attach_money</i>
                    </a>';

                }

                return $modalCursos.'
                <a href="bachiller_alumno/' . $query->alumno_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                .$btnEditar
                . $btnHistorialPagos
                . $btnPasswordChange
                . $btnModificarEstatus
                . $btnBorrar;
            })
        ->make(true);
    }

    public function changePassword(Request $request, $alumno_id)
    {
        $alumno = Alumno::with('persona')->findOrFail($alumno_id);

        return view('bachiller.alumnos.change_password', compact('alumno'));
    }

    public function changePasswordUpdate(Request $request, $alumno_id)
    {
        $alumno = Alumno::select('users_alumnos.password', 'users_alumnos.id AS user_id')
            ->join('users_alumnos', 'alumnos.aluClave', '=', 'users_alumnos.username')
            ->where('alumnos.id', $alumno_id)
            ->first();

        $validator = Validator::make($request->all(), [
            'nuevo_password'          =>  'required|max:20',
            'nuevo_confirmPassword'   =>  'required|same:nuevo_password',
        ], [
            'nuevo_confirmPassword.same'     => 'Ambos campos de contraseña deben coincidir.',
            'nuevo_password.required'        => 'La contraseña nueva es requerida.',
            'nuevo_confirmPassword.required' => 'La contraseña de verificación es requerida.'
        ]);
  
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        DB::update("UPDATE users_alumnos SET password='".$request->nuevo_password."' WHERE id=$alumno->user_id");
        
        alert('Escuela Modelo', 'Contraseña guardada correctamente', 'success')->showConfirmButton();
        return redirect()->back();
    }


    public function secundariaProcedencia (Request $request)
    {
        return SecundariaProcedencia::where("municipio_id", "=", $request->municipio_id)
            ->where("secHomologada", "=", "SI")
            ->orderBy("secNombre")
        ->get();
    }


    public function listHistorialPagosAluclave(Request $request, $aluClave) {

        $pagos = Pago::with('concepto')
        ->where('pagClaveAlu', $request->aluClave)->where('pagEstado', 'A')
        ->whereIn('pagConcPago', ["99", "01", "02", "03", "04", "05", "00", "06", "07", "08", "09", "10", "11", "12"])->get()
        ->sortByDesc(static function($pago, $key) {
            return $pago->pagAnioPer.' '.$pago->concepto->ordenReportes;
        });

        return DataTables::of($pagos)
        ->addColumn('conpNombre', static function(Pago $pago) {
            return $pago->pagConcPago.' '.$pago->concepto->conpNombre;
        })
        ->addColumn('pagImpPago', static function(Pago $pago) {
            return '$'.$pago->pagImpPago;
        })
        ->addColumn('pagFechaPago', static function(Pago $pago) {
            return Utils::fecha_string($pago->pagFechaPago, 'mesCorto');
        })->toJson();
    }//listHistorialPagosAluclave.


    public function preparatoriaProcedencia (Request $request)
    {
        return PreparatoriaProcedencia::where("municipio_id", "=", $request->municipio_id)
            ->where("prepHomologada", "=", "SI")
            ->orderBy("prepNombre")
        ->get();
    }
    
     /**
     * Show cgts semestre.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAlumnos(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        if($request->ajax()){
            $alumnos = Alumno::select('alumnos.id as alumno_id', 'alumnos.aluClave', 'alumnos.aluEstado',
                'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2', 'personas.perTelefono1')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->where('aluEstado', '!=', 'B')
                ->whereIn('aluEstado', ['E','R', 'N'])
            ->get();

            //$alumnos = Alumno::with('persona:id,perNombre,perApellido1,perApellido2')->where('aluEstado','!=','B')->where('aluEstado','!=','E')->get();
            return response()->json($alumnos);
        }
    }


    public function getMultipleAlumnosByFilter(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        if($request->ajax()){
            $alumnos = Alumno::with("persona")
                ->where('aluEstado', '!=', 'B')
                ->whereIn('aluEstado', ['E','R', 'N'])
                ->whereHas('persona', function($query) use ($request) {

                    if($request->nombreAlumno != ""){
                        $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"]);
                    }
                    
                });

            if ($request->aluClave) {
                $alumnos = $alumnos->where('aluClave', '=', $request->aluClave);
            }

            $alumnos = $alumnos->get();


            $listaNegra = ListaNegra::select('listanegra.*', 'personas.perSexo', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2')
            ->join('niveleslistanegra', 'listanegra.lnNivel', '=', 'niveleslistanegra.id')
            ->join('alumnos', 'listanegra.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            // ->where('niveleslistanegra.id', 4)
            ->where('alumnos.aluClave', $request->aluClave)
            ->first();

            if($listaNegra != ""){
                $restringido = true;
            }else{
                $restringido = true;
            }

            // if ($request->nombreAlumno) {

            //     $alumnos = $alumnos->whereHas('persona', function($query) use ($request) {
            //         $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"]);
            //     });                
            // }

            //$alumnos = Alumno::with('persona:id,perNombre,perApellido1,perApellido2')->where('aluEstado','!=','B')->where('aluEstado','!=','E')->get();
            return response()->json([
                'alumnos' => $alumnos,
                'restringido' => $restringido,
                'listaNegra' => $listaNegra
            ]);
        }
    }
    public function getAlumnosByFilter(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        if($request->ajax()){
            $alumnos = Alumno::select('alumnos.id as alumno_id', 'alumnos.aluClave', 'alumnos.aluEstado',
                'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2', 'personas.perTelefono1')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->where('aluEstado', '!=', 'B')
                ->whereIn('aluEstado', ['E','R', 'N'])
                ->whereRaw("CONCAT(aluClave, ' ', perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"])
            ->first();

            //$alumnos = Alumno::with('persona:id,perNombre,perApellido1,perApellido2')->where('aluEstado','!=','B')->where('aluEstado','!=','E')->get();
            return response()->json($alumnos);
        }
    }

    public function getAlumnoByClave(Request $request, $aluClave)
    {
        $alumno = Alumno::with('persona')->where('aluClave', $aluClave)
        ->where('aluEstado', '<>', 'B')
        ->whereIn('aluEstado', ['E', 'R', 'N'])->first();
        if($request->ajax()) {
            return response()->json($alumno);
        }
    }

    public function getAlumnoById(Request $request)
    {
        if($request->ajax()){
            $alumno = Alumno::with("persona.municipio.estado.pais", "preparatoria.municipio.estado.pais")->where('id', '=', $request->alumnoId)->first();
            return response()->json($alumno);
        }
    }

    public function conceptosBaja(Request $request)
    {
        $conceptoBaja = ConceptoBaja::all();
        return response()->json($conceptoBaja);
    }

    public function cambiarEstatusAlumno(Request $request)
    {
        $alumnoId = $request->alumnoId;
        $aluEstado = $request->aluEstado;

        $alumno = Alumno::where("id", "=", $alumnoId)->first();

        $curso = Curso::with(['cgt.plan.programa.escuela.departamento.ubicacion','periodo'])->where('alumno_id',$alumno->id)
        ->where('curEstado','<>','B')->latest('curFechaRegistro')->first();
        //Si se selecciona baja se creará o actualizará el alumno en resumen académico
        if($aluEstado == 'B'){
            if(!is_null($curso)){

                    try {
                        Baja::create([
                            'curso_id'             => $curso->id,
                            'bajTipoBeca'          => $curso->curTipoBeca ? $curso->curTipoBeca: "",
                            'bajPorcentajeBeca'    => $curso->curPorcentajeBeca,
                            'bajObservacionesBeca' => $curso->curObservacionesBeca,
                            'bajFechaRegistro'     => $curso->curFechaRegistro,
                            'bajFechaBaja'         => $request->resFechaBaja,
                            'bajEstadoCurso'       => $curso->curEstado,
                            'bajBajaTotal'         => 'C',
                            'bajRazonBaja'         => $request->conceptosBaja,
                            'bajObservaciones'     => $request->resObservaciones,
                        ]);

                        // alert('Escuela Modelo', 'Alumno dado de baja con éxito','success')->showConfirmButton();
                        // return back();
                    } catch (QueryException $e) {
                        $errorCode = $e->errorInfo[1];
                        $errorMessage = $e->errorInfo[2];
                        alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();

                        return back()->withInput();
                    }
            }else{
                return response()->json(["res" => 0 , "msg" => "El alumno no esta registrado a un curso."]);
            }


        }

        if (!$alumno->aluClave) {
            return response()->json(["res" => 0 , "msg" => "No se puede cambiar estatus del alumno porque no existe clave de pago. Favor de crear un nuevo alumno."]);
        }

        if ($alumno->aluEstado == "E" && $aluEstado == "B") {
            return response()->json(["res" => 0, "msg" => "no se puede dar de baja a un alumno egresado."]);
        }

        $res = Alumno::where("id", "=", $alumnoId)->update(['aluEstado' => $aluEstado]);

        return response()->json(["res" => $res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $departamentos = Departamentos::buscarSoloAcademicos(1, ['SUP', 'POS', 'DIP', 'PRE', 'PRI'])->unique("depClave");
        $departamentos = MetodosDepartamentos::buscarSoloAcademicos(1, ['BAC'])->unique("depClave");

        $paises = Pais::get();

        $mostrarColuman = false;

        return view('bachiller.alumnos.create', compact('departamentos', 'paises', 'mostrarColuman'));
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

        $fechaActual = Carbon::now('CDT')->format('Y-m-d');
        $esCurpValida = "accepted";
        $perCurpValida = 'required|max:18|unique:personas';
        if ($request->paisId != "1") {
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }


        $alumno = Alumno::with("persona")
            ->whereHas('persona', function ($query) use ($request) {
                if ($request->perCurp) {
                    $query->where('perCurp', $request->perCurp);
                }
            })
            ->first();

        $aluClave = "";
        if ($alumno) {
            $aluClave = $alumno->aluClave;
        }



        $validator = Validator::make(
            $request->all(),
            [
                'aluClave'      => 'unique:alumnos,aluClave,NULL,id,deleted_at,NULL',
                'persona_id'    => 'unique:alumnos,persona_id,NULL,id,deleted_at,NULL',
                'aluNivelIngr'  => 'required|max:4',
                'aluGradoIngr'  => 'required|max:4',
                'perNombre'     => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'  => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'  => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'       =>  $perCurpValida,
                'esCurpValida'  => $esCurpValida,
                'perFechaNac'   => 'required|before_or_equal:' . $fechaActual,
                'municipio_id'  => 'required',
                'perSexo'       => 'required',
                'perDirCP'      => 'max:5',
                'perDirCalle'   => 'max:25',
                'perDirNumExt'  => 'max:6',
                'perDirColonia' => 'max:60',
                'perCorreo1'    => 'nullable|email',
                // 'perTelefono2'  => 'required',
                // 'hisTutorOficial' => 'required',
                // 'hisParentescoTutor' => 'required',
                'secundaria_id' => 'required'
            
            ],
            [
                'aluClave.unique'   => "El alumno ya existe",
                'persona_id.unique' => "La persona ya existe",
                'perCurp.unique'    => "Ya existe registrado un alumno con esta misma clave CURP. "
                . "Favor de consultar los datos del alumno existente, con su clave registrada: "
                . $aluClave,
                'perCurp.max' => 'El campo de CURP no debe contener más de 18 caracteres',
                'esCurpValida.accepted' => 'La CURP proporcionada no es válida. Favor de verificarla.',
                'perCorreo1.email' => 'Debe proporcionar una dirección de correo válida, Favor de verificar.',
                'perFechaNac.before_or_equal' => 'La fecha de Nacimiento no puede ser mayor a la fecha actual.',

                'perFechaNac.required' => 'La fecha de nacimiento es obligatoria.',
                'aluNivelIngr.required' => 'El nivel de ingreso es obligatorio',
                'aluGradoIngr.required' => 'El grado de ingreso es obligatorio',
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'El apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'El apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'municipio_id.required' => 'El municipio es obligatorio',
                'perSexo.required' => 'El sexo es obligatorio',
                // 'perDirCP.required' => 'El codigo postal es obligatorio',
                // 'perDirCalle.required' => 'La calle del domicilio es obligatoria',
                // 'perDirNumExt.required' => 'El numero exterior del domicilio es obligatorio',
                // 'perDirColonia.required' => 'La colonia del domicilio es obligatoria',
                // 'perCorreo1.required' => 'El email es obligatorio',
                // 'perTelefono2.required' => 'El teléfono movil es obligatorio',
                'sec_tipo_escuela.required' => 'El campo Tipo de escuela es obligatorio',
                'sec_nombre_ex_escuela.required' => 'El campo Nombre escuela anterior es obligatorio',
                // 'hisTutorOficial.required' => 'El campo Nombre de la persona autirizada o legalmente responsable es obligatorio',
                // 'hisParentescoTutor.required' => 'El campo Parentesco legal es obligatorio',
                'secundaria_id.required' => "El campo secundaria de procedencia es obligatorio"



            ]
        );
        // return redirect ('alumno/create')->withErrors($validator)->withInput();

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $existeNombre = Persona::where("perApellido1", "=", $request->perApellido1)
        ->where("perApellido2", "=", $request->perApellido2)
        ->where("perNombre", "=", $request->perNombre)
        ->first();
        if ($existeNombre) {
            alert()->error('Ups ...', 'El nombre y apellidos coincide con nuestra base de datos. Favor de verificar que exista el alumno o empleado')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        $claveAlu = $this->generarClave($request->aluNivelIngr, $request->aluGradoIngr);
        $perCurp = $request->perCurp;
        if ($request->paisId != "1" && $request->perSexo == "M") {
            $perCurp = "XEXX010101MNEXXXA4";
        }
        if ($request->paisId != "1" && $request->perSexo == "F") {
            $perCurp = "XEXX010101MNEXXXA8";
        }

        DB::beginTransaction();
        try {
            $persona = Persona::create([
                'perCurp'        => $perCurp,
                'perApellido1'   => $request->perApellido1,
                'perApellido2'   => $request->perApellido2 ? $request->perApellido2 : "",
                'perNombre'      => $request->perNombre,
                'perFechaNac'    => $request->perFechaNac,
                'municipio_id'   => Utils::validaEmpty($request->municipio_id),
                'perSexo'        => $request->perSexo,
                'perCorreo1'     => $request->perCorreo1,
                'perTelefono1'   => $request->perTelefono1,
                'perTelefono2'   => $request->perTelefono2,
                'perDirCP'       => Utils::validaEmpty($request->perDirCP),
                'perDirCalle'    => $request->perDirCalle,
                'perDirNumInt'   => $request->perDirNumInt,
                'perDirNumExt'   => $request->perDirNumExt,
                'perDirColonia'  => $request->perDirColonia
            ]);

            if($request->preparatoria_id != ""){
                $prepa_id = $request->preparatoria_id;
            }else{
                $prepa_id = 0;
            }
            
            $alumno = Alumno::create([
                'persona_id'      => $persona->id,
                'aluClave'        => (int) $claveAlu,
                'aluNivelIngr'    => Utils::validaEmpty($request->aluNivelIngr),
                'aluGradoIngr'    => Utils::validaEmpty($request->aluGradoIngr),
                'aluMatricula'    => $request->aluMatricula,
                'preparatoria_id' => $prepa_id,
                'candidato_id'    => $request->candidato_id ? $request->candidato_id : null,
                'sec_tipo_escuela' => $request->sec_tipo_escuela,
                'sec_nombre_ex_escuela' => "",
                'secundaria_id' => $request->secundaria_id
            ]);

            //Validamos si existe eb la tabla de historia clinica 
            
            $bachiller_alumnos_historia_clinica_consulta = Bachiller_alumnos_historia_clinica::where('alumno_id', '=', $alumno->id)->first();
            if ($bachiller_alumnos_historia_clinica_consulta === null) {
                $bachiller_alumnos_historia_clinica = Bachiller_alumnos_historia_clinica::create([
                    'alumno_id' => $alumno->id,
                    'estatus_edicion' => "1"                   
                ]);

                Bachiller_alumnos_historia_clinica_actividades::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);

                Bachiller_alumnos_historia_clinica_conducta::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);


                Bachiller_alumnos_historia_clinica_desarrollo::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);

                Bachiller_alumnos_historia_clinica_familiares::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id,
                    'municipioMadre_id' => 0,
                    'municipioPadre_id' => 0
                ]);

                Bachiller_alumnos_historia_clinica_habitos::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);

                Bachiller_alumnos_historia_clinica_heredo::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);

                Bachiller_alumnos_historia_clinica_medica::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);

                Bachiller_alumnos_historia_clinica_nacimiento::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);

                Bachiller_alumnos_historia_clinica_sociales::create([
                    'historia_id' => $bachiller_alumnos_historia_clinica->id
                ]);


                //Recuperamos el registro y actualizamos desde aquí ya que en el create anteroir no se agrega 
                $bachiller_alumnos_historia_clinica_recupera = Bachiller_alumnos_historia_clinica::where('id', $bachiller_alumnos_historia_clinica->id)->first();
                DB::table('bachiller_alumnos_historia_clinica')
                        ->where('id', $bachiller_alumnos_historia_clinica_recupera->id)
                        ->update([
                            'hisTutorOficial' => $request->hisTutorOficial,
                            'hisParentescoTutor' => $request->hisParentescoTutor,
                            'hisCelularTutor' => $request->hisCelularTutor,
                            'hisCorreoTutor' => $request->hisCorreoTutor,
                            'hisCalleTutor' => $request->hisCalleTutor,
                            'hisNumeroExtTutor' => $request->hisNumeroExtTutor,
                            'hisNumeroIntTutor' => $request->hisNumeroIntTutor,
                            'hisColoniaTutor' => $request->hisColoniaTutor,
                            'hisCPTutor' => $request->hisCPTutor
                        ]);
                
            }

            if ($request->candidato_id) {
                $candidato = Candidato::findOrFail($request->candidato_id);
                $candidato->update([
                    "candidatoPreinscrito" => "SI",
                ]);
            }

            /* Si el alumno registrado se repite como candidato */
            $nosoymexicano = $request->noSoyMexicano ? $perCurp : $request->input('perCurp');
            DB::update("update candidatos c, personas p set  c.candidatoPreinscrito = 'SI' where c.perCurp = p.perCurp
            and c.perCurp <> 'XEXX010101MNEXXXA8' and c.perCurp <> 'XEXX010101MNEXXXA4' and LENGTH(ltrim(rtrim(c.perCurp))) > 0
            and p.deleted_at is null and p.perCurp = ?", [$nosoymexicano]);



            /*
            * Si existen tutores, se realiza la vinculación a este alumno.
            */
            if ($request->tutores) {
                $tutores = $request->tutores;
                $dataTutores = collect([]);
                foreach ($tutores as $key => $tutor) {
                    $tutor = explode('~', $tutor);
                    $tutNombre = $tutor[0];
                    $tutTelefono = $tutor[1];
                    $tutor = Tutor::where('tutNombre', 'like', '%' . $tutNombre . '%')
                        ->where('tutTelefono', $tutTelefono)->first();
                    if ($tutor) {
                        $dataTutores->push($tutor);
                    }
                }
                MetodosAlumnos::vincularTutores($dataTutores, $alumno);
            }

            if($request->tutor_id_edit != ""){
                if(count($request->tutor_id_edit) > 0){
                    $tutores_edit_id = $request->tutor_id_edit;
                    $tutNombreEdit = $request->tutNombreEdit;
                    $tutTelefonoEdit = $request->tutTelefonoEdit;
                    $tutCorreoEdit = $request->tutCorreoEdit;
    
                    $tutCalleEdit = $request->tutCalleEdit;
                    $tutColoniaEdit = $request->tutColoniaEdit;
                    $tutCodigoPostalEdit = $request->tutCodigoPostalEdit;
                    $tutPoblacionEdit = $request->tutPoblacionEdit;
                    $tutEstadoEdit = $request->tutEstadoEdit;
    
    
                    foreach($tutores_edit_id as $key => $tutorEditID) {
    
                        if($tutorEditID != "undefined"){
                            DB::update("UPDATE tutores SET 
                            tutNombre='".$tutNombreEdit[$key]."', 
                            tutTelefono='".$tutTelefonoEdit[$key]."', 
                            tutCalle='".$tutCalleEdit[$key]."', 
                            tutColonia='".$tutColoniaEdit[$key]."', 
                            tutCodigoPostal='".$tutCodigoPostalEdit[$key]."', 
                            tutPoblacion='".$tutPoblacionEdit[$key]."', 
                            tutEstado='".$tutEstadoEdit[$key]."', 
                            tutCorreo='".$tutCorreoEdit[$key]."' 
                            WHERE id=$tutorEditID");               
    
                        }
    
                    }
                }
            }

            

            

        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('bachiller_alumno/create')->withInput();
        }

        DB::commit(); #TEST.

        //datos para la vista de curso.create --------------------------------

        //OBTENER PERMISO DE USUARIO
        $user = Auth::user();
        $modulo = Modules::where('slug', 'curso')->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id', $modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;


        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $tiposIngreso =  [
            'PI' => 'PRIMER INGRESO',
            // 'RO' => 'REPETIDOR',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO',
            //     'EQ' => 'REVALIDACIÓN',
            //     'OY' => 'OYENTE',
            //     'XX' => 'OTRO',
        ];

        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();

        $campus = $request->campus;
        $departamento = $request->departamento;
        $programa = $request->programa;
        $programaData = Programa::where("id", "=", $programa)->first();

        $escuela = null;
        if ($programaData) {
            $escuela = $programaData->escuela->id;
        }


        $candidato = null;
        if ($request->candidato_id) {
            $candidato = Candidato::where("id", "=", $request->candidato_id)->first();
        }

        alert('Escuela Modelo', 'El Alumno se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
        return redirect('bachiller_alumno');

        // return view('bachiller.cursos.create', compact(
        //     'ubicaciones',
        //     'planesPago',
        //     'tiposIngreso',
        //     'tiposBeca',
        //     'estadoCurso',
        //     'permiso',
        //     'alumno',
        //     'campus',
        //     'departamento',
        //     'programa',
        //     'escuela',
        //     'candidato'
        // ));
    }//function store.

    private function generarClave($nivel,$grado)
    {
        $now = Carbon::now();
        $sufijo = sprintf("%04d",$this->nuevoSufijo());
        $añoActual = Str::substr($now->year, -2);

        // dd($nivel.$grado.$añoActual.$sufijo);
        return $grado.$nivel.$añoActual.$sufijo;
    }

    private function nuevoSufijo()
    {
        // // BLOQUEA LA TABLA
        DB::connection()->getpdo()->exec("LOCK TABLES clavepagosufijos WRITE");
        // AUMENTA EL PREFIJO
        DB::update("UPDATE clavepagosufijos SET cpsSufijo = cpsSufijo + 1 WHERE cpsIdentificador = 1");
        // VALIDA SI LLEGA A MIL LO REINICIA
        DB::update("UPDATE clavepagosufijos SET cpsSufijo = cpsSufijo % 10000 WHERE cpsIdentificador = 1");
        // SELECCIONA EL PREFIJO
        $sufijo = DB::table('clavepagosufijos')->first()->cpsSufijo;
        // DESBLOQUEA TABLA
        DB::connection()->getpdo()->exec("UNLOCK TABLES");

		return $sufijo;
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
        $departamentos = Departamento::get();
        $alumno = Alumno::with('persona')->findOrFail($id);
        $ultimoCurso = Curso::with('cgt.plan.programa')
        ->where('alumno_id', $alumno->id)->latest('curFechaRegistro')->first();

        $secundariaProcedencia = secundariaProcedencia::where("id", "=", $alumno->secundaria_id)->first();

        $bachiller_alumnos_historia_clinica_recupera = Bachiller_alumnos_historia_clinica::where('alumno_id', $id)->first();

        if($bachiller_alumnos_historia_clinica_recupera == ""){
            $hisTutorOficial = "";
            $hisParentescoTutor = "";
            $hisCelularTutor = "";
            $hisCorreoTutor = "";
            $hisCalleTutor = "";
            $hisNumeroExtTutor = "";
            $hisNumeroIntTutor = "";
            $hisColoniaTutor = "";
            $hisCPTutor = "";
        }else{
            $hisTutorOficial = $bachiller_alumnos_historia_clinica_recupera->hisTutorOficial;
            $hisParentescoTutor = $bachiller_alumnos_historia_clinica_recupera->hisParentescoTutor;
            $hisCelularTutor = $bachiller_alumnos_historia_clinica_recupera->hisCelularTutor;
            $hisCorreoTutor = $bachiller_alumnos_historia_clinica_recupera->hisCorreoTutor;
            $hisCalleTutor = $bachiller_alumnos_historia_clinica_recupera->hisCalleTutor;
            $hisNumeroExtTutor = $bachiller_alumnos_historia_clinica_recupera->hisNumeroExtTutor;
            $hisNumeroIntTutor = $bachiller_alumnos_historia_clinica_recupera->hisNumeroIntTutor;
            $hisColoniaTutor = $bachiller_alumnos_historia_clinica_recupera->hisColoniaTutor;
            $hisCPTutor = $bachiller_alumnos_historia_clinica_recupera->hisCPTutor;
        }

        
        $tutores = TutorAlumno::select('tutores.*')
        ->join('tutores', 'tutoresalumnos.tutor_id', '=', 'tutores.id')
        ->where('alumno_id', $alumno->id)
        ->get();

        // traemos los datos de las personas autorizadas para cualquier tramite
        $expediente = Bachiller_alumnos_historia_clinica::select('bachiller_alumnos_historia_clinica_familiares.famAutorizado1','bachiller_alumnos_historia_clinica_familiares.famAutorizado2')
        ->join('bachiller_alumnos_historia_clinica_familiares', 'bachiller_alumnos_historia_clinica.id', '=', 'bachiller_alumnos_historia_clinica_familiares.historia_id')
        ->where('bachiller_alumnos_historia_clinica.alumno_id', $id)
        ->first();

        // Validamos que la consulta no este vacia 
        if($expediente != ""){
            $personaAutorizada1 = $expediente->famAutorizado1;
            $personaAutorizada2 = $expediente->famAutorizado2;
        }else{
            $personaAutorizada1 = "";
            $personaAutorizada2 = "";
        }


        return view('bachiller.alumnos.show', compact('alumno', 'departamentos', 'secundariaProcedencia', 'ultimoCurso', 'hisTutorOficial', 'hisParentescoTutor',
    'hisCelularTutor', 'hisCorreoTutor', 'hisCalleTutor', 'hisNumeroExtTutor', 'hisNumeroIntTutor', 'hisColoniaTutor', 'hisCPTutor', 'tutores', 'personaAutorizada1', 'personaAutorizada2'));
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
        $paises = Pais::get();
        $departamentos = MetodosDepartamentos::buscarSoloAcademicos()->unique("depClave");
        $alumno = Alumno::with('persona.municipio.estado.pais')->findOrFail($id);
        $pais_id = $alumno->persona->municipio->estado->pais->id;
        $estado_id = $alumno->persona->municipio->estado->id;
        $estados = Estado::where('pais_id',$pais_id)->get();
        $municipios = Municipio::where('estado_id',$estado_id)->get();

        $secundariaProcedencia = SecundariaProcedencia::where("id", "=", $alumno->secundaria_id)->first();

        // recuperamos para mostrar los campos correspondientes 
        $bachiller_alumnos_historia_clinica = Bachiller_alumnos_historia_clinica::where('alumno_id', $id)->first();

        $secundaria_municipio_id = "";
        $secundaria_estado_id = "";
        $secundaria_pais_id = "";
        if ($secundariaProcedencia) {
            $secundaria_municipio_id = $secundariaProcedencia->municipio->id;
            $secundaria_estado_id    = $secundariaProcedencia->municipio->estado->id;
            $secundaria_pais_id      = $secundariaProcedencia->municipio->estado->pais->id;
        }

        // dd($secundaria_estado_id);

        if($bachiller_alumnos_historia_clinica == ""){
            $hisTutorOficial = "";
            $hisParentescoTutor = "";
            $hisCelularTutor = "";
            $hisCorreoTutor = "";
            $hisCalleTutor = "";
            $hisNumeroExtTutor = "";
            $hisNumeroIntTutor = "";
            $hisColoniaTutor = "";
            $hisCPTutor = "";
        }else{
            $hisTutorOficial = $bachiller_alumnos_historia_clinica->hisTutorOficial;
            $hisParentescoTutor = $bachiller_alumnos_historia_clinica->hisParentescoTutor;
            $hisCelularTutor = $bachiller_alumnos_historia_clinica->hisCelularTutor;
            $hisCorreoTutor = $bachiller_alumnos_historia_clinica->hisCorreoTutor;
            $hisCalleTutor = $bachiller_alumnos_historia_clinica->hisCalleTutor;
            $hisNumeroExtTutor = $bachiller_alumnos_historia_clinica->hisNumeroExtTutor;
            $hisNumeroIntTutor = $bachiller_alumnos_historia_clinica->hisNumeroIntTutor;
            $hisColoniaTutor = $bachiller_alumnos_historia_clinica->hisColoniaTutor;
            $hisCPTutor = $bachiller_alumnos_historia_clinica->hisCPTutor;


        }

        $preparatoriaProcedencia = PreparatoriaProcedencia::where("id", "=", $alumno->preparatoria_id)->first();

        $preparatoria_municipio_id = "";
        $preparatoria_estado_id = "";
        $preparatoria_pais_id = "";
        if ($preparatoriaProcedencia) {
            $preparatoria_municipio_id = $preparatoriaProcedencia->municipio->id;
            $preparatoria_estado_id    = $preparatoriaProcedencia->municipio->estado->id;
            $preparatoria_pais_id      = $preparatoriaProcedencia->municipio->estado->pais->id;
        }

        $mostrarColuman = true;

        $tutores = Tutor::whereNull('deleted_at')->get();

        if (User::permiso("alumno") == "A" || User::permiso("alumno") == "B" || User::permiso("alumno") == "C" || User::permiso("alumno") == "E") {
            return view('bachiller.alumnos.edit', compact(
                'alumno', 'departamentos', 'paises', 'estados', 'municipios', 'estado_id',
                'secundaria_municipio_id', 'secundaria_estado_id', 'secundaria_pais_id', 'hisTutorOficial', 'hisParentescoTutor', 'secundariaProcedencia',
            'hisCelularTutor', 'hisCorreoTutor', 'hisCalleTutor', 'hisNumeroExtTutor', 'hisNumeroIntTutor', 'hisColoniaTutor', 'hisCPTutor', 'preparatoria_municipio_id',
        'preparatoria_estado_id', 'preparatoria_pais_id', 'mostrarColuman', 'tutores'));
        }

        alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        return redirect()->route('bachiller.bachiller_alumno.index');
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

        // dd($request->preparatoria_id);

        $esCurpValida = "accepted";
        $perCurpValida = 'required|max:18|unique:personas';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) {// si pais es diferente de mexico
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }

        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8" )) {
            $esCurpValida = "accepted";
            $perCurpValida = 'required|max:18|unique:personas';
        }


        $validator = Validator::make($request->all(), [
            // 'aluNivelIngr' => 'required|max:4',
            // 'aluGradoIngr' => 'required|max:4',
            'perNombre' => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
            'perApellido1'  => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
            'perApellido2'  => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
            'perCurp'   => $perCurpValida,
            'esCurpValida' => $esCurpValida,
            'perFechaNac'   => 'required',
            'municipio_id' => 'required',
            'perSexo'   => 'required',
            // 'perDirCP'  => 'required|max:5',
            // 'perDirCalle'   => 'required|max:25',
            // 'perDirNumExt'  => 'required|max:6',
            // 'perDirColonia' => 'required|max:60',
            'perCorreo1' => 'nullable|email',
            'perTelefono2' => 'nullable',
            // 'hisTutorOficial' => 'required',
            // 'hisParentescoTutor' => 'required',
            'secundaria_id' => 'required'


            // 'sec_tipo_escuela' => 'required',
            // 'sec_nombre_ex_escuela' => 'required'
        ], [
            // 'aluNivelIngr.required' => 'El nivel de ingreso es obligatorio',
            // 'aluGradoIngr.required' => 'El grado de ingreso es obligatorio',
            'perNombre.required' => 'El nombre es obligatorio',
            'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            'perApellido1.required' => 'El apellido paterno es obligatorio',
            'perApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            'perApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            'perFechaNac.required' => 'La fecha de nacimiento es obligatoria.',
            'municipio_id.required' => 'El municipio es obligatorio',
            'perSexo.required' => 'El sexo es obligatorio',
            'perTelefono2.required' => 'El teléfono móvil es obligatorio',
            'perCorreo1.email' => 'Debe proporcionar una dirección de correo válida, Favor de verificar.',
            // 'sec_tipo_escuela.required' => 'El campo Tipo de escuela es obligatorio',
            // 'sec_nombre_ex_escuela.required' => 'El campo Nombre escuela anterior es obligatorio'
            // 'hisTutorOficial.required' => 'El campo Nombre de la persona autirizada o legalmente responsable es obligatorio',
            // 'hisParentescoTutor.required' => 'El campo Parentesco legal es obligatorio',
            'secundaria_id.required' => 'El campo Secundaria procedencia es obligatorio'



        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }


        $perCurp = $request->perCurp;
        if ($request->paisId != "1" && $request->perSexo == "M") {
            $perCurp = "XEXX010101MNEXXXA4";
        }
        if ($request->paisId != "1" && $request->perSexo == "F") {
            $perCurp = "XEXX010101MNEXXXA8";
        }

        if ($request->perCurp != "") {
            $perCurp = $request->perCurp;
        }

        DB::beginTransaction();
        try {
            

            $alumno = Alumno::with('persona')->findOrFail($id);
            $persona = $alumno->persona;
           
            

            $persona->update([
                'perCurp'       => $perCurp,
                'perApellido1'  => $request->perApellido1,
                'perApellido2'  => $request->perApellido2 ? $request->perApellido2: "",
                'perNombre'     => $request->perNombre,
                'perFechaNac'   => $request->perFechaNac,
                'municipio_id'  => Utils::validaEmpty($request->municipio_id),
                'perSexo'       => $request->perSexo,
                'perCorreo1'    => $request->perCorreo1,
                'perTelefono1'  => $request->perTelefono1,
                'perTelefono2'  => $request->perTelefono2,
                'perDirCP'      => Utils::validaEmpty($request->perDirCP),
                'perDirCalle'   => $request->perDirCalle,
                'perDirNumInt'  => $request->perDirNumInt,
                'perDirNumExt'  => $request->perDirNumExt,
                'perDirColonia' => $request->perDirColonia
            ]);

            if($request->preparatoria_id != ""){
                $prepa_id = $request->preparatoria_id;
            }else{
                $prepa_id = 0;
            }
            
            $alumno->update([
                // 'aluNivelIngr'    => Utils::validaEmpty($request->aluNivelIngr),
                // 'aluGradoIngr'    => Utils::validaEmpty($request->aluGradoIngr),
                // 'aluMatricula'    => $request->aluMatricula,
                'preparatoria_id' => $prepa_id,
                'sec_tipo_escuela' => $request->sec_tipo_escuela,
                'sec_nombre_ex_escuela' => "",
                'secundaria_id'=> $request->secundaria_id
            ]);
            if ($request->aluMatricula) {
                $alumno->update([
                    'aluMatricula'    => $request->aluMatricula,
                ]);

            }
            
            

            /*
            * Si existen tutores, se realiza la vinculación a este alumno.
            */
            if($request->tutores) {
                $tutores = $request->tutores;
                $dataTutores = collect([]);
                foreach($tutores as $key => $tutor) {
                    $tutor = explode('~', $tutor);
                    $tutNombre = $tutor[0];
                    $tutTelefono = $tutor[1];
                    $tutor = Tutor::where('tutNombre','like', '%'.$tutNombre.'%')
                        ->where('tutTelefono', $tutTelefono)->first();
                    if($tutor) {
                        $dataTutores->push($tutor);
                    }
                }
                MetodosAlumnos::vincularTutores($dataTutores->unique('id'), $alumno);


                 // editamos los datos de los tutores 
                    // if($request->tutor_id_edit != ""){
                        if(count($request->tutor_id_edit) > 0){
                            $tutores_edit_id = $request->tutor_id_edit;
                            $tutNombreEdit = $request->tutNombreEdit;
                            $tutTelefonoEdit = $request->tutTelefonoEdit;
                            $tutCorreoEdit = $request->tutCorreoEdit;

                            $tutCalleEdit = $request->tutCalleEdit;
                            $tutColoniaEdit = $request->tutColoniaEdit;
                            $tutCodigoPostalEdit = $request->tutCodigoPostalEdit;
                            $tutPoblacionEdit = $request->tutPoblacionEdit;
                            $tutEstadoEdit = $request->tutEstadoEdit;

            
                            foreach($tutores_edit_id as $key => $tutorEditID) {

                                if($tutorEditID != "undefined"){
                                    DB::update("UPDATE tutores SET 
                                    tutNombre='".$tutNombreEdit[$key]."', 
                                    tutTelefono='".$tutTelefonoEdit[$key]."', 
                                    tutCalle='".$tutCalleEdit[$key]."', 
                                    tutColonia='".$tutColoniaEdit[$key]."', 
                                    tutCodigoPostal='".$tutCodigoPostalEdit[$key]."', 
                                    tutPoblacion='".$tutPoblacionEdit[$key]."', 
                                    tutEstado='".$tutEstadoEdit[$key]."', 
                                    tutCorreo='".$tutCorreoEdit[$key]."' 
                                    WHERE id=$tutorEditID");               

                                }
            
                            }
                        }
                    // }
            }

           
            

            $bachiller_alumnos_historia_clinica = Bachiller_alumnos_historia_clinica::where('alumno_id', $id)->first();

            if($bachiller_alumnos_historia_clinica != ""){
                DB::table('bachiller_alumnos_historia_clinica')
                ->where('id', $bachiller_alumnos_historia_clinica->id)
                ->update([
                    'hisTutorOficial' => $request->hisTutorOficial,
                    'hisParentescoTutor' => $request->hisParentescoTutor,
                    'hisCelularTutor' => $request->hisCelularTutor,
                    'hisCorreoTutor' => $request->hisCorreoTutor,
                    'hisCalleTutor' => $request->hisCalleTutor,
                    'hisNumeroExtTutor' => $request->hisNumeroExtTutor,
                    'hisNumeroIntTutor' => $request->hisNumeroIntTutor,
                    'hisColoniaTutor' => $request->hisColoniaTutor,
                    'hisCPTutor' => $request->hisCPTutor
                ]);
            }else{
                $crear_historico = Bachiller_alumnos_historia_clinica::create([
                    'alumno_id' => $alumno->id,
                    'hisTutorOficial' => $request->hisTutorOficial,
                    'hisParentescoTutor' => $request->hisParentescoTutor,
                    'hisCelularTutor' => $request->hisCelularTutor,
                    'hisCorreoTutor' => $request->hisCorreoTutor,
                    'hisCalleTutor' => $request->hisCalleTutor,
                    'hisNumeroExtTutor' => $request->hisNumeroExtTutor,
                    'hisNumeroIntTutor' => $request->hisNumeroIntTutor,
                    'hisColoniaTutor' => $request->hisColoniaTutor,
                    'hisCPTutor' => $request->hisCPTutor
                ]);
            }


            
            


        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('bachiller_alumno/' . $id . '/edit')->withInput();
        }

        DB::commit();

        $alumno = Alumno::select('alumnos.id',
        'alumnos.aluClave',
        'alumnos.aluEstado',
        'personas.perApellido1',
        'personas.perApellido2',
        'personas.perNombre',
        'personas.perCurp')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('alumnos.id', '=', $id)
        ->first();

        $this->notificar_actualizacion_alumno($alumno);


        alert()->success('Actualizado', 'Se ha actualizado correctamente la información del alumno.')->showConfirmButton();
        return back();

    }//update.

    public function notificar_actualizacion_alumno(Alumno $alumno)
	{

		$this->mail = new MailerBAC([
			'username_email' => 'alumnoSCEM@modelo.edu.mx', // 'alumnos@unimodelo.com',
			'password_email' => 'YYxow691', // 'YYxow691',
			'to_email' => 'luislara@modelo.edu.mx',
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'Importante! Se ha realizado la actualización de datos',
			'body' => $this->armar_mensaje_de_notificacion_update($alumno)

		]);

        $usuario = auth()->user();

		// $director_campus = '';
		// $coordinador_secretaria_academica = '';
		

		if($usuario->campus_cch == 1) {
			$this->mail->agregar_destinatario('rrios@modelo.edu.mx');
            $this->mail->agregar_destinatario('srivero@modelo.edu.mx');

		} else if($usuario->campus_cva == 1) {
			$this->mail->agregar_destinatario('amartinez@modelo.edu.mx');
            $this->mail->agregar_destinatario('jacastro@modelo.edu.mx');
			$this->mail->agregar_destinatario('yendy_vidal@modelo.edu.mx');

		} else if($usuario->campus_cme == 1) {

			$this->mail->agregar_destinatario('msauri@modelo.edu.mx');
            $this->mail->agregar_destinatario('a.aviles@modelo.edu.mx');
			$this->mail->agregar_destinatario('arubio@modelo.edu.mx');
			$this->mail->agregar_destinatario('lmontero@modelo.edu.mx');
		}


		
		$this->mail->enviar();
	}

	/**
	* @param App\Models\Baja
	*/
	private function armar_mensaje_de_notificacion_update($alumno)
	{
		$usuario = auth()->user();
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);
		$nombre_alumno = $alumno->perApellido1.' '.$alumno->perApellido2.' '.$alumno->perNombre;

        if($alumno->aluEstado == "R"){
            $estadoAlumno = "REINGRESO";
        }
        if($alumno->aluEstado == "B"){
            $estadoAlumno = "BAJA";
        }
        if($alumno->aluEstado == "N"){
            $estadoAlumno = "NUEVO INGRESO";
        }
        if($alumno->aluEstado == "E"){
            $estadoAlumno = "EGRESADO";
        }
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

		return "<p>{$nombre_empleado} ({$usuario->username}) ha realizado la actualización de datos del siguiente alumno:</p>
		<br>
		<p><b>Clave de pago: </b> {$alumno->aluClave}</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>	
        <p><b>CURP: </b> {$alumno->perCurp}</p>	
        <p><b>Estado del alumno: </b> {$estadoAlumno}</p>		
		<p><b>Fecha de actualización: </b> ".Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto')."</p>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
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
        $alumno = Alumno::with('persona')->findOrFail($id);
        try {
            if (User::permiso("alumno") == "A" || User::permiso("alumno") == "B") {
                if ($alumno->delete()) {
                    alert('Escuela Modelo', 'El alumno se ha eliminado con éxito','success');
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el alumno')->showConfirmButton();
                }
            } else {
                alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
                return redirect('bachiller_alumno');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('bachiller_alumno');
    }


    public function buenaConducta(Request $request, $id)
    {

        $curso = Curso::with('alumno.persona', 'periodo', 'cgt.plan.programa.escuela.departamento.ubicacion.municipio.estado')->where("cursos.alumno_id", "=", $id)->where("cursos.curEstado", "=", "R")->first();
        if(!$curso){
            alert()->error('Error...', " El alumno no se encuentra registrado en un curso.")->showConfirmButton();
            return back()->withInput();
        }
        if($curso->alumno->aluEstado == 'B' ){
            alert()->error('Error...', " El alumno esta dado de baja.")->showConfirmButton();
            return back()->withInput();
        }
        $pago = Pago::where('pagClaveAlu',$curso->alumno->aluClave)->where('pagAnioPer',$curso->periodo->perAnioPago)
            ->where(function($query){
                $query->where('pagConcPago','00')->orWhere('pagConcPago','99');
            })->first();

        //dd($pago);

        if(!$pago){
            alert()->error('Error...', " El alumno no ha pagado su inscripción.")->showConfirmButton();
            return back()->withInput();
        }
        $minutario = Minutario::select('id')->where('minClavePago',$curso->alumno->aluClave)->where('minTipo','CB')->first();
        $departamento = Departamento::select('depTituloDoc','depNombreDoc','depPuestoDoc','depNombreOficial')->where('id',$curso->periodo->departamento->id)->first();

        if($minutario ==  NULL){

            $minutario = Minutario::create([
                "minAnio"         => $curso->periodo->perAnioPago,
                "minClavePago"    => $request->aluClave,
                "minDepartamento" => $curso->periodo->departamento->depClave,
                "minTipo"         => "CB",
                "minFecha"        => Carbon::now()->format("Y-m-d"),
            ]);
        }

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $nombreArchivo = 'pdf_buena_conducta';
        $pdf = PDF::loadView('reportes.pdf.bachiller.'. $nombreArchivo, [

            "curso" => $curso,
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $fechaActual->toTimeString(),
            "nombreArchivo" => $nombreArchivo,
            "departamento" => $departamento,
            "minutario" => $minutario,
            "perAnio" => $curso->periodo->perAnio
            /*
            "nombreArchivo" => $nombreArchivo,
            "aluEstado" => $request->aluEstado,
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $fechaActual->toTimeString()
            */
        ]);


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
        return redirect('bachiller_alumno');
    }


    public function buscarTutor($tutNombre, $tutTelefono) {
        $tutor = Tutor::where('tutNombre','like','%'.$tutNombre.'%')
            ->where('tutTelefono', $tutTelefono)->first();

        return json_encode($tutor);
    }//buscarTutor.


    public function crearTutor(Request $request){
        $datos = $request->datos;
        $tutor = Tutor::where('tutNombre','like','%'.$datos['tutNombre'].'%')
                  ->where('tutTelefono',$datos['tutTelefono'])->first();

        if(!$tutor){
            DB::beginTransaction();
            try {
                $tutor = Tutor::create([
                    'tutNombre' => $datos['tutNombre'],
                    'tutCalle' => $datos['tutCalle'],
                    'tutColonia' => $datos['tutColonia'],
                    'tutCodigoPostal' => $datos['tutCodigoPostal'],
                    'tutPoblacion' => $datos['tutPoblacion'],
                    'tutEstado' => $datos['tutEstado'],
                    'tutTelefono' => $datos['tutTelefono'],
                    'tutCorreo' => $datos['tutCorreo']
                ]);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

            DB::commit();
            return json_encode($tutor);

        }else{
            return json_encode(null);
        }

    }//crearTutor.

    public function tutores_alumno($id) {
        $alumno = Alumno::findOrFail($id);
        // $tutores = $alumno->tutores()->get()
        //     ->map(static function ($item, $key) {
        //         return $item->tutor;
        //     });

        $tutores = TutorAlumno::select('tutoresalumnos.id as tutorAlumno_id',
        'tutores.*')
        ->leftJoin('tutores', 'tutoresalumnos.tutor_id', '=', 'tutores.id')
        ->where('tutoresalumnos.alumno_id', $alumno->id)
        ->get();

        return json_encode($tutores);
    }//tutores_alumno.

    public function verificarExistenciaPersona(Request $request) {

        $alumno = MetodosPersonas::existeAlumno($request);
        $empleado = MetodosPersonas::existeEmpleado($request);

        $data = [
            'alumno' => $alumno,
            'empleado' => $empleado,
        ];

        if($request->ajax()){
            return json_encode($data);
        }else{
            return $data;
        }
    }//verificarExistenciaPersona.

    public function rehabilitarAlumno($alumno_id) {
        $alumno = Alumno::findOrFail($alumno_id);

        if($alumno->aluEstado == 'B') {
            $alumno->update([
                'aluEstado' => 'R'
            ]);
        }

        return json_encode($alumno);
    }//rehabilitarAlumno.

    public function empleado_crearAlumno(Request $request,$empleado_id){

        $validator = Validator::make($request->all(), [
                'aluClave'      => 'unique:alumnos,aluClave,NULL,id,deleted_at,NULL',
                'aluNivelIngr'  => 'required|max:4',
                'aluGradoIngr'  => 'required|max:4'
            ], [
                'aluClave.unique'   => "El alumno ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('bachiller_alumno/create')->withErrors($validator)->withInput();
        }

        $empleado = Empleado::findOrFail($empleado_id);
        $persona = $empleado->persona;

        $claveAlu = $this->generarClave($request->aluNivelIngr, $request->aluGradoIngr);
        DB::beginTransaction();
        try {
            $alumno = Alumno::create([
                'persona_id'      => $persona->id,
                'aluClave'        => (int) $claveAlu,
                'aluNivelIngr'    => Utils::validaEmpty($request->aluNivelIngr),
                'aluGradoIngr'    => Utils::validaEmpty($request->aluGradoIngr),
                'aluMatricula'    => $request->aluMatricula,
                'preparatoria_id' => $request->preparatoria_id
            ]);

            /*
            * Si existen tutores, se realiza la vinculación a este alumno.
            */
            if($request->tutores) {
                $tutores = $request->tutores;
                $dataTutores = collect([]);
                foreach($tutores as $key => $tutor) {
                    $tutor = explode('~', $tutor);
                    $tutNombre = $tutor[0];
                    $tutTelefono = $tutor[1];
                    $tutor = Tutor::where('tutNombre','like', '%'.$tutNombre.'%')
                        ->where('tutTelefono', $tutTelefono)->first();
                    $dataTutores->push($tutor);
                }
                MetodosAlumnos::vincularTutores($dataTutores, $alumno);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('bachiller_alumno/create')->withInput();
        }
        DB::commit(); #TEST.

        if($request->ajax()) {
            return json_encode($alumno);
        }else{
            return $alumno;
        }
    }//empleado_crearAlumno.

    /*
    * Creada para la vista curso.create.
    * retorna si el alumno tiene últimoCurso.
    */
    public function ultimoCurso(Request $request, $alumno_id) {

        $curso = Curso::with(['cgt.plan.programa.escuela.departamento.ubicacion', 'periodo'])
         ->where('alumno_id', $alumno_id)
         ->where('curEstado', '<>', 'B')
         ->latest('curFechaRegistro')
         ->first();

         $data = null;
         if($curso) {

            $cgtSiguiente = MetodosCgt::cgt_siguiente($curso->cgt);

            $data = [
                'curso' => $curso,
                'cgt' => $curso->cgt,
                'plan' => $curso->cgt->plan,
                'programa' => $curso->cgt->plan->programa,
                'escuela' => $curso->cgt->plan->programa->escuela,
                'departamento' => $curso->cgt->plan->programa->escuela->departamento,
                'ubicacion' => $curso->cgt->plan->programa->escuela->departamento->ubicacion,
                'periodo' => $curso->periodo,
                'periodoSiguiente' => $curso->cgt->plan->programa->escuela->departamento->periodoSiguiente,
                'cgtSiguiente' => $cgtSiguiente
            ];
         }
         return json_encode($data);
    }//ultimocCurso.


    public function quitarTutor(Request $request)
    {
        if($request->ajax()){


            $id = $request->input("id");

            $update = DB::update("UPDATE tutoresalumnos SET deleted_at=NOW() WHERE id=$id");

            if($update){
                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false
                ]);
            }
            

            


        }
    }

    public function vincularTutor(Request $request)
    {
        $alumno_id = $request->input("alumno_id");
        $tutor_id = $request->input("tutor_id");

        $buscamosRepetido = TutorAlumno::where('alumno_id', $alumno_id)->where('tutor_id', $tutor_id)
        ->whereNull('deleted_at')
        ->first();

        if($buscamosRepetido == ""){
            $alumnoTutor = TutorAlumno::create([
                'alumno_id' => $alumno_id,
                'tutor_id' => $tutor_id
            ]);

            if($alumnoTutor){
                return response()->json([
                    'res' => true,
                    'tutoralumno_id' => $alumnoTutor->id
                ]);
            }else{
                return response()->json([
                    'res' => false
                ]);
            }
        }else{
            return response()->json([
                'repetido' => true
            ]);
        }

    }

}

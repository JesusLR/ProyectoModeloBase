<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Models\Cgt;
use App\Http\Models\Plan;
use App\Http\Models\Curso;
use App\Http\Models\Grupo;
use App\Http\Helpers\Utils;
use App\Http\Models\Alumno;
use App\Http\Models\Historico;
use App\clases\historicos\MetodosHistoricos;
use App\clases\alumnos\MetodosAlumnos;

use Illuminate\Support\Str;
use App\Http\Models\Materia;
use App\Http\Models\Paquete;
use App\Http\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Models\Inscrito;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use App\Http\Models\Calificacion;
use App\Http\Models\Departamento;
use App\Http\Models\InscritosRechazados;
use App\Http\Models\Prerequisito;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Paquete_detalle;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\clases\SCEM\Mailer;
use App\clases\personas\MetodosPersonas;
use PHPMailer\PHPMailer\PHPMailer;

class InscritoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:inscrito',['except' => ['index','show','list']]);
        set_time_limit(8000000);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('inscrito.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $inscritos = Inscrito::select('inscritos.id as inscrito_id','alumnos.aluClave',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','periodos.perNumero',
            'periodos.perAnio','cgt.cgtGradoSemestre','grupos.gpoClave', 'materias.matClave','materias.matNombreOficial as matNombre', 
            'optativas.optClaveEspecifica', 'optativas.optNombre', 'planes.planClave',
            'programas.progClave','escuelas.escClave','departamentos.depClave','ubicacion.ubiClave')
        ->join('cursos', 'inscritos.curso_id', '=', 'cursos.id')
        ->join('grupos', 'inscritos.grupo_id', '=', 'grupos.id')
        ->join('materias', 'grupos.materia_id', '=', 'materias.id')
        ->leftJoin('optativas', 'optativas.id', '=', 'grupos.optativa_id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')

        ->latest('inscritos.created_at');

        $permiso = User::permiso("inscrito");


     


        return Datatables::of($inscritos)
            ->filterColumn('nombreCompleto',function($query,$keyword) {
                return $query->whereHas('curso.alumno.persona', function($query) use($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
            })
            ->addColumn('action',function($query) use ($permiso) {
                $btnCambiarGrupo = "";
                $btnCalificacionHistorial = "";

                if (in_array($permiso, ['C', 'A'])) {
                    $btnCambiarGrupo = '
                    <div class="col s1">
                        <a href="inscrito/cambiar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar grupo">
                            <i class="material-icons">sync_alt</i>
                        </a>
                    </div>';
                }

                if(in_array($permiso, ['A', 'B'])) {
                    $btnCalificacionHistorial = '
                    <div class="col s1">
                        <a href="inscrito/historial_cambios_calificacion/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Historial de cambios de calificación">
                            <i class="material-icons">format_list_numbered</i>
                        </a>
                    </div>';
                }

                return '<div class="row">
                <div class="col s1">
                    <a href="inscrito/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                    </a>
                </div>
                <div class="col s1">
                    <a href="inscrito/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>
                </div>
                <div class="col s1">
                    <form id="delete_' . $query->inscrito_id . '" action="inscrito/' . $query->inscrito_id . '" method="POST" style="display: inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>
                </div>'
                . $btnCambiarGrupo
                . $btnCalificacionHistorial
                . '</div>';
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
        $ubicaciones = Ubicacion::get();
        return view('inscrito.create',compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paquete()
    {
        $ubicaciones = Ubicacion::get();
        return view('inscrito.create_paquete',compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storePaquete(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'curso_id' => 'required',
                'paquete_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('create/paquete')->withErrors($validator)->withInput();
        }

        $hayAlumnosDeudores = false;
        try {
            $programa_id = $request->input('programa_id');

            if (Utils::validaPermiso('inscrito',$programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
                return redirect()->to('create/paquete');
            }

            $paquete_id = $request->paquete_id;
            $curso_id = $request->curso_id;

            $curso = Curso::with('alumno.persona')->where("id", "=", $curso_id)->whereNotIn("curEstado", ["B"])->first();
      
            if ($curso) {


                //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
                $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
                $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
                $programa = Programa::where("id", "=", $request->programa_id)->first();

                //HISTORICO DE ALUMNOS REPROBADOS
                $historicoList = self::buscarHistoricos($request);






                //INSCRIBE AL ALUMNO POR PAQUETE
                $paquetes = Paquete_detalle::with("grupo")->where('paquete_id', $paquete_id)->get();

                $alumnosSinDerechos = collect();

                foreach ($paquetes as $paq) {
                    $existeInscritoEnCurso = Inscrito::with("grupo")
                        ->where("curso_id", "=", $curso_id)
                        ->whereHas('grupo', function($query) use ($paq) {
                            $query->where('materia_id', $paq->grupo->materia_id);
                            $query->where('periodo_id', $paq->grupo->periodo_id);
                        })
                    ->first();


                    // $cursos = [$curso->id];
        
                    $alumnosSinDerecho = $this->postDesinscribirReprobados($curso->id, $historicoList, $paq->grupo_id);
                    $alumnosSinDerecho = $alumnosSinDerecho->unique();
                    $alumnosSinDerechos->push($alumnosSinDerecho);

        
                    $cursoSinDerecho = $alumnosSinDerecho->filter(function ($value, $key) use ($request) {
                        return $value->curso->id ==  $request->curso_id;
                    });
                    //FIN FILTRO TIENE DERECHO A INSCRIBIRSE A CURSOS

             
                    if (!$existeInscritoEnCurso && $cursoSinDerecho->count() == 0) {
                        if (!$hayAlumnosDeudores) {
                            $hayAlumnosDeudores = $this->inscribirAlumno($curso_id, $paq->grupo_id, 'paquete', $ubicacion);
                        } else {
                            $this->inscribirAlumno($curso_id, $paq->grupo_id, 'paquete', $ubicacion);
                        }
                    }
                }

                $this->correoNoPermitidos($alumnosSinDerechos->flatten());


                // return view("inscrito.inscritosSinDerecho", $cursoSinDerecho);
            }

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return redirect('create/paquete')->withInput();
        }

        $mensaje = $hayAlumnosDeudores ? 'Se ha inscrito con éxito pero se encontraron alumnos con deudas' : 'Se ha inscrito con éxito';
        alert('Escuela Modelo', $mensaje,'success')->showConfirmButton();
        return back()->with(compact('cursoSinDerecho'));
    }


    public function correoNoPermitidos($alumnosSinDerecho)
    {

        if ($alumnosSinDerecho->count() > 0) {
            
            //envio de correo
            $to_name = Auth::user()->empleado->persona->perNombre
            . " " . Auth::user()->empleado->persona->perApellido1
            . " ". Auth::user()->empleado->persona->perApellido2;

            // dd(Auth::user()->empleado->persona->id);


            /*
            $mailSeguimiento = DB::table("empleadosseguimiento")
                ->where("persona_id", "=",  Auth::user()->empleado->persona->id)
            */


            foreach ($alumnosSinDerecho as $elalumno) {
                $unAlumno = $elalumno;
                break;
            }
            //$unAlumno = $alumnosSinDerecho(0);
            

            $modulo = "INSCRITOS";
            $mailSeguimiento = DB::table("empleadosseguimiento")
                    ->where("prog_id", "=", $unAlumno->curso->cgt->plan->programa->id)
                    ->where("modulo", "=", $modulo)
            ->first();


            if ($mailSeguimiento) {
                $to_email = $mailSeguimiento->empCorreo1;
            } else {
                $to_email = 'aosorio@modelo.edu.mx';
            }
            


            $mail = new PHPMailer(true);
            // Server settings
            $mail->CharSet = "UTF-8";
            $mail->Encoding = 'base64';

            $mail->SMTPDebug = 0; //3;                         // Enable verbose debug output
            $mail->isSMTP();                              // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com'; //'mail.unimodelo.com';           // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                       // Enable SMTP authentication
            $mail->Username = 'inscripciones@modelo.edu.mx'; // 'inscripciones@unimodelo.com'; // SMTP username
            $mail->Password = 'i7X6nFLrfghu5ua';                 // SMTP password
            $mail->SMTPSecure = 'tls'; //'ssl';                    // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // 465;                            // TCP port to connect to
            $mail->setFrom('inscripciones@modelo.edu.mx', 'Universidad Modelo');
            // $mail->setFrom('inscripciones@unimodelo.com', 'Universidad Modelo');

            $mail->addAddress($to_email, $to_name);

            $mail->isHTML(true);  // Set email format to HTML

            $mail->Subject = "Inscritos Rechazados";

            $body = "";

            foreach ($alumnosSinDerecho as $alumno) {
                $body .= "<p>Clave del alumno: " . $alumno->curso->alumno->aluClave . "</p>
                <p>Nombre: " . $alumno->curso->alumno->persona->perNombre
                    . " " . $alumno->curso->alumno->persona->perApellido1
                    . " " . $alumno->curso->alumno->persona->perApellido2 . "</p>
                <p>Materia a inscribir: ". $alumno->grupoAInscribir->materia->matClave . " ". $alumno->grupoAInscribir->materia->matNombre ."</p>" .
                "<p>Grupo a inscribir: ". $alumno->grupoAInscribir->gpoSemestre .$alumno->grupoAInscribir->gpoClave . $alumno->grupoAInscribir->gpoTurno."</p>" .
                "<p>Plan: " . "(" .  $alumno->grupoAInscribir->materia->plan->planClave  . ")". " " . $alumno->curso->periodo->perNumero ."-". $alumno->curso->periodo->perAnio ."</p>" .
                "<p>Ubicacion: " .$alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre . "</p>" .
                "<p>Escuela: " . $alumno->curso->cgt->plan->programa->escuela->escNombre . "</p>" .
                "<p>Programa: " . $alumno->curso->cgt->plan->programa->progNombre . "</p>" .
                "<p>Motivo: " . $alumno->curso->razon . "</p>" .
                "<hr>";
            }

            $body .= "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

            $mail->Body  = $body;
            $mail->send();

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grupo()
    {
        $ubicaciones = Ubicacion::get();
        return view('inscrito.create_grupo',compact('ubicaciones'));
    }

    public function checkGrupo($curso_id)
    {
        $bandera = false;
        $curso = Curso::with('periodo.departamento')->find($curso_id);
        if ($curso){
            $bandera = MetodosAlumnos::esDeudorElegirMeses($curso->alumno->id);
        }
        return response()->json([
            'bandera' => $bandera,
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeGrupo(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'curso_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('create/grupo')->withErrors($validator)->withInput();
        }

        try {
            $programa_id = $request->programa_id;

            if (Utils::validaPermiso('inscrito', $programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
                return redirect()->to('create/grupo');
            }


            $curso_id = $request->curso_id;
            $curso = Curso::where("id", "=", $curso_id)->whereNotIn("curEstado", ["B"])->first();
            $cgt = Cgt::where("id", "=", $curso->cgt_id)->first();

            
            //VALIDA EL SEMESTRE DEL CGT
            $grupos = Grupo::with('materia', 'empleado.persona', 'plan.programa', 'periodo')
                ->where('gpoSemestre', '=', $cgt->cgtGradoSemestre)
                ->where('plan_id', '=', $cgt->plan_id)
                ->where('periodo_id', '=', $cgt->periodo_id)
                ->where('gpoClave', '=', $request->claveGrupo)
            ->get();



            //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
            $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
            $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
            $programa = Programa::where("id", "=", $request->programa_id)->first();

            //HISTORICO DE ALUMNOS REPROBADOS
            $historicoList = self::buscarHistoricos($request);


            // $cursos = [$request->curso_id];

            $alumnosSinDerecho = collect();
            $alumnosSinDerechos = collect();
            //INSCRIBE AL ALUMNO A LOS GRUPOS
            $first = true;
            foreach ($grupos as $grupo) {


                $existeInscritoEnCurso = Inscrito::with("grupo")
                    ->where("curso_id", "=", $curso_id)
                    ->whereHas('grupo', function($query) use ($grupo) {
                        $query->where('materia_id', $grupo->materia_id);
                        $query->where('periodo_id', $grupo->periodo_id);
                    })
                ->first();


                $alumnosSinDerecho = $this->postDesinscribirReprobados($request->curso_id, $historicoList, $grupo->id);
                $alumnosSinDerecho = $alumnosSinDerecho->unique();
                $alumnosSinDerechos->push($alumnosSinDerecho);

                $cursoSinDerecho = $alumnosSinDerecho->filter(function ($value, $key) use ($request) {
                    return $value->curso->id ==  $request->curso_id;
                });
                
                $cursoSinDerecho = collect();
                // if(!$existeInscritoEnCurso && $cursoSinDerecho->count() == 0) {
                //     $this->inscribirAlumno($curso_id, $grupo->id);
                // }
                if(!$existeInscritoEnCurso) {
                    $this->inscribirAlumno($curso_id, $grupo->id, 'grupo', $ubicacion, $first);
                }

                if ( $first ) $first = false;
            }
            // $this->correoNoPermitidos($alumnosSinDerechos->flatten());


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return back()->with(compact('cursoSinDerecho'));
        }

        alert('Escuela Modelo', 'Se ha inscrito con éxito','success')->showConfirmButton();
        return back()->with(compact('cursoSinDerecho'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grupoCompleto()
    {
        $ubicaciones = Ubicacion::get();
        return view('inscrito.create_grupo_completo',compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeGrupoCompleto(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'cgt_id' => 'required'
            ]
        );


        if ($validator->fails()) {
            return redirect ('create/grupoCompleto')->withErrors($validator)->withInput();
        }


        try {
            $programa_id = $request->programa_id;


            if (Utils::validaPermiso('inscrito', $programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
                return redirect()->to('create/grupoCompleto');
            }


            $cgt_id = $request->cgt_id;
   

            //CURSO SEGUN EL CGT SELECCIONADO
            $cursos = Curso::with('alumno.persona')->where([ ['cgt_id', '=', $cgt_id] ])->whereNotIn("curEstado", ["B"])->get();
            // dd($cursos);





            //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
            $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
            $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
            $programa = Programa::where("id", "=", $request->programa_id)->first();

            //HISTORICO DE ALUMNOS REPROBADOS
            $historicoList = self::buscarHistoricos($request);



            $alumnosSinDerechos = collect();
            //INSCRIBE A LOS ALUMNO PREINSCRITOS
            $hayAlumnosDeudores = false;
            foreach ($cursos as $curso) {
                $curso_id = $curso->id;

                $cgt = Cgt::where("id", "=", $cgt_id)->first();

                //VALIDA EL SEMESTRE DEL CGT
                $grupos = Grupo::with('materia', 'empleado.persona', 'plan.programa', 'periodo')
                    ->where('gpoSemestre', '=', $cgt->cgtGradoSemestre)
                    ->where('plan_id', '=', $cgt->plan_id)
                    ->where('periodo_id', '=', $cgt->periodo_id)
                    ->where('gpoClave', '=', $cgt->cgtGrupo)
                ->get();


                //INSCRIBE AL ALUMNO A LOS GRUPOS
                foreach ($grupos as $grupo) {
                    $existeInscritoEnCurso = Inscrito::with("grupo")
                        ->where("curso_id", "=", $curso_id)
                        ->whereHas('grupo', function($query) use ($grupo) {
                            $query->where('materia_id', $grupo->materia_id);
                            $query->where('periodo_id', $grupo->periodo_id);
                        })
                    ->first();
                    
                    // $cursos = [$curso_id];
                    $alumnosSinDerecho = $this->postDesinscribirReprobados($curso_id, $historicoList, $grupo->id);
                    $alumnosSinDerecho = $alumnosSinDerecho->unique();

                    $alumnosSinDerechos->push($alumnosSinDerecho);
        
                    $cursoSinDerecho = $alumnosSinDerecho->filter(function ($value, $key) use ($curso_id) {
                        return $value->curso->id ==  $curso_id;
                    });

                    // dd($cursoSinDerecho);
                    $cursoSinDerecho = collect();
                    if(!$existeInscritoEnCurso &&  $cursoSinDerecho->count() == 0) {
                        if (!$hayAlumnosDeudores) {
                            $hayAlumnosDeudores = $this->inscribirAlumno($curso_id, $grupo->id, 'grupoCompleto', $ubicacion);
                        } else {
                            $this->inscribirAlumno($curso_id, $grupo->id, 'grupoCompleto', $ubicacion);
                        }
                    }
                }
            }
            
            $mensaje = $hayAlumnosDeudores ? 'Se ha inscrito con éxito pero se encontraron alumnos con deudas' : 'Se ha inscrito con éxito';
            alert('Escuela Modelo', $mensaje, 'success')->showConfirmButton();
            return back()->with(compact('cursoSinDerecho'));
        } catch (QueryException $e) {
            $errorCode    = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('create/grupoCompleto')->withInput();
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



        $grupo = Grupo::where("id", "=", $request->grupo_id)->first();

        $validator = Validator::make($request->all(),
            [
                'curso_id' => 'required|unique:inscritos,curso_id,NULL,id,grupo_id,'.$request->input('grupo_id').',deleted_at,NULL',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('inscrito/create')->withErrors($validator)->withInput();
        }

        try {
            $programa_id = $request->input('programa_id');

            if (Utils::validaPermiso('inscrito', $programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
                return redirect()->to('inscrito/create');
            }


            //FILTRO EXISTE INSCRITO EN CURSO
            $grupo = Grupo::where("id", "=", $request->grupo_id)->first();
            $existeInscritoEnCurso = Inscrito::with("grupo")
                ->where("curso_id", "=", $request->curso_id)
                ->whereHas('grupo', function($query) use ($grupo) {
                    $query->where('materia_id', $grupo->materia_id);
                    $query->where('periodo_id', $grupo->periodo_id);
                })
            ->first();




            //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
            $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
            $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
            $programa = Programa::where("id", "=", $request->programa_id)->first();

            //HISTORICO DE ALUMNOS REPROBADOS
            $historicoList = self::buscarHistoricos($request);



            // $cursos = [$request->curso_id];
            $grupo  = $request->grupo_id;

            $alumnosSinDerecho = $this->postDesinscribirReprobados($request->curso_id, $historicoList, $grupo);
            $alumnosSinDerecho = $alumnosSinDerecho->unique();

            // $this->correoNoPermitidos($alumnosSinDerecho);

            $cursoSinDerecho = $alumnosSinDerecho->filter(function ($value, $key) use ($request) {
                return $value->curso->id ==  $request->curso_id;
            });
            //FIN FILTRO TIENE DERECHO A INSCRIBIRSE A CURSOS

            //REMOVER CUANDO QUEDE BIEN FILTRO DE ALUMNOS SIN DERECHO
            $cursoSinDerecho = collect();
            if (!$existeInscritoEnCurso && $cursoSinDerecho->count() == 0) {
                $this->inscribirAlumno($request->curso_id, $request->grupo_id, 'materias', $ubicacion);
            }



        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('inscrito/create')->withInput();
        }

        alert('Escuela Modelo', 'Se ha inscrito con éxito', 'success')->showConfirmButton();
        return back()->with(compact('cursoSinDerecho'));
    }

    private function inscribirAlumno($curso_id, $grupo_id, $procedencia, $ubicacion, $grupo_first = false) {
        $hayAlumnosDeudores = false;
        $curso = Curso::with('periodo.departamento', 'cgt.plan.programa.escuela', 'alumno.persona')->find($curso_id);
        $grupo = Grupo::with('materia')->find($grupo_id);
        $historicos = new Collection;
        if($curso && $grupo) {
            #Si ya aprobó la materia, se ignora y no procede a la inscripción.
            $departamento = $curso->periodo->departamento;
            $historicos = Historico::where('alumno_id', $curso->alumno_id)
                ->where('materia_id', $grupo->materia_id)
                ->get()
                ->filter(static function($historico) use ($grupo, $departamento) {
                    $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $grupo->materia);
                    return MetodosHistoricos::es_aprobada($calificacion, $departamento->depCalMinAprob);
                });
        }

        $inscrito = null;
        if($historicos->isEmpty()) {
            if ($procedencia == 'paquete' || $procedencia == 'grupoCompleto') {
                if(!MetodosAlumnos::esDeudorElegirMeses($curso->alumno->id)) {
                    $inscrito = Inscrito::create([
                        'curso_id'      => $curso_id,
                        'grupo_id'      => $grupo_id
                    ]);
                    $hayAlumnosDeudores = true;
                }
            } elseif($procedencia == 'grupo' || $procedencia == 'materias') {
                if ($curso){
                    if(MetodosAlumnos::esDeudorElegirMeses($curso->alumno->id)) {
                        if ($grupo_first) {
                            $this->mail = new Mailer([
                                'username_email' => 'inscripciones@modelo.edu.mx', // 'inscripciones@unimodelo.com',
                                'password_email' => 'i7X6nFLrfghu5ua',
                                'to_email' => 'luislara@modelo.edu.mx', // 'iran.canul@modelo.edu.mx',
                                'to_name' => '',
                                'cc_email' => '',
                                'subject' => '¡Importante! Se ha realizado el proceso de inscripción a materias de un alumno con ADEUDO.',
                                'body' => $this->armar_mensaje([
                                    'perNumero' => $curso->periodo->perNumero,
                                    'perAnio' => $curso->periodo->perAnio,
                                    'ubiClave' => $ubicacion->ubiClave,
                                    'ubiNombre' => $ubicacion->ubiNombre,
                                    'gpoSemestre' => $grupo->gpoSemestre,
                                    'gpoClave' => $grupo->gpoClave,
                                    'progClave' => $curso->cgt->plan->programa->progClave,
                                    'progNombre' => $curso->cgt->plan->programa->progNombre,
                                    'escClave' => $curso->cgt->plan->programa->escuela->escClave,
                                    'escNombre' => $curso->cgt->plan->programa->escuela->escNombre,
                                    'persona' => $curso->alumno->persona,
                                    'aluClave' => $curso->alumno->aluClave,
                                ]),
                            ]);
                            if($ubicacion->ubiClave == 'CCH') {
                                $director_campus = 'mduch@modelo.edu.mx';
                                $coordinador_secretaria_academica = 'jpereira@modelo.edu.mx';
                            } else if($ubicacion->ubiClave == 'CVA') {
                                $director_campus = 'ppineda@modelo.edu.mx'; // 'aime@modelo.edu.mx';
                                $coordinador_secretaria_academica = 'mtuz@modelo.edu.mx';
                            } else if($ubicacion->ubiClave == 'CME') {
                                $director_campus = 'cesauri@modelo.edu.mx';
                                $coordinador_secretaria_academica = 'sil_bar@modelo.edu.mx';
                            }
                    
                            $this->mail->agregar_destinatario('eail@modelo.edu.mx');
                            $this->mail->agregar_destinatario('flopezh@modelo.edu.mx');
                            $this->mail->agregar_destinatario('luislara@modelo.edu.mx');
                            $this->mail->agregar_destinatario($director_campus);
                            $this->mail->agregar_destinatario($coordinador_secretaria_academica);
                            
                            $this->mail->enviar();
                        }
                    }
                    $inscrito = Inscrito::create([
                        'curso_id'      => $curso_id,
                        'grupo_id'      => $grupo_id
                    ]);
                }
            } else {
                $inscrito = Inscrito::create([
                    'curso_id'      => $curso_id,
                    'grupo_id'      => $grupo_id
                ]);
            }
        }


        if ($inscrito) {
            $grupo->inscritos_gpo = $grupo->inscritos_gpo + 1;
            $grupo->save();

            Calificacion::create([
                'inscrito_id'   => $inscrito->id
            ]);
        }
        return $hayAlumnosDeudores;
    }

    private function armar_mensaje($datos)
	{
		$usuario = auth()->user();
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);
		$nombre_alumno = MetodosPersonas::nombreCompleto($datos['persona']);

		return "<p>{$nombre_empleado} ({$usuario->username}) ha inscrito a materias al siguiente alumno, con adeudo:</p>
		<br>
		<p><b>Clave de pago: </b> ".$datos['aluClave']."</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>
		<p><b>Grupo: </b> ".$datos['gpoSemestre'] . " - " .$datos['gpoClave']."</p>
		<p><b>Programa: </b> ".$datos['progClave'] . " - " .$datos['progNombre']."</p>
		<p><b>Escuela: </b> ".$datos['escClave'] . " - " .$datos['escNombre']."</p>
        <p><b>Campus: </b> ".$datos['ubiClave'] . " - " .$datos['ubiNombre']."</p>
        <p><b>Periodo y Año: </b> ".$datos['perNumero'] . " - " .$datos['perAnio']."</p>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}

    /**
     * Función para sustituir la view de MySQL 'vwhistoricoaprobados'.
     * el resultado se manda al proceso de desinscribir reprobados.
     * 
     * @param Illuminate\Http\Request
     */
    private static function buscarHistoricos(Request $request) {
        $inscritos = Inscrito::with('curso')
        ->where(static function($query) use ($request) {
            if($request->grupo_id)
                $query->where('grupo_id', $request->grupo_id);
            if($request->curso_id)
                $query->where('curso_id', $request->curso_id);
        })
        ->whereHas('curso.cgt', static function($query) use ($request) {
            if($request->cgt_id)
                $query->where('cgt_id', $request->cgt_id);
        })->get();

        return Historico::with(['alumno', 'materia', 'plan'])
        ->whereIn('alumno_id', $inscritos->pluck('curso.alumno_id'))
        ->get();
    }




    public function desinscribirReprobados(Request $request)
    {
        return view("inscrito.desinscribir");
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
        $inscrito = Inscrito::with('curso.alumno.persona','grupo.materia')->findOrFail($id);
        return view('inscrito.show',compact('inscrito'));
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
        $inscrito = Inscrito::with('curso.alumno.persona','grupo.materia')->findOrFail($id);
        $periodos = Periodo::where('departamento_id',$inscrito->curso->cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado','escuela')->where('escuela_id',$inscrito->curso->cgt->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id',$inscrito->curso->cgt->plan->programa->id)->get();
        $cgts = Cgt::where([['plan_id', $inscrito->curso->cgt->plan_id],['periodo_id', $inscrito->curso->cgt->periodo_id]])->get();
        $cursos = Curso::with('alumno.persona')->where('cgt_id', '=', $inscrito->curso->cgt->id)->get();
        $cgt = $inscrito->curso->cgt;
        $grupos = Grupo::with('materia', 'empleado.persona', 'plan.programa', 'periodo')
            ->where('gpoSemestre', $cgt->cgtGradoSemestre)->where('plan_id',$cgt->plan_id)
            ->where('periodo_id',$cgt->periodo_id)->get();
        //VALIDA PERMISOS EN EL PROGRAMA
        if(Utils::validaPermiso('inscrito',$inscrito->curso->cgt->plan->programa_id)){
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
            return redirect('inscrito');
        }else{
            return view('inscrito.edit',compact('inscrito','periodos','programas','planes','cgts','cursos','grupos'));
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'curso_id' => 'required',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect ('inscrito/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $inscrito = Inscrito::findOrFail($id);
                $inscrito->curso_id = $request->input('curso_id');
                $inscrito->grupo_id = $request->input('grupo_id');
                $inscrito->save();


                alert('Escuela Modelo', 'El inscrito se ha actualizado con éxito','success')->showConfirmButton();
                return redirect('inscrito');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
                return redirect('inscrito/'.$id.'/edit')->withInput();
            }
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
        $inscrito = Inscrito::findOrFail($id);

        $grupo = Grupo::find($inscrito->grupo_id);
        if ($grupo->inscritos_gpo > 0) {
            $grupo->inscritos_gpo = $grupo->inscritos_gpo - 1;
            $grupo->save();
        }

        try {
            if(Utils::validaPermiso('inscrito',$inscrito->curso->cgt->plan->programa_id)){
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->showConfirmButton()->autoClose(2000);
                return redirect('inscrito');
            }
            if ($inscrito->delete()) {
                alert('Escuela Modelo', 'El inscrito se ha eliminado con éxito','success');
            } else {
                alert()->error('Error...', 'No se puedo eliminar el inscrito')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('inscrito');
    }



    public function cambiarGrupo(Request $request)
    {
        $inscritoId = $request->inscritoId;
        $inscrito = Inscrito::where("id", "=", $inscritoId)->first();


        $grupos = Grupo::with("materia")
            ->where('materia_id', "=", $inscrito->grupo->materia_id)
            ->where("periodo_id", "=", $inscrito->grupo->periodo_id)
        ->get();



        return view("inscrito.cambiarGrupo", [
            "inscrito" => $inscrito,
            "grupos"   => $grupos
        ]);
    }

    public function postCambiarGrupo (Request $request)
    {
        //grupo nuevo
        $grupoId = $request->gpoId;
        $inscritoId = $request->inscritoId;

        $inscritoActual = Inscrito::where("id", "=", $inscritoId)->first();
        $grupoAnteriorId = $inscritoActual->grupo->id;


        $inscrito = Inscrito::findOrFail($inscritoId);
        $inscrito->grupo_id = $request->gpoId;
        
        if ($inscrito->save()) {
            $grupoAnterior = Grupo::findOrFail($grupoAnteriorId);
            $grupoAnterior->inscritos_gpo = $grupoAnterior->inscritos_gpo -1;
            $grupoAnterior->save();


            $grupoNuevo = Grupo::findOrFail($request->gpoId);
            $grupoNuevo->inscritos_gpo = $grupoNuevo->inscritos_gpo +1;
            $grupoNuevo->save();
        }

        alert('Escuela Modelo', 'El inscrito se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }





    // public function postDesinscribirReprobados($cursoIds, $historicoList, $grupoId)
    // {
    //     $cursos = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion', 'periodo', 'alumno.persona')
    //         // ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion',function($query) {

    //         //     $query->where('cgtGradoSemestre', ">=", 4);
    //         // })
    //         // ->where('curEstado', '<>', "B")
    //         ->whereIn('id', $cursoIds)
    //     ->get();


    //     $alumnosSinDerecho = collect();

    //     foreach ($cursos as $key => $curso) {

    //         $reprobado =  DB::select("call procBuscarReprobadosInsc("
    //             .$curso->periodo->perNumero.","
    //             .$curso->periodo->perAnio.",'"
    //             .$curso->periodo->departamento->ubicacion->ubiClave."','"
    //             .$curso->periodo->departamento->depClave."','"
    //             .$curso->cgt->plan->programa->escuela->escClave."','"
    //             .$curso->cgt->plan->programa->progClave."')");

    //         $reprobado = collect($reprobado)->where("aluClave", "=", $curso->alumno->aluClave);

    //         if (($reprobado->count()) > 0) {
    //             $alumnosSinDerecho->push([
    //                 "curso" => $curso,
    //                 "razon" =>  "ALUMNO REPROBADO"   
    //             ]);
    //         }


    //         $reprobado =  DB::select("call procBuscarReprobadosInscAnual("
    //             .$curso->periodo->perNumero.","
    //             .$curso->periodo->perAnio.",'"
    //             .$curso->periodo->departamento->ubicacion->ubiClave."','"
    //             .$curso->periodo->departamento->depClave."','"
    //             .$curso->cgt->plan->programa->escuela->escClave."','"
    //             .$curso->cgt->plan->programa->progClave."')");

    //         $reprobado = collect($reprobado)->where("aluClave", "=", $curso->alumno->aluClave);

    //         if (($reprobado->count()) > 0) {
    //             $alumnosSinDerecho->push([
    //                 "curso" => $curso,
    //                 "razon" =>  "ALUMNO REPROBADO"   
    //             ]);
    //         }

    //         dd($alumnosSinDerecho->unique("curso.id"));

    //     }
    // }

    
    public function postDesinscribirReprobados($curso_id, $historicoList, $grupoId)
    {
        $cursos = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion', 'periodo', 'alumno.persona')
            ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion',function($query) {

                $query->where('cgtGradoSemestre', ">=", 4);
            })
            // EXCLUYE ALUMNOS DADOS DE BAJA
            ->where('curEstado', '<>', "B")
            ->where('id', $curso_id)
        ->get();
        // dd($cursos, $curso_id);
        $planIds = $historicoList->pluck('plan_id')->unique();
        $listMaterias = Materia::whereIn("plan_id", $planIds)->get();


        $alumnosSinDerecho = collect();

        foreach ($cursos as $key => $curso) {
            $departamento = $curso->cgt->plan->programa->escuela->departamento;
    		$planID = $curso->cgt->plan->id;

    		//Obtener el primer curTipoIngreso del alumno.
    		$resumenAcademicoAlumno = DB::table('resumenacademico')
                ->where('alumno_id', $curso->alumno->id)->where('plan_id', $planID)
            ->first();
            


            if ($resumenAcademicoAlumno) {


                //SI ES CURSO REVALIDADOR, BUSCAR SU SEMESTRE DE INGRESO Y ACEPTAR MATERIAS DE DOS AÑOS ANTES

                $esCursoEsRevalidador = Curso::where("alumno_id", "=", $curso->alumno_id)
                    // ->where("periodo_id", "=", $curso->periodo_id)
                    ->whereHas('cgt.plan', function($query) use ($curso) {
                        $query->where('id', $curso->cgt->plan_id);
                    })
                    ->where("curTipoIngreso", "=", "EQ")
                ->first();


                $materiasPermitidas = collect();

                if ($esCursoEsRevalidador) {
                    $planID = $curso->cgt->plan->id;
        
        
                    $resumenAcademicoAlumno = DB::table('resumenacademico')
                        ->where('alumno_id', $curso->alumno->id)->where('plan_id', $planID)
                    ->first();
        
        
                    $cursoDeIngreso = Curso::with("cgt")
                        ->where("alumno_id", "=", $resumenAcademicoAlumno->alumno_id)
                        ->where("periodo_id", "=", $resumenAcademicoAlumno->resPeriodoIngreso)
                    ->first();
        
        
                    $materiasPermitidas = Materia::where("plan_id", "=", $planID)
                        ->where("matSemestre", "<", $cursoDeIngreso->cgt->cgtGradoSemestre)
                        ->where("matSemestre", ">=", $cursoDeIngreso->cgt->cgtGradoSemestre - 4)
                    ->get();


                    $materiasPermitidas = $materiasPermitidas->map(function($item, $key) {
                        return $item->id;
                    });
                }










                //BUSCAR SI EL ALUMNO DEBE MATERIAS DE 3 SEMESTRES ANTERIORES
                $existeMateriasReprobadas = $historicoList
                    ->where('plan_id', $curso->cgt->plan->id)
                    ->where("materia.matSemestre", "=", $curso->cgt->cgtGradoSemestre - 3)
                    ->where("alumno_id", "=", $curso->alumno_id)
                    ->sortByDesc('histFechaExamen')
                    ->unique('materia_id')
                    ->filter(static function($historico) use ($departamento) {
                        $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                        return MetodosHistoricos::es_reprobada($calificacion, $departamento->depCalMinAprob);
                    });


                if ($existeMateriasReprobadas->isNotEmpty()) {
                    //ALUMNO SIN DERECHO A INSCRIPCION
 
                    //si es curso revalidador excluir materias
                    if ($esCursoEsRevalidador) {
                        $existeMateriasReprobadas = $existeMateriasReprobadas->whereNotIn("materia_id", $materiasPermitidas);
                    }

                    if ($existeMateriasReprobadas->count() > 0) {

                        $curso->razon = "ALUMNO DEBE MATERIAS DE MAS DE UN AÑO";
                        $alumnosSinDerecho->push((Object) [
                            "curso" => $curso
                        ]);
                    }
                }


    
                //BUSCAR SI EL ALUMNO NO CURSÓ MATERIAS DE 3 SEMESTRES ANTERIORES
                $listMateriaAlumno = $historicoList
                    ->where("materia.matSemestre", "=", $curso->cgt->cgtGradoSemestre - 3)
                    ->where("alumno_id", $curso->alumno->id)
                    ->where("plan_id", $planID);

                $materiasNoCursadas = $listMaterias->filter(function ($item, $key) use ($curso, $listMateriaAlumno, $planID) {
                    return $item->matSemestre == $curso->cgt->cgtGradoSemestre - 3
                        && !in_array($item->id, $listMateriaAlumno->pluck('materia_id')->toArray())
                        && $item->plan_id == $planID;
                });


                //si es curso revalidador excluir materias
                if ($materiasNoCursadas->isNotEmpty()) {
                    $materiasNoCursadas = $materiasNoCursadas->whereNotIn("id", $materiasPermitidas);
                }

                
                if ($materiasNoCursadas->count() > 0) {

                    $curso->razon = "ALUMNO NO CURSÓ MATERIAS DE MAS DE UN AÑO";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);

                }
                // FIN ----------------------------------------------------------------------------------




                //BUSCAR SI EL ALUMNO DEBE/NO HA CURSADO MAS DE 3 MATERIAS EN LO QUE LLEVA DEL PLAN

                //materias reprobadas en lo que va del plan
                $materiasReprobadasPlan = $historicoList
                    ->where("alumno_id", "=", $curso->alumno_id)
                    ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                    ->sortByDesc("histFechaExamen")
                    ->unique("materia_id")
                    // ->where("aprobado", ["R", "A"]) #esto está basado en la vista SQL 'vwhistoricoaprobados'
                    ->where("plan_id", "=", $curso->cgt->plan->id)
                    ->filter(static function($historico) use ($departamento) {
                        $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                        return MetodosHistoricos::es_reprobada($calificacion, $departamento->depCalMinAprob);
                    });


                //si es curso revalidador excluir materias
                if ($materiasNoCursadas->isNotEmpty()) {
                    $materiasReprobadasPlan = $materiasReprobadasPlan->whereNotIn("materia_id", $materiasPermitidas);
                }
                if ($materiasReprobadasPlan->count() > 0) {

                    $curso->razon = "ALUMNO REPROBO MATERIAS EN LO QUE VA DEL PLAN";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);

                }


    
                //materias no cursadas en lo que va del plan
                $listMateriaAlumnoPlan = $historicoList
                    ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                    ->where("alumno_id", $curso->alumno->id)
                    ->where("plan_id", $planID);

                $materiasNoCursadasPlan = $listMaterias->filter(function ($item, $key) use ($curso, $listMateriaAlumnoPlan, $planID) {
                    return $item->matSemestre < $curso->cgt->cgtGradoSemestre
                    // return $item->matSemestre == $curso->cgt->cgtGradoSemestre
                        && !in_array($item->id, $listMateriaAlumnoPlan->pluck('materia_id')->toArray())
                        && $item->plan_id == $planID;
                });


                //si es curso revalidador excluir materias
                if ($materiasNoCursadas->isNotEmpty()) {
                    $materiasNoCursadasPlan = $materiasNoCursadasPlan->whereNotIn("id", $materiasPermitidas);
                }

                
                if ($materiasNoCursadasPlan->count() > 0) {

                    $curso->razon = "ALUMNO NO CURSÓ MATERIAS EN LO QUE VA DEL PLAN";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);
                }

                $cantMateriasReprobadasPlan = $materiasReprobadasPlan->count();
                $cantMateriasNoCursadasPlan = $materiasNoCursadasPlan->count();
                $totalMateriasDeuda = $cantMateriasReprobadasPlan + $cantMateriasNoCursadasPlan;

                if ($totalMateriasDeuda > 3) {
                        
                    $curso->razon = "TOTAL DEBE / NO CURSÓ MATERIAS EN LO QUE VA DEL PLAN";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);
                
                }
                // FIN ----------------------------------------------------------------------------------






                //falta filtro con grupo->materia_id





                $grupo = Grupo::where("id", "=", $grupoId)->first();

                //BUSCAR MATERIAS CON PREREQUISITOS REPROBADOS/NO CURSADOS
                $materiasPlanSemestre = $listMaterias
                    ->where("plan_id", "=", $planID)
                    ->where("matSemestre", "=", $curso->cgt->cgtGradoSemestre)
                    ->where("matPrerequisitos", "=", "1")
                    ->where("id", "=", $grupo->materia->id);

                $materiasPlanSemestreIds = $materiasPlanSemestre->map(function ($item, $key) {
                    return $item->id;
                })->all();





                $materiasPrerequisito = Prerequisito::whereIn("materia_id", $materiasPlanSemestreIds)->get();


                if ($materiasPrerequisito->count() > 0) {
                    foreach ($materiasPrerequisito as $key => $value) {
        
                        //materias reprobadas en lo que va del plan
                        $materiasReprobadasPrereq = $historicoList
                            ->where("alumno_id", "=", $curso->alumno_id)
                            ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                            ->sortByDesc("histFechaExamen")
                            ->where("materia_id", "=", $value->materia_prerequisito_id)
                            ->unique("materia_id")
                            // ->where("aprobado", "=", "R"); # Esto se basa en la vista SQL 'vwhistoricoaprobados'
                            ->filter(static function($historico) use ($departamento) {
                                $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                                return MetodosHistoricos::es_reprobada($calificacion, $departamento->depCalMinAprob);
                            });

                        if ($materiasReprobadasPrereq->count() > 0) {

                            $curso->razon = "PREREQUISITO REPROBADO";
                            $alumnosSinDerecho->push((Object) [
                                "curso" => $curso
                            ]);
                            //el prerequisito de la materia esta reprobada -> desinscribir de la materia
                        }



                        //materias no cursadas en lo que va del plan
                        $listMateriaAlumnoPrereq = $historicoList
                            ->where("alumno_id", $curso->alumno->id)
                            ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                            ->where("plan_id", $planID)
                            ->where("materia_id", "=", $value->materia_prerequisito_id);

                        if ($listMateriaAlumnoPrereq->count() == 0) {
                            //el prerequisito de la materia esta no cursada -> desinscribir de la materia

                            $curso->razon = "PREREQUISITO NO CURSADO";
                            $alumnosSinDerecho->push((Object) [
                                "curso" => $curso
                            ]);
                        }
                        // FIN ----------------------------------------------------------------------------------
                    }
                }



                //SI LA MATERIA ESTA APROBADA, NO INSCRIBIR
                $listMateriasAprobadas = $historicoList
                    // ->where("matSemestre", "=", $curso->cgt->cgtGradoSemestre)
                    ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                    ->where("alumno_id", $curso->alumno->id)
                    ->where("plan_id", $planID)
                    ->sortByDesc("histFechaExamen")
                    ->unique("materia_id")
                    // ->where("aprobado", "=", "A") # Esto se basa en la vista SQL 'vwhistoricoaprobados'
                    ->filter(static function($historico) use ($departamento) {
                        $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                        return MetodosHistoricos::es_aprobada($calificacion, $departamento->depCalMinAprob);
                    })
                    ->where("materia_id", "=", $grupo->materia->id);


                if ($listMateriasAprobadas->count() > 0) {

                    $curso->razon = "MATERIA APROBADA";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);
                }


            }
        }



        if ($alumnosSinDerecho->count() > 0) {

            $grupoAInscribir = Grupo::with("materia.plan")->where("id", "=", $grupoId)->first();
            // dd($grupoAInscribir);
            $alumnosSinDerecho = $alumnosSinDerecho->map(function ($item, $key) use ($grupoId, $grupoAInscribir) {

                ($item->grupoId = $grupoId);

                $item->grupoId = $grupoId;
                $item->grupoAInscribir = $grupoAInscribir;
                $item->alumnoCursoGrupo = $item->curso->alumno->id
                    . "-" . $item->curso->id
                    . "-" . $grupoId;
                return $item;
            })->unique("alumnoCursoGrupo");


            foreach ($alumnosSinDerecho as $alumno) {
                if (!InscritosRechazados::where("alumno_id", "=", $alumno->curso->alumno->id)
                    ->where("curso_id", "=", $alumno->curso->id)
                    ->where("grupo_id", "=", $grupoId)
                ->exists()) {
                
            // dd($alumno->curso->periodo_id);

                    InscritosRechazados::create([
                        'alumno_id' => $alumno->curso->alumno->id,
                        'aluClave' => $alumno->curso->alumno->aluClave,
                        'perNombre' => $alumno->curso->alumno->persona->perNombre, 
                        'perApellido1' => $alumno->curso->alumno->persona->perApellido1, 
                        'perApellido2' => $alumno->curso->alumno->persona->perApellido2, 
                        'curso_id' => $alumno->curso->id,
                        'ubicacion_id' => $alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->id,
                        'ubiClave' =>  $alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave, 
                        'ubiNombre' => $alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre, 
                        'departamento_id' => $alumno->curso->cgt->plan->programa->escuela->departamento->id, 
                        'depNivel' => $alumno->curso->cgt->plan->programa->escuela->departamento->depNivel, 
                        'depClave' => $alumno->curso->cgt->plan->programa->escuela->departamento->depClave,
                        'depNombre' => $alumno->curso->cgt->plan->programa->escuela->departamento->depNombre,
                        'escuela_id' => $alumno->curso->cgt->plan->programa->escuela->id, 
                        'escNombre' => $alumno->curso->cgt->plan->programa->escuela->escNombre, 
                        'programa_id' => $alumno->curso->cgt->plan->programa->id,
                        'progNombre' => $alumno->curso->cgt->plan->programa->progNombre, 
                        'periodo_id' => $alumno->curso->periodo_id, 
                        'perNumero' => $alumno->curso->periodo->perNumero, 
                        'perAnio' => $alumno->curso->periodo->perAnio,
                        'cgt_id' => $alumno->curso->cgt->id, 
                        'grupo_id' => $grupoId, 
                        'materia_id' => $grupoAInscribir->materia->id, 
                        'matClave' => $grupoAInscribir->materia->matClave, 
                        'matNombre' => $grupoAInscribir->materia->matNombreOficial, 
                        'plan_id' => $grupoAInscribir->materia->plan->id, 
                        'planClave' => $grupoAInscribir->materia->plan->planClave, 
                        'gpoSemestre' => $grupoAInscribir->gpoSemestre, 
                        'gpoClave' => $grupoAInscribir->gpoClave, 
                        'gpoTurno' => $grupoAInscribir->gpoTurno, 
                        'rechazadoInscrito' => "NO"
                    ]);
                }
            }
        }

        // dd($alumnosSinDerecho);

       


        return $alumnosSinDerecho;
    }


    public function historial_cambios_calificacion($inscrito_id) {
        $inscrito = Inscrito::with(['curso.periodo', 'grupo.materia.plan.programa', 'calificacion'])->findOrFail($inscrito_id);

        return view('inscrito.historial_cambios_calificacion', compact('inscrito'));
    }


    


}
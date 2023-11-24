<?php

namespace App\Http\Controllers;

use DB;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pais;

use App\Models\Plan;
use App\Http\Helpers\Utils;
use App\Models\Acuerdo;
use App\Models\Escuela;
use App\Models\Persona;
use Illuminate\Http\Request;
use App\Models\Programa;
use App\Models\Candidato;
use App\Models\Municipio;
use App\Models\Ubicacion;
use App\Models\Departamento;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\CandidatoClave;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PreparatoriaProcedencia;
use App\Models\Empleado;
use App\Models\Alumno;

class CandidatosPrimerIngresoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:CandidatosPrimerIngreso',['except' => [
            'index','show','list',
            'getProgramasByCampus',
            'preparatoriaProcedenciaCandidatos'
        ]]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('candidatos.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $candidatos = DB::table("candidatos")
        ->select('candidatos.id as id','candidatos.perCurp','candidatos.perApellido1','candidatos.perApellido2','candidatos.perNombre',
        'candidatos.perCorreo1', 'candidatos.ubiClave', 'candidatos.progClave', 'candidatos.coordinador_correo',
        'candidatos.created_at', 'candidatos.candidatoPreinscrito')
        ->whereNull('deleted_at')->latest('candidatos.created_at');

        return Datatables::of($candidatos)
            ->addColumn('created_at',function($query) {
                return Carbon::parse($query->created_at)->format("d/m/Y");
            })
            ->filterColumn('created_at', function($query, $keyword) {
                return $query->where('created_at','like','%'.$keyword.'%');
            })
            ->addColumn('action',function($query) {
                return '<a href="candidatos_primer_ingreso/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                
                <a href="candidatos_primer_ingreso/cancel/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Cancelar estado del candidato">
                    <i class="material-icons">cancel</i>
                </a>';
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
        $departamentos = Departamento::whereIn("depNivel", [1,2,3,4,5,6,7])->get()->unique("depClave");
        $paises = Pais::get();
        $ubicaciones = Ubicacion::all();
        //$ubicaciones = Ubicacion::where("id", "=", 1)->first();
        //$ubicaciones = Ubicacion::find(1);


        return View('candidatos.create', compact("departamentos", "paises", "ubicaciones"));
    }


    public function getProgramasByCampus(Request $request, $ubicacion_id)
    {
        if($request->ajax()){

            /*
            $programas = DB::table("planes")
                ->select("escuelas.escNombre", "departamentos.depClave",
                "departamentos.ubicacion_id", "planes.planEstado",
                "programas.id", "programas.progNombre")
                ->join('programas', 'programas.id', '=', 'planes.id')
                ->join('escuelas', 'escuelas.id', '=', 'programas.escuela_id')
                ->join('departamentos', 'departamentos.id', '=', 'escuelas.departamento_id')
                ->join('ubicacion', 'ubicacion.id', '=', 'departamentos.ubicacion_id')

                ->where("escuelas.escNombre", "like", "ESCUELA%")
                ->where("departamentos.depClave", "=", "SUP")
                ->where("ubicacion.id", "=", $ubicacion_id)
                ->where("planes.planEstado", "=", "N")
                ->orderBy("programas.progNombre")
            ->get();
            */

            $programas = DB::table("programas")
                ->select("escuelas.escNombre", "departamentos.depClave",
                    "departamentos.ubicacion_id", "planes.planEstado",
                    "programas.id", "programas.progNombre")
                ->join('planes', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'escuelas.id', '=', 'programas.escuela_id')
                ->join('departamentos', 'departamentos.id', '=', 'escuelas.departamento_id')
                ->join('ubicacion', 'ubicacion.id', '=', 'departamentos.ubicacion_id')

                ->where("escuelas.escNombre", "like", "ESCUELA%")
                ->where("departamentos.depClave", "=", "SUP")
                ->where("ubicacion.id", "=", $ubicacion_id)
                ->where("planes.planEstado", "=", "N")
                ->orderBy("programas.progNombre")
                ->distinct()
                ->get();




            return response()->json($programas);
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

        $prepaRequired = "required";
        if ($request->noEncuentraPrepa) {
            $prepaRequired = "";
        }

        $perCurpRequired = "required|max:18";
        $esCurpValida = "accepted";

        if ($request->noSoyMexicano) {
            $perCurpRequired = "max:18";
            $esCurpValida = "";
        }



        if (Carbon::parse($request->perFechaNac)->age < 15) {
            alert()->error('error', 'No se puede registrar a menores de 15 años.')->showConfirmButton();
            return redirect()->back()->withInput();
        }


        $validator = Validator::make($request->all(),
            [
                'image' => 'mimes:jpeg,jpg,png,pdf|file|max:10000',
                'perNombre'     => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'  => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'  => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'      => $perCurpRequired,
                'esCurpValida'  => $esCurpValida,

                'perSexo'      => 'required',
                'perFechaNac'  => 'required',

                //perLugarNac
                'municipio_id' => 'required',
                'perTelefono1' => 'required|min:10|max:10',
                'perCorreo1'   => 'required',

                'preparatoria_id' => $prepaRequired,
                'ubicacion_id'    => 'required',
                'programa_id'     => 'required',
                'passwordEscuela' => 'required'
            ],
            [
                'image.mimes' => "El archivo solo puede ser de tipo jpeg, jpg, png y pdf",
                'image.max'   => "El archivo no debe de pesar más de 10 Megas",
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'El apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'El apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',

                "perCurp.required"      => "Favor de poner la CURP",
                "perCurp.max"           => "La CURP debe tener un maximo de 18 caracteres.",
                "esCurpValida.accepted" => "La CURP debe ser un formato válido.",

                "perSexo.required"      => "Favor de seleccionar sexo",
                "perFechaNac.required"  => "Favor de poner fecha de nacimiento",
                'municipio_id.required' => "Favor de seleccionar municipio",
                'perTelefono1.required' => "Favor de poner su telefono",
                'perTelefono1.min' => "Numero de telefono solo puede ser de 10 dígitos",
                'perTelefono1.max' => "Numero de telefono solo puede ser de 10 dígitos",
                'perCorreo1.required'   => "Favor de poner su correo",
                'preparatoria_id.required' => "Favor de seleccionar preparatoria de procedencia",
                'ubicacion_id.required'    => "Favor de seleccionar campus",
                'programa_id.required'     => "Favor de seleccionar carrera",
                'passwordEscuela.required' => "Favor de poner la clave de escuela",
            ]
        );

        $encuentraClave = CandidatoClave::where("claveunica", "=", $request->passwordEscuela)
            ->whereNull('deleted_at')->first();



        if (!$encuentraClave) {
            alert()->error('error', 'La clave proporcionada es inválida.')->showConfirmButton();
            return redirect('candidatos_primer_ingreso/create')->withErrors($validator)->withInput();
        }


        if ($validator->fails()) {
            return redirect('candidatos_primer_ingreso/create')->withErrors($validator)->withInput();
        } else {



            $ubicacion = Ubicacion::where("id", "=", $request->input('ubicacion_id'))->first();

            $departamento = Departamento::where("ubicacion_id", "=", $ubicacion->id)
                ->where("depClave", "=", "SUP")
            ->first();

            $programa = Programa::where("id", "=", $request->input('programa_id'))->first();
            $escuela  = Escuela::where("id", "=", $programa->escuela_id)->first();


            if ($request->noSoyMexicano && $request->perSexo == "M") {
                $perCurp = "XEXX010101MNEXXXA4";
            }
            if ($request->noSoyMexicano && $request->perSexo == "F") {
                $perCurp = "XEXX010101MNEXXXA8";
            }

            $imageName = "";
            if ($request->image) {
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                $path = $request->image->move(env("PROJECT_PATH"), $imageName);
            }

            try {
                $candidato = Candidato::create([
                    'perCurp'      => $request->noSoyMexicano ? $perCurp : $request->input('perCurp'),
                    'perApellido1' => $request->input('perApellido1'),
                    'perApellido2' => $request->input('perApellido2'),
                    'perNombre'    => $request->input('perNombre'),
                    'perFechaNac'  => $request->input('perFechaNac'),
                    'perLugarNac'  => $request->input('municipio_id'),
                    'perSexo'      => $request->input('perSexo'),
                    'perCorreo1'   => $request->input('perCorreo1'),
                    'perTelefono1' => $request->input('perTelefono1'),
                    'perFoto'      => $imageName,
                    'curExani'     => $request->input('curExani'),
                    'preparatoria_id' => $request->noEncuentraPrepa ? 0: $request->input('preparatoria_id'),
                    'ubicacion_id'    => $request->input('ubicacion_id'),
                    'ubiClave'        => $ubicacion ? $ubicacion->ubiClave: "",
                    'ubiNombre'       => $ubicacion ? $ubicacion->ubiNombre: "",
                    'departamento_id' => $departamento ? $departamento->id: "",
                    'escuela_id'      => $escuela->id,
                    'director_id'     => $escuela->empleado_id,
                    'director_correo' => $escuela->empleado->empCorreo1 ? $escuela->empleado->empCorreo1: "",
                    'programa_id'     => $request->input('programa_id'),
                    'progClave'       => $programa->progClave,
                    'progNombre'      => $programa->progNombre,
                    'coordinador_id'  => $programa->empleado_id,
                    'coordinador_correo'   => $programa->empleado->empCorreo1 ? $programa->empleado->empCorreo1: "",
                    'candidatoPreinscrito' => "NO",
                    'esExtranjero'         => ($request->noSoyMexicano) ? 1: 0
                ]);

                if ($candidato) {
                    DB::table("candidatosclaves")
                        ->where("claveunica", "=", $request->passwordEscuela)
                        ->whereNull('deleted_at')
                        ->update(['deleted_at' => Carbon::now()]);
                }


                $municipio = Municipio::where("id", "=", $request->input('municipio_id'))->first();
                $perLugarNac = $municipio ?
                    $municipio->munNombre . ", ". $municipio->estado->edoNombre . ", " . $municipio->estado->pais->paisNombre
                : "";


                $preparatoriaId          = $request->noEncuentraPrepa ? 0: $request->input('preparatoria_id');
                $preparatoriaProcedencia = PreparatoriaProcedencia::where("id", "=", $preparatoriaId)->first();
                $preparatoriaProcedencia = $preparatoriaProcedencia && ($preparatoriaId != 0) ?
                    $preparatoriaProcedencia->prepNombre
                        . ", ". $preparatoriaProcedencia->municipio->munNombre
                        . ", ". $preparatoriaProcedencia->municipio->estado->edoNombre
                        . ", ". $preparatoriaProcedencia->municipio->estado->pais->paisNombre
                : "";


                
                $existePersona = Persona::where("perApellido1", "=", $request->perApellido1)
                    ->where("perApellido2", "=", $request->perApellido2)
                    ->where("perNombre", "like", '%'.$request->perNombre.'%')
                    ->where("perCurp", "=", $request->perCurp)
                ->first();




                $modulo = "CANDIDATOS";
                $empleadoProgCorreo = DB::table("empleadosseguimiento")
                    ->where("persona_id", "=", $programa->empleado->persona->id)
                    ->where("prog_id", "=", $programa->id)
                    ->where("modulo", "=", $modulo)
                ->first();
                // dd($programa->empleado->empCorreo1);
                if ($empleadoProgCorreo) {
                    $nombreCandidato = $request->input('perNombre')
                        . " " . $request->input('perApellido1')
                        . " ". $request->input('perApellido2');

                    $to_name  = $programa ? $programa->empleado->persona->perNombre
                        . " " . $programa->empleado->persona->perApellido1
                        . " " . $programa->empleado->persona->perApellido2: "";

                    $to_email = $empleadoProgCorreo->empCorreo1 ? $empleadoProgCorreo->empCorreo1: "";


                    $cc_name =  $escuela ? $escuela->empleado->persona->perNombre
                        . " " . $escuela->empleado->persona->perApellido1
                        . " " . $escuela->empleado->persona->perApellido2: "";

                    $empleadoEscCorreo = DB::table("empleadosseguimiento")
                        ->where("persona_id", "=", $escuela->empleado->persona->id)
                        ->where("escuela_id", "=", $escuela->id)
                        ->where("prog_id", "=", $programa->id)
                    ->first();

                    $cc_email = $empleadoEscCorreo ? $empleadoEscCorreo->empCorreo1: "";




                    $nombreCandidato   = $nombreCandidato;
                    $mailCandidato     = $request->input('perCorreo1');
                    $telefonoCandidato = $request->input('perTelefono1');
                    $carreraCandidato  = $programa->progNombre;

                    $mail = new PHPMailer(true);
                    // Server settings
                    $mail->CharSet = "UTF-8";
                    $mail->Encoding = 'base64';

                    $mail->SMTPDebug = 0; //3;                         // Enable verbose debug output
                    $mail->isSMTP();                              // Set mailer to use SMTP
                    $mail->Host =  'smtp.office365.com'; //'mail.unimodelo.com';           // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                       // Enable SMTP authentication
                    $mail->Username = 'candidatos@modelo.edu.mx'; //'mail.unimodelo.com'; // 'candidatos@modelo.edu.mx'; // SMTP username
                    $mail->Password = 'Tuv72389';                 // SMTP password
                    $mail->SMTPSecure = 'tls'; //'ssl';                    // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587; // 465;                            // TCP port to connect to
                    $mail->setFrom('candidatos@modelo.edu.mx', 'Universidad Modelo');
                    // $mail->setFrom('candidatos@unimodelo.com', 'Universidad Modelo');

                    $mail->addAddress($to_email, $to_name);
                    $mail->addCC($cc_email);
                    //$mail->addCC($cc_email);

                    $mail->isHTML(true);                          // Set email format to HTML
                    $mail->Subject = "Candidato a 1er Ingreso: " . $request->input('perNombre')
                        . " " . $request->input('perApellido1')
                        . " ". $request->input('perApellido2');

                    
                    $msgExistePersona = "";
                    if ($existePersona) {
                        $msgExistePersona = '<p><b>El nombre completo o curp del candidato ya se encuentra registrado '.
                        'en el sistema de control escolar.<br>Favor de verificar el estado del alumno o empleado en el SCEM, '.
                        'ya que debe preinscribirlo directamente.</b></p>'.
                        '<p><b>Nombre Completo: '.$existePersona->perNombre . ' ' . $existePersona->perApellido1 . $existePersona->perApellido2 . '</b></p>'.
                        '<p><b>CURP: '.$existePersona->perCurp . '</b></p>';
                    }


                    $nosoymexicano = $request->noSoyMexicano ? $perCurp : $request->input('perCurp');
                    $body = "<p>Buen día: Se ha recibido una solicitud por parte de ". $nombreCandidato." para ingresar al primer semestre"
                    ." de la " . $carreraCandidato . "</p>
                    <p>Favor de realizar el seguimiento oportuno y adecuado mediante los datos de contacto:</p>
                    <p>CURP: " . $nosoymexicano . "</p>
                    <p>Fecha de nacimiento: " . Carbon::parse($request->input('perFechaNac'))->format("d-m-Y") . "</p>
                    <p>Lugar de nacimiento: ". $perLugarNac."</p>
                    <p>Preparatoria de procedencia: " . $preparatoriaProcedencia . "</p>
                    <p>Calificación exani: " . $request->input('curExani') . "</p>
                    <p>Email: ".$mailCandidato  ."</p>
                    <p>Teléfono: " . $telefonoCandidato. "</p>".
                    $msgExistePersona.
                    "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

                    $mail->Body  = $body;
                    $mail->send();
                }

                $nosoymexicano = $request->noSoyMexicano ? $perCurp : $request->input('perCurp');
                DB::update("update candidatos c, personas p set  c.candidatoPreinscrito = 'SI' where c.perCurp = p.perCurp
 and c.perCurp <> 'XEXX010101MNEXXXA8' and c.perCurp <> 'XEXX010101MNEXXXA4' and LENGTH(ltrim(rtrim(c.perCurp))) > 0
 and p.deleted_at is null and p.perCurp = ?", [$nosoymexicano]);



                alert('Escuela Modelo', 'El candidato se ha creado con éxito','success')->showConfirmButton();
                return redirect('candidatos_primer_ingreso');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('candidatos_primer_ingreso/create')->withInput();
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
        $candidato = Candidato::findOrFail($id);
        $municipio = Municipio::where("id", "=", $candidato->perLugarNac)->first();
        $preparatoriaProcedencia = PreparatoriaProcedencia::where("id", "=", $candidato->preparatoria_id)->first();

        $existeNombre = Persona::where("perApellido1", "$candidato->perApellido1")
            ->where("perApellido2", "$candidato->perApellido2")
            ->where("perNombre", "$candidato->perNombre")
            ->where("perFechaNac", "$candidato->perFechaNac")
            ->first();

        $disabled = '';
        if ($existeNombre && $candidato->candidatoPreinscrito == 'NO') {
            $existeEmpleado = Empleado::where('persona_id', $existeNombre->id)->first();
            $existeAlumno = Alumno::where('persona_id', $existeNombre->id)->first();
            $datoEmpleado = $existeEmpleado ? "\nNo. Empleado: {$existeEmpleado->id}" : "";
            $datoAlumno = $existeAlumno ? "\nClave de Pago: {$existeAlumno->aluClave}" : "";
            
            $mensaje = "El nombre y apellidos existen en nuestra base de datos, pero no es posible verificar automáticamente debido a falta de datos. Favor de verificar que exista el alumno o empleado. \n{$datoEmpleado} {$datoAlumno}";
            $disabled = 'disabled';
            return view('candidatos.show',compact('candidato', 'municipio', 'preparatoriaProcedencia', 'mensaje', 'disabled'));
        }

        return view('candidatos.show',compact('candidato', 'municipio', 'preparatoriaProcedencia', 'disabled'));
    }


    public function preregistro(Request $request)
    {
        $departamentos = Departamento::whereIn("depNivel", [5,6])->get()->unique("depClave");
        $paises = Pais::get();

        $candidato = Candidato::where("id", "=", $request->candidatoId)->first();
        $municipio = Municipio::with('estado.pais')->where("id", "=", $candidato->perLugarNac)->first();


        $campus = $candidato->ubicacion_id;
        $departamento = $candidato->departamento_id;
        $programa = $candidato->programa_id;


        $preparatoriaProcedencia = PreparatoriaProcedencia::where("id", "=", $candidato->preparatoria_id)->first();

        return view('alumno.create', compact(
            'departamentos', 'paises', 'candidato',
            'municipio', 'preparatoriaProcedencia',
            'campus', 'departamento', 'programa'
        ));
    }

    public function cancel($id)
    {
        $candidato = Candidato::findOrFail($id);
        $candidato->update([
            'candidatoEstatus' => 'CANCELADO (Interesado ya existe como alumno)',
        ]);
        return redirect()->back();
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
        if (User::permiso("beca") == "A" || User::permiso("beca") == "B") {
            $beca = Candidato::findOrFail($id);
            return view('beca.edit', compact('beca'));
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
    public function update(Request $request, $id)
    {


        if (!(User::permiso("beca") == "A" || User::permiso("beca") == "B")) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('beca');
        }

        $validator = Validator::make($request->all(),
            [
                'bcaClave'       => 'required',
                'bcaNombre'      => 'required',
                'bcaNombreCorto' => 'required',
                'bcaVigencia'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // $programa_id = $request->input('programa_id');
            // if (Utils::validaPermiso('beca',$programa_id)) {
            //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            //     return redirect()->to('beca/' . $id . '/edit');
            // }
            try {
                $beca = Candidato::findOrFail($id);
                $beca->bcaClave       = $request->input('bcaClave');
                $beca->bcaNombre      = $request->input('bcaNombre');
                $beca->bcaNombreCorto = $request->input('bcaNombreCorto');
                $beca->bcaVigencia    = $request->input('bcaVigencia');
                $beca->save();
                alert('Escuela Modelo', 'La beca se ha actualizado con éxito','success')->showConfirmButton();
                return redirect('beca');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect()->back()->withInput();
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
        if (User::permiso("beca") == "A" || User::permiso("beca") == "B") {
            $beca = Candidato::findOrFail($id);

            try {
                if ($beca->delete()) {
                    alert('Escuela Modelo', 'La beca se ha eliminado con éxito','success');
                } else {
                    alert()->error('Error...', 'No se puedo eliminar la beca')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode    = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }
        return redirect()->back()->withInput();
    }

    public function preparatoriaProcedenciaCandidatos (Request $request)
    {
        return PreparatoriaProcedencia::where("municipio_id", "=", $request->municipio_id)
            ->where("prepHomologada", "=", "SI")
            ->orderBy("prepNombre")
        ->get();
    }
}

<?php

namespace App\Http\Controllers\Primaria;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Alumno;
use App\Http\Models\Pais;
use App\Http\Models\Primaria\Primaria_alumnos_entrevista;
use App\Http\Models\Primaria\Primaria_expediente_entrevista_inicial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use App\clases\departamentos\MetodosDepartamentos as Departamentos;
use App\Http\Helpers\Utils;
use App\Http\Models\Estado;
use App\Http\Models\Municipio;
use App\Http\Models\Persona;
use Illuminate\Support\Str;


class PrimariaAlumnosEntrevistaInicialController extends Controller
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
        return view('primaria.entrevista_inicial.show-list');
    }

    public function list()
    {
        $alumno_entrevista = Primaria_expediente_entrevista_inicial::select('primaria_expediente_entrevista_inicial.*',
        'alumnos.aluClave', 'personas.perApellido1', 'personas.perApellido2', 'personas.perNombre', 'personas.perCurp')
        ->join('alumnos', 'primaria_expediente_entrevista_inicial.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id');


        return DataTables::of($alumno_entrevista)
        ->filterColumn('clave_pago',function($query,$keyword){
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('clave_pago',function($query){
            return $query->aluClave;
        })

        // apellido paterno 
        ->filterColumn('apellido_paterno',function($query,$keyword){
            $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('apellido_paterno',function($query){
            return $query->perApellido1;
        })

        // apellido materno 
        ->filterColumn('apellido_materno',function($query,$keyword){
            $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('apellido_materno',function($query){
            return $query->perApellido2;
        })

        // nombres 
        ->filterColumn('nombres_alumno',function($query,$keyword){
            $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('nombres_alumno',function($query){
            return $query->perNombre;
        })

        // curp alumno 
        ->filterColumn('curp_alumno',function($query,$keyword){
            $query->whereRaw("CONCAT(perCurp) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('curp_alumno',function($query){
            return $query->perCurp;
        })

        ->addColumn('action',function($query){
            return '<a href="primaria_entrevista_inicial/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="primaria_entrevista_inicial/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            
            <a href="primaria_entrevista_inicial/imprimir/' . $query->id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Entrevista inicial" >
                <i class="material-icons">picture_as_pdf</i>
            </a>

            <form id="delete_' . $query->id . '" action="primaria_entrevista_inicial/' . $query->id . '" method="POST" style="display:inline; display:none;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>
            ';
        })->make(true);

    }

    public function agregarEntrevista()
    {
        // obtiene alumnos pertenecientes al departamento primaria 
        $alumnos =  DB::select("SELECT DISTINCT alumnos.id as alumno_id,
        alumnos.aluClave,
        personas.perNombre,
        personas.perApellido1,
        personas.perApellido2
        FROM cursos as cursos
        INNER JOIN alumnos as alumnos on alumnos.id = cursos.alumno_id
        INNER JOIN periodos as periodos on periodos.id = cursos.periodo_id
        INNER JOIN departamentos as departamentos on departamentos.id = periodos.departamento_id
        INNER JOIN personas as personas on personas.id = alumnos.persona_id
        WHERE departamentos.depClave = 'PRI'
        ORDER BY personas.perApellido1 ASC");

        $paises = Pais::get();

        $departamentos = Departamentos::buscarSoloAcademicos(1, ['PRI'])->unique("depClave");


        $user_empleado = User::with('empleado.persona')->where('id', auth()->id())->first();
        $empleado = $user_empleado->empleado->persona->perNombre.' '.$user_empleado->empleado->persona->perApellido1.' '.$user_empleado->empleado->persona->perApellido2;


        return view('primaria.entrevista_inicial.crear-entrevista', [
            'alumnos' => $alumnos,
            'paises'  => $paises,
            'empleado' => $empleado,
            'departamentos' => $departamentos
        ]);
    }

    public function getDatosAlumno(Request $request, $id)
    {
        if($request->ajax()){

            $alumnos = Alumno::select('alumnos.id', 'personas.perNombre', 'personas.perApellido1', 
            'personas.perApellido2', 'personas.perFechaNac', 'personas.municipio_id', 'municipios.munNombre',
            'estados.edoNombre', 'paises.paisNombre')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('municipios', 'personas.municipio_id', '=', 'municipios.id')
            ->join('estados', 'municipios.estado_id', '=', 'estados.id')
            ->join('paises', 'estados.pais_id', '=', 'paises.id')
            ->where('alumnos.id', '=', $id)
            ->get();

            // return response()->json($alumnos);
            return response()->json($alumnos);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $paises = Pais::get();

    //     return view('primaria.entrevista_inicial.create', [
    //         'paises' => $paises
    //     ]);
    // }

    public function guardarEntrevista(Request $request)
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
                'aluClave'              => 'unique:alumnos,aluClave,NULL,id,deleted_at,NULL',
                'persona_id'            => 'unique:alumnos,persona_id,NULL,id,deleted_at,NULL',
                'aluNivelIngr'          => 'required|max:4',
                'aluGradoIngr'          => 'required|max:4',
                'perNombre'             => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'          => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'          => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'               =>  $perCurpValida,
                'esCurpValida'          => $esCurpValida,
                'perFechaNac'           => 'required|before_or_equal:' . $fechaActual,
                'municipio_id'          => 'required',
                'perSexo'               => 'required',
                // 'nombrePadre'           => 'required',
                // 'apellido1Padre'        => 'required',
                // 'celularPadre'          => 'min:10',
                // 'nombreMadre'           => 'required',
                // 'apellido1Madre'        => 'required',
                // 'celularMadre'          => 'min:10',
                // 'celularTutor'          => 'min:10',
                'celularReferencia1'    => 'nullable|min:10',
                'celularReferencia2'    => 'nullable|min:10',
                'celularReferencia3'    => 'nullable|min:10',
                'tutorResponsable'      => 'required',
                'accidenteLlamar'       => 'required'

            ],
            [
                // 'expCurpAlumno.unique'          => "La CURP ya se encuentra registrada",
                // 'expCelularTutorMadre.min'      => "El celular de la madre debe contener al menos 10 dígitos",
                // 'expTelefonoCasaTutorMadre.min' => "El télefono de la madre debe contener al menos 7 dígitos",
                // 'nombrePadre.required' => "El campo Nombre padre es obligatorio",
                // 'apellido1Padre.required' => "El campo Apellido 1 padre es obligatorio",
                // 'celularPadre.min'      => "El celular del padre debe contener al menos 10 dígitos",
                // 'nombreMadre.required' => "El campo Nombre madre es obligatorio",
                // 'apellido1Madre.required' => "El campo Apellido 1 madre es obligatorio",
                'celularMadre.min'      => "El celular de la madre debe contener al menos 10 dígitos",
                'celularTutor.min'      => "El celular del tutor debe contener al menos 10 dígitos",
                'celularReferencia1.min'      => "El celular de la referencia 1 debe contener al menos 10 dígitos",
                'celularReferencia2.min'      => "El celular de la referencia 2 debe contener al menos 10 dígitos",
                'celularReferencia3.min'      => "El celular de la referencia 3 debe contener al menos 10 dígitos",
                'tutorResponsable.required' => "El campo Padre o tutor responsable financiero es obligatorio",
                'accidenteLlamar.required' => "El campo En caso de algún accidente se deberá llamar a es obligatorio",
                'aluClave.unique'   => "El alumno ya existe",
                'persona_id.unique' => "La persona ya existe",
                'perCurp.unique'    => "Ya existe registrado un alumno con esta misma clave CURP. "
                . "Favor de consultar los datos del alumno existente, con su clave registrada: "
                . $aluClave,
                'perCurp.max' => 'El campo de CURP no debe contener más de 18 caracteres',
                'esCurpValida.accepted' => 'La CURP proporcionada no es válida. Favor de verificarla.',
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


                // 'celularPadre.max'      => "El celular del padre debe contener 10 dígitos"
                // 'expTelefonoCasaTutorPadre'     => "El télefono del padre debe contener al menos 7 dígitos"
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_entrevista_inicial/create')->withErrors($validator)->withInput();
        } else {

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
            if ($request->paisId != "1" && $request->perSexo == "F"
            ) {
                $perCurp = "XEXX010101MNEXXXA8";
            }

            try {

                $persona = Persona::create([
                    'perCurp'        => $perCurp,
                    'perApellido1'   => $request->perApellido1,
                    'perApellido2'   => $request->perApellido2 ? $request->perApellido2 : "",
                    'perNombre'      => $request->perNombre,
                    'perFechaNac'    => $request->perFechaNac,
                    'municipio_id'   => Utils::validaEmpty($request->municipio_id),
                    'perSexo'        => $request->perSexo,
                ]);

                $alumno = Alumno::create([
                    'persona_id'      => $persona->id,
                    'aluClave'        => (int) $claveAlu,
                    'aluNivelIngr'    => Utils::validaEmpty($request->aluNivelIngr),
                    'aluGradoIngr'    => Utils::validaEmpty($request->aluGradoIngr),
                    'aluMatricula'    => $request->aluMatricula,
                    'preparatoria_id' => 0,
                    'candidato_id'    => null
                ]);

                /* Si el alumno registrado se repite como candidato */
                $nosoymexicano = $request->noSoyMexicano ? $perCurp : $request->input('perCurp');
                DB::update("update candidatos c, personas p set  c.candidatoPreinscrito = 'SI' where c.perCurp = p.perCurp
            and c.perCurp <> 'XEXX010101MNEXXXA8' and c.perCurp <> 'XEXX010101MNEXXXA4' and LENGTH(ltrim(rtrim(c.perCurp))) > 0
            and p.deleted_at is null and p.perCurp = ?", [$nosoymexicano]);

                if ($alumno) {

                    if($request->preescolar1 == "" || $request->preescolar1 == "NO"){
                        $preescolar1 = "NO";
                    }else{
                        $preescolar1 = "SI";
                    }
    
                    if($request->preescolar2 == "" || $request->preescolar2 == "NO"){
                        $preescolar2 = "NO";
                    }else{
                        $preescolar2 = "SI";
                    }
    
                    if($request->preescolar3 == "" || $request->preescolar3 == "NO"){
                        $preescolar3 = "NO";
                    }else{
                        $preescolar3 = "SI";
                    }
    
                    if($preescolar1 == "SI" || $preescolar2 == "SI" || $preescolar2 == "SI"){
                        $estudioPreescolar = "SI";
                    }else{
                        $estudioPreescolar = "NO";
                    }

                    Primaria_expediente_entrevista_inicial::create([
                        'alumno_id' => $alumno->id,
                        'gradoInscrito' => $request->aluGradoIngr,
                        'tiempoResidencia' => $request->tiempoResidencia,
                        'apellido1Padre' => $request->apellido1Padre,
                        'apellido2Padre' => $request->apellido2Padre,
                        'nombrePadre' => $request->nombrePadre,
                        'curpPadre' => $request->curpPadre,
                        'celularPadre' => $request->celularPadre,
                        'edadPadre' => $request->edadPadre,
                        'ocupacionPadre' => $request->ocupacionPadre,
                        'direccionPadre' => $request->direccionPadre,
                        'empresaPadre' => $request->empresaPadre,
                        'correoPadre' => $request->correoPadre,
                        'apellido1Madre' => $request->apellido1Madre,
                        'apellido2Madre' => $request->apellido2Madre,
                        'nombreMadre' => $request->nombreMadre,
                        'curpMadre' => $request->curpMadre,
                        'celularMadre' => $request->celularMadre,
                        'edadMadre' => $request->edadMadre,
                        'ocupacionMadre' => $request->ocupacionMadre,
                        'direccionMadre' => $request->direccionMadre,
                        'empresaMadre' => $request->empresaMadre,
                        'correoMadre' => $request->correoMadre,
                        'estadoCivilPadres' => $request->estadoCivilPadres,
                        'religion' => $request->religion,
                        'observaciones' => $request->observaciones,
                        'condicionFamiliar' => $request->condicionFamiliar,
                        'tutorResponsable' => $request->tutorResponsable,
                        'celularTutor' => $request->celularTutor,
                        'accidenteLlamar' => $request->accidenteLlamar,
                        'celularAccidente' => $request->celularAccidente,
                        'perAutorizada1' => $request->perAutorizada1,
                        'perAutorizada2' => $request->perAutorizada2,
                        'integrante1' => $request->integrante1,
                        'relacionIntegrante1' => $request->relacionIntegrante1,
                        'edadintegrante1' => $request->edadintegrante1,
                        'ocupacionIntegrante1' => $request->ocupacionIntegrante1,
                        'integrante2' => $request->integrante2,
                        'relacionIntegrante2' => $request->relacionIntegrante2,
                        'edadintegrante2' => $request->edadintegrante2,
                        'ocupacionIntegrante2' => $request->ocupacionIntegrante2,
                        'integrante3' => $request->integrante3,
                        'relacionIntegrante3' => $request->relacionIntegrante3,
                        'edadintegrante3' => $request->edadintegrante3,
                        'ocupacionIntegrante3' => $request->ocupacionIntegrante3,
                        'integrante4' => $request->integrante4,
                        'relacionIntegrante4' => $request->relacionIntegrante4,
                        'edadintegrante4' => $request->edadintegrante4,
                        'ocupacionIntegrante4' => $request->ocupacionIntegrante4,
                        'integrante5' => $request->integrante5,
                        'relacionIntegrante5' => $request->relacionIntegrante5,
                        'edadintegrante5' => $request->edadintegrante5,
                        'ocupacionIntegrante5' => $request->ocupacionIntegrante5,
                        'integrante6' => $request->integrante6,
                        'relacionIntegrante6' => $request->relacionIntegrante6,
                        'edadintegrante6' => $request->edadintegrante6,
                        'ocupacionIntegrante6' => $request->ocupacionIntegrante6,
                        'integrante7' => $request->integrante7,
                        'relacionIntegrante7' => $request->relacionIntegrante7,
                        'edadintegrante7' => $request->edadintegrante7,
                        'ocupacionIntegrante7' => $request->ocupacionIntegrante7,
                        'conQuienViveAlumno' => $request->conQuienViveAlumno,
                        'direccionViviendaAlumno' => $request->direccionViviendaAlumno,
                        'situcionLegal' => $request->situcionLegal,
                        'descripcionNinio' => $request->descripcionNinio,
                        'apoyoTarea' => $request->apoyoTarea,
                        'escuelaAnterior' => $request->escuelaAnterior,
                        'aniosEstudiados' => $request->aniosEstudiados,
                        'motivosCambioEscuela' => $request->motivosCambioEscuela,
                        'kinder' => $request->kinder,
                        'observacionEscolar' => $request->observacionEscolar,
                        'estudioPreescolar' => $estudioPreescolar,
                        'preescolar1' => $preescolar1,
                        'preescolar2' => $preescolar2,
                        'preescolar3' => $preescolar3,
                        'promedio1' => $request->promedio1,
                        'promedio2' => $request->promedio2,
                        'promedio3' => $request->promedio3,
                        'promedio4' => $request->promedio4,
                        'promedio5' => $request->promedio5,
                        'promedio6' => $request->promedio6,
                        'recursamientoGrado' => $request->recursamientoGrado,
                        'deportes' => $request->deportes,
                        'apoyoPedagogico' => $request->apoyoPedagogico,
                        'obsPedagogico' => $request->obsPedagogico,
                        'terapiaLenguaje' => $request->terapiaLenguaje,
                        'obsTerapiaLenguaje' => $request->obsTerapiaLenguaje,
                        'tratamientoMedico' => $request->tratamientoMedico,
                        'obsTratamientoMedico' => $request->obsTratamientoMedico,
                        'hemofilia' => $request->hemofilia,
                        'obsHemofilia' => $request->obsHemofilia,
                        'epilepsia' => $request->epilepsia,
                        'obsEpilepsia' => $request->obsEpilepsia,
                        'kawasaqui' => $request->kawasaqui,
                        'obsKawasaqui' => $request->obsKawasaqui,
                        'asma' => $request->asma,
                        'obsAsma' => $request->obsAsma,
                        'diabetes' => $request->diabetes,
                        'obsDiabetes' => $request->obsDiabetes,
                        'cardiaco' => $request->cardiaco,
                        'obsCardiaco' => $request->obsCardiaco,
                        'dermatologico' => $request->dermatologico,
                        'obsDermatologico' => $request->obsDermatologico,
                        'alergias' => $request->alergias,
                        'tipoAlergias' => $request->tipoAlergias,
                        'otroTratamiento' => $request->otroTratamiento,
                        'tomaMedicamento' => $request->tomaMedicamento,
                        'cuidadoEspecifico' => $request->cuidadoEspecifico,
                        'tratimientoNeurologico' => $request->tratimientoNeurologico,
                        'obsTratimientoNeurologico' => $request->obsTratimientoNeurologico,
                        'tratamientoPsicologico' => $request->tratamientoPsicologico,
                        'obsTratimientoPsicologico' => $request->obsTratimientoPsicologico,
                        'medicoTratante' => $request->medicoTratante,
                        'llevarAlNinio' => $request->llevarAlNinio,
                        'motivoInscripcionEscuela' => $request->motivoInscripcionEscuela,
                        'conocidoEscuela1' => $request->conocidoEscuela1,
                        'conocidoEscuela2' => $request->conocidoEscuela2,
                        'conocidoEscuela3' => $request->conocidoEscuela3,
                        'referencia1' => $request->referencia1,
                        'celularReferencia1' => $request->celularReferencia1,
                        'referencia2' => $request->referencia2,
                        'celularReferencia2' => $request->celularReferencia2,
                        'referencia3' => $request->referencia3,
                        'celularReferencia3' => $request->celularReferencia3,
                        'obsGenerales' => $request->obsGenerales,
                        'entrevistador' => $request->entrevistador,
                        'estatus_edicion' => 1
                    ]);
                }


                alert('Escuela Modelo', 'La entrevista se ha creado con éxito', 'success')->showConfirmButton();
                return redirect('primaria_entrevista_inicial');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...' . $errorCode,
                    $errorMessage
                )
                ->showConfirmButton();
                return redirect('primaria_entrevista_inicial/create')->withInput();
            }
        }
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumnoEntrevista = Primaria_expediente_entrevista_inicial::where('id', $id)->first();

        $alumno = Alumno::findOrFail($alumnoEntrevista->alumno_id);
        $persona = Persona::findOrFail($alumno->persona_id);

        $municipio = Municipio::findOrFail($persona->municipio_id);
        $estado = Estado::findOrFail($municipio->estado_id);
        $pais = Pais::findOrFail($estado->pais_id);


        $departamentos = Departamentos::buscarSoloAcademicos(1, ['PRI'])->unique("depClave");

      


        return view('primaria.entrevista_inicial.show', [
            'alumnoEntrevista' => $alumnoEntrevista,
            'alumno' => $alumno,
            'persona' => $persona,
            'departamentos' => $departamentos,
            'pais' => $pais,
            'estado' => $estado,
            'municipio' => $municipio
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
        $alumnoEntrevista = Primaria_expediente_entrevista_inicial::where('id', $id)->first();

        $alumno = Alumno::findOrFail($alumnoEntrevista->alumno_id);
        $persona = Persona::findOrFail($alumno->persona_id);
        // obtiene alumnos pertenecientes al departamento primaria 
        
        $paises = Pais::get();
        $municipios = Municipio::get();
        $estados = Estado::get();
        $departamentos = Departamentos::buscarSoloAcademicos()->unique("depClave");

        $estado_alumno = Municipio::select('estados.id as estado_id')
        ->join('estados', 'municipios.estado_id', '=', 'estados.id')
        ->where('municipios.id', $persona->municipio_id)->first();

         // pais del madre 
        $pais_alumno = Estado::select('paises.id as pais_id')
        ->join('paises', 'estados.pais_id', '=', 'paises.id')
        ->where('estados.id', $estado_alumno->estado_id)->first();


        $user_empleado = User::with('empleado.persona')->where('id', auth()->id())->first();
        $empleado = $user_empleado->empleado->persona->perNombre.' '.$user_empleado->empleado->persona->perApellido1.' '.$user_empleado->empleado->persona->perApellido2;

        return view('primaria.entrevista_inicial.edit', [
            'paises'  => $paises,
            'alumnoEntrevista' => $alumnoEntrevista,
            'empleado' => $empleado,
            'departamentos' => $departamentos,
            'persona' => $persona,
            'alumno' => $alumno,
            'estado_alumno' => $estado_alumno,
            'pais_alumno' => $pais_alumno,
            'municipios' => $municipios,
            'estados' => $estados
        ]);
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
        $esCurpValida = "accepted";
        $perCurpValida = 'required|max:18|unique:personas';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) {// si pais es diferente de mexico
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }

        //Para la curp del Padre
        // $esCurpValidaPadre = "accepted";
        // $curpPadreValida = 'required|max:18|unique:primaria_expediente_entrevista_inicial';
        // if ($request->curpPadreOld == $request->curpPadre) {// si pais es diferente de mexico
        //     $esCurpValidaPadre = "";
        //     $curpPadreValida  = 'max:18';
        // }

        // //Para la curp del Madre
        // $esCurpValidaMadre = "accepted";
        // $curpMadreCurpValida = 'required|max:18|unique:primaria_expediente_entrevista_inicial';
        // if ($request->curpMadreOld == $request->curpMadre) {// si pais es diferente de mexico
        //     $esCurpValidaMadre = "";
        //     $curpMadreCurpValida  = 'max:18';
        // }

        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8" )) {
            $esCurpValida = "accepted";
            $perCurpValida = 'required|max:18|unique:personas';
        }

        $validator = Validator::make($request->all(),
        [
            'celularPadre'          => 'nullable|min:10',
            'celularMadre'          => 'nullable|min:10',
            'celularTutor'          => 'nullable|min:10',
            'celularReferencia1'    => 'nullable|min:10',
            'celularReferencia2'    => 'nullable|min:10',
            'celularReferencia3'    => 'nullable|min:10',
            'aluGradoIngr' => 'required|max:4',
            'perNombre' => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
            'perApellido1'  => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
            'perApellido2'  => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
            'perCurp'   => $perCurpValida,
            'esCurpValida' => $esCurpValida,
            'perFechaNac'   => 'required',
            'municipio_id' => 'required',
            'perSexo'   => 'required',
            // 'curpPadre'   => $curpPadreValida,
            // 'esCurpValidaPadre' => $esCurpValidaPadre,
            // 'curpMadre'   => $curpMadreCurpValida,
            // 'esCurpValidaMadre' => $esCurpValidaMadre,
            

        ],
        [
            // 'expCurpAlumno.unique'          => "La CURP ya se encuentra registrada",
            // 'expCelularTutorMadre.min'      => "El celular de la madre debe contener al menos 10 dígitos",
            // 'expTelefonoCasaTutorMadre.min' => "El télefono de la madre debe contener al menos 7 dígitos",
            'celularPadre.min'      => "El celular del padre debe contener al menos 10 dígitos",
            'celularMadre.min'      => "El celular de la madre debe contener al menos 10 dígitos",
            'celularTutor.min'      => "El celular del tutor debe contener al menos 10 dígitos",
            'celularReferencia1.min'      => "El celular de la referencia 1 debe contener al menos 10 dígitos",
            'celularReferencia2.min'      => "El celular de la referencia 2 debe contener al menos 10 dígitos",
            'celularReferencia3.min'      => "El celular de la referencia 3 debe contener al menos 10 dígitos",
            'aluGradoIngr.required' => 'El grado de ingreso es obligatorio (apartado INFORMACIÓN PERSONAL Y FAMILIAR DEL ALUMNO)',
            'perNombre.required' => 'El nombre es obligatorio',
            'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            'perApellido1.required' => 'El apellido paterno es obligatorio',
            'perApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            'perApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            'perFechaNac.required' => 'La fecha de nacimiento es obligatoria.',
            'municipio_id.required' => 'El municipio es obligatorio',
            'perSexo.required' => 'El sexo es obligatorio',


            // 'celularPadre.max'      => "El celular del padre debe contener 10 dígitos"
            // 'expTelefonoCasaTutorPadre'     => "El télefono del padre debe contener al menos 7 dígitos"
        ]
        );

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

        if ($validator->fails()) {
            return redirect ('primaria_entrevista_inicial/'.$id.'/edit')->withErrors($validator)->withInput();
        }else{
            try {

                $entrevistaAlumno = Primaria_expediente_entrevista_inicial::where('id', $id)->first();

                $alumno = Alumno::findOrFail($entrevistaAlumno->alumno_id);
                $persona = Persona::findOrFail($alumno->persona_id);

                $alumno->update([
                    'aluGradoIngr' => $request->aluGradoIngr
                ]);

                $persona->update([
                    'perApellido1' => $request->perApellido1,
                    'perApellido2' => $request->perApellido2,
                    'perNombre' => $request->perNombre,
                    'perCurp' => $perCurp,
                    'perSexo' => $request->perSexo,
                    'municipio_id' => $request->municipio_id
                ]);

                if($request->preescolar1 == "" || $request->preescolar1 == "NO"){
                    $preescolar1 = "NO";
                }else{
                    $preescolar1 = "SI";
                }

                if($request->preescolar2 == "" || $request->preescolar2 == "NO"){
                    $preescolar2 = "NO";
                }else{
                    $preescolar2 = "SI";
                }

                if($request->preescolar3 == "" || $request->preescolar3 == "NO"){
                    $preescolar3 = "NO";
                }else{
                    $preescolar3 = "SI";
                }

                if($preescolar1 == "SI" || $preescolar2 == "SI" || $preescolar3 == "SI"){
                    $estudioPreescolar = "SI";
                }else{
                    $estudioPreescolar = "NO";
                }

                $entrevistaAlumno->update([
                'alumno_id' => $entrevistaAlumno->alumno_id, 
                'gradoInscrito' => $request->aluGradoIngr, 
                'tiempoResidencia' => $request->tiempoResidencia, 
                'apellido1Padre' => $request->apellido1Padre, 
                'apellido2Padre' => $request->apellido2Padre, 
                'curpPadre' => $request->curpPadre, 
                'nombrePadre' => $request->nombrePadre, 
                'celularPadre' => $request->celularPadre, 
                'edadPadre' => $request->edadPadre, 
                'ocupacionPadre' => $request->ocupacionPadre, 
                'direccionPadre' => $request->direccionPadre, 
                'empresaPadre' => $request->empresaPadre, 
                'correoPadre' => $request->correoPadre, 
                'apellido1Madre' => $request->apellido1Madre, 
                'apellido2Madre' => $request->apellido2Madre, 
                'nombreMadre' => $request->nombreMadre, 
                'curpMadre' => $request->curpMadre, 
                'celularMadre' => $request->celularMadre, 
                'edadMadre' => $request->edadMadre, 
                'ocupacionMadre' => $request->ocupacionMadre,
                'direccionMadre' => $request->direccionMadre,  
                'empresaMadre' => $request->empresaMadre, 
                'correoMadre' => $request->correoMadre, 
                'estadoCivilPadres' => $request->estadoCivilPadres, 
                'religion' => $request->religion, 
                'observaciones' => $request->observaciones, 
                'condicionFamiliar' => $request->condicionFamiliar, 
                'tutorResponsable' => $request->tutorResponsable, 
                'celularTutor' => $request->celularTutor, 
                'accidenteLlamar' => $request->accidenteLlamar, 
                'celularAccidente' => $request->celularAccidente, 
                'perAutorizada1' => $request->perAutorizada1,
                'perAutorizada2' => $request->perAutorizada2,
                'integrante1' => $request->integrante1, 
                'relacionIntegrante1' => $request->relacionIntegrante1, 
                'edadintegrante1' => $request->edadintegrante1, 
                'ocupacionIntegrante1' => $request->ocupacionIntegrante1, 
                'integrante2' => $request->integrante2, 
                'relacionIntegrante2' => $request->relacionIntegrante2, 
                'edadintegrante2' => $request->edadintegrante2, 
                'ocupacionIntegrante2' => $request->ocupacionIntegrante2, 
                'integrante3' => $request->integrante3,
                'relacionIntegrante3' => $request->relacionIntegrante3,
                'edadintegrante3' => $request->edadintegrante3,
                'ocupacionIntegrante3' => $request->ocupacionIntegrante3,
                'integrante4' => $request->integrante4,
                'relacionIntegrante4' => $request->relacionIntegrante4,
                'edadintegrante4' => $request->edadintegrante4,
                'ocupacionIntegrante4' => $request->ocupacionIntegrante4,
                'integrante5' => $request->integrante5,
                'relacionIntegrante5' => $request->relacionIntegrante5,
                'edadintegrante5' => $request->edadintegrante5,
                'ocupacionIntegrante5' => $request->ocupacionIntegrante5,
                'integrante6' => $request->integrante6,
                'relacionIntegrante6' => $request->relacionIntegrante6,
                'edadintegrante6' => $request->edadintegrante6,
                'ocupacionIntegrante6' => $request->ocupacionIntegrante6,
                'integrante7' => $request->integrante7,
                'relacionIntegrante7' => $request->relacionIntegrante7,
                'edadintegrante7' => $request->edadintegrante7,
                'ocupacionIntegrante7' => $request->ocupacionIntegrante7,
                'conQuienViveAlumno' => $request->conQuienViveAlumno, 
                'direccionViviendaAlumno' => $request->direccionViviendaAlumno,
                'situcionLegal' => $request->situcionLegal, 
                'descripcionNinio' => $request->descripcionNinio, 
                'apoyoTarea' => $request->apoyoTarea, 
                'escuelaAnterior' => $request->escuelaAnterior, 
                'aniosEstudiados' => $request->aniosEstudiados, 
                'motivosCambioEscuela' => $request->motivosCambioEscuela,
                'kinder' => $request->kinder,
                'observacionEscolar' => $request->observacionEscolar,
                'estudioPreescolar' => $estudioPreescolar,
                'preescolar1' => $preescolar1,
                'preescolar2' => $preescolar2,
                'preescolar3' => $preescolar3,
                'promedio1' => $request->promedio1,
                'promedio2' => $request->promedio2,
                'promedio3' => $request->promedio3,
                'promedio4' => $request->promedio4,
                'promedio5' => $request->promedio5,
                'promedio6' => $request->promedio6,
                'recursamientoGrado' => $request->recursamientoGrado,
                'deportes' => $request->deportes,
                'apoyoPedagogico' => $request->apoyoPedagogico,
                'obsPedagogico' => $request->obsPedagogico,
                'terapiaLenguaje' => $request->terapiaLenguaje,
                'obsTerapiaLenguaje' => $request->obsTerapiaLenguaje,
                'tratamientoMedico' => $request->tratamientoMedico,
                'obsTratamientoMedico' => $request->obsTratamientoMedico,
                'hemofilia' => $request->hemofilia,
                'obsHemofilia' => $request->obsHemofilia,
                'epilepsia' => $request->epilepsia,
                'obsEpilepsia' => $request->obsEpilepsia,
                'kawasaqui' => $request->kawasaqui,
                'obsKawasaqui' => $request->obsKawasaqui, 
                'asma' => $request->asma,
                'obsAsma' => $request->obsAsma,
                'diabetes' => $request->diabetes,
                'obsDiabetes' => $request->obsDiabetes,
                'cardiaco' => $request->cardiaco,
                'obsCardiaco' => $request->obsCardiaco,
                'dermatologico' => $request->dermatologico,
                'obsDermatologico' => $request->obsDermatologico,
                'alergias' => $request->alergias,
                'tipoAlergias' => $request->tipoAlergias,
                'otroTratamiento' => $request->otroTratamiento,
                'tomaMedicamento' => $request->tomaMedicamento,
                'cuidadoEspecifico' => $request->cuidadoEspecifico,
                'tratimientoNeurologico' => $request->tratimientoNeurologico,
                'obsTratimientoNeurologico' => $request->obsTratimientoNeurologico,
                'tratamientoPsicologico' => $request->tratamientoPsicologico,
                'obsTratimientoPsicologico' => $request->obsTratimientoPsicologico,
                'medicoTratante' => $request->medicoTratante,
                'llevarAlNinio'=> $request->llevarAlNinio,
                'motivoInscripcionEscuela' => $request->motivoInscripcionEscuela,
                'conocidoEscuela1' => $request->conocidoEscuela1,
                'conocidoEscuela2' => $request->conocidoEscuela2,
                'conocidoEscuela3' => $request->conocidoEscuela3,
                'referencia1' => $request->referencia1,
                'celularReferencia1' => $request->celularReferencia1,
                'referencia2' => $request->referencia2,
                'celularReferencia2' => $request->celularReferencia2,
                'referencia3' => $request->referencia3,
                'celularReferencia3' => $request->celularReferencia3,
                'obsGenerales' => $request->obsGenerales,
                'entrevistador' => $request->nombreEntrevistador,
                'estatus_edicion' => 1
                ]);
    
                alert('Escuela Modelo', 'La entrevista se ha actualizado con éxito','success')->showConfirmButton();
                return redirect('primaria_entrevista_inicial');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('primaria_entrevista_inicial')->withInput();
            }
        }

    }

    public function imprimir($id)
    {
    

        $alumnoEntrevista = Primaria_expediente_entrevista_inicial::select(
            'primaria_expediente_entrevista_inicial.*',
            'alumnos.aluClave',
            'personas.perNombre', 
            'personas.perApellido1', 
            'personas.perApellido2',
            'personas.perFechaNac', 
            'personas.perCurp', 
            'municipios.munNombre', 
            'estados.edoNombre', 
            'paises.paisNombre',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'programas.id as programa_id',
            'planes.id as plan_id',
            'periodos.id as periodo_id',
            'periodos.perAnioPago',
            'programas.progClave',
            'programas.progNombre'
        )
        ->join('alumnos', 'primaria_expediente_entrevista_inicial.alumno_id', '=', 'alumnos.id')
        ->join('cursos', 'alumnos.id', '=', 'cursos.alumno_id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('municipios', 'personas.municipio_id', '=', 'municipios.id')
        ->join('estados', 'municipios.estado_id', '=', 'estados.id')
        ->join('paises', 'estados.pais_id', '=', 'paises.id')
        ->where('primaria_expediente_entrevista_inicial.id', $id)
        ->first();


      


        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $anioNacimiento = explode("-", $alumnoEntrevista->perFechaNac);        
        $anoHoy = $fechaActual->format('Y');

        // calcular edad (año actual - año nacimiento alumno)
        $edadCalculada = $anoHoy - $anioNacimiento[0];

        $parametro_NombreArchivo = "pdf_primaria_entrevista_inicial";
        $pdf = PDF::loadView('reportes.pdf.primaria.entrevista_inicial.' . $parametro_NombreArchivo, [
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "edadCalculada" => $edadCalculada,
            "alumnoEntrevista" => $alumnoEntrevista
        ]);


        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    public function imprimirBlanco()
    {

        $parametro_NombreArchivo = "pdf_primaria_entrevista_inicial_formato_blanco";
        $pdf = PDF::loadView('reportes.pdf.primaria.entrevista_inicial.' . $parametro_NombreArchivo, [
           
        ]);


        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function imprimir_formato_de_salida()
    {
        # code...
        $parametro_NombreArchivo = "pdf_primaria_fomato_de_salida";
        $pdf = PDF::loadView('reportes.pdf.primaria.formato_de_salida.' . $parametro_NombreArchivo, [
           
        ]);


        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrevistaAlumno = Primaria_expediente_entrevista_inicial::findOrFail($id);
        try {
            if ($entrevistaAlumno->delete()) {
                alert('Escuela Modelo', 'La entrevista inicial se ha eliminado con éxito', 'success')->showConfirmButton();
                return redirect('primaria_entrevista_inicial');
            } else {
                alert()->error('Error...', 'No se puedo eliminar la entrevista inicial')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
    }
}

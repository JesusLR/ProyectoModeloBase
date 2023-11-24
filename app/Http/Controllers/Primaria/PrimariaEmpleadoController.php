<?php

namespace App\Http\Controllers\Primaria;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pais;
use App\Http\Helpers\Utils;
use App\Models\Estado;
use Illuminate\Support\Str;
use App\Models\Persona;
use App\Models\User_docente;
use App\Models\Grupo;
use App\Models\Alumno;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Municipio;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

use App\clases\personas\MetodosPersonas;
use App\Http\Controllers\Controller;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Primaria\Primaria_UsuarioLog;
use App\Models\Puesto;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class PrimariaEmpleadoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:empleado', ['except' => ['index', 'show', 'list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('primaria.empleados.show-list');
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $empleados = Primaria_empleado::select(
            'primaria_empleados.id',
            'primaria_empleados.empCredencial',
            'primaria_empleados.empNomina',
            'primaria_empleados.empEstado',
            'primaria_empleados.empNombre',
            'primaria_empleados.empApellido1',
            'primaria_empleados.empApellido2',
            'primaria_empleados.empTelefono',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->leftJoin('escuelas', 'primaria_empleados.escuela_id', '=', 'escuelas.id')
        ->leftJoin('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->latest('primaria_empleados.created_at');

        return Datatables::of($empleados)
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
            ->addColumn('empEstado', function ($query) {
                if ($query->empEstado == 'A') {
                    return 'ACTIVO';
                } elseif ($query->empEstado == 'B') {
                    return 'BAJA';
                } else {
                    return 'SUSPENDIDO';
                }
            })

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })
            ->addColumn('action', function ($query) {

                $ubicacion_clave = FacadesAuth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                $usuario_sistema =  auth()->user()->departamento_sistemas;

                $btnEditar = "";
                $btnEliminar = "";
                $btnBaja = "";

                if($ubicacion_clave == $query->ubiClave || $usuario_sistema == 1){
                    $btnEditar = '<a href="primaria_empleado/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';

                    $btnEliminar = '<form id="delete_' . $query->id . '" action="primaria_empleado/' . $query->id . '" method="POST" style="display:inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';

                    $btnBaja = '<a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect btn-darBaja" title="Dar de baja">
                        <i class="material-icons">arrow_downward</i>
                    </a>';
                }else{
                    $btnEditar = "";
                    $btnEliminar = "";
                    $btnBaja = "";
                }


                return '<a href="primaria_empleado/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                . $btnEditar
                . $btnBaja
                . $btnEliminar;
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
        $paises = Pais::get();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $puestos = Puesto::get();

        return view('primaria.empleados.create', compact('paises', 'ubicaciones', 'puestos'));
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
        $esCurpValida = "accepted";
        $perCurpValida = 'required|max:18|unique:primaria_empleados';

        $empExist = Primaria_empleado::where('empApellido1', $request->empApellido1)
            ->where('empApellido2', $request->empApellido2)
            ->where('empNombre', $request->empNombre)
            ->first();

        if ($empExist) {
            $fullName = $empExist->empNombre . ' ' . $empExist->empApellido1 . ' ' . $empExist->empApellido2;
            alert()->error('Ups...', 'El empleado ' . $fullName . ' ya existe')->showConfirmButton();
            return redirect('primaria_empleado/create');
        }

        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Primaria_empleado::where("empCURP", "=", $request->perCurp)->first();

        if (!$empleado) {
            $perCurpValida = 'max:18';
        }

        //PAIS DIFERENTE DE MEXICO
        if ($request->paisId != "1") {
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }



        $validator = Validator::make(
            $request->all(),
            [
                'empRfc'        => 'required',
                'empHorasCon'   => 'required',
                'perNombre'     => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'  => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'  => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'       => $perCurpValida,
                'esCurpValida' => $esCurpValida,
                'perFechaNac'   => 'required',
                'municipio_id'  => 'required',
                'perSexo'       => 'required',
                'perDirCP'      => 'required|max:5',
                'perDirCalle'   => 'required|max:25',
                'perDirNumExt'  => 'required|max:6',
                'perDirColonia' => 'required|max:60',
                'escuela_id'    => 'required',
                'empFechaIngreso' => 'required'
            ],
            [
                'empRfc.unique' => "El rfc ya existe",
                'empNomina.unique' => "La clave nomina ya existe",
                'empCredencial.unique' => "La clave de credencial ya existe",
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perFechaNac.required' => 'el campo fecha de nacimiento es obligatorio',
                'municipio_id.required' => 'el campo municipio es obligatorio',
                'perDirCalle.required' => 'el campo calle es obligatorio',
                'perDirNumExt.required' => 'el campo número es obligatorio',
                'perDirColonia.required' => 'el campo colonia es obligatorio',
                'perDirCP.required' => 'el campo código postal es obligatorio',
                'empFechaIngreso.required' => 'el campo fecha de ingreso es obligatorio'
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_empleado/create')->withErrors($validator)->withInput();
        }




        $existeRfc = Primaria_empleado::where("empRFC", "=", $request->empRfc)->first();
        $existeNomina = Primaria_empleado::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Primaria_empleado::where("empCredencial", "=", $request->empCredencial)->first();


        if (
            $existeCredencial && $request->empCredencial
            || $existeNomina && $request->empNomina
            || $existeRfc && $request->empRfc
        ) {
            $mensaje = "";

            if ($existeCredencial && $request->empCredencial)
                $mensaje .= "La Credencial ya existe. \n";
            if ($existeNomina && $request->empNomina)
                $mensaje .= "La Nómina ya existe. \n";
            if ($existeRfc && $request->empRfc)
                $mensaje .= "El RFC ya existe.";

            alert()->error('Ups...', $mensaje)->autoClose(5000);

            return back()->withInput();
        }


        $perCurp = $request->perCurp;
        if ($request->paisId != "1" && $request->perSexo == "M") {
            $perCurp = "XEXX010101MNEXXXA4";
        }
        if ($request->paisId != "1" && $request->perSexo == "F") {
            $perCurp = "XEXX010101MNEXXXA8";
        }


        try {


            $empleado = Primaria_empleado::create([
                'empCURP' => $perCurp,
                'empRFC' => $request->empRfc,
                'empNSS' => $request->empImss,
                'empNomina' => Utils::validaEmpty($request->empNomina),
                'empCredencial' => $request->empCredencial,
                'empApellido1' => $request->perApellido1,
                'empApellido2' => $request->perApellido2,
                'empNombre'  => $request->perNombre,
                'escuela_id' => $request->escuela_id,
                'empHoras'  => Utils::validaEmpty($request->empHorasCon),
                'empDireccionCalle' => $request->perDirCalle,
                'empDireccionNumero' => $request->perDirNumExt,
                'empDireccionColonia' => $request->perDirColonia,
                'empDireccionCP'  => Utils::validaEmpty($request->perDirCP),
                'municipio_id' => Utils::validaEmpty($request->municipio_id),
                'empTelefono' => $request->perTelefono2,
                'empFechaNacimiento' => $request->perFechaNac,
                'empSexo' => $request->perSexo,
                'empEstado' => 'A',
                'empFechaIngreso' => $request->empFechaIngreso,
                'empCorreo1' => $request->perCorreo1,
                'puesto_id' => $request->puesto_id
            ]);


            if($request->ubicacion_id == 1){
                $activar_campus_cme = 1;
            }else{
                $activar_campus_cme = 0;
            }
            if($request->ubicacion_id == 2){
                $activar_campus_cva = 1;
            }else{
                $activar_campus_cva = 0;
            }
            if($request->ubicacion_id == 3){
                $activar_campus_cch = 1;
            }else{
                $activar_campus_cch = 0;
            }


            if ($empleado->save()) {
                if ($request->input('password')) {
                    User_docente::create([
                        'empleado_id'               => $empleado->id,
                        'password'                  => bcrypt($request->input('password')),
                        'token'                     => Str::random(64),
                        'maternal'                  => 0,
                        'preescolar'                => 0,
                        'primaria'                  => 1,
                        'secundaria'                => 0,
                        'bachiller'                 => 0,
                        'superior'                  => 0,
                        'posgrado'                  => 0,
                        'educontinua'               => 0,
                        'departamento_cobranza'     => 0,
                        'campus_cme'                => $activar_campus_cme,
                        'campus_cva'                => $activar_campus_cva,
                        'campus_cch'                => $activar_campus_cch
                    ]);
                }

                alert('Escuela Modelo', 'El Empleado se ha creado con éxito', 'success')->showConfirmButton();
                return redirect('primaria_empleado');
            } else {
                alert()->error('Ups...', 'El empleado no se guardó correctamente')->showConfirmButton();
                return redirect('primaria_empleado/create');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('primaria_empleado/create')->withInput();
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
        $empleado = Primaria_empleado::with('municipio', 'escuela')->findOrFail($id);
        $puesto = Puesto::where('id', $empleado->puesto_id)->first();


        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('primaria.empleados.show', compact('empleado', 'puesto'));
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
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();
        $empleado = Primaria_empleado::with('municipio.estado.pais', 'escuela')->findOrFail($id);
        $puestos = Puesto::get();



        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        if ($empleado->municipio == "") {
            $pais_id = 0;
            $estado_id = 0;
        } else {
            $pais_id = $empleado->municipio->estado->pais->id;
            $estado_id = $empleado->municipio->estado->id;
        }

        $estados = Estado::where('pais_id', $pais_id)->get();
        $municipios = Municipio::where('estado_id', $estado_id)->get();

        $departamento = $empleado->escuela->departamento;
        $grupo = $empleado->grupos()
            ->whereIn('periodo_id', [$departamento->perActual, $departamento->perSig])
            ->latest()
            ->first();
        $grupo ? $puedeDarseDeBaja = false : $puedeDarseDeBaja = true;


        if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B" || User::permiso("empleado") == "C") {
            return view('primaria.empleados.edit', compact('empleado', 'paises', 'ubicaciones', 'estados', 'municipios', 'puedeDarseDeBaja', 'puestos'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->route('primaria_empleado.index');
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


        $esCurpValida = "accepted";
        $perCurpValida = 'required|max:18|unique:primaria_empleados';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) { // si pais es diferente de mexico
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }


        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA


        $empleado = Primaria_empleado::where("empCURP", "=", $request->perCurp)->first();


        if (!$empleado) {
            $perCurpValida = 'max:18';
        }


        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8")) {
            $esCurpValida  = "accepted";
            $perCurpValida = 'required|max:18|unique:primaria_empleados';
        }

        // dd($request->all());


        $validator = Validator::make(
            $request->all(),
            [
                'empRfc'                => 'required|min:11|max:13',
                'empHorasCon'           => 'required',
                'perNombre'             => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'          => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'          => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'               => $perCurpValida,
                'esCurpValida'          => $esCurpValida,
                'perFechaNac'           => 'required',
                'municipio_id'          => 'required',
                'perSexo'               => 'required',
                'perDirCP'              => 'required|max:5',
                'perDirCalle'           => 'required|max:25',
                'perDirNumExt'          => 'required|max:6',
                'perDirColonia'         => 'required|max:60',
                'password'              => 'max:20|confirmed',
                'password_confirmation' => 'same:password',
                'escuela_id'            => 'required',
                'empFechaIngreso'       => 'required'
            ],
            [
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perFechaNac.required' => 'el campo fecha de nacimiento es obligatorio',
                'municipio_id.required' => 'el campo municipio es obligatorio',
                'perDirCalle.required' => 'el campo calle es obligatorio',
                'perDirNumExt.required' => 'el campo número es obligatorio',
                'perDirColonia.required' => 'el campo colonia es obligatorio',
                'perDirCP.required' => 'el campo código postal es obligatorio',
                'empFechaIngreso.required' => 'el campo fecha de ingreso es obligatorio'
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $existeRfc = Primaria_empleado::where("empRFC", "=", $request->empRfc)->first();
        $existeNomina = Primaria_empleado::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Primaria_empleado::where("empCredencial", "=", $request->empCredencial)->first();


        if (($existeCredencial && $request->empCredencial)
            && $request->empCredencial != $request->empCredencialAnterior
            || ($existeNomina && $request->empNomina)
            && $request->empNomina != $request->empNominaAnterior
            || ($existeRfc && $request->empRfc)
            && $request->empRfc != $request->empRfcAnterior
        ) {


            $mensaje = "";
            if (($existeCredencial && $request->empCredencial) && $request->empCredencial != $request->empCredencialAnterior)
                $mensaje .= "La Credencial ya existe. \n";

            if (($existeNomina && $request->empNomina) && $request->empNomina != $request->empNominaAnterior)
                $mensaje .= "La Nómina ya existe. \n";

            if (($existeRfc && $request->empRfc) && $request->empRfc != $request->empRfcAnterior)
                $mensaje .= "El RFC ya existe.";

            alert()->error('Ups...', $mensaje)->autoClose(5000);

            return back()->withInput();
        }


        $perCurp = $request->perCurp;
        if ($request->paisId != "1" && $request->perSexo == "M") {
            $perCurp = "XEXX010101MNEXXXA4";
        }


        if ($request->paisId != "1" && $request->perSexo == "F") {
            $perCurp = "XEXX010101MNEXXXA8";
        }


        try {
            $empleado = Primaria_empleado::findOrFail($id);

            $empleado->update([
                'empCURP' => $perCurp,
                'empRFC' => $request->empRfc,
                'empNSS' => $request->empImss,
                'empNomina' => Utils::validaEmpty($request->empNomina),
                'empCredencial' => $request->empCredencial,
                'empApellido1' => $request->perApellido1,
                'empApellido2'  => $request->perApellido2,
                'empNombre' => $request->perNombre,
                'escuela_id' => $request->escuela_id,
                'empHoras' => Utils::validaEmpty($request->empHorasCon),
                'empDireccionCalle' => $request->perDirCalle,
                'empDireccionNumero' => $request->perDirNumExt,
                'empDireccionColonia' => $request->perDirColonia,
                'empDireccionCP' => Utils::validaEmpty($request->perDirCP),
                'municipio_id' => Utils::validaEmpty($request->municipio_id),
                'empTelefono' => $request->perTelefono2,
                'empFechaNacimiento' => $request->perFechaNac,
                'empSexo'  => $request->perSexo,
                'empEstado' => $request->empEstado,
                'empFechaIngreso' => $request->empFechaIngreso,
                'empCorreo1' => $request->perCorreo1,
                'puesto_id' => $request->puesto_id
            ]);


            if ($request->ubicacion_id == 1) {
                $campus_cme = 1;
            } else {
                $campus_cme = 0;
            }

            if ($request->ubicacion_id == 2) {
                $campus_cva = 1;
            } else {
                $campus_cva = 0;
            }

            if ($request->ubicacion_id == 3) {
                $campus_cch = 1;
            } else {
                $campus_cch = 0;
            }
            $user_docente = User_docente::where('empleado_id', $empleado->id)->first();

            if ($user_docente != "") {
                // actualizar el campus
                $user_docente->update([
                    'campus_cme' => $campus_cme,
                    'campus_cva' => $campus_cva,
                    'campus_cch' => $campus_cch
                ]);
            }

            if ($request->password) {
                $user_docente = User_docente::where('empleado_id', $empleado->id)->first();
                if ($user_docente) {
                    $user_docente->password = bcrypt($request->password);
                    $user_docente->primaria = 1;
                    $user_docente->save();
                } else {
                    $userDocente = User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->password),
                        'token'            => Str::random(64),
                        'maternal'         => 0,
                        'preescolar'       => 0,
                        'primaria'         => 1,
                        'secundaria'       => 0,
                        'bachiller'        => 1,
                        'superior'         => 0,
                        'posgrado'         => 0,
                        'educontinua'      => 0,
                        'departamento_cobranza' => 0,
                        'campus_cme' => $campus_cme,
                        'campus_cva' => $campus_cva,
                        'campus_cch' => $campus_cch
                    ]);
                }
            }



            if ($empleado->save()) {


                alert('Escuela Modelo', 'El Empleado se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect()->route('primaria_empleado.index');
            } else {
                alert()->error('Ups...', 'El empleado no se actualizado correctamente')->showConfirmButton();
                return redirect('primaria_empleado/' . $id . '/edit');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('primaria_empleado/' . $id . '/edit')->withInput();
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
        $empleado = Primaria_empleado::findOrFail($id);
        try {
            if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B") {
                if ($empleado->delete()) {
                    alert('Escuela Modelo', 'El empleado se ha eliminado con éxito', 'success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el empleado')->showConfirmButton();
                }
            } else {
                alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
                return redirect()->route('primaria_empleado.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect()->route('primaria_empleado.index');
    }


    public function darDeBaja($id)
    {

        $empleado = Primaria_empleado::findOrFail($id);
        $departamento = $empleado->escuela->departamento;
        $periodos_ids = [$departamento->perActual, $departamento->perSig];

        $grupo = $empleado->grupos()
            ->whereIn('periodo_id', $periodos_ids)
            ->latest()
            ->first();

        if ($grupo) {
            return json_encode($grupo->load('periodo'));
        } else {
            try {
                $empleado->update([
                    'empEstado' => 'B'
                ]);
            } catch (Exception $e) {
                throw $e;
            }
            return json_encode(null);
        }
    } //darBaja.

    public function puedeSerEliminado($empleado_id)
    {

        $empleado = Primaria_empleado::findOrFail($empleado_id);
        $user = User::where('empleado_id', $empleado_id)->first();

        $grupo = $empleado->grupos()
            ->latest()
            ->first();

        if ($user || $grupo) {
            return json_encode(false);
        } else {
            return json_encode(true);
        }
    } //puedeSerEliminado.

    public function verificarExistenciaPersona(Request $request)
    {

        $alumno = MetodosPersonas::existeAlumno($request);
        $empleado = MetodosPersonas::existePrimariaEmpleado($request);

        $data = [
            'alumno' => $alumno,
            'empleado' => $empleado
        ];

        if ($request->ajax()) {
            return json_encode($data);
        } else {
            return $data;
        }
    } //verificarExistenciaPersona.

    public function reactivarEmpleado($empleado_id)
    {

        $empleado = Primaria_empleado::findOrFail($empleado_id);

        if ($empleado->empEstado == 'B') {
            $empleado->update([
                'empEstado' => 'A'
            ]);
        }

        return json_encode($empleado);
    } //reactivarEmpleado.

    public function alumno_crearEmpleado(Request $request, $alumno_id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'empRfc'        => 'required',
                'empHorasCon'   => 'required',
                'escuela_id'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_empleado/create')->withErrors($validator)->withInput();
        }

        //   $alumno = Alumno::findOrFail($alumno_id);
        //   $persona = $alumno->persona;

        DB::beginTransaction();
        try {
            $empleado = Primaria_empleado::create([
                //   'persona_id'      => $persona->id,
                'empHoras'     => Utils::validaEmpty($request->empHorasCon),
                'empCredencial'   => $request->empCredencial,
                'empNomina'       => Utils::validaEmpty($request->empNomina),
                'empRFC'          => $request->empRfc,
                'empNSS'         => $request->empImss,
                'escuela_id'      => $request->escuela_id
            ]);

            if ($request->input('password')) {
                User_docente::create([
                    'empleado_id'      => $empleado->id,
                    'password'         => bcrypt($request->input('password')),
                    'token'            => Str::random(64),
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('primaria_empleado/create')->withInput();
        }
        DB::commit(); #TEST.

        if ($request->ajax()) {
            return json_encode($empleado);
        } else {
            return $empleado;
        }
    } //alumno_crearEmpleado.

    public function cambioEstado()
    {
        if (User::permiso("empleado") != 'A' && User::permiso("empleado") != 'B') return redirect('primaria_empleado');
        $mostrarFiltro = (User::permiso("empleado") == 'A');
        $mostrarEtiqueta = (User::permiso("empleado") == 'B');
        $etiqueta = User::permiso("empleado") == 'B' ? Auth::user()->empleado->escuela->escClave .' - '. Auth::user()->empleado->escuela->escNombre : '';
        $escuela_id = User::permiso("empleado") == 'B' ? Auth::user()->empleado->escuela->id : NULL;
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

        return view('primaria.empleados.cambio-estado', [
            'ubicaciones' => $ubicaciones,
            'ubicacion_id' => $ubicacion_id,
            'mostrarFiltro' => $mostrarFiltro,
            'mostrarEtiqueta' => $mostrarEtiqueta,
            'etiqueta' => $etiqueta,
            'escuela_id' => $escuela_id
        ]);
    }

    public function listEmpleados($escuela = null)
    {
        $empleados = Primaria_empleado::select('primaria_empleados.id as empleado_id',
        'primaria_empleados.empCredencial',
        'primaria_empleados.empNomina',
        'primaria_empleados.empEstado',
        'primaria_empleados.empNombre',
        'primaria_empleados.empApellido1',
        'primaria_empleados.empApellido2',
        'primaria_empleados.empTelefono',
        'puestos.puesNombre',
        'escuelas.escClave')
        ->join('puestos', 'puestos.id', 'primaria_empleados.puesto_id')
        ->join('escuelas', 'escuelas.id', 'primaria_empleados.escuela_id')
        ->whereIn('primaria_empleados.empEstado', ['A', 'B']);

        if ($escuela) $empleados->where('escuelas.id', $escuela);

        return Datatables::of($empleados)
            ->addColumn('action', function($query) {
                $checked = ($query->empEstado == 'A') ? 'checked' : '';

                return '<div class="row">
                            <div class="col s2">
                                <a id="scrollTo_'.$query->empleado_id.'" data-id="scrollTo_'.$query->empleado_id.'" href="' . url('empleado/'.$query->empleado_id.'/edit') . '" class="button button-edit" title="Editar">
                                    <i class="material-icons">edit</i>
                                </a>
                            </div>
                            <div class="col s10">
                                <div class="switch">
                                    <label>
                                    BAJA
                                    <input type="checkbox" '.$checked.' class="status_empleado_input" data-empleado-id="'.$query->empleado_id.'">
                                    <span class="lever"></span>
                                    ACTIVO
                                    </label>
                                </div>
                            </div>
                        </div>
                        ';
            })
        ->make(true);
    }

    public function cambiarMultiplesStatusEmpleados(Request $request) {
        $listado = collect([$request->listado])->collapse()->keyBy('empleado_id');
        if($listado->isEmpty()) {
            return  response()->json([
                'status' => 'warning',
                'title' => 'Sin empleados.',
                'msg' => 'No se encontraron empleados en la lista.',
            ]);
        }




        $empleados = Primaria_empleado::whereIn('id', $listado->keys())->get()->keyBy('id');
        DB::beginTransaction();
        try {
            $listado->each(static function($info, $empleado_id) use ($empleados) {
                $empleado = $empleados->get($empleado_id);
                if($empleado->empEstado != $info['nuevo_estado']) {

                    $fechaActual = Carbon::now('CDT');
                    $fecha = $fechaActual->format('Y-m-d H:i:s');

                    $empleado->update(['empEstado' =>  $info['nuevo_estado']]);
                    Primaria_UsuarioLog::create([
                        'nombre_tabla' => 'primaria_empleados',
                        'registro_id'  => $empleado->id,
                        'nombre_controlador_accion' => 'Primaria\PrimariaEmpleadoController@cambiarMultiplesStatusEmpleados',
                        'tipo_accion' => 'update',
                        'fecha_hora_movimiento' => $fecha
                      ]);
                }
            });
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'title' => 'Ha ocurrido un error',
                'msg' => $e->getMessage(),
            ]);
        }
        DB::commit();

        return response()->json([
            'status' => 'success',
            'title' => 'Actualización exitosa',
            'msg' => 'Se han actualizado el estado de los empleados.',
        ]);
    }
}

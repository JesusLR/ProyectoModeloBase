<?php

namespace App\Http\Controllers\Bachiller;

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
use App\Models\Puesto;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_UsuarioLog;
use Exception;

class BachillerEmpleadoController extends Controller
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
        return view('bachiller.empleados.show-list');
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $empleados = Bachiller_empleados::select(
            'bachiller_empleados.id',
            'bachiller_empleados.empCredencial',
            'bachiller_empleados.empNomina',
            'bachiller_empleados.empEstado',
            'bachiller_empleados.empNombre',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empTelefono'
        )
            ->latest('bachiller_empleados.created_at');

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
            ->addColumn('action', function ($query) {

                return '<a href="bachiller_empleado/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                  <i class="material-icons">visibility</i>
              </a>
              <a href="bachiller_empleado/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                  <i class="material-icons">edit</i>
              </a>
              <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect btn-darBaja" title="Dar de baja">
                  <i class="material-icons">arrow_downward</i>
              </a>
              <form id="delete_' . $query->id . '" action="bachiller_empleado/' . $query->id . '" method="POST" style="display:inline-block;">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="' . csrf_token() . '">
                  <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                      <i class="material-icons">delete</i>
                  </a>
              </form>';
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
        $puestos = Puesto::get();

        return view('bachiller.empleados.create', compact('paises', 'ubicaciones', 'puestos'));
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
        $perCurpValida = 'required|max:18|unique:bachiller_empleados';

        $empExist = Bachiller_empleados::where('empApellido1', $request->empApellido1)
            ->where('empApellido2', $request->empApellido2)
            ->where('empNombre', $request->empNombre)
            ->first();

        if ($empExist) {
            $fullName = $empExist->empNombre . ' ' . $empExist->empApellido1 . ' ' . $empExist->empApellido2;
            alert()->error('Ups...', 'El empleado ' . $fullName . ' ya existe')->showConfirmButton();
            return redirect('bachiller_empleado/create');
        }

        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Bachiller_empleados::where("empCURP", "=", $request->perCurp)->first();

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
                'empFechaIngreso' => 'required',

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
            return redirect('bachiller_empleado/create')->withErrors($validator)->withInput();
        }



        $existeRfc = Bachiller_empleados::where("empRFC", "=", $request->empRfc)->first();
        $existeNomina = Bachiller_empleados::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Bachiller_empleados::where("empCredencial", "=", $request->empCredencial)->first();


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


            $empleado = Bachiller_empleados::create([
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
                'empCorreo1' => $request->perCorreo1,
                'puesto_id' => $request->puesto_id,
                'empSexo' => $request->perSexo,
                'empEstado' => 'A',
                'empFechaIngreso' => $request->empFechaIngreso

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


            if ($empleado->save()) {
                if ($request->input('password')) {
                    User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->input('password')),
                        'token'            => Str::random(64),
                        'maternal'         => 0,
                        'preescolar'       => 0,
                        'primaria'         => 0,
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

                alert('Escuela Modelo', 'El Empleado se ha creado con éxito', 'success')->showConfirmButton();
                return redirect('bachiller_empleado');
            } else {
                alert()->error('Ups...', 'El empleado no se guardó correctamente')->showConfirmButton();
                return redirect('bachiller_empleado/create');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('bachiller_empleado/create')->withInput();
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
        $empleado = Bachiller_empleados::with('municipio', 'escuela')->findOrFail($id);

        $puesto = Puesto::where('id', $empleado->puesto_id)->first();




        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('bachiller.empleados.show', compact('empleado', 'puesto'));
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
        $empleado = Bachiller_empleados::with('municipio.estado.pais', 'escuela')->findOrFail($id);
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
        $departamento_id = $empleado->escuela->departamento->id;

        //   validamos si es merida o valladolid
        if ($departamento_id == "7" || $departamento_id == "17") {
            $grupo = $empleado->bachiller_grupos()
                ->whereIn('periodo_id', [$departamento->perActual, $departamento->perSig])
                ->latest()
                ->first();
            $grupo ? $puedeDarseDeBaja = false : $puedeDarseDeBaja = true;
        } else {
            $grupo = $empleado->bachiller_cch_grupos()
                ->whereIn('periodo_id', [$departamento->perActual, $departamento->perSig])
                ->latest()
                ->first();
            $grupo ? $puedeDarseDeBaja = false : $puedeDarseDeBaja = true;
        }




        if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B" || User::permiso("empleado") == "C") {
            return view('bachiller.empleados.edit', compact('empleado', 'paises', 'ubicaciones', 'estados', 'municipios', 'puedeDarseDeBaja', 'puestos'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->route('bachiller.bachiller_empleado.index');
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
        $perCurpValida = 'required|max:18|unique:bachiller_empleados';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) { // si pais es diferente de mexico
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }


        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA


        $empleado = Bachiller_empleados::where("empCURP", "=", $request->perCurp)->first();


        if (!$empleado) {
            $perCurpValida = 'max:18';
        }


        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8")) {
            $esCurpValida  = "accepted";
            $perCurpValida = 'required|max:18|unique:bachiller_empleados';
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
                'empFechaIngreso' => 'required',
            ],
            [
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empFechaIngreso.required' => "La fecha de ingreso es obligatorio"
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $existeRfc = Bachiller_empleados::where("empRFC", "=", $request->empRfc)->first();
        $existeNomina = Bachiller_empleados::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Bachiller_empleados::where("empCredencial", "=", $request->empCredencial)->first();


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
            $empleado = Bachiller_empleados::findOrFail($id);


            $empleado->update([
                $empleado->empCURP = $perCurp,
                $empleado->empRFC = $request->empRfc,
                $empleado->empNSS = $request->empImss,
                $empleado->empNomina = Utils::validaEmpty($request->empNomina),
                $empleado->empCredencial = $request->empCredencial,
                $empleado->empApellido1 = $request->perApellido1,
                $empleado->empApellido2  = $request->perApellido2,
                $empleado->empNombre = $request->perNombre,
                $empleado->escuela_id = $request->escuela_id,
                $empleado->empHoras = Utils::validaEmpty($request->empHorasCon),
                $empleado->empDireccionCalle = $request->perDirCalle,
                $empleado->empDireccionNumero = $request->perDirNumExt,
                $empleado->empDireccionColonia = $request->perDirColonia,
                $empleado->empDireccionCP = Utils::validaEmpty($request->perDirCP),
                $empleado->municipio_id = Utils::validaEmpty($request->municipio_id),
                $empleado->empTelefono = $request->perTelefono1,
                $empleado->empFechaNacimiento = $request->perFechaNac,
                $empleado->empSexo  = $request->perSexo,
                $empleado->empEstado = $request->empEstado,
                $empleado->empCorreo1 = $request->perCorreo1,
                $empleado->puesto_id = $request->puesto_id,
                $empleado->empFechaIngreso = $request->empFechaIngreso
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

                if ($user_docente) {
                    $user_docente->password = bcrypt($request->password);
                    $user_docente->maternal         = 0;
                    $user_docente->preescolar       = 0;
                    $user_docente->primaria         = 0;
                    $user_docente->secundaria       = 0;
                    $user_docente->bachiller        = 1;
                    $user_docente->superior         = 0;
                    $user_docente->posgrado         = 0;
                    $user_docente->educontinua      = 0;
                    $user_docente->departamento_cobranza = 0;
                    $user_docente->campus_cme = $campus_cme;
                    $user_docente->campus_cva = $campus_cva;
                    $user_docente->campus_cch = $campus_cch;
                    $user_docente->save();
                } else {
                    $userDocente = User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->password),
                        'token'            => Str::random(64),
                        'maternal'         => 0,
                        'preescolar'       => 0,
                        'primaria'         => 0,
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
                return redirect()->route('bachiller.bachiller_empleado.index');
            } else {
                alert()->error('Ups...', 'El empleado no se actualizado correctamente')->showConfirmButton();
                return redirect('bachiller_empleado/' . $id . '/edit');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('bachiller_empleado/' . $id . '/edit')->withInput();
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
        $empleado = Bachiller_empleados::findOrFail($id);
        try {
            if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B") {
                if ($empleado->delete()) {
                    alert('Escuela Modelo', 'El empleado se ha eliminado con éxito', 'success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el empleado')->showConfirmButton();
                }
            } else {
                alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
                return redirect()->route('bachiller.bachiller_empleado.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect()->route('bachiller.bachiller_empleado.index');
    }


    public function darDeBaja($id)
    {

        $empleado = Bachiller_empleados::findOrFail($id);
        $departamento = $empleado->escuela->departamento;
        $periodos_ids = [$departamento->perActual, $departamento->perSig];

        $grupo = $empleado->bachiller_grupos()
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

        $empleado = Bachiller_empleados::findOrFail($empleado_id);
        $user = User::where('empleado_id', $empleado_id)->first();

        $grupo = $empleado->bachiller_grupos()
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
        $empleado = MetodosPersonas::existeBachillerEmpleado($request);

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

        $empleado = Bachiller_empleados::findOrFail($empleado_id);

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
                'empRFC'        => 'required',
                'empHoras'   => 'required',
                'escuela_id'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_empleado/create')->withErrors($validator)->withInput();
        }

        //   $alumno = Alumno::findOrFail($alumno_id);
        //   $persona = $alumno->persona;

        DB::beginTransaction();
        try {
            $empleado = Bachiller_empleados::create([
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
            return redirect('bachiller_empleado/create')->withInput();
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
        if (User::permiso("empleado") != 'A' && User::permiso("empleado") != 'B') return redirect('secundaria_empleado');
        $mostrarFiltro = (User::permiso("empleado") == 'A');
        $mostrarEtiqueta = (User::permiso("empleado") == 'B');
        $etiqueta = User::permiso("empleado") == 'B' ? Auth::user()->empleado->escuela->escClave .' - '. Auth::user()->empleado->escuela->escNombre : '';
        $escuela_id = User::permiso("empleado") == 'B' ? Auth::user()->empleado->escuela->id : NULL;
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

        return view('bachiller.empleados.cambio-estado', [
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
        $empleados = Bachiller_empleados::select('bachiller_empleados.id as empleado_id',
        'bachiller_empleados.empCredencial',
        'bachiller_empleados.empNomina',
        'bachiller_empleados.empEstado',
        'bachiller_empleados.empNombre',
        'bachiller_empleados.empApellido1',
        'bachiller_empleados.empApellido2',
        'bachiller_empleados.empTelefono',
        'puestos.puesNombre',
        'escuelas.escClave')
        ->join('puestos', 'puestos.id', 'bachiller_empleados.puesto_id')
        ->join('escuelas', 'escuelas.id', 'bachiller_empleados.escuela_id')
        ->whereIn('bachiller_empleados.empEstado', ['A', 'B']);

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




        $empleados = Bachiller_empleados::whereIn('id', $listado->keys())->get()->keyBy('id');
        DB::beginTransaction();
        try {
            $listado->each(static function($info, $empleado_id) use ($empleados) {
                $empleado = $empleados->get($empleado_id);
                if($empleado->empEstado != $info['nuevo_estado']) {

                    $fechaActual = Carbon::now('CDT');
                    $fecha = $fechaActual->format('Y-m-d H:i:s');

                    $empleado->update(['empEstado' =>  $info['nuevo_estado']]);
                    Bachiller_UsuarioLog::create([
                        'nombre_tabla' => 'bachiller_empleados',
                        'registro_id'  => $empleado->id,
                        'nombre_controlador_accion' => 'Bachiller\BachillerEmpleadoController@cambiarMultiplesStatusEmpleados',
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

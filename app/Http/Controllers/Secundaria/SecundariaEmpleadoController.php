<?php

namespace App\Http\Controllers\Secundaria;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Models\Pais;
use App\Http\Helpers\Utils;
use App\Http\Models\Estado;
use Illuminate\Support\Str;
use App\Http\Models\Persona;
use App\Models\User_docente;
use App\Http\Models\Grupo;
use App\Http\Models\Alumno;

use Illuminate\Http\Request;
use App\Http\Models\Empleado;
use App\Http\Models\Municipio;
use App\Http\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

use App\clases\personas\MetodosPersonas;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Primaria\Primaria_empleado;
use App\Http\Models\Puesto;
use App\Http\Models\Secundaria\Secundaria_empleados;
use App\Http\Models\Secundaria\Secundaria_UsuarioLog;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class SecundariaEmpleadoController extends Controller
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
        return view('secundaria.empleados.show-list');
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $empleados = Secundaria_empleados::select(
            'secundaria_empleados.id',
            'secundaria_empleados.empCredencial',
            'secundaria_empleados.empNomina',
            'secundaria_empleados.empEstado',
            'secundaria_empleados.empNombre',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empTelefono',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->leftJoin('escuelas', 'secundaria_empleados.escuela_id', '=', 'escuelas.id')
        ->leftJoin('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->latest('secundaria_empleados.created_at');

        return Datatables::of($empleados)

            ->addColumn('empleadoID', function ($query) {
                return $query->empleado_id;
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

            ->addColumn('empEstado', function ($query) {
                if ($query->empEstado == 'A') {
                    return 'ACTIVO';
                } elseif ($query->empEstado == 'B') {
                    return 'BAJA';
                } else {
                    return 'SUSPENDIDO';
                }
            })

            ->filterColumn('empleado_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(id) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('empleado_clave', function ($query) {
                return $query->id;
            })

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })
            
            ->addColumn('action', function ($query) {


                $departamento_sistemas = auth()->user()->departamento_sistemas;
                $ubicacion_clave = FacadesAuth::user()->empleado->escuela->departamento->ubicacion->ubiClave;

                $btnEditar = "";
                $btnBaja = "";

                if($ubicacion_clave == $query->ubiClave || $departamento_sistemas == 1){
                    $btnEditar = '<a href="secundaria_empleado/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
               

                    $btnBaja = '<a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect btn-darBaja" title="Dar de baja">
                        <i class="material-icons">arrow_downward</i>
                    </a>';
                }else{
                    $btnEditar = "";
                    $btnBaja = "";
                }

                if ($departamento_sistemas == 1) {
                    $btnBorrar = '<form id="delete_' . $query->id . '" action="secundaria_empleado/' . $query->id . '" method="POST" style="display:inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                } else {
                    $btnBorrar = "";
                }

                return '<a href="secundaria_empleado/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>' 
                . $btnEditar
                . $btnBaja
                . $btnBorrar;
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

        return view('secundaria.empleados.create', compact('paises', 'ubicaciones', 'puestos'));
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
        $perCurpValida = 'required|max:18|unique:secundaria_empleados';

        $empExist = Secundaria_empleados::where('empApellido1', $request->empApellido1)
            ->where('empApellido2', $request->empApellido2)
            ->where('empNombre', $request->empNombre)
            ->first();

        if ($empExist) {
            $fullName = $empExist->empNombre . ' ' . $empExist->empApellido1 . ' ' . $empExist->empApellido2;
            alert()->error('Ups...', 'El empleado ' . $fullName . ' ya existe')->showConfirmButton();
            return redirect('secundaria_empleado/create');
        }

        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Secundaria_empleados::where("empCURP", "=", $request->empCURP)->first();

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
                'empRFC'        => 'required',
                'empHoras'   => 'required',
                'empNombre'     => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido1'  => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido2'  => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empCURP'       => $perCurpValida,
                'esCurpValida' => $esCurpValida,
                'empFechaNacimiento'   => 'required',
                'municipio_id'  => 'required',
                'empSexo'       => 'required',
                'empDireccionCP'      => 'required|max:5',
                'empDireccionCalle'   => 'required|max:25',
                'empDireccionNumero'  => 'required|max:6',
                'empDireccionColonia' => 'required|max:60',
                'escuela_id'    => 'required',
                'empFechaIngreso' => 'required',

            ],
            [
                'empRFC.unique' => "El rfc ya existe",
                'empNomina.unique' => "La clave nomina ya existe",
                'empCredencial.unique' => "La clave de credencial ya existe",
                'empNombre.required' => 'El nombre es obligatorio',
                'empNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido1.required' => 'El apellido paterno es obligatorio',
                'empApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empFechaNacimiento.required' => 'el campo fecha de nacimiento es obligatorio',
                'municipio_id.required' => 'el campo municipio es obligatorio',
                'empDireccionCalle.required' => 'el campo calle es obligatorio',
                'empDireccionNumero.required' => 'el campo número es obligatorio',
                'empDireccionColonia.required' => 'el campo colonia es obligatorio',
                'empDireccionCP.required' => 'el campo código postal es obligatorio',
                'empFechaIngreso.required' => 'el campo fecha de ingreso es obligatorio'

            ]
        );

        if ($validator->fails()) {
            return redirect('secundaria_empleado/create')->withErrors($validator)->withInput();
        }



        $existeRfc = Secundaria_empleados::where("empRFC", "=", $request->empRFC)->first();
        $existeNomina = Secundaria_empleados::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Secundaria_empleados::where("empCredencial", "=", $request->empCredencial)->first();


        if (
            $existeCredencial && $request->empCredencial
            || $existeNomina && $request->empNomina
            || $existeRfc && $request->empRFC
        ) {
            $mensaje = "";

            if ($existeCredencial && $request->empCredencial)
                $mensaje .= "La Credencial ya existe. \n";
            if ($existeNomina && $request->empNomina)
                $mensaje .= "La Nómina ya existe. \n";
            if ($existeRfc && $request->empRFC)
                $mensaje .= "El RFC ya existe.";

            alert()->error('Ups...', $mensaje)->autoClose(5000);

            return back()->withInput();
        }


        $empCURP = $request->empCURP;
        if ($request->paisId != "1" && $request->empSexo == "M") {
            $empCURP = "XEXX010101MNEXXXA4";
        }
        if ($request->paisId != "1" && $request->empSexo == "F") {
            $empCURP = "XEXX010101MNEXXXA8";
        }


        try {


            $empleado = Secundaria_empleados::create([
                'empCURP' => $empCURP,
                'empRFC' => $request->empRFC,
                'empNSS' => $request->empNSS,
                'empNomina' => Utils::validaEmpty($request->empNomina),
                'empCredencial' => $request->empCredencial,
                'empApellido1' => $request->empApellido1,
                'empApellido2' => $request->empApellido2,
                'empNombre'  => $request->empNombre,
                'escuela_id' => $request->escuela_id,
                'empHoras'  => Utils::validaEmpty($request->empHoras),
                'empDireccionCalle' => $request->empDireccionCalle,
                'empDireccionNumero' => $request->empDireccionNumero,
                'empDireccionColonia' => $request->empDireccionColonia,
                'empDireccionCP'  => Utils::validaEmpty($request->empDireccionCP),
                'municipio_id' => Utils::validaEmpty($request->municipio_id),
                'empTelefono' => $request->empTelefono,
                'empFechaNacimiento' => $request->empFechaNacimiento,
                'empCorreo1' => $request->empCorreo1,
                'puesto_id' => $request->puesto_id,
                'empSexo' => $request->empSexo,
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


            if ($empleado->save()) {
                if ($request->input('password')) {
               
                    User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->input('password')),
                        'token'            => str_random(64),
                        'maternal'         => 0,
                        'preescolar'       => 0,
                        'primaria'         => 0,
                        'secundaria'       => 1,
                        'bachiller'        => 0,
                        'superior'         => 0,
                        'posgrado'         => 0,
                        'educontinua'      => 0,
                        'departamento_cobranza' => 0,
                        'campus_cme' => $campus_cme,
                        'campus_cva' => $campus_cva,
                        'campus_cch' => 0
                    ]);
                }

                alert('Escuela Modelo', 'El Empleado se ha creado con éxito', 'success')->showConfirmButton();
                return redirect('secundaria_empleado');
            } else {
                alert()->error('Ups...', 'El empleado no se guardó correctamente')->showConfirmButton();
                return redirect('secundaria_empleado/create');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...llega' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('secundaria_empleado/create')->withInput();
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
        $empleado = Secundaria_empleados::with('municipio', 'escuela')->findOrFail($id);

        $puesto = Puesto::where('id', $empleado->puesto_id)->first();




        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('secundaria.empleados.show', compact('empleado', 'puesto'));
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $empleado = Secundaria_empleados::with('municipio.estado.pais', 'escuela')->findOrFail($id);
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
        $grupo = $empleado->secundaria_grupos()
            ->whereIn('periodo_id', [$departamento->perActual, $departamento->perSig])
            ->latest()
            ->first();
        $grupo ? $puedeDarseDeBaja = false : $puedeDarseDeBaja = true;


        if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B" || User::permiso("empleado") == "C") {
            return view('secundaria.empleados.edit', compact('empleado', 'paises', 'ubicaciones', 'estados', 'municipios', 'puedeDarseDeBaja', 'puestos'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->route('secundaria.secundaria_empleado.index');
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
        $perCurpValida = 'required|max:18|unique:secundaria_empleados';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) { // si pais es diferente de mexico
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }


        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA


        $empleado = Secundaria_empleados::where("empCURP", "=", $request->perCurp)->first();


        if (!$empleado) {
            $perCurpValida = 'max:18';
        }


        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8")) {
            $esCurpValida  = "accepted";
            $perCurpValida = 'required|max:18|unique:secundaria_empleados';
        }

        // dd($request->all());


        $validator = Validator::make(
            $request->all(),
            [
                'empRfc'                => 'required|min:11|max:13',
                'empHoras'           => 'required',
                'empNombre'             => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido1'          => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido2'          => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'               => $perCurpValida,
                'esCurpValida'          => $esCurpValida,
                'empFechaNacimiento'           => 'required',
                'municipio_id'          => 'required',
                'empSexo'               => 'required',
                'empDireccionCP'              => 'required|max:5',
                'empDireccionCalle'           => 'required|max:25',
                'empDireccionNumero'          => 'required|max:6',
                'empDireccionColonia'         => 'required|max:60',
                'password'              => 'max:20|confirmed',
                'password_confirmation' => 'same:password',
                'escuela_id'            => 'required',
                'empFechaIngreso' => 'required',
            ],
            [
                'empNombre.required' => 'El nombre es obligatorio',
                'empNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido1.required' => 'El apellido paterno es obligatorio',
                'empApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empFechaIngreso.required' => "La fecha de ingreso es obligatorio"
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $existeRfc = Secundaria_empleados::where("empRFC", "=", $request->empRfc)->first();
        $existeNomina = Secundaria_empleados::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Secundaria_empleados::where("empCredencial", "=", $request->empCredencial)->first();


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
        if ($request->paisId != "1" && $request->empSexo == "M") {
            $perCurp = "XEXX010101MNEXXXA4";
        }


        if ($request->paisId != "1" && $request->empSexo == "F") {
            $perCurp = "XEXX010101MNEXXXA8";
        }


        try {
            $empleado = Secundaria_empleados::findOrFail($id);


            $empleado->update([
                $empleado->empCURP = $perCurp,
                $empleado->empRFC = $request->empRfc,
                $empleado->empNSS = $request->empNSS,
                $empleado->empNomina = Utils::validaEmpty($request->empNomina),
                $empleado->empCredencial = $request->empCredencial,
                $empleado->empApellido1 = $request->empApellido1,
                $empleado->empApellido2  = $request->empApellido2,
                $empleado->empNombre = $request->empNombre,
                $empleado->escuela_id = $request->escuela_id,
                $empleado->empHoras = Utils::validaEmpty($request->empHoras),
                $empleado->empDireccionCalle = $request->empDireccionCalle,
                $empleado->empDireccionNumero = $request->empDireccionNumero,
                $empleado->empDireccionColonia = $request->empDireccionColonia,
                $empleado->empDireccionCP = Utils::validaEmpty($request->empDireccionCP),
                $empleado->municipio_id = Utils::validaEmpty($request->municipio_id),
                $empleado->empTelefono = $request->empTelefono,
                $empleado->empFechaNacimiento = $request->empFechaNacimiento,
                $empleado->empSexo  = $request->empSexo,
                $empleado->empEstado = $request->empEstado,
                $empleado->empCorreo1 = $request->empCorreo1,
                $empleado->puesto_id = $request->puesto_id,
                $empleado->empFechaIngreso = $request->empFechaIngreso
            ]);




            if ($request->password) {
                $user_docente = User_docente::where('empleado_id', $empleado->id)->first();
                if ($user_docente) {
                    $user_docente->password = bcrypt($request->password);
                    $user_docente->save();
                } else {
                    $userDocente = User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->password),
                        'token'            => str_random(64),
                    ]);
                }
            }



            if ($empleado->save()) {


                alert('Escuela Modelo', 'El Empleado se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect()->route('secundaria.secundaria_empleado.index');
            } else {
                alert()->error('Ups...', 'El empleado no se actualizado correctamente')->showConfirmButton();
                return redirect('secundaria_empleado/' . $id . '/edit');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('secundaria_empleado/' . $id . '/edit')->withInput();
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
        $empleado = Secundaria_empleados::findOrFail($id);
        try {
            if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B") {
                if ($empleado->delete()) {
                    alert('Escuela Modelo', 'El empleado se ha eliminado con éxito', 'success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el empleado')->showConfirmButton();
                }
            } else {
                alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
                return redirect()->route('secundaria.secundaria_empleado.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect()->route('secundaria.secundaria_empleado.index');
    }


    public function darDeBaja($id)
    {

        $empleado = Secundaria_empleados::findOrFail($id);
        $escuela = Escuela::find($empleado->escuela_id);
        $departamento = Departamento::find($escuela->departamento_id);
        
        $periodos_ids = [$departamento->perActual, $departamento->perSig];

        $grupo = $empleado->secundaria_grupos()
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

        $empleado = Secundaria_empleados::findOrFail($empleado_id);
        $user = User::where('empleado_id', $empleado_id)->first();

        $grupo = $empleado->secundaria_grupos()
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

        $alumno = MetodosPersonas::existeAlumnoSecundaria($request);
        $empleado = MetodosPersonas::existeSecundariaEmpleado($request);

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

        $empleado = Secundaria_empleados::find($empleado_id);

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
            return redirect('secundaria_empleado/create')->withErrors($validator)->withInput();
        }

        //   $alumno = Alumno::findOrFail($alumno_id);
        //   $persona = $alumno->persona;

        DB::beginTransaction();
        try {
            $empleado = Secundaria_empleados::create([
                //   'persona_id'      => $persona->id,
                'empHoras'     => Utils::validaEmpty($request->empHoras),
                'empCredencial'   => $request->empCredencial,
                'empNomina'       => Utils::validaEmpty($request->empNomina),
                'empRFC'          => $request->empRfc,
                'empNSS'         => $request->empNSS,
                'escuela_id'      => $request->escuela_id
            ]);

            if ($request->input('password')) {
                User_docente::create([
                    'empleado_id'      => $empleado->id,
                    'password'         => bcrypt($request->input('password')),
                    'token'            => str_random(64),
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('secundaria_empleado/create')->withInput();
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

        return view('secundaria.empleados.cambio-estado', [
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
        $empleados = Secundaria_empleados::select('secundaria_empleados.id as empleado_id',
        'secundaria_empleados.empCredencial',
        'secundaria_empleados.empNomina',
        'secundaria_empleados.empEstado',
        'secundaria_empleados.empNombre',
        'secundaria_empleados.empApellido1',
        'secundaria_empleados.empApellido2',
        'secundaria_empleados.empTelefono', 
        'puestos.puesNombre', 
        'escuelas.escClave')
        ->join('puestos', 'puestos.id', 'secundaria_empleados.puesto_id')
        ->join('escuelas', 'escuelas.id', 'secundaria_empleados.escuela_id')
        ->whereIn('secundaria_empleados.empEstado', ['A', 'B']);

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

        
        

        $empleados = Secundaria_empleados::whereIn('id', $listado->keys())->get()->keyBy('id');
        DB::beginTransaction();
        try {
            $listado->each(static function($info, $empleado_id) use ($empleados) {
                $empleado = $empleados->get($empleado_id);
                if($empleado->empEstado != $info['nuevo_estado']) {

                    $fechaActual = Carbon::now('CDT');
                    $fecha = $fechaActual->format('Y-m-d H:i:s');
                    
                    $empleado->update(['empEstado' =>  $info['nuevo_estado']]);
                    Secundaria_UsuarioLog::create([
                        'nombre_tabla' => 'secundaria_empleados',
                        'registro_id'  => $empleado->id,
                        'nombre_controlador_accion' => 'Secundaria\SecundariaEmpleadoController@cambiarMultiplesStatusEmpleados',
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

<?php

namespace App\Http\Controllers\Preescolar;

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
use App\Http\Models\Preescolar\Preescolar_UsuarioLog;
use Exception;

class PreescolarEmpleadosController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:empleado',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('preescolar.empleados.show-list');
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $empleados = Empleado::select('empleados.id as empleado_id','empleados.empCredencial','empleados.empNomina','empleados.empEstado',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','personas.perTelefono1')
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')->latest('empleados.created_at')
            ->join('escuelas', 'escuelas.id', 'empleados.escuela_id')
            ->join('departamentos', 'departamentos.id', 'escuelas.departamento_id')
            ->whereIn('departamentos.depClave', ['MAT', 'PRE']);

        return Datatables::of($empleados)

            ->filterColumn('nombre_docente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_docente', function ($query) {
                return $query->perNombre;
            })

            ->filterColumn('apellido1_docente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido1_docente', function ($query) {
                return $query->perApellido1;
            })

            ->filterColumn('apellido2_docente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido2_docente', function ($query) {
                return $query->perApellido2;
            })


            ->filterColumn('telefono', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perTelefono1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('telefono', function ($query) {
                return $query->perTelefono1;                
            })

            ->addColumn('empEstado', function ($query) {
                if($query->empEstado == 'A') {
                    return 'ACTIVO';
                }elseif ($query->empEstado == 'B') {
                    return 'BAJA';
                }else{
                    return 'SUSPENDIDO';
                }
            })
            ->addColumn('action', function($query) {

                $btnBajaEmpleado = "";
                $btnEliminar = "";

                if(auth()->user()->departamento_sistemas == 1){
                    $btnEliminar = '<form id="delete_' . $query->empleado_id . '" action="preescolar_empleado/' . $query->empleado_id . '" method="POST" style="display:inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $query->empleado_id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';

                }else{
                    $btnEliminar = "";
                }

                if($query->empEstado == 'B'){
                    $btnBajaEmpleado = "";
                }else{
                    $btnBajaEmpleado = '<a href="#" data-id="'.$query->empleado_id.'" class="button button--icon js-button js-ripple-effect btn-darBaja-preescolar" title="Dar de baja">
                        <i class="material-icons">arrow_downward</i>
                    </a>';
                }
                return '<a href="preescolar_empleado/'.$query->empleado_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="preescolar_empleado/'.$query->empleado_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>'
                .$btnBajaEmpleado.
                $btnEliminar;
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
        // $ubicaciones = Ubicacion::get();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        return view('preescolar.empleados.create',compact('paises','ubicaciones'));
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
        $perCurpValida = 'required|max:18|unique:personas';

        $empExist = Empleado::with("persona")
            ->whereHas('persona', function($query) use ($request) {
                $query->where('perApellido1', $request->perApellido1)
                ->where('perApellido2', $request->perApellido2)
                ->where('perNombre', $request->perNombre);
            })->first();

        if ($empExist) {
            $fullName = $empExist->persona->perNombre.' '.$empExist->persona->perApellido1.' '.$empExist->persona->perApellido2;
            alert()->error('Ups...', 'El empleado '.$fullName.' ya existe')->showConfirmButton();
            return redirect('preescolar_empleado/create');
        }

        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Empleado::with("persona")
            ->whereHas('persona', function($query) use ($request) {
                $query->where("perCurp", "=", $request->perCurp);
            })
        ->first();

        if (!$empleado) {
            $perCurpValida = 'max:18';
        }

        //PAIS DIFERENTE DE MEXICO
        if ($request->paisId != "1") {
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }



        $validator = Validator::make($request->all(),
            [
                'empRfc'        => 'required',
                'empHorasCon'   => 'required',
                'perNombre'     => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'  => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'  => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'       => $perCurpValida,
                'esCurpValida' => $esCurpValida,
                'perFechaNac'   => 'required',
                'municipio_id'  => 'required',
                'perSexo'       => 'required',
                'perDirCP'      => 'required|max:5',
                'perDirCalle'   => 'required|max:25',
                'perDirNumExt'  => 'required|max:6',
                'perDirColonia' => 'required|max:60',
                'escuela_id'    => 'required'
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
            ]
        );

        if ($validator->fails()) {
            return redirect ('preescolar_empleado/create')->withErrors($validator)->withInput();
        }




        $existeRfc = Empleado::where("empRfc", "=", $request->empRfc)->first();
        $existeNomina = Empleado::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Empleado::where("empCredencial", "=", $request->empCredencial)->first();


        if ($existeCredencial && $request->empCredencial
        || $existeNomina && $request->empNomina
        || $existeRfc && $request->empRfc) {
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
            $persona = Persona::create([
                'perCurp'        => $perCurp,
                'perApellido1'   => $request->perApellido1,
                'perApellido2'   => $request->perApellido2,
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

            if ($persona->save()) {
                $persona_id = $persona->id;
                $empleado = Empleado::create([
                    'persona_id'      => $persona_id,
                    'empHorasCon'     => Utils::validaEmpty($request->empHorasCon),
                    'empCredencial'   => $request->empCredencial,
                    'empNomina'       => Utils::validaEmpty($request->empNomina),
                    'empRfc'          => $request->empRfc,
                    'empImss'         => $request->empImss,
                    'escuela_id'      => $request->escuela_id
                ]);
                if ($empleado->save()) {

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

                    $departamento = Departamento::find($request->departamento_id);

                    if($departamento->depClave == "MAT"){
                        $maternal = 1;
                    }else{
                        $maternal = 0;
                    }
            
                    if($departamento->depClave == "PRE"){
                        $preescolar = 1;
                    }else{
                        $preescolar = 0;
                    }

                    if ($request->input('password')) {
                        User_docente::create([
                            'empleado_id'      => $empleado->id,
                            'password'         => bcrypt($request->password),
                            'token'            => str_random(64),
                            'maternal'         => $maternal,
                            'preescolar'       => $preescolar,
                            'primaria'         => 0,
                            'secundaria'       => 0,
                            'bachiller'        => 0,
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
                    return redirect('preescolar_empleado');
                } else {
                    alert()->error('Ups...', 'El empleado no se guardó correctamente')->showConfirmButton();
                    return redirect('preescolar_empleado/create');
                }
            } else {
                alert()->error('Ups...', 'La persona no se guardó correctamente')->showConfirmButton();
                return redirect('preescolar_empleado/create');
            }
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('preescolar_empleado/create')->withInput();
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
        $empleado = Empleado::with('persona','escuela')->findOrFail($id);


        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('preescolar.empleados.show',compact('empleado'));
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
        $ubicaciones = Ubicacion::get();
        $empleado = Empleado::with('persona.municipio.estado.pais','escuela')->findOrFail($id);


        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        $pais_id = $empleado->persona->municipio->estado->pais->id;
        $estado_id = $empleado->persona->municipio->estado->id;
        $estados = Estado::where('pais_id',$pais_id)->get();
        $municipios = Municipio::where('estado_id',$estado_id)->get();

        $departamento = $empleado->escuela->departamento;
        $grupo = $empleado->grupos()
                ->whereIn('periodo_id', [$departamento->perActual, $departamento->perSig])
                ->latest()
                ->first();
        $grupo ? $puedeDarseDeBaja = false : $puedeDarseDeBaja = true;


        if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B" || User::permiso("empleado") == "C") {
            return view('preescolar.empleados.edit',compact('empleado','paises','ubicaciones','estados','municipios', 'puedeDarseDeBaja'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect()->route('preescolar_empleado.index');
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
        $perCurpValida = 'required|max:18|unique:personas';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) {// si pais es diferente de mexico
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }


        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($perCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($perCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Empleado::with("persona")
            ->whereHas('persona', function($query) use ($request) {
                $query->where("perCurp", "=", $request->perCurp);
            })
        ->first();


        if (!$empleado) {
            $perCurpValida = 'max:18';
        }


        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8" )) {
            $esCurpValida  = "accepted";
            $perCurpValida = 'required|max:18|unique:personas';
        }

        // dd($request->all());


        $validator = Validator::make($request->all(),
            [
                'empRfc'                => 'required|min:11|max:13',
                'empHorasCon'           => 'required',
                'perNombre'             => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'          => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'          => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
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
                'escuela_id'            => 'required'
            ],[
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $existeRfc = Empleado::where("empRfc", "=", $request->empRfc)->first();
        $existeNomina = Empleado::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Empleado::where("empCredencial", "=", $request->empCredencial)->first();


        if (($existeCredencial && $request->empCredencial)
            && $request->empCredencial != $request->empCredencialAnterior
            || ($existeNomina && $request->empNomina)
            && $request->empNomina != $request->empNominaAnterior
            || ($existeRfc && $request->empRfc)
            && $request->empRfc != $request->empRfcAnterior) {


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
            $empleado = Empleado::with('persona')->findOrFail($id);
            $persona = Persona::findOrFail($empleado->persona->id);
            $persona->perCurp       = $perCurp;
            $persona->perApellido1  = $request->perApellido1;
            $persona->perApellido2  = $request->perApellido2;
            $persona->perNombre     = $request->perNombre;
            $persona->perFechaNac   = $request->perFechaNac;
            $persona->municipio_id  = Utils::validaEmpty($request->municipio_id);
            $persona->perSexo       = $request->perSexo;
            $persona->perCorreo1    = $request->perCorreo1;
            $persona->perTelefono1  = $request->perTelefono1;
            $persona->perTelefono2  = $request->perTelefono2;
            $persona->perDirCP      = Utils::validaEmpty($request->perDirCP);
            $persona->perDirCalle   = $request->perDirCalle;
            $persona->perDirNumInt  = $request->perDirNumInt;
            $persona->perDirNumExt  = $request->perDirNumExt;
            $persona->perDirColonia = $request->perDirColonia;
            $persona->save();


            //GUARDA EMPLEADO
            $empleado->empHorasCon      = Utils::validaEmpty($request->empHorasCon);
            $empleado->empCredencial    = $request->empCredencial;
            $empleado->empNomina        = Utils::validaEmpty($request->empNomina);
            $empleado->empRfc           = $request->empRfc;
            $empleado->empImss          = $request->empImss;
            $empleado->escuela_id       = $request->escuela_id;
            $empleado->empEstado        = $request->empEstado;



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
            
            $departamento = Departamento::find($request->departamento_id);

            if($departamento->depClave == "MAT"){
                $maternal = 1;
            }else{
                $maternal = 0;
            }
    
            if($departamento->depClave == "PRE"){
                $preescolar = 1;
            }else{
                $preescolar = 0;
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
                $user_docente = User_docente::where('empleado_id',$empleado->id)->first();
                if ($user_docente) {                    
                    $user_docente->password = bcrypt($request->password);
                    $user_docente->preescolar = 1;
                    $user_docente->save();
                } else {
                    $userDocente = User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->password),
                        'token'            => str_random(64),
                        'maternal'         => $maternal,
                        'preescolar'       => $preescolar,
                        'primaria'         => 0,
                        'secundaria'       => 0,
                        'bachiller'        => 0,
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


                alert('Escuela Modelo', 'El Empleado se ha actualizado con éxito','success')->showConfirmButton();
                return redirect()->route('preescolar_empleado.index');
            } else {
                alert()->error('Ups...','El empleado no se actualizado correctamente')->showConfirmButton();
                return redirect('preescolar_empleado/' . $id . '/edit');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();

            return redirect('preescolar_empleado/' . $id . '/edit')->withInput();
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
        $empleado = Empleado::findOrFail($id);
        try {
            if (User::permiso("empleado") == "A" || User::permiso("empleado") == "B") {
                if($empleado->delete()){
                    alert('Escuela Modelo', 'El empleado se ha eliminado con éxito','success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el empleado')->showConfirmButton();
                }
            } else {
                alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
                return redirect()->route('preescolar_empleado.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect()->route('preescolar_empleado.index');
    }


    public function darDeBaja($id) {

        $empleado = Empleado::findOrFail($id);
        $departamento = $empleado->escuela->departamento;
        $periodos_ids = [$departamento->perActual, $departamento->perSig];

        $grupo = $empleado->grupos()
                ->whereIn('periodo_id',$periodos_ids)
                ->latest()
                ->first();

        if($grupo) {
            return json_encode($grupo->load('periodo'));
        }else{
            try {
                $empleado->update([
                    'empEstado' => 'B'
                ]);
            } catch (Exception $e) {
                throw $e;
            }
            return json_encode(null);
        }
    }//darBaja.

    public function puedeSerEliminado($empleado_id){

        $empleado = Empleado::findOrFail($empleado_id);
        $user = User::where('empleado_id', $empleado_id)->first();

        $grupo = $empleado->grupos()
            ->latest()
            ->first();

        if($user || $grupo) {
            return json_encode(false);
        }else {
            return json_encode(true);
        }
    }//puedeSerEliminado.

    public function verificarExistenciaPersona(Request $request) {

        $alumno = MetodosPersonas::existeAlumno($request);
        $empleado = MetodosPersonas::existeEmpleado($request);

        $data = [
            'alumno' => $alumno,
            'empleado' => $empleado
        ];

        if($request->ajax()) {
            return json_encode($data);
        }else{
            return $data;
        }
    }//verificarExistenciaPersona.

    public function reactivarEmpleado($empleado_id) {

        $empleado = Empleado::findOrFail($empleado_id);

        if($empleado->empEstado == 'B') {
            $empleado->update([
                'empEstado' => 'A'
            ]);
        }

        return json_encode($empleado);
    }//reactivarEmpleado.

    public function alumno_crearEmpleado(Request $request, $alumno_id) {

        $validator = Validator::make($request->all(),
            [
                'empRfc'        => 'required',
                'empHorasCon'   => 'required',
                'escuela_id'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('preescolar_empleado/create')->withErrors($validator)->withInput();
        }

        $alumno = Alumno::findOrFail($alumno_id);
        $persona = $alumno->persona;

        DB::beginTransaction();
        try {
            $empleado = Empleado::create([
            'persona_id'      => $persona->id,
            'empHorasCon'     => Utils::validaEmpty($request->empHorasCon),
            'empCredencial'   => $request->empCredencial,
            'empNomina'       => Utils::validaEmpty($request->empNomina),
            'empRfc'          => $request->empRfc,
            'empImss'         => $request->empImss,
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
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('preescolar_empleado/create')->withInput();
        }
        DB::commit(); #TEST.

        if($request->ajax()) {
            return json_encode($empleado);
        }else{
            return $empleado;
        }
        
    }//alumno_crearEmpleado.

    public function cambioEstado()
    {
        if (User::permiso("empleado") != 'A' && User::permiso("empleado") != 'B') return redirect('preescolar_empleado');
        $mostrarFiltro = (User::permiso("empleado") == 'A');
        $mostrarEtiqueta = (User::permiso("empleado") == 'B');
        $etiqueta = User::permiso("empleado") == 'B' ? Auth::user()->empleado->escuela->escClave .' - '. Auth::user()->empleado->escuela->escNombre : '';
        $escuela_id = User::permiso("empleado") == 'B' ? Auth::user()->empleado->escuela->id : NULL;
        $ubicaciones = Ubicacion::get();
        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

        return view('preescolar.empleados.cambio-estado', [
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
        $empleados = Empleado::select('empleados.id as empleado_id','empleados.empCredencial','empleados.empNomina','empleados.empEstado',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','personas.perTelefono1', 'puestos.puesNombre', 'escuelas.escClave')
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            ->join('puestos', 'puestos.id', 'empleados.puesto_id')
            ->join('escuelas', 'escuelas.id', 'empleados.escuela_id')
            ->join('departamentos', 'departamentos.id', 'escuelas.departamento_id')            
            ->whereIn('empleados.empEstado', ['A', 'B'])
            ->whereIn('departamentos.depClave', ['MAT', 'PRE']);

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

    /**
    * Esta función recibe el cgt_id y un arreglo con múltiples alumnos [alumno_id => nueva_matricula]
    * por cada alumno, revisa si la matrícula fue cambiada, entonces registra el cambio.
    *
    * @param Illuminate\Http\Request $request
    * @param int $cgt_id
    */
    public function cambiarMultiplesStatusEmpleados(Request $request) {
        $listado = collect([$request->listado])->collapse()->keyBy('empleado_id');
        if($listado->isEmpty()) {
            return  response()->json([
                'status' => 'warning',
                'title' => 'Sin empleados.',
                'msg' => 'No se encontraron empleados en la lista.',
            ]);
        }

        $empleados = Empleado::whereIn('id', $listado->keys())->get()->keyBy('id');
        DB::beginTransaction();
        try {
            $listado->each(static function($info, $empleado_id) use ($empleados) {
                $empleado = $empleados->get($empleado_id);
                if($empleado->empEstado != $info['nuevo_estado']) {
                    $empleado->update(['empEstado' =>  $info['nuevo_estado']]);

                    $fechaActual = Carbon::now('CDT');
                    $fecha = $fechaActual->format('Y-m-d H:i:s');

                    Preescolar_UsuarioLog::create([
                        'nombre_tabla' => 'empleados',
                        'registro_id'  => $empleado->id,
                        'nombre_controlador_accion' => 'Preescolar\PreescolarEmpleadoController@cambiarMultiplesStatusEmpleados',
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

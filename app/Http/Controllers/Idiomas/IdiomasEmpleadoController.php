<?php

namespace App\Http\Controllers\Idiomas;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\User_docente;
use App\Http\Models\Persona;
use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Alumno;
use App\Http\Models\Pais;
use App\Http\Models\Estado;
use App\Http\Models\Idiomas\Idiomas_empleados;
use App\Http\Models\Municipio;
use App\Http\Models\Ubicacion;
use App\Http\Models\Puesto;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;


class IdiomasEmpleadoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:empleado',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('idiomas.empleados.show-list');
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $empleados = Idiomas_empleados::select('idiomas_empleados.id as empleado_id','idiomas_empleados.empCredencial','idiomas_empleados.empNomina','idiomas_empleados.empEstado',
            'idiomas_empleados.empNombre','idiomas_empleados.empApellido1','idiomas_empleados.empApellido2','idiomas_empleados.empTelefono', 'puestos.puesNombre', 'escuelas.escClave')
            ->join('puestos', 'puestos.id', 'idiomas_empleados.puesto_id')
            ->join('escuelas', 'escuelas.id', 'idiomas_empleados.escuela_id');

        return Datatables::of($empleados)
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

                $isAdmin = auth()->user()->isAdmin("empleado");

                $btn_baja = '<a href="#" data-id="'.$query->empleado_id.'" class="button button--icon js-button js-ripple-effect btn-darBaja" title="Dar de baja">
                    <i class="material-icons">arrow_downward</i>
                </a>';
                $btn_delete = '<form id="delete_' . $query->empleado_id . '" action="idiomas_empleado/' . $query->empleado_id . '" method="POST" style="display:inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->empleado_id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';

                return '<div class="row">
                    <a href="idiomas_empleado/'.$query->empleado_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                    </a>
                    <a href="idiomas_empleado/'.$query->empleado_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>'
                    . ($isAdmin ? $btn_baja : '') .
                '</div>';
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
        $ubicaciones = Ubicacion::get();
        $puestos = Puesto::get();
        return view('idiomas.empleados.create',compact('paises','ubicaciones', 'puestos'));
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
        $empCurpValida = 'required|max:18|unique:personas';

        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($empCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($empCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Idiomas_empleados::where("empCurp", "=", $request->empCurp)->first();

        if (!$empleado) {
            $empCurpValida = 'max:18';
        }

        //PAIS DIFERENTE DE MEXICO
        if ($request->paisId != "1") {
            $esCurpValida = "";
            $empCurpValida  = 'max:18';
        }



        $validator = Validator::make($request->all(),
            [
                'empRfc'        => 'required',
                'empHorasCon'   => 'required',
                'empNombre'     => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido1'  => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido2'  => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empCurp'       => $empCurpValida,
                'esCurpValida'  => $esCurpValida,
                'empFechaNac'   => 'required',
                'municipio_id'  => 'required',
                'empSexo'       => 'required',
                'empDirCP'      => 'required|max:5',
                'empDirCalle'   => 'required|max:25',
                'empDirNumExt'  => 'required|max:6',
                'empDirColonia' => 'required|max:60',
                'escuela_id'    => 'required'
            ],
            [
                'empRfc.unique' => "El rfc ya existe.",
                'empRfc.required' => "El Rfc es obligatorio.",
                'empHorasCon.required' => 'El campo Horas es obligatorio.',
                'empNomina.unique' => "La clave nomina ya existe",
                'empCredencial.unique' => "La clave de credencial ya existe",
                'empNombre.required' => 'El nombre es obligatorio',
                'empNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido1.required' => 'El apellido paterno es obligatorio',
                'empApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empFechaNac.required' => 'La Fecha de nacimiento es obligatoria.',
                'empDirCP.required' => 'El campo Código postal es obligatorio.',
                'empDirCalle.required'  => 'El campo de Calle es obligatorio',
                'empDirNumExt.required' => 'El campo Número exterior es obligatorio',
                'empDirColonia.required' => 'El campo Colonia es obligatorio',
            ]
        );

        if ($validator->fails()) {
            return redirect ('idiomas_empleado/create')->withErrors($validator)->withInput();
        }

        $existeRfc = Idiomas_empleados::where("empRfc", "=", $request->empRfc)->first();
        $existeNomina = Idiomas_empleados::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Idiomas_empleados::where("empCredencial", "=", $request->empCredencial)->first();


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


        $empCurp = $request->empCurp;
        if ($request->paisId != "1" && $request->empSexo == "M") {
            $empCurp = "XEXX010101MNEXXXA4";
        }
        if ($request->paisId != "1" && $request->empSexo == "F") {
            $empCurp = "XEXX010101MNEXXXA8";
        }

        try {
            $empleado = Idiomas_empleados::create([
                'empCURP'             => $empCurp,
                'empRFC'              => $request->empRfc,
                'empNSS'              => $request->empImss,
                'empNomina'           => Utils::validaEmpty($request->empNomina),
                'empCredencial'       => $request->empCredencial,
                'empApellido1'        => $request->empApellido1,
                'empApellido2'        => $request->empApellido2,
                'empNombre'           => $request->empNombre,
                'escuela_id'          => $request->escuela_id,
                'empHoras'            => Utils::validaEmpty($request->empHorasCon),
                'empDireccionCalle'   => $request->empDirCalle,
                'empDireccionNumero'  => $request->empDirNumExt,
                'empDireccionColonia' => $request->empDirColonia,
                'empDireccionCP'      => Utils::validaEmpty($request->empDirCP),
                'municipio_id'        => Utils::validaEmpty($request->municipio_id),
                'empTelefono'         => $request->empTelefono2,
                'empFechaNacimiento'  => $request->empFechaNac,
                'empCorreo1'          => $request->empCorreo1,
                'puesto_id'           => $request->puesto_id ?: 12, # id 12 = Docente.
                'empSexo'             => $request->empSexo,
                'empEstado'           => 'A',
                'empFechaIngreso'     => Carbon::now('America/Merida')->format('Y-m-d')
            ]);

            if ($empleado->save()) {
                if ($request->input('password')) {
                    User_docente::create([
                        'empleado_id'      => $empleado->id,
                        'password'         => bcrypt($request->input('password')),
                        'token'            => str_random(64),
                    ]);
                }

                alert('Escuela Modelo', 'El empleado se ha creado con éxito', 'success')->showConfirmButton();
                return redirect('idiomas_empleado');
            } else {
                alert()->error('Ups...', 'El empleado no se guardó correctamente')->showConfirmButton();
                return redirect('idiomas_empleado/create');
            }

        }catch (QueryException $e){
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return redirect('idiomas_empleado/create')->withInput();
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
        $empleado = Idiomas_empleados::select('idiomas_empleados.*', 'puestos.puesNombre')->join('puestos','puestos.id', '=', 'idiomas_empleados.puesto_id')->findOrFail($id);


        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        return view('idiomas.empleados.show',compact('empleado'));
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
        $empleado = Idiomas_empleados::select(
                'idiomas_empleados.*',
                'puestos.puesNombre',
                'paises.id AS pais_id',
                'estados.id AS estado_id')
            ->join('puestos','puestos.id', '=', 'idiomas_empleados.puesto_id')
            ->join('municipios','municipios.id', '=', 'idiomas_empleados.municipio_id')
            ->join('estados','estados.id', '=', 'municipios.estado_id')
            ->join('paises','paises.id', '=', 'estados.pais_id')
            ->findOrFail($id);


        if ($empleado->id == 0 || $empleado->id == 1) {
            alert()->error('Ups...', 'El empleado no existe')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        $pais_id = $empleado->pais_id;
        $estado_id = $empleado->estado_id;
        $estados = Estado::where('pais_id',$pais_id)->get();
        $municipios = Municipio::where('estado_id',$estado_id)->get();

        $departamento = $empleado->escuela->departamento;
        $grupo = $empleado->idiomas_grupos()
                ->whereIn('periodo_id', [$departamento->perActual, $departamento->perSig])
                ->latest()
                ->first();
        $grupo ? $puedeDarseDeBaja = false : $puedeDarseDeBaja = true;
        $puestos = Puesto::get();


        // if (in_array(User::permiso("empleado"), ['A', 'B', 'C'])) {
            return view('idiomas.empleados.edit', compact('empleado','paises','ubicaciones','estados','municipios', 'puedeDarseDeBaja', 'puestos'));
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_empleado');
        // }



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
        $empCurpValida = 'required|max:18|unique:personas';
        if ($request->paisId != "1" || $request->perCurpOld == $request->perCurp) {// si pais es diferente de mexico
            $esCurpValida = "";
            $empCurpValida  = 'max:18';
        }


        //AQUI HACER UN JOIN DE EMPLEADO->PERSONA.
        //SI EXISTE COMO EMPLEADO->PERSONA,  NO GUARDAR ($empCurpValida CON UNIQUE)
        // SI NO EXISTE COMO EMPLEADO->PERSONA, GUARDAR ($empCurpValida SIN UNIQUE)
        //INDIFERENTE DE ALUMNO->PERSONA
        $empleado = Idiomas_empleados::select(
            'idiomas_empleados.*',
            'puestos.puesNombre',
            'paises.id AS pais_id',
            'estados.id AS estado_id')
        ->join('puestos','puestos.id', '=', 'idiomas_empleados.puesto_id')
        ->join('municipios','municipios.id', '=', 'idiomas_empleados.municipio_id')
        ->join('estados','estados.id', '=', 'municipios.estado_id')
        ->join('paises','paises.id', '=', 'estados.pais_id')
        ->findOrFail($id);


        if (!$empleado) {
            $empCurpValida = 'max:18';
        }


        if ($request->paisId == "1" && ($request->perCurp == "XEXX010101MNEXXXA4" || $request->perCurp == "XEXX010101MNEXXXA8" )) {
            $esCurpValida  = "accepted";
            $empCurpValida = 'required|max:18|unique:personas';
        }

        $validator = Validator::make($request->all(),
            [
                'empRfc'                => 'required|min:11|max:13',
                'empHoras'           => 'required',
                'empNombre'             => ['required','max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido1'          => ['required','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empApellido2'          => ['nullable','max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'empCurp'               => $empCurpValida,
                'esCurpValida'          => $esCurpValida,
                'empFechaNacimiento'           => 'required',
                'municipio_id'          => 'required',
                'empSexo'               => 'required',
                'empDirCP'              => 'required|max:5',
                'empDirCalle'           => 'required|max:25',
                'empDirNumExt'          => 'required|max:6',
                'empDirColonia'         => 'required|max:60',
                'password'              => 'max:20|confirmed',
                'password_confirmation' => 'same:password',
                'escuela_id'            => 'required'
            ],[
                'empNombre.required' => 'El nombre es obligatorio',
                'empNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido1.required' => 'El apellido paterno es obligatorio',
                'empApellido1.regex' => 'Los apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empApellido2.regex' => 'Los apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'empFechaNacimiento.required' => 'Laa Fecha de nacimiento es obligatoria.',
                'empDirCP.required' => 'El campo Código postal es obligatorio.',
                'empDirCalle.required'  => 'El campo de Calle es obligatorio',
                'empDirNumExt.required' => 'El campo Número exterior es obligatorio',
                'empDirColonia.required' => 'El campo Colonia es obligatorio',
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $existeRfc = Idiomas_empleados::where("empRfc", "=", $request->empRfc)->first();
        $existeNomina = Idiomas_empleados::where("empNomina", "=", $request->empNomina)->first();
        $existeCredencial = Idiomas_empleados::where("empCredencial", "=", $request->empCredencial)->first();


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
            $empleado = Idiomas_empleados::findOrFail($id);
            
            $empleado->empCurp       = $request->empCurp;
            $empleado->empApellido1  = $request->empApellido1;
            $empleado->empApellido2  = $request->empApellido2;
            $empleado->empNombre     = $request->empNombre;
            $empleado->empFechaNacimiento   = $request->empFechaNacimiento;
            $empleado->municipio_id  = Utils::validaEmpty($request->municipio_id);
            $empleado->empSexo       = $request->empSexo;
            $empleado->empCorreo1    = $request->empCorreo1;
            $empleado->empTelefono  = $request->empTelefono1;
            $empleado->empDireccionCP      = Utils::validaEmpty($request->empDirCP);
            $empleado->empDireccionCalle   = $request->empDirCalle;
            $empleado->empDireccionNumero  = $request->empDirNumExt;
            $empleado->empDireccionColonia = $request->empDirColonia;
            
            $empleado->empHoras      = Utils::validaEmpty($request->empHoras);
            $empleado->empCredencial    = $request->empCredencial;
            $empleado->empNomina        = Utils::validaEmpty($request->empNomina);
            $empleado->empRfc           = $request->empRfc;
            $empleado->empNSS          = $request->empNSS;
            $empleado->escuela_id       = $request->escuela_id;
            $empleado->empEstado        = $request->empEstado;
            $empleado->puesto_id        = $request->puesto_id ?: 12;

            $empleado->save();


            if ($request->password) {
                $user_docente = User_docente::where('empleado_id',$empleado->id)->first();
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
                alert('Escuela Modelo', 'El empleado se ha actualizado con éxito','success')->showConfirmButton();
                return redirect('idiomas_empleado');
            } else {
                alert()->error('Ups...','El empleado no se actualizado correctamente')->showConfirmButton();
                return redirect('idiomas_empleado/' . $id . '/edit');
            }
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();

            return redirect('idiomas_empleado/' . $id . '/edit')->withInput();
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
        // if(!auth()->user()->isAdmin('empleado')) {
            alert('Ups!', 'Sin privilegios para esta acción', 'error')->showConfirmButton();
            return back();
        // }

        $empleado = Idiomas_empleados::findOrFail($id);
        try {
            $empleado->delete();
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back();
        }

        alert('Escuela Modelo', 'El empleado se ha eliminado con éxito', 'success')->showConfirmButton();
        return redirect('idiomas_empleado');
    }


    public function darDeBaja($id) {

        if(!auth()->user()->isAdmin('empleado')) {
            return response()->json('Sin permisos');
        }

        $empleado = Idiomas_empleados::findOrFail($id);
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
    }

    public function puedeSerEliminado($empleado_id){

        $empleado = Idiomas_empleados::findOrFail($empleado_id);
        $user = User::where('empleado_id', $empleado_id)->first();

        $grupo = $empleado->grupos()
            ->latest()
            ->first();

        if($user || $grupo) {
            return json_encode(false);
        }else {
            return json_encode(true);
        }
    }

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
    }

    public function reactivarEmpleado($empleado_id) {

        $empleado = Idiomas_empleados::findOrFail($empleado_id);

        if($empleado->empEstado == 'B') {
            $empleado->update([
                'empEstado' => 'A'
            ]);
        }

        return json_encode($empleado);
    }

    public function alumno_crearEmpleado(Request $request, $alumno_id) {

        $validator = Validator::make($request->all(),
            [
                'empRfc'        => 'required',
                'empHorasCon'   => 'required',
                'escuela_id'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('empleado/create')->withErrors($validator)->withInput();
        }

        $alumno = Alumno::findOrFail($alumno_id);
        $persona = $alumno->persona;

        DB::beginTransaction();
        try {
            $empleado = Idiomas_empleados::create([
            'persona_id'      => $persona->id,
            'empHorasCon'     => Utils::validaEmpty($request->empHorasCon),
            'empCredencial'   => $request->empCredencial,
            'empNomina'       => Utils::validaEmpty($request->empNomina),
            'empRfc'          => $request->empRfc,
            'empImss'         => $request->empImss,
            'escuela_id'      => $request->escuela_id,
            'empEstado'       => 'A',
            'empFechaRegistro'=> Carbon::now('America/Merida')->format('Y-m-d'),
            'puesto_id'       => 12, # id 12 = Docente.
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
            return redirect('empleado/create')->withInput();
        }
        DB::commit(); #TEST.

        if($request->ajax()) {
            return json_encode($empleado);
        }else{
            return $empleado;
        }
        
    }
}
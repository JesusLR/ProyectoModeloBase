<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpleadoSeguimiento;
use App\Models\Empleado;
use App\Models\Ubicacion;
use App\Models\User;
use Auth;
use Validator;
use DB;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class EmpleadoSeguimientoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:usuario', ['except' => ['index','show','list']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $showBotonAgregar = (User::permiso("usuario") == "B");
        return View('notificaciones_coordinacion.show-list', compact('showBotonAgregar'));
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $empleados = EmpleadoSeguimiento::select(
                'empleadosseguimiento.id',
                'personas.perNombre AS perNombre',
                'personas.perApellido1 AS perApellido1',
                'personas.perApellido2 AS perApellido2',
                'escuelas.escNombre',
                'empleadosseguimiento.empCorreo1',
                'programas.progNombre',
                'empleadosseguimiento.modulo')
            ->join('personas', 'empleadosseguimiento.persona_id', '=', 'personas.id')
            ->join('escuelas', 'empleadosseguimiento.escuela_id', '=', 'escuelas.id')
            ->join('programas', 'empleadosseguimiento.prog_id', '=', 'programas.id');

        return Datatables::of($empleados)
        ->filterColumn('nombreCompleto',function($query,$keyword){
            return $query->whereRaw("CONCAT(personas.perNombre, ' ', personas.perApellido1, ' ', personas.perApellido2) LIKE ?", ["%{$keyword}%"]);
        })
        ->addColumn('nombreCompleto',function($query){
            return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
        })
        ->addColumn('action',function($empleados){
            return '<a href="notificaciones_coordinacion/'.$empleados->id.'" class="button button--icon js-button js-ripple-effect" title="Ver seguimiento de empleado">
                <i class="material-icons">account_circle</i>
            </a>
            <a href="notificaciones_coordinacion/'.$empleados->id.'/edit" class="button button--icon js-button js-ripple-effect">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_'.$empleados->id.'" action="notificaciones_coordinacion/'.$empleados->id.'" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <a href="#" data-id="'.$empleados->id.'" class="button button--icon js-button js-ripple-effect confirm-delete">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        }) ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accessAgregar = (User::permiso("usuario") == "B");
        if (!$accessAgregar) {
            return redirect ('notificaciones_coordinacion');
        }
        $ubicaciones = Ubicacion::get();
        $empleados = Empleado::with('persona')->where("empleados.empEstado", "=", "A")->get();
        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
        return view('notificaciones_coordinacion.create', compact('empleados', 'ubicaciones', 'ubicacion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empleadoSeguimiento = EmpleadoSeguimiento::select('modulo', 'prog_id', DB::raw('count(*) as total'))
            ->where('modulo', $request->modulo)
            ->where('prog_id', $request->programa_id)
            ->groupBy('modulo', 'prog_id')->first();

        if ($empleadoSeguimiento->total >= 2) {
            alert()->error('Lo sentimos','Ya existen al menos 2 registros con el mismo programa y módulo')->showConfirmButton();
                return redirect('notificaciones_coordinacion/create')->withInput();
        }
        $validator = Validator::make($request->all(),
            [
                'persona_id'           => 'required',
                'escuela_id'           => 'required',
                'empCorreo1'           => 'required|regex:/(.*)@(modelo)[.](edu)[.](mx)$/',
                'programa_id'           => 'required',
                'modulo'           => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ('notificaciones_coordinacion/create')->withErrors($validator)->withInput();
        } else {
            try {
                EmpleadoSeguimiento::create([
                    'persona_id' => $request->input('persona_id'),
                    'escuela_id' => $request->input('escuela_id'),
                    'empCorreo1' => $request->input('empCorreo1'),
                    'prog_id'    => $request->input('programa_id'),
                    'modulo'     => $request->input('modulo'),
                ]);

                alert('Escuela Modelo', 'El seguimiento del empleado se ha creado con éxito','success')->showConfirmButton();
                return redirect('notificaciones_coordinacion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect('notificaciones_coordinacion/create')->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empleadoSeguimiento = EmpleadoSeguimiento::select(
            'empleadosseguimiento.id',
            'personas.perNombre AS perNombre',
            'personas.perApellido1 AS perApellido1',
            'personas.perApellido2 AS perApellido2',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'empleadosseguimiento.empCorreo1',
            'programas.progClave',
            'programas.progNombre',
            'empleadosseguimiento.modulo')
        ->join('personas', 'empleadosseguimiento.persona_id', '=', 'personas.id')
        ->join('escuelas', 'empleadosseguimiento.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('programas', 'empleadosseguimiento.prog_id', '=', 'programas.id')
        ->where('empleadosseguimiento.id', $id)
        ->first();
        $empleados = Empleado::with('persona')->where("empleados.empEstado", "=", "A")->get();
        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
        return view('notificaciones_coordinacion.show',compact('empleadoSeguimiento','ubicaciones','empleados', 'ubicacion_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleadoSeguimiento = EmpleadoSeguimiento::select(
            'empleadosseguimiento.id',
            'personas.id AS persona_id',
            'personas.perNombre AS perNombre',
            'personas.perApellido1 AS perApellido1',
            'personas.perApellido2 AS perApellido2',
            'escuelas.id AS escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.id AS departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id AS ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'empleadosseguimiento.empCorreo1',
            'programas.id AS programa_id',
            'programas.progClave',
            'programas.progNombre',
            'empleadosseguimiento.modulo')
        ->join('personas', 'empleadosseguimiento.persona_id', '=', 'personas.id')
        ->join('escuelas', 'empleadosseguimiento.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('programas', 'empleadosseguimiento.prog_id', '=', 'programas.id')
        ->where('empleadosseguimiento.id', $id)
        ->first();
        $ubicaciones = Ubicacion::get();
        $empleados = Empleado::with('persona')->where("empleados.empEstado", "=", "A")->get();
        return view('notificaciones_coordinacion.edit',compact('empleadoSeguimiento','ubicaciones','empleados', 'ubicacion_id'));
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
        $validator = Validator::make($request->all(),
            [
                'persona_id'           => 'required',
                'escuela_id'           => 'required',
                'empCorreo1'           => 'required|regex:/(.*)@(modelo)[.](edu)[.](mx)$/',
                'programa_id'           => 'required',
                'modulo'           => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ('notificaciones_coordinacion/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $empleadoSeguimiento = EmpleadoSeguimiento::findOrFail($id);
                $empleadoSeguimiento->empCorreo1  = $request->input('empCorreo1');

                $empleadoSeguimiento->save();

                alert('Escuela Modelo', 'El seguimiento del empleado se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect('notificaciones_coordinacion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('notificaciones_coordinacion/'.$id.'/edit')->withInput();
            }
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
        $empleadoSeguimiento = EmpleadoSeguimiento::findOrFail($id);
        try {
            $empleadoSeguimiento->delete();
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back();
        }

        alert('Escuela Modelo', 'El seguimiento del empleado se ha eliminado con éxito', 'success')->showConfirmButton();
        return redirect('notificaciones_coordinacion');
    }

    public function getEmpleadoDatos(Request $request, $id)
    {

        if($request->ajax()){

            $empleados = Empleado::select(
                'empleados.empCorreo1'
            )
            ->where('empleados.persona_id', '=', $id)
            ->first();
         

            return response()->json($empleados);
        }
    }
}

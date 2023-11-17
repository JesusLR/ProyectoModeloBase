<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_agenda_colores;
use App\Http\Models\Bachiller\Bachiller_agendas;

class BachillerAgendaController extends Controller
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
        $empleado_id = auth()->user()->empleado_id;        
        $bachiller_agenda_colores = Bachiller_agenda_colores::where("empleado_id", "=", $empleado_id)->first(); 
        
        /* --- inner para obtener el valor del nombre y colores de los usuarios -- */
        $colores_usuarios = Bachiller_agenda_colores::select('bachiller_agenda_colores.id', 'bachiller_agenda_colores.preesColor',
            'users.username', 'bachiller_empleados.empNombre',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre')
        ->join('users', 'users.empleado_id', '=', 'bachiller_agenda_colores.empleado_id')
        ->leftJoin('bachiller_empleados', 'bachiller_empleados.id', '=', 'users.empleado_id')
        ->leftJoin('empleados', 'empleados.id', '=', 'users.empleado_id')
        ->leftJoin('personas', 'personas.id', '=', 'empleados.persona_id')
        ->get();
        

        return view('bachiller.calendario.show-list', [
            'bachiller_agenda_colores' => $bachiller_agenda_colores,
            'colores_usuarios' => $colores_usuarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosEvento = request()->except(['_token','_method']);
        Bachiller_agendas::insert($datosEvento);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['eventos'] = Bachiller_agendas::select('bachiller_agendas.id', 'bachiller_agendas.title', 'bachiller_agendas.description',
        'bachiller_agendas.color', 'bachiller_agendas.textColor', 'bachiller_agendas.start', 'bachiller_agendas.end',
        'bachiller_agendas.usuario_at',
        'bachiller_empleados.empNombre', 
        'bachiller_empleados.empApellido1', 
        'bachiller_empleados.empApellido2',
        'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre')
        ->join('users', 'users.id', '=', 'bachiller_agendas.usuario_at')
        ->leftJoin('bachiller_empleados', 'bachiller_empleados.id', '=', 'users.empleado_id')
        ->leftJoin('empleados', 'empleados.id', '=', 'users.empleado_id')
        ->leftJoin('personas', 'personas.id', '=', 'empleados.persona_id')
        ->whereNull('bachiller_agendas.deleted_at')
        ->get();
        return response()->json($data['eventos']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $datosEvento = request()->except(['_token','_method']);
        $respuesta = Bachiller_agendas::where('id', '=', $id)->update($datosEvento);
        return response()->json($respuesta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eventos = Bachiller_agendas::findOrFail($id);
        Bachiller_agendas::destroy($id);
        return response()->json($id);
    }
}

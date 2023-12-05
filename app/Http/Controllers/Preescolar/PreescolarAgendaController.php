<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Preescolar\Preescolar_agenda;
use App\Models\Preescolar\Preescolar_agenda_colores;


class PreescolarAgendaController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
          
        /* ----------------- seleccionar color del usuario logueado ----------------- */
        $usuario_id = auth()->user()->id;        
        $preescolar_agenda_colores = Preescolar_agenda_colores::where("users_id", "=", $usuario_id)->first(); 
        
        /* --- inner para obtener el valor del nombre y colores de los usuarios -- */
        $colores_usuarios = Preescolar_agenda_colores::select('preescolar_agenda_colores.id', 'preescolar_agenda_colores.preesColor', 'users.username', 'personas.perNombre', 'personas.perApellido1', '.perApellido2')
        ->join('users', 'users.id', '=', 'preescolar_agenda_colores.users_id')
        ->join('empleados', 'empleados.id', '=', 'users.empleado_id')
        ->join('personas', 'personas.id', '=', 'empleados.persona_id')      
        ->get();

        return view('preescolar.calendario.show', compact('preescolar_agenda_colores', 'colores_usuarios'));
    }
  
    /* --------- funcion que permite registrar los eventos al calendario -------- */
    public function store(Request $request)
    {
        $datosEvento = request()->except(['_token','_method']);
        Preescolar_agenda::insert($datosEvento);
    }

    /* ---------- funcion que permite mostrar los eventos al calendario --------- */
    public function show()
    {
        $data['eventos'] = Preescolar_agenda::select('preescolar_agendas.id', 'preescolar_agendas.title', 'preescolar_agendas.description', 
        'preescolar_agendas.color', 'preescolar_agendas.textColor', 'preescolar_agendas.start', 'preescolar_agendas.end', 'preescolar_agendas.user_id',
        'personas.perNombre', 'personas.perApellido1', '.perApellido2')
        ->join('users', 'users.id', '=', 'preescolar_agendas.user_id')
        ->join('empleados', 'empleados.id', '=', 'users.empleado_id')
        ->join('personas', 'personas.id', '=', 'empleados.persona_id') 
        ->whereNull('preescolar_agendas.deleted_at')
        ->get();
        return response()->json($data['eventos']);
    }

    /* -------- funcion que permite actualizar los eventos al calendario -------- */
    public function update(Request $request, $id)
    {
        $datosEvento = request()->except(['_token','_method']);
        $respuesta = Preescolar_agenda::where('id', '=', $id)->update($datosEvento);
        return response()->json($respuesta);
    }
    
    public function destroy($id)
    {
        $eventos = Preescolar_agenda::findOrFail($id);
        Preescolar_agenda::destroy($id);
        return response()->json($id);
    }
}

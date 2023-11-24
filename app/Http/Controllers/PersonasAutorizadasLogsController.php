<?php

namespace App\Http\Controllers;

use App\Models\Logs_personas_autorizadas;
use Illuminate\Http\Request;

class PersonasAutorizadasLogsController extends Controller
{
    public function guardarResponsables(Request $request)
    {
        if ($request->ajax()) {

            // variables
            $curso_id = $request->input("curso_id");
            $alumno_id = $request->input('alumno_id');
            $ip_emitente = $request->input('ip_emitente');
            $tipo_accion = $request->input('tipo_accion');
            $fecha_hora_movimiento = $request->input('fecha_hora_movimiento');
            $usuario_at = $request->input('usuario_at');


            $logs_personas_autorizadas = Logs_personas_autorizadas::create([
                'curso_id' => $curso_id,
                'alumno_id' => $alumno_id,
                'ip_emitente' => $ip_emitente,
                'tipo_accion' => $tipo_accion,
                'fecha_hora_movimiento' => $fecha_hora_movimiento,
                'usuario_at' => $usuario_at
            ]);
            
            if($logs_personas_autorizadas){
                return response()->json([
                    'res' => "true"                
                ]);
            }

            
        }
    }
}

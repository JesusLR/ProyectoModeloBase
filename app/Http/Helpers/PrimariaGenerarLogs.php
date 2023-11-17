<?php
namespace App\Http\Helpers;

use App\Http\Models\Primaria\Primaria_UsuarioLog;
use Carbon\Carbon;

class PrimariaGenerarLogs
{
  public static function crearLogs($data)
  {
    Primaria_UsuarioLog::create([
      'curso_id' => $data->curso_id,
      'alumno_id' => $data->alumno_id,
      'nombre_tabla' => $data->nombreTabla,
      'registro_id' => $data->registroId,
      'nombre_controlador_accion' => request()->route()->action["controller"],
      'tipo_accion' => $data->tipo_accion,
      'fecha_hora_movimiento' => Carbon::now()->format('Y-m-d H:i:s'),
    ]);
  }
}
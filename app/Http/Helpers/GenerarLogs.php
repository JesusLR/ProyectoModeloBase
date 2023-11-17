<?php
namespace App\Http\Helpers;

use App\Http\Models\UsuarioLog;

class GenerarLogs
{
  public static function crearLogs($data)
  {
    UsuarioLog::create([
      'nombre_tabla' => $data->nombreTabla,
      'registro_id'  => $data->registroId,
      'nombre_controlador_accion' => request()->route()->action["controller"]
    ]);
  }
}
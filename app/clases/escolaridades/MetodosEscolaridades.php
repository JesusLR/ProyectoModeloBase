<?php
namespace App\clases\escolaridades;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Http\Models\Escolaridad;

class MetodosEscolaridades
{
    /**
    * @param int $empleado_id
    */
    public static function actualizarUltimoGrado($empleado_id)
    {
        $escolaridades = Escolaridad::with('empleado')
        ->where('empleado_id', $empleado_id)->latest('escoFechaDocumento')->get();

        if($escolaridades->isNotEmpty()) {
            $escolaridades->each(static function($escolaridad) {
                $escolaridad->update(['escoUltimoGrado' => 'N']);
            });
            $escolaridades->first()->update(['escoUltimoGrado' => 'S']);
        }
        return $escolaridades;
    }
}
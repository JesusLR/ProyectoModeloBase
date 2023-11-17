<?php
namespace App\Http\Helpers;

use App\Http\Models\UsuarioLog;

class TruncarDecimales
{
    public static function truncateFloat($number, $digitos)
    {
        $raiz = 10;
        $multiplicador = pow ($raiz,$digitos);
        $resultado = ((int)($number * $multiplicador)) / $multiplicador;
        return number_format($resultado, $digitos);
    
    }
}
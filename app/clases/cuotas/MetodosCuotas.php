<?php
namespace App\clases\cuotas;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Http\Models\Cuota;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;

class MetodosCuotas
{
    /**
    * @param App\Http\Models\Cuota
    */
    public static function definirEagerLoading($cuota) : string 
    {
        $prefix = 'relacion';

        switch ($cuota->cuoTipo) {
            case 'P':
                $prefix .= '.escuela.departamento.ubicacion';
                break;
            case 'E':
                $prefix .= '.departamento.ubicacion';
                break;
            case 'D':
                $prefix .= '.ubicacion';
                break;
        }

        return $prefix;
    }


    /**
    * @param App\Http\Models\Cuota
    */
    public static function ubicacion($cuota)
    {

        if($cuota->cuoTipo == 'P') {
            return self::existe_relacion($cuota) ? $cuota->relacion->escuela->departamento->ubicacion : null;
        } else if($cuota->cuoTipo == 'E') {
            return self::existe_relacion($cuota) ? $cuota->relacion->departamento->ubicacion : null;
        } else if($cuota->cuoTipo == 'D') {
            return self::existe_relacion($cuota) ? $cuota->relacion->ubicacion : null;
        } else {
            return null;
        }
    }


    /**
    * @param App\Http\Models\Cuota
    */
    public static function existe_relacion($cuota)
    {
        return $cuota->relacion ? true : false;
    }


    /**
     * @param App\Http\Models\Cuota $cuota
     * @param App\Http\Models\CuotaDescuento $cuota_descuento
     */
    public static function aplicaDescuento($curso, $cuota_descuento): bool 
    {
        $grado = $curso->cgt->cgtGradoSemestre;
        $esGradoValido = $grado >= $cuota_descuento->cudGradoInicial && $grado <= $cuota_descuento->cudGradoFinal;
        $esTipoIngresoValido = $cuota_descuento->cudTipoIngreso ? $cuota_descuento->cudTipoIngreso == $curso->curTipoIngreso : true;

        return $cuota_descuento->esFechaValida() && $esGradoValido && $esTipoIngresoValido;
    }
}
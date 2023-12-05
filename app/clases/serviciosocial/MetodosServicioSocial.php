<?php
namespace App\clases\serviciosocial;
 
use Illuminate\Http\Request;
use App\Models\ServicioSocial;

class MetodosServicioSocial
{


    public static function estados(): array
    {
        return [
            'A' => 'Activo',
            'S' => 'Suspendido',
            'C' => 'Cancelado',
            'L' => 'Liberado',
        ];
    }

    public static function clasificaciones(): array
    {
        return [
            'F' => 'Público Federal',
            'E' => 'Público Estatal',
            'P' => 'Público Municipal',
            'M' => 'Modelo',
            'S' => 'Social',
        ];
    }


    /**
    * @param string
    */
    public static function describirEstado($clave)
    {
        $estados = self::estados();
        return $estados[$clave] ?: 'Indefinido';
    }


    /**
    * @param string
    */
    public static function describirClasificacion($clave)
    {
        $clasificaciones = self::clasificaciones();
        return $clasificaciones[$clave] ?: 'Indefinido';
    }
}
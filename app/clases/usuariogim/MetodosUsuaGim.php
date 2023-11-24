<?php
namespace App\clases\usuariogim;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Models\UsuaGim;
use App\Models\Pago;
use App\Http\Helpers\GenerarReferencia;

use Exception;
use Carbon\Carbon;

class MetodosUsuaGim
{   
    /**
    * devuelve los pagos buscando por la clave de usuario, esta clave está
    * conformada por el prefijo '0000' más el número de usuario (usuagim_id)
    * @param int
    */
    public static function buscarPagos($usuagim_id)
    {
        $clave_usuario = '0000'.$usuagim_id;
        return Pago::with('concepto')->where('pagClaveAlu', $clave_usuario)->latest('pagFechaPago');
    }



    /**
    * Devuelve los usuarios de gimnasio filtrados desde parámetros de un request.
    * hecho principalmente para las vistas de los reportes.
    *
    * @param Illuminate\Http\Request
    */
    public static function buscarDesdeRequest($request) {
        $usuarios = UsuaGim::with('tipo', 'alumno')
        ->where(static function($query) use ($request) {
            if($request->usuariogim_id) {
                $query->where('id', $request->usuariogim_id);
            }
            if($request->gimTipo) {
                $query->where('gimTipo', $request->gimTipo);
            }
            if($request->gimApellidoPaterno) {
                $query->where('gimApellidoPaterno', $request->gimApellidoPaterno);
            }
            if($request->gimApellidoMaterno) {
                $query->where('gimApellidoMaterno', $request->gimApellidoMaterno);
            }
            if($request->gimNombre) {
                $query->where('gimNombre', $request->gimNombre);
            }
        });
        if($request->aluClave) {
            $usuarios = $usuarios->whereHas('alumno', static function($query) use ($request) {
                $query->where('aluClave', $request->aluClave);
            });
        }

        return $usuarios;
    }



    /**
    * @param App\Models\UsuaGim $usuariogim
    * @param boolean $invertido
    */
    public static function nombreCompleto($usuariogim, $invertido = false): String
    {
        $nombre = $usuariogim->gimNombre;
        $apellidos = $usuariogim->gimApellidoPaterno.' '.$usuariogim->gimApellidoMaterno;

        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }



    /**
    * @param App\Models\UsuaGim
    */
    public static function generar_referencia($usuariogim)
    {   
        $clave_pago = '0000'.$usuariogim->id;
        $carbon_now = Carbon::now('America/Merida');
        $anio = $carbon_now->format('y');
        $mes = $carbon_now->format('m');
        $fecha = $carbon_now->format('Y-m-d');
        $tugImporte = $usuariogim->tipo->tugImporte;
        $importeReferencia = number_format(ceil($tugImporte), 2, '.', '');
        $referenciaParcial = $clave_pago.$anio.$mes;
        try {
            $referencia = new GenerarReferencia;
            $referencia_final = $referencia->crear($referenciaParcial, $fecha, $importeReferencia);
        } catch (Exception $e) {
            throw new Exception("Error procesando referencia: {$e->getMessage()}", 1);
        }

        return $referencia_final;
    }

}
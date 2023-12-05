<?php
namespace App\clases\periodos;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Periodo;

class MetodosPeriodos
{
    /**
    * Devuelve los periodos anteriores, dado un periodo.
    *
    * @param App\Models\Periodo $periodo.
    * @param string $perEstado. (opcional)
    */
    public static function buscarAnteriores($periodo,$perEstado = null){
        
        return Periodo::where(static function($query) use($periodo,$perEstado){
            $query->where('departamento_id','=',$periodo->departamento_id);
            if($perEstado != null){
                $query->where('perEstado','=',$perEstado);
            }
            $query->where('perFechaInicial','<',$periodo->perFechaInicial);
        })->latest('perFechaInicial');
    }

    /**
    * Devuelve los periodos siguientes, dado un periodo.
    *
    * @param App\Models\Periodo $periodo.
    * @param string $perEstado. (opcional)
    */
    public static function buscarSiguientes($periodo, $perEstado = null) {
        
        return Periodo::where(static function($query) use ($periodo, $perEstado) {
            $query->where('departamento_id', $periodo->departamento_id);
            if($perEstado) {
                $query->where('perEstado', $perEstado);
            }
            $query->where('perFechaInicial', '>', $periodo->perFechaInicial);
        })->oldest('perFechaInicial');
    }


    /**
    * @param string
    */
    public static function definirEstructura($perEstado)
    {
        switch ($perEstado) {
            case 'A':
                $perEstado = 'Años';
                break;
            case 'B':
                $perEstado = 'Bimestres';
                break;
            case 'C':
                $perEstado = 'Cuatrimestres';
                break;
            case 'S':
                $perEstado = 'Semestres';
                break;
        }
    }
}
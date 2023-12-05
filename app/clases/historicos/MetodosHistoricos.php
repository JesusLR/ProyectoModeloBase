<?php
namespace App\clases\historicos;

use Illuminate\Http\Request;

use App\Models\Historico;
use App\Models\Materia;


class MetodosHistoricos
{

	/**
	* @param App\Models\Historico
	* @param App\Models\Materia
	*/
	public static function definirCalificacion($historico, $materia)
	{
		if($materia->esAlfabetica()) {
	      return $historico->histCalificacion == 0 ? 'Apr' : 'No Apr';
	    } else {
	      return self::calificacionNumerica($historico->histCalificacion);
	    }
	}

	public static function definirCalificacionInscritos($historico, $materia)
	{
		if($materia->esAlfabetica()) {
	      return $historico->histCalificacion == 0 ? '100' : '0';
	    } else {
	      return $historico->histCalificacion;
	    }
	}


	/**
	* Define la calificacion de una materia tipo numérica.
	*
	* @param int
	*/
	public static function calificacionNumerica($calificacion)
	{
		switch ($calificacion) {
		    case -1:
		    	$calificacion = 'Des';
		    	break;
		    case -2:
		    	$calificacion = 'S/D';
		    	break;
		    case -3:
		    	$calificacion = 'Npa';
		    	break;
	  }

		return $calificacion;
	}

	public static function es_aprobada($calificacion, $calificacion_minima)
	{
		return $calificacion >= $calificacion_minima || $calificacion == 'Apr';
	}

	public static function es_reprobada($calificacion, $calificacion_minima)
	{
		return $calificacion < $calificacion_minima || $calificacion == 'No Apr';
	}
}
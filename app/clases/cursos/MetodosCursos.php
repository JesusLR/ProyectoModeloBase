<?php
namespace App\clases\cursos;

use App\Http\Models\Curso;
use App\Http\Models\BecaHistorial;

use Carbon\Carbon;

class MetodosCursos
{

	public static function tiposDeIngreso(): array
	{
		return [
            'PI' => 'PI - PRIMER INGRESO',
            'RO' => 'RO - REPETIDOR',
            'RE' => 'RE - REINSCRIPCIÓN',
            'RI' => 'RI - REINGRESO',
            'EQ' => 'EQ - REVALIDACIÓN',
            'OY' => 'OY - OYENTE',
            'XX' => 'XX - OTRO',
        ];

	}

	/**
	 * Crea un registro en becas_historial recolectando la información del
	 * curso proporcionado.
	 * 
	 * @param App\Http\Models\Curso
	 */
	public static function crearHistorialDeBeca($curso): BecaHistorial
	{
		return BecaHistorial::create([
			'alumno_id' => $curso->alumno_id,
			'curso_id' => $curso->id,
			'porcentaje' => $curso->curPorcentajeBeca,
			'tipo' => $curso->curTipoBeca,
			'observaciones' => $curso->curObservacionesBeca,
			'fecha_cambio' => Carbon::now('America/Merida'),
			'admin_id' => auth()->user()->id,
		]);
	}

	/**
	 * Verifica si existen cambios en los campos:
	 * curTipoBeca, curPorcentajeBeca, curObservacionesBeca.
	 * 
	 * @param App\Http\Models\Curso $curso_actual
	 * @param App\Http\Models\Curso $curso_anterior
	 */
	public static function hayCambioDeBeca($curso_actual, $curso_anterior): bool
	{
		return $curso_actual->curTipoBeca != $curso_anterior->curTipoBeca
		|| $curso_actual->curPorcentajeBeca != $curso_anterior->curPorcentajeBeca
		|| $curso_actual->curObservacionesBeca != $curso_anterior->curObservacionesBeca;
	}
}
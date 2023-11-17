<?php
namespace App\Exports;

use Illuminate\Support\Collection;

use App\clases\personas\MetodosPersonas as Personas;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class FichasIncorrectasEduContinuaExport implements FromCollection
{
	public $fichas;

	/**
	* @param App\Support\Collection
	*/
	public function __construct(Collection $fichas) {
		$this->fichas = $fichas;
	}

	public function collection()
	{
		
		return $this->fichas->map(static function($ficha) {
			return [
				'username' => $ficha->usuario->username,
				'fchClaveAlu' => $ficha->fchClaveAlu,
				'nombre_alumno' => Personas::nombreCompleto($ficha->alumno->persona, true),
				'fchNumPer' => $ficha->fchNumPer,
				'fchAnioPer' => $ficha->fchAnioPer,
				'fchFechaImpr' => $ficha->fchFechaImpr,
				'fchConc' => $ficha->fchConc,
				'fhcRef1' => $ficha->fhcRef1,
				'fchFechaVenc1' => $ficha->fchFechaVenc1,
				'fhcImp1' => $ficha->fhcImp1,
				'fchClaveProgAct' => $ficha->fchClaveProgAct,
				'diplomado' => $ficha->programa ? $ficha->programa->ecNombre : '',
			];
		})->prepend([
			'username', 'Clave Pago', 'Alumno', 'Periodo',
			'Año', 'Fecha Impr', 'Concepto', 'Referencia',
			'Vencimiento', 'Importe', 'ProgAct', 'Diplomado',
		]);
	}
}
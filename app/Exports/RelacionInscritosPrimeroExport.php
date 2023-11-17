<?php
namespace App\Exports;

use Illuminate\Support\Collection;

use App\Http\Models\Periodo;
use App\Http\Helpers\UltimaFechaPago;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class RelacionInscritosPrimeroExport implements FromCollection
{
	public $periodo;
	public $departamento;
	public $ubicacion;

	/**
	* @param App\Http\Models\Periodo
	*/
	public function __construct(Periodo $periodo) {
		$this->periodo = $periodo;
		$this->departamento = $this->periodo->departamento;
		$this->ubicacion = $this->departamento->ubicacion;
	}

	public function collection()
	{
		$inscritos = DB::select("call procInscritosPrimero(
			{$this->periodo->perNumero},
			{$this->periodo->perAnio},
			'{$this->ubicacion->ubiClave}',
			'{$this->departamento->depClave}'
		)");
		
		return collect($inscritos)->prepend([
			'Esc', 'Prog', 'Sem', 'Cve Pago', 
			'Nombre', 'Pago', 'Beca', 'Edo', 'Exani', 
			'Pago Insc.', 'Pagos hasta:', UltimaFechaPago::ultimoPago(),
		]);
	}
}
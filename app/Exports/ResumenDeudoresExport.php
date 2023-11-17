<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\User;
use App\Http\Models\Periodo;
use App\Http\Helpers\UltimaFechaPago;
use DB;

class ResumenDeudoresExport implements FromCollection
{

	public $periodo;
	public $departamento;
	public $ubicacion;
	public $user;

	/**
	* @param App\Models\User $user;
	* @param App\Http\Models\Periodo $periodo;
	*/
	public function __construct(User $user, Periodo $periodo)
	{
		$this->periodo = $periodo;
		$this->departamento = $this->periodo->departamento;
		$this->ubicacion = $this->departamento->ubicacion;
		$this->user = $user;
	}

	public function collection()
	{
		return collect(DB::select("call procResumenDeudasAlumno(
					{$this->periodo->perNumero}, 
					{$this->periodo->perAnio}, 
					'{$this->ubicacion->ubiClave}', 
					'{$this->departamento->depClave}', 
					{$this->user->id})"))->prepend([
						'Ubicacion',
						'Escuela',
						'Programa',
						'Sem',
						'Cve.Pago',
						'Nombre',
						'Edo',
						'Telefono',
						'Correo',
						'Plan pago',
						'Beca',
						'Porc.Beca',
						'Año Cuota',
						'Mensualidad',
						'Pronto Pago',
						'Prorrateo',
						'Inscripcion Ago.',
						'Septiembre',
						'Octubre',
						'Noviembre',
						'Diciembre',
						'Enero',
						'Inscripcion Ene.',
						'Febrero',
						'Marzo',
						'Abril',
						'Mayo',
						'Junio',
						'Julio',
						'Agosto',
						'Pagos hasta:',
						UltimaFechaPago::ultimoPago(),
					]);
	}
}
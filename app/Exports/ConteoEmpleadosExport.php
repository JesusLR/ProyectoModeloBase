<?php
namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Models\Empleado;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class ConteoEmpleadosExport implements FromCollection
{
	public $cantidades;
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->cantidades = $this->recolectar_datos();
	}

	public function recolectar_datos()
	{
		$docentes_mujeres = $this->empleados('docente', 'femenino');
		$docentes_hombres = $this->empleados('docente', 'masculino');
		$administrativos_hombres = $this->empleados('administrativo', 'masculino');
		$administrativos_mujeres = $this->empleados('administrativo', 'femenino');
		$total = $docentes_hombres + $docentes_mujeres + $administrativos_mujeres + $administrativos_hombres;

		return new Collection([
			['', 'Docentes', 'Administrativos', 'Total'],
			['Hombres', $docentes_hombres, $administrativos_hombres, $docentes_hombres + $administrativos_hombres],
			['Mujeres', $docentes_mujeres, $administrativos_mujeres, $docentes_mujeres + $administrativos_mujeres],
			['Total', $docentes_hombres + $docentes_mujeres, $administrativos_hombres + $administrativos_mujeres, $total],
		]);
	}

	public function collection()
	{
		return $this->cantidades;
	}

	public function empleados($tipo, $sexo)
	{
		$busqueda_periodo = $tipo == 'administrativo' ? 'horariosadmivos' : 'grupos.plan.programa';
		$perSexo = $sexo == 'femenino' ? 'F' : 'M';

		return Empleado::where('id', '>', 0)
		->whereHas($busqueda_periodo, function($query) use ($tipo) {
			$query->where('periodo_id', $this->request->periodo_id);
			if($tipo == 'docente' && $this->request->escuela_id)
				$query->where('escuela_id', $this->request->escuela_id);
		})
		->when($tipo == 'administrativo', function($query) {
			return $query->whereDoesntHave('grupos', function($query) {
				$query->where('periodo_id', $this->request->periodo_id);
			})->when($this->request->escuela_id, function($query) {
				return $query->where('escuela_id', $this->request->escuela_id);
			});
		})
		->whereHas('persona', function($query) use ($perSexo) {
			$query->where('perSexo', $perSexo);
		})->count();
	}
}
<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ConstanciaDocenteController extends Controller
{
	protected $empleados;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:r_plantilla_profesores']);
    }

    public function reporte()
    {
    	return view('reportes/constancia_docente.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	$departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);
    	$ubicacion = $departamento->ubicacion;
    	$this->empleados = new Collection;
    	Empleado::with(['persona', 'escolaridades.abreviatura'])
    	->where(static function($query) use ($request) {
    		if($request->empleado_id)
    			$query->where('id', $request->empleado_id);
    	})
    	->whereHas('grupos.plan.programa', static function($query) use ($request) {
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
    		if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
    	})
    	->activos()
    	->chunk(100, function($docentes) {
    		
    		if($docentes->isEmpty())
    			return false;

    		$docentes->each(function($docente) {
    			$info = self::info_empleado($docente);
    			$this->empleados->push($info);
    		});
    	});

    	if($this->empleados->isEmpty())
    		return self::alert_verificacion();

    	$this->empleados = $this->empleados->keyBy('empleado_id');

    	$materiasData = self::buscar_grupos($this->empleados, $request)->unique('unicidad')->groupBy('empleado_id');
    	$this->empleados = $this->empleados->map(static function($empleado, $id) use ($materiasData) {
    		$materias_docente = $materiasData->pull($id);
			$anio_inicio = $materias_docente->first()['anio_curso'];

			return $empleado->merge([
				'materias' => $materias_docente ?: false, 
				'anio_inicio' => $anio_inicio,
			]);
    	})->filter(static function($empleado) {
    		return $empleado['materias'];
    	});

    	$hoy = Carbon::now('America/Merida');
    	$nombreArchivo = 'pdf_constancia_docente';
    	return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
    		"datos" => $this->empleados->sortBy('nombreCompleto'),
    		"departamento" => $departamento,
    		"ubicacion" => $ubicacion,
    		"fecha" => Utils::fecha_string($hoy),
            "periodo_id" => $request->periodo_id ? true : false,
    		"nombreArchivo" => $nombreArchivo,
    	])->stream($nombreArchivo.'.pdf');
    }

    /**
    * Alert en caso de no encontrar registros, para prevención de errores.
    */
    private static function alert_verificacion()
    {
    	alert('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
    	return back()->withInput();
    }

    /**
	* @param App\Models\Empleado
    */
    private static function info_empleado($empleado)
    {
    	$persona = $empleado->persona;
    	$escolaridad = $empleado->escolaridades->where('escoUltimoGrado', 'S')->first();

    	return collect([
    		'empleado_id' => $empleado->id,
    		'nombreCompleto' => MetodosPersonas::nombreCompleto($persona),
    		'el_la' => $persona->esHombre() ? 'el' : 'la',
    		'interesadx' => $persona->esHombre() ? 'interesado' : 'interesada',
    		'profesionista' => $escolaridad ? $escolaridad->abreviatura->abtAbreviatura : 'Profesor',
    	]);
    }

    /**
	* @param Collection $empleados
	* @param Illuminate\Http\Request
    */
    private static function buscar_grupos($empleados, $request)
    {
    	$grupos = new Collection;
    	Grupo::with(['periodo.departamento:id,depClave', 'materia.plan.programa'])
    	->where(static function($query) use ($request) {
    		if($request->periodo_id && $request->tipo_reporte != 'PH') 
    			$query->where('periodo_id', $request->periodo_id);
    	})
    	->whereIn('empleado_id', $empleados->pluck('empleado_id'))
        ->whereNull('grupo_equivalente_id')
    	->latest()
    	->chunk(200, static function($registros) use ($grupos) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(static function($registro) use ($grupos) {
    			$info = self::info_materia_impartida($registro);
    			$grupos->push($info);
    		});
    	});

    	return $grupos->sortBy('orden');
    }
    

    /**
	* @param App\Models\Grupo
    */
    private static function info_materia_impartida($grupo)
    {
    	$materia = $grupo->materia;
    	$plan = $materia->plan;
    	$programa = $plan->programa;
    	$periodo = $grupo->periodo;

    	$nombre_materia = $materia->matNombreOficial;
    	if($grupo->optativa)
    		$nombre_materia .= " - {$grupo->optativa->optNombre}";

    	return collect([
    		'empleado_id' => $grupo->empleado_id,
    		'nombre_materia' => $nombre_materia,
    		'progClave' => $programa->progClave,
    		'periodo' => "{$periodo->perNumero}/{$periodo->perAnio}",
    		'anio_curso' => $periodo->perAnio,
    		'depClave' => $periodo->departamento->depClave,
    		'orden' => intval($periodo->perAnio) + intval($grupo->empleado_id),
    		'unicidad' => "{$grupo->empleado_id}-{$materia->id}-{$nombre_materia}-{$periodo->perNumero}-{$periodo->perAnio}",
    	]);
    }
}

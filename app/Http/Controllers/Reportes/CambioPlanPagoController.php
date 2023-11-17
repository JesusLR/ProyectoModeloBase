<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\clases\cgts\MetodosCgt;
use App\clases\personas\MetodosPersonas;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CambioPlanPagoController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	return view('reportes/cambio_plan_pago.create', [
    		'fechaActual' => Carbon::now('America/Merida'),
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request) {
    	
    	$cursos = self::buscarCursos($request);
    	if($cursos->isEmpty()) {
    		alert('Sin Coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}
    	$alumnos_plan_cambiado = self::filtrarAlumnosConCambio_curPlanPago($cursos)->keys();
    	$cursos_filtrados = $cursos->whereIn('alumno_id', $alumnos_plan_cambiado);
    	$datos = self::mapearInfoPorPrograma($cursos_filtrados);

    	if($datos->isEmpty()) {
    		alert('Sin resultados', 'No aparecieron cambios de planes dentro del criterio de búsqueda proporcionado.', 'success')->showConfirmButton();
    		return back()->withInput();
    	}

    	$periodo = $cursos->first()->periodo;
    	$fechaActual = Carbon::now('America/Merida');
    	$nombreArchivo = 'pdf_cambio_plan_pago';
    	return PDF::loadView("reportes/pdf.{$nombreArchivo}",[
	        "datos" => $datos,
	        "periodo" => $periodo,
	        "ubicacion" => $periodo->departamento->ubicacion,
	        "fechaActual" => $fechaActual->format('d/m/Y'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');
    } # imprimir.



    /**
    * @param Request
    */
    private static function buscarCursos($request): Collection
    {
    	return Curso::with(['cgt.plan', 'periodo', 'alumno.persona'])
    	->whereHas('periodo', static function($query) use ($request) {
    		$query->where('departamento_id', $request->departamento_id);
    		$query->where('perAnioPago', $request->perAnioPago);
    	})
    	->whereHas('cgt.plan.programa', static function($query) use ($request) {
    		if($request->programa_id) {
    			$query->where('programa_id', $request->programa_id);
    		}
    		if($request->escuela_id) {
    			$query->where('escuela_id', $request->escuela_id);
    		}
    	})->get();
    }


    /**
    * agrupa por alumnos, keyBy elimina items que tengan la misma clave,
    * entonces, si el número de items es mayor a 1, existen claves diferentes (curPlanPagos)
    *
    * @param Collection
    */
    private static function filtrarAlumnosConCambio_curPlanPago($cursos): Collection
    {
    	return $cursos->groupBy('alumno_id')->filter(static function($alumno_cursos) {
    		$cursos = $alumno_cursos->keyBy('curPlanPago');

    		return $cursos->count() > 1;
    	});
    }


    /**
   	* @param Collection
    */
    private static function mapearInfoPorPrograma($cursos): Collection
    {
    	return $cursos->groupBy('cgt.plan.programa_id')->map(static function($programa_cursos) {
    		$programa = $programa_cursos->first()->cgt->plan->programa;
    		return collect([
    			'programa_id' => $programa->id,
    			'progClave' => $programa->progClave,
    			'progNombre' => $programa->progNombre,
    			'alumnos' => self::mapearPorAlumno($programa_cursos),
    		]);
    	});
    }


    /**
    * @param Collection
    */
    private static function mapearPorAlumno($cursos): Collection
    {
    	return $cursos->groupBy('alumno_id')->map(static function($alumno_cursos) {
    		$alumno = $alumno_cursos->first()->alumno;

    		return collect([
    			'alumno_id' => $alumno->id,
    			'aluClave' => $alumno->aluClave,
    			'nombreCompleto' => MetodosPersonas::nombreCompleto($alumno->persona),
    			'cursos' => $alumno_cursos->sortByDesc('curFechaRegistro'),
    		]);
    	})->sortBy('nombreCompleto');
    }

}

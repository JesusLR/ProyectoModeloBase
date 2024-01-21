<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Grupo;
use App\Models\Inscrito;
use App\clases\personas\MetodosPersonas;
use App\clases\calificaciones\MetodosCalificaciones;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Luecano\NumeroALetras\NumeroALetras;

use App\Http\Helpers\Utils;

class ActaExamenOrdinarioController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$ubicaciones = Ubicacion::all();
    	return view('reportes/acta_examen_ordinario.create', compact('ubicaciones'));
    }//reporte.

    public function imprimir(Request $request) {


    	$inscritos = Inscrito::with(['grupo.materia.plan', 'curso.alumno.persona', 'calificacion'])
    	->whereHas('grupo.materia.plan', static function($query) use ($request) {

    		$query->where('programa_id', $request->programa_id)
                  ->where('periodo_id', $request->periodo_id);
    		if($request->plan_id) {
    			$query->where('plan_id', $request->plan_id);
    		}
    		if($request->matClave) {
    			$query->where('matClave', $request->matClave);
    		}
            if($request->empleado_id) {
                $query->where('empleado_id', $request->empleado_id);
            }
            if($request->gpoSemestre) {
                $query->where('gpoSemestre', $request->gpoSemestre);
            }
            if($request->gpoClave) {
                $query->where('gpoClave', $request->gpoClave);
            }
            if($request->inscritos_gpo) {
                $query->where('inscritos_gpo', $request->operadorInscritos, $request->inscritos_gpo);
            }

    	})
    	->get();

    	if($inscritos->isEmpty()) {
    		alert()->warning('Sin datos', 'No se encontraron registros con la información proporcionada.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$inscrito1 = $inscritos->first();
        $programa = $inscrito1->grupo->materia->plan->programa;
    	$periodo = $inscrito1->grupo->periodo;
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;

    	$datos = $inscritos->map(static function($inscrito, $key) use ($programa) {
            $alumno = $inscrito->curso->alumno;
    		$nombre = MetodosPersonas::nombreCompleto($alumno->persona, true);
            $grupo = $inscrito->grupo;
    		$empleado = $grupo->empleado;
            $materia = $grupo->materia;
            $optNombre = $grupo->optativa ? '- '.$grupo->optativa->optNombre : '';
            $formatter = new NumeroALetras();
    		$calificacion = MetodosCalificaciones::definirCalificacion($inscrito->calificacion, $materia, 'CF');
            $calificacion_letras = $calificacion === null ? '' : str_replace(" CON 00/100","",$formatter->toWords(intval($calificacion)));
    		if(in_array($calificacion, ['NPE', 'Npa'])) {
                $motivo_falta = MetodosCalificaciones::motivo_falta($inscrito->calificacion->motivofalta_id);
    			$calificacion_letras = $motivo_falta ? strtoupper($motivo_falta->mfDescripcion) : '';
    		}elseif ($calificacion == 'Apr') {
    			$calificacion_letras = 'APROBADO';
    		}elseif ($calificacion == 'No Apr') {
    			$calificacion_letras = 'NO APROBADO';
    		}elseif ($calificacion == 'vacio') {
    			$calificacion_letras = '';
    		}
    		return collect([
    			'grupo_id' => $grupo->id,
    			'progClave' => $programa->progClave,
    			'progNombre' => $programa->progNombre,
    			'planClave' => $grupo->plan->planClave,
    			'fechaExamen' => Utils::fecha_string($inscrito->grupo->gpoFechaExamenOrdinario, 'mesCorto'),
    			'matClave' => $materia->matClave,
    			'matNombre' => "{$materia->matNombreOficial} {$optNombre}",
    			'gpoSemestre' => $grupo->gpoSemestre,
    			'gpoClave' => $grupo->gpoClave,
    			'matricula' => $alumno->aluMatricula,
    			'nombre' => $nombre,
    			'calificacion' => $calificacion,
    			'calificacion_letras' => $calificacion_letras,
    			'empleado_id' => $empleado->id,
    			'empleado_nombre' => MetodosPersonas::nombreCompleto($empleado->persona, true),
    			'orden' => $grupo->gpoClave.'-'.$nombre
    		]);
    	})->sortBy('orden')->groupBy(['gpoSemestre', 'grupo_id'])->sortKeys();

    	$fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_acta_examen_ordinario.pdf";
        return PDF::loadView("reportes.pdf.pdf_acta_examen_ordinario", [
        "semestres" => $datos,
        'periodo' => $periodo,
        "departamento" => $departamento,
        "ubicacion" => $ubicacion,
        "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
        "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
        "fechaActual" => Utils::fecha_string($fechaActual, 'mesCorto'),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo);
    }//imprimir.

}//Controller class.

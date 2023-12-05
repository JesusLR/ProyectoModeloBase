<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\clases\personas\MetodosPersonas;
use App\clases\alumnos\MetodosAlumnos;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class RegularesCursoAnteriorController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
    	return view('reportes/regulares_curso_anterior.create', compact('ubicaciones'));
    }



    public function imprimir(Request $request) {

    	$cursos = Curso::with(['alumno.persona', 'cgt.plan.programa'])
    	->where('periodo_id', $request->periodo_id)
    	->whereIn('curEstado', ['R', 'A', 'C'])
    	->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
    		if($request->escuela_id) {
    			$query->where('escuela_id', $request->escuela_id);
    		}
    		if($request->programa_id) {
    			$query->where('programa_id', $request->programa_id);
    		}
    	})->get();

    	if($cursos->isEmpty()) {
    		alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
    		return back()->withInput();
    	}

    	$periodo = $cursos->first()->periodo;
    	$data = $cursos->map(static function($curso) {
    		$alumno = $curso->alumno;
    		$cgt = $curso->cgt;

    		return collect([
    			'alumno_id' => $alumno->id,
    			'aluClave' => $alumno->aluClave,
    			'nombreCompleto' => MetodosPersonas::nombreCompleto($alumno->persona),
    			'grado' => $cgt->cgtGradoSemestre,
    			'grupo' => $cgt->cgtGrupo,
    			'curTipoIngreso' => $curso->curTipoIngreso,
    			'curPorcentajeBeca' => $curso->curPorcentajeBeca,
    			'progClave' => $cgt->plan->programa->progClave,
    			'esDeudor' => MetodosAlumnos::esDeudor($alumno->aluClave),
    		]);
    	})->filter(static function($alumno, $key) {

    		return $alumno['esDeudor'];
    	})->sortBy('nombreCompleto');

    	if($data->isEmpty()) {
    		alert()->success('Sin coincidencias', 'No hay deudores dentro del filtro seleccionado.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$fechaActual = Carbon::now('America/Merida');
    	$nombreArchivo = 'pdf_regulares_curso_anterior';
    	return PDF::loadView("reportes/pdf.{$nombreArchivo}",[
	        "data" => $data,
	        "periodo" => $periodo,
	        "departamento" => $periodo->departamento,
	        "fechaActual" => $fechaActual->format('d/m/Y'),
	        "horaActual" => $fechaActual->format('H:i:s'),
	        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo.'.pdf');
    }
}

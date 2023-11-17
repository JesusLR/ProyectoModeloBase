<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\Http\Models\TutorAlumno;

use PDF;
use Carbon\Carbon;
use App\Http\Helpers\Utils;
use App\clases\cgts\MetodosCgt;
use Illuminate\Support\Collection;
use App\clases\personas\MetodosPersonas;
use RealRashid\SweetAlert\Facades\Alert;

class RelCorreosAlumnosPadresController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	return view('reportes/rel_correos_alumnos_padres.create', [
    		'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get(),
    	]);
    }

    public function imprimir(Request $request) {
    	
    	$cursos = $request->tipo_busqueda == 'A' ? 
    	self::filtrarCursosDeAlumno($request) : self::filtrarCursosGeneral($request);

    	if($cursos->isEmpty()) {
    		alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$tutores = TutorAlumno::with('tutor')
    	->whereIn('alumno_id', $cursos->pluck('alumno_id'))
    	->latest()->get()->unique('alumno_id');

    	$datos = $cursos->map(static function($curso, $key) use ($tutores) {
    		$alumno = $curso->alumno;
    		$cgt = $curso->cgt;
    		$programa = $cgt->plan->programa;
    		$tutoria = $tutores->firstWhere('alumno_id', $alumno->id);
    		$nombreCompleto = MetodosPersonas::nombreCompleto($alumno->persona, true);
    		$ordenCgt = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);

    		return collect([
    			'aluClave' => $alumno->aluClave,
    			'nombreCompleto' => $nombreCompleto,
    			'grado' => $cgt->cgtGradoSemestre,
    			'grupo' => $cgt->cgtGrupo,
    			'perCorreo1' => $alumno->persona->perCorreo1,
    			'tutCorreo' => $tutoria ? $tutoria->tutor->tutCorreo : 'No hay tutor registrado',
    			'progClave' => $programa->progClave,
    			'progNombre' => $programa->progNombre,
    			'ordenCgt' => $ordenCgt,
    			'orden' => $programa->progClave.$ordenCgt.$nombreCompleto,
    		]);
    	})->sortBy('orden')->groupBy(['progClave', 'ordenCgt']);

    	$periodo = $cursos->first()->periodo;
    	$fechaActual = Carbon::now('America/Merida');
    	$nombreArchivo = 'pdf_rel_correos_alumnos_padres';
	    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
	      "datos" => $datos,
	      "ubicacion" => $periodo->departamento->ubicacion,
	      "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
	      "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
	      "nombreArchivo" => $nombreArchivo,
	      "fechaActual" => $fechaActual->format('d/m/Y'),
	      "horaActual" => $fechaActual->format('H:i:s'),
	    ]);

	    return $pdf->stream($nombreArchivo . '.pdf');
    } // imprimir.



    /**
    * @param Illuminate\Http\Request
    */
    private static function filtrarCursosGeneral($request): Collection
    {
    	return Curso::with(['alumno.persona', 'cgt.plan.programa'])
    	->where('periodo_id', $request->periodo_id)
    	->whereHas('cgt.plan.programa', static function($query) use ($request) {
    		$query->where('escuela_id', $request->escuela_id);
    		if($request->programa_id) {
    			$query->where('programa_id', $request->programa_id);
    		}
    		if($request->plan_id) {
    			$query->where('plan_id', $request->plan_id);
    		}
    		if($request->cgtGradoSemestre) {
    			$query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
    		}
    	})->latest('curFechaRegistro')->get()->unique('alumno_id');
    }



    /**
    * @param Illuminate\Http\Request
    */
    private static function filtrarCursosDeAlumno($req): Collection
    {
    	if(!$req->aluClave && !$req->aluMatricula && !$req->perApellido1 && !$req->perApellido2){
    		return collect([]);
    	}
    	
    	return Curso::with(['alumno.persona', 'cgt.plan.programa'])
    	->whereHas('alumno.persona', static function($query) use ($req) {
    		if($req->aluClave) {
    			$query->where('aluClave', $req->aluClave);
    		}
    		if($req->aluMatricula) {
    			$query->where('aluMatricula', $req->aluMatricula);
    		}
    		if($req->perNombre) {
    			$query->where('perNombre', 'like', '%'.$req->perNombre.'%');
    		}
    		if($req->perApellido1) {
    			$query->where('perApellido1', $req->perApellido1);
    		}
    		if($req->perApellido2) {
    			$query->where('perApellido2', $req->perApellido2);
    		}
    	})->latest('curFechaRegistro')->get()->unique('alumno_id');
    }



}

<?php

namespace App\Http\Controllers\Idiomas;

use Illuminate\Http\Request;

use App\Http\Models\Idiomas\Idiomas_cursos;
use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Idiomas\Idiomas_resumen_calificacion;
use App\Http\Models\Idiomas\Idiomas_calificaciones_materia;
use App\Http\Models\Ubicacion;
use App\clases\cambiar_carrera\idiomas\Notificacion;
use App\Http\Controllers\Controller;

use DB;
use Exception;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CambiarCarreraController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth']);
    }

    public function vista(Idiomas_cursos $curso)
    {
		$cursos = Idiomas_cursos::select(
			'idiomas_cursos.id as curso_id',
			'periodos.id as periodo_id',
			'departamentos.id as departamento_id',
			'ubicacion.id as ubicacion_id',
			'escuelas.id as escuela_id',
			'programas.id as programa_id',
			'planes.id as plan_id',
			'idiomas_grupos.id as grupo_id'
		)
		->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
		->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
		->join('programas', 'planes.programa_id', '=', 'programas.id')
		->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
		->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
		->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
		->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
		->where('idiomas_cursos.id', $curso->id)
		->first();

    	return view('idiomas.cambiar_carrera.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'curso' => $cursos,
    	]);
    }

    public function cambiar(Request $request, Idiomas_cursos $curso)
    {
    	$cursos = Idiomas_cursos::select(
			'idiomas_cursos.id as curso_id',
			'idiomas_cursos.alumno_id',
			'idiomas_cursos.curEstado',
			'idiomas_cursos.curImporteInscripcion',
			'idiomas_cursos.curImporteMensualidad',
			'idiomas_cursos.cuota_user_id',
			'idiomas_cursos.curFechaCuota',
			'periodos.id as periodo_id',
			'departamentos.id as departamento_id',
			'departamentos.perActual as perActual',
			'departamentos.perSig as perSig',
			'ubicacion.id as ubicacion_id',
			'escuelas.id as escuela_id',
			'programas.id as programa_id',
			'planes.id as plan_id',
			'idiomas_grupos.id as grupo_id',
			'idiomas_grupos.gpoGrado'
		)
		->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
		->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
		->join('programas', 'planes.programa_id', '=', 'programas.id')
		->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
		->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
		->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
		->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
		->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
		->where('idiomas_cursos.id', $curso->id)
		->first();
		$esActual = $cursos->periodo_id == $cursos->perActual;
		$esSiguiente = $cursos->periodo_id == $cursos->perSig;

    	if(!$esActual && !$esSiguiente) {
    		return self::alert_periodo_no_permitido();
    	}

		$grupo = Idiomas_grupos::select(
			'idiomas_grupos.*'
		)
		->join('idiomas_cursos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
		->where('idiomas_cursos.id', $curso->id)
		->first();

    	$nuevo_grupo = Idiomas_grupos::findOrFail($request->cgt_id);

    	if($grupo == $nuevo_grupo) {
    		return redirect('idiomas_curso');
    	}

    	$nuevo_curso = self::clonarData($cursos);
    	$nuevo_curso['grupo_id'] = $nuevo_grupo->id;
    	if($nuevo_grupo->plan_id != $cursos->plan_id) {
    		$nuevo_curso['curAnioCuotas'] = null;
    	}

    	DB::beginTransaction();
    	try {
    		$nuevo_curso_idiomas = Idiomas_cursos::create($nuevo_curso);
    		$notificacion = new Notificacion($nuevo_curso['curso_id']);
    		$notificacion->cambioRealizado($curso);
			// hay que eliminar si lo tiene idiomas_resumen_calificaciones e idiomas_calificaciones_materia
			$rc = Idiomas_resumen_calificacion::where('idiomas_curso_id', $curso->id)->first();
			if ($rc) {
				$nuevo_rc = Idiomas_resumen_calificacion::create([
					'idiomas_curso_id' => $nuevo_curso_idiomas->id
				]);
				$cm = Idiomas_calificaciones_materia::where('idiomas_resumen_calificaciones_id', $rc->id)->get();
				if ($cm) {
					foreach ($cm as $calificaciones) {
						Idiomas_calificaciones_materia::create([
							'idiomas_resumen_calificaciones_id' => $nuevo_rc->id,
							'idiomas_materia_id' => $calificaciones->idiomas_materia_id
						]);
						$calificaciones->delete();
					}
				}
				$rc->delete();
			}

			$curso->delete();
    	} catch (Exception $e) {
    		DB::rollBack();
    		return back()->withInput()->withErrors([$e->getMessage()]);
    	}
    	DB::commit();

    	alert('Realizado', 'Se ha realizado el cambio de carrera exitosamente.', 'success')->showConfirmButton();
    	return redirect('idiomas_curso');
    }

    public static function alert_periodo_no_permitido()
    {
    	alert('Acción no permitida', 'Solo se permite cambio de carrera entre cursos del periodo actual o de periodo siguiente.', 'warning')
    	->showConfirmButton();
    	return back()->withInput();
    }

    private static function clonarData(Idiomas_cursos $curso): array 
    {
    	$nuevo_grado = $curso->gpoGrado;
    	$nuevo_curso = $curso->toArray();
    	unset(
    		$nuevo_curso['id'],
    		$nuevo_curso['created_at'],
    		$nuevo_curso['updated_at'],
    		$nuevo_curso['deleted_at'],
    		$nuevo_curso['periodo'],
    		$nuevo_curso['cgt'],
    		$nuevo_curso['usuario_at']
    	);

    	if($curso->curTipoIngreso == 'RI' && $nuevo_grado == 1) {
    		$nuevo_curso['curTipoIngreso'] = 'PI';
    	}

    	if($curso->curTipoIngreso == 'PI' && $nuevo_grado != 1) {
    		$nuevo_curso['curTipoIngreso'] = 'RI';
    	}

    	$nuevo_curso['curFechaRegistro'] = Carbon::now('America/Merida')->format('Y-m-d');

    	return $nuevo_curso; 
    }
}

<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;

use App\Http\Models\Curso;
use App\Http\Models\Cgt;
use App\Http\Models\Ubicacion;
use App\clases\cambiar_carrera\Notificacion;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_cch_inscritos;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use DB;
use Exception;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerCambiarCarreraController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
	}

	public function vista(Curso $curso)
	{
		
		$curso->load(['cgt.plan.programa.escuela', 'periodo.departamento.ubicacion']);
		$periodo_actual = $curso->periodo->id;
		$plan_actual = $curso->cgt->plan->id;
		$ubicacion_actual = $curso->periodo->departamento->ubicacion->id;
		$curso_id = $curso->id;
		$departamento_actual = $curso->periodo->departamento->id;
		$escuela_actual = $curso->cgt->plan->programa->escuela->id;
		$programa_actual = $curso->cgt->plan->programa->id;
		$cgt_actual = $curso->cgt->id;

		$ubicacion = Ubicacion::find($ubicacion_actual);
		$departamento = Departamento::find($departamento_actual);
		$periodo = Periodo::find($periodo_actual);
		$escuela = Escuela::find($escuela_actual);
		$programa = Programa::find($programa_actual);
		$plan = Plan::find($plan_actual);

		$aluClave = $curso->alumno->aluClave;
		$persona = $curso->alumno->persona;

		$alumno_curso = $aluClave.'-'.$persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;

		return view('bachiller.cambiar_carrera.create', [
			'ubicaciones' => Ubicacion::whereIn('id', [1, 2, 3])->get(),
			'periodo' => $periodo,
			'plan_actual' => $plan_actual,
			'curso_id' => $curso_id,
			'ubicacion' => $ubicacion,
			'departamento' => $departamento,
			'escuela' => $escuela,
			'programa' => $programa,
			'cgt_actual' => $cgt_actual,
			'plan' => $plan,
			'alumno_curso' => $alumno_curso
		]);
	}

	public function cambiar(Request $request, Curso $curso)
	{
		if(auth()->user()->campus_cme == 1 || auth()->user()->campus_cva == 1){
			$bachiller_inscritos = Bachiller_inscritos::where('curso_id', $curso->id)->get();
		}else{
			if(auth()->user()->campus_cch == 1){
				$bachiller_inscritos = Bachiller_cch_inscritos::where('curso_id', $curso->id)->get();
			}
		}
		

		if (count($bachiller_inscritos) > 0) {
			alert('Upss...', 'No se puede realizar el cambio de cgt debido que el alumno ya se encuentra registrados en grupos materias', 'warning')->showConfirmButton();

			return back();
		}

		$periodo = $curso->periodo;
		// if (!$periodo->esActual() && !$periodo->esSiguiente()) {
		// 	return self::alert_periodo_no_permitido();
		// }

		$nuevo_cgt = Cgt::findOrFail($request->cgt_id);
		if ($curso->cgt === $nuevo_cgt) {
			return redirect('bachiller_curso');
		}

		$curso_id = $curso->id;

		// $nuevo_curso = self::clonarData($curso);
		// $nuevo_curso['cgt_id'] = $nuevo_cgt->id;
		// if ($nuevo_cgt->plan_id != $curso->cgt->plan_id) {
		// 	$nuevo_curso['curAnioCuotas'] = null;
		// }

		DB::beginTransaction();
		try {
			// $nuevo_curso = Curso::create($nuevo_curso);
			// $curso->delete();

			// $notificacion = new Notificacion($nuevo_curso);
			// $notificacion->cambioRealizado($curso);

			$curso_actualizar = Curso::find($curso_id);

			$curso_actualizar->update([
				'cgt_id' => $nuevo_cgt->id
			]);

		} catch (Exception $e) {
			DB::rollBack();
			return back()->withInput()->withErrors([$e->getMessage()]);
		}
		DB::commit();

		alert('Realizado', 'Se ha realizado el cambio de CGT exitosamente.', 'success')->showConfirmButton();
		return redirect('bachiller_curso');
	}

	// public static function alert_periodo_no_permitido()
	// {
	// 	alert('Acción no permitida', 'Solo se permite cambio de carrera entre cursos del periodo actual o de periodo siguiente.', 'warning')
	// 		->showConfirmButton();
	// 	return back()->withInput();
	// }

	// private static function clonarData(Curso $curso): array
	// {
	// 	$nuevo_grado = $curso->cgt->cgtGradoSemestre;
	// 	$nuevo_curso = $curso->toArray();
	// 	unset(
	// 		$nuevo_curso['id'],
	// 		$nuevo_curso['created_at'],
	// 		$nuevo_curso['updated_at'],
	// 		$nuevo_curso['deleted_at'],
	// 		$nuevo_curso['periodo'],
	// 		$nuevo_curso['cgt'],
	// 		$nuevo_curso['usuario_at']
	// 	);

	// 	if ($curso->curTipoIngreso == 'RI' && $nuevo_grado == 1) {
	// 		$nuevo_curso['curTipoIngreso'] = 'PI';
	// 	}

	// 	if ($curso->curTipoIngreso == 'PI' && $nuevo_grado != 1) {
	// 		$nuevo_curso['curTipoIngreso'] = 'RI';
	// 	}

	// 	$nuevo_curso['curFechaRegistro'] = Carbon::now('America/Merida')->format('Y-m-d');

	// 	return $nuevo_curso;
	// }
}

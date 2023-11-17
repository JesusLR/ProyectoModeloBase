<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Curso;
use App\Http\Models\Cgt;
use App\Http\Models\Ubicacion;
use App\clases\cambiar_carrera\Notificacion;

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

    public function vista(Curso $curso)
    {
    	return view('cambiar_carrera.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'curso' => $curso->load(['cgt.plan.programa.escuela', 'periodo.departamento.ubicacion']),
    	]);
    }

    public function cambiar(Request $request, Curso $curso)
    {
    	$periodo = $curso->periodo;
    	if(!$periodo->esActual() && !$periodo->esSiguiente()) {
    		return self::alert_periodo_no_permitido();
    	}

    	$nuevo_cgt = Cgt::findOrFail($request->cgt_id);
    	if($curso->cgt === $nuevo_cgt) {
    		return redirect('curso');
    	}

    	$nuevo_curso = self::clonarData($curso);
    	$nuevo_curso['cgt_id'] = $nuevo_cgt->id;
    	if($nuevo_cgt->plan_id != $curso->cgt->plan_id) {
    		$nuevo_curso['curAnioCuotas'] = null;
    	}

    	DB::beginTransaction();
    	try {
    		$nuevo_curso = Curso::create($nuevo_curso);
    		$curso->delete();

    		$notificacion = new Notificacion($nuevo_curso);
    		$notificacion->cambioRealizado($curso);
    	} catch (Exception $e) {
    		DB::rollBack();
    		return back()->withInput()->withErrors([$e->getMessage()]);
    	}
    	DB::commit();

    	alert('Realizado', 'Se ha realizado el cambio de carrera exitosamente.', 'success')->showConfirmButton();
    	return redirect('curso');
    }

    public static function alert_periodo_no_permitido()
    {
    	alert('Acción no permitida', 'Solo se permite cambio de carrera entre cursos del periodo actual o de periodo siguiente.', 'warning')
    	->showConfirmButton();
    	return back()->withInput();
    }

    private static function clonarData(Curso $curso): array 
    {
    	$nuevo_grado = $curso->cgt->cgtGradoSemestre;
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

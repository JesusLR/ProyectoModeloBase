<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;

use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\MatriculaAnterior;
use App\clases\personas\MetodosPersonas;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class PrimariaCambiarMatriculasController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    	// $this->middleware(['auth', 'permisos:cgt', 'permisos:alumno']);
    }

    /**
    * Esta función es para cambiar la matrícula de un solo alumno.
    *
    * @param Illuminate\Http\Request $request
    * @param int $cgt_id
    * @param int $alumno_id
    */
    public function cambiarMatricula(Request $request, $cgt_id, $alumno_id) {
    	$alumno = Alumno::findOrFail($alumno_id);
    	$programa = Cgt::with('plan.programa')->findOrFail($cgt_id)->plan->programa;

    	if($alumno->aluMatricula == $request->aluMatricula)
    	{
    		return response()->json([
    			'status' => 'warning',
    			'title' => 'No hay cambios', 
    			'msg' => 'La matricula proporcionada es la misma que ya posee el alumno.',
    		]);
    	}

    	DB::beginTransaction();
		try {
			$matricula = self::registrarCambio($programa, $alumno, $request->aluMatricula);
			$alumno->update(['aluMatricula' => $matricula->matricNueva]);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => 'error',
				'title' => 'Ha ocurrido un error', 
				'msg' => $e->getMessage
			]);
		}
		DB::commit();

		return response()->json([
			'status' => 'success', 
			'title' => 'Actualización exitosa',
			'msg' => "Se realizó el cambio de matrícula del alumno con clave: {$alumno->aluClave}",
            'alumno' => $alumno,
		]);
    }# cambiarMatricula


    /**
    * Esta función recibe el cgt_id y un arreglo con múltiples alumnos [alumno_id => nueva_matricula]
    * por cada alumno, revisa si la matrícula fue cambiada, entonces registra el cambio.
    *
    * @param Illuminate\Http\Request $request
    * @param int $cgt_id
    */
    public function cambiarMultiplesMatriculas(Request $request, $cgt_id) {
        $programa = Cgt::with('plan.programa')->findOrFail($cgt_id)->plan->programa;
        $listado = collect([$request->listado])->collapse()->keyBy('alumno_id');
        if($listado->isEmpty()) {
            return  response()->json([
                'status' => 'warning',
                'title' => 'Sin alumnos.',
                'msg' => 'No se encontraron alumnos en la lista.',
            ]);
        }

        $alumnos = Alumno::whereIn('id', $listado->keys())->get()->keyBy('id');
        DB::beginTransaction();
        try {
            $listado->each(static function($info, $alumno_id) use ($programa, $alumnos) {
                $alumno = $alumnos->get($alumno_id);
                if($alumno->aluMatricula != $info['nueva_matricula']) {
                    $matricula = self::registrarCambio($programa, $alumno, $info['nueva_matricula']);
                    $alumno->update(['aluMatricula' => $matricula->matricNueva]);
                }
            });
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'title' => 'Ha ocurrido un error',
                'msg' => $e->getMessage(),
            ]);
        }
        DB::commit();

        return response()->json([
            'status' => 'success',
            'title' => 'Actualización exitosa',
            'msg' => 'Se han actualizado las matrículas de los alumnos de este Cgt.',
        ]);
    }

    /**
    * @param int 
    */
    public function lista_alumnos($cgt_id) {

        $cgt = Cgt::with('periodo')->findOrFail($cgt_id);
        $cursos = Curso::with('alumno.persona')
        ->where([['cgt_id', $cgt->id], ['curEstado', '<>', 'B']])
        ->get()->each(static function($curso) {
            $curso->alumno->persona->nombreCompleto = MetodosPersonas::nombreCompleto($curso->alumno->persona, true);
        });
        $cgt->cursosRegulares = $cursos->sortBy('alumno.persona.nombreCompleto');

    	return view('primaria.cambiar_matriculas_cgt.lista_alumnos', [
    		'cgt' => $cgt,
    	]);
    }

    /**
    * @param App\Models\Programa $programa
    * @param App\Models\Alumno $alumno
    * @param string $nueva_matricula
    */
    public static function registrarCambio($programa, $alumno, $nueva_matricula) {

    	return MatriculaAnterior::create([
    		'alumno_id' => $alumno->id,
    		'matricNueva' => $nueva_matricula,
    		'matricAnterior' => $alumno->aluMatricula,
    		'programa_id' => $programa->id,
    	]);
    }

    /**
    * @param int $cgt_id
    * @param int $alumno_id
    */
    public function buscarAlumnoEnCgt($cgt_id, $alumno_id) {
    	return Curso::with('alumno.persona')
    	->where('cgt_id', $cgt_id)
    	->where('alumno_id', $alumno_id)->first();
    }

}

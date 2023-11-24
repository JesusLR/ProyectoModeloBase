<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Revalidaciones\RevalidarRequest;
use App\Models\Ubicacion;
use App\Models\ResumenAcademico;
use App\Models\Materia;
use App\Models\Periodo;
use App\Models\Historico;
use App\clases\alumnos\MetodosAlumnos;

use Exception;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class RevalidacionesController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {

        return view('revalidaciones.show-list');
    }

    public function edit($id) {
        $resumen = ResumenAcademico::with(['alumno.persona', 'plan.programa.escuela.departamento.ubicacion'])->findOrFail($id);
        $alumno = $resumen->alumno;
        $plan = $resumen->plan;

        return view('revalidaciones.edit', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'resumen' => $resumen,
            'alumno' => $alumno,
            'plan' => $plan,
        ]);
    }

    public function agregar($resumen_id, $materia_id) {
        $resumen = ResumenAcademico::findOrFail($resumen_id);
        $materia = Materia::findOrFail($materia_id);

        return view('revalidaciones.agregar', [
            'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
            'resumen' => $resumen,
            'materia' => $materia,
        ]);
    }

    public function revalidar(RevalidarRequest $request, $resumen_id, $materia_id) {
        $resumen = ResumenAcademico::findOrFail($resumen_id);
        $materia = Materia::findOrFail($materia_id);
        $periodo = Periodo::findOrFail($request->periodo_id);
        $alumno = $resumen->alumno;
        $optativa = $materia->matClasificacion == 'O' ? $materia->optativas()->where('id', $request->optativa_id)->first() : null;

        try {
            Historico::create([
                'alumno_id'               => $alumno->id,
                'plan_id'                 => $materia->plan_id,
                'materia_id'              => $materia->id,
                'periodo_id'              => $periodo->id,
                'histComplementoNombre'   => $optativa ? $optativa->optNombre : null,
                'histPeriodoAcreditacion' => 'RV',
                'histTipoAcreditacion'    => 'RV',
                'histFechaExamen'         => $request->histFechaExamen,
                'histCalificacion'        => $materia->esAlfabetica() ? 0 : $request->histCalificacion,
                'histNombreOficial'       => $materia->matNombreOficial,
            ]);
        } catch (Exception $e) {
            alert('Ha ocurrido un error.', $e->getMessage(), 'success')->showConfirmButton();
            return back()->withInput();
        }
        alert('Realizado', 'Se ha realizado la validación exitosamente.')->showConfirmButton();
        return redirect("revalidaciones/{$resumen->id}/edit");
    }

    public function list() {

        $resumenes = ResumenAcademico::with(['alumno.persona', 'plan.programa.escuela.departamento.ubicacion'])->select('resumenacademico.*');

        return Datatables::of($resumenes)
        ->addColumn('action', static function($resumen) {

            $btn_revalidar = '<a href="revalidaciones/' . $resumen->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Agregar revalidación">
                    <i class="material-icons">edit</i>
                </a>';

            return '<div class="row">'
                    . $btn_revalidar .
                '</div>';
        })->make(true);
    }

    public function materias_faltantes($resumen_id) {
        $resumen = ResumenAcademico::findOrFail($resumen_id);
        $alumno = $resumen->alumno;
        $plan = $resumen->plan;
        $reprobadas = MetodosAlumnos::materiasReprobadasEloquent($alumno, $plan);
        $faltantes = MetodosAlumnos::materiasFaltantes($alumno, $plan);
        $materias_adeudadas = $reprobadas->merge($faltantes)->load('plan');

        return DataTables::of($materias_adeudadas)
        ->addColumn('action', static function($materia) use ($resumen) {

            $btn_revalidar = '<a href="'. route('revalidaciones.agregar', ['resumen_id' => $resumen->id, 'materia_id' => $materia->id]) .'" class="button button--icon js-button js-ripple-effect" title="Agregar revalidación">
                    <i class="material-icons">edit</i>
                </a>';

            return '<div class="row">'
                    . $btn_revalidar .
                '</div>';
        })->make(true);
    }
}

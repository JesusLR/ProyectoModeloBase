<?php

namespace App\Http\Controllers\Bachiller;

use App\clases\alumnos\MetodosAlumnos;
use Illuminate\Http\Request;

use App\Http\Requests\Revalidaciones\RevalidarRequest;
use App\Http\Models\Ubicacion;
use App\Http\Models\Materia;
use App\Http\Models\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Bachiller\Bachiller_resumenacademico;
use Exception;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BachillerCertificadosParcialesController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {

        return view('bachiller.certificados_parciales.show-list');
    }

    public function edit($id) {
        $resumen = Bachiller_resumenacademico::with(['alumno.persona', 'plan.programa.escuela.departamento.ubicacion'])->findOrFail($id);
        $alumno = $resumen->alumno;
        $plan = $resumen->plan;

        return view('bachiller.certificados_parciales.edit', [
            'ubicaciones' => Ubicacion::whereIn('id', [1, 2])->get(),
            'resumen' => $resumen,
            'alumno' => $alumno,
            'plan' => $plan,
        ]);
    }

    public function agregar($resumen_id, $materia_id) {
        $resumen = Bachiller_resumenacademico::findOrFail($resumen_id);
        $materia = Materia::findOrFail($materia_id);

        return view('bachiller.certificados_parciales.agregar', [
            'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
            'resumen' => $resumen,
            'materia' => $materia,
        ]);
    }

    public function revalidar(RevalidarRequest $request, $resumen_id, $materia_id) {
        $resumen = Bachiller_resumenacademico::findOrFail($resumen_id);
        $materia = Materia::findOrFail($materia_id);
        $periodo = Periodo::findOrFail($request->periodo_id);
        $alumno = $resumen->alumno;
        $optativa = $materia->matClasificacion == 'O' ? $materia->optativas()->where('id', $request->optativa_id)->first() : null;

        try {
            Bachiller_historico::create([
                'alumno_id'               => $alumno->id,
                'plan_id'                 => $materia->plan_id,
                'materia_id'              => $materia->id,
                'periodo_id'              => $periodo->id,
                'histComplementoNombre'   => $optativa ? $optativa->optNombre : null,
                'histPeriodoAcreditacion' => 'CP',
                'histTipoAcreditacion'    => 'CP',
                'histFechaExamen'         => $request->histFechaExamen,
                'histCalificacion'        => $materia->esAlfabetica() ? 0 : $request->histCalificacion,
                'histNombreOficial'       => $materia->matNombreOficial,
            ]);
        } catch (Exception $e) {
            alert('Ha ocurrido un error.', $e->getMessage(), 'success')->showConfirmButton();
            return back()->withInput();
        }
        alert('Realizado', 'Se ha realizado la validación exitosamente.')->showConfirmButton();
        return redirect("bachiller_certificados_parciales/{$resumen->id}/edit");
    }

    public function list() {

        $resumenes = Bachiller_resumenacademico::with(['alumno.persona', 'plan.programa.escuela.departamento.ubicacion'])->select('bachiller_resumenacademico.*');

        return Datatables::of($resumenes)
        ->addColumn('action', static function($resumen) {

            $btn_revalidar = '<a href="bachiller_certificados_parciales/' . $resumen->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Agregar revalidación">
                    <i class="material-icons">edit</i>
                </a>';

            return '<div class="row">'
                    . $btn_revalidar .
                '</div>';
        })->make(true);
    }

    public function materias_faltantes($resumen_id) {
        $resumen = Bachiller_resumenacademico::findOrFail($resumen_id);
        $alumno = $resumen->alumno;
        $plan = $resumen->plan;
        $reprobadas = MetodosAlumnos::BachillerMateriasReprobadasEloquent($alumno, $plan);
        $faltantes = MetodosAlumnos::BachillerMateriasFaltantes($alumno, $plan);
        $materias_adeudadas = $reprobadas->merge($faltantes)->load('plan');

        return DataTables::of($materias_adeudadas)
        ->addColumn('action', static function($materia) use ($resumen) {

            $btn_revalidar = '<a href="'. route('bachiller_certificados_parciales.agregar', ['resumen_id' => $resumen->id, 'materia_id' => $materia->id]) .'" class="button button--icon js-button js-ripple-effect" title="Agregar revalidación">
                    <i class="material-icons">edit</i>
                </a>';

            return '<div class="row">'
                    . $btn_revalidar .
                '</div>';
        })->make(true);
    }
}

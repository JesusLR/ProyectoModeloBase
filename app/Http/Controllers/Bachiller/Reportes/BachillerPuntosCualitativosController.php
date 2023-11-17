<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class BachillerPuntosCualitativosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.puntos_cualitativos.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::select(
            'bachiller_inscritos_evidencias.id',
            'bachiller_inscritos_evidencias.evidencia_id',
            'bachiller_inscritos_evidencias.ievClaveCualitativa1',
            'bachiller_inscritos_evidencias.ievClaveCualitativa2',
            'bachiller_inscritos_evidencias.ievClaveCualitativa3',
            'bachiller_inscritos_evidencias.ievFechaCaptura',
            'bachiller_inscritos_evidencias.ievHoraCaptura',
            'bachiller_inscritos.id as bachiller_inscrito_id',
            'bachiller_inscritos.curso_id',
            'bachiller_inscritos.bachiller_grupo_id',
            'bachiller_inscritos.insCalificacionParcial1',
            'bachiller_inscritos.insFaltasParcial1',
            'bachiller_inscritos.insCalificacionParcial2',
            'bachiller_inscritos.insFaltasParcial2',
            'bachiller_inscritos.insCalificacionParcial3',
            'bachiller_inscritos.insFaltasParcial3',
            'bachiller_inscritos.insCalificacionFinal',
            'bachiller_inscritos.insPromedioParcial',
            'bachiller_inscritos.insPuntosObtenidosCorte1',
            'bachiller_inscritos.insPuntosObtenidosCorte2',
            'bachiller_inscritos.insPuntosObtenidosCorte3',
            'bachiller_inscritos.insPuntosMaximosCorte1',
            'bachiller_inscritos.insPuntosMaximosCorte2',
            'bachiller_inscritos.insPuntosMaximosCorte3',
            'bachiller_inscritos.insPuntosObtenidosAcumulados',
            'bachiller_inscritos.insPuntosMaximosAcumulados',
            'alumnos.id AS alumno_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'bachiller_grupos.gpoClave',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoMatComplementaria',
            'bachiller_grupos.bachiller_materia_acd_id',
            'bachiller_grupos.bachiller_materia_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matNombreCorto',
            'periodos.id as periodo_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre',
            'planes.planClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'cgt.cgtGradoSemestre as semestre',
            'cgt.cgtGrupo as grupo',
            'cursos.curEstado',
            'departamentos.depClave',
            'programas.progClave',
            'programas.progNombre',
            'bachiller_evidencias.eviNumero',
            'concepto1.cuaDescripcion as cuaDescripcion1',
            'concepto2.cuaDescripcion as cuaDescripcion2',
            'concepto3.cuaDescripcion as cuaDescripcion3',
            'concepto1.cuaCategoria as cuaCategoria1',
            'concepto2.cuaCategoria as cuaCategoria2',
            'concepto3.cuaCategoria as cuaCategoria3'

        )
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('bachiller_conceptos_cualitativos as concepto1', 'bachiller_inscritos_evidencias.ievClaveCualitativa1', '=', 'concepto1.id')
            ->leftJoin('bachiller_conceptos_cualitativos as concepto2', 'bachiller_inscritos_evidencias.ievClaveCualitativa2', '=', 'concepto2.id')
            ->leftJoin('bachiller_conceptos_cualitativos as concepto3', 'bachiller_inscritos_evidencias.ievClaveCualitativa3', '=', 'concepto3.id')
            ->where('periodos.id', $request->periodo_id)
            ->where(static function ($query) use ($request) {

                if ($request->cgtGradoSemestre) {
                    $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                }

                if ($request->cgtGrupo) {
                    $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                }

                if ($request->aluClave) {
                    $query->where('alumnos.aluClave', $request->aluClave);
                }

                if ($request->perApellido1) {
                    $query->where('personas.perApellido1', $request->perApellido1);
                }
                if ($request->perApellido2) {
                    $query->where('personas.perApellido2', $request->perApellido2);
                }
                if ($request->perNombre) {
                    $query->where('personas.perNombre', $request->perNombre);
                }

            })
            ->whereNull('bachiller_inscritos.deleted_at')
            ->whereNull('cursos.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_materias.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('bachiller_empleados.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('cgt.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->whereNotNull('bachiller_inscritos_evidencias.ievClaveCualitativa1')
            ->orderBy('personas.perApellido1')
            ->orderBy('personas.perApellido2')
            ->orderBy('personas.perNombre')
            ->orderBy('bachiller_materias.matClave', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC')
            ->get();

        if ($request->cgtGrupo) {
            if (count($bachiller_inscritos_evidencias) < 1) {
                alert()->warning('Sin coincidencias', 'No hay puntos cualitativos capturados para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
        }

        if ($request->aluClave != "" || $request->perApellido1 != "" || $request->perApellido2 != "" || $request->perNombre != "") {
            if (count($bachiller_inscritos_evidencias) < 1) {
                alert()->warning('Sin coincidencias', 'No hay puntos cualitativos capturados para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
        }

        

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $alumno = $bachiller_inscritos_evidencias->groupBy('aluClave');
        $bachiller_materias = $bachiller_inscritos_evidencias->groupBy('bachiller_materia_id');

        $parametro_NombreArchivo = "pdf_puntos_cualitativos";
        // view('reportes.pdf.bachiller.puntos_cualitativos.pdf_puntos_cualitativos')
        $pdf = PDF::loadView('reportes.pdf.bachiller.puntos_cualitativos.' . $parametro_NombreArchivo, [
            "cicloEscolar" => Utils::fecha_string($bachiller_inscritos_evidencias[0]->perFechaInicial, 'mesCorto') . ' al ' . Utils::fecha_string($bachiller_inscritos_evidencias[0]->perFechaFinal, 'mesCorto'),
            "alumno" => $alumno,
            "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
            "hora" => $fechaActual->format('H:i:s'),
            "bachiller_materias" => $bachiller_materias,
            "bachiller_inscritos_evidencias" => $bachiller_inscritos_evidencias
        ]);

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}

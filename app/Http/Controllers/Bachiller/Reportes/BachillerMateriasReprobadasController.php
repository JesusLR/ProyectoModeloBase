<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class BachillerMateriasReprobadasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.materias_aprobadas.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imprimir(Request $request)
    {
        $departamento = Departamento::findOrFail($request->departamento_id);
        $califMinAprobatoria = $departamento->depCalMinAprob;

        // Si las materias son probadas Query 
        if($request->tipoReporte == 1){

            $titulo = "MATERIAS APROBADAS POR ALUMNO (PRE-CERTIFICADO)";

            $bachiller_historico_aprobados = Bachiller_historico::select(
                'bachiller_historico.alumno_id',
                'bachiller_historico.plan_id',
                'bachiller_historico.bachiller_materia_id',
                'bachiller_historico.periodo_id',
                'bachiller_historico.histPeriodoAcreditacion',
                'bachiller_historico.histTipoAcreditacion',
                'bachiller_historico.histFechaExamen',
                'bachiller_historico.histCalificacion',
                'bachiller_historico.histFolio',
                'bachiller_historico.hisActa',
                'bachiller_historico.histLibro',
                'alumnos.aluClave',
                'alumnos.aluMatricula',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.escClave',
                'escuelas.escNombre',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial as fecha_inicio',
                'periodos.perFechaFinal as fecha_fin',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_materias.matSemestre',
                'bachiller_materias.matCreditos'
            )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('departamentos.id', '=', $request->departamento_id)
            ->where('programas.id', '=', $request->programa_id)
            ->where('planes.id', '=', $request->plan_id)
            ->where('alumnos.aluClave', '=', $request->aluClave)
            ->where('bachiller_historico.histCalificacion', '>=', $califMinAprobatoria)
            ->orderBy('periodos.perNumero', 'DESC')
            ->orderBy('periodos.perAnio', 'ASC')        
            ->get();
    
            $resultado_collection = collect($bachiller_historico_aprobados);
        }

        // Si las materias son reprobadas Query 
        if($request->tipoReporte == 2){

            $titulo = "MATERIAS REPROBADAS POR ALUMNO (PRE-CERTIFICADO)";

            $bachiller_historico_reprobadas = Bachiller_historico::select(
                'bachiller_historico.alumno_id',
                'bachiller_historico.plan_id',
                'bachiller_historico.bachiller_materia_id',
                'bachiller_historico.periodo_id',
                'bachiller_historico.histPeriodoAcreditacion',
                'bachiller_historico.histTipoAcreditacion',
                'bachiller_historico.histFechaExamen',
                'bachiller_historico.histCalificacion',
                'bachiller_historico.histFolio',
                'bachiller_historico.hisActa',
                'bachiller_historico.histLibro',
                'alumnos.aluClave',
                'alumnos.aluMatricula',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.escClave',
                'escuelas.escNombre',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial as fecha_inicio',
                'periodos.perFechaFinal as fecha_fin',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_materias.matSemestre',
                'bachiller_materias.matCreditos'
            )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('departamentos.id', '=', $request->departamento_id)
            ->where('programas.id', '=', $request->programa_id)
            ->where('planes.id', '=', $request->plan_id)
            ->where('alumnos.aluClave', '=', $request->aluClave)
            ->where('bachiller_historico.histCalificacion', '<', $califMinAprobatoria)
            ->orderBy('periodos.perNumero', 'DESC')
            ->orderBy('periodos.perAnio', 'ASC')        
            ->get();
    
            $resultado_collection = collect($bachiller_historico_reprobadas);
        }

        // Si las materias son reprobadas y aprobadas 
        if($request->tipoReporte == 3){

            $titulo = "MATERIAS APROBADAS Y REPROBADAS POR ALUMNO (PRE-CERTIFICADO)";

            $bachiller_historico_reprobadas_aprobadas = Bachiller_historico::select(
                'bachiller_historico.alumno_id',
                'bachiller_historico.plan_id',
                'bachiller_historico.bachiller_materia_id',
                'bachiller_historico.periodo_id',
                'bachiller_historico.histPeriodoAcreditacion',
                'bachiller_historico.histTipoAcreditacion',
                'bachiller_historico.histFechaExamen',
                'bachiller_historico.histCalificacion',
                'bachiller_historico.histFolio',
                'bachiller_historico.hisActa',
                'bachiller_historico.histLibro',
                'alumnos.aluClave',
                'alumnos.aluMatricula',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.escClave',
                'escuelas.escNombre',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial as fecha_inicio',
                'periodos.perFechaFinal as fecha_fin',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_materias.matSemestre',
                'bachiller_materias.matCreditos'
            )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('departamentos.id', '=', $request->departamento_id)
            ->where('programas.id', '=', $request->programa_id)
            ->where('planes.id', '=', $request->plan_id)
            ->where('alumnos.aluClave', '=', $request->aluClave)
            // ->where('bachiller_historico.histCalificacion', '<', $califMinAprobatoria)
            ->orderBy('periodos.perNumero', 'DESC')
            ->orderBy('periodos.perAnio', 'ASC')        
            ->get();
    
            $resultado_collection = collect($bachiller_historico_reprobadas_aprobadas);
        }
        
        

        

        if ($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $alumno = $resultado_collection[0]->aluClave.'  '.$resultado_collection[0]->perApellido1.' '.$resultado_collection[0]->perApellido2.' '.$resultado_collection[0]->perNombre;
        $nivelCarrera = $resultado_collection[0]->depClave.' ('.$resultado_collection[0]->planClave.') '.$resultado_collection[0]->progNombre;
        $ubicacion = $resultado_collection[0]->ubiClave.'-'.$resultado_collection[0]->ubiNombre;
        $matricula = $resultado_collection[0]->aluMatricula;
        $semestre = $resultado_collection->groupBy('matSemestre');


        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');

        $fechaHoy = $fechaActual->format('d').'/'.Utils::num_meses_corto_string($fechaActual->format('m')).'/'.$fechaActual->format('Y');


        // Buscar cursos del alumno 
       $cursos = Curso::select('cursos.id', 'cgt.cgtGradoSemestre as grado', 'cgt.cgtGrupo', 'cursos.curFechaRegistro')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->where('alumnos.aluClave', '=', $request->aluClave)
        ->get();
        $ultimoSemestre = $cursos->max('grado');
        $primerSemestre = $cursos->min('grado');


        $ultimoGrupo = Curso::select('cursos.id', 'cgt.cgtGradoSemestre as grado', 'cgt.cgtGrupo')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->where('alumnos.aluClave', '=', $request->aluClave)
        ->where('cgt.cgtGradoSemestre', '=', $ultimoSemestre)
        ->first();
        $primerGrupo = Curso::select('cursos.curFechaRegistro')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->where('alumnos.aluClave', '=', $request->aluClave)
        ->where('cgt.cgtGradoSemestre', '=', $primerSemestre)
        ->first();

        $parametro_NombreArchivo = 'pdf_bachiller_materias_aprobadas';
        $pdf = PDF::loadView('reportes.pdf.bachiller.materias_aprobadas.' . $parametro_NombreArchivo, [
            "bachiller_historico_aprobados" => $resultado_collection,
            "fechaHoy" => $fechaHoy,
            "fechaActual" => $fechaActual,
            "alumno" => $alumno,
            "nivelCarrera" => $nivelCarrera,
            "ubicacion" => $ubicacion,
            "matricula" => $matricula,
            "semestre" => $semestre,
            "ultimoSemestre" => $ultimoSemestre,
            "grupo" => $ultimoGrupo->cgtGrupo,
            "fechaIngreso" => $primerGrupo->curFechaRegistro,
            "titulo" => $titulo
        ]);

        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($titulo . '.pdf');
        return $pdf->download($titulo  . '.pdf');
    }

}

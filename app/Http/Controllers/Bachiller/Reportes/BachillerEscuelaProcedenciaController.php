<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Curso;
use App\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class BachillerEscuelaProcedenciaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {

        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        return view('bachiller.reportes.escuela_procedencia.create',compact('ubicaciones'));
    }

    public function imprimir(Request $request) {
        set_time_limit(0);
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '1024M');

        $fechaActual = Carbon::now('CDT');
        $alert_title = 'Sin registros';
        $alert_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';



        $cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela', 'alumno.secundariaProcedencia.municipioSec.estadoSec.paisSec', 'alumno.preparatoria.municipio.estado.pais'])
        ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
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
            if($request->cgtGrupo) {
                $query->where('cgtGrupo', $request->cgtGrupo);
            }
        })
        ->whereHas('alumno.persona', static function($query) use ($request) {
            if($request->aluClave) {
                $query->where('aluClave', $request->aluClave);
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
        })
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            $query->where('curEstado', '<>', 'B');

        })->get();

        if($cursos->isEmpty()) {
            alert()->warning($alert_title, $alert_text)->showConfirmButton();
            return back()->withInput();
        }

        $periodo = $cursos->first()->periodo;
        $info = collect([
            'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
            'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
            'ubiClave' => $periodo->departamento->ubicacion->ubiClave,
            'ubiNombre' => $periodo->departamento->ubicacion->ubiNombre,
        ]);

        $datos = $cursos->map(function($curso, $key) {
            $persona = $curso->alumno->persona;
            $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
            $progClave = $curso->cgt->plan->programa->progClave;
            $grupo = $curso->cgt->cgtGrupo;



            if(isset($curso->alumno->secundariaProcedencia->id)){
                $secProcedencia_id = $curso->alumno->secundariaProcedencia->id;
                $secNombre = $curso->alumno->secundariaProcedencia->secNombre;
                $municipioSec = $curso->alumno->secundariaProcedencia->municipioSec->munNombre;
                $estadoSec = $curso->alumno->secundariaProcedencia->municipioSec->estadoSec->edoNombre;
                $paisSec = $curso->alumno->secundariaProcedencia->municipioSec->estadoSec->paisSec->paisNombre;
            }else{
                $secProcedencia_id = "";
                $secNombre = "";
                $municipioSec = "";
                $estadoSec = "";
                $paisSec = "";
            }

            if(isset($curso->alumno->preparatoria->id)){
                $preparatoria_id = $curso->alumno->preparatoria->id;
                $prepNombre = $curso->alumno->preparatoria->prepNombre;
                $municipioPrep = $curso->alumno->preparatoria->municipio->munNombre;
                $estadoPrep = $curso->alumno->preparatoria->municipio->estado->edoNombre;
                $paisPrep = $curso->alumno->preparatoria->municipio->estado->pais->paisNombre;
            }else{
                $preparatoria_id = "";
                $prepNombre = "";
                $municipioPrep = "";
                $estadoPrep = "";
                $paisPrep = "";
            }

            return collect([
                'progClave' => $progClave,
                'planClave' => $curso->cgt->plan->planClave,
                'progNombreCorto' => $curso->cgt->plan->programa->progNombreCorto,
                'grado' => $curso->cgt->cgtGradoSemestre,
                'grupo' => $grupo,
                'aluClave' => $curso->alumno->aluClave,
                'nombre' => $nombre,
                'curEstado' => $curso->curEstado,
                'orden' => $progClave.'-'.$grupo.'-'.$nombre,
                'secProcedencia_id' => $secProcedencia_id,
                'secNombre' => $secNombre,
                'municipioSec' => $municipioSec,
                'estadoSec' => $estadoSec,
                'paisSec' => $paisSec,
                'preparatoria_id' => $preparatoria_id,
                'prepNombre' => $prepNombre,
                'municipioPrep' => $municipioPrep,
                'estadoPrep' => $estadoPrep,
                'paisPrep' => $paisPrep
            ]);
        })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'pdf_escuela_procedencia.pdf';

        // view('reportes.pdf.bachiller.escuela_procedencia.pdf_escuela_procedencia');
        $pdf = PDF::loadView('reportes.pdf.bachiller.escuela_procedencia.pdf_escuela_procedencia', [
            "datos" => $datos,
            "info" => $info,
            "totalCursos" => $cursos->count(),
            "nombreArchivo" => $nombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);
        $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }//imprimir.
}

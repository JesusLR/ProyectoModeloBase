<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Materia;
use App\Models\Historico;
use App\Models\Ubicacion;
use App\Models\ResumenAcademico;
use App\Models\Calificacion;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas as Personas;
use App\clases\historicos\MetodosHistoricos;
use App\clases\calificaciones\MetodosCalificaciones as Calificaciones;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PosiblesBajasController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){

    	return view('reportes/rel_pos_bajas.create',[
            'ubicaciones' => Ubicacion::sedes()->get()
    	]);
    }

    public function imprimir(Request $request){
        $cursos = $this->buscarCursos($request);
        if($cursos->isEmpty()) return self::alert_verificacion();

        $periodo = Periodo::with('departamento.ubicacion')->find($request->periodo_id);
        $departamento = $periodo->departamento;
        $ubicacion =  $departamento->ubicacion;
        
        $materiasData = Materia::whereIn('plan_id', $cursos->pluck('plan_id'))
        ->get()
        ->groupBy('plan_id');
        
        $historicosData = Historico::whereIn('alumno_id', $cursos->pluck('alumno_id'))
        ->whereHas('periodo.departamento', static function($query) use ($departamento) {
            $query->where('depClave', $departamento->depClave);
        })
        ->latest('histFechaExamen')
        ->get()
        ->unique(static function($historico) {
            return $historico->alumno_id.$historico->materia_id;
        })
        ->groupBy('alumno_id');

        $cursos = $cursos->map(static function($curso) use ($departamento, $materiasData, $historicosData) {
            $calificacion_minima = $departamento->depCalMinAprob;
            $materias = $materiasData->get($curso['plan_id'])->where('matSemestre', '<=', $curso['grado']);
            $historicos = $historicosData->pull($curso['alumno_id']) ?: new Collection;
            $historicos = $historicos->where('plan_id', $curso['plan_id']);

            $ultimos2grados = [ $curso['grado'], ($curso['grado'] - 1) ];
            $no_cursadas = self::obtener_no_cursadas($materias, $historicos);
            $reprobadas = self::obtener_reprobadas($materias, $historicos, $calificacion_minima)
            ->where('matSemestre', '<=', $curso['grado']);

            $no_cursadas_ultimos2grados = $no_cursadas->whereIn('matSemestre', $ultimos2grados);
            $no_cursadas_anios_anteriores = $no_cursadas->whereNotIn('matSemestre', $ultimos2grados);
            $reprobadas_ultimos2grados = $reprobadas->whereIn('matSemestre', $ultimos2grados);
            $reprobadas_anios_anteriores = $reprobadas->whereNotIn('matSemestre', $ultimos2grados);

            return $curso->merge([
                'no_cursadas_ultimos2grados' => $no_cursadas_ultimos2grados->count(),
                'no_cursadas_anios_anteriores' => $no_cursadas_anios_anteriores->count(),
                'reprobadas_ultimos2grados' => $reprobadas_ultimos2grados->count(),
                'reprobadas_anios_anteriores' => $reprobadas_anios_anteriores->count(),
                'adeudos_ultimos2grados' => $no_cursadas_ultimos2grados->count() + $reprobadas_ultimos2grados->count(),
                'adeudos_anios_anteriores' => $reprobadas_anios_anteriores->count() + $no_cursadas_anios_anteriores->count(),
            ]);
        })->filter(static function($curso) {
            return $curso['adeudos_anios_anteriores'] > 0 || $curso['adeudos_ultimos2grados'] > 3;
        });

        if($cursos->isEmpty()) return self::alert_verificacion();

        $cursos = self::agregar_primer_tipo_ingreso($cursos);
        if($request->parcial) {
            $calificaciones = self::obtener_datos_de_parciales($cursos, $request, $departamento)->groupBy('curso_id');
            $calificacion_maxima = intval($request->calificacion_maxima) ?: $departamento->depCalMinAprob;
            $cursos = self::agregar_datos_de_parciales_a_cursos($cursos, $calificaciones, $calificacion_maxima);
        }

        $hoy = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_rel_pos_bajas.pdf";
        return PDF::loadView("reportes.pdf.pdf_rel_pos_bajas", [
        "datos" => $cursos->sortBy('orden')->groupBy(['progClave', 'grado']),
        "fechaActual" => Utils::fecha_string($hoy, 'mesCorto'),
        "horaActual" => $hoy->format('H:i:s'),
        "ubicacion" => $ubicacion,
        "perFechaInicial" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
        "perFechaFinal" => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
        "parcial" => $request->parcial ? self::obtener_descripcion_parcial($request->parcial) : '',
        "calificacion_maxima" => $request->calificacion_maxima,
        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo);
    }//imprimir.

    /**
    * @param Illuminate\Http\Request
    */
    public function buscarCursos($request){
    	$collection = new Collection;
        Curso::with('cgt.plan.programa', 'alumno.persona')
        ->where('periodo_id', $request->periodo_id)
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            if(!$request->aluBaja) {
                $query->where('curEstado', '<>', 'B');
            }
        })
    	->whereHas('cgt.plan',function($query) use($request){
    		$query->where('programa_id', $request->programa_id);
    		if($request->cgtGradoSemestre){
    			$query->where('cgtGradoSemestre',$request->cgtGradoSemestre);
    		}
    		if($request->cgtGrupo){
    			$query->where('cgtGrupo',$request->cgtGrupo);
    		}
    	})
    	->whereHas('alumno.persona',function($query) use($request){
    		if(!$request->aluBaja){
    			$query->where('aluEstado', '<>', 'B');
    		}
    		if($request->aluClave){
    			$query->where('aluClave', $request->aluClave);
    		}
    		if($request->aluMatricula){
    			$query->where('aluMatricula', $request->aluMatricula);
    		}
    		if($request->perApellido1){
    			$query->where('perApellido1', 'like', "%{$request->perApellido1}%");
    		}
    		if($request->perApellido2){
    			$query->where('perApellido2', 'like', "%{$request->perApellido2}%");
    		}
    		if($request->perNombre){
    			$query->where('perNombre', 'like', "%{$request->perNombre}%");
    		}
    	})->chunk(200, static function($cursos) use ($collection) {

            if($cursos->isEmpty()) return false;

            $cursos->each(static function($curso) use ($collection) {
                $info = self::extraer_info_curso($curso);
                $collection->push($info);
            });
        });

        return $collection;
    }#buscarCursos.

    public static function alert_verificacion() {
        alert('Sin coincidencias', 'No se encontraron datos que coincidan con la información proporcionada.')
        ->showConfirmButton();
        return back()->withInput();
    }

    /**
    * @param App\Models\Curso
    */
    private static function extraer_info_curso($curso) {

        $alumno = $curso->alumno;
        $cgt = $curso->cgt;
        $plan = $cgt->plan;
        $programa = $plan->programa;
        $nombreCompleto = Personas::nombreCompleto($alumno->persona, true);

        return collect([
            'plan_id' => $plan->id,
            'curso_id' => $curso->id,
            'alumno_id' => $alumno->id,
            'aluClave' => $alumno->aluClave,
            'progClave' => $programa->progClave,
            'progNombre' => $programa->progNombre,
            'planClave' => $plan->planClave,
            'nombreCompleto' => $nombreCompleto,
            'tipo_ingreso' => $curso->curTipoIngreso,
            'estado_curso' => self::abreviar_estado_curso($curso->curEstado),
            'grado' => intval($cgt->cgtGradoSemestre),
            'grupo' => $cgt->cgtGrupo,
            'orden' => "{$programa->progClave}-{$cgt->cgtGrupo}-{$nombreCompleto}",
        ]);
    }

    /**
    * @param string
    */
    private static function abreviar_estado_curso($curEstado) {
        switch ($curEstado) {
            case 'R':
                $curEstado = 'Reg';
                break;
            case 'B':
                $curEstado = 'Baj';
                break;
            case 'X':
                $curEstado = 'Ext';
                break;
            default:
                $curEstado = 'Reg';
                break;
        }

        return $curEstado;
    }

    /**
    * @param Collection $materias
    * @param Collection $historicos
    */
    private static function obtener_no_cursadas($materias, $historicos) {
        return $materias->whereNotIn('id', $historicos->pluck('materia_id'));
    }

    /**
    * @param Collection $materias
    * @param Collection $historicos
    * @param int $calificacion_minima
    */
    private static function obtener_reprobadas($materias_plan, $historicos, $calificacion_minima) {

        return $historicos->map(static function($historico) use ($materias_plan, $calificacion_minima) {
            $materia = $materias_plan->get($historico->materia_id) ?: $historico->materia;
            $calificacion = MetodosHistoricos::definirCalificacion($historico, $materia);

            return collect([
                'materia' => $materia,
                'es_reprobada' => MetodosHistoricos::es_reprobada($calificacion, $calificacion_minima),
            ]);
        })->filter(static function($historico) {
            return $historico['es_reprobada'];
        })->pluck('materia');
    }

    /**
    * @param Collection
    */
    private static function agregar_primer_tipo_ingreso($cursos)
    {
        $resacasData = self::buscar_mapear_resacas($cursos);
        $cursos_ingreso = self::buscar_cursos_ingreso($resacasData);
        $resacasData = $resacasData->groupBy('alumno_id');

        return $cursos->map(static function($curso) use ($resacasData, $cursos_ingreso) {
            $resacas = $resacasData->get($curso['alumno_id']) ?: new Collection;
            $resaca = $resacas->where('plan_id', $curso['plan_id'])->first();
            $curso_ingreso = $resaca ? $cursos_ingreso->get($resaca['cadena_busqueda']) : null;
            $tipo_ingreso = $curso_ingreso ? $curso_ingreso->curTipoIngreso : '**';
            $curso->put('primer_tipo_ingreso', $tipo_ingreso);

            return $curso;
        });
    }

    /**
    * @param Collection
    */
    private static function buscar_mapear_resacas($cursos)
    {
        return ResumenAcademico::whereIn('alumno_id', $cursos->pluck('alumno_id'))
        ->whereIn('plan_id', $cursos->pluck('plan_id'))
        ->get()
        ->map(static function($resaca) {
            return collect([
                'alumno_id' => $resaca->alumno_id,
                'plan_id' => $resaca->plan_id,
                'cadena_busqueda' => "{$resaca->alumno_id}-{$resaca->resPeriodoIngreso}",
            ]);
        });
    }

    /**
    * @param Collection
    */
    private static function buscar_cursos_ingreso($resacas_mapeados)
    {
        $raw_seleccion = DB::raw("CONCAT_WS('-', alumno_id, periodo_id)");

        return Curso::select('id as curso_id', 'alumno_id', 'periodo_id', 'curTipoIngreso')
        ->whereIn($raw_seleccion, $resacas_mapeados->pluck('cadena_busqueda'))
        ->get()
        ->each(static function($curso) {
            $curso->cadena_busqueda = "{$curso->alumno_id}-{$curso->periodo_id}";
        })
        ->keyBy('cadena_busqueda');
    }

    /**
    * @param Collection $cursos
    * @param Illuminate\Http\Request $request
    */
    private static function obtener_datos_de_parciales($cursos, $request, $departamento)
    {
        $calificaciones = new Collection;
        $calificacion_minima = $departamento->depCalMinAprob;
        Calificacion::with('inscrito.grupo.materia')
        ->whereHas('inscrito.curso', static function($query) use ($request, $cursos) {
            $query->where('periodo_id', $request->periodo_id)
                  ->whereIn('curso_id', $cursos->pluck('curso_id'));
        })->chunk(100, static function($registros) use ($request, $calificaciones, $calificacion_minima) {

            if($registros->isEmpty()) return false;

            $parcial = self::obtener_clave_etapa_parcial($request->parcial);
            $registros->each(static function($registro) use ($parcial, $calificaciones, $calificacion_minima) {
                $info = self::info_esencial_calificacion($registro, $parcial, $calificacion_minima);
                $calificaciones->push($info);
            });
        });

        return $calificaciones;
    }

    /**
    * @param App\Models\Calificacion
    * @param string $parcial
    * @param int $calificacion_minima
    */
    private static function info_esencial_calificacion($calificacion, $parcial, $calificacion_minima) {
        $inscrito = $calificacion->inscrito;
        $materia = $inscrito->grupo->materia;
        $puntaje = Calificaciones::definirCalificacion($calificacion, $materia, $parcial);

        return collect([
            'curso_id' => $inscrito->curso_id,
            'materia_id' => $materia->id,
            'matSemestre' => $materia->matSemestre,
            'es_numerica' => $materia->esNumerica(),
            'puntaje' => $puntaje,
            'es_reprobada' => Calificaciones::es_reprobada($puntaje, $calificacion_minima),
        ]);
    }

    /**
    * @param string $etapa
    */
    private static function obtener_clave_etapa_parcial($etapa) {
        switch ($etapa) {
            case 'inscCalificacionParcial1':
                $etapa = 'P1';
                break;
            case 'inscCalificacionParcial2':
                $etapa = 'P2';
                break;
            case 'inscCalificacionParcial3':
                $etapa = 'P3';
                break;
            case 'inscPromedioParciales':
                $etapa = 'PP';
                break;
            case 'inscCalificacionOrdinario':
                $etapa = 'OR';
                break;
            case 'incsCalificacionFinal':
                $etapa = 'CF';
                break;
            default:
                $etapa = 'P1';
                break;
        }

        return $etapa;
    }

    /**
    * @param Collection $cursos
    * @param Collection $calificaciones
    * @param int $calificacion_maxima
    */
    private static function agregar_datos_de_parciales_a_cursos($cursos, $calificaciones, $calificacion_maxima)
    {   
        if($calificaciones->isEmpty()) return $cursos;

        return $cursos->map(static function($curso) use ($calificaciones, $calificacion_maxima) {
            $calificaciones_alumno = $calificaciones->get($curso['curso_id']) ?: new Collection;
            $calificaciones_numericas = $calificaciones_alumno->where('es_numerica', true);

            return $curso->merge([
                'reprobadas_parcial' => $calificaciones_alumno->where('es_reprobada', true)->count(),
                'parciales_debajo_del_parametro' => $calificaciones_numericas->where('puntaje', '<=', $calificacion_maxima)->count(),
            ]);
        });
    }

    /**
    * @param string $parcial
    */
    private static function obtener_descripcion_parcial($parcial) {
        switch ($parcial) {
            case 'inscCalificacionParcial1':
                $parcial = 'Parcial 1';
                break;
            case 'inscCalificacionParcial2':
                $parcial = 'Parcial 2';
                break;
            case 'inscCalificacionParcial3':
                $parcial = 'Parcial 3';
                break;
            case 'inscPromedioParciales':
                $parcial = 'Prom. Parciales';
                break;
            case 'inscCalificacionOrdinario':
                $parcial = 'Ordinario';
                break;
            case 'incsCalificacionFinal':
                $parcial = 'Calif. Final';
                break;
            default:
                $parcial = 'Parcial 1';
                break;
        }

        return $parcial;
    }

}//Controller class.

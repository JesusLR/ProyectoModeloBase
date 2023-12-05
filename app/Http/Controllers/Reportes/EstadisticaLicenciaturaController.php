<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Egresado;
use App\Models\Acuerdo;
use App\Http\Helpers\Utils;
use App\clases\periodos\MetodosPeriodos;

use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use RealRashid\SweetAlert\Facades\Alert;

class EstadisticaLicenciaturaController extends Controller
{
    //
    protected $anioActual;
    protected $anioAnterior;
    protected $departamento;
    protected $ubicacion;

    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }


    public function reporte() {
    	return view('reportes/estadisticas_estatales.licenciatura', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'anioActual' => Carbon::now('America/Merida')->year,
    	]);
    }


    public function imprimir(Request $request) {
    	$this->anioActual = $request->perAnio;
    	$this->anioAnterior = $request->perAnio - 1;
    	$cursos = $this->buscarCursos($request);
    	if($cursos->isEmpty()) return self::alert_verificacion();

    	$this->departamento = $cursos->first()->periodo->departamento;
    	$this->ubicacion = $this->departamento->ubicacion;
    	$egresados = $this->buscarEgresadosCicloAnterior($request);

    	$planes = $this->obtenerEstadisticasPorPlan($cursos, $egresados);
    	if($planes->isEmpty()) return self::alert_verificacion();
    	return $this->generarWord($planes);
    } # imprimir.


    /**
    * @param Illuminate\Http\Request
    */
    private function buscarCursos($request)
    {
    	return Curso::with(['cgt.plan', 'alumno.persona'])
    	->whereHas('periodo', function($query) use ($request) {
    		$query->where('departamento_id', $request->departamento_id)
    			->whereIn('perAnio', [$this->anioAnterior, $this->anioActual]);
    	})
    	->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
    		if($request->escuela_id) 
    			$query->where('escuela_id', $request->escuela_id);
    		if($request->programa_id)
    			$query->where('programa_id', $request->programa_id);
    		if($request->plan_id)
    			$query->where('plan_id', $request->plan_id);
    	})->get();
    }


    /**
    * alert en caso de no encontrar registros.
    */
    private static function alert_verificacion() {
    	alert('Sin Coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
    	return back()->withInput();
    }


    /**
    * @param Illuminate\Http\Request
    */
    private function buscarEgresadosCicloAnterior($request)
    {
        $queryTitulados = Egresado::with('alumno.persona')
        ->whereHas('periodoTitulacion.departamento', function($query) use ($request) {
            $query->where('departamento_id', $request->departamento_id)
                ->where('perAnioPago', $this->anioAnterior);
        });

    	return Egresado::with('alumno.persona')
    	->whereHas('periodo.departamento', function($query) use ($request) {
    		$query->where('departamento_id', $request->departamento_id)
    			->where('perAnioPago', $this->anioAnterior);
    	})
        ->union($queryTitulados)
    	->whereHas('plan.programa', static function($query) use ($request) {
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    		if($request->programa_id)
    			$query->where('programa_id', $request->programa_id);
    		if($request->plan_id)
    			$query->where('plan_id', $request->plan_id);
    	})
    	->get()->unique('alumno_id')->groupBy('plan_id');
    }


    /**
    * @param Collection $cursos
    * @param Collection $egresados
    */
    private function obtenerEstadisticasPorPlan($cursos, $egresados) 
    {	
    	$planes_ids = $cursos->unique('cgt.plan_id')->pluck('cgt.plan_id');
    	$acuerdos = self::buscarAcuerdosDePlanes($planes_ids);

    	return $cursos->groupBy('cgt.plan_id')
    	->map(function($plan_cursos) use ($egresados, $acuerdos) {
    		$info = $plan_cursos->first();
    		$plan_estructura = MetodosPeriodos::definirEstructura($info->periodo->perEstado);
    		$plan = $info->cgt->plan;
    		$programa = $plan->programa;
    		$escuela = $programa->escuela;
    		$acuerdo = $acuerdos->get($plan->id);
    		$egresados_plan = $egresados->get($plan->id);
    		$cursos_ciclo_actual = $plan_cursos->where('periodo.perAnio', $this->anioActual);
    		$cursos_ciclo_anterior = $plan_cursos->where('periodo.perAnio', $this->anioAnterior);

    		return collect([
    			'departamento' => "{$this->departamento->depNombre} - {$this->departamento->depClaveOficial}",
    			'escuela' => "{$escuela->escNombre} ({$escuela->escClave})",
    			'programa_plan' => "{$programa->progNombre} ({$programa->progClave} {$plan->planClave})",
    			'revoe' => $acuerdo && $acuerdo->acuNumero ? $acuerdo->acuNumero : '',
    			'fecha_acuerdo' => $acuerdo ? Utils::fecha_string(($acuerdo->acuFecha ?: null), 'mesCorto') : null,
    			'duracion' => "{$plan->planPeriodos} {$plan_estructura}",
    			'creditos' => $plan->planNumCreditos,
    			'ciclo_actual' => $this->datosEsencialesCursos($cursos_ciclo_actual),
    			'ciclo_anterior' => $this->datosEsencialesCursos($cursos_ciclo_anterior),
    			'egresados' => $egresados_plan ? $this->datosEsencialesEgresados($egresados_plan) : null,
    		]);
    	});
    }

    /**
    * @param array
    */
    private static function buscarAcuerdosDePlanes($planes_ids)
    {
    	return Acuerdo::whereIn('plan_id', $planes_ids)
    	->oldest('acuFecha')->get()->keyBy('plan_id');
    }


    /**
    * @param Collection
    */
    private function datosEsencialesCursos($cursos)
    {
    	return $cursos->map(function($curso) {
    		$cgt = $curso->cgt;
    		$tiene_datos = $curso->alumno->preparatoria_id != 0;
    		$municipio_prepa = $tiene_datos ? $curso->alumno->preparatoria->municipio : false;
    		$estado_prepa = $municipio_prepa ? $municipio_prepa->estado : false;
    		$pais_prepa = $estado_prepa ? $estado_prepa->pais : false;
    		$prepaEsMexicana = ($tiene_datos && $pais_prepa->id == 1);
    		$infoPersona = $this->obtenerInfoPersona($curso->alumno->persona);

    		return collect([
    			'esTitulado' => $curso->curOpcionTitulo == 'N',
    			'cgt_id' => $cgt->id,
    			'cupo' => $cgt->cgtCupo,
    			'grado' => $cgt->cgtGradoSemestre,
    			'prepa_origen' => $prepaEsMexicana ? $estado_prepa->edoNombre : $pais_prepa ? $pais_prepa->paisNombre : 'Sin datos',
    			'prepaEsMexicana' => $prepaEsMexicana,
    			'tiene_datos' => $tiene_datos,
    		])->merge($infoPersona);

    	});
    }


    /**
    * @param Collection
    */
    private function datosEsencialesEgresados($egresados)
    {	
    	return $egresados->map(function($egresado) {
    		$infoPersona = $this->obtenerInfoPersona($egresado->alumno->persona);

    		return collect([
    			'esTitulado' => $egresado->egrPeriodoTitulacion ? true : false,
    		])->merge($infoPersona);

    	});
    }


    /**
    * @param App\Models\Persona
    */
    private function obtenerInfoPersona($persona)
    {
    	$municipio = $persona->municipio;
    	$estado = $municipio->estado;
    	$pais = $estado->pais;
    	$esMexicano = $pais->id == 1;

    	return [
    		'sexo' => $persona->perSexo,
    		'edad' => $persona->edad(),
    		'esMexicano' => $esMexicano,
    		'esLocal' => $estado->id == $this->ubicacion->municipio->estado_id,
    		'origen' => $esMexicano ? $estado->edoNombre : $pais ? $pais->paisNombre : 'Sin datos',
    	];
    }


    /**
    * @param Collection
    */
    private function generarWord($planes)
    {
    	// Estilos de fuente ----------------------------
    	$titulo = ['size' => 15, 'bold' => true];
    	$subtitulo = ['size' => 14];
    	$tabla_header_fuente = ['bold' => true];

    	// Estilos párrafo ------------------------------
    	$centrado = ['align' => 'center'];
    	$izquierda = ['align' => 'left'];

    	// Estilos tabla --------------------------------
    	$estilo_tabla = array('borderSize' => 6, 'borderColor' => '999999','marginBottom' => 10);
    	$celda_header = ['bgColor' => 'D2D2D2'];

    	// Info Documento -------------------------------
    	$cicloEscolar = $this->anioActual.'-'.($this->anioActual + 1);
    	$cicloEscolarAnterior = $this->anioAnterior.'-'.$this->anioActual;

    	// Contenido Documento
    	$word = new PhpWord();
    	$nombreArchivo = "Estadistica-Licenciatura-{$cicloEscolar}.docx";
    	$word->addTableStyle('tabla_normal', $estilo_tabla);

    	foreach ($planes as $key => $plan) {

    		$cursos_actuales = $plan['ciclo_actual'];
    		$cursos_anteriores = $plan['ciclo_anterior'];
    		$cursos_actuales_1ro = $cursos_actuales->where('grado', 1);
    		$cursos_anteriores_1ro = $cursos_anteriores->where('grado', 1);
    		$total_1ro = $cursos_actuales_1ro->count();
    		$total_1ro_sin_datos = $cursos_actuales_1ro->where('tiene_datos', false)->count();
    		$egresados = $plan['egresados'] ?: collect([]);


    		$seccion = $word->addSection();
    		$seccion->addText($plan['departamento'], $titulo, $izquierda);
    		$seccion->addText($plan['escuela'], $subtitulo, $izquierda);
    		$seccion->addText($plan['programa_plan'], $subtitulo, $izquierda);
    		$seccion->addText("Revoe: {$plan['revoe']}");
    		$seccion->addText("Fecha de acuerdo: {$plan['fecha_acuerdo']}");
    		$seccion->addText("Fecha de creación: {$plan['fecha_acuerdo']}");
    		$seccion->addText("Duración del programa: {$plan['duracion']}");
    		$seccion->addText("Número de créditos por cubrir: {$plan['creditos']}");

    		$seccion->addText("Alumnos de primer ingreso del ciclo anterior", $subtitulo, $izquierda);
    		$seccion->addText("Número de periodos de inscripción del ciclo escolar {$cicloEscolarAnterior}: ");

    		$seccion->addText("Número de alumnos de primer ingreso del ciclo escolar {$cicloEscolarAnterior} por sexo:");
    		$tabla = $seccion->addTable('tabla_normal');
    		$tabla->addRow();
    		$t1_columnas = ['Hombres', 'Mujeres', 'Total'];
    		foreach ($t1_columnas as $columna) {
    			$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    		}
    		$tabla->addRow();
    		$hombres = $cursos_anteriores_1ro->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $cursos_anteriores_1ro->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$total = $cursos_anteriores_1ro->count();
    		$tabla->addCell(2000)->addText($total);

    		$seccion->addText("Numero de egresados y titulados en el ciclo escolar {$cicloEscolarAnterior}:");
    		$tabla = $seccion->addTable('tabla_normal');
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText('');
    		$celda = $tabla->addCell(2000);
    		$celda->getStyle()->setGridSpan(3);
    		$celda->addText('Egresados', $tabla_header_fuente, $celda_header);
    		$celda = $tabla->addCell(2000);
    		$celda->getStyle()->setGridSpan(3);
    		$celda->addText('Titulados', $tabla_header_fuente, $celda_header);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText('Edad', $tabla_header_fuente, $celda_header);
    		$t2_columnas = ['Hombres', 'Mujeres', 'Total', 'Hombres', 'Mujeres', 'Total'];
    		foreach ($t2_columnas as $columna) {
    			$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    		}
    		$t2_filas_edades = $egresados->groupBy('edad')->sortKeys()->keys();
    		$t2_columnas_span = ['egresados', 'titulados'];
    		foreach ($t2_filas_edades as $edad) {
    			$tabla->addRow();
    			$tabla->addCell(2000)->addText("{$edad} años", $tabla_header_fuente, $celda_header);
    			$egresados_edad = $egresados->where('edad', $edad);
    			foreach ($t2_columnas_span as $span) {
    				$esTitulado = $span == 'titulados';
    				$hombres = $egresados_edad->where('sexo', 'M')->where('esTitulado', $esTitulado)->count();
    				$tabla->addCell(2000)->addText($hombres);
    				$mujeres = $egresados_edad->where('sexo', 'F')->where('esTitulado', $esTitulado)->count();
    				$tabla->addCell(2000)->addText($mujeres);
    				$total  = $egresados_edad->where('esTitulado', $esTitulado)->count();
    				$tabla->addCell(2000)->addText($total);
    			}
    		}
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Total", $tabla_header_fuente, $celda_header);
    		foreach ($t2_columnas_span as $span) {
    			$esTitulado = $span == 'titulados';
    			$hombres = $egresados->where('sexo', 'M')->where('esTitulado', $esTitulado)->count();
    			$tabla->addCell(2000)->addText($hombres);
    			$mujeres = $egresados->where('sexo', 'F')->where('esTitulado', $esTitulado)->count();
    			$tabla->addCell(2000)->addText($mujeres);
    			$total = $egresados->where('esTitulado', $esTitulado)->count();
    			$tabla->addCell(2000)->addText($total);
    		}

    		$seccion->addText("Ciclo Actual {$cicloEscolar}", $subtitulo, $izquierda);
    		$seccion->addText("Fecha de inicio de año escolar: ");
    		$lugares_ofertados = $cursos_actuales_1ro->unique('cgt_id')->sum('cgtCupo');
    		$seccion->addText("Número de lugares ofertados para primer ingreso: {$lugares_ofertados}");

    		$seccion->addText("Número de alumnos de primer ingreso con título (Posgrado): ");
    		$tabla = $seccion->addTable('tabla_normal');
    		$tabla->addRow();
    		$t3_columnas = ['Con título', 'Sin título', 'Total'];
    		foreach ($t3_columnas as $columna) {
    			$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    		}
    		$tabla->addRow();
    		$conTitulo = $cursos_actuales_1ro->where('esTitulado', true)->count();
    		$tabla->addCell(2000)->addText($conTitulo);
    		$sinTitulo = $cursos_actuales_1ro->where('esTitulado', false)->count();
    		$tabla->addCell(2000)->addText($sinTitulo);
    		$tabla->addCell(2000)->addText($total_1ro);

    		$seccion->addText("Número de alumnos de primer ingreso: ");
    		$tabla = $seccion->addTable('tabla_normal');
    		$tabla->addRow();
    		$t4_columnas = ['Hombres', 'Mujeres', 'Total'];
    		foreach ($t4_columnas as $columna) {
    			$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    		}
    		$tabla->addRow();
    		$hombres = $cursos_actuales_1ro->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $cursos_actuales_1ro->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$tabla->addCell(2000)->addText($total_1ro);

    		$seccion->addText("Número de alumnos de primer ingreso, según donde estudiaron su bachillerato: ");
    		$tabla = $seccion->addTable('tabla_normal');
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Lugares", $tabla_header_fuente, $celda_header);
    		$tabla->addCell(2000)->addText("Cantidad", $tabla_header_fuente, $celda_header);
    		$t5_filas_origenes = $cursos_actuales_1ro->where('tiene_datos', true)->groupBy('prepa_origen')->sortKeys()->keys();
    		foreach ($t5_filas_origenes as $origen) {
    			$tabla->addRow();
    			$tabla->addCell(2000)->addText($origen);
    			$total = $cursos_actuales_1ro->where('prepa_origen', $origen)->count();
    			$tabla->addCell(2000)->addText($total);
    		}
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Sin datos");
    		$tabla->addCell(2000)->addText($total_1ro_sin_datos);

    		$seccion->addText("Lista de alumnos sin datos");
    		$seccion->addText("Alumnos de primer ingreso, según su lugar de nacimiento: ");
    		$tabla = $seccion->addTable('tabla_normal');
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("En la entidad");
    		$enLaEntidad = $cursos_actuales_1ro->where('esLocal', true)->count();
    		$tabla->addCell(2000)->addText($enLaEntidad);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Otras entidades");
    		$otrasEntidades = $cursos_actuales_1ro->where('esLocal', false)->where('esMexicano', true)->count();
    		$tabla->addCell(2000)->addText($otrasEntidades);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Estados Unidos");
    		$estadosUnidos = $cursos_actuales_1ro->where('origen', 'Estados Unidos')->count();
    		$tabla->addCell(2000)->addText($estadosUnidos);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Otro país");
    		$otroPais = $cursos_actuales_1ro->where('origen', '<>', 'Estados Unidos')->where('esMexicano', false)->count();
    		$tabla->addCell(2000)->addText($otroPais);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Sin datos");
    		$sinDatos = $cursos_actuales_1ro->where('origen', 'Sin datos')->count();
    		$tabla->addCell(2000)->addText($sinDatos);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText("Total");
    		$tabla->addCell(2000)->addText($total_1ro);



    		$seccion->addPageBreak();
    	}# foreach plan

    	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
	    try {
	      $objWriter->save(storage_path($nombreArchivo));
	    } catch (Exception $e) {
	    	alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
	    	return back()->withInput();
	    }

	    return response()->download(storage_path($nombreArchivo));
    }
}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Programa;
use App\Http\Models\Grupo;
use App\Http\Models\Empleado;
use App\Http\Models\Horario;
use App\Http\Models\HorarioAdmivo;
use App\Http\Models\Escolaridad;
use App\clases\personas\MetodosPersonas as Personas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpWord\PhpWord;

class EstadisticaMaestrosController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	return view('reportes/estadisticas_estatales.maestros', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'anioActual' => Carbon::now('America/Merida')->year,
    	]);
    }

    public function imprimir(Request $request) {

    	$horarios['grupos'] = self::buscarHorariosDeGrupos($request);
    	$horarios['administrativos'] = self::buscarHorariosAdministrativos($request);

    	if($horarios['grupos']->isEmpty() && $horarios['administrativos']->isEmpty()) {
    		return self::alert_verificacion();
    	}
    	$infoGeneral = self::obtenerInfoGeneral($request);
    	$empleados = self::buscarEmpleados($horarios);
    	$escolaridades = self::buscarEscolaridades($empleados);
    	$antiguedades = self::buscarAntiguedad($empleados);
    	$empleados = self::mapearInfoPorEmpleado($empleados, $horarios, $escolaridades, $antiguedades);
        $empleados_con_datos = self::evadirEmpleadosConFaltaDeDatos($empleados);

    	return $this->generarWord($infoGeneral, $empleados_con_datos);
    }


    /**
    * @param Illuminate\Http\Request
    */
    private static function buscarHorariosDeGrupos($request)
    {
    	return Horario::with('grupo.periodo.departamento')
    	->whereHas('grupo.periodo.departamento', static function($query) use ($request) {
    		$query->where('ubicacion_id', $request->ubicacion_id)
    			  ->where('perAnio', $request->perAnio)
    			  ->whereIn('perNumero', [3, 6]);
    		if($request->departamento_id) 
    			$query->where('departamento_id', $request->departamento_id);
    	})
    	->whereHas('grupo.plan.programa', static function($query) use ($request) {
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    		if($request->programa_id)
    			$query->where('programa_id', $request->programa_id);
    	})->get();
    }


    /**
    * @param Illuminate\Http\Request
    */
    private static function buscarHorariosAdministrativos($request)
    {
    	return HorarioAdmivo::with('periodo.departamento')
    	->whereHas('empleado.escuela', static function($query) use ($request) {
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    	})
    	->whereHas('periodo.departamento', static function($query) use ($request) {
    		$query->where('ubicacion_id', $request->ubicacion_id)
    			  ->where('perAnio', $request->perAnio)
    			  ->whereIn('perNumero', [3, 6]);
    		if($request->departamento_id)
    			$query->where('departamento_id', $request->departamento_id);
    	})->get();
    }


    /**
    * @param Illuminate\Http\Request
    */
    private static function obtenerInfoGeneral($request)
    {
    	$programa = Programa::with('escuela.departamento.ubicacion')
    	->where(static function($query) use ($request) {
    		if($request->programa_id)
    			$query->where('id', $request->programa_id);
    	})
    	->whereHas('escuela.departamento.ubicacion', static function($query) use ($request) {
    		$query->where('ubicacion_id', $request->ubicacion_id);
    		if($request->departamento_id)
    			$query->where('departamento_id', $request->departamento_id);
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    	})->first();

    	$escuela = $programa->escuela;
    	$departamento = $escuela->departamento;
    	$ubicacion = $departamento->ubicacion;

    	return [
    		'ubicacion' => "{$ubicacion->ubiClave}-{$ubicacion->ubiNombre}",
    		'cicloEscolar' => $request->perAnio.'-'.($request->perAnio + 1),
    		'departamento' => $request->departamento_id ? "{$departamento->depClave}-{$departamento->depNombre}" : null,
    		'escuela' => $request->escuela_id ? "{$escuela->escClave}-{$escuela->escNombre}" : null,
    		'programa' =>$request->programa_id ? "{$programa->progClave}-{$programa->progNombre}" : null,
    	];
    }


    /**
    * @param array
    */
    private static function buscarEmpleados($horarios)
    {	
    	$empleados_ids_grupos = $horarios['grupos']->pluck('grupo.empleado_id');
    	$empleados_ids_administrativos = $horarios['administrativos']->pluck('empleado_id');
    	$ids = $empleados_ids_administrativos->concat($empleados_ids_grupos)->unique();

    	return Empleado::with(['persona'])->whereIn('id', $ids)->get();
    }


    /**
    * @param Collection
    */
    private static function buscarEscolaridades($empleados)
    {
    	return Escolaridad::with('profesion')
    	->whereIn('empleado_id', $empleados->pluck('id'))
    	->where('escoUltimoGrado', 'S')->get()->keyBy('empleado_id');
    }


    /**
    * @param Collection
    */
    private static function buscarAntiguedad($empleados) 
    {
    	$grupos = Grupo::with('periodo')->whereIn('empleado_id', $empleados->pluck('id'))
    	->get()->sortByDesc('periodo.perFechaInicial')->keyBy('empleado_id')
    	->map(static function($grupo) {
    		return self::calcularAntiguedad($grupo->empleado_id, $grupo->periodo);
    	});

    	$administrativos = HorarioAdmivo::with('periodo')->whereIn('empleado_id', $empleados->pluck('id'))
    	->get()->sortByDesc('periodo.perFechaInicial')->keyBy('empleado_id')
    	->map(static function($horario) {
    		return self::calcularAntiguedad($horario->empleado_id, $horario->periodo);
    	});

    	return $grupos->concat($administrativos)->sortBy('anios')->keyBy('empleado_id');
    }


    /**
    * @param int $empleado_id
    * @param App\Http\Models\Periodo
    */
    private static function calcularAntiguedad($empleado_id, $periodo)
    {
    	$fechaActual = Carbon::now('America/Merida');
    	$fechaAntigua = Carbon::parse($periodo->perFechaInicial);

    	return collect([
    		'empleado_id' => $empleado_id,
    		'anios' => $fechaActual->diffInYears($fechaAntigua),
    	]);
    }

    private static function alert_verificacion() {
    	alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')
    	->showConfirmButton();
    	return back()->withInput();
    }


    /**
    * @param Collection $empleados
    * @param array $horarios
    */
    private static function mapearInfoPorEmpleado($empleados, $horarios, $escolaridades, $antiguedades)
    {
    	$horarios['grupos'] = $horarios['grupos']->groupBy('grupo.empleado_id');
    	$horarios['administrativos'] = $horarios['administrativos']->groupBy('empleado_id');
    	return $empleados->map(static function($empleado) use ($horarios, $escolaridades, $antiguedades) {
    		$horarios_grupos = $horarios['grupos']->get($empleado->id) ?: collect([]);
    		$horarios_admin = $horarios['administrativos']->get($empleado->id) ?: collect([]);
    		$horas_grupos = self::calcularHorasGrupo($horarios_grupos);
    		$horas_admin = self::calcularHorasAdministrativas($horarios_admin);
    		$escolaridad  = $escolaridades->get($empleado->id);
    		$antiguedad = $antiguedades->get($empleado->id);
    		$persona = $empleado->persona;

    		return collect([
    			'empleado_id' => $empleado->id,
    			'horas' => $horas_grupos + $horas_admin,
    			'esDocenteSUP' => $horarios_grupos->where('grupo.periodo.departamento.depClave', 'SUP')->isNotEmpty(),
    			'esDocentePOS' => $horarios_grupos->where('grupo.periodo.departamento.depClave', 'POS')->isNotEmpty(),
    			'nivel_educativo' => $escolaridad ? $escolaridad->profesion->nivel->ngNombre : 'Sin datos',
    			'esTitulado' => $escolaridad ? ($escolaridad->escoGraduado == 'S') : false,
    			'antiguedad' => $antiguedad ? $antiguedad['anios'] : 'Sin datos',
    			'edad' => $persona->edad(),
    			'sexo' => $persona->perSexo,
    			'nombreCompleto' => Personas::nombreCompleto($persona),
    		]);
    	});
    }


    /**
    * @param Collection
    */
    private static function calcularHorasGrupo($horarios_grupos)
    {
    	if($horarios_grupos->isEmpty()) return 0;

    	return $horarios_grupos->where('grupo.grupo_equivalente_id', null)
    	->sum(static function($horario) {
    		return $horario->ghFinal - $horario->ghInicio;
    	});
    }


    /**
    * @param Collection
    */
    private static function calcularHorasAdministrativas($horarios_admin)
    {
    	if($horarios_admin->isEmpty()) return 0;

    	return $horarios_admin->sum(static function($horario) {
    		return $horario->hadmFinal - $horario->hadmHoraInicio;
    	});
    }


    /**
    * @param Collection
    */
    private static function evadirEmpleadosConFaltaDeDatos($empleados)
    {
        return $empleados->whereIn('sexo', ['F', 'M'])
        ->where('edad', '!=', null)
        ->where('horas', '>', 0)
        ->where('nivel_educativo', '!=', 'Sin datos')
        ->where('antiguedad', '!=', 'Sin datos');
    }


    /**
    * @param array $info
    * @param Collection $empleados
    */
    private function generarWord($info, $empleados)
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
 		$total_empleados = $empleados->count();
 		$total_hombres = $empleados->where('sexo', 'M')->count();
 		$total_mujeres = $empleados->where('sexo', 'F')->count();
 		$sin_sexo = $empleados->whereNotIn('sexo', ['M', 'F']);
 		$sin_edad = $empleados->where('edad', null);
 		$sin_horas = $empleados->where('horas', 0);
 		$sin_nivel = $empleados->where('nivel_educativo', 'Sin datos');
 		$sin_antiguedad = $empleados->where('antiguedad', 'Sin datos');
 		$niveles_educativos = $empleados->groupBy('nivel_educativo')->sortKeys()->keys();
 		$filas_horas = [
    		'Tiempo completo' => [40,168], 'Tres cuartos de tiempo' => [21,39], 
    		'Medio tiempo' => [20, 20.5], 'Por horas' => [1, 19],
    	];
		$filas_por_horas = [
    		'1 a 4 horas' => [1,4], '5 a 8 horas' => [5,8], 
    		'9 a 12 horas' => [9, 12], '13 a 16 horas' => [13, 16],
			'17 a 20 horas' => [17, 19], 'Más de 20 horas' => [19, 19],
    	];

    	// Contenido Documento
    	$word = new PhpWord();
    	$nombreArchivo = "Estadistica-Maestros-{$info['cicloEscolar']}.docx";
    	$word->addTableStyle('tabla_normal', $estilo_tabla);

    	$seccion = $word->addSection();
    	$seccion->addText($info['ubicacion'], $titulo, $centrado);
    	if($info['departamento']) 
    		$seccion->addText($info['departamento'], $subtitulo, $centrado);
    	if($info['escuela'])
    		$seccion->addText($info['escuela'], $subtitulo, $centrado);
    	if($info['programa'])
    		$seccion->addText($info['programa'], $subtitulo, $centrado);

    	$seccion->addText('');
    	$seccion->addText('Total de personal docente, desglose por nivel de estudios y sexo.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$columnas = ['Personal', 'Hombres', 'Mujeres', 'Sin datos', 'Total'];
    	foreach ($columnas as $columna) {
    		$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    	}
    	foreach ($niveles_educativos as $nivel) {
    		$empleados_nivel = $empleados->where('nivel_educativo', $nivel);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($nivel);
    		$hombres = $empleados_nivel->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $empleados_nivel->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$sin_datos = $empleados_nivel->whereNotIn('sexo', ['M', 'F'])->count();
    		$tabla->addCell(2000)->addText($sin_datos);
    		$total = $empleados_nivel->count();
    		$tabla->addCell(2000)->addText($total);
    	}
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	$tabla->addCell(2000)->addText($total_hombres);
    	$tabla->addCell(2000)->addText($total_mujeres);
    	$tabla->addCell(2000)->addText($sin_sexo->count());
    	$tabla->addCell(2000)->addText($total_empleados);

    	$seccion->addText('');
    	$seccion->addText('Total de personal docente, por grupo de edad.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$columnas = ['Grupos de edad', 'Hombres', 'Mujeres', 'Sin datos', 'Total'];
    	foreach ($columnas as $columna) {
    		$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    	}
    	$grupos_edad = [
    		[15,19], [20,24], [25,29], [30,34], [35,39], [40,44], [45, 49], [50,54], [55,59], [60,64], [65,100],
    	];
    	foreach ($grupos_edad as $key => $edades) {
    		$empleados_edades = $empleados->where('edad', '>=', $edades[0])->where('edad', '<=', $edades[1]);
    		$descripcion = ($key != 0 || $key != 10) ? "De {$edades[0]} a {$edades[1]} años" : '';
    		if($key == 0) $descripcion = "Menos de {$edades[1]} años";
    		if($key == 10) $descripcion = "De {$edades[0]} años o más";
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($descripcion);
    		$hombres = $empleados_edades->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $empleados_edades->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$sin_datos = $empleados_edades->whereNotIn('sexo', ['M', 'F'])->count();
    		$tabla->addCell(2000)->addText($sin_datos);
    		$total = $empleados_edades->count();
    		$tabla->addCell(2000)->addText($total);
    	}
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Sin datos');
    	$hombres = $sin_edad->where('sexo', 'M')->count();
    	$tabla->addCell(2000)->addText($hombres);
    	$mujeres = $sin_edad->where('sexo', 'F')->count();
    	$tabla->addCell(2000)->addText($mujeres);
    	$sin_datos = $sin_edad->whereNotIn('sexo', ['M', 'F'])->count();
    	$tabla->addCell(2000)->addText($sin_datos);
    	$tabla->addCell(2000)->addText($sin_edad->count());
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	$tabla->addCell(2000)->addText($total_hombres);
    	$tabla->addCell(2000)->addText($total_mujeres);
    	$tabla->addCell(2000)->addText($sin_sexo->count());
    	$tabla->addCell(2000)->addText($total_empleados);

    	$seccion->addPageBreak();
    	$seccion->addText('Total de personal docente, por rango de antigüedad.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$columnas = ['Antigüedad', 'Hombres', 'Mujeres', 'Sin datos', 'Total'];
    	foreach ($columnas as $columna) {
    		$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    	}
    	$grupos_antiguedad = [
    		[0,4], [5,9], [10,14], [15,19], [20,24], [25,29], [30,100],
    	];
    	foreach($grupos_antiguedad as $key => $antiguedad) {
    		$empleados_antiguedad = $empleados->where('antiguedad', '!=', 'Sin datos')
    		->where('antiguedad', '>=', $antiguedad[0])
    		->where('antiguedad', '<=', $antiguedad[1]);
    		$descripcion = $key != 6 ? "De {$antiguedad[0]} a {$antiguedad[1]} años" : "De {$antiguedad[0]} años o más";
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($descripcion);
    		$hombres = $empleados_antiguedad->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $empleados_antiguedad->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$sin_datos = $empleados_antiguedad->whereNotIn('sexo', ['M', 'F'])->count();
    		$tabla->addCell(2000)->addText($sin_datos);
    		$total = $empleados_antiguedad->count();
    		$tabla->addCell(2000)->addText($total);
    	}
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Sin datos');
    	$sin_datos = $empleados->where('antiguedad', 'Sin datos');
    	$hombres = $sin_datos->where('sexo', 'M')->count();
    	$tabla->addCell(2000)->addText($hombres);
    	$mujeres = $sin_datos->where('sexo', 'F')->count();
    	$tabla->addCell(2000)->addText($mujeres);
    	$no_sexo = $sin_datos->whereNotIn('sexo', ['M', 'F'])->count();
    	$tabla->addCell(2000)->addText($no_sexo);
    	$tabla->addCell(2000)->addText($sin_datos->count());
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	$tabla->addCell(2000)->addText($total_hombres);
    	$tabla->addCell(2000)->addText($total_mujeres);
    	$tabla->addCell(2000)->addText($sin_sexo->count());
    	$tabla->addCell(2000)->addText($total_empleados);

    	$seccion->addText('');
    	$seccion->addText('Total de personal docente, por tiempo de dedicación.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$columnas = ['Tiempo de dedicación', 'Hombres', 'Mujeres', 'Sin datos', 'Total'];
    	foreach($columnas as $columna) {
    		$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    	}
    	foreach ($filas_horas as $descripcion => $horas) {
    		$empleados_horas = $empleados->where('horas', '>=', $horas[0])->where('horas', '<=', $horas[1]);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($descripcion);
    		$hombres = $empleados_horas->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $empleados_horas->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$no_sexo = $empleados_horas->whereNotIn('sexo', ['M', 'F'])->count();
    		$tabla->addCell(2000)->addText($no_sexo);
    		$total = $empleados_horas->count();
    		$tabla->addCell(2000)->addText($total);
    	}
    	$sin_datos = $empleados->where('horas', 0);
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Sin datos');
    	$hombres = $sin_datos->where('sexo', 'M')->count();
    	$tabla->addCell(2000)->addText($hombres);
    	$mujeres = $sin_datos->where('sexo', 'F')->count();
    	$tabla->addCell(2000)->addText($mujeres);
    	$no_sexo = $sin_datos->whereNotIn('sexo', ['M', 'F'])->count();
    	$tabla->addCell(2000)->addText($no_sexo);
    	$tabla->addCell(2000)->addText($sin_datos->count());
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	$tabla->addCell(2000)->addText($total_hombres);
    	$tabla->addCell(2000)->addText($total_mujeres);
    	$tabla->addCell(2000)->addText($sin_sexo->count());
    	$tabla->addCell(2000)->addText($total_empleados);

		$seccion->addText('');
    	$seccion->addText('Personal por hora.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$columnas = ['Tiempo de dedicación', 'Hombres', 'Mujeres', 'Sin datos', 'Total'];
    	foreach($columnas as $columna) {
    		$tabla->addCell(2000)->addText($columna, $tabla_header_fuente, $celda_header);
    	}
		$total_por_hombres = 0;
		$total_por_mujeres = 0;
		$total_por_empleados = 0;
    	foreach ($filas_por_horas as $descripcion => $horas) {
    		$empleados_por_horas = $empleados->where('horas', '>=', $horas[0])->where('horas', '<=', $horas[1]);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($descripcion);
    		$hombres = $empleados_por_horas->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $empleados_por_horas->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
			$no_sexo = $empleados_horas->whereNotIn('sexo', ['M', 'F'])->count();
    		$tabla->addCell(2000)->addText($no_sexo);
    		$total = $empleados_por_horas->count();
    		$tabla->addCell(2000)->addText($total);

			$total_por_hombres += $hombres;
			$total_por_mujeres += $mujeres;
			$total_por_empleados += $total;
    	}
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	$tabla->addCell(2000)->addText($total_por_hombres);
    	$tabla->addCell(2000)->addText($total_por_mujeres);
		$tabla->addCell(2000)->addText($sin_sexo->count());
    	$tabla->addCell(2000)->addText($total_por_empleados);

    	$seccion->addText('');
    	$seccion->addText('Nivel de estudio de personal docente, desglose por tiempo de dedicación.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Tiempo de dedicación', $tabla_header_fuente, $celda_header);
    	foreach($niveles_educativos as $nivel) {
    		$celda = $tabla->addCell(2000);
    		$celda->getStyle()->setGridSpan(2);
    		$celda->addText($nivel, $tabla_header_fuente, $celda_header);
    	}
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Titulado/Graduado', $tabla_header_fuente, $celda_header);
    	foreach($niveles_educativos as $nivel) {
    		$tabla->addCell(2000)->addText('SI', $tabla_header_fuente, $celda_header);
    		$tabla->addCell(2000)->addText('NO', $tabla_header_fuente, $celda_header);
    	}
    	foreach($filas_horas as $descripcion => $horas) {
    		$empleados_horas = $empleados->where('horas', '>=', $horas[0])->where('horas', '<=', $horas[1]);
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($descripcion);
    		foreach($niveles_educativos as $nivel) {
    			$empleados_nivel = $empleados_horas->where('nivel_educativo', $nivel);
    			$titulados_nivel = $empleados_nivel->where('esTitulado', true)->count();
    			$tabla->addCell(2000)->addText($titulados_nivel);
    			$noTitulados_nivel = $empleados_nivel->where('esTitulado', false)->count();
    			$tabla->addCell(2000)->addText($noTitulados_nivel);
    		}# horas
    	}# nivel
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Sin datos');
    	foreach($niveles_educativos as $nivel) {
    		$empleados_nivel = $sin_horas->where('nivel_educativo', $nivel);
    		$titulados_nivel = $empleados_nivel->where('esTitulado', true)->count();
    		$tabla->addCell(2000)->addText($titulados_nivel);
    		$noTitulados_nivel = $empleados_nivel->where('esTitulado', false)->count();
    		$tabla->addCell(2000)->addText($noTitulados_nivel);
    	}
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total');
    	foreach($niveles_educativos as $nivel) {
    		$empleados_nivel = $empleados->where('nivel_educativo', $nivel);
    		$titulados_nivel = $empleados_nivel->where('esTitulado', true)->count();
    		$tabla->addCell(2000)->addText($titulados_nivel);
    		$noTitulados_nivel = $empleados_nivel->where('esTitulado', false)->count();
    		$tabla->addCell(2000)->addText($noTitulados_nivel);
    	}

    	$seccion->addPageBreak();
    	$seccion->addText('Total de personal docente, según el nivel que imparten.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Nivel de estudio', $tabla_header_fuente, $celda_header);
    	$claves_departamentos = ['esDocenteSUP' =>'SUPERIOR', 'esDocentePOS' => 'POSGRADO'];
    	foreach($claves_departamentos as $clave) {
    		$celda = $tabla->addCell(2000);
    		$celda->getStyle()->setGridSpan(3);
    		$celda->addText($clave, $tabla_header_fuente, $celda_header);
    	}
    	foreach($niveles_educativos as $nivel) {
    		$tabla->addRow();
    		$tabla->addCell(2000)->addText($nivel);
    		$empleados_nivel = $empleados->where('nivel_educativo', $nivel);
    		foreach($claves_departamentos as $key => $clave) {
    			$empleados_departamento = $empleados_nivel->where($key, true);
    			$hombres = $empleados_departamento->where('sexo', 'M')->count();
    			$tabla->addCell(2000)->addText($hombres);
    			$mujeres = $empleados_departamento->where('sexo', 'F')->count();
    			$tabla->addCell(2000)->addText($mujeres);
    			$total = $empleados_departamento->count();
    			$tabla->addCell(2000)->addText($total);
    		}# clave
    	}# nivel
    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	foreach($claves_departamentos as $key => $clave) {
    		$empleados_departamento =  $empleados->where($key, true);
    		$hombres = $empleados_departamento->where('sexo', 'M')->count();
    		$tabla->addCell(2000)->addText($hombres);
    		$mujeres = $empleados_departamento->where('sexo', 'F')->count();
    		$tabla->addCell(2000)->addText($mujeres);
    		$tabla->addCell(2000)->addText($empleados_departamento->count());
    	}

    	$seccion->addPageBreak();
    	$seccion->addText('Docentes de los cuales no se encontraron datos de su nivel de estudios.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$tabla->addCell(1000)->addText('id', $tabla_header_fuente, $celda_header);
    	$tabla->addCell(4000)->addText('Nombre Completo', $tabla_header_fuente, $celda_header);
    	if($sin_nivel->isEmpty()) {
    		$tabla->addRow();
    		$tabla->addCell();
    		$tabla->addCell()->addText('*No hay docentes sin nivel educativo*');
    	}
    	foreach($sin_nivel as $docente) {
    		$tabla->addRow();
    		$tabla->addCell(1000)->addText($docente['empleado_id']);
    		$tabla->addCell(4000)->addText($docente['nombreCompleto']);
    	}

    	$seccion->addPageBreak();
    	$seccion->addText('Docentes sin datos de edad.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$tabla->addCell(1000)->addText('id', $tabla_header_fuente, $celda_header);
    	$tabla->addCell(4000)->addText('Nombre Completo', $tabla_header_fuente, $celda_header);
    	if($sin_edad->isEmpty()) {
    		$tabla->addRow();
    		$tabla->addCell();
    		$tabla->addCell()->addText('*No hay docentes sin edad*');
    	}
    	foreach($sin_edad as $docente) {
    		$tabla->addRow();
    		$tabla->addCell(1000)->addText($docente['empleado_id']);
    		$tabla->addCell(4000)->addText($docente['nombreCompleto']);
    	}

    	$seccion->addPageBreak();
    	$seccion->addText('Docentes sin datos de antigüedad.');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$tabla->addCell(1000)->addText('id', $tabla_header_fuente, $celda_header);
    	$tabla->addCell(4000)->addText('Nombre Completo', $tabla_header_fuente, $celda_header);
    	if($sin_antiguedad->isEmpty()) {
    		$tabla->addRow();
    		$tabla->addCell();
    		$tabla->addCell()->addText('*No hay docentes sin datos de antigüedad*');
    	}
    	foreach($sin_antiguedad as $docente) {
    		$tabla->addRow();
    		$tabla->addCell(1000)->addText($docente['empleado_id']);
    		$tabla->addCell(4000)->addText($docente['nombreCompleto']);
    	}

    	$seccion->addPageBreak();
    	$seccion->addText('Docentes que no tienen datos de horas(tiempo de dedicación).');
    	$tabla = $seccion->addTable('tabla_normal');
    	$tabla->addRow();
    	$tabla->addCell(1000)->addText('id', $tabla_header_fuente, $celda_header);
    	$tabla->addCell(4000)->addText('Nombre Completo', $tabla_header_fuente, $celda_header);
    	if($sin_horas->isEmpty()) {
    		$tabla->addRow();
    		$tabla->addCell();
    		$tabla->addCell()->addText('*No hay docentes sin horas*');
    	}
    	foreach($sin_horas as $docente) {
    		$tabla->addRow();
    		$tabla->addCell(1000)->addText($docente['empleado_id']);
    		$tabla->addCell(4000)->addText($docente['nombreCompleto']);
    	}



    	$writer = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
	    try {
	      $writer->save(storage_path($nombreArchivo));
	    } catch (Exception $e) {
	    	alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
	    	return back()->withInput();
	    }

	    return response()->download(storage_path($nombreArchivo));
    }# generarWord

}

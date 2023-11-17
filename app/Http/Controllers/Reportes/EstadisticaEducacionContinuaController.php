<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\InscritosEduCont;

use Exception;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use RealRashid\SweetAlert\Facades\Alert;

class EstadisticaEducacionContinuaController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte(){
    	return view('reportes/estadisticas_estatales.educacion_continua', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'anioActual' => Carbon::now('America/Merida')->year,
    	]);
    }


    public function imprimir(Request $request) {
    	$inscritos = self::buscarInscritos($request);
    	if($inscritos->isEmpty()) return self::alert_verificacion();

    	$this->ubicacion = $inscritos->first()->educacioncontinua->ubicacion;
    	$this->perAnio = $request->perAnio;
    	$estadisticas = self::obtenerEstadisticas($inscritos);

    	return $this->generarWord($estadisticas);
    }


    /**
    * @param Illuminate\Http\Request
    */
    private static function buscarInscritos($request)
    {
    	return InscritosEduCont::with(['educacioncontinua.tipoprograma', 'alumno.persona'])
    	->whereHas('educacioncontinua.periodo.departamento.ubicacion', static function($query) use ($request) {
    		$query->where('ubicacion_id', $request->ubicacion_id);
    		$query->where('perAnio', $request->perAnio);
    	})->get();
    }


    /**
    * Alert, en caso de no encontrar datos.
    */
    private static function alert_verificacion() {
    	alert('Sin Coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
    	return back()->withInput();
    }


    /**
    * @param Collection
    */
    private static function obtenerEstadisticas($inscritos)
    {
    	$tipos_programas = self::obtenerInfoPorTipoPrograma($inscritos);

    	return collect([
    		'tipos_programas' => $tipos_programas,
    		'total_programas' => $tipos_programas->sum('cantidad_programas'),
    		'total_inscritos' => $tipos_programas->sum('inscritos'),
    		'total_mujeres' => $tipos_programas->sum('mujeres'),
    		'total_hombres' => $tipos_programas->sum('hombres'),
    	]);
    }


    /**
    * @param Collection
    */
    private static function obtenerInfoPorTipoPrograma($inscritos): Collection
    {
    	return $inscritos->groupBy('educacioncontinua.tipoprograma.tpNombre')
    	->map(static function($inscritos) {
    		$tipo_programa = $inscritos->first()->educacioncontinua->tipoprograma;

    		return collect([
    			'tipo_nombre' => $tipo_programa->tpNombre,
    			'cantidad_programas' => $inscritos->groupBy('educacioncontinua_id')->count(),
    			'inscritos' => $inscritos->count(),
    			'mujeres' => $inscritos->where('alumno.persona.perSexo', 'F')->count(),
    			'hombres' => $inscritos->where('alumno.persona.perSexo', 'M')->count(),
    		]);
    	})->keyBy('tipo_nombre')->sortKeys();
    }


    /**
    * @param Collection
    */
    private function generarWord($estadisticas)
    {
    	// Estilos fuente -------------------------------
    	$titulo = ['size' => 15, 'bold' => true];
    	$subtitulo = ['size' => 14];
    	$tabla_header_fuente = ['bold' => true];

    	// Estilos párrafo ------------------------------
    	$centrado = ['align' => 'center'];

    	// Estilos tabla --------------------------------
    	$estilo_tabla = array('borderSize' => 6, 'borderColor' => '999999','marginBottom' => 10);
    	$celda_header = ['bgColor' => 'D2D2D2'];

    	// Info Documento
    	$ciclo_escolar = $this->perAnio.'-'.($this->perAnio + 1);
    	$tipos_programas = $estadisticas['tipos_programas'];

    	// Documento Contenido --------------------------
    	$word = new PhpWord();
    	$nombreArchivo = "Estadistica-EducacionContinua-{$ciclo_escolar}.docx";

    	$info = $word->addSection();
    	$info->addText("Estadística de Educación Superior, por Institución", $titulo, $centrado);
    	$info->addText("Ciclo Escolar: {$ciclo_escolar}", $subtitulo, $centrado);

    	$word->addTableStyle('Estadisticas', $estilo_tabla);
    	$tabla = $info->addTable('Estadisticas');

    	$columnas_estadisticas = ['Tipo Programa', 'Cantidad programas', 'Hombres', 'Mujeres', 'Total Inscritos'];
    	$tabla->addRow();
    	foreach ($columnas_estadisticas as $columna) {
    		$tabla->addCell(2000, $celda_header)->addText($columna, $tabla_header_fuente, $centrado);
    	}

    	$valores = ['tipo_nombre', 'cantidad_programas', 'hombres', 'mujeres', 'inscritos'];
    	foreach ($tipos_programas as $tipo_programa) {
    		$tabla->addRow();
    		foreach($valores as $valor) {
    			$tabla->addCell(2000)->addText($tipo_programa[$valor]);
    		}
    	}

    	$tabla->addRow();
    	$tabla->addCell(2000)->addText('Total', $tabla_header_fuente);
    	$totales = ['total_programas', 'total_hombres', 'total_mujeres', 'total_inscritos'];
    	foreach($totales as $total) {
    		$tabla->addCell(2000)->addText($estadisticas[$total], $tabla_header_fuente);
    	}

    	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
	    try {
	      $objWriter->save(storage_path($nombreArchivo));
	    } catch (Exception $e) {
	      alert('Ha ocurrido un problema.', $e->getMessage(), 'error')->showConfirmButton();
	      return back()->withInput();
	    }

	    return response()->download(storage_path($nombreArchivo));
    }# generarWord
}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Curso;
use App\Models\Pago;
use App\Models\Ficha;
use App\Http\Helpers\UltimaFechaPago;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ResumenAntiguedadController extends Controller
{
	protected $periodo;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:resumen_antiguedad']);
    }

    public function reporte()
    {
    	return view('reportes/resumen_antiguedad.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	$this->periodo = Periodo::findOrFail($request->periodo_id);
    	$cursos = $this->buscarCursos($request);
    	if($cursos->isEmpty()) return self::alert_verificacion();

    	$cursos = $this->quienes_adeudan_inscripcion($cursos);
    	if($cursos->isEmpty()) return self::alert_verificacion();

    	$fichas = self::buscarAntiguedad($cursos);
    	$programas = self::clasificarRangosDeAntiguedadPorPrograma($cursos, $fichas);

    	return self::generarExcel($programas);
    }

    private static function alert_verificacion()
    {
    	alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar', 'warning')->showConfirmButton();
    	return back()->withInput();
    }

    /**
	* @param Illuminate\Http\Request
    */
    private function buscarCursos($request): Collection
    {
    	$cursos = new Collection;
    	Curso::with(['alumno', 'cgt.plan.programa'])
    	->where('periodo_id', $this->periodo->id)
    	->where('curTipoIngreso', 'PI')
    	->whereHas('cgt', static function($query) {
    		$query->where('cgtGradoSemestre', 1);
    	})
    	->chunk(200, static function($registros) use ($cursos) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(static function($curso) use ($cursos) {
    			$programa = $curso->cgt->plan->programa;

    			$cursos->push([
    				'aluClave' => $curso->alumno->aluClave,
    				'progClave' => $programa->progClave,
    				'progNombre' => $programa->progNombre,
    				'curFechaRegistro' => $curso->curFechaRegistro,
    				'curso_antiguedad' => Carbon::parse($curso->curFechaRegistro)->diffInDays(Carbon::now()),
    			]);
    		});
    	});

    	return $cursos->keyBy('aluClave');
    }

    /**
	* @param Illuminate\Support\Collection
    */
    private function quienes_adeudan_inscripcion($cursos): Collection
    {
    	Pago::whereIn('pagClaveAlu', $cursos->keys())
    	->where('pagConcPago', '99')
    	->where('pagAnioPer', $this->periodo->perAnioPago)
    	->chunk(200, static function($registros) use ($cursos) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(static function($pago) use($cursos) {
    			$cursos->forget($pago->pagClaveAlu);
    		});
    	});

    	return $cursos;
    }

    /**
    * Solo devuelve los datos de la ficha más reciente por cada clave de alumno.
    *
	* @param Illuminate\Support\Collection
    */
    private static function buscarAntiguedad($cursos): Collection
    {
    	$fichas = new Collection;
    	Ficha::whereIn('fchClaveAlu', $cursos->keys())
    	->where('fchConc', '99')
    	->oldest('fchFechaImpr')
    	->chunk(200, static function($registros) use ($fichas, $cursos) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(static function($ficha) use ($fichas, $cursos) {
    			$curso = $cursos->get($ficha->fchClaveAlu) ?: false;

    			$fichas->push([
    				'aluClave' => $ficha->fchClaveAlu,
    				'fecha_impresion' => $ficha->fchFechaImpr,
    				'ficha_antiguedad' => Carbon::parse($ficha->fchFechaImpr)->diffInDays(Carbon::now()),
    			]);
    		});
    	});

    	return $fichas->keyBy('aluClave');
    }

    /**
	* @param Collection $cursos
	* @param Collection $fichas
    */
    private static function clasificarRangosDeAntiguedadPorPrograma($cursos, $fichas): Collection
    {
    	return $cursos->map(static function($curso) use ($fichas) {
    		$ficha = $fichas->pull($curso['aluClave']);
    		$antiguedad = $ficha ? $ficha['ficha_antiguedad'] : $curso['curso_antiguedad'];

    		return collect($curso)->put('antiguedad', $antiguedad);
    	})
    	->groupBy('progClave')
    	->map(static function($cursos_programa) {
    		$info = $cursos_programa->first();

    		return collect([
    			'progClave' => $info['progClave'],
    			'progNombre' => $info['progNombre'],
    			'dias_0_15' => $cursos_programa->where('antiguedad', '>=', 0)->where('antiguedad', '<', 16)->count(),
    			'dias_16_30' => $cursos_programa->where('antiguedad', '>', 15)->where('antiguedad', '<', 31)->count(),
    			'dias_30_mas' => $cursos_programa->where('antiguedad', '>', 30)->count(),
    		]);
    	})->sortBy('progClave');
    }

    /**
	* @param Collection
    */
    private static function generarExcel($programas)
    {
    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	$sheet->getStyle('A2:G2')->getFont()->setBold(true);
    	$sheet->getColumnDimension('A')->setAutoSize(true);
    	$sheet->getColumnDimension('B')->setAutoSize(true);
    	$sheet->getColumnDimension('C')->setAutoSize(true);
    	$sheet->getColumnDimension('D')->setAutoSize(true);
    	$sheet->getColumnDimension('E')->setAutoSize(true);
    	$sheet->getColumnDimension('F')->setAutoSize(true);
    	$sheet->getColumnDimension('G')->setAutoSize(true);
    	$sheet->setCellValueByColumnAndRow(1, 2, "Clave");
    	$sheet->setCellValueByColumnAndRow(2, 2, "Programa");
    	$sheet->setCellValueByColumnAndRow(3, 2, "0d - 15d");
    	$sheet->setCellValueByColumnAndRow(4, 2, "16d - 30d");
    	$sheet->setCellValueByColumnAndRow(5, 2, "+30d");
    	$sheet->setCellValueByColumnAndRow(6, 2, "Pagos hasta:");
    	$sheet->setCellValueByColumnAndRow(7, 2, UltimaFechaPago::ultimoPago());

    	$fila = 3;
    	foreach ($programas as $key => $programa) {
    	    $sheet->setCellValueExplicit("A{$fila}", $programa['progClave'], DataType::TYPE_STRING);
    	    $sheet->setCellValue("B{$fila}", $programa['progNombre']);
    	    $sheet->setCellValue("C{$fila}", $programa['dias_0_15']);
    	    $sheet->setCellValue("D{$fila}", $programa['dias_16_30']);
    	    $sheet->setCellValue("E{$fila}", $programa['dias_30_mas']);
    	    $fila++;
    	}

    	$writer = new Xlsx($spreadsheet);
    	try {
    	    $writer->save(storage_path("ResumenAntiguedad.xlsx"));
    	} catch (Exception $e) {
    	    alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
    	    return back()->withInput();
    	}

    	return response()->download(storage_path("ResumenAntiguedad.xlsx"));
    }
}

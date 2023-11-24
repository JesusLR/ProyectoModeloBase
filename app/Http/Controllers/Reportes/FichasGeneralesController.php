<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Ficha;
use App\Models\Curso;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class FichasGeneralesController extends Controller
{
	public $fichas;
	public $ubicacion;
	public $datos;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:fichas_generales']);
    	$this->fichas = new Collection;
    	$this->datos = new Collection;
    }

    public function reporte()
    {
    	return view('reportes/fichas_generales.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    		'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
    	]);
    }

    public function imprimir(Request $request)
    {
    	$this->ubicacion = Ubicacion::findOrFail($request->ubicacion_id);

    	Ficha::with(['usuario','alumno.persona'])
        ->has('alumno')
    	->whereBetween('fchFechaImpr', [$request->fecha1, $request->fecha2])
    	->chunk(200, function($registros) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(function($ficha) {
    			$this->fichas->push(self::info_esencial_ficha($ficha));
    		});
    	});

    	if($this->fichas->isEmpty())
    		return self::alert_verificacion();

    	$this->fichas = $this->fichas->keyBy('key_ficha');

    	Curso::with(['cgt.plan.programa', 'periodo'])
    	->whereIn('alumno_id', $this->fichas->pluck('alumno_id')->unique())
    	->whereHas('periodo.departamento', function($query) use ($request) {
    		$query->where('ubicacion_id', $this->ubicacion->id);
    		$query->whereIn('perAnio', $this->fichas->pluck('perAnio')->unique());
    	})
    	->chunk(100, function($registros) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(function($curso) {
    			$info = self::info_esencial_curso($curso);
    			$ficha = $this->fichas->pull($info["key_curso"]);
    			if($ficha) {
    				$orden = "{$ficha["username"]}-{$this->ubicacion->ubiClave}-{$info["escClave"]}-{{$info["progClave"]}}-{$ficha["nombreCompleto"]}-{$ficha["fecha_impresion"]}";
    				array_forget($info, "key_curso");
    				$this->datos->push($info + $ficha + ['orden' => $orden]);
    			}
    		});
    	});

    	if($this->datos->isEmpty())
    		return self::alert_verificacion();

    	return $this->generarExcel();
    }

    private static function alert_verificacion()
    {
    	alert('Sin coincidencias', 'No se encontraron datos con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
    	return back()->withInput();
    }

    /**
	* @param App\Models\Ficha
    */
    private static function info_esencial_ficha($ficha)
    {
    	$alumno = $ficha->alumno;
    	$usuario = $ficha->usuario;
    	$nombreCompleto = MetodosPersonas::nombreCompleto($alumno->persona, true);

    	return [
    		'alumno_id' => $alumno->id,
    		'username' => $usuario->username,
    		'aluClave' => $alumno->aluClave,
    		'nombreCompleto' => $nombreCompleto,
    		'perNumero' => $ficha->fchNumPer,
    		'perAnio' => $ficha->fchAnioPer,
    		'semestre' => $ficha->fchGradoSem,
    		'grupo' => $ficha->fchGrupo,
    		'fecha_impresion' => Carbon::parse($ficha->fchFechaImpr)->format('d/m/Y'),
    		'fchTipo' => $ficha->fchTipo,
    		'concepto' => $ficha->fchConc,
    		'referencia' => $ficha->fhcRef1,
    		'vencimiento' => Carbon::parse($ficha->fchFechaVenc1)->format('d/m/Y'),
    		'importe' => $ficha->fhcImp1,
    		'key_ficha' => "{$alumno->id}-{$ficha->fchNumPer}-{$ficha->fchAnioPer}-{$ficha->fchGradoSem}-{$ficha->fchGrupo}",
    	];
    }

    /** 
	* @param App\Models\Curso
    */
    private static function info_esencial_curso($curso)
    {
    	$cgt = $curso->cgt;
    	$programa = $cgt->plan->programa;
    	$escuela = $programa->escuela;
    	$periodo = $curso->periodo;
    	return [
    		'key_curso' => "{$curso->alumno_id}-{$periodo->perNumero}-{$periodo->perAnio}-{$cgt->cgtGradoSemestre}-{$cgt->cgtGrupo}",
    		'progClave' => $programa->progClave,
    		'escClave' => $escuela->escClave,
    	];
    }

    private function generarExcel()
    {
    	$this->datos = $this->datos->sortBy('orden');

    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A2:P2')->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Username");
        $sheet->setCellValueByColumnAndRow(2, 2, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(3, 2, "Alumno");
        $sheet->setCellValueByColumnAndRow(4, 2, "Periodo");
        $sheet->setCellValueByColumnAndRow(5, 2, "Año");
        $sheet->setCellValueByColumnAndRow(6, 2, "Ubi");
        $sheet->setCellValueByColumnAndRow(7, 2, "Esc");
        $sheet->setCellValueByColumnAndRow(8, 2, "Prog");
        $sheet->setCellValueByColumnAndRow(9, 2, "Semestre");
        $sheet->setCellValueByColumnAndRow(10, 2, "Grupo");
        $sheet->setCellValueByColumnAndRow(11, 2, "Fecha Impresión");
        $sheet->setCellValueByColumnAndRow(12, 2, "Edo");
        $sheet->setCellValueByColumnAndRow(13, 2, "Concepto");
        $sheet->setCellValueByColumnAndRow(14, 2, "Referencia");
        $sheet->setCellValueByColumnAndRow(15, 2, "Vencimiento");
        $sheet->setCellValueByColumnAndRow(16, 2, "Importe");

        $fila = 3;
        foreach ($this->datos as $key => $ficha) {
            $sheet->setCellValue("A{$fila}", $ficha['username']);
            $sheet->setCellValue("B{$fila}", $ficha['aluClave']);
            $sheet->setCellValue("C{$fila}", $ficha['nombreCompleto']);
            $sheet->setCellValue("D{$fila}", $ficha['perNumero']);
            $sheet->setCellValue("E{$fila}", $ficha['perAnio']);
            $sheet->setCellValue("F{$fila}", $this->ubicacion->ubiClave);
            $sheet->setCellValue("G{$fila}", $ficha['escClave']);
            $sheet->setCellValue("H{$fila}", $ficha['progClave']);
            $sheet->setCellValue("I{$fila}", $ficha['semestre']);
            $sheet->setCellValue("J{$fila}", $ficha['grupo']);
            $sheet->setCellValue("K{$fila}", $ficha['fecha_impresion']);
            $sheet->setCellValue("L{$fila}", $ficha['fchTipo']);
            $sheet->setCellValueExplicit("M{$fila}", $ficha['concepto'], DataType::TYPE_STRING);
            $sheet->setCellValue("N{$fila}", "{$ficha['referencia']}");
            $sheet->setCellValue("O{$fila}", $ficha['vencimiento']);
            $sheet->setCellValue("P{$fila}", $ficha['importe']);
            $fila++;
        }

    	$writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("FichasGenerales.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("FichasGenerales.xlsx"));
    }
}

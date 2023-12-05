<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ficha;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FichasDeCobranzaController extends Controller
{
	public $fichas;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:fichas_de_cobranza']);
    	$this->fichas = new Collection;
    }

    public function reporte()
    {
    	return view('reportes/fichas_de_cobranza.create', ['hoy' => Carbon::now('America/Merida')->format('Y-m-d')]);
    }

    public function imprimir(Request $request)
    {
    	Ficha::with(['usuario','alumno.persona'])
    	->whereHas('usuario', static function($query) {
    		$query->whereIn('username', ['MCUEVAS', 'FLOPEZH', 'NLOPEZ', 'MERCEDES']);
    	})
    	->whereBetween('fchFechaImpr', [$request->fecha1, $request->fecha2])
    	->chunk(100, function($registros) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(function($ficha) {
    			$this->fichas->push(self::info_esencial($ficha));
    		});
    	});

    	if($this->fichas->isEmpty()) {
    		alert('Sin coincidencias', 'No se encontraron datos con la información proporcionada. Favor de verificar.', 'warning')
    		->showConfirmButton();
    		return back()->withInput();
    	}
    	$this->fichas = $this->fichas->sortBy('orden');

    	return $this->generarExcel();
    	
    }

    /**
	* @param App\Models\Ficha
    */
    private static function info_esencial($ficha)
    {
    	$alumno = $ficha->alumno;
    	$usuario = $ficha->usuario;
    	$nombreCompleto = MetodosPersonas::nombreCompleto($alumno->persona, true);

    	return [
    		'username' => $usuario->username,
    		'aluClave' => $alumno->aluClave,
    		'nombreCompleto' => $nombreCompleto,
    		'perNumero' => $ficha->fchNumPer,
    		'perAnio' => $ficha->fchAnioPer,
    		'semestre' => $ficha->fchGradoSem,
    		'grupo' => $ficha->fchGrupo,
    		'fecha_impresion' => $ficha->fchFechaImpr,
    		'concepto' => $ficha->fchConc,
    		'referencia' => $ficha->fhcRef1,
    		'vencimiento' => $ficha->fchFechaVenc1,
    		'importe' => $ficha->fhcImp1,
    		'orden' => "{$usuario->username}-{$nombreCompleto}-{$ficha->fchFechaImpr}",
    	];
    }


    private function generarExcel()
    {
    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A2:L2')->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Username");
        $sheet->setCellValueByColumnAndRow(2, 2, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(3, 2, "Alumno");
        $sheet->setCellValueByColumnAndRow(4, 2, "Periodo");
        $sheet->setCellValueByColumnAndRow(5, 2, "Año");
        $sheet->setCellValueByColumnAndRow(6, 2, "Semestre");
        $sheet->setCellValueByColumnAndRow(7, 2, "Grupo");
        $sheet->setCellValueByColumnAndRow(8, 2, "Fecha Impresión");
        $sheet->setCellValueByColumnAndRow(9, 2, "Concepto");
        $sheet->setCellValueByColumnAndRow(10, 2, "Referencia");
        $sheet->setCellValueByColumnAndRow(11, 2, "Vencimiento");
        $sheet->setCellValueByColumnAndRow(12, 2, "Importe");

        $fila = 3;
        foreach ($this->fichas as $key => $ficha) {
            $sheet->setCellValue("A{$fila}", $ficha['username']);
            $sheet->setCellValue("B{$fila}", $ficha['aluClave']);
            $sheet->setCellValue("C{$fila}", $ficha['nombreCompleto']);
            $sheet->setCellValue("D{$fila}", $ficha['perNumero']);
            $sheet->setCellValue("E{$fila}", $ficha['perAnio']);
            $sheet->setCellValue("F{$fila}", $ficha['semestre']);
            $sheet->setCellValue("G{$fila}", $ficha['grupo']);
            $sheet->setCellValue("H{$fila}", $ficha['fecha_impresion']);
            $sheet->setCellValue("I{$fila}", $ficha['concepto']);
            $sheet->setCellValue("J{$fila}", "{$ficha['referencia']}");
            $sheet->setCellValue("K{$fila}", $ficha['vencimiento']);
            $sheet->setCellValue("L{$fila}", $ficha['importe']);
            $fila++;
        }

    	$writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("FichasDeCobranza.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("FichasDeCobranza.xlsx"));
    }
}

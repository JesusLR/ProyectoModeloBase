<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BachillerMejorPromedioTotalController extends Controller
{
    //
    public function __connstruct() {
    	$this->middleware('auth');
    }

    public function reporte() {
    	$ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
    	return view('bachiller.reportes.mejor_promedio_total.create', compact('ubicaciones'));
    }

    public function imprimir(Request $request) {

    	$fechaActual = Carbon::now('America/Merida');

    	$periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
    	$departamento = $periodo->departamento;
    	$ubicacion = $departamento->ubicacion;
    	$escClave = $request->escClave ?: '';
    	$progClave = $request->progClave ?: '';
    	$planClave = $request->planClave ?: '';
    	$cgtGradoSemestre = $request->cgtGradoSemestre ?: '';
    	$cgtGrupo = $request->cgtGrupo ?: '';

    	$parametros = array(
    		"'{$periodo->perNumero}'",
    		"'{$periodo->perAnio}'",
    		"'{$ubicacion->ubiClave}'",
    		"'{$departamento->depClave}'",
    		"'{$escClave}'",
    		"'{$progClave}'",
    		"'{$planClave}'",
    		"'{$cgtGradoSemestre}'",
    		"'{$cgtGrupo}'"
    	);
    	$parametros = implode(",", $parametros);

    	$promedios = DB::select('call procBachillerMejoresPromediosTotal('.$parametros.')');
    	$promedios = collect($promedios);
    	if($promedios->isEmpty()) {
    		alert()->warning('Sin Registros', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$promedios = $promedios->sortByDesc('resPromedio')->groupBy(['progClave', 'cgtGradoSemestre']);

    	$perFechaInicial = Carbon::parse($periodo->perFechaInicial)->format('d/m/Y');
    	$perFechaFinal = Carbon::parse($periodo->perFechaFinal)->format('d/m/Y');

	    $nombreArchivo = 'pdf_mejor_promedio_total';
        $info_reporte = [
          "promedios" => $promedios,
          "fechaActual" => $fechaActual->format('d/m/Y'),
          "horaActual" => $fechaActual->format('H:i:s'),
          "periodo" => $perFechaInicial.' - '.$perFechaFinal,
          "ubicacion" => $ubicacion,
          "nombreArchivo" => $nombreArchivo,
        ];

	    return $request->formato == 'PDF' ? 
            PDF::loadView('reportes.pdf.'. $nombreArchivo, $info_reporte)->stream($nombreArchivo.'.pdf') : self::generarExcel($info_reporte);
    } //imprimir

    /**
    * @param Array
    */
    private static function generarExcel($info_reporte)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $fila = 1;
        foreach($info_reporte['promedios'] as $programa) {

            foreach ($programa->sortKeys() as $key => $grado) {
                $info = $grado->first();
                $fila++;

                $sheet->mergeCells("A{$fila}:E{$fila}");
                $sheet->getStyle("A{$fila}:E{$fila}")->getFont()->setBold(true);
                $sheet->setCellValue("A{$fila}", "{$info->progClave} ({$info->planClave}) {$info->progNombre} {$info->cgtGradoSemestre}° Grado | No. créditos del plan: {$info->planNumCreditos}");
                $fila++;

                $sheet->getStyle("A{$fila}:E{$fila}")->getFont()->setBold(true);
                $sheet->setCellValue("A{$fila}", "Clave pago");
                $sheet->setCellValue("B{$fila}", "Nombre del alumno");
                $sheet->setCellValue("C{$fila}", "Promedio");
                $sheet->setCellValue("D{$fila}", "Cred.Aprobados");
                $sheet->setCellValue("E{$fila}", "Cred.Cursados");
                $fila++;

                foreach($grado as $alumno) {
                    $sheet->setCellValueExplicit("A{$fila}", $alumno->aluClave, DataType::TYPE_STRING);
                    $sheet->setCellValue("B{$fila}", $alumno->aluNombre);
                    $sheet->setCellValue("C{$fila}", $alumno->resPromedio);
                    $sheet->setCellValue("D{$fila}", $alumno->resCreditosAprobados);
                    $sheet->setCellValue("E{$fila}", $alumno->resCreditosCursados);
                    $fila++;
                }
            }

        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("MejorPromedioTotal.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("MejorPromedioTotal.xlsx"));
    }
}

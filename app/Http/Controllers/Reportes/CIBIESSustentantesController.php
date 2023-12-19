<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class CIBIESSustentantesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permisos:cibies_nuevo_ingreso']);
    }

    public function reporte()
    {
        return view('reportes/cibies_sustentantes.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'anio' => Carbon::now('America/Merida')->year,
        ]);
    }

    public function imprimir(Request $request)
    {

        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $anio = $request->anio;

        $datos = DB::select("call procCibiesSustentantes (
            '".$anio."',
            '".$ubicacion->ubiClave."'
        )");

        return $this->generarExcel($datos, $anio, $ubicacion->ubiClave);
    }

    public function generarExcel($info_reporte, $anio, $ubiClave) {


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();



        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);

        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('H2')->getFont()->setBold(true);
        $sheet->getStyle('K2')->getFont()->setBold(true);
        $sheet->getStyle('N2')->getFont()->setBold(true);
        $sheet->getStyle('Q2')->getFont()->setBold(true);
        $sheet->getStyle('T2')->getFont()->setBold(true);

        $ante = $anio-1;
        $sheet->setCellValue('A1', "{$ubiClave} {$ante}-{$anio}");
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('left');


        $sheet->setCellValue('A2', 'Programa');
        $sheet->setCellValue('B2', 'Acuerdo');
        $sheet->setCellValue('C2', 'Sust '. $ante .' Hombre');
        $sheet->setCellValue('D2', 'Sust ' .$ante .' Mujer');
        $sheet->setCellValue('E2', 'Sust '.$ante. ' Total');
        $sheet->setCellValue('F2', 'Adm '. $ante. ' Hombre');
        $sheet->setCellValue('G2', 'Adm '. $ante. ' Mujer');
        $sheet->setCellValue('H2', 'Adm '.$ante. ' Total');
        $sheet->setCellValue('I2', 'NA ' .$ante. ' Hombre');
        $sheet->setCellValue('J2', 'NA ' .$ante. ' Mujer');
        $sheet->setCellValue('K2', 'NA ' .$ante. ' Total');
        $sheet->setCellValue('L2', 'Sust '. $anio . ' Hombre');
        $sheet->setCellValue('M2', 'Sust '. $anio . ' Mujer');
        $sheet->setCellValue('N2', 'Sust '. $anio . ' Total');
        $sheet->setCellValue('O2', 'Adm '. $anio . ' Hombre');
        $sheet->setCellValue('P2', 'Adm '. $anio . ' Mujer');
        $sheet->setCellValue('Q2', 'Adm '. $anio . ' Total');
        $sheet->setCellValue('R2', 'NA '. $anio . ' Hombre');
        $sheet->setCellValue('S2', 'NA '. $anio . ' Mujer');
        $sheet->setCellValue('T2', 'NA '. $anio . ' Total');


        $fila = 3;
        foreach($info_reporte AS $value) {
            $sheet->setCellValueExplicit("A{$fila}", $value->programa, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}" , $value->acuerdo);
            $sheet->setCellValue("C{$fila}", $value->antSustH);
            $sheet->setCellValue("D{$fila}", $value->antSustM);
            $sheet->setCellValue("E{$fila}", $value->antSustT);
            $sheet->setCellValue("F{$fila}", $value->antAdmH);
            $sheet->setCellValue("G{$fila}", $value->antAdmM);
            $sheet->setCellValue("H{$fila}", $value->antAdmT);
            $sheet->setCellValue("I{$fila}", $value->antNAH);
            $sheet->setCellValue("J{$fila}", $value->antNAM);
            $sheet->setCellValue("K{$fila}", $value->antNAT);
            $sheet->setCellValue("L{$fila}", $value->actSustH);
            $sheet->setCellValue("M{$fila}", $value->actSustM);
            $sheet->setCellValue("N{$fila}", $value->actSustT);
            $sheet->setCellValue("O{$fila}", $value->actAdmH);
            $sheet->setCellValue("P{$fila}", $value->actAdmM);
            $sheet->setCellValue("Q{$fila}", $value->actAmdT);
            $sheet->setCellValue("R{$fila}", $value->actNAH);
            $sheet->setCellValue("S{$fila}", $value->actNAM);
            $sheet->setCellValue("T{$fila}", $value->actNAT);

            $spreadsheet->getActiveSheet()->getStyle('B'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('C'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('D'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('E'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('F'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('G'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('H'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('I'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('J'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('K'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('L'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('M'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('N'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('O'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('P'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('Q'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('R'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('S'.$fila.'')->getAlignment()->setHorizontal('right');
            $spreadsheet->getActiveSheet()->getStyle('T'.$fila.'')->getAlignment()->setHorizontal('right');

            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CIBIESSustentantes.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CIBIESSustentantes.xlsx"));
    }
}

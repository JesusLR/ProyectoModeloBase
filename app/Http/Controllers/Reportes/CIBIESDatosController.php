<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CIBIESDatosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    //   $this->middleware('permisos:r_inscrito_preinscrito');
    }

    public function reporte()
    {

      $ubicaciones = Ubicacion::where('id', '<>', 0)->get();

      return view('reportes.cibies_datos.create',compact('ubicaciones'));
    }

    public function imprimir(Request $request)
    {

        $ubicacion = Ubicacion::find($request->ubicacion_id);
        $departamento = Departamento::find($request->departamento_id);
        $periodo = Periodo::find($request->periodo_id);


        $datos = DB::select("call procCibiesDatos (
            ".$periodo->perNumero.",
            ".$periodo->perAnio.",
            '".$ubicacion->ubiClave."',
            '".$departamento->depClave."'
        )");

        return $this->generarExcel($datos);
    }

    public function generarExcel($info_reporte) {


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();




        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);


        // $sheet->getColumnDimension('C')->setAutoSize(true);
        // $sheet->getColumnDimension('D')->setAutoSize(true);
        // $sheet->getColumnDimension('E')->setAutoSize(true);
        // $sheet->getColumnDimension('F')->setAutoSize(true);
        // $sheet->getColumnDimension('G')->setAutoSize(true);
        // $sheet->getColumnDimension('H')->setAutoSize(true);
        // $sheet->getColumnDimension('I')->setAutoSize(true);
        // $sheet->getColumnDimension('J')->setAutoSize(true);
        // $sheet->getColumnDimension('K')->setAutoSize(true);
        // $sheet->getColumnDimension('L')->setAutoSize(true);
        // $sheet->getColumnDimension('M')->setAutoSize(true);
        // $sheet->getColumnDimension('N')->setAutoSize(true);
        // $sheet->getColumnDimension('O')->setAutoSize(true);
        // $sheet->getColumnDimension('P')->setAutoSize(true);
        // $sheet->getColumnDimension('Q')->setAutoSize(true);
        // $sheet->getColumnDimension('R')->setAutoSize(true);
        // $sheet->getColumnDimension('S')->setAutoSize(true);
        // $sheet->getColumnDimension('T')->setAutoSize(true);
        // $sheet->getColumnDimension('U')->setAutoSize(true);
        // $sheet->getColumnDimension('V')->setAutoSize(true);
        // $sheet->getColumnDimension('W')->setAutoSize(true);
        // $sheet->getColumnDimension('X')->setAutoSize(true);
        // $sheet->getColumnDimension('Y')->setAutoSize(true);
        // $sheet->getColumnDimension('Z')->setAutoSize(true);
        // $sheet->getColumnDimension('AA')->setAutoSize(true);
        // $sheet->getColumnDimension('AB')->setAutoSize(true);
        // $sheet->getColumnDimension('AC')->setAutoSize(true);
        // $sheet->getColumnDimension('AD')->setAutoSize(true);
        // $sheet->getColumnDimension('AE')->setAutoSize(true);
        // $sheet->getColumnDimension('AF')->setAutoSize(true);
        // $sheet->getColumnDimension('AG')->setAutoSize(true);
        // $sheet->getColumnDimension('AH')->setAutoSize(true);
        // $sheet->getColumnDimension('AI')->setAutoSize(true);
        // $sheet->getColumnDimension('AJ')->setAutoSize(true);
        // $sheet->getColumnDimension('AK')->setAutoSize(true);
        // $sheet->getColumnDimension('AL')->setAutoSize(true);
        // $sheet->getColumnDimension('AM')->setAutoSize(true);
        // $sheet->getColumnDimension('AN')->setAutoSize(true);
        // $sheet->getColumnDimension('AO')->setAutoSize(true);
        // $sheet->getColumnDimension('AP')->setAutoSize(true);
        // $sheet->getColumnDimension('AQ')->setAutoSize(true);
        // $sheet->getColumnDimension('AR')->setAutoSize(true);
        // $sheet->getColumnDimension('AS')->setAutoSize(true);
        // $sheet->getColumnDimension('AT')->setAutoSize(true);
        // $sheet->getColumnDimension('AU')->setAutoSize(true);
        // $sheet->getColumnDimension('AV')->setAutoSize(true);
        // $sheet->getColumnDimension('AW')->setAutoSize(true);
        // $sheet->getColumnDimension('AX')->setAutoSize(true);
        // $sheet->getColumnDimension('AY')->setAutoSize(true);
        // $sheet->getColumnDimension('AZ')->setAutoSize(true);
        // $sheet->getColumnDimension('BA')->setAutoSize(true);
        // $sheet->getColumnDimension('BB')->setAutoSize(true);
        // $sheet->getColumnDimension('BC')->setAutoSize(true);
        // $sheet->getColumnDimension('BD')->setAutoSize(true);



        $sheet->getStyle('C1:BD1')->getFont()->setBold(true);
        $sheet->getStyle('C2:BD2')->getFont()->setBold(true);

        // $sheet->getStyle('H2')->getFont()->setBold(true);
        // $sheet->getStyle('K2')->getFont()->setBold(true);
        // $sheet->getStyle('N2')->getFont()->setBold(true);
        // $sheet->getStyle('Q2')->getFont()->setBold(true);
        // $sheet->getStyle('T2')->getFont()->setBold(true);

        // $ante = $anio-1;
        // $sheet->setCellValue('A1', "{$ubiClave} {$ante}-{$anio}");
        // $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('left');

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:E1');
        $sheet->mergeCells('F1:H1');
        $sheet->mergeCells('I1:K1');
        $sheet->mergeCells('L1:N1');
        $sheet->mergeCells('O1:Q1');
        $sheet->mergeCells('R1:T1');
        $sheet->mergeCells('U1:W1');
        $sheet->mergeCells('X1:Z1');
        $sheet->mergeCells('AA1:AC1');
        $sheet->mergeCells('AD1:AF1');
        $sheet->mergeCells('AG1:AI1');
        $sheet->mergeCells('AJ1:AL1'); //12
        $sheet->mergeCells('AM1:AO1');
        $sheet->mergeCells('AP1:AR1');
        $sheet->mergeCells('AS1:AU1');
        $sheet->mergeCells('AV1:AX1');
        $sheet->mergeCells('AY1:BA1');
        $sheet->mergeCells('BB1:BD1');


        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('U1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('X1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AA1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AD1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AG1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AJ1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AM1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AP1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AS1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AV1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AY1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('BB1')->getAlignment()->setHorizontal('center');


        $sheet->setCellValue('A1', 'Programa');
        $sheet->setCellValue('B1', 'Acuerdo');
        $sheet->setCellValue('C1', '1o');
        $sheet->setCellValue('F1', '2o');
        $sheet->setCellValue('I1', '3o');
        $sheet->setCellValue('L1', '4o');
        $sheet->setCellValue('O1', '5o');
        $sheet->setCellValue('R1', '6o');
        $sheet->setCellValue('U1', '7o');
        $sheet->setCellValue('X1', '8o');
        $sheet->setCellValue('AA1', '9o');
        $sheet->setCellValue('AD1', '10o');
        $sheet->setCellValue('AG1', '11o');
        $sheet->setCellValue('AJ1', '12o');
        $sheet->setCellValue('AM1', 'TOTAL');
        $sheet->setCellValue('AP1', 'EGRESADOS');
        $sheet->setCellValue('AS1', 'TITULADOS');
        $sheet->setCellValue('AV1', 'BAJAS ESCOLARES');
        $sheet->setCellValue('AY1', 'REINCORPORADOS');
        $sheet->setCellValue('BB1', 'TRASLADOS');

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'ff949494'],
                ],
            ],
        ];

        $sheet->getStyle('C1:E1')->applyFromArray($styleArray);
        $sheet->getStyle('F1:H1')->applyFromArray($styleArray);
        $sheet->getStyle('I1:K1')->applyFromArray($styleArray);
        $sheet->getStyle('L1:N1')->applyFromArray($styleArray);
        $sheet->getStyle('O1:Q1')->applyFromArray($styleArray);
        $sheet->getStyle('R1:T1')->applyFromArray($styleArray);
        $sheet->getStyle('U1:W1')->applyFromArray($styleArray);
        $sheet->getStyle('X1:Z1')->applyFromArray($styleArray);
        $sheet->getStyle('AA1:AC1')->applyFromArray($styleArray);
        $sheet->getStyle('AD1:AF1')->applyFromArray($styleArray);
        $sheet->getStyle('AG1:AI1')->applyFromArray($styleArray);
        $sheet->getStyle('AJ1:AL1')->applyFromArray($styleArray); //12
        $sheet->getStyle('AM1:AO1')->applyFromArray($styleArray);
        $sheet->getStyle('AP1:AR1')->applyFromArray($styleArray);
        $sheet->getStyle('AS1:AU1')->applyFromArray($styleArray);
        $sheet->getStyle('AV1:AX1')->applyFromArray($styleArray);
        $sheet->getStyle('AY1:BA1')->applyFromArray($styleArray);
        $sheet->getStyle('BB1:BD1')->applyFromArray($styleArray);


        $spreadsheet->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('V2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('W2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('X2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('Y2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('Z2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AA2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AB2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AC2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AD2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AE2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AF2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AG2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AH2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AI2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AJ2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AK2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AL2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AM2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AN2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AO2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AP2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AQ2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AR2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AS2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AT2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AU2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AV2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AW2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AX2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AY2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('AZ2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('BA2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('BB2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('BC2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('BD2')->getAlignment()->setHorizontal('center');

        // fila 2
        $sheet->setCellValue('C2', 'H');
        $sheet->setCellValue('D2', 'M');
        $sheet->setCellValue('E2', 'T');
        $sheet->setCellValue('F2', 'H');
        $sheet->setCellValue('G2', 'M');
        $sheet->setCellValue('H2', 'T');
        $sheet->setCellValue('I2', 'H');
        $sheet->setCellValue('J2', 'M');
        $sheet->setCellValue('K2', 'T');
        $sheet->setCellValue('L2', 'H');
        $sheet->setCellValue('M2', 'M');
        $sheet->setCellValue('N2', 'T');
        $sheet->setCellValue('O2', 'H');
        $sheet->setCellValue('P2', 'M');
        $sheet->setCellValue('Q2', 'T');
        $sheet->setCellValue('R2', 'H');
        $sheet->setCellValue('S2', 'M');
        $sheet->setCellValue('T2', 'T');
        $sheet->setCellValue('U2', 'H');
        $sheet->setCellValue('V2', 'M');
        $sheet->setCellValue('W2', 'T');
        $sheet->setCellValue('X2', 'H');
        $sheet->setCellValue('Y2', 'M');
        $sheet->setCellValue('Z2', 'T');
        $sheet->setCellValue('AA2', 'H');
        $sheet->setCellValue('AB2', 'M');
        $sheet->setCellValue('AC2', 'T');
        $sheet->setCellValue('AD2', 'H');
        $sheet->setCellValue('AE2', 'M');
        $sheet->setCellValue('AF2', 'T');
        $sheet->setCellValue('AG2', 'H');
        $sheet->setCellValue('AH2', 'M');
        $sheet->setCellValue('AI2', 'T');
        $sheet->setCellValue('AJ2', 'H');
        $sheet->setCellValue('AK2', 'M');
        $sheet->setCellValue('AL2', 'T');
        $sheet->setCellValue('AM2', 'H');
        $sheet->setCellValue('AN2', 'M');
        $sheet->setCellValue('AO2', 'T');
        $sheet->setCellValue('AP2', 'H');
        $sheet->setCellValue('AQ2', 'M');
        $sheet->setCellValue('AR2', 'T');
        $sheet->setCellValue('AS2', 'H');
        $sheet->setCellValue('AT2', 'M');
        $sheet->setCellValue('AU2', 'T');
        $sheet->setCellValue('AV2', 'H');
        $sheet->setCellValue('AW2', 'M');
        $sheet->setCellValue('AX2', 'T');
        $sheet->setCellValue('AY2', 'H');
        $sheet->setCellValue('AZ2', 'M');
        $sheet->setCellValue('BA2', 'T');
        $sheet->setCellValue('BB2', 'H');
        $sheet->setCellValue('BC2', 'M');
        $sheet->setCellValue('BD2', 'T');

        // $inputFileName = './example1.xls';
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        // $sheet = $spreadsheet->getActiveSheet(); // Obtenes la referencia a la hoja
        // $cell = $sheet->getCell('A1'); // Seleccionas la celda
        // $cellStyle = $cell->getStyle(); // Accedes a los estilos

        // // Finalmente podes obtener el color de fondo en RGB (red, green, blue)
        // $color = $cellStyle->getFill()->getStartColor()->getRGB();  // Ejemplo: FFFFFF
        // // o en ARGB (alpha, red, green, blue)
        // $color = $cellStyle->getFill()->getStartColor()->getARGB(); // Ejemplo: FFFFFFFF

        $fila = 3;
        foreach($info_reporte AS $value) {

            $sheet->setCellValueExplicit("A{$fila}", $value->programa, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}" , $value->acuerdoClave);
            $sheet->setCellValue("C{$fila}", $value->inscM01);
            $sheet->setCellValue("D{$fila}", $value->inscF01);
            $sheet->setCellValue("E{$fila}", $value->inscT01);
            $sheet->setCellValue("F{$fila}", $value->inscM02);
            $sheet->setCellValue("G{$fila}", $value->inscF02);
            $sheet->setCellValue("H{$fila}", $value->inscT02);
            $sheet->setCellValue("I{$fila}", $value->inscM03);
            $sheet->setCellValue("J{$fila}", $value->inscF03);
            $sheet->setCellValue("K{$fila}", $value->inscT03);
            $sheet->setCellValue("L{$fila}", $value->inscM04);
            $sheet->setCellValue("M{$fila}", $value->inscF04);
            $sheet->setCellValue("N{$fila}", $value->inscT04);
            $sheet->setCellValue("O{$fila}", $value->inscM05);
            $sheet->setCellValue("P{$fila}", $value->inscF05);
            $sheet->setCellValue("Q{$fila}", $value->inscT05);
            $sheet->setCellValue("R{$fila}", $value->inscM06);
            $sheet->setCellValue("S{$fila}", $value->inscF06);
            $sheet->setCellValue("T{$fila}", $value->inscT06);
            $sheet->setCellValue("U{$fila}", $value->inscM07);
            $sheet->setCellValue("V{$fila}", $value->inscF07);
            $sheet->setCellValue("W{$fila}", $value->inscT07);
            $sheet->setCellValue("X{$fila}", $value->inscM08);
            $sheet->setCellValue("Y{$fila}", $value->inscF08);
            $sheet->setCellValue("Z{$fila}", $value->inscT08);
            $sheet->setCellValue("AA{$fila}", $value->inscM09);
            $sheet->setCellValue("AB{$fila}", $value->inscF09);
            $sheet->setCellValue("AC{$fila}", $value->inscT09);
            $sheet->setCellValue("AD{$fila}", $value->inscM10);
            $sheet->setCellValue("AE{$fila}", $value->inscF10);
            $sheet->setCellValue("AF{$fila}", $value->inscT10);
            $sheet->setCellValue("AG{$fila}", $value->inscM11);
            $sheet->setCellValue("AH{$fila}", $value->inscF11);
            $sheet->setCellValue("AI{$fila}", $value->inscT11);
            $sheet->setCellValue("AJ{$fila}", $value->inscM12);
            $sheet->setCellValue("AK{$fila}", $value->inscF12);
            $sheet->setCellValue("AL{$fila}", $value->inscT12);
            $sheet->setCellValue("AM{$fila}", $value->inscMT);
            $sheet->setCellValue("AN{$fila}", $value->inscFT);
            $sheet->setCellValue("AO{$fila}", $value->inscTT);
            $sheet->setCellValue("AP{$fila}", $value->egrM);
            $sheet->setCellValue("AQ{$fila}", $value->egrF);
            $sheet->setCellValue("AR{$fila}", $value->egrT);
            $sheet->setCellValue("AS{$fila}", $value->titM);
            $sheet->setCellValue("AT{$fila}", $value->titF);
            $sheet->setCellValue("AU{$fila}", $value->titT);
            $sheet->setCellValue("AV{$fila}", $value->bajasM);
            $sheet->setCellValue("AW{$fila}", $value->bajasF);
            $sheet->setCellValue("AX{$fila}", $value->bajasT);
            $sheet->setCellValue("AY{$fila}", $value->REM);
            $sheet->setCellValue("AZ{$fila}", $value->REF);
            $sheet->setCellValue("BA{$fila}", $value->RET);
            $sheet->setCellValue("BB{$fila}", $value->EQM);
            $sheet->setCellValue("BC{$fila}", $value->EQF);
            $sheet->setCellValue("BD{$fila}", $value->EQT);

            $spreadsheet->getActiveSheet()->getStyle('B'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('C'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('D'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('E'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('F'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('G'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('H'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('I'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('J'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('K'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('L'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('M'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('N'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('O'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('P'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('Q'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('R'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('S'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('T'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('U'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('V'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('W'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('X'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('Y'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('Z'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AA'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AB'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AC'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AD'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AE'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AF'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AG'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AH'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AI'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AJ'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AK'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AL'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AM'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AN'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AO'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AP'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AQ'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AR'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AS'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AT'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AU'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AV'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AW'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AX'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AY'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('AZ'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('BA'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('BB'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('BC'.$fila.'')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('BD'.$fila.'')->getAlignment()->setHorizontal('center');
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CIBIESDatos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CIBIESDatos.xlsx"));
    }
}

<?php

namespace App\Http\Controllers\ReportesFederal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use \PhpOffice\PhpSpreadsheet\Style\Color;
use \PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Programa;
use App\Http\Models\Plan;
use Validator;
use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class Anexo8Controller extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
  }

  public function reporte()
  {
    $ubicaciones = Ubicacion::all();
    return view('reportes-federal.anexo8.create', compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $validator = Validator::make($request->all(),
      [
        'ubicacion_id'    => 'required',
        'perAnio'    => 'required',
        'perNumero'    => 'required',
      ]
    );

    if ($validator->fails()) {
      return redirect ('reporte-federal/anexo-8')->withErrors($validator)->withInput();
    }

    $ubicacion = Ubicacion::findOrFail($request->ubicacion_id);
    // $periodo = Periodo::findOrFail($request->periodo_id);
    
    $departamento = $request->departamento_id ? Departamento::findOrFail($request->departamento_id) : NULL;
    $escuela = $request->escuela_id ? Escuela::findOrFail($request->escuela_id) : NULL;
    $programa = $request->programa_id ? Programa::findOrFail($request->programa_id) : NULL;
    $plan = $request->plan_id ? Plan::findOrFail($request->plan_id) : NULL;

    $depClave = $departamento ? $departamento->depClave : '';
    $escClave = $escuela ? $escuela->escClave : '';
    $progClave = $programa ? $programa->progClave : '';
    $planClave = $plan ? $plan->planClave : '';

    $gpoSemestre = $request->gpoSemestre ? $request->gpoSemestre : '';
    $gpoClave = $request->gpoClave ? $request->gpoClave : '';
    $aluClave = $request->aluClave ? $request->aluClave : '';
    $matricula = $request->matricula ? $request->matricula : '';
    $curp = $request->curp ? $request->curp : '';
    
    $results = DB::select("call procFederalAnexo8("
      .$request->perAnio
      .",".$request->perNumero
      .",'".$ubicacion->ubiClave
      ."','".$depClave
      ."','".$escClave
      ."','".$progClave
      ."','".$planClave
      ."','".$gpoSemestre
      ."','".$gpoClave
      ."','".$aluClave
      ."','".$matricula
      ."','".$curp
      ."')");

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Hoja de Llenado');

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
    $sheet->getColumnDimension('U')->setAutoSize(true);
    $sheet->getColumnDimension('V')->setAutoSize(true);
    $sheet->getColumnDimension('W')->setAutoSize(true);

    # COLOR DE TEXTO DE TITULO.
    $sheet->getStyle('A1:W1')->getFont()->getColor()->setARGB('006100');
    #COLOR DE CELDA D TITULO
    $sheet->getStyle('A1:W1')->getFill()
    ->setFillType(FILL::FILL_SOLID)
    ->getStartColor()->setARGB('C6EFCE');
    # BORDES TITULO
    $styleArray = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color' => ['argb' => Color::COLOR_BLACK],
        ],
        // 'left' => [
        //   'borderStyle' => Border::BORDER_MEDIUM,
        //   'color' => ['argb' => Color::COLOR_BLACK],
        // ],
        // 'right' => [
        //   'borderStyle' => Border::BORDER_MEDIUM,
        //   'color' => ['argb' => Color::COLOR_BLACK],
        // ],
      ],
    ];
  
    $sheet->getStyle('A1:W1')->applyFromArray($styleArray);

    $sheet->getStyle('A1:W1')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A1:W1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheet->setCellValue('A1', "Estatus");
    $sheet->setCellValue('B1', 'Año del ciclo escolar');
    $sheet->setCellValue('C1', "Nombre del alumno");
    $sheet->setCellValue('D1', "Primer Apellido");
    $sheet->setCellValue('E1', "Segundo Apellido");
    $sheet->setCellValue('F1', "Género");
    $sheet->setCellValue('G1', "CURP");
    $sheet->setCellValue('H1', "Fecha de Nacimiento");
    $sheet->setCellValue('I1', "País de Nacimiento");
    $sheet->setCellValue('J1', "Entidad Federativa o Ciudad de Nacimiento");
    $sheet->setCellValue('K1', "País de Procedencia");
    $sheet->setCellValue('L1', "Idioma/Lengua");
    $sheet->setCellValue('M1', "Necesidad Educativa Especial");
    $sheet->setCellValue('N1', "Presenta Antecedente Académico");
    $sheet->setCellValue('O1', "CCT");
    $sheet->setCellValue('P1', "Matrícula Institucional");
    $sheet->setCellValue('Q1', "Nivel Educativo");
    $sheet->setCellValue('R1', "Clave de la Institución");
    $sheet->setCellValue('S1', "Clave de Carrera");
    $sheet->setCellValue('T1', "Turno");
    $sheet->setCellValue('U1', "Número de Acuerdo de RVOE");
    $sheet->setCellValue('V1', "Fecha de Acuerdo de RVOE");
    $sheet->setCellValue('W1', "Modalidad Educativa");

    $fila = 2;
    foreach($results as $result) {
      $sheet->getStyle("A{$fila}:W{$fila}")->applyFromArray($styleArray);

      $sheet->setCellValue("A{$fila}", $result->estatus);
      $sheet->setCellValue("B{$fila}", $result->anio);
      $sheet->getStyle("B{$fila}")->getAlignment()->setHorizontal('center');
      $sheet->setCellValue("C{$fila}", $result->nombre);
      $sheet->setCellValue("D{$fila}", $result->apellido1);
      $sheet->setCellValue("E{$fila}", $result->apellido2);
      // $sheet->setCellValue("F{$fila}", $result->fechaProgACtual ? Carbon::parse($result->fechaProgACtual)->format('d/m/Y') : '');
      $sheet->setCellValue("F{$fila}", $result->genero);
      $sheet->getStyle("F{$fila}")->getAlignment()->setHorizontal('center');
      $sheet->setCellValue("G{$fila}", $result->curp);
      $sheet->setCellValue("H{$fila}", $result->fechanac);
      $sheet->getStyle("H{$fila}")->getAlignment()->setHorizontal('center');
      $sheet->setCellValue("I{$fila}", $result->paisnac);
      $sheet->setCellValue("J{$fila}", $result->ciudadnac);
      $sheet->setCellValue("K{$fila}", $result->paisproc);
      $sheet->setCellValue("L{$fila}", $result->idioma);
      $sheet->setCellValue("M{$fila}", $result->especial);
      $sheet->setCellValue("N{$fila}", $result->antecedente);
      $sheet->setCellValue("O{$fila}", $result->CCT);
      $sheet->setCellValue("P{$fila}", $result->matrícula);
      $sheet->setCellValue("Q{$fila}", $result->nivel);
      $sheet->setCellValue("R{$fila}", $result->claveInstitucion);
      $sheet->setCellValue("S{$fila}", $result->claveCarrera);
      $sheet->setCellValue("T{$fila}", $result->turno);
      $sheet->setCellValue("U{$fila}", $result->rvoe);
      $sheet->setCellValue("V{$fila}", $result->fecharvoe);
      $sheet->setCellValue("W{$fila}", $result->modalidad);
      $fila++;
    }

    // # NUEVA HOJA
    // $newSheet = new Worksheet($spreadsheet, 'Instrucciones');
    // $spreadsheet->addSheet($newSheet);
    // $sheet = $spreadsheet->getSheetByName('Instrucciones');

    // $sheet->getColumnDimension('A')->setWidth(6.14, 'pt');
    // $sheet->getColumnDimension('B')->setWidth(36.57, 'pt');
    // $sheet->getColumnDimension('C')->setWidth(10.71, 'pt');
    // $sheet->getColumnDimension('D')->setWidth(10.71, 'pt');
    // $sheet->getColumnDimension('E')->setWidth(38.86, 'pt');
    // $sheet->getColumnDimension('F')->setWidth(140.57, 'pt');

    // # COLOR DE TEXTO DE TITULO.
    // $sheet->getStyle('A1:F1')->getFont()->getColor()->setARGB('006100');
    // #COLOR DE CELDA D TITULO
    // $sheet->getStyle('A1:F1')->getFill()
    // ->setFillType(FILL::FILL_SOLID)
    // ->getStartColor()->setARGB('C6EFCE');
    // # BORDES TITULO
    // $styleArray = [
    //   'borders' => [
    //     'allBorders' => [
    //       'borderStyle' => Border::BORDER_THIN,
    //       'color' => ['argb' => Color::COLOR_BLACK],
    //     ],
    //     // 'left' => [
    //     //   'borderStyle' => Border::BORDER_MEDIUM,
    //     //   'color' => ['argb' => Color::COLOR_BLACK],
    //     // ],
    //     // 'right' => [
    //     //   'borderStyle' => Border::BORDER_MEDIUM,
    //     //   'color' => ['argb' => Color::COLOR_BLACK],
    //     // ],
    //   ],
    // ];
  
    // // $sheet->getStyle('A1:F1')->applyFromArray($styleArray);

    // $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue('A1', "No.");
    // $sheet->setCellValue('B1', 'Nombre del Campo');
    // $sheet->setCellValue('C1', "¿Es Obligatorio?");
    // $sheet->setCellValue('D1', "Tipo");
    // $sheet->setCellValue('E1', "Longitud máxima");
    // $sheet->setCellValue('F1', "Descripción");

    // # Contenido
    // $sheet->getStyle("A2:F2")->applyFromArray($styleArray);
    // $sheet->getStyle("A3:F3")->applyFromArray($styleArray);
    // $sheet->getStyle("A4:F4")->applyFromArray($styleArray);
    // $sheet->getStyle("A5:F5")->applyFromArray($styleArray);
    // $sheet->getStyle("A6:F6")->applyFromArray($styleArray);
    // $sheet->getStyle("A7:F7")->applyFromArray($styleArray);
    // $sheet->getStyle("A8:F8")->applyFromArray($styleArray);
    // $sheet->getStyle("A9:F9")->applyFromArray($styleArray);
    // $sheet->getStyle("A10:F10")->applyFromArray($styleArray);
    // $sheet->getStyle("A11:F11")->applyFromArray($styleArray);
    // $sheet->getStyle("A12:F12")->applyFromArray($styleArray);
    // $sheet->getStyle("A13:F13")->applyFromArray($styleArray);
    // $sheet->getStyle("A14:F14")->applyFromArray($styleArray);
    // $sheet->getStyle("A15:F15")->applyFromArray($styleArray);
    // $sheet->getStyle("A16:F16")->applyFromArray($styleArray);
    // $sheet->getStyle("A17:F17")->applyFromArray($styleArray);
    // $sheet->getStyle("A18:F18")->applyFromArray($styleArray);
    // $sheet->getStyle("A19:F19")->applyFromArray($styleArray);
    // $sheet->getStyle("A20:F20")->applyFromArray($styleArray);
    // $sheet->getStyle("A21:F21")->applyFromArray($styleArray);
    // $sheet->getStyle("A22:F22")->applyFromArray($styleArray);
    // $sheet->getStyle("A23:F23")->applyFromArray($styleArray);
    // $sheet->getStyle("A24:F24")->applyFromArray($styleArray);

    // $sheet->setCellValue("A2", '1');
    // $sheet->getStyle("A2")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B2", 'Estatus');
    // $sheet->setCellValue("C2", 'Sí');
    // $sheet->setCellValue("D2", 'Texto');
    // $sheet->setCellValue("E2", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F2", 'Conforme al catálogo distinguir si se trata de Inscripción o Reinscripción de un alumno, en un Plan y programas de estudio con RVOE.');

    // $sheet->setCellValue("A3", '2');
    // $sheet->getStyle("A3")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B3", 'Año del ciclo escolar');
    // $sheet->setCellValue("C3", 'Sí');
    // $sheet->setCellValue("D3", 'Numérico');
    // $sheet->setCellValue("E3", '4 caracteres');
    // $sheet->setCellValue("F3", 'Especificación del año escolar que se cursará. Por ejemplo: 2017.');

    // $sheet->setCellValue("A4", '3');
    // $sheet->getStyle("A4")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B4", 'Nombre del alumno');
    // $sheet->setCellValue("C4", 'Sí');
    // $sheet->setCellValue("D4", 'Texto');
    // $sheet->setCellValue("E4", '70 caracteres');
    // $sheet->setCellValue("F4", 'Nombre(s) del alumno al que corresponde el registro tal como se especifica en el acta de nacimiento del mismo o en documento equivalente.');

    // $sheet->setCellValue("A5", '4');
    // $sheet->getStyle("A5")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B5", 'Primer Apellido');
    // $sheet->setCellValue("C5", 'Sí');
    // $sheet->setCellValue("D5", 'Texto');
    // $sheet->setCellValue("E5", '70 caracteres');
    // $sheet->setCellValue("F5", 'Primer apellido del alumno al que corresponde el registro tal como se especifica en el acta de nacimiento del mismo o en documento equivalente.');

    // $sheet->setCellValue("A6", '5');
    // $sheet->getStyle("A6")->getAlignment()->setHorizontal('center');
    
    // $sheet->setCellValue("B6", 'Segundo Apellido');
    // $sheet->setCellValue("C6", 'NO');
    // $sheet->setCellValue("D6", 'Texto');
    // $sheet->setCellValue("E6", '70 caracteres');
    // $sheet->setCellValue("F6", 'Segundo apellido del alumno al que corresponde el registro tal como se especifica en el acta de nacimiento del mismo o en documento equivalente. En caso de no tener el alumno un segundo apellido, dejar en blanco el campo.');
    // $sheet->getStyle("F6")->getAlignment()->setWrapText(true);

    // $sheet->setCellValue("A7", '6');
    // $sheet->getStyle("A7")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B7", 'Género');
    // $sheet->setCellValue("C7", 'Sí');
    // $sheet->setCellValue("D7", 'Texto');
    // $sheet->setCellValue("E7", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F7", 'Seleccionar: del catálogo M = Mujer o H = Hombre.');

    // $sheet->setCellValue("A8", '7');
    // $sheet->getStyle("A8")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B8", 'CURP');
    // $sheet->setCellValue("C8", 'Sí');
    // $sheet->setCellValue("D8", 'Texto');
    // $sheet->setCellValue("E8", '18 caracteres');
    // $sheet->setCellValue("F8", 'Clave única de registro de población proporcionada por RENAPO, correspondiente al alumno al que hace referencia el registro. En casos especiales, acercarse con la Autoridad Educativa Federal correspondiente para su debida atención.');
    // $sheet->getStyle("F8")->getAlignment()->setWrapText(true);

    // $sheet->setCellValue("A9", '8');
    // $sheet->getStyle("A9")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B9", 'Fecha de Nacimiento');
    // $sheet->setCellValue("C9", 'Sí');
    // $sheet->setCellValue("D9", 'Numérico');
    // $sheet->setCellValue("E9", '8 caracteres');
    // $sheet->setCellValue("F9", 'Fecha de nacimiento del alumno especificada en el acta de nacimiento del mismo o documento equivalente, bajo el formato de: aaaammdd.');

    // $sheet->setCellValue("A10", '9');
    // $sheet->getStyle("A10")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B10", 'País de Nacimiento');
    // $sheet->setCellValue("C10", 'Sí');
    // $sheet->setCellValue("D10", 'Texto');
    // $sheet->setCellValue("E10", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F10", 'Seleccionar conforme al catálogo, el país de nacimiento del alumno,  con base en su acta de nacimiento o documento equivalente.');

    // $sheet->setCellValue("A11", '10');
    // $sheet->getStyle("A11")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B11", 'Entidad Federativa o Ciudad de Nacimiento');
    // $sheet->setCellValue("C11", 'Sí');
    // $sheet->setCellValue("D11", 'Texto');
    // $sheet->setCellValue("E11", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F11", 'Seleccionar conforme al catálogo, la entidad federativa o ciudad de nacimiento del alumno,  con base en su acta de nacimiento o documento equivalente.');

    // $sheet->setCellValue("A12", '11');
    // $sheet->getStyle("A12")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B12", 'País de Procedencia');
    // $sheet->setCellValue("C12", 'NO');
    // $sheet->setCellValue("D12", 'Texto');
    // $sheet->setCellValue("E12", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F12", 'Seleccionar conforme al catálogo, el país de procedencia del alumno, en caso de que haya realizado estudios previos en dicho lugar.');

    // $sheet->setCellValue("A13", '12');
    // $sheet->getStyle("A13")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B13", 'Idioma/Lengua');
    // $sheet->setCellValue("C13", 'NO');
    // $sheet->setCellValue("D13", 'Texto');
    // $sheet->setCellValue("E13", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F13", 'Seleccionar conforme al catálogo el Idioma o Lengua natural del alumno.');

    // $sheet->setCellValue("A14", '13');
    // $sheet->getStyle("A14")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B14", 'Necesidad Educativa Especial');
    // $sheet->setCellValue("C14", 'NO');
    // $sheet->setCellValue("D14", 'Texto');
    // $sheet->setCellValue("E14", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F14", 'CSeleccionar conforme al catálogo de tratarse de alumnos de educación especial (con discapacidad o con aptitudes sobresalientes).');

    // $sheet->setCellValue("A15", '14');
    // $sheet->getStyle("A15")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B15", 'Presenta Antecedente Académico');
    // $sheet->setCellValue("C15", 'Sí');
    // $sheet->setCellValue("D15", 'Texto');
    // $sheet->setCellValue("E15", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F15", 'Seleccionar conforme al catálogo correspondiente.');

    // $sheet->setCellValue("A16", '15');
    // $sheet->getStyle("A16")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B16", 'CCT');
    // $sheet->setCellValue("C16", 'NO');
    // $sheet->setCellValue("D16", 'Texto');
    // $sheet->setCellValue("E16", '10 caracteres');
    // $sheet->setCellValue("F16", 'Indicar la Clave del Centro de Trabajo (CCT) asignada a la Institución Particular titular del RVOE.');

    // $sheet->setCellValue("A17", '16');
    // $sheet->getStyle("A17")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B17", 'Matrícula Institucional');
    // $sheet->setCellValue("C17", 'Sí');
    // $sheet->setCellValue("D17", 'Texto');
    // $sheet->setCellValue("E17", '20 caracteres');
    // $sheet->setCellValue("F17", 'Número de matrícula del alumno.');

    // $sheet->setCellValue("A18", '17');
    // $sheet->getStyle("A18")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B18", 'Nivel Educativo');
    // $sheet->setCellValue("C18", 'Sí');
    // $sheet->setCellValue("D18", 'Numérico');
    // $sheet->setCellValue("E18", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F18", 'Seleccionar conforme al catálogo el nivel educativo.');

    // $sheet->setCellValue("A19", '18');
    // $sheet->getStyle("A19")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B19", 'Clave de la Institución');
    // $sheet->setCellValue("C19", 'Sí');
    // $sheet->setCellValue("D19", 'Texto');
    // $sheet->setCellValue("E19", '10 caracteres');
    // $sheet->setCellValue("F19", 'Señalar la clave proporcionada por la Dirección General de Profesiones de la SEP.');

    // $sheet->setCellValue("A20", '19');
    // $sheet->getStyle("A20")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B20", 'Clave de Carrera');
    // $sheet->setCellValue("C20", 'Sí');
    // $sheet->setCellValue("D20", 'Texto');
    // $sheet->setCellValue("E20", '10 caracteres');
    // $sheet->setCellValue("F20", 'Señalar la clave proporcionada por la Dirección General de Profesiones de la SEP.');

    // $sheet->setCellValue("A21", '20');
    // $sheet->getStyle("A21")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B21", 'Turno');
    // $sheet->setCellValue("C21", 'NO');
    // $sheet->setCellValue("D21", 'Texto');
    // $sheet->setCellValue("E21", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F21", 'Seleccionar conforme al catálogo, el turno que le corresponde al alumno de acuerdo con el CCT.');

    // $sheet->setCellValue("A22", '21');
    // $sheet->getStyle("A22")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B22", 'Número de Acuerdo de RVOE');
    // $sheet->setCellValue("C22", 'Sí');
    // $sheet->setCellValue("D22", 'Texto');
    // $sheet->setCellValue("E22", '70 caracteres');
    // $sheet->setCellValue("F22", 'Número del acuerdo de RVOE otorgado por la autoridad educativa competente.');

    // $sheet->setCellValue("A23", '22');
    // $sheet->getStyle("A23")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B23", 'Fecha de Acuerdo de RVOE');
    // $sheet->setCellValue("C23", 'Sí');
    // $sheet->setCellValue("D23", 'Numérico');
    // $sheet->setCellValue("E23", '8 caracteres');
    // $sheet->setCellValue("F23", 'Fecha del acuerdo de RVOE, conforme al formato: aaaammdd..');

    // $sheet->setCellValue("A24", '23');
    // $sheet->getStyle("A24")->getAlignment()->setHorizontal('center');
    // $sheet->setCellValue("B24", 'Modalidad Educativa');
    // $sheet->setCellValue("C24", 'Sí');
    // $sheet->setCellValue("D24", 'Texto');
    // $sheet->setCellValue("E24", 'No aplica, se selecciona del catálogo');
    // $sheet->setCellValue("F24", 'Seleccionar conforme al catálogo, tipo de modalidad educativa (escolar, no escolarizada y mixta).');

    // $sheet->mergeCells("A26:F29");
    // $sheet->setCellValue("A26", 'Instrucciones:');
    // $sheet->getStyle('A26')->getFont()->setBold(true);
    // $sheet->getStyle('A26')->getAlignment()->setHorizontal('left');
    // $sheet->getStyle('A26')->getAlignment()->setVertical('top');
    // $sheet->getStyle("A26:F29")->applyFromArray($styleArray);

    // $spreadsheet->setActiveSheetIndex(0);

    $writer = new Xlsx($spreadsheet);
    try {
        $writer->save(storage_path("Anexo_8_CME.xlsx"));
    } catch (Exception $e) {
        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
        return back()->withInput();
    }
    return response()->download(storage_path("Anexo_8_CME.xlsx"));
  }
}
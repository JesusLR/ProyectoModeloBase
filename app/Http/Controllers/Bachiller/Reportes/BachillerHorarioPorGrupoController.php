<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Cgt;
use App\Http\Models\Plan;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Escuela;
use App\Http\Models\Materia;
use App\Http\Models\Periodo;
use App\Http\Models\Programa;
use App\Http\Models\Historico;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\ResumenAcademico;
use App\Http\Helpers\Utils;

use PDF;
use Auth;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerHorarioPorGrupoController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function reporte()
  {
    return view('bachiller.reportes.horario_por_grupo.create', [
      "ubicaciones" => Ubicacion::sedes()->get()
    ]);
  }


  public function imprimir(Request $request)
  {
    $escuela = Escuela::findOrFail($request->escuela_id);
    $periodo = Periodo::with('departamento.ubicacion')->find($request->periodo_id);
    $departamento = $periodo->departamento;
    $ubicacion = $departamento->ubicacion;
    $progClave = $request->programa_id ? Programa::findOrFail($request->programa_id)->progClave : '';
    $planClave = $request->plan_id ? Plan::findOrFail($request->plan_id)->planClave : '';

    $cgtGradoSemestre = $request->cgtGradoSemestre?"'".$request->cgtGradoSemestre."'":"''";
    $cgtGrupo = $request->cgtGrupo   ?"'".$request->cgtGrupo."'":"''";

    $cgts = DB::select(DB::raw("call procBachillerHorarioCGT(
      {$periodo->perNumero},
      {$periodo->perAnio},
      '{$ubicacion->ubiClave}',
      '{$ubicacion->depClave}',
      '{$escuela->escClave}',
      '{$progClave}',
      '{$planClave}',
      {$cgtGradoSemestre},
      {$cgtGrupo}
    )"));


    if(!$cgts) {
      alert()->warning('Sin registros', 'No se encuentra información con los criterios de búsqueda')->showConfirmButton();
      return back()->withInput();
    }

    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    $nombreArchivo = "Horario ".$periodo->perNumero." ".$periodo->perAnio." ".$escuela->escClave.".docx";


    $sectionStyle = array('breakType' => 'continuous', 'marginBottom' => 300);
    $universidadFontStyle = array('size' => 16);
    $escuelaFontStyle = array('size' => 10, 'bold' => true);
    $programaFontStyle = array('size' => 12, 'bold' => true);
    $headerFontStyle = array('size' => 12);
    $firmaFontStyle = array('size' => 10);
    $centeredText = array('align' => 'center', 'lineHeight' => 1);
    $cellHFontStyle = array('size' => 10);
    $cellFontStyle = array('size' => 8);
    // // 2. Advanced table
    $styleTable      = array('borderSize' => 6, 'borderColor' => '999999','marginBottom' => 10);
    $cellRowSpan     = array('vMerge' => 'restart', 'valign' => 'center', 'marginTop' => 10, 'bgColor' => 'B1B1B1');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan     = array('gridSpan' => 2, 'valign' => 'center');
    $cellHCentered   = array('align' => 'center','bgColor' => '666666');
    $cellVCentered   = array('valign' => 'center', 'align' => 'center');

    $phpWord->addTableStyle('Materias', $styleTable);
    $phpWord->addTableStyle('Horario', $styleTable);
   


    //COLUMNAS DOBLES
    // $table->addRow();
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);


    foreach ($cgts as $cgt) {


      $header = array('size' => 12, 'align' => 'center');


  

      $gradoSemestre = Utils::semestres_numeracion_ordinal($cgt->cgtGradoSemestre);

      $section = $phpWord->addSection($sectionStyle);

      $section->addText('BACHILLER MODELO', $universidadFontStyle, $centeredText);
      $section->addText($cgt->escNombre, $escuelaFontStyle, $centeredText);
      $section->addText($cgt->progNombre, $programaFontStyle, $centeredText);
      $section->addText('CURSO ESCOLAR '.$cgt->perAnio, $headerFontStyle, $centeredText);
      $section->addText("HORARIO DE CLASES", $headerFontStyle, $centeredText);
      $section->addText($gradoSemestre." SEMESTRE", $escuelaFontStyle, $centeredText);
      $section->addText("GRUPO ". $cgt->cgtGrupo, $escuelaFontStyle, $centeredText);

      // $section_horario = $phpWord->addSection($sectionStyle);
      $table = $section->addTable('Horario');
      $table->addRow();
      //COLUMNAS
      $cell = $table->addCell(2000, $cellRowSpan);
      $textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun->addText(htmlspecialchars('HORA'));
  
      $cell1 = $table->addCell(2000, $cellRowSpan);
      $textrun1 = $cell1->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun1->addText(htmlspecialchars('LUNES'));
  
      $cell2 = $table->addCell(4000, $cellRowSpan);
      $textrun2 = $cell2->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun2->addText(htmlspecialchars('MARTES'));
  
      $cell3 = $table->addCell(2000, $cellRowSpan);
      $textrun3 = $cell3->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun3->addText(htmlspecialchars('MIERCOLES'));
  
      $cell4 = $table->addCell(2000, $cellRowSpan);
      $textrun4 = $cell4->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun4->addText(htmlspecialchars('JUEVES'));
  
      $cell4 = $table->addCell(2000, $cellRowSpan);
      $textrun4 = $cell4->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun4->addText(htmlspecialchars('VIERNES'));
  
      $cell5 = $table->addCell(2000, $cellRowSpan);
      $textrun5 = $cell5->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun5->addText(htmlspecialchars('SABADO'));



      // Validamos de que campus viene la solucitud 
      if($ubicacion->ubiClave == "CME" || $ubicacion->ubiClave == "CVA" || $ubicacion->ubiClave == "CMT"){
        $horarios = DB::select(DB::raw('call procBachillerHorarioImpresoYucatan('
        ."'".$cgt->perNumero . "'"
        .","."'".$cgt->perAnio . "'"
        .","."'".$cgt->ubiClave . "'"
        .",". "'".$cgt->progClave . "'"
        .",". "'".$cgt->planClave. "'"
        .","."'".$cgt->cgtGradoSemestre. "'"
        .","."'".$cgt->cgtGrupo. "'"
      .')'));
      }else{
        $horarios = DB::select(DB::raw('call procBachillerHorarioImpresoChetumal('
        ."'".$cgt->perNumero . "'"
        .","."'".$cgt->perAnio . "'"
        .","."'".$cgt->ubiClave . "'"
        .",". "'".$cgt->progClave . "'"
        .",". "'".$cgt->planClave. "'"
        .","."'".$cgt->cgtGradoSemestre. "'"
        .","."'".$cgt->cgtGrupo. "'"
      .')'));
      }

      



      foreach ($horarios as $horario) {

        $matLunes = $horario->matLunes;
        $matMartes = $horario->matMartes;
        $matMiercoles = $horario->matMiercoles;
        $matJueves = $horario->matJueves;
        $matViernes = $horario->matViernes;
        $matSabado = $horario->matSabado;

        $table->addRow();

        $table->addCell(2000)->addText($horario->horaInicio.":".$horario->minInicio."-".$horario->horaFinal.":".$horario->minFinal, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($matLunes, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($matMartes, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($matMiercoles, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($matJueves, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($matViernes, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($matSabado, $cellFontStyle, $cellVCentered);
      }


      //ESPACIO ENTRE TABLAS.
      $section->addText("", $headerFontStyle, $centeredText);
      $section->addText("", $headerFontStyle, $centeredText);



      // $section_Materias = $phpWord->addSection($sectionStyle);
      $table = $section->addTable('Materias');
      $table->addRow();
      //COLUMNAS
      $cell = $table->addCell(2000, $cellRowSpan);
      $textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun->addText(htmlspecialchars('CLAVE'));
  
      $cell1 = $table->addCell(2000, $cellRowSpan);
      $textrun1 = $cell1->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun1->addText(htmlspecialchars('GRUPO'));
  
      $cell2 = $table->addCell(4000, $cellRowSpan);
      $textrun2 = $cell2->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun2->addText(htmlspecialchars('MATERIA'));
  
      $cell3 = $table->addCell(2000, $cellRowSpan);
      $textrun3 = $cell3->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun3->addText(htmlspecialchars('MAESTRO'));
  
      $cell4 = $table->addCell(2000, $cellRowSpan);
      $textrun4 = $cell4->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun4->addText(htmlspecialchars('ORD'));
  
      $cell4 = $table->addCell(2000, $cellRowSpan);
      $textrun4 = $cell4->addTextRun($cellHFontStyle, $cellHCentered);
      $textrun4->addText(htmlspecialchars('AULA'));
  


      if($ubicacion->ubiClave == "CME" || $ubicacion->ubiClave == "CVA" || $ubicacion->ubiClave == "CMT"){
        $lista = DB::select(DB::raw('call procBachillerHorarioListaYucatan('
        ."'".$cgt->perNumero . "'"
        .","."'".$cgt->perAnio . "'"
        .","."'".$cgt->ubiClave . "'"
        .",". "'".$cgt->progClave . "'"
        .",". "'".$cgt->planClave. "'"
        .","."'".$cgt->cgtGradoSemestre. "'"
        .","."'".$cgt->cgtGrupo. "'"
      .')'));
      }else{
        $lista = DB::select(DB::raw('call procBachillerHorarioListaChetumal('
        ."'".$cgt->perNumero . "'"
        .","."'".$cgt->perAnio . "'"
        .","."'".$cgt->ubiClave . "'"
        .",". "'".$cgt->progClave . "'"
        .",". "'".$cgt->planClave. "'"
        .","."'".$cgt->cgtGradoSemestre. "'"
        .","."'".$cgt->cgtGrupo. "'"
      .')'));
      }
     



      foreach ($lista as $item) {
        $table->addRow();
        $table->addCell(2000)->addText($item->matClave, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($item->gpoClave, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($item->matNombre, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($item->empNombre, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($item->fechaExamen, $cellFontStyle, $cellVCentered);
        $table->addCell(2000)->addText($item->aulas, $cellFontStyle, $cellVCentered);
      }


      // $section_firma = $phpWord->addSection($sectionStyle);
      $section->addText('Autorizó', $firmaFontStyle, $centeredText);
      $section->addText('_____________________________', $firmaFontStyle, $centeredText);
      $section->addText($cgt->director, $firmaFontStyle, $centeredText);
      $section->addText($cgt->progNombre, $firmaFontStyle, $centeredText);

      $section->addPageBreak();

    }







    




    


    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    try {
      $objWriter->save(storage_path($nombreArchivo));
    } catch (Exception $e) {
      throw $e;

    }


    return response()->download(storage_path($nombreArchivo));


  }

}

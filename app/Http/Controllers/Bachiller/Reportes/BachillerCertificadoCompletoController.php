<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Bachiller\Bachiller_materias;
use App\Http\Models\Bachiller\Bachiller_resumenacademico;
use DB;
use PDF;
use Auth;
use Exception;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerCertificadoCompletoController extends Controller
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
    return view('bachiller.reportes.certificado_completo.create', [
      'ubicaciones' => Ubicacion::whereIn('id', [1, 2])->get()
    ]);
  }


  public function imprimir(Request $request)
  {

    $curso = Curso::with("cgt","alumno")
      ->whereHas('alumno', function ($query) use ($request) {
        $query->where('aluClave', "=", $request->aluClave);
      })
      ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', function ($query) use ($request) {
        $query->where('programa_id', $request->programa_id);
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }

      })
    ->get()
    ->unique("alumno.id")
    ->first();




    if (!$curso) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    $plan = $curso->cgt->plan;

    $historico = Bachiller_historico::where("alumno_id", "=", $curso->alumno->id)
    ->where('plan_id', $plan->id)
    ->get();



    $materias = Bachiller_materias::with("plan.programa.escuela")
    ->where('plan_id', $plan->id)
    ->get();

    $materias = $materias->map(function ($item, $key) use ($historico) {
      $matHistorico = $historico->where("bachiller_materia_id", "=", $item->id);

      $item->matHistorico = $matHistorico->sortByDesc("histFechaExamen")->first();

      return $item;
    });

    $semestres = $materias->unique("matSemestre");
    $semestres = $semestres->map(function ($item, $key) use ($materias) {

      $materiaSem = $materias->where("matSemestre", "=", $item->matSemestre);
      $item->materias = $materiaSem->sortBy("id");

      return $item;
    })
    ->sortBy("matSemestre");




    $resaca = Bachiller_resumenacademico::where("alumno_id", "=", $curso->alumno->id)
    ->where('plan_id', $plan->id)
    ->first();

    if(!$resaca) {
      alert()->warning('Ups!', 'No se encontró resumen académico del alumno. Favor de verificar.')->showConfirmButton();
      return back()->withInput();
    }

    $tipoCertificado = "";
    $tipoCertificado = "";
    if ($resaca->resAvanceAcumulado >= 100) {
      $tipoCertificadoTitulo = "CERTIFICADO COMPLETO";
      $tipoCertificado = "COMPLETO";
    } else {
      $tipoCertificadoTitulo = "CERTIFICADO PARCIAL";
      $tipoCertificado = "PARCIAL";
    }


    



    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    


    $header = array('size' => 14, 'bold' => true, 'align' => "center");


    $section = $phpWord->addSection();


    $section->addText(htmlspecialchars('Preparatoria ESCUELA MODELO'), $header);
    $section->addText(htmlspecialchars('Secretaría de Investigación, Innovación y Educación Superior'), $header);
    $section->addText(htmlspecialchars('Clave: 31PSU0009X'), $header);
    $section->addText(htmlspecialchars($tipoCertificadoTitulo), $header);


    $nombreAlumno = $curso->alumno->persona->perNombre . " " . $curso->alumno->persona->perApellido1 . " " . $curso->alumno->persona->perApellido2;

    if ($tipoCertificado == "COMPLETO") {
      $section->addText("QUÍMICA FARMACÉUTICO BIÓLOGO CELIA MARÍA DEL SOCORRO QUINTAL AVILÉS, Secretaria Administrativa de la Universidad Modelo, en relación con la Maestría en Comunicación Política y Marketing Electoral con Reconocimiento de Validez Oficial de Estudios, otorgado por la Secretaría de Educación del Estado de Yucatán, según Acuerdo No. 1231 de fecha veinte de julio de dos mil seis.", ['align'=>'both']);
      $section->addText("CERTIFICO: Que en los libros de las actas de exámenes que existen en esta Universidad consta que ". $nombreAlumno .", cursó y acreditó  todas las  asignaturas del plan de estudios de la Maestría en Comunicación Política y Marketing Electoral. Los datos correspondientes a esas asignaturas son los siguientes:", ['align'=>'both']);
    }
    if ($tipoCertificado == "PARCIAL") {
      $section->addText("QUÍMICA FARMACÉUTICO BIÓLOGO CELIA MARÍA DEL SOCORRO QUINTAL AVILÉS,
      Secretaria Administrativa de la Universidad Modelo, en relación con Ingeniería Industrial Logística
      con Reconocimiento de Validez Oficial de Estudios, otorgado por la Secretaría de Educación del
      Estado de Yucatán, según Acuerdo No. 1458 de fecha once de julio de dos mil ocho.", ['align'=>'both']);
      $section->addText("CERTIFICO: Que en los libros de las actas de exámenes que existen en esta Universidad consta
      que ". $nombreAlumno .", cursó y acreditó veinticinco asignaturas del plan
      de estudios de Ingeniería Industrial Logística. Los datos correspondientes a esas asignaturas son
      los siguientes:", ['align'=>'both']);
    }



    // // 2. Advanced table
    $styleTable      = array('borderSize' => 6, 'borderColor' => '999999');
    $cellRowSpan     = array('vMerge' => 'restart', 'valign' => 'center');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan     = array('gridSpan' => 2, 'valign' => 'center');
    $cellHCentered   = array('align' => 'center');
    $cellVCentered   = array('valign' => 'center');

    $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
    $table = $section->addTable('Colspan Rowspan');

    $table->addRow();

    //COLUMNAS
    $cell = $table->addCell(2000, $cellRowSpan);
    $textrun = $cell->addTextRun($cellHCentered);
    $textrun->addText(htmlspecialchars('Nombre de la asignatura'));

    $cell1 = $table->addCell(2000, $cellRowSpan);
    $textrun1 = $cell1->addTextRun($cellHCentered);
    $textrun1->addText(htmlspecialchars('Ciclo'));

    $cell2 = $table->addCell(4000, $cellColSpan);
    $textrun2 = $cell2->addTextRun($cellHCentered);
    $textrun2->addText(htmlspecialchars('Calificación'));

    $cell3 = $table->addCell(2000, $cellRowSpan);
    $textrun3 = $cell3->addTextRun($cellHCentered);
    $textrun3->addText(htmlspecialchars('Observaciones'));

    //COLUMNAS DOBLES
    $table->addRow();
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Número'), null, $cellHCentered);
    $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Letra'), null, $cellHCentered);
    $table->addCell(null, $cellRowContinue);

    //data

    foreach ($semestres as $semestre) {
      
      $nombreSemestre = "";
      switch ($semestre->matSemestre) {
        case 1:
          $nombreSemestre = "Primer Semestre";  break;
        case 2:
          $nombreSemestre = "Segundo Semestre"; break;
        case 3:
          $nombreSemestre = "Tercer Semestre";  break;
        case 4:
          $nombreSemestre = "Cuarto Semestre";  break;
        case 5:
          $nombreSemestre = "Quinto Semestre";  break;
        case 6:
          $nombreSemestre = "Sexto Semestre";   break;
        case 7:
          $nombreSemestre = "Septimo Semestre"; break;
        case 8:
          $nombreSemestre = "Octavo Semestre";  break;
        case 9:
          $nombreSemestre = "Noveno Semestre";  break;
        case 10:
          $nombreSemestre = "Decimo Semestre";  break;
        default:
          $nombreSemestre = "";
          break;
      }


      $table->addRow();
      $table->addCell(2000)->addText(htmlspecialchars("{$nombreSemestre}"));
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");


      foreach ($semestre->materias as $key => $value) {

        $matNombre = ucwords(strtolower($value->matNombreOficial));
        $table->addRow();

        if ($value->matHistorico) {
          $complementoNombre = "";
          if ($value->matHistorico->histComplementoNombre) {
            $complementoNombre = " - " . ucwords(strtolower($value->matHistorico->histComplementoNombre));
          }

          
          $table->addCell(2000)->addText(htmlspecialchars("{$matNombre}". $complementoNombre));
        } else {
          $table->addCell(2000)->addText(htmlspecialchars("{$matNombre}"));
        }

        if ($value->matHistorico) {
          $table->addCell(2000)->addText($value->matHistorico->periodo->perAnioPago ."-".($value->matHistorico->periodo->perAnioPago+1));
        } else {
          $table->addCell(2000)->addText("");
        }

        if ($value->matHistorico) {
          $table->addCell(2000)->addText($value->matHistorico->histCalificacion);
        } else {
          $table->addCell(2000)->addText("");
        }

        if ($value->matHistorico) {
          $califEnLetra = NumeroALetras::convert($value->matHistorico->histCalificacion,0,-11);
          $califEnLetra =  ucwords(strtolower(str_replace(" CON 00/100 0", "", $califEnLetra)));
          $table->addCell(2000)->addText($califEnLetra);
        } else {
          $table->addCell(2000)->addText("");
        }

        if ($value->matHistorico) {
          $observaciones = "";
          
          if ($value->matHistorico->histPeriodoAcreditacion == "EX") {
            $observaciones = "err" . " - " . $value->matHistorico->histFechaExamen;
          }
          if ($value->matHistorico->histPeriodoAcreditacion == "RV") {
            $observaciones = "equivalente";
          }

          $table->addCell(2000)->addText($observaciones);
        } else {
          $table->addCell(2000)->addText("");
        }

      }

    }

    $fechaEmision = Carbon::parse($request->fechaEmision);

    $diaLetras = NumeroALetras::convert($fechaEmision->day,0,-11);
    $diaLetras =  (strtolower(str_replace(" CON 00/100 0", "", $diaLetras)));


    $mesLetras = Utils::num_meses_string($fechaEmision->month);

    $anioLetras = NumeroALetras::convert($fechaEmision->year,0,-11);
    $anioLetras =  (strtolower(str_replace(" CON 00/100 0", "", $anioLetras)));

    
    //END TABLE
    $section->addText("");
    $section->addText("");
    $section->addText("El presente " . $tipoCertificadoTitulo . " ampara dieciséis asignaturas. La escala de calificación es de 0 a 100. ");
    $section->addText("Mérida, Yucatán, Estados Unidos Mexicanos, a los ".$diaLetras." días del mes de ". $mesLetras." del año ".$anioLetras.".");


    $section->addSection();
    $html = "<p style='text-align:center;'>______________________________</p>";
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);



    $section->addSection();
    $html = "<p>Rector</p>";
    $html .= "<p>______________________________</p>";
    $html .= "<p>Carlos Sauri Duch</p>";
    $html .= "<p>Ingeniero Industrial en Producción</p>";
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


    $section->addSection();
    $html = "<p style='text-align:center;'>Jefe del Departamento de Registro y Certificación</p>";
    $html .= "<p style='text-align:center;'>______________________________</p>";
    $html .= "<p style='text-align:center;'>Julio César Mijangos Noh</p>";
    $html .= "<p style='text-align:center;'>Licenciado en Educación</p>";
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


    $section->addText("Matrícula: " . $curso->alumno->aluMatricula);
    


    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    try {
      $objWriter->save(storage_path('certificado_completo.docx'));
    } catch (Exception $e) {


    }


    return response()->download(storage_path('certificado_completo.docx'));


  }

}
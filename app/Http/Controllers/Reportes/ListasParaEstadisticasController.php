<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Exception;

class ListasParaEstadisticasController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
    	$ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();
    	return view('reportes/listas_para_estadisticas.create', compact('ubicaciones'));
    }

    public function imprimir(Request $request) {
    	$fechaActual = Carbon::now('CDT');

    	$cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
    	->where('periodo_id', $request->periodo_id)
    	->where('curEstado', '<>', 'B')
    	->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
    		if($request->escuela_id) {
    			$query->where('escuela_id', $request->escuela_id);
    		}
    		if($request->programa_id) {
    			$query->where('programa_id', $request->programa_id);
    		}
    		if($request->plan_id) {
    			$query->where('plan_id', $request->plan_id);
    		}
    		if($request->cgtGradoSemestre) {
    			$query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
    		}
    		if($request->cgtGrupo) {
    			$query->where('cgtGrupo', $request->cgtGrupo);
    		}
    	})->get();

    	if($cursos->isEmpty()) {
    		alert()->warning('Sin Información', 'No se encontraron datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
    		return back()->withInput();
    	}

    	$curso1 = $cursos->first();
    	$periodo = $curso1->periodo->load('departamento.ubicacion');
    	$departamento = $periodo->departamento;
    	$ubicacion = $departamento->ubicacion;

    	$cursos = $cursos->map(static function($curso, $key) {
    		$alumno = $curso->alumno;
    		$persona = $alumno->persona;
    		$programa = $curso->cgt->plan->programa;

    		return collect([
    			'nombreCompleto' => MetodosPersonas::nombreCompleto($persona, true),
    			'grado' => $curso->cgt->cgtGradoSemestre,
    			'grupo' => $curso->cgt->cgtGrupo,
    			'progClave' => $programa->progClave,
    			'progNombre' => $programa->progNombre
    		]);
    	})->sortBy(static function($item, $key) {

    		return $item['progClave'].'-'.$item['grupo'].'-'.$item['nombreCompleto'];
    	})->groupBy(['progClave', 'grado']);

    	if($request->tipoImpresion == 'W'){
    		try {
    			return $this->crear_archivo_word($cursos);
    		} catch (Exception $e) {
    			alert()->error('Error', $e->getMessage())->showConfirmButton();
    			return back()->withInput();
    		}
    	}


    	setlocale(LC_TIME, 'es_ES.UTF-8');
	    // En windows
	    setlocale(LC_TIME, 'spanish');

	    $nombreArchivo = 'pdf_listas_para_estadisticas';
	    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
	      "datos" => $cursos,
	      "fechaActual" => $fechaActual->format('d/m/Y'),
	      "horaActual" => $fechaActual->format('H:i:s'),
	      "perFechaInicial" => Carbon::parse($periodo->perFechaInicial)->format('d/m/Y'),
	      "perFechaFinal" => Carbon::parse($periodo->perFechaFinal)->format('d/m/Y'),
	      "ubicacion" => $ubicacion,
	      "nombreArchivo" => $nombreArchivo,
	    ]);

	    $pdf->setPaper('letter', 'portrait');
	    $pdf->defaultFont = 'Times Sans Serif';
	    return $pdf->stream($nombreArchivo.'.pdf');
	    return $pdf->download($nombreArchivo.'.pdf');
    }//imprimir


    /**
    * estructura el archivo de word para generar las listas y tablas.
    */
    public function crear_archivo_word($cursos) {

    	$word = new \PhpOffice\PhpWord\PhpWord();

    	$nombreArchivo = 'listas_para_estadisticas.docx';

    	// estilos
    	$sectionStyle = array('breakType' => 'continuous', 'marginBottom' => 300);
    	$programaFontStyle = array('size' => 12, 'bold' => true);
    	$centeredText = array('align' => 'center', 'lineHeight' => 1);
    	$cellHFontStyle = array('size' => 10);
    	$cellFontStyle = array('size' => 8);

    	// estilo tablas.
    	$styleTable      = array('borderSize' => 6, 'borderColor' => '999999','marginBottom' => 10);
	    $cellRowSpan     = array('vMerge' => 'restart', 'valign' => 'center', 'marginTop' => 10, 'bgColor' => 'B1B1B1');
	    $cellRowContinue = array('vMerge' => 'continue');
	    $cellColSpan     = array('gridSpan' => 2, 'valign' => 'center');
	    $cellHCentered   = array('align' => 'center','bgColor' => '666666');
	    $cellVCentered   = array('valign' => 'center', 'align' => 'center');

	    $word->addTableStyle('programas', $styleTable);

	    $listas = $word->addSection($sectionStyle);
		$header = $listas->addHeader();
		$header->addImage(
		    public_path('images/logo-pago.jpg'),
		    array(
		        'width'         => 50,
		        'height'        => 50,
		        'marginTop'     => 100,
		        'marginLeft'    => 100,
		        'wrappingStyle' => 'behind'
		    )
		);

	    foreach ($cursos as $key => $programa) {

	    	$info = $programa->first()->first();
	    	$grados = $programa->sortKeys();
	    	$contador = 1;
	    	// $listas->addText($info['progClave'].' - '.$info['progNombre'], $programaFontStyle, $centeredText);

	    	$table = $listas->addTable('programas');

	    	$table->addRow(500, array('tblHeader' => true));
	    	$cell = $table->addCell(9000, $cellRowSpan);
	    	$cell->getStyle()->setGridSpan(4);
	    	$textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
	        $textrun->addText(htmlspecialchars($info['progClave'].' - '.$info['progNombre']));

	    	$table->addRow(500, array('tblHeader' => true));
	    	//COLUMNAS
	        $cell = $table->addCell(1000, $cellRowSpan);
	        $textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
	        $textrun->addText(htmlspecialchars('Num.'));

	        $cell = $table->addCell(2000, $cellRowSpan);
	        $textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
	        $textrun->addText(htmlspecialchars('Nombre del alumno'));

	        $cell = $table->addCell(1000, $cellRowSpan);
	        $textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
	        $textrun->addText(htmlspecialchars('grado'));

	        $cell = $table->addCell(1000, $cellRowSpan);
	        $textrun = $cell->addTextRun($cellHFontStyle, $cellHCentered);
	        $textrun->addText(htmlspecialchars('grupo'));


	        foreach ($grados as $key => $grado) {

	        	foreach ($grado as $key => $alumno) {
	        		$table->addRow();
	        		$table->addCell(1000)->addText($contador++, $cellFontStyle, $cellVCentered);
	        		$table->addCell(5000)->addText($alumno['nombreCompleto'], $cellFontStyle, $cellVCentered);
	        		$table->addCell(1000)->addText($alumno['grado'], $cellFontStyle, $cellVCentered);
	        		$table->addCell(1000)->addText($alumno['grupo'], $cellFontStyle, $cellVCentered);
	        	}

	        } // foreach grado

	        $listas->addPageBreak();
	    } // foreach programa

	    $writer = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');

		try {
	      $writer->save(storage_path($nombreArchivo));
	    } catch (Exception $e) {
	      throw new Exception("Error guardando archivo word", 1);
	      
	    }

	    return response()->download(storage_path($nombreArchivo));
    } // crear_archivo_word.
}

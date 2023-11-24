<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\clases\personas\MetodosPersonas;

use Exception;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class AlumnosUltimoGradoController extends Controller
{
	protected $cursos;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:alumnos_ultimo_grado']);
    	$this->cursos = new Collection;
    }

    public function reporte()
    {
    	return view('reportes/alumnos_ultimo_grado.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	self::buscarCursosUltimoGrado($request)
    	->chunk(150, function($registros) {
    		
    		if($registros->isEmpty())
    			return false;

    		$registros->each(function($curso) {
    			$this->cursos->push(self::info_esencial($curso));
    		});

    	});

    	if($this->cursos->isEmpty()) {
    		alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
    		return back()->withInput();
    	}

    	return $this->generarExcel();
    }

    /**
	* @param Illuminate\Http\Request
    */
    private static function buscarCursosUltimoGrado($request)
    {
    	return Curso::with(['cgt.plan.programa', 'alumno.persona'])
    	->where('periodo_id', $request->periodo_id)
    	->whereHas('cgt.plan.programa', static function($query) use ($request) {
    		$query->whereColumn('cgtGradoSemestre', 'planPeriodos');
    		if($request->plan_id)
    			$query->where('plan_id', $request->plan_id);
    		if($request->programa_id)
    			$query->where('programa_id', $request->programa_id);
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    	});
    }

    /**
	* @param App\Models\Curso
    */
    private static function info_esencial(Curso $curso): array
    {
    	$alumno = $curso->alumno;
    	$persona = $alumno->persona;
    	$cgt = $curso->cgt;
    	$programa = $cgt->plan->programa;
    	$apellidos = MetodosPersonas::soloApellidos($persona);
        $nombreCompleto = MetodosPersonas::nombreCompleto($persona, true);

    	return [
    		'aluClave' => $alumno->aluClave,
    		'aluMatricula' => $alumno->aluMatricula,
            'apellidos' => $apellidos,
            'nombres' => $persona->perNombre,
    		'nombreCompleto' => $nombreCompleto,
    		'perCorreo1' => $persona->perCorreo1,
    		'grado' => $cgt->cgtGradoSemestre,
    		'grupo' => $cgt->cgtGrupo,
    		'progClave' => $programa->progClave,
    		'progNombre' => $programa->progNombre,
    	];
    }

    public function generarExcel()
    {
    	$spreadsheet = new Spreadsheet();
    	$this->cursos->sortBy('nombreCompleto')->groupBy('progClave')->sortKeys()
    	->each(static function($programa_cursos, $progClave) use ($spreadsheet) {
    		$sheet = $spreadsheet->createSheet();
    		$sheet->setTitle($progClave);
    		$sheet->getStyle('A2:I2')->getFont()->setBold(true);
    		$sheet->getColumnDimension('A')->setAutoSize(true);
    		$sheet->getColumnDimension('B')->setAutoSize(true);
    		$sheet->getColumnDimension('C')->setAutoSize(true);
    		$sheet->getColumnDimension('D')->setAutoSize(true);
    		$sheet->getColumnDimension('E')->setAutoSize(true);
    		$sheet->getColumnDimension('F')->setAutoSize(true);
    		$sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
    		$sheet->getColumnDimension('I')->setAutoSize(true);
    		$sheet->setCellValueByColumnAndRow(1, 2, "Carrera");
    		$sheet->setCellValueByColumnAndRow(2, 2, "Nombre carrera");
    		$sheet->setCellValueByColumnAndRow(3, 2, "Clave Pago");
    		$sheet->setCellValueByColumnAndRow(4, 2, "Matricula");
            $sheet->setCellValueByColumnAndRow(5, 2, "Apellidos");
    		$sheet->setCellValueByColumnAndRow(6, 2, "Nombres");
    		$sheet->setCellValueByColumnAndRow(7, 2, "Semestre");
    		$sheet->setCellValueByColumnAndRow(8, 2, "Grupo");
    		$sheet->setCellValueByColumnAndRow(9, 2, "Correo");

    		$fila = 3;
    		foreach($programa_cursos as $curso) {
    			$sheet->setCellValue("A{$fila}", $curso['progClave']);
    			$sheet->setCellValue("B{$fila}", $curso['progNombre']);
    			$sheet->setCellValueExplicit("C{$fila}", $curso['aluClave'], DataType::TYPE_STRING);
    			$sheet->setCellValueExplicit("D{$fila}", $curso['aluMatricula'], DataType::TYPE_STRING);
                $sheet->setCellValue("E{$fila}", $curso['apellidos']);
    			$sheet->setCellValue("F{$fila}", $curso['nombres']);
    			$sheet->setCellValue("G{$fila}", $curso['grado']);
    			$sheet->setCellValue("H{$fila}", $curso['grupo']);
    			$sheet->setCellValue("I{$fila}", $curso['perCorreo1']);
    			$fila++;
    		}

    	});

    	$writer = new Xlsx($spreadsheet);
    	try {
    	    $writer->save(storage_path("AlumnosUltimoGrado.xlsx"));
    	} catch (Exception $e) {
    	    alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
    	    return back()->withInput();
    	}

    	return response()->download(storage_path("AlumnosUltimoGrado.xlsx"));
    }
}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ListaPorTipoIngresoController extends Controller
{
	public $cursos;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:lista_por_tipo_ingreso']);
    	$this->cursos = new Collection;
    }

    public function reporte()
    {
    	return view('reportes/lista_por_tipo_ingreso.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	self::buscarCursos($request)->chunk(100, function($registros) {
    		if($registros->isEmpty())
    			return false;

    		$registros->each(function($curso) {
    			$this->cursos->push(self::info_esencial($curso));
    		});
    	});

    	if($this->cursos->isEmpty()) {
    		alert('Sin coincidencias', 'No se encontraron datos con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
    		return back()->withInput();
    	}

    	return $this->generarExcel();
    }

    /**
	* @param Illuminate\Http\Request
    */
    private static function buscarCursos($request)
    {
    	return Curso::with(['alumno.persona', 'periodo', 'cgt.plan.programa'])
    	->whereHas('periodo', static function($query) use ($request) {
    		$query->where('departamento_id', $request->departamento_id);
    	})
    	->whereHas('cgt.plan.programa', static function($query) use ($request) {
    		if($request->periodo_id)
    			$query->where('periodo_id', $request->periodo_id);
    		if($request->plan_id)
    			$query->where('plan_id', $request->plan_id);
    		if($request->programa_id)
    			$query->where('programa_id', $request->programa_id);
    		if($request->escuela_id)
    			$query->where('escuela_id', $request->escuela_id);
    		if($request->cgtGradoSemestre)
    			$query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
    	})
    	->where('curEstado', '<>', 'B')
    	->whereIn('curTipoIngreso', ['EQ', 'RO', 'RE']);
    }

    /**
	* @param App\Http\Models\Curso
    */
    private static function info_esencial($curso)
    {
    	$periodo = $curso->periodo;
    	$alumno = $curso->alumno;
    	$persona = $alumno->persona;
    	$cgt = $curso->cgt;
    	$plan = $cgt->plan;
    	$programa = $plan->programa;
        $nombreCompleto = MetodosPersonas::nombreCompleto($persona, true);

    	return [
    		'perNumero' => $periodo->perNumero,
    		'perAnio' => $periodo->perAnio,
    		'aluClave' => $alumno->aluClave,
    		'nombreCompleto' => $nombreCompleto,
    		'progClave' => $programa->progClave,
    		'progNombre' => $programa->progNombre,
    		'planClave' => $plan->planClave,
    		'grado' => $cgt->cgtGradoSemestre,
    		'grupo' => $cgt->cgtGrupo,
    		'curEstado' => $curso->curEstado,
    		'curTipoIngreso' => $curso->curTipoIngreso,
    		'edad' => $persona->edad(),
    		'perSexo' => $persona->perSexo,
            'orden' => "{$curso->curTipoIngreso}-{$programa->progClave}-{$nombreCompleto}",
    	];
    }

    private function generarExcel()
    {
        $this->cursos = $this->cursos->sortBy('orden');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	    $sheet->getStyle('A2:M2')->getFont()->setBold(true);
	    $sheet->getColumnDimension('D')->setAutoSize(true); # nombre alumno
	    $sheet->getColumnDimension('F')->setAutoSize(true); # nombre carrera
	    $sheet->setCellValueByColumnAndRow(1, 2, "num_per_cur");
	    $sheet->setCellValueByColumnAndRow(2, 2, "anio_per_cur");
	    $sheet->setCellValueByColumnAndRow(3, 2, "clave_pago_cur");
	    $sheet->setCellValueByColumnAndRow(4, 2, "Nombre alumno");
	    $sheet->setCellValueByColumnAndRow(5, 2, "clave_carr_cur");
	    $sheet->setCellValueByColumnAndRow(6, 2, "nombre_carr");
	    $sheet->setCellValueByColumnAndRow(7, 2, "clave_plan_cur");
	    $sheet->setCellValueByColumnAndRow(8, 2, "grado_sem_cur");
	    $sheet->setCellValueByColumnAndRow(9, 2, "grupo_cur");
	    $sheet->setCellValueByColumnAndRow(10, 2, "estado_cur");
	    $sheet->setCellValueByColumnAndRow(11, 2, "tipo_ingr_cur");
	    $sheet->setCellValueByColumnAndRow(12, 2, "edad");
	    $sheet->setCellValueByColumnAndRow(13, 2, "sexo");

	    $fila = 3;
	    foreach ($this->cursos as $key => $curso) {
	        $sheet->setCellValue("A{$fila}", $curso['perNumero']);
	        $sheet->setCellValue("B{$fila}", $curso['perAnio']);
	        $sheet->setCellValueExplicit("C{$fila}", $curso['aluClave'], DataType::TYPE_STRING);
	        $sheet->setCellValue("D{$fila}", $curso['nombreCompleto']);
	        $sheet->setCellValue("E{$fila}", $curso['progClave']);
	        $sheet->setCellValue("F{$fila}", $curso['progNombre']);
	        $sheet->setCellValue("G{$fila}", $curso['planClave']);
	        $sheet->setCellValue("H{$fila}", $curso['grado']);
	        $sheet->setCellValue("I{$fila}", $curso['grupo']);
	        $sheet->setCellValue("J{$fila}", $curso['curEstado']);
	        $sheet->setCellValue("K{$fila}", $curso['curTipoIngreso']);
	        $sheet->setCellValue("L{$fila}", $curso['edad']);
	        $sheet->setCellValue("M{$fila}", $curso['perSexo']);
	        $fila++;
	    }

		$writer = new Xlsx($spreadsheet);
	    try {
	        $writer->save(storage_path("ListaPorTipoIngreso.xlsx"));
	    } catch (Exception $e) {
	        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
	        return back()->withInput();
	    }

	    return response()->download(storage_path("ListaPorTipoIngreso.xlsx"));
    }
}

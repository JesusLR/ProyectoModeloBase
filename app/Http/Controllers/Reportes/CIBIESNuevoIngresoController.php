<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Curso;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;
use Exception;

class CIBIESNuevoIngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:cibies_nuevo_ingreso']);
    }

    public function reporte()
    {
        return view('reportes/cibies_nuevo_ingreso.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'anio' => Carbon::now('America/Merida')->year,
        ]);
    }

    public function imprimir(Request $request)
    {
        $cursos = new Collection;
        self::buscarCursos($request)
        ->chunk(150, static function($registros) use ($cursos) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($curso) use ($cursos) {
                $cursos->push(self::info_esencial($curso));
            });
        });

        if($cursos->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $cursos);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'ciclo_escolar' => "{$periodo->perAnioPago} - " . ($periodo->perAnioPago + 1),
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarCursos($request)
    {
        return Curso::with(['alumno.persona.municipio.estado.pais', 'cgt.plan.programa'])
        ->where('periodo_id', $request->periodo_id)
        ->where('curEstado', '!=', 'B')
        ->whereIn('curTipoIngreso', ['PI', 'NI'])
        ->whereHas('cgt.plan.programa', static function($query) use ($request) {
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        });
    }

    /**
     * @param App\Http\Models\Curso
     */
    private static function info_esencial($curso)
    {
        $alumno = $curso->alumno;
        $persona = $alumno->persona;
        $plan = $curso->cgt->plan;
        $programa = $plan->programa;
        $municipio = $persona->municipio;
        $estado = $municipio ? $municipio->estado : null;
        $pais = $estado ? $estado->pais : null;

        $esYucateco = $estado && $estado->edoNombre == 'Yucatán';
        $esMexicano = $pais && $pais->paisNombre == 'México';
        $nombreCompleto = $persona->nombreCompleto(true);

        return [
            'aluClave' => $alumno->aluClave,
            'nombreCompleto' => $nombreCompleto,
            'edad' => $persona->edad(),
            'sexo' => $persona->esMujer() ? 'Mujer' : 'Hombre',
            'munNombre' => $esYucateco ? $municipio->munNombre : '',
            'edoNombre' => !$esYucateco && $esMexicano ? ($estado ? $estado->edoNombre : '') : '',
            'paisNombre' => !$esMexicano ? ($pais ? $pais->paisNombre : '') : '',
            'carrera' => $programa->progClave . ' (' . $plan->planClave . ') ' . $programa->progNombre,
            'curExani' => $curso->curExani,
            'orden' => $nombreCompleto,
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $cursos) {

        $departamento = $info_reporte['departamento'];
        $ubicacion = $info_reporte['ubicacion'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->getStyle('B4')->getFont()->setBold(true);
        $sheet->getStyle('B5')->getFont()->setBold(true);
        $sheet->getStyle('B6')->getFont()->setBold(true);
        $sheet->mergeCells("C1:E1");
        $sheet->mergeCells("C2:E2");
        $sheet->mergeCells("C3:E3");
        $sheet->mergeCells("C4:E4");
        $sheet->mergeCells("C5:E5");
        $sheet->mergeCells("C6:E6");
        $sheet->setCellValue('B1', 'NOMBRE DE LA INSTITUCIÓN');
        $sheet->setCellValue('B2', 'ALUMNOS SOLICITANTES');
        $sheet->setCellValue('B3', 'ALUMNOS SUSTENTANTES');
        $sheet->setCellValue('B4', 'ALUMNOS ADMITIDOS');
        $sheet->setCellValue('B5', 'ALUMNOS INSCRITOS');
        $sheet->setCellValue('B6', 'CICLO ESCOLAR');
        $sheet->setCellValue('C1', "{$ubicacion->ubiNombre} - {$departamento->depNombre}");
        # Celdas C2 y C3 no se llenan.
        $sheet->setCellValue('C4', $cursos->count());
        $sheet->setCellValue('C5', $cursos->count());
        $sheet->setCellValue('C6', $info_reporte['ciclo_escolar']);

        $sheet->getStyle("A9:V9")->getFont()->setBold(true); #tabla principal

        $sheet->setCellValueByColumnAndRow(1, 9, "CLAVE ALUMNO");
        $sheet->setCellValueByColumnAndRow(2, 9, "NOMBRE COMPLETO DEL ALUMNO");
        $sheet->setCellValueByColumnAndRow(3, 9, "EDAD");
        $sheet->setCellValueByColumnAndRow(4, 9, "SEXO");
        $sheet->setCellValueByColumnAndRow(5, 9, "YUCATÁN (MUNICIPIO)");
        $sheet->setCellValueByColumnAndRow(6, 9, "OTRO ESTADO");
        $sheet->setCellValueByColumnAndRow(7, 9, "OTRO PAÍS (ESCRIBIR)");
        $sheet->setCellValueByColumnAndRow(8, 9, "HABLA MAYA");
        $sheet->setCellValueByColumnAndRow(9, 9, "DISCAPACIDAD");
        $sheet->setCellValueByColumnAndRow(10, 9, "TIPO DE DISCAPACIDAD");
        $sheet->setCellValueByColumnAndRow(11, 9, "PROGRAMA EDUCATIVO QUE CURSA");
        $sheet->setCellValueByColumnAndRow(12, 9, "NIVEL");
        $sheet->setCellValueByColumnAndRow(13, 9, "RESULTADO CENEVAL");
        $sheet->setCellValueByColumnAndRow(14, 9, "TIPO DE BACHILLERATO DE PROCEDENCIA");
        $sheet->setCellValueByColumnAndRow(15, 9, "SISTEMA DEL BACHILLERATO DE PROCEDENCIA");
        $sheet->setCellValueByColumnAndRow(16, 9, "CONTÓ CON APOYO EN EL BACHILLERATO");
        $sheet->setCellValueByColumnAndRow(17, 9, "NOMBRE(S) DE PROGRAMA(S) DE APOYO EN EL BACHILLERATO (ESPECIFICAR)");
        $sheet->setCellValueByColumnAndRow(18, 9, "CUENTA CON APOYO ACTUALMENTE");
        $sheet->setCellValueByColumnAndRow(19, 9, "TIPOS DE APOYO 1 (ELEGIR)");
        $sheet->setCellValueByColumnAndRow(20, 9, "TIPOS DE APOYO 2 (ELEGIR)");
        $sheet->setCellValueByColumnAndRow(21, 9, "TIPOS DE APOYO 3 (ELEGIR)");
        $sheet->setCellValueByColumnAndRow(22, 9, "OTROS, EN CASO DE NO ENCONTRARSE EN LAS LISTAS ANTERIORES");

        $fila = 10;
        foreach($cursos->sortBy('orden') as $curso) {
            $sheet->setCellValueExplicit("A{$fila}", $curso['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $curso['nombreCompleto']);
            $sheet->setCellValue("C{$fila}", $curso['edad']);
            $sheet->setCellValue("D{$fila}", $curso['sexo']);
            $sheet->setCellValue("E{$fila}", $curso['munNombre']);
            $sheet->setCellValue("F{$fila}", $curso['edoNombre']);
            $sheet->setCellValue("G{$fila}", $curso['paisNombre']);
            # H, I y J no se llenan.
            $sheet->setCellValue("K{$fila}", $curso['carrera']);
            $sheet->setCellValue("L{$fila}", $departamento->depClave);
            $sheet->setCellValue("M{$fila}", $curso['curExani']);

            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CIBIESNuevoIngreso.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CIBIESNuevoIngreso.xlsx"));
    }
}

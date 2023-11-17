<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Curso;
use App\Http\Models\Egresado;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;
use Exception;


class HistoricoMatriculaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:historico_matricula']);
    }

    public function reporte() {

        return view('reportes/historico_matricula.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'anio' => Carbon::now('America/Merida')->year,
        ]);
    }

    public function imprimir(Request $request) {

        $ciclos = self::recolectarEstadisticaPorCiclo($request)->get();
        if($ciclos->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $info_reporte = self::obtenerInfoReporte($request);

        return $this->generarExcel($info_reporte, $ciclos);

    }

    private static function recolectarEstadisticaPorCiclo($request)
    {
        return Periodo::select('periodos.id AS periodo_id', 'periodos.perNumero', 'periodos.perAnio', 'periodos.perAnioPago',
            'ubicacion.ubiClave', 'departamentos.depClave', 'ubicacion.ubiNombre', 'departamentos.depNombre',
            'cursos_inscritos.total_inscritos', 'cursos_inscritos.perSexo AS sexo', 
            'nuevo_ingreso.total_nuevo_ingreso', 'nuevo_ingreso.perSexo AS sexo_nuevo_ingreso', 
            'reincorporados.total_reincorporados', 'reincorporados.perSexo AS sexo_reincorporados',
            'alumnos_egresados.total_egresados', 'alumnos_egresados.perSexo AS sexo_egresados'
        )
        ->join('departamentos', 'departamentos.id', 'periodos.departamento_id')
        ->join('ubicacion', 'ubicacion.id', 'departamentos.ubicacion_id')
        ->joinSub(self::censarInscritosSubQuery($request), 'cursos_inscritos', static function($join) {
            $join->on('periodos.id', 'cursos_inscritos.inscritos_periodo_id');
        })
        ->joinSub(self::censarInscritosSubQuery($request, 'nuevo_ingreso'), 'nuevo_ingreso', static function($join) {
            $join->on('periodos.id', 'nuevo_ingreso.nuevo_ingreso_periodo_id')
                ->on('nuevo_ingreso.perSexo', 'cursos_inscritos.perSexo');
        })
        ->joinSub(self::censarInscritosSubQuery($request, 'reincorporados'), 'reincorporados', static function($join) {
            $join->on('periodos.id', 'reincorporados.reincorporados_periodo_id')
                ->on('reincorporados.perSexo', 'cursos_inscritos.perSexo');
        })
        ->leftJoinSub(self::censarEgresadosSubQuery($request), 'alumnos_egresados', static function($join) {
            $join->on('periodos.perAnioPago', 'alumnos_egresados.egresados_perAnioPago')
                ->on('alumnos_egresados.perSexo', 'cursos_inscritos.perSexo');
        })
        ->where(static function($query) use ($request) {
            $query->where([
                ['periodos.departamento_id', $request->departamento_id],
                ['periodos.perEstado', 'S'],
                ['periodos.perNumero', 3]
            ]);
            if($request->anio1)
                $query->where('periodos.perAnioPago', '>=', $request->anio1);
            if($request->anio2)
                $query->where('periodos.perAnioPago', '<=', $request->anio2);
        });
    }

    /**
     * Realiza el censo de todos los cursos que no sean baja.
     * 
     * @param Illuminate\Http\Request
     * @param string $filtro
     */
    private static function censarInscritosSubQuery($request, $filtro = null)
    {
        $clave = $filtro ?: 'inscritos';

        return Curso::select(DB::raw("count(*) as total_{$clave}"), 'personas.perSexo',
            "cursos.periodo_id AS {$clave}_periodo_id"
        )
        ->join('alumnos', 'alumnos.id', 'cursos.alumno_id')
        ->join('personas', 'personas.id', 'alumnos.persona_id')
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->join('planes', 'planes.id', 'cgt.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->where('curEstado', '<>', 'B')
        ->where(static function($query) use ($request, $filtro) {
            $query->whereIn('personas.perSexo', ['M', 'F']);
            if($filtro == 'nuevo_ingreso') {
                $query->whereIn('curTipoIngreso', ['PI', 'NI']);
            } else if($filtro == 'reincorporados') {
                $query->whereIn('curTipoIngreso', ['RI', 'EQ', 'RO', 'RE', 'RN', 'RR']);
            } else {
                $query->whereIn('curTipoIngreso', ['PI', 'NI', 'RI', 'EQ', 'RO', 'RE', 'RN', 'RR']);
            }

            if($request->programa_id)
                $query->where('programas.id', $request->programa_id);
            if($request->escuela_id)
                $query->where('programas.escuela_id', $request->escuela_id);
        })
        ->groupBy('cursos.periodo_id', 'personas.perSexo');
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function censarEgresadosSubQuery($request)
    {
        return Egresado::select(DB::raw("count(*) as total_egresados"), 'personas.perSexo', 'periodos.perAnioPago AS egresados_perAnioPago')
        ->join('alumnos', 'alumnos.id', 'egresados.alumno_id')
        ->join('personas', 'personas.id', 'alumnos.persona_id')
        ->join('planes', 'planes.id', 'egresados.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('escuelas', 'escuelas.id', 'programas.escuela_id')
        ->join('periodos', 'periodos.id', 'egresados.periodo_id')
        ->where(static function($query) use ($request) {
            $query->where('escuelas.departamento_id', $request->departamento_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->groupBy('periodos.perAnioPago', 'personas.perSexo');
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerInfoReporte($request) {
        $departamento = Departamento::with('ubicacion')->findOrFail($request->departamento_id);

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'rango_anios' => "Rango de años: {$request->anio1} a {$request->anio2}",
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $ciclos) {

        $anios = $ciclos->keyBy('perAnioPago')->sortKeys()->keys();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->mergeCells("A1:R1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['rango_anios']}");

        $sheet->getStyle("A2:R2")->getFont()->setBold(true);
        $sheet->mergeCells("B2:I2"); # Aspirantes (Proceso Propio Institución).
        $sheet->mergeCells("J2:K2"); # AP Externos.
        $sheet->setCellValue('B2', 'ASPIRANTES (PROCESO PROPIO INSTITUCIÓN)');
        $sheet->setCellValue('J2', 'AP EXTERNOS');

        $sheet->getStyle("A3:R3")->getFont()->setBold(true);
        $sheet->mergeCells("B3:C3"); # Solicitantes.
        $sheet->mergeCells("D3:E3"); # Sustentantes.
        $sheet->mergeCells("F3:G3"); # Admitidos.
        $sheet->mergeCells("H3:I3"); # Inscritos. (Sección Aspirantes).
        $sheet->mergeCells("J3:K3"); # Inscritos. (Sección AP Externos).
        $sheet->mergeCells("L3:N3"); # Total de Inscritos.
        $sheet->mergeCells("O3:R3"); # Alumnos.
        $sheet->setCellValue('B3', 'SOLICITANTES');
        $sheet->setCellValue('D3', 'SUSTENTANTES');
        $sheet->setCellValue('F3', 'ADMITIDOS');
        $sheet->setCellValue('H3', 'INSCRITOS');
        $sheet->setCellValue('J3', 'INSCRITOS');
        $sheet->setCellValue('L3', 'TOTAL DE INSCRITOS');
        $sheet->setCellValue('O3', 'ALUMNOS');

        $sheet->getStyle("A4:R4")->getFont()->setBold(true);
        $sheet->setCellValue('A4', 'CICLO');
        $columna = 'B';
        for($i = 1; $i < 7; $i++) {
            $sheet->setCellValue("{$columna}4", 'H');
            $columna++;    
            $sheet->setCellValue("{$columna}4", 'M');    
            $columna++;
        }
        $sheet->setCellValue('N4', 'TOTAL');
        $sheet->setCellValue('O4', 'MATRÍCULA TOTAL');
        $sheet->setCellValue('P4', 'NUEVO INGRESO');
        $sheet->setCellValue('Q4', 'REINCORPORADOS');
        $sheet->setCellValue('R4', 'EGRESADOS');


        $fila = 5;
        foreach($anios as $anio) {
            $sheet->setCellValueExplicit("A{$fila}", ($anio . ' - ' . ($anio + 1)), DataType::TYPE_STRING);
            $sheet->setCellValue("F{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso', 'M'));
            $sheet->setCellValue("G{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso', 'F'));
            $sheet->setCellValue("H{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso', 'M'));
            $sheet->setCellValue("I{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso', 'F'));
            $sheet->setCellValue("L{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso', 'M'));
            $sheet->setCellValue("M{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso', 'F'));
            $sheet->setCellValue("N{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso'));
            $sheet->setCellValue("O{$fila}", "=SUM(P{$fila}:Q{$fila})"); 
            $sheet->getCell("O{$fila}")->getStyle()->setQuotePrefix(true); # hace que lea la fórmula.
            $sheet->setCellValue("P{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_nuevo_ingreso'));
            $sheet->setCellValue("Q{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_reincorporados'));
            $sheet->setCellValue("R{$fila}", self::contarInscritosPorAnio($ciclos, $anio, 'total_egresados'));
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("HistoricoMatricula.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("HistoricoMatricula.xlsx"));
    }

    /**
     * @param Illuminate\Http\Collection $ciclos
     * @param int $anio
     * @param string $filtro
     * @param string $sexo
     */
    private static function contarInscritosPorAnio($ciclos, $anio, $filtro = null, $sexo = null): int
    {
        $filtro = $filtro ?: 'total_inscritos';

        $filtrados = $ciclos->where('perAnioPago', $anio);

        if($sexo)
            return $filtrados->where('sexo', $sexo)->sum($filtro);

        return $filtrados->sum($filtro);
    }
}

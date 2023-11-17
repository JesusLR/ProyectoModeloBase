<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Curso;
use App\Http\Models\Pago;
use App\Http\Helpers\Utils;
use App\Http\Helpers\UltimaFechaPago;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;

class RelacionPagosCompletosController extends Controller
{
    private static $departamento;

    public function __construct() {
        $this->middleware(['auth', 'permisos:relacion_pagos_completos']);
    }

    public function reporte() {

        return view('reportes/relacion_pagos_completos.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'anio' => Carbon::now('America/Merida')->year,
        ]);
    }

    public function imprimir(Request $request) {

        $periodos = self::buscarPeriodos($request);
        if($periodos->isEmpty())
            return self::alert_verificacion(1);

        $periodoBase = self::determinarPeriodoBase($periodos, $request);
        self::$departamento = $periodoBase->departamento;

        if(!self::buscarCursosBases($request, $periodoBase)->exists())
            return self::alert_verificacion(2);

        $alumnos = new Collection;
        self::buscarCursosBases($request, $periodoBase)
        ->chunk(150, static function($cursos) use ($request, $alumnos) {
            if($cursos->isEmpty())
                return false;

            $pagos = self::buscarPagosPorCursosEnAnio($cursos, $request);

            $cursos->each(static function($curso) use ($alumnos, $pagos) {
                $pagosAlumno = $pagos->pull($curso->alumno->aluClave);
                if($pagosAlumno && self::tieneTodosLosPagos($curso, $pagosAlumno))
                    $alumnos->push(self::info_esencial_alumno($curso, $pagosAlumno));
            });
        });

        if($alumnos->isEmpty())
            return self::alert_verificacion(3);

        $periodos->each(static function($periodo) use ($alumnos) {
            $cursos = self::buscarCursosPorPeriodo($periodo, $alumnos);

            $alumnos->each(static function($alumno) use ($cursos, $periodo) {
                $curso = $cursos->pull($alumno['alumno_id']);
                if($curso)
                    $alumno['cursos_antes']->put($periodo->id, $curso);
            });
        });

        $info_reporte = [
            'periodoBase' => $periodoBase,
            'periodos' => $periodos, #Periodos anteriores (del mismo perAnioPago)
            'request' => $request,
        ];

        return $this->generarExcel($info_reporte, $alumnos);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarPeriodos($request) {

        return Periodo::with('departamento.ubicacion')
        ->where([
            ['departamento_id', $request->departamento_id],
            ['perAnioPago', $request->perAnioPago],
            ['perEstado', $request->perEstado]
        ])
        ->oldest('perFechaInicial')->get();
    }

    /**
     * @param Illuminate\Support\Collection $periodos
     * @param Illuminate\Http\Request $request
     */
    private static function determinarPeriodoBase($periodos, $request) {
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');

        if($request->cgtGradoSemestre) {
            return $periodos->sortByDesc('perFechaInicial')->where('perFechaInicial', '<', $hoy)->first();
        } else {
            return $periodos->first();
        }
    }

    private static function alert_verificacion($test = null) {
        alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.('.$test.')', 'warning')->showConfirmButton();
        return back()->withInput();
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param App\Http\Models\Periodo $periodoBase
     */
    private static function buscarCursosBases($request, $periodoBase) {

        return Curso::with(['alumno.persona', 'cgt.plan.programa'])
        ->whereHas('periodo', static function($query) use ($periodoBase) {
            $query->where([
                ['departamento_id', $periodoBase->departamento_id],
                ['perAnioPago', $periodoBase->perAnioPago],
                ['perNumero', $periodoBase->perNumero],
                ['perEstado', $periodoBase->perEstado]
            ]);
        })
        ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->cgtGradoSemestre)
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
        });
    }

    /**
     * @param App\Http\Models\Curso
     * @param Illuminate\Support\Collection $pagos
     */
    private static function info_esencial_alumno($curso, $pagos) {
        $alumno = $curso->alumno;

        return [
            'alumno_id' => $alumno->id,
            'aluClave' => $alumno->aluClave,
            'nombreCompleto' => $alumno->persona->nombreCompleto(true),
            'pagos' => $pagos->keyBy('pagConcPago'),
            'cursos_antes' => new Collection,
        ];
    }

    /**
     * @param Illuminate\Support\Collection $cursos
     * @param Illuminate\Http\Request $request
     */
    private static function buscarPagosPorCursosEnAnio($cursos, $request) {

        $conceptos = [
            '99', '01', '02', '03', '04', '05', '00', 
            '06', '07', '08', '09', '10', '11', '12',
        ];

        return Pago::select('pagClaveAlu', 'pagConcPago', 'pagImpPago')
        ->where(static function($query) use ($request, $cursos, $conceptos) {
            $query->whereIn('pagClaveAlu', $cursos->pluck('alumno.aluClave'))
                ->whereIn('pagConcPago', $conceptos)
                ->where('pagAnioPer', $request->perAnioPago);
            if($request->pagImpPago)
                $query->where('pagImpPago', '>=', $request->pagImpPago);
        })
        ->latest('pagFechaPago')
        ->get()
        ->groupBy('pagClaveAlu')
        ->map(static function($pagos_alumno) {
            return $pagos_alumno->unique('pagConcPago');
        });
    }

    /**
     * Basado en el curPlanPago, define la cantidad de pagos que debe tener el alumno.
     * - departamento PRI no paga inscripción 00.
     * - Campus CVA tiene 13 pagos.
     * 
     * @param App\Http\Models\Curso $curso
     * @param Illuminate\Support\Collection $pagos
     */
    private static function tieneTodosLosPagos($curso, $pagos) {
        $ubicacion = self::$departamento->ubicacion;

        $numeroDePagos = $curso->curPlanPago == 'D' ? 13 : 12;

        if(self::$departamento->depClave == 'PRI' && $curso->curPlanPago == 'N')
            $numeroDePagos = 11;

        if($ubicacion->ubiClave == 'CVA')
            $numeroDePagos = $curso->curPlanPago == 'N' ? 11 : 13;

        return $pagos->count() == $numeroDePagos;
    }

    /**
     * @param App\Http\Models\Periodo $periodo
     * @param Illuminate\Support\Collection $alumnos
     */
    private static function buscarCursosPorPeriodo($periodo, $alumnos) {
        $clave = "periodo{$periodo->perNumero}";

        return Curso::select("cursos.alumno_id AS {$clave}_alumno_id", "cursos.curEstado AS {$clave}_curEstado",
            "cursos.curPlanPago AS {$clave}_curPlanPago", "cursos.curAnioCuotas AS {$clave}_curAnioCuotas", "alumnos.aluEstado AS {$clave}_aluEstado",
            "cgt.cgtGradoSemestre AS {$clave}_grado","cgt.cgtGrupo AS {$clave}_grupo", "programas.progClave AS {$clave}_progClave"
        )
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->join('planes', 'planes.id', 'cgt.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('alumnos', 'alumnos.id', 'cursos.alumno_id')
        ->join('periodos', 'periodos.id', 'cursos.periodo_id')
        ->whereIn('cursos.alumno_id', $alumnos->pluck('alumno_id'))
        ->where('periodos.id', $periodo->id)
        ->oldest('cursos.curFechaRegistro')
        ->get()
        ->keyBy("{$clave}_alumno_id");
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($info_reporte, $alumnos) {

        $ubicacion = self::$departamento->ubicacion;
        $periodos = $info_reporte['periodos'];
        $request = $info_reporte['request'];
        $titulo = "{$ubicacion->ubiClave} - " . self::$departamento->depClave ." - Año escolar {$request->perAnioPago}";
        $titulo .=  "       Última fecha de pago: " . UltimaFechaPago::ultimoPago();

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
        $sheet->mergeCells("A1:BD1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', $titulo);
        $sheet->getStyle("A2:BD2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Clave de pago");
        $sheet->setCellValueByColumnAndRow(2, 2, "Nombre alumno");
        $encabezado = 2;
        if($periodos->isNotEmpty()) {
            foreach($periodos as $periodo) {
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Periodo-Año");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Programa");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Grado");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Grupo");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Pago");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Curso Estado");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Alumno Estado");
                $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Curso cuota");
            }
        }
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Inscripción");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Septiembre");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Octubre");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Noviembre");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Diciembre");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Enero");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Inscripción");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Febrero");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Marzo");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Abril");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Mayo");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Junio");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Julio");
        $sheet->setCellValueByColumnAndRow((++$encabezado), 2, "Agosto");

        $fila = 3;
        foreach($alumnos->sortBy('nombreCompleto') as $alumno) {
            $pagos = $alumno['pagos'];

            $sheet->setCellValueExplicit("A{$fila}", $alumno['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $alumno['nombreCompleto']);
            $columna = "B";
            if($periodos->isNotEmpty()) {
                foreach($periodos as $periodo) {
                    $sheet->setCellValueExplicit((++$columna . $fila), ("{$periodo->perNumero}-{$periodo->perAnio}"), DataType::TYPE_STRING);
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'progClave'));
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'grado'));
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'grupo'));
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'curPlanPago'));
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'curEstado'));
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'aluEstado'));
                    $sheet->setCellValue((++$columna . $fila), self::mostrarAtributoDeCurso($alumno, $periodo, 'curAnioCuotas'));
                }
            }
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '99'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '01'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '02'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '03'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '04'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '05'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '00'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '06'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '07'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '08'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '09'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '10'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '11'));
            $sheet->setCellValue((++$columna . $fila), self::mostrarImportePorConcepto($pagos, '12'));
            $fila++;
            $columna = "B"; # comenzará la fila de otro alumno.
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("RelacionPagosCompletos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("RelacionPagosCompletos.xlsx"));
    }

    /**
     * Si el alumno tiene un 'cursos_antes' en el periodo_id indicado, devuelve el atributo solicitado.
     * 
     * @param array $alumno_info
     * @param App\Http\Models\Periodo $periodo
     * @param string $atributo_curso
     */
    private static function mostrarAtributoDeCurso($alumno, $periodo, $atributo_curso) {
        $atributo = "periodo{$periodo->perNumero}_{$atributo_curso}";
        $curso = $alumno['cursos_antes']->get($periodo->id);

        return $curso ? $curso->{$atributo} : null;
    }

    /**
     * Verifica que exista el pago por medio del concepto, muestra el importe.
     * 
     * @param Illuminate\Support\Collection $pagos
     * @param string $concepto
     */
    private static function mostrarImportePorConcepto($pagos, $concepto) {
        $pago = $pagos->get($concepto);

        return $pago ? $pago->pagImpPago : null;
    }
}

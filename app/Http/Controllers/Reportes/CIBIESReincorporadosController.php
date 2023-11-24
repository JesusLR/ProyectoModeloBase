<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Curso;
use App\Models\Calificacion;
use App\clases\periodos\MetodosPeriodos;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Exception;

class CIBIESReincorporadosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:cibies_reincorporados']);
    }

    public function reporte() {
        return view('reportes/cibies_reincorporados.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        $reincorporados = new Collection;
        self::buscarReincorporados($request)
        ->chunk(150, static function($registros) use ($reincorporados) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($curso) use ($reincorporados) {
                $reincorporados->push(self::info_esencial($curso));
            });
        });

        if($reincorporados->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $info_reporte = self::obtenerInfoReporte($request);

        $info_reporte['total_reprobados'] = self::buscarReprobadosQuery($request, $info_reporte['periodo_anterior'])
            ->having('promedioTotal', '<', $info_reporte['departamento']->depCalMinAprob)
            ->get()->count();

        return $this->generarExcel($info_reporte, $reincorporados);
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
            'periodo_anterior' => MetodosPeriodos::buscarAnteriores($periodo, $periodo->perEstado)->first(),
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
    public function buscarReincorporados($request)
    {
        return Curso::with(['alumno.persona.municipio.estado.pais', 'cgt.plan.programa.escuela'])
        ->where('periodo_id', $request->periodo_id)
        ->where('curEstado', '!=', 'B')
        ->whereIn('curTipoIngreso', ['RI', 'EQ', 'RO', 'RE', 'RN', 'RR'])
        ->whereHas('cgt.plan.programa', static function($query) use ($request) {
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        });
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param App\Models\Periodo $periodo
     */
    public function buscarReprobadosQuery($request, $periodo)
    {
        return Calificacion::select(DB::raw("FORMAT(AVG(calificaciones.incsCalificacionFinal), 2) AS promedioTotal"), 'cursos.alumno_id')
        ->join('inscritos', 'inscritos.id', 'calificaciones.inscrito_id')
        ->join('grupos', 'grupos.id', 'inscritos.grupo_id')
        ->join('cursos', 'cursos.id', 'inscritos.curso_id')
        ->join('materias', 'materias.id', 'grupos.materia_id')
        ->join('planes', 'planes.id', 'materias.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('escuelas', 'escuelas.id', 'programas.escuela_id')
        ->join('periodos', 'periodos.id', 'grupos.periodo_id')
        ->where(static function($query) use ($request, $periodo) {
            $query->where([
                ['periodos.id', $periodo->id],
                ['materias.matTipoAcreditacion', 'N'],
                ['cursos.curEstado', '!=', 'B']
            ]);
            $query->whereNull('grupos.deleted_at');

            if($request->programa_id)
                $query->where('programas.id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuelas.id', $request->escuela_id);

        })
        ->groupBy('cursos.alumno_id', 'planes.id');
    }

    /**
     * @param App\Models\Curso
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
            'carrera' => $programa->progNombre,
            'escClave' => $programa->escuela->escClave,
            'grado' => $curso->cgt->cgtGradoSemestre,
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
        $sheet->mergeCells("C1:E1");
        $sheet->mergeCells("C2:E2");
        $sheet->mergeCells("C3:E3");
        $sheet->mergeCells("C4:E4");
        $sheet->setCellValue('B1', 'NOMBRE DE LA INSTITUCIÓN');
        $sheet->setCellValue('B2', 'TOTAL ALUMNOS QUE REPROBARON CURSO:');
        $sheet->setCellValue('B3', 'TOTAL DE ALUMNOS RETENIDOS DEL CICLO ANTERIOR:');
        $sheet->setCellValue('B4', 'CICLO ESCOLAR');
        $sheet->setCellValue('C1', "{$ubicacion->ubiNombre} - {$departamento->depNombre}");
        $sheet->setCellValue('C2', $info_reporte['total_reprobados']);
        $sheet->setCellValue('C3', $cursos->count());
        $sheet->setCellValue('C4', $info_reporte['ciclo_escolar']);

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
        $sheet->setCellValueByColumnAndRow(13, 9, "PERIODO LECTIVO AL QUE SE INSCRIBE (GRADO)");
        $sheet->setCellValueByColumnAndRow(14, 9, "CONTÓ CON APOYO EN EL BACHILLERATO");
        $sheet->setCellValueByColumnAndRow(15, 9, "NOMBRE(S) DE PROGRAMA(S) DE APOYO EN EL BACHILLERATO (ESPECIFICAR)");
        $sheet->setCellValueByColumnAndRow(16, 9, "CUENTA CON APOYO ACTUALMENTE");
        $sheet->setCellValueByColumnAndRow(17, 9, "TIPOS DE APOYO 1 (ELEGIR)");
        $sheet->setCellValueByColumnAndRow(18, 9, "TIPOS DE APOYO 2 (ELEGIR)");
        $sheet->setCellValueByColumnAndRow(19, 9, "TIPOS DE APOYO 3 (ELEGIR)");
        $sheet->setCellValueByColumnAndRow(20, 9, "OTROS, EN CASO DE NO ENCONTRARSE EN LAS LISTAS ANTERIORES");

        $fila = 10;
        foreach($cursos->sortBy('orden') as $curso) {
            $nivel = 'Licenciatura';
            if($departamento->depClave == 'POS')
                $nivel = $curso['escClave'] == 'MAE' ? 'Maestría' : 'Especialización';

            $sheet->setCellValueExplicit("A{$fila}", $curso['aluClave'], DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $curso['nombreCompleto']);
            $sheet->setCellValue("C{$fila}", $curso['edad']);
            $sheet->setCellValue("D{$fila}", $curso['sexo']);
            $sheet->setCellValue("E{$fila}", $curso['munNombre']);
            $sheet->setCellValue("F{$fila}", $curso['edoNombre']);
            $sheet->setCellValue("G{$fila}", $curso['paisNombre']);
            # H, I y J no se llenan.
            $sheet->setCellValue("K{$fila}", $curso['carrera']);
            $sheet->setCellValue("L{$fila}", $nivel);
            $sheet->setCellValue("M{$fila}", $curso['grado']);

            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("CIBIESReincorporados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("CIBIESReincorporados.xlsx"));
    }
}

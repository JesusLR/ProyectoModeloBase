<?php

namespace App\Http\Controllers\Tutorias\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Plan;
use App\Models\Periodo;
use App\Models\Curso;
use App\Models\Tutorias\Tutorias_categoria_preguntas;
use App\Models\Tutorias\Tutorias_formularios;
use App\Models\Tutorias\Tutorias_respuestas;
use App\Models\Tutorias\Tutorias_pregunta_respuestas;
use App\Http\Helpers\Utils;
use App\clases\cgts\MetodosCgt;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportePorTipoRespuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function reporte()
    {
        return view('tutorias.reportes.reporte_por_tipo_respuesta.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'categorias_preguntas' => Tutorias_categoria_preguntas::whereNull('deleted_at')->get(),
            'formularios' => Tutorias_formularios::where('Eliminado',0)->get(),
        ]);
    }

    public function imprimir(Request $request)
    {
        $info_reporte = self::obtenerInfoReporte($request);
        $cursos = new Collection;
        self::buscarCursos($request)
        ->chunk(150, static function($registros) use ($request, $cursos) {
            if($registros->isEmpty())
                return false;

            $respuestas_preguntas = self::buscarRespuestasPreguntas($request, $registros);

            $registros->each(static function($curso) use ($cursos, $respuestas_preguntas) {
                $respuestas_alumno = $respuestas_preguntas->get($curso->id);
                if($respuestas_alumno instanceof Collection)
                    $cursos->push(self::info_esencial($curso, $respuestas_alumno));
            });
        });

        if($cursos->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        return $this->generarExcel($info_reporte, $cursos);
    }

    public static function obtenerInfoReporte($request)
    {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $fechas_periodo = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'periodo_descripcion' => "{$fechas_periodo} ({$periodo->perNumero}/{$periodo->perAnio})",
        ];
    }

    public static function buscarCursos($request)
    {
        return Curso::with(['alumno.persona', 'cgt.plan.programa'])
        ->whereHas('alumno.persona', static function($query) use ($request) {
            if($request->aluClave)
                $query->where('aluClave', $request->aluClave);
            if($request->perApellido1)
                $query->where('perApellido1', 'like', "%{$request->perApellido1}%");
            if($request->perApellido2)
                $query->where('perApellido2', 'like', "%{$request->perApellido2}%");
            if($request->perNombre)
                $query->where('perNombre', 'like', "%{$request->perNombre}%");
        })
        ->whereHas('cgt.plan.programa', static function($query) use ($request) {
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->cgtGradoSemestre)
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
            if($request->cgtGrupo)
                $query->where('cgtGrupo', $request->cgtGrupo);
        })
        ->where('periodo_id', $request->periodo_id);
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Support\Collection $cursos
     */
    public static function buscarRespuestasPreguntas($request, $cursos): Collection
    {

        return Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.Semaforizacion',
            'tutorias_pregunta_respuestas.Respuesta', 'tutorias_preguntas.Nombre AS NombrePregunta', 
            'tutorias_categoria_preguntas.Nombre AS NombreCategoria',
            'tutorias_formularios.Nombre AS NombreFormulario', 'tutorias_alumnos.AlumnoIDSCEM', 'tutorias_alumnos.CursoID'
        )
        ->join('tutorias_alumnos', 'tutorias_alumnos.AlumnoID', 'tutorias_pregunta_respuestas.AlumnoID')
        ->join('tutorias_respuestas', 'tutorias_respuestas.RespuestaID', 'tutorias_pregunta_respuestas.RespuestaID')
        ->join('tutorias_preguntas', 'tutorias_preguntas.PreguntaID', 'tutorias_respuestas.PreguntaID')
        ->join('tutorias_categoria_preguntas', 'tutorias_categoria_preguntas.CategoriaPreguntaID', 'tutorias_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_formularios.FormularioID', 'tutorias_preguntas.FormularioID')
        ->where(static function($query) use ($request, $cursos) {
            $query->whereIn('tutorias_alumnos.CursoID', $cursos->pluck('id'));
            if($request->PreguntaID)
                $query->where('tutorias_preguntas.PreguntaID', $request->PreguntaID);
            if($request->CategoriaPreguntaID)
                $query->where('tutorias_categoria_preguntas.CategoriaPreguntaID', $request->CategoriaPreguntaID);
            if($request->FormularioID)
                $query->where('tutorias_formularios.FormularioID', $request->FormularioID);
            if($request->RespuestaID)
                $query->where('tutorias_pregunta_respuestas.RespuestaID', $request->RespuestaID);
            if($request->Semaforizacion)
                $query->where('tutorias_pregunta_respuestas.Semaforizacion', $request->Semaforizacion);
        })
        ->whereNull('tutorias_alumnos.deleted_at')
        //->whereNull('tutorias_respuestas.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->whereNull('tutorias_pregunta_respuestas.deleted_at')
        ->get()
        ->groupBy('CursoID');
    }

    /**
     * @param App\Models\Curso $curso
     * @param Illuminate\Support\Collection $respuestas
     */
    public static function info_esencial($curso, $respuestas)
    {
        $alumno = $curso->alumno;
        $nombreCompleto = $alumno->persona->nombreCompleto(true);
        $cgt = $curso->cgt;
        $cgtOrden = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);
        $plan = $cgt->plan;
        $programa = $plan->programa;

        return [
            'alumno_id' => $alumno->id,
            'aluClave' => $alumno->aluClave,
            'nombreCompleto' => $nombreCompleto,
            'grado' => $cgt->cgtGradoSemestre,
            'grupo' => $cgt->cgtGrupo,
            'descripcion_programa' => "{$programa->progClave} ({$plan->planClave}) {$programa->progNombre}",
            'agrupacion' => "{$programa->progClave} ({$plan->planClave})",
            'respuestas' => $respuestas,
            'orden' => $cgtOrden . $nombreCompleto,
        ];
    }

    /**
     * @param array $info_reporte
     * @param Illuminate\Support\Collection $cursos
     */
    public function generarExcel($info_reporte, $cursos) {

        $alumnosAgrupadosPorPlan = $cursos->groupBy('agrupacion')->sortKeys();

        $spreadsheet = new Spreadsheet();
        foreach($alumnosAgrupadosPorPlan as $key => $alumnos_plan) {
            $sheet_name = $key;
            $newSheet = new Worksheet($spreadsheet, $sheet_name);
            $spreadsheet->addSheet($newSheet);
            $sheet = $spreadsheet->getSheetByName($sheet_name);
            self::llenarDatosPorTab($sheet, $info_reporte, $alumnos_plan);
        }
        $spreadsheet->removeSheetByIndex(0); # Borrar la primer tab (está vacía).

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ReportePorTipoRespuesta.xlsx"));
        } catch (Exception $e) {
            throw $e;
        }

        return response()->download(storage_path('ReportePorTipoRespuesta.xlsx'));
    }

    /**
     * @param Worksheet $sheet
     * @param array $info_reporte
     * @param Illuminate\Support\Collection
     */
    private function llenarDatosPorTab($sheet, $info_reporte, $cursos) {

        $ubicacion = $info_reporte['ubicacion'];
        $departamento = $info_reporte['departamento'];
        $periodo = $info_reporte['periodo_descripcion'];
        $info_plan = $cursos->first();

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);

        $sheet->mergeCells("A1:I1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} - {$departamento->depClave} - {$periodo}");

        $sheet->mergeCells("A2:I2");
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('A2', $info_plan['descripcion_programa']);

        $sheet->getStyle("A3:I3")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 3, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(2, 3, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(3, 3, "Grado");
        $sheet->setCellValueByColumnAndRow(4, 3, "Grupo");
        $sheet->setCellValueByColumnAndRow(5, 3, "Formulario");
        $sheet->setCellValueByColumnAndRow(6, 3, "Categoria");
        $sheet->setCellValueByColumnAndRow(7, 3, "Pregunta");
        $sheet->setCellValueByColumnAndRow(8, 3, "Respuesta");
        $sheet->setCellValueByColumnAndRow(9, 3, "Semaforización");

        $fila = 4;
        foreach($cursos->sortBy('orden') as $alumno) {
            foreach($alumno['respuestas'] as $respuesta) {
                $sheet->setCellValueExplicit("A{$fila}", $alumno['aluClave'], DataType::TYPE_STRING);
                $sheet->setCellValue("B{$fila}", $alumno['nombreCompleto']);
                $sheet->setCellValue("C{$fila}", $alumno['grado']);
                $sheet->setCellValue("D{$fila}", $alumno['grupo']);
                $sheet->setCellValue("E{$fila}", $respuesta['NombreFormulario']);
                $sheet->setCellValue("F{$fila}", $respuesta['NombreCategoria']);
                $sheet->setCellValue("G{$fila}", $respuesta['NombrePregunta']);
                $sheet->setCellValue("H{$fila}", $respuesta['Respuesta']);
                $sheet->setCellValue("I{$fila}", self::definirSemaforizacion($respuesta['Semaforizacion']));
                $fila++;
            }
            $fila++;
        }
    }

    /**
     * Recibe el campo 'Semaforizacion' de la tabla tutorias_pregunta_respuestas.
     *
     * @param int $semaforizacion
     */
    private static function definirSemaforizacion($semaforizacion)
    {
        switch ($semaforizacion) {
            case 1:
                return 'Verde';
            case 2:
                return 'Amarillo';
            case 3:
                return 'Rojo';
            default:
                return 'No definido';
        }
    }
}

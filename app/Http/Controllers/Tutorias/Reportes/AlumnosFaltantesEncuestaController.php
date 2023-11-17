<?php

namespace App\Http\Controllers\Tutorias\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Plan;
use App\Http\Models\Periodo;
use App\Http\Models\Curso;
use App\Http\Models\Tutorias\Tutorias_formularios;
use App\Http\Models\Tutorias\Tutorias_categoria_preguntas;
use App\Http\Models\Tutorias\Tutorias_preguntas;
use App\Http\Models\Tutorias\Tutorias_pregunta_respuestas;
use App\Http\Helpers\Utils;
use App\clases\cgts\MetodosCgt;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlumnosFaltantesEncuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte() {

        return view('tutorias.reportes.alumnos_faltantes_encuesta.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'categorias_preguntas' => Tutorias_categoria_preguntas::get(),
            'formularios' => Tutorias_formularios::where('Eliminado',0)->get(),
        ]);
    }

    public function imprimir(Request $request)
    {
        $info_reporte = self::obtenerInfoReporte($request);
        $preguntasRequeridas = self::buscarPreguntasRequeridas($request);

        $cursos = new Collection;
        self::buscarCursos($request)
        ->chunk(150, static function($registros) use ($request, $cursos, $preguntasRequeridas) {

            if($registros->isEmpty())
                return false;

            $respuestas_preguntas = self::buscarRespuestasPreguntas($request, $registros);

            $registros->each(static function($curso) use ($cursos, $respuestas_preguntas, $preguntasRequeridas) {
                $respuestas_alumno = $respuestas_preguntas->get($curso->id) ?: new Collection;

                //dd($preguntasRequeridas, $respuestas_preguntas, $curso->id, $respuestas_alumno);
                //SI FALTAN POR CONTESTAR!!!!!
                if($respuestas_alumno->isNotEmpty())
                {
                    $preguntas_faltantes = self::obtenerPreguntasFaltantes($preguntasRequeridas, $respuestas_alumno);

                    if($preguntas_faltantes->isNotEmpty())
                        $cursos->push(self::info_esencial($curso, $preguntas_faltantes));
                }


            });
        });

        if($cursos->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        return $this->generarExcel($info_reporte, $cursos);
    }

    /**
     * @param Illuminate\Http\Request
     */
    public static function obtenerInfoReporte($request)
    {
        $periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $formulario = Tutorias_formularios::findOrFail($request->FormularioID);
        $fechas_periodo = Utils::fecha_string($periodo->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($periodo->perFechaFinal, 'mesCorto');

        return [
            'ubicacion' => $departamento->ubicacion,
            'departamento' => $departamento,
            'formulario' => $formulario,
            'periodo_descripcion' => "{$fechas_periodo} ({$periodo->perNumero}/{$periodo->perAnio})",
            'tipo_lista' => $request->tipo_lista,
        ];
    }

    /**
     * @param Illuminate\Http\Request
     */
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
        ->where('periodo_id', $request->periodo_id)
        ->where('curEstado', '=', 'R');
    }

    private static function buscarPreguntasRequeridas($request)
    {
        return Tutorias_preguntas::select('tutorias_preguntas.PreguntaID', 'tutorias_preguntas.FormularioID',
            'tutorias_preguntas.CategoriaPreguntaID',
            'tutorias_preguntas.Nombre', 'tutorias_formularios.Nombre AS nombreFormulario',
            'tutorias_categoria_preguntas.Nombre AS nombreCategoria'
        )
        ->join('tutorias_formularios', 'tutorias_formularios.FormularioID', 'tutorias_preguntas.FormularioID')
        ->join('tutorias_categoria_preguntas', 'tutorias_categoria_preguntas.CategoriaPreguntaID', 'tutorias_preguntas.CategoriaPreguntaID')
        ->where(static function($query) use ($request) {
            $query->where('tutorias_preguntas.FormularioID', $request->FormularioID);
            if($request->PreguntaID)
                $query->where('tutorias_preguntas.PreguntaID', $request->PreguntaID);
            if($request->CategoriaPreguntaID)
                $query->where('tutorias_preguntas.CategoriaPreguntaID', $request->CategoriaPreguntaID);
        })
        ->whereNotIn('tutorias_preguntas.PreguntaID', [119, 126])
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->get();
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Support\Collection $cursos
     */
    public static function buscarRespuestasPreguntas($request, $cursos): Collection
    {
        //dd($request->PreguntaID, $request->CategoriaPreguntaID, $request->FormularioID);
        return Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.PreguntaID',
            'tutorias_alumnos.AlumnoIDSCEM', 'tutorias_alumnos.CursoID'
        )
        ->join('tutorias_alumnos', 'tutorias_alumnos.AlumnoID', 'tutorias_pregunta_respuestas.AlumnoID')
        //->leftJoin('tutorias_respuestas', 'tutorias_respuestas.RespuestaID', 'tutorias_pregunta_respuestas.RespuestaID')
        ->join('tutorias_preguntas', 'tutorias_preguntas.PreguntaID', 'tutorias_pregunta_respuestas.PreguntaID')
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
        })
        ->where(static function($query) {
            $query->where('tutorias_pregunta_respuestas.Respuesta', '=', 'Pendiente por responder')
                ->orWhereNull('tutorias_pregunta_respuestas.Respuesta');
        })
        ->whereNotIn('tutorias_preguntas.PreguntaID', [119, 126])
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
     * @param Illuminate\Support\Collection $preguntasRequeridas
     * @param Illuminate\Support\Collection $respuestas_alumno
     */
    private static function obtenerPreguntasFaltantes($preguntasRequeridas, $respuestas_alumno)
    {
        //if($respuestas_alumno->isEmpty())
            //return $preguntasRequeridas;

        return $preguntasRequeridas->whereIn('PreguntaID', $respuestas_alumno->pluck('PreguntaID'));
    }

    /**
     * @param App\Http\Models\Curso $curso
     * @param Illuminate\Support\Collection $preguntas_faltantes
     */
    public static function info_esencial($curso, $preguntas_faltantes)
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
            'preguntas_faltantes' => $preguntas_faltantes,
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
            $writer->save(storage_path("AlumnosFaltantesEncuesta.xlsx"));
        } catch (Exception $e) {
            throw $e;
        }

        return response()->download(storage_path('AlumnosFaltantesEncuesta.xlsx'));
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
        $formulario = $info_reporte['formulario'];
        $info_plan = $cursos->first();
        $tipo_lista = $info_reporte['tipo_lista'];

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $ultimaColumna = $tipo_lista == 'P' ? 'F' : 'D';
        $sheet->mergeCells("A1:{$ultimaColumna}1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} - {$departamento->depClave} - {$periodo}");

        $sheet->mergeCells("A2:{$ultimaColumna}2");
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('A2', "{$info_plan['descripcion_programa']} | Formulario: {$formulario->Nombre}");

        $sheet->mergeCells("A3:{$ultimaColumna}3");
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "Formulario: {$formulario->Nombre}");

        $sheet->getStyle("A4:{$ultimaColumna}4")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 4, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(2, 4, "Nombre del alumno");
        $sheet->setCellValueByColumnAndRow(3, 4, "Grado");
        $sheet->setCellValueByColumnAndRow(4, 4, "Grupo");
        if($tipo_lista == 'P') {
            $sheet->setCellValueByColumnAndRow(5, 4, "Categoria");
            $sheet->setCellValueByColumnAndRow(6, 4, "Pregunta");
        }

        $fila = 5;
        foreach($cursos->sortBy('orden') as $alumno) {
            if($tipo_lista == 'P') {

                foreach($alumno['preguntas_faltantes'] as $pregunta) {
                    $sheet->setCellValueExplicit("A{$fila}", $alumno['aluClave'], DataType::TYPE_STRING);
                    $sheet->setCellValue("B{$fila}", $alumno['nombreCompleto']);
                    $sheet->setCellValue("C{$fila}", $alumno['grado']);
                    $sheet->setCellValue("D{$fila}", $alumno['grupo']);
                    $sheet->setCellValue("E{$fila}", $pregunta['nombreCategoria']);
                    $sheet->setCellValue("F{$fila}", $pregunta['Nombre']);
                    $fila++;
                }
                $fila++;

            } else {
                
                $sheet->setCellValueExplicit("A{$fila}", $alumno['aluClave'], DataType::TYPE_STRING);
                $sheet->setCellValue("B{$fila}", $alumno['nombreCompleto']);
                $sheet->setCellValue("C{$fila}", $alumno['grado']);
                $sheet->setCellValue("D{$fila}", $alumno['grupo']);
                $fila++;
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_extraordinarios;
use App\Http\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BachillerListaAlumnosRecuperativosController extends Controller
{
    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.alumnos_recuperativos.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function getRecuperativos(Request $request, $periodo_id, $plan_id)
    {
        if ($request->ajax()) {

            $extraordinarios = Bachiller_extraordinarios::select(
                'bachiller_extraordinarios.id',
                'bachiller_extraordinarios.extAlumnosInscritos',
                'bachiller_extraordinarios.extPago',
                'bachiller_extraordinarios.extFecha',
                'bachiller_extraordinarios.extHora',
                'periodos.perNumero',
                'periodos.perAnio',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_empleados.empNombre as perNombre',
                'bachiller_empleados.empApellido1 as perApellido1',
                'bachiller_empleados.empApellido2 as perApellido2',
                'planes.planClave',
                'programas.progClave',
                'ubicacion.ubiClave',
                'empleadoAux.empApellido1',
                'empleadoAux.empApellido2',
                'empleadoAux.empNombre'
            )
                ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
                ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
                ->leftJoin('bachiller_empleados as empleadoAux', 'bachiller_extraordinarios.bachiller_empleado_sinodal_id', '=', 'empleadoAux.id')
                ->where('periodos.id', '=', $periodo_id)
                ->where('planes.id', '=', $plan_id)
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();

            return response()->json($extraordinarios);
        }
    }

    public function imprimir(Request $request)
    {

        $inscritosextraordinarios = Bachiller_inscritosextraordinarios::select(
            'bachiller_inscritosextraordinarios.id',
            'bachiller_inscritosextraordinarios.iexFecha',
            'bachiller_inscritosextraordinarios.iexCalificacion',
            'bachiller_inscritosextraordinarios.iexEstado',
            'bachiller_extraordinarios.id as extraordinario_id',
            'bachiller_extraordinarios.extFecha as extFecha',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matSemestre',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'planes.planClave',
            'alumnos.aluClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.progClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.depClave',
            'programas.progNombre',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre'
        )
            ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('alumnos', 'bachiller_inscritosextraordinarios.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->leftJoin('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
            // ->leftJoin('bachiller_fechas_regularizacion', 'bachiller_extraordinarios.bachiller_fecha_regularizacion_id', '=', 'bachiller_fechas_regularizacion.id')
            ->where(static function ($query) use ($request) {

                if ($request->bachiller_recuperativo_id) {
                    $query->where('bachiller_extraordinarios.id', $request->bachiller_recuperativo_id);
                }

                if ($request->matClave) {
                    $query->where('bachiller_materias.matClave', $request->matClave);
                }

                if ($request->clave_empleado) {
                    $query->where('bachiller_empleados.id', $request->clave_empleado);
                }

                if ($request->empApellido1) {
                    $query->where('bachiller_empleados.empApellido1', $request->empApellido1);
                }
                if ($request->empApellido2) {
                    $query->where('bachiller_empleados.empApellido2', $request->empApellido2);
                }
                if ($request->empNombre) {
                    $query->where('bachiller_empleados.empNombre', $request->empNombre);
                }
                if ($request->fechaExamen) {
                    $query->where('bachiller_extraordinarios.extFecha', $request->fechaExamen);
                }
            })

            ->where('periodos.id', $request->periodo_id)
            ->where('planes.id', $request->plan_id)
            ->where('bachiller_inscritosextraordinarios.iexEstado', '!=', 'C')
            // ->where('bachiller_extraordinarios.id', $request->recuperativo_id)
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->get();

        $resultado_collection = collect($inscritosextraordinarios);


        if ($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');

        $fechaHoy = Utils::fecha_string($fechaActual, $fechaActual->format('m'), $fechaActual->format('y'));

        $bachiller_recuperativo = $resultado_collection->groupBy('extraordinario_id');

        if ($request->tipoReporte == 1) {
            return $this->generarExcel($bachiller_recuperativo);
        }

        if ($request->tipoReporte == 2) {
            $parametro_NombreArchivo = 'pdf_bachiller_lista_de_asistencia_recuperativos';
            // view('reportes.pdf.bachiller.alumnos_recuperativos.pdf_bachiller_lista_de_asistencia_recuperativos')
            $pdf = PDF::loadView('reportes.pdf.bachiller.alumnos_recuperativos.' . $parametro_NombreArchivo, [
                "fechaActual"       => $fechaActual,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "alumnos_recuperativos" => $resultado_collection,
                "fechaHoy" => $fechaHoy,
                "bachiller_recuperativo" => $bachiller_recuperativo
            ]);

            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }


    public function generarExcel($bachiller_recuperativo)
    {
        $contador = 1;
        $contador2 = 1;

        $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();

        
        foreach ($bachiller_recuperativo as $extra_id => $valores) {
            foreach($valores as $value){
                if($value->extraordinario_id == $extra_id && $contador++ == 1){
                    $sheet = $spreadsheet->createSheet();
                    $sheet->setTitle("hoja");
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
                    $sheet->getColumnDimension('L')->setAutoSize(true);
                    $sheet->getColumnDimension('L')->setAutoSize(true);
                    $sheet->getColumnDimension('M')->setAutoSize(true);
                    $sheet->getColumnDimension('N')->setAutoSize(true);
                    $sheet->getColumnDimension('O')->setAutoSize(true);
                    $sheet->getColumnDimension('P')->setAutoSize(true);
                    $sheet->getColumnDimension('Q')->setAutoSize(true);
                    $sheet->getColumnDimension('R')->setAutoSize(true);
                    $sheet->getColumnDimension('S')->setAutoSize(true);
                    $sheet->getColumnDimension('T')->setAutoSize(true);
                    $sheet->getColumnDimension('U')->setAutoSize(true);
                    $sheet->getColumnDimension('V')->setAutoSize(true);

                    $sheet->mergeCells("A1:K1");
                    $sheet->getStyle('A1')->getFont()->setBold(true);

                    // $sheet->setCellValue('A1', "{$info_reporte['ubicacion']->ubiClave} - {$info_reporte['departamento']->depClave} - {$info_reporte['periodo_descripcion']}");
                    $sheet->setCellValue('A1', "PREPARATORIA ESCUELA MODELO");
                    $sheet->mergeCells("A2:K2");
                    $sheet->getStyle('A2')->getFont()->setBold(true);
                    $sheet->setCellValue('A2', "LISTA DE ALUMNOS RECUPERATIVOS");


                    

                    $sheet->mergeCells("A3:K3");
                    $sheet->getStyle('A3')->getFont()->setBold(true);
                    $sheet->setCellValue('A3', "Ubicacion: {$value->ubiClave}-{$value->ubiNombre}");

                    $sheet->mergeCells("A4:K4");
                    $sheet->getStyle('A4')->getFont()->setBold(true);
                    $sheet->setCellValue('A4', "Período: {$value->perNumero}-{$value->perAnio}");

                    $sheet->mergeCells("A5:K5");
                    $sheet->getStyle('A5')->getFont()->setBold(true);
                    $sheet->setCellValue('A5', "Nivel: {$value->depClave} ({$value->planClave}) {$value->progNombre}");

                    $sheet->mergeCells("A6:K6");
                    $sheet->getStyle('A6')->getFont()->setBold(true);
                    $sheet->setCellValue('A6', "Semestre: {$value->matSemestre}");

                    $sheet->mergeCells("A7:K7");
                    $sheet->getStyle('A7')->getFont()->setBold(true);
                    $sheet->setCellValue('A7', "Materia-Recuperativo: {$value->extraordinario_id}-{$value->matClave}-{$value->matNombre}");

                    $sheet->mergeCells("A8:K8");
                    $sheet->getStyle('A8')->getFont()->setBold(true);
                    $sheet->setCellValue('A8', "Docente: {$value->empApellido1} {$value->empApellido2} {$value->empNombre}");

                    $sheet->getStyle("A10:V22")->getFont()->setBold(false);


                    $sheet->setCellValueByColumnAndRow(1, 10, "#");
                    $sheet->setCellValueByColumnAndRow(2, 10, "Clave Pago");
                    $sheet->setCellValueByColumnAndRow(3, 10, "Nombre del Alumno");
                    $sheet->setCellValueByColumnAndRow(4, 10, "Asistencia 1");
                    $sheet->setCellValueByColumnAndRow(5, 10, "Asistencia 2");
                    $sheet->setCellValueByColumnAndRow(6, 10, "Asistencia 3");
                    $sheet->setCellValueByColumnAndRow(7, 10, "Asistencia 4");
                    $sheet->setCellValueByColumnAndRow(8, 10, "Asistencia 5");
                    $sheet->setCellValueByColumnAndRow(9, 10, "Asistencia 6");
                    $sheet->setCellValueByColumnAndRow(10, 10, "Asistencia 7");
                    $sheet->setCellValueByColumnAndRow(11, 10, "Asistencia 8");
                    $sheet->setCellValueByColumnAndRow(12, 10, "Asistencia 9");
                    $sheet->setCellValueByColumnAndRow(13, 10, "Asistencia 10");
                    $sheet->setCellValueByColumnAndRow(14, 10, "Asistencia 11");
                    $sheet->setCellValueByColumnAndRow(15, 10, "Asistencia 12");
                    $sheet->setCellValueByColumnAndRow(16, 10, "Asistencia 13");
                    $sheet->setCellValueByColumnAndRow(17, 10, "Asistencia 14");
                    $sheet->setCellValueByColumnAndRow(18, 10, "Asistencia 15");
                    $sheet->setCellValueByColumnAndRow(19, 10, "Asistencia 16");
                    $sheet->setCellValueByColumnAndRow(20, 10, "Asistencia 17");
                    $sheet->setCellValueByColumnAndRow(21, 10, "Asistencia 18");
                    $sheet->setCellValueByColumnAndRow(22, 10, "Faltas");

                    $fila = 11;
                    $fila2 = 11;
                    foreach ($valores as $key => $inscrito) {
                       if($inscrito->extraordinario_id == $extra_id){
                            $sheet->setCellValue("A{$fila}", $key + 1);
                            $sheet->setCellValue("B{$fila}", $inscrito['aluClave']);
                            $sheet->setCellValueExplicit("C{$fila}", $inscrito['perApellido1'] . ' ' . $inscrito['perApellido2'] . ' ' . $inscrito['perNombre'], DataType::TYPE_STRING);
                            $sheet->setCellValue("D{$fila}", "");
                            $sheet->setCellValue("E{$fila}", "");
                            $sheet->setCellValue("F{$fila}", "");
                            $sheet->setCellValue("G{$fila}", "");
                            $sheet->setCellValue("H{$fila}", "");
                            $sheet->setCellValue("I{$fila}", "");
                            $sheet->setCellValue("J{$fila}", "");
                            $sheet->setCellValue("K{$fila}", "");
                            $sheet->setCellValue("L{$fila}", "");
                            $sheet->setCellValue("M{$fila}", "");
                            $sheet->setCellValue("N{$fila}", "");
                            $sheet->setCellValue("O{$fila}", "");
                            $sheet->setCellValue("P{$fila}", "");
                            $sheet->setCellValue("Q{$fila}", "");
                            $sheet->setCellValue("R{$fila}", "");
                            $sheet->setCellValue("S{$fila}", "");
                            $sheet->setCellValue("T{$fila}", "");
                            $sheet->setCellValue("U{$fila}", "");
                            $sheet->setCellValue("V{$fila}", "");
                            $fila++;
                       }
                    }

                }
            }

            $contador = 1;
        }

        $writer = new Xlsx($spreadsheet);

        // return $contador;
        try {
            $writer->save(storage_path("BachillerListaAlumnosIncritosRecuperativos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
        return response()->download(storage_path("BachillerListaAlumnosIncritosRecuperativos.xlsx"));

    }
}

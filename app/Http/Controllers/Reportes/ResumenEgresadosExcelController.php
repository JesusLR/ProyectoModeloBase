<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Programa;
use App\Http\Models\Egresado;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Exception;

class ResumenEgresadosExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:r_plantilla_profesores']);
    }

    public function reporte() {

        return view('reportes/resumen_egresados_excel.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        $censo_egresados = self::censarEgresados($request)->get();

        if($censo_egresados->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        return $this->generarExcel($censo_egresados);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function censarEgresados($request) {
        $agrupacion = 'programas.id';

        return Programa::select('programas.id AS programa_id', 'programas.progClave', 'escuelas.escClave',
            'departamentos.depClave', 'ubicacion.ubiClave', 'ubicacion.ubiNombre', 'departamentos.depNombre',
            'egresados_programa.total_egresados', 'titulados_programa.total_titulados',
            'egresados_programa.max_anio', 'egresados_programa.min_anio'
        )
        ->join('escuelas', 'escuelas.id', 'programas.escuela_id')
        ->join('departamentos', 'departamentos.id', 'escuelas.departamento_id')
        ->join('ubicacion', 'ubicacion.id', 'departamentos.ubicacion_id')
        ->joinSub(self::contarEgresadosPorAgrupacionQuery($request, $agrupacion), 'egresados_programa', static function($join) {
            $join->on('egresados_programa.egresados_programa_id', 'programas.id');
        })
        ->leftJoinSub(self::contarTituladosPorAgrupacionQuery($request, $agrupacion), 'titulados_programa', static function($join) {
            $join->on('titulados_programa.titulados_programa_id', 'programas.id');
        })
        ->where(static function($query) use ($request) {
            $query->whereIn('departamentos.depClave', ['SUP', 'POS']);
            if($request->plan_id)
                $query->where('planes.id', $request->plan_id);
            if($request->programa_id)
                $query->where('programas.id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuelas.id', $request->escuela_id);
            if($request->departamento_id)
                $query->where('departamentos.id', $request->departamento_id);
            if($request->ubicacion_id)
                $query->where('ubicacion.id', $request->ubicacion_id);
        });
    }

    /**
     * @param Illuminate\Http\Request
     * @param string $agrupacion
     */
    private static function contarEgresadosPorAgrupacionQuery($request, $agrupacion) {

        return Egresado::select(DB::raw("COUNT(*) AS total_egresados"), 'programas.id as egresados_programa_id',
            DB::raw("MAX(periodos.perAnioPago) AS max_anio"), DB::raw("MIN(periodos.perAnioPago) AS min_anio")
        )
        ->join('planes', 'planes.id', 'egresados.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('periodos', 'periodos.id', 'egresados.periodo_id')
        ->where(static function($query) use ($request) {
            if($request->programa_id)
                $query->where('programas.id', $request->programa_id);
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
        })
        ->groupBy($agrupacion);
    }

    /**
     * @param Illuminate\Http\Request
     * @param string $agrupacion
     */
    private static function contarTituladosPorAgrupacionQuery($request, $agrupacion) {

        return Egresado::select(DB::raw("COUNT(*) AS total_titulados"), 'programas.id as titulados_programa_id')
        ->join('planes', 'planes.id', 'egresados.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->has('periodoTitulacion')
        ->where(static function($query) use ($request) {
            if($request->programa_id)
                $query->where('programas.id', $request->programa_id);
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
        })
        ->groupBy($agrupacion);
    }

    /**
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($censo_egresados) {

        $departamentos = $censo_egresados->groupBy(static function($censo) {
            return $censo['ubiClave'] . ' ' . $censo['depClave'];
        });

        $spreadsheet = new Spreadsheet();

        foreach($departamentos as $ubiClave_depClave => $censo) {
            $newSheet = new Worksheet($spreadsheet, $ubiClave_depClave);
            $spreadsheet->addSheet($newSheet);
            $sheet = $spreadsheet->getSheetByName($ubiClave_depClave);
            self::llenarDatosPorTab($sheet, $censo);
        }
        $spreadsheet->removeSheetByIndex(0); # Borrar primer tab (No se utilizó).

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ResumenEgresados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ResumenEgresados.xlsx"));
    }

    /**
     * @param PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param Illuminate\Support\Collection $censo
     */
    private static function llenarDatosPorTab($sheet, $censo) {

        $censo->each(static function($programa) {
            $programa->orden = "{$programa->escClave} - {$programa->progClave}";
        });

        $info_censo = $censo->first();

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->mergeCells("A1:F1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$info_censo['ubiNombre']} | {$info_censo['depNombre']} | {$censo->min('min_anio')} - {$censo->max('max_anio')}");
        $sheet->getStyle("A2:F2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Ubicación");
        $sheet->setCellValueByColumnAndRow(2, 2, "Departamento");
        $sheet->setCellValueByColumnAndRow(3, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(4, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(5, 2, "Egresados");
        $sheet->setCellValueByColumnAndRow(6, 2, "Titulados");

        $fila = 3;
        foreach($censo->sortBy('orden') as $programa) {
            $sheet->setCellValue("A{$fila}", $programa->ubiClave);
            $sheet->setCellValue("B{$fila}", $programa->depClave);
            $sheet->setCellValue("C{$fila}", $programa->escClave);
            $sheet->setCellValue("D{$fila}", $programa->progClave);
            $sheet->setCellValue("E{$fila}", ($programa->total_egresados ?: 0));
            $sheet->setCellValue("F{$fila}", ($programa->total_titulados ?: 0));
            $fila++;
        }
    }
}

<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Empleado;
use App\Http\Models\Puesto;

use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Exception;

class DirectorioEmpleadosController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function reporte() {

        return view('reportes/directorio_empleados.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'puestos' => Puesto::get(),
        ]);
    }

    public function imprimir(Request $request) {
        
        if(!self::buscarEmpleados($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $directorio = new Collection;
        self::buscarEmpleados($request)
        ->chunk(150, static function($empleados) use ($directorio) {
            if($empleados->isEmpty())
                return false;

            $empleados->each(static function($empleado) use ($directorio) {
                $directorio->push(self::info_esencial($empleado));
            });
        });

        $ubicacion = Ubicacion::findOrFail($request->ubicacion_id);

        return $this->generarExcel($ubicacion, $directorio);
    }

    /**
     * @param Illuminate\Http\Request $request
     */
    private static function buscarEmpleados($request) {

        return Empleado::with(['persona', 'escuela', 'puesto'])
        ->whereHas('persona', static function($query) use ($request) {
            if($request->perApellido1)
                $query->where('perApellido1', 'like', "%{$request->perApellido1}%");
            if($request->perApellido2)
                $query->where('perApellido2', 'like', "%{$request->perApellido2}%");
            if($request->perNombre)
                $query->where('perNombre', 'like', "%{$request->perNombre}%");
        })
        ->whereHas('escuela.departamento', static function($query) use ($request) {
            if($request->departamento_id)
                $query->where('departamento_id', $request->departamento_id);
            if($request->ubicacion_id)
                $query->where('ubicacion_id', $request->ubicacion_id);
        })
        ->where(static function($query) use ($request) {
            if($request->empleado_id)
                $query->where('id', $request->empleado_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
            if($request->puesto_id)
                $query->where('puesto_id', $request->puesto_id);
        });
    }

    /**
     * @param App\Http\Models\Empleado
     */
    private static function info_esencial($empleado) {
        $persona = $empleado->persona;
        $puesto = $empleado->puesto;
        $escuela = $empleado->escuela;

        return [
            'empleado_id' => $empleado->id,
            'perApellido1' => $persona->perApellido1,
            'perApellido2' => $persona->perApellido2,
            'perNombre' => $persona->perNombre,
            'cargo' => $puesto->puesNombre,
            'telefono1' => $persona->perTelefono1,
            'telefono2' => $persona->perTelefono2,
            'perCorreo1' => $persona->perCorreo1,
            'direccion' => $persona->perDirCalle . ' ' . $persona->perDirNumInt . ' ' . $persona->perDirNumExt . ' ' . $persona->perDirColonia,
            'escClave' => $escuela->escClave,
            'orden' => $escuela->escClave . '-' . $persona->nombreCompleto(true),
        ];
    }

    /**
     * @param App\Http\Models\Ubicacion $ubicacion
     * @param Illuminate\Support\Collection $directorio
     */
    public function generarExcel($ubicacion, $directorio) {

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
        $sheet->mergeCells("A1:J1");
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', "{$ubicacion->ubiClave} {$ubicacion->ubiNombre} - Directorio de Empleados");
        $sheet->getStyle("A2:J2")->getFont()->setBold(true);

        $sheet->setCellValueByColumnAndRow(1, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(2, 2, "No. empleado");
        $sheet->setCellValueByColumnAndRow(3, 2, "Apellido paterno");
        $sheet->setCellValueByColumnAndRow(4, 2, "Apellido materno");
        $sheet->setCellValueByColumnAndRow(5, 2, "Nombre");
        $sheet->setCellValueByColumnAndRow(6, 2, "Cargo");
        $sheet->setCellValueByColumnAndRow(7, 2, "Tel. domicilio");
        $sheet->setCellValueByColumnAndRow(8, 2, "Tel. celular");
        $sheet->setCellValueByColumnAndRow(9, 2, "Dirección");
        $sheet->setCellValueByColumnAndRow(10, 2, "Correo electrónico");

        $fila = 3;
        foreach($directorio->sortBy('orden') as $empleado) {
            $sheet->setCellValue("A{$fila}", $empleado['escClave']);
            $sheet->setCellValueExplicit("B{$fila}", $empleado['empleado_id'], DataType::TYPE_STRING);
            $sheet->setCellValue("C{$fila}", $empleado['perApellido1']);
            $sheet->setCellValueExplicit("D{$fila}", $empleado['perApellido2'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E{$fila}", $empleado['perNombre'], DataType::TYPE_STRING);
            $sheet->setCellValue("F{$fila}", $empleado['cargo']);
            $sheet->setCellValueExplicit("G{$fila}", $empleado['telefono2'], DataType::TYPE_STRING);
            $sheet->setCellValue("H{$fila}", $empleado['telefono1']);
            $sheet->setCellValueExplicit("I{$fila}", $empleado['direccion'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$fila}", $empleado['perCorreo1'], DataType::TYPE_STRING);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("DirectorioEmpleados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("DirectorioEmpleados.xlsx"));
    }
}

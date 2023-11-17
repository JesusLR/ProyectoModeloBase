<?php

namespace App\Http\Controllers\Procesos;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Pago;
use App\Http\Models\Curso;
use App\Http\Models\Cecc;
use App\Http\Models\ConceptoReferenciaUbicacion;

use DB;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExcelPagosController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:p_pago']);
    }

    public function reporte()
    {
    	return view('procesos/excel_pagos.create', [
    		'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
    	]);
    }

    public function descargar(Request $request)
    {
        // $pagos = DB::select("call procPagosPorFechas('{$request->fecha1}', '{$request->fecha2}')");

        if(!self::buscarPagos($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $pagos = new Collection;
        self::buscarPagos($request)
        ->chunk(200, static function($registros) use ($pagos) {
            if($registros->isEmpty())
                return false;

            $cursos = self::buscarCursos($registros);

            $registros->each(static function($pago) use ($pagos, $cursos) {
                $curso = $cursos->get($pago->pagClaveAlu);
                $pagos->push(self::info_esencial($pago, $curso));
            });
        });

        return $this->generarExcel($pagos);
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarPagos($request) {

        return Pago::select('pagos.pagClaveAlu', 'pagos.pagAnioPer', 'pagos.pagConcPago',
            'conceptospago.conpNombre', 'pagos.pagFechaPago', 'pagos.pagImpPago',
            'pagos.pagRefPago', "pagos.pagEstado", 'pagos.pagFormaAplico',
            'users.username', DB::raw("CONCAT_WS(' ', personas.perNombre, personas.perApellido1, personas.perApellido2) AS usuario")
        )
        ->join('conceptospago', 'conceptospago.conpClave', 'pagos.pagConcPago')
        ->join('users', 'users.id', 'pagos.usuario_at')
        ->join('empleados', 'empleados.id', 'users.empleado_id')
        ->join('personas', 'personas.id', 'empleados.persona_id')
        ->where([
            ['pagos.pagFechaPago', '>=', $request->fecha1],
            ['pagos.pagFechaPago', '<=', $request->fecha2],
        ])
        ->orderBy('pagos.pagFechaPago');
    }

    /**
     * @param Illuminate\Support\Collection
     */
    private static function buscarCursos($pagos) {

        return Curso::select('alumnos.aluClave',
            'programas.progClave',
            'escuelas.escClave',
            'departamentos.depClave',
            'ubicacion.ubiClave',
            'conceptosreferenciaubicacion.conpRefClave',
            'conceptosreferenciaubicacion.conpNombre',
            'cecc.clave',
            'cecc.descripcion')
        ->join('alumnos', 'alumnos.id', 'cursos.alumno_id')
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->join('planes', 'planes.id', 'cgt.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('escuelas', 'escuelas.id', 'programas.escuela_id')
        ->join('departamentos', 'departamentos.id', 'escuelas.departamento_id')
        ->join('ubicacion', 'ubicacion.id', 'departamentos.ubicacion_id')
        ->join('conceptosreferenciaubicacion',function($join){

            $join->on("conceptosreferenciaubicacion.ubiClave","=","ubicacion.ubiClave")
                ->on("conceptosreferenciaubicacion.escClave","=","escuelas.escClave")
                ->on("conceptosreferenciaubicacion.depClave","=","departamentos.depClave");

        })
        ->leftjoin('cecc',function($join){

            $join->on("cecc.ubiClave","=","ubicacion.ubiClave")
                ->on("cecc.escClave","=","escuelas.escClave")
                ->on("cecc.progClave","=","programas.progClave");

        })
        ->whereIn('alumnos.aluClave', $pagos->pluck('pagClaveAlu'))
        ->oldest('cursos.curFechaRegistro')
        ->get()
        ->keyBy('aluClave'); # devuelve el curso más actual por cada alumno.
    }

    /**
     * @param App\Http\Models\Pago
     * @param App\Http\Models\Curso
     */
    private static function info_esencial($pago, $curso = null) {

        return (Object) [
            'clave_pago' => $pago->pagClaveAlu,
            'anio_escolar_pago' => $pago->pagAnioPer,
            'clave_concepto_pago' => $pago->pagConcPago,
            'descripcion_concepto_pago' => $pago->conpNombre,
            'fecha_pago' => $pago->pagFechaPago,
            'importe_pago' => $pago->pagImpPago,
            'referencia_pago' => $pago->pagRefPago,
            'estado_de_pago' => $pago->pagEstado == 'A' ? 'APLICADO' : 'NO APLICADO',
            'metodo_pago_registrado' => $pago->pagFormaAplico == 'A' ? 'AUTOMÁTICO' : 'MANUAL',
            'username' => $pago->username,
            'usuario' => $pago->usuario,
            'programa' => $curso ? $curso->progClave : '',
            'escuela' => $curso ? $curso->escClave : '',
            'departamento' => $curso ? $curso->depClave : '',
            'ubicacion' => $curso ? $curso->ubiClave : '',
            'ceec_clave' => $curso ? $curso->clave : '',
            'ceec_descripcion' => $curso ? $curso->descripcion : '',
            'conpRefClave' => $curso ? $curso->conpRefClave : '',
            'conpNombre' => $curso ? $curso->conpNombre : '',
        ];
    }

    /**
     * @param Illuminate\Support\Collection
     */
    public function generarExcel($pagos) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A2:Q2')->getFont()->setBold(true);
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
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Ubicacion");
        $sheet->setCellValueByColumnAndRow(2, 2, "Departamento");
        $sheet->setCellValueByColumnAndRow(3, 2, "Escuela");
        $sheet->setCellValueByColumnAndRow(4, 2, "Programa");
        $sheet->setCellValueByColumnAndRow(5, 2, "XX Clave");
        $sheet->setCellValueByColumnAndRow(6, 2, "XX Descripcion");
        $sheet->setCellValueByColumnAndRow(7, 2, "Ceec Clave");
        $sheet->setCellValueByColumnAndRow(8, 2, "Ceec Descripcion");
        $sheet->setCellValueByColumnAndRow(9, 2, "Clave Pago");
        $sheet->setCellValueByColumnAndRow(10, 2, "Año pago");
        $sheet->setCellValueByColumnAndRow(11, 2, "Concepto");
        $sheet->setCellValueByColumnAndRow(12, 2, "Descripción Concepto");
        $sheet->setCellValueByColumnAndRow(13, 2, "Fecha pago");
        $sheet->setCellValueByColumnAndRow(14, 2, "Importe");
        $sheet->setCellValueByColumnAndRow(15, 2, "Referencia");
        $sheet->setCellValueByColumnAndRow(16, 2, "Estado");
        $sheet->setCellValueByColumnAndRow(17, 2, "Método pago");
        $sheet->setCellValueByColumnAndRow(18, 2, "username");
        $sheet->setCellValueByColumnAndRow(19, 2, "usuario");

        $fila = 3;
        foreach ($pagos as $key => $pago) {
            $sheet->setCellValue("A{$fila}", $pago->ubicacion);
            $sheet->setCellValue("B{$fila}", $pago->departamento);
            $sheet->setCellValue("C{$fila}", $pago->escuela);
            $sheet->setCellValue("D{$fila}", $pago->programa);
            $sheet->setCellValue("E{$fila}", $pago->conpRefClave, DataType::TYPE_STRING);
            $sheet->setCellValue("F{$fila}", $pago->conpNombre);
            $sheet->setCellValue("G{$fila}", $pago->ceec_clave, DataType::TYPE_STRING);
            $sheet->setCellValue("H{$fila}", $pago->ceec_descripcion);
            $sheet->setCellValueExplicit("I{$fila}", $pago->clave_pago, DataType::TYPE_STRING);
            $sheet->setCellValue("J{$fila}", $pago->anio_escolar_pago);
            $sheet->setCellValueExplicit("K{$fila}", $pago->clave_concepto_pago, DataType::TYPE_STRING);
            $sheet->setCellValue("L{$fila}", $pago->descripcion_concepto_pago);
            $sheet->setCellValue("M{$fila}", $pago->fecha_pago);
            $sheet->setCellValue("N{$fila}", $pago->importe_pago);
            $sheet->setCellValueExplicit("O{$fila}", $pago->referencia_pago, DataType::TYPE_STRING);
            $sheet->setCellValue("P{$fila}", $pago->estado_de_pago);
            $sheet->setCellValue("Q{$fila}", $pago->metodo_pago_registrado);
            $sheet->setCellValue("R{$fila}", $pago->username);
            $sheet->setCellValue("S{$fila}", $pago->usuario);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("ExcelPagos.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("ExcelPagos.xlsx"));
    }
}

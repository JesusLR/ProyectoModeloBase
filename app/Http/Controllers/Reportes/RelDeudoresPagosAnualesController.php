<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Periodo;
use App\Http\Models\Cgt;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Escuela;
use App\Http\Models\Departamento;
use App\Http\Models\Ubicacion;
use App\Http\Models\Cuota;
use App\Http\Helpers\UltimaFechaPago;
use Auth;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RelDeudoresPagosAnualesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    //$this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    //obtener año actual para el filtro que genera el reporte del año de periodo
    $anioActual = Carbon::now();

    $aluEstado = [
        'R' => 'REGULARES',
        'P' => 'PREINSCRITOS',
        'C' => 'CONDICIONADO',
        'A' => 'CONDICIONADO 2',
        'B' => 'BAJA',
        'T' => 'TODOS',
    ];
/*
      $escuelas = Escuela::with('departamento.ubicacion')
          ->whereHas('departamento.ubicacion', static function($query) {
              $query->where('depClave', 'SUP')
                  ->where('ubiClave', 'CME')
                  ->where("escNombre", "like", "ESCUELA%");
          })->get();
*/

      return View('reportes/relacion_deudores_pagos_anuales.create', [
        "aluEstado" => $aluEstado,
        "anioActual"=>$anioActual
         // ,
        //"escuelas" => $escuelas
      ]);
  }


  public function imprimir(Request $request)
    {

        $userId = Auth::id();

        $tipoReporte = "escuela";
        $parametro_NombreArchivo = "";
        $parametro_Titulo = "";
        $parametro_Mes = "";
        $parametro_Ubicacion = "";
        $parametro_Periodo = "";
        $parametro_Semestre_Inicio = 1;
        $parametro_Semestre_Fin = 15;
        $parametro_ConcPagoInicial = "00";
        $parametro_ConcPagoFinal = "12";
        $parametro_ConcPagoInscripcion = "99";
        $anioPeriodo3 = $request->perAnio;
        $anioPeriodo1 = (string)((int)$anioPeriodo3 + 1);
        $parametro_iniciaFecha = $anioPeriodo3.'-08-10';
        $parametro_finFecha = $anioPeriodo1.'-08-20';


        if ($request->numSemestre != "0")
        {
            $parametro_Semestre_Inicio = $request->numSemestre;
            $parametro_Semestre_Fin = $request->numSemestre;
        }

        if ($request->pagConcPago != "99")
        {
            $parametro_ConcPagoInicial = "00";
            $parametro_ConcPagoFinal = "10";
            $parametro_ConcPagoInscripcion = "99";
        }

        if ($request->fechaPago == "rango") {
            $parametro_iniciaFecha = $request->iniciaFecha;
            $parametro_finFecha = $request->finFecha;
        }

        if( ($request->depClave == "MAT") || ($request->depClave == "PRE")
            || ($request->depClave == "PRI") || ($request->depClave == "SEC")
            || ($request->depClave == "BAC") )
        {
            $request->escClave = $request->depClave;
        }


        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // Output: 54esmdr0qf
        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);
        $nombreProcedure = $request->tipo_reporte == "PDF" ? 'procColeAnualesEscuela' : 'procColeAnualesEscuelaExcel';


        $parametro_NombreArchivo = 'pdf_relacion_deudores_pagos_anuales';
        $result =  DB::select("call $nombreProcedure("
            .$userId
            .",".$request->perAnio
            .",'".$request->ubiClave
            ."','".$request->depClave
            ."','".$request->escClave
            ."','".$parametro_ConcPagoInicial
            ."','".$parametro_ConcPagoFinal
            ."','".$parametro_ConcPagoInscripcion
            ."',".$parametro_Semestre_Inicio
            .",".$parametro_Semestre_Fin
            .",".$request->montoDinero
            .",'".$parametro_iniciaFecha
            ."','".$parametro_finFecha."'"
            .",'I','".$temporary_table_name."')");

        $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
        $pagos_deudores_collection = collect( $pagos_deudores_array );

        //dd($pagos_deudores_collection);

        $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
        $parametro_RangoFechas = "Fechas de pago: Todo el periodo";
        if ($request->fechaPago == "rango") {
            $timestamp1 = strtotime($parametro_iniciaFecha);
            $new_date1 = date("d/m/Y", $timestamp1);
            $timestamp2 = strtotime($parametro_finFecha);
            $new_date2 = date("d/m/Y", $timestamp2);
            $parametro_RangoFechas = "Fechas de pago: ".$new_date1." - " .$new_date2;
        }
        $parametro_Periodo = "Periodo: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
        $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion." - Nivel: ".$request->depClave;
        $parametro_Titulo = "RELACIÓN PAGOS RECIBIDOS DE DEUDORES (>= $".$request->montoDinero." M.N.): ".$result[0]->_return_escuela;
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );


        if($pagos_deudores_collection->isEmpty()) {
            alert()->warning('No hay datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar los datos del filtro, como el año y la clave de '.$tipoReporte)->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now("America/Merida");;
        $info_reporte = [
            "pagos" => $pagos_deudores_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format("H:i:s"),
            "nombreArchivo" => $parametro_NombreArchivo,
            "elTitulo" => $parametro_Titulo,
            "elMes" => $parametro_Mes,
            "laUbicacion" => $parametro_Ubicacion,
            "ubiClave" => $request->ubiClave,
            "depClave" =>$request->depClave,
            "elPeriodo" => $parametro_Periodo,
            "elRango" => $parametro_RangoFechas,
            "ultimaFechaPago" => "Ultima fecha de pago: " . UltimaFechaPago::ultimoPago(),
        ];

        if($request->tipo_reporte == "PDF") {

            $pdf = PDF::loadView('reportes.pdf.' . $parametro_NombreArchivo, $info_reporte);
            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        } else {
            return $this->generarExcel($info_reporte);
        }
    }

    public function generarExcel($info)
    {
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
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
        $sheet->getColumnDimension('AE')->setAutoSize(true);
        $sheet->getColumnDimension('AF')->setAutoSize(true);
        $sheet->getStyle('A1:AF1')->getFont()->setBold(true);
        $sheet->mergeCells('A1:AF1'); #encabezado Info del reporte
        $sheet->getStyle('A2:AF2')->getFont()->setBold(true);
        $sheet->mergeCells('A2:B2'); #encabezado periodo y rango de fechas
        $sheet->mergeCells('C2:J2'); #encabezado Periodo3
        $sheet->mergeCells('K2:R2'); #encabezado Periodo1
        $sheet->getStyle('A3:AF3')->getFont()->setBold(true);
        #header fila1
        $sheet->setCellValueByColumnAndRow(1, 1, "{$info['laUbicacion']} | {$info['elTitulo']} | {$info['elPeriodo']} | {$info['ultimaFechaPago']}");
        #header fila2
        $sheet->setCellValueByColumnAndRow(1, 2, "{$info['elRango']}");
        $sheet->setCellValueByColumnAndRow(3, 2, "Periodo 3");
        $sheet->setCellValueByColumnAndRow(11, 2, "Periodo 1");
        #header fila 3
        $sheet->setCellValueByColumnAndRow(1, 3, "Clave pago");
        $sheet->setCellValueByColumnAndRow(2, 3, "Nombre Alumno");
        $sheet->setCellValueByColumnAndRow(3, 3, "Año");
        $sheet->setCellValueByColumnAndRow(4, 3, "Programa");
        $sheet->setCellValueByColumnAndRow(5, 3, "Grado");
        $sheet->setCellValueByColumnAndRow(6, 3, "Grupo");
        $sheet->setCellValueByColumnAndRow(7, 3, "Pago");
        $sheet->setCellValueByColumnAndRow(8, 3, "Curso estado");
        $sheet->setCellValueByColumnAndRow(9, 3, "Alumno estado");
        $sheet->setCellValueByColumnAndRow(10, 3, "Curso cuota");
        $sheet->setCellValueByColumnAndRow(11, 3, "Año");
        $sheet->setCellValueByColumnAndRow(12, 3, "Programa");
        $sheet->setCellValueByColumnAndRow(13, 3, "Grado");
        $sheet->setCellValueByColumnAndRow(14, 3, "Grupo");
        $sheet->setCellValueByColumnAndRow(15, 3, "Pago");
        $sheet->setCellValueByColumnAndRow(16, 3, "Curso estado");
        $sheet->setCellValueByColumnAndRow(17, 3, "Alumno estado");
        $sheet->setCellValueByColumnAndRow(18, 3, "Curso cuota");
        $sheet->setCellValueByColumnAndRow(19, 3, "Inscripción");
        $sheet->setCellValueByColumnAndRow(20, 3, "Septiembre");
        $sheet->setCellValueByColumnAndRow(21, 3, "Octubre");
        $sheet->setCellValueByColumnAndRow(22, 3, "Noviembre");
        $sheet->setCellValueByColumnAndRow(23, 3, "Diciembre");
        $sheet->setCellValueByColumnAndRow(24, 3, "Enero");
        $sheet->setCellValueByColumnAndRow(25, 3, "Inscripción");
        $sheet->setCellValueByColumnAndRow(26, 3, "Febrero");
        $sheet->setCellValueByColumnAndRow(27, 3, "Marzo");
        $sheet->setCellValueByColumnAndRow(28, 3, "Abril");
        $sheet->setCellValueByColumnAndRow(29, 3, "Mayo");
        $sheet->setCellValueByColumnAndRow(30, 3, "Junio");
        $sheet->setCellValueByColumnAndRow(31, 3, "Julio");
        $sheet->setCellValueByColumnAndRow(32, 3, "Agosto");

        $fila = 4;
        foreach($info['pagos'] as $pago) {
            $sheet->setCellValueExplicit("A{$fila}", $pago->cve_pago, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$fila}", $pago->alumno);
            $sheet->setCellValue("C{$fila}", $pago->periodo3_anio);
            $sheet->setCellValue("D{$fila}", $pago->periodo3_cve_programa);
            $sheet->setCellValue("E{$fila}", $pago->periodo3_grado);
            $sheet->setCellValue("F{$fila}", $pago->periodo3_grupo);
            $sheet->setCellValue("G{$fila}", $pago->periodo3_plan_pago);
            $sheet->setCellValue("H{$fila}", $pago->periodo3_curso_estado);
            $sheet->setCellValue("I{$fila}", $pago->periodo3_alumno_estado);
            $sheet->setCellValue("J{$fila}", $pago->periodo3_curso_cuota);
            $sheet->setCellValue("K{$fila}", $pago->periodo1_anio);
            $sheet->setCellValue("L{$fila}", $pago->periodo1_cve_programa);
            $sheet->setCellValue("M{$fila}", $pago->periodo1_grado);
            $sheet->setCellValue("N{$fila}", $pago->periodo1_grupo);
            $sheet->setCellValue("O{$fila}", $pago->periodo1_plan_pago);
            $sheet->setCellValue("P{$fila}", $pago->periodo1_curso_estado);
            $sheet->setCellValue("Q{$fila}", $pago->periodo1_alumno_estado);
            $sheet->setCellValue("R{$fila}", $pago->periodo1_curso_cuota);
            $sheet->setCellValue("S{$fila}", $pago->cve99_cobrado);
            $sheet->setCellValue("T{$fila}", $pago->cve01_cobrado);
            $sheet->setCellValue("U{$fila}", $pago->cve02_cobrado);
            $sheet->setCellValue("V{$fila}", $pago->cve03_cobrado);
            $sheet->setCellValue("W{$fila}", $pago->cve04_cobrado);
            $sheet->setCellValue("X{$fila}", $pago->cve05_cobrado);
            $sheet->setCellValue("Y{$fila}", $pago->cve00_cobrado);
            $sheet->setCellValue("Z{$fila}", $pago->cve06_cobrado);
            $sheet->setCellValue("AA{$fila}", $pago->cve07_cobrado);
            $sheet->setCellValue("AB{$fila}", $pago->cve08_cobrado);
            $sheet->setCellValue("AC{$fila}", $pago->cve09_cobrado);
            $sheet->setCellValue("AD{$fila}", $pago->cve10_cobrado);
            $sheet->setCellValue("AE{$fila}", $pago->cve11_cobrado);
            $sheet->setCellValue("AF{$fila}", $pago->cve12_cobrado);
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("DeudoresPagosAnuales.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("DeudoresPagosAnuales.xlsx"));
    }

}

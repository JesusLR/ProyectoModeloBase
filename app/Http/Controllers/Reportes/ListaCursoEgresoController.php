<?php

namespace App\Http\Controllers\Reportes;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Programa;
use App\Models\Plan;
use App\Http\Helpers\Utils;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ListaCursoEgresoController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    $ubicaciones = Ubicacion::where('ubiClave','<>','000')->get();
    return View('reportes.lista_curso_egreso.create',compact('ubicaciones'));
  }

  public function imprimir(Request $request)
  {
    $validator = Validator::make($request->all(),
      [
        'ubicacion_id'    => 'required',
        'departamento_id'    => 'required',
        'escuela_id'    => 'required',
        'perAnioPAgo'    => 'required|numeric|min:0',
      ]
    );

    if ($validator->fails()) {
      return redirect ('reporte/lista_cursos_egresos')->withErrors($validator)->withInput();
    }

    $ubicacion = Ubicacion::findOrFail($request->ubicacion_id);
    $departamento = Departamento::findOrFail($request->departamento_id);
    $escuela = Escuela::findOrFail($request->escuela_id);
    $programa = $request->programa_id ? Programa::findOrFail($request->programa_id) : NULL;
    $plan = $request->plan_id ? Plan::findOrFail($request->plan_id) : NULL;

    $progClave = $programa ? $programa->progClave : '';
    $planClave = $plan ? $plan->planClave : '';
    
    $results = DB::select("call procUniversidadListaAcreditacion("
      .$request->perAnioPAgo
      .",'".$ubicacion->ubiClave
      ."','".$escuela->escClave
      ."','".$progClave
      ."','".$planClave
      ."')");

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
    $sheet->getColumnDimension('O')->setAutoSize(true);

    # Contenido título.
    $sheet->getStyle('A1:M1')->getFont()->setBold(true);
    $sheet->setCellValue('A1', "#");
    $sheet->setCellValue('B1', 'Clave depago');
    $sheet->setCellValue('C1', "Apellido 1");
    $sheet->setCellValue('D1', "Apellido 2");
    $sheet->setCellValue('E1', "Nombres");
    $sheet->setCellValue('F1', "Último Curso");
    $sheet->setCellValue('G1', "Programa");
    $sheet->setCellValue('H1', "Nombre Programa");
    $sheet->setCellValue('I1', "Plan");
    $sheet->setCellValue('J1', "Fecha Ingreso");
    $sheet->setCellValue('K1', "Prog Ingreso");
    $sheet->setCellValue('L1', "Nombre Programa Ingreso");
    $sheet->setCellValue('M1', "Plan Ingreso");
    $sheet->setCellValue('N1', "Fecha Egreso");
    $sheet->setCellValue('O1', "Fecha Titulación");
    $sheet->setCellValue('P1', "Opción Titulación");

    $fila = 2;
    foreach($results as $result) {
      $sheet->setCellValue("A{$fila}", $result->consecutivo);
      $sheet->setCellValue("B{$fila}", $result->clavePago);
      $sheet->setCellValue("C{$fila}", $result->apellido1);
      $sheet->setCellValue("D{$fila}", $result->apellido2);
      $sheet->setCellValue("E{$fila}", $result->nombres);
      $sheet->setCellValue("F{$fila}", $result->fechaProgACtual ? Carbon::parse($result->fechaProgACtual)->format('d/m/Y') : '');
      $sheet->setCellValue("G{$fila}", $result->claveProgActual);
      $sheet->setCellValue("H{$fila}", $result->programaActual);
      $sheet->setCellValue("I{$fila}", $result->planActual);
      $sheet->setCellValue("J{$fila}", $result->fechaIngreso ? Carbon::parse($result->fechaIngreso)->format('d/m/Y') : '');
      $sheet->setCellValue("K{$fila}", $result->claveProgIngreso);
      $sheet->setCellValue("L{$fila}", $result->programaIngreso);
      $sheet->setCellValue("M{$fila}", $result->planIngreso);
      $sheet->setCellValue("N{$fila}", $result->fechaEgreso ? Carbon::parse($result->fechaEgreso)->format('d/m/Y'): '');
      $sheet->setCellValue("O{$fila}", $result->fechaTitulacion);
      $sheet->setCellValue("P{$fila}", $result->opcionTitulacion);
      $fila++;
    }

    $writer = new Xlsx($spreadsheet);
    try {
        $writer->save(storage_path("ListaCursosEgresos.xlsx"));
    } catch (Exception $e) {
        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
        return back()->withInput();
    }
    return response()->download(storage_path("ListaCursosEgresos.xlsx"));
  }
}

<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

use App\Http\Models\InscritoExtraordinario;
use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Programa;
use App\Http\Models\Aula;
use App\Http\Models\Extraordinario;
use App\Http\Models\Optativa;

use Carbon\Carbon;
use Validator;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProgramacionExamenesController extends Controller
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
    return View('reportes/programacion_examenes.create', [
      'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }

  public function imprimir(Request $request)
  {
    $validator = Validator::make($request->all(),
    [
        'extFecha'      => 'date_format:Y-m-d|nullable',
        'extHora'         => 'date_format:H:i:s|nullable'
    ],
    [
        'extFecha.date_format' => "La fecha no tiene el formato correcto",
        'extHora.date_format' => "La hora no tiene el formato correcto"
    ]
    );
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $periodo = Periodo::findOrFail($request->periodo_id);

    $progExamenes = new Collection;
    self::buscarExtraordinarios($request)
    ->chunk(150, static function($registros) use ($progExamenes) {
      if($registros->isEmpty())
        return false;

      $registros->each(static function($extraordinario) use ($progExamenes) {
        $progExamenes->push(self::info_esencial($extraordinario));
      });
    });
     
    if($progExamenes->isEmpty()){
      alert()->warning('Sin coincidencias', 'No existen registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
          return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');

    //variables que se mandan a la vista fuera del array
    $programaNombre = $request->programa_id ? Programa::findOrFail($request->programa_id) : null;
    $ubicacionNombre = $periodo->departamento->ubicacion;
    $perFechas = $periodo->perFechaInicial.' al '.$periodo->perFechaFinal.' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';
    $tipoInscrip = '';
    switch ($request->regular) {
      case 'p':
      $tipoInscrip = 'Solo pagadas';
      break;
      case 'n':
      $tipoInscrip = 'Solo no pagadas';
      break;
      case 't':
      $tipoInscrip = 'Pagadas y no pagadas';
      break;      
    }

    if ($request->formato == 'PDF') {
      $nombreArchivo = 'pdf_programacion_examenes';
      return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
        "progExamenes" => $progExamenes->sortBy('ordenar')->unique('extraId')->groupBy(['agrupacion', 'gdo']),
        "fechaActual" => $fechaActual->format('d/m/Y'),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo.'.pdf',
        "programaNombre" => $programaNombre,
        "ubicacionNombre" => $ubicacionNombre,
        "tipoInscrip" => $tipoInscrip,
        "periodo" => $perFechas,
      ])->stream($nombreArchivo.'.pdf');
    } else {
      $response = $this->generarExcel(
        $progExamenes->sortBy('ordenar')->unique('extraId')->groupBy(['agrupacion', 'gdo']),
        $perFechas,
        $ubicacionNombre,
        $programaNombre,
        $tipoInscrip,
        $periodo,
        $request->estadoPago
      );
  
      if ($response['error']) {
        alert('Ha ocurrido un problema', $response['msg'], 'error')->showConfirmButton();
        return back()->withInput();
      }
      return response()->download(storage_path($response['filaName']));
    }
  }

  public function generarExcel($progExamenes, $perFechas, $ubicacionNombre, $programaNombre, $tipoInscrip, $periodo, $estadoPago)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $modoRegistro = 'Estado de pago cualquiera (pagado o pendiente por pagar)';
    if ($estadoPago == 'p') $modoRegistro = 'Pendiente por pagar';
    if ($estadoPago == 'e') $modoRegistro = 'Pago recibido en efectivo';
    if ($estadoPago == 'b') $modoRegistro = 'Pago recibido en banco';

    $sheet->setCellValue('A1', 'Período');
    $sheet->setCellValue('B1', $perFechas);
    $sheet->setCellValue('E1', 'Inscrip: '.$tipoInscrip);
    $sheet->setCellValue('F1', 'Tipo Pago: '.$modoRegistro);
    $sheet->setCellValue('H1', 'Fecha de impresión: '.Carbon::now('America/Merida')->format('d/m/Y'));
    $sheet->setCellValue('J1', 'Hora de impresión: '.Carbon::now('America/Merida')->format('H:i:s'));
    $sheet->setCellValue('L1', 'Nombre del controlador: ProgramacionExamenesController');

    $sheet->setCellValue('A2', 'Ubi');
    $sheet->setCellValue('B2', 'Dep');
    $sheet->setCellValue('C2', 'Esc');
    $sheet->setCellValue('D2', 'Prog');
    $sheet->setCellValue('E2', 'Plan');
    $sheet->setCellValue('F2', 'Materia');
    $sheet->setCellValue('G2', 'Nombre Materia');
    $sheet->setCellValue('H2', 'Empleado');
    $sheet->setCellValue('I2', 'Nombre Empleado');
    $sheet->setCellValue('J2', 'Grado');
    $sheet->setCellValue('K2', 'Grupo');
    $sheet->setCellValue('L2', 'Aula');
    $sheet->setCellValue('M2', 'Fecha Examen');
    $sheet->setCellValue('N2', 'Hora');
    $sheet->setCellValue('O2', 'Costo');
    $sheet->setCellValue('P2', 'Sol');
    $sheet->setCellValue('Q2', 'Total');

    $solTotal = 0;
    $priceTotal = 0;

    foreach ($progExamenes as $programa) {
      $primerExamen = $programa->first()->first();
      $progClave = $primerExamen['progClave'];

      $cell = 3;
      foreach($programa as $grado) {
        $iteration = 1;
        foreach ($grado as $examen) {
          $solTotal += $examen["sol"];

          $costo =  $examen["costo"] ? $examen["costo"]: 0;
          $priceSubTotal = $costo * $examen["sol"];
          $priceTotal += $costo * $examen["sol"];

          $hora = $examen["extHora"] ? \Carbon\Carbon::createFromFormat('H:i:s',$examen["extHora"])->format('h:i A'):'';

          $sheet->setCellValue('A'.$cell, $ubicacionNombre->ubiClave);
          $sheet->setCellValue('B'.$cell, $periodo->departamento->depClave);
          $sheet->setCellValue('C'.$cell, $examen["escClave"]);
          $sheet->setCellValue('D'.$cell, $examen["progClave"]);
          $sheet->setCellValue('E'.$cell, $examen["planClave"]);
          $sheet->setCellValue('F'.$cell, $examen["matClave"]);
          $sheet->setCellValue('G'.$cell, $examen["matNombre"].' '.$examen["optNombre"]);
          $sheet->setCellValue('H'.$cell, $examen['personaId']);
          $sheet->setCellValue('I'.$cell, ($examen['sinodalNombre'] ? $examen["sinodalNombre"]: $examen['empleadoNombre']));
          $sheet->setCellValue('J'.$cell, $examen["gdo"]);
          $sheet->setCellValue('K'.$cell, $examen["gpo"]);
          $sheet->setCellValue('L'.$cell, $examen["aula"]);
          $sheet->setCellValue('M'.$cell, $examen["extFecha"]);
          $sheet->setCellValue('N'.$cell, $hora);
          $sheet->setCellValue('O'.$cell, $examen["costo"]? number_format($examen["costo"],0, '', ''): '');
          $sheet->setCellValue('P'.$cell, $examen["sol"]);
          $sheet->setCellValue('Q'.$cell, number_format($priceSubTotal,0, '', ''));

          $cell++;
          $iteration++;
        }
      }

      $solTotal = 0;  
      $priceTotal = 0;
    }

    $writer = new Xlsx($spreadsheet);

    try {
      $writer->save(storage_path('excel_programacion_examenes.xlsx'));
    } catch (Exception $e) {
      return [
        'error' => true,
        'msg' => $e->getMessage()
      ];
    }

    return [
      'error' => false,
      'filaName' => 'excel_programacion_examenes.xlsx'
    ];
  }

  public function generarExcelFormat($progExamenes, $perFechas, $ubicacionNombre, $programaNombre, $tipoInscrip)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'UNIVERSIDAD MODELO');
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->setCellValue('N1', Carbon::now('America/Merida')->format('d/m/Y'));
    $sheet->setCellValue('N2', Carbon::now('America/Merida')->format('H:i:s'));
    $sheet->setCellValue('A3', 'PROGRAMACION DE EXAMENES EXTRAORDINARIOS');
    $sheet->getStyle('A3')->getFont()->setBold(true);
    $sheet->setCellValue('N3', 'excel_programacion_examenes.xlsx');
    $sheet->setCellValue('A5', 'Período: '.$perFechas);
    $sheet->setCellValue('A6', 'Ubicación: '.$ubicacionNombre->ubiClave.' '.$ubicacionNombre->ubiNombre);
    $sheet->setCellValue('A7', $programaNombre? 'Niv/Carr: '.$programaNombre->progClave.' '.$programaNombre->progNombre : '');
    $sheet->setCellValue('A8', 'Inscrip: '.$tipoInscrip);

    $sheet->setCellValue('B10', 'Num');
    $sheet->setCellValue('C10', 'CveEx');
    $sheet->setCellValue('D10', 'Plan');
    $sheet->setCellValue('E10', 'Materia');
    $sheet->setCellValue('F10', 'Nombre de la materia');
    $sheet->setCellValue('G10', 'Gdo');
    $sheet->setCellValue('H10', 'Gpo');
    $sheet->setCellValue('I10', 'Fecha exam');
    $sheet->setCellValue('J10', 'Hora');
    $sheet->setCellValue('K10', 'Costo');
    $sheet->setCellValue('L10', 'Sol');
    $sheet->setCellValue('M10', 'Total');
    $sheet->getStyle('B10:M10')->getFont()->setBold(true);
    $sheet->getStyle('B10:M10')->getAlignment()->setHorizontal('center');

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

    $solTotal = 0;
    $priceTotal = 0;

    foreach ($progExamenes as $programa) {
      $primerExamen = $programa->first()->first();
      $progClave = $primerExamen['progClave'];
      
      $sheet->setCellValue('B11', 'Niv/Carr:');
      $sheet->setCellValue('C11', $progClave);

      $cell = 12;
      foreach($programa as $grado) {
        $iteration = 1;
        foreach ($grado as $examen) {
          $solTotal += $examen["sol"];

          $costo =  $examen["costo"] ? $examen["costo"]: 0;
          $priceSubTotal = $costo * $examen["sol"];
          $priceTotal += $costo * $examen["sol"];

          $hora = $examen["extHora"] ? \Carbon\Carbon::createFromFormat('H:i:s',$examen["extHora"])->format('h:i'):'';

          $sheet->setCellValue('B'.$cell, $iteration);
          $sheet->setCellValue('C'.$cell, $examen["extraId"]);
          $sheet->setCellValue('D'.$cell, $examen["planClave"]);
          $sheet->setCellValue('E'.$cell, $examen["matClave"]);
          $sheet->setCellValue('F'.$cell, $examen["matNombre"].' '.$examen["optNombre"].' - '.($examen['sinodalNombre'] ? $examen["sinodalNombre"]: $examen['empleadoNombre']));
          $sheet->setCellValue('G'.$cell, $examen["gdo"]);
          $sheet->setCellValue('H'.$cell, $examen["gpo"]);
          $sheet->setCellValue('I'.$cell, $examen["extFecha"]);
          $sheet->setCellValue('J'.$cell, $hora);
          $sheet->setCellValue('K'.$cell, $examen["costo"]? '$'.number_format($examen["costo"],0): '');
          $sheet->getStyle('K'.$cell)->getAlignment()->setHorizontal('right');
          $sheet->setCellValue('L'.$cell, $examen["sol"]);
          $sheet->setCellValue('M'.$cell, '$'.number_format($priceSubTotal,0));
          $sheet->getStyle('M'.$cell)->getAlignment()->setHorizontal('right');

          $cell++;
          $iteration++;
        }
        $cell++;
      }
      $sheet->setCellValue('L'.$cell, $solTotal);
      $sheet->setCellValue('M'.$cell, '$'.number_format($priceTotal,0));
      $sheet->getStyle('M'.$cell)->getAlignment()->setHorizontal('right');

      $solTotal = 0;  
      $priceTotal = 0;
    }

    $writer = new Xlsx($spreadsheet);
    try {
      $writer->save(storage_path("excel_programacion_examenes.xlsx"));
    } catch (Exception $e) {
      alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
      return back()->withInput();
    }

    return response()->download(storage_path("excel_programacion_examenes.xlsx"));
  }

  /**
   * @param App\Http\Models\Extraordinario
   */
  private static function info_esencial($extraordinario) {
    $materia = $extraordinario->materia;
    $plan = $materia->plan;
    $programa = $plan->programa;

    return [  
        'extraId' => $extraordinario->id,
        'planClave' => $plan->planClave,
        'matClave' => $materia->matClave,
        'matNombre' => $materia->matNombreOficial,
        'optNombre' => ($extraordinario->optativa_id != 0 && $extraordinario->optativa) ? $extraordinario->optativa->optNombre : '',
        'personaId' => $extraordinario->empleado->persona->id,
        'empleadoNombre' => $extraordinario->empleado->persona->nombreCompleto(true),
        'sinodalNombre' => $extraordinario->empleado_sinodal_id ? $extraordinario->empleadoSinodal->persona->nombreCompleto(true) : '',
        'aula' => $extraordinario->aula->aulaClave,
        'gdo' => $materia->matSemestre,
        'gpo' => $extraordinario->extGrupo,
        'extFecha' => $extraordinario->extFecha,
        'extHora' => $extraordinario->extHora,
        'costo' => $extraordinario->extPago,
        'sol' => $extraordinario->extAlumnosInscritos,
        'progClave' => $programa->progClave,
        'progNombre' => $programa->progNombre,
        'ordenar' => $programa->progClave.$plan->planClave.str_pad($materia->matSemestre, 2, "0", STR_PAD_LEFT).$materia->matNombreOficial,
        'agrupacion' => $programa->progClave.$plan->planClave,
        'escClave' => $programa->escuela->escClave
      ];
  }

  /**
   * @param Illuminate\Http\Request
   */
  private static function buscarExtraordinarios($request) {

    return Extraordinario::with(['materia.plan.programa.escuela', 'aula', 'inscritos', 'empleado.persona', 'empleadoSinodal.persona', 'optativa'])
    ->whereHas('materia.plan.programa.escuela', static function($query) use ($request) {
      if($request->matClave)
        $query->where('matClave', $request->matClave);
      if($request->plan_id)
        $query->where('plan_id', $request->plan_id);
      if($request->programa_id)
        $query->where('programa_id', $request->programa_id);
      if($request->escuela_id)
        $query->where('escuela_id', $request->escuela_id);
      if($request->departamento_id)
        $query->where('departamento_id', $request->departamento_id);
    })
    ->where(static function($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
      if($request->examenId)
        $query->where('id', $request->examenId);
      if($request->empleado_sinodal_id)
        $query->where('empleado_sinodal_id', $request->empleado_sinodal_id);
      if($request->extGrupo)
        $query->where('extGrupo', $request->extGrupo);
      if($request->extFecha)
        $query->where('extFecha', $request->extFecha);
      if($request->extHora)
        $query->where('extHora', $request->extHora);
      if($request->extPago)
        $query->where('extPago', $request->extPago);
      if($request->inscritos == 'si')
        $query->where('extAlumnosInscritos', '>', 0);
      if($request->inscritos == 'no')
        $query->where('extAlumnosInscritos', '=', 0);

      if ($request->estadoPago == 'p') {
        $query->whereHas('inscritos', static function($query) {
          $query->where('iexEstado', 'a')
          ->orWhere('iexEstado', 'n');
        });
      }
      if ($request->estadoPago == 'e') {
        $query->whereHas('inscritos', static function($query) {
          $query->where('iexEstado', 'p')
          ->where('iexModoRegistro', 'e');
        });
      }
      if ($request->estadoPago == 'b') {
        $query->whereHas('inscritos', static function($query) {
          $query->where('iexEstado', 'p')
          ->where('iexModoRegistro', 'b');
        });
      }

      if(in_array($request->regular, ['p', 't']) && $request->inscritos == 'si') {
        $query->whereHas('inscritos', static function($query) use ($request) {
          $request->regular == 'p' ? $query->where('iexEstado', 'P') : $query->where('iexEstado', '!=', 'C');
        });
      } elseif ($request->regular == 'n' && $request->inscritos == 'si') {
        $query->whereHas('inscritos', static function($query) {
          $query->where('iexEstado', '!=', 'A');
        });
      }

      if($request->aulaClave) {
        $query->whereHas('aula', static function($query) use ($request) {
          $query->where('aulaClave', $request->aulaClave);
        });
      }

    });
  }
}
<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Pago;
use App\Models\Ubicacion;
use App\clases\cgts\MetodosCgt;
use App\Http\Helpers\Utils;
use App\Models\Cgt;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Programa;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerInscritosPreinscritosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $tiposIngreso = array(
            'NI' => 'NUEVO INGRESO',
            'PI' => 'PRIMER INGRESO',
            'RO' => 'REPETIDOR',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO',
            'EQ' => 'REVALIDACIÓN',
            'OY' => 'OYENTE',
            'XX' => 'OTRO',
            '' => 'TODOS'
        );
        $alumnos_curso = array(
            'P' => 'PREINSCRITOS',
            'R' => 'INSCRITOS',
            'C' => 'CONDICIONADO',
            'A' => 'CONDICIONADO 2',
            '' => 'TODOS',
        );
        $alumnos_estado = array(
            'N' => 'NUEVO INGRESO',
            'R' => 'REINGRESO',
            '' => 'TODOS',
        );
        $tipo_reporte = array(
            'R' => 'SOLO RAYAS PARA FIRMA',
            'N' => 'NORMAL(SE IMPRIMEN TODOS LOS DATOS)',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );
        $orden_reporte = array(
            'N' => 'NOMBRE(EMPEZANDO POR APELLIDOS)',
            'F' => 'FECHA DE INSCRIPCIÓN(SE ACTIVA SÓLO SI ELIGE TIPO DE REPORTE NORMAL)',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );
        $espaciado = array(
            '1' => 'SENCILLO',
            '2' => 'DOBLE',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );

        $tipoformato = array(
            '1' => 'PDF',
            '2' => 'EXCEL'
        );

        $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();

        $departamentos = Departamento::where('depClave', '=', 'BAC')->get();

        //dd($departamentos);

        return view('bachiller.reportes.inscritos_preinscritos.create', compact(
            'tiposIngreso',
            'alumnos_curso',
            'alumnos_estado',
            'tipo_reporte',
            'orden_reporte',
            'espaciado',
            'ubicaciones',
            'departamentos',
            'tipoformato'
        ));
    }

    // usar para excel
    public function imprimir(Request $request)
    {
        $cursos = Curso::with([
            'cgt' => function ($query) {
                $query->select('id', 'plan_id', 'cgtGradoSemestre', 'cgtGrupo')
                    ->with(['plan' => function ($query) {
                        $query->select('id', 'planClave', 'programa_id')
                            ->with(['programa' => function ($query) {
                                $query->select('id', 'escuela_id', 'progClave', 'progNombre')
                                    ->with(['escuela' => function ($query) {
                                        $query->select('id', 'departamento_id', 'escClave', 'escNombre')
                                            ->with(['departamento' => function ($query) {
                                                $query->select('id', 'ubicacion_id', 'depClave', 'depNombre')
                                                    ->with(['ubicacion' => function ($query) {
                                                        $query->select('id', 'ubiClave', 'ubiNombre');
                                                    }]);
                                            }]);
                                    }]);
                            }]);
                    }]);
            },
            'periodo' => function ($query) {
                $query->select('id', 'perNumero', 'perAnio',  'perAnioPago', 'perFechaInicial', 'perFechaFinal');
            }
        ])
            ->whereHas('periodo', function ($query) use ($request) {
                $query->where('periodo_id', $request->periodo_id);
            })
            ->whereHas('alumno', function ($query) use ($request) {
                $query->where('aluClave', 'like', '%' . $request->input('aluClave') . '%')
                    ->where('aluEstado', 'like', '%' . $request->input('aluEstado') . '%');
            })
            ->whereHas('alumno.persona', function ($query) use ($request) {
                $query->where('perApellido1', 'like', '%' . $request->input('perApellido1') . '%')
                    //->where('perApellido2', 'like', '%'.$request->input('perApellido2').'%')
                    ->where('perNombre', 'like', '%' . $request->input('perNombre') . '%');
            })
            ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', function ($query) use ($request) {
                $query->where('departamento_id', $request->departamento_id);
                if ($request->escuela_id) {
                    $query->where('escuela_id', $request->escuela_id);
                }
                if ($request->programa_id) {
                    $query->where('programa_id', $request->programa_id);
                }
                if ($request->plan_id) {
                    $query->where('plan_id', $request->plan_id);
                }
                if ($request->cgtGradoSemestre) {
                    $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
                }
                if ($request->cgtGrupo) {
                    $query->where('cgtGrupo', $request->cgtGrupo);
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->curTipoIngreso) {
                    $query->where('curTipoIngreso', $request->curTipoIngreso);
                }
            })
            ->distinct()
            ->select('cgt_id', 'periodo_id', 'curEstado')
            ->get();

        if ($cursos->isEmpty()) {
            alert()->warning('Sin Información', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $cgts = $cursos->sortBy(static function ($curso) {
            $cgt = $curso->cgt;
            return MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);
        })->unique("cgt.id");


        // $cgts->get();
        if (count($cgts)) {

            if ($request->tipoformato == 1) {
                return $this->imprimirPDF($request);
            }

            if ($request->tipoformato == 2) {
                return $this->generarExcel($cgts, $request);
            }
        } else {
            alert()->error('Error...', 'No se encontraron datos')->showConfirmButton();
            return redirect('bachiller_reporte/bachiller_inscrito_preinscrito')->withInput();
        }

        // return response()->json($alumno);
    }

    public function generarExcel($cgts, $request)
    {
        $contador = 1;
        $contador2 = 1;

        $spreadsheet = new Spreadsheet();

        $cgt_agrupados = $cgts->groupBy('cgt_id');

        foreach ($cgt_agrupados as $cgt_agru => $valores) {
            foreach ($valores as $cgt_asinado) {
                if ($cgt_agru == $cgt_asinado->cgt_id) {


                    //elegir el título que va a tener el reporte
                    switch ($request->input('curEstado')) {
                        case 'P':
                            $textoTitulo = "ALUMNOS PREINSCRITOS";
                            break;
                        case 'R':
                            $textoTitulo = "ALUMNOS INSCRITOS";
                            break;
                        case 'C':
                            $textoTitulo = "ALUMNOS CONDICIONADOS";
                            break;
                        case 'A':
                            $textoTitulo = "ALUMNOS CONDICIONADOS";
                            break;
                        default:
                            $textoTitulo = "ALUMNOS PREINSCRITOS, INSCRITOS Y CONDICIONADOS";
                            break;
                    }



                    $fechaActual1 = Carbon::now('America/Merida');
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    // En windows
                    setlocale(LC_ALL, 'es_MX', 'es', 'ES');
                    $fechaActual = $fechaActual1->format("d/m/y");
                    $horaActual = $fechaActual1->format("h:i:s");

                    //valores para celdas de datos
                    $altoCelda = 15;

                    $GLOBALS['tipoReporte'] = $request->input('tipoReporte');
                    $GLOBALS["saltoLinea"] = $altoCelda * $request->input('espaciadoLinea');




                    foreach ($cgts as $cgt) {

                        //periodo
                        $mes = \Carbon\Carbon::parse($cgt->periodo->perFechaInicial)->format('m');
                        $dia = \Carbon\Carbon::parse($cgt->periodo->perFechaInicial)->format('d');
                        $year = \Carbon\Carbon::parse($cgt->periodo->perFechaInicial)->format('Y');
                        $fechaInicio = $dia . '/' . Utils::num_meses_corto_string($mes) . '/' . $year;

                        $mes2 = \Carbon\Carbon::parse($cgt->periodo->perFechaFinal)->format('m');
                        $dia2 = \Carbon\Carbon::parse($cgt->periodo->perFechaFinal)->format('d');
                        $year2 = \Carbon\Carbon::parse($cgt->periodo->perFechaFinal)->format('Y');
                        $fechaFin = $dia2 . '/' . Utils::num_meses_corto_string($mes2) . '/' . $year2;


                        //consulta para cada alumno del grupo
                        $cgt_id = $cgt->cgt_id;

                        //Validamos por que sei en apellido materno esta en NULL no se refleja el registro
                        if ($request->input('perApellido2') != "") {
                            $alumno = Curso::select(
                                'cursos.id as curso',
                                'cursos.curTipoIngreso',
                                'cursos.curTipoBeca',
                                'cursos.curPorcentajeBeca',
                                'alumnos.aluClave',
                                'alumnos.aluEstado',
                                'personas.perApellido1',
                                'personas.perApellido2',
                                'personas.perNombre',
                                'personas.perCurp',
                                'cursos.curEstado',
                                'cursos.cgt_id'
                            )
                                ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                                ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
                                ->where('cursos.cgt_id', '=', $cgt_id)
                                ->where('cursos.curEstado', 'like', '%' . $request->input('curEstado') . '%')
                                ->where('personas.perApellido1', 'like', '%' . $request->input('perApellido1') . '%')
                                //->where('personas.perApellido2', 'like', '%'.$request->input('perApellido2').'%')
                                ->where('personas.perNombre', 'like', '%' . $request->input('perNombre') . '%')
                                ->where('alumnos.aluClave', 'like', '%' . $request->input('aluClave') . '%')
                                ->where('alumnos.aluEstado', 'like', '%' . $request->input('aluEstado') . '%');
                        } else {
                            $alumno = Curso::select(
                                'cursos.id as curso',
                                'cursos.curTipoIngreso',
                                'cursos.curTipoBeca',
                                'cursos.curPorcentajeBeca',
                                'alumnos.aluClave',
                                'alumnos.aluEstado',
                                'personas.perApellido1',
                                'personas.perApellido2',
                                'personas.perNombre',
                                'personas.perCurp',
                                'cursos.curEstado',
                                'cursos.cgt_id'
                            )
                                ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                                ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
                                ->where('cursos.cgt_id', '=', $cgt_id)
                                ->where('cursos.curEstado', 'like', '%' . $request->input('curEstado') . '%')
                                ->where('personas.perApellido1', 'like', '%' . $request->input('perApellido1') . '%')
                                // ->where('personas.perApellido2', 'like', '%'.$request->input('perApellido2').'%')
                                ->where('personas.perNombre', 'like', '%' . $request->input('perNombre') . '%')
                                ->where('alumnos.aluClave', 'like', '%' . $request->input('aluClave') . '%')
                                ->where('alumnos.aluEstado', 'like', '%' . $request->input('aluEstado') . '%');
                        }

                        if ($request->input('ordenReporte') == 'N') {
                            $alumno = $alumno->orderBy('perApellido1', 'asc')
                                ->orderBy('perApellido2', 'asc')
                                ->orderBy('perNombre', 'asc');
                        }

                        if ($request->curTipoIngreso) {
                            $alumno = $alumno->where('curTipoIngreso', $request->curTipoIngreso);
                        }

                        $alumno = $alumno->get();


                        if (!$request->curEstado) {
                            $alumno = $alumno->where("curEstado", "!=", "B");
                        }

                        $sheet = $spreadsheet->createSheet();
                        $sheet->setTitle($cgt->cgt->cgtGradoSemestre . '-' . $cgt->cgt->cgtGrupo);
                        $sheet->getColumnDimension('A')->setAutoSize(true);
                        $sheet->getColumnDimension('B')->setAutoSize(true);
                        $sheet->getColumnDimension('C')->setAutoSize(true);
                        $sheet->getColumnDimension('D')->setAutoSize(true);
                        $sheet->getColumnDimension('E')->setAutoSize(true);
                        $sheet->getColumnDimension('F')->setAutoSize(true);
                        $sheet->getColumnDimension('G')->setAutoSize(true);
                        $sheet->getColumnDimension('H')->setAutoSize(true);
                        $sheet->getColumnDimension('I')->setAutoSize(true);
                        // $sheet->getColumnDimension('J')->setAutoSize(true);
                        // $sheet->getColumnDimension('K')->setAutoSize(true);
                        // $sheet->getColumnDimension('L')->setAutoSize(true);
                        // $sheet->getColumnDimension('L')->setAutoSize(true);
                        // $sheet->getColumnDimension('M')->setAutoSize(true);
                        // $sheet->getColumnDimension('N')->setAutoSize(true);
                        // $sheet->getColumnDimension('O')->setAutoSize(true);
                        // $sheet->getColumnDimension('P')->setAutoSize(true);
                        // $sheet->getColumnDimension('Q')->setAutoSize(true);
                        // $sheet->getColumnDimension('R')->setAutoSize(true);
                        // $sheet->getColumnDimension('S')->setAutoSize(true);
                        // $sheet->getColumnDimension('T')->setAutoSize(true);
                        // $sheet->getColumnDimension('U')->setAutoSize(true);
                        // $sheet->getColumnDimension('V')->setAutoSize(true);

                        // $sheet->mergeCells("D1");
                        $sheet->getStyle('D1')->getFont()->setBold(true);
                        $sheet->setCellValue('D1', 'Preparatoria "ESCUELA MODELO"');

                        // $sheet->mergeCells("D2");
                        $sheet->getStyle('D2')->getFont()->setBold(true);
                        $sheet->setCellValue('D2', "ALUMNOS PREINSCRITOS, INSCRITOS Y CONDICIONADOS");

                        $sheet->getStyle('D4')->getFont()->setBold(true);
                        $sheet->setCellValue('D4', "Período: {$fechaInicio} - {$fechaFin} ({$cgt->periodo->perNumero}-{$cgt->periodo->perAnio})");

                        $sheet->getStyle('D5')->getFont()->setBold(true);
                        $sheet->setCellValue('D5', "Nivel/Carrera: {$cgt->cgt->plan->programa->progClave} ({$cgt->cgt->plan->planClave}) {$cgt->cgt->plan->programa->progNombre}");

                        $sheet->getStyle('D6')->getFont()->setBold(true);
                        $sheet->setCellValue('D6', "Ubicación: {$cgt->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave}-{$cgt->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre}");

                        if ($request->tipoReporte == "R") {
                            $sheet->getStyle('G1')->getFont()->setBold(true);
                            $sheet->setCellValue('G1', "Fecha: {$fechaActual}");

                            $sheet->getStyle('G2')->getFont()->setBold(true);
                            $sheet->setCellValue('G2', "Hora: {$horaActual}");

                            $sheet->getStyle('G4')->getFont()->setBold(true);
                            $sheet->setCellValue('G4', "Semestre: {$cgt->cgt->cgtGradoSemestre} Grupo: {$cgt->cgt->cgtGrupo}");
                        }


                        if ($request->tipoReporte == "N") {
                            $sheet->getStyle('H1')->getFont()->setBold(true);
                            $sheet->setCellValue('H1', "Fecha: {$fechaActual}");

                            $sheet->getStyle('H2')->getFont()->setBold(true);
                            $sheet->setCellValue('H2', "Hora: {$horaActual}");

                            $sheet->getStyle('H4')->getFont()->setBold(true);
                            $sheet->setCellValue('H4', "Semestre: {$cgt->cgt->cgtGradoSemestre} Grupo: {$cgt->cgt->cgtGrupo}");
                        }



                        $sheet->getStyle('A8:I8')->getFont()->setBold(true);
                        $sheet->setCellValueByColumnAndRow(1, 8, "Num");
                        $sheet->setCellValueByColumnAndRow(2, 8, "Cve Pago");
                        $sheet->setCellValueByColumnAndRow(3, 8, "C.U.R.P ");
                        $sheet->setCellValueByColumnAndRow(4, 8, "Nombre del alumno");
                        $sheet->setCellValueByColumnAndRow(5, 8, "Sem");
                        $sheet->setCellValueByColumnAndRow(6, 8, "Grupo");

                        if ($request->tipoReporte == "R") {
                            $sheet->setCellValueByColumnAndRow(7, 8, "Firma");
                        }

                        if ($request->tipoReporte == "N") {
                            $sheet->setCellValueByColumnAndRow(7, 8, "Ingr");
                            $sheet->setCellValueByColumnAndRow(8, 8, "Pagó Inscr");
                            $sheet->setCellValueByColumnAndRow(9, 8, "Beca");

                            $columnFilterFecha = $spreadsheet->getActiveSheet()->setAutoFilter("A8:I8");
                        }


                        $fila = 9;




                        foreach ($alumno as $key => $alumno) {

                            // Solucitud de espacio entre lineas 
                            if ($request->espaciadoLinea == 1) {
                                $spreadsheet->getActiveSheet()->getRowDimension($fila)->setRowHeight(15);
                            }
                            if ($request->espaciadoLinea == 2) {
                                $spreadsheet->getActiveSheet()->getRowDimension($fila)->setRowHeight(30);
                            }


                            $sheet->setCellValue("A{$fila}", $key + 1);
                            $sheet->setCellValue("B{$fila}", $alumno->aluClave);
                            $sheet->setCellValue("C{$fila}", $alumno->perCurp);
                            $sheet->setCellValue("D{$fila}", $alumno->perApellido1 . ' ' . $alumno->perApellido2 . ' ' . $alumno->perNombre);
                            $sheet->setCellValue("E{$fila}", $cgt->cgt->cgtGradoSemestre);
                            $sheet->setCellValue("F{$fila}", $cgt->cgt->cgtGrupo);


                            $conceptoInscripcion = $cgt->periodo->perNumero == 1 ? '00' : '99';
                            $datoPagoInscripcion = Pago::where(["pagClaveAlu" => $alumno->aluClave, "pagAnioPer" => $cgt->periodo->perAnioPago, "pagConcPago" => $conceptoInscripcion])->first();
                            if ($datoPagoInscripcion) {
                                $datoPagoInscripcion = Carbon::parse($datoPagoInscripcion->pagFechaPago)->format("Y-m-d");
                            } else {
                                $datoPagoInscripcion = "";
                            }

                            if ($alumno->curPorcentajeBeca > 0) {
                                $datoBeca = sprintf("%s %s%%", $alumno->curTipoBeca, $alumno->curPorcentajeBeca);
                            } else {
                                $datoBeca = "";
                            }

                            if ($request->tipoReporte == "R") {
                                $sheet->setCellValue("G{$fila}", "______________________");
                            }

                            if ($request->tipoReporte == "N") {
                                $sheet->setCellValue("G{$fila}", $alumno->curTipoIngreso . ' ' . $alumno->aluEstado);
                                $sheet->setCellValue("H{$fila}", $datoPagoInscripcion);
                                $sheet->setCellValue("I{$fila}", $datoBeca);
                            }






                            $fila++;
                        }
                    }
                }
            }

            $contador = 1;


            $writer = new Xlsx($spreadsheet);

            // return $contador;
            try {
                $writer->save(storage_path("BachillerInscritosPreinscritosController.xlsx"));
            } catch (Exception $e) {
                alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
                return back()->withInput();
            }
            return response()->download(storage_path("BachillerInscritosPreinscritosController.xlsx"));
        }
    }

    // usar para PDF 
    public function imprimirPDF($request)
    {
        // $cursos = Curso::with([
        //     'cgt' => function ($query) {
        //         $query->select('id', 'plan_id', 'cgtGradoSemestre', 'cgtGrupo')
        //             ->with(['plan' => function ($query) {
        //                 $query->select('id', 'planClave', 'programa_id')
        //                     ->with(['programa' => function ($query) {
        //                         $query->select('id', 'escuela_id', 'progClave', 'progNombre')
        //                             ->with(['escuela' => function ($query) {
        //                                 $query->select('id', 'departamento_id', 'escClave', 'escNombre')
        //                                     ->with(['departamento' => function ($query) {
        //                                         $query->select('id', 'ubicacion_id', 'depClave', 'depNombre')
        //                                             ->with(['ubicacion' => function ($query) {
        //                                                 $query->select('id', 'ubiClave', 'ubiNombre');
        //                                             }]);
        //                                     }]);
        //                             }]);
        //                     }]);
        //             }]);
        //     },
        //     'periodo' => function ($query) {
        //         $query->select('id', 'perNumero', 'perAnio',  'perAnioPago', 'perFechaInicial', 'perFechaFinal');
        //     }
        // ])
        //     ->whereHas('periodo', function ($query) use ($request) {
        //         $query->where('periodo_id', $request->periodo_id);
        //     })
        //     ->whereHas('alumno', function ($query) use ($request) {
        //         $query->where('aluClave', 'like', '%' . $request->input('aluClave') . '%')
        //             ->where('aluEstado', 'like', '%' . $request->input('aluEstado') . '%');
        //     })
        //     ->whereHas('alumno.persona', function ($query) use ($request) {
        //         $query->where('perApellido1', 'like', '%' . $request->input('perApellido1') . '%')
        //             //->where('perApellido2', 'like', '%'.$request->input('perApellido2').'%')
        //             ->where('perNombre', 'like', '%' . $request->input('perNombre') . '%');
        //     })
        //     ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', function ($query) use ($request) {
        //         $query->where('departamento_id', $request->departamento_id);
        //         if ($request->escuela_id) {
        //             $query->where('escuela_id', $request->escuela_id);
        //         }
        //         if ($request->programa_id) {
        //             $query->where('programa_id', $request->programa_id);
        //         }
        //         if ($request->plan_id) {
        //             $query->where('plan_id', $request->plan_id);
        //         }
        //         if ($request->cgtGradoSemestre) {
        //             $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
        //         }
        //         if ($request->cgtGrupo) {
        //             $query->where('cgtGrupo', $request->cgtGrupo);
        //         }
        //     })
        //     ->where(function ($query) use ($request) {
        //         if ($request->curTipoIngreso) {
        //             $query->where('curTipoIngreso', $request->curTipoIngreso);
        //         }
        //     })
        //     ->distinct()
        //     ->select('cgt_id', 'periodo_id', 'curEstado')
        //     ->get();

        $periodoSelect = Periodo::find($request->periodo_id);
        $ubicacionSelect = Ubicacion::find($request->ubicacion_id);
        $departamentoSelect = Departamento::find($request->departamento_id);
        $escuelaSelect = Escuela::find($request->escuela_id);
        $programaSelect = Programa::find($request->programa_id);
        $planSelect = Plan::find($request->plan_id);

        $perNumero = $periodoSelect->perNumero;
        $perAnio = $periodoSelect->perAnio;
        $ubiClave = $ubicacionSelect->ubiClave;
        $curEstado = $request->curEstado;
        $ordenReporte = $request->ordenReporte;
        $depClave = $departamentoSelect->depClave;
        $depEscuela = $escuelaSelect->depEscuela;
        $progClave = $programaSelect->progClave;
        $planClave = $planSelect->planClave;
        $cgtGradoSemestre = $request->cgtGradoSemestre;
        $cgtGrupo = $request->cgtGrupo;
        $aluClave = $request->aluClave;
        $perApellido1 = $request->perApellido1;
        $perApellido2 = $request->perApellido2;
        $perNombre = $request->perNombre;
        $aluEstado = $request->aluEstado;



        $cursos = DB::select('call procBachillerPreinscritos(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [
            $perNumero,
            $perAnio,
            $ubiClave,
            $curEstado,
            $ordenReporte,
            $depClave,
            $depEscuela,
            $progClave,
            $planClave,
            $cgtGradoSemestre,
            $cgtGrupo,
            $aluClave,
            $perApellido1,
            $perApellido2,
            $perNombre,
            $aluEstado
        ]);

        $cursos = collect($cursos);

        if ($cursos->isEmpty()) {
            alert()->warning('Sin Información', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $cgts = $cursos->groupBy('cgt_id');

        // return $cgts = $cursos->sortBy(static function ($curso) {


        //     // return $cgt = Cgt::where('id', $curso->cgt_id)
        //     // ->get();

        //     return MetodosCgt::stringOrden($curso->cgtSemestre, $curso->cgtGrupo);
        // })->unique("cgt.id");




        // $cgts->get();
        if (count($cgts)) {
            //elegir el título que va a tener el reporte
            switch ($request->input('curEstado')) {
                case 'P':
                    $textoTitulo = "ALUMNOS PREINSCRITOS";
                    break;
                case 'R':
                    $textoTitulo = "ALUMNOS INSCRITOS";
                    break;
                case 'C':
                    $textoTitulo = "ALUMNOS CONDICIONADOS";
                    break;
                case 'A':
                    $textoTitulo = "ALUMNOS CONDICIONADOS";
                    break;
                default:
                    $textoTitulo = "ALUMNOS PREINSCRITOS, INSCRITOS Y CONDICIONADOS";
                    break;
            }

            $pdf = new PDF('P', 'pt', 'Letter');
            $pdf->AliasNbPages();
            $pdf->SetTitle('Relacion de Bachiller Inscritos');
            $pdf->SetFont('Times', '', 9);

            $dibujarLinea = 0;
            $dibujarLineaEncabezado = 1;
            $anchoTituloIzquierdo = 390;
            $altoTitulo = 15;

            $fechaActual1 = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');
            $fechaActual = $fechaActual1->format("d/m/y");
            $horaActual = $fechaActual1->format("h:i:s");

            $GLOBALS['dibujarLinea'] = $dibujarLinea;
            $GLOBALS['dibujarLineaEncabezado'] = $dibujarLineaEncabezado;
            $GLOBALS['anchoTituloIzquierdo'] = $anchoTituloIzquierdo;
            $GLOBALS['altoTitulo'] = $altoTitulo;
            $GLOBALS['fechaActual'] = $fechaActual;
            $GLOBALS['horaActual'] = $horaActual;
            $GLOBALS['textoTitulo'] = $textoTitulo;

            //valores para celdas de datos
            $altoCelda = 15;
            $anchoNumero = 25;
            $anchoClavePago = 50;
            $anchoCurp = 120;
            $anchoNombre = 230;
            $anchoGrado = 20;
            $anchoGrupo = 20;
            $anchoIngreso = 25;
            $anchoPagoInscripcion = 55;
            $anchoBeca = 0;
            $anchoLineaFirma = 0;

            $GLOBALS['altoCelda'] = $altoCelda;
            $GLOBALS['anchoNumero'] = $anchoNumero;
            $GLOBALS['anchoClavePago'] = $anchoClavePago;
            $GLOBALS['anchoCurp'] = $anchoCurp;
            $GLOBALS['anchoNombre'] = $anchoNombre;
            $GLOBALS['anchoGrado'] = $anchoGrado;
            $GLOBALS['anchoGrupo'] = $anchoGrupo;
            $GLOBALS['anchoIngreso'] = $anchoIngreso;
            $GLOBALS['anchoPagoInscripcion'] = $anchoPagoInscripcion;
            $GLOBALS['anchoBeca'] = $anchoBeca;
            $GLOBALS['anchoLineaFirma'] = $anchoLineaFirma;


            $GLOBALS['tipoReporte'] = $request->input('tipoReporte');
            $GLOBALS["saltoLinea"] = $altoCelda * $request->input('espaciadoLinea');



            //textos de encabezados
            $encNumero = "Num";
            $encClavePago = "Cve Pago";
            $encCurp = "C.U.R.P";
            $encNombre = "Nombre del alumno";
            $encGrado = "Gra";
            $encGrupo = "Gru";
            $encIngreso = "Ingr";
            $encPagoInscripcion = utf8_decode("Pagó Inscr.");
            $encBeca = "Beca";
            $encLineaFirma = "Firma";



            $cont = 1;

            foreach ($cgts as $cgt_id => $cgt) {

                foreach ($cgt as $cgt_div) {


                    if ($cgt_id == $cgt_div->cgt_id && $cont++ == 1) {
                        //periodo
                        $mes = \Carbon\Carbon::parse($cgt_div->perFechaInicial)->format('m');
                        $dia = \Carbon\Carbon::parse($cgt_div->perFechaInicial)->format('d');
                        $year = \Carbon\Carbon::parse($cgt_div->perFechaInicial)->format('Y');
                        $fechaInicio = $dia . '/' . Utils::num_meses_corto_string($mes) . '/' . $year;

                        $mes2 = \Carbon\Carbon::parse($cgt_div->perFechaFinal)->format('m');
                        $dia2 = \Carbon\Carbon::parse($cgt_div->perFechaFinal)->format('d');
                        $year2 = \Carbon\Carbon::parse($cgt_div->perFechaFinal)->format('Y');
                        $fechaFin = $dia2 . '/' . Utils::num_meses_corto_string($mes2) . '/' . $year2;


                        // return ;
                        $periodo = sprintf("Período: %s - %s (%s-%s)", $fechaInicio, $fechaFin, $cgt_div->perNumero, $cgt_div->perAnio);
                        $periodo = utf8_decode($periodo);
                        //grado y grupo
                        $gradoGrupo = sprintf("Semestre: %s   Grupo: %s", $cgt_div->cgtSemestre, $cgt_div->cgtGrupo);
                        $gradoGrupo = utf8_decode($gradoGrupo);
                        //ubicación
                        $ubicacion = sprintf("Ubicación: %s-%s", $cgt_div->ubiClave, $cgt_div->ubiNombre);
                        $ubicacion = utf8_decode($ubicacion);
                        //Programa y plan
                        $programaPlan = sprintf("Nivel/Carrera: %s (%s) %s", $cgt_div->progClave, $cgt_div->planClave, $cgt_div->progNombre);
                        $programaPlan = utf8_decode($programaPlan);


                        $GLOBALS['periodo'] = $periodo;
                        $GLOBALS['gradoGrupo'] = $gradoGrupo;
                        $GLOBALS['ubicacion'] = $ubicacion;
                        $GLOBALS['programaPlan'] = $programaPlan;

                        $pdf->SetMargins(18, 18, 18);
                        $pdf->AddPage();




                        // dd($cgt);

                        //consulta para cada alumno del grupo
                        $cgt_id = $cgt_div->cgt_id;

                        $prt = Periodo::find($request->periodo_id);
                        $conceptoInscripcion2 = $cgt_div->perNumero == 1 ? '00' : '99';
               

                        $alumno = $cgt;


                        $datoNumero = 0;

                        $arr = [];


                        $estadoActual = "";

                        foreach ($alumno as $key => $fila) {

                            $arr[] = $fila->aluClave;

                            $datoNumero++;
                            $datoClavePago = $fila->aluClave;
                            $datoClavePago = utf8_decode($datoClavePago);
                            $datoCurp = $fila->perCurp;
                            $datoCurp = utf8_decode($datoCurp);

                            if ($fila->curEstado == "P") {
                                $estadoActual = "(Pre)";
                            }

                            if ($fila->curEstado == "C" || $fila->curEstado == "A") {
                                $estadoActual = "(Con)";
                            }

                            if ($fila->curEstado == "B") {
                                $estadoActual = "(Baja)";
                            }

                            $datoNombre = $fila->aluNombre. ' ' . $estadoActual;
                            $estadoActual = "";
                            $datoNombre = utf8_decode($datoNombre);
                            $datoGrado = $fila->cgtSemestre;
                            $datoGrupo = $fila->cgtGrupo;
                            $datoIngreso = $fila->curTipoIngreso.' '.$fila->aluEstado;


                            // $datoPagoInscripcion = "";
                            $datoPagoInscripcion = Utils::fecha_string($fila->pagFecha, $fila->pagFecha);


                            $datoBeca = $fila->beca;

                            $pdf->Cell($anchoNumero, $altoCelda, $datoNumero, $dibujarLinea, 0, 'R');
                            $pdf->Cell($anchoClavePago, $altoCelda, $datoClavePago, $dibujarLinea, 0);
                            $pdf->Cell($anchoCurp, $altoCelda, $datoCurp, $dibujarLinea, 0);
                            $pdf->Cell($anchoNombre, $altoCelda, $datoNombre, $dibujarLinea, 0);
                            $pdf->Cell($anchoGrado, $altoCelda, $datoGrado, $dibujarLinea, 0, 'R');
                            $pdf->Cell($anchoGrupo, $altoCelda, $datoGrupo, $dibujarLinea, 0, 'C');
                            //verificar si se imprime completo o solo líneas
                            if ($GLOBALS['tipoReporte'] == "N") {
                                //imprimir todos los datos
                                $pdf->Cell($anchoIngreso, $altoCelda, $datoIngreso, $dibujarLinea, 0, 'C');
                                $pdf->Cell($anchoPagoInscripcion, $altoCelda, $datoPagoInscripcion, $dibujarLinea, 0, 'C');
                                $pdf->Cell($anchoBeca, $altoCelda, $datoBeca, $dibujarLinea, 0, 'C');
                            }

                            if ($GLOBALS['tipoReporte'] == "R") {


                                $pdf->Cell($anchoLineaFirma, $altoCelda, "", "B", 0);
                            }

                            $pdf->Ln($GLOBALS["saltoLinea"]);
                        }
                    }
                }

                $cont = 1;
            }
        } else {
            alert()->error('Error...', 'No se encontraron datos')->showConfirmButton();
            return redirect('bachiller_reporte/bachiller_inscrito_preinscrito')->withInput();
        }

        // return response()->json($alumno);
        $pdf->Output();
        exit;
    }
}

class PDF extends Fpdf
{
    function Header()
    {
        $dibujarLinea = $GLOBALS['dibujarLinea'];
        $dibujarLineaEncabezado = $GLOBALS['dibujarLineaEncabezado'];
        $anchoTituloIzquierdo   = $GLOBALS['anchoTituloIzquierdo'];
        $altoTitulo   = $GLOBALS['altoTitulo'];
        $textoTitulo  = $GLOBALS['textoTitulo'];
        $fechaActual  = $GLOBALS['fechaActual'];
        $horaActual   = $GLOBALS['horaActual'];
        $periodo      = $GLOBALS['periodo'];
        $programaPlan = $GLOBALS['programaPlan'];
        $gradoGrupo   = $GLOBALS['gradoGrupo'];
        $ubicacion    = $GLOBALS['ubicacion'];
        $altoCelda    = $GLOBALS['altoCelda'];
        $anchoNumero  = $GLOBALS['anchoNumero'];
        $anchoClavePago = $GLOBALS['anchoClavePago'];
        $anchoCurp      = $GLOBALS['anchoCurp'];
        $anchoNombre    = $GLOBALS['anchoNombre'];
        $anchoGrado     = $GLOBALS['anchoGrado'];
        $anchoGrupo     = $GLOBALS['anchoGrupo'];
        $anchoIngreso   = $GLOBALS['anchoIngreso'];
        $anchoPagoInscripcion = $GLOBALS['anchoPagoInscripcion'];
        $anchoBeca  = $GLOBALS['anchoBeca'];


        $tipoReporte = $GLOBALS["tipoReporte"];

        //textos de encabezados
        $encNumero = "Num";
        $encClavePago = "Cve Pago";
        $encCurp = "C.U.R.P";
        $encNombre = "Nombre del alumno";
        $encGrado = "Sem";
        $encGrupo = "Gru";
        $encIngreso = "Ingr";
        $encPagoInscripcion = utf8_decode("Pagó Inscr.");
        $encBeca = "Beca";
        $encLineaFirma = "Firma";

        $this->Cell($anchoTituloIzquierdo, $altoTitulo, 'Preparatoria "ESCUELA MODELO"', $dibujarLinea, 0);
        $this->Cell(0, $altoTitulo, $fechaActual, $dibujarLinea, 0, 'R');
        $this->Ln($altoTitulo);
        $this->Cell($anchoTituloIzquierdo, $altoTitulo, $textoTitulo, $dibujarLinea, 0);
        $this->Cell(0, $altoTitulo, $horaActual, $dibujarLinea, 0, 'R');
        $this->Ln($altoTitulo);
        $this->Cell(0, $altoTitulo, "BachillerInscritosPreinscritosController.php", $dibujarLinea, 0, 'R');
        $this->Ln($altoTitulo);
        $this->Cell($anchoTituloIzquierdo, $altoTitulo, $periodo, $dibujarLinea, 0);
        $this->Ln($altoTitulo);
        $this->Cell($anchoTituloIzquierdo, $altoTitulo, $programaPlan, $dibujarLinea, 0);
        $this->Cell(0, $altoTitulo, $gradoGrupo, $dibujarLinea, 0);
        $this->Ln($altoTitulo);
        $this->Cell(0, $altoTitulo, $ubicacion, $dibujarLinea, 0);
        $this->Ln($altoTitulo);
        $this->Cell($anchoNumero, $altoCelda, $encNumero, $dibujarLineaEncabezado, 0, 'C');
        $this->Cell($anchoClavePago, $altoCelda, $encClavePago, $dibujarLineaEncabezado, 0, 'C');
        $this->Cell($anchoCurp, $altoCelda, $encCurp, $dibujarLineaEncabezado, 0, 'C');
        $this->Cell($anchoNombre, $altoCelda, $encNombre, $dibujarLineaEncabezado, 0, 'C');
        $this->Cell($anchoGrado, $altoCelda, $encGrado, $dibujarLineaEncabezado, 0, 'C');
        $this->Cell($anchoGrupo, $altoCelda, $encGrupo, $dibujarLineaEncabezado, 0, 'C');


        //imprimir todos los datos o solo las líneas para firma
        if ($tipoReporte == "N") {
            //imprimir todos los datos
            $this->Cell($anchoIngreso, $altoCelda, $encIngreso, $dibujarLineaEncabezado, 0);
            $this->Cell($anchoPagoInscripcion, $altoCelda, $encPagoInscripcion, $dibujarLineaEncabezado, 0);
            $this->Cell($anchoBeca, $altoCelda, $encBeca, $dibujarLineaEncabezado, 0);
        }

        if ($tipoReporte == "R") {
            //imprimir sólo líneas para firma
            $this->Cell($GLOBALS['anchoLineaFirma'], $altoCelda, $encLineaFirma, $dibujarLineaEncabezado, 0);
        }

        $this->Ln($GLOBALS["saltoLinea"]);
    }

    function Footer()
    {
        $this->setY(-30);
        $this->setFont('Times', 'I', '9');
        $this->Cell(0, 19, "Pag. " . $this->PageNo() . " de {nb}", 0, 0, 'C');
    }
}

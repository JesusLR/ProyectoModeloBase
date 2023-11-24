<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bachiller\Bachiller_pago_certificado;
use App\Models\Ubicacion;
use App\Models\Curso;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class BachillerReciboCertificadoController extends Controller
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
    
        $estatus_certificado = [
            'P'   => 'PAGADOS',
            'N'   => 'NO PAGADOS',
            'T'   => 'AMBOS'
        ];

        $formato = [
            'P'   => 'PDF',
            'E'   => 'EXCEL'
        ];

        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        return view('bachiller.reportes.certificados.create',compact('estatus_certificado', 'ubicaciones', 'formato'));
    }

    public function imprimir(Request $request) {
        
        $alert_title = 'Sin registros';
        $alert_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';

        


        $bachiller_pago_certificado = Bachiller_pago_certificado::with(['curso.alumno.persona', 'curso.cgt.plan.programa.escuela.departamento.ubicacion', 'curso.periodo', 'curso'])
        ->whereHas('curso.cgt.plan.programa.escuela', static function($query) use ($request) {
            $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id) {
                $query->where('programa_id', $request->programa_id);
            }
            if($request->plan_id) {
                $query->where('plan_id', $request->plan_id);
            }
            if($request->cgtGradoSemestre) {
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
            }
            if($request->cgtGrupo) {
                $query->where('cgtGrupo', $request->cgtGrupo);
            }
        })
        ->whereHas('curso.alumno.persona', static function($query) use ($request) {
            if($request->aluClave) {
                $query->where('aluClave', $request->aluClave);
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
        })
        ->whereHas('curso.periodo', static function($query) use ($request) {
            if($request->periodo_id) {
                $query->where('id', $request->periodo_id);
            }
        })
        ->get();


        if($request->estatus_certificado == "N"){

          

            if(!$bachiller_pago_certificado->isEmpty()) {

                $ignorar_cursos = $bachiller_pago_certificado->map(function($bachiller_pago_certificado, $key) {
                    $curso_id = $bachiller_pago_certificado->curso->id;
        
                    return collect([
                        'curso_id' => $curso_id
                        
        
                    ]);
                })->sortBy('orden');


                // llenamos el array 
                $cursos_a_ignorar = [];

                foreach($ignorar_cursos as $key => $value){
                    $cursos_a_ignorar[] = $value['curso_id'];
                }


                $cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
                ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
                    $query->where('escuela_id', $request->escuela_id);
                    if($request->programa_id) {
                        $query->where('programa_id', $request->programa_id);
                    }
                    if($request->plan_id) {
                        $query->where('plan_id', $request->plan_id);
                    }
                    if($request->cgtGradoSemestre) {
                        $query->where('cgtGradoSemestre', 6);
                    }
                    if($request->cgtGrupo) {
                        $query->where('cgtGrupo', $request->cgtGrupo);
                    }
                })
                ->whereHas('alumno.persona', static function($query) use ($request) {
                    if($request->aluClave) {
                        $query->where('aluClave', $request->aluClave);
                    }
                    if($request->perApellido1) {
                        $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
                    }
                    if($request->perApellido2) {
                        $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
                    }
                    if($request->perNombre) {
                        $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
                    }
                })
                ->where(static function($query) use ($request, $cursos_a_ignorar) {
                    $query->whereNotIn('id', $cursos_a_ignorar);
                    $query->where('periodo_id', $request->periodo_id);
                    $query->where('curEstado', '<>', 'B');
                    
                
                })->get();


            }else{


                $cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
                ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
                    $query->where('escuela_id', $request->escuela_id);
                    if($request->programa_id) {
                        $query->where('programa_id', $request->programa_id);
                    }
                    if($request->plan_id) {
                        $query->where('plan_id', $request->plan_id);
                    }
                    if($request->cgtGradoSemestre) {
                        $query->where('cgtGradoSemestre', 6);
                    }
                    if($request->cgtGrupo) {
                        $query->where('cgtGrupo', $request->cgtGrupo);
                    }
                })
                ->whereHas('alumno.persona', static function($query) use ($request) {
                    if($request->aluClave) {
                        $query->where('aluClave', $request->aluClave);
                    }
                    if($request->perApellido1) {
                        $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
                    }
                    if($request->perApellido2) {
                        $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
                    }
                    if($request->perNombre) {
                        $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
                    }
                })
                ->where(static function($query) use ($request) {
                    $query->where('periodo_id', $request->periodo_id);
                    $query->where('curEstado', '<>', 'B');
                
                })->get();
            }

            
            

        }

        if($request->estatus_certificado == "T"){
            

            $cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
            ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
                $query->where('escuela_id', $request->escuela_id);
                if($request->programa_id) {
                    $query->where('programa_id', $request->programa_id);
                }
                if($request->plan_id) {
                    $query->where('plan_id', $request->plan_id);
                }
                if($request->cgtGradoSemestre) {
                    $query->where('cgtGradoSemestre', 6);
                }
                if($request->cgtGrupo) {
                    $query->where('cgtGrupo', $request->cgtGrupo);
                }
            })
            ->whereHas('alumno.persona', static function($query) use ($request) {
                if($request->aluClave) {
                    $query->where('aluClave', $request->aluClave);
                }
                if($request->perApellido1) {
                    $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
                }
                if($request->perApellido2) {
                    $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
                }
                if($request->perNombre) {
                    $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
                }
            })
            ->where(static function($query) use ($request) {
                $query->where('periodo_id', $request->periodo_id);
                $query->where('curEstado', '<>', 'B');
            
            })->get();

            if($cursos->isEmpty()) {
                alert()->warning($alert_title, $alert_text)->showConfirmButton();
                return back()->withInput();
            }

            $totalCursos = $cursos->count();

            $periodo = $cursos->first()->periodo;
            $info = collect([
                'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
                'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
                'ubiClave' => $periodo->departamento->ubicacion->ubiClave,
                'ubiNombre' => $periodo->departamento->ubicacion->ubiNombre,
            ]);

            $datos = $cursos->map(function($curso, $key) {
                $curso_id = $curso->id;
                $persona = $curso->alumno->persona;
                $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
                $progClave = $curso->cgt->plan->programa->progClave;
                $grupo = $curso->cgt->cgtGrupo;

                return collect([
                    'curso_id' => $curso_id,
                    'progClave' => $progClave,
                    'planClave' => $curso->cgt->plan->planClave,
                    'progNombreCorto' => $curso->cgt->plan->programa->progNombreCorto,
                    'grado' => $curso->cgt->cgtGradoSemestre,
                    'grupo' => $grupo,
                    'aluClave' => $curso->alumno->aluClave,
                    'nombre' => $nombre,
                    'curEstado' => $curso->curEstado,
                    'orden' => $progClave.'-'.$grupo.'-'.$nombre,
                    'estatus_pago' => 'BUSCAR'
                ]);
            })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);
            
        }

        // muestra los que no han pagado 
        if($request->estatus_certificado == "N"){


            if($cursos->isEmpty()) {
                alert()->warning($alert_title, $alert_text)->showConfirmButton();
                return back()->withInput();
            }

            $totalCursos = $cursos->count();

            $periodo = $cursos->first()->periodo;
            $info = collect([
                'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
                'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
                'ubiClave' => $periodo->departamento->ubicacion->ubiClave,
                'ubiNombre' => $periodo->departamento->ubicacion->ubiNombre,
            ]);

            $datos = $cursos->map(function($curso, $key) {
                $persona = $curso->alumno->persona;
                $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
                $progClave = $curso->cgt->plan->programa->progClave;
                $grupo = $curso->cgt->cgtGrupo;

                return collect([
                    'progClave' => $progClave,
                    'planClave' => $curso->cgt->plan->planClave,
                    'progNombreCorto' => $curso->cgt->plan->programa->progNombreCorto,
                    'grado' => $curso->cgt->cgtGradoSemestre,
                    'grupo' => $grupo,
                    'aluClave' => $curso->alumno->aluClave,
                    'nombre' => $nombre,
                    'curEstado' => $curso->curEstado,
                    'orden' => $progClave.'-'.$grupo.'-'.$nombre,
                    'estatus_pago' => 'NO PAGADO'
                ]);
            })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);
        }

        // solo muestra los que ya pagaron 
        if($request->estatus_certificado == "P"){

            $totalCursos = $bachiller_pago_certificado->count();

            if($bachiller_pago_certificado->isEmpty()) {
                alert()->warning($alert_title, $alert_text)->showConfirmButton();
                return back()->withInput();
            }


            $periodo = $bachiller_pago_certificado->first()->curso->periodo;

            $info = collect([
                'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
                'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
                'ubiClave' => $periodo->departamento->ubicacion->ubiClave,
                'ubiNombre' => $periodo->departamento->ubicacion->ubiNombre,
            ]);

            $datos = $bachiller_pago_certificado->map(function($bachiller_pago_certificado, $key) {
                $persona = $bachiller_pago_certificado->curso->alumno->persona;
                $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
                $progClave = $bachiller_pago_certificado->curso->cgt->plan->programa->progClave;
                $grupo = $bachiller_pago_certificado->curso->cgt->cgtGrupo;

                return collect([
                    'progClave' => $progClave,
                    'planClave' => $bachiller_pago_certificado->curso->cgt->plan->planClave,
                    'progNombreCorto' => $bachiller_pago_certificado->curso->cgt->plan->programa->progNombreCorto,
                    'grado' => $bachiller_pago_certificado->curso->cgt->cgtGradoSemestre,
                    'grupo' => $grupo,
                    'aluClave' => $bachiller_pago_certificado->curso->alumno->aluClave,
                    'nombre' => $nombre,
                    'curEstado' => $bachiller_pago_certificado->curso->curEstado,
                    'orden' => $progClave.'-'.$grupo.'-'.$nombre,
                    'estatus_pago' => $bachiller_pago_certificado->estatus_pago

                ]);
            })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);

        }

        $fechaActual = Carbon::now('America/Merida');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        if($request->formato == "P"){

            $nombreArchivo = 'pdf_reporte_por_grupo.pdf';

            // view('reportes.pdf.bachiller.certificado.pdf_reporte_por_grupo');
            $pdf = PDF::loadView('reportes.pdf.bachiller.certificado.pdf_reporte_por_grupo', [
                "datos" => $datos,
                "info" => $info,
                "totalCursos" => $totalCursos,
                "nombreArchivo" => $nombreArchivo,
                "curEstado" => $request->curEstado,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
            ]);
            $pdf->setPaper('letter', 'portrait');
            // $pdf->setPaper('letter', 'landscape');
    
            $pdf->defaultFont = 'Times Sans Serif';
            return $pdf->stream($nombreArchivo);
            return $pdf->download($nombreArchivo);
        }
        
        if($request->formato == "E")
        {

            $fechaActual = $fechaActual->format('d/m/Y');
            // $horaActual = $fechaActual->format('H:m:s');


            return $this->generarExcel($datos, $info, $totalCursos, $fechaActual);
        }
       

    }//imprimir.


    public function generarExcel($datos, $info, $totalCursos, $fechaActual)
    {

        $contador = 1;
        $contador2 = 1;
        $spreadsheet = new Spreadsheet();

        foreach ($datos as $programa)
        {
            foreach($programa as $plan)
            {
                $grados = $plan->sortKeys();

                foreach($grados as $grado)
                {

                    foreach($grado as $grupo)
                    {
                            $grupoInfo = $grupo->first();
    
                            if($contador++ == 1){
                                    $sheet = $spreadsheet->createSheet();

                                    $sheet->setTitle($grupoInfo["grupo"]);
                                    $sheet->getColumnDimension('A')->setAutoSize(true);
                                    $sheet->getColumnDimension('B')->setAutoSize(true);
                                    $sheet->getColumnDimension('C')->setAutoSize(true);
                                    $sheet->getColumnDimension('D')->setAutoSize(true);
                                    $sheet->getColumnDimension('E')->setAutoSize(true);
                                    $sheet->getColumnDimension('F')->setAutoSize(true);
                                    $sheet->getColumnDimension('G')->setAutoSize(true);
                                    $sheet->getColumnDimension('H')->setAutoSize(true);
                                    $sheet->getColumnDimension('I')->setAutoSize(true);
        
        
                                    $sheet->getStyle('C1')->getFont()->setBold(true);
                                    $sheet->setCellValue('C1', 'Preparatoria "ESCUELA MODELO"');
            
                                    // $sheet->mergeCells("D2");
                                    $sheet->getStyle('C2')->getFont()->setBold(true);
                                    $sheet->setCellValue('C2', "LISTA DE ALUMNOS CERTIFICADOS");
        
                                    $sheet->setCellValue('C4', "Período : {$info['perFechaInicial']} - {$info['perFechaFinal']}");
                                    $sheet->setCellValue('C5', "Niv/Carr: {$grupoInfo['progClave']} - ({$grupoInfo["planClave"]})");
                                    $sheet->setCellValue('C6', "Ubicac : {$info['ubiClave']} - {$info['ubiNombre']}");
        
                                    $sheet->setCellValue('D6', "Grado : {$grupoInfo["grado"]}");
                                    $sheet->setCellValue('E6', "Grupo : {$grupoInfo["grupo"]}");
                                    $sheet->setCellValue('D4', "Fecha : {$fechaActual}");



                                    $sheet->getStyle('A8:I8')->getFont()->setBold(true);
                                    $sheet->setCellValueByColumnAndRow(1, 8, "Num");
                                    $sheet->setCellValueByColumnAndRow(2, 8, "Cve pago");
                                    $sheet->setCellValueByColumnAndRow(3, 8, "Nombre del alumno");
                                    $sheet->setCellValueByColumnAndRow(4, 8, "Estado de Pago");
                                

                                    $fila = 9;
                                    
                                foreach ($grupo as $alumno)
                                {
                               
                                    $sheet->setCellValue("A{$fila}", $contador2++);                                    
                                    $sheet->setCellValue("B{$fila}", $alumno['aluClave']);
                                    $sheet->setCellValue("C{$fila}", $alumno['nombre']);

                                    if($alumno['estatus_pago'] == "BUSCAR"){

                                        $curso_id = $alumno['curso_id'];
                                        $bachiller_pago_certificado = Bachiller_pago_certificado::where('curso_id', $curso_id)->first();

                                        if($bachiller_pago_certificado != ""){
                                            
                                            $sheet->setCellValue("D{$fila}", $bachiller_pago_certificado->estatus_pago);
                                        }else{
                                            $sheet->setCellValue("D{$fila}", 'NO PAGADO');
                                        }

                                    }else{
                                        $sheet->setCellValue("D{$fila}", $alumno['estatus_pago']);
                                    }
                                    
                                 
    
                                
    
                                    $fila++;
                                }
    
                                $contador2 = 1;
                            }
        
    
                            
    
    
                            $contador = 1; 
                    }
                                   

                    
                }
               
               
            }

              
        }

       

        $writer = new Xlsx($spreadsheet);

        // return $contador;
        try {
            $writer->save(storage_path("BachillerPagoCertificado.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
        return response()->download(storage_path("BachillerPagoCertificado.xlsx"));
    }

}//Controller class.
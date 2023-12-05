<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Egresado;
use App\Models\Curso;
use App\Models\Pago;
use App\clases\personas\MetodosPersonas;
use App\Http\Helpers\Utils;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RelEgresadosController extends Controller
{
    public $ubicacion;

    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){
    	$aluTipo = [
    		'T' => 'Todos los del periodo',
    		'P' => 'Solo los de certificados pendientes'
    	];
    	return view('reportes/rel_egresados.create',[
    		'aluTipo' => $aluTipo,
    		'fechaActual' => Carbon::now('America/Merida'),
            'ubicaciones' => Ubicacion::sedes()->get()
    	]);
    }//FIN function reporte.

    public function imprimir(Request $request){
        $recursos = $this->obtenerRecursos($request);
        return $this->relEgresados($recursos);
    }//FIN function imprimir.

    public function obtenerRecursos($request){

        /*
        * Obtener perAnio Pago del periodo del filtro.
        * -> Para buscar pagos de Inscripción Agosto.
        * -> Y pagos de Titulación.
        */
    	$egresados = Egresado::with(['ultimoPeriodo', 'plan.programa', 'alumno.persona'])
    	  ->whereHas('ultimoPeriodo',static function($query) use($request){
            $query->where('departamento_id', $request->departamento_id);
            if($request->periodo_id)
                $query->where('periodo_id', $request->periodo_id);
    	  })
    	  ->whereHas('plan.programa',static function($query) use($request){
            if($request->plan_id)
                $query->where('plan_id', $request->plan_id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id) 
                $query->where('escuela_id', $request->escuela_id);
          })
    	  ->whereHas('alumno.persona',static function($query) use($request){
            if($request->aluClave)
                $query->where('aluClave',$request->aluClave);
            if($request->aluMatricula)
                $query->where('aluMatricula',$request->aluMatricula);
            if($request->perApellido1)
                $query->where('perApellido1',$request->perApellido1);
            if($request->perApellido2)
                $query->where('perApellido2',$request->perApellido2);
            if($request->perNombre)
                $query->where('perNombre',$request->perNombre);
          })
          ->where(static function($query) use($request){
            if($request->aluTipo && $request->aluTipo == 'P'){
                $query->where('egrFechaExpedicionTitulo',null);
            }
            if($request->egrDate){
                $egrDate = Carbon::parse($request->egrDate)->format('Y-m-d');
                $query->whereDate('created_at', $egrDate);
            }
          })
          ->get()
          ->each(static function($egresado) {
            $alumno = $egresado->alumno;
            $periodo = $egresado->ultimoPeriodo;
            $egresado->key_pago_titulacion = "{$alumno->aluClave}_{$periodo->perAnioPago}_86";
            $egresado->key_pago_inscripcion = "{$alumno->aluClave}_{$periodo->perAnioPago}_99";
            $egresado->alumno_periodo = "{$alumno->id}_{$periodo->id}";
          });
          
          $cursos = Curso::with('cgt')->where(static function($query) use ($egresados){
            $query->whereIn('alumno_id', $egresados->pluck('alumno_id')->unique())
                ->whereIn('periodo_id', $egresados->pluck('egrUltimoPeriodo')->unique());
          })->oldest('curFechaRegistro')
          ->get()
          ->each(static function($curso) {
            $curso->alumno_periodo = $curso->alumno_id."_".$curso->periodo_id;
          })->keyBy('alumno_periodo');

          /*
          * Buscar los pagos de los alumnos filtrados.
          * -> Titulación, conpClave(concepto) = 86.
          * -> Inscripción de Agosto, concepto = 99.
          */
          $pagos = Pago::whereIn('pagClaveAlu', $egresados->pluck('alumno.aluClave')->unique())
                ->whereIn('pagConcPago', [86, 99])
                ->whereIn('pagAnioPer', $egresados->pluck('ultimoPeriodo.perAnioPago')->unique())
                ->oldest('pagFechaPago')
                ->get()
                ->each(static function($pago) {
                    $pago->key_pago = "{$pago->pagClaveAlu}_{$pago->pagAnioPer}_{$pago->pagConcPago}";
                })->keyBy('key_pago');

          $recursos = [
            'egresados' => $egresados,
            'cursos' => $cursos,
            'pagos' => $pagos,
            'tipoReporte' => $request->tipoReporte,
          ];

          return $recursos;
    }//FIN function obtenerRecursos.

    public function relEgresados($recursos){
        $datos = new Collection;
        $fechaActual = Carbon::now('America/Merida');
        $horaActual = $fechaActual->format('H:i:s');
        $egresados = $recursos['egresados'];
        if($egresados->isEmpty()){
            alert()->warning('Sin coincidencias','No existen registros con la información proporcionada')->showConfirmButton();
            return back()->withInput();
        }

        $this->ubicacion = $egresados->first()->ultimoPeriodo->departamento->ubicacion;
        $cursos = $recursos['cursos'];
        $pagos = $recursos['pagos'];

        $egresados->each(static function($egresado) use ($cursos, $pagos, $datos) {

            $alumno = $egresado->alumno;
            $ultimoCurso = $cursos->pull($egresado->alumno_periodo);
            $pago_titulacion = $pagos->pull($egresado->key_pago_titulacion);
            $pago_inscripcion = $pagos->pull($egresado->key_pago_inscripcion);
            $grado = $ultimoCurso ? $ultimoCurso->cgt->cgtGradoSemestre : '';
            $grupo = $ultimoCurso ? $ultimoCurso->cgt->cgtGrupo : '';
            $info_egresado = self::info_esencial_egresado($egresado)->merge([
                'pre' => $pago_inscripcion ? true : false,
                'fecha_pago_titulacion' => $pago_titulacion ? Utils::fecha_string($pago_titulacion->pagFechaPago, 'mesCorto') : '',
                'grado_grupo' => $grado.$grupo,
            ]);

            if($ultimoCurso)
                $datos->push($info_egresado);
        });

        $datos = $datos->sortBy(static function($egresado) {
            return $egresado['progClave'].$egresado['grado_grupo'].$egresado['nombreCompleto'];
        })->groupBy('progClave');

        if($recursos['tipoReporte'] == 'Excel')
            return $this->generarExcel($datos);

        $nombreArchivo = "pdf_rel_egresados.pdf";
        return PDF::loadView("reportes.pdf.pdf_rel_egresados", [
        "datos" => $datos,
        "ubicacion" => $this->ubicacion,
        "fechaActual" => Utils::fecha_string($fechaActual, 'mesCorto'),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo
        ])->stream($nombreArchivo);
    }//FIN function relEgresados.

    private static function info_esencial_egresado(Egresado $egresado)
    {
        $programa = $egresado->plan->programa;
        $alumno = $egresado->alumno;
        $persona = $alumno->persona;

        return collect([
            'progClave' => $programa->progClave,
            'progNombre' => $programa->progNombre,
            'aluClave' => $alumno->aluClave,
            'matricula' => $alumno->aluMatricula,
            'nombreCompleto' => MetodosPersonas::nombreCompleto($persona, true),
            'perSexo' => $persona->perSexo,
            'mesEgresado' => $egresado->created_at->format('m/Y'),
        ]);
    }

    public function generarExcel($programas)
    {
        $spreadsheet = new SpreadSheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A2:H2')->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow(1, 2, "Cve. Alu");
        $sheet->setCellValueByColumnAndRow(2, 2, "Matrícula");
        $sheet->setCellValueByColumnAndRow(3, 2, "Nombre de alumno");
        $sheet->setCellValueByColumnAndRow(4, 2, "PRE = No ha pagado Inscripción");
        $sheet->setCellValueByColumnAndRow(5, 2, "Sex");
        $sheet->setCellValueByColumnAndRow(6, 2, "Gra");
        $sheet->setCellValueByColumnAndRow(7, 2, "Mes Egre");
        $sheet->setCellValueByColumnAndRow(8, 2, "Fecha Pago Tit");

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $fila = 3;
        foreach ($programas as $egresados) {
            foreach ($egresados as $egresado) {
                $sheet->setCellValue("A{$fila}", $egresado['aluClave']);
                $sheet->setCellValue("B{$fila}", $egresado['matricula']);
                $sheet->setCellValue("C{$fila}", $egresado['nombreCompleto']);
                $sheet->setCellValue("D{$fila}", $egresado['pre'] ? '' : 'PRE');
                $sheet->setCellValue("E{$fila}", $egresado['perSexo']);
                $sheet->setCellValue("F{$fila}", $egresado['grado_grupo']);
                $sheet->setCellValue("G{$fila}", $egresado['mesEgresado']);
                $sheet->setCellValue("H{$fila}", $egresado['fecha_pago_titulacion']);
                $fila++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path("RelacionEgresados.xlsx"));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path("RelacionEgresados.xlsx"));
    }

}//FIN Controller class

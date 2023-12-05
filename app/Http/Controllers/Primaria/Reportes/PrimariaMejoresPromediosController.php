<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Support\Collection;
use App\clases\cgts\MetodosCgt;
use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Curso;
use App\Models\Primaria\Primaria_inscrito;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Exception;
use PDF;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PrimariaMejoresPromediosController extends Controller
{

    protected $request;
  
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
      $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
      return view('primaria.reportes.mejores_promedios.create',compact('ubicaciones'));
    }
  
    public function imprimir(Request $request){
      $this->request = $request;
      $cursos = self::buscarCursos($this->request);

      $cursos_periodo = $this->extraerCursosPeriodo($cursos);
      $cursos = self::extraerPrimerosCursos($cursos, $cursos_periodo);
      
  
      if($cursos_periodo->isEmpty()) return self::alert_verificacion();
      # --------------------------------------------------------------------------------
      $info = $cursos_periodo->first();
      $periodo = $info->periodo;
      $departamento = $periodo->departamento;

      if($request->plan_id){
        $plan = $info->cgt->plan;
      }else{
        $plan = "";
      }
      
      $calificacion_minima = $departamento->depCalMinAprob;
      # --------------------------------------------------------------------------------
      $inscritosData = self::buscarInscritos($cursos_periodo, $plan, $request->periodo_id);

      # --------------------------------------------------------------------------------
      $agrupacion = $request->numeroAlumnos == 0 ? 'orden_cgt' : 'orden_periodo';
  
      $alumnos = $cursos_periodo->map(function($curso) use ($inscritosData, $cursos, $calificacion_minima) {
        $alumno = $curso->alumno;
        $cgt = $curso->cgt;
        $programa = $curso->cgt->plan->programa;
        $inscritos = $inscritosData->pull($alumno->id) ?: collect([]);
        $curso_ingreso = $cursos->pull($alumno->id) ?: $curso;
        
  
        // $inscritos->each(static function($inscrito) {
        //   $inscrito->inscPromedioTrim = $inscrito->inscPromedioTrim > 0 ? $inscrito->inscPromedioTrim : 0;
        // });
  
        $info['promedio'] = $this->calcularPromedio($inscritos, $curso->periodo_id);
  
        $info['curEstado'] = self::abreviarEstado($curso->curEstado);
        $info['aluClave'] = $alumno->aluClave;
        $info['nombreCompleto'] = MetodosPersonas::nombreCompleto($alumno->persona, true);
        $info['grado'] = $cgt->cgtGradoSemestre;
        $info['grupo'] = $cgt->cgtGrupo;
        $info['orden_cgt'] = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);
        $info['grado_ingreso'] = $curso_ingreso->cgt->cgtGradoSemestre;
        $info['progClave'] = $programa->progClave;
        // $info['numMat'] = $inscritos->count();
        // $info['numExt'] = $inscritos->where('histPeriodoAcreditacion', 'EX', 'RE', 'AC')->count();
        // $info['numExt'] = $inscritos->where('histPeriodoAcreditacion', 'EX', 'RE', 'AC')->count();
        // $info['numDeb'] = $inscritos->whereIn('histPeriodoAcreditacion', ['PN','EX', 'RE', 'AC'])->where('histCalificacion', '<', $calificacion_minima)->count();
        // $info['numDeb'] = $inscritos->where('inscPromedioTrim', '<', $calificacion_minima)->count();

        // $info['numRev'] = $inscritos->where('histPeriodoAcreditacion', 'RV')->where('histTipoAcreditacion', 'RV')->count();
        // $info['orden_periodo'] = $curso->periodo_id;
  
        return $info;
      })->sortByDesc('promedio')->unless($this->request->numeroAlumnos == 0,function($alumnos) {
        return $alumnos->take($this->request->numeroAlumnos);
      })->groupBy($agrupacion)->sortKeys();
      # ------------------------------------------------------------------------------
      $fechaActual = Carbon::now('America/Merida');

      if($request->programa_id){
        $nombreArchivo = 'pdf_mejores_promedios';
      }else{
        $nombreArchivo = 'pdf_mejores_promedios_sin_plan';
      }
      

      
      $info_reporte = [
        "datos" => $alumnos,
        "fechaActual" => $fechaActual->format('d/m/Y'),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo,
        "ubicacion" => $departamento->ubicacion,
        "programa" => $plan ? $plan->programa : "",
        "plan" => $plan,
        "tituloReporte" => self::definirTituloReporte($request->numeroAlumnos),
        "mensajeHead" => "No se incluyen materias revalidadas",
        "periodo" => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto').' - '.Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
      ];
  
    //   view('reportes.pdf.primaria.mejores_promedios.pdf_mejores_promedios');

      return $request->formato == 'PDF' ? 
        PDF::loadView('reportes.pdf.primaria.mejores_promedios.'. $nombreArchivo, $info_reporte)->stream($nombreArchivo.'.pdf') : self::generarExcel($info_reporte);
  
    }//imprimir.
  
  
    /**
    * @param Illuminate\Http\Request
    */
    private static function buscarCursos($request)
    {
      return Curso::with(['cgt.plan.programa', 'alumno.persona'])
      ->where('periodo_id', $request->periodo_id)
      ->whereHas('cgt.plan.programa', static function($query) use ($request) {

        if($request->plan_id){
          $query->where('plan_id', $request->plan_id);
        }
       
        if($request->grado1)
          $query->where('cgtGradoSemestre', '>=', $request->grado1);
        if($request->grado2)
          $query->where('cgtGradoSemestre', '<=', $request->grado2);
        if($request->cgtGrupo) 
          $query->where('cgtGrupo', $request->cgtGrupo);
      })
      ->where('curEstado', '!=', 'B')
      ->oldest('curFechaRegistro')
      ->get();
    }
  
    /**
    * @param Collection
    *
    * @return Collection
    */
    private function extraerCursosPeriodo($cursos): Collection
    {
      return $cursos->where('periodo_id', $this->request->periodo_id)->keyBy('alumno_id');
    }
  
  
    /**
    * Retorna el primer curso encontrado de cada alumno.
    *
    * @param Collection $cursos
    * @param Collection $cursos_periodo
    *
    * @return Collection
    */
    private static function extraerPrimerosCursos($cursos, $cursos_periodo): Collection
    {
      return $cursos->whereIn('alumno_id', $cursos_periodo->pluck('alumno_id'))
      ->sortByDesc('curFechaRegistro')
      ->keyBy('alumno_id');
    }
  
  
    /**
    * @param Collection $cursos
    * @param App\Models\Plan
    * @return Collection
    */
    private static function buscarInscritos($cursos, $plan, $periodo_id): Collection
    {
      return Primaria_inscrito::join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
      ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
      ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
      ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
      ->join('programas', 'planes.programa_id', '=', 'programas.id')
      ->whereIn('cursos.alumno_id', $cursos->pluck('alumno_id'))
      ->where('primaria_grupos.periodo_id', $periodo_id)
      ->where(static function ($query) use ($plan) {
        if ($plan != "") {
            $query->where('planes.id', $plan->id);
        }        
      })      
      // ->where('primaria_materias.matTipoAcreditacion', 'N')   
      ->where('cursos.curEstado', '!=', 'B')   
      ->whereNull('cursos.deleted_at')
      // ->whereNotIn('primaria_materias.matClasificacion', ['X', 'C'])
      // ->oldest('primaria_grupos.gpoFechaExamenOrdinario')
      ->get()
       ->keyBy(static function($historico) {
        return "{$historico->alumno_id}-{$historico->primaria_materia_id}";
      })->groupBy('alumno_id');
    }
  
    /**
    * @param Collection $inscritos
    * @param int $periodo_id
    */
    private function calcularPromedio($inscritos, $periodo_id)
    {
      // return number_format($historicos->where('histPeriodoAcreditacion', '!=', 'RV')          
      //     ->avg('histCalificacion'), $this->request->numeroDecimales);

      if($inscritos->avg('inscCalificacionSep') != "" || $inscritos->avg('inscCalificacionSep') != NULL){
        $inscCalificacionSep = $inscritos->avg('inscCalificacionSep');
      }else{
        $inscCalificacionSep = 0;
      }

      if($inscritos->avg('inscCalificacionOct') != "" || $inscritos->avg('inscCalificacionOct') != NULL){
        $inscCalificacionOct = $inscritos->avg('inscCalificacionOct');
      }else{
        $inscCalificacionOct = 0;
      }

      if($inscritos->avg('inscCalificacionNov') != "" || $inscritos->avg('inscCalificacionNov') != NULL){
        $inscCalificacionNov = $inscritos->avg('inscCalificacionNov');
      }else{
        $inscCalificacionNov = 0;
      }

      if($inscritos->avg('inscCalificacionEne') != "" || $inscritos->avg('inscCalificacionEne') != NULL){
        $inscCalificacionEne = $inscritos->avg('inscCalificacionEne');
      }else{
        $inscCalificacionEne = 0;
      }

      if($inscritos->avg('inscCalificacionFeb') != "" || $inscritos->avg('inscCalificacionFeb') != NULL){
        $inscCalificacionFeb = $inscritos->avg('inscCalificacionFeb');
      }else{
        $inscCalificacionFeb = 0;
      }

      if($inscritos->avg('inscCalificacionMar') != "" || $inscritos->avg('inscCalificacionMar') != NULL){
        $inscCalificacionMar = $inscritos->avg('inscCalificacionMar');
      }else{
        $inscCalificacionMar = 0;
      }

      if($inscritos->avg('inscCalificacionAbr') != "" || $inscritos->avg('inscCalificacionAbr') != NULL){
        $inscCalificacionAbr = $inscritos->avg('inscCalificacionAbr');
      }else{
        $inscCalificacionAbr = 0;
      }

      if($inscritos->avg('inscCalificacionMay') != "" || $inscritos->avg('inscCalificacionMay') != NULL){
        $inscCalificacionMay = $inscritos->avg('inscCalificacionMay');
      }else{
        $inscCalificacionMay = 0;
      }

      if($inscritos->avg('inscCalificacionJun') != "" || $inscritos->avg('inscCalificacionJun') != NULL){
        $inscCalificacionJun = $inscritos->avg('inscCalificacionJun');
      }else{
        $inscCalificacionJun = 0;
      }

      $meses = ($inscCalificacionSep + $inscCalificacionOct + $inscCalificacionNov + $inscCalificacionEne + $inscCalificacionFeb + $inscCalificacionMar + $inscCalificacionAbr + $inscCalificacionMay + $inscCalificacionJun)/9;

      return number_format($meses, $this->request->numeroDecimales);

      

    }
  
  
    /**
    * @param string
    */
    private static function abreviarEstado($curEstado)
    {
      switch ($curEstado) {
        case 'R':
          $curEstado = 'Insc.';
          break;
        case 'P':
          $curEstado = 'Prei.';
          break;
        case 'C':
          $curEstado = 'Cond1';
          break;
        case 'A':
          $curEstado = 'Cond2';
          break;
        case 'B':
          $curEstado = 'Baja';
          break;
      }
  
      return $curEstado;
    }
  
  
    /**
    * @param int
    */
    private static function definirTituloReporte($numeroAlumnos)
    {
      if($numeroAlumnos == 0) {
        return 'MEJORES PROMEDIOS, LISTAS DE GRUPOS COMPLETOS';
      } else {
        return "LOS {$numeroAlumnos} MEJORES PROMEDIOS POR NIVEL/CARRERA";
      }
    }
  
  
    private function alert_verificacion()
    {
      alert('Sin coincidencias', 'No haydatos que coincidan con la información proporcionada. Favor de verificar.')
      ->showConfirmButton();
      return back()->withInput();
    }
  
    /**
    * @param array $info_reporte
    */
    private static function generarExcel($info_reporte)
    {
      $ubicacion = $info_reporte['ubicacion'];
      $programa = $info_reporte['programa'];
      $plan = $info_reporte['plan'];
      $header_reporte = "{$ubicacion->ubiClave} - {$programa->progClave} ({$plan->planClave}) {$programa->progNombre}";
  
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
  
      $sheet->getStyle("A1:K1")->getFont()->setBold(true);
      $sheet->getStyle("A2:K2")->getFont()->setBold(true);
      $sheet->getStyle("A3:K3")->getFont()->setBold(true);
      $sheet->mergeCells("A1:K1");
      $sheet->mergeCells("A2:B2");
      $sheet->mergeCells("C2:F2");
      $sheet->mergeCells("G2:K2");
  
      $sheet->setCellValue("A1", "{$header_reporte}   |   {$info_reporte['tituloReporte']}");
  
      $sheet->setCellValue("A2", "Periodo:    {$info_reporte['periodo']}");
      $sheet->setCellValue("C2", "PERIODO ACTUAL");
      $sheet->setCellValue("G2", "HISTORIAL CARRERA");
  
      $sheet->setCellValue("A3", "Cve Pago");
      $sheet->setCellValue("B3", "Nombre del alumno");
      $sheet->setCellValue("C3", "Gra");
      $sheet->setCellValue("D3", "Gpo");
      $sheet->setCellValue("E3", "Edo");
      $sheet->setCellValue("F3", "Promedio");
      $sheet->setCellValue("G3", "Grado Ingreso");
      $sheet->setCellValue("H3", "#Mat");
      $sheet->setCellValue("I3", "#Ext");
      $sheet->setCellValue("J3", "#Deb");
      $sheet->setCellValue("K3", "#Rev");
  
      $fila = 3;
      foreach($info_reporte['datos'] as $agrupacion) {
        $fila++;
        
        foreach($agrupacion as $alumno) {
          $sheet->setCellValueExplicit("A{$fila}", $alumno['aluClave'], DataType::TYPE_STRING);
          $sheet->setCellValue("B{$fila}", $alumno['nombreCompleto']);
          $sheet->setCellValue("C{$fila}", $alumno['grado']);
          $sheet->setCellValue("D{$fila}", $alumno['grupo']);
          $sheet->setCellValue("E{$fila}", $alumno['curEstado']);
          $sheet->setCellValueExplicit("F{$fila}", $alumno['promedio'], DataType::TYPE_STRING);
          $sheet->setCellValue("G{$fila}", $alumno['grado_ingreso']);
          $sheet->setCellValue("H{$fila}", $alumno['numMat']);
          $sheet->setCellValue("I{$fila}", $alumno['numExt']);
          $sheet->setCellValue("J{$fila}", $alumno['numDeb']);
          $sheet->setCellValue("K{$fila}", ($alumno['numRev'] > 0 ? $alumno['numRev'] : ''));
          $fila++;
        }
  
      }
  
      $writer = new Xlsx($spreadsheet);
      try {
          $writer->save(storage_path("BachillerMejoresPromedios.xlsx"));
      } catch (Exception $e) {
          alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
          return back()->withInput();
      }
  
      return response()->download(storage_path("BachillerMejoresPromedios.xlsx"));
    }
  
  }//

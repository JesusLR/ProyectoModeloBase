<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Alumno;
use App\Http\Models\Conceptoscursoestado;
use App\Http\Models\Periodo;
use App\Http\Models\Primaria\Primaria_expediente_entrevista_inicial;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaRepoteFichaTecnicaController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $ubicaciones = Ubicacion::sedes()->get();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();

        $conceptos = Conceptoscursoestado::get();

        return view('primaria.reportes.expediente_alumnos.ficha_tecnica', [
            "ubicaciones" => $ubicaciones,
            "conceptos" => $conceptos
        ]);
    }

    public function imprimirFicha(Request $request)
    {

        // parametros del \request 
        $aluClave = $request->aluClave;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $periodo_id = $request->periodo_id;
        $grado = $request->gpoGrado;
        $grupo = $request->gpoClave;
        $tipoReporte = $request->tipoReporte;

        if($tipoReporte == "1"){
            if($aluClave !=  ""){
                $alumnoEntrevista = Primaria_expediente_entrevista_inicial::select(
                    'primaria_expediente_entrevista_inicial.*',
                    'alumnos.aluClave',
                    'personas.perNombre', 
                    'personas.perApellido1', 
                    'personas.perApellido2',
                    'personas.perFechaNac', 
                    'personas.perCurp', 
                    'municipios.munNombre', 
                    'estados.edoNombre', 
                    'paises.paisNombre',
                    'cgt.cgtGradoSemestre',
                    'cgt.cgtGrupo',
                    'programas.id as programa_id',
                    'planes.id as plan_id',
                    'periodos.id as periodo_id',
                    'periodos.perAnioPago',               
                    'programas.progClave',
                    'programas.progNombre'
                )
                ->join('alumnos', 'primaria_expediente_entrevista_inicial.alumno_id', '=', 'alumnos.id')
                ->join('cursos', 'alumnos.id', '=', 'cursos.alumno_id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('municipios', 'personas.municipio_id', '=', 'municipios.id')
                ->join('estados', 'municipios.estado_id', '=', 'estados.id')
                ->join('paises', 'estados.pais_id', '=', 'paises.id')
                ->where('programas.id', $programa_id)
                ->where('planes.id', $plan_id)
                ->where('periodos.id', $periodo_id)
                ->where('cgt.cgtGradoSemestre', $grado)
                ->where('cgt.cgtGrupo', $grupo)
                ->where('alumnos.aluClave', $aluClave)->first();

                if($alumnoEntrevista == "") {
                    alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.')->showConfirmButton();
                    return back()->withInput();
                  }
        
        
                $fechaActual = Carbon::now('America/Merida');
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');
        
                $anioNacimiento = explode("-", $alumnoEntrevista->perFechaNac);        
                $anoHoy = $fechaActual->format('Y');
        
                // calcular edad (año actual - año nacimiento alumno)
                $edadCalculada = $anoHoy - $anioNacimiento[0];

                $parametro_NombreArchivo = "pdf_primaria_entrevista_inicial";
                $pdf = PDF::loadView('reportes.pdf.primaria.entrevista_inicial.' . $parametro_NombreArchivo, [
                    "edadCalculada" => $edadCalculada,
                    "alumnoEntrevista" => $alumnoEntrevista,
                    "fechaActual" => $fechaActual->format('d-m-Y')
                ]);
        
                $pdf->defaultFont = 'Times Sans Serif';
        
                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
            }else{
                $alumnoEntrevista = Primaria_expediente_entrevista_inicial::select(
                    'primaria_expediente_entrevista_inicial.*',
                    'alumnos.aluClave',
                    'personas.perNombre', 
                    'personas.perApellido1', 
                    'personas.perApellido2',
                    'personas.perFechaNac', 
                    'personas.perCurp', 
                    'municipios.munNombre', 
                    'estados.edoNombre', 
                    'paises.paisNombre',
                    'cgt.cgtGradoSemestre',
                    'cgt.cgtGrupo',
                    'programas.id as programa_id',
                    'planes.id as plan_id',
                    'periodos.id as periodo_id',
                    'periodos.perAnioPago', 
                    'programas.progClave',
                    'programas.progNombre'
                )
                ->join('alumnos', 'primaria_expediente_entrevista_inicial.alumno_id', '=', 'alumnos.id')
                ->join('cursos', 'alumnos.id', '=', 'cursos.alumno_id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('municipios', 'personas.municipio_id', '=', 'municipios.id')
                ->join('estados', 'municipios.estado_id', '=', 'estados.id')
                ->join('paises', 'estados.pais_id', '=', 'paises.id')
                ->where('programas.id', $programa_id)
                ->where('planes.id', $plan_id)
                ->where('periodos.id', $periodo_id)
                ->where('cgt.cgtGradoSemestre', $grado)
                ->where('cgt.cgtGrupo', $grupo)
                ->get();

                if(count($alumnoEntrevista) == 0) {
                    alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.')->showConfirmButton();
                    return back()->withInput();
                }

                $fechaActual = Carbon::now('America/Merida');
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');
        
                // $anioNacimiento = explode("-", $alumnoEntrevista->perFechaNac);        
                // $anoHoy = $fechaActual->format('Y');
        
                // calcular edad (año actual - año nacimiento alumno)
                // $edadCalculada = $anoHoy - $anioNacimiento[0];

                $parametro_NombreArchivo = "pdf_primaria_entrevista_inicial_general";
                $pdf = PDF::loadView('reportes.pdf.primaria.entrevista_inicial.' . $parametro_NombreArchivo, [
                    // "edadCalculada" => $edadCalculada,
                    "alumnosEntrevistas" => $alumnoEntrevista,
                    "fechaActual" => $fechaActual->format('d-m-Y')
                ]);
        
                $pdf->defaultFont = 'Times Sans Serif';
        
                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
            }         
        }

        if($tipoReporte == "2"){

         
            $programa = Programa::findorFail($programa_id);
            $periodo = Periodo::findorFail($periodo_id);

            $parametro_NombreArchivo = "pdf_primaria_entrevista_inicial_formato_blanco";
                $pdf = PDF::loadView('reportes.pdf.primaria.entrevista_inicial.' . $parametro_NombreArchivo, [
                    "programa" => $programa,
                    "periodo" =>$periodo
                ]);
        
                $pdf->defaultFont = 'Times Sans Serif';
        
                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }



    }
 

}

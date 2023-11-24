<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use App\clases\personas\MetodosPersonas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Conceptoscursoestado;
use App\Models\Periodo;
use App\Models\Secundaria\Secundaria_inscritos;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaCalificacionFaltanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Reporte()
    {
        // $ubicaciones = Ubicacion::sedes()->get();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();


        $conceptos = Conceptoscursoestado::get();
       
        return view('secundaria.reportes.calificaciones_faltantes.create', [
            'ubicaciones' => $ubicaciones,
            'conceptos' => $conceptos
        ]);
       
    }

 
    public function imprimirCalificacionesFaltantes(Request $request)
    {

        // filtra las calificaciones de acuerdo al mes que el usuario indique 
        $mesEvaluar = $request->mesEvaluar;
        $periodo = Periodo::find($request->periodo_id);
        $perAnioPago = $periodo->perAnioPago;
        $ubicacion_id = $request->ubicacion_id;

        $ubicacion = Ubicacion::where('id', $ubicacion_id)->first();
        
        //Validamos el mes para traer los datos correspondentes 
        if($mesEvaluar == "Septiembre"){
            $calificacionMesEvaluar = "pi.inscCalificacionSep";
        }
        if($mesEvaluar == "Octubre"){
            $calificacionMesEvaluar = "pi.inscCalificacionOct";
        }
        if($mesEvaluar == "Noviembre"){
            $calificacionMesEvaluar = "pi.inscCalificacionNov";
        }
        if($mesEvaluar == "Diciembre"){
            $calificacionMesEvaluar = "pi.inscCalificacionDic";
        }
        if($mesEvaluar == "Enero"){
            $calificacionMesEvaluar = "pi.inscCalificacionEne";
        }
        if($mesEvaluar == "Febrero"){
            $calificacionMesEvaluar = "pi.inscCalificacionFeb";
        }
        if($mesEvaluar == "Marzo"){
            $calificacionMesEvaluar = "pi.inscCalificacionMar";
        }
        if($mesEvaluar == "Abril"){
            $calificacionMesEvaluar = "pi.inscCalificacionAbr";
        }
        if($mesEvaluar == "Mayo"){
            $calificacionMesEvaluar = "pi.inscCalificacionMay";
        }
        if($mesEvaluar == "Junio"){
            $calificacionMesEvaluar = "pi.inscCalificacionJun";
        }

   
        $alumnos_con_calificaciones_faltantes =  DB::select("SELECT 
        cgt.cgtGradoSemestre as grado,
        cgt.cgtGrupo as grupo,
        cgt.cgtTurno as turno,
        concat_ws(' ',pe.empApellido1,pe.empApellido2, pe.empNombre) as docente,
        pm.matNombre,
        alumnos.aluClave,
        concat_ws(' ',
        personas.perApellido1,
        personas.perApellido2,
        personas.perNombre) as alumno,
        pi.id AS secundaria_inscrito_id,
        pg.gpoMatComplementaria
        FROM
        cursos
                  INNER JOIN periodos ON cursos.periodo_id = periodos.id
                  AND periodos.deleted_at IS NULL
                  INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
                  AND alumnos.deleted_at IS NULL
                  INNER JOIN personas ON alumnos.persona_id = personas.id
                  AND personas.deleted_at IS NULL
                  INNER JOIN cgt ON cursos.cgt_id = cgt.id
                  AND cgt.deleted_at IS NULL
                  INNER JOIN planes ON cgt.plan_id = planes.id
                  AND planes.deleted_at IS NULL
                  INNER JOIN programas ON planes.programa_id = programas.id
                  AND programas.deleted_at IS NULL
                  INNER JOIN escuelas ON programas.escuela_id = escuelas.id
                  AND escuelas.deleted_at IS NULL
                  INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
                  AND departamentos.deleted_at IS NULL
                  INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
                  AND ubicacion.deleted_at IS NULL
                  INNER JOIN secundaria_inscritos pi ON pi.curso_id = cursos.id 
                  AND pi.deleted_at IS NULL
                  INNER JOIN secundaria_grupos pg on pg.id = pi.grupo_id
                  AND pg.deleted_at IS NULL
                  INNER JOIN secundaria_materias pm on pm.id = pg.secundaria_materia_id
                  AND pm.deleted_at IS NULL
                  INNER JOIN secundaria_empleados pe on pe.id = pg.empleado_id_docente
                  AND pe.deleted_at IS NULL
                  WHERE
                    cursos.deleted_at IS NULL
                  AND cursos.curEstado <> 'B'  
                  AND depClave = 'SEC'
                  AND ubicacion.ubiClave = '".$ubicacion->ubiClave."'
                  AND periodos.perAnioPago = $perAnioPago
                  AND $calificacionMesEvaluar IS NULL
                  ORDER BY personas.perApellido1 asc, 
                  personas.perApellido2 asc,
                  personas.perNombre asc;");

                  
        // si no hay datos muestra alerta 
        if (count($alumnos_con_calificaciones_faltantes) == 0) {
            alert()->warning('Sin coincidencias', 'Datos relacionados a la busqueda realizada')->showConfirmButton();
            return back()->withInput();
        }   
   

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $parametro_NombreArchivo = 'pdf_secundaria_calificaciones_faltantes'; //nombre del archivo blade

        // view('reportes.pdf.secundaria.calificaciones_faltantes.pdf_secundaria_calificaciones_faltantes');

            $pdf = PDF::loadView('reportes.pdf.secundaria.calificaciones_faltantes.' . $parametro_NombreArchivo, [               
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),               
                "mesEvaluar" => $mesEvaluar,
                "parametro_NombreArchivo" => $parametro_NombreArchivo,
                "cicloescolar" => $perAnioPago,
                "alumnos" => $alumnos_con_calificaciones_faltantes
            ]);

            // $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');



        
    }

 
}

<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\TutorAlumno;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BachillerReporteAlumnosExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $departamento = Departamento::find(7);
        # code...
        $periodos = Periodo::select('periodos.id', 'periodos.perNumero', 'periodos.perAnio')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->where('departamentos.id', '=', $departamento->id)
        ->where('periodos.id', '>=', $departamento->perActual)
        ->orderBy('perAnioPago', 'DESC')->get();

        return view('bachiller.reportes.alumnosExcel.show-list', [
            'periodos' => $periodos
        ]);
    }

    public function reporteAlumnos()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.alumnosExcel.show-list-eduardo', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    // public function getAlumnosCursosEduardo(Request $request)
    // {

        

    //     if(!empty($request->periodo_id))
    //     {
    //         $resultado_array =  DB::select("call procAlumnosExcelTodosLosNivelesEduardo(" . $request->periodo_id . ")");
    //         $resultado_collection = collect($resultado_array);
      
              
    //     }else{
    //         $resultado_array =  DB::select("call procAlumnosExcelTodosLosNivelesEduardo(0)");
    //         $resultado_collection = collect($resultado_array);
    //     }


    //     return DataTables::of($resultado_collection)->make(true);
    // }

    public function getAlumnosCursos(Request $request)
    {

        if(!empty($request->perAnio))
        {
            // $resultado_array =  DB::select("call procBachillerImprimeAlumnosExcel(" . $request->perAnio . ", " . $request->perNumero . ")");

            $resultado_array = DB::select("SELECT
            cursos.id,
            alumnos.id AS alumno_id,
            alumnos.aluClave,
            alumnos.aluMatricula,
            personas.perNombre,
            personas.perApellido1,
            personas.perApellido2,
            personas.perCurp,
            personas.perFechaNac,
            personas.perSexo,
            periodos.perAnioPago,
            cgt.cgtGradoSemestre,
            cgt.cgtGrupo,
            cgt.cgtTurno,
            cursos.curTipoBeca,
            becas.bcaNombre,
            cursos.curPorcentajeBeca,
            cursos.curObservacionesBeca,
            personas.perTelefono1,
            personas.perTelefono2,
            personas.perCorreo1,
            cursos.curEstado,
            ubicacion.ubiClave,
            periodos.perAnio,
            periodos.perNumero,
            bachiller_alumnos_historia_clinica.hisTutorOficial,
            bachiller_alumnos_historia_clinica.hisCelularTutor,
            bachiller_alumnos_historia_clinica.hisCorreoTutor,
            bachiller_alumnos_historia_clinica.hisParentescoTutor
                FROM cursos AS cursos
                INNER JOIN periodos AS periodos ON periodos.id = cursos.periodo_id
                AND periodos.deleted_at IS NULL
                INNER JOIN alumnos AS alumnos ON alumnos.id = cursos.alumno_id
                AND alumnos.deleted_at IS NULL
                INNER JOIN personas AS personas ON personas.id = alumnos.persona_id
                AND personas.deleted_at IS NULL
                INNER JOIN cgt AS cgt ON cgt.id = cursos.cgt_id
                AND cgt.deleted_at IS NULL
                INNER JOIN planes AS planes ON planes.id = cgt.plan_id
                AND planes.deleted_at IS NULL
                INNER JOIN programas AS programas ON programas.id = planes.programa_id
                AND programas.deleted_at IS NULL
                INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
                AND escuelas.deleted_at IS NULL
                INNER JOIN departamentos AS departamentos ON departamentos.id = escuelas.departamento_id
                AND departamentos.deleted_at IS NULL
                INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
                AND ubicacion.deleted_at IS NULL
                LEFT JOIN bachiller_alumnos_historia_clinica as bachiller_alumnos_historia_clinica ON bachiller_alumnos_historia_clinica.alumno_id = alumnos.id
                AND bachiller_alumnos_historia_clinica.deleted_at IS NULL
                LEFT JOIN bachiller_alumnos_historia_clinica_familiares as bachiller_alumnos_historia_clinica_familiares ON bachiller_alumnos_historia_clinica_familiares.historia_id = bachiller_alumnos_historia_clinica.id
                AND bachiller_alumnos_historia_clinica_familiares.deleted_at IS NULL
                LEFT JOIN becas AS becas ON becas.bcaClave = cursos.curTipoBeca
                -- LEFT JOIN tutoresalumnos AS tutoresalumnos ON tutoresalumnos.alumno_id = alumnos.id
                -- LEFT JOIN tutores AS tutores ON tutores.id = tutoresalumnos.tutor_id
                WHERE cursos.deleted_at IS NULL
                AND departamentos.depClave = 'BAC'
                AND periodos.perAnio = $request->perAnio
                AND periodos.perNumero = $request->perNumero
                ORDER BY cgt.cgtGradoSemestre, cgt.cgtGrupo, personas.perApellido1, personas.perApellido2, ubicacion.ubiClave ASC");


            $resultado_collection = collect($resultado_array);

      
              
        }else{
            $resultado_array =  DB::select("call procBachillerImprimeAlumnosExcel(0, 0)");
            $resultado_collection = collect($resultado_array);
        }


        // return DataTables::of($resultado_collection)->make(true);

        return Datatables::of($resultado_collection)

            ->addColumn('hisTutorOficial', function ($query) {              
                    
                return $query->hisTutorOficial;     
                
            })

            ->addColumn('hisParentescoTutor', function ($query) {              
                    
                return $query->hisParentescoTutor;     
                
            })

            ->addColumn('hisCelularTutor', function ($query) {              
                    
                return $query->hisCelularTutor;     
                
            })

            ->addColumn('hisCorreoTutor', function ($query) {              
                    
                return $query->hisCorreoTutor;     
                
            })

            // ->addColumn('perFechaNac', function ($query) {              
                
            //     return Utils::fecha_string($query->perFechaNac, $query->perFechaNac);
                
            // })            

            // ->addColumn('perSexo', function ($query) {              
                
            //     return $query->perSexo;
                
            // })            

            ->addColumn('aluMatricula', function ($query) {              
                
                return $query->aluMatricula;
                
            })
         
            ->addColumn('tutNombre1', function ($query) {              
                
                // $resultado_array_tutNombre1 =  DB::select("call procBachillerImprimeAlumnosExcelTutores(" . $query->alumno_id . ")");

                $resultado_array_tutNombre1 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");

                $resultado_collections_tutNombre1 = collect($resultado_array_tutNombre1);

                if(count($resultado_collections_tutNombre1) > 0){
                    return $resultado_collections_tutNombre1[0]->tutNombre;
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutTelefono1', function ($query) {              
                
                $resultado_array_tutTelefono1 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutTelefono1 = collect($resultado_array_tutTelefono1);

                if(count($resultado_collections_tutTelefono1) > 0){
                    return $resultado_collections_tutTelefono1[0]->tutTelefono;
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutCorreo1', function ($query) {              
                
                $resultado_array_tutCorreo1 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutCorreo1 = collect($resultado_array_tutCorreo1);

                if(count($resultado_collections_tutCorreo1) > 0){
                    return $resultado_collections_tutCorreo1[0]->tutCorreo; 
                }else{
                    return "";
                }               
                
            })


            // tutor 2 
            ->addColumn('tutNombre2', function ($query) {              
                
                $resultado_array_tutNombre2 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutNombre2 = collect($resultado_array_tutNombre2);

                if(count($resultado_collections_tutNombre2) > 0){
                    if(!empty($resultado_collections_tutNombre2[1]->tutNombre)){
                        return $resultado_collections_tutNombre2[1]->tutNombre;
                    }else{
                        return "";
                    }
                   
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutTelefono2', function ($query) {              
                
                $resultado_array_tutTelefono2 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutTelefono2 = collect($resultado_array_tutTelefono2);

                if(count($resultado_collections_tutTelefono2) > 0){
                    if(!empty($resultado_collections_tutTelefono2[1]->tutTelefono)){
                        return $resultado_collections_tutTelefono2[1]->tutTelefono;
                    }else{
                        return "";
                    }
                   
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutCorreo2', function ($query) {              
                
                $resultado_array_tutCorreo2 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutCorreo2 = collect($resultado_array_tutCorreo2);

                if(count($resultado_collections_tutCorreo2) > 0){
                    if(!empty($resultado_collections_tutCorreo2[1]->tutCorreo)){
                        return $resultado_collections_tutCorreo2[1]->tutCorreo; 
                    }else{
                        return "";
                    }
                    
                }else{
                    return "";
                }               
                
            })
           

            // tutor 3 
            ->addColumn('tutNombre3', function ($query) {              
                
                $resultado_array_tutNombre3 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutNombre3 = collect($resultado_array_tutNombre3);

                if(count($resultado_collections_tutNombre3) > 0){
                    if(!empty($resultado_collections_tutNombre3[2]->tutNombre)){
                        return $resultado_collections_tutNombre3[2]->tutNombre;
                    }else{
                        return "";
                    }
                   
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutTelefono3', function ($query) {              
                
                $resultado_array_tutTelefono3 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutTelefono3 = collect($resultado_array_tutTelefono3);

                if(count($resultado_collections_tutTelefono3) > 0){
                    if(!empty($resultado_collections_tutTelefono3[2]->tutTelefono)){
                        return $resultado_collections_tutTelefono3[2]->tutTelefono;
                    }else{
                        return "";
                    }
                   
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutCorreo3', function ($query) {              
                
                $resultado_array_tutCorreo3 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutCorreo3 = collect($resultado_array_tutCorreo3);

                if(count($resultado_collections_tutCorreo3) > 0){
                    if(!empty($resultado_collections_tutCorreo3[2]->tutCorreo)){
                        return $resultado_collections_tutCorreo3[2]->tutCorreo; 
                    }else{
                        return "";
                    }
                    
                }else{
                    return "";
                }               
                
            })

            // tutor 4 
            ->addColumn('tutNombre4', function ($query) {              
                
                $resultado_array_tutNombre4 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutNombre4 = collect($resultado_array_tutNombre4);

                if(count($resultado_collections_tutNombre4) > 0){
                    if(!empty($resultado_collections_tutNombre4[3]->tutNombre)){
                        return $resultado_collections_tutNombre4[3]->tutNombre;
                    }else{
                        return "";
                    }
                   
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutTelefono4', function ($query) {              
                
                $resultado_array_tutTelefono4 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutTelefono4 = collect($resultado_array_tutTelefono4);

                if(count($resultado_collections_tutTelefono4) > 0){
                    if(!empty($resultado_collections_tutTelefono4[3]->tutTelefono)){
                        return $resultado_collections_tutTelefono4[3]->tutTelefono;
                    }else{
                        return "";
                    }
                   
                }else{
                    return "";
                }               
                
            })

            ->addColumn('tutCorreo4', function ($query) {              
                
                $resultado_array_tutCorreo4 =  DB::select("SELECT DISTINCT tutoresalumnos.alumno_id, 
                tutores.tutNombre, 
                tutores.tutCalle, 
                tutores.tutColonia,
                tutores.tutCorreo,
                tutores.tutTelefono
                FROM tutoresalumnos as tutoresalumnos
                LEFT JOIN tutores AS tutores on tutores.id = tutoresalumnos.tutor_id
                WHERE tutoresalumnos.alumno_id = $query->alumno_id");
                $resultado_collections_tutCorreo4 = collect($resultado_array_tutCorreo4);

                if(count($resultado_collections_tutCorreo4) > 0){
                    if(!empty($resultado_collections_tutCorreo4[3]->tutCorreo)){
                        return $resultado_collections_tutCorreo4[3]->tutCorreo; 
                    }else{
                        return "";
                    }
                    
                }else{
                    return "";
                }               
                
            })

            
         
            ->make(true);
    
    }


}

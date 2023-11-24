<?php

namespace App\Http\Controllers\Tutorias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Tutorias\Tutorias_alumnos;
use App\Models\Tutorias\Tutorias_categoria_preguntas;
use App\Models\Tutorias\Tutorias_formularios;
use App\Models\Tutorias\Tutorias_opciones;
use App\Models\Tutorias\Tutorias_pregunta_respuestas;
use App\Models\Tutorias\Tutorias_preguntas;
use App\Models\Tutorias\Tutorias_respuestas;
use App\Models\Tutorias\Tutorias_usuario;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\clases\SCEM\Mailer;
use App\Models\Curso;
use App\Models\Ubicacion;
use Carbon\Carbon;

class TutoriasEncuestasController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('permisos:tutoriasusuarios',['except' => ['index', 'list', 'create']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tutorias.alumnos.show-list');
    }

    public function list()
    {


        $alumnos = Tutorias_alumnos::select(
            'tutorias_alumnos.AlumnoID',
            'tutorias_alumnos.Nombre',
            'tutorias_alumnos.ApellidoPaterno as apellido_patermo_alumno',
            'tutorias_alumnos.ApellidoMaterno as apellido_materno_alumno',
            'tutorias_alumnos.Correo',
            'tutorias_alumnos.Matricula',
            'tutorias_alumnos.CarreraID',
            'tutorias_alumnos.ClaveCarrera',
            'tutorias_alumnos.EscuelaID',
            'tutorias_alumnos.ClaveEscuela',
            'tutorias_alumnos.Escuela',
            'tutorias_alumnos.UniversidadID',
            'tutorias_alumnos.ClaveUniversidad',
            'tutorias_alumnos.Universidad',
            'tutorias_alumnos.CursoID',
            'periodos.perAnioPago',
            'alumnos.aluClave',
            'cgt.cgtGradoSemestre',
            'escuelas.escClave',
            'personas.perNombre'

        )
        ->leftJoin('tutorias_carreras', 'tutorias_alumnos.CarreraID', '=', 'tutorias_carreras.CarreraID')
        ->leftJoin('cursos', 'tutorias_alumnos.CursoID', '=', 'cursos.id')
        ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->leftJoin('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->leftJoin('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->leftJoin('planes', 'cgt.plan_id', '=', 'planes.id')
        ->leftJoin('programas', 'planes.programa_id', '=', 'programas.id')
        ->leftJoin('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->orderBy('periodos.perAnioPago', 'DESC');



        return DataTables::of($alumnos)

            ->filterColumn('semestre', function($query, $keyword) {
                $query->whereRaw("CONCAT(cgtGradoSemestre) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('semestre',function($query) {
                return $query->cgtGradoSemestre;
            })

            ->filterColumn('apellido1', function($query, $keyword) {
                $query->whereRaw("CONCAT(ApellidoPaterno) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('apellido1',function($query) {
                return $query->apellido_patermo_alumno;
            })

            ->filterColumn('apellido2', function($query, $keyword) {
                $query->whereRaw("CONCAT(ApellidoMaterno) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('apellido2',function($query) {
                return $query->apellido_materno_alumno;
            })

            ->filterColumn('nombre_alumno', function($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('nombre_alumno',function($query) {
                return $query->perNombre;
            })

            ->filterColumn('clave_pago', function($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('clave_pago',function($query) {
                return $query->aluClave;
            })

            ->filterColumn('periodo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
                
            })
            ->addColumn('periodo', function ($query) {
                return $query->perAnioPago;
            })
            ->addColumn('action', function ($alumnos) {
                $acciones = '';

                $acciones = '<div class="row">

                    <a href="/tutorias_encuestas/encuestas_disponibles/'.$alumnos->aluClave.'/'.$alumnos->CursoID.'" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>'
                    ;

                return $acciones;
            })
            ->make(true);

    }


    public function create_alumnos()
    {

        $ubicaciones = Ubicacion::get();

        return view('tutorias.alumnos.create', [
            "ubicaciones" => $ubicaciones
        ]);

    }

    public function storeAlumno(Request $request)
    {

        $cursos = Curso::select(
            'cursos.*',
            'alumnos.aluClave',
            'alumnos.aluMatricula',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'personas.perCorreo1',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'periodos.perNumero',
            'periodos.perAnio',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'

        )
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->where('cursos.periodo_id', $request->periodo_id)
        ->where('cursos.curEstado', '!=', 'B')
        ->whereNull('cursos.deleted_at')
        ->whereNull('alumnos.deleted_at')
        ->whereNull('personas.deleted_at')
        ->whereNull('cgt.deleted_at')
        ->whereNull('periodos.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->whereNull('planes.deleted_at')
        ->whereNull('programas.deleted_at')
        ->whereNull('escuelas.deleted_at')
        ->get();

        $usuario_at = auth()->user()->id;

        foreach($cursos as $curso){

            $tutorias_alumno = Tutorias_alumnos::where('AlumnoIDSCEM', '=', $curso->alumno_id)
            ->where('CursoID', '=', $curso->id)
            ->first();


            if($tutorias_alumno == ""){
                Tutorias_alumnos::create([
                    'AlumnoIDExterno' => 0,
                    'AlumnoIDSCEM' => $curso->alumno_id,
                    'CursoID' => $curso->id,
                    'Nombre' => $curso->perNombre,
                    'ApellidoPaterno' => $curso->perApellido1,
                    'ApellidoMaterno' => $curso->perApellido2,
                    'Correo' => $curso->perCorreo1,
                    'Matricula' => $curso->aluMatricula,
                    'CarreraID' => $curso->programa_id,
                    'CarreraIDSCEM' => $curso->programa_id,
                    'ClaveCarrera' => $curso->progClave,
                    'Carrera' => $curso->progNombre,
                    'Parcial' => NULL,
                    'Foto' => NULL,
                    'EscuelaID' => $curso->escuela_id,
                    'EscuelaIDSCEM' => $curso->escuela_id,
                    'ClaveEscuela' => $curso->escClave,
                    'Escuela' => $curso->escNombre,
                    'UniversidadID' => $curso->ubicacion_id,
                    'UniversidadIDSCEM' => $curso->ubicacion_id,
                    'ClaveUniversidad' =>  $curso->ubiClave,
                    'Universidad' => $curso->ubiNombre,
                    'Estatus' => 1,
                    'Eliminado' => 0,
                    'Semestre' => $curso->cgtGradoSemestre
                ]);

                
                
                // if($curso->aluMatricula == ""){
                //     $aluMatricula = "VACIO";
                // }else{
                //     $aluMatricula = $curso->aluMatricula;
                // }

                // if($curso->perCorreo1 == ""){
                //     $perCorreo1 = "VACIO";
                // }else{
                //     $perCorreo1 = $curso->perCorreo1;
                // }

                // if($curso->perApellido2 == ""){
                //     $perApellido2 = "VACIO";
                // }else{
                //     $perApellido2 = $curso->perApellido2;
                // }

                // DB::select("call procTutoriasAgregarAlumnos(
                //     ".$curso->alumno_id.",
                //     ".$curso->id.",
                //     '".$curso->perNombre."',
                //     '".$curso->perApellido1."',
                //     '".$perApellido2."',
                //     '".$perCorreo1."',
                //     '".$aluMatricula."',
                //     ".$curso->programa_id.",
                //     ".$curso->programa_id.",
                //     '".$curso->progClave."',
                //     '".$curso->progNombre."',
                //     ".$curso->escuela_id.",
                //     ".$curso->escuela_id.",
                //     '".$curso->escClave."',
                //     '".$curso->escNombre."',
                //     ".$curso->ubicacion_id.",
                //     ".$curso->ubicacion_id.",
                //     '".$curso->ubiClave."',
                //     '".$curso->ubiNombre."',
                //     '".$curso->cgtGradoSemestre."',
                //     ".$usuario_at."
                // )");

                // $aluMatricula = "VACIO";
                // $perCorreo1 = "VACIO";
                // $perApellido2 = "VACIO";
                
            }
        }

        alert()->success('Escuela Modelo', "Los registros se han agregado con exito")->autoClose(5000);
        return back();

    }

    public function encuestas_disponibles($aluClave, $CursoID)
    {
        $alumno = Tutorias_alumnos::select('tutorias_alumnos.*',
        'alumnos.aluClave')
        ->leftJoin('cursos', 'tutorias_alumnos.CursoID', '=', 'cursos.id')
        ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('alumnos.aluClave', '=', $aluClave)
        ->where('cursos.id', '=', $CursoID)
        ->firstOrFail();

        //dd($aluClave);

        $formulario = Tutorias_formularios::get();

        $categiria_preguntas = Tutorias_categoria_preguntas::get();

        $tutorias_preguntas = Tutorias_preguntas::select('tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre',
        'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_preguntas.TipoRespuesta',
        'tutorias_formularios.FormularioID')
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_formularios.Eliminado', '=', 0)
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->get();

        $tutorias_formularios = Tutorias_formularios::where('Estatus', 1)->get();

        return view('tutorias.alumnos.numero-encuestas', [
            'alumno' => $alumno,
            'tutorias_formularios' => $tutorias_formularios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function encuesta_nuevo($FormularioID, $AlumnoID)
    {

        $tutorias_formulario = Tutorias_formularios::where('FormularioID', '=', $FormularioID)
        ->where('Estatus', '=', 1)
        ->whereNull('deleted_at')
        ->first();       


        $tutorias_respuestas = Tutorias_preguntas::select(
            'tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre AS Nombre_Pregunta',
            'tutorias_preguntas.CategoriaPreguntaID AS CategoriaPreguntaID_Pregunta',
            'tutorias_preguntas.TipoRespuesta AS TipoRespuesta_Pregunta',
            'tutorias_preguntas.Porcentaje AS Porcentaje_Pregunta',
            'tutorias_preguntas.AtributoWS AS AtributoWS_Pregunta',
            'tutorias_preguntas.Estatus AS Estatus_Pregunta',
            'tutorias_preguntas.totalRespuestas AS totalRespuestas_Pregunta',
            'tutorias_preguntas.orden_visual_pregunta',
            'tutorias_formularios.Nombre AS Nombre_Formulario',
            'tutorias_formularios.Descripcion AS Descripcion_Formulario',
            'tutorias_formularios.Instruccion AS Instruccion_Formulario',
            'tutorias_formularios.Parcial AS Parcial_Formulario',
            'tutorias_formularios.Tipo AS Tipo_Formulario',
            'tutorias_formularios.FechaInicioVigencia AS FechaInicioVigencia_Formulario',
            'tutorias_formularios.FechaFinVigencia AS FechaFinVigencia_Formulario',
            'tutorias_formularios.Estatus AS Estatus_Formulario',
            'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_categoria_preguntas.Nombre AS Nombre_Categoria',
            'tutorias_categoria_preguntas.Descripcion AS Descripcion_Categoria',
            'tutorias_categoria_preguntas.Estatus AS Estatus_Categoria',
            'tutorias_categoria_preguntas.orden_visual_categoria'
        )
        ->leftJoin('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->where('tutorias_formularios.Estatus', '=', 1)
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();

        if(count($tutorias_respuestas) > 0){
            $categorias_grupo = $tutorias_respuestas->groupBy('CategoriaPreguntaID');
            $pregunta_grupo = $tutorias_respuestas->groupBy('PreguntaID');           

        }else{
            $categorias_grupo = [];
            $pregunta_grupo = [];
        }

        // consulta todo lo relacionado al formulario 
        $tutorias_respuestas = Tutorias_respuestas::select(
            'tutorias_respuestas.RespuestaID',
            'tutorias_respuestas.Nombre AS Nombre_Respuesta',
            'tutorias_respuestas.Tipo AS Tipo_Respuesta',
            'tutorias_respuestas.Semaforizacion AS Semaforizacion_Respuesta',
            'tutorias_respuestas.estatus AS Estatus_Respuesta',
            'tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre AS Nombre_Pregunta',
            'tutorias_preguntas.CategoriaPreguntaID AS CategoriaPreguntaID_Pregunta',
            'tutorias_preguntas.TipoRespuesta AS TipoRespuesta_Pregunta',
            'tutorias_preguntas.Porcentaje AS Porcentaje_Pregunta',
            'tutorias_preguntas.AtributoWS AS AtributoWS_Pregunta',
            'tutorias_preguntas.Estatus AS Estatus_Pregunta',
            'tutorias_preguntas.totalRespuestas AS totalRespuestas_Pregunta',
            'tutorias_preguntas.orden_visual_pregunta',
            'tutorias_formularios.Nombre AS Nombre_Formulario',
            'tutorias_formularios.Descripcion AS Descripcion_Formulario',
            'tutorias_formularios.Instruccion AS Instruccion_Formulario',
            'tutorias_formularios.Parcial AS Parcial_Formulario',
            'tutorias_formularios.Tipo AS Tipo_Formulario',
            'tutorias_formularios.FechaInicioVigencia AS FechaInicioVigencia_Formulario',
            'tutorias_formularios.FechaFinVigencia AS FechaFinVigencia_Formulario',
            'tutorias_formularios.Estatus AS Estatus_Formulario',
            'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_categoria_preguntas.Nombre AS Nombre_Categoria',
            'tutorias_categoria_preguntas.Descripcion AS Descripcion_Categoria',
            'tutorias_categoria_preguntas.Estatus AS Estatus_Categoria',
            'tutorias_categoria_preguntas.orden_visual_categoria'
        )
        ->leftJoin('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->where('tutorias_respuestas.estatus', '=', 'SI')
        ->where('tutorias_formularios.Estatus', '=', 1)
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->whereNull('tutorias_respuestas.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();

        if(count($tutorias_respuestas) > 0){
            $tutorias_respuestas_grupo = $tutorias_respuestas->groupBy('RespuestaID');
        }else{
            $tutorias_respuestas_grupo = [];
        }       


        $alumno = Tutorias_alumnos::select('tutorias_alumnos.*',
        'alumnos.aluClave')
        ->leftJoin('cursos', 'tutorias_alumnos.CursoID', '=', 'cursos.id')
        ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('tutorias_alumnos.AlumnoID', '=', $AlumnoID)
        ->first();


        // respuestas del alumno 
        $categoria_respuestas_alumnos = Tutorias_pregunta_respuestas::select(
            'tutorias_pregunta_respuestas.PreguntaRespuestaID',
            'tutorias_pregunta_respuestas.Tipo as Tipo_Respondido',
            'tutorias_pregunta_respuestas.RespuestaID as RespuestaID_Respondido',
            'tutorias_pregunta_respuestas.Respuesta as Respuesta_Respondido',
            'tutorias_pregunta_respuestas.PreguntaID as PreguntaID_Respondido',
            'tutorias_pregunta_respuestas.AlumnoID as AlumnoID_Respondido',
            'tutorias_pregunta_respuestas.Porcentaje as Porcentaje_Respondido',
            'tutorias_pregunta_respuestas.Disponible as Disponible_Respondido',
            'tutorias_pregunta_respuestas.FormularioID as FormularioID_Respondido',
            'tutorias_pregunta_respuestas.Parcial as Parcial_Respondido',
            'tutorias_pregunta_respuestas.CarreraID as CarreraID_Respondido',
            'tutorias_pregunta_respuestas.ClaveCarrera as ClaveCarrera_Respondido',
            'tutorias_pregunta_respuestas.Carrera as Carrera_Respondido',
            'tutorias_pregunta_respuestas.EscuelaID as EscuelaID_Respondido',
            'tutorias_pregunta_respuestas.ClaveEscuela as ClaveEscuela_Respondido',
            'tutorias_pregunta_respuestas.Escuela as Escuela_Respondido',
            'tutorias_pregunta_respuestas.UniversidadID as UniversidadID_Respondido',
            'tutorias_pregunta_respuestas.ClaveUniversidad as ClaveUniversidad_Respondido',
            'tutorias_pregunta_respuestas.Universidad as Universidad_Respondido',
            'tutorias_pregunta_respuestas.Semaforizacion as Semaforizacion_Respondido',
            'tutorias_pregunta_respuestas.CategoriaID as CategoriaID_Respondido',
            'tutorias_pregunta_respuestas.NombreCategoria as NombreCategoria_Respondido',
            'tutorias_pregunta_respuestas.DescripcionCategoria as DescripcionCategoria_Respondido',
            'tutorias_respuestas.Tipo AS Tipo_Respuesta',
            'tutorias_respuestas.Semaforizacion AS Semaforizacion_Respuesta',
            'tutorias_respuestas.PreguntaID AS PreguntaID_Respuesta',
            'tutorias_respuestas.estatus AS estatus_Respuesta',
            'tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre AS Nombre_Pregunta',
            'tutorias_preguntas.CategoriaPreguntaID AS CategoriaPreguntaID_Pregunta',
            'tutorias_preguntas.TipoRespuesta AS TipoRespuesta_Pregunta',
            'tutorias_preguntas.FormularioID AS FormularioID_Pregunta',
            'tutorias_preguntas.Porcentaje AS Porcentaje_Pregunta',
            'tutorias_preguntas.AtributoWS AS AtributoWS_Pregunta',
            'tutorias_preguntas.Estatus AS Estatus_Pregunta',
            'tutorias_preguntas.Eliminado AS Eliminado_Pregunta',
            'tutorias_preguntas.orden_visual_pregunta',
            'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_categoria_preguntas.Nombre as Nombre_Categoria',
            'tutorias_categoria_preguntas.Descripcion as Descripcion_Categoria',
            'tutorias_categoria_preguntas.Estatus as Estatus_Categoria',
            'tutorias_categoria_preguntas.orden_visual_categoria'


        )
        ->leftJoin('tutorias_respuestas', 'tutorias_pregunta_respuestas.RespuestaID', '=', 'tutorias_respuestas.RespuestaID')
        ->leftJoin('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_pregunta_respuestas.CategoriaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_pregunta_respuestas.FormularioID', '=', $FormularioID)
        // ->where('tutorias_preguntas.Estatus', '=', 1)
        // ->where('tutorias_formularios.Estatus', '=', 1)
        ->whereNull('tutorias_pregunta_respuestas.deleted_at')
        ->whereNull('tutorias_respuestas.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();
                
        if(count($categoria_respuestas_alumnos) > 0){
            $categorias_grupo_respondido = $categoria_respuestas_alumnos->groupBy('CategoriaPreguntaID');
            $pregunta_grupo_respondido = $categoria_respuestas_alumnos->groupBy('PreguntaID');           

        }else{
            $categorias_grupo_respondido = [];
            $pregunta_grupo_respondido = [];
        }

       

        return view('tutorias.alumnos.encuesta_new', [
            "alumno" => $alumno,
            "tutorias_formulario" => $tutorias_formulario,
            "categorias_grupo" => $categorias_grupo,
            "pregunta_grupo" => $pregunta_grupo,
            "tutorias_respuestas_grupo" => $tutorias_respuestas_grupo,
            "categoria_respuestas_alumnos" => $categoria_respuestas_alumnos,
            "categorias_grupo_respondido" => $categorias_grupo_respondido,
            "pregunta_grupo_respondido" => $pregunta_grupo_respondido
        ]);
    }

    public function encuesta($FormularioID, $AlumnoID)
    {

        $tutorias_preguntas = Tutorias_preguntas::select(
            'tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre',
            'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_categoria_preguntas.Nombre AS NombrePregunta',
            'tutorias_preguntas.TipoRespuesta',
            'tutorias_formularios.FormularioID',
            'tutorias_categoria_preguntas.Descripcion',
            'tutorias_formularios.Nombre AS nombreFormulario',
            'tutorias_formularios.FechaInicioVigencia',
            'tutorias_formularios.FechaFinVigencia'
        )
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_formularios.Eliminado', '=', 0)
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();

        $agrupar_categoria_preguntas1 = Tutorias_preguntas::select('tutorias_preguntas.CategoriaPreguntaID','tutorias_categoria_preguntas.Nombre AS NombreCategoria',
        'tutorias_categoria_preguntas.orden_visual_categoria',
        'tutorias_preguntas.orden_visual_pregunta')
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();

        $agrupar_categoria_preguntas = $agrupar_categoria_preguntas1->groupBy('NombreCategoria');

        // return $agrupar_categoria_preguntas = DB::table('tutorias_preguntas')
        // ->select(DB::raw('count(*) as CategoriaPregunta_count, tutorias_preguntas.CategoriaPreguntaID, tutorias_categoria_preguntas.Nombre AS NombreCategoria'),
        // DB::raw('count(*) as orden_visual_categoria, tutorias_categoria_preguntas.orden_visual_categoria, tutorias_categoria_preguntas.orden_visual_categoria'),
        // DB::raw('count(*) as orden_visual_pregunta, tutorias_preguntas.orden_visual_pregunta, tutorias_preguntas.orden_visual_pregunta'))
        // ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        // ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        // ->groupBy('tutorias_preguntas.CategoriaPreguntaID')
        // ->groupBy('tutorias_preguntas.orden_visual_pregunta')
        // ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        // ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        // ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        // ->get();

        $tutorias_respuesta_agrupada = DB::table('tutorias_respuestas')
        ->select(DB::raw('count(*) as PreguntaID_count, tutorias_respuestas.PreguntaID'))
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_respuestas.estatus', 'SI')
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->whereNull('tutorias_respuestas.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->groupBy('tutorias_respuestas.PreguntaID')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();


        $tutRespuestas = Tutorias_respuestas::select(
            'tutorias_respuestas.RespuestaID',
            'tutorias_respuestas.Nombre',
            'tutorias_respuestas.Tipo',
            'tutorias_respuestas.Semaforizacion',
            'tutorias_respuestas.PreguntaID',
            'tutorias_preguntas.Nombre as NombrePrgunta',
            'tutorias_preguntas.CategoriaPreguntaID',
            'tutorias_preguntas.FormularioID',
            'tutorias_formularios.Parcial'
        )
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->where('tutorias_respuestas.estatus', 'SI')
        ->whereNull('tutorias_respuestas.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();


        $alumno = Tutorias_alumnos::select('tutorias_alumnos.*',
        'alumnos.aluClave')
        ->leftJoin('cursos', 'tutorias_alumnos.CursoID', '=', 'cursos.id')
        ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('tutorias_alumnos.AlumnoID', '=', $AlumnoID)->firstOrFail();


        // datos que se agregan cuando ya se ha respondido la encuesta

        // retorna datos para poner en el emcabezado
        $respuestas_datos_alumno = Tutorias_pregunta_respuestas::select(
            'tutorias_pregunta_respuestas.*',
            'tutorias_alumnos.*',
            'tutorias_formularios.Nombre as NombreFormulario',
            'tutorias_formularios.FechaInicioVigencia',
            'tutorias_formularios.FechaFinVigencia'
        )
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->whereNull('tutorias_pregunta_respuestas.deleted_at')
        ->whereNull('tutorias_alumnos.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->first();


        // retorna las categorias de manera agrupada, que fueron respondidas por cada alumno
       $categoria_respuestas_alumnos = DB::table('tutorias_pregunta_respuestas')
        ->select(
            'tutorias_pregunta_respuestas.CategoriaID',
            DB::raw('count(*) as CategoriaID, tutorias_pregunta_respuestas.CategoriaID'),
            'tutorias_pregunta_respuestas.NombreCategoria',
            DB::raw('count(*) as NombreCategoria, tutorias_pregunta_respuestas.NombreCategoria'),
            'tutorias_categoria_preguntas.orden_visual_categoria',
            DB::raw('count(*) as orden_visual_categoria, tutorias_categoria_preguntas.orden_visual_categoria')
        )
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->groupBy('tutorias_pregunta_respuestas.CategoriaID')
        ->groupBy('tutorias_pregunta_respuestas.NombreCategoria')
        ->groupBy('tutorias_categoria_preguntas.orden_visual_categoria')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->whereNull('tutorias_pregunta_respuestas.deleted_at')
        ->whereNull('tutorias_alumnos.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->get();


        // retorna las categorias de manera agrupada, que fueron respondidas por cada alumno
        $categoria_respuestas1 = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.CategoriaID',
        'tutorias_pregunta_respuestas.CategoriaID',
        'tutorias_pregunta_respuestas.NombreCategoria',
        'tutorias_categoria_preguntas.orden_visual_categoria')
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->whereNull('tutorias_pregunta_respuestas.deleted_at')
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->whereNull('tutorias_alumnos.deleted_at')
        ->whereNull('tutorias_formularios.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->get();

        $categoria_respuestas = $categoria_respuestas1->groupBy('CategoriaID');

        // retorna las respuestas que el alumno selecciono o respondio
        $respuestas_alumno = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.*', 'tutorias_preguntas.*', 'tutorias_respuestas.RespuestaID',
        'tutorias_categoria_preguntas.orden_visual_categoria')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_respuestas', 'tutorias_pregunta_respuestas.RespuestaID', '=', 'tutorias_respuestas.RespuestaID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_pregunta_respuestas.FormularioID', '=', $FormularioID)
        // ->where('tutorias_respuestas.estatus', 'SI')
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->whereNull('tutorias_pregunta_respuestas.deleted_at')
        ->whereNull('tutorias_preguntas.deleted_at')
        ->whereNull('tutorias_respuestas.deleted_at')
        ->whereNull('tutorias_categoria_preguntas.deleted_at')
        ->get();


        if ($respuestas_datos_alumno != "") {
            // retorna las respuestas disponibles que se encuentran en la tabla "tutorias_respuestas"
             $respuestasTable = Tutorias_respuestas::select(
                'tutorias_respuestas.*',
                'tutorias_categoria_preguntas.CategoriaPreguntaID',
                'tutorias_categoria_preguntas.Nombre as NombreCategoria',
                'tutorias_categoria_preguntas.Descripcion as DescripcionCategoria',
                'tutorias_preguntas.TipoRespuesta'
            )
            ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
            ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
            ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
            ->where('tutorias_preguntas.FormularioID', '=', $respuestas_datos_alumno->FormularioID)
            ->whereNull('tutorias_respuestas.deleted_at')
            ->where('tutorias_respuestas.estatus', 'SI')
            ->where('tutorias_preguntas.Estatus', '=', 1)
            ->whereNull('tutorias_preguntas.deleted_at')
            ->whereNull('tutorias_formularios.deleted_at')
            ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
            ->get();
        } else {
            $respuestasTable = "";
        }




        $preguntas_respuestas = Tutorias_pregunta_respuestas::get()
            ->where('FormularioID', '=', $FormularioID)
            ->where('AlumnoID', '=', $AlumnoID);

        return view('tutorias.alumnos.encuesta', [
            'tutorias_preguntas' => $tutorias_preguntas,
            'agrupar_categoria_preguntas' => $agrupar_categoria_preguntas,
            'tutorias_respuesta_agrupada' => $tutorias_respuesta_agrupada,
            'tutRespuestas' => $tutRespuestas,
            'FormularioID' => $FormularioID,
            'alumno' => $alumno,
            'categoria_respuestas_alumnos' => $categoria_respuestas_alumnos,
            'categoria_respuestas' => $categoria_respuestas,
            'respuestas_alumno' => $respuestas_alumno,
            'respuestasTable' => $respuestasTable,
            'respuestas_datos_alumno' => $respuestas_datos_alumno
        ]);
    }

    public function encuesta_covid($FormularioID, $AlumnoID)
    {

        $tutorias_preguntas = Tutorias_preguntas::select(
            'tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre',
            'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_categoria_preguntas.Nombre AS NombrePregunta',
            'tutorias_preguntas.TipoRespuesta',
            'tutorias_formularios.FormularioID',
            'tutorias_categoria_preguntas.Descripcion',
            'tutorias_formularios.Nombre AS nombreFormulario',
            'tutorias_formularios.FechaInicioVigencia',
            'tutorias_formularios.FechaFinVigencia'
        )
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_formularios.Eliminado', '=', 0)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();

        $agrupar_categoria_preguntas1 = Tutorias_preguntas::select('tutorias_preguntas.CategoriaPreguntaID','tutorias_categoria_preguntas.Nombre AS NombreCategoria',
        'tutorias_categoria_preguntas.orden_visual_categoria',
        'tutorias_preguntas.orden_visual_pregunta')
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();

        $agrupar_categoria_preguntas = $agrupar_categoria_preguntas1->groupBy('NombreCategoria');

        // return $agrupar_categoria_preguntas = DB::table('tutorias_preguntas')
        // ->select(DB::raw('count(*) as CategoriaPregunta_count, tutorias_preguntas.CategoriaPreguntaID, tutorias_categoria_preguntas.Nombre AS NombreCategoria'),
        // DB::raw('count(*) as orden_visual_categoria, tutorias_categoria_preguntas.orden_visual_categoria, tutorias_categoria_preguntas.orden_visual_categoria'),
        // DB::raw('count(*) as orden_visual_pregunta, tutorias_preguntas.orden_visual_pregunta, tutorias_preguntas.orden_visual_pregunta'))
        // ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        // ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        // ->groupBy('tutorias_preguntas.CategoriaPreguntaID')
        // ->groupBy('tutorias_preguntas.orden_visual_pregunta')
        // ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        // ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        // ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        // ->get();

        $tutorias_respuesta_agrupada = DB::table('tutorias_respuestas')
        ->select(DB::raw('count(*) as PreguntaID_count, tutorias_respuestas.PreguntaID'))
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_respuestas.estatus', 'SI')
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->groupBy('tutorias_respuestas.PreguntaID')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();


        $tutRespuestas = Tutorias_respuestas::select(
            'tutorias_respuestas.RespuestaID',
            'tutorias_respuestas.Nombre',
            'tutorias_respuestas.Tipo',
            'tutorias_respuestas.Semaforizacion',
            'tutorias_respuestas.PreguntaID',
            'tutorias_preguntas.Nombre as NombrePrgunta',
            'tutorias_preguntas.CategoriaPreguntaID',
            'tutorias_preguntas.FormularioID',
            'tutorias_formularios.Parcial'
        )
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        ->where('tutorias_respuestas.estatus', 'SI')
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();



        $alumno = Tutorias_alumnos::select('tutorias_alumnos.*',
        'alumnos.aluClave')
        ->leftJoin('cursos', 'tutorias_alumnos.CursoID', '=', 'cursos.id')
        ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('tutorias_alumnos.AlumnoID', '=', $AlumnoID)->firstOrFail();


        // datos que se agregan cuando ya se ha respondido la encuesta

        // retorna datos para poner en el emcabezado
        $respuestas_datos_alumno = Tutorias_pregunta_respuestas::select(
            'tutorias_pregunta_respuestas.*',
            'tutorias_alumnos.*',
            'tutorias_formularios.Nombre as NombreFormulario',
            'tutorias_formularios.FechaInicioVigencia',
            'tutorias_formularios.FechaFinVigencia'
        )
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->first();


        // retorna las categorias de manera agrupada, que fueron respondidas por cada alumno
       $categoria_respuestas_alumnos = DB::table('tutorias_pregunta_respuestas')
        ->select(
            'tutorias_pregunta_respuestas.CategoriaID',
            DB::raw('count(*) as CategoriaID, tutorias_pregunta_respuestas.CategoriaID'),
            'tutorias_pregunta_respuestas.NombreCategoria',
            DB::raw('count(*) as NombreCategoria, tutorias_pregunta_respuestas.NombreCategoria'),
            'tutorias_categoria_preguntas.orden_visual_categoria',
            DB::raw('count(*) as orden_visual_categoria, tutorias_categoria_preguntas.orden_visual_categoria')
        )
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->groupBy('tutorias_pregunta_respuestas.CategoriaID')
        ->groupBy('tutorias_pregunta_respuestas.NombreCategoria')
        ->groupBy('tutorias_categoria_preguntas.orden_visual_categoria')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->get();


        // retorna las categorias de manera agrupada, que fueron respondidas por cada alumno
        $categoria_respuestas1 = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.CategoriaID',
        'tutorias_pregunta_respuestas.CategoriaID',
        'tutorias_pregunta_respuestas.NombreCategoria',
        'tutorias_categoria_preguntas.orden_visual_categoria')
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_formularios.FormularioID', '=', $FormularioID)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->get();

        $categoria_respuestas = $categoria_respuestas1->groupBy('CategoriaID');

        // retorna las respuestas que el alumno selecciono o respondio
        $respuestas_alumno = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.*', 'tutorias_preguntas.*', 'tutorias_respuestas.RespuestaID',
        'tutorias_categoria_preguntas.orden_visual_categoria')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->leftJoin('tutorias_respuestas', 'tutorias_pregunta_respuestas.RespuestaID', '=', 'tutorias_respuestas.RespuestaID')
        ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')        
        ->where('tutorias_respuestas.estatus', 'SI')
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->where('tutorias_pregunta_respuestas.FormularioID', '=', $FormularioID)
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC')
        ->get();


        if ($respuestas_datos_alumno != "") {
            // retorna las respuestas disponibles que se encuentran en la tabla "tutorias_respuestas"
             $respuestasTable = Tutorias_respuestas::select(
                'tutorias_respuestas.*',
                'tutorias_categoria_preguntas.CategoriaPreguntaID',
                'tutorias_categoria_preguntas.Nombre as NombreCategoria',
                'tutorias_categoria_preguntas.Descripcion as DescripcionCategoria'
            )
            ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
            ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
            ->leftJoin('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
            ->where('tutorias_preguntas.FormularioID', '=', $respuestas_datos_alumno->FormularioID)
            ->where('tutorias_preguntas.Estatus', '=', 1)
            ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
            ->get();
        } else {
            $respuestasTable = "";
        }




        $preguntas_respuestas = Tutorias_pregunta_respuestas::get()
            ->where('FormularioID', '=', $FormularioID)
            ->where('AlumnoID', '=', $AlumnoID);

        return view('tutorias.alumnos.encuesta-covid', [
            'tutorias_preguntas' => $tutorias_preguntas,
            'agrupar_categoria_preguntas' => $agrupar_categoria_preguntas,
            'tutorias_respuesta_agrupada' => $tutorias_respuesta_agrupada,
            'tutRespuestas' => $tutRespuestas,
            'FormularioID' => $FormularioID,
            'alumno' => $alumno,
            'categoria_respuestas_alumnos' => $categoria_respuestas_alumnos,
            'categoria_respuestas' => $categoria_respuestas,
            'respuestas_alumno' => $respuestas_alumno,
            'respuestasTable' => $respuestasTable,
            'respuestas_datos_alumno' => $respuestas_datos_alumno
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_nuevo(Request $request)
    {

        if($request->ACCION == "GUARDAR"){

            // variables del request
            $Tipo_Respuesta = $request->Tipo_Respuesta;

            // respuestas
            return $Respuesta = $request->Respuesta;
            $collectionRespuesta = collect($Respuesta);
            $Respuestas = $collectionRespuesta->values(); //este el el valor
            $PreguntaID = $collectionRespuesta->keys();


            $AlumnoID = $request->AlumnoID;
            $FormularioID = $request->FormularioID;
            $Parcial = $request->Parcial;
            $CarreraID = $request->CarreraID;
            $ClaveCarrera = $request->ClaveCarrera;
            $Carrera = $request->Carrera;
            $EscuelaID = $request->EscuelaID;
            $ClaveEscuela = $request->ClaveEscuela;
            $Escuela = $request->Escuela;
            $UniversidadID = $request->UniversidadID;
            $ClaveUniversidad = $request->ClaveUniversidad;
            $Universidad = $request->Universidad;
            $CategoriaID = $request->CategoriaPreguntaID;
            $NombreCategoria = $request->NombreCategoria;
            $DescripcionCategoria = $request->DescripcionCategoria;

            //SemaforizCION
            $Semaforizacion = $request->Semaforizacion;
            $collectionSemaforizacion = collect($Semaforizacion);
            $SemaforizacionValue = $collectionSemaforizacion->values();  //este el el valor

            // RespuestaID
            $respuestaID = $request->respuestaData;
            $collectionRespuesta = collect($respuestaID);
            $RespuestaValue = $collectionRespuesta->values();  //este el el valor

            $numeroDeRespuestas = count($collectionRespuesta);

            $respuestas = [];
            for ($i=0; $i < $numeroDeRespuestas; $i++) {
                $respuestas[$RespuestaValue[$i]] = $Respuestas[$i];
                $preguntaRespuesta = array();
                $preguntaRespuesta = new Tutorias_pregunta_respuestas();
                $preguntaRespuesta['Tipo'] = $Tipo_Respuesta[$i];
                $preguntaRespuesta['RespuestaID'] = $RespuestaValue[$i];
                $preguntaRespuesta['Respuesta'] = $Respuestas[$i];
                $preguntaRespuesta['PreguntaID'] = $PreguntaID[$i];
                $preguntaRespuesta['AlumnoID'] = $AlumnoID;
                $preguntaRespuesta['Porcentaje'] = 100;
                $preguntaRespuesta['Disponible'] = 0;
                $preguntaRespuesta['FormularioID'] = $FormularioID;
                $preguntaRespuesta['Parcial'] = $Parcial;
                $preguntaRespuesta['CarreraID'] = $CarreraID;
                $preguntaRespuesta['ClaveCarrera'] = $ClaveCarrera;
                $preguntaRespuesta['Carrera'] = $Carrera;
                $preguntaRespuesta['EscuelaID'] = $EscuelaID;
                $preguntaRespuesta['ClaveEscuela'] = $ClaveEscuela;
                $preguntaRespuesta['Escuela'] = $Escuela;
                $preguntaRespuesta['UniversidadID'] = $UniversidadID;
                $preguntaRespuesta['ClaveUniversidad'] = $ClaveUniversidad;
                $preguntaRespuesta['Universidad'] = $Universidad;
                $preguntaRespuesta['Semaforizacion'] = $SemaforizacionValue[$i];
                $preguntaRespuesta['CategoriaID'] = $CategoriaID[$i];
                $preguntaRespuesta['NombreCategoria'] = $NombreCategoria[$i];
                $preguntaRespuesta['DescripcionCategoria'] = $DescripcionCategoria[$i];

                $preguntaRespuesta->save();
            }

            $busca_formulario = Tutorias_formularios::findOrFail($FormularioID);
            if($busca_formulario->Tipo == 3){
                $this->enviarCorreoEncuestaInansistenciaCovid19($FormularioID, $AlumnoID, $respuestas);
            }

            alert('Escuela Modelo', 'La encuesta se guardo con éxito', 'success')->showConfirmButton();
            return back();
        }


        if($request->ACCION == "ACTUALIZAR"){



            // variables del request
            $Tipo = $request->Tipo;

            // respuestas
            $Respuesta = $request->Respuesta;
            $collectionRespuesta = collect($Respuesta);
            $Respuestas = $collectionRespuesta->values(); //este el el valor
            $PreguntaRespuestaID = $collectionRespuesta->keys();


            $AlumnoID = $request->AlumnoID;
            $FormularioID = $request->FormularioID;
            $CarreraID = $request->CarreraID;
            $ClaveCarrera = $request->ClaveCarrera;
            $Carrera = $request->Carrera;
            $EscuelaID = $request->EscuelaID;
            $ClaveEscuela = $request->ClaveEscuela;
            $Escuela = $request->Escuela;
            $UniversidadID = $request->UniversidadID;
            $ClaveUniversidad = $request->ClaveUniversidad;
            $Universidad = $request->Universidad;

            $CategoriaID = $request->CategoriaID;
            $NombreCategoria = $request->NombreCategoria;
            $DescripcionCategoria = $request->DescripcionCategoria;

            //SemaforizCION
            $Semaforizacion = $request->Semaforizacion;
            $collectionSemaforizacion = collect($Semaforizacion);
            $SemaforizacionValue = $collectionSemaforizacion->values();  //este el el valor

            // RespuestaID
            $respuestaID = $request->respuestaData;
            $collectionRespuesta = collect($respuestaID);
            $RespuestaValue = $collectionRespuesta->values();  //este el el valor

            for ($i = 0; $i < count($Respuestas);  $i++ ) {

                DB::table('tutorias_pregunta_respuestas')
                ->where('PreguntaRespuestaID', $PreguntaRespuestaID[$i])
                ->update([
                    'RespuestaID' => $RespuestaValue[$i],
                    'Respuesta' => $Respuestas[$i],
                    // 'CategoriaID' => $CategoriaID[$i],
                    // 'NombreCategoria' => $NombreCategoria[$i],
                    // 'DescripcionCategoria' => $DescripcionCategoria[$i],
                    'Semaforizacion' => $SemaforizacionValue[$i]

                ]);
            }
            // Actualizamos solo las preguntas con respuesta abierta 
            for($xx = 0; $xx < count($request->PreguntaID); $xx++){
                $tutRsp = Tutorias_respuestas::where('Nombre', '=', null)
               ->where('PreguntaID', '=', $request->PreguntaID[$xx])
               ->get();

               foreach ($tutRsp as $key => $value) {
                    // print_r("<br>".$value->RespuestaID. ' '.$value->PreguntaID);

                    DB::table('tutorias_pregunta_respuestas')
                    // ->where('PreguntaRespuestaID', $PreguntaRespuestaID)
                    ->where('PreguntaID', $value->PreguntaID)
                    ->update([
                        'RespuestaID' => $value->RespuestaID,
                        'Semaforizacion' => $value->Semaforizacion

                    ]);
               }               
           }
            alert('Escuela Modelo', 'La encuesta se guardo con éxito', 'success')->showConfirmButton();
            // return redirect('tutorias_encuestas/encuesta/'.$FormularioID.'/'.$AlumnoID);
            return back();
        }
    }

    public function store(Request $request)
    {

        if($request->ACCION == "GUARDAR"){

            // variables del request
            $Tipo = $request->Tipo;

            // respuestas
            $Respuesta = $request->Respuesta;
            $collectionRespuesta = collect($Respuesta);
            $Respuestas = $collectionRespuesta->values(); //este el el valor
            $PreguntaID = $collectionRespuesta->keys();


            $AlumnoID = $request->AlumnoID;
            $FormularioID = $request->FormularioID;
            $Parcial = $request->Parcial;
            $CarreraID = $request->CarreraID;
            $ClaveCarrera = $request->ClaveCarrera;
            $Carrera = $request->Carrera;
            $EscuelaID = $request->EscuelaID;
            $ClaveEscuela = $request->ClaveEscuela;
            $Escuela = $request->Escuela;
            $UniversidadID = $request->UniversidadID;
            $ClaveUniversidad = $request->ClaveUniversidad;
            $Universidad = $request->Universidad;
            $CategoriaID = $request->CategoriaPreguntaID;
            $NombreCategoria = $request->NombreCategoria;
            $DescripcionCategoria = $request->DescripcionCategoria;

            //SemaforizCION
            $Semaforizacion = $request->Semaforizacion;
            $collectionSemaforizacion = collect($Semaforizacion);
            $SemaforizacionValue = $collectionSemaforizacion->values();  //este el el valor

            // RespuestaID
            $respuestaID = $request->respuestaData;
            $collectionRespuesta = collect($respuestaID);
            $RespuestaValue = $collectionRespuesta->values();  //este el el valor

            $numeroDeRespuestas = count($collectionRespuesta);

            $respuestas = [];
            for ($i=0; $i < $numeroDeRespuestas; $i++) {
                $respuestas[$RespuestaValue[$i]] = $Respuestas[$i];
                $preguntaRespuesta = array();
                $preguntaRespuesta = new Tutorias_pregunta_respuestas();
                $preguntaRespuesta['Tipo'] = $Tipo[$i];
                $preguntaRespuesta['RespuestaID'] = $RespuestaValue[$i];
                $preguntaRespuesta['Respuesta'] = $Respuestas[$i];
                $preguntaRespuesta['PreguntaID'] = $PreguntaID[$i];
                $preguntaRespuesta['AlumnoID'] = $AlumnoID;
                $preguntaRespuesta['Porcentaje'] = 100;
                $preguntaRespuesta['Disponible'] = 0;
                $preguntaRespuesta['FormularioID'] = $FormularioID;
                $preguntaRespuesta['Parcial'] = $Parcial;
                $preguntaRespuesta['CarreraID'] = $CarreraID;
                $preguntaRespuesta['ClaveCarrera'] = $ClaveCarrera;
                $preguntaRespuesta['Carrera'] = $Carrera;
                $preguntaRespuesta['EscuelaID'] = $EscuelaID;
                $preguntaRespuesta['ClaveEscuela'] = $ClaveEscuela;
                $preguntaRespuesta['Escuela'] = $Escuela;
                $preguntaRespuesta['UniversidadID'] = $UniversidadID;
                $preguntaRespuesta['ClaveUniversidad'] = $ClaveUniversidad;
                $preguntaRespuesta['Universidad'] = $Universidad;
                $preguntaRespuesta['Semaforizacion'] = $SemaforizacionValue[$i];
                $preguntaRespuesta['CategoriaID'] = $CategoriaID[$i];
                $preguntaRespuesta['NombreCategoria'] = $NombreCategoria[$i];
                $preguntaRespuesta['DescripcionCategoria'] = $DescripcionCategoria[$i];

                $preguntaRespuesta->save();
            }

            $busca_formulario = Tutorias_formularios::findOrFail($FormularioID);
            if($busca_formulario->Tipo == 3){
                $this->enviarCorreoEncuestaInansistenciaCovid19($FormularioID, $AlumnoID, $respuestas);
            }

            alert('Escuela Modelo', 'La encuesta se guardo con éxito', 'success')->showConfirmButton();
            return back();
        }


        if($request->ACCION == "ACTUALIZAR"){



            // variables del request
            $Tipo = $request->Tipo;

            // respuestas
            $Respuesta = $request->Respuesta;
            $collectionRespuesta = collect($Respuesta);
            $Respuestas = $collectionRespuesta->values(); //este el el valor
            $PreguntaRespuestaID = $collectionRespuesta->keys();


            $AlumnoID = $request->AlumnoID;
            $FormularioID = $request->FormularioID;
            $CarreraID = $request->CarreraID;
            $ClaveCarrera = $request->ClaveCarrera;
            $Carrera = $request->Carrera;
            $EscuelaID = $request->EscuelaID;
            $ClaveEscuela = $request->ClaveEscuela;
            $Escuela = $request->Escuela;
            $UniversidadID = $request->UniversidadID;
            $ClaveUniversidad = $request->ClaveUniversidad;
            $Universidad = $request->Universidad;

            $CategoriaID = $request->CategoriaID;
            $NombreCategoria = $request->NombreCategoria;
            $DescripcionCategoria = $request->DescripcionCategoria;

            //SemaforizCION
            $Semaforizacion = $request->Semaforizacion;
            $collectionSemaforizacion = collect($Semaforizacion);
            $SemaforizacionValue = $collectionSemaforizacion->values();  //este el el valor

            // RespuestaID
            $respuestaID = $request->respuestaData;
            $collectionRespuesta = collect($respuestaID);
            $RespuestaValue = $collectionRespuesta->values();  //este el el valor

            for ($i = 0; $i < count($Respuestas);  $i++ ) {

                DB::table('tutorias_pregunta_respuestas')
                ->where('PreguntaRespuestaID', $PreguntaRespuestaID[$i])
                ->update([
                    'RespuestaID' => $RespuestaValue[$i],
                    'Respuesta' => $Respuestas[$i],
                    // 'CategoriaID' => $CategoriaID[$i],
                    // 'NombreCategoria' => $NombreCategoria[$i],
                    // 'DescripcionCategoria' => $DescripcionCategoria[$i],
                    'Semaforizacion' => $SemaforizacionValue[$i]

                ]);
            }
            // Actualizamos solo las preguntas con respuesta abierta 
            for($xx = 0; $xx < count($request->PreguntaID); $xx++){
                $tutRsp = Tutorias_respuestas::where('Nombre', '=', null)
               ->where('PreguntaID', '=', $request->PreguntaID[$xx])
               ->get();

               foreach ($tutRsp as $key => $value) {
                    // print_r("<br>".$value->RespuestaID. ' '.$value->PreguntaID);

                    DB::table('tutorias_pregunta_respuestas')
                    // ->where('PreguntaRespuestaID', $PreguntaRespuestaID)
                    ->where('PreguntaID', $value->PreguntaID)
                    ->update([
                        'RespuestaID' => $value->RespuestaID,
                        'Semaforizacion' => $value->Semaforizacion

                    ]);
               }               
           }
            alert('Escuela Modelo', 'La encuesta se guardo con éxito', 'success')->showConfirmButton();
            // return redirect('tutorias_encuestas/encuesta/'.$FormularioID.'/'.$AlumnoID);
            return back();
        }
    }

    public function enviarCorreoEncuestaInansistenciaCovid19($formularioId, $alumnoId, $respuestas)
	{
        $director = Tutorias_pregunta_respuestas::select('empleados.empCorreo1')
        ->join('escuelas', 'escuelas.id', '=', 'tutorias_pregunta_respuestas.EscuelaID')
        ->join('empleados', 'empleados.id', '=', 'escuelas.empleado_id')
        ->where('tutorias_pregunta_respuestas.FormularioID', $formularioId)
        ->where('tutorias_pregunta_respuestas.AlumnoID', $alumnoId)
        ->first();

        $coordinador = Tutorias_pregunta_respuestas::select('empleados.empCorreo1')
        ->join('programas', 'programas.id', '=', 'tutorias_pregunta_respuestas.CarreraID')
        ->join('empleados', 'empleados.id', '=', 'programas.empleado_id')
        ->where('tutorias_pregunta_respuestas.FormularioID', $formularioId)
        ->where('tutorias_pregunta_respuestas.AlumnoID', $alumnoId)
        ->first();

        $toMail = 'aosorio@modelo.edu.mx';
        if($director && $director->empCorreo1)
            $toMail = $director->empCorreo1;

        if (!preg_match('/(.*)@(modelo)[.](edu)[.](mx)$/', $director->empCorreo1)) {
            $toMail = 'aosorio@modelo.edu.mx';
        }

		$this->mail = new Mailer([
			'username_email' => 'inasistencias@modelo.edu.mx', // 'inasistencias@unimodelo.com',
			'password_email' => 'xNAQ9SWHtY', // 'CKbfWK9JT4',
			'to_email' => $toMail,
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'ENCUESTA DE SEGUIMIENTO Y EVOLUCIÓN DE COVID.',
			'body' => $this->armarMensajeEncuestaInasistenciaCovid19($formularioId, $alumnoId, $respuestas),
		]);

		if($coordinador && $coordinador->empCorreo1) {
            if (!preg_match('/(.*)@(modelo)[.](edu)[.](mx)$/', $director->empCorreo1)) {
                //
            } else {
                $this->mail->agregar_destinatario($coordinador->empCorreo1);
            }
        }
		$this->mail->enviar();
	}

	/**
	* @param App\Models\Baja
	*/
	public function armarMensajeEncuestaInasistenciaCovid19($formularioId, $alumnoId, $respuestas)
	{
        $alumno = Tutorias_pregunta_respuestas::join('tutorias_alumnos', 'tutorias_alumnos.AlumnoID', '=', 'tutorias_pregunta_respuestas.AlumnoID')
        ->join('alumnos', 'alumnos.id', '=', 'tutorias_alumnos.AlumnoIDSCEM')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('tutorias_pregunta_respuestas.FormularioID', $formularioId)->where('tutorias_pregunta_respuestas.AlumnoID', $alumnoId)->first();

        $preguntas = Tutorias_preguntas::where('FormularioID', $formularioId)->get();
        
        $nombreCompleto = $alumno->perNombre.' '.$alumno->perApellido1.' '.$alumno->perApellido2;

        $tutoriasRespuestas = [];
        foreach ($preguntas as $pregunta) {
            $tutoriasRespuestas[$pregunta->PreguntaID] = Tutorias_respuestas::select('Nombre', 'RespuestaID')->where('PreguntaID', $pregunta->PreguntaID)
            ->where(function($query) use ($respuestas) {
                foreach ($respuestas as $index => $respuesta) {
                    $query->orWhere('RespuestaID', $index);
                }
            })->get();
        }

        foreach ($tutoriasRespuestas as $res) {
            foreach ($res as $respuesta) {
                if (is_null($respuesta->Nombre)) {
                    // esta es la fecha
                    $created = new Carbon($respuestas[$respuesta->RespuestaID]);
                    $respuesta->Nombre = $created->format('d/m/Y');
                }
            }
        }

        return view('tutorias.encuestas.EncuestaInasistenciaCovid19',
            compact(
                'alumno',
                'preguntas',
                'tutoriasRespuestas',
                'nombreCompleto'
            )
        )
        ->render();
	}


    public function storeCovid(Request $request)
    {

        if($request->ACCION == "GUARDAR"){

            // variables del request
            $Tipo = $request->Tipo;

            // respuestas
            $Respuesta = $request->Respuesta;
            $collectionRespuesta = collect($Respuesta);
            $Respuestas = $collectionRespuesta->values(); //este el el valor
            $PreguntaID = $collectionRespuesta->keys();


            $AlumnoID = $request->AlumnoID;
            $FormularioID = $request->FormularioID;
            $Parcial = $request->Parcial;
            $CarreraID = $request->CarreraID;
            $ClaveCarrera = $request->ClaveCarrera;
            $Carrera = $request->Carrera;
            $EscuelaID = $request->EscuelaID;
            $ClaveEscuela = $request->ClaveEscuela;
            $Escuela = $request->Escuela;
            $UniversidadID = $request->UniversidadID;
            $ClaveUniversidad = $request->ClaveUniversidad;
            $Universidad = $request->Universidad;
            $CategoriaID = $request->CategoriaPreguntaID;
            $NombreCategoria = $request->NombreCategoria;
            $DescripcionCategoria = $request->DescripcionCategoria;

            //SemaforizCION
            $Semaforizacion = $request->Semaforizacion;
            $collectionSemaforizacion = collect($Semaforizacion);
            $SemaforizacionValue = $collectionSemaforizacion->values();  //este el el valor

            // RespuestaID
            $respuestaID = $request->respuestaData;
            $collectionRespuesta = collect($respuestaID);
            $RespuestaValue = $collectionRespuesta->values();  //este el el valor



            $numeroDeRespuestas = count($collectionRespuesta);



            for ($i=0; $i < $numeroDeRespuestas; $i++) {
                $preguntaRespuesta = array();
                $preguntaRespuesta = new Tutorias_pregunta_respuestas();
                $preguntaRespuesta['Tipo'] = 0;
                $preguntaRespuesta['RespuestaID'] = $RespuestaValue[$i];
                $preguntaRespuesta['Respuesta'] = $Respuestas[$i];
                $preguntaRespuesta['PreguntaID'] = 133; //SI
                $preguntaRespuesta['AlumnoID'] = $AlumnoID;
                $preguntaRespuesta['Porcentaje'] = 100;
                $preguntaRespuesta['Disponible'] = 0;
                $preguntaRespuesta['FormularioID'] = $FormularioID;
                $preguntaRespuesta['Parcial'] = $Parcial;
                $preguntaRespuesta['CarreraID'] = $CarreraID;
                $preguntaRespuesta['ClaveCarrera'] = $ClaveCarrera;
                $preguntaRespuesta['Carrera'] = $Carrera;
                $preguntaRespuesta['EscuelaID'] = $EscuelaID;
                $preguntaRespuesta['ClaveEscuela'] = $ClaveEscuela;
                $preguntaRespuesta['Escuela'] = $Escuela;
                $preguntaRespuesta['UniversidadID'] = $UniversidadID;
                $preguntaRespuesta['ClaveUniversidad'] = $ClaveUniversidad;
                $preguntaRespuesta['Universidad'] = $Universidad;
                $preguntaRespuesta['Semaforizacion'] = 0;
                $preguntaRespuesta['CategoriaID'] = $CategoriaID[$i];
                $preguntaRespuesta['NombreCategoria'] = $NombreCategoria[$i];
                $preguntaRespuesta['DescripcionCategoria'] = $DescripcionCategoria[$i];


                $preguntaRespuesta->save();
            }

            DB::statement('call procTutoriasActualizarDatosCorrespondientes'); 


            $busca_formulario = Tutorias_formularios::findOrFail($FormularioID);
            if($busca_formulario->Tipo == 3){
                // Aqui metes la función para el envio de correos 
                // tus parametros son: $FormularioID, $AlumnoID
            }

            alert('Escuela Modelo', 'La encuesta se guardo con éxito', 'success')->showConfirmButton();
            return back();
        }


    }
   

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $tutorias_preguntas = Tutorias_preguntas::select(
            'tutorias_preguntas.PreguntaID',
            'tutorias_preguntas.Nombre',
            'tutorias_categoria_preguntas.CategoriaPreguntaID',
            'tutorias_categoria_preguntas.Nombre AS NombrePregunta',
            'tutorias_preguntas.TipoRespuesta',
            'tutorias_formularios.FormularioID'
        )
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        // ->groupBy('tutorias_preguntas.CategoriaPreguntaID')
        ->where('tutorias_formularios.Eliminado', '=', 0)
        ->where('tutorias_preguntas.FormularioID', '=', $id)
        ->where('tutorias_preguntas.Estatus', '=', 1)
        ->get();

        $agrupar_categotia_preguntas = DB::table('tutorias_preguntas')
        ->select(DB::raw('count(*) as CategoriaPregunta_count, tutorias_preguntas.CategoriaPreguntaID, tutorias_categoria_preguntas.Nombre AS NombreCategoria'))
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->groupBy('CategoriaPreguntaID')
        // ->orderBy('NombreCategoria')
        ->where('tutorias_preguntas.FormularioID', '=', $id)
            ->get();

        $tutorias_respuesta_agrupada = DB::table('tutorias_respuestas')
        ->select(DB::raw('count(*) as PreguntaID_count, tutorias_respuestas.PreguntaID'))
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
       ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
       ->where('tutorias_preguntas.FormularioID', '=', $id)
       ->where('tutorias_preguntas.Estatus', '=', 1)
       ->where('tutorias_respuestas.estatus', '=', 'SI')
        ->groupBy('tutorias_respuestas.PreguntaID')
        ->get();


        $tutRespuestas = Tutorias_respuestas::select('tutorias_respuestas.RespuestaID', 'tutorias_respuestas.Nombre',
        'tutorias_respuestas.Tipo', 'tutorias_respuestas.Semaforizacion', 'tutorias_respuestas.PreguntaID', 'tutorias_preguntas.Nombre as NombrePrgunta',
        'tutorias_preguntas.CategoriaPreguntaID', 'tutorias_preguntas.FormularioID')
       ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
       ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
       ->where('tutorias_preguntas.FormularioID', '=', $id)
       ->where('tutorias_preguntas.Estatus', '=', 1)
       ->where('tutorias_respuestas.estatus', '=', 'SI')
       ->get();


        $tutorias_opciones = Tutorias_opciones::get();

        return view('tutorias.alumnos.encuesta', [
            'tutorias_preguntas' => $tutorias_preguntas,
            'agrupar_categotia_preguntas' => $agrupar_categotia_preguntas,
            'tutorias_respuesta_agrupada' => $tutorias_respuesta_agrupada,
            'tutRespuestas' => $tutRespuestas,
            'id' => $id,
            'tutorias_opciones' => $tutorias_opciones
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

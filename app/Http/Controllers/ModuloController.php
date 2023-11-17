<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;

use App\Models\Modules;

class ModuloController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Schema::disableForeignKeyConstraints();
        Modules::truncate();
        Schema::enableForeignKeyConstraints();


        //SE DEBE RESPETAR EL ORDEN EN EL QUE SE ENCUENTRA, SI SE CAMBIA SE PIERDEN LOS IDS CON LOS PERMISOS

        //LOS NUEVOS PERMISOS PASAN AL FINAL DE LA LISTA
        
        Modules::create([
            'name'        => 'Usuarios',
            'slug'        => 'usuario',
            'class' => 'Administración',
        ]);
        Modules::create([
            'name'        => 'Campus',
            'slug'        => 'ubicacion',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Departamentos',
            'slug'        => 'departamento',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Escuelas',
            'slug'        => 'escuela',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Programas',
            'slug'        => 'programa',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Planes',
            'slug'        => 'plan',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Periodos',
            'slug'        => 'periodo',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Acuerdos',
            'slug'        => 'acuerdo',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Materias',
            'slug'        => 'materia',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Optativas',
            'slug'        => 'optativa',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Aulas',
            'slug'        => 'aula',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Paises',
            'slug'        => 'pais',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Estados',
            'slug'        => 'estado',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Municipios',
            'slug'        => 'municipio',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Profesion',
            'slug'        => 'profesion',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Abreviatura',
            'slug'        => 'abreviatura',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Clave Profesor',
            'slug'        => 'clave_profesor',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Empleados',
            'slug'        => 'empleado',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Alumnos',
            'slug'        => 'alumno',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'CGTS',
            'slug'        => 'cgt',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Grupos',
            'slug'        => 'grupo',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Calificaciones',
            'slug'        => 'calificacion',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Paquetes',
            'slug'        => 'paquete',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Preinscritos',
            'slug'        => 'curso',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Inscritos',
            'slug'        => 'inscrito',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Extraordinarios',
            'slug'        => 'extraordinario',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Matricula Anterior',
            'slug'        => 'matricula_anterior',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Escolaridad',
            'slug'        => 'escolaridad',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Solicitud Extraordinario',
            'slug'        => 'solicitud_extraordinario',
            'class' => 'ControlEscolar',
        ]);
        Modules::create([
            'name'        => 'Tarjeta de pago',
            'slug'        => 'r_tarjeta_pago',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Reporte inscritos y preinscritos',
            'slug'        => 'r_inscrito_preinscrito',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Lista de asistencia por grupo',
            'slug'        => 'r_asistencia_grupo',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Reporte de plantilla de profesores',
            'slug'        => 'r_plantilla_profesores',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Reporte de actas pendientes',
            'slug'        => 'r_actas_pendientes',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Reporte de alumnos becados',
            'slug'        => 'r_alumnos_becados',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Reporte de grupo por semestre',
            'slug'        => 'r_grupo_semestre',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name'        => 'Constancia de inscripción',
            'slug'        => 'r_constancia_inscripcion',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Reporte de planes de estudio',
            'slug'        => 'r_planes_estudio',
            'class' => 'Reportes',
        ]);
        Modules::create([
            'name'        => 'Aplica Pagos',
            'slug'        => 'p_pago',
            'class' => 'Procesos',
        ]);
        Modules::create([
            'name'        => 'Archivo Grupo',
            'slug'        => 'a_grupo',
            'class' => 'Archivos',
        ]);
        Modules::create([
            'name'        => 'Archivo Inscripción',
            'slug'        => 'a_inscripcion',
            'class' => 'Archivos',
        ]);
        Modules::create([
            'name'        => 'Archivo Ordinario',
            'slug'        => 'a_ordinario',
            'class' => 'Archivos',
        ]);
        Modules::create([
            'name'        => 'Archivo Extraordinario',
            'slug'        => 'a_extraordinario',
            'class' => 'Archivos',
        ]);

        Modules::create([
            'name'        => 'Archivo2 Extraordinario2',
            'slug'        => 'a_extraordinario2',
            'class'       => 'Reportes',
        ]);

        Modules::create([
            'name'        => 'Beca',
            'slug'        => 'beca',
            'class' => 'Catálogos',
        ]);

        Modules::create([
            'name'        => 'Horarios Administrativos',
            'slug'        => 'horarios_administrativos',
            'class' => 'ControlEscolar',
        ]);


        Modules::create([
            'name'        => 'Historico',
            'slug'        => 'historico',
            'class' => 'Administración',
        ]);
        Modules::create([
            'name'  => 'R istro',
            'slug'  => 'registro',
            'class' => 'Catálogos', 
        ]);

        Modules::create([
            'name'  => 'Candidato',      //modulo error, no borrar
            'slug'  => 'candidato',
            'class' => 'ControlEscolar', 
        ]);
        

        Modules::create([
            'name'  => 'CandidatosPrimerIngreso',
            'slug'  => 'CandidatosPrimerIngreso',
            'class' => 'ControlEscolar', 
        ]);

        
        Modules::create([
            'name'  => 'calendarioexamen',      
            'slug'  => 'calendarioexamen',
            'class' => 'ControlEscolar', 
        ]);

        Modules::create([
            'name'  => 'cambiar_contrasena',      
            'slug'  => 'cambiar_contrasena',
            'class' => 'ControlEscolar', 
        ]);

        Modules::create([
            'name'  => 'servicio_social',      
            'slug'  => 'servicio_social',
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name'  => 'Programas Educacion Continua',      
            'slug'  => 'prog_educacion_continua',
            'class' => 'EducacionContinua',
        ]);

        Modules::create([
            'name'  => 'Tipos Programas Educacion Continua',      
            'slug'  => 'tipos_prog_edu_continua',
            'class' => 'EducacionContinua',
        ]);
        Modules::create([
            'name'  => 'Inscritos Educacion Continua',      
            'slug'  => 'inscritos_edu_continua',
            'class' => 'EducacionContinua',
        ]);

        Modules::create([
            'name'  => 'Relación Educacion Continua',      
            'slug'  => 'relacion_edu_continua',
            'class' => 'EducacionContinua',
        ]);
        
        Modules::create([
            'name'  => 'Relación Pagos Educacion Continua',      
            'slug'  => 'rel_pagos_edu_continua',
            'class' => 'EducacionContinua',
        ]);
        
        Modules::create([
            'name'  => 'Relación Alumnos Educacion Continua',      
            'slug'  => 'rel_alu_prog_edu_continua',
            'class' => 'EducacionContinua',
        ]);

        Modules::create([
            'name' => 'Egresados',
            'slug' => 'egresados', 
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name' => 'Recordatorio de pagos',
            'slug' => 'recordatorioPagos',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Registro de cuotas',
            'slug' => 'registro_cuotas',
            'class' => 'Pagos',
        ]);

        Modules::create([
            'name' => 'Preinscripción automática',
            'slug' => 'preinscripcion_automatica',
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name' => 'Conteo de Empleados',
            'slug' => 'conteo_empleados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Relacion Inscritos Primero',
            'slug' => 'relacion_inscritos_primero',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Fichas Incorrectas Educación Continua',
            'slug' => 'fichas_incorrectas_edu_continua',
            'class' => 'EducacionContinua',
        ]);

        Modules::create([
            'name' => 'Resumen de inscritos y preinscritos',
            'slug' => 'resumen_inscritos_preinscritos',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Fichas de Cobranza',
            'slug' => 'fichas_de_cobranza',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Fichas Generales',
            'slug' => 'fichas_generales',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Listas por tipo de ingreso',
            'slug' => 'lista_por_tipo_ingreso',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Resumen de Antigüedad',
            'slug' => 'resumen_antiguedad',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Puestos',
            'slug' => 'puestos',
            'class' => 'Catálogos',
        ]);

        Modules::create([
            'name' => 'Alumnos de último grado',
            'slug' => 'alumnos_ultimo_grado',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Cuotas Registradas',
            'slug' => 'cuotas_registradas',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Becas con Observaciones',
            'slug' => 'becas_con_observaciones',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Resúmenes Académicos',
            'slug' => 'resumen_academico',
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name' => 'Menú Servicios Externos',
            'slug' => 'servicios_externos',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Hurra Alumnos',
            'slug' => 'hurra_alumnos',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Hurra Maestros',
            'slug' => 'hurra_maestros',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Hurra Ordinarios',
            'slug' => 'hurra_ordinarios',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Hurra Horarios',
            'slug' => 'hurra_horarios',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Hurra Calificaciones',
            'slug' => 'hurra_calificaciones',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Alumnos Encuestados',
            'slug' => 'alumnos_encuestados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Revalidaciones',
            'slug' => 'revalidaciones',
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name' => 'Resumen Alumnos Encuestados',
            'slug' => 'resumen_alumnos_encuestados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Resumen Docentes Encuestados',
            'slug' => 'resumen_docentes_encuestados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Docentes Encuestados',
            'slug' => 'docentes_encuestados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Hurra Extraordinarios',
            'slug' => 'hurra_extraordinarios',
            'class' => 'ServiciosExternos',
        ]);

        Modules::create([
            'name' => 'Deudores Económico Académico',
            'slug' => 'deudores_economico_academico',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Alumnos Regulares Sin Curso',
            'slug' => 'alumnos_regulares_sin_curso',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Preinscritos Extraordinarios',
            'slug' => 'preinscrito_extraordinario',
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name' => 'Menú Reportes Extraordinarios',
            'slug' => 'menu_reportes_extraordinarios',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Resumen de Inscritos a Extraordinario',
            'slug' => 'resumen_inscritos_extraordinario',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Lista de Servicio Social',
            'slug' => 'lista_servicio_social',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Cambiar CGT',
            'slug' => 'cambiar_cgt',
            'class' => 'ControlEscolar',
        ]);

        Modules::create([
            'name' => 'Alumnos Reprobados por Parciales',
            'slug' => 'alumnos_reprobados_parciales',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Directorio de Empleados',
            'slug' => 'directorio_empleados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Relación de Pagos Completos',
            'slug' => 'relacion_pagos_completos',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Conteo de Servicio Social',
            'slug' => 'conteo_servicio_social',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Reportes Tutorías',
            'slug' => 'reportes_tutorias',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Historico Matricula',
            'slug' => 'historico_matricula',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'CIBIES Nuevo Ingreso',
            'slug' => 'cibies_nuevo_ingreso',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'CIBIES Reincorporados',
            'slug' => 'cibies_reincorporados',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'CIBIES Docentes',
            'slug' => 'cibies_docentes',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'CIBIES Administrativos',
            'slug' => 'cibies_administrativos',
            'class' => 'Reportes',
        ]);

        Modules::create([
            'name' => 'Horarios Personales Excel',
            'slug' => 'horarios_personales_excel',
            'class' => 'Reportes',
        ]);


        
        alert('Escuela Modelo', 'Módulos creados correctamente','success')->showConfirmButton()->autoClose(3000);
        return redirect('usuario');
    }

}
@if (Auth::user()->primaria == 1)


    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    @if (Auth::user()->departamento_sistemas == 1)

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Primaria</span>
            </a>
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI Catálogos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                {{--  programas   --}}
                                <li>
                                    <a href="{{ route('primaria.primaria_programa.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Programas</span>
                                    </a>
                                </li>

                                {{--  planes   --}}
                                <li>
                                    <a href="{{ route('primaria.primaria_plan.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Planes</span>
                                    </a>
                                </li>

                                {{--  periodos   --}}
                                <li>
                                    <a href="{{ route('primaria.primaria_periodo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Períodos</span>
                                    </a>
                                </li>

                                {{--  materias   --}}
                                <li>
                                    <a href="{{ route('primaria.primaria_materia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('primaria.primaria_materias_asignaturas.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias Asignaturas</span>
                                    </a>
                                </li>

                                {{--  cgts   --}}
                                <li>
                                    <a href="{{route('primaria.primaria_cgt.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CGT</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_categoria_contenido.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Perf. Cat. Contenidos  </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_calificador.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Perf. Calificadores  </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_contenido_fundamental.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Perf. Contenidos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria.primaria_migrar_inscritos_acd.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Migrar Inscritos ACD</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI C.Escolar</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ route('primaria_alumno.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('primaria_curso.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Preinscritos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria_asignar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Asignar CGT</span>
                                    </a>
                                </li>
                                {{--  cambiar CGT   --}}
                                <li>
                                    <a href="{{route('primaria.primaria_cambiar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambiar CGT</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria.primaria_materias_inscrito.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cargar Materias a Inscrito</span>
                                    </a>
                                </li>
                                {{--  CGT Materias  --}}
                                <li>
                                    <a href="{{route('primaria.primaria_cgt_materias.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CGT Materias</span>
                                    </a>
                                </li>
                                {{-- Asignar Docente Presencial  --}}
                                <li>
                                    <a href="{{route('primaria.primaria.primaria_asignar_docente_presencial.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Docente Presencial Gpo.</span>
                                    </a>
                                </li>
                                {{-- Asignar Docente Virtual  --}}
                                <li>
                                    <a href="{{route('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Docente Virtual Gpo.</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('primaria_grupo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Grupos</span>
                                    </a>
                                </li>
                                {{-- Cambio de Programa --}}
                                <li>
                                    <a href="{{route('primaria.primaria.primaria_cambio_programa.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambio de Programa</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria.primaria.primaria_inscrito_modalidad.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscrito Modalidad</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_docente_inscrito_modalidad.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Docente Inscrito Modalidad</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('primaria_asignar_grupo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscritos Grupos</span>
                                    </a>
                                </li>
                                {{--  observaciones calificaciones   --}}
                                <li>
                                    <a href="{{route('primaria.primaria.primaria_obs_boleta.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Obs. boleta</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria.primaria_horarios_libres.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Horarios libres</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria.primaria_fecha_publicacion_calificacion_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fecha Calif. Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_fecha_publicacion_calificacion_alumno.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fecha Calif. Alumnos</span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="{{route('primaria.primaria_calificacion_general.viewCalificacionGeneral')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Modificar Boleta</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_generar_promedios.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Generar promedio</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI Expediente</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{route('primaria.primaria_entrevista_inicial.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>  Entrevista Inicial </span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="{{route('primaria.primaria_perfil.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>  Perfiles  </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('primaria.primaria_seguimiento_escolar.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>  Seguimiento escolar  </span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="#">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>  Ficha técnica  </span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('primaria_calendario.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Agenda</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('primaria.primaria_alumnos_excel') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos Excel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI Docentes</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ route('primaria_empleado.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Empleados</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('primaria.primaria_cambiar_contrasenia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Acceso de Docente</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('primaria_calendario.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Agenda</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{route('primaria.primaria_planeacion_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Planeación</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('primaria.primaria_ahorro_escolar.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ahorro escolar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{--  Act. ExtraEscolares  --}}
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI -Act. ExtraEscolares</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ route('universidad.universidad_actividades.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Actividades (Grupos)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('universidad.universidad_nuevo_externo.create') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Nuevo Externo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('universidad.universidad_actividades_inscritos.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscritos Actividades</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('empleado') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Instructores (Empleados)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI Pagos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('pagos/ficha_general') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ficha general</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('primaria/pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos Manuales</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">PRI Reportes</span>
                        </a>
                        <div class="collapsible-body">
                            <ul class="collapsible" data-collapsible="accordion">
                                {{-- Alumnos --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Alumnos</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ route('primaria_inscrito_preinscrito.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Inscritos y preinscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/primaria_resumen_inscritos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen inscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria.primaria_lista_edades.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de edades</span>
                                                </a>
                                            </li>
                                            {{--  Expediente de alumnos   --}}
                                            <li>
                                                <a href="{{ route('primaria_reporte.expediente_alumnos.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Expediente de alumnos</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.primaria_estatus_preescolar.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Estudiaron Preescolar</span>
                                                </a>
                                            </li>
                                            {{--  Ficha técnica  --}}
                                            <li>
                                                <a href="{{ route('primaria_reporte.ficha_tecnica.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Ficha técnica</span>
                                                </a>
                                            </li>
                                            {{--  Reporte de alumnos becados   --}}
                                            <li>
                                                <a href="{{ route('primaria_reporte.primaria_alumnos_becados.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. alumnos becados</span>
                                                </a>
                                            </li>
                                            {{-- Relación de Bajas --}}
                                            <li>
                                                <a href="{{ route('primaria.primaria_relacion_bajas_periodo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. de bajas</span>
                                                </a>
                                            </li>
                                            {{-- Perfiles de Bajas --}}
                                            <li>
                                                <a href="{{ route('primaria.primaria_perfil_alumno.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Perfiles</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria.reporte.ahorro_escolar.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Ahorro</span>
                                                </a>
                                            </li>
                                            {{-- Rel. de Familia/Tutores --}}
                                            <li>
                                                <a href="{{ route('primaria.primaria_relacion_tutores.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. de Familia/Tutores</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria.primaria_datos_completos_alumno.reporteAlumnos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Datos Completos de Alumno</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista Presencial-Virtual</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.primaria_inscritos_sexo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen inscritos sexo</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{--  Constancias   --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Constancias</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ route('primaria_reporte.constancia_cupo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Cupo</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria_reporte.constancia_estudio.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Estudio</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria_reporte.no_adeudo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>No Adeudo</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.primaria_buena_conducta.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Buena conducta</span>
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a href="{{ route('primaria_reporte.constancia_pasaporte.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Pasaporte</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                {{-- Calificaciones --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Calificaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {{--  Calificaciones de grupo  --}}
                                            <li>
                                                <a href="{{ route('primaria_reporte.calificaciones_grupo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. por grupo</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria_reporte.calificacion_por_materia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. por materia</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria_calificacion_materia_ingles.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. de Inglés</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria.primaria_boleta_de_calificaciones.reporteBoleta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Boleta</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('primaria.primaria_boleta_de_calificaciones_acd.reporteBoleta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Boleta ACD</span>
                                                </a>
                                            </li>
                                            {{-- Historial Académico del Alumno --}}
                                            <li>
                                                <a href="{{ route('primaria.primaria_historial_alumno.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Historial académico del alumno</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria_reporte.calificaciones_faltantes.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones faltantes</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.primaria_mejores_promedios.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Mejores Promedios</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                {{--  Docentes  --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Docentes</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {{--  Rel maestros escuela  --}}
                                            <li>
                                                <a href="{{ route('primaria_relacion_maestros_escuela.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Grupos Maestros</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria_reporte.relacion_maestros_acd.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Grupos ACD</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.reporte.planeacion_docente.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Planeación</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                {{--  Grupos   --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Grupos</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {{--  lista de asistencia   --}}
                                            {{--  <li>
                                                <a href="{{ route('primaria_reporte.lista_de_asistencia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia</span>
                                                </a>
                                            </li>  --}}
                                             {{--  lista de asistencia   --}}
                                             <li>
                                                <a href="{{ route('primaria.primaria_asistencia_grupo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Asistencia por grupo</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.primaria_grupo_materia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Asistencia por materia</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('primaria.primaria_faltas.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Faltas Alumno</span>
                                                </a>
                                            </li>
                                            
                                            {{--  lista de asistencia ACD  --}}
                                            <li>
                                                <a href="{{route('primaria_reporte.lista_de_asistencia_ACD.reporteACD')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia ACD</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- Pagos --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Pagos</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/primaria_relacion_deudas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Deudas de un Alumno</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/primaria_relacion_deudores') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Relación de Deudores</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </li>








    @endif

@endif

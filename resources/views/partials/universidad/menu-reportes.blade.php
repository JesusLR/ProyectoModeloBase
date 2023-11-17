@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Univ.Reportes</span>
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
                                <a href="{{ url('reporte/historico_inscripciones') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Historico inscripciones</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/primer_ingreso') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Primer ingreso</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/inscrito_preinscrito') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Inscritos y preinscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/asistencia_grupo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Asistencia por grupo</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/grupo_materia') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Asistencia por materia</span>
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin('conteo_servicio_social'))
                                <li>
                                    <a href="{{ url('reporte/conteo_servicio_social') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Conteo de servicio social</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('lista_servicio_social'))
                                <li>
                                    <a href="{{ url('reporte/lista_servicio_social') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Lista de servicio social</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('reporte/materias_adeudadas_alumnos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Materias adeudadas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_alumnos_matriculas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. alumnos matriculas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/alumnos_becados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. alumnos becados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_datos_generales') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. datos generales</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_deudores') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. alumnos deudores</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/alumnos_foraneos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. foráneos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_pos_bajas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. posibles bajas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/servicio_social') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. servicio social</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/resumen_grupos_alumno') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen grupos alumno</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('reporte/alumnos_asistentes') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. alumnos asistentes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/inscritos_sexo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen inscritos sexo</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/posibles_hermanos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. posibles hermanos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_cumple_alumnos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. cumpleaños alumnos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/res_antiguedad_preinscritos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Res. Antigüedad Preinscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/res_alumnos_no_inscritos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Res. Alumnos no Inscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_bajas_periodo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. Bajas por periodo</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_alumnos_reprobados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. Alumnos Reprobados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_correos_alumnos_padres') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. Correos de Alumnos/Padres</span>
                                </a>
                            </li>
                            @if(in_array(Auth::user()->permiso("recordatorioPagos"), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/recordatorio_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Recordatorio de pagos</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('relacion_inscritos_primero'), ['A', 'B']))
                                <li>
                                    <a href="{{ url('reporte/relacion_inscritos_primero') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Rel. Inscritos de primero</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('lista_por_tipo_ingreso'), ['A', 'B']))
                                <li>
                                    <a href="{{ url('reporte/lista_por_tipo_ingreso') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Lista por tipo ingreso</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('alumnos_ultimo_grado'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/alumnos_ultimo_grado') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos de último grado</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('alumnos_encuestados'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/alumnos_encuestados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos Encuestados</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('resumen_alumnos_encuestados'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/resumen_alumnos_encuestados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen Alumnos Encuestados</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('deudores_economico_academico'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/deudores_economico_academico') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Deudores Económico Académico</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('alumnos_regulares_sin_curso'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/alumnos_regulares_sin_curso') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos Regulares Sin Curso</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('alumnos_reprobados_parciales'))
                                <li>
                                    <a href="{{ url('reporte/alumnos_reprobados_parciales') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Reprobados por parciales</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                {{-- Acreditaciones --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Acreditaciones</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/historicos_por_escuela') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Históricos por escuela</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/lista_cursos_egresos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Lista de cursos y egresos</span>
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
                            <li>
                                <a href="{{ url('reporte/actas_pendientes') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Actas pendientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/boleta_calificaciones') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Boleta de Calificaciones</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/historial_alumno') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Historial académico de alumno</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/kardex_academico') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Kardex Académico</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/mejores_promedios') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Mejores Promedios</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/mejor_promedio_total') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Mejor Promedio Total</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/indice_reprobacion') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Indice de reprobación</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/porcentaje_aprobacion') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Porcentaje de aprobación</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/acta_extraordinario') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Acta de examen extraordinario</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/acta_examen_ordinario') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Acta de examen ordinario</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/resumen_cal_grupos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen calificación por grupos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/resumen_promedios') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen promedios</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/acreditaciones') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Desempeño Académico</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Constancias --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Constancias</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/buena_conducta') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Buena conducta</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/calificacion_final') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Calificaciones finales</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/calificacion_carrera') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Calificaciones completa</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/calificacion_parcial') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Calificaciones parciales</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/constancia_inscripcion') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Inscripción</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/solicitud_beca') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Solicitud de beca</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/certificado_completo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Certificado completo</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                {{-- Cursos --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Cursos</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/aulas_escuela') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Aulas por escuela</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/aulas_ocupadas_escuela') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Aulas ocupadas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/carga_alumnos_aula') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Carga de alumnos por aula</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/grupo_semestre') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Grupos por semestre</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/materias_plan') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Materias por plan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/optativas_periodo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Optativas por período</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/ocupacion_de_aula') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Ocupación de Aulas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_cambios_carrera') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. Cambios de Carrera</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_cgt') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. de CGTs</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_grupos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. de grupos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/planes_estudio') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. planes estudio</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_grupos_equivalentes') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. grupos equivalentes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/horario_por_grupo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Horario de clases</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/resumen_escuelas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Res. Escuelas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Docentes --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Docentes</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/carga_grupos_maestro') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Carga grupos por maestro</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/cumple_empleados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Cumpleaños de empleados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/horario_personal_maestros') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Horarios personal maestro</span>
                                </a>
                            </li>
                            @if(in_array(auth()->user()->permiso('horarios_personales_excel'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/horarios_personales_excel') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Horarios personales excel</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('reporte/horarios_administrativos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Horarios Administrativos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/plantilla_profesores') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Plantilla de profesores</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_maestros_escuela') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. maestros escuela</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/constancia_docente') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Constancia Docente</span>
                                </a>
                            </li>
                            @if(in_array(auth()->user()->permiso('conteo_empleados'), ['A', 'B']))
                                <li>
                                    <a href="{{ url('reporte/conteo_empleados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Conteo de Empleados</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('resumen_docentes_encuestados'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/resumen_docentes_encuestados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen Docentes Encuestados</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('docentes_encuestados'))
                                <li>
                                    <a href="{{ url('reporte/docentes_encuestados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Docentes Encuestados</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('directorio_empleados'), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/directorio_empleados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Directorio de empleados</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
                {{-- Direccion --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Dirección</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/relacion_nuevo_ingreso_exani') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. nuevo ingreso</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_candidatos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rel. candidatos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Egresados --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Egresados</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/rel_pos_egresados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Posibles egresados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/rel_egresados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Relación egresados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/res_egresados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen egresados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/resumen_egresados_excel') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen egresados (Excel)</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/resumen_titulados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen titulados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/titulados_pasantes') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Titulados y pasantes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/total_egresados_tit') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Total egresados y titulados</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Evaluaciones --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Evaluaciones</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/calendario_examenes_ordinarios') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Calendario exa. ordinarios</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/listas_evaluacion_parcial') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Listas evaluación parcial</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/listas_evaluacion_ordinaria') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Listas evaluación ordinaria</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/programacion_examenes') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Programación de exa. extraordinarios</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/numero_examenes') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Número de exámenes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/validar_fechas_ordinarios') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Validación de fechas de Ordinarios</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Extraordinarios --}}
                @if(in_array(auth()->user()->permiso('menu_reportes_extraordinarios'), ['A', 'B', 'C']))
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">Extraordinarios</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('reporte/relacion_inscritos_extraordinario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Relación de Inscritos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/relacion_solicitudes_extraordinario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Relación de Solicitudes</span>
                                    </a>
                                </li>
                                @if(in_array(auth()->user()->permiso('resumen_inscritos_extraordinario'), ['A', 'B', 'C']))
                                    <li>
                                        <a href="{{ url('reporte/resumen_inscritos_extraordinario') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Resumen de Inscritos</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- Pagos --}}
                @if (Auth::user()->username == "DESARROLLO"
                    || Auth::user()->username == "GASTON"
                    || Auth::user()->username == "LLARA"
                    || Auth::user()->username == "RAVILA"
                    || Auth::user()->username == "FLOPEZH"
                    || Auth::user()->username == "EAIL"
                    || Auth::user()->username == "MCUEVAS"
                    || Auth::user()->username == "SRIVERO"
                    || Auth::user()->username == "NLOPEZ"
                    || Auth::user()->username == "MARIANAT"
                    || Auth::user()->username == "MERCEDES"
                    || Auth::user()->username == "MCARRILLO"
                    || Auth::user()->username == "HRIVAS"
                    || Auth::user()->username == "CESAURI"
                    || Auth::user()->username == "MARTHA"
                    || Auth::user()->username == "DENISECG")
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">Pagos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                @if (Auth::user()->username == "DESARROLLO"
                                || Auth::user()->username == "GASTON"
                                || Auth::user()->username == "LLARA"
                                || Auth::user()->username == "FLOPEZH"
                                || Auth::user()->username == "EAIL"
                                || Auth::user()->username == "MCUEVAS"
                                || Auth::user()->username == "SRIVERO"
                                || Auth::user()->username == "MARIANAT"
                                || Auth::user()->username == "MCARRILLO"
                                || Auth::user()->username == "NLOPEZ"
                                || Auth::user()->username == "MERCEDES"
                                || Auth::user()->username == "HRIVAS"
                                || Auth::user()->username == "CESAURI"
                                || Auth::user()->username == "MARTHA"
                                || Auth::user()->username == "DENISECG")
                                    <li>
                                        <a href="{{ url('reporte/relacion_deudas') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Deudas de un Alumno</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reporte/alumnos_sin_renovacion_beca') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos sin renovacion de beca</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reporte/becas_campus_carrera_escuela') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Montos de Becas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reporte/movimiento_becas') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Movimiento de Becas</span>
                                        </a>
                                    </li>
                                    <li>
                                        @if (Auth::user()->username != "MCUEVAS" 
                                        || Auth::user()->username != "SRIVERO"
                                        || Auth::user()->username != "HRIVAS"
                                        || Auth::user()->username != "DENISECG")
                                            <a href="{{ url('reporte/colegiaturas') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Pagos de Colegiaturas</span>
                                            </a>
                                        @endif
                                    </li>
                                    <li>
                                        <a href="{{ url('reporte/relacion_deudores') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Relación de Deudores</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reporte/relacion_deudores_pagos_anuales') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Pagos Recibidos</span>
                                        </a>
                                    </li>
                                @endif

                                {{--
                                @if (Auth::user()->username == "DESARROLLO"
                                    || Auth::user()->username == "RAVILA"
                                    || Auth::user()->username == "FLOPEZH"
                                    || Auth::user()->username == "CESAURI"
                                    || Auth::user()->username == "EAIL"
                                    || Auth::user()->username == "DENISECG"
                                    || Auth::user()->username == "JPEREIRA"
                                    || Auth::user()->username == "MCUEVAS"
                                    || Auth::user()->username == "MCUEVAS"
                                    || Auth::user()->username == "HRIVAS")
                                    <li>
                                        <a href="{{ url('reporte/tarjetas_pago_alumnos') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Tarjetas de pago</span>
                                        </a>
                                    </li>
                                @endif
                                --}}
                                
                                <li>
                                    <a href="{{ url('reporte/estado_cuenta') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Estado de Cuenta</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/relacion_condicionados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Rel. Condicionados</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/rel_pagos_capturados_usuario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos capturados por usuario</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/pagos_duplicados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos duplicados</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/historial_pagos_alumno') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Historial de Pagos de Alumno</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/pagos_errores_al_aplicar') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Errores al aplicar</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/deudores_curso_anterior') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Deudores Curso Anterior</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/resumen_pronto_pago') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen Pronto Pago</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('reporte/cambio_plan_pago') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambios de plan de pago</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ url('reporte/recordatorio_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Recordatorio de pagos</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ url('reporte/resumen_deudores') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen Deudores</span>
                                    </a>
                                </li>
                                @if(auth()->user()->isAdmin('fichas_de_cobranza'))
                                    <li>
                                        <a href="{{ url('reporte/fichas_de_cobranza') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Fichas de Cobranza</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->isAdmin('fichas_generales'))
                                    <li>
                                        <a href="{{ url('reporte/fichas_generales') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Fichas generales</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->isAdmin('cuotas_registradas'))
                                    <li>
                                        <a href="{{ url('reporte/cuotas_registradas') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Cuotas Registradas</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->isAdmin('becas_con_observaciones'))
                                    <li>
                                        <a href="{{ url('reporte/becas_con_observaciones') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Becas con Observaciones</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->isAdmin('relacion_pagos_completos'))
                                    <li>
                                        <a href="{{ url('reporte/relacion_pagos_año_completos') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Relación de Pagos Completos</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('reporte/listas_pagos_lagunas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Lista pagos lagunas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- Segey --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">SEGEY</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte/segey/registro_alumnos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Registro de alumnos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Estadísticas</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            @if(auth()->user()->isAdmin('cibies_administrativos'))
                                <li>
                                    <a href="{{ url('reporte/cibies_administrativos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CIBIES Administrativos</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('cibies_docentes'))
                                <li>
                                    <a href="{{ url('reporte/cibies_docentes') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CIBIES Docentes</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('historico_matricula'))
                                <li>
                                    <a href="{{ url('reporte/historico_matricula') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CIBIES Historico Matrícula</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('cibies_nuevo_ingreso'))
                                <li>
                                    <a href="{{ url('reporte/cibies_nuevo_ingreso') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CIBIES Nuevo Ingreso</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin('cibies_reincorporados'))
                                <li>
                                    <a href="{{ url('reporte/cibies_reincorporados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CIBIES Reincorporados</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('reporte/resumen_inscritos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen inscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/listas_para_estadisticas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Listas de alumnos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/estadistica_estatal_educacion_continua') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Estatales de Educacion Continua</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/estadistica_estatal_licenciatura') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Estatales de Licenciatura</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/estadistica_estatal_maestros') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Estatales de Maestros</span>
                                </a>
                            </li>
                            @if(in_array(auth()->user()->permiso('resumen_inscritos_preinscritos'), ['A', 'B']))
                                <li>
                                    <a href="{{ url('reporte/resumen_inscritos_preinscritos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen de inscritos y preinscritos</span>
                                    </a>
                                </li>
                            @endif
                            @if(in_array(auth()->user()->permiso('resumen_antiguedad'), ['A', 'B']))
                                <li>
                                    <a href="{{ url('reporte/resumen_antiguedad') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen de Antigüedad</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                {{-- Tutorías --}}
                @if(auth()->user()->isAdmin('reportes_tutorias'))
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">Tutorías</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('reporte/tutorias/reporte_por_tipo_respuesta') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Reporte por tipo de respuesta</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/tutorias/alumnos_faltantes_encuesta') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos Faltantes Encuesta</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </li>

@endif

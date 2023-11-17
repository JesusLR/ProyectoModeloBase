@if (Auth::user()->bachiller == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1
            || $userClave == "JIMENARIVERO")

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">BAC. Reportes</span>
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
                                        <a href="{{ route('bachiller_inscrito_preinscrito.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Inscritos y preinscritos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_resumen_inscritos.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Resumen inscritos</span>
                                        </a>
                                    </li>
                                    {{--  Expediente de alumnos   --}}
                                    {{--  <li>
                                        <a href="{{ route('bachiller_reporte.expediente_alumnos.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Expediente de alumnos</span>
                                        </a>
                                    </li>  --}}
                                    {{--  Reporte de alumnos becados   --}}
                                    <li>
                                        <a href="{{ route('bachiller_reporte.bachiller_alumnos_becados.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Rel. alumnos becados</span>
                                        </a>
                                    </li>
                                    {{--  Relación de Padres de Familia   --}}
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_relacion_bajas_periodo.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Rel. de Bajas</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_alumnos_excel.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos (Excel)</span>
                                        </a>
                                    </li>

                                    {{--  Relación de alumnos deudores   --}}
                                    @if ($userClave == "ANDREA" || $userClave == 'MCARRILLO')
                                        <li>
                                            <a href="{{ url('reporte/bachiller_relacion_deudores') }}">
                                                <!-- pendiente -->
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Relación de Deudores</span>
                                            </a>
                                        </li>
                                    @endif

                                    {{--  <li>
                                        <a href="{{ route('bachiller.bachiller_lealtad_alumnos.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos Leales</span>
                                        </a>
                                    </li>  --}}
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_historico_inscripciones.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Historico Inscripciones</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_escuela_procedencia.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Escuela Procedencia</span>
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('bachiller.bachiller_certificados_pagados.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Certificados Pagado</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_justificaciones.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Justificaciones</span>
                                        </a>
                                    </li>
                                    
                                    {{-- Rel. de Familia/Tutores --}}
                                    {{--  <li>
                                        <a href="{{ route('bachiller.bachiller_relacion_tutores.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Rel. de Familia/Tutores</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_datos_completos_alumno.reporteAlumnos') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Datos Completos de Alumno</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_alumnos_no_inscritos_materias.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos no inscritos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_alumnos_inscritos_acd.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos inscritos ACD</span>
                                        </a>
                                    </li>  --}}


                                </ul>
                            </div>
                        </li>
                        {{-- Calificaciones Merida y Valladolid--}}
                        @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                                {{--  Constancias   --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Constancias</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_buena_conducta.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Buena conducta</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_calificacion_carrera.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones completas</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_calificacion_parcial.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones parciales</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_constancia_inscripcion.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Inscripción</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('bachiller.bachiller_constancia_medica.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Médica</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('bachiller.bachiller_precertificado.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Pre-certificados</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('bachiller.bachiller_historial_alumno.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Historial académico alumnos</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('bachiller.bachiller_constancia_computo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Computo</span>
                                                </a>
                                            </li> 
                                        </ul>
                                    </div>
                                </li>

                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Calificaciones</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        {{--  Calificaciones de grupo  --}}
                                        {{-- <li>
                                            <a href="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Lista de Calificaciones</span>
                                            </a>
                                        </li> --}}
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_evidencias_faltantes.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Evidencias Faltantes</span>
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_resumen_evidencias.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. Evidencias</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_avance_calificaciones.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. de calificaciones</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_avance_por_grupo.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Avance por grupos</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_adas_faltantes.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>ADAS sin calificar</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_resumen_calificaciones_grupo.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. Calificaciones por Grupo</span>
                                            </a>
                                        </li>
                                        {{--  <li>
                                            <a href="{{ route('bachiller.bachiller_calificacion_final.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Califacion Final</span>
                                            </a>
                                        </li>  --}}

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_acta_extraordinario.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Acta de examen extraordinario</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_materias_aprobadas.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Mat. Aprobadas</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_actas_pendientes.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Actas Pendientes</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_puntos_perdidos.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. Puntos Perdidos</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_boleta_final.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Boleta Final</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_mejores_promedios.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Mejor Promedio</span>
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_mejores_promedios_anuales.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Mejor Promedio Anual</span>
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_puntos_cualitativos.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Puntos Cualitativos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif

                        {{-- Calificaciones Chetumal  --}}
                        @if (Auth::user()->campus_cch == 1)
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Calificaciones</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        {{--  Calificaciones de grupo  --}}
                                        {{-- <li>
                                            <a href="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Lista de Calificaciones</span>
                                            </a>
                                        </li> --}}
                                        {{-- <li>
                                            <a href="{{ route('bachiller.bachiller_resumen_evidencias.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. Evidencias</span>
                                            </a>
                                        </li> --}}

                                        {{-- <li>
                                            <a href="{{ route('bachiller.bachiller_avance_calificaciones.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. de calificaciones</span>
                                            </a>
                                        </li> --}}

                                        {{-- <li>
                                            <a href="{{ route('bachiller.bachiller_avance_por_grupo.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Avance por grupos</span>
                                            </a>
                                        </li> --}}

                                        {{-- <li>
                                            <a href="{{ route('bachiller.bachiller_calificacion_final.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Califacion Final</span>
                                            </a>
                                        </li> --}}

                                        {{-- <li>
                                            <a href="{{ route('bachiller.bachiller_acta_extraordinario.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Acta de examen extraordinario</span>
                                            </a>
                                        </li> --}}
                                        {{-- <li>
                                            <a href="{{ route('bachiller_reporte.calificacion_por_materia.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. por materia</span>
                                            </a>
                                        </li>  --}}
                                        {{--  <li>
                                            <a href="{{ route('bachiller_calificacion_materia_ingles.index') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Res. de Inglés</span>
                                            </a>
                                        </li>  --}}
                                        {{--  <li>
                                            <a href="{{ route('bachiller.bachiller_boleta_de_calificaciones.reporteBoleta') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Boleta</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_boleta_de_calificaciones_acd.reporteBoleta') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Boleta ACD</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_historial_alumno.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Historial académico del alumno</span>
                                            </a>
                                        </li>  --}}
                                    </ul>
                                </div>
                            </li>
                        @endif

                        {{--  Docentes  --}}
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <span class="nav-text">Docentes</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    {{--  Rel maestros escuela  --}}
                                    <li>
                                        <a href="{{ route('bachiller_relacion_maestros_escuela.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Rel. Grupos Maestros</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_carga_grupos_maestro.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Carga grupos por maestro</span>
                                        </a>
                                    </li>

                                    {{--  <li>
                                        <a href="{{ route('bachiller.bachiller_horarios_administrativos.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Horarios Administrativos</span>
                                        </a>
                                    </li>  --}}
                                    {{--  <li>
                                        <a href="{{ route('bachiller_reporte.relacion_maestros_acd.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Rel. Grupos ACD</span>
                                        </a>
                                    </li>  --}}
                                </ul>
                            </div>
                        </li>

                        {{-- Evaluaciones --}}
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <span class="nav-text">Recuperativos</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    <li>
                                        <a href="{{ route('bachiller.programacion_examenes.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Programación de exa. Recuperativos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_relacion_inscritos_extraordinario.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Inscritos a recuperativos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_resumen_inscritos_recuperativos.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Res. Inscritos recuperativos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_alumnos_recuperativos.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Lista alumnos insc. recuperativos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('bachiller.bachiller_rel_extraordinarios.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Relación Extraordinarios</span>
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

                                    {{--  <li>
                                        <a href="{{ route('bachiller.lista_de_asistencia.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Lista de asistencia</span>
                                        </a>
                                    </li>  --}}
                                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1 || Auth::user()->campus_cch == 1)
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_asistencia_grupo.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Asistencia por grupo</span>
                                        </a>
                                    </li>
                                    @endif

                                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_grupo_materia.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Asistencia por materia</span>
                                        </a>
                                    </li>
                                    @endif


                                    @if (Auth::user()->campus_cch == 1)
                                    <li>
                                        <a href="{{ route('bachiller.bachiller_grupo_materia_cch.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Asistencia por materia</span>
                                        </a>
                                    </li>
                                    @endif
                                    
                                </ul>
                            </div>
                        </li>

                        {{--  Cursos   --}}
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <span class="nav-text">Cursos</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    {{--  Grupos por semestre  --}}
                                    <li>
                                        <a href="{{route('bachiller.bachiller_grupo_semestre.reporte')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Grupos por semestre</span>
                                        </a>
                                    </li>
                                    {{--  Calificaciones de grupo  --}}
                                    <li>
                                        <a href="{{route('bachiller.bachiller_horario_por_grupo.reporte')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Horario de clases</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{route('bachiller.bachiller_horario_clases_alumno.reporte')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Horario de clases(alumno)</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        {{--  Formatos UADY  --}}
                        @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)                          

                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Formatos UADY</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_REA.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>REA (Registro de alumnos)</span>
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_SOCA.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>SOCA (Optativas)</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('bachiller.bachiller_SOCA_ACO.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>SOCA (Acompañamientos)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_BGU_Resultados.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>BGU Resultados</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            {{--  911   --}}
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">911</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        
                                        <li>
                                            <a href="{{ route('bachiller.bachiller_resumen_edades.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Resumen de edades</span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if (Auth::user()->username == "ARELYMAR")       
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <span class="nav-text">Pagos</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    <li>
                                        <a href="{{ url('reporte/bachiller_relacion_deudores') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Relación de Deudores</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif

                        {{-- Pagos --}}
                        @if ( (Auth::user()->departamento_cobranza == 1)
                                || $userClave == "JPEREIRA"
                                || $userClave == "HRIVAS"
                                || $userClave == "RRIOSC"
                                || $userClave == "SRIVERO"
                                || $userClave == "MARIANAT")
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Pagos</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/bachiller_relacion_deudas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Deudas de un Alumno</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/bachiller_relacion_deudores') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Relación de Deudores</span>
                                                </a>
                                            </li>
                                            @if ($userClave == "JIMENARIVERO")
                                                <li>
                                                    <a href="{{ url('reporte/relacion_deudores_pagos_anuales') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Pagos Recibidos</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ url('reporte/becas_campus_carrera_escuela') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Montos de Becas</span>
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
@endif

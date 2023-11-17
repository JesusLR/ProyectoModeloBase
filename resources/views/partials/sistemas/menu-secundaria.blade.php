@if (Auth::user()->secundaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Secundaria</span>
            </a>
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SEC Catálogos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                {{--  programas   --}}
                                <li>
                                    <a href="{{ route('secundaria.secundaria_programa.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Programas</span>
                                    </a>
                                </li>

                                {{--  planes   --}}
                                <li>
                                    <a href="{{ route('secundaria.secundaria_plan.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Planes</span>
                                    </a>
                                </li>

                                {{--  periodos   --}}
                                <li>
                                    <a href="{{ route('secundaria.secundaria_periodo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Períodos</span>
                                    </a>
                                </li>

                                {{--  materias   --}}
                                <li>
                                    <a href="{{ route('secundaria.secundaria_materia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias</span>
                                    </a>
                                </li>

                                {{--  cgts   --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_cgt.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CGT</span>
                                    </a>
                                </li>

                                {{--  porcentaje   --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_porcentaje.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Porcentajes</span>
                                    </a>
                                </li>

                                {{--  migrar inscritos ACD   --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_migrar_inscritos_acd.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Migrar Inscritos ACD</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SEC C.Escolar</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ route('secundaria.secundaria_alumno.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('secundaria.secundaria_historia_clinica.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Entrevista inicial</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('secundaria.secundaria_curso.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Preinscritos</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('secundaria.secundaria_grupo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Grupos</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('secundaria.secundaria_asignar_grupo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscritos Grupos</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('secundaria.secundaria_asignar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Asignar CGT</span>
                                    </a>
                                </li>


                                {{--  cambiar CGT   --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_cambiar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambiar CGT</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{route('secundaria.secundaria_cambio_grupo_acd.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambiar grupo ACD</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('secundaria.secundaria_materias_inscrito.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cargar Materias a Inscrito</span>
                                    </a>
                                </li>

                                {{--  CGT Materias  --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_cgt_materias.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CGT Materias</span>
                                    </a>
                                </li>

                                {{-- Asignar Docente CGT  --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_asignar_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Grupos - docente</span>
                                    </a>
                                </li>



                                {{-- Cambio de Programa 
                                <li>
                                    <a href="{{route('secundaria.secundaria_cambio_programa.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambio de Programa</span>
                                    </a>
                                </li>
                                --}}



                                <li>
                                    <a href="{{ route('secundaria.secundaria_empleado.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Empleados / Docentes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('secundaria.secundaria_cambiar_contrasenia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Contraseña de Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('secundaria.secundaria_calendario.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Agenda</span>
                                    </a>
                                </li>



                                {{--  
                                <li>
                                    <a href="{{ route('secundaria.secundaria_resumen_academico.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen academico</span>
                                    </a>
                                </li>
                                --}}

                                <li>
                                    <a href="{{route('secundaria.secundaria_fecha_publicacion_calificacion_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calif. Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('secundaria.secundaria_fecha_publicacion_calificacion_alumno.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calif. Alumno</span>
                                    </a>
                                </li>

                                {{--  observaciones calificaciones   --}}
                                <li>
                                    <a href="{{route('secundaria.secundaria_obs_boleta.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Nota mensual Calif.</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('secundaria.secundaria_generar_promedios.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Generar promedio</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('secundaria.secundaria_alumnos_restringidos.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos Restringidos</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                     {{--  Act. ExtraEscolares  --}}
                     <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SEC Act. ExtraEscolares</span>
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
                            <span class="nav-text">SEC Pagos</span>
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
                                    <a href="{{ url('secundaria/pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos Manuales</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SEC Reportes</span>
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
                                                <a href="{{ route('secundaria_inscrito_preinscrito.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Inscritos y preinscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/secundaria_resumen_inscritos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen inscritos</span>
                                                </a>
                                            </li>
                                            {{--  Expediente de alumnos   --}}
                                            <li>
                                                <a href="{{ route('secundaria_reporte.expediente_alumnos.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Expediente de alumnos</span>
                                                </a>
                                            </li>
                                            {{--  Reporte de alumnos becados   --}}
                                            <li>
                                                <a href="{{ route('secundaria_reporte.secundaria_alumnos_becados.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. alumnos becados</span>
                                                </a>
                                            </li>
                                            {{--  Relación de Padres de Familia   --}}
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_relacion_bajas_periodo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. de Bajas</span>
                                                </a>
                                            </li>
                                            {{-- Rel. de Familia/Tutores --}}
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_relacion_tutores.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. de Familia/Tutores</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_datos_completos_alumno.reporteAlumnos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Datos Completos de Alumno</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_alumnos_no_inscritos_materias.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Alumnos no inscritos</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria.secundaria_alumnos_inscritos_acd.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Alumnos inscritos ACD</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria.secundaria_acd_faltantes.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Alumnos No inscritos ACD</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria.secundaria_no_inscritos.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Alumnos No inscritos (Base)</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria.secundaria_lista_de_interasados.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de interesados</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria.secundaria_inscritos_sexo.reporte') }}">
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
                                                <a href="{{ route('secundaria.secundaria_constancia_buena_conducta.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Buena Conducta</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria.secundaria_constancia_estudios.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Estudios</span>
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
                                                <a href="{{ route('secundaria_reporte.calificaciones_grupo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de Calificaciones</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_resumen_de_calificaciones.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. de calificaciones</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_resumen_de_calificaciones_trim.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. de Calif. Trimestres</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria_reporte.calificacion_por_materia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. por materia</span>
                                                </a>
                                            </li>
                                            {{--  <li>
                                                <a href="{{ route('secundaria_calificacion_materia_ingles.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. de Inglés</span>
                                                </a>
                                            </li>  --}}
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_boleta_de_calificaciones.reporteBoleta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Boleta</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_boleta_de_calificaciones_acd.reporteBoleta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Boleta ACD</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria.secundaria_historial_alumno.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Historial académico del alumno</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('secundaria_reporte.calificaciones_faltantes.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones faltantes</span>
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
                                                <a href="{{ route('secundaria_relacion_maestros_escuela.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Grupos Maestros</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('secundaria_reporte.relacion_maestros_acd.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Grupos ACD</span>
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
                                            <li>
                                                <a href="{{ route('secundaria_reporte.lista_de_asistencia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia</span>
                                                </a>
                                            </li>
                                            {{--  lista de asistencia ACD  --}}
                                            <li>
                                                <a href="{{route('secundaria_reporte.lista_de_asistencia_ACD.reporteACD')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia ACD</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('secundaria.secundaria_resumen_inasistencias.index')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen de inasistencia</span>
                                                </a>
                                            </li>
                                            {{--  Relación Grupos Materias   --}}
                                            <li>
                                                <a href="{{route('secundaria.secundaria_grupo_semestre.reporte')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. grupos materias</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- Pagos --}}
                                @if (Auth::user()->departamento_cobranza == 1)
                                    <li class="bold">
                                        <a class="collapsible-header waves-effect waves-cyan">
                                            <span class="nav-text">Pagos</span>
                                        </a>
                                        <div class="collapsible-body">
                                            <ul>
                                                <li>
                                                    <a href="{{ url('reporte/secundaria_relacion_deudas') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Deudas de un Alumno</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/secundaria_relacion_deudores') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Relación de Deudores</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </li>

    @endif

@endif

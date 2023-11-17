{{-- Mostrar menú para bachiller de yucatán  --}}
@if (Auth::user()->bachiller == 1 && Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Bachiller UADY</span>
            </a>
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC Catálogos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                {{--  programas   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_programa.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Programas</span>
                                    </a>
                                </li>

                                {{--  planes   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_plan.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Planes</span>
                                    </a>
                                </li>

                                {{--  periodos   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_periodo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Períodos</span>
                                    </a>
                                </li>

                                {{--  materias   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_materia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias</span>
                                    </a>
                                </li>
                                

                                {{--  porcentaje   --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_porcentaje.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Porcentajes</span>
                                    </a>
                                </li>

                               
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC C.Escolar</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                {{--  cgts   --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_cgt.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>0-CGT</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_historia_clinica.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>1-Entrevista inicial</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('bachiller.bachiller_alumno.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>2-Alumnos</span>
                                    </a>
                                </li>                                
                                <li>
                                    <a href="{{ route('bachiller.bachiller_curso.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>3-Preinscritos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_preinscripcion_automatica.create') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>3.1-Preinscripcion automatica</span>
                                    </a>
                                </li>

                                {{--  CGT Materias  --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_cgt_materias.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>4-CGT Materias</span>
                                    </a>
                                </li> 
                                <li>
                                    <a href="{{ route('bachiller.bachiller_grupo_merida.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>5-Grupos Mérida</span>
                                    </a>
                                </li>                               

                                {{-- Asignar Docente CGT  --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_asignar_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>6-Docentes Grupos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_asignar_grupo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>7-Inscritos Grupos Mérida</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('bachiller.bachiller_asignar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>8-Asignar CGT</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('bachiller.bachiller_horarios_administrativos')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>9-Horarios administrativos Mérida</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('bachiller.bachiller_horarios_administrativos_chetumal')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>9-Horarios administrativos Chetumal</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_empleado.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>10-Empleados / Docentes</span>
                                    </a>
                                </li>
                                {{--  cambiar CGT   --}}
                                 <li>
                                    <a href="{{route('bachiller.bachiller_cambiar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambiar CGT</span>
                                    </a>
                                </li> 


                                 <li>
                                    <a href="{{route('bachiller.bachiller_materias_inscrito.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias Nurevo Inscrito</span>
                                    </a>
                                </li> 
                                {{-- Cambio de Programa 
                                <li>
                                    <a href="{{route('bachiller.bachiller_cambio_programa.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambio de Programa</span>
                                    </a>
                                </li>
                                --}}
                                
                                <li>
                                    <a href="{{ route('bachiller.bachiller_cambiar_contrasenia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Contraseña de Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('bachiller.bachiller_calendario.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Agenda</span>
                                    </a>
                                </li> 

                                {{--  
                                <li>
                                    <a href="{{ route('bachiller.bachiller_resumen_academico.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen academico</span>
                                    </a>
                                </li>
                                --}}

                                 <li>
                                    <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calif. Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calif. Alumno</span>
                                    </a>
                                </li> 

                                {{--  observaciones calificaciones   --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_obs_boleta.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Nota mensual Calif.</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('bachiller_recuperativos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Recuperativos</span>
                                    </a>
                                </li>
                                
                                {{--  <li>
                                    <a href="{{ url('bachiller_curso_recuperativo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Curso Recuperativo</span>
                                    </a>
                                </li>  --}}

                                <li>
                                    <a href="{{ route('bachiller.bachiller_evidencias.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Evidencias</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('bachiller.bachiller_fechas_regularizacion.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas de Regularización</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('bachiller.bachiller_calendario_examen.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calendario Examen</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{--  <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC Pagos</span>
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
                                    <a href="{{ url('bachiller/pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos Manuales</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>  --}}

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC Reportes</span>
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
                                {{-- Calificaciones --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Calificaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {{--  Calificaciones de grupo  --}}
                                            <li>
                                                <a href="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de Calificaciones</span>
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
                                                <a href="{{ route('bachiller.bachiller_calificacion_final.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Califacion Final</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('bachiller.bachiller_acta_extraordinario.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Acta de examen extraordinario</span>
                                                </a>
                                            </li>
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
                                        <span class="nav-text">Evaluaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ route('bachiller.programacion_examenes.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Programación de exa. extraordinarios</span>
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
                                                <a href="{{ route('bachiller_reporte.lista_de_asistencia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia</span>
                                                </a>
                                            </li>  --}}
                                            {{--  lista de asistencia ACD  --}}
                                            {{--  <li>
                                                <a href="{{route('bachiller_reporte.lista_de_asistencia_ACD.reporteACD')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia ACD</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('bachiller.bachiller_resumen_inasistencias.index')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen de inasistencia</span>
                                                </a>
                                            </li>  --}}
                                            {{--  Relación Grupos Materias   --}}
                                            {{--  <li>
                                                <a href="{{route('bachiller.bachiller_grupo_semestre.reporte')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. grupos materias</span>
                                                </a>
                                            </li>  --}}
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
                                                {{--  <li>
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
                                                </li>  --}}
                                            </ul>
                                        </div>
                                    </li>
                                @endif

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

{{-- Mostrar menú para bachiller de Quintana Roo  --}}
@if (Auth::user()->bachiller == 1 && Auth::user()->campus_cch == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Bachiller SEQ</span>
            </a>
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC Catálogos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                {{--  programas   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_programa.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Programas</span>
                                    </a>
                                </li>

                                {{--  planes   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_plan.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Planes</span>
                                    </a>
                                </li>

                                {{--  periodos   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_periodo.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Períodos</span>
                                    </a>
                                </li>

                                {{--  materias   --}}
                                <li>
                                    <a href="{{ route('bachiller.bachiller_materia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias</span>
                                    </a>
                                </li>
                                

                                {{--  porcentaje   --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_porcentaje.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Porcentajes</span>
                                    </a>
                                </li>

                               
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC C.Escolar</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                {{--  cgts   --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_cgt.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>0-CGT</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_historia_clinica.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>1-Entrevista inicial</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('bachiller.bachiller_alumno.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>2-Alumnos</span>
                                    </a>
                                </li>                                
                                <li>
                                    <a href="{{ route('bachiller.bachiller_curso.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>3-Preinscritos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_preinscripcion_automatica.create') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>3.1-Preinscripcion automatica</span>
                                    </a>
                                </li>

                                {{--  CGT Materias  --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_cgt_materias.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>4-CGT Materias</span>
                                    </a>
                                </li>                                 

                                <li>
                                    <a href="{{ route('bachiller.bachiller_grupo_chetumal.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>5-Grupos Chetumal</span>
                                    </a>
                                </li>

                                {{-- Asignar Docente CGT  --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_asignar_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>6-Docentes Grupos</span>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="{{ route('bachiller.bachiller_asignar_grupo_chetumal.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>7-Inscritos Grupos Chetumal</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('bachiller.bachiller_asignar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>8-Asignar CGT</span>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="{{route('bachiller.bachiller_horarios_administrativos_chetumal')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>9-Horarios administrativos Chetumal</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bachiller.bachiller_empleado.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>10-Empleados / Docentes</span>
                                    </a>
                                </li>
                                {{--  cambiar CGT   --}}
                                 <li>
                                    <a href="{{route('bachiller.bachiller_cambiar_cgt.edit')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambiar CGT</span>
                                    </a>
                                </li> 


                                 <li>
                                    <a href="{{route('bachiller.bachiller_materias_inscrito.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias Nurevo Inscrito</span>
                                    </a>
                                </li> 
                                {{-- Cambio de Programa 
                                <li>
                                    <a href="{{route('bachiller.bachiller_cambio_programa.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambio de Programa</span>
                                    </a>
                                </li>
                                --}}
                                
                                <li>
                                    <a href="{{ route('bachiller.bachiller_cambiar_contrasenia.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Contraseña de Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('bachiller.bachiller_calendario.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Agenda</span>
                                    </a>
                                </li> 

                                {{--  
                                <li>
                                    <a href="{{ route('bachiller.bachiller_resumen_academico.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resumen academico</span>
                                    </a>
                                </li>
                                --}}

                                 <li>
                                    <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calif. Docentes</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Fechas Calif. Alumno</span>
                                    </a>
                                </li> 

                                {{--  observaciones calificaciones   --}}
                                <li>
                                    <a href="{{route('bachiller.bachiller_obs_boleta.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Nota mensual Calif.</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('bachiller_recuperativos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Recuperativos</span>
                                    </a>
                                </li>
                                
                                {{--  <li>
                                    <a href="{{ url('bachiller_curso_recuperativo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Curso Recuperativo</span>
                                    </a>
                                </li>  --}}

                                <li>
                                    <a href="{{ route('bachiller.bachiller_evidencias.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Evidencias</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    {{--  <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC Pagos</span>
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
                                    <a href="{{ url('bachiller/pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos Manuales</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>  --}}

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">BAC Reportes</span>
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
                                {{-- Calificaciones --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Calificaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {{--  Calificaciones de grupo  --}}
                                            {{--  <li>
                                                <a href="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de Calificaciones</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_resumen_de_calificaciones.index') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. de calificaciones</span>
                                                </a>
                                            </li>
                                            <li>
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
                                                <a href="{{ route('bachiller_reporte.relacion_maestros_acd.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Grupos ACD</span>
                                                </a>
                                            </li>  --}}
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
                                                <a href="{{ route('bachiller_reporte.lista_de_asistencia.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia</span>
                                                </a>
                                            </li>  --}}
                                            {{--  lista de asistencia ACD  --}}
                                            {{--  <li>
                                                <a href="{{route('bachiller_reporte.lista_de_asistencia_ACD.reporteACD')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Lista de asistencia ACD</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('bachiller.bachiller_resumen_inasistencias.index')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen de inasistencia</span>
                                                </a>
                                            </li>  --}}
                                            {{--  Relación Grupos Materias   --}}
                                            {{--  <li>
                                                <a href="{{route('bachiller.bachiller_grupo_semestre.reporte')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. grupos materias</span>
                                                </a>
                                            </li>  --}}
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
                                                {{--  <li>
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
                                                </li>  --}}
                                            </ul>
                                        </div>
                                    </li>
                                @endif

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

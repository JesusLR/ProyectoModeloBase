@if (Auth::user()->secundaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">SEC. Reportes</span>
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
                                        <a href="{{ route('secundaria.secundaria_alumnos_excel.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos Excel</span>
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


                                    <li>
                                        <a href="{{ route('secundaria.secundaria_recuperativos.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Calificación Recuperativo</span>
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
                                    {{--  <li>
                                        <a href="{{ route('secundaria_reporte.lista_de_asistencia.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Lista de asistencia</span>
                                        </a>
                                    </li>  --}}
                                    <li>
                                        <a href="{{ route('secundaria.secundaria_asistencia_grupo.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Asistencia por grupo</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('secundaria.secundaria_grupo_materia.reporte') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Asistencia por materia</span>
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
                                    {{--  <li>
                                        <a href="{{route('secundaria.secundaria_grupo_semestre.reporte')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Rel. grupos materias</span>
                                        </a>
                                    </li>  --}}
                                </ul>
                            </div>
                        </li>

                        @if (Auth::user()->id == 176 || Auth::user()->id == 198)
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <span class="nav-text">Pagos</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
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
                        {{-- Pagos --}}
                        @if ( (Auth::user()->departamento_cobranza == 1) || (Auth::user()->username == "MARIANAT") )
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

@if (Auth::user()->primaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">PRIM. Reportes</span>
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
                                        {{-- psicologas de primaria no lo ven --}}
                                        @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA")
                                        && (Auth::user()->username != "ANGELINAMICHELL"))
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
                                        @endif

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

                                        @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA")
                                        && (Auth::user()->username != "ANGELINAMICHELL"))
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

                                                <li>
                                                    <a href="{{ route('primaria.reporte.ahorro_escolar.index') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Ahorro</span>
                                                    </a>
                                                </li>
                                        @endif
                                        {{-- Perfiles --}}
                                        <li>
                                            <a href="{{ route('primaria.primaria_perfil_alumno.index') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Perfiles</span>
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
                                            <a href="{{ route('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Lista Presencial-Virtual</span>
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

                            @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA")
                            && (Auth::user()->username != "ANGELINAMICHELL"))

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
                                                    <a href="{{ route('primaria.calificaciones_grupo_campos_formativos.reporte') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Res. por grupo Campos Formativos</span>
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

                                                {{--  lista de faltas   --}}
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
                            @endif


                            {{--  solo valladolid   --}}
                            @if (Auth::user()->id == 176 || Auth::user()->id == 198 || $userClave == "MCARRILLO")
                                    <li class="bold">
                                        <a class="collapsible-header waves-effect waves-cyan">
                                            <span class="nav-text">Pagos</span>
                                        </a>
                                        <div class="collapsible-body">
                                            <ul>                                                
                                                <li>
                                                    <a href="{{ url('reporte/primaria_relacion_deudores') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Relación de Deudores</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                            @endif

                            {{-- Pagos --}}
                            @if (Auth::user()->departamento_cobranza == 1
                                || $userClave == "MARIANAT")
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

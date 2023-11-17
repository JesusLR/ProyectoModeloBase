@if (Auth::user()->primaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

            {{-- psicologas de primaria no lo ven --}}
            @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA")
            && (Auth::user()->username != "ANGELINAMICHELL"))

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">PRIM. C.ESCOLAR</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>

                                <li>
                                    <a href="{{ route('primaria_curso.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>A-Preinscritos</span>
                                    </a>
                                </li>

                            <li>
                                <a href="{{ route('primaria_alumno.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>B-Alumnos</span>
                                </a>
                            </li>


                                {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                                @if (Auth::user()->departamento_cobranza == 0)

                                    {{--  Asignar CGT  --}}
                                    <li>
                                        <a href="{{route('primaria_asignar_cgt.edit')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>1-Asignar CGT</span>
                                        </a>
                                    </li>
                                    {{--  CGT Materias Asignaturas (inscribir alumnos a grupos) --}}
                                    <li>
                                        <a href="{{route('primaria.primaria_cgt_materias.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>2-CGT Materias</span>
                                        </a>
                                    </li>
                                    {{-- Asignar Docente Presencial  --}}
                                    <li>
                                        <a href="{{route('primaria.primaria.primaria_asignar_docente_presencial.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>3-Docente Presencial Gpo.</span>
                                        </a>
                                    </li>
                                    {{-- Asignar Docente Virtual  --}}
                                    {{--  <li>
                                        <a href="{{route('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>4-Docente Virtual Gpo.</span>
                                        </a>
                                    </li>  --}}
                                    {{--  Grupos  --}}
                                    <li>
                                        <a href="{{ route('primaria_grupo.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>5-Grupos Formados</span>
                                        </a>
                                    </li>
                                    {{--  Inscritos Grupos   --}}
                                    <li>
                                        <a href="{{ route('primaria_asignar_grupo.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>6-Inscritos a Grupos</span>
                                        </a>
                                    </li>
                                    {{--  cambiar CGT   --}}
                                    <li>
                                        <a href="{{route('primaria.primaria_cambiar_cgt.edit')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>7-Cambiar CGT</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('primaria.primaria_materias_inscrito.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>8-Cargar Materias a Inscrito</span>
                                        </a>
                                    </li>
                                    {{-- Cambio de Programa --}}
                                    {{--  <li>
                                        <a href="{{route('primaria.primaria.primaria_cambio_programa.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>9-Cambio de Programa</span>
                                        </a>
                                    </li>  --}}
                                    {{--  <li>
                                        <a href="{{route('primaria.primaria.primaria_inscrito_modalidad.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>10-Inscrito Modalidad</span>
                                        </a>
                                    </li>  --}}

                                    <li>
                                        <a href="{{route('primaria.primaria_docente_inscrito_modalidad.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>11-Docente Inscrito Modalidad</span>
                                        </a>
                                    </li>
                                    {{--  observaciones calificaciones   --}}
                                    <li>
                                        <a href="{{route('primaria.primaria.primaria_obs_boleta.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Obs. boleta</span>
                                        </a>
                                    </li>
                                    {{--  Horarios libres   --}}
                                    <li>
                                        <a href="{{route('primaria.primaria_horarios_libres.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Docentes horarios libres</span>
                                        </a>
                                    </li>
                                    {{--  Fecha Publicación Calif Docente  --}}
                                    <li>
                                        <a href="{{route('primaria.primaria_fecha_publicacion_calificacion_docente.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Fechas captura docente</span>
                                        </a>
                                    </li>
                                    
                                    {{--  Fecha Publicación Calif. Alumno  --}}
                                    {{--  
                                    <li>
                                        <a href="{{route('primaria.primaria_fecha_publicacion_calificacion_alumno.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Fecha Publicación Calif.</span>
                                        </a>
                                    </li>
                                    --}}

                                    {{--  para modificar todas las calificaciones   --}}
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

                                @endif

                        </ul>
                    </div>
                </li>


                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">PRIM. Docentes</span>
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
            @endif

            {{-- SI LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
            @if (Auth::user()->departamento_cobranza == 1
                    || $userClave == "MARIANAT"
                    || $userClave == "MCARRILLO")
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <i class="material-icons">dashboard</i>
                            <span class="nav-text">PRIM. Pagos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('pagos/ficha_general') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ficha general</span>
                                    </a>
                                </li>
                                @if ( $userClave == "FLOPEZH"
                                    || $userClave == "MARIANAT")
                                    <li>
                                        <a href="{{ url('pagos/aplicar_pagos') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Consultar pagos</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('pagos/consulta_fichas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Consulta de fichas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('becas_historial/cursos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Historial de becas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
            @endif

    @endif

@endif

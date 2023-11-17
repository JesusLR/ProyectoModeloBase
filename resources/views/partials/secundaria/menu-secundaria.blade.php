@if (Auth::user()->secundaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">SECUNDARIA</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                            {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                            @if (Auth::user()->departamento_cobranza == 0)
                                <li>
                                    <a href="{{ route('secundaria.secundaria_historia_clinica.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>A-Entrevista inicial</span>
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ route('secundaria.secundaria_curso.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>B-Preinscritos</span>
                                </a>
                            </li>


                            {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                            @if (Auth::user()->departamento_cobranza == 0)
                                    <li>
                                        <a href="{{ route('secundaria.secundaria_grupo.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>1-Grupos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('secundaria.secundaria_asignar_grupo.index') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>2-Inscritos Grupos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('secundaria.secundaria_asignar_cgt.edit')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>3-Asignar CGT</span>
                                        </a>
                                    </li>

                                    {{--  CGT Materias  --}}
                                    <li>
                                        <a href="{{route('secundaria.secundaria_cgt_materias.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>4-CGT Materias</span>
                                        </a>
                                    </li>

                                    {{-- Asignar Docente CGT  --}}
                                    <li>
                                        <a href="{{route('secundaria.secundaria_asignar_docente.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>5-Grupos - docente</span>
                                        </a>
                                    </li>

                                    {{--  cambiar CGT   --}}
                                    <li>
                                        <a href="{{route('secundaria.secundaria_cambiar_cgt.edit')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>6-Cambiar CGT</span>
                                        </a>
                                    </li>
                                    {{--  Cargar Materias a Inscrito   --}}
                                    <li>
                                        <a href="{{route('secundaria.secundaria_materias_inscrito.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>7-Cargar Materias a Inscrito</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{route('secundaria.secundaria_cambio_grupo_acd.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>8-Cambiar grupo ACD</span>
                                        </a>
                                    </li>

                                    
                                    {{--  migrar inscritos ACD   --}}
                                    <li>
                                        <a href="{{route('secundaria.secundaria_migrar_inscritos_acd.index')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Migrar Inscritos ACD</span>
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
                                            <span>Fechas Calif. Alumnos</span>
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
                                        <a href="{{route('secundaria.secundaria_modificar_boleta.modificar')}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Modificar Calificaciones</span>
                                        </a>
                                    </li>
                            @endif

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
                    <span class="nav-text">SEC. Pagos</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ url('pagos/ficha_general') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Ficha general</span>
                            </a>
                        </li>
                        @if ($userClave == "FLOPEZH"
                            || $userClave == "MARIANAT")
                            <li>
                                <a href="{{ url('secundaria/pagos/aplicar_pagos') }}">
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

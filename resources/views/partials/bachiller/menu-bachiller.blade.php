{{-- Menú para Merida y Valladolid --}}
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
                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                    <span class="nav-text">BAC. UADY</span>
                @endif

                @if (Auth::user()->campus_cch == 1)
                    <span class="nav-text">BAC. SEQ</span>
                @endif
            </a>
            <div class="collapsible-body">
                <ul>
                    {{-- cgts --}}
                    <li>
                        <a href="{{route('bachiller.bachiller_cgt.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>1-CGT</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bachiller.bachiller_alumno.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>2-Alumnos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bachiller.bachiller_historia_clinica.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>2.1-Expediente Alumno</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('bachiller.bachiller_curso.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>3-Preinscritos</span>
                        </a>
                    </li>
                    {{-- @if ($userClave == "DESARROLLO") --}}
                    <li>
                        <a href="{{ route('bachiller.bachiller_preinscripcion_automatica.create') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>3.1-Preinscripcion automatica</span>
                        </a>
                    </li>
                    {{--  @endif --}}

                    {{-- Yucatán  --}}
                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_grupo_uady.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>4-Grupos</span>
                            </a>
                        </li>
                    @endif

                    {{-- Chetumal  --}}
                    @if (Auth::user()->campus_cch == 1)
                        {{--  cambiar CGT   --}}
                        <li>
                            <a href="{{route('bachiller.bachiller_cambiar_cgt_cch.edit')}}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>4-Cambiar CGT</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bachiller.bachiller_grupo_seq.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>5-Grupos</span>
                            </a>
                        </li>
                    @endif


                    {{-- Asignar Docente CGT --}}
                    {{--  <li>
                        <a href="{{route('bachiller.bachiller_asignar_docente.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>6-Docentes Grupos</span>
                        </a>
                    </li>  --}}

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_asignar_grupo.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>5-Inscritos Grupos</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('bachiller.bachiller_paquete.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>6-Paquetes</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('bachiller.bachiller_inscrito_paquete.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>6.1-Inscritos Paquetes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bachiller.bachiller_evidencias.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>7-Evidencias</span>
                            </a>
                        </li>
                        {{--  cambiar CGT   --}}
                        <li>
                            <a href="{{route('bachiller.bachiller_cambiar_cgt_yucatan.edit')}}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>8-Cambiar CGT</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('bachiller.bachiller_migrar_inscritos_acd.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>11-Migrar Inscritos</span>
                            </a>
                        </li>

                        {{--  <li>
                            <a href="{{ route('bachiller.bachiller_copiar_inscritos.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>12-Cambiar Inscritos</span>
                            </a>
                        </li>  --}}

                        <li>
                            <a href="{{ route('bachiller.bachiller_copiar_horario.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>12-Copiar Horario</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('bachiller.bachiller_cierre_actas.filtro') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Cierre Ordinarios</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->campus_cch == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_asignar_grupo_seq.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>6-Inscritos Grupos</span>
                            </a>
                        </li>
                        {{-- CGT Materias --}}
                        <li>
                            <a href="{{route('bachiller.bachiller_cgt_materias.index')}}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>7-CGT Materias</span>
                            </a>
                        </li>


                    @endif


                    {{--  <li>
                        <a href="{{route('bachiller.bachiller_asignar_cgt.edit')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>8-Asignar CGT</span>
                        </a>
                    </li>  --}}

                    {{--  <li>
                        <a href="{{ route('bachiller.bachiller_empleado.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Empleados / Docentes</span>
                        </a>
                    </li>  --}}
                  

                    

                    @if (Auth::user()->campus_cch == 1)
                    {{--  <li>
                        <a href="{{route('bachiller.bachiller_horarios_administrativos_chetumal')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Horarios administrativos</span>
                        </a>
                    </li>  --}}
                    @endif

                    

                    {{-- cambiar CGT --}}
                    {{--  <li>
                        <a href="{{route('bachiller.bachiller_cambiar_cgt.edit')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Cambiar CGT</span>
                        </a>
                    </li>  --}}

                    {{--
                    <li>
                        <a href="{{route('bachiller.bachiller_materias_inscrito.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Materias Nuevo Inscrito</span>
                        </a>
                    </li>
                    --}}

                    {{-- <li>
                        <a href="{{ route('bachiller.bachiller_calendario.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Agenda</span>
                        </a>
                    </li> --}}

                    {{--
                    <li>
                        <a href="{{ route('bachiller.bachiller_resumen_academico.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Resumen academico</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Fechas Calif. Docentes</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('bachiller.bachiller_obs_boleta.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Nota mensual Calif.</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('bachiller_curso_recuperativo') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Curso Recuperativo</span>
                        </a>
                    </li>

                    --}}

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ url('bachiller_recuperativos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Recuperativos</span>
                            </a>
                        </li>       
                        
                        <li>
                            <a href="{{ route('bachiller.bachiller_cierre_extras.filtro') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Cierre Recuperativos</span>
                            </a>
                        </li>
                    @endif


                    {{--
                    <li>
                        <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Fechas Calif. Alumno</span>
                        </a>
                    </li>
                    --}}

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)                            
                            <li>
                                <a href="{{ route('bachiller.bachiller_historial_academico.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Historial Académico</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bachiller.bachiller_revalidaciones.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Revalidaciones</span>
                                </a>
                            </li>

                            {{--  <li>
                                <a href="{{ url('bachiller_certificados_parciales') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Certificados Parciales</span>
                                </a>
                            </li>  --}}
                    @endif


                </ul>
            </div>
        </li>

    @endif


    {{-- SI LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if (Auth::user()->departamento_cobranza == 1
            || ($userClave == "ANDREA"
            || $userClave == "SRIVERO"
            || $userClave == "JPEREIRA"
            || $userClave == "RRIOSC"
            || $userClave == "MARIANAT"
            || $userClave == "MCARRILLO"
            || $userClave == "HRIVAS")
            )

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">BAC. Pagos</span>
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
                        || $userClave == "HRIVAS"
                        || $userClave == "JPEREIRA"
                        || $userClave == "MARIANAT" )
                        <li>
                            <a href="{{ url('pagos/aplicar_pagos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Consultar pagos</span>
                            </a>
                        </li>
                    @endif
                    @if ($userClave == "JIMENARIVERO")
                        <li>
                            <a href="{{ url('bachiller/pagos/aplicar_pagos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Pagos Manuales</span>
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

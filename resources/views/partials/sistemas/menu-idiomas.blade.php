@if (Auth::user()->idiomas == 1)
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp


        {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->idiomas == 1 )

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Academia de idiomas</span>
        </a>
        <div class="collapsible-body">
            <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">IDI C.Escolar</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('idiomas_alumno') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span class="nav-text">Alumno</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('curso_idiomas.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Preinscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('idiomas_grupo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Grupos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('idiomas_asistencia_grupo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Asistencias</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('idiomas_listas_evaluacion') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Listas evaluación</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('idiomas_boleta_calificaciones') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Boleta calificaciones</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('idiomas_listas_pagos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Listas pagos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('idiomas_calificacion_final_grupo') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Calif. final por grupo</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{--  Act. ExtraEscolares  --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">IDI -Act. ExtraEscolares</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('idiomas_empleado') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Instructores (Empleados)</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </li>

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Catálogos de idiomas</span>
        </a>
        <div class="collapsible-body">
            <ul>
                <li>
                    <a href="{{ url('idiomas_programa') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Programas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('idiomas_nivel') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Niveles/Grados</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('idiomas_materia') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Materias/Asignaturas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('idiomas_cuota') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Cuotas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('idiomas_ficha_pago') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Ficha pago</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    @endif

@endif

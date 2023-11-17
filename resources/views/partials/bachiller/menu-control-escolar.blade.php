@if (Auth::user()->bachiller == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp
    {{--  Menú cátalogos   --}}
    @include('partials.bachiller.menu-catalogos')

    @if (Auth::user()->departamento_control_escolar == 1 || $userClave == 'JIMENARIVERO')

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">BAC. C.Escolar</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    {{--  materias   --}}
                    <li>
                        <a href="{{ route('bachiller.bachiller_materia.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Materias</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bachiller.bachiller_empleado.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Empleados / Docentes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bachiller.bachiller_cambiar_contrasenia.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Contraseña de Docentes</span>
                        </a>
                    </li>

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_horarios_administrativos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Horarios administrativos UADY</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bachiller.bachiller_calendario_examen.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Fechas Calendario Examen</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->campus_cch == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_calendario_examen_cch.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Fechas Calendario Examen</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_fechas_regularizacion.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Fechas de Regularización</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bachiller.bachiller_periodos_vacacionales.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Períodos Vacacionales</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('bachiller.bachiller_calendario.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Agenda</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('bachiller.bachiller_justificaciones.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Justificaciones</span>
                        </a>
                    </li>


                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller-portal-configuracion.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Config. Portal</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('bachiller.bachiller_alumnos_restringidos.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Alumnos Restringidos</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <li>
                            <a href="{{ route('bachiller.bachiller_pago_certificado.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Pago Certificado</span>
                            </a>
                        </li>
                    @endif

                    {{-- <li>
                        <a href="{{ route('bachiller.bachiller_alumno.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Alumnos</span>
                        </a>
                    </li> --}}

                </ul>
            </div>
        </li>

    @endif

@endif

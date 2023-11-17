@if (Auth::user()->idiomas == 1)

    {{--  Menú cátalogos   --}}
    @include('partials.bachiller.menu-catalogos')

    @if (Auth::user()->departamento_control_escolar == 1)

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Control Escolar</span>
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
                    <li>
                        <a href="{{ route('bachiller.bachiller_calendario.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Agenda</span>
                        </a>
                    </li>
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

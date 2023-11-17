@if (Auth::user()->secundaria == 1)

    {{--  Menú cátalogos   --}}
    @include('partials.secundaria.menu-catalogos')

    @if (Auth::user()->departamento_control_escolar == 1)

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">SEC. C.Escolar</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    {{--  cgts   --}}
                    <li>
                        <a href="{{route('secundaria.secundaria_cgt.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>CGT</span>
                        </a>
                    </li>
                    {{--  materias   --}}
                    <li>
                        <a href="{{ route('secundaria.secundaria_materia.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Materias</span>
                        </a>
                    </li>
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
                    <li>
                        <a href="{{ route('secundaria.secundaria_alumno.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Alumnos</span>
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

    @endif

@endif

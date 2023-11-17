@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}


    {{--  vista del menu catalogos   --}}
    @include('partials.preescolar.menu-catalogos')

    @if (Auth::user()->departamento_control_escolar == 1)
            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">PRE. C.Escolar</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                            <li>
                                <a href="{{ route('preescolar_empleado.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Empleados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('preescolar_alumnos.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos</span>
                                </a>
                            </li>
                    </ul>
                </div>
            </li>
    @endif

@endif

@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )
    {{--
    @if (Auth::user()->empleado->escuela->departamento->depClave == "SUP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "DIP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "AEX" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "IDI")
    --}}

    @if (Auth::user()->username == "DESARROLLO" || Auth::user()->username == "LLARA"
    || Auth::user()->username == "GIO"|| Auth::user()->username == "CESAURI"
    || Auth::user()->username == "EAIL")
        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Administración</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li>
                        <a href="{{ url('permiso') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Crear permisos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('modulo') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Crear modulos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('permiso/modulo') }}" target="_blank">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Crear permiso-modulo</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('usuario') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('portal-configuracion') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    @endif


@endif

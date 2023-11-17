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
                    <span class="nav-text">Archivos SEP</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ url('archivo/grupo') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Grupos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('archivo/inscripcion') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Inscripciones</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('archivo/ordinario') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Ordinarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('archivo/extraordinario') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Extraordinarios</span>
                            </a>
                        </li>
                        @if (Auth::user()->username == "DESARROLLO")
                            <li>
                                <a href="{{ url('archivo/control_estados') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Control de estados</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

@endif

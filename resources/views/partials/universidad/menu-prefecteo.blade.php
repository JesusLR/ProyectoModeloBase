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
                    <span class="nav-text">Prefecteo</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ url('prefecteo') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Lista de prefecteos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('aulas_en_clase') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Aulas en clase</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('aulas/ocupadas') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Aulas Ocupadas por Escuelas</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

@endif

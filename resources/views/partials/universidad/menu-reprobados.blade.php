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

    @if (Auth::user()->username == "DESARROLLO" )
        {{-- Ficha Preinscrito Extraordinario --}}
        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Ficha Preinscrito Extra</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li>
                        <a href="{{ url('fichas_preinscritos_extraordinarios') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Fichas Preinscrito Extra</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    @endif


@endif

@if (Auth::user()->natacion == 1)
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp


        {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->natacion == 1 )

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Catálogos de natación</span>
        </a>
        <div class="collapsible-body">
            <ul>
                <li>
                    <a href="{{ url('natacion_alumno') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Alumnos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('natacion_ficha_pago') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Ficha pago</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    @endif

@endif

@if (Auth::user()->gimnasio == 1)
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp


        {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->gimnasio == 1 )

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Catálogos de gimnasio</span>
        </a>
        <div class="collapsible-body">
            <ul>
                <li>
                    <a href="{{ url('gimnasio_tipo_usuario') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Tipo usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('gimnasio_usuario') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('gimnasio_alumno') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span class="nav-text">Alumnos</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    @endif

@endif

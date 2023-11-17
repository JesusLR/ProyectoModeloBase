@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp


    @if (Auth::user()->departamento_control_escolar == 1)
        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">PRE. Catálogos</span>
            </a>
            <div class="collapsible-body">
                <ul>

                    {{--  Rubricas   --}}
                    <li>
                        <a href="{{route('preescolar.preescolar_rubricas.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Rúbricas</span>
                        </a>
                    </li>

                    {{--  Fechas de Calificaciones  --}}
                    <li>
                        <a href="{{route('preescolar.preescolar_fecha_de_calificaciones.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Fechas de calificaciones</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    @endif

@endif

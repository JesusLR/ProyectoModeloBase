@if (Auth::user()->secundaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">SEC. Catálogos</span>
            </a>
            <div class="collapsible-body">
                <ul>

                    {{--  programas   --}}
                    <li>
                        <a href="{{ route('secundaria.secundaria_programa.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Programas</span>
                        </a>
                    </li>

                    {{--  planes   --}}
                    <li>
                        <a href="{{ route('secundaria.secundaria_plan.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Planes</span>
                        </a>
                    </li>

                    {{--  periodos   --}}
                    <li>
                        <a href="{{ route('secundaria.secundaria_periodo.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Períodos</span>
                        </a>
                    </li>

                    {{--  materias   --}}
                    <li>
                        <a href="{{ route('secundaria.secundaria_materia.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Materias</span>
                        </a>
                    </li>

                    {{--  cgts   --}}
                    <li>
                        <a href="{{route('secundaria.secundaria_cgt.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>CGT</span>
                        </a>
                    </li>

                    {{--  porcentaje   --}}
                    <li>
                        <a href="{{route('secundaria.secundaria_porcentaje.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Porcentajes</span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>

    @endif

@endif

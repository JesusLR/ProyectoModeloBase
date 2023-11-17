@if (
        ( (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1) )
        && auth()->user()->isAdmin('inscritos_edu_continua')
    )
    {{--
@if(in_array(Auth::user()->empleado->escuela->departamento->depClave, ['SUP', 'POS', 'DIP', 'AEX', 'IDI']) && auth()->user()->isAdmin('inscritos_edu_continua'))
    --}}



    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Educacion Continua</span>
        </a>
        <div class="collapsible-body">
            <ul>
                <li>
                    <a href="{{ url('progeducontinua') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Programas edu. continua</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('inscritosEduContinua') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Inscritos edu. continua</span>
                    </a>
                </li>


                <li>
                    <a href="{{ url('reporte/relacion_educontinua') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Rel. edu. continua</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('reporte/rel_pagos_educontinua') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Rel. pagos edu. continua</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('reporte/rel_aluprog_educontinua') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Rel. alumnos edu. continua</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('tiposProgEduContinua') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Tipos Programa edu. continua</span>
                    </a>
                </li>
                @if(auth()->user()->isAdmin('fichas_incorrectas_edu_continua'))
                    <li>
                        <a href="{{ url('reporte/fichas_incorrectas_edu_continua') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Posibles fichas incorrectas</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </li>

@endif

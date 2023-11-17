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

        @if (Auth::user()->username == "DESARROLLO"
                || Auth::user()->username == "LLARA"
                || Auth::user()->username == "FLOPEZH"
                || Auth::user()->username == "MCUEVAS"
                || Auth::user()->username == "SRIVERO"
                || Auth::user()->username == "JPEREIRA"
                || Auth::user()->username == "MARIANAT"
                || Auth::user()->username == "MAGUI"
                || Auth::user()->username == "MARTHA"
                || Auth::user()->username == "GPEREZ"
                || Auth::user()->username == "MELIBETH"
                || Auth::user()->username == "EAIL"
                || Auth::user()->username == "ARIVERO"
                || Auth::user()->username == "NLOPEZ"
                || Auth::user()->username == "MERCEDES"
                || Auth::user()->username == "MCARRILLO"
                || Auth::user()->username == "HRIVAS"
                || Auth::user()->username == "MARTHA"
                || Auth::user()->username == "CESAURI"
                || Auth::user()->username == "DENISECG")

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">Univ. Pagos</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('pagos/ficha_general') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Ficha general</span>
                                </a>
                            </li>

                            @if (Auth::user()->username != "MAGUI"
                                && Auth::user()->username != "MARTHA"
                                && Auth::user()->username != "GPEREZ"
                                && Auth::user()->username != "MELIBETH"
                                && Auth::user()->username != "HRIVAS"
                                && Auth::user()->username != "DENISECG")
                                <li>
                                    <a href="{{ url('pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Consultar pagos</span>
                                    </a>
                                </li>
                            @endif

                            @if(in_array(Auth::user()->permiso('registro_cuotas'), ['A', 'B', 'P']))
                                <li>
                                    <a href="{{ url('pagos/registro_cuotas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Registro de cuotas</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('pagos/consulta_fichas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Consulta de fichas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/concepto_pago') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Conceptos de pagos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('becas_historial/cursos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Historial de becas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            @endif

@endif

@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)
            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Preescolar</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                            <li>
                                <a href="{{ route('preescolar_alumnos.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('curso_preescolar.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Preinscritos</span>
                                </a>
                            </li>

                            @if ( $userClave == "FLOPEZH"  || $userClave == "REBECAR" || $userClave == "MFERNANDA"
                                || $userClave == "SUSANA" || $userClave == "DIONEDPENICHE" || $userClave == "CSAURI")

                                <li>
                                    <a href="{{ url('pagos/ficha_general') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ficha general</span>
                                    </a>
                                </li>

                            @endif
                            @if ($userClave == "FLOPEZH" || $userClave == "ARIVERO" || $userClave == "SUSANA" || $userClave == "CSAURI")
                                <li>
                                    <a href="{{ url('preescolar/pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos Manuales</span>
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ route('preescolar_inscrito_preinscrito.create') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Inscritos y preinscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/preescolar_resumen_inscritos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Resumen inscritos</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('reporte/preescolar_relacion_deudas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Deudas de un Alumno</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/preescolar_relacion_deudores') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Relación de Deudores</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte/relacion_deudores_pagos_anuales') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Pagos Recibidos</span>
                                </a>
                            </li>
                            @if(in_array(Auth::user()->permiso("recordatorioPagos"), ['A', 'B', 'C']))
                                <li>
                                    <a href="{{ url('reporte/recordatorio_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Recordatorio de pagos</span>
                                    </a>
                                </li>
                            @endif

                    </ul>
                </div>
            </li>
    @endif

@endif

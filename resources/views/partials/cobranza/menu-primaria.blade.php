@if (Auth::user()->primaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)

            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Primaria</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ route('primaria_alumno.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Alumnos</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('primaria_curso.index') }}">
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
                                <a href="{{ url('primaria/pagos/aplicar_pagos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Pagos Manuales</span>
                                </a>
                            </li>
                        @endif

                        {{--  Reporte de alumnos becados   --}}
                        <li>
                            <a href="{{ route('primaria_reporte.primaria_alumnos_becados.reporte') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Rel. alumnos becados</span>
                            </a>
                        </li>

                        {{-- Relación de Bajas --}}
                        <li>
                            <a href="{{ route('primaria.primaria_relacion_bajas_periodo.reporte') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Rel. de bajas</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('primaria_inscrito_preinscrito.reporte') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Inscritos y preinscritos</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('reporte/primaria_resumen_inscritos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Resumen inscritos</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('reporte/primaria_relacion_deudas') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Deudas de un Alumno</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('reporte/primaria_relacion_deudores') }}">
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

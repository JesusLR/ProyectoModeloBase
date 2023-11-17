@if (Auth::user()->secundaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Secundaria</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li>
                        <a href="{{ route('secundaria.secundaria_alumno.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Alumnos</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('secundaria.secundaria_empleado.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Empleados / Docentes</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('secundaria.secundaria_curso.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Preinscritos</span>
                        </a>
                    </li>
                    @if ( $userClave == "FLOPEZH"  || $userClave == "REBECAR" || $userClave == "MFERNANDA"
                         || $userClave == "SUSANA" || $userClave == "MARIANAT" || $userClave == "MCARRILLO"
                         || $userClave == "DIONEDPENICHE" || $userClave == "CSAURI")
                        <li>
                            <a href="{{ url('pagos/ficha_general') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Ficha general</span>
                            </a>
                        </li>
                    @endif
                    @if ($userClave == "FLOPEZH" || $userClave == "ARIVERO" || $userClave == "MARIANAT"
                        || $userClave == "MCARRILLO" || $userClave == "SUSANA")
                        <li>
                            <a href="{{ url('secundaria/pagos/aplicar_pagos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Pagos Manuales</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('secundaria_inscrito_preinscrito.reporte') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Inscritos y preinscritos</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('reporte/secundaria_resumen_inscritos') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Resumen inscritos</span>
                        </a>
                    </li>

                    {{--  Reporte de alumnos becados   --}}
                    <li>
                        <a href="{{ route('secundaria_reporte.secundaria_alumnos_becados.reporte') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Rel. alumnos becados</span>
                        </a>
                    </li>

                    {{--  Relación de Padres de Familia   --}}
                    <li>
                        <a href="{{ route('secundaria.secundaria_relacion_bajas_periodo.reporte') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Rel. de Bajas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('reporte/secundaria_relacion_deudas') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Deudas de un Alumno</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('reporte/secundaria_relacion_deudores') }}">
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

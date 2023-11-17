@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )
    {{--
        @if (in_array(auth()->user()->permiso('p_pago'), ['A', 'B']))
        --}}
    {{-- SOLO LO DEBE VER GASTON Y DESARROLLO --}}
    @if (Auth::user()->username == "DESARROLLO"
            || Auth::user()->username == "GASTON")
            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Procesos</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ url('proceso/pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Aplica pagos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('contabilidad/alumnos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Excel Alumnos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('contabilidad/fichas') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Excel Fichas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('contabilidad/referencias') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Excel Referencias</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('proceso/excel_pagos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Excel Pagos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        @endif

@endif

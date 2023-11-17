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
                    <span class="nav-text">PRE. Reportes</span>
                </a>


                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
                            {{--  Cátalogos   --}}
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Catálogos</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('reporte.preescolar_rubricas.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Rúbricas</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            {{-- Alumnos --}}
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Alumnos</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
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
                                    </ul>
                                </div>
                            </li>
                            {{-- Pagos --}}
                            @if(  Auth::user()->departamento_cobranza == 1 )
                                    <li class="bold">
                                        <a class="collapsible-header waves-effect waves-cyan">
                                            <span class="nav-text">Pagos</span>
                                        </a>
                                        <div class="collapsible-body">
                                            <ul>
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
                                                    <a href="{{ url('reporte/becas_campus_carrera_escuela') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Montos de Becas</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                            @endif

                        </ul>
                    </div>
              </li>
    @endif


@endif

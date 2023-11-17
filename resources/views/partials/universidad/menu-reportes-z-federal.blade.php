@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Univ.Reportes-Z Federales</span>
        </a>
        <div class="collapsible-body">
            <ul class="collapsible" data-collapsible="accordion">
                {{-- Reporte federal --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">Reporte Federal</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte-federal/anexo-8') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Anexo 8</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte-federal/acta_extraordinario') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Acta de examen extraordinario</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reporte-federal/acta_examen_ordinario_federales') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Actas de examen ordinario</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">SEGEY Federales</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ url('reporte-federal/segey/registro_alumnos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Registro de alumnos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </li>

@endif

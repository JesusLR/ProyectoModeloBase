@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )

    @if (auth()->user()->isAdmin("servicios_externos"))
        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Servicios Externos</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    @if(auth()->user()->isAdmin('hurra_alumnos'))
                        <li>
                            <a href="{{ url('hurra_alumnos') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Hurra alumnos</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin('hurra_maestros'))
                        <li>
                            <a href="{{ url('hurra_maestros') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Hurra maestros</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin('hurra_ordinarios'))
                        <li>
                            <a href="{{ url('hurra_ordinarios') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Hurra ordinarios</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin('hurra_horarios'))
                        <li>
                            <a href="{{ url('hurra_horarios') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Hurra horarios</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin('hurra_calificaciones'))
                        <li>
                            <a href="{{ url('hurra_calificaciones') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Hurra calificaciones</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin('hurra_extraordinarios'))
                        <li>
                            <a href="{{ url('hurra_extraordinarios') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Hurra extraordinarios</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>

    @endif
    
@endif

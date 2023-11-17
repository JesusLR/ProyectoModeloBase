@if (Auth::user()->secundaria == 1)
<li class="bold">
    <a class="collapsible-header waves-effect waves-cyan">
        <i class="material-icons">dashboard</i>
        <span class="nav-text">Act. ExtraEscolares</span>
    </a>

    <div class="collapsible-body">
        <ul>
            <li>
                <a href="{{ route('universidad.universidad_actividades.index') }}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Actividades (Grupos)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('universidad.universidad_nuevo_externo.create') }}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Nuevo Externo</span>
                </a>
            </li>
            <li>
                <a href="{{ route('universidad.universidad_actividades_inscritos.index') }}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Inscritos Actividades</span>
                </a>
            </li>

            <li>
                <a href="{{ url('empleado') }}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Instructores (Empleados)</span>
                </a>
            </li>
        </ul>
    </div>
        
  </li>
@endif

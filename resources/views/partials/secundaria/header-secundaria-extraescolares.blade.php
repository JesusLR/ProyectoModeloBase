@if (Auth::user()->secundaria == 1)
<optgroup label="Act. ExtraEscolares">
         
    <option value="{{ route('universidad.universidad_actividades.index') }}"
        {{ url()->current() ==  route('universidad.universidad_actividades.index') ? "selected": "" }}>Actividades (Grupos)</option>

    <option value="{{ route('universidad.universidad_nuevo_externo.create') }}"
        {{ url()->current() ==  route('universidad.universidad_nuevo_externo.create') ? "selected": "" }}>Nuevo Externo</option>

    <option value="{{ route('universidad.universidad_actividades_inscritos.index') }}"
        {{ url()->current() ==  route('universidad.universidad_actividades_inscritos.index') ? "selected": "" }}>Inscritos Actividades</option>

        <option value="{{ url('empleado') }}"
                    {{ url()->current() ==  url('empleado') ? "selected": "" }}>Instructores (Empleados)</option>

    
</optgroup>
@endif

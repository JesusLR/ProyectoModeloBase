@if (Auth::user()->secundaria == 1)

    @if (Auth::user()->departamento_control_escolar == 1)
        <optgroup label="Sec. Control Escolar">
        	{{--  materias   --}}
            <option value="{{ route('secundaria.secundaria_materia.index') }}" {{ url()->current() ==  route('secundaria.secundaria_materia.index') ? "selected": "" }}>Materias</option>
            {{--  Empleados   --}}
            <option value="{{ route('secundaria.secundaria_empleado.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_empleado.index') ? "selected": "" }}>Empleados / Docentes</option>
            {{--  Acceso de Docente   --}}
            <option value="{{ route('secundaria.secundaria_cambiar_contrasenia.index') }}"
            {{ url()->current() ==  route('secundaria.secundaria_cambiar_contrasenia.index') ? "selected": "" }}>Contraseña de Docentes</option>
            {{--  Agenda   --}}
            <option value="{{ route('secundaria.secundaria_calendario.index') }}"
            {{ url()->current() ==  route('secundaria.secundaria_calendario.index') ? "selected": "" }}>Agenda</option>
            <option value="{{ route('secundaria.secundaria_alumno.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_alumno.index') ? "selected": "" }}>Alumnos</option>

            <option value="{{ route('secundaria.secundaria_alumnos_restringidos.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_alumnos_restringidos.index') ? "selected": "" }}>Alumnos Restringidos</option>
        </optgroup>
    @endif

@endif

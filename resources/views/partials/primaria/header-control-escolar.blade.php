@if (Auth::user()->primaria == 1)

    @if (Auth::user()->departamento_control_escolar == 1)

        {{-- psicologas de primaria no lo ven --}}
        @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA")
        && (Auth::user()->username != "ANGELINAMICHELL"))

                <optgroup label="Prim. Control Escolar">
                    <option value="{{ route('primaria_alumno.index') }}"
                        {{ url()->current() ==  route('primaria_alumno.index') ? "selected": "" }}>Alumnos</option>
                </optgroup>
        @endif

                <optgroup label="Expediente">
                    <option value="{{ route('primaria.primaria_entrevista_inicial.index') }}"
                        {{ url()->current() ==  route('primaria.primaria_entrevista_inicial.index') ? "selected": "" }}>Entrevista Inicial </option>

                        <option value="{{ route('primaria.primaria_perfil.index') }}"
                        {{ url()->current() ==  route('primaria.primaria_perfil.index') ? "selected": "" }}>Perfiles </option>

                        <option value="{{ route('primaria.primaria_seguimiento_escolar.index') }}"
                        {{ url()->current() ==  route('primaria.primaria_seguimiento_escolar.index') ? "selected": "" }}>Seguimiento Escolar </option>

                        <option value="{{ route('primaria_calendario.index') }}"
                        {{ url()->current() ==  route('primaria_calendario.index') ? "selected": "" }}>Agenda </option>

                        <option value="{{ route('primaria.primaria_alumnos_excel') }}"
                {{ url()->current() ==  route('primaria.primaria_alumnos_excel') ? "selected": "" }}>Alumnos Excel </option>


                </optgroup>
    @endif
@endif

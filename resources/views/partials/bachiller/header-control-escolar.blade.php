@if (Auth::user()->bachiller == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1 || $userClave == "JIMENARIVERO")
        <optgroup label="BAC. Control Escolar">
        	{{--  materias   --}}
            <option value="{{ route('bachiller.bachiller_materia.index') }}" {{ url()->current() ==  route('bachiller.bachiller_materia.index') ? "selected": "" }}>Materias</option>
            {{--  Empleados   --}}
            <option value="{{ route('bachiller.bachiller_empleado.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_empleado.index') ? "selected": "" }}>Empleados / Docentes</option>
            {{--  Acceso de Docente   --}}    
            <option value="{{ route('bachiller.bachiller_cambiar_contrasenia.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_cambiar_contrasenia.index') ? "selected": "" }}>Contraseña de Docentes</option>
         
     

            @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)

            <option value="{{ route('bachiller.bachiller_horarios_administrativos') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos') ? "selected": "" }}>Horarios administrativos</option>

            <option value="{{ route('bachiller.bachiller_calendario_examen.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_calendario_examen.index') ? "selected": "" }}>Fechas Calendario Examen</option>


            <option value="{{ route('bachiller.bachiller_fechas_regularizacion.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_fechas_regularizacion.index') ? "selected": "" }}>Fechas de Regularización</option>


            <option value="{{ route('bachiller.bachiller_periodos_vacacionales.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_periodos_vacacionales.index') ? "selected": "" }}>Períodos Vacacionales</option>
            @endif

            @if (Auth::user()->campus_cch == 1)
                <option value="{{ route('bachiller.bachiller_calendario_examen_cch.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_calendario_examen_cch.index') ? "selected": "" }}>Fechas Calendario Examen</option>
            @endif

            
            {{--  Agenda   --}}
            <option value="{{ route('bachiller.bachiller_calendario.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_calendario.index') ? "selected": "" }}>Agenda</option>

            <option value="{{ route('bachiller.bachiller_justificaciones.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_justificaciones.index') ? "selected": "" }}>Justificaciones</option>

            @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)

            <option value="{{ route('bachiller.bachiller-portal-configuracion.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller-portal-configuracion.index') ? "selected": "" }}>Config. Portal</option>

            <option value="{{ route('bachiller.bachiller_alumnos_restringidos.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_alumnos_restringidos.index') ? "selected": "" }}>Alumnos Restringidos</option>

            <option value="{{ route('bachiller.bachiller_pago_certificado.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_pago_certificado.index') ? "selected": "" }}>Pago Certificado</option>
                

            
            @endif

            
            {{-- <option value="{{ route('bachiller.bachiller_alumno.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_alumno.index') ? "selected": "" }}>Alumnos</option> --}}
        </optgroup>
    @endif

@endif

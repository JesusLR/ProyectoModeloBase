{{--  valida si es preescolar o no  para mostrar la vista correspondiente  --}}
@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->maternal == 1)
        @php
            $userDepClave = "MAT";
        @endphp
    @endif
    @if (Auth::user()->preescolar == 1)
        @php
            $userDepClave = "PRE";
        @endphp
    @endif

    @if (Auth::user()->departamento_control_escolar == 1)

        <optgroup label="Control Escolar">
            {{--  Empleados   --}}
            <option value="{{ route('preescolar_empleado.index') }}" {{ url()->current() ==  route('preescolar_empleado.index') ? "selected": "" }}>Empleados</option>
            {{--  Alumnos   --}}
            <option value="{{ route('preescolar_alumnos.index') }}" {{ url()->current() ==  route('preescolar_alumnos.index') ? "selected": "" }}>Alumnos</option>
        </optgroup>

    @endif

@endif

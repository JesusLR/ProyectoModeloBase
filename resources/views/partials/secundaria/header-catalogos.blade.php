@if (Auth::user()->secundaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="Sec. Catálogos">
            {{--  programas  --}}
            <option value="{{ route('secundaria.secundaria_programa.index') }}" {{ url()->current() ==  route('secundaria.secundaria_programa.index') ? "selected": "" }}>Programas</option>
            {{--  planes   --}}
            <option value="{{ route('secundaria.secundaria_plan.index') }}" {{ url()->current() ==  route('secundaria.secundaria_plan.index') ? "selected": "" }}>Planes</option>
            {{--  periodos   --}}
            <option value="{{ route('secundaria.secundaria_periodo.index') }}" {{ url()->current() ==  route('secundaria.secundaria_periodo.index') ? "selected": "" }}>Períodos</option>
            {{--  materias   --}}
            <option value="{{ route('secundaria.secundaria_materia.index') }}" {{ url()->current() ==  route('secundaria.secundaria_materia.index') ? "selected": "" }}>Materias</option>
            {{--  cgts   --}}
            <option value="{{ route('secundaria.secundaria_cgt.index') }}" {{ url()->current() ==  route('secundaria.secundaria_cgt.index') ? "selected": "" }}>CGT</option>
            {{--  porcentajes   --}}
            <option value="{{ route('secundaria.secundaria_porcentaje.index') }}" {{ url()->current() ==  route('secundaria.secundaria_porcentaje.index') ? "selected": "" }}>Porcentajes</option>

            

        </optgroup>
    @endif

@endif

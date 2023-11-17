@if (Auth::user()->bachiller == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="Catálogos">
            {{--  programas  --}}
            <option value="{{ route('bachiller.bachiller_programa.index') }}" {{ url()->current() ==  route('bachiller.bachiller_programa.index') ? "selected": "" }}>Programas</option>
            {{--  planes   --}}
            <option value="{{ route('bachiller.bachiller_plan.index') }}" {{ url()->current() ==  route('bachiller.bachiller_plan.index') ? "selected": "" }}>Planes</option>
            {{--  periodos   --}}
            <option value="{{ route('bachiller.bachiller_periodo.index') }}" {{ url()->current() ==  route('bachiller.bachiller_periodo.index') ? "selected": "" }}>Períodos</option>
            {{--  materias   --}}
            <option value="{{ route('bachiller.bachiller_materia.index') }}" {{ url()->current() ==  route('bachiller.bachiller_materia.index') ? "selected": "" }}>Materias</option>
            {{--  cgts   --}}
            <option value="{{ route('bachiller.bachiller_cgt.index') }}" {{ url()->current() ==  route('bachiller.bachiller_cgt.index') ? "selected": "" }}>CGT</option>
            {{--  porcentajes   --}}
            <option value="{{ route('bachiller.bachiller_porcentaje.index') }}" {{ url()->current() ==  route('bachiller.bachiller_porcentaje.index') ? "selected": "" }}>Porcentajes</option>

            {{--  Migrar Inscritos ACD   --}}
            <option value="{{ route('bachiller.bachiller_migrar_inscritos_acd.index') }}" {{ url()->current() ==  route('bachiller.bachiller_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos ACD</option>

        </optgroup>
    @endif

@endif

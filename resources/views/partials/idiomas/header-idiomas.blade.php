@if (Auth::user()->idiomas == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->idiomas == 1 )
        <optgroup label="Academia de idiomas">
            <optgroup label="> IDI C.Escolarmnos">
                {{--  programas  --}}
                <option value="{{ route('idiomas.idiomas_programa.index') }}" {{ url()->current() ==  route('idiomas.idiomas_programa.index') ? "selected": "" }}>Programas</option>
                {{--  Niveles   --}}
                <option value="{{ route('idiomas.idiomas_nivel.index') }}" {{ url()->current() ==  route('idiomas.idiomas_nivel.index') ? "selected": "" }}>Niveles</option>
                {{--  Materias   --}}
                <option value="{{ route('idiomas.idiomas_materia.index') }}" {{ url()->current() ==  route('idiomas.idiomas_materia.index') ? "selected": "" }}>Materias</option>
                {{--  Cuotas   --}}
                <option value="{{ route('idiomas.idiomas_cuota.index') }}" {{ url()->current() ==  route('idiomas.idiomas_cuota.index') ? "selected": "" }}>Cuotas</option>
            </optgroup>
            <optgroup label="> IDI -Act. ExtraEscolares">
                {{--  programas  --}}
                <option value="{{ route('idiomas.idiomas_programa.index') }}" {{ url()->current() ==  route('idiomas.idiomas_programa.index') ? "selected": "" }}>Programas</option>
                {{--  Niveles   --}}
                <option value="{{ route('idiomas.idiomas_nivel.index') }}" {{ url()->current() ==  route('idiomas.idiomas_nivel.index') ? "selected": "" }}>Niveles</option>
                {{--  Materias   --}}
                <option value="{{ route('idiomas.idiomas_materia.index') }}" {{ url()->current() ==  route('idiomas.idiomas_materia.index') ? "selected": "" }}>Materias</option>
                {{--  Cuotas   --}}
                <option value="{{ route('idiomas.idiomas_cuota.index') }}" {{ url()->current() ==  route('idiomas.idiomas_cuota.index') ? "selected": "" }}>Cuotas</option>
            </optgroup>
        </optgroup>

        <optgroup label="Catálogos">
            {{--  programas  --}}
            <option value="{{ route('idiomas.idiomas_programa.index') }}" {{ url()->current() ==  route('idiomas.idiomas_programa.index') ? "selected": "" }}>Programas</option>
            {{--  Niveles   --}}
            <option value="{{ route('idiomas.idiomas_nivel.index') }}" {{ url()->current() ==  route('idiomas.idiomas_nivel.index') ? "selected": "" }}>Niveles</option>
            {{--  Materias   --}}
            <option value="{{ route('idiomas.idiomas_materia.index') }}" {{ url()->current() ==  route('idiomas.idiomas_materia.index') ? "selected": "" }}>Materias</option>
            {{--  Cuotas   --}}
            <option value="{{ route('idiomas.idiomas_cuota.index') }}" {{ url()->current() ==  route('idiomas.idiomas_cuota.index') ? "selected": "" }}>Cuotas</option>
        </optgroup>
    @endif

@endif

@if (Auth::user()->gimnasio == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->gimnasio == 1 )
        <optgroup label="Catálogos">
            {{--  tipos de usuarios  --}}
            <option value="{{ route('idiomas.idiomas_programa.index') }}" {{ url()->current() ==  route('idiomas.idiomas_programa.index') ? "selected": "" }}>Programas</option>
            {{--  usuarios   --}}
            <option value="{{ route('idiomas.idiomas_nivel.index') }}" {{ url()->current() ==  route('idiomas.idiomas_nivel.index') ? "selected": "" }}>Niveles</option>
        </optgroup>
    @endif

@endif

@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )
    {{--
    @if (Auth::user()->empleado->escuela->departamento->depClave == "SUP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "DIP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "AEX" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "IDI")
    --}}


        @if (Auth::user()->username == "DESARROLLO" || Auth::user()->username == "LLARA"
        || Auth::user()->username == "GIO"|| Auth::user()->username == "CESAURI"
        || Auth::user()->username == "EAIL")

            <optgroup label="Prefecteo">
                <option value="{{ url('prefecteo') }}" {{ url()->current() ==  url('prefecteo') ? "selected": "" }}>Lista de prefecteos</option>
                <option value="{{ url('aulas_en_clase') }}" {{ url()->current() ==  url('aulas_en_clase') ? "selected": "" }}>Aulas en clase</option>
                <option value="{{ url('aulas/ocupadas') }}" {{ url()->current() ==  url('aulas/ocupadas') ? "selected": "" }}>Aulas ocupadas por Escuelas</option>
            </optgroup>

        @endif

@endif

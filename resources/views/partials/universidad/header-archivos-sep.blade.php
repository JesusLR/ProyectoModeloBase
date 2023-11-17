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


            <optgroup label="Archivos SEP">
                <option value="{{ url('archivo/grupo') }}" {{ url()->current() ==  url('archivo/grupo') ? "selected": "" }}>Grupos SEP</option>
                <option value="{{ url('archivo/inscripcion') }}" {{ url()->current() ==  url('archivo/inscripcion') ? "selected": "" }}>Inscripciones SEP</option>
                <option value="{{ url('archivo/ordinario') }}"  {{ url()->current() ==  url('archivo/ordinario') ? "selected": "" }}>Ordinarios SEP</option>
                <option value="{{ url('archivo/extraordinario') }}" {{ url()->current() ==  url('archivo/extraordinario') ? "selected": "" }}>Extraordinarios SEP</option>
                @if (Auth::user()->username == "DESARROLLO")
                    <option value="{{ url('archivo/control_estados') }}" {{ url()->current() ==  url('archivo/control_estados') ? "selected": "" }}>Control de estados</option>
                @endif
            </optgroup>

        @endif

@endif

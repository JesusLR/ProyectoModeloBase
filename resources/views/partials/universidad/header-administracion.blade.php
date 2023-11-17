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

        <optgroup label="Administración">
            <option value="{{ url('permiso') }}" {{ url()->current() ==  url('permiso') ? "selected": "" }}>Crear permisos</option>
            <option value="{{ url('modulo') }}" {{ url()->current() ==  url('modulo') ? "selected": "" }}>Crear modulos</option>
            <option value="{{ url('permiso/modulo') }}" {{ url()->current() ==  url('permiso/modulo') ? "selected": "" }}>Crear permiso-modulo</option>
            <option value="{{ url('usuario') }}" {{ url()->current() ==  url('usuario') ? "selected": "" }}>Usuarios</option>
            <option value="{{ url('portal-configuracion') }}" {{ url()->current() ==  url('portal-configuracion') ? "selected": "" }}>Configuración</option>
        </optgroup>

    @endif


@endif

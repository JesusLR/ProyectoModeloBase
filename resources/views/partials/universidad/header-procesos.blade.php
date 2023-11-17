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

        @if (in_array(auth()->user()->permiso('p_pago'), ['A', 'B']))
            <optgroup label="Procesos">
                <option value="{{ url('proceso/pago') }}" {{ url()->current() ==  url('proceso/pago') ? "selected": "" }}>Aplica pagos</option>
                <option value="{{ url('contabilidad/alumnos') }}" {{ url()->current() ==  url('contabilidad/alumnos') ? "selected": "" }}>Excel Alumnos</option>
                <option value="{{ url('contabilidad/fichas') }}" {{ url()->current() ==  url('contabilidad/fichas') ? "selected": "" }}>Excel Fichas</option>
                <option value="{{ url('contabilidad/referencias') }}" {{ url()->current() ==  url('contabilidad/referencias') ? "selected": "" }}>Excel Referencias</option>
                <option value="{{ url('proceso/excel_pagos') }}" {{ url()->current() ==  url('proceso/excel_pagos') ? "selected": "" }}>Excel Pagos</option>
            </optgroup>
        @endif

@endif

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

                <optgroup label="Gimnasio">
                    <option value="{{ url('usuariogim') }}" {{ url()->current() ==  url('usuariogim') ? "selected": "" }}>Lista de usuarios</option>
                    <option value="{{ url('reporte/gimnasio_pagos_aplicados') }}" {{ url()->current() ==  url('reporte/gimnasio_pagos_aplicados') ? "selected": "" }}>Pagos Aplicados</option>
                </optgroup>

            @endif

@endif

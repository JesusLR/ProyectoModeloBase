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
            || Auth::user()->username == "FLOPEZH" || Auth::user()->username == "MCUEVAS"
            || Auth::user()->username == "SRIVERO"
            || Auth::user()->username == "JPEREIRA" || Auth::user()->username == "MARIANAT"
            || Auth::user()->username == "MAGUI" || Auth::user()->username == "MARTHA"
            || Auth::user()->username == "GPEREZ" || Auth::user()->username == "MELIBETH"
            || Auth::user()->username == "EAIL" || Auth::user()->username == "ARIVERO"
            || Auth::user()->username == "NLOPEZ" || Auth::user()->username == "MERCEDES"
            || Auth::user()->username == "MCARRILLO"|| Auth::user()->username == "HRIVAS"
            || Auth::user()->username == "DENISECG"
            || Auth::user()->username == "MARTHA"|| Auth::user()->username == "CESAURI")
                    <optgroup label="Pagos">
                        <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

                        @if (Auth::user()->username != "MAGUI" && Auth::user()->username != "MARTHA"
                          && Auth::user()->username != "GPEREZ" && Auth::user()->username != "MELIBETH"
                          && Auth::user()->username != "HRIVAS"&& Auth::user()->username != "DENISECG")
                            <option value="{{ url('pagos/aplicar_pagos') }}" {{ url()->current() ==  url('pagos/aplicar_pagos') ? "selected": "" }}>Consultar pagos</option>
                        @endif
                        <option value="{{ url('pagos/consulta_fichas') }}" {{ url()->current() ==  url('pagos/consulta_fichas') ? "selected": "" }}>Consulta de fichas</option>
                        <option value="{{ url('/concepto_pago') }}" {{ url()->current() ==  url('/concepto_pago') ? "selected": "" }}>Conceptos de pago</option>
                        <option value="{{ url('becas_historial/cursos') }}" {{ url()->current() ==  url('becas_historial/cursos') ? "selected": "" }}>Historial de becas</option>
                    </optgroup>
        @endif


@endif

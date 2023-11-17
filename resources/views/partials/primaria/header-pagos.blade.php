@if (Auth::user()->primaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    {{-- SI LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if (Auth::user()->departamento_cobranza == 1)

        <optgroup label="Pagos">
            <option value="{{ url('pagos/ficha_general') }}"
                {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

            @if ($userClave == "FLOPEZH")

            <option value="{{ url('primaria/pagos/aplicar_pagos') }}"
                {{ url()->current() ==  url('primaria/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>
            @endif

        </optgroup>
    @endif


@endif

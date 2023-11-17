@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}
        {{-- PREESCOLAR --}}
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp

        @if (Auth::user()->departamento_cobranza == 1)

            <optgroup label="Pagos">
              {{--  Ficha general   --}}
              <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

                @if ( $userClave == "FLOPEZH" )
                    {{--  Pagos Manuales   --}}
                    <option value="{{ url('preescolar/pagos/aplicar_pagos') }}" {{ url()->current() ==  url('preescolar/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>

                @endif


            </optgroup>

        @endif


@endif

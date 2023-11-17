{{--  valida si es preescolar o no  para mostrar la vista correspondiente  --}}
@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)

        <optgroup label="Preescolar">
            {{--  Alumnos   --}}
            <option value="{{ route('preescolar_alumnos.index') }}" {{ url()->current() ==  route('preescolar_alumnos.index') ? "selected": "" }}>Alumnos</option>

            {{--  Preinscritos   --}}
            <option value="{{ route('curso_preescolar.index') }}" {{ url()->current() ==  route('curso_preescolar.index') ? "selected": "" }}>Preinscritos</option>

            @if ( $userClave == "FLOPEZH"  || $userClave == "REBECAR" || $userClave == "MFERNANDA"
                || $userClave == "SUSANA" || $userClave == "DIONEDPENICHE" || $userClave == "CSAURI")
                <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>
            @endif

            @if ( $userClave == "FLOPEZH" || $userClave == "SUSANA" || $userClave == "ARIVERO" || $userClave == "CSAURI")
                {{--  Pagos Manuales   --}}
                <option value="{{ url('preescolar/pagos/aplicar_pagos') }}" {{ url()->current() ==  url('preescolar/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>

            @endif

            <option value="{{ route('preescolar_inscrito_preinscrito.create') }}"
                {{ url()->current() ==  route('preescolar_inscrito_preinscrito.create') ? "selected": "" }}>Inscritos y preinscritos</option>

            {{--  Resumen inscritos   --}}
            <option value="{{ url('reporte/preescolar_resumen_inscritos') }}"
                {{ url()->current() ==  url('reporte/preescolar_resumen_inscritos') ? "selected": "" }}>Resumen inscritos PRE</option>


            <option value="{{ url('reporte/preescolar_relacion_deudas') }}"
                {{ url()->current() ==  url('reporte/preescolar_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

            {{--  Resumen inscritos   --}}
            <option value="{{ url('reporte/preescolar_relacion_deudores') }}"
                {{ url()->current() ==  url('reporte/preescolar_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

            <option value="{{ url('reporte/relacion_deudores_pagos_anuales') }}"
                {{ url()->current() ==  url('reporte/relacion_deudores_pagos_anuales') ? "selected": "" }}>Pagos Recibidos</option>

            @if(in_array(Auth::user()->permiso('recordatorioPagos'), ['A', 'B', 'C']))
                <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option>
            @endif


        </optgroup>

    @endif

@endif

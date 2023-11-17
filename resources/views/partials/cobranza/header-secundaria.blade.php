@if (Auth::user()->secundaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)
        <optgroup label="Secundaria">
            <option value="{{ route('secundaria.secundaria_alumno.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_alumno.index') ? "selected": "" }}>Alumnos</option>

           {{--  Empleados   --}}
            <option value="{{ route('secundaria.secundaria_empleado.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_empleado.index') ? "selected": "" }}>&nbsp;&nbsp;Empleados / Docentes</option>

            @if ( $userClave == "FLOPEZH"  || $userClave == "REBECAR" || $userClave == "MFERNANDA"
                 || $userClave == "SUSANA" || $userClave == "MARIANAT" || $userClave == "MCARRILLO"
                 || $userClave == "DIONEDPENICHE" || $userClave == "CSAURI")

                <option value="{{ url('pagos/ficha_general') }}"
                    {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>
            @endif


            @if ($userClave == "FLOPEZH" || $userClave == "ARIVERO" || $userClave == "MARIANAT"
                || $userClave == "MCARRILLO" || $userClave == "SUSANA" || $userClave == "CSAURI")

                <option value="{{ url('secundaria/pagos/aplicar_pagos') }}"
                    {{ url()->current() ==  url('secundaria/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>
            @endif

            <option value="{{ route('secundaria_inscrito_preinscrito.reporte') }}"
                {{ url()->current() ==  route('secundaria_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

            <option value="{{ url('reporte/secundaria_resumen_inscritos') }}"
                {{ url()->current() ==  url('reporte/secundaria_resumen_inscritos') ? "selected": "" }}>Resumen de inscritos SEC</option>

            {{--  Reporte de alumnos becados   --}}
            <option value="{{ route('secundaria_reporte.secundaria_alumnos_becados.reporte') }}"
                {{ url()->current() ==  route('secundaria_reporte.secundaria_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>

            {{--  Relación de bajas   --}}
            <option value="{{ route('secundaria.secundaria_relacion_bajas_periodo.reporte') }}"
                {{ url()->current() ==  route('secundaria.secundaria_relacion_bajas_periodo.reporte') ? "selected": "" }}>Rel. alumnos becados</option>


            {{--  Deudas de un Alumno  --}}
            <option value="{{ url('reporte/secundaria_relacion_deudas') }}"
                {{ url()->current() ==  url('reporte/secundaria_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

            {{--  relacion deudores  --}}
            <option value="{{ url('reporte/secundaria_relacion_deudores') }}"
                {{ url()->current() ==  url('reporte/secundaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

            <option value="{{ url('reporte/relacion_deudores_pagos_anuales') }}"
                {{ url()->current() ==  url('reporte/relacion_deudores_pagos_anuales') ? "selected": "" }}>Pagos Recibidos</option>
                
            @if(in_array(Auth::user()->permiso('recordatorioPagos'), ['A', 'B', 'C']))
                <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option>
            @endif

        </optgroup>
    @endif

@endif

@if (Auth::user()->bachiller == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)
        <optgroup label="Bachiller">
            <option value="{{ route('bachiller.bachiller_alumno.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_alumno.index') ? "selected": "" }}>Alumnos</option>

           {{--  Empleados   --}}
            <option value="{{ route('bachiller.bachiller_empleado.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_empleado.index') ? "selected": "" }}>&nbsp;&nbsp;Empleados / Docentes</option>

            @if ( $userClave == "FLOPEZH"  || $userClave == "REBECAR" || $userClave == "MFERNANDA"
                 || $userClave == "SUSANA" || $userClave == "MARIANAT" || $userClave == "MCARRILLO" ||
                $userClave == "DIONEDPENICHE" || $userClave == "CSAURI")

                <option value="{{ url('pagos/ficha_general') }}"
                    {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>
            @endif


            @if ($userClave == "FLOPEZH" || $userClave == "ARIVERO" || $userClave == "MARIANAT"
                || $userClave == "MCARRILLO" || $userClave == "SUSANA" || $userClave == "CSAURI")

                <option value="{{ url('bachiller/pagos/aplicar_pagos') }}"
                    {{ url()->current() ==  url('bachiller/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>
            @endif

            <option value="{{ route('bachiller_inscrito_preinscrito.reporte') }}"
                {{ url()->current() ==  route('bachiller_inscrito_preinscrito.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inscritos y preinscritos</option>

            <option value="{{ url('reporte/bachiller_resumen_inscritos') }}"
                {{ url()->current() ==  url('reporte/bachiller_resumen_inscritos') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Resumen de inscritos</option>

            {{--  Reporte de alumnos becados   --}}
            <option value="{{ route('bachiller_reporte.bachiller_alumnos_becados.reporte') }}"
                {{ url()->current() ==  route('bachiller_reporte.bachiller_alumnos_becados.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. alumnos becados</option>

            {{--  Relación de bajas   --}}
            <option value="{{ route('bachiller.bachiller_relacion_bajas_periodo.reporte') }}"
                {{ url()->current() ==  route('bachiller.bachiller_relacion_bajas_periodo.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. de Bajas</option>


            {{--  Deudas de un Alumno  --}}
            <option value="{{ url('reporte/bachiller_relacion_deudas') }}"
                {{ url()->current() ==  url('reporte/bachiller_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

            {{--  relacion deudores  --}}
            <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

            <option value="{{ url('reporte/relacion_deudores_pagos_anuales') }}"
                {{ url()->current() ==  url('reporte/relacion_deudores_pagos_anuales') ? "selected": "" }}>Pagos Recibidos</option>
            <option value="{{ url('reporte/estado_cuenta') }}" {{ url()->current() ==  url('reporte/estado_cuenta') ? "selected": "" }}>Estado de Cuenta</option>
            @if ($userClave == "FLOPEZH" || $userClave == "SUSANA" || $userClave == "CSAURI")
             <option value="{{ url('reporte/resumen_deudores') }}" {{ url()->current() ==  url('reporte/resumen_deudores') ? "selected": "" }}>Resumen Deudores</option>
            @endif
            @if(in_array(Auth::user()->permiso('recordatorioPagos'), ['A', 'B', 'C']))
                <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option>
            @endif

        </optgroup>
    @endif

@endif

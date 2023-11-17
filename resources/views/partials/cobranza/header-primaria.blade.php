@if (Auth::user()->primaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_cobranza == 1)

                <optgroup label="Primaria">

                    <option value="{{ route('primaria_alumno.index') }}"
                        {{ url()->current() ==  route('primaria_alumno.index') ? "selected": "" }}>Alumnos</option>

                    <option value="{{ route('primaria_curso.index') }}"
                        {{ url()->current() ==  route('primaria_curso.index') ? "selected": "" }}>Preinscritos</option>

                    @if ( $userClave == "FLOPEZH"  || $userClave == "REBECAR" || $userClave == "MFERNANDA"
                        || $userClave == "SUSANA" || $userClave == "DIONEDPENICHE" || $userClave == "CSAURI")
                        <option value="{{ url('pagos/ficha_general') }}"
                            {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>
                    @endif

                    @if ( $userClave == "FLOPEZH" || $userClave == "SUSANA" || $userClave == "ARIVERO" || $userClave == "CSAURI")

                        <option value="{{ url('primaria/pagos/aplicar_pagos') }}"
                            {{ url()->current() ==  url('primaria/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>
                    @endif

                    <option value="{{ route('primaria_inscrito_preinscrito.reporte') }}"
                        {{ url()->current() ==  route('primaria_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                    <option value="{{ url('reporte/primaria_resumen_inscritos') }}"
                        {{ url()->current() ==  url('reporte/primaria_resumen_inscritos') ? "selected": "" }}>Resumen inscritos PRI</option>

                    <option value="{{ route('primaria_reporte.primaria_alumnos_becados.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.primaria_alumnos_becados.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. alumnos becados</option>

                    {{-- Relación de Bajas --}}
                    <option value="{{ route('primaria.primaria_relacion_bajas_periodo.reporte') }}"
                        {{ url()->current() ==  route('primaria.primaria_relacion_bajas_periodo.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. de bajas</option>


                    {{--  Deudas de un Alumno  --}}
                    <option value="{{ url('reporte/primaria_relacion_deudas') }}"
                        {{ url()->current() ==  url('reporte/primaria_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

                    <option value="{{ url('reporte/primaria_relacion_deudores') }}"
                        {{ url()->current() ==  url('reporte/primaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

                    <option value="{{ url('reporte/relacion_deudores_pagos_anuales') }}"
                        {{ url()->current() ==  url('reporte/relacion_deudores_pagos_anuales') ? "selected": "" }}>Pagos Recibidos</option>

                    @if(in_array(Auth::user()->permiso('recordatorioPagos'), ['A', 'B', 'C']))
                        <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option>
                    @endif
                        
                </optgroup>
    @endif


@endif

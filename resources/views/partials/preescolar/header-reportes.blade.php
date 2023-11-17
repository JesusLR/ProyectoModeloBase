@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)
        <optgroup label="Reportes">
            {{--  Catálogos   --}}
            <optgroup label="&nbsp;Catálogos">
                <option value="{{ route('reporte.preescolar_rubricas.reporte') }}"
                {{ url()->current() ==  route('reporte.preescolar_rubricas.reporte') ? "selected": "" }}>Rúbricas</option>
            </optgroup>
            {{-- Alumnos --}}
            <optgroup label="&nbsp;Alumnos">
                <option value="{{ route('preescolar_inscrito_preinscrito.create') }}"
                {{ url()->current() ==  route('preescolar_inscrito_preinscrito.create') ? "selected": "" }}>Inscritos y preinscritos</option>

                {{--  Resumen inscritos   --}}
                <option value="{{ url('reporte/preescolar_resumen_inscritos') }}"
                {{ url()->current() ==  url('reporte/preescolar_resumen_inscritos') ? "selected": "" }}>Resumen inscritos</option>

                {{--  Reporte de alumnos becados   --}}
                <option value="{{ route('primaria_reporte.primaria_alumnos_becados.reporte') }}"
                {{ url()->current() ==  route('primaria_reporte.primaria_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>
            </optgroup>

            {{-- Pagos --}}
            @if(  Auth::user()->departamento_cobranza == 1 )
                <optgroup label="&nbsp;Pagos">
                    <option value="{{ url('reporte/preescolar_relacion_deudas') }}"
                    {{ url()->current() ==  url('reporte/preescolar_relacion_deudas') ? "selected": "" }}>Deudas de un Alumn</option>

                    {{--  Resumen inscritos   --}}
                    <option value="{{ url('reporte/preescolar_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/preescolar_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

                    {{--  Becas por Campus, Programa y Escuela  --}}
                    <option value="{{ url('reporte/becas_campus_carrera_escuela') }}"
                    {{ url()->current() ==  url('reporte/becas_campus_carrera_escuela') ? "selected": "" }}>Montos de Becas</option>

                </optgroup>

            @endif
        </optgroup>
    @endif

@endif

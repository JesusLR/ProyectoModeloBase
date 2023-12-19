@if (Auth::user()->primaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

        <optgroup label="Prim. Reportes">
                {{-- Alumnos --}}
                <optgroup label="&nbsp;Alumnos">

                    {{-- psicologas de primaria no lo ven --}}
                    @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA") && (Auth::user()->username != "ANGELINAMICHELL"))

                                <option value="{{ route('primaria_inscrito_preinscrito.reporte') }}"
                                {{ url()->current() ==  route('primaria_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                                <option value="{{ url('reporte/primaria_resumen_inscritos') }}"
                                    {{ url()->current() ==  url('reporte/primaria_resumen_inscritos') ? "selected": "" }}>Resumen inscritos</option>
                    @endif


                    <option value="{{ route('primaria.primaria_lista_edades.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_lista_edades.index') ? "selected": "" }}>Lista de edades</option>
                    {{--  Expediente de alumnos   --}}
                    <option value="{{ route('primaria_reporte.expediente_alumnos.index') }}"
                    {{ url()->current() ==  route('primaria_reporte.expediente_alumnos.index') ? "selected": "" }}>Expediente de alumnos</option>

                    <option value="{{ route('primaria.primaria_estatus_preescolar.reporte') }}"
                    {{ url()->current() ==  route('primaria.primaria_estatus_preescolar.reporte') ? "selected": "" }}>Estudiaron Preescolar</option>

                    <option value="{{ route('primaria_reporte.ficha_tecnica.index') }}"
                    {{ url()->current() ==  route('primaria_reporte.ficha_tecnica.index') ? "selected": "" }}>Ficha técnica</option>

                    <option value="{{ route('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte') ? "selected": "" }}>Lista Presencial-Virtual</option>

                    {{-- psicologas de primaria no lo ven --}}
                    @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA") && (Auth::user()->username != "ANGELINAMICHELL"))

                            {{--  Reporte de alumnos becados   --}}
                            <option value="{{ route('primaria_reporte.primaria_alumnos_becados.reporte') }}"
                            {{ url()->current() ==  route('primaria_reporte.primaria_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>

                            {{-- Relación de Bajas --}}
                            <option value="{{ route('primaria.primaria_relacion_bajas_periodo.reporte') }}"
                            {{ url()->current() ==  route('primaria.primaria_relacion_bajas_periodo.reporte') ? "selected": "" }}>Rel. de bajas</option>

                            <option value="{{ route('primaria.reporte.ahorro_escolar.index') }}"
                            {{ url()->current() ==  route('primaria.reporte.ahorro_escolar.index') ? "selected": "" }}>Ahorro</option>
                    @endif


                    <option value="{{ route('primaria.primaria_perfil_alumno.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_perfil_alumno.index') ? "selected": "" }}>Perfiles</option>


                        <option value="{{ route('primaria.primaria_relacion_tutores.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_relacion_tutores.index') ? "selected": "" }}>Rel. de Familia/Tutores</option>
                </optgroup>

                <optgroup label="&nbsp;Constancias">

                    {{--  Calificaciones de grupo  --}}
                    <option value="{{ route('primaria_reporte.constancia_cupo.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.constancia_cupo.reporte') ? "selected": "" }}>Constancia Cupo</option>
    
                    {{--  Calificaciones por materia  --}}
                    <option value="{{ route('primaria_reporte.constancia_estudio.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.constancia_estudio.reporte') ? "selected": "" }}>Constancia Estudio</option>

                    <option value="{{ route('primaria_reporte.no_adeudo.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.no_adeudo.reporte') ? "selected": "" }}>Constancia No Adeudo</option>

                    <option value="{{ route('primaria.primaria_buena_conducta.reporte') }}"
                        {{ url()->current() ==  route('primaria.primaria_buena_conducta.reporte') ? "selected": "" }}>Constancia Buena conducta</option>

                    <option value="{{ route('primaria_reporte.constancia_pasaporte.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.constancia_pasaporte.reporte') ? "selected": "" }}>Constancia Pasaporte</option>
                </optgroup>

                {{-- psicologas de primaria no lo ven --}}
                @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA") && (Auth::user()->username != "ANGELINAMICHELL"))

                    <optgroup label="&nbsp;Calificaciones">

                        {{--  Calificaciones de grupo  --}}
                        <option value="{{ route('primaria_reporte.calificaciones_grupo.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.calificaciones_grupo.reporte') ? "selected": "" }}>Res. por grupo</option>
                        <option value="{{ route('primaria.calificaciones_grupo_campos_formativos.reporte') }}"
                        {{ url()->current() ==  route('primaria.calificaciones_grupo_campos_formativos.reporte') ? "selected": "" }}>Res. por grupo Campos Formativos</option>
                        {{--  Calificaciones por materia  --}}
                        <option value="{{ route('primaria_reporte.calificacion_por_materia.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.calificacion_por_materia.reporte') ? "selected": "" }}>Res. por materia</option>

                        {{--  Calificaciones ingles  --}}
                        <option value="{{ route('primaria_calificacion_materia_ingles.index') }}"
                        {{ url()->current() ==  route('primaria_calificacion_materia_ingles.index') ? "selected": "" }}>Res. de Inglés</option>

                        {{--  Boleta  --}}
                        <option value="{{ route('primaria.primaria_boleta_de_calificaciones.reporteBoleta') }}"
                        {{ url()->current() ==  route('primaria.primaria_boleta_de_calificaciones.reporteBoleta') ? "selected": "" }}>Boleta</option>

                        {{--  Boleta ACD --}}
                        <option value="{{ route('primaria.primaria_boleta_de_calificaciones_acd.reporteBoleta') }}"
                        {{ url()->current() ==  route('primaria.primaria_boleta_de_calificaciones_acd.reporteBoleta') ? "selected": "" }}>Boleta ACD</option>

                        <option value="{{ route('primaria.primaria_historial_alumno.reporte') }}"
                        {{ url()->current() ==  route('primaria.primaria_historial_alumno.reporte') ? "selected": "" }}>Historial académico del alumno</option>

                        <option value="{{ route('primaria_reporte.calificaciones_faltantes.reporte') }}"
                            {{ url()->current() ==  route('primaria_reporte.calificaciones_faltantes.reporte') ? "selected": "" }}>Calificaciones Faltantes</option>

                        <option value="{{ route('primaria.primaria_mejores_promedios.reporte') }}"
                            {{ url()->current() ==  route('primaria.primaria_mejores_promedios.reporte') ? "selected": "" }}>Mejores Promedios</option>
                    </optgroup>

                    <optgroup label="&nbsp;Docentes">

                        {{--  Rel. Grupos Maestros  --}}
                        <option value="{{ route('primaria_relacion_maestros_escuela.reporte') }}"
                        {{ url()->current() ==  route('primaria_relacion_maestros_escuela.reporte') ? "selected": "" }}>Rel. Grupos Maestros</option>

                        {{--  Rel. Grupos ACD  --}}
                        <option value="{{ route('primaria_reporte.relacion_maestros_acd.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.relacion_maestros_acd.reporte') ? "selected": "" }}>Rel. Grupos ACD</option>

                        <option value="{{ route('primaria.reporte.planeacion_docente.index') }}"
                        {{ url()->current() ==  route('primaria.reporte.planeacion_docente.index') ? "selected": "" }}>Planeación</option>

                    </optgroup>

                    <optgroup label="&nbsp;Grupos">

                        {{--  Lista de asistencia  --}}
                        {{--  <option value="{{ route('primaria_reporte.lista_de_asistencia.reporte') }}"
                        {{ url()->current() ==  route('primaria_reporte.lista_de_asistencia.reporte') ? "selected": "" }}>&nbsp;&nbsp;Lista de asistencia</option>  --}}

                        <option value="{{ route('primaria.primaria_asistencia_grupo.reporte') }}"
                        {{ url()->current() ==  route('primaria.primaria_asistencia_grupo.reporte') ? "selected": "" }}>Asistencia por grupo</option>

                        <option value="{{ route('primaria.primaria_grupo_materia.reporte') }}"
                        {{ url()->current() ==  route('primaria.primaria_grupo_materia.reporte') ? "selected": "" }}>Asistencia por materia</option>

                        <option value="{{ route('primaria.primaria_faltas.reporte') }}"
                        {{ url()->current() ==  route('primaria.primaria_faltas.reporte') ? "selected": "" }}>Faltas Alumno</option>

                        {{--  lista de asistencia ACD  --}}
                        <option value="{{ route('primaria_reporte.lista_de_asistencia_ACD.reporteACD') }}"
                        {{ url()->current() ==  route('primaria_reporte.lista_de_asistencia_ACD.reporteACD') ? "selected": "" }}>Lista de asistencia ACD</option>

                    </optgroup>

                @endif

                {{--  solo valladolid   --}}
                @if (Auth::user()->id == 176 || Auth::user()->id == 198)
                <optgroup label="&nbsp;Pagos PRI">

                    {{--  lista de asistencia ACD  --}}
                    <option value="{{ url('reporte/primaria_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/primaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores PRI</option>

                </optgroup>
                @endif
                {{-- Pagos --}}
                @if (Auth::user()->departamento_cobranza == 1
                    || $userClave == "MARIANAT")

                        <optgroup label="&nbsp;Pagos PRI">

                            {{--  Deudas de un Alumno  --}}
                            <option value="{{ url('reporte/primaria_relacion_deudas') }}"
                            {{ url()->current() ==  url('reporte/primaria_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

                            {{--  lista de asistencia ACD  --}}
                            <option value="{{ url('reporte/primaria_relacion_deudores') }}"
                            {{ url()->current() ==  url('reporte/primaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

                            {{--  Becas por Campus, Programa y Escuela  --}}
                            <option value="{{ url('reporte/becas_campus_carrera_escuela') }}"
                            {{ url()->current() ==  url('reporte/becas_campus_carrera_escuela') ? "selected": "" }}>Montos de Becas</option>

                        </optgroup>

                @endif

        </optgroup>

    @endif

@endif

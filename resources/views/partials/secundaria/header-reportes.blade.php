@if (Auth::user()->secundaria == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

            <optgroup label="Sec. Reportes">
                {{-- Alumnos --}}
                <optgroup label="&nbsp;Alumnos">
                    <option value="{{ route('secundaria_inscrito_preinscrito.reporte') }}"
                    {{ url()->current() ==  route('secundaria_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                    <option value="{{ url('reporte/secundaria_resumen_inscritos') }}"
                        {{ url()->current() ==  url('reporte/secundaria_resumen_inscritos') ? "selected": "" }}>Resumen de inscritos</option>


                    {{--  Expediente de alumnos   --}}
                    <option value="{{ route('secundaria_reporte.expediente_alumnos.index') }}"
                    {{ url()->current() ==  route('secundaria_reporte.expediente_alumnos.index') ? "selected": "" }}>Expediente de alumnos</option>

                    {{--  Reporte de alumnos becados   --}}
                    <option value="{{ route('secundaria_reporte.secundaria_alumnos_becados.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.secundaria_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>

                    {{--  Relación de bajas   --}}
                    <option value="{{ route('secundaria.secundaria_relacion_bajas_periodo.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_relacion_bajas_periodo.reporte') ? "selected": "" }}>Rel. alumnos becados</option>


                    {{-- Rel. de Familia/Tutores --}}
                    <option value="{{ route('secundaria.secundaria_relacion_tutores.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_relacion_tutores.index') ? "selected": "" }}>Rel. alumnos becados</option>

                    
                    <option value="{{ route('secundaria.secundaria_alumnos_excel.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_alumnos_excel.index') ? "selected": "" }}>Alumnos Excel</option>

                    <option value="{{ route('secundaria.secundaria_alumnos_no_inscritos_materias.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_alumnos_no_inscritos_materias.index') ? "selected": "" }}>Alumnos no inscritos</option>

                    <option value="{{ route('secundaria.secundaria_alumnos_inscritos_acd.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_alumnos_inscritos_acd.index') ? "selected": "" }}>Alumnos inscritos ACD</option>

                    <option value="{{ route('secundaria.secundaria_acd_faltantes.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_acd_faltantes.reporte') ? "selected": "" }}>Alumnos No inscritos ACD</option>

                    <option value="{{ route('secundaria.secundaria_no_inscritos.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_no_inscritos.reporte') ? "selected": "" }}>Alumnos No inscritos (Base)</option>

                    
                </optgroup>

                {{--  constancias   --}}
                <optgroup label="&nbsp;Constancias">
                    <option value="{{ route('secundaria.secundaria_constancia_buena_conducta.reporte') }}"
                        {{ url()->current() ==  route('secundaria.secundaria_constancia_buena_conducta.reporte') ? "selected": "" }}>Buena Conducta</option>

                    <option value="{{ route('secundaria.secundaria_constancia_estudios.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_constancia_estudios.reporte') ? "selected": "" }}>Estudios</option>
                    
                </optgroup>

                <optgroup label="&nbsp;Calificaciones">

                    {{--  Calificaciones de grupo  --}}
                    <option value="{{ route('secundaria_reporte.calificaciones_grupo.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.calificaciones_grupo.reporte') ? "selected": "" }}>Lista de Calificaciones</option>

                    <option value="{{ route('secundaria.secundaria_resumen_de_calificaciones.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_resumen_de_calificaciones.index') ? "selected": "" }}>Res. de calificaciones</option>

                    <option value="{{ route('secundaria.secundaria_resumen_de_calificaciones_trim.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_resumen_de_calificaciones_trim.index') ? "selected": "" }}>Res. de Calif. Trimestres</option>

                    {{--  Calificaciones por materia  --}}
                    <option value="{{ route('secundaria_reporte.calificacion_por_materia.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.calificacion_por_materia.reporte') ? "selected": "" }}>Res. por materia</option>

                    {{--  Calificaciones ingles  --}}
                    {{--  <option value="{{ route('secundaria_calificacion_materia_ingles.index') }}"
                    {{ url()->current() ==  route('secundaria_calificacion_materia_ingles.index') ? "selected": "" }}>&nbsp; Res. de Inglés</option>  --}}

                    {{--  Boleta  --}}
                    <option value="{{ route('secundaria.secundaria_boleta_de_calificaciones.reporteBoleta') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_boleta_de_calificaciones.reporteBoleta') ? "selected": "" }}>Boleta</option>

                    {{--  Boleta ACD --}}
                    <option value="{{ route('secundaria.secundaria_boleta_de_calificaciones_acd.reporteBoleta') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_boleta_de_calificaciones_acd.reporteBoleta') ? "selected": "" }}>Boleta ACD</option>

                    <option value="{{ route('secundaria.secundaria_historial_alumno.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_historial_alumno.reporte') ? "selected": "" }}>Historial académico del alumno</option>

                    <option value="{{ route('secundaria_reporte.calificaciones_faltantes.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.calificaciones_faltantes.reporte') ? "selected": "" }}>Calificaciones Faltantes</option>
                </optgroup>

                <optgroup label="&nbsp;Docentes">

                    {{--  Rel. Grupos Maestros  --}}
                    <option value="{{ route('secundaria_relacion_maestros_escuela.reporte') }}"
                    {{ url()->current() ==  route('secundaria_relacion_maestros_escuela.reporte') ? "selected": "" }}>Rel. Grupos Maestros</option>

                    {{--  Rel. Grupos ACD  --}}
                    <option value="{{ route('secundaria_reporte.relacion_maestros_acd.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.relacion_maestros_acd.reporte') ? "selected": "" }}>Rel. Grupos ACD</option>

                </optgroup>


                <optgroup label="&nbsp;Grupos">

                    {{--  Lista de asistencia  --}}
                    {{--  <option value="{{ route('secundaria_reporte.lista_de_asistencia.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.lista_de_asistencia.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de asistencia</option>  --}}

                    <option value="{{ route('secundaria.secundaria_asistencia_grupo.reporte') }}"
                        {{ url()->current() ==  route('secundaria.secundaria_asistencia_grupo.reporte') ? "selected": "" }}>Asistencia por grupo</option>
                    

                    <option value="{{ route('secundaria.secundaria_grupo_materia.reporte') }}"
                        {{ url()->current() ==  route('secundaria.secundaria_grupo_materia.reporte') ? "selected": "" }}>Asistencia por materia</option>
                    


                    {{--  lista de asistencia ACD  --}}
                    <option value="{{ route('secundaria_reporte.lista_de_asistencia_ACD.reporteACD') }}"
                    {{ url()->current() ==  route('secundaria_reporte.lista_de_asistencia_ACD.reporteACD') ? "selected": "" }}>Lista de asistencia ACD</option>

                    <option value="{{ route('secundaria.secundaria_resumen_inasistencias.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_resumen_inasistencias.index') ? "selected": "" }}>Resumen de inasistencia</option>

                    {{--  <option value="{{ route('secundaria.secundaria_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Resumen de inasistencia</option>  --}}

                    {{--  <option value="{{ route('secundaria.secundaria_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. grupos materias</option>  --}}

                </optgroup>

                @if (Auth::user()->id == 176 || Auth::user()->id == 198)
                <optgroup label="&nbsp;Pagos SEC">

                    <option value="{{ url('reporte/secundaria_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/secundaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores SEC</option>


                </optgroup>
                @endif
                {{-- Pagos --}}
                @if (Auth::user()->departamento_cobranza == 1)

                    <optgroup label="&nbsp;Pagos SEC">

                        {{--  Deudas de un Alumno  --}}
                        <option value="{{ url('reporte/secundaria_relacion_deudas') }}"
                        {{ url()->current() ==  url('reporte/secundaria_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

                        {{--  lista de asistencia ACD  --}}
                        <option value="{{ url('reporte/secundaria_relacion_deudores') }}"
                        {{ url()->current() ==  url('reporte/secundaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

                        {{--  Becas por Campus, Programa y Escuela  --}}
                        <option value="{{ url('reporte/becas_campus_carrera_escuela') }}"
                        {{ url()->current() ==  url('reporte/becas_campus_carrera_escuela') ? "selected": "" }}>Montos de Becas</option>


                    </optgroup>

                @endif

            </optgroup>

    @endif
@endif

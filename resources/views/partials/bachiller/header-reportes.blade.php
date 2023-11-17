@if (Auth::user()->bachiller == 1)

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1 || $userClave == "JIMENARIVERO")

            <optgroup label="BAC. Reportes">
                {{-- Alumnos --}}
                <optgroup label="&nbsp;Alumnos">
                    <option value="{{ route('bachiller_inscrito_preinscrito.reporte') }}"
                        {{ url()->current() ==  route('bachiller_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                    <option value="{{ route('bachiller.bachiller_resumen_inscritos.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_resumen_inscritos.reporte') ? "selected": "" }}>Resumen de inscritos</option>

                    {{--  Expediente de alumnos   --}}
                    {{--  <option value="{{ route('bachiller_reporte.expediente_alumnos.index') }}"
                        {{ url()->current() ==  route('bachiller_reporte.expediente_alumnos.index') ? "selected": "" }}>&nbsp; Expediente de alumnos</option>  --}}

                    {{--  Reporte de alumnos becados   --}}
                    <option value="{{ route('bachiller_reporte.bachiller_alumnos_becados.reporte') }}"
                        {{ url()->current() ==  route('bachiller_reporte.bachiller_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>

                    {{--  Relación de bajas   --}}
                    <option value="{{ route('bachiller.bachiller_relacion_bajas_periodo.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_relacion_bajas_periodo.reporte') ? "selected": "" }}>Rel. de Bajas</option>

                    <option value="{{ route('bachiller.bachiller_alumnos_excel.index') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_alumnos_excel.index') ? "selected": "" }}>Alumnos (Excel)</option>

                    {{-- Relación de deudores --}}
                    @if ( $userClave == "ANDREA" || $userClave == 'MCARRILLO')
                        <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                            {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>
                    @endif

                    {{--  <option value="{{ route('bachiller.bachiller_lealtad_alumnos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_lealtad_alumnos.reporte') ? "selected": "" }}>&nbsp;Alumnos Leales</option>  --}}

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)

                        <option value="{{ route('bachiller.bachiller_historico_inscripciones.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_historico_inscripciones.reporte') ? "selected": "" }}>Historico Inscripciones</option>

                    @endif

                    <option value="{{ route('bachiller.bachiller_escuela_procedencia.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_escuela_procedencia.reporte') ? "selected": "" }}>Escuela Procedencia</option>

                    <option value="{{ route('bachiller.bachiller_certificados_pagados.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_certificados_pagados.reporte') ? "selected": "" }}>Certificados Pagado</option>

                    <option value="{{ route('bachiller.bachiller_justificaciones.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_justificaciones.reporte') ? "selected": "" }}>Justificaciones Reporte</option>

                </optgroup>

                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)

                    <optgroup label="&nbsp;Constancias">

                            <option value="{{ route('bachiller.bachiller_buena_conducta.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_buena_conducta.reporte') ? "selected": "" }}>Buena conducta</option>

                            <option value="{{ route('bachiller.bachiller_calificacion_carrera.index') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_calificacion_carrera.index') ? "selected": "" }}>Calificaciones completas</option>

                            <option value="{{ route('bachiller.bachiller_calificacion_parcial.index') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_calificacion_parcial.index') ? "selected": "" }}>Calificaciones parciales</option>

                            <option value="{{ route('bachiller.bachiller_constancia_inscripcion.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_constancia_inscripcion.reporte') ? "selected": "" }}>Inscripción</option>

                            <option value="{{ route('bachiller.bachiller_constancia_medica.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_constancia_medica.reporte') ? "selected": "" }}>Médica</option>

                            <option value="{{ route('bachiller.bachiller_precertificado.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_precertificado.reporte') ? "selected": "" }}>Pre-certificados</option>

                            <option value="{{ route('bachiller.bachiller_historial_alumno.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_historial_alumno.reporte') ? "selected": "" }}>Historial académico alumnos</option>

                            <option value="{{ route('bachiller.bachiller_constancia_computo.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_constancia_computo.reporte') ? "selected": "" }}>Constancia Computo</option>

                    </optgroup>

                    <optgroup label="&nbsp;Calificaciones">

                        <option value="{{ route('bachiller.bachiller_evidencias_faltantes.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_evidencias_faltantes.reporte') ? "selected": "" }}>Evidencias Faltantes</option>

                         <option value="{{ route('bachiller.bachiller_resumen_evidencias.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_resumen_evidencias.reporte') ? "selected": "" }}>Res. Evidencias</option>

                         <option value="{{ route('bachiller.bachiller_avance_calificaciones.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_avance_calificaciones.reporte') ? "selected": "" }}>Res. de calificaciones</option>

                         <option value="{{ route('bachiller.bachiller_avance_por_grupo.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_avance_por_grupo.reporte') ? "selected": "" }}>Avance por grupos</option>


                        <option value="{{ route('bachiller.bachiller_adas_faltantes.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_adas_faltantes.reporte') ? "selected": "" }}>ADAS sin calificar</option>


                        <option value="{{ route('bachiller.bachiller_resumen_calificaciones_grupo.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_resumen_calificaciones_grupo.reporte') ? "selected": "" }}>Res. Calificaciones por Grupo</option>
{{--  
                         <option value="{{ route('bachiller.bachiller_calificacion_final.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_calificacion_final.reporte') ? "selected": "" }}>&nbsp;&nbsp; Califacion Final</option>  --}}

                         <option value="{{ route('bachiller.bachiller_acta_extraordinario.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_acta_extraordinario.reporte') ? "selected": "" }}>Acta de examen extraordinario</option>

                        <option value="{{ route('bachiller.bachiller_materias_aprobadas.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_materias_aprobadas.reporte') ? "selected": "" }}>Mat. Aprobadas</option>

                        <option value="{{ route('bachiller.bachiller_actas_pendientes.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_actas_pendientes.reporte') ? "selected": "" }}>Actas Pendientes</option>

                        <option value="{{ route('bachiller.bachiller_puntos_perdidos.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_puntos_perdidos.reporte') ? "selected": "" }}>Res. Puntos Perdidos</option>

                        <option value="{{ route('bachiller.bachiller_boleta_final.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_boleta_final.reporte') ? "selected": "" }}>Boleta Final</option>


                        <option value="{{ route('bachiller.bachiller_mejores_promedios.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_mejores_promedios.reporte') ? "selected": "" }}>Mejor Promedio</option>

                        <option value="{{ route('bachiller.bachiller_mejores_promedios_anuales.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_mejores_promedios_anuales.reporte') ? "selected": "" }}>Mejor Promedio Anual</option>

                        <option value="{{ route('bachiller.bachiller_puntos_cualitativos.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_puntos_cualitativos.reporte') ? "selected": "" }}>Puntos Cualitativos</option>

                    </optgroup>
                @endif

                @if (Auth::user()->campus_cch == 1)
                    <optgroup label="&nbsp;Calificaciones">



                    </optgroup>
                @endif

                <optgroup label="&nbsp;Docentes">

                    {{--  Rel. Grupos Maestros  --}}
                    <option value="{{ route('bachiller_relacion_maestros_escuela.reporte') }}"
                        {{ url()->current() ==  route('bachiller_relacion_maestros_escuela.reporte') ? "selected": "" }}>Rel. Grupos Maestros</option>

                    <option value="{{ route('bachiller.bachiller_carga_grupos_maestro.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_carga_grupos_maestro.reporte') ? "selected": "" }}>Carga grupos por maestro</option>

                    {{--  <option value="{{ route('bachiller.bachiller_horarios_administrativos.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos.reporte') ? "selected": "" }}>&nbsp;&nbsp; Horarios Administrativos</option>  --}}

                </optgroup>

                <optgroup label="&nbsp;Recuperativos">

                    {{--  Rel. Grupos Maestros  --}}
                    <option value="{{ route('bachiller.programacion_examenes.reporte') }}"
                        {{ url()->current() ==  route('bachiller.programacion_examenes.reporte') ? "selected": "" }}>Programación de exa. extraordinarios</option>

                    <option value="{{ route('bachiller.bachiller_relacion_inscritos_extraordinario.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_relacion_inscritos_extraordinario.reporte') ? "selected": "" }}>Inscritos a recuperativos</option>

                    <option value="{{ route('bachiller.bachiller_resumen_inscritos_recuperativos.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_resumen_inscritos_recuperativos.reporte') ? "selected": "" }}>Res. Inscritos recuperativos</option>

                    <option value="{{ route('bachiller.bachiller_alumnos_recuperativos.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_alumnos_recuperativos.reporte') ? "selected": "" }}>Lista alumnos insc. recuperativos</option>

                    <option value="{{ route('bachiller.bachiller_rel_extraordinarios.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_rel_extraordinarios.reporte') ? "selected": "" }}>Relación Extraordinarios</option>

                </optgroup>


                <optgroup label="&nbsp;Grupos">                    

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1 || Auth::user()->campus_cch == 1)
                        <option value="{{ route('bachiller.bachiller_asistencia_grupo.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_asistencia_grupo.reporte') ? "selected": "" }}>Asistencia por grupo</option>
                    @endif

                    @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                        <option value="{{ route('bachiller.bachiller_grupo_materia.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_grupo_materia.reporte') ? "selected": "" }}>Asistencia por materia</option>
                    @endif

                    @if (Auth::user()->campus_cch == 1)
                        <option value="{{ route('bachiller.bachiller_grupo_materia_cch.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_grupo_materia_cch.reporte') ? "selected": "" }}>Asistencia por materia</option>
                    @endif
                </optgroup>

                <optgroup label="&nbsp;Cursos">
                    <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>Grupos por semestre</option>

                    <option value="{{ route('bachiller.bachiller_horario_por_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horario_por_grupo.reporte') ? "selected": "" }}>Horario de clases</option>

                    <option value="{{ route('bachiller.bachiller_horario_clases_alumno.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horario_clases_alumno.reporte') ? "selected": "" }}>Horario de clases (alumno)</option>
                </optgroup>

                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)

                    <optgroup label="&nbsp;Formatos UADY">

                            <option value="{{ route('bachiller.bachiller_REA.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_REA.reporte') ? "selected": "" }}>REA (Registro de alumnos)</option>

                            <option value="{{ route('bachiller.bachiller_SOCA.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_SOCA.reporte') ? "selected": "" }}>SOCA (Optativas)</option>

                            <option value="{{ route('bachiller.bachiller_SOCA_ACO.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_SOCA_ACO.reporte') ? "selected": "" }}>SOCA (Acompañamientos)</option>

                            <option value="{{ route('bachiller.bachiller_BGU_Resultados.reporte') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_BGU_Resultados.reporte') ? "selected": "" }}>BGU Resultados</option>
                           

                    </optgroup>


                    <optgroup label="&nbsp;911">

                        <option value="{{ route('bachiller.bachiller_resumen_edades.reporte') }}"
                        {{ url()->current() ==  route('bachiller.bachiller_resumen_edades.reporte') ? "selected": "" }}>Resumen de edades</option>
                       
        
                    </optgroup>

                @endif

                @if(Auth::user()->username == "ARELYMAR")
                <optgroup label="&nbsp;Pagos">
                    {{--  REPORTES Deudores  --}}
                        <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                        {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>Relación de Deudores BAC</option>
                </optgroup>
                @endif

                {{-- Pagos --}}
                @if ( (Auth::user()->departamento_cobranza == 1)
                                || $userClave == "JPEREIRA"
                                || $userClave == "HRIVAS"
                                || $userClave == "RRIOS"
                                || $userClave == "MARIANAT")

                    <optgroup label="&nbsp;Pagos">

                        {{--  Deudas de un Alumno  --}}
                        <option value="{{ url('reporte/bachiller_relacion_deudas') }}"
                        {{ url()->current() ==  url('reporte/bachiller_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

                        {{--  REPORTES Deudores  --}}
                        <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                        {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

                        {{--  Becas por Campus, Programa y Escuela  --}}
                        <option value="{{ url('reporte/becas_campus_carrera_escuela') }}"
                        {{ url()->current() ==  url('reporte/becas_campus_carrera_escuela') ? "selected": "" }}>Montos de Becas</option>


                    </optgroup>

                @endif

            </optgroup>

    @endif
@endif

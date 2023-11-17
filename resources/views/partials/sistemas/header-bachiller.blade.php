{{--  header para yucatan   --}}
@if (Auth::user()->bachiller == 1 && Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="BAC UADY Catálogos">
            {{--  programas  --}}
            <option value="{{ route('bachiller.bachiller_programa.index') }}" {{ url()->current() ==  route('bachiller.bachiller_programa.index') ? "selected": "" }}>Programas</option>
            {{--  planes   --}}
            <option value="{{ route('bachiller.bachiller_plan.index') }}" {{ url()->current() ==  route('bachiller.bachiller_plan.index') ? "selected": "" }}>Planes</option>
            {{--  periodos   --}}
            <option value="{{ route('bachiller.bachiller_periodo.index') }}" {{ url()->current() ==  route('bachiller.bachiller_periodo.index') ? "selected": "" }}>Períodos</option>
            {{--  materias   --}}
            <option value="{{ route('bachiller.bachiller_materia.index') }}" {{ url()->current() ==  route('bachiller.bachiller_materia.index') ? "selected": "" }}>Materias</option>
            {{--  cgts   --}}
            <option value="{{ route('bachiller.bachiller_cgt.index') }}" {{ url()->current() ==  route('bachiller.bachiller_cgt.index') ? "selected": "" }}>CGT</option>
            {{--  porcentajes   --}}
            <option value="{{ route('bachiller.bachiller_porcentaje.index') }}" {{ url()->current() ==  route('bachiller.bachiller_porcentaje.index') ? "selected": "" }}>Porcentajes</option>


        </optgroup>

        <optgroup label="BAC UADY C.Escolar">
            <option value="{{ route('bachiller.bachiller_alumno.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_alumno.index') ? "selected": "" }}>Alumnos</option>

            <option value="{{ route('bachiller.bachiller_historia_clinica.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_historia_clinica.index') ? "selected": "" }}>Entrevista inicial</option>

            <option value="{{ route('bachiller.bachiller_curso.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_curso.index') ? "selected": "" }}>Preinscritos</option>

            {{--  Grupos   --}}
            <option value="{{ route('bachiller.bachiller_grupo_uady.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_grupo_uady.index') ? "selected": "" }}>Grupos UADY</option>

            <option value="{{ route('bachiller.bachiller_grupo_seq.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_grupo_seq.index') ? "selected": "" }}>Grupos SEQ</option>

            {{--  Grupos inscritos   --}}
            <option value="{{ route('bachiller.bachiller_asignar_grupo.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_asignar_grupo.index') ? "selected": "" }}>Inscritos Grupos</option>
     

            <option value="{{ route('bachiller.bachiller_asignar_cgt.edit') }}"
                {{ url()->current() ==  route('bachiller.bachiller_asignar_cgt.edit') ? "selected": "" }}>Asignar CGT</option>

            {{--  <option value="{{ route('bachiller.bachiller_cambiar_cgt.edit') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cambiar_cgt.edit') ? "selected": "" }}>Cambiar CGT</option>  --}}

            <option value="{{ route('bachiller.bachiller_materias_inscrito.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_materias_inscrito.index') ? "selected": "" }}>Cargar Materias a Inscrito</option>
            {{--  CGT Materias  --}}
            <option value="{{ route('bachiller.bachiller_cgt_materias.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

            {{-- Asignar Docente CGT  --}}
            <option value="{{ route('bachiller.bachiller_asignar_docente.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_asignar_docente.index') ? "selected": "" }}>Grupos - docente</option>



            {{--  Cambio de programa   
            <option value="{{ route('bachiller.bachiller_cambio_programa.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cambio_programa.index') ? "selected": "" }}>Cambio de Programa</option>
            --}}


            {{--  Empleados   --}}
            <option value="{{ route('bachiller.bachiller_empleado.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_empleado.index') ? "selected": "" }}>Empleados / Docentes</option>

            <option value="{{ route('bachiller.bachiller_migrar_inscritos_acd.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos UADY</option>

            <option value="{{ route('bachiller.bachiller_copiar_inscritos.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_copiar_inscritos.index') ? "selected": "" }}>Copiar Inscritos UADY</option>

                <option value="{{ route('bachiller.bachiller_copiar_horario.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_copiar_horario.index') ? "selected": "" }}>Copiar Horario UADY</option>

            {{--  Agenda   --}}
            <option value="{{ route('bachiller.bachiller_calendario.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_calendario.index') ? "selected": "" }}>Agenda</option>


            <option value="{{ route('bachiller.bachiller_resumen_academico.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_resumen_academico.index') ? "selected": "" }}>Resumen académico</option>

            {{--  Acceso de Docente   --}}
            <option value="{{ route('bachiller.bachiller_cambiar_contrasenia.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cambiar_contrasenia.index') ? "selected": "" }}>Contraseña de Docentes</option>

            {{--  Resumen académico   
            <option value="{{ route('bachiller.bachiller_resumen_academico.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_resumen_academico.index') ? "selected": "" }}>Resumen académico</option>
            --}}
            <option value="{{ route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index') ? "selected": "" }}>Fechas Calif. Docentes</option>

            <option value="{{ route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index') ? "selected": "" }}>Fechas Calif. Alumnos</option>

            {{--  Observaciones calificaciones   --}}
            <option value="{{ route('bachiller.bachiller_obs_boleta.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_obs_boleta.index') ? "selected": "" }}>Nota mensual Calif.</option>

            <option value="{{ route('bachiller.bachiller_horarios_administrativos') }}"
                {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos') ? "selected": "" }}>Horarios administrativos</option>

            <option value="{{ url('bachiller_recuperativos') }}"
                {{ url()->current() ==  url('bachiller_recuperativos') ? "selected": "" }}>Recuperativos</option>

                

            {{--  <option value="{{ url('bachiller_curso_recuperativo') }}"
                {{ url()->current() ==  url('bachiller_curso_recuperativo') ? "selected": "" }}>Curso Recuperativo</option>  --}}
            <option value="{{ url('solicitudes/bachiller_recuperativos') }}"
                {{ url()->current() ==  url('solicitudes/bachiller_recuperativos') ? "selected": "" }}>Solicitud recuperativo</option>

            <option value="{{ route('bachiller.bachiller_evidencias.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_evidencias.index') ? "selected": "" }}>Evidencias</option>

            <option value="{{ route('bachiller.bachiller_fechas_regularizacion.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_fechas_regularizacion.index') ? "selected": "" }}>Fechas de Regularización</option>

            <option value="{{ route('bachiller.bachiller_calendario_examen.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_calendario_examen.index') ? "selected": "" }}>Fechas Calendario Examen</option>

            <option value="{{ route('bachiller.bachiller_paquete.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_paquete.index') ? "selected": "" }}>Paquetes</option>

            <option value="{{ route('bachiller.bachiller_inscrito_paquete.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_inscrito_paquete.index') ? "selected": "" }}>Inscritos Paquetes</option>

            <option value="{{ route('bachiller.bachiller_periodos_vacacionales.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_periodos_vacacionales.index') ? "selected": "" }}>Períodos Vacacionales</option>

            <option value="{{ route('bachiller.bachiller_historial_academico.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_historial_academico.index') ? "selected": "" }}>Historial Académico</option>

            <option value="{{ route('bachiller.bachiller_revalidaciones.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_revalidaciones.index') ? "selected": "" }}>Revalidaciones</option>


                <option value="{{ route('bachiller.bachiller_cierre_actas.filtro') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cierre_actas.filtro') ? "selected": "" }}>Cierre Ordinarios</option>

            <option value="{{ route('bachiller.egregados.filtro') }}"
                {{ url()->current() ==  route('bachiller.egregados.filtro') ? "selected": "" }}>Registro Automático Egresados</option>

                <option value="{{ route('bachiller.bachiller_justificaciones.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_justificaciones.index') ? "selected": "" }}>Justificaciones</option>

            <option value="{{ route('bachiller.bachiller-portal-configuracion.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller-portal-configuracion.index') ? "selected": "" }}>Config. Portal BAC</option>

            <option value="{{ route('bachiller.bachiller_pago_certificado.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_pago_certificado.index') ? "selected": "" }}>Pago Certificado UADY</option>

                
                
        </optgroup>

        

        <optgroup label="BAC UADY Reportes">
            {{-- Alumnos --}}
            <optgroup label="&nbsp;Alumnos BAC UADY">
                <option value="{{ route('bachiller_inscrito_preinscrito.reporte') }}"
                    {{ url()->current() ==  route('bachiller_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                <option value="{{ route('bachiller.bachiller_resumen_inscritos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_inscritos.reporte') ? "selected": "" }}>Resumen de inscritos BAC UADY</option>

                {{--  Expediente de alumnos   --}}
                {{--  <option value="{{ route('bachiller_reporte.expediente_alumnos.index') }}"
                    {{ url()->current() ==  route('bachiller_reporte.expediente_alumnos.index') ? "selected": "" }}>&nbsp;&nbsp;Expediente de alumnos</option>  --}}

                {{--  Reporte de alumnos becados   --}}
                <option value="{{ route('bachiller_reporte.bachiller_alumnos_becados.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.bachiller_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>

                {{--  Relación de bajas   --}}
                <option value="{{ route('bachiller.bachiller_relacion_bajas_periodo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_relacion_bajas_periodo.reporte') ? "selected": "" }}>Rel. de Bajas</option>

                <option value="{{ route('bachiller.bachiller_alumnos_excel.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_alumnos_excel.index') ? "selected": "" }}>Alumnos (Excel)</option>
          
                    <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>Relación de Deudores UADY</option>

                    <option value="{{ route('bachiller.bachiller_inscritos_sexo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_inscritos_sexo.reporte') ? "selected": "" }}>Resumen inscritos sexo BAC UADY</option>

                    <option value="{{ route('bachiller.bachiller_historico_inscripciones.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_historico_inscripciones.reporte') ? "selected": "" }}>Historico Inscripciones UADY</option>

                    <option value="{{ route('bachiller.bachiller_lealtad_alumnos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_lealtad_alumnos.reporte') ? "selected": "" }}>Alumnos Leales BAC UADY</option>

                    <option value="{{ route('bachiller.bachiller_escuela_procedencia.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_escuela_procedencia.reporte') ? "selected": "" }}>Escuela Procedencia UADY</option>

                    <option value="{{ route('bachiller.bachiller_certificados_pagados.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_certificados_pagados.reporte') ? "selected": "" }}>Certificados Pagado UADY</option>

                    <option value="{{ route('bachiller.bachiller_justificaciones.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_justificaciones.reporte') ? "selected": "" }}>Justificaciones UADY</option>
                {{-- Rel. de Familia/Tutores --}}
                {{--  <option value="{{ route('bachiller.bachiller_relacion_tutores.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_relacion_tutores.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp; Rel. alumnos becados</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_datos_completos_alumno.reporteAlumnos') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_datos_completos_alumno.reporteAlumnos') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Datos Completos de Alumnos</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_alumnos_no_inscritos_materias.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_alumnos_no_inscritos_materias.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Alumnos no inscritos</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_alumnos_inscritos_acd.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_alumnos_inscritos_acd.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Alumnos inscritos ACD</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_lista_de_interasados.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_lista_de_interasados.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de interesados</option>  --}}

                   
            </optgroup>

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

                <option value="{{ route('bachiller.bachiller_constancia_computo.reporte') }}"
                {{ url()->current() ==  route('bachiller.bachiller_constancia_computo.reporte') ? "selected": "" }}>Computo</option>

                

            </optgroup>   

            <optgroup label="&nbsp;Calificaciones">

                {{--  Calificaciones de grupo  --}}
                {{--  <option value="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.calificaciones_grupo.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de Calificaciones</option>  --}}

                {{--  Calificaciones por materia  --}}

                <option value="{{ route('bachiller.bachiller_evidencias_faltantes.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_evidencias_faltantes.reporte') ? "selected": "" }}>Evidencias Faltantes</option>

                <option value="{{ route('bachiller.bachiller_resumen_evidencias.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_evidencias.reporte') ? "selected": "" }}>Res. Evidecias</option>

                {{--  <option value="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.calificaciones_grupo.reporte') ? "selected": "" }}>Lista de Calificaciones</option>  --}}

                <option value="{{ route('bachiller.bachiller_avance_calificaciones.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_avance_calificaciones.reporte') ? "selected": "" }}>Res. de calificaciones</option>

                <option value="{{ route('bachiller.bachiller_avance_por_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_avance_por_grupo.reporte') ? "selected": "" }}>Avance por grupos</option>

                <option value="{{ route('bachiller.bachiller_resumen_calificaciones_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_calificaciones_grupo.reporte') ? "selected": "" }}>Res. Calificaciones por Grupo</option>


                <option value="{{ route('bachiller.bachiller_acta_extraordinario.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_acta_extraordinario.reporte') ? "selected": "" }}>Acta de examen recuperativo</option>

                <option value="{{ route('bachiller.bachiller_materias_aprobadas.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_materias_aprobadas.reporte') ? "selected": "" }}>Mat. Aprobadas</option>

                <option value="{{ route('bachiller.bachiller_actas_pendientes.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_actas_pendientes.reporte') ? "selected": "" }}>Actas Pendientes</option>

                <option value="{{ route('bachiller.bachiller_puntos_perdidos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_puntos_perdidos.reporte') ? "selected": "" }}>Res. Puntos Perdidos</option>

                <option value="{{ route('bachiller.bachiller_boleta_final.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_boleta_final.reporte') ? "selected": "" }}>Boleta Final</option>

                <option value="{{ route('bachiller.bachiller_puntos_cualitativos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_puntos_cualitativos.reporte') ? "selected": "" }}>Puntos Cualitativos</option>

                <option value="{{ route('bachiller.bachiller_mejores_promedios.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_mejores_promedios.reporte') ? "selected": "" }}>Mejor Promedio</option>


                <option value="{{ route('bachiller.bachiller_mejores_promedios_anuales.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_mejores_promedios_anuales.reporte') ? "selected": "" }}>Mejor Promedio Anual</option>

                <option value="{{ route('bachiller.bachiller_adas_faltantes.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_adas_faltantes.reporte') ? "selected": "" }}>ADAS faltantes</option>
                {{--  Calificaciones ingles  --}}
                {{--  <option value="{{ route('bachiller_calificacion_materia_ingles.index') }}"
                {{ url()->current() ==  route('bachiller_calificacion_materia_ingles.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;Res. de Inglés</option>  --}}

                {{--  Boleta  --}}
                {{--  <option value="{{ route('bachiller.bachiller_boleta_de_calificaciones.reporteBoleta') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_boleta_de_calificaciones.reporteBoleta') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;Boleta</option>  --}}

                {{--  Boleta ACD --}}
                {{--  <option value="{{ route('bachiller.bachiller_boleta_de_calificaciones_acd.reporteBoleta') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_boleta_de_calificaciones_acd.reporteBoleta') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Boleta ACD</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_historial_alumno.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_historial_alumno.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Historial académico del alumno</option>  --}}
            </optgroup>

            <optgroup label="&nbsp;Docentes">

                {{--  Rel. Grupos Maestros  --}}
                <option value="{{ route('bachiller_relacion_maestros_escuela.reporte') }}"
                    {{ url()->current() ==  route('bachiller_relacion_maestros_escuela.reporte') ? "selected": "" }}>Rel. Grupos Maestros</option>

                <option value="{{ route('bachiller.bachiller_carga_grupos_maestro.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_carga_grupos_maestro.reporte') ? "selected": "" }}>Carga grupos por maestro</option>
                
                    {{--  <option value="{{ route('bachiller.bachiller_horarios_administrativos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos.reporte') ? "selected": "" }}>&nbsp;&nbsp; Horarios Administrativos</option>  --}}
                    {{--  Rel. Grupos ACD  --}}
                {{--  <option value="{{ route('bachiller_reporte.relacion_maestros_acd.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.relacion_maestros_acd.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. Grupos ACD</option>  --}}

                {{--  <option value="{{ route('bachiller_reporte.calificaciones_faltantes.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.calificaciones_faltantes.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Calificaciones Faltantes</option>  --}}

            </optgroup>

            <optgroup label="&nbsp;Recuperativos">

                {{--  Rel. Grupos Maestros  --}}
                <option value="{{ route('bachiller.programacion_examenes.reporte') }}"
                    {{ url()->current() ==  route('bachiller.programacion_examenes.reporte') ? "selected": "" }}>Programación de exa. recuperativos</option>

                <option value="{{ route('bachiller.bachiller_relacion_inscritos_extraordinario.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_relacion_inscritos_extraordinario.reporte') ? "selected": "" }}>Inscritos a recuperativos</option>


                <option value="{{ route('bachiller.bachiller_resumen_inscritos_recuperativos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_inscritos_recuperativos.reporte') ? "selected": "" }}>Res. Inscritos recuperativos</option>

                <option value="{{ route('bachiller.bachiller_alumnos_recuperativos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_alumnos_recuperativos.reporte') ? "selected": "" }}>Lista alumnos insc. recuperativos</option>

                <option value="{{ route('bachiller.bachiller_rel_extraordinarios.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_rel_extraordinarios.reporte') ? "selected": "" }}>Relación Extraordinarios</option>

                

            </optgroup>


            <optgroup label="&nbsp;Grupos UADY">

                {{--  Lista de asistencia  --}}
                <option value="{{ route('bachiller.bachiller_asistencia_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_asistencia_grupo.reporte') ? "selected": "" }}>Asistencia por grupo</option>

                <option value="{{ route('bachiller.bachiller_grupo_materia.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_materia.reporte') ? "selected": "" }}>Asistencia por materia</option>

                {{--  lista de asistencia ACD  --}}
                {{--  <option value="{{ route('bachiller_reporte.lista_de_asistencia_ACD.reporteACD') }}"
                    {{ url()->current() ==  route('bachiller_reporte.lista_de_asistencia_ACD.reporteACD') ? "selected": "" }}>&nbsp;&nbsp;&nbsp; Lista de asistencia ACD</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_resumen_inasistencias.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_inasistencias.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp; Resumen de inasistencia</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp; Resumen de inasistencia</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp; Rel. grupos materias</option>  --}}

            </optgroup>



            <optgroup label="&nbsp;Pagos">

                {{--  Deudas de un Alumno  --}}
                {{--  <option value="{{ url('reporte/bachiller_relacion_deudas') }}"
                    {{ url()->current() ==  url('reporte/bachiller_relacion_deudas') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deudas de un Alumno</option>  --}}

                {{--  lista de asistencia ACD  --}}
                {{--  <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Relación de Deudores</option>  --}}

            </optgroup>

            <optgroup label="&nbsp;Cursos">

                <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>Grupos por semestre</option>
                {{--  Calificaciones de grupo  --}}
                <option value="{{ route('bachiller.bachiller_horario_por_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horario_por_grupo.reporte') ? "selected": "" }}>Horario de clases</option>

                <option value="{{ route('bachiller.bachiller_horario_clases_alumno.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horario_clases_alumno.reporte') ? "selected": "" }}>Horario de clases (alumno)</option>

                
            </optgroup>

            <optgroup label="&nbsp;Formatos UADY">

                <option value="{{ route('bachiller.bachiller_REA.reporte') }}"
                {{ url()->current() ==  route('bachiller.bachiller_REA.reporte') ? "selected": "" }}>REA (Registro de alumnos)</option>

                <option value="{{ route('bachiller.bachiller_SOCA.reporte') }}"
                {{ url()->current() ==  route('bachiller.bachiller_SOCA.reporte') ? "selected": "" }}>SOCA (Optativas)</option>

                <option value="{{ route('bachiller.bachiller_SOCA_ACO.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_SOCA_ACO.reporte') ? "selected": "" }}>SOCA (Acompañamientos)</option>

                <option value="{{ route('bachiller.bachiller_BGU_Resultados.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_BGU_Resultados.reporte') ? "selected": "" }}>BGU Resultados UADY</option>
               
                            
            </optgroup>

            <optgroup label="&nbsp;911">

                <option value="{{ route('bachiller.bachiller_resumen_edades.reporte') }}"
                {{ url()->current() ==  route('bachiller.bachiller_resumen_edades.reporte') ? "selected": "" }}>Resumen de edades</option>
               

            </optgroup>


        </optgroup>



    @endif

@endif



{{--  header para chetumal   --}}
@if (Auth::user()->bachiller == 1 && Auth::user()->campus_cch == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="BAC SEQ Catálogos">
            {{--  programas  --}}
            <option value="{{ route('bachiller.bachiller_programa.index') }}" {{ url()->current() ==  route('bachiller.bachiller_programa.index') ? "selected": "" }}>Programas</option>
            {{--  planes   --}}
            <option value="{{ route('bachiller.bachiller_plan.index') }}" {{ url()->current() ==  route('bachiller.bachiller_plan.index') ? "selected": "" }}>Planes</option>
            {{--  periodos   --}}
            <option value="{{ route('bachiller.bachiller_periodo.index') }}" {{ url()->current() ==  route('bachiller.bachiller_periodo.index') ? "selected": "" }}>Períodos</option>
            {{--  materias   --}}
            <option value="{{ route('bachiller.bachiller_materia.index') }}" {{ url()->current() ==  route('bachiller.bachiller_materia.index') ? "selected": "" }}>Materias</option>
            {{--  cgts   --}}
            <option value="{{ route('bachiller.bachiller_cgt.index') }}" {{ url()->current() ==  route('bachiller.bachiller_cgt.index') ? "selected": "" }}>CGT</option>
            {{--  porcentajes   --}}
            <option value="{{ route('bachiller.bachiller_porcentaje.index') }}" {{ url()->current() ==  route('bachiller.bachiller_porcentaje.index') ? "selected": "" }}>Porcentajes</option>


        </optgroup>

        <optgroup label="BAC SEQ C.Escolar">

            <option value="{{ route('bachiller.bachiller_historia_clinica.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_historia_clinica.index') ? "selected": "" }}>Expediente Alumno</option>

            <option value="{{ route('bachiller.bachiller_alumno.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_alumno.index') ? "selected": "" }}>Alumnos</option>            

            <option value="{{ route('bachiller.bachiller_curso.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_curso.index') ? "selected": "" }}>Preinscritos</option>

            <option value="{{ route('bachiller.bachiller_preinscripcion_automatica.create') }}"
                {{ url()->current() ==  route('bachiller.bachiller_preinscripcion_automatica.create') ? "selected": "" }}>Preinscripción Automatica</option>

                {{--  CGT Materias  --}}
            <option value="{{ route('bachiller.bachiller_cgt_materias.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

            <option value="{{ route('bachiller.bachiller_grupo_seq.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_grupo_seq.index') ? "selected": "" }}>Grupos</option>

                    {{-- Asignar Docente CGT  --}}
            <option value="{{ route('bachiller.bachiller_asignar_docente.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_asignar_docente.index') ? "selected": "" }}>Docentes Grupos</option>
         
            {{--  Grupos inscritos   --}}
            <option value="{{ route('bachiller.bachiller_asignar_grupo_seq.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_asignar_grupo_seq.index') ? "selected": "" }}>Inscritos Grupos SEQ</option>

            <option value="{{ route('bachiller.bachiller_asignar_cgt.edit') }}"
                {{ url()->current() ==  route('bachiller.bachiller_asignar_cgt.edit') ? "selected": "" }}>Asignar CGT</option>


            <option value="{{ route('bachiller.bachiller_horarios_administrativos_seq') }}"
                {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos_seq') ? "selected": "" }}>Horarios administrativos SEQ</option>

                {{--  Empleados   --}}
            <option value="{{ route('bachiller.bachiller_empleado.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_empleado.index') ? "selected": "" }}>Empleados / Docentes</option>


            <option value="{{ route('bachiller.bachiller_cambiar_cgt_cch.edit') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cambiar_cgt_cch.edit') ? "selected": "" }}>Cambiar CGT</option>

            <option value="{{ route('bachiller.bachiller_materias_inscrito.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_materias_inscrito.index') ? "selected": "" }}>Materias Nuevo Inscrito</option>            

            {{--  Acceso de Docente   --}}
            <option value="{{ route('bachiller.bachiller_cambiar_contrasenia.index') }}"
            {{ url()->current() ==  route('bachiller.bachiller_cambiar_contrasenia.index') ? "selected": "" }}>Contraseña de Docentes</option>

            
            {{--  Agenda   --}}
            <option value="{{ route('bachiller.bachiller_calendario.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_calendario.index') ? "selected": "" }}>Agenda</option>           

            {{--  Resumen académico   
            <option value="{{ route('bachiller.bachiller_resumen_academico.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_resumen_academico.index') ? "selected": "" }}>Resumen académico</option>
            --}}
            <option value="{{ route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index') ? "selected": "" }}>Fechas Calif. Docentes</option>

            <option value="{{ route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index') ? "selected": "" }}>Fechas Calif. Alumnos</option>

            {{--  Observaciones calificaciones   --}}
            <option value="{{ route('bachiller.bachiller_obs_boleta.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_obs_boleta.index') ? "selected": "" }}>Nota mensual Calif.</option>

            {{--  <option value="{{ route('bachiller.bachiller_horarios_administrativos') }}"
                {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos') ? "selected": "" }}>Horarios administrativos</option>  --}}

            <option value="{{ url('bachiller_recuperativos') }}"
                {{ url()->current() ==  url('bachiller_recuperativos') ? "selected": "" }}>Recuperativos</option>

            <option value="{{ route('bachiller.bachiller_cierre_extras.filtro') }}"
                {{ url()->current() ==  route('bachiller.bachiller_cierre_extras.filtro') ? "selected": "" }}>Cierre Recuperativos</option>

            

            <option value="{{ route('bachiller.bachiller_evidencias.index') }}"
                {{ url()->current() ==  route('bachiller.bachiller_evidencias.index') ? "selected": "" }}>Evidencias</option>
                
        </optgroup>

        

        <optgroup label="BAC SEQ Reportes">
            {{-- Alumnos --}}
            <optgroup label="&nbsp;&nbsp;&nbsp; Alumnos BAC SEQ">
                <option value="{{ route('bachiller_inscrito_preinscrito.reporte') }}"
                    {{ url()->current() ==  route('bachiller_inscrito_preinscrito.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inscritos y preinscritos</option>

                <option value="{{ route('bachiller.bachiller_resumen_inscritos.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_inscritos.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Resumen de inscritos BAC SEQ</option>

                {{--  Expediente de alumnos   --}}
                {{--  <option value="{{ route('bachiller_reporte.expediente_alumnos.index') }}"
                    {{ url()->current() ==  route('bachiller_reporte.expediente_alumnos.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Expediente de alumnos</option>  --}}

                {{--  Reporte de alumnos becados   --}}
                <option value="{{ route('bachiller_reporte.bachiller_alumnos_becados.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.bachiller_alumnos_becados.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. alumnos becados</option>

                {{--  Relación de bajas   --}}
                <option value="{{ route('bachiller.bachiller_relacion_bajas_periodo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_relacion_bajas_periodo.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. de Bajas</option>


                {{-- Rel. de Familia/Tutores --}}
                {{--  <option value="{{ route('bachiller.bachiller_relacion_tutores.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_relacion_tutores.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. alumnos becados</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_datos_completos_alumno.reporteAlumnos') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_datos_completos_alumno.reporteAlumnos') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Datos Completos de Alumnos</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_alumnos_no_inscritos_materias.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_alumnos_no_inscritos_materias.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Alumnos no inscritos</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_alumnos_inscritos_acd.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_alumnos_inscritos_acd.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Alumnos inscritos ACD</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_lista_de_interasados.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_lista_de_interasados.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de interesados</option>  --}}

                   
            </optgroup>

            <optgroup label="&nbsp;&nbsp;&nbsp; Calificaciones">

                {{--  Calificaciones de grupo  --}}
                {{--  <option value="{{ route('bachiller_reporte.calificaciones_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.calificaciones_grupo.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de Calificaciones</option>  --}}

                {{--  Calificaciones por materia  --}}
                {{--  <option value="{{ route('bachiller_reporte.calificacion_por_materia.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.calificacion_por_materia.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Res. por materia</option>  --}}

                {{--  Calificaciones ingles  --}}
                {{--  <option value="{{ route('bachiller_calificacion_materia_ingles.index') }}"
                {{ url()->current() ==  route('bachiller_calificacion_materia_ingles.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Res. de Inglés</option>  --}}

                {{--  Boleta  --}}
                {{--  <option value="{{ route('bachiller.bachiller_boleta_de_calificaciones.reporteBoleta') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_boleta_de_calificaciones.reporteBoleta') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Boleta</option>  --}}

                {{--  Boleta ACD --}}
                {{--  <option value="{{ route('bachiller.bachiller_boleta_de_calificaciones_acd.reporteBoleta') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_boleta_de_calificaciones_acd.reporteBoleta') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Boleta ACD</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_historial_alumno.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_historial_alumno.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Historial académico del alumno</option>  --}}
            </optgroup>

            <optgroup label="&nbsp;&nbsp;&nbsp; Docentes">

                {{--  Rel. Grupos Maestros  --}}
                <option value="{{ route('bachiller_relacion_maestros_escuela.reporte') }}"
                    {{ url()->current() ==  route('bachiller_relacion_maestros_escuela.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. Grupos Maestros</option>

                <option value="{{ route('bachiller.bachiller_carga_grupos_maestro.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_carga_grupos_maestro.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Carga grupos por maestro</option>
                {{--  Rel. Grupos ACD  --}}
                {{--  <option value="{{ route('bachiller_reporte.relacion_maestros_acd.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.relacion_maestros_acd.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. Grupos ACD</option>  --}}

                {{--  <option value="{{ route('bachiller_reporte.calificaciones_faltantes.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.calificaciones_faltantes.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Calificaciones Faltantes</option>  --}}

            </optgroup>

            <optgroup label="&nbsp;&nbsp;&nbsp; Evaluaciones">

                {{--  Rel. Grupos Maestros  --}}
                <option value="{{ route('bachiller.programacion_examenes.reporte') }}"
                    {{ url()->current() ==  route('bachiller.programacion_examenes.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Programación de exa. extraordinarios</option>

                

            </optgroup>


            <optgroup label="&nbsp;&nbsp;&nbsp; Grupos">

                {{--  Lista de asistencia  --}}
                {{--  <option value="{{ route('bachiller_reporte.lista_de_asistencia.reporte') }}"
                    {{ url()->current() ==  route('bachiller_reporte.lista_de_asistencia.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de asistencia</option>  --}}

                {{--  lista de asistencia ACD  --}}
                {{--  <option value="{{ route('bachiller_reporte.lista_de_asistencia_ACD.reporteACD') }}"
                    {{ url()->current() ==  route('bachiller_reporte.lista_de_asistencia_ACD.reporteACD') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lista de asistencia ACD</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_resumen_inasistencias.index') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_resumen_inasistencias.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Resumen de inasistencia</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Resumen de inasistencia</option>  --}}

                {{--  <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rel. grupos materias</option>  --}}

            </optgroup>



            <optgroup label="&nbsp;&nbsp;&nbsp; Pagos">

                {{--  Deudas de un Alumno  --}}
                {{--  <option value="{{ url('reporte/bachiller_relacion_deudas') }}"
                    {{ url()->current() ==  url('reporte/bachiller_relacion_deudas') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deudas de un Alumno</option>  --}}

                {{--  lista de asistencia ACD  --}}
                {{--  <option value="{{ url('reporte/bachiller_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/bachiller_relacion_deudores') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Relación de Deudores</option>  --}}

            </optgroup>

            <optgroup label="&nbsp;&nbsp;&nbsp; Cursos">

                <option value="{{ route('bachiller.bachiller_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_grupo_semestre.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Grupos por semestre</option>
                {{--  Calificaciones de grupo  --}}
                <option value="{{ route('bachiller.bachiller_horario_por_grupo.reporte') }}"
                    {{ url()->current() ==  route('bachiller.bachiller_horario_por_grupo.reporte') ? "selected": "" }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Horario de clases</option>

                

                
            </optgroup>


        </optgroup>



    @endif

@endif


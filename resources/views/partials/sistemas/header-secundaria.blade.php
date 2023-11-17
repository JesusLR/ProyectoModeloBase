@if (Auth::user()->secundaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{--  NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOS  --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="SEC Catálogos">
            {{--  programas  --}}
            <option value="{{ route('secundaria.secundaria_programa.index') }}" {{ url()->current() ==  route('secundaria.secundaria_programa.index') ? "selected": "" }}>Programas</option>
            {{--  planes   --}}
            <option value="{{ route('secundaria.secundaria_plan.index') }}" {{ url()->current() ==  route('secundaria.secundaria_plan.index') ? "selected": "" }}>Planes</option>
            {{--  periodos   --}}
            <option value="{{ route('secundaria.secundaria_periodo.index') }}" {{ url()->current() ==  route('secundaria.secundaria_periodo.index') ? "selected": "" }}>Períodos</option>
            {{--  materias   --}}
            <option value="{{ route('secundaria.secundaria_materia.index') }}" {{ url()->current() ==  route('secundaria.secundaria_materia.index') ? "selected": "" }}>Materias</option>
            {{--  cgts   --}}
            <option value="{{ route('secundaria.secundaria_cgt.index') }}" {{ url()->current() ==  route('secundaria.secundaria_cgt.index') ? "selected": "" }}>CGT</option>
            {{--  porcentajes   --}}
            <option value="{{ route('secundaria.secundaria_porcentaje.index') }}" {{ url()->current() ==  route('secundaria.secundaria_porcentaje.index') ? "selected": "" }}>Porcentajes</option>

            {{--  Migrar Inscritos ACD   --}}
            <option value="{{ route('secundaria.secundaria_migrar_inscritos_acd.index') }}" {{ url()->current() ==  route('secundaria.secundaria_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos ACD</option>

        </optgroup>


        <optgroup label="SEC C.Escolar">
            <option value="{{ route('secundaria.secundaria_alumno.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_alumno.index') ? "selected": "" }}>Alumnos</option>

            <option value="{{ route('secundaria.secundaria_historia_clinica.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_historia_clinica.index') ? "selected": "" }}>Entrevista inicial</option>

            <option value="{{ route('secundaria.secundaria_curso.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_curso.index') ? "selected": "" }}>Preinscritos</option>

            {{--  Grupos   --}}
            <option value="{{ route('secundaria.secundaria_grupo.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_grupo.index') ? "selected": "" }}>Grupos</option>

            {{--  Grupos inscritos   --}}
            <option value="{{ route('secundaria.secundaria_asignar_grupo.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_asignar_grupo.index') ? "selected": "" }}>Inscritos Grupos</option>

            <option value="{{ route('secundaria.secundaria_asignar_cgt.edit') }}"
                {{ url()->current() ==  route('secundaria.secundaria_asignar_cgt.edit') ? "selected": "" }}>Asignar CGT</option>

            <option value="{{ route('secundaria.secundaria_cambiar_cgt.edit') }}"
                {{ url()->current() ==  route('secundaria.secundaria_cambiar_cgt.edit') ? "selected": "" }}>Cambiar CGT</option>

            {{--  Cambiar grupo ACD  --}}
            <option value="{{ route('secundaria.secundaria_cambio_grupo_acd.index') }}"
            {{ url()->current() ==  route('secundaria.secundaria_cambio_grupo_acd.index') ? "selected": "" }}>Cambiar grupo ACD</option>

            <option value="{{ route('secundaria.secundaria_materias_inscrito.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_materias_inscrito.index') ? "selected": "" }}>Cargar Materias a Inscrito</option>
            {{--  CGT Materias  --}}
            <option value="{{ route('secundaria.secundaria_cgt_materias.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

            {{-- Asignar Docente CGT  --}}
            <option value="{{ route('secundaria.secundaria_asignar_docente.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_asignar_docente.index') ? "selected": "" }}>Grupos - docente</option>



            {{--  Cambio de programa   
            <option value="{{ route('secundaria.secundaria_cambio_programa.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_cambio_programa.index') ? "selected": "" }}>&nbsp;&nbsp;Cambio de Programa</option>
            --}}


            {{--  Empleados   --}}
            <option value="{{ route('secundaria.secundaria_empleado.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_empleado.index') ? "selected": "" }}>Empleados / Docentes</option>

            {{--  Agenda   --}}
            <option value="{{ route('secundaria.secundaria_calendario.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_calendario.index') ? "selected": "" }}>Agenda</option>

            {{--  Acceso de Docente   --}}
            <option value="{{ route('secundaria.secundaria_cambiar_contrasenia.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_cambiar_contrasenia.index') ? "selected": "" }}>Contraseña de Docentes</option>

            {{--  Resumen académico   
            <option value="{{ route('secundaria.secundaria_resumen_academico.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_resumen_academico.index') ? "selected": "" }}>Resumen académico</option>
            --}}
            <option value="{{ route('secundaria.secundaria_fecha_publicacion_calificacion_docente.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_fecha_publicacion_calificacion_docente.index') ? "selected": "" }}>Fechas Calif. Docentes</option>

            <option value="{{ route('secundaria.secundaria_fecha_publicacion_calificacion_alumno.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_fecha_publicacion_calificacion_alumno.index') ? "selected": "" }}>Fechas Calif. Alumnos</option>

            {{--  Observaciones calificaciones   --}}
            <option value="{{ route('secundaria.secundaria_obs_boleta.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_obs_boleta.index') ? "selected": "" }}>Nota mensual Calif.</option>


            <option value="{{ route('secundaria.secundaria_alumnos_restringidos.index') }}"
                {{ url()->current() ==  route('secundaria.secundaria_alumnos_restringidos.index') ? "selected": "" }}>Alumnos Restringidos</option>
                
        </optgroup>

        <optgroup label="SEC Act. ExtraEscolares">

            <option value="{{ route('universidad.universidad_actividades.index') }}"
                {{ url()->current() ==  route('universidad.universidad_actividades.index') ? "selected": "" }}>Actividades (Grupos)</option>            
                
            <option value="{{ route('universidad.universidad_nuevo_externo.create') }}"
                {{ url()->current() ==  route('universidad.universidad_nuevo_externo.create') ? "selected": "" }}>Nuevo Externo</option>

            <option value="{{ route('universidad.universidad_actividades_inscritos.index') }}"
                {{ url()->current() ==  route('universidad.universidad_actividades_inscritos.index') ? "selected": "" }}>Inscritos Actividades</option>

                <option value="{{ url('empleado') }}"
                    {{ url()->current() ==  url('empleado') ? "selected": "" }}>Instructores (Empleados)</option>

                   
        </optgroup>

        <optgroup label="SEC Pagos">
            <option value="{{ url('pagos/ficha_general') }}"
                {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

            <option value="{{ url('secundaria/pagos/aplicar_pagos') }}"
                    {{ url()->current() ==  url('secundaria/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>

        </optgroup>


        <optgroup label="SEC Reportes">
            {{-- Alumnos --}}
            <optgroup label="&nbsp;Alumnos SEC">
                <option value="{{ route('secundaria_inscrito_preinscrito.reporte') }}"
                    {{ url()->current() ==  route('secundaria_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                <option value="{{ url('reporte/secundaria_resumen_inscritos') }}"
                    {{ url()->current() ==  url('reporte/secundaria_resumen_inscritos') ? "selected": "" }}>Resumen de inscritos SEC</option>

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

                <option value="{{ route('secundaria.secundaria_datos_completos_alumno.reporteAlumnos') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_datos_completos_alumno.reporteAlumnos') ? "selected": "" }}>Datos Completos de Alumnos</option>

                    <option value="{{ route('secundaria.secundaria_alumnos_no_inscritos_materias.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_alumnos_no_inscritos_materias.index') ? "selected": "" }}>Alumnos no inscritos</option>

                    <option value="{{ route('secundaria.secundaria_alumnos_inscritos_acd.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_alumnos_inscritos_acd.index') ? "selected": "" }}>Alumnos inscritos ACD</option>
                    
                    <option value="{{ route('secundaria.secundaria_lista_de_interasados.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_lista_de_interasados.index') ? "selected": "" }}>Lista de interesados</option>

                    <option value="{{ route('secundaria.secundaria_inscritos_sexo.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_inscritos_sexo.reporte') ? "selected": "" }}>Resumen inscritos sexo SEC</option>

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
                {{ url()->current() ==  route('secundaria_calificacion_materia_ingles.index') ? "selected": "" }}>&nbsp;&nbsp;&nbsp; Res. de Inglés</option>  --}}

                {{--  Boleta  --}}
                <option value="{{ route('secundaria.secundaria_boleta_de_calificaciones.reporteBoleta') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_boleta_de_calificaciones.reporteBoleta') ? "selected": "" }}>Boleta</option>

                {{--  Boleta ACD --}}
                <option value="{{ route('secundaria.secundaria_boleta_de_calificaciones_acd.reporteBoleta') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_boleta_de_calificaciones_acd.reporteBoleta') ? "selected": "" }}>Boleta ACD</option>

                <option value="{{ route('secundaria.secundaria_historial_alumno.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_historial_alumno.reporte') ? "selected": "" }}>Historial académico del alumno</option>
            </optgroup>

            <optgroup label="&nbsp;Docentes">

                {{--  Rel. Grupos Maestros  --}}
                <option value="{{ route('secundaria_relacion_maestros_escuela.reporte') }}"
                    {{ url()->current() ==  route('secundaria_relacion_maestros_escuela.reporte') ? "selected": "" }}>Rel. Grupos Maestros</option>

                {{--  Rel. Grupos ACD  --}}
                <option value="{{ route('secundaria_reporte.relacion_maestros_acd.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.relacion_maestros_acd.reporte') ? "selected": "" }}>Rel. Grupos ACD</option>

                <option value="{{ route('secundaria_reporte.calificaciones_faltantes.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.calificaciones_faltantes.reporte') ? "selected": "" }}>Calificaciones Faltantes</option>

            </optgroup>


            <optgroup label="&nbsp;Grupos">

                {{--  Lista de asistencia  --}}
                <option value="{{ route('secundaria_reporte.lista_de_asistencia.reporte') }}"
                    {{ url()->current() ==  route('secundaria_reporte.lista_de_asistencia.reporte') ? "selected": "" }}>Lista de asistencia</option>

                {{--  lista de asistencia ACD  --}}
                <option value="{{ route('secundaria_reporte.lista_de_asistencia_ACD.reporteACD') }}"
                    {{ url()->current() ==  route('secundaria_reporte.lista_de_asistencia_ACD.reporteACD') ? "selected": "" }}>Lista de asistencia ACD</option>

                <option value="{{ route('secundaria.secundaria_resumen_inasistencias.index') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_resumen_inasistencias.index') ? "selected": "" }}>Resumen de inasistencia</option>

                <option value="{{ route('secundaria.secundaria_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_grupo_semestre.reporte') ? "selected": "" }}>Resumen de inasistencia</option>

                <option value="{{ route('secundaria.secundaria_grupo_semestre.reporte') }}"
                    {{ url()->current() ==  route('secundaria.secundaria_grupo_semestre.reporte') ? "selected": "" }}>Rel. grupos materias</option>

            </optgroup>



            <optgroup label="&nbsp;Pagos SEC">

                {{--  Deudas de un Alumno  --}}
                <option value="{{ url('reporte/secundaria_relacion_deudas') }}"
                    {{ url()->current() ==  url('reporte/secundaria_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno SEC</option>

                {{--  lista de asistencia ACD  --}}
                <option value="{{ url('reporte/secundaria_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/secundaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores SEC</option>

            </optgroup>



        </optgroup>



    @endif

@endif

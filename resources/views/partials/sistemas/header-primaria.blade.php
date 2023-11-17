@if (Auth::user()->primaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="PRI Catálogos">
            <option value="{{ route('primaria.primaria_periodo.index') }}" {{ url()->current() ==  route('primaria.primaria_periodo.index') ? "selected": "" }}>Períodos</option>
            <option value="{{ route('primaria.primaria_programa.index') }}" {{ url()->current() ==  route('primaria.primaria_programa.index') ? "selected": "" }}>Programas</option>
            <option value="{{ route('primaria.primaria_plan.index') }}" {{ url()->current() ==  route('primaria.primaria_plan.index') ? "selected": "" }}>Planes</option>
            <option value="{{ route('primaria.primaria_materia.index') }}" {{ url()->current() ==  route('primaria.primaria_materia.index') ? "selected": "" }}>Materias</option>
            <option value="{{ route('primaria.primaria_materias_asignaturas.index') }}" {{ url()->current() ==  route('primaria.primaria_materias_asignaturas.index') ? "selected": "" }}>Materias Asignaturas</option>
            <option value="{{ route('primaria.primaria_cgt.index') }}" {{ url()->current() ==  route('primaria.primaria_cgt.index') ? "selected": "" }}>CGT</option>
            <option value="{{ route('primaria.primaria_categoria_contenido.index') }}" {{ url()->current() ==  route('primaria.primaria_categoria_contenido.index') ? "selected": "" }}>Perf. Cat. Contenidos </option>
            <option value="{{ route('primaria.primaria_calificador.index') }}" {{ url()->current() ==  route('primaria.primaria_calificador.index') ? "selected": "" }}>Perf. Calificadores </option>
            <option value="{{ route('primaria.primaria_contenido_fundamental.index') }}" {{ url()->current() ==  route('primaria.primaria_contenido_fundamental.index') ? "selected": "" }}>Perf. Contenidos</option>
            {{--  Migrar Inscritos ACD   --}}
            <option value="{{ route('primaria.primaria_migrar_inscritos_acd.index') }}" {{ url()->current() ==  route('primaria.primaria_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos ACD</option>
        </optgroup>

        <optgroup label="PRI C.Escolar">
                <option value="{{ route('primaria_alumno.index') }}"
                    {{ url()->current() ==  route('primaria_alumno.index') ? "selected": "" }}>Alumnos</option>

                <option value="{{ route('primaria_curso.index') }}"
                    {{ url()->current() ==  route('primaria_curso.index') ? "selected": "" }}>Preinscritos</option>


                <option value="{{ route('primaria_asignar_cgt.edit') }}"
                    {{ url()->current() ==  route('primaria_asignar_cgt.edit') ? "selected": "" }}>Asignar CGT</option>

                <option value="{{ route('primaria.primaria_materias_inscrito.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_materias_inscrito.index') ? "selected": "" }}>Cargar Materias a Inscrito</option>

                {{--  CGT Materias  --}}
                <option value="{{ route('primaria.primaria_cgt_materias.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

                {{-- Asignar Docente Presencial  --}}
                <option value="{{ route('primaria.primaria.primaria_asignar_docente_presencial.index') }}"
                    {{ url()->current() ==  route('primaria.primaria.primaria_asignar_docente_presencial.index') ? "selected": "" }}>Docentes Presenciales Grupos</option>

                {{-- Asignar Docente Virtual  --}}
                <option value="{{ route('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual') }}"
                    {{ url()->current() ==  route('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual') ? "selected": "" }}>Docentes Virtuales Grupos</option>

                {{--  Grupos   --}}
                <option value="{{ route('primaria_grupo.index') }}"
                    {{ url()->current() ==  route('primaria_grupo.index') ? "selected": "" }}>Grupos</option>

                {{--  Cambio de programa   --}}
                <option value="{{ route('primaria.primaria.primaria_cambio_programa.index') }}"
                    {{ url()->current() ==  route('primaria.primaria.primaria_cambio_programa.index') ? "selected": "" }}>Cambio de Programa</option>

                      {{-- Inscrito Modalidad --}}
                      <option value="{{ route('primaria.primaria.primaria_inscrito_modalidad.index') }}"
                      {{ url()->current() ==  route('primaria.primaria.primaria_inscrito_modalidad.index') ? "selected": "" }}>Inscrito Modalidad</option>

            
                <option value="{{ route('primaria.primaria_docente_inscrito_modalidad.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_docente_inscrito_modalidad.index') ? "selected": "" }}>Docente Inscrito Modalidad</option>

                <option value="{{ route('primaria.primaria_cambiar_cgt.edit') }}"
                    {{ url()->current() ==  route('primaria.primaria_cambiar_cgt.edit') ? "selected": "" }}>Cambiar CGT</option>
                {{--  Grupos inscritos   --}}
                <option value="{{ route('primaria_asignar_grupo.index') }}"
                    {{ url()->current() ==  route('primaria_asignar_grupo.index') ? "selected": "" }}>Inscritos Grupos</option>


                {{--  Observaciones calificaciones   --}}
                <option value="{{ route('primaria.primaria.primaria_obs_boleta.index') }}"
                    {{ url()->current() ==  route('primaria.primaria.primaria_obs_boleta.index') ? "selected": "" }}>Obs. boleta</option>

                <option value="{{ route('primaria.primaria_horarios_libres.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_horarios_libres.index') ? "selected": "" }}>Horarios libres</option>

                <option value="{{ route('primaria.primaria_fecha_publicacion_calificacion_docente.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_fecha_publicacion_calificacion_docente.index') ? "selected": "" }}>Fecha Calif. Docentes</option>

                <option value="{{ route('primaria.primaria_fecha_publicacion_calificacion_alumno.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_fecha_publicacion_calificacion_alumno.index') ? "selected": "" }}>Fecha Calif. Alumnos</option>

                    <option value="{{ route('primaria.primaria_calificacion_general.viewCalificacionGeneral') }}"
                    {{ url()->current() ==  route('primaria.primaria_calificacion_general.viewCalificacionGeneral') ? "selected": "" }}>Modificar Boleta</option>

        </optgroup>

        <optgroup label="PRI Expediente">
            <option value="{{ route('primaria.primaria_entrevista_inicial.index') }}"
                {{ url()->current() ==  route('primaria.primaria_entrevista_inicial.index') ? "selected": "" }}>Entrevista Inicial </option>

            

            <option value="{{ route('primaria.primaria_perfil.index') }}"
                {{ url()->current() ==  route('primaria.primaria_perfil.index') ? "selected": "" }}>Perfiles </option>

            <option value="{{ route('primaria.primaria_seguimiento_escolar.index') }}"
                {{ url()->current() ==  route('primaria.primaria_seguimiento_escolar.index') ? "selected": "" }}>Seguimiento Escolar </option>

            <option value="{{ route('primaria_calendario.index') }}"
                {{ url()->current() ==  route('primaria_calendario.index') ? "selected": "" }}>Agenda </option>

            <option value="{{ route('primaria.primaria_datos_completos_alumno.reporteAlumnos') }}"
                {{ url()->current() ==  route('primaria.primaria_datos_completos_alumno.reporteAlumnos') ? "selected": "" }}>Datos Completos de Alumno </option>


            <option value="{{ route('primaria.primaria_alumnos_excel') }}"
                {{ url()->current() ==  route('primaria.primaria_alumnos_excel') ? "selected": "" }}>Alumnos Excel </option>
        </optgroup>


        <optgroup label="PRI Docentes">

            {{-- empleados  --}}
            <option value="{{ route('primaria_empleado.index') }}"
                {{ url()->current() ==  route('primaria_empleado.index') ? "selected": "" }}>Empleados</option>

            {{-- acceso a docente  --}}
            <option value="{{ route('primaria.primaria_cambiar_contrasenia.index') }}"
                {{ url()->current() ==  route('primaria.primaria_cambiar_contrasenia.index') ? "selected": "" }}>Acceso de Docente </option>

            {{--  Agenda   --}}
            <option value="{{ route('primaria_calendario.index') }}"
                {{ url()->current() ==  route('primaria_calendario.index') ? "selected": "" }}>Agenda</option>


            <option value="{{ route('primaria.primaria_planeacion_docente.index') }}"
                {{ url()->current() ==  route('primaria.primaria_planeacion_docente.index') ? "selected": "" }}>Planeación </option>

            <option value="{{ route('primaria.primaria_ahorro_escolar.index') }}"
                {{ url()->current() ==  route('primaria.primaria_ahorro_escolar.index') ? "selected": "" }}>Ahorro escolar</option>

        </optgroup>

        <optgroup label="PRI Act. ExtraEscolares">

            <option value="{{ route('universidad.universidad_actividades.index') }}"
            {{ url()->current() ==  route('universidad.universidad_actividades.index') ? "selected": "" }}>Actividades (Grupos)</option>

        <option value="{{ route('universidad.universidad_nuevo_externo.create') }}"
            {{ url()->current() ==  route('universidad.universidad_nuevo_externo.create') ? "selected": "" }}>Nuevo Externo</option>

        <option value="{{ route('universidad.universidad_actividades_inscritos.index') }}"
            {{ url()->current() ==  route('universidad.universidad_actividades_inscritos.index') ? "selected": "" }}>Inscritos Actividades</option>

            <option value="{{ url('empleado') }}"
                    {{ url()->current() ==  url('empleado') ? "selected": "" }}>Instructores (Empleados)</option>

                   
        </optgroup>

        <optgroup label="PRI Pagos">
            <option value="{{ url('pagos/ficha_general') }}"
                {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

            <option value="{{ url('primaria/pagos/aplicar_pagos') }}"
                {{ url()->current() ==  url('primaria/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>

        </optgroup>

        <optgroup label="PRI Reportes">
            {{-- Alumnos --}}
            <optgroup label="&nbsp;Alumnos PRI">
                <option value="{{ route('primaria_inscrito_preinscrito.reporte') }}"
                    {{ url()->current() ==  route('primaria_inscrito_preinscrito.reporte') ? "selected": "" }}>Inscritos y preinscritos</option>

                <option value="{{ url('reporte/primaria_resumen_inscritos') }}"
                    {{ url()->current() ==  url('reporte/primaria_resumen_inscritos') ? "selected": "" }}>Resumen inscritos PRI</option>

                <option value="{{ route('primaria.primaria_lista_edades.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_lista_edades.index') ? "selected": "" }}>Lista de edades</option>
                {{--  Expediente de alumnos   --}}
                <option value="{{ route('primaria_reporte.expediente_alumnos.index') }}"
                    {{ url()->current() ==  route('primaria_reporte.expediente_alumnos.index') ? "selected": "" }}>Expediente de alumnos</option>

                <option value="{{ route('primaria.primaria_estatus_preescolar.reporte') }}"
                    {{ url()->current() ==  route('primaria.primaria_estatus_preescolar.reporte') ? "selected": "" }}>Estudiaron Preescolar</option>

                <option value="{{ route('primaria_reporte.ficha_tecnica.index') }}"
                    {{ url()->current() ==  route('primaria_reporte.ficha_tecnica.index') ? "selected": "" }}>Ficha técnica</option>

                {{--  Reporte de alumnos becados   --}}
                <option value="{{ route('primaria_reporte.primaria_alumnos_becados.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.primaria_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>

                {{-- Relación de Bajas --}}
                <option value="{{ route('primaria.primaria_relacion_bajas_periodo.reporte') }}"
                    {{ url()->current() ==  route('primaria.primaria_relacion_bajas_periodo.reporte') ? "selected": "" }}>Rel. de bajas</option>

                <option value="{{ route('primaria.primaria_perfil_alumno.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_perfil_alumno.index') ? "selected": "" }}>Perfiles</option>

                <option value="{{ route('primaria.reporte.ahorro_escolar.index') }}"
                    {{ url()->current() ==  route('primaria.reporte.ahorro_escolar.index') ? "selected": "" }}>Ahorro</option>

                <option value="{{ route('primaria.primaria_relacion_tutores.index') }}"
                    {{ url()->current() ==  route('primaria.primaria_relacion_tutores.index') ? "selected": "" }}>Rel. de Familia/Tutores</option>

                <option value="{{ route('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte') ? "selected": "" }}>Lista Presencial-Virtual</option>

                    <option value="{{ route('primaria.primaria_inscritos_sexo.reporte') }}"
                    {{ url()->current() ==  route('primaria.primaria_inscritos_sexo.reporte') ? "selected": "" }}>Resumen inscritos sexo PRI</option>
            </optgroup>

            <optgroup label="&nbsp;Constancias">

                {{--  Calificaciones de grupo  --}}
                <option value="{{ route('primaria_reporte.constancia_cupo.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.constancia_cupo.reporte') ? "selected": "" }}>Constancia Cupo</option>

                {{--  Calificaciones por materia  --}}
                <option value="{{ route('primaria_reporte.constancia_estudio.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.constancia_estudio.reporte') ? "selected": "" }}>Constancia Estudio</option>

                <option value="{{ route('primaria.primaria_buena_conducta.reporte') }}"
                    {{ url()->current() ==  route('primaria.primaria_buena_conducta.reporte') ? "selected": "" }}>Constancia Buena conducta</option>

                <option value="{{ route('primaria_reporte.constancia_pasaporte.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.constancia_pasaporte.reporte') ? "selected": "" }}>Constancia Pasaporte</option>
            </optgroup>

            <optgroup label="&nbsp;Calificaciones">

                {{--  Calificaciones de grupo  --}}
                <option value="{{ route('primaria_reporte.calificaciones_grupo.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.calificaciones_grupo.reporte') ? "selected": "" }}>Res. por grupo</option>

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
                    {{ url()->current() ==  route('primaria_relacion_maestros_escuela.reporte') ? "selected": "" }}>Grupos Maestros</option>

                {{--  Rel. Grupos ACD  --}}
                <option value="{{ route('primaria_reporte.relacion_maestros_acd.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.relacion_maestros_acd.reporte') ? "selected": "" }}>Grupos ACD</option>

                <option value="{{ route('primaria.reporte.planeacion_docente.index') }}"
                    {{ url()->current() ==  route('primaria.reporte.planeacion_docente.index') ? "selected": "" }}>Planeación</option>

            </optgroup>

            <optgroup label="&nbsp;Grupos">

                {{--  Lista de asistencia  --}}
                {{--  <option value="{{ route('primaria_reporte.lista_de_asistencia.reporte') }}"
                    {{ url()->current() ==  route('primaria_reporte.lista_de_asistencia.reporte') ? "selected": "" }}>&nbsp;&nbsp; Lista de asistencia</option>  --}}

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


            <optgroup label="&nbsp;Pagos PRI">
                {{--  Deudas de un Alumno  --}}
                <option value="{{ url('reporte/primaria_relacion_deudas') }}"
                    {{ url()->current() ==  url('reporte/primaria_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno PRI</option>

                {{--  lista de asistencia ACD  --}}
                <option value="{{ url('reporte/primaria_relacion_deudores') }}"
                    {{ url()->current() ==  url('reporte/primaria_relacion_deudores') ? "selected": "" }}>Relación de Deudores PRI</option>

            </optgroup>



        </optgroup>



    @endif

@endif

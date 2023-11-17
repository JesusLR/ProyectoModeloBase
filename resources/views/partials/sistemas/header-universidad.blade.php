@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )


    @if(  Auth::user()->departamento_sistemas == 1 )

        <optgroup label="SUP-POS Catálogos">
            <option value="{{ url('ubicacion') }}" {{ url()->current() ==  url('ubicacion') ? "selected": "" }}>Ubicación</option>
            <option value="{{ url('departamento') }}" {{ url()->current() ==  url('departamento') ? "selected": "" }}>Departamentos</option>
            <option value="{{ url('escuela') }}" {{ url()->current() ==  url('escuela') ? "selected": "" }}>Escuelas</option>
            <option value="{{ url('programa') }}" {{ url()->current() ==  url('programa') ? "selected": "" }}>Programas</option>
            <option value="{{ url('plan') }}" {{ url()->current() ==  url('plan') ? "selected": "" }}>Planes</option>
            <option value="{{ url('periodo') }}" {{ url()->current() ==  url('periodo') ? "selected": "" }}>Periodos</option>
            <option value="{{ url('acuerdo') }}" {{ url()->current() ==  url('acuerdo') ? "selected": "" }}>Acuerdos</option>
            <option value="{{ url('materia') }}" {{ url()->current() ==  url('materia') ? "selected": "" }}>Materias</option>
            <option value="{{ url('optativa') }}" {{ url()->current() ==  url('optativa') ? "selected": "" }}>Optativas</option>
            <option value="{{ url('aula') }}" {{ url()->current() ==  url('aula') ? "selected": "" }}>Aulas</option>
            <option value="{{ url('profesion') }}" {{ url()->current() ==  url('profesion') ? "selected": "" }}>Profesiones</option>
            <option value="{{ url('abreviatura') }}" {{ url()->current() ==  url('abreviatura') ? "selected": "" }}>Abreviaturas</option>
            <option value="{{ url('beca') }}" {{ url()->current() ==  url('beca') ? "selected": "" }}>Becas</option>
            <option value="{{ url('concepto_baja') }}" {{ url()->current() ==  url('concepto_baja') ? "selected": "" }}>Concepto de bajas</option>
            <option value="{{ url('concepto_titulacion') }}" {{ url()->current() ==  url('concepto_titulacion') ? "selected": "" }}>Concepto de titulación</option>
            <option value="{{ url('paises') }}" {{ url()->current() ==  url('paises') ? "selected": "" }}>Paises</option>
            <option value="{{ url('estados') }}" {{ url()->current() ==  url('estados') ? "selected": "" }}>Estados</option>
            <option value="{{ url('municipios') }}" {{ url()->current() ==  url('municipios') ? "selected": "" }}>Municipios</option>
            <option value="{{ url('preparatorias') }}" {{ url()->current() ==  url('preparatorias') ? "selected": "" }}>Preparatorias</option>
            <option value="{{ url('registro') }}" {{ url()->current() ==  url('registro') ? "selected": "" }}>Responsables de registro</option>
            <option value="{{ url('puestos') }}" {{ url()->current() ==  url('puestos') ? "selected": "" }}>Puestos</option>
        </optgroup>

        <optgroup label="SUP-POS C.Escolar">

            <option value="{{ url('empleado') }}" {{ url()->current() ==  url('empleado') ? "selected": "" }}>Empleados</option>
            <option value="{{ url('alumno') }}" {{ url()->current() ==  url('alumno') ? "selected": "" }}>Alumnos</option>
            <option value="{{ url('alumno_restringido') }}" {{ url()->current() ==  url('alumno_restringido') ? "selected": "" }}>Alumnos restringidos</option>

            <option value="{{ url('cgt') }}" {{ url()->current() ==  url('cgt') ? "selected": "" }}>CGT</option>
            @if(in_array(auth()->user()->permiso('cambiar_cgt'), ['A', 'B', 'C']))
                <option value="{{ url('cambiar_cgt') }}" {{ url()->current() ==  url('cambiar_cgt') ? "selected": "" }}>Cambiar CGT</option>
            @endif
            <option value="{{ url('grupo') }}" {{ url()->current() ==  url('grupo') ? "selected": "" }}>Grupos</option>
            <option value="{{ url('paquete') }}" {{ url()->current() ==  url('paquete') ? "selected": "" }}>Paquetes</option>
            <option value="{{ url('curso') }}" {{ url()->current() ==  url('curso') ? "selected": "" }}>Preinscritos</option>
            <option value="{{ url('inscrito') }}" {{ url()->current() ==  url('inscrito') ? "selected": "" }}>Inscritos</option>

            <option value="{{ url('preinscrito_extraordinario') }}" {{ url()->current() ==  url('preinscrito_extraordinario') ? "selected": "" }}>Preinscrito extraordinario</option>

            <option value="{{ url('extraordinario') }}" {{ url()->current() ==  url('extraordinario') ? "selected": "" }}>Extraordinarios</option>
            <option value="{{ url('matricula_anterior') }}" {{ url()->current() ==  url('matricula_anterior') ? "selected": "" }}>Matricula Anterior</option>
            <option value="{{ url('escolaridad') }}" {{ url()->current() ==  url('escolaridad') ? "selected": "" }}>Escolaridad</option>
            <option value="{{ url('clave_profesor') }}" {{ url()->current() ==  url('clave_profesor') ? "selected": "" }}>Clave SEGEY</option>
            <option value="{{ url('horarios_administrativos') }}" {{ url()->current() ==  url('horarios_administrativos') ? "selected": "" }}>Horarios administrativos</option>
            <option value="{{ url('historico') }}" {{ url()->current() ==  url('historico') ? "selected": "" }}>Historico</option>

            <option value="{{ url('preinscripcion_auto') }}" {{ url()->current() ==  url('preinscripcion_auto') ? "selected": "" }}>Preinscripción Automática</option>

            <option value="{{ url('serviciosocial') }}" {{ url()->current() ==  url('serviciosocial') ? "selected": "" }}>Servicio Social</option>

                <option value="{{ url('cierre_actas') }}" {{ url()->current() ==  url('cierre_actas') ? "selected": "" }}>Cierre de actas</option>
                <option value="{{ url('cierre_extras') }}" {{ url()->current() ==  url('cierre_actas') ? "selected": "" }}>Cierre de actas(Extraordinarios)</option>
               <option value="{{ url('egresados') }}" {{ url()->current() ==  url('egresados') ? "selected": "" }}>Egresados</option>
                <option value="{{ url('registro_egresados') }}" {{ url()->current() ==  url('registro_egresados') ? "selected": "" }}>Registro Automático Egresados</option>

                <option value="{{ url('tutores') }}" {{ url()->current() ==  url('tutores') ? "selected": "" }}>Tutores</option>
                <option value="{{ url('calendarioexamen') }}" {{ url()->current() ==  url('calendarioexamen') ? "selected": "" }}>Calendario Exámenes</option>
                <option value="{{ url('candidatos_primer_ingreso') }}" {{ url()->current() ==  url('candidatos_primer_ingreso') ? "selected": "" }}>Candidatos 1er Ingreso</option>


                <option value="{{ url('cambiar_contrasena') }}" {{ url()->current() ==  url('cambiar_contrasena') ? "selected": "" }}>Cambiar contraseña de docentes</option>

                <option value="{{ url('extracurricular') }}" {{ url()->current() ==  url('extracurricular') ? "selected": "" }}>Extracurricular</option>

                 <option value="{{ url('resumen_academico') }}" {{ url()->current() ==  url('resumen_academico') ? "selected": "" }}>Resúmenes académicos</option>
                 <option value="{{ url('revalidaciones') }}" {{ url()->current() ==  url('revalidaciones') ? "selected": "" }}>Revalidaciones</option>

        </optgroup>

        <optgroup label="SUP-POS Pagos">
            <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

             <option value="{{ url('pagos/aplicar_pagos') }}" {{ url()->current() ==  url('pagos/aplicar_pagos') ? "selected": "" }}>Consultar pagos</option>

            <option value="{{ url('pagos/consulta_fichas') }}" {{ url()->current() ==  url('pagos/consulta_fichas') ? "selected": "" }}>Consulta de fichas</option>
            <option value="{{ url('/concepto_pago') }}" {{ url()->current() ==  url('/concepto_pago') ? "selected": "" }}>Conceptos de pago</option>
            <option value="{{ url('becas_historial/cursos') }}" {{ url()->current() ==  url('becas_historial/cursos') ? "selected": "" }}>Historial de becas</option>
        </optgroup>

        <optgroup label="SUP-POS Reportes">
            <optgroup label="> Alumnos">
                <option value="{{ url('reporte/primer_ingreso') }}" {{ url()->current() ==  url('reporte/primer_ingreso') ? "selected": "" }}>Primer ingreso</option>
                <option value="{{ url('reporte/inscrito_preinscrito') }}" {{ url()->current() ==  url('reporte/inscrito_preinscrito') ? "selected": "" }}>Inscritos y preinscritos</option>
                <option value="{{ url('reporte/asistencia_grupo') }}" {{ url()->current() ==  url('reporte/asistencia_grupo') ? "selected": "" }}>Lista asistencia por grupo</option>
                <option value="{{ url('reporte/grupo_materia') }}" {{ url()->current() ==  url('reporte/grupo_materia') ? "selected": "" }}>Lista asistencia por materia</option>
                @if(auth()->user()->isAdmin('conteo_servicio_social'))
                    <option value="{{ url('reporte/conteo_servicio_social') }}" {{ url()->current() ==  url('reporte/conteo_servicio_social') ? "selected": "" }}>Conteo de servicio social</option>
                @endif
                @if(auth()->user()->isAdmin('lista_servicio_social'))
                    <option value="{{ url('reporte/lista_servicio_social') }}" {{ url()->current() ==  url('reporte/lista_servicio_social') ? "selected": "" }}>Lista de servicio social</option>
                @endif
                <option value="{{ url('reporte/materias_adeudadas_alumnos') }}" {{ url()->current() ==  url('reporte/materias_adeudadas_alumnos') ? "selected": "" }}>Materias adeudadas</option>
                <option value="{{ url('reporte/rel_alumnos_matriculas') }}" {{ url()->current() ==  url('reporte/rel_alumnos_matriculas') ? "selected": "" }}>Rel. alumnos matriculas</option>
                <option value="{{ url('reporte/alumnos_becados') }}" {{ url()->current() ==  url('reporte/alumnos_becados') ? "selected": "" }}>Rel. alumnos becados</option>
                <option value="{{ url('reporte/rel_datos_generales') }}" {{ url()->current() ==  url('reporte/alumnos_becados') ? "selected": "" }}>Rel. datos generales</option>
                <option value="{{ url('reporte/alumnos_foraneos') }}" {{ url()->current() ==  url('reporte/alumnos_foraneos') ? "selected": "" }}>Rel. foráneos</option>
                <option value="{{ url('reporte/rel_pos_bajas') }}" {{ url()->current() ==  url('reporte/rel_pos_bajas') ? "selected": "" }}>Rel. posibles bajas</option>
                <option value="{{ url('reporte/servicio_social') }}" {{ url()->current() ==  url('reporte/servicio_social') ? "selected": "" }}>Rel. servicio social</option>
                <option value="{{ url('reporte/resumen_grupos_alumno') }}" {{ url()->current() ==  url('reporte/resumen_grupos_alumno') ? "selected": "" }}>Resumen grupos alumno</option>
                <option value="{{ url('reporte/alumnos_asistentes') }}" {{ url()->current() ==  url('reporte/alumnos_asistentes') ? "selected": "" }}>Rel. alumnos asistentes</option>
                <option value="{{ url('reporte/inscritos_sexo') }}" {{ url()->current() ==  url('reporte/inscritos_sexo') ? "selected": "" }}>Resumen inscritos sexo</option>
                <option value="{{ url('reporte/alumnos_asistentes') }}" {{ url()->current() ==  url('reporte/alumnos_asistentes') ? "selected": "" }}>Rel. alumnos asistentes</option>
                <option value="{{ url('reporte/posibles_hermanos') }}" {{ url()->current() ==  url('reporte/posibles_hermanos') ? "selected": "" }}>Rel. posibles hermanos</option>
                <option value="{{ url('reporte/rel_cumple_alumnos') }}" {{ url()->current() ==  url('reporte/rel_cumple_alumnos') ? "selected": "" }}>Rel. cumpleaños alumnos</option>
                <option value="{{ url('reporte/res_antiguedad_preinscritos') }}" {{ url()->current() ==  url('reporte/res_antiguedad_preinscritos') ? "selected": "" }}>Res. Antigüedad Preinscritos</option>
                <option value="{{ url('reporte/res_alumnos_no_inscritos') }}" {{ url()->current() ==  url('reporte/res_alumnos_no_inscritos') ? "selected": "" }}>Res. Alumnos no Inscritos</option>
                <option value="{{ url('reporte/relacion_bajas_periodo') }}" {{ url()->current() ==  url('reporte/relacion_bajas_periodo') ? "selected": "" }}>Rel. Bajas por periodo</option>
                <option value="{{ url('reporte/rel_alumnos_reprobados') }}" {{ url()->current() ==  url('reporte/rel_alumnos_reprobados') ? "selected": "" }}>Rel. Alumnos Reprobados</option>
                <option value="{{ url('reporte/rel_correos_alumnos_padres') }}" {{ url()->current() ==  url('reporte/rel_correos_alumnos_padres') ? "selected": "" }}>Rel. Correos Alumnos/Padres</option>
                    <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option>
                <option value="{{ url('reporte/relacion_deudores') }}" {{ url()->current() ==  url('reporte/relacion_deudores') ? "selected": "" }}>Rel. alumnos deudores</option>
                     <option value="{{ url('reporte/relacion_inscritos_primero') }}" {{ url()->current() ==  url('reporte/relacion_inscritos_primero') ? "selected": "" }}>Rel. Inscritos de primero</option>
                   <option value="{{ url('reporte/lista_por_tipo_ingreso') }}" {{ url()->current() ==  url('reporte/lista_por_tipo_ingreso') ? "selected": "" }}>Lista por tipo ingreso</option>
                    <option value="{{ url('reporte/alumnos_ultimo_grado') }}" {{ url()->current() ==  url('reporte/alumnos_ultimo_grado') ? "selected": "" }}>Alumnos de último grado</option>
                   <option value="{{ url('reporte/alumnos_encuestados') }}" {{ url()->current() ==  url('reporte/alumnos_encuestados') ? "selected": "" }}>Alumnos encuestados</option>
                   <option value="{{ url('reporte/resumen_alumnos_encuestados') }}" {{ url()->current() ==  url('reporte/resumen_alumnos_encuestados') ? "selected": "" }}>Resumen Alumnos encuestados</option>
                   <option value="{{ url('reporte/deudores_economico_academico') }}" {{ url()->current() ==  url('reporte/deudores_economico_academico') ? "selected": "" }}>Deudores Económico Académico</option>
                  <option value="{{ url('reporte/alumnos_regulares_sin_curso') }}" {{ url()->current() ==  url('reporte/alumnos_regulares_sin_curso') ? "selected": "" }}>Alumnos Regulares Sin Curso</option>
                  @if(auth()->user()->isAdmin('alumnos_reprobados_parciales'))
                    <option value="{{ url('reporte/alumnos_reprobados_parciales') }}" {{ url()->current() ==  url('reporte/alumnos_reprobados_parciales') ? "selected": "" }}>Reprobados por parciales</option>
                  @endif
            </optgroup>

            <optgroup label="> Acreditaciones">
                <option value="{{ url('reporte/historicos_por_escuela') }}" {{ url()->current() ==  url('reporte/historicos_por_escuela') ? "selected": "" }}>Historicos por escuela</option>
            </optgroup>

            <optgroup label="> Calificaciones">
                <option value="{{ url('reporte/actas_pendientes') }}" {{ url()->current() ==  url('reporte/actas_pendientes') ? "selected": "" }}>Actas pendientes</option>
                <option value="{{ url('reporte/boleta_calificaciones') }}" {{ url()->current() ==  url('reporte/boleta_calificaciones') ? "selected": "" }}>Boleta de Calificaciones</option>
                <option value="{{ url('reporte/historial_alumno') }}" {{ url()->current() ==  url('reporte/historial_alumno') ? "selected": "" }}>Historial acádemico de alumnos</option>
                <option value="{{ url('reporte/kardex_academico') }}" {{ url()->current() ==  url('reporte/kardex_academico') ? "selected": "" }}>kardex Académico</option>
                <option value="{{ url('reporte/mejores_promedios') }}" {{ url()->current() ==  url('reporte/mejores_promedios') ? "selected": "" }}>Mejores Promedios</option>
                <option value="{{ url('reporte/mejor_promedio_total') }}" {{ url()->current() ==  url('reporte/mejores_promedios') ? "selected": "" }}>Mejor Promedio Total</option>
                <option value="{{ url('reporte/indice_reprobacion') }}" {{ url()->current() ==  url('reporte/indice_reprobacion') ? "selected": "" }}>Indice de reprobación</option>
                <option value="{{ url('reporte/porcentaje_aprobacion') }}" {{ url()->current() ==  url('reporte/porcentaje_aprobacion') ? "selected": "" }}>Porcentaje de aprobación</option>
                <option value="{{ url('reporte/acta_extraordinario') }}" {{ url()->current() ==  url('reporte/acta_extraordinario') ? "selected": "" }}>Acta de examen extraordinario</option>
                <option value="{{ url('reporte/acta_examen_ordinario') }}" {{ url()->current() ==  url('reporte/acta_examen_ordinario') ? "selected": "" }}>Acta de examen ordinario</option>
                <option value="{{ url('reporte/resumen_cal_grupos') }}" {{ url()->current() ==  url('reporte/resumen_cal_grupos') ? "selected": "" }}>Resumen calificación por grupos</option>
                <option value="{{ url('reporte/resumen_promedios') }}" {{ url()->current() ==  url('reporte/resumen_promedios') ? "selected": "" }}>Resumen promedios por grupos</option>
                <option value="{{ url('reporte/acreditaciones') }}" {{ url()->current() ==  url('reporte/acreditaciones') ? "selected": "" }}>Desempeño Académico</option>
                
            </optgroup>

            <optgroup label="> Constancias">
                <option value="{{ url('reporte/constancia_inscripcion') }}">Constancia de inscripción</option>
                <option value="{{ url('reporte/buena_conducta') }}">Constancia de buena conducta</option>
                <option value="{{ url('reporte/solicitud_beca') }}">Constancia de solicitud de beca</option>
                <option value="{{ url('reporte/certificado_completo') }}">Certificado completo</option>
                <option value="{{ url('reporte/calificacion_final') }}">Constancia de calificaciones finales</option>
                <option value="{{ url('reporte/calificacion_carrera') }}">Constancia de toda la carrera</option>
                <option value="{{ url('reporte/calificacion_parcial') }}">Constancia de calificaciones parciales</option>
            </optgroup>

            <optgroup label="> Cursos">
                <option value="{{ url('reporte/aulas_escuela') }}" {{ url()->current() ==  url('reporte/aulas_escuela') ? "selected": "" }}>Aulas por escuela</option>
                <option value="{{ url('reporte/aulas_ocupadas_escuela') }}" {{ url()->current() ==  url('reporte/aulas_ocupadas_escuela') ? "selected": "" }}>Aulas ocupadas</option>
                <option value="{{ url('reporte/carga_alumnos_aula') }}" {{ url()->current() ==  url('reporte/carga_alumnos_aula') ? "selected": "" }}>Carga de alumnos por aula</option>
                <option value="{{ url('reporte/grupo_semestre') }}" {{ url()->current() ==  url('reporte/grupo_semestre') ? "selected": "" }}>Grupos por semestre</option>
                <option value="{{ url('reporte/materias_plan') }}" {{ url()->current() ==  url('reporte/materias_plan') ? "selected": "" }}>Materias por plan</option>
                <option value="{{ url('reporte/optativas_periodo') }}" {{ url()->current() ==  url('reporte/optativas_periodo') ? "selected": "" }}>Optativas por período</option>
                <option value="{{ url('reporte/rel_cambios_carrera') }}" {{ url()->current() ==  url('reporte/rel_cambios_carrera') ? "selected": "" }}>Rel. Cambios de Carrera</option>
                <option value="{{ url('reporte/relacion_cgt') }}" {{ url()->current() ==  url('reporte/relacion_cgt') ? "selected": "" }}>Rel. de CGTs</option>
                <option value="{{ url('reporte/relacion_grupos') }}" {{ url()->current() ==  url('reporte/relacion_grupos') ? "selected": "" }}>Rel. de grupos</option>
                <option value="{{ url('reporte/planes_estudio') }}" {{ url()->current() ==  url('reporte/planes_estudio') ? "selected": "" }}>Rel. Planes estudio</option>
                <option value="{{ url('reporte/rel_grupos_equivalentes') }}" {{ url()->current() ==  url('reporte/rel_grupos_equivalentes') ? "selected": "" }}>Rel. grupos equivalentes</option>
                <option value="{{ url('reporte/horario_por_grupo') }}" {{ url()->current() ==  url('reporte/horario_por_grupo') ? "selected": "" }}>Horario de clases</option>
                <option value="{{ url('reporte/resumen_escuelas') }}" {{ url()->current() ==  url('reporte/resumen_escuelas') ? "selected": "" }}>Res. Escuelas</option>
            </optgroup>

            <optgroup label="> Docentes">
                <option value="{{ url('reporte/carga_grupos_maestro') }}" {{ url()->current() ==  url('reporte/carga_grupos_maestro') ? "selected": "" }}>Carga grupos por maestro</option>
                <option value="{{ url('reporte/cumple_empleados') }}" {{ url()->current() ==  url('reporte/cumple_empleados') ? "selected": "" }}>Cumpleaños de empleados</option>
                <option value="{{ url('reporte/horario_personal_maestros') }}" {{ url()->current() ==  url('reporte/horario_personal_maestros') ? "selected": "" }}>Horarios personal maestro</option>
                @if(in_array(auth()->user()->permiso('horarios_personales_excel'), ['A', 'B', 'C']))
                    <option value="{{ url('reporte/horarios_personales_excel') }}" {{ url()->current() ==  url('reporte/horarios_personales_excel') ? "selected": "" }}>Horarios personales excel</option>
                @endif
                <option value="{{ url('reporte/horarios_administrativos') }}" {{ url()->current() ==  url('reporte/horarios_administrativos') ? "selected": "" }}>Horarios Administrativos</option>

                <option value="{{ url('reporte/plantilla_profesores') }}" {{ url()->current() ==  url('reporte/plantilla_profesores') ? "selected": "" }}>Plantilla de profesores</option>
                <option value="{{ url('reporte/relacion_maestros_escuela') }}" {{ url()->current() ==  url('reporte/relacion_maestros_escuela') ? "selected": "" }}>Rel. maestros escuela</option>
                <option value="{{ url('reporte/constancia_docente') }}" {{ url()->current() ==  url('reporte/constancia_docente') ? "selected": "" }}>Constancia Docente</option>
                   <option value="{{ url('reporte/conteo_empleados') }}" {{ url()->current() ==  url('reporte/conteo_empleados') ? "selected": "" }}>Conteo Empleados</option>
                   <option value="{{ url('reporte/resumen_docentes_encuestados') }}" {{ url()->current() ==  url('reporte/resumen_docentes_encuestados') ? "selected": "" }}>Resumen Docentes Encuestados</option>
                   <option value="{{ url('reporte/docentes_encuestados') }}" {{ url()->current() ==  url('reporte/docentes_encuestados') ? "selected": "" }}>Docentes Encuestados</option>
                @if(in_array(auth()->user()->permiso('directorio_empleados'), ['A', 'B', 'C']))
                   <option value="{{ url('reporte/directorio_empleados') }}" {{ url()->current() ==  url('reporte/directorio_empleados') ? "selected": "" }}>Directorio de Empleados</option>
                @endif
            </optgroup>

            <optgroup label="> Dirección">
                <option value="{{ url('reporte/relacion_nuevo_ingreso_exani') }}" {{ url()->current() ==  url('reporte/relacion_nuevo_ingreso_exani') ? "selected": "" }}>Rel. nuevo ingreso</option>
                <option value="{{ url('reporte/relacion_candidatos') }}" {{ url()->current() ==  url('reporte/relacion_candidatos') ? "selected": "" }}>Rel. candidatos</option>
            </optgroup>

            <optgroup label="> Egresados">
                <option value="{{ url('reporte/rel_pos_egresados') }}" {{ url()->current() ==  url('reporte/rel_pos_egresados') ? "selected": "" }}>Posibles egresados</option>
                <option value="{{ url('reporte/rel_egresados') }}" {{ url()->current() ==  url('reporte/rel_egresados') ? "selected": "" }}>Relación egresados</option>
                <option value="{{ url('reporte/res_egresados') }}" {{ url()->current() ==  url('reporte/res_egresados') ? "selected": "" }}>Resumen egresados</option>
                <option value="{{ url('reporte/resumen_egresados_excel') }}" {{ url()->current() ==  url('reporte/resumen_egresados_excel') ? "selected": "" }}>Resumen egresados (Excel)</option>
                <option value="{{ url('reporte/resumen_titulados') }}" {{ url()->current() ==  url('reporte/resumen_titulados') ? "selected": "" }}>Resumen titulados</option>
                <option value="{{ url('reporte/titulados_pasantes') }}" {{ url()->current() ==  url('reporte/titulados_pasantes') ? "selected": "" }}>Relación de titulados y pasantes</option>
                <option value="{{ url('reporte/total_egresados_tit') }}" {{ url()->current() ==  url('reporte/total_egresados_tit') ? "selected": "" }}>Total de egresados y titulados</option>
            </optgroup>

            <optgroup label="> Evaluaciones">
                <option value="{{ url('reporte/calendario_examenes_ordinarios') }}" {{ url()->current() ==  url('reporte/calendario_examenes_ordinarios') ? "selected": "" }}>Calendario exa. ordinarios</option>
                <option value="{{ url('reporte/listas_evaluacion_parcial') }}" {{ url()->current() ==  url('reporte/listas_evaluacion_parcial') ? "selected": "" }}>Listas evaluación parcial</option>
                <option value="{{ url('reporte/listas_evaluacion_ordinaria') }}" {{ url()->current() ==  url('reporte/listas_evaluacion_ordinaria') ? "selected": "" }}>Listas evaluación ordinaria</option>
                <option value="{{ url('reporte/programacion_examenes') }}" {{ url()->current() ==  url('reporte/programacion_examenes') ? "selected": "" }}>Programación de exa. extraordinarios</option>
                <option value="{{ url('reporte/numero_examenes') }}" {{ url()->current() ==  url('reporte/numero_examenes') ? "selected": "" }}>Número de exámenes</option>
                <option value="{{ url('reporte/validar_fechas_ordinarios') }}" {{ url()->current() ==  url('reporte/validar_fechas_ordinarios') ? "selected": "" }}>Validación de fechas de ordinarios</option>
            </optgroup>

                <optgroup label="> Extraordinarios">
                    <option value="{{ url('reporte/relacion_inscritos_extraordinario') }}" {{ url()->current() ==  url('reporte/relacion_inscritos_extraordinario') ? "selected": "" }}>Relación de Inscritos</option>
                     <option value="{{ url('reporte/resumen_inscritos_extraordinario') }}" {{ url()->current() ==  url('reporte/resumen_inscritos_extraordinario') ? "selected": "" }}>Resumen de Inscritos</option>

                </optgroup>



                <optgroup label="> Pagos">
                    <option value="{{ url('reporte/relacion_deudas') }}">Deudas de un Alumno</option>
                    <option value="{{ url('reporte/alumnos_sin_renovacion_beca') }}">Alumnos sin renovacion de beca</option>
                    <option value="{{ url('reporte/becas_campus_carrera_escuela') }}">Montos de Beca</option>
                    <option value="{{ url('pagos/movimiento_becas') }}" {{ url()->current() ==  url('movimiento_becas') ? "selected": "" }}>Movimiento de Becas</option>

                    <option value="{{ url('reporte/colegiaturas') }}">Pagos de Colegiaturas</option>

                    <option value="{{ url('reporte/relacion_deudores') }}">Relación de Deudores</option>

                    {{--
                    <option value="{{ url('reporte/tarjetas_pago_alumnos') }}" {{ url()->current() ==  url('reporte/tarjetas_pago_alumnos') ? "selected": "" }}>Tarjetas de pago</option>
                    --}}
                    
                    <option value="{{ url('pagos/registro_cuotas') }}" {{ url()->current() ==  url('registro_cuotas') ? "selected": "" }}>Registro de cuotas</option>


                    <option value="{{ url('reporte/estado_cuenta') }}" {{ url()->current() ==  url('reporte/estado_cuenta') ? "selected": "" }}>Estado de Cuenta</option>
                    <option value="{{ url('reporte/relacion_condicionados') }}" {{ url()->current() ==  url('reporte/relacion_condicionados') ? "selected": "" }}>Relación de condicionados</option>
                    <option value="{{ url('reporte/rel_pagos_capturados_usuario') }}" {{ url()->current() ==  url('reporte/rel_pagos_capturados_usuario') ? "selected": "" }}>Pagos capturados por usuario</option>
                    <option value="{{ url('reporte/pagos_duplicados') }}" {{ url()->current() ==  url('reporte/pagos_duplicados') ? "selected": "" }}>Pagos duplicados</option>
                    <option value="{{ url('reporte/historial_pagos_alumno') }}" {{ url()->current() ==  url('reporte/historial_pagos_alumno') ? "selected": "" }}>Historial de Pagos de Alumno</option>
                    <option value="{{ url('reporte/pagos_errores_al_aplicar') }}" {{ url()->current() ==  url('reporte/pagos_errores_al_aplicar') ? "selected": "" }}>Errores al aplicar</option>
                    <option value="{{ url('reporte/deudores_curso_anterior') }}" {{ url()->current() ==  url('reporte/deudores_curso_anterior') ? "selected": "" }}>Deudores Curso Anterior</option>
                    <option value="{{ url('reporte/resumen_pronto_pago') }}" {{ url()->current() ==  url('reporte/resumen_pronto_pago') ? "selected": "" }}>Resumen pronto pago</option>
                    <option value="{{ url('reporte/cambio_plan_pago') }}" {{ url()->current() ==  url('reporte/cambio_plan_pago') ? "selected": "" }}>Cambios de plan de pago</option>
                    <option value="{{ url('reporte/resumen_deudores') }}" {{ url()->current() ==  url('reporte/resumen_deudores') ? "selected": "" }}>Resumen Deudores</option>
                    <option value="{{ url('reporte/fichas_de_cobranza') }}" {{ url()->current() ==  url('reporte/fichas_de_cobranza') ? "selected": "" }}>Fichas de cobranza</option>
                    <option value="{{ url('reporte/fichas_generales') }}" {{ url()->current() ==  url('reporte/fichas_generales') ? "selected": "" }}>Fichas generales</option>
                    <option value="{{ url('reporte/cuotas_registradas') }}" {{ url()->current() ==  url('reporte/cuotas_registradas') ? "selected": "" }}>Cuotas Registradas</option>
                    <option value="{{ url('reporte/becas_con_observaciones') }}" {{ url()->current() ==  url('reporte/becas_con_observaciones') ? "selected": "" }}>Becas con Observaciones</option>
                    @if(auth()->user()->isAdmin('relacion_pagos_completos'))
                        <option value="{{ url('reporte/relacion_pagos_año_completos') }}" {{ url()->current() ==  url('reporte/relacion_pagos_año_completos') ? "selected": "" }}>Relación de Pagos Completos</option>
                    @endif

                </optgroup>


            <optgroup label="SEGEY">
                <option value="{{ url('reporte/segey/registro_alumnos') }}" {{ url()->current() ==  url('reporte/segey/registro_alumnos') ? "selected": "" }}>Registro de alumnos</option>
            </optgroup>
            <optgroup label="Estadisticas">
                @if(auth()->user()->isAdmin('cibies_administrativos'))
                    <option value="{{ url('reporte/cibies_administrativos') }}" {{ url()->current() ==  url('reporte/cibies_administrativos') ? "selected": "" }}>CIBIES Administrativos</option>
                @endif
                @if(auth()->user()->isAdmin('cibies_docentes'))
                    <option value="{{ url('reporte/cibies_docentes') }}" {{ url()->current() ==  url('reporte/cibies_docentes') ? "selected": "" }}>CIBIES Docentes</option>
                @endif
                @if(auth()->user()->isAdmin('historico_matricula'))
                    <option value="{{ url('reporte/historico_matricula') }}" {{ url()->current() ==  url('reporte/historico_matricula') ? "selected": "" }}>CIBIES Histórico Matrícula</option>
                @endif
                @if(auth()->user()->isAdmin('cibies_reincorporados'))
                    <option value="{{ url('reporte/cibies_reincorporados') }}" {{ url()->current() ==  url('reporte/cibies_reincorporados') ? "selected": "" }}>CIBIES Reincorporados</option>
                @endif
                <option value="{{ url('reporte/resumen_inscritos') }}" {{ url()->current() ==  url('reporte/resumen_inscritos') ? "selected": "" }}>Resumen Inscritos SUP</option>
                <option value="{{ url('reporte/listas_para_estadisticas') }}" {{ url()->current() ==  url('reporte/listas_para_estadisticas') ? "selected": "" }}>Listas de alumnos</option>
                <option value="{{ url('reporte/estadistica_estatal_licenciatura') }}" {{ url()->current() ==  url('reporte/estadistica_estatal_licenciatura') ? "selected": "" }}>Estatales de Licenciatura</option>
                <option value="{{ url('reporte/estadistica_estatal_educacion_continua') }}" {{ url()->current() ==  url('reporte/estadistica_estatal_educacion_continua') ? "selected": "" }}>Estatales de Educacion Continua</option>
                <option value="{{ url('reporte/estadistica_estatal_maestros') }}" {{ url()->current() ==  url('reporte/estadistica_estatal_maestros') ? "selected": "" }}>Estatales de Maestros</option>
                <option value="{{ url('reporte/resumen_inscritos_preinscritos') }}" {{ url()->current() ==  url('reporte/resumen_inscritos_preinscritos') ? "selected": "" }}>Resumen de inscritos y preinscritos SUP</option>
                <option value="{{ url('reporte/resumen_antiguedad') }}" {{ url()->current() ==  url('reporte/resumen_antiguedad') ? "selected": "" }}>Resumen de Antigüedad</option>
            </optgroup>

            <optgroup label="> Tutorías">
                <option value="{{ url('reporte/tutorias/reporte_por_tipo_respuesta') }}" {{ url()->current() ==  url('reporte/tutorias/reporte_por_tipo_respuesta') ? "selected": "" }}>Reporte por tipo de respuesta</option>
                <option value="{{ url('reporte/tutorias/alumnos_faltantes_encuesta') }}" {{ url()->current() ==  url('reporte/tutorias/alumnos_faltantes_encuesta') ? "selected": "" }}>Alumnos Faltantes Encuesta</option>
            </optgroup>

        </optgroup>

        <optgroup label="SUP-POS Prefecteo">
            <option value="{{ url('prefecteo') }}" {{ url()->current() ==  url('prefecteo') ? "selected": "" }}>Lista de prefecteos</option>
            <option value="{{ url('aulas_en_clase') }}" {{ url()->current() ==  url('aulas_en_clase') ? "selected": "" }}>Aulas en clase</option>
            <option value="{{ url('aulas/ocupadas') }}" {{ url()->current() ==  url('aulas/ocupadas') ? "selected": "" }}>Aulas ocupadas por Escuelas</option>
        </optgroup>

        <optgroup label="SUP-POS Archivos SEP">
            <option value="{{ url('archivo/grupo') }}" {{ url()->current() ==  url('archivo/grupo') ? "selected": "" }}>Grupos SEP</option>
            <option value="{{ url('archivo/inscripcion') }}" {{ url()->current() ==  url('archivo/inscripcion') ? "selected": "" }}>Inscripciones SEP</option>
            <option value="{{ url('archivo/ordinario') }}"  {{ url()->current() ==  url('archivo/ordinario') ? "selected": "" }}>Ordinarios SEP</option>
            <option value="{{ url('archivo/extraordinario') }}" {{ url()->current() ==  url('archivo/extraordinario') ? "selected": "" }}>Extraordinarios SEP</option>
            <option value="{{ url('archivo/control_estados') }}" {{ url()->current() ==  url('archivo/control_estados') ? "selected": "" }}>Control de estados</option>
        </optgroup>

        <optgroup label="SUP-POS Educ.Continua">
            <option value="{{ url('progeducontinua') }}" {{ url()->current() ==  url('progeducontinua') ? "selected": "" }}>Programas edu. continua</option>
            <option value="{{ url('inscritosEduContinua') }}" {{ url()->current() ==  url('inscritosEduContinua') ? "selected": "" }}>Inscritos edu. continua</option>
            <option value="{{ url('reporte/relacion_educontinua') }}" {{ url()->current() ==  url('reporte/relacion_educontinua') ? "selected": "" }}>Rel. edu. continua</option>
            <option value="{{ url('reporte/rel_pagos_educontinua') }}" {{ url()->current() ==  url('reporte/rel_pagos_educontinua') ? "selected": "" }}>Rel. pagos edu. continua</option>
            <option value="{{ url('reporte/rel_aluprog_educontinua') }}" {{ url()->current() ==  url('reporte/rel_aluprog_educontinua') ? "selected": "" }}>Rel. alumnos edu. continua</option>
            <option value="{{ url('tiposProgEduContinua') }}" {{ url()->current() ==  url('tiposProgEduContinua') ? "selected": "" }}>Tipos programa edu. continua</option>
                <option value="{{ url('reporte/fichas_incorrectas_edu_continua') }}" {{ url()->current() ==  url('reporte/fichas_incorrectas_edu_continua') ? "selected": "" }}>Posibles fichas incorrectas</option>
        </optgroup>

        <optgroup label="SUP-POS Procesos">
            <option value="{{ url('proceso/pago') }}" {{ url()->current() ==  url('proceso/pago') ? "selected": "" }}>Aplica pagos</option>
            <option value="{{ url('contabilidad/alumnos') }}" {{ url()->current() ==  url('contabilidad/alumnos') ? "selected": "" }}>Excel Alumnos</option>
            <option value="{{ url('contabilidad/fichas') }}" {{ url()->current() ==  url('contabilidad/fichas') ? "selected": "" }}>Excel Fichas</option>
            <option value="{{ url('contabilidad/referencias') }}" {{ url()->current() ==  url('contabilidad/referencias') ? "selected": "" }}>Excel Referencias</option>
            <option value="{{ url('proceso/excel_pagos') }}" {{ url()->current() ==  url('proceso/excel_pagos') ? "selected": "" }}>Excel Pagos</option>
        </optgroup>

        <optgroup label="SUP-POS S.Externos">

            <option value="{{ url('hurra_alumnos') }}" {{ url()->current() ==  url('hurra_alumnos') ? "selected": "" }}>Hurra Alumnos</option>
            <option value="{{ url('hurra_maestros') }}" {{ url()->current() ==  url('hurra_maestros') ? "selected": "" }}>Hurra Maestros</option>
            <option value="{{ url('hurra_ordinarios') }}" {{ url()->current() ==  url('hurra_ordinarios') ? "selected": "" }}>Hurra Ordinarios</option>
            <option value="{{ url('hurra_horarios') }}" {{ url()->current() ==  url('hurra_horarios') ? "selected": "" }}>Hurra Horarios</option>
            <option value="{{ url('hurra_calificaciones') }}" {{ url()->current() ==  url('hurra_calificaciones') ? "selected": "" }}>Hurra Calificaciones</option>
            <option value="{{ url('hurra_extraordinarios') }}" {{ url()->current() ==  url('hurra_extraordinarios') ? "selected": "" }}>Hurra Extraordinarios</option>

        </optgroup>

        <optgroup label="Gimnasio">
            <option value="{{ url('usuariogim') }}" {{ url()->current() ==  url('usuariogim') ? "selected": "" }}>Lista de usuarios</option>
            <option value="{{ url('reporte/gimnasio_pagos_aplicados') }}" {{ url()->current() ==  url('reporte/gimnasio_pagos_aplicados') ? "selected": "" }}>Pagos Aplicados</option>
        </optgroup>

        <optgroup label="SCEM Administración">
            <option value="{{ url('permiso') }}" {{ url()->current() ==  url('permiso') ? "selected": "" }}>Crear permisos</option>
            <option value="{{ url('modulo') }}" {{ url()->current() ==  url('modulo') ? "selected": "" }}>Crear modulos</option>
            <option value="{{ url('permiso/modulo') }}" {{ url()->current() ==  url('permiso/modulo') ? "selected": "" }}>Crear permiso-modulo</option>
            <option value="{{ url('usuario') }}" {{ url()->current() ==  url('usuario') ? "selected": "" }}>Usuarios</option>
            <option value="{{ url('portal-configuracion') }}" {{ url()->current() ==  url('portal-configuracion') ? "selected": "" }}>Configuración</option>
        </optgroup>

        <optgroup label="Tutorías">
            <option value="{{ url('tutorias_encuestas') }}" {{ url()->current() ==  url('tutorias_encuestas') ? "selected": "" }}>Encuestas</option>
            <option value="{{ url('tutorias_categoria_pregunta') }}" {{ url()->current() ==  url('tutorias_categoria_pregunta') ? "selected": "" }}>Categoría pregunta</option>
            <option value="{{ url('tutorias_factores_riesgo') }}" {{ url()->current() ==  url('tutorias_factores_riesgo') ? "selected": "" }}>Analisis de resultados</option>
            <option value="{{ url('tutorias_formulario') }}" {{ url()->current() ==  url('tutorias_formulario') ? "selected": "" }}>Formulario</option>
            <option value="{{ url('reporte/tutorias/alumnos_faltantes_encuesta') }}" {{ url()->current() ==  url('reporte/tutorias/alumnos_faltantes_encuesta') ? "selected": "" }}>Alumnos Faltantes Encuesta</option>
            <option value="{{ url('reporte/tutorias/reporte_por_tipo_respuesta') }}" {{ url()->current() ==  url('reporte/tutorias/reporte_por_tipo_respuesta') ? "selected": "" }}>Reporte por Tipo Respuesta</option>
        </optgroup>


    @endif


@endif

@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    @if (Auth::user()->departamento_cobranza == 1)
        <optgroup label="Universidad">

                <optgroup label="Control Escolar">

                    @if (Auth::user()->username == "FLOPEZH" || Auth::user()->username == "MCUEVAS"
                        || Auth::user()->username == "NLOPEZ" || Auth::user()->username == "CSAURI")
                            <option value="{{ url('acuerdo') }}" {{ url()->current() ==  url('acuerdo') ? "selected": "" }}>Acuerdos</option>
                    @endif
                    <option value="{{ url('empleado') }}" {{ url()->current() ==  url('empleado') ? "selected": "" }}>Empleados</option>
                    <option value="{{ url('alumno') }}" {{ url()->current() ==  url('alumno') ? "selected": "" }}>Alumnos</option>
                    @if(App\Models\User::permiso("alumno") == "A" || App\Models\User::permiso("alumno") == "B" || Auth::user()->username == "DESARROLLO"|| Auth::user()->username == "FLOPEZH" || Auth::user()->username == "CSAURI")
                        <option value="{{ url('alumno_restringido') }}" {{ url()->current() ==  url('alumno_restringido') ? "selected": "" }}>Alumnos restringidos</option>
                    @endif    

                    <option value="{{ url('curso') }}" {{ url()->current() ==  url('curso') ? "selected": "" }}>Preinscritos</option>
                    <option value="{{ url('beca') }}" {{ url()->current() ==  url('beca') ? "selected": "" }}>Becas</option>
                    
                    <option value="{{ url('cgt') }}" {{ url()->current() ==  url('cgt') ? "selected": "" }}>CGT</option>

                    @if (in_array(auth()->user()->permiso('egresados'), ['A', 'B']))
                        <option value="{{ url('egresados') }}" {{ url()->current() ==  url('egresados') ? "selected": "" }}>Egresados</option>
                    @endif

                    @if(Auth::user()->username == 'DESARROLLO' ||
                          in_array(App\Models\User::permiso('cambiar_contrasena'), ['A','B','C']))
                        <option value="{{ url('cambiar_contrasena') }}" {{ url()->current() ==  url('cambiar_contrasena') ? "selected": "" }}>Cambiar contraseña de docentes</option>
                    @endif
                                   
                </optgroup>


                @if (Auth::user()->username == "DESARROLLO" || Auth::user()->username == "LLARA"
                    || Auth::user()->username == "FLOPEZH" || Auth::user()->username == "MCUEVAS"
                    || Auth::user()->username == "SRIVERO"
                    || Auth::user()->username == "JPEREIRA" || Auth::user()->username == "MARIANAT"
                    || Auth::user()->username == "MAGUI" || Auth::user()->username == "MARTHA"
                    || Auth::user()->username == "GPEREZ" || Auth::user()->username == "MELIBETH"
                    || Auth::user()->username == "EAIL" || Auth::user()->username == "ARIVERO"
                    || Auth::user()->username == "NLOPEZ" || Auth::user()->username == "MERCEDES"
                    || Auth::user()->username == "MCARRILLO"|| Auth::user()->username == "HRIVAS"
                    || Auth::user()->username == "DENISECG"
                    || Auth::user()->username == "MARTHA"|| Auth::user()->username == "CESAURI" || Auth::user()->username == "CSAURI")
                            <optgroup label="Pagos">
                                <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

                                @if (Auth::user()->username != "MAGUI" 
                                  && Auth::user()->username != "GPEREZ" && Auth::user()->username != "MELIBETH"
                                  && Auth::user()->username != "HRIVAS"&& Auth::user()->username != "DENISECG")
                                    <option value="{{ url('pagos/aplicar_pagos') }}" {{ url()->current() ==  url('pagos/aplicar_pagos') ? "selected": "" }}>Consultar pagos</option>
                                @endif
                                <option value="{{ url('pagos/consulta_fichas') }}" {{ url()->current() ==  url('pagos/consulta_fichas') ? "selected": "" }}>Consulta de fichas</option>
                                <option value="{{ url('/concepto_pago') }}" {{ url()->current() ==  url('/concepto_pago') ? "selected": "" }}>Conceptos de pago</option>
                                <option value="{{ url('becas_historial/cursos') }}" {{ url()->current() ==  url('becas_historial/cursos') ? "selected": "" }}>Historial de becas</option>
                            </optgroup>
                @endif
                
                

                <optgroup label="Reportes">
                            <optgroup label="> Alumnos">
                                <option value="{{ url('reporte/primer_ingreso') }}" {{ url()->current() ==  url('reporte/primer_ingreso') ? "selected": "" }}>Primer ingreso</option>
                                <option value="{{ url('reporte/inscrito_preinscrito') }}" {{ url()->current() ==  url('reporte/inscrito_preinscrito') ? "selected": "" }}>Inscritos y preinscritos</option>
                                <option value="{{ url('reporte/asistencia_grupo') }}" {{ url()->current() ==  url('reporte/asistencia_grupo') ? "selected": "" }}>Lista asistencia por grupo</option>
                                <option value="{{ url('reporte/grupo_materia') }}" {{ url()->current() ==  url('reporte/grupo_materia') ? "selected": "" }}>Lista asistencia por materia</option>
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
                                @if(in_array(Auth::user()->permiso('recordatorioPagos'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option>
                                @endif
                                <option value="{{ url('reporte/relacion_deudores') }}" {{ url()->current() ==  url('reporte/relacion_deudores') ? "selected": "" }}>Rel. alumnos deudores</option>
                                @if(in_array(auth()->user()->permiso('relacion_inscritos_primero'), ['A', 'B']))
                                    <option value="{{ url('reporte/relacion_inscritos_primero') }}" {{ url()->current() ==  url('reporte/relacion_inscritos_primero') ? "selected": "" }}>Rel. Inscritos de primero</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('lista_por_tipo_ingreso'), ['A', 'B']))
                                    <option value="{{ url('reporte/lista_por_tipo_ingreso') }}" {{ url()->current() ==  url('reporte/lista_por_tipo_ingreso') ? "selected": "" }}>Lista por tipo ingreso</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('alumnos_ultimo_grado'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/alumnos_ultimo_grado') }}" {{ url()->current() ==  url('reporte/alumnos_ultimo_grado') ? "selected": "" }}>Alumnos de último grado</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('alumnos_encuestados'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/alumnos_encuestados') }}" {{ url()->current() ==  url('reporte/alumnos_encuestados') ? "selected": "" }}>Alumnos encuestados</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('resumen_alumnos_encuestados'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/resumen_alumnos_encuestados') }}" {{ url()->current() ==  url('reporte/resumen_alumnos_encuestados') ? "selected": "" }}>Resumen Alumnos encuestados</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('deudores_economico_academico'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/deudores_economico_academico') }}" {{ url()->current() ==  url('reporte/deudores_economico_academico') ? "selected": "" }}>Deudores Económico Académico</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('alumnos_regulares_sin_curso'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/alumnos_regulares_sin_curso') }}" {{ url()->current() ==  url('reporte/alumnos_regulares_sin_curso') ? "selected": "" }}>Alumnos Regulares Sin Curso</option>
                                @endif
                            </optgroup>

                            <optgroup label="> Calificaciones">
                                <option value="{{ url('reporte/actas_pendientes') }}" {{ url()->current() ==  url('reporte/actas_pendientes') ? "selected": "" }}>Actas pendientes</option>
                                <option value="{{ url('reporte/boleta_calificaciones') }}" {{ url()->current() ==  url('reporte/boleta_calificaciones') ? "selected": "" }}>Boleta de Calificaciones</option>
                                <option value="{{ url('reporte/historial_alumno') }}" {{ url()->current() ==  url('reporte/historial_alumno') ? "selected": "" }}>Historial acádemico de alumnos</option>
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
                                <option value="{{ url('reporte/grupo_semestre') }}" {{ url()->current() ==  url('reporte/grupo_semestre') ? "selected": "" }}>Grupos por semestre</option>
                                <option value="{{ url('reporte/materias_plan') }}" {{ url()->current() ==  url('reporte/materias_plan') ? "selected": "" }}>Materias por plan</option>
                                <option value="{{ url('reporte/optativas_periodo') }}" {{ url()->current() ==  url('reporte/optativas_periodo') ? "selected": "" }}>Optativas por período</option>
                                <option value="{{ url('reporte/ocupacion_de_aula') }}" {{ url()->current() ==  url('reporte/ocupacion_de_aula') ? "selected": "" }}>Ocupación de Aulas</option>
                                <option value="{{ url('reporte/rel_cambios_carrera') }}" {{ url()->current() ==  url('reporte/rel_cambios_carrera') ? "selected": "" }}>Rel. Cambios de Carrera</option>
                                <option value="{{ url('reporte/relacion_cgt') }}" {{ url()->current() ==  url('reporte/relacion_cgt') ? "selected": "" }}>Rel. de CGTs</option>
                                <option value="{{ url('reporte/relacion_grupos') }}" {{ url()->current() ==  url('reporte/relacion_grupos') ? "selected": "" }}>Rel. de grupos</option>
                                <option value="{{ url('reporte/planes_estudio') }}" {{ url()->current() ==  url('reporte/planes_estudio') ? "selected": "" }}>Rel. Planes estudio</option>
                                <option value="{{ url('reporte/rel_grupos_equivalentes') }}" {{ url()->current() ==  url('reporte/rel_grupos_equivalentes') ? "selected": "" }}>Rel. grupos equivalentes</option>
                                <option value="{{ url('reporte/horario_por_grupo') }}" {{ url()->current() ==  url('reporte/horario_por_grupo') ? "selected": "" }}>Horario de clases</option>
                            </optgroup>

                            <optgroup label="> Docentes">
                                <option value="{{ url('reporte/carga_grupos_maestro') }}" {{ url()->current() ==  url('reporte/carga_grupos_maestro') ? "selected": "" }}>Carga grupos por maestro</option>
                                <option value="{{ url('reporte/cumple_empleados') }}" {{ url()->current() ==  url('reporte/cumple_empleados') ? "selected": "" }}>Cumpleaños de empleados</option>
                                <option value="{{ url('reporte/horario_personal_maestros') }}" {{ url()->current() ==  url('reporte/horario_personal_maestros') ? "selected": "" }}>Horarios personal maestro</option>
                                <option value="{{ url('reporte/plantilla_profesores') }}" {{ url()->current() ==  url('reporte/plantilla_profesores') ? "selected": "" }}>Plantilla de profesores</option>
                                <option value="{{ url('reporte/relacion_maestros_escuela') }}" {{ url()->current() ==  url('reporte/relacion_maestros_escuela') ? "selected": "" }}>Rel. maestros escuela</option>
                                <option value="{{ url('reporte/constancia_docente') }}" {{ url()->current() ==  url('reporte/constancia_docente') ? "selected": "" }}>Constancia Docente</option>
                                @if(in_array(auth()->user()->permiso('conteo_empleados'), ['A', 'B']))
                                    <option value="{{ url('reporte/conteo_empleados') }}" {{ url()->current() ==  url('reporte/conteo_empleados') ? "selected": "" }}>Conteo Empleados</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('resumen_docentes_encuestados'), ['A', 'B', 'C']))
                                    <option value="{{ url('reporte/resumen_docentes_encuestados') }}" {{ url()->current() ==  url('reporte/resumen_docentes_encuestados') ? "selected": "" }}>Resumen Docentes Encuestados</option>
                                @endif
                                @if(auth()->user()->isAdmin('docentes_encuestados'))
                                    <option value="{{ url('reporte/docentes_encuestados') }}" {{ url()->current() ==  url('reporte/docentes_encuestados') ? "selected": "" }}>Docentes Encuestados</option>
                                @endif
                            </optgroup>

                            <optgroup label="> Dirección">
                                <option value="{{ url('reporte/relacion_nuevo_ingreso_exani') }}" {{ url()->current() ==  url('reporte/relacion_nuevo_ingreso_exani') ? "selected": "" }}>Rel. nuevo ingreso</option>
                                <option value="{{ url('reporte/relacion_candidatos') }}" {{ url()->current() ==  url('reporte/relacion_candidatos') ? "selected": "" }}>Rel. candidatos</option>
                            </optgroup>

                            <optgroup label="> Egresados">
                                <option value="{{ url('reporte/rel_pos_egresados') }}" {{ url()->current() ==  url('reporte/rel_pos_egresados') ? "selected": "" }}>Posibles egresados</option>
                                <option value="{{ url('reporte/rel_egresados') }}" {{ url()->current() ==  url('reporte/rel_pos_egresados') ? "selected": "" }}>Relación egresados</option>
                                <option value="{{ url('reporte/res_egresados') }}" {{ url()->current() ==  url('reporte/rel_pos_egresados') ? "selected": "" }}>Resumen egresados</option>
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

                            @if(in_array(auth()->user()->permiso('menu_reportes_extraordinarios'), ['A', 'B', 'C']))
                                <optgroup label="> Extraordinarios">
                                    <option value="{{ url('reporte/relacion_inscritos_extraordinario') }}" {{ url()->current() ==  url('reporte/relacion_inscritos_extraordinario') ? "selected": "" }}>Relación de Inscritos</option>
                                    <option value="{{ url('reporte/relacion_solicitudes_extraordinario') }}" {{ url()->current() ==  url('reporte/relacion_solicitudes_extraordinario') ? "selected": "" }}>Relación de Solicitudes</option>
                                    @if(in_array(auth()->user()->permiso('resumen_inscritos_extraordinario'), ['A', 'B', 'C']))
                                        <option value="{{ url('reporte/resumen_inscritos_extraordinario') }}" {{ url()->current() ==  url('reporte/resumen_inscritos_extraordinario') ? "selected": "" }}>Resumen de Inscritos</option>
                                    @endif
                                </optgroup>
                            @endif

                            @if (Auth::user()->username == "DESARROLLO"
                                || Auth::user()->username == "GASTON"
                              || Auth::user()->username == "LLARA"
                              || Auth::user()->username == "RAVILA"
                              || Auth::user()->username == "FLOPEZH"
                              || Auth::user()->username == "EAIL"
                              || Auth::user()->username == "MCUEVAS"
                              || Auth::user()->username == "SRIVERO"
                              || Auth::user()->username != "NLOPEZ"
                              || Auth::user()->username == "MERCEDES"
                              || Auth::user()->username == "MCARRILLO"
                              || Auth::user()->username == "MARIANAT"
                              || Auth::user()->username == "HRIVAS"
                              || Auth::user()->username == "DENISECG"
                              || Auth::user()->username == "MARTHA"
                              || Auth::user()->username == "CESAURI"
                              || Auth::user()->username == "CSAURI")
                                <optgroup label="> Pagos">
                                    @if (Auth::user()->username == "DESARROLLO"
                                      || Auth::user()->username == "GASTON"
                                      || Auth::user()->username == "LLARA"
                                      || Auth::user()->username == "FLOPEZH"
                                      || Auth::user()->username == "EAIL"
                                      || Auth::user()->username == "MCUEVAS"
                                      || Auth::user()->username == "SRIVERO"
                                      || Auth::user()->username == "MARIANAT"
                                      || Auth::user()->username == "MCARRILLO"
                                      || Auth::user()->username == "NLOPEZ"
                                      || Auth::user()->username == "MERCEDES"
                                      || Auth::user()->username == "HRIVAS"
                                      || Auth::user()->username == "DENISECG"
                                      || Auth::user()->username == "MARTHA"
                                      || Auth::user()->username == "CESAURI"
                                      || Auth::user()->username == "CSAURI")
                                        <option value="{{ url('reporte/relacion_deudas') }}">Deudas de un Alumno</option>
                                        <option value="{{ url('reporte/becas_campus_carrera_escuela') }}">Montos de Beca</option>
                                        <option value="{{ url('reporte/movimiento_becas') }}"
                                            {{ url()->current() ==  url('reporte/movimiento_becas') ? "selected": "" }}>Movimiento de Becas
                                        </option>
                                        @if (Auth::user()->username != "MCUEVAS"
                                        || Auth::user()->username != "SRIVERO"
                                        || Auth::user()->username != "MARIANAT"
                                        || Auth::user()->username != "HRIVAS"
                                        || Auth::user()->username == "DENISECG"
                                        || Auth::user()->username == "CESAURI"
                                        || Auth::user()->username == "EAIL")
                                            <option value="{{ url('reporte/colegiaturas') }}">Pagos de Colegiaturas</option>
                                        @endif
                                        <option value="{{ url('reporte/relacion_deudores') }}">Relación de Deudores</option>
                                    @endif

                                    <option value="{{ url('reporte/relacion_deudores_pagos_anuales') }}"
                                    {{ url()->current() ==  url('reporte/relacion_deudores_pagos_anuales') ? "selected": "" }}>Pagos Recibidos
                                    </option>
                                    
                                    {{-- 
                                    @if (Auth::user()->username == "DESARROLLO" || Auth::user()->username == "RAVILA" || Auth::user()->username == "FLOPEZH"|| Auth::user()->username == "CESAURI"
                                    || Auth::user()->username == "EAIL" || Auth::user()->username == "MCUEVAS"
                                    || Auth::user()->username == "NLOPEZ")
                                        <option value="{{ url('reporte/tarjetas_pago_alumnos') }}" {{ url()->current() ==  url('reporte/tarjetas_pago_alumnos') ? "selected": "" }}>Tarjetas de pago</option>
                                    @endif
                                    --}}

                                    @if (in_array(Auth::user()->permiso('registro_cuotas'), ['A', 'B', 'P']))
                                        <option value="{{ url('pagos/registro_cuotas') }}" {{ url()->current() ==  url('registro_cuotas') ? "selected": "" }}>Registro de cuotas</option>
                                    @endif

                                    <option value="{{ url('reporte/estado_cuenta') }}" {{ url()->current() ==  url('reporte/estado_cuenta') ? "selected": "" }}>Estado de Cuenta</option>
                                    <option value="{{ url('reporte/relacion_condicionados') }}" {{ url()->current() ==  url('reporte/relacion_condicionados') ? "selected": "" }}>Relación de condicionados</option>
                                    <option value="{{ url('reporte/rel_pagos_capturados_usuario') }}" {{ url()->current() ==  url('reporte/rel_pagos_capturados_usuario') ? "selected": "" }}>Pagos capturados por usuario</option>
                                    <option value="{{ url('reporte/pagos_duplicados') }}" {{ url()->current() ==  url('reporte/pagos_duplicados') ? "selected": "" }}>Pagos duplicados</option>
                                    <option value="{{ url('reporte/historial_pagos_alumno') }}" {{ url()->current() ==  url('reporte/historial_pagos_alumno') ? "selected": "" }}>Historial de Pagos de Alumno</option>
                                    <option value="{{ url('reporte/pagos_errores_al_aplicar') }}" {{ url()->current() ==  url('reporte/pagos_errores_al_aplicar') ? "selected": "" }}>Errores al aplicar</option>
                                    <option value="{{ url('reporte/deudores_curso_anterior') }}" {{ url()->current() ==  url('reporte/deudores_curso_anterior') ? "selected": "" }}>Deudores Curso Anterior</option>
                                    <option value="{{ url('reporte/resumen_pronto_pago') }}" {{ url()->current() ==  url('reporte/resumen_pronto_pago') ? "selected": "" }}>Resumen pronto pago</option>
                                    <option value="{{ url('reporte/cambio_plan_pago') }}" {{ url()->current() ==  url('reporte/cambio_plan_pago') ? "selected": "" }}>Cambios de plan de pago</option>
                                    {{-- <option value="{{ url('reporte/recordatorio_pagos') }}" {{ url()->current() ==  url('reporte/recordatorio_pagos') ? "selected": "" }}>Recordatorios de pagos</option> --}}
                                    <option value="{{ url('reporte/resumen_deudores') }}" {{ url()->current() ==  url('reporte/resumen_deudores') ? "selected": "" }}>Resumen Deudores</option>
                                    @if(auth()->user()->isAdmin('fichas_de_cobranza'))
                                        <option value="{{ url('reporte/fichas_de_cobranza') }}" {{ url()->current() ==  url('reporte/fichas_de_cobranza') ? "selected": "" }}>Fichas de cobranza</option>
                                    @endif
                                    @if(auth()->user()->isAdmin('fichas_generales'))
                                        <option value="{{ url('reporte/fichas_generales') }}" {{ url()->current() ==  url('reporte/fichas_generales') ? "selected": "" }}>Fichas generales</option>
                                    @endif
                                    @if(auth()->user()->isAdmin('cuotas_registradas'))
                                        <option value="{{ url('reporte/cuotas_registradas') }}" {{ url()->current() ==  url('reporte/cuotas_registradas') ? "selected": "" }}>Cuotas Registradas</option>
                                    @endif
                                    @if(auth()->user()->isAdmin('becas_con_observaciones'))
                                        <option value="{{ url('reporte/becas_con_observaciones') }}" {{ url()->current() ==  url('reporte/becas_con_observaciones') ? "selected": "" }}>Becas con Observaciones</option>
                                    @endif
                                    @if(auth()->user()->isAdmin('relacion_pagos_completos'))
                                        <option value="{{ url('reporte/relacion_pagos_año_completos') }}" {{ url()->current() ==  url('reporte/relacion_pagos_año_completos') ? "selected": "" }}>Relación de Pagos Completos</option>
                                    @endif
                                </optgroup>
                            @endif

                            <optgroup label="SEGEY">
                                <option value="{{ url('reporte/segey/registro_alumnos') }}" {{ url()->current() ==  url('reporte/segey/registro_alumnos') ? "selected": "" }}>Registro de alumnos</option>
                            </optgroup>
                            <optgroup label="Estadisticas">
                                <option value="{{ url('reporte/resumen_inscritos') }}" {{ url()->current() ==  url('reporte/resumen_inscritos') ? "selected": "" }}>Resumen Inscritos</option>
                                <option value="{{ url('reporte/listas_para_estadisticas') }}" {{ url()->current() ==  url('reporte/listas_para_estadisticas') ? "selected": "" }}>Listas de alumnos</option>
                                <option value="{{ url('reporte/estadistica_estatal_licenciatura') }}" {{ url()->current() ==  url('reporte/estadistica_estatal_licenciatura') ? "selected": "" }}>Estatales de Licenciatura</option>
                                <option value="{{ url('reporte/estadistica_estatal_educacion_continua') }}" {{ url()->current() ==  url('reporte/estadistica_estatal_educacion_continua') ? "selected": "" }}>Estatales de Educacion Continua</option>
                                <option value="{{ url('reporte/estadistica_estatal_maestros') }}" {{ url()->current() ==  url('reporte/estadistica_estatal_maestros') ? "selected": "" }}>Estatales de Maestros</option>
                                @if(in_array(auth()->user()->permiso('resumen_inscritos_preinscritos'), ['A', 'B']))
                                    <option value="{{ url('reporte/resumen_inscritos_preinscritos') }}" {{ url()->current() ==  url('reporte/resumen_inscritos_preinscritos') ? "selected": "" }}>Resumen de inscritos y preinscritos</option>
                                @endif
                                @if(in_array(auth()->user()->permiso('resumen_antiguedad'), ['A', 'B']))
                                    <option value="{{ url('reporte/resumen_antiguedad') }}" {{ url()->current() ==  url('reporte/resumen_antiguedad') ? "selected": "" }}>Resumen de Antigüedad</option>
                                @endif
                            </optgroup>

                </optgroup>


                <optgroup label="Educacion Continua">
                    <option value="{{ url('progeducontinua') }}" {{ url()->current() ==  url('progeducontinua') ? "selected": "" }}>Programas edu. continua</option>
                    <option value="{{ url('inscritosEduContinua') }}" {{ url()->current() ==  url('inscritosEduContinua') ? "selected": "" }}>Inscritos edu. continua</option>
                    <option value="{{ url('reporte/relacion_educontinua') }}" {{ url()->current() ==  url('reporte/relacion_educontinua') ? "selected": "" }}>Rel. edu. continua</option>
                    <option value="{{ url('reporte/rel_pagos_educontinua') }}" {{ url()->current() ==  url('reporte/rel_pagos_educontinua') ? "selected": "" }}>Rel. pagos edu. continua</option>
                    <option value="{{ url('reporte/rel_aluprog_educontinua') }}" {{ url()->current() ==  url('reporte/rel_aluprog_educontinua') ? "selected": "" }}>Rel. alumnos edu. continua</option>
                    <option value="{{ url('tiposProgEduContinua') }}" {{ url()->current() ==  url('tiposProgEduContinua') ? "selected": "" }}>Tipos programa edu. continua</option>
                    @if(in_array(auth()->user()->permiso('fichas_incorrectas_edu_continua'), ['A', 'B']))
                        <option value="{{ url('reporte/fichas_incorrectas_edu_continua') }}" {{ url()->current() ==  url('reporte/fichas_incorrectas_edu_continua') ? "selected": "" }}>Posibles fichas incorrectas</option>
                    @endif
                </optgroup>

        </optgroup>
    @endif

@endif

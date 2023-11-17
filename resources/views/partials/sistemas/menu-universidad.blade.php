@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )

    @if(  Auth::user()->departamento_sistemas == 1 )

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Universidad</span>
            </a>
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Catálogos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                <li>
                                    <a href="{{ url('ubicacion') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ubicación</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('departamento') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Departamentos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('escuela') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Escuelas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('programa') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Programas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('plan') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Planes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('periodo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Periodos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('acuerdo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Acuerdos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('materia') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Materias</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('optativa') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Optativas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('aula') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Aulas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('profesion') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Profesiones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('abreviatura') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Abreviaturas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('beca') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Becas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('concepto_baja') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Concepto de bajas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('concepto_titulacion') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Concepto de titulación</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('paises') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Paises</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('estados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Estados</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('municipios') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Municipios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('preparatorias') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Preparatorias</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('registro') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Registro</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('puestos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Puestos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS C.Escolar</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('empleado') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Empleados</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('alumno') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos</span>
                                    </a>
                                </li>
                                    <li>
                                        <a href="{{ url('alumno_restringido') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Alumnos restringidos</span>
                                        </a>
                                    </li>
                                <li>
                                    <a href="{{ url('cgt') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CGT</span>
                                    </a>
                                </li>
                                @if(in_array(auth()->user()->permiso('cambiar_cgt'), ['A', 'B', 'C']))
                                    <li>
                                        <a href="{{ url('cambiar_cgt') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>cambiar CGT</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('grupo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Grupos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('paquete') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Paquetes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('curso') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Preinscritos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('inscrito') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscritos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('preinscrito_extraordinario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Preinscrito ExtraOrdinario</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('extraordinario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Extraordinarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('matricula_anterior') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Matricula Anterior</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('escolaridad') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Escolaridad</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('clave_profesor') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Clave SEGEY</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('horarios_administrativos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Horarios administrativos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('historico') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Historico</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('preinscripcion_auto') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Preinscripción Automática</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('serviciosocial') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Servicio Social</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('cierre_actas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cierre Ordinarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('cierre_extras') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cierre Extraordinarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('egresados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Egresados</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('registro_egresados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Registro Automático Egresados</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('tutores') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Tutores</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('candidatos_primer_ingreso') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Candidatos 1er ingreso</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('calendarioexamen') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Calendario Exámenes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('cambiar_contrasena') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Cambiar contraseña de docentes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('extracurricular') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Extracurricular</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('resumen_academico') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Resúmenes académicos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('revalidaciones') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Revalidaciones</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Pagos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('pagos/ficha_general') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ficha general</span>
                                    </a>
                                </li>
                                    <li>
                                        <a href="{{ url('pagos/aplicar_pagos') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Consultar pagos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('pagos/registro_cuotas') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Registro de cuotas</span>
                                        </a>
                                    </li>

                                <li>
                                    <a href="{{ url('pagos/consulta_fichas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Consulta de fichas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/concepto_pago') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Conceptos de pagos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('becas_historial/cursos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Historial de becas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/listas_pagos_lagunas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Lista pagos lagunas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Reportes</span>
                        </a>
                        <div class="collapsible-body">
                            <ul class="collapsible" data-collapsible="accordion">
                                {{-- Alumnos --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Alumnos</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/primer_ingreso') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Primer ingreso</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/inscrito_preinscrito') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Inscritos y preinscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/asistencia_grupo') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Asistencia por grupo</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/grupo_materia') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Asistencia por materia</span>
                                                </a>
                                            </li>
                                            @if(auth()->user()->isAdmin('conteo_servicio_social'))
                                                <li>
                                                    <a href="{{ url('reporte/conteo_servicio_social') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Conteo de servicio social</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->user()->isAdmin('lista_servicio_social'))
                                                <li>
                                                    <a href="{{ url('reporte/lista_servicio_social') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Lista de servicio social</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ url('reporte/materias_adeudadas_alumnos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Materias adeudadas</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_alumnos_matriculas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. alumnos matriculas</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/alumnos_becados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. alumnos becados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_datos_generales') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. datos generales</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/relacion_deudores') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. alumnos deudores</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/alumnos_foraneos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. foráneos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_pos_bajas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. posibles bajas</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/servicio_social') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. servicio social</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/resumen_grupos_alumno') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen grupos alumno</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ url('reporte/alumnos_asistentes') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. alumnos asistentes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/inscritos_sexo') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen inscritos sexo</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/posibles_hermanos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. posibles hermanos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_cumple_alumnos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. cumpleaños alumnos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/res_antiguedad_preinscritos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. Antigüedad Preinscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/res_alumnos_no_inscritos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. Alumnos no Inscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/relacion_bajas_periodo') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Bajas por periodo</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_alumnos_reprobados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Alumnos Reprobados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_correos_alumnos_padres') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Correos de Alumnos/Padres</span>
                                                </a>
                                            </li>
                                               <li>
                                                    <a href="{{ url('reporte/recordatorio_pagos') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Recordatorio de pagos</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/relacion_inscritos_primero') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Rel. Inscritos de primero</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/lista_por_tipo_ingreso') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Lista por tipo ingreso</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/alumnos_ultimo_grado') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Alumnos de último grado</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/alumnos_encuestados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Alumnos Encuestados</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/resumen_alumnos_encuestados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Resumen Alumnos Encuestados</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/deudores_economico_academico') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Deudores Económico Académico</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/alumnos_regulares_sin_curso') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Alumnos Regulares Sin Curso</span>
                                                    </a>
                                                </li>
                                                @if(auth()->user()->isAdmin('alumnos_reprobados_parciales'))
                                                    <li>
                                                        <a href="{{ url('reporte/alumnos_reprobados_parciales') }}">
                                                            <i class="material-icons">keyboard_arrow_right</i>
                                                            <span>Reprobados por parciales</span>
                                                        </a>
                                                    </li>
                                                @endif

                                        </ul>
                                    </div>
                                </li>
                                {{-- Acreditaciones --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Acreditaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/historicos_por_escuela') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Historicos por escuela</span>
                                                </a>
                                            </li>
                                    </div>
                                </li>
                                {{-- Calificaciones --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Calificaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/actas_pendientes') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Actas pendientes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/boleta_calificaciones') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Boleta de Calificaciones</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/historial_alumno') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Historial académico de alumnos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/kardex_academico') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>kardex Académico</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/mejores_promedios') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Mejores Promedios</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/mejor_promedio_total') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Mejor Promedio Total</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/indice_reprobacion') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Indice de reprobación</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/porcentaje_aprobacion') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Porcentaje de aprobación</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/acta_extraordinario') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Acta de examen extraordinario</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/acta_examen_ordinario') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Acta de examen ordinario</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/resumen_cal_grupos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen calificación por grupos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/resumen_promedios') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen promedios</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/acreditaciones') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Desempeño Académico</span>
                                                </a>
                                            </li>                                            
                                        </ul>
                                    </div>
                                </li>
                                {{-- Constancias --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Constancias</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/buena_conducta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Buena conducta</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/calificacion_final') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones finales</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/calificacion_carrera') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones completa</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/calificacion_parcial') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calificaciones parciales</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/constancia_inscripcion') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Inscripción</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/solicitud_beca') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Solicitud de beca</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/certificado_completo') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Certificado completo</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                {{-- Cursos --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Cursos</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/aulas_escuela') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Aulas por escuela</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/aulas_ocupadas_escuela') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Aulas ocupadas</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/carga_alumnos_aula') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Carga de alumnos por aula</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/grupo_semestre') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Grupos por semestre</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/materias_plan') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Materias por plan</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/optativas_periodo') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Optativas por período</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_cambios_carrera') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. Cambios de Carrera</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/relacion_cgt') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. de CGTs</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/relacion_grupos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. de grupos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/planes_estudio') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. planes estudio</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_grupos_equivalentes') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. grupos equivalentes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/horario_por_grupo') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Horario de clases</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/resumen_escuelas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Res. Escuelas</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- Docentes --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Docentes</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/carga_grupos_maestro') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Carga grupos por maestro</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/cumple_empleados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Cumpleaños de empleados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/horario_personal_maestros') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Horarios personal maestro</span>
                                                </a>
                                            </li>
                                            @if(in_array(auth()->user()->permiso('horarios_personales_excel'), ['A', 'B', 'C']))
                                                <li>
                                                    <a href="{{ url('reporte/horarios_personales_excel') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Horarios personales excel</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ url('reporte/plantilla_profesores') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Plantilla de profesores</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/horarios_administrativos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Horarios Administrativos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/relacion_maestros_escuela') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. maestros escuela</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/constancia_docente') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Constancia Docente</span>
                                                </a>
                                            </li>
                                                <li>
                                                    <a href="{{ url('reporte/conteo_empleados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Conteo de Empleados</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/resumen_docentes_encuestados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Resumen Docentes Encuestados</span>
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="{{ url('reporte/docentes_encuestados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Docentes Encuestados</span>
                                                    </a>
                                                </li>
                                                
                                            @if(in_array(auth()->user()->permiso('directorio_empleados'), ['A', 'B', 'C']))
                                                <li>
                                                    <a href="{{ url('reporte/directorio_empleados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Directorio de Empleados</span>
                                                    </a>
                                                </li>
                                            @endif


                                        </ul>
                                    </div>
                                </li>
                                {{-- Direccion --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Dirección</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/relacion_nuevo_ingreso_exani') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. nuevo ingreso</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/relacion_candidatos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Rel. candidatos</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- Egresados --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Egresados</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/rel_pos_egresados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Posibles egresados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/rel_egresados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Relación egresados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/res_egresados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen egresados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/resumen_egresados_excel') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen egresados (Excel)</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/resumen_titulados') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen titulados</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/titulados_pasantes') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Titulados y pasantes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/total_egresados_tit') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Total egresados y titulados</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- Evaluaciones --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Evaluaciones</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/calendario_examenes_ordinarios') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Calendario exa. ordinarios</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/listas_evaluacion_parcial') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Listas evaluación parcial</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/listas_evaluacion_ordinaria') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Listas evaluación ordinaria</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/programacion_examenes') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Programación de exa. extraordinarios</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/numero_examenes') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Número de exámenes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/validar_fechas_ordinarios') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Validación de fechas de Ordinarios</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- Extraordinarios --}}
                                    <li class="bold">
                                        <a class="collapsible-header waves-effect waves-cyan">
                                            <span class="nav-text">Extraordinarios</span>
                                        </a>
                                        <div class="collapsible-body">
                                            <ul>
                                                <li>
                                                    <a href="{{ url('reporte/relacion_inscritos_extraordinario') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Relación de Inscritos</span>
                                                    </a>
                                                </li>
                                                    <li>
                                                        <a href="{{ url('reporte/resumen_inscritos_extraordinario') }}">
                                                            <i class="material-icons">keyboard_arrow_right</i>
                                                            <span>Resumen de Inscritos</span>
                                                        </a>
                                                    </li>

                                            </ul>
                                        </div>
                                    </li>


                                {{-- Pagos --}}

                                    <li class="bold">
                                        <a class="collapsible-header waves-effect waves-cyan">
                                            <span class="nav-text">Pagos</span>
                                        </a>
                                        <div class="collapsible-body">
                                            <ul>

                                                <li>
                                                    <a href="{{ url('reporte/relacion_deudas') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Deudas de un Alumno</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/alumnos_sin_renovacion_beca') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Alumnos sin renovacion de beca</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/becas_campus_carrera_escuela') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Montos de Becas</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/movimiento_becas') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Movimiento de Becas</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/colegiaturas') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Pagos de Colegiaturas</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/relacion_deudores') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Relación de Deudores</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/relacion_deudores_pagos_anuales') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Pagos Recibidos</span>
                                                    </a>
                                                </li>

                                                {{--
                                                <li>
                                                    <a href="{{ url('reporte/tarjetas_pago_alumnos') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Tarjetas de pago</span>
                                                    </a>
                                                </li>
                                                --}}
                                                
                                                <li>
                                                    <a href="{{ url('reporte/estado_cuenta') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Estado de Cuenta</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/relacion_condicionados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Rel. Condicionados</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/rel_pagos_capturados_usuario') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Pagos capturados por usuario</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/pagos_duplicados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Pagos duplicados</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/historial_pagos_alumno') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Historial de Pagos de Alumno</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/pagos_errores_al_aplicar') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Errores al aplicar</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/deudores_curso_anterior') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Deudores Curso Anterior</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/resumen_pronto_pago') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Resumen Pronto Pago</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/cambio_plan_pago') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Cambios de plan de pago</span>
                                                    </a>
                                                </li>
                                                {{-- <li>
                                                    <a href="{{ url('reporte/recordatorio_pagos') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Recordatorio de pagos</span>
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a href="{{ url('reporte/resumen_deudores') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Resumen Deudores</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/fichas_de_cobranza') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Fichas de Cobranza</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/fichas_generales') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Fichas generales</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/cuotas_registradas') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Cuotas Registradas</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('reporte/becas_con_observaciones') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>Becas con Observaciones</span>
                                                    </a>
                                                </li>
                                                @if(auth()->user()->isAdmin('relacion_pagos_completos'))
                                                    <li>
                                                        <a href="{{ url('reporte/relacion_pagos_año_completos') }}">
                                                            <i class="material-icons">keyboard_arrow_right</i>
                                                            <span>Relación de Pagos Completos</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>


                                {{-- Segey --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">SEGEY</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/segey/registro_alumnos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Registro de alumnos</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Estadísticas</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            @if(auth()->user()->isAdmin('cibies_administrativos'))
                                                <li>
                                                    <a href="{{ url('reporte/cibies_administrativos') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>CIBIES Administrativos</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->user()->isAdmin('cibies_docentes'))
                                                <li>
                                                    <a href="{{ url('reporte/cibies_docentes') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>CIBIES Docentes</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->user()->isAdmin('historico_matricula'))
                                                <li>
                                                    <a href="{{ url('reporte/historico_matricula') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>CIBIES Histórico Matrícula</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->user()->isAdmin('cibies_nuevo_ingreso'))
                                                <li>
                                                    <a href="{{ url('reporte/cibies_nuevo_ingreso') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>CIBIES Nuevo Ingreso</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->user()->isAdmin('cibies_reincorporados'))
                                                <li>
                                                    <a href="{{ url('reporte/cibies_reincorporados') }}">
                                                        <i class="material-icons">keyboard_arrow_right</i>
                                                        <span>CIBIES Reincorporados</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ url('reporte/resumen_inscritos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen inscritos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/listas_para_estadisticas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Listas de alumnos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/estadistica_estatal_educacion_continua') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Estatales de Educacion Continua</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/estadistica_estatal_licenciatura') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Estatales de Licenciatura</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/estadistica_estatal_maestros') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Estatales de Maestros</span>
                                                </a>
                                            </li>
                                             <li>
                                                <a href="{{ url('reporte/resumen_inscritos_preinscritos') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen de inscritos y preinscritos</span>
                                                </a>
                                            </li>
                                             <li>
                                                <a href="{{ url('reporte/resumen_antiguedad') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Resumen de Antigüedad</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                {{-- Tutorías --}}
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <span class="nav-text">Tutorías</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{ url('reporte/tutorias/reporte_por_tipo_respuesta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Reporte por tipo respuesta</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/tutorias/alumnos_faltantes_encuesta') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Alumnos Faltantes Encuesta</span>
                                                </a>
                                            </li>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Prefecteo</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('prefecteo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Lista de prefecteos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('aulas_en_clase') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Aulas en clase</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('aulas/ocupadas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Aulas Ocupadas por Escuelas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Archivos SEP</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('archivo/grupo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Grupos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('archivo/inscripcion') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscripciones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('archivo/ordinario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Ordinarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('archivo/extraordinario') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Extraordinarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('archivo/control_estados') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Control de estados</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Educ.Continua</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('progeducontinua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Programas edu. continua</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('inscritosEduContinua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Inscritos edu. continua</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/relacion_educontinua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Rel. edu. continua</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/rel_pagos_educontinua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Rel. pagos edu. continua</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/rel_aluprog_educontinua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Rel. alumnos edu. continua</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('tiposProgEduContinua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Tipos Programa edu. continua</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('reporte/fichas_incorrectas_edu_continua') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Posibles fichas incorrectas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS Procesos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('proceso/pago') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Aplica pagos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('contabilidad/alumnos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Excel Alumnos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('contabilidad/fichas') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Excel Fichas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('contabilidad/referencias') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Excel Referencias</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('proceso/excel_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Excel Pagos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">SUP-POS S.Externos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('hurra_alumnos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Hurra alumnos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('hurra_maestros') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Hurra maestros</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('hurra_ordinarios') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Hurra ordinarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('hurra_horarios') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Hurra horarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('hurra_calificaciones') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Hurra calificaciones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('hurra_extraordinarios') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Hurra extraordinarios</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="bold">
                        <a target="_blank" href="{{ url('manuales') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Manuales</span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>


        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Gimnasio</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li>
                        <a href="{{ url('usuariogim') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Lista de usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('reporte/gimnasio_pagos_aplicados') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Pagos Aplicados</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">SCEM Administración</span>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li>
                        <a href="{{ url('permiso') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Crear permisos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('modulo') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Crear modulos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('permiso/modulo') }}" target="_blank">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Crear permiso-modulo</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('usuario') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('portal-configuracion') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Configuración</span>
                        </a>
                    </li>                  
                </ul>
            </div>
        </li>

        <li class="bold">
            <a class="collapsible-header waves-effect waves-cyan">
                <i class="material-icons">dashboard</i>
                <span class="nav-text">Tutorias</span>
            </a>


            {{-- Cátalogos  --}}
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">


                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">Catálogos</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                <li>
                                    <a href="{{route('tutorias_bitacora_electronica.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Bitácora electrónica</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('tutorias_categoria_pregunta.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Categoría pregunta</span>
                                    </a>
                                </li>

                                {{-- Formulario  --}}
                                <li>
                                    <a href="{{route('tutorias_formulario.index')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Formulario</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                </ul>
            </div>

            {{-- Reportes  --}}
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">


                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">Reportes</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{url('reporte/tutorias/alumnos_faltantes_encuesta')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Alumnos Faltantes Encuesta</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('reporte/tutorias/reporte_por_tipo_respuesta')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Reporte por tipo de respuesta</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                </ul>
            </div>

            {{-- Configuración      --}}
            <div class="collapsible-body">
                <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <span class="nav-text">Configuración</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>

                                {{-- Usuarios  --}}
                                <li>
                                    <a href="{{ route('tutorias_usuario.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Usuarios</span>
                                    </a>
                                </li>

                                {{-- Rol de usuarios  --}}
                                <li>
                                    <a href="{{ route('tutorias_rol.index') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Rol de usuarios</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Factores de riesgo  --}}
                    <li>
                        <a href="{{route('tutorias_factores_riesgo.index')}}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Analisis de resultados</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('tutorias_encuestas.index') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Encuestas</span>
                        </a>
                    </li>

                </ul>
            </div>



        </li>
        
    @endif


@endif

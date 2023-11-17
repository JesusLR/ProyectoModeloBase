@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp


        {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->departamento_sistemas == 1 )

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Maternal | Preescolar</span>
        </a>
        <div class="collapsible-body">
            <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">MAT-PRE Catálogos</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>

                            {{--  ubicacion   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_ubicacion.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Ubicaciones</span>
                                </a>
                            </li>

                            {{--  departamento   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_departamento.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Departamentos</span>
                                </a>
                            </li>

                            {{--  escuela   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_escuela.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Escuelas</span>
                                </a>
                            </li>

                            {{--  programas   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_programa.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Programas</span>
                                </a>
                            </li>

                            {{--  planes   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_plan.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Planes</span>
                                </a>
                            </li>

                            {{--  periodos   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_periodo.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Períodos</span>
                                </a>
                            </li>

                            {{--  materias   --}}
                            <li>
                                <a href="{{ route('preescolar.preescolar_materia.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Materias</span>
                                </a>
                            </li>

                            {{--  cgts   --}}
                            <li>
                                <a href="{{route('preescolar.preescolar_cgt.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>CGT</span>
                                </a>
                            </li>

                            {{--  Tipo Rubricas   --}}
                            <li>
                                <a href="{{route('preescolar.preescolar_tipo_rubricas.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Tipo de rúbricas</span>
                                </a>
                            </li>

                            {{--  Rubricas   --}}
                            <li>
                                <a href="{{route('preescolar.preescolar_rubricas.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Rúbricas</span>
                                </a>
                            </li>

                            {{--  Fechas de Calificaciones  --}}
                            <li>
                                <a href="{{route('preescolar.preescolar_fecha_de_calificaciones.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Fechas de calificaciones</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">MAT-PRE C.Escolar</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('preescolar_empleado.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Empleados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('preescolar_alumnos.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('curso_preescolar.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Preinscritos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('clinica') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Historia clinica</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('preescolar.preescolar_asignar_cgt.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Asignar CGT</span>
                                </a>
                            </li>

                            {{--  cambiar CGT   --}}
                            <li>
                                <a href="{{route('preescolar.preescolar_cambiar_cgt.edit')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Cambiar CGT</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('preescolar.preescolar_cgt_materias.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>CGT Materias</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('preescolar_grupo.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Grupos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('preescolar.preescolar_grupo_rubricas.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Grupo-Rúbricas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('PreescolarInscritos.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Inscritos materia</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('preescolar.preescolar_modificar_plantilla_calificaciones.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Cambiar plantilla (calificaciones)</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('calendario') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Calendario</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('preescolar.preescolar_cambiar_contrasenia.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Acceso de Docente</span>
                                </a>
                            </li>            
                            
                            
                        </ul>
                    </div>
                </li>

                {{--  Act. ExtraEscolares  --}}
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">MAT-PRE -Act. ExtraEscolares</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('universidad.universidad_actividades.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Actividades (Grupos)</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('universidad.universidad_nuevo_externo.create') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Nuevo Externo</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('universidad.universidad_actividades_inscritos.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Inscritos Actividades</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('empleado') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Instructores (Empleados)</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">MAT-PRE Pagos</span>
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
                                    <a href="{{ url('preescolar/pagos/aplicar_pagos') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Pagos Manuales</span>
                                    </a>
                                </li>
                        </ul>
                    </div>
                </li>

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <span class="nav-text">MAT-PRE Reportes</span>
                    </a>
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
                            {{--  Cátalogos   --}}
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Catálogos</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('reporte.preescolar_rubricas.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Rúbricas</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            {{-- Alumnos --}}
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-cyan">
                                    <span class="nav-text">Alumnos</span>
                                </a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('preescolar_inscrito_preinscrito.create') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Inscritos y preinscritos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('reporte/preescolar_resumen_inscritos') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Resumen inscritos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('preescolar.preescolar_alumnos_excel') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Datos Completos de Alumnos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('preescolar.datos_completos_alumno.reporteAlumnos') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Datos Completos de Alumno</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('preescolar.preescolar_inscritos_sexo.reporte') }}">
                                                <i class="material-icons">keyboard_arrow_right</i>
                                                <span>Resumen inscritos sexo</span>
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
                                                <a href="{{ url('reporte/preescolar_relacion_deudas') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Deudas de un Alumno</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('reporte/preescolar_relacion_deudores') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Relación de Deudores</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </li>

    @endif

@endif

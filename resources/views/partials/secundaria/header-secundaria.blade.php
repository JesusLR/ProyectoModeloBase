@if (Auth::user()->secundaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Secundaria</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                            {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                            @if (Auth::user()->departamento_cobranza == 0)

                                <optgroup label="Secundaria">
                                    <option value="{{ route('secundaria.secundaria_historia_clinica.index') }}"
                                        {{ url()->current() ==  route('secundaria.secundaria_historia_clinica.index') ? "selected": "" }}>Entrevista inicial</option>
                                </optgroup>

                            @endif


                            <option value="{{ route('secundaria.secundaria_curso.index') }}"
                            {{ url()->current() ==  route('secundaria.secundaria_curso.index') ? "selected": "" }}>Preinscritos</option>


                            {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                            @if (Auth::user()->departamento_cobranza == 0)
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

                                    <option value="{{ route('secundaria.secundaria_materias_inscrito.index') }}"
                                            {{ url()->current() ==  route('secundaria.secundaria_materias_inscrito.index') ? "selected": "" }}>Cargar Materias a Inscrito</option>

                                    {{--  CGT Materias  --}}
                                    <option value="{{ route('secundaria.secundaria_cgt_materias.index') }}"
                                    {{ url()->current() ==  route('secundaria.secundaria_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

                                    {{-- Asignar Docente CGT  --}}
                                    <option value="{{ route('secundaria.secundaria_asignar_docente.index') }}"
                                        {{ url()->current() ==  route('secundaria.secundaria_asignar_docente.index') ? "selected": "" }}>Grupos - docente</option>

                                        {{--  Migrar Inscritos ACD   --}}
            <option value="{{ route('secundaria.secundaria_migrar_inscritos_acd.index') }}" {{ url()->current() ==  route('secundaria.secundaria_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos ACD</option>

                                    {{--  Cambio de programa   
                                    <option value="{{ route('secundaria.secundaria_cambio_programa.index') }}"
                                        {{ url()->current() ==  route('secundaria.secundaria_cambio_programa.index') ? "selected": "" }}>Cambio de Programa</option>
                                    --}}


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

                                    {{--  //Cambiar grupo ACD  --}}
                                    <option value="{{ route('secundaria.secundaria_cambio_grupo_acd.index') }}"
                                    {{ url()->current() ==  route('secundaria.secundaria_cambio_grupo_acd.index') ? "selected": "" }}>Cambiar grupo ACD</option>

                                    <option value="{{ route('secundaria.secundaria_modificar_boleta.modificar') }}"
                                    {{ url()->current() ==  route('secundaria.secundaria_modificar_boleta.modificar') ? "selected": "" }}>Modificar Calificaciones</option>

                                    

                            @endif

                    </ul>
                </div>
            </li>
    @endif

@endif

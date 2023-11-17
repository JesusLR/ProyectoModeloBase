@if (Auth::user()->bachiller == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1 || $userClave == "JIMENARIVERO")

            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Bachiller</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                            <optgroup label="Bachiller">
                                <option value="{{ route('bachiller.bachiller_historia_clinica.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_historia_clinica.index') ? "selected": "" }}>Entrevista inicial</option>
                            </optgroup>

                            <option value="{{ route('bachiller.bachiller_curso.index') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_curso.index') ? "selected": "" }}>Preinscritos</option>

                            <option value="{{ route('bachiller.bachiller_preinscripcion_automatica.create') }}"
                            {{ url()->current() ==  route('bachiller.bachiller_preinscripcion_automatica.create') ? "selected": "" }}>Preinscripcion automatica</option>

                                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                                    <option value="{{ route('bachiller.bachiller_grupo_uady.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_grupo_uady.index') ? "selected": "" }}>Grupos UADY</option>
                                @endif

                                @if (Auth::user()->campus_cch == 1)
                                    <option value="{{ route('bachiller.bachiller_grupo_seq.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_grupo_seq.index') ? "selected": "" }}>Grupos SEQ</option>
                                @endif

                                {{--  Grupos inscritos   --}}
                                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                                    <option value="{{ route('bachiller.bachiller_asignar_grupo.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_asignar_grupo.index') ? "selected": "" }}>Inscritos Grupos</option>

                                    <option value="{{ route('bachiller.bachiller_migrar_inscritos_acd.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos</option>

                                    {{--  <option value="{{ route('bachiller.bachiller_copiar_inscritos.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_copiar_inscritos.index') ? "selected": "" }}>Cambiar Inscritos</option>  --}}

                                    <option value="{{ route('bachiller.bachiller_copiar_horario.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_copiar_horario.index') ? "selected": "" }}>Copiar Horario</option>
                                @endif

                                @if (Auth::user()->campus_cch == 1)
                                    <option value="{{ route('bachiller.bachiller_asignar_grupo_seq.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_asignar_grupo_seq.index') ? "selected": "" }}>Inscritos Grupos</option>
                                @endif

                                @if (Auth::user()->campus_cch == 1)
                                    <option value="{{ route('bachiller.bachiller_cgt_materias.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

                                    <option value="{{ route('bachiller.bachiller_cambiar_cgt_cch.edit') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_cambiar_cgt_cch.edit') ? "selected": "" }}>Cambiar CGT</option>
                                @endif

                                

                                @if (Auth::user()->campus_cch == 1)
                                    {{--  <option value="{{ route('bachiller.bachiller_horarios_administrativos_chetumal') }}"
                                        {{ url()->current() ==  route('bachiller.bachiller_horarios_administrativos_chetumal') ? "selected": "" }}>&nbsp;&nbsp;Horarios administrativos</option>                                      --}}
                                @endif

                                

                                <option value="{{ route('bachiller.bachiller_materias_inscrito.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_materias_inscrito.index') ? "selected": "" }}>Materias Nuevo Inscrito</option>

                                

                                <option value="{{ route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index') ? "selected": "" }}>Fechas Calif. Docentes</option>

                                <option value="{{ route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index') }}"
                                    {{ url()->current() ==  route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index') ? "selected": "" }}>Fechas Calif. Alumnos</option>

                                {{--  Observaciones calificaciones   --}}
                                <option value="{{ route('bachiller.bachiller_obs_boleta.index') }}"
                                {{ url()->current() ==  route('bachiller.bachiller_obs_boleta.index') ? "selected": "" }}>Nota mensual Calif.</option>


                                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)

                                <option value="{{ route('bachiller.bachiller_cierre_actas.filtro') }}"
                                {{ url()->current() ==  route('bachiller.bachiller_cierre_actas.filtro') ? "selected": "" }}>Cierre Ordinarios</option>


                                <option value="{{ url('bachiller_recuperativos') }}"
                                {{ url()->current() ==  url('bachiller_recuperativos') ? "selected": "" }}>Recuperativos</option>

                                <option value="{{ route('bachiller.bachiller_cierre_extras.filtro') }}"
                                {{ url()->current() ==  route('bachiller.bachiller_cierre_extras.filtro') ? "selected": "" }}>Cierre Recuperativos</option>

                                <option value="{{ url('solicitudes/bachiller_recuperativos') }}"
                                {{ url()->current() ==  url('solicitudes/bachiller_recuperativos') ? "selected": "" }}>Solicitud recuperativo</option>

                                <option value="{{ route('bachiller.bachiller_evidencias.index') }}"
                                {{ url()->current() ==  route('bachiller.bachiller_evidencias.index') ? "selected": "" }}>Evidencias</option>
                                @endif

                                

                                @if (Auth::user()->campus_cme == 1 || Auth::user()->campus_cva == 1)
                                    <option value="{{ route('bachiller.bachiller_paquete.index') }}"
                                        {{ url()->current() ==  route('bachiller.bachiller_paquete.index') ? "selected": "" }}>Paquetes</option>
                                    

                                    <option value="{{ route('bachiller.bachiller_historial_academico.index') }}"
                                        {{ url()->current() ==  route('bachiller.bachiller_historial_academico.index') ? "selected": "" }}>Historial Académico</option>

                                    <option value="{{ route('bachiller.bachiller_revalidaciones.index') }}"
                                        {{ url()->current() ==  route('bachiller.bachiller_revalidaciones.index') ? "selected": "" }}>Revalidaciones</option>

                                @endif

                    </ul>
                </div>
            </li>
    @endif

@endif

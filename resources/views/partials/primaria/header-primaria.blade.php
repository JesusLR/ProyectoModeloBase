@if (Auth::user()->primaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->departamento_control_escolar == 1)

        {{-- psicologas de primaria no lo ven --}}
        @if ((Auth::user()->username != "MONICAEGLE") && (Auth::user()->username != "IVONNEVERA") 
        && (Auth::user()->username != "ANGELINAMICHELL"))

                <optgroup label="Primaria">

                        <option value="{{ route('primaria_curso.index') }}"
                        {{ url()->current() ==  route('primaria_curso.index') ? "selected": "" }}>Preinscritos</option>

                        {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                        @if (Auth::user()->departamento_cobranza == 0)

                            {{--  Grupos   --}}
                            <option value="{{ route('primaria_grupo.index') }}"
                            {{ url()->current() ==  route('primaria_grupo.index') ? "selected": "" }}>Grupos</option>

                            {{--  Grupos inscritos   --}}
                            <option value="{{ route('primaria_asignar_grupo.index') }}"
                            {{ url()->current() ==  route('primaria_asignar_grupo.index') ? "selected": "" }}>Inscritos Grupos</option>

                            <option value="{{ route('primaria_asignar_cgt.edit') }}"
                            {{ url()->current() ==  route('primaria_asignar_cgt.edit') ? "selected": "" }}>Asignar CGT</option>

                            {{--  CGT Materias  --}}
                            <option value="{{ route('primaria.primaria_cgt_materias.index') }}"
                            {{ url()->current() ==  route('primaria.primaria_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>

                            <option value="{{ route('primaria.primaria_materias_asignaturas.index') }}" {{ url()->current() ==  route('primaria.primaria_materias_asignaturas.index') ? "selected": "" }}>Materias Asignaturas</option>


                            {{-- Asignar Docente Presencial  --}}
                            <option value="{{ route('primaria.primaria.primaria_asignar_docente_presencial.index') }}"
                            {{ url()->current() ==  route('primaria.primaria.primaria_asignar_docente_presencial.index') ? "selected": "" }}>Docentes Presenciales Grupos</option>

                            {{-- Asignar Docente Virtual  --}}
                            {{--  <option value="{{ route('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual') }}"
                            {{ url()->current() ==  route('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual') ? "selected": "" }}>&nbsp;Docentes Virtuales Grupos</option>  --}}

                            {{--  Cambio de programa   --}}
                            {{--  <option value="{{ route('primaria.primaria.primaria_cambio_programa.index') }}"
                            {{ url()->current() ==  route('primaria.primaria.primaria_cambio_programa.index') ? "selected": "" }}>&nbsp;&nbsp;Cambio de Programa</option>  --}}


                            {{-- Inscrito Modalidad --}}
                            {{--  <option value="{{ route('primaria.primaria.primaria_inscrito_modalidad.index') }}"
                            {{ url()->current() ==  route('primaria.primaria.primaria_inscrito_modalidad.index') ? "selected": "" }}>&nbsp;Inscrito Modalidad</option>  --}}

                            <option value="{{ route('primaria.primaria_docente_inscrito_modalidad.index') }}"
                            {{ url()->current() ==  route('primaria.primaria_docente_inscrito_modalidad.index') ? "selected": "" }}>Docente Inscrito Modalidad</option>

                            <option value="{{ route('primaria.primaria_cambiar_cgt.edit') }}"
                                {{ url()->current() ==  route('primaria.primaria_cambiar_cgt.edit') ? "selected": "" }}>Cambiar CGT</option>

                            <option value="{{ route('primaria.primaria_materias_inscrito.index') }}"
                            {{ url()->current() ==  route('primaria.primaria_materias_inscrito.index') ? "selected": "" }}>Cargar Materias a Inscrito</option>

                            {{--  Observaciones calificaciones   --}}
                            <option value="{{ route('primaria.primaria.primaria_obs_boleta.index') }}"
                            {{ url()->current() ==  route('primaria.primaria.primaria_obs_boleta.index') ? "selected": "" }}>Obs. boleta</option>

                            <option value="{{ route('primaria.primaria_horarios_libres.index') }}"
                                {{ url()->current() ==  route('primaria.primaria_horarios_libres.index') ? "selected": "" }}>Docentes horarios libres</option>

                            <option value="{{ route('primaria.primaria_fecha_publicacion_calificacion_docente.index') }}"
                                {{ url()->current() ==  route('primaria.primaria_fecha_publicacion_calificacion_docente.index') ? "selected": "" }}>Fechas captura docente</option>

                            {{--  
                            <option value="{{ route('primaria.primaria_fecha_publicacion_calificacion_alumno.index') }}"
                                {{ url()->current() ==  route('primaria.primaria_fecha_publicacion_calificacion_alumno.index') ? "selected": "" }}>Fecha publicación calif.</option>
                            --}}
                            
                            <option value="{{ route('primaria.primaria_calificacion_general.viewCalificacionGeneral') }}"
                                {{ url()->current() ==  route('primaria.primaria_calificacion_general.viewCalificacionGeneral') ? "selected": "" }}>Modificar Boleta</option>

                            <option value="{{ route('primaria.primaria_generar_promedios.index') }}"
                                {{ url()->current() ==  route('primaria.primaria_generar_promedios.index') ? "selected": "" }}>Generar promedio</option>

                        @endif
                </optgroup>


                @if (Auth::user()->departamento_cobranza == 0)

                        <optgroup label="Docentes">

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

                @endif


        @endif

    @endif


@endif

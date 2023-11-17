@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}

        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp

        @if (Auth::user()->maternal == 1)
            @php
              $userDepClave = "MAT";
            @endphp
        @endif
        @if (Auth::user()->preescolar == 1)
            @php
              $userDepClave = "PRE";
            @endphp
        @endif

        @if (Auth::user()->departamento_control_escolar == 1)
            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">PRE. C.Escolar</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ route('curso_preescolar.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Preinscritos</span>
                            </a>
                        </li>
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

                        {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                        @if(  Auth::user()->departamento_cobranza == 0 )
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
                                <a href="{{ route('PreescolarInscritos.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Inscritos materia</span>
                                </a>
                            </li>
                            {{--  <li>
                                <a href="{{ route('preescolar.preescolar_modificar_plantilla_calificaciones.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Cambiar plantilla (calificaciones)</span>
                                </a>
                            </li>  --}}
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

                            <li>
                                <a href="{{ route('preescolar.preescolar_alumnos_excel') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos Excel</span>
                                </a>
                            </li>

                        @endif

                        {{--  <li>
                            <a href="{{ url('preescolar_calendario_calificaciones') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Calendario calificaciones</span>
                            </a>
                        </li>  --}}
                    </ul>
                </div>
            </li>
        @endif


        {{-- SI LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
        @if(  Auth::user()->departamento_cobranza == 1 )
            <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Pagos</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ url('pagos/ficha_general') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Ficha general</span>
                            </a>
                        </li>
                        @if ($userClave == "FLOPEZH")
                            <li>
                                <a href="{{ url('preescolar/pagos/aplicar_pagos') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Pagos Manuales</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif


@endif

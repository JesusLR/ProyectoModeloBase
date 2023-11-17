@if (Auth::user()->primaria == 1)

        {{--  vista del menu catalogos   --}}
        @include('partials.primaria.menu-catalogos')

        @if (Auth::user()->departamento_control_escolar == 1)

            {{-- psicologas de primaria SI lo ven --}}
            @if ((Auth::user()->username == "MONICAEGLE") || (Auth::user()->username == "IVONNEVERA")
            || (Auth::user()->username == "ANGELINAMICHELL"))


                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">PRIM. C.Escolar</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('primaria_alumno.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            @endif



                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">PRIM. Expediente</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{route('primaria.primaria_entrevista_inicial.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>	Entrevista Inicial </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{route('primaria.primaria_perfil.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>	Perfiles  </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('primaria.primaria_seguimiento_escolar.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>	Seguimiento escolar  </span>
                                </a>
                            </li>

                            {{-- <li>
                                <a href="#">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>	Ficha técnica  </span>
                                </a>
                            </li> --}}

                            <li>
                                <a href="{{ route('primaria_calendario.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Agenda</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('primaria.primaria_alumnos_excel') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos Excel</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>



        @endif

@endif

@if (Auth::user()->primaria == 1)


    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    @if (Auth::user()->departamento_sistemas == 1)

            {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
            @if (Auth::user()->departamento_cobranza == 0)

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">PRIM. Catálogos</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>

                            {{--  programas   --}}
                            <li>
                                <a href="{{ route('primaria.primaria_programa.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Programas</span>
                                </a>
                            </li>

                            {{--  planes   --}}
                            <li>
                                <a href="{{ route('primaria.primaria_plan.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Planes</span>
                                </a>
                            </li>

                            {{--  periodos   --}}
                            <li>
                                <a href="{{ route('primaria.primaria_periodo.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Períodos</span>
                                </a>
                            </li>

                            {{--  materias   --}}
                            <li>
                                <a href="{{ route('primaria.primaria_materia.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Materias</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('primaria.primaria_materias_asignaturas.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Materias Asignaturas</span>
                                </a>
                            </li>
                            

                            {{--  cgts   --}}
                            <li>
                                <a href="{{route('primaria.primaria_cgt.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>CGT</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('primaria.primaria_categoria_contenido.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Perf. Cat. Contenidos  </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('primaria.primaria_calificador.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Perf. Calificadores  </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('primaria.primaria_contenido_fundamental.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Perf. Contenidos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('primaria.primaria_migrar_inscritos_acd.index')}}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Migrar Inscritos ACD</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            @endif

    @endif

    {{--  para mostrar en primaria   --}}
    @if (Auth::user()->primaria == 1)
    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">PRIM. Catálogos</span>
        </a>
        <div class="collapsible-body">
            <ul>
            
                {{--  materias   --}}
                <li>
                    <a href="{{ route('primaria.primaria_materia.index') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Materias</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('primaria.primaria_campos_formativos.index') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Campos Formativos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('primaria.primaria_campos_formativos_observaciones.index') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Campos Formativos Observaciones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('primaria.primaria_campos_formativos_materias.index') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Campos Formativos Materias</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    @endif

@endif

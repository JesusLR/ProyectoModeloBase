@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )
    {{--
    @if (Auth::user()->empleado->escuela->departamento->depClave == "SUP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "DIP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "AEX" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "IDI")
    --}}

        @if (Auth::user()->username == "DESARROLLO" 
        || Auth::user()->username == "LLARA"
        || Auth::user()->username == "CESAURI"
        || Auth::user()->username == "EAIL"
        || Auth::user()->username == "HERALI"
        || Auth::user()->username == "LURZAIZ"
        || Auth::user()->username == "MDZIBM"
        || Auth::user()->username == "GLORIA"
        || Auth::user()->username == "CAGUILAR"
        || Auth::user()->username == "RCARRILLO"
        || Auth::user()->username == "MAGALY"
        || Auth::user()->username == "KARLATORRES"
        || Auth::user()->username == "LIGIACONTRERAS"
        || Auth::user()->username == "NTORRES"
        || Auth::user()->username == "MARTHA"
        || Auth::user()->username == "GABRIELAGARCIA"
        || Auth::user()->username == "AMIRA")

                            {{-- TUTORIAS --}}
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <i class="material-icons">dashboard</i>
                                <span class="nav-text">Tutorias</span>
                            </a>
                            @if (Auth::user()->username == "DESARROLLO" 
                            || Auth::user()->username == "LLARA"
                            || Auth::user()->username == "CESAURI"
                            || Auth::user()->username == "EAIL")


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
                            @endif
                            @if (Auth::user()->username == "DESARROLLO" 
                            || Auth::user()->username == "LLARA"
                            || Auth::user()->username == "CESAURI"
                            || Auth::user()->username == "EAIL"
                            || Auth::user()->username == "HERALI"
                            || Auth::user()->username == "LURZAIZ"
                            || Auth::user()->username == "MDZIBM"
                            || Auth::user()->username == "GLORIA"
                            || Auth::user()->username == "CAGUILAR"
                            || Auth::user()->username == "RCARRILLO"
                            || Auth::user()->username == "MAGALY"
                            || Auth::user()->username == "KARLATORRES"
                            || Auth::user()->username == "LIGIACONTRERAS"
                            || Auth::user()->username == "NTORRES"
                            || Auth::user()->username == "MARTHA"
                            || Auth::user()->username == "GABRIELAGARCIA"
                            || Auth::user()->username == "AMIRA")
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
                                                    @if (Auth::user()->username == "DESARROLLO" 
                                                    || Auth::user()->username == "LLARA"
                                                    || Auth::user()->username == "CESAURI"
                                                    || Auth::user()->username == "EAIL")
                                                    <li>
                                                        <a href="{{url('reporte/tutorias/reporte_cuantitativo_respuesta')}}">
                                                            <i class="material-icons">keyboard_arrow_right</i>
                                                            <span>Reporte cuantitativo de respuesta</span>
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            @endif
                            @if (Auth::user()->username == "DESARROLLO" 
                            || Auth::user()->username == "LLARA"
                            || Auth::user()->username == "CESAURI"
                            || Auth::user()->username == "EAIL")
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
                            @endif



                        </li>

        @endif


@endif

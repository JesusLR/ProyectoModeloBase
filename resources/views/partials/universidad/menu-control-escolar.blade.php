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

    <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan">
            <i class="material-icons">dashboard</i>
            <span class="nav-text">Univ. Control Escolar</span>
        </a>
        <div class="collapsible-body">
            <ul>

                <li>
                    <a href="{{ url('notificaciones_coordinacion') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>Notificaciones Coordinación</span>
                    </a>
                </li>
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

                        @if(App\Models\User::permiso("alumno") == "A" || App\Models\User::permiso("alumno") == "B" || Auth::user()->username == "DESARROLLO")
                            <li>
                                <a href="{{ url('alumno_restringido') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Alumnos restringidos</span>
                                </a>
                            </li>
                        @endif
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
                                    <span>Cambiar CGT</span>
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
                        {{-- <li>
                            <a href="{{ url('pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Referencia de pago</span>
                            </a>
                        </li> --}}
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


                    @if (in_array(Auth::user()->permiso('preinscripcion_automatica'), ['A', 'B']))
                        <li>
                            <a href="{{ url('preinscripcion_auto') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Preinscripción Automática</span>
                            </a>
                        </li>
                    @endif


                        <li>
                            <a href="{{ url('serviciosocial') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Servicio Social</span>
                            </a>
                        </li>


                    @if (Auth::user()->username == "DESARROLLO"
                        || Auth::user()->username == "LLARA"
                        || Auth::user()->username == "EAIL"
                        || Auth::user()->username == "CELIA"
                        || Auth::user()->username == "SILVIA"
                        || Auth::user()->username == "JPEREIRA"
                        || Auth::user()->username == "MARIANAT"
                        || Auth::user()->username == "MCARRILLO")
                        <li>
                            <a href="{{ url('cierre_actas') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Cierre Ordinarios</span>
                            </a>
                        </li>
                    @endif


                    @if (Auth::user()->username == "DESARROLLO"
                        || Auth::user()->username == "LLARA"
                        || Auth::user()->username == "EAIL"
                        || Auth::user()->username == "CELIA"
                        || Auth::user()->username == "SILVIA"
                        || Auth::user()->username == "JPEREIRA"
                        || Auth::user()->username == "MARIANAT"
                        || Auth::user()->username == "MCARRILLO")
                        <li>
                            <a href="{{ url('cierre_extras') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Cierre Extraordinarios</span>
                            </a>
                        </li>
                    @endif

                    @if (in_array(auth()->user()->permiso('egresados'), ['A', 'B']))
                        <li>
                            <a href="{{ url('egresados') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Egresados</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->permiso('egresados') == 'A')
                        <li>
                            <a href="{{ url('registro_egresados') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Registro Automático Egresados</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ url('egresados/create') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Registro Manual Egresados</span>
                            </a>
                        </li> --}}
                    @endif
                        <li>
                            <a href="{{ url('recibo_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Recibo de pago</span>
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


                    @if(in_array(App\Models\User::permiso('cambiar_contrasena'), ['A','B','C']) ||
                        Auth::user()->username == 'DESARROLLO')
                        <li>
                            <a href="{{ url('cambiar_contrasena') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Cambiar contraseña de docentes</span>
                            </a>
                        </li>
                    @endif


                        <li>
                            <a href="{{ url('extracurricular') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Extracurricular</span>
                            </a>
                        </li>
                    @if(auth()->user()->permiso('resumen_academico') == "A")
                        <li>
                            <a href="{{ url('resumen_academico') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Resúmenes académicos</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin('revalidaciones'))
                        <li>
                            <a href="{{ url('revalidaciones') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Revalidaciones</span>
                            </a>
                        </li>
                    @endif
            </ul>
        </div>
    </li>

@endif

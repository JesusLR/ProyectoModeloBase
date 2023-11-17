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
                <span class="nav-text">Univ. Catálogos</span>
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
                @if (App\Models\User::permiso("registro") == "A" || App\Models\User::permiso("registro") == "B"
                     || Auth::user()->username == "DESARROLLO")
                    <li>
                        <a href="{{ url('registro') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Registro</span>
                        </a>
                    </li>
                @endif
                @if(in_array(auth()->user()->permiso('puestos'), ['A', 'B', 'C']))
                    <li>
                        <a href="{{ url('puestos') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>Puestos</span>
                        </a>
                    </li>
                @endif

                </ul>
            </div>
        </li>

@endif

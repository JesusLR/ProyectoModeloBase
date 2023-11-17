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

        <optgroup label="Univ.Catálogos">
            <option value="{{ url('ubicacion') }}" {{ url()->current() ==  url('ubicacion') ? "selected": "" }}>Ubicación</option>
            <option value="{{ url('departamento') }}" {{ url()->current() ==  url('departamento') ? "selected": "" }}>Departamentos</option>
            <option value="{{ url('escuela') }}" {{ url()->current() ==  url('escuela') ? "selected": "" }}>Escuelas</option>
            <option value="{{ url('programa') }}" {{ url()->current() ==  url('programa') ? "selected": "" }}>Programas</option>
            <option value="{{ url('plan') }}" {{ url()->current() ==  url('plan') ? "selected": "" }}>Planes</option>
            <option value="{{ url('periodo') }}" {{ url()->current() ==  url('periodo') ? "selected": "" }}>Periodos</option>
            <option value="{{ url('acuerdo') }}" {{ url()->current() ==  url('acuerdo') ? "selected": "" }}>Acuerdos</option>
            <option value="{{ url('materia') }}" {{ url()->current() ==  url('materia') ? "selected": "" }}>Materias</option>
            <option value="{{ url('optativa') }}" {{ url()->current() ==  url('optativa') ? "selected": "" }}>Optativas</option>
            <option value="{{ url('aula') }}" {{ url()->current() ==  url('aula') ? "selected": "" }}>Aulas</option>
            <option value="{{ url('profesion') }}" {{ url()->current() ==  url('profesion') ? "selected": "" }}>Profesiones</option>
            <option value="{{ url('abreviatura') }}" {{ url()->current() ==  url('abreviatura') ? "selected": "" }}>Abreviaturas</option>
            <option value="{{ url('beca') }}" {{ url()->current() ==  url('beca') ? "selected": "" }}>Becas</option>
            <option value="{{ url('concepto_baja') }}" {{ url()->current() ==  url('concepto_baja') ? "selected": "" }}>Concepto de bajas</option>
            <option value="{{ url('concepto_titulacion') }}" {{ url()->current() ==  url('concepto_titulacion') ? "selected": "" }}>Concepto de titulación</option>
            <option value="{{ url('paises') }}" {{ url()->current() ==  url('paises') ? "selected": "" }}>Paises</option>
            <option value="{{ url('estados') }}" {{ url()->current() ==  url('estados') ? "selected": "" }}>Estados</option>
            <option value="{{ url('municipios') }}" {{ url()->current() ==  url('municipios') ? "selected": "" }}>Municipios</option>
            <option value="{{ url('preparatorias') }}" {{ url()->current() ==  url('preparatorias') ? "selected": "" }}>Preparatorias</option>
            @if (App\Models\User::permiso("registro") == "A" || App\Models\User::permiso("registro") == "B" || Auth::user()->username == "DESARROLLO")
                <option value="{{ url('registro') }}" {{ url()->current() ==  url('registro') ? "selected": "" }}>Responsables de registro</option>
            @endif
            @if(in_array(auth()->user()->permiso('puestos'), ['A', 'B', 'C']))
                <option value="{{ url('puestos') }}" {{ url()->current() ==  url('puestos') ? "selected": "" }}>Puestos</option>
            @endif
        </optgroup>

@endif

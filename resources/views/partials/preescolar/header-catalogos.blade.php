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


    {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    {{--
    @if(    ( App\Http\Helpers\SuperUsuario::tieneSuperPoder($userDepClave, $userClave) )
    || ( !App\Http\Helpers\ClubdePanchito::esAmigo($userDepClave, $userClave) )
    )
    --}}

    @if(  Auth::user()->departamento_sistemas == 1 )

            <optgroup label="Catálogos">
                {{--  programas   --}}
                <option value="{{ route('preescolar.preescolar_programa.index') }}" {{ url()->current() ==  route('preescolar.preescolar_programa.index') ? "selected": "" }}>Programas</option>
                {{--  planes   --}}
                <option value="{{ route('preescolar.preescolar_plan.index') }}" {{ url()->current() ==  route('preescolar.preescolar_plan.index') ? "selected": "" }}>Planes</option>
                {{--  periodos   --}}
                <option value="{{ route('preescolar.preescolar_periodo.index') }}" {{ url()->current() ==  route('preescolar.preescolar_periodo.index') ? "selected": "" }}>Períodos</option>
                {{--  materias   --}}
                <option value="{{ route('preescolar.preescolar_materia.index') }}" {{ url()->current() ==  route('preescolar.preescolar_materia.index') ? "selected": "" }}>Materias</option>
                {{--  cgts   --}}
                <option value="{{ route('preescolar.preescolar_cgt.index') }}" {{ url()->current() ==  route('preescolar.preescolar_cgt.index') ? "selected": "" }}>CGT</option>
                {{--  Tipo rubricas   --}}
                <option value="{{ route('preescolar.preescolar_tipo_rubricas.index') }}" {{ url()->current() ==  route('preescolar.preescolar_tipo_rubricas.index') ? "selected": "" }}>Tipo de rubricas</option>
                {{--  Rubricas   --}}
                <option value="{{ route('preescolar.preescolar_rubricas.index') }}" {{ url()->current() ==  route('preescolar.preescolar_rubricas.index') ? "selected": "" }}>Rubricas</option>

                <option value="{{ route('preescolar.preescolar_fecha_de_calificaciones.index') }}" {{ url()->current() ==  route('preescolar.preescolar_fecha_de_calificaciones.index') ? "selected": "" }}>Fechas de calificaciones</option>

            </optgroup>

    @else
    <optgroup label="Catálogos">
        {{--  Rubricas   --}}
        <option value="{{ route('preescolar.preescolar_rubricas.index') }}" {{ url()->current() ==  route('preescolar.preescolar_rubricas.index') ? "selected": "" }}>Rubricas</option>

        <option value="{{ route('preescolar.preescolar_fecha_de_calificaciones.index') }}" {{ url()->current() ==  route('preescolar.preescolar_fecha_de_calificaciones.index') ? "selected": "" }}>Fechas de calificaciones</option>

    </optgroup>
    @endif

@endif

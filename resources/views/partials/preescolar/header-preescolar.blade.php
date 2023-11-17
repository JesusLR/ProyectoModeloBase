@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
    {{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}
        {{-- PREESCOLAR --}}
        @php
            $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
            $userClave = Auth::user()->username;
        @endphp

        @if (Auth::user()->departamento_control_escolar == 1)

            <optgroup label="Preescolar">
                {{--  Preinscritos   --}}
                <option value="{{ route('curso_preescolar.index') }}" {{ url()->current() ==  route('curso_preescolar.index') ? "selected": "" }}>Preinscritos</option>

                {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
                @if(  Auth::user()->departamento_cobranza == 0 )

                        {{--  Historia clinica   --}}
                        <option value="{{ url('clinica') }}" {{ url()->current() ==  url('clinica') ? "selected": "" }}>Historia clinica</option>
                        {{--  Asignar CGT   --}}
                        <option value="{{ route('preescolar.preescolar_asignar_cgt.index') }}" {{ url()->current() ==  route('preescolar.preescolar_asignar_cgt.index') ? "selected": "" }}>Asignar CGT</option>
                        {{--  Cambiar CGT   --}}
                        <option value="{{ route('preescolar.preescolar_cambiar_cgt.edit') }}" {{ url()->current() ==  route('preescolar.preescolar_cambiar_cgt.edit') ? "selected": "" }}>Cambiar CGT</option>

                        <option value="{{ route('preescolar.preescolar_cgt_materias.index') }}" {{ url()->current() ==  route('preescolar.preescolar_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>
                        
                        {{--  Grupos   --}}
                        <option value="{{ route('preescolar_grupo.index') }}" {{ url()->current() ==  route('preescolar_grupo.index') ? "selected": "" }}>Grupos</option>
                        {{--  Inscritos materia   --}}
                        <option value="{{ route('PreescolarInscritos.index') }}" {{ url()->current() ==  route('PreescolarInscritos.index') ? "selected": "" }}>Inscritos materia</option>


                        {{--  <option value="{{ route('preescolar.preescolar_modificar_plantilla_calificaciones.index') }}" {{ url()->current() ==  route('preescolar.preescolar_modificar_plantilla_calificaciones.index') ? "selected": "" }}>Cambiar plantilla (calificaciones)</option>  --}}

                        {{--  Calendario   --}}
                        <option value="{{ url('calendario') }}" {{ url()->current() ==  url('calendario') ? "selected": "" }}>Calendario</option>

                        <option value="{{ route('preescolar.preescolar_alumnos_excel') }}" {{ url()->current() ==  route('preescolar.preescolar_alumnos_excel') ? "selected": "" }}>Alumnos Excel</option>
                        


                @endif

            </optgroup>

        @endif

    {{-- SI LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
        {{--  @if( ( App\Http\Helpers\SuperUsuario::tieneSuperPoder($userDepClave, $userClave) )
               || App\Http\Helpers\ClubdePanchito::esAmigo($userDepClave, $userClave) )  --}}


            {{--  <optgroup label="Pagos">  --}}
              {{--  Ficha general   --}}
              {{--  <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>  --}}

                {{--  @if (( App\Http\Helpers\SuperUsuario::tieneSuperPoder($userDepClave, $userClave) )
                                || $userClave == "FLOPEZH.PREESCOLAR")  --}}
                {{--  Pagos Manuales   --}}
                {{--  <option value="{{ url('preescolar/pagos/aplicar_pagos') }}" {{ url()->current() ==  url('preescolar/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>

                @endif  --}}


            {{--  </optgroup>     --}}

        {{--  @endif  --}}


@endif

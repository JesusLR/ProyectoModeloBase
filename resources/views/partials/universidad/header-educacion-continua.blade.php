@if (
        ( (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1) )
        && auth()->user()->isAdmin('inscritos_edu_continua')
    )
    {{--
    @if (Auth::user()->empleado->escuela->departamento->depClave == "SUP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "DIP" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "AEX" ||
                    Auth::user()->empleado->escuela->departamento->depClave == "IDI")
    --}}

        <optgroup label="Educacion Continua">
            <option value="{{ url('progeducontinua') }}" {{ url()->current() ==  url('progeducontinua') ? "selected": "" }}>Programas edu. continua</option>
            <option value="{{ url('inscritosEduContinua') }}" {{ url()->current() ==  url('inscritosEduContinua') ? "selected": "" }}>Inscritos edu. continua</option>
            <option value="{{ url('reporte/relacion_educontinua') }}" {{ url()->current() ==  url('reporte/relacion_educontinua') ? "selected": "" }}>Rel. edu. continua</option>
            <option value="{{ url('reporte/rel_pagos_educontinua') }}" {{ url()->current() ==  url('reporte/rel_pagos_educontinua') ? "selected": "" }}>Rel. pagos edu. continua</option>
            <option value="{{ url('reporte/rel_aluprog_educontinua') }}" {{ url()->current() ==  url('reporte/rel_aluprog_educontinua') ? "selected": "" }}>Rel. alumnos edu. continua</option>
            <option value="{{ url('tiposProgEduContinua') }}" {{ url()->current() ==  url('tiposProgEduContinua') ? "selected": "" }}>Tipos programa edu. continua</option>
            @if(in_array(auth()->user()->permiso('fichas_incorrectas_edu_continua'), ['A', 'B']))
                <option value="{{ url('reporte/fichas_incorrectas_edu_continua') }}" {{ url()->current() ==  url('reporte/fichas_incorrectas_edu_continua') ? "selected": "" }}>Posibles fichas incorrectas</option>
            @endif
        </optgroup>

@endif

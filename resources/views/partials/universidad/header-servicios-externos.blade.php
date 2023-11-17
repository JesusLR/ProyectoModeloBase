@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )

    @if (auth()->user()->isAdmin('servicios_externos'))
        <optgroup label="Servicios Externos">
            @if(auth()->user()->isAdmin('hurra_alumnos'))
                <option value="{{ url('hurra_alumnos') }}" {{ url()->current() ==  url('hurra_alumnos') ? "selected": "" }}>Hurra Alumnos</option>
            @endif
            @if(auth()->user()->isAdmin('hurra_maestros'))
                <option value="{{ url('hurra_maestros') }}" {{ url()->current() ==  url('hurra_maestros') ? "selected": "" }}>Hurra Maestros</option>
            @endif
            @if(auth()->user()->isAdmin('hurra_ordinarios'))
                <option value="{{ url('hurra_ordinarios') }}" {{ url()->current() ==  url('hurra_ordinarios') ? "selected": "" }}>Hurra Ordinarios</option>
            @endif
            @if(auth()->user()->isAdmin('hurra_horarios'))
                <option value="{{ url('hurra_horarios') }}" {{ url()->current() ==  url('hurra_horarios') ? "selected": "" }}>Hurra Horarios</option>
            @endif
            @if(auth()->user()->isAdmin('hurra_calificaciones'))
                <option value="{{ url('hurra_calificaciones') }}" {{ url()->current() ==  url('hurra_calificaciones') ? "selected": "" }}>Hurra Calificaciones</option>
            @endif
            @if(auth()->user()->isAdmin('hurra_extraordinarios'))
                <option value="{{ url('hurra_extraordinarios') }}" {{ url()->current() ==  url('hurra_extraordinarios') ? "selected": "" }}>Hurra Extraordinarios</option>
            @endif
        </optgroup>
    @endif

@endif

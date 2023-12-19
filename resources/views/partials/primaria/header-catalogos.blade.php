@if (Auth::user()->primaria == 1)
    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp


    {{-- NO LO DEBEN DE VER LOS AMIGOS DEL PANCHITOs --}}
    @if(  Auth::user()->departamento_sistemas == 1 )
        <optgroup label="Prim. Catálogos">
            <option value="{{ route('primaria.primaria_periodo.index') }}" {{ url()->current() ==  route('primaria.primaria_periodo.index') ? "selected": "" }}>Períodos</option>
            <option value="{{ route('primaria.primaria_programa.index') }}" {{ url()->current() ==  route('primaria.primaria_programa.index') ? "selected": "" }}>Programas</option>
            <option value="{{ route('primaria.primaria_plan.index') }}" {{ url()->current() ==  route('primaria.primaria_plan.index') ? "selected": "" }}>Planes</option>
            <option value="{{ route('primaria.primaria_materia.index') }}" {{ url()->current() ==  route('primaria.primaria_materia.index') ? "selected": "" }}>Materias</option>
            <option value="{{ route('primaria.primaria_cgt.index') }}" {{ url()->current() ==  route('primaria.primaria_cgt.index') ? "selected": "" }}>CGT</option>
            <option value="{{ route('primaria.primaria_categoria_contenido.index') }}" {{ url()->current() ==  route('primaria.primaria_categoria_contenido.index') ? "selected": "" }}>Perf. Cat. Contenidos </option>
            <option value="{{ route('primaria.primaria_calificador.index') }}" {{ url()->current() ==  route('primaria.primaria_calificador.index') ? "selected": "" }}>Perf. Calificadores </option>
            <option value="{{ route('primaria.primaria_contenido_fundamental.index') }}" {{ url()->current() ==  route('primaria.primaria_contenido_fundamental.index') ? "selected": "" }}>Perf. Contenidos</option>
            {{--  Migrar Inscritos ACD   --}}
            <option value="{{ route('primaria.primaria_migrar_inscritos_acd.index') }}" {{ url()->current() ==  route('primaria.primaria_migrar_inscritos_acd.index') ? "selected": "" }}>Migrar Inscritos ACD</option>
        </optgroup>

    @endif

    <optgroup label="Prim. Catálogos">
        <option value="{{ route('primaria.primaria_materia.index') }}" {{ url()->current() ==  route('primaria.primaria_materia.index') ? "selected": "" }}>Materias</option>
        <option value="{{ route('primaria.primaria_campos_formativos.index') }}" {{ url()->current() ==  route('primaria.primaria_campos_formativos.index') ? "selected": "" }}>Campos Formativos</option>
        <option value="{{ route('primaria.primaria_campos_formativos_observaciones.index') }}" {{ url()->current() ==  route('primaria.primaria_campos_formativos_observaciones.index') ? "selected": "" }}>Campos Formativos Observaciones</option>
        <option value="{{ route('primaria.primaria_campos_formativos_materias.index') }}" {{ url()->current() ==  route('primaria.primaria_campos_formativos_materias.index') ? "selected": "" }}>Campos Formativos Materias</option>
    </optgroup>

@endif

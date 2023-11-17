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


    <optgroup label="Univ.Control Escolar">

        <option value="{{ url('empleado') }}" {{ url()->current() ==  url('empleado') ? "selected": "" }}>Empleados</option>
        <option value="{{ url('alumno') }}" {{ url()->current() ==  url('alumno') ? "selected": "" }}>Alumnos</option>
        @if(App\Models\User::permiso("alumno") == "A" || App\Models\User::permiso("alumno") == "B" || Auth::user()->username == "DESARROLLO")
            <option value="{{ url('alumno_restringido') }}" {{ url()->current() ==  url('alumno_restringido') ? "selected": "" }}>Alumnos restringidos</option>
        @endif

        <option value="{{ url('cgt') }}" {{ url()->current() ==  url('cgt') ? "selected": "" }}>CGT</option>
        @if(in_array(auth()->user()->permiso('cambiar_cgt'), ['A', 'B', 'C']))
            <option value="{{ url('cambiar_cgt') }}" {{ url()->current() ==  url('cambiar_cgt') ? "selected": "" }}>cambiar CGT</option>
        @endif
        <option value="{{ url('grupo') }}" {{ url()->current() ==  url('grupo') ? "selected": "" }}>Grupos</option>
        <option value="{{ url('paquete') }}" {{ url()->current() ==  url('paquete') ? "selected": "" }}>Paquetes</option>
        <option value="{{ url('curso') }}" {{ url()->current() ==  url('curso') ? "selected": "" }}>Preinscritos</option>
        <option value="{{ url('inscrito') }}" {{ url()->current() ==  url('inscrito') ? "selected": "" }}>Inscritos</option>

        <option value="{{ url('preinscrito_extraordinario') }}" {{ url()->current() ==  url('preinscrito_extraordinario') ? "selected": "" }}>Preinscrito extraordinario</option>

        <option value="{{ url('extraordinario') }}" {{ url()->current() ==  url('extraordinario') ? "selected": "" }}>Extraordinarios</option>
        <option value="{{ url('matricula_anterior') }}" {{ url()->current() ==  url('matricula_anterior') ? "selected": "" }}>Matricula Anterior</option>
        <option value="{{ url('escolaridad') }}" {{ url()->current() ==  url('escolaridad') ? "selected": "" }}>Escolaridad</option>
        <option value="{{ url('clave_profesor') }}" {{ url()->current() ==  url('clave_profesor') ? "selected": "" }}>Clave SEGEY</option>
        {{-- <option value="{{ url('pago') }}" {{ url()->current() ==  url('pago') ? "selected": "" }}>Referencia de pago</option> --}}
        <option value="{{ url('horarios_administrativos') }}" {{ url()->current() ==  url('horarios_administrativos') ? "selected": "" }}>Horarios administrativos</option>
        <option value="{{ url('historico') }}" {{ url()->current() ==  url('historico') ? "selected": "" }}>Historico</option>

        @if (in_array(Auth::user()->permiso('preinscripcion_automatica'), ['A', 'B']))
            <option value="{{ url('preinscripcion_auto') }}" {{ url()->current() ==  url('preinscripcion_auto') ? "selected": "" }}>Preinscripción Automática</option>
        @endif


        <option value="{{ url('serviciosocial') }}" {{ url()->current() ==  url('serviciosocial') ? "selected": "" }}>Servicio Social</option>

        @if (Auth::user()->username == "DESARROLLO" || Auth::user()->username == "LLARA" || Auth::user()->username == "EAIL" || Auth::user()->username == "CELIA" || Auth::user()->username == "SILVIA")
            <option value="{{ url('cierre_actas') }}" {{ url()->current() ==  url('cierre_actas') ? "selected": "" }}>Cierre de actas</option>
        @endif
        @if (Auth::user()->username == "DESARROLLO" || Auth::user()->username == "LLARA" || Auth::user()->username == "EAIL" || Auth::user()->username == "CELIA" || Auth::user()->username == "SILVIA")
            <option value="{{ url('cierre_extras') }}" {{ url()->current() ==  url('cierre_actas') ? "selected": "" }}>Cierre de actas(Extraordinarios)</option>
        @endif
        @if (in_array(auth()->user()->permiso('egresados'), ['A', 'B']))
            <option value="{{ url('egresados') }}" {{ url()->current() ==  url('egresados') ? "selected": "" }}>Egresados</option>
        @endif
        @if(auth()->user()->permiso('egresados') == 'A')
            <option value="{{ url('registro_egresados') }}" {{ url()->current() ==  url('registro_egresados') ? "selected": "" }}>Registro Automático Egresados</option>
            {{-- <option value="{{ url('egresados/create') }}" {{ url()->current() ==  url('egresados/create') ? "selected": "" }}>Registro Manual Egresados</option> --}}
        @endif

        <option value="{{ url('tutores') }}" {{ url()->current() ==  url('tutores') ? "selected": "" }}>Tutores</option>
        <option value="{{ url('calendarioexamen') }}" {{ url()->current() ==  url('calendarioexamen') ? "selected": "" }}>Calendario Exámenes</option>
        <option value="{{ url('candidatos_primer_ingreso') }}" {{ url()->current() ==  url('candidatos_primer_ingreso') ? "selected": "" }}>Candidatos 1er Ingreso</option>


        @if(Auth::user()->username == 'DESARROLLO' ||
              in_array(App\Models\User::permiso('cambiar_contrasena'), ['A','B','C']))
            <option value="{{ url('cambiar_contrasena') }}" {{ url()->current() ==  url('cambiar_contrasena') ? "selected": "" }}>Cambiar contraseña de docentes</option>
        @endif


        <option value="{{ url('extracurricular') }}" {{ url()->current() ==  url('extracurricular') ? "selected": "" }}>Extracurricular</option>

        @if(auth()->user()->permiso('resumen_academico') == "A")
            <option value="{{ url('resumen_academico') }}" {{ url()->current() ==  url('resumen_academico') ? "selected": "" }}>Resúmenes académicos</option>
        @endif
        @if(auth()->user()->isAdmin('revalidaciones'))
            <option value="{{ url('revalidaciones') }}" {{ url()->current() ==  url('revalidaciones') ? "selected": "" }}>Revalidaciones</option>
        @endif

    </optgroup>

@endif

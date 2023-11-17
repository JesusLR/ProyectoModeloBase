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

            {{-- menu tutorias  --}}
            <optgroup label="Tutorías">
                @if (Auth::user()->username == "DESARROLLO" 
                || Auth::user()->username == "LLARA"
                || Auth::user()->username == "CESAURI"
                || Auth::user()->username == "EAIL")
                    <option value="{{ url('tutorias_encuestas') }}" {{ url()->current() ==  url('tutorias_encuestas') ? "selected": "" }}>Encuestas</option>
                    <option value="{{ url('tutorias_categoria_pregunta') }}" {{ url()->current() ==  url('tutorias_categoria_pregunta') ? "selected": "" }}>Categoría pregunta</option>
                    <option value="{{ url('tutorias_factores_riesgo') }}" {{ url()->current() ==  url('tutorias_factores_riesgo') ? "selected": "" }}>Analisis de resultados</option>
                    <option value="{{ url('tutorias_formulario') }}" {{ url()->current() ==  url('tutorias_formulario') ? "selected": "" }}>Formulario</option>
                @endif
                <option value="{{ url('reporte/tutorias/alumnos_faltantes_encuesta') }}" {{ url()->current() ==  url('reporte/tutorias/alumnos_faltantes_encuesta') ? "selected": "" }}>Alumnos Faltantes Encuesta</option>
                <option value="{{ url('reporte/tutorias/reporte_por_tipo_respuesta') }}" {{ url()->current() ==  url('reporte/tutorias/reporte_por_tipo_respuesta') ? "selected": "" }}>Reporte por Tipo Respuesta</option>
                @if (Auth::user()->username == "DESARROLLO" 
                || Auth::user()->username == "LLARA"
                || Auth::user()->username == "CESAURI"
                || Auth::user()->username == "EAIL")
                <option value="{{ url('reporte/tutorias/reporte_cuantitativo_respuesta') }}" {{ url()->current() ==  url('reporte/tutorias/reporte_cuantitativo_respuesta') ? "selected": "" }}>Reporte cuantitativo Respuesta</option>
                @endif
            </optgroup>

        @endif


@endif

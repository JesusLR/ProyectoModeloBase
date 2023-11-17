@if (
        (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
        || (Auth::user()->educontinua == 1)
    )


        <optgroup label="Univ.Reportes-Z Federales">
            <optgroup label="> Reporte Federal">
                <option value="{{ url('reporte-federal/anexo-8') }}" {{ url()->current() ==  url('reporte-federal/anexo-8') ? "selected": "" }}>Anexo 8</option>
                <option value="{{ url('reporte-federal/acta_extraordinario') }}" {{ url()->current() ==  url('reporte-federal/acta_extraordinario') ? "selected": "" }}>Acta de examen extraordinario</option>
                <option value="{{ url('reporte-federal/acta_examen_ordinario_federales') }}" {{ url()->current() ==  url('reporte-federal/acta_examen_ordinario_federales') ? "selected": "" }}>Actas de examen ordinario</option>
            </optgroup>
        </optgroup>

        <optgroup label="SEGEY Federales">
            <option value="{{ url('reporte-federal/segey/registro_alumnos') }}" {{ url()->current() ==  url('reporte-federal/segey/registro_alumnos') ? "selected": "" }}>Registro de alumnos</option>
        </optgroup>


@endif

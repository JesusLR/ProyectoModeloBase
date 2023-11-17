@if ( Auth::user()->superior == 1 )
<optgroup label="Manual de usuario">
    <option target="_blank" value="{{ url('manuales') }}" {{ url()->current() ==  url('manuales') ? "selected": "" }}>Reportes</option>
</optgroup>
@endif
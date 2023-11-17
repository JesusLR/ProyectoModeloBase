@if ( Auth::user()->superior == 1 )
<li class="bold">
    <a class="collapsible-header waves-effect waves-cyan">
        <i class="material-icons">dashboard</i>
        <span class="nav-text">Manual de usuario</span>
    </a>
    <div class="collapsible-body">
        <ul class="collapsible" data-collapsible="accordion">

            <li class="bold">
                <a target="_blank" href="{{ url('manuales') }}">
                    <i class="material-icons">keyboard_arrow_right</i>
                    <span>Reportes</span>
                </a>
            </li>

        </ul>
    </div>
</li>
@endif
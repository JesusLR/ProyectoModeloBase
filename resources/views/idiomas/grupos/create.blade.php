@extends('layouts.dashboard')

@section('template_title')
    Idiomas Grupo
@endsection

<style>
.picker__date-display { background-color: #01579b !important; }
.clockpicker-tick:hover { background: #01579b !important; }
.clockpicker-canvas line { stroke: #01579b !important; }
.clockpicker-canvas-bearing { fill: #01579b !important; }
.clockpicker-canvas-bg { fill: #01579b !important; }
.picker__close { color: #01579b !important;}
</style>

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_grupo')}}" class="breadcrumb">Lista de Grupo</a>
    <a href="{{url('idiomas_grupo/create')}}" class="breadcrumb">Agregar Grupo</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'idiomas.idiomas_grupo.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR GRUPO</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#horarios">Horarios</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

                                    $selected = '';
                                    if ($ubicacion->id == $ubicacion_id) {
                                        $selected = 'selected';
                                    }
                                
                                    if ($ubicacion->id == old("ubicacion_id")) {
                                        $selected = 'selected';
                                    }
                                @endphp
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiClave ."-". $ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-idold="{{old('departamento_id')}}"
                            class="browser-default validate select2"
                            required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-idold="{{old('escuela_id')}}"
                            class="browser-default validate select2"
                            required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-periodo-idold="{{old('periodo_id')}}"
                            class="browser-default validate select2"
                            required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-idold="{{old('programa_id')}}"
                            class="browser-default validate select2"
                            required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-idold="{{old('plan_id')}}"
                            class="browser-default validate select2"
                            required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('nivel_id', 'Grado *', array('class' => '')); !!}
                        <select id="nivel_id"
                            data-programa-idold="{{old('nivel_id')}}"
                            class="browser-default validate select2"
                            required name="nivel_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoClave', NULL, array( 'id' => 'gpoClave',
                            'class' => 'validate','required','maxlength' => '3',
                            'value' => old("gpoClave") ? old("gpoClave"): "" )) !!}
                        {!! Form::label('gpoClave', 'Clave grupo *', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoDescripcion', NULL, array( 'id' => 'gpoDescripcion',
                            'class' => 'validate','required','maxlength' => '100',
                            'value' => old("gpoDescripcion") ? old("gpoDescripcion"): "" )) !!}
                        {!! Form::label('gpoDescripcion', 'Descripción *', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('gpoCupo', NULL, array('id' => 'gpoCupo', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('gpoCupo', 'Cupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('empleado_id', 'Maestro *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="horarios">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraInicioLunes', NULL, array('id' => 'gpoHoraInicioLunes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraInicioLunes', 'Hora inicio lunes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraFinLunes', NULL, array('id' => 'gpoHoraFinLunes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraFinLunes', 'Hora fin lunes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoAulaLunes', NULL, array('id' => 'gpoAulaLunes', 'class' => 'validate', 'maxlength' => '55')) !!}
                        {!! Form::label('gpoAulaLunes', 'Aula lunes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraInicioMartes', NULL, array('id' => 'gpoHoraInicioMartes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraInicioMartes', 'Hora inicio Martes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraFinMartes', NULL, array('id' => 'gpoHoraFinMartes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraFinMartes', 'Hora fin Martes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoAulaMartes', NULL, array('id' => 'gpoAulaMartes', 'class' => 'validate', 'maxlength' => '55')) !!}
                        {!! Form::label('gpoAulaMartes', 'Aula Martes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraInicioMiercoles', NULL, array('id' => 'gpoHoraInicioMiercoles', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraInicioMiercoles', 'Hora inicio miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraFinMiercoles', NULL, array('id' => 'gpoHoraFinMiercoles', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraFinMiercoles', 'Hora fin miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoAulaMiercoles', NULL, array('id' => 'gpoAulaMiercoles', 'class' => 'validate', 'maxlength' => '55')) !!}
                        {!! Form::label('gpoAulaMiercoles', 'Aula miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraInicioJueves', NULL, array('id' => 'gpoHoraInicioJueves', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraInicioJueves', 'Hora inicio Jueves', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraFinJueves', NULL, array('id' => 'gpoHoraFinJueves', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraFinJueves', 'Hora fin Jueves', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoAulaJueves', NULL, array('id' => 'gpoAulaJueves', 'class' => 'validate', 'maxlength' => '55')) !!}
                        {!! Form::label('gpoAulaJueves', 'Aula Jueves', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraInicioViernes', NULL, array('id' => 'gpoHoraInicioViernes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraInicioViernes', 'Hora inicio Viernes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraFinViernes', NULL, array('id' => 'gpoHoraFinViernes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraFinViernes', 'Hora fin Viernes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoAulaViernes', NULL, array('id' => 'gpoAulaViernes', 'class' => 'validate', 'maxlength' => '55')) !!}
                        {!! Form::label('gpoAulaViernes', 'Aula Viernes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraInicioSabado', NULL, array('id' => 'gpoHoraInicioSabado', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraInicioSabado', 'Hora inicio Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoHoraFinSabado', NULL, array('id' => 'gpoHoraFinSabado', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                        {!! Form::label('gpoHoraFinSabado', 'Hora fin Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoAulaSabado', NULL, array('id' => 'gpoAulaSabado', 'class' => 'validate', 'maxlength' => '55')) !!}
                        {!! Form::label('gpoAulaSabado', 'Aula Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
</div>



@include('modales.equivalentes')

@endsection

@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
    $(document).ready(function() {
        $('.timepicker').on('mousedown',function(event){
            event.preventDefault();
        });
        $('.timepicker').pickatime({
            default: 'now', // Set default time: 'now', '1:30AM', '16:30'
            fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
            twelvehour: false, // Use AM/PM or 24-hour format
            donetext: 'Hecho', // text for done-button
            cleartext: 'Borrar', // text for clear-button
            canceltext: 'Cancelar', // Text for cancel-button,
            container: undefined, // ex. 'body' will append picker to body
            autoclose: false, // automatic close timepicker
            ampmclickable: true, // make AM PM clickable
            aftershow: function(event){} //Function for after opening timepicker
        });
    });
</script>



@include('idiomas.scripts.preferencias')
@include('idiomas.scripts.departamentos')
@include('idiomas.scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('idiomas.scripts.niveles')
@include('scripts.periodos')
@include('scripts.semestres')
@include('scripts.materias')
@include('scripts.grupos')
@include('scripts.optativas')


@endsection
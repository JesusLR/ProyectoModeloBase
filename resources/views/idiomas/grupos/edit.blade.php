@extends('layouts.dashboard')

@section('template_title')
    Idiomas grupo
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
    <a href="{{url('idiomas_grupo/'.$grupo->id.'/edit')}}" class="breadcrumb">Editar grupo</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['idiomas.idiomas_grupo.update', $grupo->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR GRUPO #{{$grupo->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$grupo->plan->programa->escuela->departamento->ubicacion_id}}" selected >{{$grupo->plan->programa->escuela->departamento->ubicacion->ubiClave}}-{{$grupo->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$grupo->plan->programa->escuela->departamento_id}}" selected >{{$grupo->plan->programa->escuela->departamento->depClave}}-{{$grupo->plan->programa->escuela->departamento->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$grupo->plan->programa->escuela_id}}" selected >{{$grupo->plan->programa->escuela->escClave}}-{{$grupo->plan->programa->escuela->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="{{$grupo->periodo_id}}" >{{$grupo->periodo->perNumero ." - ".$grupo->periodo->perAnio}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$grupo->plan->programa->id}}">{{$grupo->plan->programa->progClave}}-{{$grupo->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$grupo->plan->id}}" >{{$grupo->plan->planClave}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('nivel_id', 'Grado  *', array('class' => '')); !!}
                        <select id="nivel_id" class="browser-default validate select2" required name="nivel_id" style="width: 100%;">
                            <option value="{{$nivel->gpoGrado}}" >{{$nivel->gpoGrado}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoClave', $grupo->gpoClave, array('id' => 'gpoClave', 'class' => 'validate','required','readonly')) !!}
                            {!! Form::label('gpoClave', 'Clave grupo *', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoDescripcion', $grupo->gpoDescripcion, array('id' => 'gpoDescripcion', 'class' => 'validate','required','readonly')) !!}
                            {!! Form::label('gpoDescripcion', 'Clave grupo *', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoCupo', $grupo->gpoCupo, array('id' => 'gpoCupo', 'class' => 'validate','required','readonly')) !!}
                            {!! Form::label('gpoCupo', 'Clave grupo *', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="empleadoinput" style="position:relative">
                            {!! Form::label('empleado_id', 'Maestro *', array('class' => '')); !!}
                            <select id="empleado_id"  class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($empleados as $empleado)
                                    @php
                                        $empleadoId = $grupo->idiomas_empleado_id;
                                    @endphp
                                    <option value="{{$empleado->id}}" {{($empleadoId == $empleado->id) ? 'selected': ''}}>
                                        {{$empleado->id ." - ".$empleado->empNombre
                                            ." ". $empleado->empApellido1
                                            ." ". $empleado->empApellido2}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="block" style="width: 100%; height: 65px; position: absolute; top:0; left:0; display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EQUIVALENTE BAR--}}
            <div id="horarios">
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioLunes', $grupo->gpoHoraInicioLunes, array('id' => 'pgoHoraInicioLunes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraInicioLunes', 'Hora inicio lunes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinLunes', $grupo->gpoHoraFinLunes, array('id' => 'pgoHoraFinLunes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraFinLunes', 'Hora fin lunes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaLunes', $grupo->gpoAulaLunes, array('id' => 'pgoAulaLunes', 'class' => 'validate', 'maxlength' => '55')) !!}
                            {!! Form::label('gpoAulaLunes', 'Aula lunes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioMartes', $grupo->gpoHoraInicioMartes, array('id' => 'pgoHoraInicioMartes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraInicioMartes', 'Hora inicio martes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinMartes', $grupo->gpoHoraFinMartes, array('id' => 'pgoHoraFinMartes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraFinMartes', 'Hora fin martes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaMartes', $grupo->gpoAulaMartes, array('id' => 'pgoAulaMartes', 'class' => 'validate', 'maxlength' => '55')) !!}
                            {!! Form::label('gpoAulaMartes', 'Aula martes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioMiercoles', $grupo->gpoHoraInicioMiercoles, array('id' => 'gpoHoraInicioMiercoles', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraInicioMiercoles', 'Hora inicio miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinMiercoles', $grupo->gpoHoraFinMiercoles, array('id' => 'gpoHoraFinMiercoles', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraFinMiercoles', 'Hora fin miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaMiercoles', $grupo->gpoAulaMiercoles, array('id' => 'gpoAulaMiercoles', 'class' => 'validate', 'maxlength' => '55')) !!}
                            {!! Form::label('gpoAulaMiercoles', 'Aula miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioJueves', $grupo->gpoHoraInicioJueves, array('id' => 'gpoHoraInicioJueves', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraInicioJueves', 'Hora inicio jueves', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinJueves', $grupo->gpoHoraFinJueves, array('id' => 'gpoHoraFinJueves', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraFinJueves', 'Hora fin jueves', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaJueves', $grupo->gpoAulaJueves, array('id' => 'gpoAulaJueves', 'class' => 'validate', 'maxlength' => '55')) !!}
                            {!! Form::label('gpoAulaJueves', 'Aula jueves', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioViernes', $grupo->gpoHoraInicioViernes, array('id' => 'gpoHoraInicioViernes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraInicioViernes', 'Hora inicio viernes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinViernes', $grupo->gpoHoraFinViernes, array('id' => 'gpoHoraFinViernes', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraFinViernes', 'Hora fin viernes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaViernes', $grupo->gpoAulaViernes, array('id' => 'gpoAulaViernes', 'class' => 'validate', 'maxlength' => '55')) !!}
                            {!! Form::label('gpoAulaViernes', 'Aula viernes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioSabado', $grupo->gpoHoraInicioSabado, array('id' => 'gpoHoraInicioSabado', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraInicioSabado', 'Hora inicio sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinSabado', $grupo->gpoHoraFinSabado, array('id' => 'gpoHoraFinSabado', 'class' => 'validate timepicker', 'maxlength' => '5')) !!}
                            {!! Form::label('gpoHoraFinSabado', 'Hora fin sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaSabado', $grupo->gpoAulaSabado, array('id' => 'gpoAulaSabado', 'class' => 'validate', 'maxlength' => '55')) !!}
                            {!! Form::label('gpoAulaSabado', 'Aula sábado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['display' => 'inline-block', 'class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

    <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

    @endsection

    @section('footer_scripts')

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


                apply_data_to_select('optativa_id', 'optativa-id');

                $("#ubicacion_id").change( event => {
                    $("#departamento_id").empty();
                    $("#escuela_id").empty();
                    $("#periodo_id").empty();
                    $("#programa_id").empty();
                    $("#plan_id").empty();
                    $("#cgt_id").empty();
                    $("#materia_id").empty();
                    $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                    $("#perFechaInicial").val('');
                    $("#perFechaFinal").val('');
                    $.get(base_url+`/api/departamentos/${event.target.value}`,function(res,sta){
                        res.forEach(element => {
                            $("#departamento_id").append(`<option value=${element.id}>${element.depClave}-${element.depNombre}</option>`);
                        });
                    });
                });
            });
        </script>
        @include('idiomas.scripts.escuelas')
        @include('scripts.programas')
        @include('scripts.planes')
        @include('scripts.periodos')
        @include('scripts.cgts')
        @include('scripts.materias')
        @include('scripts.grupos')
        @include('scripts.optativas')

    @endsection
@extends('layouts.dashboard')

@section('template_title')
    Notificaciones Coordinación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('notificaciones_coordinacion')}}" class="breadcrumb">Lista de Notificaciones Coordinación</a>
    <a href="{{url('notificaciones_coordinacion/create')}}" class="breadcrumb">Agregar Notificaciones Coordinación</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'notificaciones_coordinacion.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR NOTIFICACIONES COORDINACIÓN</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
                <div class="nav-content">
                    <ul class="tabs tabs-transparent">
                        <li class="tab"><a class="active" href="#general">General</a></li>
                    </ul>
                </div>
            </nav>

            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                    <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" required name="ubicacion_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                    <select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" required name="departamento_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                    <select id="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" required name="escuela_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col s4">
                  {!! Form::label('persona_id', 'Empleado', array('class' => '')); !!}
                  <select id="persona_id" class="browser-default validate select2" required name="persona_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->persona->id}}" >{{$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="input-field col s4">
                    {!! Form::text('empCorreo1', NULL, array('id' => 'empCorreo1', 'class' => 'validate noUpperCase','required')) !!}
                    {!! Form::label('empCorreo1', 'Correo *', array('class' => '')); !!}
                </div>

                <div class="col s4">
                    {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                    <select id="programa_id" class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" required name="programa_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col s4">
                    {!! Form::label('modulo', 'Módulo *', array('class' => '')); !!}
                    <select id="modulo" class="browser-default validate select2" data-programa-id="{{old('modulo')}}" required name="modulo" style="width: 100%;">
                        <option value="EXTRAORDINARIOS">EXTRAORDINARIOS</option>
                        <option value="INSCRITOS">INSCRITOS</option>
                        <option value="CANDIDATOS">CANDIDATOS</option>
                    </select>
                </div>

              </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect light-blue darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection

@section('footer_scripts')

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

  <script>
    $(document).ready(function() {
        let ubicacion = $('#ubicacion_id');
        let departamento = $('#departamento_id');
        let escuela = $('#escuela_id');
        let programa = $('#programa_id');

        apply_data_to_select('ubicacion_id', 'ubicacion-id');
        apply_data_to_select('escuela_id', 'periodo-id');
        apply_data_to_select('programa_id', 'programa-id');

        ubicacion.val() ? getDepartamentosListaCompleta(ubicacion.val()) : resetSelect('departamento_id');

        ubicacion.on('change', function() {
            this.value ? getDepartamentosListaCompleta(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            this.value ? getEscuelasListaCompleta(this.value) : resetSelect('escuela_id');
        });

        escuela.on('change', function() {
            this.value ? getProgramas(this.value) : resetSelect('programa_id');
        });

        function obtenerDatosEmpleado(empleado_id) {
            $.get(base_url+`/api/getEmpleadoDatos/${empleado_id}`, function(res,sta) {

                if(res.empCorreo1 == null) $("#empCorreo1").val("");
                else $("#empCorreo1").val(res.empCorreo1);
                
                Materialize.updateTextFields();
            });
        }
        
        $("#persona_id").change( event => {
            obtenerDatosEmpleado(event.target.value);
        });
    });
  </script>
@endsection
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
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => ['notificaciones_coordinacion.update', $empleadoSeguimiento->id], 'method' => 'PUT']) !!}
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
            <div class="input-field col s12 m6 l4">
                    {!! Form::text('ubicacion_id', $empleadoSeguimiento->ubiClave.'-'.$empleadoSeguimiento->ubiNombre, array('readonly' => 'true')) !!}
                    {!! Form::label('ubicacion_id', 'Campus', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l4">
                    {!! Form::text('departamento_id', $empleadoSeguimiento->depClave.'-'.$empleadoSeguimiento->depNombre, array('readonly' => 'true')) !!}
                    {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l4">
                    {!! Form::text('escuela_id', $empleadoSeguimiento->escClave.'-'.$empleadoSeguimiento->escNombre, array('readonly' => 'true')) !!}
                    {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                </div>
            </div>

            <div class="row">
                <div class="input-field col s4">
                    {!! Form::text('persona_id', $empleadoSeguimiento->perNombre ." ". $empleadoSeguimiento->perApellido1." ".$empleadoSeguimiento->perApellido2, array('readonly' => 'true')) !!}
                    {!! Form::label('persona_id', 'Empleado', array('class' => '')); !!}
                </div>

                <div class="input-field col s4">
                    {!! Form::text('empCorreo1', $empleadoSeguimiento->empCorreo1, array('id' => 'empCorreo1', 'class' => 'validate noUpperCase','required')) !!}
                    {!! Form::label('empCorreo1', 'Correo *', array('class' => '')); !!}
                </div>

                <div class="input-field col s4">
                    {!! Form::text('programa_id', $empleadoSeguimiento->progClave.'-'.$empleadoSeguimiento->progNombre ,array('readonly' => 'true')) !!}
                    {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                </div>

            </div>
            <div class="row">
                <div class="input-field col s4">
                    {!! Form::text('modulo', $empleadoSeguimiento->modulo ,array('readonly' => 'true')) !!}
                    {!! Form::label('modulo', 'Módulo', array('class' => '')); !!}
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
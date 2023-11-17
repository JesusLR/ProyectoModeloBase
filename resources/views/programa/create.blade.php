@extends('layouts.dashboard')

@section('template_title')
    Programa
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('programa')}}" class="breadcrumb">Lista de programas</a>
    <label class="breadcrumb">Agregar programa</label>
@endsection

@section('content')

@php
    $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'programa.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PROGRAMA</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" required name="ubicacion_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" required name="departamento_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" required name="escuela_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('empleado_id', 'Coordinador *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" data-empleado-id="{{old('empleado_id')}}" required name="empleado_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->id}} - {{$empleado->persona->nombreCompleto()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', old('progClave'), array('id' => 'progClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('progClave', 'Clave programa *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progNombre', old('progNombre'), array('id' => 'progNombre', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('progNombre', 'Nombre programa *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progNombreCorto', old('progNombreCorto'), array('id' => 'progNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('progNombreCorto', 'Nombre corto * (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m8">
                        <div class="input-field">
                            {!! Form::text('progTituloOficial', old('progTituloOficial'), array('id' => 'progTituloOficial', 'class' => 'validate','maxlength'=>'78')) !!}
                            {!! Form::label('progTituloOficial', 'Título oficial de la carrera como debe aparecer en el certificado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>


          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <script type="text/javascript" src={{asset('js/funcionesAuxiliares.js')}}></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        let ubicacion = $('#ubicacion_id');
        let departamento = $('#departamento_id');

        apply_data_to_select('ubicacion_id', 'ubicacion-id');
        apply_data_to_select('empleado_id', 'empleado-id');

        ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
        ubicacion.on('change', function() {
            this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            this.value ? getEscuelas(this.value) : resetSelect('escuela_id');
        });
    });
</script>

@endsection
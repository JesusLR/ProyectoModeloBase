@extends('layouts.dashboard')

@section('template_title')
    Escuela
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_escuela')}}" class="breadcrumb">Lista de escuelas</a>
    <label class="breadcrumb">Agregar escuela</label>
@endsection

@section('content')

@php
    $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_escuela.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR ESCUELA</span>

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
                        {!! Form::label('empleado_id', 'Director *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" data-empleado-id="{{old('empleado_id')}}" required name="empleado_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->id}} - {{$empleado->persona->nombreCompleto()}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', old('escClave'), array('id' => 'escClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('escClave', 'Clave escuela *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombre', old('escNombre'), array('id' => 'escNombre', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('escNombre', 'Nombre escuela *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombreCorto', old('escNombreCorto'), array('id' => 'escNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('escNombreCorto', 'Nombre corto * (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('escPorcExaPar', old('escPorcExaPar'), array('id' => 'escPorcExaPar', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                            {!! Form::label('escPorcExaPar', '% Exa Parciales *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('escPorcExaOrd', old('escPorcExaOrd'), array('id' => 'escPorcExaOrd', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                            {!! Form::label('escPorcExaOrd', '% Exa Ordinario *', array('class' => '')); !!}
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

        apply_data_to_select('ubicacion_id', 'ubicacion-id');
        apply_data_to_select('empleado_id', 'empleado-id');

        ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
        ubicacion.on('change', function() {
            this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
        });
    });
</script>
@endsection
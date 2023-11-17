@extends('layouts.dashboard')

@section('template_title')
    Escolaridad
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('escolaridad')}}" class="breadcrumb">Lista de escolaridades</a>
    <label class="breadcrumb">Agregar escolaridad</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'escolaridad.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR ESCOLARIDAD</span>

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
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Empleado *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->persona->perNombre}} {{$empleado->persona->perApellido1}} {{$empleado->persona->perApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                  <div class="col s12 m6">
                      {!! Form::label('profesion_id', 'Profesión *', array('class' => '')); !!}
                      <select id="profesion_id" class="browser-default validate select2" required name="profesion_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($profesiones as $profesion)
                              <option value="{{$profesion->id}}" @if(old('profesion_id') == $profesion->id) {{ 'selected' }} @endif>{{$profesion->profNivel}}-{{$profesion->profNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6">
                      {!! Form::label('abreviaturaTitulo_id', 'Abreviatura *', array('class' => '')); !!}
                      <select id="abreviaturaTitulo_id" class="browser-default validate select2" required name="abreviaturaTitulo_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($abreviaturas as $abreviatura)
                              <option value="{{$abreviatura->id}}" @if(old('abreviaturaTitulo_id') == $abreviatura->id) {{ 'selected' }} @endif>{{$abreviatura->abtAbreviatura}}-{{$abreviatura->abtDescripcion}}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoGraduado', 'Graduado *', array('class' => '')); !!}
                      <select id="escoGraduado" class="browser-default validate select2" required name="escoGraduado" style="width: 100%;">
                          <option value="S" selected >SI</option>
                          <option value="N">NO</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoTipoDocumento', 'Tipo documento *', array('class' => '')); !!}
                      <select id="escoTipoDocumento" class="browser-default validate select2" required name="escoTipoDocumento" style="width: 100%;">
                          <option value="T" selected >TITULO</option>
                          <option value="C">CEDULA</option>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('escoFolio', NULL, array('id' => 'escoFolio', 'class' => 'validate','maxlength' => '10')) !!}
                      {!! Form::label('escoFolio', 'Folio escolaridad', ['class' => '']); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoFechaDocumento', 'Fecha de documento *', array('class' => '',)); !!}
                      {!! Form::date('escoFechaDocumento', NULL, array('id' => 'escoFechaDocumento', 'class' => 'validate','required')) !!}
                  </div>
                </div>
                <div class="row">
                  <div class="col s12">
                      <div class="input-field">
                      {!! Form::text('escoObservaciones', NULL, array('id' => 'escoObservaciones', 'class' => 'validate','maxlength' => '255')) !!}
                      {!! Form::label('escoObservaciones', 'Observaciones', ['class' => '']); !!}
                      </div>
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




@endsection

@section('footer_scripts')
@endsection
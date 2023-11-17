@extends('layouts.dashboard')

@section('template_title')
    Escolaridad
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('escolaridad')}}" class="breadcrumb">Lista de escolaridades</a>
    <label class="breadcrumb">Editar escolaridad</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
            {{ Form::open(array('method'=>'PUT','route' => ['escolaridad.update', $escolaridad->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR ESCOLARIDAD #{{$escolaridad->id}}</span>

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
                            <option value="{{$empleado->id}}" @if($escolaridad->empleado_id == $empleado->id) {{ 'selected' }} @endif>{{$empleado->persona->perNombre}} {{$empleado->persona->perApellido1}} {{$empleado->persona->perApellido2}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                  <div class="col s12 m6">
                      {!! Form::label('profesion_id', 'Profesión *', array('class' => '')); !!}
                      <select id="profesion_id" class="browser-default validate select2" required name="profesion_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($profesiones as $profesion)
                              <option value="{{$profesion->id}}" @if($escolaridad->profesion_id == $profesion->id) {{ 'selected' }} @endif>{{$profesion->profNivel}}-{{$profesion->profNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6">
                      {!! Form::label('abreviaturaTitulo_id', 'Abreviatura *', array('class' => '')); !!}
                      <select id="abreviaturaTitulo_id" class="browser-default validate select2" required name="abreviaturaTitulo_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($abreviaturas as $abreviatura)
                              <option value="{{$abreviatura->id}}" @if($escolaridad->abreviaturaTitulo_id == $abreviatura->id) {{ 'selected' }} @endif>{{$abreviatura->abtAbreviatura}}-{{$abreviatura->abtDescripcion}}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoUltimoGrado', 'Ultimo grado', array('class' => '')); !!}
                      <input type="text" name="escoUltimoGrado" id="escoUltimoGrado" value="{{$escolaridad->escoUltimoGrado == 'S' ? 'SI' : 'NO'}}" readonly>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoGraduado', 'Graduado *', array('class' => '')); !!}
                      <select id="escoGraduado" class="browser-default validate select2" required name="escoGraduado" style="width: 100%;">
                          <option value="S" @if($escolaridad->escoGraduado == "S") {{ 'selected' }} @endif >SI</option>
                          <option value="N" @if($escolaridad->escoGraduado == "N") {{ 'selected' }} @endif>NO</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoTipoDocumento', 'Tipo documento *', array('class' => '')); !!}
                      <select id="escoTipoDocumento" class="browser-default validate select2" required name="escoTipoDocumento" style="width: 100%;">
                          <option value="T" @if($escolaridad->escoTipoDocumento == "T") {{ 'selected' }} @endif >TITULO</option>
                          <option value="C" @if($escolaridad->escoTipoDocumento == "C") {{ 'selected' }} @endif>CEDULA</option>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('escoFolio', $escolaridad->escoFolio, array('id' => 'escoFolio', 'class' => 'validate','maxlength' => '10')) !!}
                      {!! Form::label('escoFolio', 'Folio escolaridad', ['class' => '']); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('escoFechaDocumento', 'Fecha de documento *', array('class' => '',)); !!}
                      {!! Form::date('escoFechaDocumento', $escolaridad->escoFechaDocumento, array('id' => 'escoFechaDocumento', 'class' => 'validate','required')) !!}
                  </div>
                </div>
                <div class="row">
                  <div class="col s12">
                      <div class="input-field">
                      {!! Form::text('escoObservaciones', $escolaridad->escoObservaciones, array('id' => 'escoObservaciones', 'class' => 'validate','maxlength' => '255')) !!}
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
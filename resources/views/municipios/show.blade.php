@extends('layouts.dashboard')

@section('template_title')
    Municipio
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('municipios')}}" class="breadcrumb">Lista de municipios</a>
    <label class="breadcrumb">Ver Municipio</label>
@endsection

@section('content')

@php
  $estado = $municipio->estado;
  $pais = $estado->pais;
@endphp

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">MUNICIPIO #{{$municipio->municipio_id}}</span>

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
                      <label for="pais_id">Pais*</label>
                      <select class="browser-default validate select2" id="pais_id" name="pais_id" style="width:100%;" required>
                        <option value="pais_id">{{$pais->paisNombre}}</option>
                      </select>
                    </div>
                    <div class="col s12 m6 l4">
                      <label for="estado_id">Estado*</label>
                      <select class="browser-default validate select2" id="estado_id" name="estado_id" style="width:100%;" required>
                        <option value="{{$estado->id}}">{{$estado->edoNombre}}</option>
                      </select>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('munNombre', $municipio->munNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('munNombre', 'Nombre del Municipio', array('class' => '')); !!}
                        </div>
                    </div>
                    
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

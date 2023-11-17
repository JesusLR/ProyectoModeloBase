@extends('layouts.dashboard')

@section('template_title')
    Paises
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('paises')}}" class="breadcrumb">Lista de paises</a>
    <label class="breadcrumb">Agregar Pais</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'paises.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PAIS</span>

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
                    
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('paisNombre', NULL, array('id' => 'paisNombre', 'class' => 'validate','required','maxlenght'=>'50')) !!}
                            {!! Form::label('paisNombre', 'Nombre del Pais', array('class' => '')); !!}
                        </div>
                    </div>
            
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('paisAbrevia', NULL, array('id' => 'paisAbrevia', 'class' => 'validate','required','maxlenght'=>'5')) !!}
                            {!! Form::label('paisAbrevia', 'Nombre del Pais abreviado', array('class' => '')); !!}
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
@include('scripts.preferencias')
@include('scripts.departamentos')
@include('scripts.escuelas')

@endsection
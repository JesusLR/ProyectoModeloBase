@extends('layouts.dashboard')

@section('template_title')
    Concepto de titulación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_titulacion')}}" class="breadcrumb">Lista de conceptos de titulación</a>
    <label class="breadcrumb">Agregar Concepto de titulación</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'concepto_titulacion.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CONCEPTO DE TITULACIÓN</span>

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
                      <div class="input-field">
                        {!! Form::text('contClave', $ultimoConceptoTitulacion->contClave+1, array('id' => 'contClave','required','readonly')) !!}
                        {!! Form::label('contClave', 'Clave del Concepto titulacion', array('class' => '')); !!}
                    </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('contNombre', NULL, array('id' => 'contNombre', 'class' => 'validate','required','maxlenght'=>'50')) !!}
                            {!! Form::label('contNombre', 'Nombre del Concepto de titulacion*', array('class' => '')); !!}
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
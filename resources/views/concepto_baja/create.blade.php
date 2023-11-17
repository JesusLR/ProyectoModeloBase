@extends('layouts.dashboard')

@section('template_title')
    Conceptos de baja
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_baja')}}" class="breadcrumb">Lista de conceptos de baja</a>
    <label class="breadcrumb">Agregar Concepto de baja</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'concepto_baja.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CONCEPTO DE BAJA</span>

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
                        {!! Form::text('conbClave', $ultimoConceptoBaja->conbClave+1, array('id' => 'conbClave','required','readonly')) !!}
                        {!! Form::label('conbClave', 'Clave del Concepto Baja*', array('class' => '')); !!}
                    </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conbNombre', NULL, array('id' => 'conbNombre', 'class' => 'validate','required','maxlenght'=>'50')) !!}
                            {!! Form::label('conbNombre', 'Nombre del Concepto Baja', array('class' => '')); !!}
                        </div>
                    </div>
            
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conbAbreviatura', NULL, array('id' => 'conbAbreviatura', 'class' => 'validate','maxlenght'=>'15')) !!}
                            {!! Form::label('conbAbreviatura', 'Nombre abreviado', array('class' => '')); !!}
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
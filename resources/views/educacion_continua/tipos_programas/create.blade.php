@extends('layouts.dashboard')

@section('template_title')
    Tipo Programa edu. continua
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('tiposProgEduContinua')}}" class="breadcrumb">Tipo Programa</a>
    <label class="breadcrumb">Agregar Tipo Programa</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tiposProgEduContinua.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR TIPO PROGRAMA</span>

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
                    {!! Form::text('tpAbreviatura', NULL, array('id' => 'tpAbreviatura', 'class' => 'validate','required')) !!}
                    {!! Form::label('tpAbreviatura', 'Abreviatura *', []); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('tpNombre', NULL, array('id' => 'tpNombre', 'class' => 'validate','required')) !!}
                    {!! Form::label('tpNombre', 'Nombre *', []); !!}
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
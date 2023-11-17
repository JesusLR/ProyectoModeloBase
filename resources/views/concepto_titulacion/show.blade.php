@extends('layouts.dashboard')

@section('template_title')
    Concepto de titulación
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_titulacion')}}" class="breadcrumb">Lista de conceptos de titulación</a>
    <label class="breadcrumb">Ver concepto de titulación</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CONCEPTO DE TITULACIÓN #{{$conceptoTitulacion->id}}</span>

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
                            {!! Form::text('contClave', $conceptoTitulacion->contClave, array('readonly' => 'true')) !!}
                            {!! Form::label('contClave', 'Clave del Concepto titulacion', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('contNombre', $conceptoTitulacion->contNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('contNombre', 'Nombre del Concepto titulacion', array('class' => '')); !!}
                        </div>
                    </div>
            
                    
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

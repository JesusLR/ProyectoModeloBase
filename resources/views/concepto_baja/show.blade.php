@extends('layouts.dashboard')

@section('template_title')
    Conceptos de baja
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_baja')}}" class="breadcrumb">Lista de conceptos de baja</a>
    <label class="breadcrumb">Ver concepto de baja</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CONCEPTO DE BAJA #{{$conceptoBaja->id}}</span>

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
                            {!! Form::text('conbClave', $conceptoBaja->conbClave, array('readonly' => 'true')) !!}
                            {!! Form::label('conbClave', 'Clave del Concepto Baja*', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conbNombre', $conceptoBaja->conbNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('conbNombre', 'Nombre del Concepto Baja', array('class' => '')); !!}
                        </div>
                    </div>
            
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conbAbreviatura', $conceptoBaja->conbAbreviatura, array('readonly' => 'true')) !!}
                            {!! Form::label('conbAbreviatura', 'Nombre abreviado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@extends('layouts.dashboard')

@section('template_title')
    Abreviatura
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('abreviatura')}}" class="breadcrumb">Lista de abreviaturas</a>
    <label class="breadcrumb">Ver abreviatura</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ABREVIATURA #{{$abreviatura->id}}</span>

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
                            {!! Form::text('id', $abreviatura->id, array('readonly' => 'true')) !!}
                            {!! Form::label('id', 'Número', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('abtAbreviatura', $abreviatura->abtAbreviatura, array('readonly' => 'true')) !!}
                            {!! Form::label('abtAbreviatura', 'Nombre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('abtDescripcion', $abreviatura->abtDescripcion, array('readonly' => 'true')) !!}
                            {!! Form::label('abtDescripcion', 'Descripción', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
  </div>

@endsection

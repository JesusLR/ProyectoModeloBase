@extends('layouts.dashboard')

@section('template_title')
    Abreviatura
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('abreviatura')}}" class="breadcrumb">Lista de abreviaturas</a>
    <label class="breadcrumb">Editar abreviatura</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
            {{ Form::open(array('method'=>'PUT','route' => ['abreviatura.update', $abreviatura->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR ABREVIATURA #{{$abreviatura->id}}</span>

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
                        {!! Form::text('abtAbreviatura', $abreviatura->abtAbreviatura, array('id' => 'abtAbreviatura', 'class' => 'validate','required','readonly','maxlength'=>'10')) !!}
                        {!! Form::label('abtAbreviatura', 'Nombre *', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                        {!! Form::text('abtDescripcion', $abreviatura->abtDescripcion, array('id' => 'abtDescripcion', 'class' => 'validate','required','maxlength'=>'50')) !!}
                        {!! Form::label('abtDescripcion', 'Nombre *', ['class' => '']); !!}
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
@extends('layouts.dashboard')

@section('template_title')
    Aula
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('aula')}}" class="breadcrumb">Lista de aulas</a>
    <label class="breadcrumb">Ver aula</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AULA #{{$aula->id}}</span>

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
                            {!! Form::text('ubiClave', $aula->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('aulaClave', $aula->aulaClave, array('readonly' => 'true')) !!}
                        {!! Form::label('aulaClave', 'Clave', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('aulaCupo', $aula->aulaCupo, array('readonly' => 'true')) !!}
                        {!! Form::label('aulaCupo', 'Cupo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('aulaDescripcion', $aula->aulaDescripcion, ['readonly' => 'true']) !!}
                        {!! Form::label('aulaDescripcion', 'Descripción', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('aulaUbicacion', $aula->aulaUbicacion, array('readonly' => 'true')) !!}
                        {!! Form::label('aulaUbicacion', 'Ubicación', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('aulaEdificio', $aula->aulaEdificio, array('readonly' => 'true')) !!}
                        {!! Form::label('aulaEdificio', 'Edificio', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection

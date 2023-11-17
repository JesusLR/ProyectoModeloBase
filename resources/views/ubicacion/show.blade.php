@extends('layouts.dashboard')

@section('template_title')
    Ubicación
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('ubicacion')}}" class="breadcrumb">Lista de Ubicaciones</a>
    <label class="breadcrumb">Ver ubicacion</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">UBICACIÓN #{{$ubicacion->id}}</span>

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
                            {!! Form::text('ubiClave', $ubicacion->ubiClave, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Clave', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiNombre', $ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiNombre', 'Nombre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiCalle', $ubicacion->ubiCalle, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiCalle', 'Calle', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('ubiCP', $ubicacion->ubiCP, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiCP', 'Código Postal', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('estado_id', $ubicacion->municipio->estado->edoNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('estado_id', 'Estado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('municipio_id', $ubicacion->municipio->munNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('municipio_id', 'Municipio', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
  </div>

@endsection

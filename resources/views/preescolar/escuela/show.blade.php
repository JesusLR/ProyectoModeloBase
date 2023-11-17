@extends('layouts.dashboard')

@section('template_title')
    Escuela
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_escuela')}}" class="breadcrumb">Lista de escuelas</a>
    <label class="breadcrumb">Ver escuela</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ESCUELA #{{$escuela->id}}</span>

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
                            {!! Form::text('ubicacion_id', $escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubicacion_id', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id', $escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empleado_id', $escuela->empleado->persona->perNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_id', 'Director', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', $escuela->escClave, array('readonly' => 'true')) !!}
                            {!! Form::label('escClave', 'Clave escuela', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombre', $escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escNombre', 'Nombre escuela', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombreCorto', $escuela->escNombreCorto, array('readonly' => 'true')) !!}
                            {!! Form::label('escNombreCorto', 'Nombre corto (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('escPorcExaPar', $escuela->escPorcExaPar, array('readonly' => 'true','min'=>'0')) !!}
                            {!! Form::label('escPorcExaPar', '% Exa Parciales', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('escPorcExaOrd', $escuela->escPorcExaOrd, array('readonly' => 'true','min'=>'0')) !!}
                            {!! Form::label('escPorcExaOrd', '% Exa Ordinario', array('class' => '')); !!}
                        </div>
                    </div>
                </div>


          </div>
        </div>
    </div>
  </div>

@endsection

@extends('layouts.dashboard')

@section('template_title')
    Optativa
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('optativa')}}" class="breadcrumb">Lista de optativas</a>
    <label class="breadcrumb">Ver optativa</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">OPTATIVA #{{$optativa->id}}</span>

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
                            {!! Form::text('ubiClave', $optativa->materia->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id', $optativa->materia->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $optativa->materia->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('programa_id', $optativa->materia->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $optativa->materia->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 ">
                        <div class="input-field">
                            {!! Form::text('materia_id', $optativa->materia->matNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('materia_id', 'Materia optativa', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('optNumero', $optativa->optNumero, array('readonly' => 'true')) !!}
                            {!! Form::label('optNumero', 'Número de Optativa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m8">
                        <div class="input-field">
                            {!! Form::text('optNombre', $optativa->optNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('optNombre', 'Nombre optativa', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('optClaveGenerica', $optativa->optClaveGenerica, array('readonly' => 'true')) !!}
                            {!! Form::label('optClaveGenerica', 'Clave genérica', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('optClaveEspecifica', $optativa->optClaveEspecifica, array('readonly' => 'true')) !!}
                            {!! Form::label('optClaveEspecifica', 'Clave específica', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

          </div>
        </div>
    </div>
  </div>

@endsection

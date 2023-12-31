@extends('layouts.dashboard')

@section('template_title')
    Acuerdo
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('acuerdo')}}" class="breadcrumb">Lista de acuerdos</a>
    <label class="breadcrumb">Editar acuerdo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['acuerdo.update', $acuerdo->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR ACUERDO #{{$acuerdo->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$acuerdo->plan->programa->escuela->departamento->ubicacion_id}}" selected >{{$acuerdo->plan->programa->escuela->departamento->ubicacion->ubiClave}}-{{$acuerdo->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$acuerdo->plan->programa->escuela->departamento_id}}" selected >{{$acuerdo->plan->programa->escuela->departamento->depClave}}-{{$acuerdo->plan->programa->escuela->departamento->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$acuerdo->plan->programa->escuela_id}}" selected >{{$acuerdo->plan->programa->escuela->escClave}}-{{$acuerdo->plan->programa->escuela->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$acuerdo->plan->programa_id}}" selected >{{$acuerdo->plan->programa->progClave}}-{{$acuerdo->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$acuerdo->plan_id}}" selected >{{$acuerdo->plan->planClave}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('acuEstadoPlan', 'Estado del Programa *', array('class' => '')); !!}
                        <select id="acuEstadoPlan" class="browser-default validate select2" required name="acuEstadoPlan" style="width: 100%;">
                            <option value="N" @if($acuerdo->acuEstadoPlan == "N") {{ 'selected' }} @endif>NUEVO</option>
                            <option value="L" @if($acuerdo->acuEstadoPlan == "L") {{ 'selected' }} @endif>LIQUIDACIÓN</option>
                            <option value="C" @if($acuerdo->acuEstadoPlan == "C") {{ 'selected' }} @endif>CERRADO</option>
                            <option value="X" @if($acuerdo->acuEstadoPlan == "X") {{ 'selected' }} @endif>EXTRAOFICIAL</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('acuNumero', $acuerdo->acuNumero, array('id' => 'acuNumero', 'class' => 'validate','required','maxlength'=>'10')) !!}
                            {!! Form::label('acuNumero', 'Número de Acuerdo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('', 'Fecha del Acuerdo *', array('class' => '')); !!}
                        {!! Form::date('acuFecha', $acuerdo->acuFecha, array('class' => 'validate','required')) !!}
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
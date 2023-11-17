@extends('layouts.dashboard')

@section('template_title')
    Matricula Anterior
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('matricula_anterior')}}" class="breadcrumb">Lista de matriculas</a>
    <label class="breadcrumb">Ver matricula anterior</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">MATRICULA ANTERIOR #{{$matricula->id}}</span>

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
                            {!! Form::text('alumno_id', $matricula->alumno->persona->perNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('alumno_id', 'Alumno', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matricNueva', $matricula->matricNueva, array('readonly' => 'true')) !!}
                            {!! Form::label('matricNueva', 'Matricula actual', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matricAnterior', $matricula->matricAnterior, array('readonly' => 'true')) !!}
                            {!! Form::label('matricAnterior', 'Matricula anterior', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('programa_id', NULL, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('usuario_at', $matricula->usuario->empleado->persona->perNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('usuario_at', 'Usuario', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('updated_at', $matricula->updated_at, array('readonly' => 'true')) !!}
                            {!! Form::label('updated_at', 'Fecha', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
  </div>

@endsection


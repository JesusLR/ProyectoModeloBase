@extends('layouts.dashboard')

@section('template_title')
    Profesión
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('profesion')}}" class="breadcrumb">Lista de profesiones</a>
    <label class="breadcrumb">Ver profesión</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">PROFESIÓN #{{$profesion->id}}</span>

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
                            {!! Form::text('id', $profesion->id, array('readonly' => 'true')) !!}
                            {!! Form::label('id', 'Número', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('profNombre', $profesion->profNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('profNombre', 'Nombre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('profNivel', nivel_profesion($profesion->profNivel), array('readonly' => 'true')) !!}
                            {!! Form::label('profNivel', 'Nivel', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
  </div>

@endsection

@php
    function nivel_profesion($valor){
        switch ($valor) {
            case 'L':
                return 'LICENCIATURA';
                break;
            case 'E':
                return 'ESPECIALIDAD';
                break;
            case 'M':
                return 'MAESTRIA';
                break;
            case 'D':
                return 'DOCTORADO';
                break;
            default:
                return 'NINGUNO';
        }
    }
@endphp


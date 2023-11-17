@extends('layouts.dashboard')

@section('template_title')
    Clave de profesor
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('clave_profesor')}}" class="breadcrumb">Lista de claves de profesores</a>
    <label class="breadcrumb">Ver clave de profesor</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CLAVE DE PROFESOR #{{$claveProfesor->id}}</span>

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
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('ubicacion_id', $claveProfesor->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubicacion_id', 'Ubicación', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('empleado_id', $claveProfesor->empleado->persona->perNombre.' '.$claveProfesor->empleado->persona->perApellido1.' '.$claveProfesor->empleado->persona->perApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_id', 'Profesor', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                        {!! Form::text('cpClaveSegey', $claveProfesor->cpClaveSegey, array('readonly' => 'true')) !!}
                        {!! Form::label('cpClaveSegey', 'Clave profesor', ['class' => '']); !!}
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


@extends('layouts.dashboard')

@section('template_title')
    Puestos
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('puestos')}}" class="breadcrumb">Lista de puestos</a>
    <label class="breadcrumb">Editar puesto</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['puestos.update', $puesto->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR PUESTO #{{$puesto->id}}</span>

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
                            <input type="text" name="puesNombre" id="puesNombre" value="{{old('puesNombre') ?: $puesto->puesNombre}}" class="validate noUpperCase" required>
                            <label for="puesNombre">Nombre del puesto*</label>
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
@extends('layouts.dashboard')

@section('template_title')
    Cambiar contraseña de docente
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('cambiar_contrasena')}}" class="breadcrumb">Lista de docentes</a>
    <a href="{{url('cambiar_contrasena/'.$docente->id)}}" class="breadcrumb">Ver Docente</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Docente clave #{{$docente->empleado->id}}</span>

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


                @php
                    $persona = $docente->empleado->persona;
                @endphp

                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('perNombre', 'Nombre', array('class'=>'')) !!}
                        <input type="text" name="perNombre" id="perNombre" value="{{$persona->perNombre}}" maxlength="100" class="validate" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('perApellido1', 'Apellido paterno', array('class'=>'')) !!}
                        <input type="text" name="perApellido1" id="perApellido1" value="{{$persona->perApellido1}}" maxlength="200" class="validate" readonly>
                    </div>
                    @if($persona->perApellido2)
                        <div class="col s12 m6 l4">
                            {!! Form::label('perApellido2', 'Apellido materno', array('class'=>'')) !!}
                            <input type="text" name="perApellido2" id="perApellido2" value="{{$persona->perApellido2}}" maxlength="200" class="validate" readonly>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="perCorreo1">Correo</label>
                        <input type="text" name="perCorreo1" id="perCorreo1" value="{{$persona->perCorreo1}}" class="validate" readonly>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection

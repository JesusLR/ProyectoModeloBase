@extends('layouts.dashboard')

@section('template_title')
    Clave SEGEY
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('clave_profesor')}}" class="breadcrumb">Lista de claves SEGEY</a>
    <label class="breadcrumb">Editar clave SEGEY</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
            {{ Form::open(array('method'=>'PUT','route' => ['clave_profesor.update', $claveProfesor->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR CLAVE SEGEY #{{$claveProfesor->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$claveProfesor->ubicacion_id}}">{{$claveProfesor->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        {!! Form::label('empleado_id', 'Profesor *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="{{$claveProfesor->empleado_id}}">
                              {{$claveProfesor->empleado->persona->perNombre}}
                              {{$claveProfesor->empleado->persona->perApellido1}}
                              {{$claveProfesor->empleado->persona->perApellido2}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                        {!! Form::number('cpClaveSegey', $claveProfesor->cpClaveSegey, array('id' => 'cpClaveSegey', 'class' => 'validate','required','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                        {!! Form::label('cpClaveSegey', 'Clave profesor *', ['class' => '']); !!}
                        </div>
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

@section('footer_scripts')

@endsection
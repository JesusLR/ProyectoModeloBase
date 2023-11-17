@extends('layouts.dashboard')

@section('template_title')
  Clave SEGEY
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('clave_profesor')}}" class="breadcrumb">Lista de claves SEGEY</a>
    <label class="breadcrumb">Agregar clave SEGEY</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'clave_profesor.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CLAVE SEGEY</span>

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
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m4">
                      {!! Form::label('empleado_id', 'Profesor *', array('class' => '')); !!}
                      <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($empleados as $empleado)
                            <option value="{{$empleado->id}}">
                              {{$empleado->id . " " . $empleado->persona->perNombre . " " . $empleado->persona->perApellido1 . " " . $empleado->persona->perApellido2}}
                            </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m4">
                      <div class="input-field">
                      {!! Form::number('cpClaveSegey', NULL, array('id' => 'cpClaveSegey', 'class' => 'validate','required','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
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
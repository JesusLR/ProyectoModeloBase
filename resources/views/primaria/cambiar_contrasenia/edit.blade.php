@extends('layouts.dashboard')

@section('template_title')
  Primaria acceso de docente
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('primaria_cambiar_contrasenia')}}" class="breadcrumb">Lista Docentes</a>
    <a href="{{url('primaria_cambiar_contrasenia/'.$docente->id.'/edit')}}" class="breadcrumb">Editar Contraseña</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_cambiar_contrasenia.update', $docente->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Docente clave #{{$empleado->id}}</span>

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
                    <label for="empleado_id">Empleado *</label>
                    <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                      <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="{{$empleado->id}}">{{$empleado->id}}-{{$empleado->empNombre}} {{$empleado->empApellido1}} {{$empleado->empApellido2}}</option>
                
                    </select>
                  </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="perCorreo1">Correo</label>
                        <input type="text" name="perCorreo1" id="perCorreo1" value="{{$empleado->empCorreo1}}" class="validate" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="validate noUpperCase"> 
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="confirmPassword">Confirmar contraseña</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" class="validate noUpperCase">
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
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
@endsection
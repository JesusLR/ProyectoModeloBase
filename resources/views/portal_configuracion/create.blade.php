@extends('layouts.dashboard')

@section('template_title')
Portal Configuración
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('portal-configuracion')}}" class="breadcrumb">Lista de Portal Configuración</a>
    <a href="{{url('portal-configuracion/create')}}" class="breadcrumb">Agregar Portal Configuración</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'portal-configuracion.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PORTAL CONFIGURACIÓN</span>

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
                <div class="input-field col s6">
                  {!! Form::text('pcClave', NULL, array('id' => 'pcClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('pcClave', 'Clave *', array('class' => '')); !!}
                </div>
                <div class=" col s6">
                  {!! Form::label('pcPortal', 'Estado', array('class' => '')); !!}
                  <select id="pcPortal" class="browser-default validate select2" required name="pcPortal" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="A">Alumno</option>
                      <option value="D">Docente</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  {!! Form::text('pcDescripcion', NULL, array('id' => 'pcDescripcion', 'class' => 'validate')) !!}
                  {!! Form::label('pcDescripcion', 'Descripcion *', array('class' => '')); !!}
                </div>
                <div class=" col s6">
                  {!! Form::label('pcEstado', 'Estado', array('class' => '')); !!}
                  <select id="pcEstado" class="browser-default validate select2" required name="pcEstado" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="A">Activo</option>
                      <option value="I">Inactivo</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect light-blue darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection

@section('footer_scripts')
  @include('scripts.preferencias')
  @include('scripts.departamentos')
  @include('scripts.escuelas')
  @include('scripts.programas')

  <script>
    $(document).ready(function() {
        $('input:radio').change(function() {
              if($(this).is(":checked")) {
                  var clase = $(this).val();
                  var array = clase.split("-");
                  var modulo = array[0];
                  var permiso = array[1];
                  $("." + modulo).each(function(){
                    $(this).val(permiso);
                  });
              }
          });
      });
  </script>
@endsection
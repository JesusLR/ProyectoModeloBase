@extends('layouts.dashboard')

@section('template_title')
    Usuario
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('usuario')}}" class="breadcrumb">Lista de usuarios</a>
    <a href="{{url('usuario/'.$user->id)}}" class="breadcrumb">Ver usuario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
          <span class="card-title">USUARIO #{{$user->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#modulos">Permiso Modulos</a></li>
                  <li class="tab"><a href="#acceso">Permiso Carreras</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
              <div class="row">
                <div class="input-field col col s12 m6 l4">
                    {!! Form::text('username', $user->username, array('readonly' => 'true')) !!}
                    {!! Form::label('username', 'Usuario'); !!}
                </div>
                <div class="input-field col col s12 m8">
                    {!! Form::text('empleado_id', $user->empleado->persona->perNombre." ".$user->empleado->persona->perApellido1." ".$user->empleado->persona->perApellido2, array('readonly' => 'true')) !!}
                    {!! Form::label('empleado_id', 'Empleado'); !!}
                  </div>
              </div>
            </div>
            {{-- MODULOS BAR--}}
            <div id="modulos" style="padding-bottom:20px">
              <br>
                <ul >
                    @foreach($permissions_module_user as $permission_module_user)
                      <li>{{$permission_module_user->module->name}} - {{$permission_module_user->permission->description}}</li>
                    @endforeach
                </ul>
            </div>
            {{-- ACCESO BAR--}}
            <div id="acceso">
                <br>
                <ul >
                    @foreach($permiso_programa_user as $permiso)
                      <li>{{$permiso->programa->progNombre}}</li>
                    @endforeach
                </ul>
            </div>

          </div>
        </div>
    </div>
  </div>
@endsection


@section('footer_scripts')

  @include('scripts.departamentos')
  @include('scripts.escuelas')
  @include('scripts.programas')

  <script>
    $(document).ready(function() {
        $('input:checkbox').change(function() {
              if($(this).is(":checked")) {
                  var clase = $(this).val();
                  $("." + clase).each(function(){
                    $(this).val("3");
                  });
              }else{
                  var clase = $(this).val();
                  $("." + clase).each(function(){
                      var valor = $(this).val();
                      $(this).val("4");
                  });
              }
          });
      });
  </script>
@endsection
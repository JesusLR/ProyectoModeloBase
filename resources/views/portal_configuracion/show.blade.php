@extends('layouts.dashboard')

@section('template_title')
Portal Configuración
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('portal-configuracion')}}" class="breadcrumb">Lista de Portal Configuración</a>
    <a href="{{url('portal-configuracion/'.$portalConfiguracion->id)}}" class="breadcrumb">Ver Portal Configuración</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
          <span class="card-title">PORTAL CONFIGURACIÓN #{{$portalConfiguracion->id}}</span>

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
                    {!! Form::text('pcClave', $portalConfiguracion->pcClave, array('readonly' => 'true')) !!}
                    {!! Form::label('pcClave', 'Clave'); !!}
                </div>
                <div class="input-field col s6">
                    {!! Form::text('pcPortal', $portalConfiguracion->pcPortal, array('readonly' => 'true')) !!}
                    {!! Form::label('pcPortal', 'Portal'); !!}
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                    {!! Form::text('pcDescripcion', $portalConfiguracion->pcDescripcion, array('readonly' => 'true')) !!}
                    {!! Form::label('pcDescripcion', 'Clave'); !!}
                </div>
                <div class="input-field col s6">
                    {!! Form::text('pcEstado', $portalConfiguracion->pcEstado, array('readonly' => 'true')) !!}
                    {!! Form::label('pcEstado', 'Estado'); !!}
                </div>
              </div>
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
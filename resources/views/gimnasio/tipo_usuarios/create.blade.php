@extends('layouts.dashboard')

@section('template_title')
    Gimnasio tipo usuario
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('gimnasio_tipo_usuario')}}" class="breadcrumb">Lista de usuarios del gimnasio</a>
    <a href="{{url('gimnasio_tipo_usuario/create')}}" class="breadcrumb">Agregar usuario de gimnasio</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'gimnasio.gimnasio_tipo_usuario.store', 'method' => 'POST', 'id' => 'form_usuagim']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR TIPO DE USUARIO DE GIMNASIO</span>

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
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="tugClave" id="tugClave" class="validate" maxLength="3" value="{{old('tugClave')}}" required>
                            <label for="tugClave">Clave</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="tugDescripcion" id="tugDescripcion" class="validate" value="{{old('tugDescripcion')}}" >
                            <label for="tugDescripcion">Descripción</label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="text" name="tugImporte" id="tugImporte" class="validate" value="{{old('tugImporte')}}" required>
                            <label for="tugImporte">Importe</label>
                        </div>
                    </div>
                </div>
                
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' => 'btn-large waves-effect  darken-3', 'type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}


@endsection

@section('footer_scripts')

<script type="text/javascript">
    $(document).ready(function() {
        //
    });
</script>

@endsection
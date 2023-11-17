@extends('layouts.dashboard')

@section('template_title')
    Gimnasio
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('gimnasio_usuario')}}" class="breadcrumb">Lista de Usuarios de gimnasio</a>
    <a href="{{url('gimnasio_usuario/'.$tipo->id.'/edit')}}" class="breadcrumb">Editar tipo usuario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['gimnasio.gimnasio_tipo_usuario.update', $tipo->id], 'id' => 'form_usuagim')) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Usuario #{{$tipo->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#pagos">Pagos</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <br>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="tugClave" id="tugClave" value="{{$tipo->tugClave}}" class="validate" required>
                            <label for="tugClave">Clave</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="tugDescripcion" id="tugDescripcion" value="{{$tipo->tugDescripcion}}" class="validate" required>
                            <label for="tugDescripcion">Descripción</label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="text" name="tugImporte" id="tugImporte" value="{{$tipo->tugImporte}}" class="validate" required>
                            <label for="tugImporte">Importe</label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                      <label for="tugVigente">Vigente</label>
                      <select name="tugVigente" id="tugVigente" class="browser-default validate select2" style="width:100%;" required>
                          <option value="S" @if($tipo->tugVigente == 'S') selected @endif>S</option>
                          <option value="N" @if($tipo->tugVigente == 'N') selected @endif>N</option>
                        </select>
                        
                    </div>
                </div>
                
            </div>



          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3', 'id'=>'btn-guardar', 'type'=>'submit']) !!}
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
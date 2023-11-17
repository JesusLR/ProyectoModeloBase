@extends('layouts.dashboard')

@section('template_title')
    Prefecteos
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('prefecteo')}}" class="breadcrumb">Lista de Prefecteos</a>
    <a href="{{url('prefecteo/create')}}" class="breadcrumb">Agregar Prefecteo</a>
@endsection

@section('content')

    @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
    @endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'prefecteo.store', 'method' => 'POST']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PREFECTEO</span>

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
                      <label for="ubicacion_id">Ubicación*</label>
                      <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                          @foreach($ubicaciones as $ubicacion)
                              <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="departamento_id">Departamento*</label>
                      <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="periodo_id">Periodo*</label>
                      <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 14">
                      <div class="input-field">
                        <p style="text-align:center;">Fecha de revisión</p>
                        {!! Form::date('prefFecha', $fechaActual, array('id' => 'prefFecha', 'class' => 'validate', 'required')) !!}
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
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        if(ubicacion_id) {
            ubicacion.val(ubicacion_id).select2();
            getDepartamentos(ubicacion_id);
        }

        ubicacion.on('change', function() {
            this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            this.value ? getPeriodos(this.value) : resetSelect('periodo_id');
        });

    });

</script>

@endsection
@extends('layouts.dashboard')

@section('template_title')
    Responsable de registro / Certificación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('registro')}}" class="breadcrumb">Lista de Responsables de registro</a>
    <a href="{{url('registro/create')}}" class="breadcrumb">Agregar Responsable</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'registro.store', 'method' => 'POST']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR RESPONSABLE</span>

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
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                @endphp

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @if($ubicacion->id == $ubicacion_id)
                                    <option value="{{$ubicacion->id}}" selected>{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>;
                                @else
                                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>;
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('regFechaInicioVigencia', 'Fecha Inicio Vigencia', array('class'=>'')) !!}
                        <input type="date" name="regFechaInicioVigencia" id="regFechaInicioVigencia" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('regNombreResponsable', 'Nombre', array('class'=>'')) !!}
                        <input type="text" name="regNombreResponsable" id="regNombreResponsable" value="" required maxlength="100" class="validate">
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('regCargoResponsable', 'Cargo', array('class'=>'')) !!}
                        <input type="text" name="regCargoResponsable" id="regCargoResponsable" value="" maxlength="200" class="validate">
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

        var ubicacion_id = $('#ubicacion_id').val();
        getDepartamentos(ubicacion_id, 'departamento_id');

        $('#ubicacion_id').on('change', function() {
            var ubicacion_id = $(this).val();
            ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
        });

    });

    


</script>

@endsection
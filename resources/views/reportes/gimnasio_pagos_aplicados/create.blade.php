@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Gimnasio - Pagos Aplicados</a>
@endsection

@section('content')

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/gimnasio_pagos_aplicados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Usuarios - Pagos Aplicados</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="filtros">

            <div class="row">
              <div class="col s12 m6 l6">
                <label for="gimTipo">Tipo de Usuario*</label>
                <select name="gimTipo" id="gimTipo" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @foreach($tipos as $tipo)
                    <option value="{{$tipo->tugClave}}">{{$tipo->tugClave}} - {{$tipo->tugDescripcion}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('usuariogim_id', NULL, array('id' => 'usuariogim_id', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('usuariogim_id', 'Numero de Usuario', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('gimApellidoPaterno', NULL, array('id' => 'gimApellidoPaterno', 'class' => 'validate')) !!}
                  {!! Form::label('gimApellidoPaterno', 'Apellido Paterno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('gimApellidoMaterno', NULL, array('id' => 'gimApellidoMaterno', 'class' => 'validate')) !!}
                  {!! Form::label('gimApellidoMaterno', 'Apellido Materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('gimNombre', NULL, array('id' => 'gimNombre', 'class' => 'validate')) !!}
                  {!! Form::label('gimNombre', 'Nombre', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l6">
                <p class="center-align">Fechas:</p>
                <div class=" col s12 m6 l6">
                  <label for="fecha1">Desde:</label>
                  <input type="date" name="fecha1" id="fecha1" class="validate" value="{{old('fecha1')}}" required>
                </div>
                <div class=" col s12 m6 l6">
                  <label for="fecha2">Hasta:</label>
                  <input type="date" name="fecha2" id="fecha2" class="validate" value="{{old('fecha2')}}" required>
                </div>
              </div>
            </div>
          
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
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

        var gimTipo = {!! json_encode(old('gimTipo')) !!};
        gimTipo && $('#gimTipo').val(gimTipo).select2();
        
    });
</script>

@endsection
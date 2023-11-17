@extends('layouts.dashboard')

@section('template_title')
Reportes
@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Programación de exámenes recuperativos</a>
@endsection

@section('content')

@php
$ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' =>
    'bachiller.programacion_examenes.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">PROGRAMACIÓN DE EXÁMENES RECUPERATIVOS</span>
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
            <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('inscritos', 'Incluir alumnos inscritos', ['class' => '']); !!}
              <select name="inscritos" id="inscritos" data-inscritos="{{old('inscritos') ?: 't'}}"
                class="browser-default validate select2" style="width: 100%;">
                <option value="si">Sí</option>
                <option value="no">No</option>
                <option value="t">Ambos</option>
              </select>
            </div>
            <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('regular', 'Solicitudes de regularización', ['class' => '']); !!}
              <select name="regular" id="regular" data-regular="{{old('regular') ?: 't'}}"
                class="browser-default validate select2" style="width: 100%;">
                <option value="T">Todas</option>
                <option value="P">Pagadas</option>
                <option value="N">No pagadas</option>
              </select>
            </div>

            <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('extTipo', 'Tipo recuperativo *', array('class' => '')); !!}
              <select id="extTipo" data-extTipo-id="{{old('extTipo')}}" class="browser-default validate select2"
                name="extTipo" style="width: 100%;">
                <option value="" {{ old('extTipo')=="" ? "selected" : "" }}>Todas</option>
                <option value="ACOMPAÑAMIENTO" {{ old('extTipo')=="ACOMPAÑAMIENTO" ? "selected" : "" }}>Acompañamiento
                </option>
                <option value="RECURSAMIENTO" {{ old('extTipo')=="RECURSAMIENTO" ? "selected" : "" }}>Recursamiento
                </option>

              </select>
            </div>

          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <label for="ubicacion_id">Ubicación *</label>
              <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
                @foreach($ubicaciones as $ubicacion)
                @php
                $selected = '';

                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'
                </option>';
                } else {
                if ($ubicacion->id == old("ubicacion_id")) {
                $selected = 'selected';
                }

                echo '<option value="'.$ubicacion->id.'" '. $selected .'>
                  '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                }
                @endphp
                @endforeach
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="departamento_id">Departamento *</label>
              <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="escuela_id">Escuela *</label>
              <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}"
                class="browser-default validate select2" style="width:100%;">
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <label for="periodo_id">Periodo *</label>
              <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="programa_id">Programa *</label>
              <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}"
                class="browser-default validate select2" style="width:100%;">
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="plan_id">Plan *</label>
              <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}"
                class="browser-default validate select2" style="width:100%;">
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::number('examenId', NULL, array('id' => 'examenId', 'class' => 'validate')) !!}
                {!! Form::label('examenId', 'Clave del examen', array('class' => '')); !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('extGrupo', NULL, array('id' => 'extGrupo', 'class' => 'validate')) !!}
                {!! Form::label('extGrupo', 'Clave del grupo', array('class' => '')); !!}
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('extFecha', 'Fecha en formato AAAA-MM-DD. Ej: 1999-12-24 ', array('class' => '')); !!}
              {!! Form::date('extFecha', NULL, array('id' => 'extFecha', 'class' => 'validate', "")) !!}
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('extHora', 'Hora en formato HH:mm:ss Ej: 19:00:00 ', array('class' => '')); !!}
              {!! Form::time('extHora', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
            </div>

          </div>
          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('aulaClave', NULL, array('id' => 'aulaClave', 'class' => 'validate')) !!}
                {!! Form::label('aulaClave', 'Lugar del examen', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::number('empleado_sinodal_id', NULL, array('id' => 'empleado_sinodal_id', 'class' =>
                'validate')) !!}
                {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('extPago', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                {!! Form::label('extPago', 'Costo del examen', array('class' => '')); !!}
              </div>
            </div>
          </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large
          waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>



  @endsection



  @section('footer_scripts')
  {{-- Script de funciones auxiliares --}}
  @include('bachiller.scripts.preferencias')
  @include('bachiller.scripts.departamentos')
  @include('bachiller.scripts.escuelas_todos')
  @include('bachiller.scripts.programas')
  @include('bachiller.scripts.planes-espesificos')

  @endsection
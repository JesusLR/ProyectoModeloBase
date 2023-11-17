@extends('layouts.dashboard')

@section('template_title')
Reportes
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Relación de Inscritos a recuperativos</a>
@endsection

@section('content')

@php
$ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' =>
    'bachiller.bachiller_relacion_inscritos_extraordinario.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">RELACIÓN DE INSCRITOS A RECUPERATIVOS</span>
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
            <div class="col s12 m6 l4">
              {!! Form::label('tipoReporte', 'Vista de reporte *', array('class' => '')); !!}
              <select id="tipoReporte" data-tipoReporte-id="{{old('tipoReporte')}}"
                class="browser-default validate select2" required name="tipoReporte" style="width: 100%;">
                <option value="1" {{ old('tipoReporte') == "1" ? "selected" : ""}}>EXCEL</option>
                <option value="2" {{ old('tipoReporte') == "2" ? "selected" : ""}}>PDF</option>
              </select>
            </div>


            <div class="col s12 m6 l4">
              {!! Form::label('iexEstado', 'Solicitudes de regularización *', array('class' => '')); !!}
              <select id="iexEstado" data-iexEstado-id="{{old('iexEstado')}}"
                class="browser-default validate select2"  name="iexEstado" style="width: 100%;">
                <option value="" {{ old('iexEstado') == "" ? "selected" : ""}}>Todas</option>
                <option value="P" {{ old('iexEstado') == "P" ? "selected" : ""}}>Pagadas</option>
                <option value="N" {{ old('iexEstado') == "N" ? "selected" : ""}}>No pagadas</option>

              </select>
            </div>


            <div class="col s12 m6 l4">
              {!! Form::label('extTipo', 'Tipo recuperativo *', array('class' => '')); !!}
              <select id="extTipo" data-extTipo-id="{{old('extTipo')}}"
                class="browser-default validate select2"  name="extTipo" style="width: 100%;">
                <option value="" {{ old('extTipo') == "" ? "selected" : ""}}>Todas</option>
                <option value="ACOMPAÑAMIENTO" {{ old('extTipo') == "ACOMPAÑAMIENTO" ? "selected" : ""}}>Acompañamiento</option>
                <option value="RECURSAMIENTO" {{ old('extTipo') == "RECURSAMIENTO" ? "selected" : ""}}>Recursamiento</option>

              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
              <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
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
              {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
              <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}"
                class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
              <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}"
                class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
              <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2"
                required name="periodo_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
              <select id="programa_id" data-programa-id="{{old('programa_id')}}"
                class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
              <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2"
                required name="plan_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('folio', old('folio'), array('id' => 'folio', 'class' => 'validate')) !!}
                {!! Form::label('folio', 'Folio recuperativo', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('matClave', old('matClave'), array('id' => 'matClave', 'class' => 'validate')) !!}
                {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <label for="extFecha">Fecha Examen</label>
              <input type="date" name="extFecha" id="extFecha" value="{{old('extFecha')}}">
            </div>
          </div>

        </div>
      </div>

      <div class="card-action">
        {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large
        waves-effect darken-3','type' => 'submit']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection

@section('footer_scripts')

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_todos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')


@endsection
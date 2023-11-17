@extends('layouts.dashboard')

@section('template_title')
    Archivos SEP
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('archivo/extraordinario')}}" class="breadcrumb">Generar archivo extraordinario</a>
@endsection

@section('content')

@php
    $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'archivo/extraordinario/descargar', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">GENERAR ARCHIVO EXTRAORDINARIO</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" name="ubicacion_id" style="width: 100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" style="width: 100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela (opcional)', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" style="width: 100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tipo', 'Tipo *', array('class' => '')); !!}
                        <select id="tipo" class="browser-default validate select2" name="tipo" style="width: 100%;" required>
                            @foreach($tipos as $key => $value)
                                <option value="{{$key}}" @if(old('tipo') == $key) {{ 'selected' }} @endif>{{$key}}){{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="oportunidad">Oportunidad</label>
                        <select class="browser-default validate select2" data-oportunidad-id="{{old('oportunidad')}}" id="oportunidad" name="oportunidad" style="width:100%;">
                            @foreach($oportunidades AS $oportunidad)
                                <option value="{{ $oportunidad }}" @if(old('oportunidad') == $oportunidad) {{ 'selected' }} @endif>{{ $oportunidad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="tipo_acreditacion_div" class="col s12 m6 l4">
                        {!! Form::label('tipo_acreditacion', 'Tipo de acreditación', array('class' => '')); !!}
                        <select id="tipo_acreditacion" class="browser-default validate select2" name="tipo_acreditacion" style="width: 100%;">
                            <option value="T"  @if(old('tipo_acreditacion') == 'T') {{ 'selected' }} @endif>Todos</option>
                            <option value="A"  @if(old('tipo_acreditacion') == 'A') {{ 'selected' }} @endif>Alfabetica</option>
                            <option value="N"  @if(old('tipo_acreditacion') == 'N') {{ 'selected' }} @endif>Numerica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tipo_registro', 'Tipo de registro *', array('class' => '')); !!}
                        <select id="tipo_registro" class="browser-default validate select2" required name="tipo_registro" style="width: 100%;">
                            <option value="E">ESTATAL</option>
                            <option value="F">FEDERAL</option>
                        </select>
                    </div>
                </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">note_add</i> GENERAR ARCHIVOS', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection


@section('footer_scripts')

{{-- @include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.periodos') --}}
<script type="text/javascript">
    $(document).ready(function() {
        let ubicacion = $('#ubicacion_id');
        let departamento = $('#departamento_id');
        let periodo = $('#periodo_id');
        let tipo = $('#tipo');

        apply_data_to_select('ubicacion_id', 'ubicacion-id');

        tipo.val() == 'C' ? $('#tipo_acreditacion_div').show() : $('#tipo_acreditacion_div').hide();

        ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
        ubicacion.on('change', function() {
            this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            if(this.value) {
                getPeriodos(this.value);
                getEscuelas(this.value);
            } else {
                resetSelect('periodo_id');
                resetSelect('escuela_id');
            }
        });

        periodo.on('change', function() {
            this.value ? periodo_fechasInicioFin(this.value) : emptyElements(['perFechaInicial', 'perFechaFinal']);
        })

        tipo.on('change', function() {
            this.value == 'C' ? $('#tipo_acreditacion_div').show() : $('#tipo_acreditacion_div').hide();
        });

    });
</script>

@endsection
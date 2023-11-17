@extends('layouts.dashboard')

@section('template_title')
    Archivos SEP
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('archivo/ordinario')}}" class="breadcrumb">Generar archivo ordinario</a>
@endsection

@section('content')

@php
    $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'archivo/ordinario/descargar', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">GENERAR ARCHIVO ORDINARIO</span>

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
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
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
                        <label for="escuela_id">Escuela</label>
                        <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" id="escuela_id" name="escuela_id" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="programa_id">Programa</label>
                        <select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" id="programa_id" name="programa_id" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('tipo_registro', 'Tipo de registro *', array('class' => '')); !!}
                        <select id="tipo_registro" class="browser-default validate select2" required name="tipo_registro" style="width: 100%;">
                            <option value="E">ESTATAL</option>
                            <option value="F">FEDERAL</option>
                        </select>
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
                    <div id="tipo_acreditacion_div" class="col s12 m6 l4">
                        {!! Form::label('tipo_acreditacion', 'Tipo de acreditación', array('class' => '')); !!}
                        <select id="tipo_acreditacion" class="browser-default validate select2" name="tipo_acreditacion" style="width: 100%;">
                            <option value="T"  @if(old('tipo_acreditacion') == 'T') {{ 'selected' }} @endif>Todos</option>
                            <option value="A"  @if(old('tipo_acreditacion') == 'A') {{ 'selected' }} @endif>Alfabetica</option>
                            <option value="N"  @if(old('tipo_acreditacion') == 'N') {{ 'selected' }} @endif>Numerica</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field" id="chunk_div">
                            <input type="number" name="chunk" id="chunk" value="{{old('chunk')}}">
                            <label for="chunk">Cantidad por archivo</label>
                        </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        let ubicacion = $('#ubicacion_id');
        let departamento = $('#departamento_id');
        let periodo = $('#periodo_id');
        let escuela = $('#escuela_id');
        let tipo = $('#tipo');

        apply_data_to_select('ubicacion_id', 'ubicacion-id');

        tipo.val() == 'I' ? $('#chunk_div').show() : $('#chunk_div').hide();
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

        escuela.on('change', function() {
            this.value ? getProgramas(this.value) : resetSelect('programa_id');
        });

        periodo.on('change', function() {
            this.value ? periodo_fechasInicioFin(this.value) : emptyElements(['perFechaInicial', 'perFechaFinal']);
        });

        tipo.on('change', function() {
            this.value == 'I' ? $('#chunk_div').show() : $('#chunk_div').hide();
            this.value == 'C' ? $('#tipo_acreditacion_div').show() : $('#tipo_acreditacion_div').hide();
        });
    });
</script>
@endsection
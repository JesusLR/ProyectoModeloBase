@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Pagos Completos</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_pagos_completos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Pagos Completos</span>
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
                  <label for="ubicacion_id">Ubicacion*</label>
                  <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" name="ubicacion_id" id="ubicacion_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" id="departamento_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <div class="col s12 m6 l6">
                    <label for="perAnioPago">Año escolar*</label>
                    <select class="browser-default validate select2" data-anio-pago="{{old('perAnioPago')}}" name="perAnioPago" id="perAnioPago" style="width:100%;" required>
                      @for($i = $anio; $i > ($anio - 10); $i--)
                        <option value="{{$i}}">{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                  <div class="col s12 m6 l6">
                    <label for="perEstado">Tipos de periodo*</label>
                    <select class="browser-default validate select2" data-per-estado="{{old('perEstado')}}" name="perEstado" id="perEstado" style="width:100%;" required>
                      <option value="S">Semestral</option>
                      <option value="C">Cuatrimestral</option>
                      <option value="A">Anual</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela</label>
                  <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="programa_id">Programa</label>
                  <select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" name="programa_id" id="programa_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="cgtGradoSemestre">Grado</label>
                  <select class="browser-default validate select2" data-cgt-grado="{{old('cgtGradoSemestre')}}" name="cgtGradoSemestre" id="cgtGradoSemestre" style="width:100%;">
                    <option value="">Todos</option>
                    @for($s = 1; $s < 15; $s++)
                      <option value="{{$s}}">{{$s}}</option>
                    @endfor
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="pagImpPago" id="pagImpPago" class="validate">
                    <label for="pagImpPago">Pagos con importe mayor o igual a:</label>
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

<script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let ubicacion = $('#ubicacion_id');
    let departamento = $('#departamento_id');
    let escuela = $('#escuela_id');

    apply_data_to_select('ubicacion_id', 'ubicacion-id');
    apply_data_to_select('perAnioPago', 'anio-pago');
    apply_data_to_select('perEstado', 'per-estado');
    apply_data_to_select('cgtGradoSemestre', 'cgt-grado');

    ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
    ubicacion.on('change', function() {
      this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
    });

    departamento.on('change', function() {
      if(this.value) {
        getEscuelas(this.value);
      } else {
        resetSelect('escuela_id');
      }
    });

    escuela.on('change', function() {
      this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

  });
</script>
@endsection

@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Conteo de Empleados</a>
@endsection

@section('content')
@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/conteo_empleados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Conteo de Empleados</span>
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
                  <label for="ubicacion_id">Ubicación*</label>
                  <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" id="ubicacion_id" name="ubicacion_id" style="width: 100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" id="departamento_id" name="departamento_id" style="width: 100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo*</label>
                  <select class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" id="periodo_id" name="periodo_id" style="width: 100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela</label>
                  <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" id="escuela_id" name="escuela_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
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

      apply_data_to_select('ubicacion_id', 'ubicacion-id');

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
      })
    });
  </script>
@endsection

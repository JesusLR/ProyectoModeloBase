@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de inscritos</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_resumen_inscritos.imprimir', 'method' => 'GET']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">RESUMEN DE INSCRITOS</span>
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
                {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '',]); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" required style="width: 100%;" required>
                  <option value="I" selected>Inscritos</option>
                  <option value="P">Preinscritos y condicionados</option>
                </select>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="ubicacion_id">Ubicación *</label>
                  <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento *</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela *</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>              
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo *</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="card-action">
              {!! Form::button('<i class="material-icons left ">keyboard_arrow_down</i> GENERAR EXCEL', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
            </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
</div>
</div>

  {{-- Script de funciones auxiliares  --}}
  {{--
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  --}}

@endsection


@section('footer_scripts')

@include('bachiller.scripts.funcionesAuxiliares')

<script type="text/javascript">
    $(document).ready(function() {
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        var escuela = $('#escuela_id');

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        if(ubicacion_id) {
            ubicacion.val(ubicacion_id).select2();
            getDepartamentos(ubicacion_id);
        }

        ubicacion.on('change', function() {
            this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            if(this.value) {
                getPeriodosTodos(this.value);
                getEscuelas(this.value);
            } else {
                resetSelect('periodo_id');
                resetSelect('escuela_id');
            }
        });

        escuela.on('change', function() {
            this.value ? getProgramas(this.value) : resetSelect('programa_id');
        });

    });
</script>

@endsection

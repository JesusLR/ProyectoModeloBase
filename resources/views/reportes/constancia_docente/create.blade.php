@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Constancia Docente</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/constancia_docente/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Constancia Docente</span>
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
                <label for="tipo_reporte">Tipo de reporte</label>
                <select name="tipo_reporte" id="tipo_reporte" data-tipo-reporte="{{old('tipo_reporte')}}" class="browser-default validate select2" style="width:100%;">
                  <option value="">Por periodo y escuela</option>
                  <option value="P">Por periodo</option>
                  <option value="PH">Por periodo (Historial docentes)</option>
                  <option value="E">Por escuela</option>
                  <option value="D">Por docente</option>
                </select>
              </div>
            </div>

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
                  <label for="periodo_id">Periodo <span id="span_periodo"></span></label>
                  <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela <span id="span_escuela"></span></label>
                  <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa <span id="span_escuela"></span></label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  <input type="number" name="empleado_id" id="empleado_id" class="validate" min="0" value="{{old('empleado_id')}}">
                  <label for="empleado_id">No. de empleado <span id="span_empleado"></span></label>
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
        let tipo_reporte = $('#tipo_reporte')
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        let escuela = $('#escuela_id');

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        if(ubicacion_id) {
            ubicacion.val(ubicacion_id).select2();
            getDepartamentos(ubicacion_id);
        }

        apply_data_to_select('tipo_reporte', 'tipo-reporte');

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

        actualizar_campos_requeridos(tipo_reporte.value);
        tipo_reporte.on('change', function() {
          actualizar_campos_requeridos(this.value);
        });
        
        function actualizar_campos_requeridos(tipo) {
          if(tipo == 'E') {
            applyRequired(['escuela_id']);
            unsetRequired(['periodo_id', 'empleado_id']);
            $('#span_escuela').html('*');
            $('#span_periodo').html('');
            $('#span_empleado').html('');
          } else if(tipo == 'P' || tipo == 'PH') {
            applyRequired(['periodo_id']);
            unsetRequired(['escuela_id', 'empleado_id']);
            $('#span_escuela').html('');
            $('#span_periodo').html('*');
            $('#span_empleado').html('');
          } else if(tipo == 'D') {
            applyRequired(['empleado_id']);
            unsetRequired(['periodo_id', 'escuela_id']);
            $('#span_escuela').html('');
            $('#span_periodo').html('');
            $('#span_empleado').html('*');
          } else {
            applyRequired(['periodo_id', 'escuela_id']);
            unsetRequired(['empleado_id']);
            $('#span_escuela').html('*');
            $('#span_periodo').html('*');
            $('#span_empleado').html('');
          }
        }
    });

</script>

@endsection
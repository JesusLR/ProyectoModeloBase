@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Movimiento de Becas</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/movimiento_becas/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Movimiento de Becas</span>
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
                  <label for="periodo_id">Periodo*</label>
                  <select class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" id="periodo_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
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
                  <label for="plan_id">Plan</label>
                  <select class="browser-default validate select2" data-plan-id="{{old('plan_id')}}" name="plan_id" id="plan_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    <input type="number" name="semestre" id="semestre" value="{{old('semestre')}}" class="validate">
                    <label for="semestre">Grado</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input type="text" name="grupo" id="grupo" value="{{old('grupo')}}" class="validate">
                    <label for="grupo">Grupo</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="aluClave" id="aluClave" value="{{old('aluClave')}}" class="validate">
                    <label for="aluClave">Clave de pago</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <p class="center-align">Fecha de cambio:</p>
                  <div class="col s12 m6 l6">
                    <label for="fecha1">Desde:</label>
                    <input type="date" name="fecha1" id="fecha1" value="{{old('fecha1')}}" max="{{$hoy}}" class="validate">
                  </div>
                  <div class="col s12 m6 l6">
                    <label for="fecha2">Hasta:</label>
                    <input type="date" name="fecha2" id="fecha2" value="{{old('fecha2')}}" max="{{$hoy}}" class="validate">
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
    let programa = $('#programa_id');

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
    });

    escuela.on('change', function() {
      this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

    programa.on('change', function() {
      this.value ? getPlanes(this.value) : resetSelect('plan_id');
    });

  });
</script>
@endsection

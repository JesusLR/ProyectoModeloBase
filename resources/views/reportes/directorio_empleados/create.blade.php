@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Directorio de Empleados</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/directorio_empleados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Directorio de Empleados</span>
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
                  <label for="departamento_id">Departamento</label>
                  <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" id="departamento_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela</label>
                  <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="puesto_id">Puesto</label>
                  <select class="browser-default validate select2" data-puesto-id="{{old('puesto_id')}}" name="puesto_id" id="puesto_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($puestos as $puesto)
                      <option value="{{$puesto->id}}">{{$puesto->puesNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="empleado_id" id="empleado_id" class="validate" value="{{old('empleado_id')}}">
                    <label for="empleado_id">No. Empleado</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    <input type="text" name="perApellido1" id="perApellido1" class="validate" value="{{old('perApellido1')}}">
                    <label for="perApellido1">Apellido paterno</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input type="text" name="perApellido2" id="perApellido2" class="validate" value="{{old('perApellido2')}}">
                    <label for="perApellido2">Apellido materno</label>
                  </div>
                </div>
                <div class="col ss12 m6 l4">
                  <div class="input-field">
                    <input type="text" name="perNombre" id="perNombre" class="validate" value="{{old('perNombre')}}">
                    <label for="perNombre">Nombre</label>
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

    apply_data_to_select('ubicacion_id', 'ubicacion-id');
    apply_data_to_select('puesto_id', 'puesto-id');

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

  });
</script>
@endsection

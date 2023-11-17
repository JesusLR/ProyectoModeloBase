@extends('layouts.dashboard')

@section('template_title')
    Revalidaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('revalidaciones')}}" class="breadcrumb">Lista de alumnos</a>
    <label class="breadcrumb">Agregar Revalidación</label>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'revalidaciones.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR REVALIDACIÓN</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <div class="row">
                  <div class="col s12 m6 l4">
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="aluClave" id="aluClave" value="{{old('aluClave') ?: $alumno->aluClave}}" required class="validate">
                      <label for="aluClave">Clave de pago*</label>
                    </div>
                  </div>
                </div>

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
                      <label for="escuela_id">Escuela*</label>
                      <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                    </div>
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                    <label for="periodo_ingreso">Periodo ingreso*</label>
                    <select class="browser-default validate select2" data-periodo-ingreso="{{old('periodo_ingreso')}}" name="periodo_ingreso" id="periodo_ingreso" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="periodo_ultimo">Periodo último*</label>
                    <select class="browser-default validate select2" data-periodo-ultimo="{{old('periodo_ultimo')}}" name="periodo_ultimo" id="periodo_ultimo" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="periodo_egreso">Periodo egreso</label>
                    <select class="browser-default validate select2" data-periodo-egreso="{{old('periodo_egreso')}}" name="periodo_egreso" id="periodo_egreso" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>

                <div class="row"> 
                    <div class="col s12 m6 l4">
                      <label for="programa_id">Programa*</label>
                      <select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" name="programa_id" id="programa_id" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                    </div>
                    <div class="col s12 m6 l4">
                      <div class="col s12 m6 l6">
                        <label for="plan_id">Plan*</label>
                        <select class="browser-default validate select2" data-plan-id="{{old('plan_id')}}" name="plan_id" id="plan_id" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                      </div>
                      <div class="col s12 m6 l6">
                        <label for="resUltimoGrado">Ultimo grado*</label>
                        <select class="browser-default validate select2" data-ultimo-grado="{{old('resUltimoGrado')}}" name="resUltimoGrado" id="resUltimoGrado" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                      </div>
                    </div>
                </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
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
    let plan = $('#plan_id');

    apply_data_to_select('ubicacion_id', 'ubicacion-id');

    ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
    ubicacion.on('change', function() {
      this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
    });

    departamento.on('change', function() {
      if(this.value) {
        getEscuelas(this.value);
        getPeriodos(this.value, 'periodo_ingreso');
        getPeriodos(this.value, 'periodo_ultimo');
        getPeriodos(this.value, 'periodo_egreso');
      } else {
        resetSelect('escuela_id');
        resetSelect('periodo_ingreso');
        resetSelect('periodo_ultimo');
        resetSelect('periodo_egreso');
      }
    });

    escuela.on('change', function() {
      this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

    programa.on('change', function() {
      this.value ? getPlanes(this.value) : resetSelect('plan_id');
    });

    plan.on('change', function() {
      this.value ? getSemestres(this.value, 'resUltimoGrado') : resetSelect('resUltimoGrado');
    });

  });
</script>
@endsection
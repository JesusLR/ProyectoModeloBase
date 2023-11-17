@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Lista de asistencia por materia</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/grupo_materia/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">LISTA DE ASISTENCIA POR MATERIA</span>

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

                @php
                  $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                @endphp

                {{-- <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                            {!! Form::label('ubiClave', 'Clave de campus *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                            {!! Form::label('depClave', 'Clave departamento *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'6', "required")) !!}
                            {!! Form::label('perNumero', 'Número de periodo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0', "required")) !!}
                            {!! Form::label('perAnio', 'Año de periodo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                  <div class="col s12 m6 l4">
                    <label for="ubicacion_id">Ubicación*</label>
                    <select class="browser-default validate select2" name="ubicacion_id" id="ubicacion_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                        <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
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
                            {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('gpoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                            {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                            {!! Form::label('matClave', 'Clave de materia', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('empleado_id', NULL, array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
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
    var ubicacion = $('#ubicacion_id');
    var departamento = $('#departamento_id');
    var periodo = $('#periodo_id');
    var escuela = $('#escuela_id');
    var programa = $('#programa_id');
    var plan = $('#plan_id');

    var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
    if(ubicacion_id) {
      ubicacion.val(ubicacion_id).select2();
      getDepartamentos(ubicacion_id, 'departamento_id');
    }

    ubicacion.on('change', function() {
      this.value ? getDepartamentos(this.value, 'departamento_id') : resetSelect('departamento_id');
    });

    departamento.on('change', function() {
      if(this.value) {
        getPeriodos(this.value, 'periodo_id');
        getEscuelas(this.value, 'escuela_id');
      } else {
        resetSelect('periodo_id');
        resetSelect('escuela_id');
      }
    });

    escuela.on('change', function() {
      this.value ? getProgramas(this.value, 'programa_id') : resetSelect('programa_id');
    });

    programa.on('change', function() {
      this.value ? getPlanes(this.value, 'plan_id') : resetSelect('plan_id');
    });


  });
</script>
@endsection

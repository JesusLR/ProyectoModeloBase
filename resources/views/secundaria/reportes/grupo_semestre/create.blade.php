@extends('layouts.dashboard')

@section('template_title')
    Reporte rel. grupo materia
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación grupos materias </a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_grupo_semestre.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">RELACIÓN GRUPOS MATERIA</span>
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
                {!! Form::label('tipoReporte', 'Tipo Reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;" required>
                  {{--  <option value="">Seleccionar</option>  --}}
                  <option value="gradoMateria">Grado-Materia</option>
                  {{--  <option value="paquete">Paquete</option>  --}}
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div  class="tipo-grado-materia">
                  {!! Form::label('tipoGradoMateria', 'Tipo vista', ['class' => '']); !!}
                  <select name="tipoGradoMateria" id="tipoGradoMateria" class="browser-default validate select2" style="width: 100%;">
                    <option value="horarios">Horarios</option>
                    <option value="maestros">Maestros</option>
                  </select>
                </div>
              </div>
            </div>
            <hr>

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
                <label for="escuela_id">Escuela*</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>
            </div>

            
            <div class="row">
              
              <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo*</label>
                  <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'readonly')) !!}
                  {!! Form::label('perFechaInicial', 'Fecha Inicial', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal','readonly')) !!}
                  {!! Form::label('perFechaFinal', 'Fecha Final', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan*</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                  {!! Form::label('materia_id', 'Clave materia', array('class' => '')); !!}
                  <select name="materia_id" id="materia_id" data-materia-id="{{old('materia_id')}}" class="browser-default validate select2" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('gpoSemestre', 'Grado', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                  {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                <select name="empleado_id" id="empleado_id" class="browser-default validate select2" style="width: 100%;">
                  <option value="">Seleccionar maestro</option>
                  @foreach ($empleados as $empleado)
                    <option value="{{$empleado->id}}">
                      {{$empleado->id}} - {{$empleado->empNombre}}
                      {{$empleado->empApellido1}} {{$empleado->empApellido2}}  
                    </option>
                  @endforeach
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

  

@endsection


@section('footer_scripts')

{{-- Script de funciones auxiliares  --}}
@include('secundaria.scripts.funcionesAuxiliares')

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
            getDepartamentos(ubicacion_id);
        }

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

        plan.on('change', function() {
          this.value ? getMaterias(this.value) : resetSelect('materia_id');
        });

        periodo.val() && periodo_fechasInicioFin(periodo.val());
        periodo.on('change', function() {
          this.value ? periodo_fechasInicioFin(this.value) : emptyElements(['perFechaInicial', 'perFechaFinal'])
        });
        
    });
</script>

  @include('secundaria.scripts.grupo-semestre')
@endsection
@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Materias adeudadas por alumnos</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/materias_adeudadas_alumnos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Materias adeudadas por alumnos</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          @php
            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
          @endphp

          {{-- GENERAL BAR--}}
          <div id="filtros">

            <div class="row">
              <div class="col s12 m6 l4">
                <label for="formato">Formato del reporte*</label>
                <select name="formato" id="formato" class="validate browser-default select2" style="width:100%" required>
                  <option value="PDF">PDF</option>
                  <option value="Excel">Excel</option>
                </select>
              </div>              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                  {{-- <option value="">Seleccionar</option> --}}
                  <option value="A">MATERIAS POR ALUMNO</option>
                  <option value="M">ALUMNOS POR MATERIA</option>
                </select>
              </div>
              {{-- <div class="col s12 m6 l4">
                {!! Form::label('periodosIncluir', 'Periodos a incluir', ['class' => '']); !!}
                <select name="periodosIncluir" id="periodosIncluir" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONAR</option>
                  <option value="ACTUAL">INCLUIR ACTUAL</option>
                  <option value="SIGUIENTEACTUAL">INCLUIR SIGUIENTE AL ACTUAL</option>
                </select>
              </div> --}}

              <div class="col s12 m6 l4">
                {!! Form::label('resEstado', '¿Desea incluir alumnos dados de baja?', ['class' => '']); !!}
                <select name="resEstado" id="resEstado" class="browser-default validate select2" style="width: 100%;">
                  {{-- <option value="">Seleccionar</option> --}}
                  <option value="N">NO</option>
                  <option value="S">SI</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('incluirNoCursadas', '¿Desea incluir materias no  cursadas, o solo reprobados?', ['class' => '']); !!}
                  <select name="incluirNoCursadas" id="incluirNoCursadas" class="browser-default validate select2" style="width: 100%;">
                    {{-- <option value="">Seleccionar</option> --}}
                    <option value="N">SOLO REPROBADOS</option>
                    <option value="S">INCLUIR NO CURSADAS</option>
                  </select>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <label for="urgentes">Factor de riesgo</label>
                <select class="browser-default validate select2" name="urgentes" id="urgentes" style="width:100%;">
                  <option value="N">Sin filtro de factor de riesgo</option>
                  <option value="C">Cuatro o más reprobadas</option>
                  <option value="S">Más de un año de antigüedad</option>
                  <option value="A">Posible baja (Ambos factores)</option>
                </select>
              </div>
            </div>

            <hr>
            <br>
            <div class="row">
              <div class="col s12 m6 l4">
                <label for="ubicacion_id">Ubicacion*</label>
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
                <label for="escuela_id">Escuela*</label>
                <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">
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
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('resUltimoGrado', NULL, array('id' => 'resUltimoGrado', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('resUltimoGrado', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula alumno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s1s2 m6 l6">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                </div>
                <div class="input-field col s1s2 m6 l6">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l6">
                <p style="margin-bottom: -15px;">Poner clave de materia si quiere incluir una materia específica.</p>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave de materia', ['class' => '']); !!}

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
  {{-- @include('scripts.grupo-semestre') --}}
<script type="text/javascript">
  $(document).ready(function() {

    var ubicacion = $('#ubicacion_id');
    var departamento = $('#departamento_id');
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
      this.value ? getEscuelas(this.value) : resetSelect('escuela_id');
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

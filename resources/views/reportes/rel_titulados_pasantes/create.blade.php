@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Titulados y Pasantes</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/titulados_pasantes/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Titulados y Pasantes</span> 
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
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela*</label>
                  <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m12 l12">
              <p>(Para elegir <b>Período de Egreso</b> independiente de cuando se titularon)*</p>
              </div>
              <div class="col s12 m6 l4">
                  <select name="egrUltimoPeriodo" id="egrUltimoPeriodo" data-periodo-id="{{old('egrUltimoPeriodo')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m12 l12">
              <p>(Para elegir <b>Período de Titulación</b> independiente de cuando egresaron)*</p>
              </div>

              <div class="col s12 m6 l4">
                  <select name="egrPeriodoTitulacion" id="egrPeriodoTitulacion" data-periodo-id="{{old('egrPeriodoTitulacion')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('perSexo', 'Sexo', ['class' => '',]); !!}
                <select name="perSexo" id="perSexo" class="browser-default validate" style="width: 100%;">
                  <option value="">Ambos</option>
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
                </select>
              </div>
            </div>

          <div class="row">
            <div class="col s12 m6 l3">
              <br>
              {!! Form::label('egrOpcionTitulo', 'Concepto de Titulación', ['class' => '',]); !!}
              <select name="egrOpcionTitulo" id="egrOpcionTitulo" class="browser-default validate select2" style="width: 100%;">
                <option value="">Todos</option>
                @foreach ($conceptoTitulacion as $item)
              <option value="{{$item->id}}">{{$item->contNombre}}</option>
                @endforeach
              </select>
            </div>
            <div class="col s12 m6 l3">
              <br>
              {!! Form::label('pasantes', '¿Incluir pasantes?', ['class' => '',]); !!}
              <select name="pasantes" id="pasantes" class="browser-default validate select2" style="width: 100%;">
               <option value="si">Si</option>
               <option value="no">No</option>
              </select>
            </div>
            <div class="col s12 m6 l3">
              <div class="input-field">
                {!! Form::label('', 'Fecha Examen Profesional', array('class' => '')); !!}
                <br>
                {!! Form::date('egrFechaExamenProfesional', NULL, array('id' => 'egrFechaExamenProfesional', 'class' => 'validate')) !!}
              </div>
            </div>
            <div class="col s12 m6 l3">
              <div class="input-field">
                {!! Form::label('', 'Fecha Expedición Titulación', array('class' => '')); !!}
                <br>
                {!! Form::date('egrFechaExpedicionTitulo', NULL, array('id' => 'egrFechaExpedicionTitulo', 'class' => 'validate')) !!}
              </div>
            </div>
          </div>
      
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'id' => 'btn-reporte']) !!}
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

    /**
    * Para este reporte, la ubicacion y el departamento son obligatorios.
    * Necesitan especificar al menos un periodo, el de Egreso o el de Titulación.
    * Si no seleccionan algún periodo, deben especificar una carrera (programa).
    */

    var ubicacion = $('#ubicacion_id');
    var departamento = $('#departamento_id');
    var escuela = $('#escuela_id');
    var programa = $('#programa_id');

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
            getPeriodos(this.value, 'egrUltimoPeriodo');
            getPeriodos(this.value, 'egrPeriodoTitulacion');
            getEscuelas(this.value);
        } else {
            resetSelect('egrUltimoPeriodo');
            resetSelect('egrPeriodoTitulacion');
            resetSelect('escuela_id');
        }
    });

    escuela.on('change', function() {
        this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

    programa.on('change', function() {
        this.value ? getPlanes(this.value) : resetSelect('plan_id');
    });

    $('#btn-reporte').on('click', function() {

      if( $('#egrUltimoPeriodo').val() || $('#egrPeriodoTitulacion').val() || programa.val()) {
        $('form').submit();
      } else {
        show_validation_message();
      }

    });

  });



  function show_validation_message() {
    swal({
      type: 'warning',
      title: 'Parámetros requeridos',
      text: 'Necesita especificar al menos un período (Egreso ó Titulación). \n \n '+
      'Si no especifica ningún período, debe especificar un programa.'
    });
  }

</script>
@endsection
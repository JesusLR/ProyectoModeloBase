@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Tarjetas de pago de alumnos</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/tarjetas_pago_alumnos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Tarjetas de pago de alumnos ***</span>
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
              <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo*</label>
                  <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela*</label>
                  <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" >
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                <select id="plan_id" class="browser-default validate select2"  name="plan_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <label for="curEstado">Estado*</label>
                <select name="curEstado" id="curEstado" data-ubicacion-id="{{old('curEstado')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="T">Todos</option>
                      <option value="I">Inscritos</option>
                      <option value="R">Reingreso</option>
                      <option value="P">Preinscrito</option>
                      <option value="K">Condicionados</option>
                      <option value="C">Condicionado 1</option>
                      <option value="A">Condicionado 2</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGradoSemestre', 'Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 l4">
                {!! Form::label('curPlanPago', 'Plan de pago', array('class' => '')); !!}
                <select id="curPlanPago" class="browser-default validate select2" name="curPlanPago" style="width: 100%;">
                    <option value="">Todos</option>
                    <option value="A">Anticipo / crédito</option>
                    <option value="N">10 meses</option>
                    <option value="O">11 meses</option>
                    <option value="D">12 meses</option>
                </select>
              </div>

              <div class="col s12 l4">
                {!! Form::label('vigenciaBeca', 'Vigencia beca', array('class' => '')); !!}
                <select id="vigenciaBeca" class="browser-default validate select2" name="vigenciaBeca" style="width: 100%;">
                    <option value="" selected>Todos</option>
                    <option value="A">Anual</option>
                    <option value="S">Semestral</option>
                </select>
              </div>


              <div class="col s12 l4">
                {!! Form::label('bcaClave', 'Tipo de beca', array('class' => '')); !!}
                <select id="bcaClave" class="browser-default validate select2" name="bcaClave" style="width: 100%;">
                    <option value="" selected>Todos</option>
                    @foreach($becas as $beca)
                        <option value="{{$beca->bcaClave}}">{{$beca->bcaClave . " - " . $beca->bcaNombre}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('porcentajeBeca', NULL, array('id' => 'porcentajeBeca', 'class' => 'validate')) !!}
                  {!! Form::label('porcentajeBeca', 'Porcentaje de beca', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>

              <div class="col s12 l4">
                {!! Form::label('banco', 'Banco', array('class' => '')); !!}
                <select id="banco" class="browser-default validate select2" name="banco" style="width: 100%;">
                    <option value="BBVA">BBVA</option>
                    <option value="HSBC">HSBC</option>
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
<script type="text/javascript">

  $(document).ready(function() {
      // OBTENER PLANES
      $("#programa_id").change( event => {
          $("#plan_id").empty();


          $("#cgt_id").empty();
          $("#materia_id").empty();
          $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

          console.log("event.target.value")
          console.log(event.target.value)

          $.get(base_url+`/api/planes/${event.target.value}`,function(res,sta){
              //seleccionar el post preservado
              var planSeleccionadoOld = $("#plan_id").data("plan-idold")
              $("#plan_id").empty()
              $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

              res.forEach(element => {
                  var selected = "";
                  if (element.id === planSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#plan_id").append(`<option value=${element.id} ${selected}>${element.planClave}</option>`);
              });

              $('#plan_id').trigger('change'); // Notify only Select2 of changes
          });
      });

   });
</script>

@endsection

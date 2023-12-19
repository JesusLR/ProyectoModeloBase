@extends('layouts.dashboard')

@section('template_title')
Reporte
@endsection

@section('breadcrumbs')
<a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Resumen de calificaciones por grupo (campos formativos)</a>
@endsection

@section('content')

@php
$ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' =>
    'primaria.calificaciones_grupo_campos_formativos.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">RESUMEN DE CALIFICACIONES POR GRUPO (CAMPOS FORMATIVOS)</span>
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
              <label for="ubicacion_id">Ubicación *</label>
              <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @foreach($ubicaciones as $ubicacion)
                @php
                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                $selected = '';
                if($ubicacion->id == $ubicacion_id){
                $selected = 'selected';
                }
                @endphp
                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                @endforeach
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="departamento_id">Departamento *</label>
              <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="escuela_id">Escuela *</label>
              <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <label for="periodo_id">Periodo *</label>
              <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="programa_id">Programa</label>
              <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}"
                class="browser-default validate select2" style="width:100%;">
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="plan_id">Plan</label>
              <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}"
                class="browser-default validate select2" style="width:100%;">
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>            
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field col s12 m6 l6">
                {!! Form::number('gpoGrado', NULL, array('id' => 'gpoGrado', 'class' => 'validate','min'=>'0')) !!}
                {!! Form::label('gpoGrado', 'Grado', array('class' => '')); !!}
              </div>
              <div class="input-field col s12 m6 l6">
                {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
              </div>
            </div>
            
            
            <div id="vistaPorTrimestre" class="col s12 m6 l4">
              <label for="trimestreEvaluar">Trimestre a consultar *</label>
              <select required name="trimestreEvaluar" id="trimestreEvaluar"
                data-trimestreEvaluar-id="{{old('trimestreEvaluar')}}" class="browser-default validate select2"
                style="width:100%;">
                <option value="">SELECCIONE UNA OPCIÓN</option>
                <option value="1">TRIMESTRE 1</option>
                <option value="2">TRIMESTRE 2</option>
                <option value="3">TRIMESTRE 3</option>
              </select>
            </div>
          </div>

          
          {{-- <div class="row">
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
          </div> --}}

          {{-- <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field col s12 m6 l6">
                {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0'))
                !!}
                {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
              </div>
              <div class="input-field col s12 m6 l6">
                {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0'))
                !!}
                {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
              </div>
            </div>
          </div> --}}

        </div>
      </div>
      <div class="card-action">
        {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large
        waves-effect darken-3','type' => 'submit']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>



@endsection

@section('footer_scripts')

{{--  @include('primaria.scripts.preferencias')  --}}
@include('primaria.scripts.departamentos')

<script type="text/javascript">
  $(document).ready(function() {
      function obtenerEscuelas (departamentoId) {

          console.log(departamentoId)
          $("#escuela_id").empty();
          
          $("#periodo_id").empty();
          $("#programa_id").empty();
          $("#plan_id").empty();
          $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#programa_id").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
          $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          
          $("#perFechaInicial").val('');
          $("#perFechaFinal").val('');



          $.get(base_url+`/api/escuelas/${departamentoId}`,function(res,sta){

              //seleccionar el post preservado
              var escuelaSeleccionadoOld = $("#escuela_id").data("escuela-id")
              $("#escuela_id").empty()

              res.forEach(element => {
                  var selected = "";
                  if (element.id === escuelaSeleccionadoOld) {
                      selected = "selected";
                  }

                  $("#escuela_id").append(`<option value=${element.id} ${selected}>${element.escClave}-${element.escNombre}</option>`);
              });

              $('#escuela_id').trigger('change'); // Notify only Select2 of changes

          });

          //OBTENER PERIODOS
          $.get(base_url+`/primaria_periodo/todos/periodos/${departamentoId}`,function(res2,sta){
              var perSeleccionado;


              var periodoSeleccionadoOld = $("#periodo_id").data("periodo-id")

              console.log(periodoSeleccionadoOld)
              $("#periodo_id").empty()
              res2.forEach(element => {

                  var selected = "";
                  if (element.id === periodoSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#periodo_id").append(`<option value=${element.id} ${selected}>${element.perNumero}-${element.perAnio}</option>`);
              });
              //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
              $.get(base_url+`/primaria_periodo/api/periodo/${perSeleccionado}`,function(res3,sta){
                  $("#perFechaInicial").val(res3.perFechaInicial);
                  $("#perFechaFinal").val(res3.perFechaFinal);
                  Materialize.updateTextFields();
              });

              $('#periodo_id').trigger('change'); // Notify only Select2 of changes
          });//TERMINA PERIODO
      }


      $("#departamento_id").change( event => {
          obtenerEscuelas(event.target.value)
      });
   });
</script>

<script type="text/javascript">

  $(document).ready(function() {

      $("#escuela_id").change( event => {
          $("#programa_id").empty();

          $("#plan_id").empty();
          $("#programa_id").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
          $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

      
          $.get(base_url+`/api/primaria_programa/${event.target.value}`,function(res,sta){
              //seleccionar el post preservado
              var programaSeleccionadoOld = $("#programa_id").data("programa-id")

              res.forEach(element => {
                  var selected = "";
                  if (element.id === programaSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#programa_id").append(`<option value=${element.id} ${selected}>${element.progClave}-${element.progNombre}</option>`);
              });

              $('#programa_id').trigger('change'); // Notify only Select2 of changes
          });
      });

   });
</script>


<script type="text/javascript">

  $(document).ready(function() {
      // OBTENER PLANES
      $("#programa_id").change( event => {
          $("#plan_id").empty();

      
          $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

          console.log("event.target.value")
          console.log(event.target.value)
          
          $.get(base_url+`/primaria_plan/api/planes/${event.target.value}`,function(res,sta){
              //seleccionar el post preservado
              var planSeleccionadoOld = $("#plan_id").data("plan-id")
              
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

@include('primaria.scripts.periodos')



@endsection
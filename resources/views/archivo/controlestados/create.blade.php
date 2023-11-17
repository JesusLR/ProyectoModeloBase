@extends('layouts.dashboard')

@section('template_title')
    Control de estados
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('/archivo/control_estados')}}" class="breadcrumb">Control de estados</a>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'class' => 'submit','route' => 'controlestados.update', 'method' => 'POST']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">CONTROL DE ESTADOS</span>

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
            <br>
            <div class="row">
              <div class="col s12 m6 l4">
                  {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          @php
                          $ubicacion_id = $periodo->periodo->departamento->ubicacion->id;
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
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" departamento-idold="{{$periodo->periodo->departamento->id}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>


            <div class="row">
              <div class="col s12 m12 l12">
              <input type="checkbox" name="primeraFecha" id="primeraFecha" value="1" {{$primeraFecha ? "checked": ""}}  >
                <label for="primeraFecha">Primera Fecha</label>
              </div>
              <div class="col s12 m12 l12">
              <input type="checkbox" name="segundaFecha" id="segundaFecha" value="1" {{$segundaFecha ? "checked": ""}}>
                <label for="segundaFecha">Segunda Fecha</label>
              </div>
              <div class="col s12 m12 l12">
              <input type="checkbox" name="terceraFecha" id="terceraFecha" value="1" {{$terceraFecha ? "checked": ""}}>
                <label for="terceraFecha">Tercera Fecha</label>
              </div>
              <div class="col s12 m12 l12">
              <input type="checkbox" name="cuartaFecha" id="cuartaFecha" value="1" {{$cuartaFecha ? "checked": ""}}>
                <label for="cuartaFecha">Cuarta Fecha</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class=" material-icons left">save</i> Guardar', ['class' => ' btn-large waves-effect  darken-3','id'=>'btn-guardar']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {

      function obtenerDepartamentos(ubicacionId) {
          console.log(ubicacionId);

          console.log("aqui")
          $("#departamento_id").empty();


          $("#escuela_id").empty();
          $("#periodo_id").empty();
          $("#programa_id").empty();
          $("#plan_id").empty();
          $("#cgt_id").empty();
          $("#materia_id").empty();
          $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

          $("#perFechaInicial").val('');
          $("#perFechaFinal").val('');

          $.get(base_url+`/api/departamentos/${ubicacionId}`, function(res,sta) {

              //seleccionar el post preservado
              var departamentoSeleccionadoOld = "{{$periodo->periodo->departamento->id}}"
              $("#departamento_id").empty()
              res.forEach(element => {
                  var selected = "";
                  console.log("asd",departamentoSeleccionadoOld)
                  if (element.id == departamentoSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#departamento_id").append(`<option value=${element.id} ${selected}>${element.depClave}-${element.depNombre}</option>`);
              });
              $('#departamento_id').trigger('change'); // Notify only Select2 of changes
          });
      }
      
      obtenerDepartamentos($("#ubicacion_id").val())
      $("#ubicacion_id").change( event => {
          obtenerDepartamentos(event.target.value)
      });
   });
</script>

<script>

  $("#btn-guardar").on("click", function(e) {
    e.preventDefault();

    $(".submit").submit();

  })
  
  $("#departamento_id").change( event => {
        $("#periodo_id").empty();

        $.get(base_url+`/api/periodos/${event.target.value}`,function(res2,sta){
            var perSeleccionado;

            var periodo_id = "{{$periodo->periodo->id}}"
            var selected ="";
            res2.forEach(element => {
              if (element.id == periodo_id) {
                  console.log("entra periodo")
                  console.log(element.id, periodo_id)
                  selected = "selected"
              }

              $("#periodo_id").append(`<option value=${element.id} ${selected}>${element.perNumero}-${element.perAnio}</option>`);
              
              selected = "";

            });
            $('#periodo_id').trigger('change'); // Notify only Select2 of changes

            //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
            // $.get(base_url+`/api/periodo/${perSeleccionado}`,function(res3,sta){
            //     $("#perFechaInicial").val(res3.perFechaInicial);
            //     $("#perFechaFinal").val(res3.perFechaFinal);
            //     Materialize.updateTextFields();
            // });
      });//TERMINA PERIODO
  });

</script>
@endsection
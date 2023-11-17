@extends('layouts.dashboard')

@section('template_title')
    Reportes lista de asistencia
@endsection

@section('breadcrumbs')
  <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Lista de asistencia</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.lista_de_asistencia.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">LISTA DE ASISTENCIA</span>
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
                  {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                  <select id="ubicacion_id" class="browser-default validate select2" required
                      name="ubicacion_id" style="width: 100%;">
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
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required
                      name="departamento_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                  <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id"
                      style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
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
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan *</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
             
            </div>



            <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('matSemestre', 'Semestre *', array('class' => '')); !!}
                  <select id="matSemestre"
                      data-gposemestre-id="{{old('matSemestre')}}"
                      class="browser-default validate select2" required name="matSemestre" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        <input type="text" name="gpoGrupo" id="gpoGrupo" value="{{old('gpoGrupo')}}" maxlength="3">
                        <label for="gpoGrupo" id="gpoGrupo_label">Grupo</label>
                    </div>
                </div>

                <div class="col s12 m6 l4" style="display: none;">
                  <label for="tipoVista">Tipo de vista *</label>
                  <select name="tipoVista" id="tipoVista" data-periodo-id="{{old('tipoVista')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="listaVacia">LISTA VACÍA</option>
                      <option value="listaLlena">LISTA CON FECHAS</option>
                  </select>
                </div>

                <div class="col s12 m6 l4">
                  <label for="tipoVistaLista">Tipo de vista *</label>
                  <select name="tipoVistaLista" id="tipoVistaLista" data-periodo-id="{{old('tipoVistaLista')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="grupo-materia">ASISTENCIA POR GRUPO-MATERIA</option>
                      <option value="grupo">ASISTENCIA POR GRUPO</option>
                      <option value="docente">ASISTENCIA POR DOCENTE</option>

                  </select>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4" style="display: none;" id="materiaHidden">
                {!! Form::label('bachiller_materia_id', 'Materia', array('class' => '')); !!}
                <select id="bachiller_materia_id"
                    data-bachiller_materia_id-id="{{old('bachiller_materia_id')}}"
                    class="browser-default validate select2" name="bachiller_materia_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>

              <div class="col s12 m6 l4" id="bachiller_materiaACDHidden">
                {!! Form::label('bachiller_empleado', 'Materia complementaria', array('class' => '')); !!}
                <select id="bachiller_materia_acd_id" disabled
                    data-bachiller_materia_acd_id-id="{{old('bachiller_materia_acd_id')}}"
                    class="browser-default validate select2" name="bachiller_materia_acd_id" style="width: 100%;">
                </select>
              </div>

              <div class="col s12 m6 l4" id="bachiller_docente_div">
                <label for="bachiller_empleado" id="bachiller_empleado_label">Docente</label>
                <select id="bachiller_empleado" class="browser-default validate select2" name="bachiller_empleado" style="width: 100%;">
                  <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
                  @foreach ($bachiller_empleados as $bachiller_empleado)
                    <option value="{{$bachiller_empleado->id}}">{{$bachiller_empleado->id}} - {{$bachiller_empleado->empApellido1. ' '. $bachiller_empleado->empApellido2.' '.$bachiller_empleado->empNombre}}</option>                      
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row" style="display: none;" id="fechasBusqueda">
              <div class="col s12 m6 l4">
                {!! Form::label('fechaInicio', 'Fecha de inicio *', array('class' => '')); !!}
                {!! Form::date('fechaInicio', NULL, array('id' => 'fechaInicio', 'class' => 'validate')) !!}
              </div>

              <div class="col s12 m6 l4">
                {!! Form::label('fechaFin', 'Fecha final *', array('class' => '')); !!}
                {!! Form::date('fechaFin', NULL, array('id' => 'fechaFin', 'class' => 'validate')) !!}
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

{{--  @include('bachiller.scripts.funcionesAuxiliares')  --}}
@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')

@include('bachiller.reportes.resumen_de_evidencias.getMateria')
@include('bachiller.reportes.resumen_de_evidencias.getMateriaACD')
@include('bachiller.scripts.numeroSemestre')



<script>
  $("#tipoVista").change(function(){
    if($('select[id=tipoVista]').val() == "listaLlena"){
      $("#fechasBusqueda").show();   
      $('#fechaInicio').attr('required', 'required');
      $('#fechaFin').attr('required', 'required');

    }else{
      $("#fechasBusqueda").hide();
      $('#fechaInicio').removeAttr('required');
      $('#fechaFin').removeAttr('required');
    }
});
</script>


<script>
  $("#tipoVistaLista").change(function(){
    if($('select[id=tipoVistaLista]').val() == "grupo-materia"){    
      $("#materiaHidden").show();
      $("#bachiller_materiaACDHidden").show();
      $("#bachiller_empleado").prop('required', true);
      $("#bachiller_docente_div").hide();
      $("#gpoGrupo_label").html('Grupo *');
      $("#bachiller_empleado").val("").trigger("change");


    }
    
    if($('select[id=tipoVistaLista]').val() == "grupo"){    
      $("#materiaHidden").hide();
      $("#bachiller_materiaACDHidden").hide();
      $("#bachiller_empleado_label").html('Docente');
      $("#bachiller_empleado").prop('required', false);
      $("#bachiller_docente_div").hide();
      $("#gpoGrupo_label").html('Grupo');
      $("#bachiller_materia_id").prop('required', false);
      $("#bachiller_materia_id").val("").trigger("change");
      $("#bachiller_materia_acd_id").prop('required', false);
      $("#bachiller_materia_acd_id").val("").trigger("change");
      $("#bachiller_empleado").val("").trigger("change");
      $("#gpoGrupo").prop('required', false);

      

    }
    
    if($('select[id=tipoVistaLista]').val() == "docente"){    
      $("#materiaHidden").hide();
      $("#bachiller_materiaACDHidden").hide();
      $("#bachiller_empleado_label").html('Docente *');
      $("#bachiller_empleado").prop('required', true);
      $("#bachiller_docente_div").show();
      $("#gpoGrupo_label").html('Grupo');

      $("#bachiller_materia_id").prop('required', false);
      $("#bachiller_materia_id").val("").trigger("change");
      $("#bachiller_materia_acd_id").prop('required', false);
      $("#bachiller_materia_acd_id").val("").trigger("change");
    }
  });

  if($('select[id=tipoVistaLista]').val() == "grupo-materia"){    
    $("#materiaHidden").show();    
    $("#bachiller_materiaACDHidden").show();
    $("#bachiller_empleado_label").html('Docente');
    $("#bachiller_empleado").prop('required', false);
    $("#bachiller_docente_div").hide();
    $("#gpoGrupo_label").html('Grupo *');
  }
  
  if($('select[id=tipoVistaLista]').val() == "grupo"){    
    $("#materiaHidden").hide();    
    $("#bachiller_materiaACDHidden").hide();
    $("#bachiller_empleado_label").html('Docente');
    $("#bachiller_empleado").prop('required', false);
    $("#bachiller_docente_div").hide();
    $("#gpoGrupo_label").html('Grupo *');
  }

  if($('select[id=tipoVistaLista]').val() == "docente"){    
    $("#materiaHidden").hide();    
    $("#bachiller_materiaACDHidden").hide();
    $("#bachiller_empleado_label").html('Docente *');
    $("#bachiller_empleado").prop('required', true);
    $("#bachiller_docente_div").show();
    $("#gpoGrupo").prop('required', false);
    $("#gpoGrupo_label").html('Grupo');
  }
</script>

<script type="text/javascript">

  $(document).ready(function() {
     
      //Para que solo permita letras 
      $('#gpoGrupo').keypress(function (e) {
          var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
          return !((tecla > 47 && tecla < 58) || tecla == 46);
      });

    
   });
</script>
@endsection

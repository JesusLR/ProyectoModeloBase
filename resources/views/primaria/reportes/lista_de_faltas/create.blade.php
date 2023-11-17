@extends('layouts.dashboard')

@section('template_title')
    Reportes lista de asistencia
@endsection

@section('breadcrumbs')
  <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Lista de asistencia</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'primaria_reporte.lista_de_faltas.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">LISTA DE FALTAS</span>
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
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                        @php
                            $selected = '';

                            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                            if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                            } else {
                                if ($ubicacion->id == old("ubicacion_id")) {
                                    $selected = 'selected';
                                }

                                echo '<option value="'.$ubicacion->id.'" '. $selected .'>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                            }
                        @endphp
                    @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%; pointer-events: none" required>
                      {{--  <option value="">SELECCIONE UNA OPCIÓN</option>  --}}
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela*</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                </select>
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
                  <label for="plan_id">Plan *</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
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
                  {!! Form::label('numeroGrado', 'Grado *', array('class' => '')); !!}
                  <select name="numeroGrado" id="numeroGrado" data-numeroGrado-id="{{old('numeroGrado')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @for ($i = 1; $i < 7; $i++)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>                  
                </div>
                              

                <div class="col s12 m6 l4">
                  {!! Form::label('primaria_grupo_id_select', 'Grupo (Opcional para búsqueda de una solo asignatura)', array('class' => '')); !!}
                  <select name="primaria_grupo_id_select" id="primaria_grupo_id_select" data-primaria_grupo_id_select-id="{{old('primaria_grupo_id_select')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                   
                  </select>                  
                </div>

                <div class="col s12 m6 l4">
                  <label for="" id="tipoDeModalidadLabel">Tipo de modalidad *</label>
                  <select name="tipoDeModalidad" id="tipoDeModalidad" class="browser-default validate select2" style="width: 100%;" disabled>
                    <option value="">SELECCIONE UNA OPCION</option>
                    <option value="P">PRESENCIAL</option>
                    <option value="V">VIRTUAL</option>
                  </select>
                </div>
            </div>

            <div class="row" id="fechasBusqueda">
              <div class="col s12 m6 l4">
                {!! Form::label('fechaInicio', 'Fecha de inicio *', array('class' => '')); !!}
                {!! Form::date('fechaInicio', NULL, array('id' => 'fechaInicio', 'class' => 'validate', 'required')) !!}
              </div>

              <div class="col s12 m6 l4">
                {!! Form::label('fechaFin', 'Fecha final *', array('class' => '')); !!}
                {!! Form::date('fechaFin', NULL, array('id' => 'fechaFin', 'class' => 'validate', 'required')) !!}
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

@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.reportes.lista_de_faltas.getGruposGrado')

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
  $("#periodo_id").change(function(){
    if($('select[id=periodo_id]').val() >= "1942"){
      $("#tipoDeModalidad").prop('disabled', false);
      $("#tipoDeModalidad").prop('required', true);
      $("#tipoDeModalidadLabel").text('Modalidad *');
    }else{
      $("#tipoDeModalidad").val("").trigger( "change" );
      $("#tipoDeModalidad").prop('disabled', true);
      $("#tipoDeModalidad").prop('required', false);      
      $("#tipoDeModalidadLabel").text('Modalidad');      

    }
  });

  if($('select[id=periodo_id]').val() >= "1942"){
    $("#tipoDeModalidad").prop('disabled', false);
    $("#tipoDeModalidad").prop('required', true);
    $("#tipoDeModalidadLabel").text('Modalidad *');
  }else{
    $("#tipoDeModalidad").val("").trigger( "change" );
    $("#tipoDeModalidad").prop('disabled', true);
    $("#tipoDeModalidad").prop('required', false);      
    $("#tipoDeModalidadLabel").text('Modalidad');      

  }
</script>
@endsection

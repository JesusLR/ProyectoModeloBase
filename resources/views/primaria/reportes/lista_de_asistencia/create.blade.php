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
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'primaria_reporte.lista_de_asistencia.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Lista de asistencia</span>
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
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
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
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%; pointer-events: none" required>
                      {{--  <option value="">SELECCIONE UNA OPCIÓN</option>  --}}
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela *</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                </select>
              </div>
             
            </div>

            <div class="row">
              
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa *</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan *</label>
                  <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo *</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>



            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::number('gpoGrado', old('gpoGrado'), array('id' => 'gpoGrado', 'class' => 'validate','required', 'min' => '0', 'max'=>'6')) !!}
                        {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                    </div>
                </div>
                
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('gpoGrupo', old('gpoGrupo'), array('id' => 'gpoGrupo', 'class' => 'validate','required','maxlength'=>'5')) !!}
                        {!! Form::label('gpoGrupo', 'Grupo *', array('class' => '')); !!}
                    </div>
                </div>

                <div class="col s12 m6 l4">
                  <label for="tipoVista">Tipo de vista *</label>
                  <select name="tipoVista" id="tipoVista" data-periodo-id="{{old('tipoVista')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="listaVacia" {{ old('tipoVista') == 'listaVacia' ? 'selected' : '' }}>LISTA VACÍA</option>
                      <option value="listaLlena" {{ old('tipoVista') == 'listaLlena' ? 'selected' : '' }}>LISTA CON FECHAS</option>
                  </select>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4" style="margin-top:10px;">
                <label for="" id="tipoDeModalidadLabel"></label>
                <select name="tipoDeModalidad" id="tipoDeModalidad" class="browser-default validate select2" style="width: 100%;" disabled>
                  <option value="">SELECCIONE UNA OPCION</option>
                  <option value="P" {{ old('tipoDeModalidad') == 'P' ? 'selected' : '' }}>PRESENCIAL</option>
                  <option value="V" {{ old('tipoDeModalidad') == 'V' ? 'selected' : '' }}>VIRTUAL</option>
                </select>
              </div>
            </div>

            <div class="row" style="display: none;" id="fechasBusqueda">
              <div class="col s12 m6 l4">
                {!! Form::label('fechaInicio', 'Fecha de inicio *', array('class' => '')); !!}
                {!! Form::date('fechaInicio', old('fechaInicio'), array('id' => 'fechaInicio', 'class' => 'validate')) !!}
              </div>

              <div class="col s12 m6 l4">
                {!! Form::label('fechaFin', 'Fecha final *', array('class' => '')); !!}
                {!! Form::date('fechaFin', old('fechaFin'), array('id' => 'fechaFin', 'class' => 'validate')) !!}
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
@include('primaria.scripts.periodos')
@include('primaria.reportes.calificacion_por_materia.funcionJs')


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
</script>
@endsection

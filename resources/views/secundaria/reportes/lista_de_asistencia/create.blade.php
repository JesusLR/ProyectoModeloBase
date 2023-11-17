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
      $perActual = Auth::user()->empleado->escuela->departamento->perActual;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'secundaria_reporte.lista_de_asistencia.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
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
                  <label for="ubicacion_id">Ubicación*</label>
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
                  <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo*</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id', $perActual)}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>



            <div class="row">

                <div class="col s12 m6 l4">
                  <label for="tipoReporte">Reporte por *</label>
                  <select name="tipoReporte" id="tipoReporte" data-periodo-id="{{old('tipoReporte')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="gradoGrupo" {{ old('tipoReporte') == 1 ? 'gradoGrupo' : '' }}>GRADO-GRUPO</option>
                      <option value="docente" {{ old('tipoReporte') == 1 ? 'docente' : '' }}>DOCENTE</option>
                  </select>
                </div>

                <div class="col s12 m6 l4 divGradoGrupo" style="display: none;">
                    <div class="input-field">
                        {!! Form::number('gpoGrado', old('gpoGrado'), array('id' => 'gpoGrado', 'class' => 'validate', 'min' => '0', 'max'=>'3')) !!}
                        {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                    </div>
                </div>
                
                <div class="col s12 m6 l4 divGradoGrupo" style="display: none;">
                    <div class="input-field">
                        {!! Form::text('gpoGrupo', old('gpoGrupo'), array('id' => 'gpoGrupo', 'class' => 'validate','maxlength'=>'5')) !!}
                        {!! Form::label('gpoGrupo', 'Grupo *', array('class' => '')); !!}
                    </div>
                </div>

                <div class="col s12 m6 l4" style="display: none;">
                  <label for="tipoVista">Tipo de vista *</label>
                  <select name="tipoVista" id="tipoVista" data-periodo-id="{{old('tipoVista')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="listaVacia" {{ old('tipoVista') == 1 ? 'listaVacia' : '' }}>LISTA VACÍA</option>
                      <option value="listaLlena" {{ old('tipoVista') == 1 ? 'listaLlena' : '' }}>LISTA CON FECHAS</option>
                  </select>
                </div>


                <div class="col s12 m6 l4 divDocente" style="display: none;">
                  <div class="input-field">
                      {!! Form::number('secundaria_empleado_id', old('secundaria_empleado_id'), array('id' => 'secundaria_empleado_id', 'class' => 'validate', 'min' => '0')) !!}
                      {!! Form::label('secundaria_empleado_id', 'Docente (Número de empleado) *', array('class' => '')); !!}
                  </div>
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

@include('secundaria.scripts.preferencias_espesificas')
@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')
@include('secundaria.reportes.calificacion_por_materia.funcionJs')



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
  

  $("#tipoReporte").change(function(){
    if($('select[id=tipoReporte]').val() == "gradoGrupo"){
      $(".divGradoGrupo").show();   
      $('#gpoGrado').attr('required', 'required');
      $('#gpoGrupo').attr('required', 'required');
      $(".divDocente").hide();
      $('#secundaria_empleado_id').removeAttr('required');
    
    }else{
      $(".divGradoGrupo").hide();
      $('#gpoGrado').removeAttr('required');
      $('#gpoGrupo').removeAttr('required');
      $(".divDocente").show();

    }
  });

  if($('select[id=tipoReporte]').val() == "gradoGrupo"){
    $(".divGradoGrupo").show();  
    $('#gpoGrado').attr('required', 'required');
    $('#gpoGrupo').attr('required', 'required'); 
    $(".divDocente").hide();
    $('#secundaria_empleado_id').removeAttr('required');  


  }else{
    $(".divGradoGrupo").hide();
    $('#gpoGrado').removeAttr('required');
    $('#gpoGrupo').removeAttr('required');
    $(".divDocente").show();
    $('#secundaria_empleado_id').attr('required', 'required');

  }

</script>



@endsection

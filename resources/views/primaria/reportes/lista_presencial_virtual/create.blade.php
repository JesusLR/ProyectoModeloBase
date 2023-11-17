@extends('layouts.dashboard')

@section('template_title')
    Reportes lista
@endsection

@section('breadcrumbs')
  <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Lista presencial-virtual</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'primaria_reporte.lista_de_asistencia_virtual_presencial.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">LISTA PRESENCIAL-VIRTUAL</span>
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
                        {!! Form::text('gpoGrupo', old('gpoGrupo'), array('id' => 'gpoGrupo', 'class' => 'validate','maxlength'=>'5')) !!}
                        {!! Form::label('gpoGrupo', 'Grupo *', array('class' => '')); !!}
                    </div>
                </div>


                <div class="col s12 m6 l4" style="margin-top:10px;">
                  <label for="" id="tipoDeModalidadLabel"></label>
                  <select name="tipoDeModalidad" id="tipoDeModalidad" class="browser-default validate select2" style="width: 100%;" disabled>
                    <option value="">SELECCIONE UNA OPCION</option>
                    <option value="P" {{ old('tipoDeModalidad') == 'P' ? 'selected' : '' }}>PRESENCIAL</option>
                    <option value="V" {{ old('tipoDeModalidad') == 'V' ? 'selected' : '' }}>VIRTUAL</option>
                  </select>
                </div>
              
            </div>

            <div class="row">
              <div class="col s12 m6 l4" style="margin-top:10px;">
                <label for="" id="docente_id">Docente *</label>
                <select name="docente_id" id="docente_id" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONE UNA OPCION</option>
                  @forelse ($docentes as $docente)
                      <option value="{{$docente->id}}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>{{$docente->empApellido1.' '.$docente->empApellido2.' '.$docente->empNombre}}</option>
                  @empty
                      
                  @endforelse
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

@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas_todos')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')



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

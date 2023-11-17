@extends('layouts.dashboard')

@section('template_title')
    Reportes grupo maestros
@endsection

@section('breadcrumbs')
  <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación grupo maestros</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria_relacion_maestros_escuela.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación grupo maestros</span>
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
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('acuEstadoPlan', 'Tipo PDF*', ['class' => '']); !!}
                <select name="tipoPdf" id="tipoPdf" class="browser-default validate select2" style="width: 100%;" required>
                {{--  <option value="">Seleccionar</option>  --}}
                {{-- <option value="E">Por escuela</option> --}}
                  {{-- <option value="ECA">Por escuela con carga académica</option> --}}
                  <option value="G">General por nombre</option>
                  {{--  <option value="EC">Por escuela y carrera</option>
                  <option value="S">Por semestre</option>  --}}
                </select>
              </div>

              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('tipoEspacio', 'Seleccionar espaciado', ['class' => '']); !!}
                <select name="tipoEspacio" id="tipoEspacio" class="browser-default validate select2" style="width: 100%;">
                  <option value="sencillo">SENCILLO</option>
                  <option value="doble">DOBLE</option>
                </select>
              </div>
            </div>

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
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela *<span id="escuela_span"></span></label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                </select>
              </div>
             
            </div>

            <div class="row">
              
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa *<span id="programa_span"></span></label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan *</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo *<span id="periodo_span"></span></label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4" style="margin-top:10px;">
                <label for="" id="tipoDeModalidadLabel"></label>
                <select name="tipoDeModalidad" id="tipoDeModalidad" class="browser-default validate select2" style="width: 100%;" disabled>
                  <option value="">Seleccionar</option>
                  <option value="P">PRESENCIAL</option>
                  <option value="V">VIRTUAL</option>
                </select>
              </div>
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('empEstado', 'Estado del empleado *', ['class' => '']); !!}
                <select name="empEstado" id="empEstado" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="T">Seleccionar</option>
                  <option value="A">Activo</option>
                  <option value="B">Baja</option>
                  <option value="S">Suspendido</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="col s12 m6 l6">
                  {!! Form::label('empleado_id', 'Número de empleado', array('class' => '')); !!}
                  <select name="empleado_id" id="empleado_id" data-empleado-id="{{old('empleado_id')}}" class="browser-default validate select2" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach ($primaria_empleados as $primaria_empleado)
                        <option value="{{$primaria_empleado->id}}">{{$primaria_empleado->id.'-'.$primaria_empleado->empApellido1.'-'.$primaria_empleado->empApellido2.'-'.$primaria_empleado->empNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('gpoSemestre', 'Grado', array('class' => '')); !!}
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido paterno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
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

  


@endsection


@section('footer_scripts')
{{-- Script de funciones auxiliares  --}}

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
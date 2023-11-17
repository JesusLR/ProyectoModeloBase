@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Lista de asistencia por materia</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_grupo_materia_cch.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">LISTA DE ASISTENCIA POR MATERIA</span>

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
                    <label for="departamento_id">Departamento *</label>
                    <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" id="departamento_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="escuela_id">Escuela *</label>
                    <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>                  
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                    <label for="periodo_id">Período *</label>
                    <select class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" id="periodo_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="programa_id">Programa *</label>
                    <select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" name="programa_id" id="programa_id" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="plan_id">Plan *</label>
                    <select class="browser-default validate select2" data-plan-id="{{old('plan_id')}}" name="plan_id" id="plan_id" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('gpoSemestre', 'Semestre', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                            {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                            {!! Form::label('matClave', 'Clave de materia', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('empleado_id', NULL, array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
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

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')


@endsection

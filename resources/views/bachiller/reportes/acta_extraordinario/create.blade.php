@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Acta de examen recuperativo</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_acta_extraordinario.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">ACTA DE EXAMEN RECUPERATIVO</span>
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
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela *</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">              
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa *</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
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
                <label for="periodo_id">Periodo *</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('matSemestre', NULL, array('id' => 'matSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('matSemestre', 'Semestre', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('extGrupo', NULL, array('id' => 'extGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('extGrupo', 'Clave del grupo', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate', "")) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
                <div class="col s12 m6 l6">
                  {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                  <select name="empleado_id" id="empleado_id" data-periodo-id="{{old('empleado_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach ($docentes as $docente)
                        <option value="{{$docente->id}}">{{$docente->id.'-'.$docente->empApellido1.' '.$docente->empApellido2.' '.$docente->empNombre}}</option>
                    @endforeach
                  </select>                  
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('extAlumnosInscritos', NULL, array('id' => 'extAlumnosInscritos', 'class' => 'validate')) !!}
                  {!! Form::label('extAlumnosInscritos', 'Número de alumnos inscritos', array('class' => '')); !!}
                </div>
              </div>
            </div>

          </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

  

@endsection


@section('footer_scripts')

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_todos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')

@endsection
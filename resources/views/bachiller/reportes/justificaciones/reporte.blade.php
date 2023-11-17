@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Reporte de justificaciones solicitadas</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_justificaciones.imprimir_reporte', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REPORTE DE JUSTIFIACIONES SOLICITADAS</span>

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
               
                @php
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                @endphp
                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="numero_justifaciones">Núnero de justifaciones *</label>
                        <select name="numero_justifaciones" id="numero_justifaciones" data-departamento-id="{{old('numero_justifaciones')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="TODAS">TODAS</option>
                            <option value="-3">Menores a 3</option>
                            <option value="3">3 Justificaciones</option>
                            <option value="+3">Mas de 3</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curEstado', 'Ubicación*', ['class' => '']); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $selected = '';
      
                                    
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
                        <label for="periodo_id">Período *</label>
                        <select name="periodo_id" id="periodo_id" data-escuela-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="programa_id">Programa *</label>
                        <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="plan_id">Plan *</label>
                        <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('cgtGradoSemestre', 'Semestre', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate', 'maxlength'=>2)) !!}
                            {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
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
@include('bachiller.scripts.escuelas_todos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@endsection
@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Lista de historico inscripciones</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_historico_inscripciones.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">LISTA DE HISTORICO INSCRIPCIONES</span>

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
                        {!! Form::label('opcion', 'Opción para alumnos', ['class' => '']); !!}
                        <select name="opcion" id="opcion" class="browser-default validate select2" style="width: 100%;">
                            @foreach($opciones as $key => $value)
                                <option value="{{$key}}" @if(old('opcion') == $key) {{ 'selected' }} @endif>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('opcionVista', 'Opción para alumnos', ['class' => '']); !!}
                        <select name="opcionVista" id="opcionVista" class="browser-default validate select2" style="width: 100%;">
                            <option value="EXCEL">EXCEL</option>
                            <option value="PDF">PDF</option>
                        </select>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curEstado', 'Ubicación*', ['class' => '']); !!}
                        <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
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
                        <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="escuela_id">Escuela</label>
                        <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
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
                        <label for="programa_id">Programa</label>
                        <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="plan_id">Plan</label>
                        <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgtGradoSemestreb', 'Grado*', ['class' => '']); !!}
                        <select name="cgtGradoSemestreb" id="cgtGradoSemestreb" data-ubicacion-id="{{old('cgtGradoSemestreb')}}" class="browser-default validate select2" style="width:100%;" required>
                            @foreach($grados as $key =>  $grado)
                                <option value="{{$key}}">{{$grado}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate', 'maxlength'=>2)) !!}
                        {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
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
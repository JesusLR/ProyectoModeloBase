@extends('layouts.dashboard')

@section('template_title')
Constancia de computo
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<label class="breadcrumb">Constancia de computo</label>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' =>
    'bachiller.bachiller_constancia_computo.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">Constancia de computo</span>

        {{-- NAVIGATION BAR--}}
        <nav class="nav-extended">
          <div class="nav-content">
            <ul class="tabs tabs-transparent">
              <li class="tab"><a class="active" href="#general">General</a></li>
            </ul>
          </div>
        </nav>

        {{-- GENERAL BAR--}}
        <div id="general">

          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('grado', 'Grado *', array('class' => '')); !!}
              <select id="grado" data-grado-id="{{old('grado')}}" class="browser-default validate select2" required
                name="grado" style="width: 100%;">
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
              </select>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
              <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @foreach($ubicaciones as $ubicacion)
                @php
                $selected = '';

                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'
                </option>';
                } else {
                if ($ubicacion->id == old("ubicacion_id")) {
                $selected = 'selected';
                }

                echo '<option value="'.$ubicacion->id.'" '. $selected .'>
                  '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                }
                @endphp
                @endforeach
              </select>
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
              <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}"
                class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
              <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2"
                required name="escuela_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
              <select id="periodo_id" data-plan-id="{{old('periodo_id')}}" class="browser-default validate select2"
                required name="periodo_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>

            {{-- <div class="col s12 m6 l4">
              <div class="col s12 m6 l6">
                {!! Form::label('perNumero', 'Número periodo', array('class' => '')); !!}
                <select id="perNumero" data-perNumero="{{old('perNumero')}}" class="browser-default validate select2"
                  name="perNumero" style="width: 100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  <option value="1">1</option>
                  <option value="3">3</option>
                </select>
              </div>
              <div class="col s12 m6 l6">
                {!! Form::label('perAnioPago', 'Año periodo', array('class' => '')); !!}
                <select name="perAnioPago" id="perAnioPago" class="browser-default validate select2"
                  style="width:100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @for($i = $anioActual; $i > 1996; $i--)
                  <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </div>
            </div> --}}

            <div class="col s12 m6 l4">
              {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
              <select id="programa_id" data-programa-id="{{old('programa_id')}}"
                class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
              <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" required
                name="plan_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>

          </div>

          <div class="row">            
            <div class="col s12 m6 l4">
              <div class="input-field col s12 m6 l6">
                {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                {!! Form::label('aluClave', 'Clave Pago', array('class' => '')); !!}
              </div>
              <div class="input-field col s12 m6 l6">
                {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                {!! Form::label('aluMatricula', 'Matrícula', array('class' => '')); !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
              </div>
            </div>

            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
              </div>
            </div>

            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
              </div>
            </div>
          </div>

          {{-- <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field col s12 m6 l6">
                {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' =>
                'validate','min'=>'0')) !!}
                {!! Form::label('cgtGradoSemestre', 'Semestre', array('class' => '')); !!}
              </div>
              <div class="input-field col s12 m6 l6">
                {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate', 'maxlength'=>2)) !!}
                {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
              </div>
            </div>
          </div> --}}


        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">explicit</i> Generar Reporte', ['class' => 'btn-large
          waves-effect darken-3 submit-button','type' => 'submit']) !!}
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
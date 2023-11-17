@extends('layouts.dashboard')

@section('template_title')
Cierre de actas
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Cierre de actas</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' =>
    'bachiller.bachiller_cierre_actas.cierreActas', 'method' => 'POST', 'target' => '_blank', 'id' =>
    'form_cierre_actas']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">CIERRE DE ACTAS</span>
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
              <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2"
                required name="periodo_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
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
              <div class="input-field col">
                {!! Form::number('gpoSemestre', old('gpoSemestre'), array('id' => 'gpoSemestre', 'class' =>
                'validate','min'=>'0')) !!}
                {!! Form::label('gpoSemestre', 'Grado o Semestre', array('class' => '')); !!}
              </div>
              <div class="input-field col">
                {!! Form::text('gpoClave', old('gpoClave'), array('id' => 'gpoClave', 'class' => 'validate')) !!}
                {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('matClave', old('matClave'), array('id' => 'matClave', 'class' => 'validate')) !!}
                {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::number('empleado_id', old('empleado_id'), array('id' => 'empleado_id', 'class' =>
                'validate','min'=>'0')) !!}
                {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
              </div>
            </div>
          </div>


          <div class="row">
            
            {{--  <div class="col s12 m6 l4">
              {!! Form::label('gpoFechaExamenOrdinario', 'Fecha de Ordinario', array('class' => '')); !!}
              {!! Form::date('gpoFechaExamenOrdinario', old('gpoFechaExamenOrdinario'), array('id' => 'gpoFechaExamenOrdinario', 'class' =>'validate')) !!}
            </div>  --}}
          </div>

        </div>
      </div>
      <div class="card-action">
        {!! Form::button('<i class="material-icons left">data_usage</i> GENERAR CIERRE', ['class' => 'btn-large
        waves-effect darken-3', 'id' => 'btn_submit']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection


@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let btn_submit = $('#btn_submit');

    btn_submit.on('click', function(e) {
      e.preventDefault();
      $(this).prop('disabled', true);

      $('#form_cierre_actas').submit();
    });
  });
</script>

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_todos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@endsection
@extends('layouts.dashboard')

@section('template_title')
    Extraordinario
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('extraordinario')}}" class="breadcrumb">Lista de extraordinarios</a>
    <label class="breadcrumb">Agregar extraordinario</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'extraordinario.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR EXTRAORDINARIO</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
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
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="gpoSemestre" class="browser-default validate select2" required name="gpoSemestre" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', NULL, array('id' => 'extGrupo', 'class' => 'validate','maxlength' => '3')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6">
                        {!! Form::label('aula_id', 'Aula', array('class' => '')); !!}
                        <select id="aula_id" class="browser-default validate select2" name="aula_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div id="seccion_optativa" class="row" hidden>
                    <div class="col s12 ">
                        {!! Form::label('optativa_id', 'Optativa', array('class' => '')); !!}
                        <select id="optativa_id" class="browser-default validate select2" name="optativa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFecha', 'Fecha examen', array('class' => '')); !!}
                        {!! Form::date('extFecha', NULL, array('id' => 'extFecha', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHora', 'Hora examen', array('class' => '')); !!}
                        {!! Form::time('extHora', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extPago', NULL, array('id' => 'extPago', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"')) !!}
                        {!! Form::label('extPago', 'Costo Examen', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_sinodal_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>


@endsection

@section('footer_scripts')

@include('scripts.preferencias')
@include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('scripts.periodos')
@include('scripts.semestres')
@include('scripts.materias')
@include('scripts.grupos')
@include('scripts.optativas')
@include('scripts.aulas')

@endsection
@extends('layouts.dashboard')

@section('template_title')
    Bachiller vacionales
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_periodos_vacacionales.index')}}" class="breadcrumb">Lista de períodos vacacionales</a>
    <a href="{{route('bachiller.bachiller_periodos_vacacionales.create')}}" class="breadcrumb">Agregar período vacacional</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_periodos_vacacionales.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PERÍODO VACACIONAL</span>

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
                        <select id="ubicacion_id" class="browser-default validate select2" required
                            name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                            @php
                            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                            $selected = '';
                            if($ubicacion->id == $ubicacion_id){
                            $selected = 'selected';
                            }
                            @endphp
                            <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required
                            name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                            'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                            'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('pvTipo', 'Tipo *', array('class' => '')); !!}
                        <select id="pvTipo" data-pvTipo-id="{{old('pvTipo')}}" class="browser-default validate select2" required name="pvTipo"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="P" {{ old('pvTipo') == 'P' ? 'selected' : '' }}>Primavera</option>
                            <option value="V" {{ old('pvTipo') == 'V' ? 'selected' : '' }}>Verano</option>
                            <option value="I" {{ old('pvTipo') == 'I' ? 'selected' : '' }}>Invierno</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('pvInicio', 'Fecha inicio vacaciones *', ['class' => '']); !!}                       
                        {!! Form::date('pvInicio', old('pvInicio'), array('id' => 'pvInicio', 'class' =>'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('pvFinal', 'Fecha final vacaciones*', ['class' => '']); !!}
                        {!! Form::date('pvFinal', old('pvFinal'), array('id' => 'pvFinal', 'class' =>'validate')) !!}
                    </div>
                    
                </div>
                <br>            
               


          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
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
@include('bachiller.scripts.periodos')


@endsection
@extends('layouts.dashboard')

@section('template_title')
    Paquete
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('paquete')}}" class="breadcrumb">Lista de Paquete</a>
    <a href="{{url('paquete/create')}}" class="breadcrumb">Agregar Paquete</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'paquete.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PAQUETE</span>

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
                    <div class="col s12 m6 l4">
                        {!! Form::label('semestre_id', 'Semestre *', array('class' => '')); !!}
                        <select id="semestre_id" class="browser-default validate select2" required name="semestre_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @for($i = 1;$i<=10;$i++)
                                <option value="{{$i}}" @if(old('semestre_id') == $i) {{ 'selected' }} @endif>{{$i}}</option>
                            @endfor;
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s10">
                        {!! Form::label('grupo_id', 'Grupo *', array('class' => '')); !!}
                        <select id="grupo_id" class="browser-default validate select2" required name="grupo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s2">
                        {!! Form::button('<i class="material-icons">add</i>', ['id'=>'agregarGrupo','class' => 'btn-large waves-effect  darken-3']) !!}
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-paquetes" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Maestro</th>
                                <th>Curso-Grupo-Turno</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
@include('scripts.cgts')
@include('scripts.materias')
@include('scripts.grupos')
@include('scripts.paquetes')


@endsection
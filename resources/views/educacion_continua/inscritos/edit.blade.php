@extends('layouts.dashboard')

@section('template_title')
    Inscrito Edu. Continua
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('inscritosEduContinua')}}" class="breadcrumb">Lista de inscritos</a>
    <label class="breadcrumb">Editar inscrito # {{$inscrito->id}}</label>
@endsection

@section('content')

@php
  use App\clases\personas\MetodosPersonas;

  $alumno = $inscrito->alumno;
  $persona = $alumno->persona;
  $alumno_info = $alumno->aluClave.'-'.MetodosPersonas::nombreCompleto($persona, true);
  $programa = $inscrito->educacioncontinua;
@endphp


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => ['inscritosEduContinua.update', $inscrito->id], 'method' => 'PUT']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR INSCRITO # {{$inscrito->id}}</span>

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
                  <div class="input-field">
                    <input type="text" name="alumno_info" id="alumno_info" value="{{$alumno_info}}" class="validate" readonly>
                    <label for="alumno_info">Alumno:</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    <label for="programa_id">Programa:</label>
                    <select name="programa_id" id="programa_id" class="browser-default validate select2" style="width:100%;">
                      <option value="{{$programa->id}}">{{$programa->ecClave}}-{{$programa->ecNombre}}</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('iecGrupo', old('iecGrupo') ?: $inscrito->iecGrupo, array('id' => 'iecGrupo', 'class' => 'validate', 'maxlength'=>'3')) !!}
                    {!! Form::label('iecGrupo', 'Grupo', []); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('iecFechaRegistro', 'Fecha registro *', []); !!}
                  {!! Form::date('iecFechaRegistro', $inscrito->iecFechaRegistro, array('id' => 'iecFechaRegistro', 'class' => 'validate', 'readonly')) !!}
                </div>
              </div>


              
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('iecImporteInscripcion', old('iecImporteInscripcion') ?: $inscrito->iecImporteInscripcion, array('id' => 'iecImporteInscripcion', 'class' => 'validate', 'step'=>'0.01')) !!}
                    {!! Form::label('iecImporteInscripcion', 'Importe inscripcion', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('iecFechaProcesoRegistro', 'Fecha proceso registro', array('class' => '')); !!}
                  {!! Form::date('iecFechaProcesoRegistro', $inscrito->iecFechaProcesoRegistro, array('id' => 'iecFechaProcesoRegistro', 'class' => 'validate', 'readonly')) !!}
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

@endsection
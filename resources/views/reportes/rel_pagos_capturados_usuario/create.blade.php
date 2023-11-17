@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de pagos capturados por usuario</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/rel_pagos_capturados_usuario/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de pagos capturados por usuario</span>
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
            <br>
            <div class="row">
              <b>Buscar pagos realizados entre las siguientes fechas:</b>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('fecha1', 'fecha 1 *', array('class' => '')); !!}
                  <input type="date" name="fecha1" id="fecha1" class="validate" value="{{old('fecha1')}}" required>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('fecha2', 'fecha 2 *', array('class' => '')); !!}
                  <input type="date" name="fecha2" id="fecha2" class="validate" value="{{old('fecha2')}}" required>
                </div>
              </div>
            </div>
           
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('username', NULL, array('id' => 'username', 'class' => 'validate','required')) !!}
                  {!! Form::label('username', 'Usuario*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                  {!! Form::label('aluClave', 'Clave de pago (Alumno)', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('pagAnioPer',NULL, array('id' => 'pagAnioPer', 'class' => 'validate','min'=>'1997','max'=>$fechaActual->year)) !!}
                  {!! Form::label('pagAnioPer', 'Año de Periodo', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('pagConcPago', NULL, array('id' => 'pagConcPago', 'class' => 'validate')) !!}
                  {!! Form::label('pagConcPago', 'Concepto de pago', array('class' => '')); !!}
                </div>
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

@endsection
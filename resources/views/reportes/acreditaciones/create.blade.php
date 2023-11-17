@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Desempeño Académico</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/acreditaciones/exportarExcel', 'method' => 'POST']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Desempeño Académico</span>
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
                {!! Form::label('ubicacion_id', 'Clave de campus *', array('class' => '')); !!}
                <select name="ubicacion_id" id="ubicacion_id" class="browser-default validate select2" style="width: 100%;" required>
                  @foreach ($ubicacion as $ubi)
                    <option value="{{$ubi->id}}">{{$ubi->ubiClave}} - {{$ubi->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Clave departamento *', array('class' => '')); !!}
                  <select name="departamento_id" id="departamento_id" class="browser-default validate select2" style="width: 100%;" required>
            
                  </select>

              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('escuela_id', 'Clave de escuela *', array('class' => '')); !!}
                <select name="escuela_id" id="escuela_id" class="browser-default validate select2" style="width: 100%;" required>
        
                </select>
              </div>
              
            </div>
            <div class="row">
          
              <div class="col s12 m6 l4">
                {!! Form::label('periodo_id', 'Periodo *', ['class' => '',]); !!}
                <select name="periodo_id" id="periodo_id" class="browser-default validate select2" style="width: 100%;" required>
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('fechaInicial', NULL, array('id' => 'fechaInicial', 'readonly')) !!}
                  {!! Form::label('fechaInicial', 'Fecha Inicial', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('fechaFinal', NULL, array('id' => 'fechaFinal','readonly')) !!}
                  {!! Form::label('fechaFinal', 'Fecha Final', array('class' => '')); !!}
                </div>
              </div>
              
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('programa_id', 'Clave de programa *', array('class' => '')); !!}
                <select name="programa_id" id="programa_id" class="browser-default validate select2" style="width: 100%;" required>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('plan_id', 'Clave del plan *', array('class' => '')); !!}
                <select name="plan_id" id="plan_id" class="browser-default validate select2" style="width: 100%;" required>
                </select>
              </div>
              
              <div class="col s12 m6 l4">
                  {!! Form::label('cgt_id', 'Cgt', array('class' => '')); !!}
                  <select name="cgt_id" id="cgt_id" class="browser-default validate select2" style="width: 100%;" required>
                  </select>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">file_download</i> GENERAR EXCEL', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
@include('scripts/obtenerDatosIds')
@endsection
@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Becas por Campus, Programa y Programa</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/becas_campus_carrera_escuela/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Becas por Campus, Programa y Escuela</span>
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
                {!! Form::label('tipoReporte', 'Seleccionar tipo de reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                    <option value="campus">CAMPUS | DEPARTAMENTO (NIVEL)</option>
                    <option value="escuela">ESCUELA</option>
                    <option value="carrera">PROGRAMA</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('tipoFormato', 'Seleccionar tipo de formato', ['class' => '']); !!}
                <select name="tipoFormato" id="tipoFormato" class="browser-default validate select2" style="width: 100%;">
                    <option value="PDF">PDF</option>
                    <option value="EXCEL">EXCEL</option>
                </select>
              </div>
            </div>


            <hr>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('depClave', 'Clave de departamento', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                          {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "")) !!}
                          {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('aluEstado', 'Seleccione alumnos a incluir en el reporte', ['class' => '']); !!}
                <select name="aluEstado" id="aluEstado" class="browser-default validate select2" style="width: 100%;">
                  @foreach($aluEstado as $key => $value)
                    <option value="{{$key}}" @if(old('aluEstado') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                  @endforeach
                </select>
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
@endsection

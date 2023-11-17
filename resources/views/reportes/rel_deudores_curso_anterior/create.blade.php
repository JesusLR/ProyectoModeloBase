@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Deudores Año Escolar Anterior</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/deudores_curso_anterior/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Deudores Año Escolar Anterior</span>
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
                          {!! Form::label('tipoResumen', 'Seleccionar tipo de reporte', ['class' => '']); !!}
                          <select name="tipoResumen" id="tipoResumen" class="browser-default validate select2" style="width: 100%;">
                              <option value="2AÑOS">ALUMNOS QUE ADEUDAN EN EL AÑO ESCOLAR ANTERIOR</option>
                          </select>
                      </div>

                      <div class="col s12 m6 l4">
                          {!! Form::label('tipoReporte', 'Seleccionar filtro de reporte', ['class' => '']); !!}
                          <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                              <option value="departamento">POR DEPARTAMENTO</option>
                                {{-- <option value="escuela">ESCUELA</option> --}}
                      </select>
                  </div>
             </div>

            <hr>

            <div class="row">
                    <div class="col s12 m6 l4">
                          {!! Form::label('ubiClave', 'Seleccionar la Clave del Campus', ['class' => '']); !!}
                          <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;">
                              <option value="CME">CME | Mérida</option>
                              <option value="CVA">CVA | Valladolid</option>
                              <option value="CCH">CCH | Chetumal</option>
                          </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('depClave', 'Seleccionar la Clave del Departamento', ['class' => '']); !!}
                        <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;">
                            <option value="SUP">SUP | Superior</option>
                            <option value="POS">POS | Posgrado</option>
                        </select>
                    </div>
                    {{--
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', 'ARQ', array('id' => 'escClave', 'class' => 'validate','min'=>'0', 'maxlength' => 3, "required")) !!}
                            {!! Form::label('escClave', 'Clave de Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                    --}}
            </div>

            <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('perAnio', $anioActual->year - 1, array('id' => 'perAnio', 'class' => 'validate','min'=>'1998','max'=>$anioActual->year, "required")) !!}
                            {!! Form::label('perAnio', 'Año del curso escolar (más reciente)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('mesPago', 'Seleccione el ultimo mes que desea consultar', ['class' => '']); !!}
                        <select name="mesPago" id="mesPago" class="browser-default validate select2" style="width: 100%;">
                            <option value="1">SEPTIEMBRE</option>
                            <option value="2">OCTUBRE</option>
                            <option value="3">NOVIEMBRE</option>
                            <option value="4">DICIEMBRE</option>
                            <option value="5">ENERO</option>
                            <option value="6">FEBRERO</option>
                            <option value="7">MARZO</option>
                            <option value="8">ABRIL</option>
                            <option value="9">MAYO</option>
                            <option value="10">JUNIO</option>
                            <option value="11">JULIO</option>
                            <option value="12">AGOSTO</option>
                        </select>
                    </div>
                {{-- </div>
                <div class="row"> --}}

                 </div>

                 <div class="row">
                      <div class="col s12 m6 l4">
                          {!! Form::label('curEstados', 'Estado del Curso (Año Adeudado)', ['class' => '']); !!}
                          <select name="curEstados" id="curEstados" class="browser-default validate select2" style="width: 100%;">
                              <option value="RPCA">Solo Regulares, Preinscritos y Condicionados</option>
                              <option value="B">Solo Bajas en el curso anterior</option>
                              <option value="X">Todos los alumnos (incluye bajas)</option>
                          </select>
                      </div>
                      <div class="col s12 m6 l4">
                          {!! Form::label('curEstadosActuales', 'Estado del Curso Actual', ['class' => '']); !!}
                          <select name="curEstadosActuales" id="curEstadosActuales" class="browser-default validate select2" style="width: 100%;">
                              <option value="RPCA">Solo Regulares, Preinscritos y Condicionados</option>
                              <option value="R">Solo Regulares</option>
                              <option value="P">Solo Preinscritos</option>
                              <option value="CA">Solo Condicionados (C y A)</option>
                              <option value="C">Solo Condicionados C</option>
                              <option value="A">Solo Condicionados A</option>
                              <option value="B">Solo Bajas en el curso actual</option>
                              <option value="X">Todos los alumnos (incluye bajas)</option>
                          </select>
                      </div>
                 </div>

          </div>
        </div>

        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE EN EXCEL', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
@endsection

@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Candidatos</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_candidatos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Candidatos</span>
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
                              <option value="I">ALUMNOS REGISTRADOS DE PRIMER INGRESO</option>
                          </select>
                      </div>

                      <div class="col s12 m6 l4">
                          {!! Form::label('tipoReporte', 'Seleccionar filtro de reporte', ['class' => '']); !!}
                          <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                              <option value="escuela">ESCUELA</option>
                              <option value="programa">PROGRAMA</option>
                          </select>
                      </div>
                 </div>

                <hr>

                <div class="row">
                        <div class="col s12 m6 l4">
                              {!! Form::label('ubiClave', 'Seleccionar la Clave del Campus', ['class' => '']); !!}
                              <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;">
                                  <option value="CME">CME | Mérida</option>
                              </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('depClave', 'Seleccionar la Clave del Departamento', ['class' => '']); !!}
                            <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;">
                                <option value="SUP">SUP | Superior</option>
                            </select>
                        </div>
                </div>


                <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('perAnio', $anioActual->year, array('id' => 'perAnio', 'class' => 'validate','min'=>'2020','max'=>$anioActual->year, "required")) !!}
                                {!! Form::label('perAnio', 'Año de inicio del curso escolar (Periodo # 3)', array('class' => '')); !!}
                            </div>
                        </div>
                    {{-- </div>
                    <div class="row"> --}}
                          <div class="col s12 m6 l4">
                              <div class="input-field">
                                  {!! Form::text('progClave', '', array('id' => 'progClave', 'class' => 'validate','min'=>'0', 'maxlength' => 3, "required")) !!}
                                  {!! Form::label('progClave', 'Clave de Escuela ó Programa', array('class' => '')); !!}
                              </div>
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

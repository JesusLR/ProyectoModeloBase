@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de Pagos de Colegiaturas</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/colegiaturas/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de Pagos de Colegiaturas</span>
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
                              <option value="I">CANTIDAD DE IMPORTES $</option>
                              <option value="N">NÚMERO DE ALUMNOS</option>
                          </select>

                      </div>

                </div>

                <div class="row">
                      <div class="col s12 m6 l4">
                        {!! Form::label('tipoReporte', 'Seleccionar filtro de reporte', ['class' => '']); !!}
                        <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                            <option value="campus">CAMPUS | DEPARTAMENTO (NIVEL)</option>
                            <option value="escuela">ESCUELA</option>
                            <option value="carrera">PROGRAMA</option>
                        </select>

                      </div>
                </div>

                <hr>

                <div class="row">
                      <div class="col s12 m6 l4">
                          {!! Form::label('ubiClave', 'Clave de campus', ['class' => '']); !!}
                          <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;">
                              <option value="CME">CME | Mérida</option>
                              <option value="CVA">CVA | Valladolid</option>
                              <option value="CCH">CCH | Chetumal</option>
                          </select>
                      </div>
                      <div class="col s12 m6 l4">
                          {!! Form::label('depClave', 'Clave de departamento', ['class' => '']); !!}
                          <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;">
                              <option value="SUP">SUP | Superior</option>
                              <option value="POS">POS | Posgrado</option>
                              <option value="BAC">BAC | Bachiller</option>
                              <option value="SEC">SEC | Secundaria</option>
                              <option value="PRI">PRI | Primaria</option>
                              <option value="PRE">PRE | Preescolar</option>
                              <option value="MAT">MAT | Maternal</option>
                          </select>
                      </div>
                </div>

                <div class="row">
                        <div class="col s12 m6 l4">
                              <div class="input-field">
                                  {!! Form::number('perAnio', $anioActual->year, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                                  {!! Form::label('perAnio', 'Año escolar (Inicio del Año Escolar ó Inicio del Periodo 3)', array('class' => '')); !!}
                              </div>
                        </div>
                        <div class="col s12 m6 l4">
                                {!! Form::label('curEstados', 'Estado del Curso', ['class' => '']); !!}
                                <select name="curEstados" id="curEstados" class="browser-default validate select2" style="width: 100%;">
                                    <option value="R">Solo Regulares</option>
                                    <option value="P">Solo Preinscritos</option>
                                    <option value="CA">Solo Condicionados</option>
                                    <option value="B">Solo Bajas en el curso</option>
                                    <option value="RPCA">Solo Regulares, Preinscritos y Condicionados</option>
                                    <option value="X">Todos los alumnos (incluye bajas)</option>
                                </select>
                        </div>
                </div>

                {{--
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
                --}}
              <div class="row">

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

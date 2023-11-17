@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Deudores de Colegiaturas</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_deudores/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Deudores de Colegiaturas</span>
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
                              <option value="I">RELACIÓN DE DEUDORES</option>
                              <option value="00">INSCRIPCIÓN DE ENERO (POR ESCUELA)</option>
                          </select>
                      </div>

                      <div class="col s12 m6 l4">
                          {!! Form::label('tipoReporte', 'Seleccionar filtro de reporte', ['class' => '']); !!}
                          <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                              <option value="escuela">ESCUELA</option>
                              <option value="carrera">PROGRAMA (CARRERA)</option>
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
                        <div class="col s12 m6 l4">
                            {!! Form::label('numSemestre', 'Seleccionar el Semestre', ['class' => '']); !!}
                            <select name="numSemestre" id="numSemestre" class="browser-default validate select2" style="width: 100%;">
                                <option value="0">Todos</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                            </select>
                        </div>
                </div>





                <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('perAnio', $anioActual->year - 1, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                                {!! Form::label('perAnio', 'Año de inicio del curso escolar (Periodo # 3)', array('class' => '')); !!}
                            </div>
                        </div>
                    {{-- </div>
                    <div class="row"> --}}
                          <div class="col s12 m6 l4">
                              <div class="input-field">
                                  {!! Form::text('progClave', 'ARQ', array('id' => 'progClave', 'class' => 'validate','min'=>'0', 'maxlength' => 3, "required")) !!}
                                  {!! Form::label('progClave', 'Clave de Escuela | Programa', array('class' => '')); !!}
                              </div>
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
                  <div class="col s12 m6 l4">
                      {!! Form::label('curEstados', 'Estado del Curso', ['class' => '']); !!}
                      <select name="curEstados" id="curEstados" class="browser-default validate select2" style="width: 100%;">
                          <option value="RPCA">Solo Regulares, Preinscritos y Condicionados</option>
                          <option value="B">Solo Bajas en el curso</option>
                          <option value="X">Todos los alumnos (incluye bajas)</option>
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

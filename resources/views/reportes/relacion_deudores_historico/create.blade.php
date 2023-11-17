@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación Histórico de Deudores</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_deudores_historico/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación Histórico de Deudores</span>
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
                              <option value="I">PERIODO/AÑO DONDE TIENE DEUDA</option>
                          </select>
                      </div>
                </div>
                 <div class="row">
                      <div class="col s12 m6 l4">
                          {!! Form::label('tipoReporte', 'Seleccionar filtro de reporte', ['class' => '']); !!}
                          <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                              <!-- <option value="campus">CAMPUS | DEPARTAMENTO (NIVEL)</option> -->
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
                </div>

                <div class="row">
                      <div class="col s12 m6 l4">
                          <div class="input-field">
                              {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0', 'maxlength' => 3, "required")) !!}
                              {!! Form::label('progClave', 'Clave del Programa de Estudios', array('class' => '')); !!}
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

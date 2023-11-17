@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Mejores promedios</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_mejores_promedios_anuales.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Mejores promedios</span>
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
                <label for="formato">Formato del reporte*</label>
                <select class="browser-default validate select2" data-formato="{{old('formato')}}" id="formato" name="formato" style="width:100%" required>
                  <option value="PDF">PDF</option>
                  <option value="Excel">Excel</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4" style="margin-top:10px;">
                  {!! Form::label('numeroAlumnos', 'Mejores promedios', ['class' => '']); !!}
                  <select name="numeroAlumnos" id="numeroAlumnos" class="browser-default validate select2" style="width: 100%;">
                    <option value="10">10 Alumnos</option>
                    <option value="15">15 Alumnos</option>
                    <option value="20">20 Alumnos</option>
                    <option value="0">Grupos completos</option>
                  </select>
                </div>
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('numeroDecimales', 'Número de decimales en los promedios', ['class' => '']); !!}
                <select name="numeroDecimales" id="numeroDecimales" class="browser-default validate select2" style="width: 100%;">
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                  {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          @php
                              $selected = '';

                              $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                              if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                  echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                              } else {
                                  if ($ubicacion->id == old("ubicacion_id")) {
                                      $selected = 'selected';
                                  }

                                  echo '<option value="'.$ubicacion->id.'" '. $selected .'>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                              }
                          @endphp
                      @endforeach
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id"
                      data-departamento-id="{{old('departamento_id')}}"
                      class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                  <select id="escuela_id"
                      data-escuela-id="{{old('escuela_id')}}"
                      class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">            
              <div class="col s12 m6 l4">
                  {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                  <select id="programa_id"
                      data-programa-id="{{old('programa_id')}}"
                      class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                  <select id="plan_id"
                      data-plan-id="{{old('plan_id')}}"
                      class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>           
              <div class="col s12 m6 l4">
                {!! Form::label('periodo_id', 'Periodo (ultimo ciclo escolar concluido) *', array('class' => '')); !!}
                <select id="periodo_id"
                    data-plan-id="{{old('periodo_id')}}"
                    class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>   

            <div class="row">
              <div class="col s12 m6 l4">
                <p class="center-align">Rango de semestres</p>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('grado1', NULL, array('id' => 'grado1', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('grado1', 'A partir de:', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('grado2', NULL, array('id' => 'grado2', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('grado2', 'Hasta:', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
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

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_todos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')



@endsection
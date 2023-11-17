@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de inscritos</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/preescolar_resumen_inscritos/imprimir', 'method' => 'GET']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de inscritos</span>
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
                {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '',]); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" required style="width: 100%;" required>
                  <option value="I" selected>Inscritos</option>
                  <option value="P">Preinscritos y condicionados</option>
                </select>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="ubicacion_id">Ubicación *</label>
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                        @php
                        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                        $selected = '';
                        if($ubicacion->id == $ubicacion_id){
                        $selected = 'selected';
                        }
                        @endphp
                        <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento *</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>       
              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela *</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>      
            </div>

            <div class="row">              
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo *</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>
            </div>

            <div class="card-action">
              {!! Form::button('<i class="material-icons left ">keyboard_arrow_down</i> GENERAR EXCEL', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
            </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
</div>
</div>

  {{-- Script de funciones auxiliares  --}}
  {{--
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  --}}

@endsection


@section('footer_scripts')

@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas_todos')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')

@endsection

@extends('layouts.dashboard')

@section('template_title')
Reporte de calificaciones por grupo
@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Lista de calificaciones faltantes</a>
@endsection

@section('content')

@php
$ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
$perActual = Auth::user()->empleado->escuela->departamento->perActual;
@endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' =>
    'secundaria_reporte.calificacion_faltante.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">REPORTE DE CALIFICACIONES FALTANTES</span>
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
              <label for="ubicacion_id">Ubicación*</label>
              <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                style="width: 100%;">
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
              <label for="departamento_id">Departamento*</label>
              <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="escuela_id">Escuela*</label>
              <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
              </select>
            </div>
          </div>

          <div class="row">

            <div class="col s12 m6 l4">
              <label for="programa_id">Programa*</label>
              <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="plan_id">Plan</label>
              <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
            <div class="col s12 m6 l4">
              <label for="periodo_id">Periodo*</label>
              <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id', $perActual)}}"
                class="browser-default validate select2" style="width:100%;" required>
                <option value="">SELECCIONE UNA OPCIÓN</option>
              </select>
            </div>
          </div>





        </div>

        <div class="row">
          <div id="vistaPorMes" class="col s12 m6 l4">
            <label for="mesEvaluar">Mes a consultar *</label>
            <select required name="mesEvaluar" id="mesEvaluar" data-mesEvaluar-id="{{old('mesEvaluar')}}"
              class="browser-default validate select2" style="width:100%;">
              <option value="">SELECCIONE UNA OPCIÓN</option>
              <option value="Septiembre">SEPTIEMBRE</option>
              <option value="Octubre">OCTUBRE</option>
              <option value="Noviembre">NOVIEMBRE</option>
              <option value="Diciembre">DICIEMBRE</option>
              <option value="Enero">ENERO</option>
              <option value="Febrero">FEBRERO</option>
              <option value="Marzo">MARZO</option>
              <option value="Abril">ABRIL</option>
              <option value="Mayo">MAYO</option>
              <option value="Junio">JUNIO</option>
            </select>
          </div>


        </div>


      </div>
    </div>
    <div class="card-action">
      {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large
      waves-effect darken-3','type' => 'submit']) !!}
    </div>
  </div>
  {!! Form::close() !!}
</div>
</div>



@endsection

@section('footer_scripts')

@include('secundaria.scripts.preferencias_espesificas')
@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')

@endsection
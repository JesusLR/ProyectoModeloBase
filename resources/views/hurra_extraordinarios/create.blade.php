@extends('layouts.dashboard')

@section('template_title')
    Hurra Extraordinarios
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Hurra Extraordinarios</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'hurra_extraordinarios/generar', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Hurra Extraordinarios</span>
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
                <label for="ubicacion_id">Ubicación</label>
                <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" name="ubicacion_id" id="ubicacion_id" style="width:100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @foreach($ubicaciones as $ubicacion)
                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col 12 m6 l4">
                <div class="input-field">
                  <input type="number" name="perNumero" id="perNumero" value="{{old('perNumero')}}" class="validate" required>
                  <label for="perNumero">Periodo*</label>
                </div>
              </div>
              <div class="col 12 m6 l4">
                <div class="input-field">
                  <input type="number" name="perAnio" id="perAnio" value="{{old('perAnio')}}" class="validate" required>
                  <label for="perAnio">Año*</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR ARCHIVO', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

<script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    apply_data_to_select('ubicacion_id', 'ubicacion-id');
  });
</script>
@endsection

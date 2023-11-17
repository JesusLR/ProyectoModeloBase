@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Mejor Promedio Total</a>
@endsection

@section('content')

@php
  $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/mejor_promedio_total/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Mejor promedio total</span>
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
                <label for="formato">Formato de reporte*</label>
                <select class="browser-default validate select2" data-formato="{{old('formato')}}" id="formato" name="formato" style="width:100%;" required>
                  <option value="PDF">PDF</option>
                  <option value="Excel">Excel</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <label for="ubicacion_id">Ubicación*</label>
                <select name="ubicacion_id" id="ubicacion_id" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @foreach($ubicaciones as $ubicacion)
                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="departamento_id">Departamento*</label>
                <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo*</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                  {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate')) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
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

  {{-- Script de funciones auxxiliares --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript'))!!}
@endsection


@section('footer_scripts')

  <script type="text/javascript">
    $(document).ready(function() {
      var ubicacion = $('#ubicacion_id');
      var departamento = $('#departamento_id');

      var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
      if(ubicacion_id) {
        ubicacion.val(ubicacion_id).select2();
        getDepartamentos(ubicacion_id);
      }

      ubicacion.on('change', function() {
        this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
      });

      departamento.on('change', function() {
        this.value ? getPeriodos(this.value) : resetSelect('periodo_id');
      });
    });
  </script>

@endsection
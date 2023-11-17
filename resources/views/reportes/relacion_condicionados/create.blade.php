@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Condicionados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_condicionados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Condicionados</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          @php
            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
          @endphp

          {{-- GENERAL BAR--}}
          <div id="filtros">

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('curEstado', 'Estado del curso (tipo de condicionado) *', array('class' => '')); !!}
                <select id="curEstado" name="curEstado" class="browser-default validate select2" style="width:100%;">
                  <option value="">TODOS</option>
                  <option value="C">C</option>
                  <option value="A">A</option>
                  <option value="X">X</option>
                </select>
              </div>
            </div>
           
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('ubicacion_id', 'Ubicacion *', array('class' => '')); !!}
                  <select id="ubicacion_id" name="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" name="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                  <select id="periodo_id" name="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                  <select id="escuela_id" name="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                  <select id="programa_id" name="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
            </div>


          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
  
  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection


@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {

    var curEstado = {!! json_encode(old('curEstado')) !!};
    $('#curEstado').val(curEstado).select2();

    var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id)!!};
    $('#ubicacion_id').val(ubicacion_id).select2();

    ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');

    $('#ubicacion_id').on('change', function() {
      ubicacion_id = $(this).val();
      ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
    });

    $('#departamento_id').on('change', function() {
      var departamento_id = $(this).val();
      if(departamento_id) {
        getPeriodos(departamento_id, 'periodo_id');
        getEscuelas(departamento_id, 'escuela_id');
      } else {
        resetSelect('periodo_id');
        resetSelect('escuela_id');
      }
    });

    $('#escuela_id').on('change', function() {
      var escuela_id = $(this).val();
      escuela_id ? getProgramas(escuela_id, 'programa_id') : resetSelect('programa_id');
    });




  });
</script>

@endsection
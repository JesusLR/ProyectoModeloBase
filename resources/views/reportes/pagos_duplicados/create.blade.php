@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Pagos Duplicados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/pagos_duplicados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Pagos Duplicados</span>
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
                {!! Form::label('ubicacion_id', 'Ubicacion', array('class' => '')); !!}
                <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @foreach($ubicaciones as $ubicacion)
                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <br>
            <div class="row">
              <b>Buscar pagos realizados entre las siguientes fechas:</b>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('fecha1', 'fecha 1', array('class' => '')); !!}
                  <input type="date" name="fecha1" id="fecha1" class="validate" value="{{old('fecha1')}}" required>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('fecha2', 'fecha 2', array('class' => '')); !!}
                  <input type="date" name="fecha2" id="fecha2" class="validate" value="{{old('fecha2')}}" required>
                </div>
              </div>
            </div>
           
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('pagAnioPer',NULL, array('id' => 'pagAnioPer', 'class' => 'validate','min'=>'1997','max'=>$fechaActual->year)) !!}
                  {!! Form::label('pagAnioPer', 'Año de Inicio de curso', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('pagConcPago', NULL, array('id' => 'pagConcPago', 'class' => 'validate')) !!}
                  {!! Form::label('pagConcPago', 'Concepto de pago', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                  {!! Form::label('aluClave', 'Clave de pago (Alumno)', array('class' => '')); !!}
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

    var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
    ubicacion_id && $('#ubicacion_id').val(ubicacion_id).select2();
    ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');

    $('#ubicacion_id').on('change', function() {
      ubicacion_id = $(this).val();
      ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
    });

    $('#departamento_id').on('change', function() {
      var departamento_id = $(this).val();
      departamento_id ? getEscuelas(departamento_id, 'escuela_id') : resetSelect('escuela_id');
    });




  });
</script>

@endsection
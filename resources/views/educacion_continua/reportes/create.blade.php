@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Relación de programas</a>
@endsection

@section('content')

@php
  use App\clases\personas\MetodosPersonas;
  $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_educontinua/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RELACIÓN DE PROGRAMAS</span>

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
                  <label for="ubicacion_id">Ubicacion</label>
                  <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option>SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo</label>
                  <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela</label>
                  <select name="escuela_id" id="escuela_id" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('tipoprograma_id', 'Tipo programa', ['class' => '']); !!}
                  <select name="tipoprograma_id" id="tipoprograma_id" data-tipoprograma-id="{{old('tipoprograma_id')}}" class="browser-default validate select2" style="width: 100%;">
                    <option value="">Seleccionar</option>
                    @foreach($tiposPrograma as $key => $item)
                      <option value="{{$item->id}}">{{$item->tpNombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecClave', old('ecClave'), array('id' => 'ecClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('ecClave', 'Clave prog.', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecNombre', old('ecNombre'), array('id' => 'ecNombre', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('ecNombre', 'Nombre del programa', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecFechaRegistro', 'Fecha registro', array('class' => '')); !!}
                  {!! Form::date('ecFechaRegistro', old('ecFechaRegistro'), array('id' => 'ecFechaRegistro', 'class' => 'validate','min'=>'0')) !!}
                </div>
              </div>



                <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecCoordinador_empleado_id', 'Coordinador', array('class' => '')); !!}
                    <select id="ecCoordinador_empleado_id" data-ec-coordinador="{{old('ecCoordinador_empleado_id')}}" class="browser-default validate select2" name="ecCoordinador_empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}" >{{MetodosPersonas::nombreCompleto($empleado->persona)}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecInstructor1_empleado_id', 'Instructor 1', array('class' => '')); !!}
                    <select id="ecInstructor1_empleado_id" data-ec-instructor1="{{old('ecInstructor1_empleado_id')}}" class="browser-default validate select2" name="ecInstructor1_empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}" >{{MetodosPersonas::nombreCompleto($empleado->persona)}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecInstructor2_empleado_id', 'Instructor 2', array('class' => '')); !!}
                    <select id="ecInstructor2_empleado_id" data-ec-instructor2="{{old('ecInstructor2_empleado_id')}}" class="browser-default validate select2" name="ecInstructor2_empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}" >{{MetodosPersonas::nombreCompleto($empleado->persona)}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecEstado', 'Estado', array('class' => '')); !!}
                    <select name="ecEstado" id="ecEstado" data-ec-estado="{{old('ecEstado')}}" class="browser-default validate select2" style="width: 100%;">
                        <option value="">SELECCIONAR</option>
                        <option value="A">ABIERTO</option>
                        <option value="C">CERRADO</option>
                    </select>
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

  <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection


@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let ubicacion = $('#ubicacion_id');
    let departamento = $('#departamento_id');

    apply_data_to_select('tipoprograma_id', 'tipoprograma-id');
    apply_data_to_select('ecCoordinador_empleado_id', 'ec-coordinador');
    apply_data_to_select('ecInstructor1_empleado_id', 'ec-instructor1');
    apply_data_to_select('ecInstructor2_empleado_id', 'ec-instructor2');
    apply_data_to_select('ecEstado', 'ec-estado');

    let ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
    if(ubicacion_id) {
      ubicacion.val(ubicacion_id).select2();
      getDepartamentos(ubicacion_id);
    }

    ubicacion.on('change', function() {
      this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
    });

    departamento.on('change', function() {
      if(this.value) {
        getPeriodos(this.value);
        getEscuelas(this.value); 
      } else { 
        resetSelect('periodo_id');
        resetSelect('escuela_id');
      }
    });

  });
</script>
@endsection
@extends('layouts.dashboard')

@section('template_title')
    Programa edu. continua
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('progeducontinua')}}" class="breadcrumb">Lista de Programas</a>
    <label class="breadcrumb">Agregar Programa</label>
@endsection

@section('content')

@php
  use App\clases\personas\MetodosPersonas;
  $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'progeducontinua.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PROGRAMA</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                  <select id="ubicacion_id" class="browser-default validate select2" name="ubicacion_id" style="width: 100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" class="browser-default validate select2" name="departamento_id" style="width: 100%;" data-departamento-id="{{old('departamento_id')}}" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                  <select id="escuela_id" class="browser-default validate select2" name="escuela_id" style="width: 100%;" data-escuela-id="{{old('escuela_id')}}" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                  <select id="periodo_id" class="browser-default validate select2" name="periodo_id" style="width: 100%;" data-periodo-id="{{old('periodo_id')}}" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                    {!! Form::date('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                    {!! Form::date('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                  </div>
                </div>
              </div>




              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecClave', NULL, array('id' => 'ecClave', 'class' => 'validate','required','maxlength'=>'15')) !!}
                    {!! Form::label('ecClave', 'Clave programa *', []); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecNombre', NULL, array('id' => 'ecNombre', 'class' => 'validate','required')) !!}
                    {!! Form::label('ecNombre', 'Nombre programa *', []); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('tipoprograma_id', 'Tipo programa *', []); !!}
                  <select id="tipoprograma_id" class="browser-default validate select2" data-tipoprograma="{{old('tipoprograma_id')}}" name="tipoprograma_id" style="width: 100%;" required>
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($tiposPrograma as $tipoPrograma)
                      <option value="{{$tipoPrograma->id}}">{{$tipoPrograma->tpNombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ecFechaRegistro', 'Fecha registro *', []); !!}
                  {!! Form::date('ecFechaRegistro', old('ecFechaRegistro') ?: $fechaActual, array('id' => 'ecFechaRegistro', 'class' => 'validate','required')) !!}
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ecCoordinador_empleado_id', 'Empleado coordinador *', []); !!}
                  <select id="ecCoordinador_empleado_id" class="browser-default validate select2" data-ec-coordinador="{{old('ecCoordinador_empleado_id')}}" name="ecCoordinador_empleado_id" style="width: 100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($empleados as $empleado)
                      <option value="{{$empleado->id}}">{{MetodosPersonas::nombreCompleto($empleado->persona)}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecInstructor1_empleado_id', 'Instructor uno', []); !!}
                  <select id="ecInstructor1_empleado_id" class="browser-default validate select2" data-ec-instructor1="{{old('ecInstructor1_empleado_id')}}" name="ecInstructor1_empleado_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($empleados as $empleado)
                      <option value="{{$empleado->id}}">{{MetodosPersonas::nombreCompleto($empleado->persona)}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecInstructor2_empleado_id', 'Instructor dos', []); !!}
                  <select id="ecInstructor2_empleado_id" class="browser-default validate select2" data-ec-instructor2="{{old('ecInstructor2_empleado_id')}}" name="ecInstructor2_empleado_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($empleados as $empleado)
                      <option value="{{$empleado->id}}">{{MetodosPersonas::nombreCompleto($empleado->persona)}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ecEstado', 'Estado del programa *', []); !!}
                  <select id="ecEstado" class="browser-default validate select2" data-ec-estado="{{old('ecEstado')}}" name="ecEstado" style="width: 100%;" required>
                      <option value="A">ABIERTO</option>
                      <option value="C">CERRADO</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m12 l12">
                  <h5>Cuotas y fechas de vencimiento</h5>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImporteInscripcion', old('ecImporteInscripcion'), array('id' => 'ecImporteInscripcion', 'class' => 'validate')) !!}
                    {!! Form::label('ecImporteInscripcion', 'Inscripcion', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoInscripcion', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoInscripcion', old('ecVencimientoInscripcion') ?: $fechaActual, array('id' => 'ecVencimientoInscripcion', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago8', old('ecImportePago8'), array('id' => 'ecImportePago8', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago8', 'Inscripción 2', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago8', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago8', old('ecVencimientoPago8') ?: $fechaActual, array('id' => 'ecVencimientoPago8', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago1', old('ecImportePago1'), array('id' => 'ecImportePago1', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago1', 'Importe pago 1', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago1', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago1', old('ecVencimientoPago1') ?: $fechaActual, array('id' => 'ecVencimientoPago1', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago2', old('ecImportePago2'), array('id' => 'ecImportePago2', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago2', 'Importe pago 2', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago2', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago2', old('ecVencimientoPago2') ?: $fechaActual, array('id' => 'ecVencimientoPago2', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago3', old('ecImportePago3'), array('id' => 'ecImportePago3', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago3', 'Importe pago 3', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago3', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago3', old('ecVencimientoPago3') ?: $fechaActual, array('id' => 'ecVencimientoPago3', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago4', old('ecImportePago4'), array('id' => 'ecImportePago4', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago4', 'Importe pago 4', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago4', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago4', old('ecVencimientoPago4') ?: $fechaActual, array('id' => 'ecVencimientoPago4', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago5', old('ecImportePago5'), array('id' => 'ecImportePago5', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago5', 'Importe pago 5', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago5', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago5', old('ecVencimientoPago5') ?: $fechaActual, array('id' => 'ecVencimientoPago5', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago6', old('ecImportePago6'), array('id' => 'ecImportePago6', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago6', 'Importe pago 6', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago6', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago6', old('ecVencimientoPago6') ?: $fechaActual, array('id' => 'ecVencimientoPago6', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago7', old('ecImportePago7'), array('id' => 'ecImportePago7', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago7', 'Importe pago 7', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m7 l4">
                  {!! Form::label('ecVencimientoPago7', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago7', old('ecVencimientoPago7') ?: $fechaActual, array('id' => 'ecVencimientoPago7', 'class' => 'validate')) !!}
                </div>
              </div>



            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
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
    let periodo = $('#periodo_id');
    let escuela = $('#escuela_id');

    apply_data_to_select('tipoprograma_id', 'tipoprograma');
    apply_data_to_select('ecCoordinador_empleado_id', 'ec-coordinador');
    apply_data_to_select('ecInstructor1_empleado_id', 'ec-instructor1');
    apply_data_to_select('ecInstructor2_empleado_id', 'ec-instructor2');
    apply_data_to_select('ecEstado', 'ec-estado');

    var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
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

    periodo.on('change', function() {
      this.value ? periodo_fechasInicioFin(this.value) : emptyElements(['perFechaInicial', 'perFechaFinal']);
    });

  });
</script>

@endsection
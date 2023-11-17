@extends('layouts.dashboard')

@section('template_title')
    Cuota
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('pagos/registro_cuotas')}}" class="breadcrumb">Lista de cuotas</a>
    <label class="breadcrumb">Agregar cuota</label>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'registroCuotas.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CUOTA</span>

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
                  <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" required name="ubicacion_id" style="width: 100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('escClave', 'Tipo Cuota', array('class' => '')); !!}
                    <select name="cuoTipo" id="cuoTipo" class="browser-default validate select2" data-cuo-tipo="{{old('cuoTipo')}}" required style="width: 100%;">
                      <option value="E">ESCUELA</option>
                      <option value="D">DEPARTAMENTO</option>
                      <option value="P">PROGRAMA</option>
                    </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                  <select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}"  name="departamento_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                  <select id="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}"  name="escuela_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                  <select id="programa_id" class="browser-default validate select2" data-programa-id="{{old('programa_id')}}"  name="programa_id" style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <hr>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoAnio', old('cuoAnio'), array('id' => 'cuoAnio', 'class' => 'validate')) !!}
                    {!! Form::label('cuoAnio', 'Año inicio curso *', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImportePadresFamilia', old('cuoImportePadresFamilia'), array('id' => 'cuoImportePadresFamilia', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImportePadresFamilia', 'Importe PadFam/Incorpo. UADY', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteOrdinarioUady', old('cuoImporteOrdinarioUady'), array('id' => 'cuoImporteOrdinarioUady', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteOrdinarioUady', 'Importe Exam. Ord. UADY', array('class' => '')); !!}
                  </div>
                </div>
              </div>


              
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad10', old('cuoImporteMensualidad10'), array('id' => 'cuoImporteMensualidad10', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad10', 'Importe Mensualidad 10 Meses', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad11', old('cuoImporteMensualidad11'), array('id' => 'cuoImporteMensualidad11', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad11', 'Importe Mensualidad 11 Meses', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad12', old('cuoImporteMensualidad12'), array('id' => 'cuoImporteMensualidad12', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad12', 'Importe Mensualidad 12 Meses', array('class' => '')); !!}
                  </div>
                </div>
              </div>


                            
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteVencimiento', old('cuoImporteVencimiento'), array('id' => 'cuoImporteVencimiento', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteVencimiento', 'Importe Cargo Mes Vencido', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteProntoPago', old('cuoImporteProntoPago'), array('id' => 'cuoImporteProntoPago', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteProntoPago', 'Importe Descto Pronto Pago', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoDiasProntoPago', old('cuoDiasProntoPago'), array('id' => 'cuoDiasProntoPago', 'class' => 'validate')) !!}
                    {!! Form::label('cuoDiasProntoPago', 'Num. de Dias Pronto Pago', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoNumeroCuenta', old('cuoNumeroCuenta'), array('id' => 'cuoNumeroCuenta', 'class' => 'validate')) !!}
                    {!! Form::label('cuoNumeroCuenta', 'Número de cuenta o convenio', array('class' => '')); !!}
                  </div>
                </div>

              </div>


              <div class="row">
                <div class="col s12 m12 l12">
                  <hr>
                  <h5>Inscripción</h5>
                  <p>Importes</p>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion1', old('cuoImporteInscripcion1'), array('id' => 'cuoImporteInscripcion1', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion1', 'Primer Plazo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion1', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion1', \Carbon\Carbon::now(), array('id' => 'cuoFechaLimiteInscripcion1', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion2', old('cuoImporteInscripcion2'), array('id' => 'cuoImporteInscripcion2', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion2', 'Segundo Plazo', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion2', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion2', \Carbon\Carbon::now(), array('id' => 'cuoFechaLimiteInscripcion2', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion3', old('cuoImporteInscripcion3'), array('id' => 'cuoImporteInscripcion3', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion3', 'Tercer Plazo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion3', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion3', \Carbon\Carbon::now(), array('id' => 'cuoFechaLimiteInscripcion3', 'class' => 'validate')) !!}
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

  <script type="text/javascript" src={{asset('js/funcionesAuxiliares.js')}}></script>

@endsection

@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function() {
    let ubicacion = $('#ubicacion_id');
    let departamento = $('#departamento_id');
    let escuela = $('#escuela_id');

    apply_data_to_select('ubicacion_id', 'ubicacion-id');
    apply_data_to_select('cuoTipo', 'cuo-tipo');

    ubicacion.val() && getDepartamentosListaCompleta(ubicacion.val());
    ubicacion.on('change', function() {
      this.value ? getDepartamentosListaCompleta(this.value) : resetSelect('departamento_id');
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

    escuela.on('change', function() {
      this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

  });
</script>

@endsection
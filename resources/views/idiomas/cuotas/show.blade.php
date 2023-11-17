@extends('layouts.dashboard')

@section('template_title')
    Idiomas cuota
@endsection


@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_cuota')}}" class="breadcrumb">Lista de cuotas</a>
    <label class="breadcrumb">Ver de cuota</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CUOTA #{{$cuota->id}}</span>

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
                        <div class="input-field">
                            {!! Form::text('programa_id', $cuota->progClave, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Clave de programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoAnioPago', $cuota->cuoAnioPago, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoAnioPago', 'Año inicio curso', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoDescuentoMensualidad', $cuota->cuoDescuentoMensualidad, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoDescuentoMensualidad', 'Descuento Mensualidad', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoDescuentoInscripcion', $cuota->cuoDescuentoInscripcion, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoDescuentoInscripcion', 'Descuento Inscripción', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteMensualidad', $cuota->cuoImporteMensualidad, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoImporteMensualidad', 'Importe Mensualidad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteVencimiento', $cuota->cuoImporteVencimiento, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoImporteVencimiento', 'Importe Vencimiento', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoNumeroCuenta', $cuota->cuoNumeroCuenta, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoNumeroCuenta', 'Numero de cuenta', array('class' => '')); !!}
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
                            {!! Form::text('cuoImporteInscripcion1', $cuota->cuoImporteInscripcion1, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoImporteInscripcion1', 'Primer Plazo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripcion1', 'Fecha Límite', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripcion1', $cuota->cuoFechaInscripcion1, array('readonly' => 'true')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteInscripcion2', $cuota->cuoImporteInscripcion2, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoImporteInscripcion2', 'Segundo Plazo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripcion2', 'Fecha Límite', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripcion2', $cuota->cuoFechaInscripcion2, array('readonly' => 'true')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteInscripcion3', $cuota->cuoImporteInscripcion3, array('readonly' => 'true')) !!}
                            {!! Form::label('cuoImporteInscripcion3', 'Tercer Plazo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripicion3', 'Fecha Límite', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripicion3', $cuota->cuoFechaInscripicion3, array('readonly' => 'true')) !!}
                    </div>
                </div>

          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Pagos Recibidos de Deudores</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_deudores_pagos_anuales/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Pagos Recibidos de Deudores</span>
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
                    <label for="tipo_reporte">Tipo reporte*</label>
                    <select class="browser-default validate select2" data-tipo-reporte="{{old('tipo_reporte')}}" id="tipo_reporte" name="tipo_reporte" style="width:100%;" required>
                      <option value="PDF">PDF</option>
                      <option value="EXCEL">Excel</option>
                    </select>
                  </div>
                </div>

                 <div class="row">
                      <div class="col s12 m6 l6">
                          {!! Form::label('tipoResumen', 'Seleccionar tipo de reporte', ['class' => '']); !!}
                          <select name="tipoResumen" id="tipoResumen" class="browser-default validate select2" style="width: 100%;">
                                {{-- <option value="0">CUALQUIER PAGO RECIBIDO</option>--}}
                                <option value="mayorIgual">PAGOS RECIBIDOS MAYOR O IGUAL A CANTIDAD DEFINIDA</option>
                          </select>
                      </div>

                     <div class="col s12 m6 l6">
                         <div class="input-field">
                             {!! Form::number('montoDinero', 8000, array('id' => 'montoDinero', 'class' => 'validate','min'=>'0','max'=>1000000000, "required")) !!}
                             {!! Form::label('montoDinero', 'Cantidad definida $', array('class' => '')); !!}
                         </div>
                     </div>
                 </div>

            <hr>

            <div class="row">
                    <div class="col s12 m6 l6">
                          {!! Form::label('ubiClave', 'Seleccionar la Clave del Campus', ['class' => '']); !!}
                          <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;">
                              <option value="CME">CME | Mérida</option>
                              <option value="CVA">CVA | Valladolid</option>
                              <option value="CCH">CCH | Chetumal</option>
                          </select>
                    </div>
                    <div class="col s12 m6 l6">
                        {!! Form::label('depClave', 'Seleccionar la Clave del Departamento', ['class' => '']); !!}
                        <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;">
                            <option value="MAT">MAT | Maternal</option>
                            <option value="PRE">PRE | Preescolar</option>
                            <option value="PRI">PRI | Primaria</option>
                            <option value="SEC">SEC | Secundaria</option>
                            <option value="BAC">BAC | Bachiller</option>
                            <option value="SUP">SUP | Superior</option>
                            <option value="POS">POS | Posgrado</option>
                        </select>
                    </div>


            </div>



            <div class="row">

                <div class="col s12 m6 l6">
                    <div class="input-field">
                        {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0', 'maxlength' => 3)) !!}
                        {!! Form::label('escClave', 'Clave de la Escuela', array('class' => '')); !!}
                    </div>
                </div>


                <div class="col s12 m6 l6">
                    {!! Form::label('numSemestre', 'Seleccionar el Grado | Semestre', ['class' => '']); !!}
                    <select name="numSemestre" id="numSemestre" class="browser-default validate select2" style="width: 100%;">
                        <option value="0">Todos</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                    </select>
                </div>

            </div>

              <div class="row">
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::number('perAnio', $anioActual->year - 1, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                          {!! Form::label('perAnio', 'Año de inicio del curso escolar (Periodo # 3)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l6">
                      {!! Form::label('pagConcPago', 'Seleccionar el Concepto de Pago', ['class' => '']); !!}
                      <select name="pagConcPago" id="pagConcPago" class="browser-default validate select2" style="width: 100%;">
                          <option value="99">Pagos con Claves 99, 00 al 12</option>
                          <option value="10">Solo Pagos de Clave 10 (Junio)</option>
                      </select>
                  </div>
              </div>

            <div class="row">

                <div class="col s12 m4 l4">
                    {!! Form::label('fechaPago', 'Fechas de pago', ['class' => '']); !!}
                    <select name="fechaPago" id="fechaPago" class="browser-default validate select2" style="width: 100%;">
                        <option value="cualquiera">Cualquier fecha a partir del año del periodo 3</option>
                        <option value="rango">Definir un rango de fechas</option>
                    </select>
                </div>

                <div class="col s12 m4 l4">
                    {!! Form::label('iniciaFecha', 'Fecha de inicio', array('class' => '')); !!}
                    <input type="date" name="iniciaFecha" id="iniciaFecha" min="1999-01-01" max="2050-12-31" value="<?php echo date("Y-m-d");?>" required>
                </div>

                <div class="col s12 m4 l4">
                    {!! Form::label('finFecha', 'Fecha final', array('class' => '')); !!}
                    <input type="date" name="finFecha" id="finFecha" min="1999-01-01" max="2050-12-31" value="<?php echo date("Y-m-d");?>" required>
                </div>

            </div>

            {{--
            <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('aluEstado', 'Seleccione alumnos a incluir en el reporte', ['class' => '']); !!}
                    <select name="aluEstado" id="aluEstado" class="browser-default validate select2" style="width: 100%;">
                      @foreach($aluEstado as $key => $value)
                        <option value="{{$key}}" @if(old('aluEstado') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col s12 m6 l4">
                    {!! Form::label('escClave', 'Seleccionar la Clave de escuela', ['class' => '']); !!}
                    <select name="escClave" id="escClave" class="browser-default validate select2" style="width: 100%;">
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                        @foreach($escuelas as $escuela)
                            <option value="{{$escuela->escClave}}">{{$escuela->escClave}} - {{$escuela->escNombre}}</option>
                        @endforeach
                    </select>
                  </div>
            --}}

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
    let tipo_reporte = $('#tipo_reporte');

    apply_data_to_select('tipo_reporte', 'tipo-reporte');

    tipo_reporte.val() ? applyRequired(['escClave']) : unsetRequired(['escClave']);
    tipo_reporte.on('change', function() {
      $(this).val() == 'PDF' ? applyRequired(['escClave']) : unsetRequired(['escClave']);
    });
  });
</script>
@endsection

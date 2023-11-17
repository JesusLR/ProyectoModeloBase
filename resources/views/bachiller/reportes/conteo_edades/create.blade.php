@extends('layouts.dashboard')

@section('template_title')
    Reporte
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Reporte de resumen de edades</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_resumen_edades.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REPORTE DE RESUMEN DE EDADES</span>

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
                        {!! Form::label('tipoReporte', 'Campus *', array('class' => '')); !!}
                        <select id="tipoReporte" class="browser-default validate select2" required name="tipoReporte" style="width: 100%;">
                            <option value="excel">EXCEL</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $selected = '';

                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                        echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    } else {
                                        if ($ubicacion->id == old("ubicacion_id")) {
                                            $selected = 'selected';
                                        }

                                        echo '<option value="'.$ubicacion->id.'" '. $selected .'>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-plan-id="{{old('periodo_id')}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-id="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>                  
                    
                </div>


          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR PDF', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')


@endsection
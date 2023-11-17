@extends('layouts.dashboard')

@section('template_title')
    Bachiller vacionales
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_periodos_vacacionales.index')}}" class="breadcrumb">Lista de períodos vacacionales</a>
    <a href="{{route('bachiller.bachiller_periodos_vacacionales.show', ['id' => $bachiller_periodos_vacaciones->id])}}" class="breadcrumb">Ver período vacacional</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">PERÍODO VACACIONAL</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
                        <input type="text" value="{{$bachiller_periodos_vacaciones->ubiClave}}-{{$bachiller_periodos_vacaciones->ubiNombre}}" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        <input type="text" value="{{$bachiller_periodos_vacaciones->depClave}}-{{$bachiller_periodos_vacaciones->depNombre}}" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        <input type="text" value="BAC-BACHILLERATO" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                        <input type="text" value="{{$bachiller_periodos_vacaciones->perNumero}}-{{$bachiller_periodos_vacaciones->perAnio}}" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perFechaInicial', $bachiller_periodos_vacaciones->perFechaInicial, array('id' => 'perFechaInicial', 'class' =>
                            'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perFechaFinal', $bachiller_periodos_vacaciones->perFechaFinal, array('id' => 'perFechaFinal', 'class' =>
                            'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('pvTipo', 'Tipo *', array('class' => '')); !!}
                        @if ("P" == $bachiller_periodos_vacaciones->pvTipo)
                            @php
                                $respuesta = "Primavera";
                            @endphp
                        @endif
                        @if ("V" == $bachiller_periodos_vacaciones->pvTipo)
                            @php
                                $respuesta = "Verano";
                            @endphp
                        @endif
                        @if ("I" == $bachiller_periodos_vacaciones->pvTipo)
                            @php
                                $respuesta = "Invierno";
                            @endphp
                        @endif
                        {!! Form::text('perFechaInicial', $respuesta, array('id' => 'perFechaInicial', 'class' =>
                        'validate','readonly')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('pvInicio', 'Fecha inicio vacaciones *', ['class' => '']); !!}                       
                        {!! Form::date('pvInicio', $bachiller_periodos_vacaciones->pvInicio, array('id' => 'pvInicio', 'class' =>'validate', 'readonly')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('pvFinal', 'Fecha final vacaciones*', ['class' => '']); !!}
                        {!! Form::date('pvFinal', $bachiller_periodos_vacaciones->pvFinal, array('id' => 'pvFinal', 'class' =>'validate', 'readonly')) !!}
                    </div>
                    
                </div>
                <br>            
               


          </div>
        </div>
    </div>
  </div>


@endsection

@section('footer_scripts')


@endsection
@extends('layouts.dashboard')

@section('template_title')
    Concepto de Pago
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_pago')}}" class="breadcrumb">Lista de Conceptos de pagos</a>
    <a href="{{url('concepto_pago/create')}}" class="breadcrumb">Agregar Concepto</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'concepto_pago.store', 'method' => 'POST']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CONCEPTO</span>

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
                        {!! Form::label('conpClave', 'Clave de concepto *', array('class'=>'')) !!}
                        <input type="number" name="conpClave" id="conpClave" value="" max="99" class="validate" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        {!! Form::label('conpNombre', 'Nombre *', array('class'=>'')) !!}
                        <input type="text" name="conpNombre" id="conpNombre" value="" maxlength="50" class="validate" required>
                    </div>
                    <div class="col s12 m6 l6">
                        {!! Form::label('conpAbreviatura', 'Abreviatura', array('class'=>'')) !!}
                        <input type="text" name="conpAbreviatura" id="conpAbreviatura" value="" maxlength="15" class="validate">
                    </div>
                </div>
                
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' => 'btn-large waves-effect  darken-3', 'type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {{-- {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!} --}}


@endsection

@section('footer_scripts')

<script type="text/javascript">
    $(document).ready(function() {

        console.log('Hola Mundo');

    });


</script>

@endsection
@extends('layouts.dashboard')

@section('template_title')
    Concepto de Pago
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_pago')}}" class="breadcrumb">Lista de Conceptos de pago</a>
    <a href="{{url('concepto_pago/'.$concepto->id.'/edit')}}" class="breadcrumb">Editar Concepto</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['concepto_pago.update', $concepto->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Concepto #{{$concepto->id}}</span>

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
                  {{-- <input type="hidden" name="concepto_id" id="concepto_id" value="{{$concepto->id}}"> --}}
                    <div class="col s12 m6 l4">
                        {!! Form::label('conpClave', 'Clave de concepto *', array('class'=>'')) !!}
                        <input type="text" name="conpClave" id="conpClave" value="{{$concepto->conpClave}}" maxlength="20" class="validate" required readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        {!! Form::label('conpNombre', 'Nombre *', array('class'=>'')) !!}
                        <input type="text" name="conpNombre" id="conpNombre" value="{{$concepto->conpNombre}}" maxlength="50" class="validate" required>
                    </div>
                    <div class="col s12 m6 l6">
                        {!! Form::label('conpAbreviatura', 'Abreviatura', array('class'=>'')) !!}
                        <input type="text" name="conpAbreviatura" id="conpAbreviatura" value="{{$concepto->conpAbreviatura}}" maxlength="15" class="validate">
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
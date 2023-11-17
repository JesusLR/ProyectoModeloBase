@extends('layouts.dashboard')

@section('template_title')
    Concepto de Pago
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('concepto_pago')}}" class="breadcrumb">Lista de Conceptos de Pago</a>
    <a href="{{url('concepto_pago/'.$concepto->id)}}" class="breadcrumb">Ver Concepto</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CONCEPTO #{{$concepto->id}}</span>

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
                        <input type="text" name="conpClave" id="conpClave" value="{{$concepto->conpClave}}"  maxlength="20" class="validate" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        {!! Form::label('conpNombre', 'Nombre *', array('class'=>'')) !!}
                        <input type="text" name="conpNombre" id="conpNombre" value="{{$concepto->conpNombre}}" maxlength="50" class="validate" readonly>
                    </div>
                    <div class="col s12 m6 l6">
                        {!! Form::label('conpAbreviatura', 'Abreviatura', array('class'=>'')) !!}
                        <input type="text" name="conpAbreviatura" id="conpAbreviatura" value="{{$concepto->conpAbreviatura}}" maxlength="15" class="validate" readonly>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection

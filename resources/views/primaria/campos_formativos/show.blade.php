@extends('layouts.dashboard')

@section('template_title')
    Primaria campo formativo
@endsection


@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_campos_formativos.index')}}" class="breadcrumb">Lista de campos formativos</a>
    <label class="breadcrumb">Ver campo formativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CAMPO FORMATIVO #{{$primaria_campos_formativos->id}}</span>

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
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('ubiClave', $primaria_campos_formativos->camFormativos, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campo Formativo', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>
          </div>
        </div>
    </div>
  </div>

@endsection

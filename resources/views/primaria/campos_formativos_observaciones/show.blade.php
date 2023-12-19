@extends('layouts.dashboard')

@section('template_title')
    Primaria materia
@endsection


@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_campos_formativos_observaciones.index')}}" class="breadcrumb">Lista de observaciones campos formativos</a>
    <label class="breadcrumb">Ver campo formativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            {{--  <span class="card-title">CAMPO FORMATIVO OBSERVACIONES#{{$primaria_campos_formativos_observaciones->id}}</span>  --}}

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
                            {!! Form::text('camFormativos', $primaria_campo_formativo_observaciones->camFormativos, array('readonly' => 'true')) !!}
                            {!! Form::label('camFormativos', 'Campo Formativo', array('class' => '')); !!}
                        </div>
                    </div>   
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivelCalificacion', $primaria_campo_formativo_observaciones->nivelCalificacion, array('readonly' => 'true')) !!}
                            {!! Form::label('nivelCalificacion', 'Nivel Calificación', array('class' => '')); !!}
                        </div>
                    </div>   
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('trimestre', $primaria_campo_formativo_observaciones->trimestre, array('readonly' => 'true')) !!}
                            {!! Form::label('trimestre', 'Trimestre', array('class' => '')); !!}
                        </div>
                    </div>  
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="col s12 m6 l12">
                            <div class="input-field">
                                {!! Form::text('observaciones', $primaria_campo_formativo_observaciones->observaciones, array('readonly' => 'true')) !!}
                                {!! Form::label('observaciones', 'Observación', array('class' => '')); !!}
                            </div>
                        </div>                      
                        
                    </div>
                </div> 
                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection

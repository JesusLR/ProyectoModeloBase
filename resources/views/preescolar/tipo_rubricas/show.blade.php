@extends('layouts.dashboard')

@section('template_title')
   Preescolar rúbrica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_tipo_rubricas')}}" class="breadcrumb">Lista de tipo rúbricas</a>
    <label class="breadcrumb">Ver rúbrica</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">RUBRICA #{{$rubrica->id}}</span>

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
                                {!! Form::label('tipo', 'Tipo *', array('class' => '')); !!}
                                {!! Form::text('tipo', $rubrica->tipo, array('readonly' => 'true')) !!}
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('grado', 'Grado *', array('class' => '')); !!}
                                {!! Form::text('grado', $rubrica->grado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre1', 'Trimestre 1', array('class' => '')); !!}
                                {!! Form::text('trimestre1', $rubrica->trimestre1, array('readonly' => 'true')) !!}
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre2', 'Trimestre 2', array('class' => '')); !!}
                                {!! Form::text('trimestre2', $rubrica->trimestre2, array('readonly' => 'true')) !!}
                            </div>

                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre3', 'Trimestre 3', array('class' => '')); !!}
                                {!! Form::text('trimestre3', $rubrica->trimestre3, array('readonly' => 'true')) !!}

                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col s12 m6 l8">
                                <div class="input-field">
                                    {!! Form::textarea('rubrica', $rubrica->rubrica, array('id' => 'rubrica', 'class' => 'materialize-textarea','required','maxlength'=>'255', 'readonly' => 'true')) !!}
                                    {!! Form::label('rubrica', 'Rubrica *', array('class' => '')); !!}
                                </div>
                            </div>                            
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('aplica', 'Aplica *', array('class' => '')); !!}
                                {!! Form::text('aplica', $rubrica->aplica, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </div>
  </div>

@endsection

@section('footer_scripts')


@endsection

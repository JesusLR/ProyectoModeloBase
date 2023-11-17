@extends('layouts.dashboard')

@section('template_title')
   Preescolar rúbrica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_tipo_rubricas')}}" class="breadcrumb">Lista de rubricas</a>
    <label class="breadcrumb">Editar rúbrica</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['preescolar.preescolar_tipo_rubricas.update', $preescolar_rubricas_tipo->id])) }}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">EDITAR RÚBRICA #{{$preescolar_rubricas_tipo->id}}</span>

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
                                    {!! Form::text('progClave', $programa->progClave.'-'.$programa->progNombre, array('id' => 'progClave', 'class' => 'validate','required','maxlength'=>'3', 'readonly')) !!}
                                    {!! Form::label('progClave', 'Programa *', array('class' => '')); !!}
                                </div>
                            </div>
                            <div class="col s12 m6 l8">
                                <div class="input-field">
                                    {!! Form::text('tipo', $preescolar_rubricas_tipo->tipo, array('id' => 'tipo', 'class' => 'validate','maxlength'=>'255')) !!}
                                    {!! Form::label('tipo', 'Tipo *', array('class' => '')); !!}
                                </div>
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

@endsection

@section('footer_scripts')


@endsection

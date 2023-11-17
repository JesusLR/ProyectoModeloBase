@extends('layouts.dashboard')

@section('template_title')
   Preescolar tipo rúbrica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_tipo_rubricas')}}" class="breadcrumb">Lista de rubicas</a>
    <label class="breadcrumb">Agregar tipo rúbrica</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_tipo_rubricas.store', 'method' => 'POST']) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">AGREGAR TIPO RÚBRICA</span>

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
                            <div class="col s12 m6 l8">
                                <div class="input-field">
                                    {!! Form::text('tipo', old('tipo'), array('id' => 'tipo', 'class' => 'validate','maxlength'=>'255')) !!}
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

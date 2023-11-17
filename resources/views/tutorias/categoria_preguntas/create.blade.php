@extends('layouts.dashboard')

@section('template_title')
Categoría pregunta
@endsection

@section('head')
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_categoria_pregunta')}}" class="breadcrumb">Lista de categoría pregunta</a>
<a href="{{url('tutorias_categoria_pregunta/create')}}" class="breadcrumb">Agregar categoría pregunta</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_categoria_pregunta.store', 'method' =>
        'POST']) !!}
        <div class="card">
            <div class="card-content">
                <span class="card-title">AGREGAR CATEGORÍA PREGUNTA</span>
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
                                {!! Form::text('Nombre', NULL, array('id' => 'Nombre', 'class' => 'validate')) !!}
                                {!! Form::label('Nombre', 'Nombre *', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l8">
                            <div class="input-field">
                                {!! Form::text('Descripcion', NULL, array('id' => 'Descripcion', 'class' => 'validate')) !!}
                                {!! Form::label('Descripcion', 'Descripción *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <input type="number" name="orden_visual_categoria" id="orden_visual_categoria" min="1" max="100" class="validate">
                                {!! Form::label('orden_visual_categoria', 'Orden visual de la categoría *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large
                    waves-effect darken-3','type' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')

@endsection
@extends('layouts.dashboard')

@section('template_title')
    Primaria campo formativo
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_campos_formativos.index')}}" class="breadcrumb">Lista de campos formativos</a>
    <label class="breadcrumb">Editar campo formativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_campos_formativos.update', $primaria_campos_formativos->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR CAMPO FORMATIVO #{{$primaria_campos_formativos->id}}</span>

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
                            {!! Form::text('camFormativos', old('camFormativos', $primaria_campos_formativos->camFormativos), array('id' => 'camFormativos', 'class' => '')) !!}
                            {!! Form::label('camFormativos', 'Campo Formativo *', array('class' => '')); !!}
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
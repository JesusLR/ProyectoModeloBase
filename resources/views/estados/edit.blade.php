@extends('layouts.dashboard')

@section('template_title')
    Estados
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('estados')}}" class="breadcrumb">Lista de estados</a>
    <label class="breadcrumb">Editar Estado</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['estados.update', $estado->estado_id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR ESTADO #{{$estado->estado_id}}</span>

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
                    <div class="col s12 m6 l4" style="margin-top:10px;">
                      {!! Form::label('pais', 'Pais'); !!}
                      <select name="pais_id" id="pais_id" class="browser-default validate select2" style="width: 100%;">
                        <option value="" disabled>Seleccionar Pais</option>
                        @foreach ($pais as $item)
                        <option value="{{$item->id}}" {{ $estado->pais_id == $item->id ? 'selected="selected"' : '' }}>{{$item->paisNombre}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('edoNombre', $estado->edoNombre, array('id' => 'edoNombre', 'class' => 'validate','required','maxlenght'=>'50')) !!}
                            {!! Form::label('edoNombre', 'Nombre del Estado', array('class' => '')); !!}
                        </div>
                    </div>
            
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('edoAbrevia', $estado->edoAbrevia, array('id' => 'edoAbrevia', 'class' => 'validate','required','maxlenght'=>'5')) !!}
                            {!! Form::label('edoAbrevia', 'Nombre del Estado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row"> 
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::text('edoRenapo', $estado->edoRenapo, array('id' => 'edoRenapo', 'class' => 'validate','maxlenght'=>'2')) !!}
                          {!! Form::label('edoRenapo', 'Renapo del Estado', array('class' => '')); !!}
                      </div>
                  </div>
          
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::text('edoISO', $estado->edoISO, array('id' => 'edoISO', 'class' => 'validate','maxlenght'=>'3')) !!}
                          {!! Form::label('edoISO', 'ISO del Estado', array('class' => '')); !!}
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

@include('scripts.departamentos')
@include('scripts.escuelas')

@endsection
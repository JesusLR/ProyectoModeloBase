@extends('layouts.dashboard')

@section('template_title')
    Aula
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('aula')}}" class="breadcrumb">Lista de aulas</a>
    <label class="breadcrumb">Editar aula</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
            {{ Form::open(array('method'=>'PUT','route' => ['aula.update', $aula->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR AULA #{{$aula->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$aula->ubicacion->id}}" selected >{{$aula->ubicacion->ubiClave}}-{{$aula->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('aulaClave', $aula->aulaClave, array('id' => 'aulaClave', 'class' => 'validate','required','readonly','maxlength'=>'3')) !!}
                        {!! Form::label('aulaClave', 'Clave *', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('aulaCupo', $aula->aulaCupo, array('id' => 'aulaCupo', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('aulaCupo', 'Cupo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('aulaDescripcion', $aula->aulaDescripcion, ['id' => 'aulaDescripcion', 'class' => 'validate','maxlength'=>'45']) !!}
                        {!! Form::label('aulaDescripcion', 'Descripción', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('aulaUbicacion', $aula->aulaUbicacion, array('id' => 'aulaUbicacion', 'class' => 'validate','maxlength'=>'45')) !!}
                        {!! Form::label('aulaUbicacion', 'Ubicación', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('aulaEdificio', $aula->aulaEdificio, array('id' => 'aulaEdificio', 'class' => 'validate','maxlength'=>'255')) !!}
                        {!! Form::label('aulaEdificio', 'Edificio', ['class' => '']); !!}
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
@include('scripts.departamentos')
@include('scripts.escuelas')
@endsection
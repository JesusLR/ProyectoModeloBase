@extends('layouts.dashboard')

@section('template_title')
    Ubicación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('ubicacion')}}" class="breadcrumb">Lista de ubicaciones</a>
    <label class="breadcrumb">Editar ubicación</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['ubicacion.update', $ubicacion->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR UBICACIÓN #{{$ubicacion->id}}</span>

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
                            {!! Form::text('ubiClave', $ubicacion->ubiClave, array('id' => 'ubiClave', 'class' => 'validate','required','readonly','maxlength'=>'3')) !!}
                            {!! Form::label('ubiClave', 'Clave *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiNombre', $ubicacion->ubiNombre, array('id' => 'ubiNombre', 'class' => 'validate','maxlength'=>'20')) !!}
                            {!! Form::label('ubiNombre', 'Nombre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiCalle', $ubicacion->ubiCalle, array('id' => 'ubiCalle', 'class' => 'validate','maxlength'=>'30')) !!}
                            {!! Form::label('ubiCalle', 'Calle', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                                {!! Form::number('ubiCP', $ubicacion->ubiCP, array('id' => 'ubiCP', 'class' => 'validate','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                                {!! Form::label('ubiCP', 'Código Postal', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                        <select id="estado_id" class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($estados as $estado)
                                <option value="{{$estado->id}}" @if($ubicacion->municipio->estado_id == $estado->id) {{ 'selected' }} @endif>{{$estado->edoNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                        <select id="municipio_id" class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($municipios as $municipio)
                                <option value="{{$municipio->id}}" @if($ubicacion->municipio->id == $municipio->id) {{ 'selected' }} @endif>{{$municipio->munNombre}}</option>
                            @endforeach
                        </select>
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

@include('scripts.estados')
@include('scripts.municipios')

@endsection
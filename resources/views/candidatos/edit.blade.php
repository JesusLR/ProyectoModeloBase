@extends('layouts.dashboard')

@section('template_title')
    Beca
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('beca')}}" class="breadcrumb">Lista de Becas</a>
    <label class="breadcrumb">Editar beca</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
            {{ Form::open(array('method'=>'PUT','route' => ['beca.update', $beca->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Editar beca #{{$beca->id}}</span>

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
                    {!! Form::text('bcaClave', $beca->bcaClave) !!}
                    {!! Form::label('bcaClave', 'cLAVE', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaNombre', $beca->bcaNombre) !!}
                    {!! Form::label('bcaNombre', 'Nombre', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaNombreCorto', $beca->bcaNombreCorto) !!}
                    {!! Form::label('bcaNombreCorto', 'Nombre corto', array('class' => '')); !!}
                  </div>
              </div>

              
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('bcaVigencia', 'Vigencia *', array('class' => '')); !!}
                  <select id="bcaVigencia" class="browser-default validate select2" required name="bcaVigencia" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    <option value="A" {{$beca->bcaVigencia == "A" ? "selected": ""}}>A</option>
                    <option value="S" {{$beca->bcaVigencia == "S" ? "selected": ""}}>S</option>
                  </select>
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
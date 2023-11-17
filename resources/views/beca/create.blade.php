@extends('layouts.dashboard')

@section('template_title')
    Beca
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('beca')}}" class="breadcrumb">Lista de becas</a>
    <label class="breadcrumb">Agregar beca</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'beca.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR BECA</span>

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
                {{--  bcaVigencia --}}
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaClave', NULL, array('id' => 'bcaClave', 'class' => 'validate','required','maxlength'=>'10')) !!}
                    {!! Form::label('bcaClave', 'Clave *', ['class' => '']); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaNombre', NULL, array('id' => 'bcaNombre', 'class' => 'validate','required','maxlength'=>'10')) !!}
                    {!! Form::label('bcaNombre', 'Nombre *', ['class' => '']); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaNombreCorto', NULL, array('id' => 'bcaNombreCorto', 'class' => 'validate','required','maxlength'=>'50')) !!}
                    {!! Form::label('bcaNombreCorto', 'Nombre corto *', ['class' => '']); !!}
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('bcaVigencia', 'Vigencia *', array('class' => '')); !!}
                  <select id="bcaVigencia" class="browser-default validate select2" required name="bcaVigencia" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="A">A</option>
                      <option value="S">S</option>
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
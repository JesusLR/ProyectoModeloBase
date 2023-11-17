@extends('layouts.dashboard')

@section('template_title')
  Inscritos
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Desinscribir alumnos reprobados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'postDesinscribirReprobados', 'method' => 'POST']) !!}
      <div class="card ">
        <div class="card-content">
          <span class="card-title">Desinscribir alumnos reprobados</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="filtros">
            <div class="row">

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('depClave', 'Clave de departamento', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('escClave','Clave de Escuela', array('class' => '')); !!}
                </div> 
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('progClave','Clave de programa', array('class' => '')); !!}
                </div> 
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'período número', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997', "required")) !!}
                  {!! Form::label('perAnio', 'período año', array('class' => '')); !!}
                </div>
              </div>

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate', "required")) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            </div>

          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">save</i> DESINSCRIBIR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
@endsection
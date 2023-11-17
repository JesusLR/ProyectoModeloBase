@extends('layouts.dashboard')

@section('template_title')
    Cierre Extraordinarios
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Cierre de actas(Extraordinario)</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'cierre_extras/realizar', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">CIERRE DE ACTAS</span>
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
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','maxlength'=>'3', "required")) !!}
                  {!! Form::label('ubiClave', 'Clave de campus*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('depClave', 'Clave departamento*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('escClave', 'Clave de Escuela', array('class' => '')); !!}
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'1','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0','max'=>$fechaActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                   {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                   {!! Form::label('planClave', 'Clave de Plan', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('empleado_id', NULL, array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('iexFecha', NULL, array('id' => 'iexFecha', 'class' => 'validate','maxlength'=>'10','data-toggle'=>'tooltip','title'=>'dd/mm/yyyy')) !!}
                   {!! Form::label('iexFecha', 'Fecha de Extraordinario', array('class' => '')); !!}
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">save</i> REALIZAR CIERRE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection


@section('footer_scripts')

@endsection
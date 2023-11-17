@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Estado de Cuenta</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/estado_cuenta/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Estado de cuenta</span>
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
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('aluClave', 'Clave de pago*', array('class' => '')); !!}
                </div>
              </div>
              {{-- <div class="col s12 m6 l4">
                <br>
                <div class="">
                  <input type="checkbox" name="todosLosAnios" id="todosLosAnios" class="validate">
                  {!! Form::label('todosLosAnios', 'Todos los años', array('class' => '')); !!}
                </div>
              </div> --}}
            </div>

            <div class="row">
              
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('pagAnioPer',NULL, array('id' => 'pagAnioPer', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year)) !!}
                    {!! Form::label('pagAnioPer', 'Año', array('class' => '')); !!}
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m12 l6">
                <div class="card-panel amber lighten-5">
                  Si desea obtener los pagos de todos los años cursados del alumno, 
                  deje vacío el campo <b>Año</b>.
                </div>
              </div>
            </div>
            

           



          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')

@endsection
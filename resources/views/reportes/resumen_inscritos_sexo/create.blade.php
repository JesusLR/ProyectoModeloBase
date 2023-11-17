@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de inscritos por género</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/inscritos_sexo/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de inscritos por género</span>
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
              <div class="col s12 m6 l6">
                <div class="input-field">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', 'required')) !!}
                  {!! Form::label('perNumero', 'Número del período *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l6">
                <div class="input-field">
                  {!! Form::text('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year + 1,'required')) !!}
                  {!! Form::label('perAnio', 'Año del período *', array('class' => '')); !!}
                </div>
              </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
</div>
</div>
@endsection


@section('footer_scripts')


@endsection
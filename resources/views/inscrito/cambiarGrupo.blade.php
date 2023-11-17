@extends('layouts.dashboard')

@section('template_title')
  Inscritos
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Cambiar alumno de grupo</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'inscrito/postCambiarGrupo', 'method' => 'POST']) !!}
      <input type="hidden" value="{{$inscrito->id}}" name="inscritoId">
      <div class="card ">
        <div class="card-content">
          <span class="card-title">CAMBIAR ALUMNO DE GRUPO. INSCRITO #{{$inscrito->id}}</span>
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
                {!! Form::label('gpoId', 'Cambiar alumno a grupo', ['class' => '']); !!}
                <select name="gpoId" id="gpoId" class="browser-default validate select2" style="width: 100%;">
                    @foreach($grupos as $key => $value)
                      <option value="{{$value->id}}" {{$inscrito->grupo->id == $value->id ? "selected": ""}}>
                          {{$value->materia->matNombre}} - {{$value->gpoSemestre}}{{$value->gpoClave}}{{$value->gpoTurno}}
                      </option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">save</i> GUARDAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
@endsection
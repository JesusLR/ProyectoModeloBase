@extends('layouts.dashboard')

@section('template_title')
    Hurra Alumnos
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Hurra alumnos</a>
@endsection

@section('content')

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'hurra_alumnos/generar', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Hurra Alumnos</span>
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
                    <input type="number" name="perNumero" id="perNumero" value="{{old('perNumero')}}" class="validate" required>
                    <label for="perNumero">Periodo</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="perAnio" id="perAnio" value="{{old('perAnio')}}" class="validate" required>
                    <label for="perAnio">Año</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('curEstado', 'Estado del curso', array('class' => '')); !!}
                  <select id="curEstado" class="browser-default validate " name="curEstado" style="width: 100%;" required>
                      <option value="B" selected>Sin Bajas</option>
                      <option value="T">TODOS</option>
                  </select>
                </div>
              </div>

          </div>
        </div>

        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR ARCHIVO', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection

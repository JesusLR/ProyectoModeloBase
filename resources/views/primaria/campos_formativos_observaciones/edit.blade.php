@extends('layouts.dashboard')

@section('template_title')
    Primaria observación campo formativo
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_campos_formativos_observaciones.index')}}" class="breadcrumb">Lista de observaciones campos formativos</a>
    <label class="breadcrumb">Editar observacion campo formativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_campos_formativos_observaciones.update', $primaria_campo_formativo_observaciones->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR OBSERVACIÓN CAMPO FORMATIVO #{{$primaria_campo_formativo_observaciones->id}}</span>

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
                  {!! Form::label('primaria_campo_formativo_id', 'Campo Formativo *', array('class' => '')); !!}
                  <select id="primaria_campo_formativo_id" class="browser-default validate select2" required
                      name="primaria_campo_formativo_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach ($primaria_campos_formativos as $item)
                          <option {{ $primaria_campo_formativo_observaciones->primaria_campo_formativo_id == $item->id ? "selected":"" }} value="{{ $item->id }}">{{ $item->camFormativos }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('nivelCalificacion', $primaria_campo_formativo_observaciones->nivelCalificacion, array('id' => 'nivelCalificacion', 'class' => '')) !!}
                        {!! Form::label('nivelCalificacion', 'Nivel Calificación *', array('class' => '')); !!}
                    </div>
                </div>  
                <div class="col s12 m6 l4">
                  {!! Form::label('trimestre', 'Trimestre *', array('class' => '')); !!}
                  <select id="trimestre" class="browser-default validate select2" required
                      name="trimestre" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option {{ $primaria_campo_formativo_observaciones->trimestre == 1 ? "selected":"" }} value="1">1</option>
                      <option {{ $primaria_campo_formativo_observaciones->trimestre == 2 ? "selected":"" }} value="2">2</option>
                      <option {{ $primaria_campo_formativo_observaciones->trimestre == 3 ? "selected":"" }} value="3">3</option>
                  </select>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m6 l12">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('observaciones', $primaria_campo_formativo_observaciones->observaciones, array('id' => 'observaciones', 'class' => '')) !!}
                            {!! Form::label('observaciones', 'Observación', array('class' => '')); !!}
                        </div>
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



@endsection
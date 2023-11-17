@extends('layouts.dashboard')

@section('template_title')
    Estados
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('estados')}}" class="breadcrumb">Lista de estados</a>
    <label class="breadcrumb">Ver Estado</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ESTADO #{{$estado->estado_id}}</span>

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
                  <div class="col s12 m6 l4" style="margin-top:10px;">
                    {!! Form::label('pais', 'Pais'); !!}
                    <select name="pais_id" id="pais_id" class="browser-default validate select2" disabled style="width: 100%;">
                      <option value="" disabled>Seleccionar Pais</option>
                      @foreach ($pais as $item)
                      <option value="{{$item->id}}" {{ $estado->pais_id == $item->id ? 'selected="selected"' : '' }}>{{$item->paisNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('edoNombre', $estado->edoNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('edoNombre', 'Nombre del Estado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('edoAbrevia', $estado->edoAbrevia, array('readonly' => 'true')) !!}
                            {!! Form::label('edoAbrevia', 'Nombre del Estado abreviado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row"> 
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::text('edoRenapo', $estado->edoRenapo, array('readonly' => 'true')) !!}
                          {!! Form::label('edoRenapo', 'Renapo del Estado', array('class' => '')); !!}
                      </div>
                  </div>
          
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::text('edoISO', $estado->edoISO, array('readonly' => 'true')) !!}
                          {!! Form::label('edoISO', 'ISO del Estado', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

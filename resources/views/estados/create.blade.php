@extends('layouts.dashboard')

@section('template_title')
    Estados
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('estados')}}" class="breadcrumb">Lista de estados</a>
    <label class="breadcrumb">Agregar Estado</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'estados.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR ESTADO</span>

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
                      {!! Form::label('pais', 'Pais', ['class' => '']); !!}
                      <select name="pais_id" id="pais_id" class="browser-default validate select2" data-pais-id="{{old('pais_id')}}" required style="width: 100%;">
                        <option value="" disabled>Seleccionar Pais</option>
                        @foreach ($pais as $item)
                        <option value="{{$item->id}}">{{$item->paisNombre}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('edoNombre', old('edoNombre'), array('id' => 'edoNombre', 'class' => 'validate','required','maxlenght'=>'30')) !!}
                            {!! Form::label('edoNombre', 'Nombre del Estado*', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('edoAbrevia', old('edoAbrevia'), array('id' => 'edoAbrevia', 'class' => 'validate','required','maxlenght'=>'10')) !!}
                            {!! Form::label('edoAbrevia', 'Nombre del Estado abreviado*', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row"> 
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::text('edoRenapo', old('edoRenapo'), array('id' => 'edoRenapo', 'class' => 'validate','maxlenght'=>'2')) !!}
                          {!! Form::label('edoRenapo', 'Renapo del Estado', array('class' => '')); !!}
                      </div>
                  </div>
          
                  <div class="col s12 m6 l6">
                      <div class="input-field">
                          {!! Form::text('edoISO', old('edoISO'), array('id' => 'edoISO', 'class' => 'validate','maxlenght'=>'3')) !!}
                          {!! Form::label('edoISO', 'ISO del Estado', array('class' => '')); !!}
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

  <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let pais = $('#pais_id');

    apply_data_to_select('pais_id', 'pais-id');
  });
</script>
@endsection
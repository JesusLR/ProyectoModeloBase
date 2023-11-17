@extends('layouts.dashboard')

@section('template_title')
    Municipios
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('municipios')}}" class="breadcrumb">Lista de municipios</a>
    <label class="breadcrumb">Agregar Municipio</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'municipios.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR MUNICIPIO</span>

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
                      <label for="pais_id">País*</label>
                      <select class="browser-default validate select2" data-pais-id="{{old('pais_id') ?: 1}}" id="pais_id" name="pais_id" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                        @foreach($paises as $pais)
                          <option value="{{$pais->id}}">{{$pais->paisNombre}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col s12 m6 l4">
                      <label for="estado_id">Estado*</label>
                      <select class="browser-default validate select2" data-estado-id="{{old('estado_id')}}" id="estado_id" name="estado_id" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('munNombre', old('munNombre'), array('id' => 'munNombre', 'class' => 'validate','required','maxlenght'=>'50')) !!}
                            {!! Form::label('munNombre', 'Nombre del Municipio*', array('class' => '')); !!}
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

    pais.val() ? getEstados(pais.val()) : resetSelect('estado_id');
    pais.on('change', function() {
      this.value ? getEstados(this.value) : resetSelect('estado_id');
    });

  });
</script>
@endsection
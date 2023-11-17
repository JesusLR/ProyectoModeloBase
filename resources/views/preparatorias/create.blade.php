@extends('layouts.dashboard')

@section('template_title')
    Preparatorias
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preparatorias')}}" class="breadcrumb">Lista de preparatorias</a>
    <label class="breadcrumb">Agregar Preparatoria</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preparatorias.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PREPARATORIA</span>

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
                    <label for="municipio_id">Municipio*</label>
                    <select class="browser-default validate select2" data-municipio-id="{{old('municipio_id')}}" id="municipio_id" name="municipio_id" style="width:100%" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                <div class="row"> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('prepNombre', old('prepNombre'), array('id' => 'prepNombre', 'class' => 'validate','required','maxlenght'=>'255')) !!}
                            {!! Form::label('prepNombre', 'Nombre de la Preparatoria*', array('class' => '')); !!}
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
    let estado = $('#estado_id');

    apply_data_to_select('pais_id', 'pais-id');

    pais.val() ? getEstados(pais.val()) : resetSelect('estado_id');
    pais.on('change', function() {
      this.value ? getEstados(this.value) : resetSelect('estado_id');
    });

    estado.on('change', function() {
      this.value ? getMunicipios(this.value) : resetSelect('municipio_id');
    });
  });
</script>
@endsection
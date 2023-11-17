@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Reporte cuantitativo de Respuesta</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/tutorias/reporte_cuantitativo_respuesta/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Reporte cuantitativo de Respuesta</span>
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
                  <label for="ubicacion_id">Ubicacion*</label>
                  <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" name="ubicacion_id" id="ubicacion_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" id="departamento_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo*</label>
                  <select class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" id="periodo_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela</label>
                  <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="programa_id">Programa</label>
                  <select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" name="programa_id" id="programa_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="plan_id">Plan</label>
                  <select class="browser-default validate select2" data-plan-id="{{old('plan_id')}}" name="plan_id" id="plan_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    <input type="number" name="cgtGradoSemestre" id="cgtGradoSemestre" value="{{old('cgtGradoSemestre')}}" class="validate">
                    <label for="cgtGradoSemestre">Grado</label>
                  </div>
                </div>
              </div>

              <hr>

              <div class="row">
                <p class="center-align"><b>FILTRO DE TUTORIAS</b></p>
                <div class="col s12 m6 l4">
                  <label for="FormularioID">Formulario*</label>
                  <select class="browser-default validate select2" name="FormularioID" id="FormularioID" data-formulario-id="{{old('FormularioID')}}" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($formularios as $formulario)
                      <option value="{{$formulario->FormularioID}}">{{$formulario->Nombre}}</option>
                    @endforeach
                  </select>
                </div>
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

<script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let ubicacion = $('#ubicacion_id');
    let departamento = $('#departamento_id');
    let escuela = $('#escuela_id');
    let programa = $('#programa_id');
    let categoria_pregunta = $('#CategoriaPreguntaID');
    let formulario = $('#FormularioID')
    let pregunta = $('#PreguntaID');

    apply_data_to_select('ubicacion_id', 'ubicacion-id');
    apply_data_to_select('FormularioID', 'formulario-id');
    apply_data_to_select('CategoriaPreguntaID', 'categoria-pregunta-id');
    apply_data_to_select('Semaforizacion', 'semaforizacion');

    ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
    ubicacion.on('change', function() {
      this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
    });

    departamento.on('change', function() {
      if(this.value) {
        getPeriodos(this.value);
        getEscuelas(this.value);
      } else {
        resetSelect('periodo_id');
        resetSelect('escuela_id');
      }
    });

    escuela.on('change', function() {
      this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

    programa.on('change', function() {
      this.value ? getPlanes(this.value) : resetSelect('plan_id');
    });

    formulario.on('change', function() {
      let params = {
        FormularioID: formulario.val(),
        CategoriaPreguntaID: categoria_pregunta.val(),
      };
      params.FormularioID || params.CategoriaPreguntaID ? getTutoriasPreguntas(params) : resetSelect('PreguntaID');
    });

    categoria_pregunta.on('change', function() {
      let params = {
        FormularioID: formulario.val(),
        CategoriaPreguntaID: categoria_pregunta.val(),
      };
      params.FormularioID || params.CategoriaPreguntaID ? getTutoriasPreguntas(params) : resetSelect('PreguntaID');
    });

    pregunta.on('change', function() {
      this.value ? getTutoriasRespuestas(this.value) : resetSelect('RespuestaID');
    });

  });
</script>
@endsection

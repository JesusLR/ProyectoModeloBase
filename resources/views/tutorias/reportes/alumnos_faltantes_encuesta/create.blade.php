@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Lista de Alumnos Faltantes por Responder</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/tutorias/alumnos_faltantes_encuesta/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Lista de Alumnos Faltantes por Responder</span>
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
                  <label for="tipo_lista">Tipo de listado*</label>
                  <select class="browser-default validate select2" name="tipo_lista" id="tipo_lista" style="width:100%;" required>
                    <option value="A">Lista de Alumnos, sin incluir las preguntas del formulario</option>
                    <option value="P">
                      Lista detallada con preguntas del formulario. 
                      (Funciona como referencia del formulario, es posible que algunas preguntas ya estén respondidas por el alumno, pero existen preguntas faltantes)
                    </option>
                  </select>
                </div>
              </div>

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
                  <label for="escuela_id">Escuela*</label>
                  <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;" required>
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
                  <div class="input-field col s12 m6 l6">
                    <input type="text" name="cgtGrupo" id="cgtGrupo" value="{{old('cgtGrupo')}}" class="validate">
                    <label for="cgtGrupo">Grupo</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="aluClave" id="aluClave" value="{{old('aluClave')}}" class="validate">
                    <label for="aluClave">Clave de pago</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    <label for="perApellido1">Apellido paterno</label>
                    <input type="text" name="perApellido1" id="perApellido1" class="validate" value="{{old('perApellido1')}}">
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <label for="perApellido2">Apellido materno</label>
                    <input type="text" name="perApellido2" id="perApellido2" class="validate" value="{{old('perApellido2')}}">
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <label for="perNombre">Nombre</label>
                    <input type="text" name="perNombre" id="perNombre" class="validate" value="{{old('perNombre')}}">
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
                <div class="col s12 m6 l4">
                  <label for="CategoriaPreguntaID">Categoría de pregunta</label>
                  <select class="browser-default validate select2" name="CategoriaPreguntaID" id="CategoriaPreguntaID" data-categoria-pregunta-id="{{old('CategoriaPreguntaID')}}" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($categorias_preguntas as $categoria)
                      <option value="{{$categoria->CategoriaPreguntaID}}">{{$categoria->Nombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="PreguntaID">Pregunta</label>
                  <select class="browser-default validate select2" name="PreguntaID" id="PreguntaID" data-pregunta-id="{{old('PreguntaID')}}" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
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
    let formulario = $('#FormularioID');

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

  });
</script>
@endsection

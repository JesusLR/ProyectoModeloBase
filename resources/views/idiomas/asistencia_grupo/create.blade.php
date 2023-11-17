@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Lista de asistencia por grupo</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'idiomas_asistencia_grupo/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">LISTA DE ASISTENCIA POR GRUPO</span>

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

                @php
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                @endphp

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curEstado', 'Ubicación*', ['class' => '']); !!}
                        <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="departamento_id">Departamento*</label>
                        <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="periodo_id">Periodo*</label>
                        <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="escuela_id">Escuela*</label>
                        <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="programa_id">Programa</label>
                        <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="plan_id">Plan</label>
                        <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate', 'maxlength'=>3)) !!}
                            {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
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

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection


@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function () {

        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        var escuela = $('#escuela_id');
        var programa = $('#programa_id');
        var plan = $('#plan_id');

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        ubicacion_id && ubicacion.val(ubicacion_id).select2();
        ubicacion_id ? getDepartamentosIdiomas(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');

        ubicacion.on('change', function() {
            $(this).val() ? getDepartamentosIdiomas($(this).val(), 'departamento_id') : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            if(departamento.val()) {
                getPeriodos(departamento.val(), 'periodo_id');
                getEscuelasIdiomas(departamento.val(), 'escuela_id');
            } else {
                resetSelect('periodo_id');
                resetSelect('escuela_id');
            }
        });

        escuela.on('change', function() {
            escuela.val() ? getProgramas(escuela.val(), 'programa_id') : resetSelect('programa_id');
        });

        programa.on('change', function() {
            programa.val() ? getPlanes(programa.val(), 'plan_id') : resetSelect('plan_id');
        });

        function getDepartamentosIdiomas(ubicacion_id, targetSelect = 'departamento_id', val = null, dataName = null) {

            var select = $('#' + targetSelect);
            var current_data = dataName || 'departamento-id';
            var current_value = val || select.data(current_data);
            select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
            $.ajax({
                type: 'GET',
                url: base_url + '/idiomas_curso/api/departamentos/' + ubicacion_id,
                dataType: 'json',
                data: { ubicacion_id: ubicacion_id },
                success: function(departamentos) {
                    if (departamentos) {
                        $.each(departamentos, function(key, value) {
                            select.append(new Option(value.depClave + '-' + value.depNombre, value.id));
                            (value.id == current_value) && select.val(value.id);
                        });
                        select.trigger('change');
                        select.trigger('click');
                    }
                },
                error: function(Xhr, textMessage, errorMessage) {
                    console.log(errorMessage);
                }
            });
        } //getDepartamentos.

        function getEscuelasIdiomas(departamento_id, targetSelect = 'escuela_id', val = null, dataName = null) {
            var select = $('#' + targetSelect);
            var current_data = dataName || 'escuela-id';
            var current_value = val || select.data(current_data);
            select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
            $.ajax({
                type: 'GET',
                url: base_url + '/idiomas_curso/api/escuelas/' + departamento_id,
                dataType: 'json',
                data: { departamento_id: departamento_id },
                success: function(escuelas) {
                    if (escuelas) {
                        $.each(escuelas, function(key, value) {
                            select.append(new Option(value.escClave + '-' + value.escNombre, value.id));
                            (value.id == current_value) && select.val(value.id);
                        });
                        select.trigger('change');
                        select.trigger('click');
                    }
                },
                error: function(Xhr, textMessage, errorMessage) {
                    console.log(errorMessage);
                }
            });
        } //getEscuelas.

    });
</script>
@endsection
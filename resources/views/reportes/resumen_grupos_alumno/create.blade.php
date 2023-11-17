@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen grupos alumno</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/resumen_grupos_alumno/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen grupos alumno</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          @php
            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
          @endphp

          {{-- GENERAL BAR--}}
          <div id="filtros">
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                  <select id="ubicacion_id" name="ubicacion_id" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $key => $ubicacion)
                      @if($ubicacion_id == $ubicacion->id)
                        <option value="{{$ubicacion->id}}" selected>{{$ubicacion->ubiNombre}}</option>
                      @else
                        <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" name="departamento_id" class="browser-default validate select2" style="width:100%;" required>
                    <option  value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                  <select id="periodo_id" name="periodo_id" class="browser-default validate select2" style="width:100%;" required>
                    <option  value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                  <select id="escuela_id" name="escuela_id" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="">
                  {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                  <select id="programa_id" name="programa_id" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="col s12 m6 l6">
                  {!! Form::label('cgtGradoSemestre', 'Grado', array('class' => '')); !!}
                  <select id="cgtGradoSemestre" name="cgtGradoSemestre" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l6">
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matrícula', array('class' => '')); !!}
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                  </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
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
  $(document).ready(function() {


    var ubicacion_id = $('#ubicacion_id').val();
    ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
    $('#ubicacion_id').on('change', function() {
      ubicacion_id = $(this).val();
      ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
    });

    $('#departamento_id').on('change', function() {
      var departamento_id = $(this).val();
      if(departamento_id) {
        getPeriodos(departamento_id, 'periodo_id');
        getEscuelas(departamento_id, 'escuela_id');
      } else {
        resetSelect('periodo_id');
        resetSelect('escuela_id');
      }
    });

    $('#escuela_id').on('change', function() {
      var escuela_id = $(this).val();
      escuela_id ? getProgramas(escuela_id, 'programa_id') : resetSelect('programa_id');
    });

    $('#programa_id').on('change', function() {
      var programa_id = $(this).val();
      var periodo_id  = $('#periodo_id').val();
      programa_id ? getPlanes(programa_id, 'plan_id') : resetSelect('plan_id');

      if(periodo_id) {
        var dataObject = {programa_id: programa_id};
        getGrados(periodo_id, dataObject, 'cgtGradoSemestre');
      } else {
        resetSelect('cgtGradoSemestre');
      }

    });

    $('#periodo_id').on('change', function() {
      var periodo_id = $(this).val();
      var programa_id = $('#programa_id').val();

      if(periodo_id) {
        var dataObject = {programa_id: programa_id};
        getGrados(periodo_id, dataObject, 'cgtGradoSemestre');
      } else {
        resetSelect('cgtGradoSemestre');
      }

    });



  });

  function getGrados(periodo_id, dataObject, targetSelect) {
    var select = $('#' + targetSelect);
    select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
    $.ajax({
      type: 'GET',
      url: base_url +'/api/resumen_grupos_alumno/getGrados/'+periodo_id,
      data: dataObject,
      dataType: 'json',
      success: function(grados) {
        if(grados) {
          $.each(grados, function(key, value) {
            select.append(new Option(value +'°', value));
          });
          select.trigger('change');
        }
      },
      error: function(Xhr, textStatus, errorMessage) {
        console.log(errorMessage);
      }
    })
  }
</script>
@endsection
@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Actas pendientes</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/actas_pendientes/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">ACTAS PENDIENTES</span>
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
                <label for="grupos_con_inscritos">¿Incluir solo grupos con alumnos inscritos?</label>
                <select class="browser-default validate select2" name="grupos_con_inscritos" id="grupos_con_inscritos" style="width:100%;">
                  <option value="SI">SI</option>
                  <option value="">NO</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('tipoActa', 'Tipo acta', ['class' => '']); !!}
                <select name="tipoActa" id="tipoActa" class="browser-default validate select2" style="width: 100%;">
                  <option value="ORDINARIO">Ordinario</option>
                  <option value="EXTRAORDINARIO">Extraordinario</option>
                </select>
              </div>

              <div id="select-ordinarios" class="col s12 m6 l4">
                <label for="actasPendientes">Actas pendientes</label>
                <select name="actasPendientes" id="actasPendientes" class="browser-default validate select2" style="width: 100%;">
                  <option value="pendientesCapturar">Pendientes por capturar</option>
                  <option value="pendientesCerrar">Pendientes por cerrar</option>
                  <option value="cerradas">Cerradas</option>
                </select>
              </div>

              <div id="select-extras" class="col s12 m6 l4">
                <label for="actasPendientesExtras">Actas pendientes</label>
                <select name="actasPendientesExtras" id="actasPendientesExtras" class="browser-default validate select2" style="width: 100%;">
                  <option value="pendientesCapturar">Pendientes por capturar</option>
                  <option value="pendientesPorCalificar">Pendientes por calificar</option>
                </select>
              </div>

              <div class="col s12 m6 l4">
                <div style="margin-top: 25px; display:none;" class="chck-incluir-pendientes">
                  <input type="checkbox" id="check" name="chckincluirpendientes" class="chckincluirpendientes">
                  <label for="check">¿Incluir pendientes por capturar?</label>
                </div>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="ubicacion_id">Ubicación*</label>
                  <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
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
                  <label for="escuela_id">Escuela</label>
                  <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
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
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
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
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('empleado_id', NULL, array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
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

  @include('scripts.actas-pendientes')
  <script type="text/javascript">
    $(document).ready(function() {

      if($('#tipoActa').val() == 'Ordinario') {
        $('#select-ordinarios').hide();
        $('#select-extras').show();
      } else {
        $('#select-extras').hide();
        $('#select-ordinarios').show();
      }

      $('#tipoActa').on("change", function (e) {
        var tipoActa = e.target.value

        if (tipoActa === "EXTRAORDINARIO") {
          $("#actasPendientes").val("pendientesCapturar")
          $('#actasPendientes').select2().trigger('change');
          // $('#actasPendientes').prop('disabled', true);
          $('#cgtGradoSemestre').prop('disabled', true);
          $("#cgtGradoSemestre").val("")
          $('#cgtGrupo').prop('disabled', true);
          $("#cgtGrupo").val("")
          $('#select-ordinarios').hide();
          $('#select-extras').show();
        } else {
          // $('#actasPendientes').prop('disabled', false);
          $('#cgtGradoSemestre').prop('disabled', false);
          $('#cgtGrupo').prop('disabled', false);
          $('#select-extras').hide();
          $('#select-ordinarios').show();
        }

      })
    })

  </script>

<script type="text/javascript">
    $(document).ready(function() {
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        var escuela = $('#escuela_id');
        var programa = $('#programa_id');

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        if(ubicacion_id) {
            ubicacion.val(ubicacion_id).select2();
            getDepartamentos(ubicacion_id);
        }

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
        
    });
</script>

@endsection
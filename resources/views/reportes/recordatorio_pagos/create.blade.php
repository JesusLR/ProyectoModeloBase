@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Recordatorio de pagos</a>
@endsection

@section('content')

  @php
    use App\Http\Helpers\Utils;
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
      $month = intval($hoy->month) <= 1 ? 12 : $hoy->month - 1;
      $mesEscolarActual = Utils::obtenerMesEscolar($month);
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/recordatorio_pagos/imprimir', 'method' => 'POST', 'target' => '_blank', 'id' => 'form_recordatorios']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Recordatorio de Pago</span>
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
                <label for="meses">Último mes de pago</label>
                <select name="meses" id="meses" data-mes="{{old('meses')}}" class="browser-default validate select2" style="width:100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @foreach($meses as $mes_numero => $mes_nombre)
                    <option value="{{$mes_numero}}">{{$mes_nombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="estado_curso"> Estado del curso</label>
                <select name="estado_curso" id="estado_curso" data-estado-curso="{{old('estado_curso')}}" class="browser-default validate select2" style="width:100%;">
                  <option value="P-R-C-A">Todos</option>
                  <option value="R-C-A">Inscritos</option>
                  <option value="C-A">Condicionados</option>
                  <option value="R">Regulares</option>
                  <option value="P">Preinscritos</option>
                  <option value="C">Condicionados 1</option>
                  <option value="A">Condicionados 2</option>
                  <option value="B">Bajas</option>
                </select>
              </div>
            </div>

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
                <label for="ciclo_escolar">Ciclo Escolar*</label>
                <select name="ciclo_escolar" id="ciclo_escolar" data-ciclo-escolar="{{old('ciclo_escolar')}}" class="browser-default validate select2" style="width:100%;" required>
                  @for($i = $hoy->year; $i > 2000; $i--)
                    <option value="{{$i}}">{{$i}} - {{$i + 1}}</option>
                  @endfor
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
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('aluClave', old('aluClave'), array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('aluMatricula', old('aluMatricula'), array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matrícula', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  <input type="text" name="nombres" id="nombres" value="{{old('nombres')}}" class="validate">
                  <label for="nombres">Nombre(s)</label>
                </div>
                <div class="input-field col s12 m6 l6">
                  <input type="text" name="apellidos" id="apellidos" value="{{old('apellidos')}}" class="validate">
                  <label for="apellidos">Apellidos</label>
                </div>
              </div>
            </div>
          
          </div>
        </div>
      </div>
      {{-- CARD PARA MOSTRAR EJEMPLO DEL MENSAJE A ENVIAR --}}
      <div class="card">
        <div class="card-content">
          <span class="card-title">Cuerpo del Mensaje</span>
          <hr>
          {{-- NAVIGATION BAR --}}
          <div id="cuerpo_mensaje">
            <div class="row">
              <div class="col s12 m8 l8">
                <p>
                  [<b>Saludo inicial</b>]: [<b>Nombre del alumno</b>]
                  <br><br><br>
                  {!!Lang::get('recordatorios/RecordatorioPago.acuerdoVista')!!}
                </p>
                <br>
                <p class="center-align">[<b>LISTA DE ADEUDOS</b>]</p>
                <br>
                <div class="input-field col s12 m12 l12">
                  <input type="hidden" name="mensaje_id" id="mensaje_id" value="{{$mensaje ? $mensaje->id : ''}}">
                </div>
                <div class="input-field col s12 m12 l12">
                  <textarea name="mensaje_agregado" id="mensaje_agregado" class="materialize-textarea noUpperCase" data-length="400">
                  {{$mensaje->msjMensaje}}
                  </textarea>
                  <label for="mensaje_agregado">Agregar mensaje</label>
                </div>
                <p class="center-align">
                  Por su atención al presente, reiterámosle nuestro reconocimiento.
                </p>
                <p class="center-align">
                  Atentamente:
                </p>
                <p class="center-align">
                  COORDINACIÓN ADMINISTRATIVA
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <div class="row">
            <input type="hidden" name="accion" id="accion" value="">
            <div class="col s12 m6 l4">
              <button class="btn-large waves-effect btn_accion" value="PDF">
                <i class="material-icons left">picture_as_pdf</i>GENERAR PDF
              </button>
            </div>
            <div class="col s12 m6 l4">
              <button class="btn-large waves-effect btn_accion" value="email">
                <i class="material-icons left">email</i>Enviar correos
              </button>
            </div>
          </div>
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
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        var escuela = $('#escuela_id');
        var programa = $('#programa_id');
        let campos_requeridos = {
          ubicacion_id: 'Ubicacion',
          departamento_id: 'Departamento',
          ciclo_escolar: 'Ciclo Escolar',
          escuela_id: 'Escuela',
        };

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        if(ubicacion_id) {
            ubicacion.val(ubicacion_id).select2();
            getDepartamentos(ubicacion_id);
        }

        apply_data_to_select('ciclo_escolar', 'ciclo-escolar');
        apply_data_to_select('meses', 'mes', {!! json_encode($mesEscolarActual) !!});
        apply_data_to_select('estado_curso', 'estado-curso', 'P-R-C-A');

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

        $('.btn_accion').on('click', function(e) {
            e.preventDefault();
          // if(this.value == 'PDF') {
            let campos_validados = validate_formFields(campos_requeridos);
            if($.isEmptyObject(campos_validados)) {
              $('#accion').val(this.value);
              $('#form_recordatorios').submit();
            } else {
              showRequiredFields(campos_validados);
            }
          // } else {
          //   swal({
          //     type: 'warning',
          //     title: 'Modulo en desarrollo.',
          //     text: 'Este módulo está en etapa de desarrollo, esta acción aún no está disponible.',
          //   })
          // }
        });
        
    });

</script>

@endsection
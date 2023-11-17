@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Programación de exámenes extraordinarios</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/programacion_examenes/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Programación de exámenes extraordinarios</span>
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
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('formato', 'Tipo de formato', ['class' => '']); !!}
                <select name="formato" id="formato" class="browser-default validate select2" style="width: 100%;">
                  <option value="PDF">PDF</option>
                  <option value="EXCEL">EXCEL</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('inscritos', 'Incluir alumnos inscritos', ['class' => '']); !!}
                <select name="inscritos" id="inscritos" data-inscritos="{{old('inscritos') ?: 't'}}" class="browser-default validate select2" style="width: 100%;">
                  <option value="si">Sí</option>
                  <option value="no">No</option>
                  <option value="t">Ambos</option>
                </select>
              </div>
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('regular', 'Solicitudes de regularización', ['class' => '']); !!}
                <select name="regular" id="regular" data-regular="{{old('regular') ?: 't'}}" class="browser-default validate select2" style="width: 100%;">
                  <option value="t">Todas</option>
                  <option value="p">Pagadas</option>
                  <option value="n">No pagadas</option>
                </select>
              </div>

              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('estadoPago', 'Estado de pago', ['class' => '']); !!}
                <select name="estadoPago" id="estadoPago" data-regular="{{old('estadoPago') ?: 't'}}" class="browser-default validate select2" style="width: 100%;">
                  <option value="c">Estado de pago cualquiera (pagado o pendiente por pagar)</option>
                  <option value="p">Pendiente por pagar</option>
                  <option value="e">Pago recibido en efectivo</option>
                  <option value="b">Pago recibido en banco</option>
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
                <div class="input-field">
                  {!! Form::number('examenId', NULL, array('id' => 'examenId', 'class' => 'validate')) !!}
                  {!! Form::label('examenId', 'Clave del examen', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('matClave', NULL, array('id' => 'matClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('extGrupo', NULL, array('id' => 'extGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('extGrupo', 'Clave del grupo', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('extFecha', NULL, array('id' => 'extFecha', 'class' => 'validate', "")) !!}
                    {!! Form::label('extFecha', 'Fecha en formato AAAA-MM-DD. Ej: 1999-12-24 ', array('class' => '')); !!}
                  </div>
                </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('extHora', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                  {!! Form::label('extHora', 'Hora en formato HH:mm:ss Ej: 19:00:00 ', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aulaClave', NULL, array('id' => 'aulaClave', 'class' => 'validate')) !!}
                  {!! Form::label('aulaClave', 'Lugar del examen', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('empleado_sinodal_id', NULL, array('id' => 'empleado_sinodal_id', 'class' => 'validate')) !!}
                  {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('extPago', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                  {!! Form::label('extPago', 'Costo del examen', array('class' => '')); !!}
                </div>
              </div>
            </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
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

        apply_data_to_select('inscritos', 'inscritos');
        apply_data_to_select('regular', 'regular');

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
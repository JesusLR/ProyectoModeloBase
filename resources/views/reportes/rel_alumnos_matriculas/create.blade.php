@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de alumnos con matrículas</a>
@endsection

@section('content')
  
  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/rel_alumnos_matriculas/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de alumnos con matrículas</span>
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
                {!! Form::label('ordernarPor', 'Seleccionar Orden', ['class' => '']); !!}
                <select name="ordernarPor" id="ordernarPor" class="browser-default validate select2" style="width: 100%;">
                  <option value="nombre">NOMBRE</option>
                  <option value="grado">GRADO</option>
                </select>
              </div>


              <div class="col s12 m6 l4">
                {!! Form::label('tipoReporte', 'Seleccionar tipo reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                  <option value="normal">NORMAL</option>
                  <option value="rayas">SOLO RAYAS PARA FIRMA</option>
                </select>
              </div>

              <div class="col s12 m6 l4">
                {!! Form::label('tipoEspacio', 'Seleccionar espaciado', ['class' => '']); !!}
                <select name="tipoEspacio" id="tipoEspacio" class="browser-default validate select2" style="width: 100%;">
                  <option value="sencillo">SENCILLO</option>
                  <option value="doble">DOBLE</option>
                </select>
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
                        {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                        {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                    </div>
                </div>
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido paterno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('aluEstado', 'Seleccione alumnos a incluir en el reporte', ['class' => '']); !!}
                <select name="aluEstado" id="aluEstado" class="browser-default validate select2" style="width: 100%;">
                  @foreach($aluEstado as $key => $value)
                    <option value="{{$key}}" @if(old('aluEstado') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                  @endforeach
                </select>
              </div>


              <div class="col s12 m6 l4">
                {!! Form::label('curTipoIngreso', 'Tipo de ingreso SEGEY', ['class' => '']); !!}
                <select name="curTipoIngreso" id="curTipoIngreso" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  @foreach($tiposIngresoSegey as $key => $value)
                    <option value="{{$key}}" @if(old('curTipoIngreso') == $key) {{ 'selected' }} @endif>{{$value}}</option>
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
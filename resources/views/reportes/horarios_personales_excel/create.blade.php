@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Horarios Personales Excel</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

  <div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/horarios_personales_excel/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">HORARIOS PERSONALES EXCEL</span>

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
                    <label for="escuela_id">Escuela*</label>
                    <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    <label for="programa_id">Programa*</label>
                    <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
              </div>

              {{-- <div class="row">
                <div class="col s12 m6 l4" style="margin-top:10px;">
                    <label for="tipoHora">Escoger filtro horas</label>
                    <select name="tipoHora" id="tipoHora" data-escuela-id="{{old('tipoHora')}}" class="browser-default validate select2" style="width:100%;" >
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                        <option value="DOC">HORAS DOCENTES</option>
                        <option value="ADMIN">HORAS ADMINISTRATIVAS</option>
                        <option value="DOCADMIN">HORAS DOCENTES/ADMINISTRATIVAS</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::number('horas', NULL, array('id' => 'horas', 'class' => 'validate','min'=>'0')) !!}
                      {!! Form::label('horas', 'Horas', array('class' => '')); !!}
                    </div>
                </div>
              </div> --}}

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('empleado_id', NULL, array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                  </div>

                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                    {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 l6">
                    {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                    {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
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
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        var escuela = $('#escuela_id');

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
    });
</script>

@endsection
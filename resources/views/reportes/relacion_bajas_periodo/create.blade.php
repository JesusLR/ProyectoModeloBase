@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Relación de bajas por periodo</a>
@endsection

@section('content')
  <div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/relacion_bajas_periodo/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RELACION DE BAJAS POR PERIODO</span>

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
                  <label for="formato_reporte">Formato del reporte*</label>
                  <select class="browser-default validate select2" name="formato_reporte" id="formato_reporte" style="width:100%" required>
                    <option value="PDF">PDF</option>
                    <option value="Excel">Excel</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                    <select id="ubicacion_id" name="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $key => $ubicacion)
                        <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                    <select id="departamento_id" name="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" style="width:100%;" required>
                      <option  value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                    <select id="periodo_id" name="periodo_id" class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" style="width:100%;" required>
                      <option  value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                    <select id="escuela_id" name="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                    <select id="programa_id" name="programa_id" class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l3">
                  {!! Form::label('bajFechaBaja', 'Fecha de baja', array('class' => '')); !!}
                  <input type="date" name="bajFechaBaja" id="bajFechaBaja" value="{{old('bajFechaBaja')}}">
                </div>
                <div class="col s12 m6 l3">
                  <label for="fechaBaja2">Fecha de baja 2</label>
                  <input type="date" name="fechaBaja2" id="fechaBaja2" value="{{old('fechaBaja2')}}">
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('aluClave', old('aluClave'), array('id' => 'aluClave', 'class' => 'validate')) !!}
                    {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('aluMatricula', old('aluMatricula'), array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                    {!! Form::label('aluMatricula', 'Matricula', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perApellido1', old('perApellido1'), array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perApellido2', old('perApellido2'), array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perNombre', old('perNombre'), array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
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

    apply_data_to_select('ubicacion_id', 'ubicacion-id');

    let ubicacion_id = $('#ubicacion_id').val();
    ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
    $('#ubicacion_id').on('change', function() {
      ubicacion_id = $(this).val();
      ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
    });

    $('#departamento_id').on('change', function() {
      let departamento_id = $(this).val();
      if(departamento_id) {
        getPeriodos(departamento_id, 'periodo_id');
        getEscuelas(departamento_id, 'escuela_id');
      } else {
        resetSelect('periodo_id');
        resetSelect('escuela_id');
      }
    });

    $('#escuela_id').on('change', function() {
      let escuela_id = $(this).val();
      escuela_id ? getProgramas(escuela_id, 'programa_id') : resetSelect('programa_id');
    });




  });
</script>
@endsection
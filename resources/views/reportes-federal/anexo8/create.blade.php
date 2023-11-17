@extends('layouts.dashboard')

@section('template_title')
    Reportes Federales
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Anexo 8 - Federales</a>
@endsection

@section('content')
  <div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte-federal/anexo-8/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ANEXO 8 - FEDERALES</span>

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
                  <div class="input-field col s12 m6 l6">
                    {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'6', 'required' => true)) !!}
                    {!! Form::label('perNumero', 'Numero del periodo', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 l6">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997', 'required' => true)) !!}
                    {!! Form::label('perAnio', 'Año del periodo', array('class' => '')); !!}
                  </div>
                </div>
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
                    {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                    <select id="departamento_id" name="departamento_id" class="browser-default validate select2" style="width:100%;">
                      <option  value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                    <select id="escuela_id" name="escuela_id" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                    <select id="programa_id" name="programa_id" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                    <select id="plan_id" name="plan_id" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('gpoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 l6">
                    {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                    {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l6">
                  <div class="input-field col s12 m6 l4">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                    {!! Form::label('aluClave', 'Clave Pago', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 l4">
                    {!! Form::text('matricula', NULL, array('id' => 'matricula', 'class' => 'validate')) !!}
                    {!! Form::label('matricula', 'Matricula', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 l4">
                    {!! Form::number('curp', NULL, array('id' => 'curp', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('curp', 'Curp', array('class' => '')); !!}
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
      programa_id ? getPlanesFederales(programa_id, 'plan_id') : resetSelect('plan_id');
    });



  });
</script>
@endsection
@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Horario por grupo</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_horario_por_grupo.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">HORARIO POR GRUPO</span>

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
              
              {{-- <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                    {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                  </div>
                </div>
              </div> --}}

              {{-- <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                  </div>
                </div>
              </div> --}}

              {{-- <div class="row">
                <div class="col s12 m4 l4">
                    {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                    <select name="escClave" id="escClave" class="browser-default validate select2" style="width: 100%;" required>
                      <option value="">Seleccionar</option>
                      @foreach ($escuelas as $escuela)
                        <option value="{{$escuela->escClave}}">{{$escuela->escClave}} - {{$escuela->escNombre}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col s12 m4 l4">
                  <div class="input-field">
                    {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m4 l4">
                  <div class="input-field">
                    {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                  </div>
                </div>
              </div> --}}

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                    {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
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

  

@endsection
{{-- Script de funciones auxiliares  --}}
@include('bachiller.scripts.funcionesAuxiliares')

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
                getPeriodosTodos(this.value);
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
            this.value ? getPlanesTodos(this.value) : resetSelect('plan_id');
        });
        
    });
</script>

@endsection
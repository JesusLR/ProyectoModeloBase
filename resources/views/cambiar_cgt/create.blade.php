@extends('layouts.dashboard')

@section('template_title')
    Cambiar CGT
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Cambiar CGT</a>
@endsection

@section('content')

@php
  $ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'cambiar_cgt/realizar_cambio', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Cambiar CGT</span>
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
                  <label for="ubicacion_id">Ubicacion*</label>
                  <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" name="ubicacion_id" id="ubicacion_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" id="departamento_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo*</label>
                  <select class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" id="periodo_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="escuela_id">Escuela*</label>
                  <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" name="escuela_id" id="escuela_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" name="programa_id" id="programa_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="plan_id">Plan*</label>
                  <select class="browser-default validate select2" data-plan-id="{{old('plan_id')}}" name="plan_id" id="plan_id" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="cgt_id">Actual CGT*</label>
                  <select class="browser-default validate select2" name="cgt_id" id="cgt_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="cgt_asignado">CGT nuevo*</label>
                  <select class="browser-default validate select2" name="cgt_asignado" id="cgt_asignado" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l6">
                  <label for="cursos_ids">Elija los cursos que desee cambiar</label>
                  <select class="browser-default validate select2" name="cursos_ids[]" id="cursos_ids" style="width:100%" multiple required>
                    <option value="">SELECCIONE MÚLTIPLES</option>
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

<script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let ubicacion = $('#ubicacion_id');
    let departamento = $('#departamento_id');
    let periodo = $('#periodo_id');
    let escuela = $('#escuela_id');
    let programa = $('#programa_id');
    let plan = $('#plan_id');
    let cgt = $('#cgt_id');

    apply_data_to_select('ubicacion_id', 'ubicacion-id');

    ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
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

    periodo.on('change', function() {
      if(this.value && plan.val()) {
        getCgts_plan_periodo(plan.val(), periodo.val(), 'cgt_id');
      } else {
        resetSelect('cgt_id');
      }
    });

    plan.on('change', function() {
      if(this.value && periodo.val()) {
        getCgts_plan_periodo(plan.val(), periodo.val(), 'cgt_id');
      } else {
        resetSelect('cgt_id');
      }
    });

    cgt.on('change', function() {
      if(this.value && plan.val() && periodo.val()) {
        fillCgtAsignadoSelector(plan.val(), periodo.val(), this.value);
        fillCursosSelector(this.value);
      } else {
        resetSelect('cgt_asignado');
      }
    });
  });


  async function fillCgtAsignadoSelector(plan_id, periodo_id, cgt_id) {
    let cgt = await getCgtSelected(cgt_id);
    if(Object.keys(cgt).length > 0) {
      getCgtsPorSemestre(plan_id, periodo_id, cgt.cgtGradoSemestre, 'cgt_asignado');
    }
  }

  async function fillCursosSelector(cgt_id) {
    let cursos = await getCursosDelCgt(cgt_id);
    if(cursos.length > 0) {
      $('#cursos_ids').empty().append(new Option('SELECCIONE MÚLTIPLES', ''));
      $.each(cursos, function(key, curso) {
          let alumno = curso.alumno;
          let persona = alumno.persona;
          let selectorText = `${alumno.aluClave} - ${persona.perNombre} ${persona.perApellido1} ${persona.perApellido2}`;
          let option = `<option value="${curso.id}" selected>${selectorText}</option>`;
          $('#cursos_ids').append(option);
      });
    }
  }

  function getCgtSelected(cgt_id) {
    
    return fetch(`${base_url}/api/cgts/${cgt_id}`)
            .then(res => res.json())
            .then(data => data);
  }

  function getCursosDelCgt(cgt_id) {

    return fetch(`${base_url}/api/cursos/${cgt_id}`)
          .then(res => res.json())
          .then(data => data);
  }

</script>
@endsection

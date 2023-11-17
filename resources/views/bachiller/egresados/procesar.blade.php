@extends('layouts.dashboard')

@section('template_title')
    Registro de Egresados
@endsection

@section('breadcrumbs')
  <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Registro de Egresados</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.egregados.procesar', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">REGISTRO DE EGRESADOS</span>
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
                <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                  style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  @foreach($ubicaciones as $ubicacion)
                  @php
                  $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                  $selected = '';
                  if($ubicacion->id == $ubicacion_id){
                  $selected = 'selected';
                  }
                  @endphp
                  <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
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
                <label for="escuela_id">Escuela*</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>     
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan*</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
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
              <p style="text-align: center;font-size:1.2em;">Alumno</p>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m4 14">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matrícula', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">school</i> REGISTRAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
  

@endsection


@section('footer_scripts')

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')

<script type="text/javascript">
    
    // funciones para esta vista. -----------------------------

    function buscarInfoAlumno(aluClave) {
      $.ajax({
        processing : 'true',
        serverSide : 'true',
        url : 'bachiller_registro_egresados/buscar/' + aluClave,
        method : 'POST',
        data : {aluClave : aluClave,"_token":"{{csrf_token()}}"},
        dataType : "json",
        success : function(resumen){
          actualizarFormulario(resumen);
        }
      });
    }//buscarInfoAlumno.

    function actualizarFormulario(resumen) {
        let alumno = resumen ? resumen.alumno : null;
        let persona = alumno ? alumno.persona : null;
        let periodoUltimo = resumen ? resumen.periodoUltimo : null;
        let plan = resumen ? resumen.plan : null;
        let programa = plan ? plan.programa : null;
        let escuela = programa ? programa.escuela : null;
        let departamento = escuela ? escuela.departamento : null;
        let ubicacion = departamento ? departamento.ubicacion : null;

        $('#plan_id').data('plan-id', plan ? plan.id : '');
        $('#programa_id').data('programa-id', programa ? programa.id : '');
        $('#escuela_id').data('escuela-id', escuela ? escuela.id : '');
        $('#departamento_id').data('departamento-id', departamento ? departamento.id : '');
        $('periodo_id').data('periodo-id', periodoUltimo ? periodoUltimo.id : '');
        ubicacion ? $('#ubicacion_id').val(ubicacion.id).select2() : $('#ubicacion_id').val('').select2();
        $('#aluMatricula').val(alumno ? alumno.aluMatricula : '');
        $('#perApellido1').val(persona ? persona.perApellido1 : '');
        $('#perApellido2').val(persona ? persona.perApellido2 : '');
        $('#perNombre').val(persona ? persona.perNombre : '');
        Materialize.updateTextFields();
    } //autoCompletarFormulario.
</script>

@endsection
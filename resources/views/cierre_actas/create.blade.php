@extends('layouts.dashboard')

@section('template_title')
    Cierre de actas
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Cierre de actas</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'cierre_actas/realizar', 'method' => 'POST', 'target' => '_blank', 'id' => 'form_cierre_actas']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">CIERRE DE ACTAS</span>
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
                <div class="input-field">
                  {!! Form::text('ubiClave', old('ubiClave'), array('id' => 'ubiClave', 'class' => 'validate','maxlength'=>'3', "required")) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', old('depClave'), array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', old('escClave'), array('id' => 'escClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('escClave', 'Clave de Escuela', array('class' => '')); !!}
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perNumero', old('perNumero'), array('id' => 'perNumero', 'class' => 'validate','min'=>'1','max'=>'6', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perAnio', old('perAnio'), array('id' => 'perAnio', 'class' => 'validate','min'=>'0','max'=>$fechaActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('progClave', old('progClave'), array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                   {!! Form::text('planClave', old('planClave'), array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                   {!! Form::label('planClave', 'Clave de Plan', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col">
                  {!! Form::number('gpoSemestre', old('gpoSemestre'), array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('gpoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                </div>
                <div class="input-field col">
                  {!! Form::text('gpoClave', old('gpoClave'), array('id' => 'gpoClave', 'class' => 'validate')) !!}
                  {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', old('matClave'), array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('empleado_id', old('empleado_id'), array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('gpoFechaExamenOrdinario', old('gpoFechaExamenOrdinario'), array('id' => 'gpoFechaExamenOrdinario', 'class' => 'validate','maxlength'=>'10','data-toggle'=>'tooltip','title'=>'dd/mm/yyyy')) !!}
                   {!! Form::label('gpoFechaExamenOrdinario', 'Fecha de Ordinario', array('class' => '')); !!}
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3', 'id' => 'btn_submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection


@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    let btn_submit = $('#btn_submit');

    btn_submit.on('click', function(e) {
      e.preventDefault();
      $(this).prop('disabled', true);

      $('#form_cierre_actas').submit();
    });
  });
</script>
@endsection
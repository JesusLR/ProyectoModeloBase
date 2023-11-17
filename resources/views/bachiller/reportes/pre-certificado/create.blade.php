@extends('layouts.dashboard')

@section('template_title')
Reportes
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Constancia de pre-certificados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' =>
    'bachiller.bachiller_precertificado.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">Constancia de pre-certificados</span>
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
              {!! Form::label('ubicacion_id', 'Campus', ['class' => '']); !!}
              <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @foreach($ubicaciones as $ubicacion)
                @php
                $selected = '';

                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'
                </option>';
                } else {
                if ($ubicacion->id == old("ubicacion_id")) {
                $selected = 'selected';
                }

                echo '<option value="'.$ubicacion->id.'" '. $selected .'>
                  '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                }
                @endphp
                @endforeach
              </select>
            </div>            
          </div>

          <hr>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','required')) !!}
                {!! Form::label('aluClave', 'Clave de pago*', array('class' => '')); !!}
              </div>
            </div>

            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                {!! Form::label('aluMatricula', 'Matricula alumno', array('class' => '')); !!}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0'))
                !!}
                {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0'))
                !!}
                {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
              </div>
            </div>
          </div>
          {{-- <div class="row">
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' =>
                'validate','min'=>'0')) !!}
                {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
              </div>
            </div>
          </div> --}}
        </div>
      </div>
      <div class="card-action">
        {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large
        waves-effect darken-3','type' => 'submit']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
@endsection
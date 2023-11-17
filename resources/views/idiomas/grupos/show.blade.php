@extends('layouts.dashboard')

@section('template_title')
    Idiomas grupo
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_grupo')}}" class="breadcrumb">Lista de Grupo</a>
    <a href="{{url('idiomas_grupo/'.$grupo->id)}}" class="breadcrumb">Ver grupo</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">GRUPO #{{$grupo->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#horarios">Horarios</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiClave', $grupo->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id', $grupo->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $grupo->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('periodo_id', $grupo->periodo->perNumero.'-'.$grupo->periodo->perAnio, array('readonly' => 'true')) !!}
                            {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('programa_id', $grupo->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $grupo->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoGrado', $nivel->gpoGrado, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoGrado', 'Grado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoClave', $grupo->gpoClave, array('readonly' => 'true')) !!}
                        {!! Form::label('gpoClave', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoDescripcion', $grupo->gpoDescripcion, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoDescripcion', 'Descripción', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('gpoCupo', $grupo->gpoCupo, array('readonly' => 'true')) !!}
                        {!! Form::label('gpoCupo', 'Cupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::label('empleado_id', 'Maestro', array('class' => '')); !!}
                        {!! Form::text('empleado_id', $empleado->empNombre.' '.$empleado->empApellido1.' '.$empleado->empApellido2, array('readonly' => 'true')) !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- EQUIVALENTE BAR--}}
            <div id="horarios">
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioLunes', $grupo->gpoHoraInicioLunes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraInicioLunes', 'Hora inicio lunes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinLunes', $grupo->gpoHoraFinLunes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraFinLunes', 'Hora fin lunes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaLunes', $grupo->gpoAulaLunes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoAulaLunes', 'Aula lunes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioMartes', $grupo->gpoHoraInicioMartes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraInicioMartes', 'Hora inicio martes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinMartes', $grupo->gpoHoraFinMartes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraFinMartes', 'Hora fin martes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaMartes', $grupo->gpoAulaMartes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoAulaMartes', 'Aula martes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioMiercoles', $grupo->gpoHoraInicioMiercoles, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraInicioMiercoles', 'Hora inicio miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinMiercoles', $grupo->gpoHoraFinMiercoles, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraFinMiercoles', 'Hora fin miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaMiercoles', $grupo->gpoAulaMiercoles, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoAulaMiercoles', 'Aula miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioJueves', $grupo->gpoHoraInicioJueves, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraInicioJueves', 'Hora inicio jueves', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinJueves', $grupo->gpoHoraFinJueves, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraFinJueves', 'Hora fin jueves', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaJueves', $grupo->gpoAulaJueves, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoAulaJueves', 'Aula jueves', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioViernes', $grupo->gpoHoraInicioViernes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraInicioViernes', 'Hora inicio viernes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinViernes', $grupo->gpoHoraFinViernes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraFinViernes', 'Hora fin viernes', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaViernes', $grupo->gpoAulaViernes, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoAulaViernes', 'Aula viernes', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraInicioSabado', $grupo->gpoHoraInicioSabado, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraInicioSabado', 'Hora inicio sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoHoraFinSabado', $grupo->gpoHoraFinSabado, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoHoraFinSabado', 'Hora fin sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            {!! Form::text('gpoAulaSabado', $grupo->gpoAulaSabado, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoAulaSabado', 'Aula sábado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection

@extends('layouts.dashboard')

@section('template_title')
    Grupo
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar_grupo.index')}}" class="breadcrumb">Lista de Grupo</a>
    <a href="{{url('preescolar_grupo/'.$preescolar_grupo->id)}}" class="breadcrumb">Ver grupo</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">GRUPO #{{$preescolar_grupo->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  {{-- <li class="tab"><a href="#equivalente">Equivalente</a></li> --}}
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiClave', $preescolar_grupo->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id', $preescolar_grupo->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $preescolar_grupo->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('periodo_id', $preescolar_grupo->periodo->perNumero.'-'.$preescolar_grupo->periodo->perAnio, array('readonly' => 'true')) !!}
                            {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $preescolar_grupo->periodo->perFechaInicial, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $preescolar_grupo->periodo->perFechaFinal, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('programa_id', $preescolar_grupo->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $preescolar_grupo->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoGrado', $preescolar_grupo->gpoGrado, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoGrado', 'Grado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoClave', $preescolar_grupo->gpoClave, array('readonly' => 'true')) !!}
                        {!! Form::label('gpoClave', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoTurno', $preescolar_grupo->gpoTurno, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoTurno', 'Turno', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 ">
                        <div class="input-field">
                            {!! Form::text('materia_id', $preescolar_grupo->preescolar_materia->matClave.'-'.$preescolar_grupo->preescolar_materia->matNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('materia_id', 'Materia', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('gpoCupo', $preescolar_grupo->gpoCupo, array('readonly' => 'true')) !!}
                        {!! Form::label('gpoCupo', 'Cupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empleado_id', $preescolar_grupo->empleado->persona->perNombre.' '.$preescolar_grupo->empleado->persona->perApellido1.' '.$preescolar_grupo->empleado->persona->perApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_id', 'Docente titular', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empleado_sinodal_id', ($docente_auxiliar) ? $docente_auxiliar->persona->perNombre.' '.$docente_auxiliar->persona->perApellido1.' '.$docente_auxiliar->persona->perApellido2 : NULL, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_sinodal_id', 'Docente auxiliar', array('class' => '')); !!}
                        </div>
                    </div>
                </div>             
                

            </div>

           
          </div>
        </div>
    </div>
  </div>

@endsection

@extends('layouts.dashboard')

@section('template_title')
    Extraordinario
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('extraordinario')}}" class="breadcrumb">Lista de extraordinario</a>
    <label class="breadcrumb">Ver extraordinario</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EXTRAORDINARIO #{{$extraordinario->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiClave', $extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id',$extraordinario->materia->plan->programa->escuela->departamento->depClave . " - " . $extraordinario->materia->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $extraordinario->materia->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('periodo_id', $extraordinario->periodo->perNumero.'-'.$extraordinario->periodo->perAnio, array('readonly' => 'true')) !!}
                            {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $extraordinario->periodo->perFechaInicial, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $extraordinario->periodo->perFechaFinal, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('programa_id', $extraordinario->materia->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $extraordinario->materia->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoSemestre', $extraordinario->materia->matSemestre, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoSemestre', 'Semestre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', $extraordinario->extGrupo, array('readonly' => 'true')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('materia_id', $extraordinario->materia->matNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('materia_id', 'Materia', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('aula_id', $extraordinario->aula->aulaClave, array('readonly' => 'true')) !!}
                        {!! Form::label('aula_id', 'Aula', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                        {!! Form::text('optativa_id', ($extraordinario->optativa) ? $extraordinario->optativa->optNombre : NULL, array('readonly' => 'true')) !!}
                        {!! Form::label('optativa_id', 'Optativa', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('extFecha', $extraordinario->extFecha, array('readonly' => 'true')) !!}
                            {!! Form::label('extFecha', 'Fecha examen', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('extHora', $extraordinario->extHora, array('readonly' => 'true')) !!}
                            {!! Form::label('extHora', 'Hora examen', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('extPago', $extraordinario->extPago, array('readonly' => 'true')) !!}
                            {!! Form::label('extPago', 'Costo Examen', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                            {!! Form::text('empleado_id', $extraordinario->empleado->persona->perNombre.' '.$extraordinario->empleado->persona->perApellido1.''.$extraordinario->empleado->persona->perApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_id', 'Docente', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                            {!! Form::text('empleado_sinodal_id', (
                                $extraordinario->empleadoSinodal) ?
                                    $extraordinario->empleadoSinodal->persona->perNombre
                                    . ' ' . $extraordinario->empleadoSinodal->persona->perApellido1
                                    . ' ' . $extraordinario->empleadoSinodal->persona->perApellido2
                                : NULL, ['readonly' => 'true']) !!}
                            {!! Form::label('empleado_sinodal_id', 'Sinodal', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
    </div>
  </div>

@endsection

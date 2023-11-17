@extends('layouts.dashboard')

@section('template_title')
    Inscrito
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('inscrito')}}" class="breadcrumb">Lista de Inscritos</a>
    <a href="{{url('inscrito/'.$inscrito->id.'/edit')}}" class="breadcrumb">Editar inscrito</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['inscrito.update', $inscrito->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR INSCRITO #{{$inscrito->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion_id}}" selected >{{$inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave}}-{{$inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->plan->programa->escuela->departamento_id}}" selected >{{$inscrito->curso->cgt->plan->programa->escuela->departamento->depClave}}-{{$inscrito->curso->cgt->plan->programa->escuela->departamento->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->plan->programa->escuela_id}}" selected >{{$inscrito->curso->cgt->plan->programa->escuela->escClave}}-{{$inscrito->curso->cgt->plan->programa->escuela->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->periodo->id}}">{{$inscrito->curso->cgt->periodo->perNumero ." - ".$inscrito->curso->cgt->periodo->perAnio}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $inscrito->curso->cgt->periodo->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $inscrito->curso->cgt->periodo->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->plan->programa->id}}">{{$inscrito->curso->cgt->plan->programa->progClave}}-{{$inscrito->curso->cgt->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->plan->id}}">{{$inscrito->curso->cgt->plan->planClave}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                        <select id="cgt_id" class="browser-default validate select2" required name="cgt_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->cgt->id}}">{{$inscrito->curso->cgt->cgtGradoSemestre.'-'.$inscrito->curso->cgt->cgtGrupo.'-'.$inscrito->curso->cgt->cgtTurno}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('curso_id', 'Alumno preinscrito*', array('class' => '')); !!}
                        <select id="curso_id" class="browser-default validate select2" required name="curso_id" style="width: 100%;">
                            <option value="{{$inscrito->curso->id}}">{{$inscrito->curso->alumno->aluClave}}-{{$inscrito->curso->alumno->persona->perNombre}} {{$inscrito->curso->alumno->persona->perApellido1}} {{$inscrito->curso->alumno->persona->perApellido2}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('grupo_id', 'Grupo-Materia *', array('class' => '')); !!}
                        <select id="grupo_id" class="browser-default validate select2" required name="grupo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($grupos as $grupo)
                                <option value="{{$grupo->id}}" @if($inscrito->grupo_id == $grupo->id) {{ 'selected' }} @endif>{{"Grupo: ".$grupo->gpoSemestre.'-'.$grupo->gpoClave.'-'.$grupo->gpoTurno.' '."Materia: ".$grupo->materia->matClave.'-'.$grupo->materia->matNombre.' '."Maestro: ".$grupo->empleado->id.'-'.$grupo->empleado->persona->perNombre.' '.$grupo->empleado->persona->perApellido1.' '.$grupo->empleado->persona->perApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('scripts.periodos')
@include('scripts.cgts')
@include('scripts.cursos')
@include('scripts.inscritos')

@endsection
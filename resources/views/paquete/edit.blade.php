@extends('layouts.dashboard')

@section('template_title')
    Paquete
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('paquete')}}" class="breadcrumb">Lista de Paquete</a>
    <a href="{{url('paquete/'.$paquete->id.'/edit')}}" class="breadcrumb">Editar paquete</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
    {{ Form::open(array('method'=>'PUT','route' => ['paquete.update', $paquete->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR PAQUETE ID {{$paquete->id}}. Num {{$paquete->consecutivo}}</span>

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
                            <option value="{{$paquete->plan->programa->escuela->departamento->ubicacion_id}}" selected >{{$paquete->plan->programa->escuela->departamento->ubicacion->ubiClave}}-{{$paquete->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$paquete->plan->programa->escuela->departamento_id}}" selected >{{$paquete->plan->programa->escuela->departamento->depClave}}-{{$paquete->plan->programa->escuela->departamento->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$paquete->plan->programa->escuela_id}}" selected >{{$paquete->plan->programa->escuela->escClave}}-{{$paquete->plan->programa->escuela->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="{{$paquete->periodo_id}}" >{{$paquete->periodo->perNumero.'-'.$paquete->periodo->perAnio}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $paquete->periodo->perFechaInicial, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $paquete->periodo->perFechaFinal, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$paquete->plan->programa_id}}" selected >{{$paquete->plan->programa->progClave}}-{{$paquete->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$paquete->plan_id}}" selected >{{$paquete->plan->planClave}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('semestre_id', 'Semestre *', array('class' => '')); !!}
                        <select id="semestre_id" class="browser-default validate select2" required name="semestre_id" style="width: 100%;">
                            <option value="{{$paquete->semestre}}" selected >{{$paquete->semestre}}</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s10">
                        {!! Form::label('grupo_id', 'Grupo *', array('class' => '')); !!}
                        <select id="grupo_id" class="browser-default validate select2" name="grupo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($gruposSemestre as $grupo)
                                <option value="{{$grupo->id}}">{{'Materia:'.$grupo->materia->matClave.'-'.$grupo->materia->matNombre.' Maestro: '.$grupo->empleado->id.'-'.$grupo->empleado->persona->perNombre.' '.$grupo->empleado->persona->perApellido1.' '.$grupo->empleado->persona->perApellido2.' CGT: '.$grupo->gpoSemestre.'-'.$grupo->gpoClave.'-'.$grupo->gpoTurno}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s2">
                        {!! Form::button('<i class="material-icons">add</i>', ['id'=>'agregarGrupo','class' => 'btn-large waves-effect  darken-3']) !!}
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-paquetes" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Maestro</th>
                                <th>Curso-Grupo-Turno</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($paquetes as $paquete_detalle)
                                <tr id="grupo{{$paquete_detalle->grupo->id}}">
                                    <td>{{$paquete_detalle->grupo->materia->matClave.'-'.$paquete_detalle->grupo->materia->matNombre}}</td>
                                    <td>{{$paquete_detalle->grupo->empleado->id.'-'.$paquete_detalle->grupo->empleado->persona->perNombre.'-'.$paquete_detalle->grupo->empleado->persona->perApellido1.'-'.$paquete_detalle->grupo->empleado->persona->perApellido2}}</td>
                                    <td>{{$paquete_detalle->grupo->gpoSemestre.'-'.$paquete_detalle->grupo->gpoClave.'-'.$paquete_detalle->grupo->gpoTurno}}</td>
                                    <td>
                                        <input name="grupos[{{$paquete_detalle->grupo->id}}]" type="hidden" value="{{$paquete_detalle->grupo->id}}" readonly="true"/>
                                        <a href="javascript:;" onclick="eliminarGrupo({{$paquete_detalle->grupo->id}})" class="button button--icon js-button js-ripple-effect" title="Eliminar grupo">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@include('scripts.materias')
@include('scripts.grupos')
@include('scripts.paquetes')

@endsection
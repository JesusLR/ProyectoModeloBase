@extends('layouts.dashboard')

@section('template_title')
    Bachiller paquete
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_paquete')}}" class="breadcrumb">Lista de Paquete</a>
    <a href="{{url('bachiller_paquete/'.$paquete->id.'/edit')}}" class="breadcrumb">Editar paquete</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
    {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_paquete.update', $paquete->id])) }}
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
                            <option value="{{$paquete->ubicacion_id}}" selected >{{$paquete->ubiClave}}-{{$paquete->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$paquete->departamento_id}}" selected >{{$paquete->depClave}}-{{$paquete->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$paquete->escuela_id}}" selected >{{$paquete->escClave}}-{{$paquete->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="{{$paquete->periodo_id}}" >{{$paquete->perNumero.'-'.$paquete->perAnio}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $paquete->perFechaInicial, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $paquete->perFechaFinal, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$paquete->programa_id}}" selected >{{$paquete->progClave}}-{{$paquete->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$paquete->plan_id}}" selected >{{$paquete->planClave}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('semestre_id', 'CGT *', array('class' => '')); !!}
                        <select id="semestre_id" class="browser-default validate select2" required name="semestre_id" style="width: 100%;">
                            <option value="{{$paquete->cgt_id}}" selected >{{$paquete->cgtGradoSemestre}}-{{$paquete->cgtGrupo}}-{{$paquete->cgtTurno}}</option>
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
                                @if ($grupo->gpoMatComplementaria != null)
                                <option value="{{$grupo->id}}">{{'Materia:'.$grupo->matClave.'-'.$grupo->matNombre.' Materia complementaria: '. $grupo->gpoMatComplementaria. ' Maestro: '.$grupo->bachiller_empleado_id.'-'.$grupo->empNombre.' '.$grupo->empApellido1.' '.$grupo->empApellido2.' CGT: '.$grupo->gpoGrado.'-'.$grupo->gpoClave.'-'.$grupo->gpoTurno}}</option>

                                @else
                                <option value="{{$grupo->id}}">{{'Materia:'.$grupo->matClave.'-'.$grupo->matNombre.' Maestro: '.$grupo->bachiller_empleado_id.'-'.$grupo->empNombre.' '.$grupo->empApellido1.' '.$grupo->empApellido2.' CGT: '.$grupo->gpoGrado.'-'.$grupo->gpoClave.'-'.$grupo->gpoTurno}}</option>

                                @endif
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
                                <th>Materia complementaria</th>
                                <th>Docente</th>
                                <th>Curso-Grupo-Turno</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($paquetes as $paquete_detalle)
                                <tr id="grupo{{$paquete_detalle->id}}">
                                    <td>{{$paquete_detalle->matClave.'-'.$paquete_detalle->matNombre}}</td>
                                    <td>{{$paquete_detalle->gpoMatComplementaria}}</td>
                                    <td>{{$paquete_detalle->bachiller_empleado_id.'-'.$paquete_detalle->empNombre.'-'.$paquete_detalle->empApellido1.'-'.$paquete_detalle->empApellido2}}</td>
                                    <td>{{$paquete_detalle->gpoGrado.'-'.$paquete_detalle->gpoClave.'-'.$paquete_detalle->gpoTurno}}</td>
                                    <td>
                                        <input name="grupos[{{$paquete_detalle->id}}]" type="hidden" value="{{$paquete_detalle->id}}" readonly="true"/>
                                        <a href="javascript:;" onclick="eliminarGrupo({{$paquete_detalle->id}})" class="button button--icon js-button js-ripple-effect" title="Eliminar grupo">
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

  <style>
    table tbody tr:nth-child(odd) {
        background: #D8D5DB;
    }
    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }
    table th {
      background: #01579B;
      color: #fff;
      
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
</style>
@endsection

@section('footer_scripts')


@include('bachiller.scripts.grupos-carga-tabla')
@include('bachiller.scripts.paquetes')

@endsection
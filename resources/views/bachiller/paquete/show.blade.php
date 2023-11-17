@extends('layouts.dashboard')

@section('template_title')
    Bachiller paquete
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_paquete')}}" class="breadcrumb">Lista de Paquete</a>
    <a href="{{url('bachiller_paquete/'.$paquete->id)}}" class="breadcrumb">Ver paquete</a>
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
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
                        <div class="input-field">
                            {!! Form::text('ubiClave', $paquete->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id', $paquete->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $paquete->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('periodo_id', $paquete->periodo->perNumero.'-'.$paquete->periodo->perAnio, array('readonly' => 'true')) !!}
                            {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                        </div>
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
                        <div class="input-field">
                            {!! Form::text('programa_id', $paquete->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $paquete->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('semestre_id', $paquete->cgt->cgtGradoSemestre.'-'.$paquete->cgt->cgtGrupo.'-'.$paquete->cgt->cgtTurno, array('readonly' => 'true')) !!}
                            {!! Form::label('semestre_id', 'CGT', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
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
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($paquetes as $paquete_detalle)
                                <tr>
                                    <td>{{$paquete_detalle->bachiller_grupo_yucatan->bachiller_materia->matNombre}}</td>
                                    <td>{{$paquete_detalle->bachiller_grupo_yucatan->gpoMatComplementaria}}</td>
                                    <td>{{$paquete_detalle->bachiller_grupo_yucatan->bachiller_empleado->empNombre}} {{$paquete_detalle->bachiller_grupo_yucatan->bachiller_empleado->empApellido1}} {{$paquete_detalle->bachiller_grupo_yucatan->bachiller_empleado->empApellido2}}</td>
                                    <td>{{$paquete_detalle->bachiller_grupo_yucatan->gpoGrado.'-'.$paquete_detalle->bachiller_grupo_yucatan->gpoClave.'-'.$paquete_detalle->bachiller_grupo_yucatan->gpoTurno}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
          </div>
        </div>
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

@extends('layouts.dashboard')

@section('template_title')
    Resumen Académico
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('resumen_academico')}}" class="breadcrumb">Lista de resumenes</a>
    <label class="breadcrumb">Ver Resumen</label>
@endsection

@section('content')

@php
  use App\Http\Helpers\Utils;
@endphp

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RESUMEN   #{{$resumenAcademico->id}}</span>

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
                  <div class="col s12 m6 l6">
                    <p><b>Ubicación: </b>{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</p>
                    <p><b>Departamento: </b>{{$departamento->depClave}} - {{$departamento->depNombre}}</p>
                    <p><b>Escuela: </b>{{$escuela->escClave}} - {{$escuela->escNombre}}</p>
                    <p><b>Programa: </b>{{$programa->progClave}} ({{$plan->planClave}}) {{$programa->progNombre}}</p>
                  </div>
                  <div class="col s12 m6 l6">
                    <p><b>Clave de pago: </b> {{$alumno->aluClave}}</p>
                    <p><b>Nombre del Alumno: </b> {{$persona->nombreCompleto(true)}}</p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col s12 m6 l4">
                    <p><b>Periodo ingreso: </b> 
                      @if($periodoIngreso)
                        {{$periodoIngreso->perNumero}}-{{$periodoIngreso->perAnio}}
                        <b>Fecha: </b> {{Utils::fecha_string($resumenAcademico->resFechaIngreso, 'mesCorto')}}
                      @endif
                    </p>
                    <p><b>Periodo egreso: </b> 
                      @if($periodoEgreso)
                        {{$periodoEgreso->perNumero}}-{{$periodoEgreso->perAnio}}
                        <b>Fecha: </b> {{Utils::fecha_string($resumenAcademico->resFechaEgreso, 'mesCorto')}}
                      @endif
                    </p>
                    <p><b>Periodo último: </b> 
                      @if($periodoUltimo)
                        {{$periodoUltimo->perNumero}}-{{$periodoUltimo->perAnio}}
                        <b>Semestre: </b> {{$resumenAcademico->resUltimoGrado}}
                      @endif
                    </p>
                    <p><b>Clave especialidad: </b> {{ $resumenAcademico->resClaveEspecialidad }}</p>
                  </div>
                  <div class="col s12 m6 l4">
                    <p><b>Creditos cursados: </b> {{$resumenAcademico->resCreditosCursados}}</p>
                    <p><b>Creditos aprobados: </b> {{$resumenAcademico->resCreditosAcumulados}}</p>
                    <p><b>Avance acumulado: </b> {{$resumenAcademico->resAvanceAcumulado}}</p>
                    <p><b>Promedio acumulado: </b> {{ $resumenAcademico->resPromedioAcumulado }}</p>
                  </div>
                  <div class="col s12 m6 l4">
                    <p><b>Estado: </b> {{ $resumenAcademico->resEstado }}</p>
                    <p><b>Observaciones: </b> {{ $resumenAcademico->resObservaciones }}</p>
                    <p><b>Fecha de baja: </b> {{ Utils::fecha_string($resumenAcademico->resFechaBaja, 'mesCorto') }}</p>
                    <p><b>Razón de baja: </b> {{ $resumenAcademico->resRazonBaja }}</p>
                  </div>
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

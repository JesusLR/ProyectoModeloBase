@extends('layouts.dashboard')

@section('template_title')
    Bachiller Justificaciones
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_justificaciones.index')}}" class="breadcrumb">Lista justificaciones</a>
    <a href="" class="breadcrumb">Ver justificacion</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">JUSTIFICACIONES #{{ $bachiller_justificacion->id }}</span>

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
                        {!! Form::label('curEstado', 'Ubicación', ['class' => '']); !!}
                        <input type="text" value="{{ $bachiller_justificacion->ubiClave.'-'.$bachiller_justificacion->ubiNombre }}" readonly>                                                </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="departamento_id">Departamento</label>
                        <input type="text" value="{{ $bachiller_justificacion->depClave.'-'.$bachiller_justificacion->depNombre }}" readonly>                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="escuela_id">Escuela </label>
                        <input type="text" value="{{ $bachiller_justificacion->escClave.'-'.$bachiller_justificacion->escNombre }}" readonly>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="periodo_id">Período</label>
                        <input type="text" value="{{ $bachiller_justificacion->perNumero.'-'.$bachiller_justificacion->perAnio }}" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="programa_id">Programa</label>
                        <input type="text" value="{{ $bachiller_justificacion->progClave.'-'.$bachiller_justificacion->progNombre }}" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="plan_id">Plan</label>
                        <input type="text" value="{{ $bachiller_justificacion->planClave }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="curso_id">Alumno</label>
                        <input type="text" value="{{ $bachiller_justificacion->aluClave.'-'.$bachiller_justificacion->perApellido1.' '.$bachiller_justificacion->perApellido2.' '.$bachiller_justificacion->perNombre }}" readonly>
                    </div>

                
                    <div class="col s12 m6 l4">
                        <label for="">Razón de la falta</label>
                        <br>
                        <input type="text" value="{{ $bachiller_justificacion->jusRazonFalta }}" readonly>                        
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                {!! Form::label('fechaInicio', 'Fecha de inicio', array('class' => '')); !!}
                                <input type="date" value="{{ $bachiller_justificacion->jusFechaInicio }}" readonly>
                            </div>
                            <div class="col s12 m6 l6">
                                {!! Form::label('fechaFin', 'Fecha de fin', array('class' => '')); !!}
                                <input type="date" value="{{ $bachiller_justificacion->jusFechaFin }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

            
          </div>
        </div>

       
    </div>
  </div>


@endsection


@section('footer_scripts')


@endsection